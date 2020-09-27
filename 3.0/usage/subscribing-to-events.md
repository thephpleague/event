---
layout: default
title: Subscribing to Events
---

# Subscribing to Events

The `League\Event\ListenerAcceptor` (interface) allows you to subscribe to
events. There are two implementations of this interface:

1. `League\Event\EventDispatcher`
2. `League\Event\PrioritizedListenerCollection`

This means you can subscribe to events with the event dispatcher directly, or
subscribe to the internal listener collection:

```php
use League\Event\EventDispatcher;
use League\Event\PrioritizedListenerCollection;

$listenerProvider = new PrioritizedListenerCollection();
$dispatcher = new EventDispatcher($listenerProvider);

// Subscribe with the dispatcher
$listenerProvider->subscribeTo($eventIdentifier, $listener);

// Subscribe with the listener provider
$listenerProvider->subscribeTo($eventIdentifier, $listener);
```

## Subscribing parameters

The `$eventIdentifier` parameter is a `string`. The default (and advised) way of
subscribing, is to subscribe to a fully qualified class name of an event class name.

```php

class SomethingHappened {
    // properties (and getters)
}

$dispatcher->subscribeTo(SomethingHappened::class, $listener);
```

The `$listener` parameter is a `callable` value. For convenience, a 
`League\Event\Listener` interface is provided. This interface ensures 
that whatever the listener accepts is an expected event object.

Provide a callable:

```php
$dispatcher->subscribeTo($eventIdentifier, function(object $event) {
    
});
```

Or, provide a listener instance:

```php
class MyListener implements League\Event\Listener {
    public function __invoke(object|SomethingHappened $event): void
    {
        // handle event
    }
}

$dispatcher->subscribeTo($eventIdentfier, new MyListener());
```

## Prioritizing listeners

When subscribing to events, you influence the caller order by setting
the priority of the subscription.

```php
use League\Event\ListenerAcceptor;

$dispatcher->subscribeTo($eventIdentifier, $listener, $priority);
```

The `$priority` parameter is an `int`. The higher the value, the earlier
it will be called.

```php
use League\Event\ListenerAcceptor;

// Lowest priority is called last
$dispatcher->subscribeTo($eventIdentifier, $lastListener, -100);

// Same priority? Subscribe order is maintained
$dispatcher->subscribeTo($eventIdentifier, $secondListener, 10);
$dispatcher->subscribeTo($eventIdentifier, $thirdListener, 10);

// Highest priority is called first
$dispatcher->subscribeTo($eventIdentifier, $firstListener, PHP_INT_MAX);
```

The ListenerPriority class exposes a couple predefined priorities.

```php
use League\Event\ListenerPriority;

$dispatcher->subscribeTo($eventIdentifier, $listener, ListenerPriority::HIGH);
$dispatcher->subscribeTo($eventIdentifier, $listener, ListenerPriority::NORMAL);
$dispatcher->subscribeTo($eventIdentifier, $listener, ListenerPriority::LOW);
```


## Custom PSR-14 listener provider

Unless your custom listener provider also implements the `League\Event\ListenerAcceptor`
interface, adding new event subscriptions through the event dispatcher will not work.

When you try to subscribe to an event with an incompatible provider, the
`League\Event\UnableToSubscribeListener` exception will be thrown.

## Dispatching events

Next up is event dispatching. View the [documentation about dispatching events](/3.0/usage/dispatching-events/)
