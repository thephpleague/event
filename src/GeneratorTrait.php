<?php

namespace League\Event;

trait GeneratorTrait
{
    /**
     * The registered events.
     *
     * @var object[]
     */
    protected $events = [];

    /**
     * Add an event.
     *
     * @param object $event
     *
     * @return $this
     */
    protected function addEvent($event)
    {
        $this->events[] = $event;

        return $this;
    }

    /**
     * Release all the added events.
     *
     * @return object[]
     */
    public function releaseEvents()
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}
