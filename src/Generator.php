<?php

namespace League\Event;

class Generator implements GeneratorInterface
{
    use GeneratorTrait;

    /**
     * {@inheritdoc}
     */
    public function addEvent(EventInterface $event)
    {
        $this->events[] = $event;

        return $this;
    }
}
