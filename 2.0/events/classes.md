---
layout: default
title: Class Based Events
---

# Class Based Events

The emitter accepts implementations of the `EventInterface` interface.

~~~ php
use League\Event\AbstractEvent;

class DomainEvent implements EventInterface
{
    public function getName()
    {
        return 'DomainEvent';
    }
    // Add domain methods here
}

$emitter->addListener('DomainEvent', function ($event) {
    echo $event->getName(); // echo's "DomainEvent"
});

$emitter->emit(new DomainEvent);
~~~

## AbstractEvent

The package also provides an abstract class which provides a defauls `getName`
implementation returning the FQCN.
