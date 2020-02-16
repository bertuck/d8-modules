<?php

namespace Drupal\kb_glossary\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\text\Plugin\Field\FieldType\TextLongItem;

/**
 * Plugin implementation of the 'text_long' field type.
 *
 * @FieldType(
 *   id = "text_long",
 *   label = @Translation("Text (formatted, long)"),
 *   description = @Translation("This field stores a long text with a text format."),
 *   category = @Translation("Text"),
 *   default_widget = "text_textarea",
 *   default_formatter = "text_default"
 * )
 */
class GlossaryTextareaItem extends TextLongItem {

    /**
     * {@inheritdoc}
     */
    public static function defaultFieldSettings() {
        return [
            'display_glossary' => 0,
        ] + parent::defaultFieldSettings();
    }

    /**
     * {@inheritdoc}
     */
    public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
        $properties = parent::propertyDefinitions($field_definition);

        $properties['glossary'] = DataDefinition::create('string')
            ->setLabel(t('Glossary'));

        return $properties;
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty() {
        $value = $this->get('glossary')->getValue();
        return parent::isEmpty() && ($value === NULL || $value === '');
    }

    /**
     * {@inheritdoc}
     */
    public function fieldSettingsForm(array $form, FormStateInterface $form_state) {
        $settings = $this->getSettings();

        $form = parent::fieldSettingsForm($form, $form_state);

        $form['display_glossary'] = [
            '#type' => 'checkbox',
            '#title' => $this->t('Glossary mode'),
            '#default_value' => isset($settings['display_glossary']) ? $settings['display_glossary'] : false,
            '#description' => $this->t('Active glossary mode on this field.')
        ];

        return $form;
    }
}
