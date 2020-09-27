<?php

namespace League\Event;

use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;

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
            function (ListenerAcceptor $dispatcher) use ($listener1) {
                $dispatcher->subscribeTo('event', $listener1);
            },
            $listener1,
        ];

        yield "subscribing once" => [
            function (ListenerAcceptor $dispatcher) use ($listener2) {
                $dispatcher->subscribeOnceTo('event', $listener2);
            },
            $listener2,
        ];

        yield "subscribing from subscriber" => [
            function (ListenerAcceptor $dispatcher) use ($listener3) {
                $dispatcher->subscribeListenersFrom(
                    new class ($listener3) implements ListenerSubscriber {
                        /**  @var Listener */
                        private $listener;

                        public function __construct(Listener $listener)
                        {
                            $this->listener = $listener;
                        }

                        public function subscribeListeners(ListenerAcceptor $acceptor): void
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

        $dispatcher->dispatch(new StubNamedEvent('event'));

        $this->assertEquals(0, $listener->numberOfTimeCalled());

        $dispatcher->dispatchBufferedEvents();

        $this->assertEquals(1, $listener->numberOfTimeCalled());

        $dispatcher->dispatchBufferedEvents();

        $this->assertEquals(1, $listener->numberOfTimeCalled());
    }
}
