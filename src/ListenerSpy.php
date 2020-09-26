<?php

declare(strict_types=1);

namespace League\Event;

class ListenerSpy implements Listener
{
    /**
     * @var object|null
     */
    private $calledWith = null;

    /**
     * @var int
     */
    private $timesCalled = 0;

    public function __invoke(object $event): void
    {
        $this->timesCalled += 1;
        $this->calledWith = $event;
    }

    public function numberOfTimeCalled(): int
    {
        return $this->timesCalled;
    }

    public function wasCalledWith(object $event): bool
    {
        return $event === $this->calledWith;
    }
}
