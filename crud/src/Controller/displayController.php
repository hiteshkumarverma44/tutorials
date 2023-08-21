<?php

namespace Drupal\crud\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class dispalyController.
 *
 * @package Drupal\mydata\Controller
 */
class displayController extends ControllerBase
{
    // public function getContent()
    // {
    //     // First we'll tell the user what's going on. This content can be found
    //     // in the twig template file: templates/description.html.twig.
    //     // @todo: Set up links to create nodes and point to devel module.
    //     $build = [
    //       'description' => [
    //         '#theme' => 'mydata_description',
    //         '#description' => 'foo',
    //         '#attributes' => [],
    //       ],
    //     ];
    //     return $build;
    // }

    /**
     * Display.
     *
     * @return string
     *   Return Hello string.
     */
    public function display()
    {
        /**return [
          '#type' => 'markup',
          '#markup' => $this->t('Implement method: display with parameter(s): $name'),
        ];*/
        //create table header
        $header_table = array(
            'id' => $this->t('SrNo'),
            'name' => $this->t('Name'),
            'number' => $this->t('MobileNumber'),
            'email' => $this->t('Email'),
            'gender' => $this->t('Gender'),
            'opt' => $this->t('operations'),
            'opt1' => $this->t('operations'),
        );

        //select records from table
        $query = \Drupal::database()->select('crud_code', 'm');
        $query->fields('m', ['id', 'name', 'number', 'email', 'gender']);
        $results = $query->execute()->fetchAll();
        $rows = array();
        foreach ($results as $data) {
            $edit_link = Link::createFromRoute($this->t('Edit'), 'crud.mydata_form', ['id' => $data->id], ['absolute' => TRUE]);
            $delete_link = Link::createFromRoute($this->t('Delete'), 'crud.crud_delete', ['id' => $data->id], ['absolute' => TRUE]);
            $build_link_action = [
                'action_edit' => [
                    '#type' => 'html_tag',
                    '#value' => $edit_link->toString(),
                    '#tag' => 'div',
                    '#attributes' => ['class' => ['action-edit']]
                ],
                'action_delete' => [
                    '#type' => 'html_tag',
                    '#value' => $delete_link->toString(),
                    '#tag' => 'div',
                    // '#ajax' =>[  'callback' => 'cruddelete',],
                    '#attributes' => [
                        'class' => ['action-edit'],
                        // 'onclick' => 'cruddelete()'
                    ]
                ]
            ];

            //print the data from table
            $rows[] = array(
                'id' => $data->id,
                'name' => $data->name,
                'number' => $data->number,
                'email' => $data->email,
                'gender' => $data->gender,
                'opt' => \Drupal::service('renderer')->render($build_link_action['action_edit']),
                'opt1' => \Drupal::service('renderer')->render($build_link_action['action_delete']),


                // \Drupal::l('Delete', $delete),
                // \Drupal::l('Edit', $edit),
            );
        }
        //display data in site
        $form['table'] = [
            '#type' => 'table',
            '#header' => $header_table,
            '#rows' => $rows,
            '#empty' => $this->t('No users found'),
        ];
        return $form;
    }

    public function cruddelete()
    {
        echo "hello delete";
        // exit;
        $id = \Drupal::routeMatch()->getParameter('id');
        $query = \Drupal::database();
        $query->delete('crud_code')
            ->condition('id', $id)
            ->execute();
        $messanger = \Drupal::messenger();
        $messanger->addStatus('your entry has been deleted');
        $response = new RedirectResponse("/display");
        $response->send();
    }

    public function crud_test()
    {
        echo "test test";
        exit;
    }
}
