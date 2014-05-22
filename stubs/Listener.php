<?php

namespace League\Event\Stub;

use League\Event\EventAbstract;
use League\Event\ListenerAbstract;

class Listener extends ListenerAbstract
{
    public function handle(EventAbstract $event)
    {
        $event->stopPropagation();
    }
}
