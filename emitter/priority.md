---
layout: default
permalink: /emitter/priority/
title: Emitter (Priority)
---

# Priority Emitter

The `PriorityEmitter` class is exactly the same as the normal `Emitter` but allows you to specify
a listener's priority. When emitting events, the listeners will be sorted accordingly.

~~~ php
use League\Event\PriorityEmitter as Emitter;

$emitter = new Emitter;
$emitter->addListener('event.name', $second, Emitter::P_NORMAL);
$emitter->addListener('event.name', $third, Emitter::P_LOW);
$emitter->addListener('event.name', $first, Emitter::P_HIGH);
~~~

## Predefined priorities

* `League\Event\PriorityEmitter::P_HIGH`: (int) 100
* `League\Event\PriorityEmitter::P_NORMAL`: (int) 0
* `League\Event\PriorityEmitter::P_LOW`: (int) -100

## Custom priority values

Priorities are integers, so you can define custom priority levels or just use ints.

~~~ php
$emitter->addListener('event.name', $listener, 75);
~~~
