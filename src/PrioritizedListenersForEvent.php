<?php

declare(strict_types=1);

namespace League\Event;

use const SORT_ASC;
use const SORT_DESC;
use const SORT_NUMERIC;

/**
 * @internal
 */
class PrioritizedListenersForEvent
{
    /** @var array<int, iterable<callable>> */
    private $listeners = [];
    /** @var list<callable> */
    private $sortedListeners = [];
    /** @var bool */
    private $isSorted = false;
    /** @var bool */
    private $containsOneTimeListener = false;

    public function addListener(callable $listener, int $priority): void
    {
        $this->isSorted = false;
        $this->listeners[$priority][] = $listener;

        if ($listener instanceof OneTimeListener) {
            $this->containsOneTimeListener = true;
        }
    }

    public function getListeners(): iterable
    {
        if ($this->isSorted === false) {
            $this->sortListeners();
        }

        $listeners = $this->sortedListeners;

        if ($this->containsOneTimeListener) {
            $this->removeOneTimeListeners();
        }

        return $listeners;
    }

    private function sortListeners(): void
    {
        $this->isSorted = true;
        krsort($this->listeners, SORT_NUMERIC);

        foreach($this->listeners as $group) {
            foreach ($group as $listener) {
                $this->sortedListeners[] = $listener;
            }
        }
    }

    private function removeOneTimeListeners(): void
    {
        $filter = static function ($listener): bool {
            return $listener instanceof OneTimeListener === false;
        };

        $this->sortedListeners = array_filter($this->sortedListeners, $filter);

        foreach ($this->listeners as $priority => $listeners) {
            $this->listeners[$priority] = array_filter($this->sortedListeners, $filter);
        }
    }
}
