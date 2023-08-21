<?php

namespace Drupal\custompluginblock\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a custompluginblock block.
 *
 * @Block(
 *   id = "custompluginblockid",
 *   admin_label = @Translation("custompluginblock"),
 *   category = @Translation("custom")
 * )
 */
class custompluginblock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'foo' => $this->t('Hello world!'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['foo'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Foo'),
      '#default_value' => $this->configuration['foo'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['foo'] = $form_state->getValue('foo');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build['content'] = [
      '#markup' => $this->t('It works!'),
    ];
    return $build;
  }

}
