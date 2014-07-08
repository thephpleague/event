<?php

namespace League\Event;

class Event extends AbstractEvent
{
    /**
     * @var  string  $name
     */
    protected $name;

    /**
     * Constructor
     *
     * @param  string  $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get the event name
     *
     * @return  string  name
     */
    public function getName()
    {
        return $this->name;
    }
}
