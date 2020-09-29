<?php

declare(strict_types=1);

namespace League\Event;

use Psr\EventDispatcher\EventDispatcherInterface;

interface EventDispatchingListenerRegistry extends ListenerRegistry, EventDispatcherInterface
{
}
