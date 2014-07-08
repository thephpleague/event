<?php

namespace League\Event;


trait GeneratorTrait
{
    protected $events = [];

    /**
     * Add an event
     *
     * @param AbstractEvent $event
     * @return self
     */
    public function addEvent(AbstractEvent $event)
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