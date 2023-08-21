<?php
namespace Drupal\custom_general\Controller;

class WelcomePage{
    public function welcomePage(){
        return [
            '#markup' => 'Welcome to our website'
        ];
    }
}