<?php

declare(strict_types=1);

namespace League\Event;

/**
 * @internal
 */
class OneTimeListener implements Listener
{
    /**
     * @var callable
     */
    protected $listener;

    public function __construct(callable $listener)
    {
        $this->listener = $listener;
    }

    /**
     * @inheritdoc
     */
    public function __invoke(object $event): void
    {
        call_user_func($this->listener, $event);
    }
}
