---
layout: default
permalink: /events/class-based-events/
title: Class Based Events
---

# Class Based Events

The emitter accepts extensions of the `AbstractEvent` class as events.

~~~ php
use League\Event\AbstractEvent;

class DomainEvent extends AbstractEvent
{
    // Add domain methods here
}

$emitter->addListener('DomainEvent', function ($event) {
    echo $event->getName(); // echo's "DomainEvent"
});

$emitter->emit(new DomainEvent);
~~~
