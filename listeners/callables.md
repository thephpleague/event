---
layout: default
permalink: /listeners/callables/
title: Callable Listeners
---

# Callable Listeners

Any argument which satisfies the `callable` type-hint is accepted.

~~~ php
$emitter->addListener('event.name', function ($event) {
   // Handle the event.
});
~~~
