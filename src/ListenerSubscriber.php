<?php

declare(strict_types=1);

namespace League\Event;

interface ListenerSubscriber
{
    public function subscribeListeners(ListenerAcceptor $acceptor): void;
}
