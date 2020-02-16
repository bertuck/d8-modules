<?php

namespace Drupal\kb_glossary\Twig;

/**
 * Class DefaultService.
 *
 * @package Drupal\MachineNameExtension
 */
class MachineNameExtension extends \Twig_Extension {

    /**
     * {@inheritdoc}
     * This function must return the name of the extension. It must be unique.
     */
    public function getName() {
        return 'machineName.twig_extension';
    }

    /**
     * In this function we can declare the extension function
     */
    public function getFilters() {
        return array(
            new \Twig_SimpleFilter('machineName',
                array($this, 'machineName')
            )
        );
    }

    /**
     * The php function to load a given block
     */
    public function machineName($term) {
        return \Drupal::service('kb_glossary.service.parser')->transform($term['#object']->get('name')->getString());
    }

}
