---
layout: default
title: Buffered Event Dispatcher
---

# Buffered Event Dispatcher

The buffered event dispatcher allows you to stage your events before
committing to publishing them. The buffered event dispatcher decorates
a `Psr\EventDispatching\EventDisparcherInterface` instance.

```php
use League\Event\BufferedEventDispatcher;
use League\Event\EventDispatcher;

$internalDispatcher = new EventDispatcher();
$internalDispatcher->subscribeTo(stdClass::class, fn () => echo "Hello!");

$dispatcher = new BufferedEventDispatcher($internalDispatcher);

$dispatcher->dispatch(new stdClass()); // no listener is called;
$dispatcher->dispatch(new stdClass()); // no listener is called;

$dispatcher->dispatchBufferedEvents(); // listener is called twice
```
