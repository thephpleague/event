<?php

namespace League\Event;

class PriorityEmitter extends Emitter
{
    /**
     * High priority.
     *
     * @var int
     */
    const P_HIGH = 100;

    /**
     * Normal priority.
     *
     * @var int
     */
    const P_NORMAL = 0;

    /**
     * Low priority.
     *
     * @var int
     */
    const P_LOW = -100;

    /**
     * Add a listener for an event.
     *
     * The first parameter should be the event name, and the second should be
     * the event listener. It may implement the League\Event\ListenerInterface
     * or simply be "callable". In this case, the priority emitter also accepts
     * an optional third parameter specifying the priority as an integer. You
     * may use one of our predefined constants here if you want.
     *
     * @param string                     $event
     * @param ListenerInterface|callable $listener
     * @param int                        $priority
     *
     * @return $this
     */
    public function addListener($event, $listener, $priority = self::P_NORMAL)
    {
        if ( ! $listener instanceof ListenerInterface) {
            $listener = $this->ensureListener($listener);
        }

        if ( ! isset($this->listeners[$event])) {
            $this->listeners[$event] = [];
        }

        $this->listeners[$event][] = [$listener, $priority];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeListener($event, $listener)
    {
        foreach ($this->listeners[$event] as $index => $registered) {
            if ($registered[0]->isListener($listener)) {
                unset($this->listeners[$event][$index]);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getListeners($event)
    {
        if ( ! $this->hasListeners($event)) {
            return [];
        }

        $listeners = $this->listeners[$event];

        usort($listeners, function ($a, $b) {
            return $a[1] - $b[1];
        });

        return array_map(function ($listener) {
            return $listener[0];

        }, $listeners);
    }
}
