<?php

declare(strict_types=1);

namespace League\Event;

use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use stdClass;

class BufferedEventDispatcherTest extends TestCase
{
    /**
     * @test
     * @dataProvider dpScenariosWhereSubscribingIsTried
     */
    public function subscribing_does_not_work_when_the_underlying_dispatcher_does_not_allow_subscribing(
        callable $scenario
    ): void {
        $internalDispatcher = new class() implements EventDispatcherInterface {
            public function dispatch(object $event): object
            {
                return $event;
            }
        };
        $dispatcher = new BufferedEventDispatcher($internalDispatcher);

        $this->expectExceptionObject(
            UnableToSubscribeListener::becauseTheEventDispatcherDoesNotAcceptListeners($internalDispatcher)
        );

        $scenario($dispatcher);
    }

    public function dpScenariosWhereSubscribingIsTried(): iterable
    {
        $listener1 = new ListenerSpy();
        $listener2 = new ListenerSpy();
        $listener3 = new ListenerSpy();

        yield "subscribing" => [
            function (ListenerRegistry $dispatcher) use ($listener1) {
                $dispatcher->subscribeTo('event', $listener1);
            },
            $listener1,
        ];

        yield "subscribing once" => [
            function (ListenerRegistry $dispatcher) use ($listener2) {
                $dispatcher->subscribeOnceTo('event', $listener2);
            },
            $listener2,
        ];

        yield "subscribing from subscriber" => [
            function (ListenerRegistry $dispatcher) use ($listener3) {
                $dispatcher->subscribeListenersFrom(
                    new class($listener3) implements ListenerSubscriber {
                        /**  @var Listener */
                        private $listener;

                        public function __construct(Listener $listener)
                        {
                            $this->listener = $listener;
                        }

                        public function subscribeListeners(ListenerRegistry $acceptor): void
                        {
                            $acceptor->subscribeTo('event', $this->listener);
                        }
                    }
                );
            },
            $listener3,
        ];
    }

    /**
     * @test
     * @dataProvider dpScenariosWhereSubscribingIsTried
     */
    public function subscribing_with_the_dispatcher(callable $scenario, ListenerSpy $listener): void
    {
        $dispatcher = new BufferedEventDispatcher(new EventDispatcher());

        $scenario($dispatcher);
        $dispatcher->dispatch($event = new StubNamedEvent('event'));

        // Assert dispatching is not done yet
        $this->assertEquals(0, $listener->numberOfTimeCalled());

        // Triggering a dispatch
        $dispatcher->dispatchBufferedEvents();

        $this->assertEquals(1, $listener->numberOfTimeCalled());

        $dispatcher->dispatchBufferedEvents();

        $this->assertEquals(1, $listener->numberOfTimeCalled());
    }

    /**
     * @test
     */
    public function dispatching_buffered_events_returns_the_events_in_the_order_of_dispatching(): void
    {
        $dispatcher = new BufferedEventDispatcher(new EventDispatcher());
        $dispatcher->dispatch($first = new stdClass());
        $dispatcher->dispatch($second = new stdClass());
        $dispatcher->dispatch($third = new stdClass());

        $dispatchedEvents = $dispatcher->dispatchBufferedEvents();

        $this->assertIsArray($dispatchedEvents);
        $this->assertCount(3, $dispatchedEvents);
        $this->assertContainsOnlyInstancesOf(stdClass::class, $dispatchedEvents);
        $this->assertSame($first, $dispatchedEvents[0]);
        $this->assertSame($second, $dispatchedEvents[1]);
        $this->assertSame($third, $dispatchedEvents[2]);
    }
}
