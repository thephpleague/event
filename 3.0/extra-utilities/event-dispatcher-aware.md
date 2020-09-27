---
layout: default
title: Event Dispatcher Aware
---

To reduce boilerplate code, an interface and trait are shipped to
quickly allow code that depends on an event dispatcher to use it.

```php
class DependantOnEventDispatcher implements League\Event\EventDispatcherAware{
    use League\Event\EventDispatcherAwareBehavior;
}

$instance = new DependantOnEventDispatcher();

// retrieve an event dispatcher
$eventDispatcher = $instance->eventDispatcher();

// you can also instruct which instance of an event dispatcher to use
$instance->useEventDispatcher($eventDispatcher);
```
