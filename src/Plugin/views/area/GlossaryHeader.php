<?php

/**
 * @file
 * Definition of Drupal\d8views\Plugin\views\area\GlossaryHeader
 */

namespace Drupal\kb_glossary\Plugin\views\area;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\State\StateInterface;
use Drupal\views\Plugin\views\area\AreaPluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Add dynamic header used by view.
 *
 * @ingroup views_area_handlers
 *
 * @ViewsArea("glossary_header")
 */
class GlossaryHeader extends AreaPluginBase {

    /**
     * @var StateInterface Drupal\Core\State\StateInterface
     */
    protected $state;

  /**
   * GlossaryHeader constructor.
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   * @param StateInterface $state
   */
    public function __construct(array $configuration, $plugin_id, $plugin_definition, StateInterface $state) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->state = $state;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('state')
        );
    }
    /**
     * {@inheritdoc}
     */
    protected function defineOptions() {
        $options = parent::defineOptions();

        return $options;
    }

    /**
     * {@inheritdoc}
     */
    public function buildOptionsForm(&$form, FormStateInterface $form_state) {
        parent::buildOptionsForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function render($empty = FALSE) {
        return [
            '#type' => 'processed_text',
            '#text' => $this->state->get('glossary_description'),
            '#cache' => [
                'tags' => ['config:views.view.glossary_taxonomy'],
            ],
            '#format' => 'full_html'
        ];
    }
}
