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
$emitter->addListenet('event.name', $listener);
~~~

The listener can be of two types:

* `callable` - ([view docs](/dev-master/listeners/callables/))
* `League\Event\ListenerInterface` - ([view docs](/dev-master/listeners/class-based-listeners))

## Listener Priority

Optionally event flow can be influenced by setting a priority. Priorities are represented
as integers.

~~~ php
$emitter->addListener('event.name', $listener, 100);
~~~

The `League\Event\EmitterInterface` has 3 predefined priorities:

* `EmitterInterface::P_HIGH` - 100
* `EmitterInterface::P_NORMAL` - 0
* `EmitterInterface::P_HIGH` - -100


