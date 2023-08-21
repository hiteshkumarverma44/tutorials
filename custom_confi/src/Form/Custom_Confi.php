<?php

namespace Drupal\custom_confi\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class Custom_Confi extends ConfigFormBase {

  /**
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'custom_confi.settings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_confi_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /**
   * {@inheritdoc}
   */

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);

    // $form['custom_confi_id']=array(
    //   '#type'=>'textfield',
    //   '#title'=>'id',
    //   '#default_value'=>1
    // );
    $form['first_name'] = array(
        '#type'=>'textfield',
        '#title'=>t('First Name'),
        '#default_value'=>''
    );
    $form['last_name'] = array(
        '#type'=>'textfield',
        '#title'=>t('Last Name'),
        '#default_value'=>''
    );
    $form['email']=array(
        '#type'=>'email',
        '#title'=>t('Email Address'),
        '#default_value'=>''
    );
    $form['contact_number'] = array(
        '#type'=>'tel',
        '#title'=>'Contact Number',
        '#default_value'=>''
    );
    $form['terms_condition'] = array(
        '#type'=>'checkbox',
        '#title'=>'Do you agree to the above conditions',

    );


    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */


  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration.
    $this->config(static::SETTINGS)
      // Set the submitted configuration setting.
      ->set('first_name', $form_state->getValue('first_name'))
      // You can set multiple configurations at once by making
      // multiple calls to set().
      ->set('last_name', $form_state->getValue('last_name'))
      ->set('email_id', $form_state->getValue('email'))
      ->set('phone', $form_state->getValue('contact_number'))
      ->set('checkterm', $form_state->getValue('terms_condition'))
      ->save();
    parent::submitForm($form, $form_state);

    $postData = $form_state->getValues();
    unset($postData['submit'],$postData['save'],$postData['form_build_id'],$postData['form_token'],$postData['form_id'],$postData['op']);
    $query= \Drupal::database();
    $query->insert('custom_confi')->fields($postData)->execute();
  }

}