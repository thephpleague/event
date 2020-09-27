---
layout: default
title: Event Generator
---

# Event Generator

In some styles of programming, events are collected before they are dispatched in one go.
The `League\Event\EventGenerator` interface is designed, so you can do just that. Along-side
the interface, is a trait to that satisfies the requirements.

```php
class SomethingThatGeneratesEvents implements League\Event\EventGenerator {
    use League\Event\EventGeneratorBehavior;

    public function doSomething(): void
    {
        $this->recordEvent(new SomethingHappened());
        $this->recordEvent(new SomethingElseHappened());
    }
}
```

You can now interact with the model, after which you can dispatch the recorded events.

```
$something = new SomethingThatGeneratesEvents();
$something->doSomething();

$dispatcher->dispatchGeneratedEvents($something);
```
