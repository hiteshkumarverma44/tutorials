<?php

namespace Drupal\dino_roar\jurassic;

use Drupal\Core\KeyValueStore\KeyValueFactoryInterface;

class RoarGenerator
{

    /**
     * @var KeyValueFactoryInterface
     */
    private $keyValueFactory;
    private $useCache;

    public function __construct(KeyValueFactoryInterface $keyValueFactory, $useCache)
    {
        $this->keyValueFactory = $keyValueFactory;
        $this->useCache = $useCache;
    }
    public function getRoar($length)
    {

        $key = 'roar_' . $length;

        $store = $this->keyValueFactory->get('dino');

        if ($this->useCache && $store->has($key)) {
            return $store->get($key);
        }

        sleep(5);
        $string = 'this is roar ' . str_repeat('0', $length) . ' roar';

        if($this->useCache){
            $store->set($key, $string);
        }

        return $string;
    }
}
