<?php

declare(strict_types=1);

namespace League\Event;

class StubMutableEvent
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function append(string $value): void
    {
        $this->value .= $value;
    }
}
