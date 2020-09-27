<?php

namespace League\Event;

interface ListenerAcceptor
{
    public function subscribeTo(string $event, callable $listener, int $priority = ListenerPriority::NORMAL): void;

    public function subscribeOnceTo(string $event, callable $listener, int $priority = ListenerPriority::NORMAL): void;

    public function subscribeListenersFrom(ListenerSubscriber $subscriber): void;
}
