<?php

namespace League\Event;

interface GeneratorInterface
{
    /**
     * Release all the added events.
     *
     * @return object[]
     */
    public function releaseEvents();
}
