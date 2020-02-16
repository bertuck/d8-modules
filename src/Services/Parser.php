<?php


namespace Drupal\kb_glossary\Services;

use Drupal\Component\Transliteration\TransliterationInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Language\LanguageInterface;

class Parser {

    /**
     * @var array $availableFields
     */
    protected $availableFields = [];

    /**
     * @var string
     */
    static $field = 'display_glossary';

    /**
     * The transliteration service.
     *
     * @var TransliterationInterface
     */
    protected $transliteration;

    /**
     * The transliteration service.
     *
     * @var TransliterationInterface
     */
    protected $twig;

    /**
     * @var EntityTypeManagerInterface
     */
    protected $entityTypeManager;


    /**
     * @var string
     */
    static $entityType = 'glossary';

    /**
     * @param TransliterationInterface $transliteration
     * @param \Twig_Environment $twig
     * @param EntityTypeManagerInterface $entityTypeManager
     */
    public function __construct(TransliterationInterface $transliteration, \Twig_Environment $twig, EntityTypeManagerInterface $entityTypeManager) {
        $this->transliteration = $transliteration;
        $this->twig = $twig;
        $this->entityTypeManager = $entityTypeManager;

    }

    /**
     * @param EntityInterface $entity
     * @return array
     */
    public function getAvailableFields(EntityInterface $entity) {
        foreach ($entity->getFieldDefinitions() as $key => $field) {
            $fieldSetting = $entity->get($key)->getSetting(self::$field);
            if (!$fieldSetting || $fieldSetting == 0) {
                continue;
            }
            $this->availableFields[] = $key;
        }

        return $this->availableFields;
    }

  /**
   * @param array $build
   * @param EntityInterface $entity
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
    public function setValueEntityField(array &$build, EntityInterface $entity) {
        $this->getAvailableFields($entity);

        foreach($this->availableFields as $key => $field) {
            if (!isset($build[$field])) {
                continue;
            }
            $build[$field][0]['#text'] = isset($build[$field][0]) ? $this->parsing($build[$field][0]['#text']) : NULL;
        }
    }


  /**
   * @param $html
   * @return mixed|string|string[]|null
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
    private function parsing($html) {
        $tree = $this->entityTypeManager->getStorage('taxonomy_term')->loadTree(self::$entityType);

        $search = '/(<h[2-6](\s|\S)*?<\/h[2-6]>)|(<a(\s|\S)*?<\/a>)|(<img(\s|\S)*?\/>)|(<button(\s|\S)*?<\/button>)|(<iframe(\s|\S)*?<\/iframe>)|(<script(\s|\S)*?<\/script>)/msi';
        preg_match_all($search, $html, $tagMatches);
        $html = preg_replace($search, "#STRING#", $html);

        $params = $this->analyzeAndReplace($tree);

        $html = preg_replace($params['patterns'], $params['replace_button'], $html, 1);

        for ($i = 0; $i < sizeof($tagMatches[0]); $i++) {
            $html = $this->replaceFirst("#STRING#", $tagMatches[0][$i], $html);
        }

        foreach($params['params'] as $key => $tokens) {
            foreach($tokens as $k => $token) {
                $html = str_replace($k, $token, $html);
            }
        }

        return $html;
    }

  /**
   * @param $tree
   * @return array
   * @throws \Twig\Error\LoaderError
   * @throws \Twig\Error\RuntimeError
   * @throws \Twig\Error\SyntaxError
   */
    private function analyzeAndReplace($tree) {
        $params = array();
        $replace_button = array();
        $patterns = array();

        foreach ($tree as $term) {
            $patterns[] = '{([^\w@\.]|^)('. str_replace(')', '\)', str_replace('(', '\(', $term->name)) .')(?=([^\w]|\s|&nbsp;|$))}sui';

            $this->createArrayParams($term, $params);

            $replace_button[] = $this->renderTwigLink($term, $params);
        }

        return array('replace_button' => $replace_button, 'params' => $params, 'patterns' => $patterns);
    }

    /**
     * @param $term
     * @param $params
     */
    private function createArrayParams($term, &$params) {
        $params[$term->tid] = array(
            '#DESCRIPTION-' . $term->tid . '#' => isset($term->description__value) ? html_entity_decode(strip_tags($this->trimText($term->description__value, 100))) : '',
            '#PATH-' . $term->tid . '#' => \Drupal::request()->getSchemeAndHttpHost() . '/lexique/'.substr(strtoupper($term->name), 0, 1) . '#' . $this->transform($term->name),
            '#TITLE-' . $term->tid . '#' => $term->name
        );
    }

  /**
   * @param $term
   * @param $params
   * @return string
   * @throws \Twig\Error\LoaderError
   * @throws \Twig\Error\RuntimeError
   * @throws \Twig\Error\SyntaxError
   */
    private function renderTwigLink($term, $params) {
        return $this->twig->render(
            drupal_get_path('module', 'kb_glossary') . "/templates/glossary--link.html.twig",
            array(
                'term_path' => $params[$term->tid]['#PATH-'. $term->tid . "#"],
                'title' => $params[$term->tid]['#TITLE-' . $term->tid . '#'],
                'description_tmp' => $params[$term->tid]['#DESCRIPTION-' . $term->tid . '#'])
        );
    }

    /**
     * @param $find
     * @param $replace
     * @param $subject
     * @return string
     */
    private function replaceFirst($find, $replace, $subject) {
       return implode($replace, explode($find, $subject, 2));
    }

    /**
     * trims text to a space then adds ellipses if desired
     * @param string $input text to trim
     * @param int $length in characters to trim to
     * @param bool $ellipses if ellipses (...) are to be added
     * @param bool $strip_html if html tags are to be stripped
     * @return string
     */
    private function trimText($input, $length, $ellipses = true, $strip_html = true, $cut = true) {
        //strip tags, if desired
        if ($strip_html) {
            $input = strip_tags($input);
        }

        //no need to trim, already shorter than trim length
        if (strlen($input) <= $length) {
            return $input;
        }

        //find last space within length
        $last_space = strrpos(substr($input, 0, $length), ' ');
        $trimmed_text = substr($input, 0, $last_space);

        if (!$cut) {
            $trimmed_text = substr($input, 0, $length);
        }
        //add ellipses (...)
        if ($ellipses) {
            if ($cut) {
                $trimmed_text .= ' ...';
            } else {
                $trimmed_text .= '...';
            }
        }

        return $trimmed_text;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($value) {
        $new_value = $this->transliteration->transliterate($value, LanguageInterface::LANGCODE_DEFAULT, '_');
        $new_value = strtolower($new_value);
        $new_value = preg_replace('/[^a-z0-9_]+/', '_', $new_value);
        return preg_replace('/_+/', '_', $new_value);
    }

}
