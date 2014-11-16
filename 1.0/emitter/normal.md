---
layout: default
title: Emitter (Normal)
---

# Emitter

The `Emitter` class is the main point of interest in the Event package. This is where you
register listeners and trigger events.

~~~ php
use League\Event\Emitter;

$emitter = new Emitter;
~~~

Once you've got the `Emitter` instance, you can register listeners using
[callables](/listeners/callables) or [classes](/listeners/class-based-listeners).
