<?php

namespace League\Event;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Psr\EventDispatcher\StoppableEventInterface;

class EventDispatcher implements EventDispatcherInterface, ListenerAcceptor
{
    /**
     * @var ListenerProviderInterface
     */
    protected $listenerProvider;

    public function __construct(ListenerProviderInterface $listenerProvider = null)
    {
        $this->listenerProvider = $listenerProvider instanceof ListenerProviderInterface
            ? $listenerProvider
            : new PrioritizedListenerCollection();
    }

    public function dispatch(object $event): void
    {
        $listeners = $this->listenerProvider->getListenersForEvent($event);

        $event instanceof StoppableEventInterface
            ? $this->dispatchStoppableEvent($listeners, $event)
            : $this->dispatchUnstoppableEvent($listeners, $event);
    }

    public function dispatchGeneratedEvents(EventGenerator $generator): void
    {
        foreach ($generator->releaseEvents() as $event) {
            $this->dispatch($event);
        }
    }

    private function dispatchStoppableEvent(iterable $listeners, StoppableEventInterface $event): void
    {
        foreach ($listeners as $listener) {
            if ($event->isPropagationStopped()) {
                break;
            }

            $listener($event);
        }
    }

    private function dispatchUnstoppableEvent(iterable $listeners, $event): void
    {
        foreach ($listeners as $listener) {
            $listener($event);
        }
    }

    public function subscribe(string $event, callable $listener, int $priority = self::P_NORMAL): void
    {
        if ( ! $this->listenerProvider instanceof ListenerAcceptor) {
            throw UnableToSubscribeListener::becauseTheListenerProviderDoesNotAcceptListeners($this->listenerProvider);
        }

        $this->listenerProvider->subscribe($event, $listener, $priority);
    }

    public function subscribeOnce(string $event, callable $listener, int $priority = self::P_NORMAL): void
    {
        if ( ! $this->listenerProvider instanceof ListenerAcceptor) {
            throw UnableToSubscribeListener::becauseTheListenerProviderDoesNotAcceptListeners($this->listenerProvider);
        }

        $this->listenerProvider->subscribeOnce($event, $listener, $priority);
    }

    public function subscribeFrom(ListenerSubscriber $subscriber): void
    {
        if ( ! $this->listenerProvider instanceof ListenerAcceptor) {
            throw UnableToSubscribeListener::becauseTheListenerProviderDoesNotAcceptListeners($this->listenerProvider);
        }

        $this->listenerProvider->subscribeFrom($subscriber);
    }
}
