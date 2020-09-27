<?php

declare(strict_types=1);

namespace League\Event;

use Psr\EventDispatcher\ListenerProviderInterface;

class PrioritizedListenerCollection implements ListenerAcceptor, ListenerProviderInterface
{
    /** @var array<string,PrioritizedListenersForEvent> */
    protected $listenersPerEvent = [];

    public function subscribeTo(string $event, callable $listener, int $priority = self::P_NORMAL): void
    {
        $group = array_key_exists($event, $this->listenersPerEvent)
            ? $this->listenersPerEvent[$event]
            : $this->listenersPerEvent[$event] = new PrioritizedListenersForEvent();

        $group->addListener($listener, $priority);
    }

    public function subscribeOnceTo(string $event, callable $listener, int $priority = self::P_NORMAL): void
    {
        $this->subscribeTo($event, new OneTimeListener($listener), $priority);
    }

    public function getListenersForEvent(object $event): iterable
    {
        if ($event instanceof HasEventName) {
            yield from $this->getListenersForEventName($event->eventName());
        }

        /**
         * @var string                       $key
         * @var PrioritizedListenersForEvent $group
         */
        foreach ($this->listenersPerEvent as $key => $group) {
            if ($event instanceof $key) {
                yield from $group->getListeners();
            }
        }
    }

    private function getListenersForEventName(string $eventName): iterable
    {
        if ( ! array_key_exists($eventName, $this->listenersPerEvent)) {
            return [];
        }

        return $this->listenersPerEvent[$eventName]->getListeners();
    }

    public function subscribeListenersFrom(ListenerSubscriber $subscriber): void
    {
        $subscriber->subscribeListeners($this);
    }
}
