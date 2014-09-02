<?php

namespace League\Event;

abstract class ListenerAbstract implements ListenerInterface
{
    /**
     * Check weather the listener is the given parameter.
     *
     * @param mixed $listener
     *
     * @return bool
     */
    public function isListener($listener)
    {
        return $this === $listener;
    }
}
