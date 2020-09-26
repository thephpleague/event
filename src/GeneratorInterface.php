<?php
declare(strict_types=1);

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
