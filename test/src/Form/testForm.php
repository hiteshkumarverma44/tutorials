<?php

namespace Drupal\test\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Code\DataBase\DataBase;
use Drupal\Core\Form\FormState;
use Symfony\Component\HttpFoundation\RedirectResponse;




class testForm extends FormBase
{
    /**
     * {@inheritDoc}
     */
    public function getFormId()
    {
        return 'test_form';
    }
    /**
     *{@inheritDoc}
     */

    public function buildForm(array $form, FormStateInterface $form_state)
    {

        // $resultone = \Drupal::database()->select('testconfi', 'c')
        //     ->fields('c', array('test_confi_id', 'heading', 'currentDate'))
        //     ->execute()->fetchAllAssoc('test_confi_id');

        // $rows = array();
        // foreach ($resultone as $row => $content) {
        //     $rows[] = array(
        //         'data' => array(
        //             $content->test_confi_id, $content->heading, $content->currentDate
        //         )
        //     );
        // }

        // $heading = $content->test_confi_id;
        // echo $content->test_confi_id;

        // $cdate = $content->currentDate;
        // echo $content->currentDate;


        $config = \Drupal::config('test_confi.settings');
        // Will print 'Hello'.
        print $config->get('heading');
        // Will print 'en'.

        echo "<br>";
        print $config->get('currentDate');

        // $form['headingOne'] = array(
        //     '#type' => 'textfield',
        //     '#title' => $this->t('Heading'),
        //     '#default_value' => $config->get('heading'),
        //   );


        $form['first_name'] = array(
            '#type' => 'textfield',
            '#title' => t('First Name'),
            '#default_value' => '',
            // '#required' => true,

        );
        $form['last_name'] = array(
            '#type' => 'textfield',
            '#title' => t('Last Name'),
            '#default_value' => '',
            // '#required' => true,

        );
        $form['dob'] = array(
            '#type' => 'date',
            '#title' => t('DOB'),
            '#default_value' => '',
            // '#required' => true,
        );
        $form['gender'] = array(
            '#type' => 'select',
            '#title' => 'Select Gender',
            '#options' => array(
                "Male" => "Male",
                "Female" => "Female",
                "Other" => "Other"
            ),
            '#default_value' => '',
            // '#required' => true,
        );

        $form['profile_image'] = [
            '#type' => 'managed_file',
            '#title' => t('Profile Picture'),
            '#upload_validators' => array(
                'file_validate_extensions' => array('gif png jpg jpeg'),
                'file_validate_size' => array(25600000),
            ),
            '#theme' => 'image_widget',
            '#preview_image_style' => 'medium',
            '#upload_location' => 'public://profile-pictures',
            // '#required' => TRUE,
        ];

        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => 'Submit Form',
            '#button_type' => 'primary',
            // '#required' => true,
        );

        return $form;
    }


    /**
     * {@inheritDoc}
     */

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        $fname = $form_state->getValue('first_name');
        if (!preg_match("/^[a-z]*$/i", $fname)) {
            $form_state->setErrorByName('first_name', $this->t('Enter a valid name'));
        };

        $lname = $form_state->getValue('last_name');
        if (!preg_match("/^[a-z]*$/i", $lname)) {
            $form_state->setErrorByName('last_name', $this->t('Enter a valid name'));
        };


        // exit;
    }

    /**
     * {@inheritdoc}
     */

    public function submitForm(array &$form, FormStateInterface $form_state)
    {


        //     $data = serialize($form_state->getValue('newcol'));

        $f_n = $form_state->getValue('first_name');
        $l_n = $form_state->getValue('last_name');
        $dob = $form_state->getValue('dob');
        $gender = $form_state->getValue('gender');
        $image = $form_state->getValue('profile_image');

        $connection = \Drupal::database();
        $result = $connection->insert('testform')
            ->fields([
                'first_name' => $f_n,
                'last_name' => $l_n,
                'dob' => $dob,
                'gender' => $gender,
                'profile_image' => $image,
            ])
            ->execute();

        $messenger = \Drupal::messenger();
        $messenger->addStatus(t('Form Submitted Successfully'));

        // foreach ($form_state->getValues() as $key => $value) {
        //     \Drupal::messenger()->addStatus($key . ': ' . $value);
        // }

        $form_state->setRedirect("test.showdata");
    }
}
