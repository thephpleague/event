<?php

declare(strict_types=1);

namespace League\Event;

interface ListenerAcceptor
{
    /**
     * High priority.
     *
     * @const int
     */
    public const P_HIGH = 100;

    /**
     * Normal priority.
     *
     * @const int
     */
    public const P_NORMAL = 0;

    /**
     * Low priority.
     *
     * @const int
     */
    public const P_LOW = -100;

    public function subscribe(string $event, callable $listener, int $priority = self::P_NORMAL): void;

    public function subscribeOnce(string $event, callable $listener, int $priority = self::P_NORMAL): void;

    public function subscribeFrom(ListenerSubscriber $subscriber): void;
}
