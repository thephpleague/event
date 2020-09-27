---
layout: default
title: Subscribing to Events
---

The event dispatcher follows the PSR-14 guidelines for implementation.
Events can be dispatched from an event dispatcher instance. They MUST be
objects.

```php
use League\Event\EventDispatcher;

$dispatcher = new EventDispatcher();

$dispatcher->dispatch(new AccountWasDisabled());
```

### Dispatching events with dynamic event names

[View the documentation on dispatching events with dynamic event names.](/3.0/usage/named-events/)
