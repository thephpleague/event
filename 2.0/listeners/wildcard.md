---
layout: default
title: Wildcard Listeners
---

# Wilcard Listeners

Wildcard Listeners allow you to listen to listen to ANY event.
When an event is emitted, wildcard listeners will be invoked AFTER
the normal events are.

## Registering Wildcard Listeners

~~~ php
$emitter->addListener('*', new CustomWildcardListener);
~~
