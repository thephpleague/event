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
$emitter = new Emitter;


```
