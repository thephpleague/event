<?php

namespace League\Event\Stub;

use League\Event\AbstractListener;
use League\Event\EventInterface;

class Listener extends AbstractListener
{
    public function handle(EventInterface $event)
    {
        $event->stopPropagation();
    }
}
