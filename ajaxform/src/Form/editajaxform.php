<?php

namespace Drupal\ajaxform\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Code\DataBase\DataBase;
use Drupal\Core\Form\FormState;
use Drupal\Core\Messenger\MessengerInterface;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\file\Entity\File;

use Symfony\Component\HttpFoundation\RedirectResponse;

class editajaxform extends FormBase
{


    /**
     * {@inheritDoc}
     */
    public function getFormId()
    {
        return 'editajaxformid';
    }
    /**
     * {@inheritDoc}
     */
     public function buildForm(array $form, FormStateInterface $form_state)
    {
        $id = \Drupal:: routeMatch()->getParameter('id');
        $query = \Drupal::database();
        $data = $query->select('ajaxform','n')
                    ->fields('n', array('fullname','email', 'phone'))
                    ->condition('id', $id , '=')
                    ->execute()->fetchAssoc('id');

        $form['fullname'] = array(
            '#type' => 'textfield',
            '#title' => t('Full Name'),
            '#default_value' => (isset($data['fullname'])) ? $data['fullname'] : '',
        );

        $form['email'] = array(
            '#type' => 'textfield',
            '#title' => t('email'),
            '#default_value' =>  (isset($data['email'])) ? $data['email'] : '',

        );

        $form['phone'] = array(
            '#type' => 'textfield',
            '#title' => t('phone'),
            '#default_value' =>  (isset($data['phone'])) ? $data['phone'] : '',

        );

        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => 'Save',
            '#button_type' => 'primary',
        );

        return $form;
    }

     /**
     * {@inheritdoc}
     */

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $fullname = $form_state->getValue('fullname');
        $email = $form_state->getValue('email');
        $phone = $form_state->getValue('phone');


        $id = \Drupal:: routeMatch()->getParameter('id');
        $connection = \Drupal::database();
        $result = $connection->update('ajaxform')
        ->fields([
        'fullname' => $fullname,
        'email' => $email,
        'phone' => $phone,
        ])
        ->condition('id', $id , '=')
        ->execute();
        \Drupal::messenger()->addStatus($this->t('Successfully saved your updates'));
        $response = new RedirectResponse("/ajax/showform");
        $response->send();
    }

}
