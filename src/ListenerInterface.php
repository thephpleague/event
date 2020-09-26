<?php
declare(strict_types=1);

namespace League\Event;

interface ListenerInterface
{
    /**
     * Handle an event.
     *
     * @param object $event
     *
     * @return void
     */
    public function handle($event);

    /**
     * Check whether the listener is the given parameter.
     *
     * @param mixed $listener
     *
     * @return bool
     */
    public function isListener($listener);
}
