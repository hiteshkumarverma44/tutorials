<?php

/**
 * @file
 * Contains \Drupal\heroblock\Form.
 */

namespace Drupal\heroblock\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;


class customForm extends FormBase
{
    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'custom_form_id';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {

        // $form['my_file'] = [
        //     '#type' => 'managed_file',
        //     '#title' => 'Add Media',
        //     '#name' => 'my_custom_file',
        //     '#description' => $this->t('my file description'),
        //     '#default_value' => [$config->get('my_file')],
        //     '#upload_location' => 'public://'
        //   ];

        $form['media'] = [
            '#type' => 'managed_file',
            '#title' => t('Add Media'),
            '#upload_validators' => array(
                'file_validate_extensions' => array('gif png jpg jpeg'),
                'file_validate_size' => array(25600000),
            ),
            // **'#theme' => 'image_widget',**
            // **'#preview_image_style' => 'medium',**
            '#upload_location' => 'public://profile-pictures',
            '#required' => TRUE,
        ];

        $form['name'] = array(
            '#type' => 'textfield',
            '#title' => t('Name:'),
            //   '#required' => TRUE,
        );

        $form['title'] = array(
            '#type' => 'textfield',
            '#title' => t('Title'),
            //   '#required' => TRUE,
        );
        $form['test_link'] = [
            '#type' => 'url',
            '#title' => $this->t('Link title'),
            // Example of a Url object from a route. See the documentation
            // for more methods that may help generate a Url object.
            '#url' => Url::fromRoute('entity.node.canonical', ['node' => 1]),
          ];
        // contact_crud.contactmanage:


        // $build['examples_link'] = [
        //     '#title' => $this
        //       ->t('Examples'),
        //     '#type' => 'link',
        //     '#url' => \Drupal\Core\Url::fromRoute('examples.description'),
        //   ];
        // echo "<pre>";
        // print_r($form['link']);
        // echo "</pre>";
        // exit;
        $form['selectposition'] = array(
            '#title' => t('select position'),
            '#type' => 'select',
            // '#description' => '.',
            '#options' => array(t('--- SELECT ---'), t('left'), t('right')),
        );

        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Register'),
            '#button_type' => 'primary',
        );
        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {

        // drupal_set_message($this->t('@emp_name ,Your application is being submitted!', array('@emp_name' => $form_state->getValue('employee_name'))));
    }
}
