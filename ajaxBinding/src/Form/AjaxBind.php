<?php

namespace Drupal\ajaxBinding\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class AjaxBind extends FormBase
{
    /**
     * get form id
     */

    public function getFormId()
    {
        return 'ajax_form_id';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {

        $triggering_element = $form_state->getTriggeringElement();
        $form['country'] = [
            '#type' => 'select',
            '#title' => $this->t('Country'),
            '#options' => [
                'serbia' => $this->t('Serbia'),
                'usa' => $this->t('USA'),
                'italy' => $this->t('Italy'),
                'france' => $this->t('France'),
                'germany' => $this->t('Germany'),
            ],
            '#ajax' => [
                'callback' => [$this, 'reloadCity'],
                'event' => 'change',
                'wrapper' => 'city-field-wrapper',
            ],
        ];

        // $form['submit'] = [
        //     '#type' => 'submit',
        //     '#title' => 'save'
        // ];


        $form['city'] = [
            '#type' => 'select',
            '#title' => $this->t('City'),
            '#options' => [

                'belgrade' => $this->t('Belgrade'),
                'washington' => $this->t('Washington'),
                'rome' => $this->t('Rome'),
                'paris' => $this->t('Paris'),
                'berlin' => $this->t('Berlin'),
            ],
            '#prefix' => '<div id="city-field-wrapper">',
            '#suffix' => '</div>',
            '#value' => empty($triggering_element) ? 'belgrade' : $this->getCityForCountry($triggering_element['#value']),
        ];

        return $form;
    }


    public function reloadCity(array $form, FormStateInterface $form_state)
    {
        return $form['city'];
    }

    protected function getCityForCountry($country)
    {
        $map = [
            'serbia' => 'belgrade',
            'usa' => 'washington',
            'italy' => 'rome',
            'france' => 'paris',
            'germany' => 'berlin',
        ];

        return $map[$country] ?? null;
    }


    public function submitForm(array &$form, FormStateInterface $form_state)
    {
    }
}
