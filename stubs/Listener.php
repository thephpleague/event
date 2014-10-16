<?php

namespace League\Event\Stub;

use League\Event\EventInterface;
use League\Event\AbstractListener;

class Listener extends AbstractListener
{
    public function handle(EventInterface $event)
    {
        $event->stopPropagation();
    }
}
