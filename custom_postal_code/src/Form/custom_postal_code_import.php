<?php

namespace Drupal\custom_postal_code\Form;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Code\DataBase\DataBase;
use Drupal\Core\Form\FormState;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;


class custom_postal_code_import extends FormBase
{
  /**
   * {@inheritDoc}
   */
  public function getFormId()
  {
    return 'digital';
  }

  /**
   * {@inheritDoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {

    $form = array(
      '#attributes' => array('enctype' => 'multipart/form-data'),
    );

    $form['file_upload_details'] = array(
      '#markup' => t('<b>The File</b>'),
    );

    $validators = array(
      'file_validate_extensions' => array('xlsx'),
    );
    $form['excel_file'] = array(
      '#type' => 'managed_file',
      '#name' => 'excel_file',
      '#title' => t('File *'),
      '#size' => 20,
      '#description' => t('Excel format only'),
      '#upload_validators' => $validators,
      '#upload_location' => 'public://content/excel_files/',
    );

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('import'),
      '#button_type' => 'primary',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $file = \Drupal::entityTypeManager()->getStorage('file')
      ->load($form_state->getValue('excel_file')[0]);
    $full_path = $file->get('uri')->value;
    $file_name = basename($full_path);
    $inputFileName = \Drupal::service('file_system')->realpath('public://content/excel_files/' . $file_name);

    $spreadsheet = IOFactory::load($inputFileName);

    $sheetData = $spreadsheet->getActiveSheet();

    $rows = array();
    foreach ($sheetData->getRowIterator() as $row) {
      $cellIterator = $row->getCellIterator();
      $cellIterator->setIterateOnlyExistingCells(FALSE);
      $cells = [];
      foreach ($cellIterator as $cell) {
        $cells[] = $cell->getValue();
      }

      $rows[] = $cells;
    }

    foreach ($rows as $value) {
      $postal_code = $value[0];
      $description = $value[1];

      $c_date = date("Y-m-d H:i:s");
      $created_date = strtotime($c_date);
      $u_date = date("Y-m-d H:i:s");
      $updated_date = strtotime($u_date);

      $connection = \Drupal::database();
      $result = $connection->insert('custom_postal_code')
        ->fields([
          'postal_code' => $postal_code,
          'description' => $description,
          'created_date' => $created_date,
          'updated_date' => $updated_date,
        ])
        ->execute();
    }


    \Drupal::messenger()->addMessage('imported successfully');
  }
}
