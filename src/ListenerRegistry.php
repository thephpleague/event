<?php

declare(strict_types=1);

namespace League\Event;

/**
 * @method void unsubscribeFor(string $event, callable $listener)
 * @method void unsubscribeAll(callable $listener)
 * @method void unsubscribeAllFor(string $event)
 */
interface ListenerRegistry
{
    public function subscribeTo(string $event, callable $listener, int $priority = ListenerPriority::NORMAL): void;

    public function subscribeOnceTo(string $event, callable $listener, int $priority = ListenerPriority::NORMAL): void;

    public function subscribeListenersFrom(ListenerSubscriber $subscriber): void;
}
