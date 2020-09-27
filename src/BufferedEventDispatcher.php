<?php

declare(strict_types=1);

namespace League\Event;

use Psr\EventDispatcher\EventDispatcherInterface;

class BufferedEventDispatcher implements EventDispatcherInterface, ListenerAcceptor
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

    public function dispatch(object $event): void
    {
        $this->recordEvent($event);
    }

    public function dispatchBufferedEvents(): void
    {
        foreach ($this->releaseEvents() as $event) {
            $this->dispatcher->dispatch($event);
        }
    }

    public function subscribeTo(string $event, callable $listener, int $priority = ListenerPriority::NORMAL): void
    {
        if ( ! $this->dispatcher instanceof ListenerAcceptor) {
            throw UnableToSubscribeListener::becauseTheEventDispatcherDoesNotAcceptListeners($this->dispatcher);
        }

        $this->dispatcher->subscribeTo($event, $listener, $priority);
    }

    public function subscribeOnceTo(string $event, callable $listener, int $priority = ListenerPriority::NORMAL): void
    {
        if ( ! $this->dispatcher instanceof ListenerAcceptor) {
            throw UnableToSubscribeListener::becauseTheEventDispatcherDoesNotAcceptListeners($this->dispatcher);
        }

        $this->dispatcher->subscribeOnceTo($event, $listener, $priority);
    }

    public function subscribeListenersFrom(ListenerSubscriber $subscriber): void
    {
        if ( ! $this->dispatcher instanceof ListenerAcceptor) {
            throw UnableToSubscribeListener::becauseTheEventDispatcherDoesNotAcceptListeners($this->dispatcher);
        }

        $this->dispatcher->subscribeListenersFrom($subscriber);
    }
}
