<?php

namespace League\Event\Stub;

use League\Event\EventInterface;
use League\Event\GeneratorInterface;
use League\Event\GeneratorTrait;

class DomainGenerator implements GeneratorInterface
{
    use GeneratorTrait;

    public function recordAnEvent(EventInterface $event)
    {
        $this->addEvent($event);
    }
} 