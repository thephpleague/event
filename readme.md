# League\Event



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

You can create custom event types by extending the `EventAbstract` class.

```php
use League\Event\EventAbstract;

class DomainEvent extends EventAbstract
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
use League\Event\EventAbstract;
use League\Event\ListenerAbstract;

class DomainListener extends ListenerAbstract
{
    public function handle(EventAbstract $event)
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
$emitter->emit('event');
```

## Return values

When an event is emitted the return value has two options:

* `false`<br/> When there were nog listeners
* `EventAbstract`<br/> The event instance which was handled by the listeners


