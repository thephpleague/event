---
layout: default
title: Upgrading from V2 to V3
---

# Upgrading from V2 to V3

Releasing a major version also allows for concepts to be refined,
this major version takes full advantage of that opportunity.

## Many renames...

Many things are renamed in this new version. This was largely caused
by the terminology clashes with PSR-14. A new group of names, that
didn't conflict with PSR-14 was needed. The new names needed to make
sense in relation to PSR-14, as well as in the extended functionality
that the package provides.

There are now a conceptually cohesive names for class names and method
names, which make sense.

## Events are `object`s

For parity with PSR-14, the EventInterface has been removed. Any valid
`object` can now be used to dispatch an event.

For events that supply their own event name, the `League\Event\HasEventName`
interface is introduced that allows you to specify the event name by
implementing the `eventName` method.

Because of this all, the abstract event was subsequently removed. Additionally,
the `League\Event\Event` class was removed.

Instead of this class, you're encouraged to introduce your own event type if
you require named events. For example:

```php
use League\Event\HasEventName;

class DomainEvent implements HasEventName
{
    private string $eventName;
    private function __construct(string $eventName)
    {
        $this->eventName = $eventName;
    }

    public function eventName(): string
    {
        return $this->eventName;
    }

    public static function named(string $name): DomainEvent
    {
        return new DomainEvent($name);
    }
}
```

## PSR-14 support

Due to slashes in terminology, the names of classes and methods have
been adjusted from V2 to V3. Most notably, the Emitter class
is now called the EventDispatcher class. This was due to the Emitter,
in PSR-14 terminology, being the code that uses a dispatcher to dispatch
events. Because of this, all the terminology needed to be adjusted.

### Callable listeners

PSR-14 defines listeners as any callable. The listener interface

### Event propagation

For event propagation control, the `Psr\EventDispatcher\StoppableEventInterface`
can be implemented.

## Buffered event dispatcher is now a decorator

```diff
- $emitter = new League\Event\BufferedEmitter();
+ $dispatcher = new League\Event\BufferedEventDispatcher($internalDispatcher);

// with terminology rename
- $emitEvents = $emitter->emitBufferedEvents();
+ $dispatchedEvents = $dispatcher->dispatchBufferedEvents();
```

## Other renames

Here is an overview of all the other renames:

```diff
// The emitter is now an event dispatcher
- $emitter = new League\Event\Emitter();
+ $dispatcher = new League\Event\EventDispatcher();

// The emit function is now called dispatch
- $emitter->emit($event);
+ $dispatcher->dispatch($event);

// Listener interface looses interface suffix
- use League\Event\ListenerInterface;
+ use League\Event\Listener;

// Event generator is now called EventGenerator
- use League\Event\GeneratorInterface;
+ use League\Event\EventGenerator;

// Event generator is now called EventGenerator
- use League\Event\GeneratorInterface;
+ use League\Event\EventGenerator;

// Adding a listerner is now "subscribing"
- $dispatcher->addListener($eventIdentifier, $listener);
+ $dispatcher->subscribeTo($eventIdentifier, $listener);

- $dispatcher->addOneTimeListener($eventIdentifier, $listener);
+ $dispatcher->subscribeOneTo($eventIdentifier, $listener);

// ListenerProviderInterface is now ListenerSubscriber
- use League\Event\ListenerProviderInterface;
+ use League\Event\ListenerSubscriber;

// supplying the listeners via a subscriber:
- $dispatcher->useListenerProvider($subscriber);
+ $dispatcher->subscribeListenersFrom($subscriber);

// ListenerAcceptorInterface is now ListenerRegistry
- use League\Event\ListenerAcceptorInterface;
+ use League\Event\ListenerRegistry;
```
