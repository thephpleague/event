<?php

namespace League\Event;

interface GeneratorInterface
{
    /**
     * Add an event.
     *
     * @param EventInterface $event
     *
     * @return $this
     */
    public function addEvent(EventInterface $event);

    /**
     * Release all the added events.
     *
     * @return EventInterface[]
     */
    public function releaseEvents();
}
