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
     * Create a new instance.
     *
     * @param string $name
     *
     * @return void
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
