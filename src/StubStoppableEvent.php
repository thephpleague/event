<?php

declare(strict_types=1);

namespace League\Event;

use Psr\EventDispatcher\StoppableEventInterface;

class StubStoppableEvent implements StoppableEventInterface
{
    /**
     * @var bool
     */
    private $isStopped = false;

    public function stopPropagation(): void
    {
        $this->isStopped = true;
    }

    public function isPropagationStopped(): bool
    {
        return $this->isStopped;
    }
}
