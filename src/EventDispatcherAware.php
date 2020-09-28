<?php

declare(strict_types=1);

namespace League\Event;

interface EventDispatcherAware
{
    public function useEventDispatcher(EventDispatcher $dispatcher): void;

    public function eventDispatcher(): EventDispatcher;
}
