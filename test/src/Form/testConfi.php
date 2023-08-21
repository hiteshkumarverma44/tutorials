<?php

namespace Drupal\test\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class testConfi extends ConfigFormBase
{

    /**
     * Config settings.
     *
     * @var string
     */
    const SETTINGS = 'test_confi.settings';

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'test_confi_admin_settings';
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames()
    {
        return [
            static::SETTINGS,
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $config = $this->config(static::SETTINGS);

        $today = date("d-m-Y");

        $form['heading'] = array(
            '#type' => 'textfield',
            '#title' => t('Heading'),
            '#default_value' => 'Custom Test form config Heading'
        );

        $form['currentDate'] = array(
            // '#type' => 'date',
            '#type' => 'textfield',
            '#title' => 'Current Date',
            '#default_value' => $today,
            // '#date_increment' => 1,
        );

        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */


    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        // Retrieve the configuration.
        $this->config(static::SETTINGS)
            // Set the submitted configuration setting.
            ->set('heading', $form_state->getValue('heading'))
            // You can set multiple configurations at once by making
            // multiple calls to set().
            ->set('date', $form_state->getValue('currentDate'))
            ->save();
        parent::submitForm($form, $form_state);

        // $config = $this->config('test_confi.settings');
        // $config->set('heading', $form_state->getValue('heading'));
        // $config->save();

        $postData = $form_state->getValues();
        unset($postData['submit'], $postData['save'], $postData['form_build_id'], $postData['form_token'], $postData['form_id'], $postData['op']);
        $query = \Drupal::database();
        $query->insert('testconfi')->fields($postData)->execute();
    }
}
