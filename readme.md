# League\Event

[![Author](http://img.shields.io/badge/author-@frankdejonge-blue.svg?style=flat-square)](https://twitter.com/frankdejonge)
[![Build Status](https://img.shields.io/travis/thephpleague/event/master.svg?style=flat-square)](https://travis-ci.org/thephpleague/event)
[![Quality Score](https://img.shields.io/scrutinizer/g/thephpleague/event.svg?style=flat-square)](https://scrutinizer-ci.com/g/thephpleague/event)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Packagist Version](https://img.shields.io/packagist/v/league/event.svg?style=flat-square)](https://packagist.org/packages/league/event)
[![Total Downloads](https://img.shields.io/packagist/dt/league/event.svg?style=flat-square)](https://packagist.org/packages/league/event)
<!-- [![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/thephpleague/event.svg?style=flat-square)](https://scrutinizer-ci.com/g/thephpleague/event/code-structure) -->
# Usage (Basic)

Register a listener for an event.

```php
use League\Event\Emitter;

$emitter = new Emitter;
$emitter->addListener('event.name', function ($event) {
    echo "I've listened to " . $event->getName();
});

$emitter->emit('event.name');
```

Remove a listener.

```php
$emitter->removeListener('event.name', $listener);
// or remove all listeners
$emitter->removeAllListeners('event.name');
```

# Usage (Advanced)

You can create custom event types by extending the `AbstractEvent` class.

```php
use League\Event\AbstractEvent;

class DomainEvent extends AbstractEvent
{
    public function getName()
    {
        return 'event.name';
    }

    // ... add business logic here
}

$emitter->emit(new DomainEvent);
```

You can create custom listeners.

```php
use League\Event\AbstractEvent;
use League\Event\AbstractListener;

class DomainListener extends AbstractListener
{
    public function handle(AbstractEvent $event)
    {
        // Handle the event.
    }
}
```

You can stop event propagation.

```php
$emitter->addListener('event', function ($event) {
    $event->stopPropagation();
});
$emitter->addListener('event', function ($event) {
    // This will never be called!
});

$emitter->emit('event');
```


You can prioritize listeners by using the `PriorityEmitter`.

```php
$emitter = new League\Event\PriorityEmitter;
$emitter->addListener('event', $second, 10); // This will be handled
$emitter->addListener('event', $first, 50); // after this is handled.
$emittedEvent = $emitter->emit('event');
```

## Passing additional parameters to event listeners

When emitting an event, all trailing arguments will be forwarded to the listeners. Due to how php's interfaces work a default value must be supplied when present in the `handle` method signature to ensure method signature compatibility.

### Using a closure

```php
$emitter->on('event', function ($event, $param = null) {
	var_dump(func_get_args());
});

$emitter->emit('event', 'param value');
```

### Using a class

```php
class Listener extends AbstractListener
{
	public function handle(AbstractEvent $event, $param = null)
	{
		var_dump(func_get_args());
	}
}

$emitter->on('event', new Listener);
$emitter->emit('event', 'param value');
```
