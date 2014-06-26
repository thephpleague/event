<?php

namespace League\Event;


trait GeneratorTrait
{
    protected $events = [];

    /**
     * Add an event
     *
     * @param EventAbstract $event
     * @return self
     */
    public function addEvent(EventAbstract $event)
    {
        $this->events[] = $event;

        return $this;
    }

    /**
     * Release all the added events.
     *
     * @return array
     */
    public function releaseEvents()
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
} 