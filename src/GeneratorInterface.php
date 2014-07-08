<?php

namespace League\Event;

interface GeneratorInterface
{
    /**
     * Add an event
     *
     * @param AbstractEvent $event
     * @return self
     */
    public function addEvent(AbstractEvent $event);

    /**
     * Release all the added events.
     *
     * @return array
     */
    public function releaseEvents();
}