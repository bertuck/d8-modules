<?php

namespace Drupal\kb_ckeditor_plugins\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginInterface;
use Drupal\ckeditor\CKEditorPluginButtonsInterface;
use Drupal\Component\Plugin\PluginBase;
use Drupal\editor\Entity\Editor;

/**
 * Defines the "Icon" plugin.
 *
 * @CKEditorPlugin(
 *   id = "icon",
 *   label = @Translation("CKEditor Icon"),
 *   module = "kb_ckeditor_plugins"
 * )
 */
class Icon extends PluginBase implements CKEditorPluginInterface, CKEditorPluginButtonsInterface
{


    /**
     * Implements \Drupal\kb_ckeditor_plugins\Plugin\CKEditorPluginInterface::getDependencies().
     */
    function getDependencies(Editor $editor)
    {
        return array();
    }



    /**
     * Implements \Drupal\kb_ckeditor_plugins\Plugin\CKEditorPluginInterface::getLibraries().
     */
    function getLibraries(Editor $editor)
    {
        return array();
    }



    /**
     * Implements \Drupal\kb_ckeditor_plugins\Plugin\CKEditorPluginInterface::isInternal().
     */
    function isInternal()
    {
        return false;
    }



    /**
     * Implements \Drupal\kb_ckeditor_plugins\Plugin\CKEditorPluginInterface::getFile().
     */
    function getFile()
    {
        $plugin = drupal_get_path('module', 'kb_ckeditor_plugins') . '/js/plugins/icon/plugin.js';

        return $plugin;
    }



    /**
     * Implements \Drupal\kb_ckeditor_plugins\Plugin\CKEditorPluginInterface::getConfig().
     */
    public function getConfig(Editor $editor)
    {
        return array();
    }



    /**
     * Implements \Drupal\kb_ckeditor_plugins\Plugin\CKEditorPluginInterface::getConfig().
     */
    public function getButtons()
    {
        return array(
            'icon' => array(
                'label' => t('icon'),
                'image' => drupal_get_path('module', 'kb_ckeditor_plugins') . '/js/plugins/icon/icons/icon.png',
            ),
        );
    }
}