---
layout: default
title: Dynamic Event Names
---

In some cases, having an event class for every type of event is not needed.
For those cases, a generic event can be introduced that implement
the `League\Event\HasEventName` interface.

```php
class SomethingHappened implements League\Event\HasEventName
{
    /** @var string */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function eventName(): string
    {
        return $this->name;
    }
}

$dispatcher->subscribeTo('this.happened', $listener);
$dispatcher->dispatch(new SomethingHappened('this.happened'));
```
