<?php

declare(strict_types=1);

namespace League\Event;

use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\ListenerProviderInterface;
use stdClass;

class EventDispatcherTest extends TestCase
{
    /**
     * @test
     */
    public function listening_to_a_plain_object_event(): void
    {
        $dispatcher = new EventDispatcher();
        $listenerSpy = new ListenerSpy();
        $event = new stdClass;

        $dispatcher->subscribeTo(stdClass::class, $listenerSpy);
        $dispatcher->dispatch($event);

        $this->assertTrue($listenerSpy->wasCalledWith($event));
    }

    /**
     * @test
     */
    public function dispatching_returns_the_event_object(): void
    {
        $event = new stdClass();
        $dispatcher = new  EventDispatcher();

        $returnedEvent = $dispatcher->dispatch($event);

        $this->assertSame($event, $returnedEvent);
    }

    /**
     * @test
     */
    public function listening_to_a_named_event(): void
    {
        $dispatcher = new EventDispatcher();
        $listenerSpy = new ListenerSpy();
        $event = new StubNamedEvent('event.name');

        $dispatcher->subscribeTo('event.name', $listenerSpy);
        $dispatcher->dispatch($event);

        $this->assertTrue($listenerSpy->wasCalledWith($event));
    }

    /**
     * @test
     */
    public function listening_to_a_named_event_ignores_other_names(): void
    {
        $dispatcher = new EventDispatcher();
        $listenerSpy = new ListenerSpy();
        $dispatcher->subscribeTo('event.name', $listenerSpy);
        $dispatcher->dispatch(new StubNamedEvent('event.name'));
        $dispatcher->dispatch(new StubNamedEvent('other.event.name'));

        $this->assertEquals(1, $listenerSpy->numberOfTimeCalled());
    }

    /**
     * @test
     */
    public function it_uses_a_provided_listener_provider(): void
    {
        $listenerSpy = new ListenerSpy();
        $provider = new PrioritizedListenerRegistry();
        $provider->subscribeTo(stdClass::class, $listenerSpy);
        $dispatcher = new EventDispatcher($provider);
        $event = new stdClass();

        $dispatcher->dispatch($event);

        $this->assertTrue($listenerSpy->wasCalledWith($event));
    }

    /**
     * @test
     */
    public function it_only_keeps_notifying_handlers_when_the_event_propagation_is_not_stopped(): void
    {
        $dispatcher = new EventDispatcher();
        $listenerSpy = new ListenerSpy();
        $event = new StubStoppableEvent();

        $dispatcher->subscribeTo(
            StubStoppableEvent::class,
            function (StubStoppableEvent $event) {
                $event->stopPropagation();
            }
        );
        $dispatcher->subscribeTo(StubStoppableEvent::class, $listenerSpy);
        $dispatcher->dispatch($event);

        $this->assertFalse($listenerSpy->wasCalledWith($event));
    }

    /**
     * @test
     */
    public function it_calls_one_time_listeners_one_time(): void
    {
        $normalListener = new ListenerSpy();
        $oneTimeListener = new ListenerSpy();

        $dispatcher = new EventDispatcher();
        $dispatcher->subscribeTo(stdClass::class, $normalListener);
        $dispatcher->subscribeOnceTo(stdClass::class, $oneTimeListener);

        $dispatcher->dispatch(new stdClass());
        $dispatcher->dispatch(new stdClass());
        $dispatcher->dispatch(new stdClass());

        $this->assertEquals(1, $oneTimeListener->numberOfTimeCalled());
        $this->assertEquals(3, $normalListener->numberOfTimeCalled());
    }

    /**
     * @test
     * @dataProvider dpScenariosCausingSubscribingFailure
     */
    public function subscribing_does_not_work_when_the_underlying_provider_does_not_allow_subscribing(callable $scenario
    ): void {
        $provider = new class() implements ListenerProviderInterface {
            public function getListenersForEvent(object $event): iterable
            {
                return [];
            }
        };
        $dispatcher = new EventDispatcher($provider);

        $this->expectExceptionObject(
            UnableToSubscribeListener::becauseTheListenerProviderDoesNotAcceptListeners($provider)
        );

        $scenario($dispatcher);
    }

    public function dpScenariosCausingSubscribingFailure(): iterable
    {
        yield "subscribing" => [
            function (EventDispatcher $dispatcher) {
                $dispatcher->subscribeTo(
                    'event',
                    function () {
                    }
                );
            },
        ];

        yield "subscribing once" => [
            function (EventDispatcher $dispatcher) {
                $dispatcher->subscribeOnceTo(
                    'event',
                    function () {
                    }
                );
            },
        ];

        yield "subscribing from subscriber" => [
            function (EventDispatcher $dispatcher) {
                $dispatcher->subscribeListenersFrom(
                    new class () implements ListenerSubscriber {
                        public function subscribeListeners(ListenerRegistry $acceptor): void
                        {
                        }
                    }
                );
            },
        ];
    }

    /**
     * @test
     */
    public function listeners_are_prioritized(): void
    {
        $dispatcher = new EventDispatcher();
        $event = new StubMutableEvent('Hi!');
        $append = static function (string $value) {
            return static function (StubMutableEvent $event) use ($value) {
                $event->append(' ' . $value);
            };
        };
        $appendHello = $append('Hello,');
        $appendWorld = $append('World!');
        $appendGoodBye = $append('Good bye!');
        $dispatcher->subscribeTo(StubMutableEvent::class, $appendWorld, 0);
        $dispatcher->subscribeTo(StubMutableEvent::class, $appendHello, 10);
        $dispatcher->subscribeTo(StubMutableEvent::class, $appendGoodBye, -10);

        $dispatcher->dispatch($event);

        $this->assertEquals('Hi! Hello, World! Good bye!', $event->value());
    }

    /**
     * @test
     */
    public function events_from_an_event_generator_can_be_dispatched(): void
    {
        $dispatcher = new EventDispatcher();
        $listener = new ListenerSpy();
        $dispatcher->subscribeTo(stdClass::class, $listener);

        $eventGenerator = new class () implements EventGenerator {
            use EventGeneratorBehavior {
                recordEvent as public;
            }
        };
        $eventGenerator->recordEvent(new stdClass());
        $eventGenerator->recordEvent(new stdClass());
        $eventGenerator->recordEvent(new stdClass());
        $dispatcher->dispatchGeneratedEvents($eventGenerator);

        $this->assertEquals(3, $listener->numberOfTimeCalled());
    }

    /**
     * @test
     */
    public function listeners_can_be_subscribed_through_a_subscriber(): void
    {
        $subscriber = new class () implements ListenerSubscriber {
            public function subscribeListeners(ListenerRegistry $acceptor): void
            {
                $acceptor->subscribeTo(
                    StubMutableEvent::class,
                    function (StubMutableEvent $event) {
                        $event->append(' mutated');
                    }
                );
            }
        };
        $dispatcher = new EventDispatcher();
        $dispatcher->subscribeListenersFrom($subscriber);
        $event = new StubMutableEvent('this is');
        $dispatcher->dispatch($event);

        $this->assertEquals('this is mutated', $event->value());
    }
}
