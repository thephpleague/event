---
layout: default
permalink: /events/propagation/
title: Additional Arguments
---

# Event Propagation

In event based programming the term `event propagation` is used to describe how events flow
from A to B. When an event is emitted from the `Emitter` the event flows through the registered
listeners. Each Listener has the opportunity to handle the event and influence the event flow,
which is done by stopping the propagation.

Events flow through the listeners in order of assignment. When using the `PriorityEmitter` the order
is sorted by priority. Listeners with the same priority again are ordered by assignment.

## Stopping propagation

In order to stop event propagation the `stopPropagation` method should be called on the event instance.

~~~ php
$emitter->addListener('event.name', function ($event) {
    $event->stopPropagation();
});

$emitter->addListener('event.name', function ($event) {
    // This will not be triggered
});

$emitter->emit('event.name');
~~~

## Detecting stopped propagation

The emitter returns the emitted event, this can then be used to detect wether propagation is stopped.

~~~ php
$event = $emitter->emit('named.event');

if ($event->isPropagationStopped()) {
    // The propagation was stopped
} else {
    // All the listeners were invoked.
}
~~~
