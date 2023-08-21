<?php

namespace Drupal\custom_multistep_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class CustomMultistepForm extends FormBase
{

    public function getFormId()
    {
        return "custom multistep form";
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {

        if($form_state->get("cpage") && $form_state->get("cpage") == 2){
            return $this->secondForm($form, $form_state);
        }   // if cpage i.e. current page ==2 it will automatically return to the secondForm

        if($form_state->get("cpage") && $form_state->get("cpage") == 3){
            return $this->thirdForm($form, $form_state);
        }

        $form_state->set("cpage", 1);   //setting the current page to 1

        $form['firstname'] = [
            '#type' => 'textfield',
            '#title' => 'First Name',
            '#default_value' => $form_state->getValue("firstname"),
        ];

        $form['firstnext'] = [
            '#type' => 'submit',
            '#value' => 'Next',
            '#submit' => ['::firstNext']    // calling the firstNext function on the next button
        ];  // building the next button
        return $form;
    }

    public function firstNext(array &$form, FormStateInterface $form_state)
    {
        $form_state->set("cpage", 2);   // current page set to 2
        $form_state->set("data",[
            'firstname' => $form_state->getValue("firstname"),
        ]); //setting the data with the firstname to carry to page 2 and page 3
        $form_state->setRebuild(TRUE);  //allowing form to rebuild
    }

    public function secondForm(array $form, FormStateInterface $form_state)
    {
        $form['lastname'] = [
            '#type' => 'textfield',
            '#title' => 'Last Name',
            '#default_value' => $form_state->getValue("lastname"),
        ];

        $form['secondback'] = [
            '#type' => 'submit',
            '#value' => 'Back',
            '#submit' => ['::secondBack']   // on click of back calling the secondBack function .
        ];
        $form['secondnext'] = [
            '#type' => 'submit',
            '#value' => 'Next',
            '#submit' => ['::secondNext']
        ];

        return $form;
    }

    public function secondBack(array &$form, FormStateInterface $form_state)
    {
        $form_state->setValues($form_state->get("data"));
        $form_state->set("cpage",1);
        $form_state->setRebuild(TRUE);
    }

    public function secondNext(array &$form, FormStateInterface $form_state)
    {
        $values = $form_state->get("data"); // getting the date of firstname
        $form_state->set("cpage",3);    // setting current page to 3
        $form_state->set("data",[
            'firstname' => $values['firstName'],    //taking firstname and storing it into data, to set things right.
            'lastname' => $form_state->getValue("lastname"),    // taking lastname from the data and collecting it to third page.
        ]);
        $form_state->setRebuild(TRUE);
    }

    public function thirdForm(array $form, FormStateInterface $form_state)
    {
        $form['email'] = [
            '#type' => 'email',
            '#title' => 'Email ID',
        ];

        $form['thirdback'] = [
            '#type' => 'submit',
            '#value' => 'Back',
            '#submit' => ['::thirdBack']
        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => 'submit',
        ];

        return $form;
    }

    public function thirdBack(array &$form, FormStateInterface $form_state)
    {
        $form_state->setValues($form_state->get("data"));
        $form_state->set("cpage",2);
        $form_state->setRebuild(TRUE);
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $mail = $form_state->getValue("email");
        $values = $form_state->get("data");
        $firstname = $values['firstname'];
        $lastname = $values['lastname'];
        $this->messenger()->addMessage($this->t("the form submitted successfully with name : @first @last , Email: @mail",[
            '@first' => $firstname,
            '@last' => $lastname,
            '@email' => $mail
        ]));

    }
}
