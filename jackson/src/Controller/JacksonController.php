<?php

namespace Drupal\jackson\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for jackson routes.
 */
class JacksonController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
