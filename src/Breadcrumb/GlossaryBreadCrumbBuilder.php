<?php

namespace Drupal\kb_glossary\Breadcrumb;

use Drupal\Core\Link;
use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Provides a custom breadcrumb builder for group content type paths.
 */
class GlossaryBreadCrumbBuilder implements BreadcrumbBuilderInterface {
  use StringTranslationTrait;

  /**
   * @inheritdoc
   */
  public function applies(RouteMatchInterface $route_match) {
    if ($route_match->getRouteObject()->getDefault('view_id') == 'glossary_taxonomy') {
      return TRUE;
    }

    return FALSE;
  }

  /**
   * @inheritdoc
   */
  public function build(RouteMatchInterface $route_match) {

    $breadcrumb = new Breadcrumb();
    $view = $route_match->getRouteObject();
    $title = \Drupal::service('state')->get('glossary_title') ? : $view->getDefault('_title');
    $breadcrumb->addLink(Link::createFromRoute($this->t('Accueil'), '<front>'));
    $argument = $route_match->getParameter('arg_0');
    if ($argument) {
      $breadcrumb->addLink(Link::createFromRoute($title, 'view.glossary_taxonomy.page_1'));
      $breadcrumb->addLink(Link::createFromRoute($argument, '<none>'));
    } else {
      $breadcrumb->addLink(Link::createFromRoute($title, '<none>'));
    }

    // This breadcrumb builder is based on a route parameter, and hence it
    // depends on the 'route' cache context.
    $breadcrumb->addCacheContexts(['route']);
    $breadcrumb->addCacheTags(['config:views.view.glossary_taxonomy']);

    return $breadcrumb;
  }

}
