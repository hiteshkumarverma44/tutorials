<?php

namespace Drupal\custom_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Code\DataBase\DataBase;
use Drupal\Core\Form\FormState;

// use Symfony\Component\PropertyAccess\PropertyAccess;


class custom_form extends FormBase
{
    /**
     * {@inheritDoc}
     */
    public function getFormId()
    {
        return 'create_form';
    }
    /**
     *{@inheritDoc}
     */

    public function buildForm(array $form, FormStateInterface $form_state)
    {



        $form['first_name'] = array(
            '#type' => 'textfield',
            '#title' => t('First Name'),
            '#default_value' => '',
            // '#required' => true,
            '#attribute' => array(
                'class' => array('class-one', 'class-two'),
                'id' => 'test-id',
                'placeholder' => 'this is field placeholder',
            ),
        );
        $form['last_name'] = array(
            '#type' => 'textfield',
            '#title' => t('Last Name'),
            '#default_value' => '',
            // '#required' => true,

        );
        $form['email'] = array(
            '#type' => 'email',
            '#title' => t('Email Address'),
            '#default_value' => '',
            // '#required' => true,
        );
        $form['contact_number'] = array(
            '#type' => 'tel',
            '#title' => 'Contact Number',
            '#default_value' => '',
            // '#required' => true,
        );


        // $form['select']['newcol'] = array(
        //     '#type' => 'checkboxes',
        //     '#options' => array('a' => $this->t('aa'), 'b' => $this->t('bb'),'c' =>$this->t('cc'), 'd' =>$this->t('dd')),
        //     '#title' => $this->t('<h1 style="color:blue;background-color:red;">Select one or more options.</h1>'),
        // );

        $form['newcol'] = array(
            '#title' => t('<h1 style="color:blue;background-color:green;">select one or more options .</h1>'),
            '#type' => 'checkboxes',
            '#options' => array(1=> "One", 2 => "Two", 3 => "Three"),
            '#default_value' => array(1, 3),
        );


        // $form['newcol'] = array(
        //     '#type' => 'checkboxes',
        //     '#title' => t('Various Options by Checkbox'),
        //     '#options' => array(
        //       'key1' => t('Option One'),
        //       'key2' => t('Option Two'),
        //       'key3' => t('Option Three'),
        //     ),
        //     '#default_value' => variable_get( 'options', array('key1', 'key3') ),
        //    );

        // $form['newcol'] = array
        // (
        // '#type'            => 'checkboxes',
        // '#options'         => array
        //   (
        //   15 => 'a',
        //   20 => 'b',
        //   25 => 'c',
        //   ),
        // '#default_value'   => variable_get('fd_boxes', 0),
        // );

        $form['terms_condition'] = array(
            '#type' => 'checkbox',
            '#title' => 'Do you agree to the above conditions',
            // '#required' => true,

        );
        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => 'Submit Form',
            '#button_type' => 'primary',
            // '#required' => true,
        );

        return $form;
        // exit;
    }
    /**
     *{@inheritDoc}
     */
    // public function validateForm(array &$form, FormStateInterface $form_state)
    // {
    //     $first_name = $form_state->getValue('first_name');
    //     $last_name = $form_state->getValue('last_name');
    //     $email = $form_state->getValue('email');
    //     $contact_number = $form_state->getValue('contact_number');
    //     $terms_condition = $form_state->getValue('terms_condition');

    //     // if ($first_name == '') {
    //     //     $form_state->setErrorByName('first_name', $this->t('First name can not be left blank'));
    //     // }
    //     if (!preg_match('/^[a-zA-Z]+$/', $first_name)) {
    //         $form_state->setErrorByName('first_name', $this->t('only alphabets can be isnerted'));
    //     }

    //     // if ($last_name == '') {
    //     //     $form_state->setErrorByName('last_name', $this->t('Last name can not be left blank'));
    //     // }
    //     if (!preg_match('/^[a-zA-Z]+$/', $last_name)) {
    //         $form_state->setErrorByName('last_name', $this->t('only alphabets can be isnerted'));
    //     }

    //     // if ($email == '') {
    //     //     $form_state->setErrorByName('last_name', $this->t('email name can not be left blank'));
    //     // }
    //     if (!preg_match('/^([a-zA-Z0-9\-]+[.]?[a-zA-Z0-9\-]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/', $email)) {
    //         $form_state->setErrorByName('email', $this->t('Please enter valid email address!'));
    //     }

    //     // if(!preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/',$email)){
    //     //     $form_state->setErrorByName('email',$this->t('please enter a valid email id'));
    //     // }

    //     // if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    //     //     $form_state->setErrorByName('email',$this->t('please enter a valid email id'));
    //     // }


    //     if (strlen($contact_number) < 10 || strlen($contact_number) > 10) {
    //         $form_state->setErrorByName('contact_number', $this->t('only 10 digits can be used'));
    //     }
    //     if (!preg_match('/^[0-9]+$/', $contact_number)) {
    //         $form_state->setErrorByName('contact_number', $this->t('only digits can be entered in contacts'));
    //     }
    //     // if(!ctype_digit($contact_number)){
    //     //     $form_state->setErrorByName('contact_number',$this->t('only digits can be entered in contacts'));
    //     // }

    //     // if($terms_condition == 0){
    //     //     $form_state->setErrorByName('$terms_contact',$this->t('please agree to the above conditions'));
    //     // }

    //     if ($form_state->getValue('terms_condition') == '0') {
    //         $form_state->setErrorByName('terms_condition', $this->t('MUST agree to the conditions'));
    //     }

    //     //  // If validation errors, add inline errors
    //     // if ($errors = $form_state->getErrors()) {
    //     // // Add error to fields using Symfony Accessor
    //     // $accessor = PropertyAccess::createPropertyAccessor();
    //     // foreach ($errors as $field => $error) {
    //     // if ($accessor->getValue($form, $field)) {
    //     //     $accessor->setValue($form, $field.'[#prefix]', '<div class="form-group error">');
    //     //     $accessor->setValue($form, $field.'[#suffix]', '<div class="input-error-desc">' .$error. '</div></div>');
    //     //     }
    //     //   }
    //     // }


    // }


    //  public function validateForm(array &$form, FormStateInterface $form_state){
    //       $first_name = $form_state->getValue('first_name');
    //       if (($first_name) == '') {
    //             $form_state->setErrorByName('_first_name', $this->t('First Name field is required'));
    //       }
    //       if($form_state->getValue('last_name')==''){
    //           $form_state->setErrorByName('_last_name',$this->t('Last Name is required'));
    //       }
    //       if($form_state->getValue('email')==''){
    //           $form_state->setErrorByName('_email',$this->t('email is required'));
    //       }
    //       if($form_state->getValue('contact_number')==''){
    //           $form_state->setErrorByName('_contact_number',$this->t('contact number is required'));
    //       }
    //       if($form_state->getValue('terms_condition')=='0'){
    //           $form_state->setErrorByName('terms_condition',$this->t('MUST agree to the conditions'));
    //       }







    /**
     * {@inheritdoc}
     */

    public function submitForm(array &$form, FormStateInterface $form_state)
    {


        $data = serialize($form_state->getValue('newcol'));

        $f_n = $form_state->getValue('first_name');
        $l_n = $form_state->getValue('last_name');
        $em = $form_state->getValue('email');
        $p_n = $form_state->getValue('contact_number');
        $term = $form_state->getValue('terms_condition');

        $connection = \Drupal::database();
        $result = $connection->insert('custom_form')
            ->fields([
                'first_name' => $f_n,
                'last_name' => $l_n,
                'email' => $em,
                'contact_number' => $p_n,
                'terms_condition' => $term,
                'newcol' => $data,
            ])
            ->execute();




        // foreach ($form_state as $key => $element)
        // {
        // variable_set($key, $element); // Serialized as necessary, so it will store an array
        // }

        // $postData = $form_state->getValues();
        // unset($postData['submit'], $postData['save'], $postData['form_build_id'], $postData['form_token'], $postData['form_id'], $postData['op']);
        // $query = \Drupal::database();
        // $query->insert('custom_form')->fields($postData)->execute();




        // $postData = $form_state->getValues();

        // echo "<pre>";

        // print_r($postData);

        // echo "</pre>";


    }
}
