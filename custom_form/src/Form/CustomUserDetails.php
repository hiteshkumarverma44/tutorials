<?php

namespace Drupal\custom_form\Form;

use \Drupal\Core\Form\FormBase;
use \Drupal\Core\Form\FormStateInterface;

class CustomUserDetails extends FormBase
{
    public function getFormId()
    {
        return "custom user detailed form";
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {

        $form['#attached']['library'][] = "custom_form/customjsform";
        // kint($ $form['#attached']['library'][] = "custom_form/customjsform");
        // dd($ $form['#attached']['library'][] = "custom_form/customjsform");
        // dump($ $form['#attached']['library'][] = "custom_form/customjsform");
        // exit;
        $form['username'] =[
            '#type' => 'textfield',
            '#title' => 'User Name',
            '#required' => true,
        ];
        $form['usermail'] =[
            '#type' => 'textfield',
            '#title' => 'User Email',
            '#required' => true,
        ];
        $form['usergender'] =[
            '#type' => 'select',
            '#title' => 'User Gender',
            '#required' => true,
            '#options' =>[
                'male' => 'male-1',
                'female'=>'female-2',
                'other' => 'other-3'
            ],
        ];
        $form['submit']=[
            '#type' => 'submit',
            '#value' => 'save'
        ];

        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        if(strlen($form_state->getValue('username')) < 6){
            $form_state->setErrorByName('username','please make sure your username length is more than 5');
        }

    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        \Drupal::messenger()->addMessage('user details submitted successfully');

        // $value = $form_state->getValues();
        // \Drupal::database()->insert('user_details')->fields([
        //     'name' => $value['username'],
        //     'mail' => $value['usermail'],
        //     'gender' => $value['usergender'],
        // ])->execute();
    }
}
