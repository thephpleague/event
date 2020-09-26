<?php
declare(strict_types=1);

namespace League\Event;

abstract class AbstractEvent implements EventInterface
{
    use PropagationAwareBehaviour, EmitterAwareBehaviour;

    public function getName()
    {
        return get_class($this);
    }
}
