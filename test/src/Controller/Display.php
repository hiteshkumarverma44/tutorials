<?php

/**
 * @file
 * Contains \Drupal\test\Controller\Display.
 */

namespace Drupal\test\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Class Display.
 *
 * @package Drupal\test\Controller
 */
class Display extends ControllerBase
{

    /**
     * showdata.
     *
     * @return string
     *   Return Table format data.
     */

    // public function showheading()
    // {
    //     // you can write your own query to fetch the data I have given my example.

    //     $resultOne = \Drupal::database()->select('testconfi', 'c')
    //         ->fields('c', array('test_confi_id', 'heading', 'currentDate'))
    //         ->execute()->fetchAllAssoc('test_confi_id');
    //     // Create the row element.
    //     $rowsheading = array();
    //     foreach ($resultOne as $rowshead => $contentheading) {
    //         $rowsheading[] = array(
    //             'data' => array($contentheading->test_confi_id, $contentheading->heading, $contentheading->currentDate)
    //         );
    //     }
    //     // Create the header.
    //     $headerFirst = array('Heading', 'CurrentDate');
    //     $output1 = array(
    //         '#theme' => 'table',    // Here you can write #type also instead of #theme.
    //         '#header' => $headerFirst,
    //         '#rowsheading' => $rowsheading
    //     );
    //     return $output1;
    // }


    public function showdata()
    {





        // you can write your own query to fetch the data I have given my example.

        $result = \Drupal::database()->select('testform', 'n')
            ->fields('n', array('test_id', 'first_name', 'last_name', 'dob', 'gender', 'profile_image'))
            ->execute()->fetchAllAssoc('test_id');
        // Create the row element.
        $rows = array();
        foreach ($result as $row => $content) {
            $rows[] = array(
                'data' => array($content->test_id, $content->first_name, $content->last_name, $content->dob, $content->gender, $content->profile_image)
            );
        }
        // Create the header.
        $header = array('test_id', 'first_name', 'last_name', 'dob', 'gender', 'profile_image');
        $output = array(
            '#theme' => 'table',    // Here you can write #type also instead of #theme.
            '#header' => $header,
            '#rows' => $rows
        );
        return $output;
    }
}
