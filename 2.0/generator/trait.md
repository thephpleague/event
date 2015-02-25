---
layout: default
title: Generator Trait
---

# Generator Trait

The `GeneratorTrait` provides an implementation of the `GeneratorInterface` to accumulate events and release them at a later time.
There are two methods provided by this trait:

* public function releaseGeneratedEvents
* protected function addEvent

The `addEvent` method's visibility is protected to ensure events are only added from within,
preventing outside interference and to ensure the implementor has full control over which
events are emitted.

## Implementation Example

~~~ php
use League\Event\GeneratorTrait;
use League\Event\GeneratorInterface;

class User implements GeneratorInterface
{
    use GeneratorTrait;

    public function updateAddress(Address $address)
    {
        $this->addres = $address;
        $this->addEvent(new UserAddressWasChanged($this, $address));
    }
}

$user = new User;
$user->updateAddress(new Address(...));
~~~

## Emitting and Releasing Generated Events

Once events are generated, you'll want to release them so they can be emitted. The
`GeneratorInterface` specifies a `releaseGeneratedEvents` which returns an array
of events to be emitted.

~~~ php
$events = $user->releaseGeneratedEvents();
$emitter->emitBatch($events);

// Or the shorter version
$emitter->emitGeneratedEvents($user);
~~~


When you prefer a more expressive syntax you can alter the `addEvent` method name like so:

~~~ php
class User
{
    use GeneratorTrait {
        addEvent as recordThat;
    }

    public function updateAddress(Address $address)
    {
        $this->addres = $address;
        $this->recordThat(new UserAddressWasChanged($this, $address));
    }
}
~~~
