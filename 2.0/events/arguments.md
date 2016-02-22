---
layout: default
title: Additional Arguments
---

# Additional Arguments

When emitting events, either string or class based, you can supply additional arguments.

~~~ php
$emitter->addListener('event.name', function ($event, $param) {

});

$emitter->emit('event.name', 'param value');
~~~

When using class based listeners, the method signature must comply with the interface.
Therefor the parameters must have default values.

~~~ php
use League\Event\AbstractEvent;
use League\Event\AbstractListener;

class DomainListener extends AbstractListener
{
    public function handle(AbstractEvent $event, $param = null)
    {
        // Handle the event
    }
}

$emitter->addListener('event.name', new DomainListener);
$emitter->emit('event.name', 'param value');
~~~
