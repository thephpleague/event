<?php

namespace League\Event;

interface GeneratorInterface
{
    /**
     * Add an event.
     *
     * @param AbstractEvent $event
     *
     * @return $this
     */
    public function addEvent(AbstractEvent $event);

    /**
     * Release all the added events.
     *
     * @return AbstractEvent[]
     */
    public function releaseEvents();
}
