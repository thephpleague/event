---
layout: default
title: Named Events
---

# Named Events

The emitter accepts strings as events, which will be converted to a `Event` instance.

~~~ php
<?php
use League\Event\Event;

$emitter->addListener('string.event.name', function (Event $event) {
    echo $event->getName(); // echo's "string.event.name"
});

$emitter->emit('string.event.name');
// OR even better:
$emitter->emit(Event::named('string.event.name'));
~~~
