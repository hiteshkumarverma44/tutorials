<?php

namespace Drupal\plugin_type_example\Plugin\Sandwich;

use Drupal\plugin_type_example\SandwichPluginBase;

/**
 * Plugin implementation of the sandwich.
 *
 * @Sandwich(
 *   id = "foo",
 *   label = @Translation("Foo"),
 *   description = @Translation("Foo description.")
 * )
 */
class Foo extends SandwichPluginBase {

}
