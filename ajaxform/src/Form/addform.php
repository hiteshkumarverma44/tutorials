<?php

namespace Drupal\ajaxform\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Url;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;

class addform extends FormBase
{

    /**
     * {@inheritDoc}
     */
    public function getFormId()
    {
        return 'ajaxform';
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {

        $form['element'] = [
            '#type' => 'markup',
            '#markup' => "<div class='success'></div>",
            '#prefix' => '<div id="div-addform">',
        ];

        $form['fullname'] = [
            '#type' => 'textfield',
            '#title' => t('Full Name :'),
            '#maxlength' => 20,
            '#attributes' => array(
                'class' => ['text-class']
            ),
            '#default_value' => '',
            '#prefix' => '<div class="form-class-fields">',
            '#suffix' => '</div>',
        ];
        $form['email'] = [
            '#type' => 'email',
            '#title' => $this->t('Email :'),
            '#maxlength' => 50,
            '#attributes' => array(
                'class' => ['text-class'],
            ),
            '#default_value' => '',
            '#prefix' => '<div class="form-class-fields">',
            '#suffix' => '</div>',
        ];

        $form['phone'] = [
            '#type' => 'tel',
            '#title' => $this->t('Phone :'),
            '#maxlength' => 20,
            '#attributes' => array(
                'class' => ['text-class'],
            ),
            '#default_value' =>  '',
            '#prefix' => '<div class="form-class-fields">',
            '#suffix' => '</div>',
        ];

        // $form['actions']['#type'] = 'actions';
        $form['actions']['Save'] = [
            '#type' => 'submit',
            '#button_type' => 'primary',
            // '#ajax' => ['callback' => '::submitData'],
            '#ajax' => [
                'callback' => [$this, 'submitData'],
                'event' => 'click',
            ],
            '#value' => $this->t('Submit'),
            '#attributes' => array(
                'class' => ['ajaxSubmitButton'],
            ),
            // '#suffix' => '</div>',
            '#prefix' => '<div class="form-class-fields">',
            '#suffix' => '</div></div>',
        ];

        $form['#attached']['library'] = 'ajaxform/ajaxform_js_css';

        return $form;
    }

    public function submitData(array &$form, FormStateInterface $form_state)
    {
        $ajax_response = new AjaxResponse();
        $ajax_response->addCommand(new HtmlCommand('.success', 'form submitted successfully'));



        $messenger = \Drupal::messenger();
        $messenger->addStatus(t('Form Submitted Successfully'));

        // foreach ($form_state->getValues() as $key => $value) {
        //     \Drupal::messenger()->addStatus($key . ': ' . $value);
        // }

        $form_state->setRedirect("ajaxform.showform");
        $url = Url::fromRoute('ajaxform.showform');
        $command = new RedirectCommand($url->toString());
        $ajax_response->addCommand($command);
        return $ajax_response;
    }

    /**
     * {@inheritdoc}
     */

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $name = $form_state->getValue('fullname');
        $email = $form_state->getValue('email');
        $phone = $form_state->getValue('phone');


        $connection = \Drupal::database();
        $result = $connection->insert('ajaxform')
            ->fields([
                'fullname' => $name,
                'email' => $email,
                'phone' => $phone,

            ])
            ->execute();
    }
}
