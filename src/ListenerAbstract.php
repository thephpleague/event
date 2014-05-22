<?php

namespace League\Event;

abstract class ListenerAbstract implements ListenerInterface
{
    /**
     * {inheritdoc}
     */
    public function isListener($listener)
    {
        return $this === $listener;
    }
}
