<?php

namespace League\Event;

use SplPriorityQueue;

class PriorityEmitter extends Emitter
{
    /**
     * @const  P_HIGH  High priority
     */
    const P_HIGH = 100;

    /**
     * @const  P_NORMAL  Normal priority
     */
    const P_NORMAL = 0;

    /**
     * @const  P_LOW  Low priority
     */
    const P_LOW = -100;

    /**
     * Add a listener to an event
     *
     * @param  string  $event  event name
     * @param  callable|ListenerInterface  $listener
     * @param  integer  $priority
     */
    public function addListener($event, $listener, $priority = self::P_NORMAL)
    {
        if ( ! $listener instanceof ListenerInterface)
            $listener = $this->ensureListener($listener);

        if ( ! isset($this->listeners[$event])) {
            $this->listeners[$event] = [];
        }

        $this->listeners[$event][] = [$listener, $priority];

        return $this;
    }

    /**
     * {inheritdoc}
     */
    public function removeListener($event, $listener)
    {
        foreach($this->listeners[$event] as $index => $registered) {
            if ($registered[0]->isListener($listener))
                unset($this->listeners[$event][$index]);
        }
    }

    /**
     * {inheritdoc}
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

        return array_map(function ($listener)
        {
            return $listener[0];

        } , $listeners);
    }
}
