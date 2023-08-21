<?php

namespace Drupal\dino_roar\jurassic;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class DinoListener implements EventSubscriberInterface
{

    public function onKernalRequest($event){
        echo "<pre>";
        var_dump($event);
        echo "</pre>";
        die;

    }
    public static function getSubscribedEvents()
    {
        return[
            KernelEvents::REQUEST => 'onKernalRequest',
        ];
    }
}
