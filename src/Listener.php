<?php

declare(strict_types=1);

namespace League\Event;

interface Listener
{
    public function __invoke(object $event): void;
}
