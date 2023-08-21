<?php

namespace Drupal\plugin_type_example;

/**
 * Interface for sandwich plugins.
 */
interface SandwichInterface
{

  /**
   * Returns the translated plugin label.
   *
   * @return string
   *   The translated title.
   */
  public function label();


  /**
   * Provide a description of the sandwich.
   *
   * @return string
   *   A string description of the sandwich.
   */
  public function description();

  /**
   * Provide the number of calories per serving for the sandwich.
   *
   * @return float
   *   The number of calories per serving.
   */
  public function calories();

  /**
   * @param array $extras
   *   An array of extra ingredients to include with this sandwich.
   *
   * @return mixed
   */
  public function order(array $extras);
}
