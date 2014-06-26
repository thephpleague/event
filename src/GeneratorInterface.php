<?php

namespace League\Event;

interface GeneratorInterface
{
    /**
     * Add an event
     *
     * @param EventAbstract $event
     * @return self
     */
    public function addEvent(EventAbstract $event);

    /**
     * Release all the added events.
     *
     * @return array
     */
    public function releaseEvents();
}