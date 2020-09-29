<?php

declare(strict_types=1);

namespace League\Event;

use Psr\EventDispatcher\EventDispatcherInterface;

class BufferedEventDispatcher implements EventDispatcherInterface, ListenerRegistry
{
    use EventGeneratorBehavior {
        recordEvent as protected;
        releaseEvents as protected;
    }

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function dispatch(object $event): object
    {
        $this->recordEvent($event);

        return $event;
    }

    /**
     * @return object[]
     */
    public function dispatchBufferedEvents(): array
    {
        $events = [];

        foreach ($this->releaseEvents() as $event) {
            $events[] = $this->dispatcher->dispatch($event);
        }

        return $events;
    }

    public function subscribeTo(string $event, callable $listener, int $priority = ListenerPriority::NORMAL): void
    {
        if ( ! $this->dispatcher instanceof ListenerRegistry) {
            throw UnableToSubscribeListener::becauseTheEventDispatcherDoesNotAcceptListeners($this->dispatcher);
        }

        $this->dispatcher->subscribeTo($event, $listener, $priority);
    }

    public function subscribeOnceTo(string $event, callable $listener, int $priority = ListenerPriority::NORMAL): void
    {
        if ( ! $this->dispatcher instanceof ListenerRegistry) {
            throw UnableToSubscribeListener::becauseTheEventDispatcherDoesNotAcceptListeners($this->dispatcher);
        }

        $this->dispatcher->subscribeOnceTo($event, $listener, $priority);
    }

    public function subscribeListenersFrom(ListenerSubscriber $subscriber): void
    {
        if ( ! $this->dispatcher instanceof ListenerRegistry) {
            throw UnableToSubscribeListener::becauseTheEventDispatcherDoesNotAcceptListeners($this->dispatcher);
        }

        $this->dispatcher->subscribeListenersFrom($subscriber);
    }
}
