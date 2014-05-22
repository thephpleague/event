<?php

namespace League\Event;

interface ListenerInterface
{
    /**
     * Handle an event
     *
     * @param   EventAbstract  $event
     * @return  void
     */
    public function handle(EventAbstract $event);

    /**
     * Check weather the listener is the given parameter
     *
     * @param   mixed  $listener
     * @return  boolean
     */
    public function isListener($listener);
}
