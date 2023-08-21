<?php

/**
 * @file
 * Contains \Drupal\custom_postal_code\Form\search_postal.
 */

namespace Drupal\custom_postal_code\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class custom_postal_code_search extends FormBase
{
  /**
   * {@inheritdoc}
   */

  public function getFormId()
  {
    return 'search_postal';
  }

  /**
   * {@inheritdoc}
   */

  public function buildForm(array $form, FormStateInterface $form_state)
  {

    $form['search_postal'] = array(
      '#type' => 'textfield',
      '#default_value' => '',
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('filter'),
      '#button_type' => 'primary',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    if ($form_state->getValue('search_postal') == "") {
      $form_state->setErrorByName('from', $this->t('You must enter a valid Postal code.'));
    }
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $field = $form_state->getValues();
    $search_postal = $field["search_postal"];
    $url = \Drupal\Core\Url::fromRoute('custom.custom_postal_code_showdata')
      ->setRouteParameters(array('search_postal' => $search_postal));
    $form_state->setRedirectUrl($url);
  }
}
