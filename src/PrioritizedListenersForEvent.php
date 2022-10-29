<?php

declare(strict_types=1);

namespace League\Event;

use const SORT_NUMERIC;

/**
 * @internal
 */
class PrioritizedListenersForEvent
{
    /** @var array<int, array<int,callable>> */
    private $listeners = [];
    /** @var array<int,callable>|null */
    private $sortedListeners;

    public function addListener(callable $listener, int $priority): void
    {
        $this->sortedListeners = null;
        $this->listeners[$priority][] = $listener;
    }

    public function getListeners(): iterable
    {
        return $this->sortedListeners ?? $this->sortListeners();
    }

    private function sortListeners(): array
    {
        $filter = static function ($listener): bool {
            return $listener instanceof OneTimeListener === false;
        };
        krsort($this->listeners, SORT_NUMERIC);
        $listeners = [];
        foreach ($this->listeners as $priority => $group) {
            foreach ($group as $listener) {
                $listeners[] = $listener;
            }
            $this->listeners[$priority] = array_filter($group, $filter);
        }
        $this->sortedListeners = array_filter($listeners, $filter);

        return $listeners;
    }
}
