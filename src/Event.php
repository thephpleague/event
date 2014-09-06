<?php

namespace League\Event;

class Event extends AbstractEvent
{
    /**
     * The event name.
     *
     * @var string
     */
    protected $name;

    /**
     * Create a new event instance.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get the event name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
