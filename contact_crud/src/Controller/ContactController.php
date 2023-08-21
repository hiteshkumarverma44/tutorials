<?php

namespace Drupal\contact_crud\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\OpenModalDialogCommand;

/**
 * Class ContactController.
 *
 * @package Drupal\contact_crud\Controller
 */
class ContactController extends ControllerBase {

    /**
   * {@inheritdoc}
   */
  public function manageContact() {
	$form['form'] = $this->formBuilder()->getForm('Drupal\contact_crud\Form\ContactForm');
	$render_array = $this->formBuilder()->getForm('Drupal\contact_crud\Form\ContactTableForm','All');
	   $form['form1'] = $render_array;
	    // $form['form']['#suffix'] = '<div class="pagination">'.getPager().'</div>';
    return $form;
  }
  /**
   * {@inheritdoc}
   * Deletes the given contact
   */
  public function deleteContactAjax($cid) {
    $res = \Drupal::database()->query("delete from contactcrud where id = :id", array(':id' => $cid));
   $render_array = \Drupal::formBuilder()->getForm('Drupal\contact_crud\Form\ContactTableForm','All');

   $response = new AjaxResponse();
      $response->addCommand(new HtmlCommand('.result_message','' ));
      $response->addCommand(new \Drupal\Core\Ajax\AppendCommand('.result_message', $render_array));
      $response->addCommand(new \Drupal\Core\Ajax\InvokeCommand('.pagination-link', 'removeClass', array('active')));
      $response->addCommand(new \Drupal\Core\Ajax\InvokeCommand('.pagination-link:first', 'addClass', array('active')));

   return $response;

 }

  /**
  * {@inheritdoc}
  * update the given contact
  */
 public function editContactAjax($cid) {

     $conn = Database::getConnection();
     $query = $conn->select('contactcrud', 'st');
     $query->condition('id', $cid)->fields('st');
     $record = $query->execute()->fetchAssoc();

    $render_array = \Drupal::formBuilder()->getForm('Drupal\contact_crud\Form\ContactEditForm',$record);
    $response = new AjaxResponse();
    $response->addCommand(new OpenModalDialogCommand('Edit Form', $render_array, ['width' => '800']));

   return $response;
 }



 public function tablePaginationAjax($no){
     $response = new AjaxResponse();
     $render_array = \Drupal::formBuilder()->getForm('Drupal\contact_crud\Form\ContactTableForm',$no);
      $response->addCommand(new HtmlCommand('.result_message','' ));
       $response->addCommand(new \Drupal\Core\Ajax\AppendCommand('.result_message', $render_array));


    return $response;

 }
}