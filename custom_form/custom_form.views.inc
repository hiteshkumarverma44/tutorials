<?php


/**
 * Implements hook_views_data().
 */



function custom_form_views_data()
{


    $data['custom_form']['table']['group'] = t('Custom Contact Form');
    $data['custom_form']['table']['base'] = [

        'title' => t('Custom Contact Form'),
        'id' => 1
    ];

    //fields
    $data['custom_form']['first_name'] = [
        'title' => t('First Name'),
        'help' => t('This is first name field'),
        'field' => [
            'id' => 'standard',
        ],

    ];
    $data['custom_form']['last_name'] = [
        'title' => t('Last Name'),
        'help' => t('this is our last name field'),
        'field' => [
            'id' => 'standard',
        ]
    ];
    $data['custom_form']['email'] = [
        'title' => t('email'),
        'help' => t('this is our email field'),
        'field' => [
            'id' => 'standard',
        ]
    ];
    $data['custom_form']['contact_number'] = [
        'title' => t('contact number'),
        'help' => t('this is our contact number field'),
        'field' => [
            'id' => 'standard',
        ]
    ];

    $data['custom_form']['newcol'] = [
        'title' => t('newcol'),
        'help' => t('this is our checkterm option field'),
        'field' => [
            'id' => 'standard',
        ]
    ];
    $data['custom_form']['terms_condition'] = [
        'title' => t('terms_condition'),
        'help' => t('this is our terms_condition field'),
        'field' => [
            'id' => 'standard',
        ]
    ];

    return $data;
}


// function custom_form_views_data_alter(){
//     $data2['custom_form']['table']['group'] = t('Custom Contact Form');
//     $data2['custom_form']['table']['base'] = [

//     ];

//     $data2(unserialize(['custom_form']['newcol']));
//         return $data2;
// }