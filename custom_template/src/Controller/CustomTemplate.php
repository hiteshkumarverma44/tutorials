<?php

namespace Drupal\custom_template\Controller;

use Drupal\Core\Controller\ControllerBase;

class CustomTemplate extends ControllerBase{
    public function customTemplate(){
        return
           [ '#theme' =>'custom_template',
            '#text' => 'welcome to our D4drupal channel',
        ];

}
}

?>