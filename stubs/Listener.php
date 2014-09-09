<?php

namespace League\Event\Stub;

use League\Event\AbstractEvent;
use League\Event\AbstractListener;

class Listener extends AbstractListener
{
    public function handle(AbstractEvent $event)
    {
        $event->stopPropagation();
    }
}
