---
layout: default
permalink: /events/string-events/
title: String Events
---

# String Events

The emitter accepts strings as events, which will be converted to a `Event` instance.

~~~ php
$emitter->addListener('string.event.name', function ($event) {
    echo $event->getName(); // echo's "string.event.name"
});

$emitter->emit('string.event.name');
~~~
