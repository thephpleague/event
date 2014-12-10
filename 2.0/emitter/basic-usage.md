---
layout: default
title: Basic Usage
---

# Basic Usage

The `Emitter` class is the main point of interest in the Event package. This is where you
register listeners and trigger events.

## Creating the Emitter

~~~ php
use League\Event\Emitter;

$emitter = new Emitter;
~~~

## Registering Listeners

Listeners are registered through the `addListener` method.

~~~ php
$emitter->addListener('event.name', $listener);
~~~

The listener can be of two types:

* `callable` - ([view docs](/2.0/listeners/callables/))
* `League\Event\ListenerInterface` - ([view docs](/2.0/listeners/classes/))

## Listener Priority

Optionally event flow can be influenced by setting a priority. Priorities are represented
as integers.

~~~ php
$emitter->addListener('event.name', $listener, 100);
~~~

The `League\Event\EmitterInterface` has 3 predefined priorities:

* `EmitterInterface::P_HIGH`: 100
* `EmitterInterface::P_NORMAL`: 0
* `EmitterInterface::P_LOW`: -100

## Emitting events

Events are emitted using the `emit` function.

~~~ php
$event = $emitter->emit($event);
~~~

The event can be of two types:

* `string` - ([view docs](/2.0/events/named/))
* `League\Event\EventInterface` - ([view docs](/2.0/events/classes/))

### Emitting events in batches

~~~ php
$events = $emitter->emitBatch([$event, $event, $event]);
~~~

### Emit Return Values

Events emitted are returned as the result. When emitting events in batches an array
of events is returned.
