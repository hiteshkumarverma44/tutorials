<?php

namespace Drupal\blockmodule\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'customBlock' Block.
 *
 * @Block(
 *   id = "customBlock_id",
 *   admin_label = @Translation("Custom BLock"),
 *   category = @Translation("custom Block"),
 * )
 */
class CustomBlock extends BlockBase
{

  /**
   * {@inheritdoc}
   */
  public function build()
  {

    $database = \Drupal::database();
    $query = $database->select('node_field_data', 'n');
    $query->fields('n');
    $query->range(2, 3);
    $result = $query->execute();
    $record = $result->fetchAll();
    $titles = [];

    foreach ($record as $value) {
      $titles[] = $value->title;
    }

    echo "<pre>";
    print_r($titles);
    echo "</pre>";


    return [
      '#theme' => 'my_custom_block',
      '#title' => $titles,

    ];
  }
}
