<?php

namespace Drupal\contact_crud\Form;

use Drupal\Core\Render\Renderer;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Routing;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Ajax\AlertCommand;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Form\FormState;
use Drupal\Core\Link;
use Drupal\Core\Database\Database;
use Drupal\Core\Render\Element\Submit;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\quickedit\Ajax\FieldFormValidationErrorsCommand;

/**
 * Class ContactForm.
 *
 * @package Drupal\contact_crud\Form
 */
class ContactForm extends FormBase
{


    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'contact_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state, $record = NULL)
    {
        $form['element'] = [
            '#type' => 'markup',
            '#markup' => "<div class='success'></div>",
            '#prefix' => '<div id="div-addform">',
        ];

        $form['fullname'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Full Name'),
            '#maxlength' => 20,
            '#attributes' => array(
                'class' => ['txt-class'],
            ),
            '#default_value' => '',
            '#prefix' => '<div class="form-class-fields" id="name-div-id">',
            '#suffix' => '<div id="name-error"></div></div>',
        ];
        $form['email'] = [
            '#type' => 'email',
            '#title' => $this->t('Email'),
            '#maxlength' => 50,
            '#attributes' => array(
                'class' => ['txt-class'],
            ),
            '#default_value' => '',
            '#prefix' => '<div class="form-class-fields" id="email-div-id1">',
            '#suffix' => '<div id="email-error1"></div></div>',
        ];
        $form['phone'] = [
            '#type' => 'tel',
            '#title' => $this->t('Phone'),
            '#maxlength' => 20,
            '#attributes' => array(
                'class' => ['txt-class'],
            ),
            '#default_value' =>  '',
            '#prefix' => '<div class="form-class-fields" id="phone-div-id">',
            '#suffix' => '<div id="phone-error"></div></div>',

        ];

        $form['actions']['#type'] = 'actions';
        $form['actions']['Save'] = [
            '#type' => 'submit',
            '#button_type' => 'primary',
            '#ajax' => ['callback' => '::submitDataAjaxCallback'],
            // '#validate' => ['::validateSubmit'],
            '#value' => $this->t('Save'),
            '#prefix' => '<div class="form-class-fields">',
            '#suffix' => '</div></div>',
        ];

        // $form['actions']['clear'] = [
        //     '#type' => 'submit',
        //     '#ajax' => ['callback' => '::clearForm', 'wrapper' => 'form-div',],
        //     '#value' => 'Clear',
        //     '#prefix' => '<div class="form-class-fields">',
        //     '#suffix' => '</div></div>',
        // ];
        $render_array['#attached']['library'][] = 'contact_crud/global_styles';
        return $form;
    }


    // public function clearForm(array &$form, FormStateInterface $form_state)
    // {
    //     $response = new AjaxResponse();
    //     $response->addCommand(new InvokeCommand('.txt-class', 'val', ['']));
    //     $response->addCommand(new InvokeCommand('#edit-fullname', 'removeAttr', ['style']));
    //     $response->addCommand(new HtmlCommand('#div-fullname-message', ''));
    //     $response->addCommand(new InvokeCommand('.txt-class', 'val', ['']));

    //     return $response;
    // }

    // public function validateSubmit($form, FormStateInterface $form_state)
    // {
    //     $phone = $form_state->getValue('phone');
    //     if (strlen($phone) < 10 || strlen($phone) > 10) {
    //         $form_state->setErrorByName('phone', $this->t('only 10 digits can be used'));
    //     }
    //     if (!preg_match('/^[0-9]+$/', $phone)) {
    //         $form_state->setErrorByName('phone', $this->t('only digits can be entered in contacts'));
    //     }
    // }

    // public function validateForm(array &$form, FormStateInterface $form_state)
    // {
    //     // $fname = $form_state->getValue('fullname');
    //     // if (!preg_match("/^[a-z]*$/i", $fname)) {
    //     //     $form_state->setErrorByName('fullname', $this->t('Enter a valid name'));
    //     // };

    //     // $email = $form_state->getValue('email');
    //     // if (!preg_match('/^([a-zA-Z0-9\-]+[.]?[a-zA-Z0-9\-]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/', $email)) {
    //     //     $form_state->setErrorByName('email', $this->t('Please enter valid email address!'));
    //     // }
    //     // $phone = $form_state->getValue('phone');
    //     // if (strlen($phone) < 10 || strlen($phone) > 10) {
    //     //     $form_state->setErrorByName('phone', $this->t('only 10 digits can be used'));
    //     // }
    //     // if (!preg_match('/^[0-9]+$/', $phone)) {
    //     //     $form_state->setErrorByName('phone', $this->t('only digits can be entered in contacts'));
    //     // }
    // }
    public function submitDataAjaxCallback($form, FormStateInterface $form_state)
    {

        // $fname = $form_state->getValue('fullname');
        // if (!preg_match("/^[a-z]*$/i", $fname)) {
        //     $form_state->setErrorByName('fullname', $this->t('Enter a valid name'));
        // };

        // $email = $form_state->getValue('email');
        // if (!preg_match('/^([a-zA-Z0-9\-]+[.]?[a-zA-Z0-9\-]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/', $email)) {
        //     $form_state->setErrorByName('email', $this->t('Please enter valid email address!'));
        // }
        // $phone = $form_state->getValue('phone');
        // if (strlen($phone) < 10 || strlen($phone) > 10) {
        //     $form_state->setErrorByName('phone', $this->t('only 10 digits can be used'));
        // }
        // if (!preg_match('/^[0-9]+$/', $phone)) {
        //     $form_state->setErrorByName('phone', $this->t('only digits can be entered in contacts'));
        // }


        $conn = Database::getConnection();
        $field = $form_state->getValues();
        $re_url = Url::fromRoute('contact_crud.contact');
        $fields["fullname"] = $field['fullname'];
        $fields["email"] = $field['email'];
        $fields["phone"] = $field['phone'];
        $response = new AjaxResponse();
        $error = FALSE;

        if (!preg_match("/^[a-z]*$/i", $fields["fullname"])) {
            $css = ['border' => '1px solid red'];
            $text_css = ['color' => 'red'];
            $message = ('Full Name not valid.');
            $response->addCommand(new \Drupal\Core\Ajax\CssCommand('#edit-fullname', $css));
            $response->addCommand(new \Drupal\Core\Ajax\CssCommand('#name-div-id', $text_css));
            $response->addCommand(new \Drupal\Core\Ajax\HtmlCommand('#name-error', $message));
            $error = true;
            // return $response;
        } else {
            $css = ['border' => '1px solid black'];
            $text_css = ['color' => 'black'];
            $message = '';
            $response->addCommand(new \Drupal\Core\Ajax\CssCommand('#edit-fullname', $css));
            $response->addCommand(new \Drupal\Core\Ajax\CssCommand('#name-div-id', $text_css));
            $response->addCommand(new \Drupal\Core\Ajax\HtmlCommand('#name-error', $message));
        }


        // if (!preg_match('/^([a-zA-Z0-9\-]+[.]?[a-zA-Z0-9\-]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/', $fields['email'])) {
        //     $css = ['border' => '1px solid red'];
        //     $text_css = ['color' => 'red'];
        //     $message = ('email is not valid.');
        //     $response->addCommand(new \Drupal\Core\Ajax\CssCommand('#edit-email', $css));
        //     $response->addCommand(new \Drupal\Core\Ajax\CssCommand('#email-div-id', $text_css));
        //     $response->addCommand(new \Drupal\Core\Ajax\HtmlCommand('#email-error', $message));
        //     // return $response;
        //     $error = true;
        // } else {
        //     $css = ['border' => '1px solid black'];
        //     $text_css = ['color' => 'black'];
        //     $message = '';
        //     $response->addCommand(new \Drupal\Core\Ajax\CssCommand('#edit-email', $css));
        //     $response->addCommand(new \Drupal\Core\Ajax\CssCommand('#email-div-id', $text_css));
        //     $response->addCommand(new \Drupal\Core\Ajax\HtmlCommand('#email-error', $message));
        // }

        if (!preg_match("/^([a-zA-Z0-9\-]+[.]?[a-zA-Z0-9\-]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/", $fields["email"])) {
            $css = ['border' => '1px solid red'];
            $text_css = ['color' => 'red'];
            $message = ('Email not valid.');
            $response->addCommand(new \Drupal\Core\Ajax\CssCommand('#edit-email', $css));
            $response->addCommand(new \Drupal\Core\Ajax\CssCommand('#email-div-id1', $text_css));
            $response->addCommand(new \Drupal\Core\Ajax\HtmlCommand('#email-error1', $message));
            $error = true;
            // return $response;
        } else {
            $css = ['border' => '1px solid black'];
            $text_css = ['color' => 'black'];
            $message = '';
            $response->addCommand(new \Drupal\Core\Ajax\CssCommand('#edit-email', $css));
            $response->addCommand(new \Drupal\Core\Ajax\CssCommand('#email-div-id1', $text_css));
            $response->addCommand(new \Drupal\Core\Ajax\HtmlCommand('#email-error1', $message));
        }

        if (strlen($fields["phone"]) != 10) {
            $css = ['border' => '1px solid red'];
            $text_css = ['color' => 'red'];
            $message = ('phone no not valid.');
            $response->addCommand(new \Drupal\Core\Ajax\CssCommand('#edit-phone', $css));
            $response->addCommand(new \Drupal\Core\Ajax\CssCommand('#phone-div-id', $text_css));
            $response->addCommand(new \Drupal\Core\Ajax\HtmlCommand('#phone-error', $message));
            // return $response;
            $error = true;
        } else {
            $css = ['border' => '1px solid black'];
            $text_css = ['color' => 'black'];
            $message = '';
            $response->addCommand(new \Drupal\Core\Ajax\CssCommand('#edit-phone', $css));
            $response->addCommand(new \Drupal\Core\Ajax\CssCommand('#phone-div-id', $text_css));
            $response->addCommand(new \Drupal\Core\Ajax\HtmlCommand('#phone-error', $message));
        }


        if ($error) {
            return $response;
        }

        $conn->insert('contactcrud')->fields($fields)->execute();
        $dialogText['#attached']['library'][] = 'core/drupal.dialog.ajax';
        $render_array = \Drupal::formBuilder()->getForm('Drupal\contact_crud\Form\ContactTableForm', 'All');
        $response = new \Drupal\Core\Ajax\AjaxResponse();
        $response->addCommand(new HtmlCommand('.result_message', ''));
        $response->addCommand(new \Drupal\Core\Ajax\AppendCommand('.result_message', $render_array));
        $response->addCommand(new HtmlCommand('.pagination', ''));
        $response->addCommand(new \Drupal\Core\Ajax\AppendCommand('.pagination', getPager()));
        $response->addCommand(new \Drupal\Core\Ajax\InvokeCommand('.pagination-link', 'removeClass', array('active')));
        $response->addCommand(new \Drupal\Core\Ajax\InvokeCommand('.pagination-link:first', 'addClass', array('active')));
        $response->addCommand(new InvokeCommand('.txt-class', 'val', ['']));

        // return $response;

        $css = ['border' => '1px solid black'];
        $text_css = ['color' => 'black'];
        $message = '';
        $response->addCommand(new \Drupal\Core\Ajax\CssCommand('#edit-email', $css));
        $response->addCommand(new \Drupal\Core\Ajax\CssCommand('#email-div-id1', $text_css));
        $response->addCommand(new \Drupal\Core\Ajax\HtmlCommand('#email-error1', $message));
        $response->addCommand(new \Drupal\Core\Ajax\CssCommand('#edit-phone', $css));
        $response->addCommand(new \Drupal\Core\Ajax\CssCommand('#phone-div-id', $text_css));
        $response->addCommand(new \Drupal\Core\Ajax\HtmlCommand('#phone-error', $message));
        $response->addCommand(new \Drupal\Core\Ajax\CssCommand('#edit-fullname', $css));
        $response->addCommand(new \Drupal\Core\Ajax\CssCommand('#name-div-id', $text_css));
        $response->addCommand(new \Drupal\Core\Ajax\HtmlCommand('#name-error', $message));

        return $response;
    }



    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
    }
}
