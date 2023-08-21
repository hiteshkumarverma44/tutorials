<?php

namespace Drupal\crud\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class MydataForm.
 *
 * @package Drupal\mydata\Form
 */
class addeditform extends FormBase
{
  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'crud_addedit_id';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {

    $conn = Database::getConnection();
    echo "hello";
    $record = array();
    $test = \Drupal::routeMatch()->getParameter('id');
    print_r($test);
    //  exit;


    if ($test == 0) {
      $record = [];
    } elseif ($test != 0) {
      $query = $conn->select('crud_code', 'm')
        ->condition('id', $test)
        ->fields('m');
      $record = $query->execute()->fetchAssoc();
    }

    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Candidate Name:'),
      //   '#required' => TRUE,
      //'#default_values' => array(array('id')),
      '#default_value' => (isset($record['name'])) ? $record['name'] : 'sfadslfjdsalf',
    );
    $form['number'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Mobile Number:'),
      '#default_value' => (isset($record['mobilenumber']) && $_GET['num']) ? $record['mobilenumber'] : '',
    );
    $form['email'] = array(
      '#type' => 'email',
      '#title' => $this->t('Email ID:'),
      //   '#required' => TRUE,
      '#default_value' => (isset($record['email']) && $_GET['num']) ? $record['email'] : '',
    );
    $form['gender'] = array(
      '#type' => 'select',
      '#title' => ('Gender'),
      '#options' => array(
        'Female' => $this->t('Female'),
        'male' => $this->t('Male'),
        '#default_value' => (isset($record['gender']) && $_GET['num']) ? $record['gender'] : '',
      ),
    );

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'save',
      //'#value' => t('Submit'),
    ];
    return $form;
  }
  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    //  $name = $form_state->getValue('name');
    //   if(preg_match('/[^A-Za-z]/', $name)) {
    //      $form_state->setErrorByName('name', $this->t('your name must in characters without space'));
    //   }
    // if (!intval($form_state->getValue('candidate_age'))) {
    //      $form_state->setErrorByName('candidate_age', $this->t('Age needs to be a number'));
    //     }
    //  /* $number = $form_state->getValue('candidate_age');
    //   if(!preg_match('/[^A-Za-z]/', $number)) {
    //      $form_state->setErrorByName('candidate_age', $this->t('your age must in numbers'));
    //   }*/
    //   if (strlen($form_state->getValue('number')) < 10 ) {
    //     $form_state->setErrorByName('number', $this->t('your mobile number must in 10 digits'));
    //    }
    parent::validateForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {

    $id = \Drupal::routeMatch()->getParameter('id');

    $field = $form_state->getValues();
    $name = $field['name'];
    //echo "$name";
    $number = $field['number'];
    $email = $field['email'];
    $gender = $field['gender'];
    if ($id != 0) {
      $field  = array(
        'name'   => $name,
        'number' =>  $number,
        'email' =>  $email,
        'gender' => $gender,
      );
      $query = \Drupal::database();
      $query->update('crud_code')
        ->fields($field)
        ->condition('id', $id)
        ->execute();
      $messanger = \Drupal::messenger();
      $messanger->addStatus('your form has been updated');
      $response = new RedirectResponse("/display");
      $response->send();

      //   $form_state->setRedirect('mydata.display_table_controller_display');
    } else {
      $field  = array(
        'name'   =>  $name,
        'number' =>  $number,
        'email' =>  $email,
        'gender' => $gender,
      );
      $query = \Drupal::database();
      $query->insert('crud_code')
        ->fields($field)
        ->execute();
      $messanger = \Drupal::messenger();
      $messanger->addStatus('your form has been submitted');
      $response = new RedirectResponse("/display");
      $response->send();
    }
  }
}
