---
layout: default
title: Dispatcher Setup
---

# Dispatcher Setup

The `League\Event\EventDispatcher` is the primary point of interaction
with the `league/event` package.

## Create an event dispatcher

```php
use League\Event\EventDispatcher;

$dispatcher = new EventDispatcher();
```

## Supplying a `Psr\EventDispatcher\ListenerProviderInterface`

By default, the event dispatcher will create its own internal listener
registry, which implements the listener interface as defined by PSR-14.

If needed, you can supply an alternate PSR-14 implementation in the constructor. 

```php
use League\Event\EventDispatcher;

$dispatcher = new EventDispatcher($customListenerProvider);
```

## Subscribing to events

Listeners can subscribe to events with the event dispatcher directly, or be registered
with the default listener provider.

[View the documentation on subscribing to events.](/3.0/usage/subscribing-to-events/)
