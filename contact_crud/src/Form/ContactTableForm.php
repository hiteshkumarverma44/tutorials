<?php

namespace Drupal\contact_crud\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Link;

/**
 * Provides the list of Contact.
 */

class ContactTableForm extends FormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'contact_crud_table_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $pageNo = NULL)
  {
    $header = [
      'id' => $this->t('Id'),
      'fullname' => $this->t('Full Name'),
      'email' => $this->t('Email'),
      'phone' => $this->t('phone'),
      'opt' => $this->t('Operations')
    ];

    if ($pageNo != '') {
      $form['table'] = [
        '#type' => 'table',
        '#header' => $header,
        '#rows' => $this->get_Contacts($pageNo),
        '#empty' => $this->t('No users found'),
      ];
    } else {
      $form['table'] = [
        '#type' => 'table',
        '#header' => $header,
        '#rows' => $this->get_Contacts("All"),
        '#empty' => $this->t('No records found'),
      ];
    }

    $form['#attached']['library'][] = 'core/drupal.dialog.ajax';
    $form['#attached']['library'][] = 'contact_crud/global_styles';
    $form['#prefix'] = '<div class="result_message">';
    $form['#suffix'] = '</div>';
    $form['#cache'] = [
      'max-age' => 0
    ];
    // $form['#attached']['library'][] = 'contact_crud/global_styles';
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state)
  {
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
  }

  function get_Contacts($opt)
  {
    $res = array();
    if ($opt == "All") {

      $results = \Drupal::database()->select('contactcrud', 'st');

      $results->fields('st');
      $results->range(0, 15);
      $results->orderBy('st.id', 'ASC');
      $res = $results->execute()->fetchAll();
      $ret = [];
    } else {
      $query = \Drupal::database()->select('contactcrud', 'st');

      $query->fields('st');
      $query->range($opt * 15, 15);
      $query->orderBy('st.id', 'ASC');
      $res = $query->execute()->fetchAll();
      $ret = [];
    }
    foreach ($res as $row) {


      $edit = Url::fromUserInput('/ajax/contact_crud/contact/edit/' . $row->id);
      // $delete = Url::fromUserInput('/ajax/contact_crud/contact/delete/' . $row->id, array('attributes' => array('onclick' => "return confirm('Are you sure you want to delete ?');")));
      $delete = Url::fromUserInput('/ajax/contact_crud/contact/delete/' . $row->id);

      $edit_link = Link::fromTextAndUrl(t('Edit'), $edit);
      $delete_link = Link::fromTextAndUrl(t('Delete'), $delete);
      $edit_link = $edit_link->toRenderable();
      $delete_link  = $delete_link->toRenderable();
      $edit_link['#attributes'] = ['class' => 'use-ajax'];
      $delete_link['#attributes'] = ['class' => 'use-ajax'];


      $mainLink = t('@linkApprove  @linkReject', array('@linkApprove' => $edit_link, '@linkReject' => $delete_link));


      $ret[] = [
        'id' => $row->id,
        'fullname' => $row->fullname,
        'email' => $row->email,
        'phone' => $row->phone,
        'opt' => \Drupal::service('renderer')->render($delete_link),
        'opt1' => \Drupal::service('renderer')->render($edit_link),
      ];
    }
    return $ret;
  }
}
