<?php

namespace Drupal\custom_postal_code\Form;

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

class custom_postal_code_edit extends FormBase
{   
    
    
    /**
     * {@inheritDoc}
     */
    public function getFormId()
    {
        return 'custom_postal_code_edit';
    }
    /**
     * {@inheritDoc}
     */
     public function buildForm(array $form, FormStateInterface $form_state)
    {   
        $id = \Drupal:: routeMatch()->getParameter('sr_no');
        $query = \Drupal::database();
        $data = $query->select('custom_postal_code','n')
                    ->fields('n', array('postal_code', 'description'))
                    ->condition('sr_no', $id , '=')
                    ->execute()->fetchAssoc('sr_no');

        $form['postal_code'] = array(
            '#type' => 'textfield',
            '#title' => t('Postal Code'),
            '#default_value' => (isset($data['postal_code'])) ? $data['postal_code'] : '',
        );

        $form['description'] = array(
            '#type' => 'textfield',
            '#title' => t('Description'),
            '#default_value' =>  (isset($data['description'])) ? $data['description'] : '',

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
        $postal_code = $form_state->getValue('postal_code');
        $description = $form_state->getValue('description');

        $u_date = date("Y-m-d H:i:s");
        $updated_date = strtotime($u_date);

        $id = \Drupal:: routeMatch()->getParameter('sr_no');
        $connection = \Drupal::database();
        $result = $connection->update('custom_postal_code')
        ->fields([
        'postal_code' => $postal_code,
        'description' => $description,
        'updated_date' => $updated_date,
        ])
        ->condition('sr_no', $id , '=')
        ->execute();
        \Drupal::messenger()->addStatus($this->t('Successfully saved your updates'));
        $response = new RedirectResponse("/admin/postal");
        $response->send();
    }

}
