<?php

namespace Drupal\custom_postal_code\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;

/**
 * Class Display.
 *
 * @package Drupal\custom_postal_code\Controller
 */
class Display extends ControllerBase
{

  /**
   * showdata.
   *
   * @return array|string Return Table format data.
   *   Return Table format data.
   */
  public function showdata(): array|string
  {
    //Get parameter value while submitting filter form
    $search_postal = \Drupal::request()->query->get('search_postal');
    $output['form'] = $this->formBuilder()->getForm('\Drupal\custom_postal_code\Form\custom_postal_code_search');

    $database = \Drupal::database();
    $query = $database->select('custom_postal_code', 'n');
    $query->fields('n', array('sr_no', 'postal_code', 'description', 'created_date', 'updated_date'));
    if ($search_postal != 'NULL' && !empty($search_postal)) {
      $query->condition('postal_code', $search_postal);
    }
    $pager = $query->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(9);
    $result = $pager->execute()->fetchAllAssoc('sr_no');

    $rows = [];
    foreach ($result as $data) {
      $c_timestamp = $data->created_date;
      $c_date = date("d-m-Y", $c_timestamp);
      $u_timestamp = $data->updated_date;
      $u_date = date("d-m-Y", $u_timestamp);
      $edit_link = Link::createFromRoute($this->t('Edit'), 'custom.custom_postal_code_edit', ['sr_no' => $data->sr_no], ['absolute' => TRUE]);
      $delete_link = Link::createFromRoute($this->t('Delete'), 'custom.custom_postal_code_delete', ['sr_no' => $data->sr_no], ['absolute' => TRUE]);
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
          '#attributes' => ['class' => ['action-edit']]
        ]
      ];
      $rows[] = [
        'sr_no' => $data->sr_no,
        'postal_code' => $data->postal_code,
        'description' => $data->description,
        'created_date' => $c_date,
        'updated_date' => $u_date,
        'operations' => \Drupal::service('renderer')->render($build_link_action)
      ];
    }
    $header = array('Sr no.', 'Postal code', 'Description', 'Created date', 'Updated date', 'Operation');
    $output['results_table'] = array(
      '#theme' => 'table',    // Here you can write #type also instead of #theme.
      '#header' => $header,
      '#rows' => $rows
    );
    $output[] = ['#type' => 'pager']; // Here is the pager
    return $output;
  }

  public function staticPostalDisplay()
  {

    // $a1 = array('postal 1', 'postal 2', 'postal 3', 'postal 4','postal 5');

    $postal_code = [];
    $query = \Drupal::database();
    $query = $query->select('custom_postal_code', 'n');
    $query->fields('n', array('postal_code'));
    $postal_code = $query->execute()->fetchCol();

    // echo "<pre>";
    // foreach ($postal_code as $v) {
    //   print_r($v->postal_code);
    //   // foreach ($v as $string) {
    //   //   print_r($string);
    //   // }
    // }
    // echo "</pre>";
    // echo "<pre>";
    // print_r(array_column($postal_code, 'postal_code'));
    // echo "<br>";
    // print_r($postal_code);
    // echo "</pre>";

    // exit;
    // $a = json_decode(json_encode($query), true);

    // foreach ($a as $key) {
    //   foreach ($key as $va) {
    //     $postal_code[] = $va;
    //   }
    // }

    // echo "<pre>";
    // print_r($a);
    // echo "<br>";
    // echo "<br>";
    // print_r($key);
    // echo "<br>";
    // echo "<br>";
    // print_r($va);
    // echo "<br>"; echo "<br>";
    // print_r($postal_code);

    // echo "</pre>";
    // exit;

    // $result = array_intersect($a1, $postal_code);
    // $count = count($result);
    // echo 'the postal codes are (postal 1, postal 2, postal 3, postal 4, postal 5)';


    // if($count == 0){
    //   return [
    //     '#theme' => 'my_template',
    //     '#postal_code' => 'you are not at the right place',
    //   ];
    // }
    // else{
    //   return [
    //     '#theme' => 'my_template',
    //     '#postal_code' => 'Welcome to our page',
    //   ];
    // }


    // $a = array(
    //   'one1'=> array('oneone1','two'),
    //   'one2'=> array('oneone1','two'),
    //   'one3'=> array('oneone1','two'),
    //   'one4'=> array('oneone1','two'),
    //   'one5'=> array('oneone1','two'),
    // );

    // exit;

    return [
      '#theme' => 'my_template',
      '#postal_code' => $postal_code,
    ];
  }
}
