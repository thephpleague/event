<?php

declare(strict_types=1);

namespace League\Event;

interface HasEventName
{
    public function eventName(): string;
}
