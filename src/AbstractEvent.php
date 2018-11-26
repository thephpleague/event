<?php

namespace League\Event;

abstract class AbstractEvent implements EventInterface
{
    use PropagationAwareBehaviour, EmitterAwareBehaviour;

    public function getName()
    {
        return get_class($this);
    }
}
