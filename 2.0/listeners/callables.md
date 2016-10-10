---
layout: default
title: Callable Listeners
---

# Callable Listeners

Any argument which satisfies the `callable` type-hint is accepted.

~~~ php
<?php

$emitter->addListener('event.name', function ($event) {
   // Handle the event.
});
// Or better:
$emitter->addListener('event.name', CallbackListener::fromCallable(function () {
    // Handle the event.
}));
~~~
