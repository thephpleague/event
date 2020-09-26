<?php
declare(strict_types=1);

namespace League\Event;

interface EventInterface extends
    PropagationAwareInterface,
    EmitterAwareInterface,
    HasEventNameInterface
{
}
