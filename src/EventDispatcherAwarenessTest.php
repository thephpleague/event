<?php

declare(strict_types=1);

namespace League\Event;

use PHPUnit\Framework\TestCase;

class EventDispatcherAwarenessTest extends TestCase
{
    /**
     * @test
     */
    public function using_a_event_dispatcher(): void
    {
        $instance = $this->eventDispatcherAwareInstance();
        $dispatcher = new EventDispatcher();
        $instance->useEventDispatcher($dispatcher);

        $this->assertSame($dispatcher, $instance->eventDispatcher());
    }

    /**
     * @test
     */
    public function when_no_dispatcher_is_provided_a_dispatcher_is_created(): void
    {
        $instance = $this->eventDispatcherAwareInstance();

        $eventDispatcher = $instance->eventDispatcher();
        $this->assertInstanceOf(EventDispatcher::class, $eventDispatcher);
        $this->assertSame($eventDispatcher, $instance->eventDispatcher());
    }

    private function eventDispatcherAwareInstance(): EventDispatcherAware
    {
        return new class() implements EventDispatcherAware {
            use EventDispatcherAwareTrait;
        };
    }
}
