<?php
namespace Drupal\ajaxform\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;

class deleteajaxform extends ConfirmFormBase {
    public $id;

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'deleteajaxformid';
    }

    public function getQuestion() {
        return $this->t('Delete data');
    }

    public function getCancelUrl() {
        // return new Url('../');
    }

    public function getDescription() {
        return $this->t('Do you want to delete data number %id ?', ['%id' => $this->id]);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfirmText() {
        return $this->t('Delete contact');
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
    public function buildForm(array $form, FormStateInterface $form_state, $id = NULL) {

        $this->id = $id;
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
        $query->delete('ajaxform')
            ->condition('id', $this->id)
            ->execute();
        \Drupal::messenger()->addStatus('Successfully deleted.');
        $response = new \Symfony\Component\HttpFoundation\RedirectResponse('/ajax/showform');
        $response->send();
        // \Drupal::messenger()->addStatus($this->t('Successfully saved your updates'));
        // $response = new RedirectResponse("/ajax/showform");
        // $response->send();
    }
}