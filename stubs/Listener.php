<?php

namespace League\Event\Stub;

use League\Event\AbstractEvent;
use League\Event\ListenerAbstract;

class Listener extends ListenerAbstract
{
    public function handle(AbstractEvent $event)
    {
        $event->stopPropagation();
    }
}
