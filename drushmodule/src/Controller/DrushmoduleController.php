<?php

namespace Drupal\drushmodule\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for drushModule routes.
 */
class DrushmoduleController extends ControllerBase {

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
