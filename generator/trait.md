---
layout: default
permalink: /generator/trait/
title: Generator Trait
---

# Generator Trait

The `GeneratorTrait` provides an interface to record events and release them at a later time.

## Implementation Example

~~~ php
use League\Event\Generator;

class User
{
    use Generator;

    public function updateAddress(Address $address)
    {
        $this->addres = $address;
        $this->addEvent(new UserAddressWasChanged($this, $address));
    }
}

$user = new User;
$user->updateAddress(new Addres(...));
$events = $user->releaseEvents();
$emitter->emitBatch($events);
~~~

When you prefer a more expressive syntax you can alter the `addEvent` method name like so:

~~~ php
class User
{
    use Generator {
        addEvent as recordThat;
    }

    public function updateAddress(Address $address)
    {
        $this->addres = $address;
        $this->recordThat(new UserAddressWasChanged($this, $address));
    }
}
~~~
