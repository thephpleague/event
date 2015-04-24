---
layout: default
title: Class Based Listeners
---

# Class Based Listeners

Class based listeners allow for a nicer and clean listener management. The `Emitter`
accepts listeners which implement the `ListenerInterface`. This interface require two
methods to be defined; `isListener` and `handle`. Because many listeners will have the
same implementation of `isListener` the `AbstractListener` implements this for you.

## Implementing the ListenerInterface

~~~ php
use League\Event\ListenerInterface;
use League\Event\EventInterface;

class DomainListener implements ListenerInterface
{
    public function isListener($listener)
    {
        return $listener === $this;
    }

    public function handle(EventInterface $event)
    {
        // Handle the event.
    }
}

$emitter->addListener('event.name', new DomainListener);
~~~

## Extending the AbstractListener

~~~ php
use League\Event\AbstractListener;
use League\Event\EventInterface;

class DomainListener extends AbstractListener
{
    public function handle(EventInterface $event)
    {
        // Handle the event.
    }
}
~~~
