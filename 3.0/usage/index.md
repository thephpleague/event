---
layout: default
title: Usage
---

### Step 1: Create an event dispatcher

```php
use League\Event\EventDispatcher;

$dispatcher = new EventDispatcher();
```

For more information about setting up the dispatcher, view the
[documentation about dispatcher setup](/3.0/usage/dispatcher-setup/).


### Step 2: Subscribe to an event

Listeners can subscribe to events with the dispatcher.

```php
$dispatcher->subscribe($eventIdentifier, $listener);
```

For more information about subscribing, view the
[documentation about subscribing to events](/3.0/usage/subscribing-to-events/).

### Step 3: Dispatch an event

Events can be dispatched by the dispatcher.

```php
$dispatcher->dispatch($event);
```

For more information about dispatching, view the
[documentation about dispatching events](/3.0/usage/dispatching-events/).

