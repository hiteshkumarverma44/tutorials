<?php
namespace Drupal\basic_page\Controller;

class basic_pageController {
  public function basicPage() {
    $element = array(
    '#markup' => 'Hello world'
    );
    return $element;
  }
}
?>