<?php

namespace Drupal\kb_glossary\Form;


use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\State\StateInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;

class ConfigurationForm extends ConfigFormBase {


    /**
     * @var EntityTypeManagerInterface
     */
    protected $entityTypeManager;

    /**
     * @var ConfigFactoryInterface
     */
    protected $config;

    /**
     * @var StateInterface
     */
    protected $state;

    /**
     * @param EntityTypeManagerInterface $entityTypeManager
     * @param ConfigFactoryInterface $config
     * @param StateInterface $state
     */
    public function __construct(EntityTypeManagerInterface $entityTypeManager, ConfigFactoryInterface $config, StateInterface $state) {
        $this->entityTypeManager = $entityTypeManager;
        $this->config = $config;
        $this->state = $state;
        parent::__construct($this->config);
    }

    /**
     * @param ContainerInterface $container
     * @return static
     */
    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('entity_type.manager'),
            $container->get('config.factory'),
            $container->get('state')
        );

    }

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'kb_glossary.form_configuration';
    }

    /**
     * @return array
     */
    protected function getEditableConfigNames() {
        return array(
            'kb_glossary.configuration'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array  $form, FormStateInterface $form_state) {
        $form['link'] = array(
            '#title' => $this->t('Voir le lexique'),
            '#type' => 'link',
            '#url' => Url::fromRoute('view.glossary_taxonomy.page_1')
        );

        $form['glossary_title'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Titre'),
            '#default_value' => $this->state->get('glossary_title'),
            '#required' => TRUE,
        );

        $form['glossary_description'] = array(
            '#type' => 'text_format',
            '#title' => $this->t('Description'),
            '#default_value' => $this->state->get('glossary_description'),
            '#required' => FALSE,
        );

        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        // Set glossary title and description
        $this->state->set('glossary_title', $form_state->getValue('glossary_title'));
        $this->state->set('glossary_description', $form_state->getValue('glossary_description')['value']);

        // INVALIDATING CACHE TAGS GLOSSARY
        Cache::invalidateTags(['config:views.view.glossary_taxonomy']);
    }
}
