<?php
/**
 * @file
 * Contains \Drupal\heroblock\Plugin\Block\ArticleBlock.
 */

namespace Drupal\heroblock\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormInterface;

/**
 * Provides a 'Custom' block.
 *
 * @Block(
 *   id = "heroblock_id",
 *   admin_label = @Translation("Hero Custom block"),
 *   category = @Translation("Custom Custom block example")
 * )
 */
class heroblock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $form = \Drupal::formBuilder()->getForm('Drupal\heroblock\Form\customForm');
    // $form['#attached']['library'][] = 'heroblock/customblock-style';

    return $form;
   }
}