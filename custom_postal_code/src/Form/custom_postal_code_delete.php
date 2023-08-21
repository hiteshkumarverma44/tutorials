<?php
namespace Drupal\custom_postal_code\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;

class custom_postal_code_delete extends ConfirmFormBase {
    public $sr_no;

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'delete_form';
    }

    public function getQuestion() {
        return $this->t('Delete data');
    }

    public function getCancelUrl() {
        // return new Url('../');
    }

    public function getDescription() {
        return $this->t('Do you want to delete data number %sr_no ?', ['%sr_no' => $this->sr_no]);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfirmText() {
        return $this->t('Delete Postal Code!');
    }

    /**
     * {@inheritdoc}
     */
    public function getCancelText() {
        return $this->t('Cancel');
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state, $sr_no = NULL) {

        $this->sr_no = $sr_no;
        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        parent::validateForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $query = \Drupal::database();
        $query->delete('custom_postal_code')
            ->condition('sr_no', $this->sr_no)
            ->execute();
        \Drupal::messenger()->addStatus('Successfully deleted.');
        $response = new \Symfony\Component\HttpFoundation\RedirectResponse('../');
        $response->send();
    }
}