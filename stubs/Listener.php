<?php

namespace League\Event\Stub;

use League\Event\AbstractListener;
use League\Event\PropagationAwareInterface;

class Listener extends AbstractListener
{
    public function handle($event)
    {
        if ($event instanceof PropagationAwareInterface) {
            $event->stopPropagation();
        }
    }
}
