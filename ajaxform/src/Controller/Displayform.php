<?php

/**
 * @file
 * Contains \Drupal\ajaxform\Controller\Display.
 */

namespace Drupal\ajaxform\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Class Displayform.
 *
 * @package Drupal\ajaxform\Controller
 */
class Displayform extends ControllerBase
{

    // /**
    //  * {@inheritdoc}
    //  */
    // public function manageContact()
    // {
    //     $form['form'] = $this->formBuilder()->getForm('Drupal\ajaxform\Form\addform');
    //     $render_array = $this->formBuilder()->getForm('Drupal\ajaxform\Controller\Displayform', 'All');
    //     $form['form1'] = $render_array;
    //     return $form;
    // }

    /**
     * showform.
     *
     * @return array
     *   Return Table format data.
     */
    public function showform()
    {

        // you can write your own query to fetch the data I have given my example.

        $result = \Drupal::database()->select('ajaxform', 'n')
            ->fields('n', array('id', 'fullname', 'email', 'phone'))
            ->execute()->fetchAllAssoc('id');
        // Create the row element.
        $rows = array();
        foreach ($result as $data) {
            $edit_link = Link::createFromRoute($this->t('Edit'), 'ajaxform.ajax_edit_form', ['id' => $data->id], ['absolute' => TRUE]);
            $delete_link = Link::createFromRoute($this->t('Delete'), 'ajaxform.ajax_delete', ['id' => $data->id], ['absolute' => TRUE]);
            $build_link_action = [
                'action_edit' => [
                    '#type' => 'html_tag',
                    '#value' => $edit_link->toString(),
                    // '#value' => 'edit',
                    '#tag' => 'div',
                    '#attributes' => ['class' => ['action-edit']]
                ],
                'action_delete' => [
                    '#type' => 'html_tag',
                    '#value' => $delete_link->toString(),
                    // '#value' => 'delete',
                    '#tag' => 'div',
                    '#attributes' => ['class' => ['action-edit']]
                ]
            ];
            $rows[] = [
                'id' => $data->id,
                'fullname' => $data->fullname,
                'email' => $data->email,
                'phone' => $data->phone,

                'operations' => \Drupal::service('renderer')->render($build_link_action)
            ];
        }
        // Create the header.
        $header = array('No', 'Full Name', 'Email', 'Phone', 'Operation');
        $output = array(
            '#theme' => 'table',    // Here you can write #type also instead of #theme.
            '#header' => $header,
            '#rows' => $rows
        );
        return $output;
    }
}
