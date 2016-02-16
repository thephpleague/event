<?php

namespace League\Event;

interface ListenerInterface
{
    /**
     * Handle an event.
     *
     * @param EventInterface $event
     * @param mixed $param
     *
     * @return void
     */
    public function handle(EventInterface $event, $param = null);

    /**
     * Check whether the listener is the given parameter.
     *
     * @param mixed $listener
     *
     * @return bool
     */
    public function isListener($listener);
}
