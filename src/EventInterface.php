<?php

namespace League\Event;

interface EventInterface extends
    PropagationAwareInterface,
    EmitterAwareInterface,
    HasEventNameInterface
{
}
