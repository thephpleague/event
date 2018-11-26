<?php

namespace League\Event\Stub;

use League\Event\GeneratorInterface;
use League\Event\GeneratorTrait;

class DomainGenerator implements GeneratorInterface
{
    use GeneratorTrait;

    public function recordAnEvent($event)
    {
        $this->addEvent($event);
    }
}
