<?php

declare(strict_types=1);

namespace League\Event;

class StubNamedEvent implements HasEventName
{
    /**
     * @var string
     */
    private $eventName;

    public function __construct(string $eventName)
    {
        $this->eventName = $eventName;
    }

    public function eventName(): string
    {
        return $this->eventName;
    }
}
