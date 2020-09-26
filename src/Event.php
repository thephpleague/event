<?php
declare(strict_types=1);

namespace League\Event;

class Event extends AbstractEvent
{
    /**
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

    public function getName()
    {
        return $this->name;
    }

    /**
     * Create a new event instance.
     *
     * @param string $name
     *
     * @return static
     */
    public static function named($name)
    {
        return new static($name);
    }
}
