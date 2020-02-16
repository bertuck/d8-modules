<?php
namespace Drupal\kb_error_pages\Controllers;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\State\StateInterface;
use Drupal\file\Entity\File;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ErrorController extends ControllerBase {

    /**
     * @var $mapService
     */
    protected $mapService;

    /**
     * @var StateInterface
     */
    protected $state;

    /**
     * MapController constructor.
     * @param StateInterface $state
     */
    public function __construct(StateInterface $state) {
        $this->state = $state;
    }

    /**
     * @param ContainerInterface $container
     * @return static
     */
    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('state')
        );
    }

    /**
     * Returns a simple page.
     *
     * @return array
     *   A simple renderable array.
     */
    public function AccessDenied() {
        $error['title'] = $this->state->get('error_403_title');
        $error['img'] = $this->PrepareRenderImage('403');
        $error['body'] = [
            '#type' => 'processed_text',
            '#text' => $this->state->get('error_403_description'),
            '#cache' => [
                'tags' => ['config:system.403'],
            ],
            '#format' => 'full_html'
        ];
        return [
            '#theme' => 'access-denied',
            '#error' => $error,
            '#cache' => array(
                'tags' => ['config:error.pages.403'],
            )
        ];
    }

    /**
     * Returns a simple page.
     *
     * @return array
     *   A simple renderable array.
     */
    public function NotFound() {
        $error['title'] = $this->state->get('error_404_title');
        $error['img'] = $this->PrepareRenderImage('404');
        $error['body'] = [
            '#type' => 'processed_text',
            '#text' => $this->state->get('error_404_description'),
            '#cache' => [
                'tags' => ['config:system.404'],
            ],
            '#format' => 'full_html'
        ];

        return [
            '#theme' => 'not-found',
            '#error' => $error,
            '#cache' => array(
                'tags' => ['config:system.404'],
            )
        ];
    }

    private function PrepareRenderImage($error){
        $imageRenderArray = [];
        if (empty($this->state->get("error_{$error}_img")[0])) {
            return [];
        }
        $file = File::load($this->state->get("error_{$error}_img")[0]);
        if (!empty($file)) {
            $variables = array(
                'style_name' => 'is_error_page',
                'uri' => $file->getFileUri(),
            );
            $image = \Drupal::service('image.factory')->get($file->getFileUri());
            if ($image->isValid()) {
                $variables['width'] = $image->getWidth();
                $variables['height'] = $image->getHeight();
            }
            else {
                $variables['width'] = $variables['height'] = NULL;
            }

            $imageRenderArray = [
                '#theme' => 'image_style',
                '#width' => $variables['width'],
                '#height' => $variables['height'],
                '#style_name' => $variables['style_name'],
                '#uri' => $variables['uri'],
            ];
        }
        return $imageRenderArray;
    }
}