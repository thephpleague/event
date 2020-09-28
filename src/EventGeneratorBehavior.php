<?php

declare(strict_types=1);

namespace League\Event;

trait EventGeneratorBehavior
{
    /**
     * @var object[]
     */
    protected $events = [];

    /**
     * @return $this
     */
    protected function recordEvent(object $event): self
    {
        $this->events[] = $event;

        return $this;
    }

    /**
     * @return object[]
     */
    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}
