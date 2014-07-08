<?php

namespace League\Event;

interface ListenerInterface
{
    /**
     * Handle an event
     *
     * @param   AbstractEvent  $event
     * @return  void
     */
    public function handle(AbstractEvent $event);

    /**
     * Check weather the listener is the given parameter
     *
     * @param   mixed  $listener
     * @return  boolean
     */
    public function isListener($listener);
}
