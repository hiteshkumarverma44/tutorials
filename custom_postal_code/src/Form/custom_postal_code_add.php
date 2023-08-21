<?php

namespace Drupal\custom_postal_code\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Code\DataBase\DataBase;
use Drupal\Core\Form\FormState;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class custom_postal_code_add extends FormBase
{
    /**
     * {@inheritDoc}
     */
    public function getFormId()
    {
        return 'custom_postal_code_add';
    }
    /**
     * {@inheritDoc}
     */

    public function buildForm(array $form, FormStateInterface $form_state)
    {


        $form['postal_code'] = array(
            '#type' => 'textfield',
            '#title' => t('Postal Code'),
            '#default_value' => '',
        );

        $form['description'] = array(
            '#type' => 'textfield',
            '#title' => t('Description'),
            '#default_value' => '',
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

        $c_date = date("Y-m-d H:i:s");
        $created_date = strtotime($c_date);
        $u_date = date("Y-m-d H:i:s");
        $updated_date = strtotime($u_date);

        $connection = \Drupal::database();
        $result = $connection->insert('custom_postal_code')
            ->fields([
                'postal_code' => $postal_code,
                'description' => $description,
                'created_date' => $created_date,
                'updated_date' => $updated_date,
            ])
            ->execute();

        \Drupal::messenger()->addStatus($this->t('Successfully added your postal code'));
        $response = new RedirectResponse("/admin/postal");
        $response->send();
    }
}
