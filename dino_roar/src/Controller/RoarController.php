<?php

namespace Drupal\dino_roar\Controller;

use Drupal\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\dino_roar\jurassic\RoarGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface as DependencyInjectionContainerInterface;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class RoarController extends ControllerBase{

    private $roarGenerator;

    public function __construct(RoarGenerator $roarGenerator)
    {
        $this->roarGenerator = $roarGenerator;
    }

    public static function create(DependencyInjectionContainerInterface $container)
    {
        $roarGenerator = $container->get('dino_roar.roar_generator');
        return new static($roarGenerator);
    }
    public function roar($count){

        // $roarGenerator = new RoarGenerator();
        // $roar = $roarGenerator->getRoar($count);
        $roar = $this->roarGenerator->getRoar($count);

        // $roar = 'this is roar '. str_repeat('0',$count).' roar';
        return new HttpFoundationResponse($roar);
    }
}

?>