---
layout: default
title: Listener Subscriber
---

# Listener Subscriber

Listener subscribers are a convenient way to subscribe multiple listeners
at once. They allow you to group the registration by concern to help
keep your code organized.

```php
class MyListenerSubscriber implements League\Event\ListenerSubscriber
{
    public function subscribeListeners(ListenerRegistry $listenerRegistry): void
    {
        $listenerRegistry->subscribeTo(SomethingHappened::class, new DoThisWhenSomethingHappened());
        $listenerRegistry->subscribeTo(SomethingElseHappened::class, new OrThisWhenSomethingElseHappened());
    }
}

$dispatcher->subscribeListenersFrom(new MyListenerSubscriber());
```
