<?php

namespace League\Event;

use InvalidArgumentException;

class Emitter implements EmitterInterface
{
    /**
     * @var  array  $listeners
     */
    protected $listeners = [];

    /**
     * Add a listener to for an event
     *
     * @param   string  $event  event name
     * @param   ListenerInterface|callable  $listener
     * @return  $this
     */
    public function addListener($event, $listener)
    {
        $listener = $this->ensureListener($listener);

        if ( ! isset($this->listeners[$event]))
            $this->listeners[$event] = [];

        $this->listeners[$event][] = $listener;

        return $this;
    }

    /**
     * Add a listener to for an event
     *
     * @param   string  $event  event name
     * @param   ListenerInterface|callable  $listener
     * @return $this
     */
    public function addOneTimeListener($event, $listener)
    {
        $listener = $this->ensureListener($listener);
        $listener = new OneTimeListener($listener);

        return $this->addListener($event, $listener);
    }

    /**
     * Remove a specific listener for an event
     *
     * @param   string  $event  event name
     * @param   ListenerInterface|callable  $listener
     * @return $this
     */
    public function removeListener($event, $listener)
    {
        $listeners = $this->getListeners($event);

        foreach($listeners as $index => $registered) {
            if ( ! $registered->isListener($listener)) continue;
            unset($this->listeners[$event][$index]);
            break;
        }

        return $this;
    }

    /**
     * Remove all listeners for an event
     *
     * @param   string  $event  event name
     * @return  $this
     */
    public function removeAllListeners($event)
    {
        if ($this->hasListeners($event)) {
            unset($this->listeners[$event]);
        }

        return $this;
    }

    /**
     * Ensure the input is a listener
     *
     * @param   ListenerInterface|callable  $listener
     * @throws  InvalidArgumentException
     * @return  $this
     */
    protected function ensureListener($listener)
    {
        if ($listener instanceof ListenerInterface) {
            return $listener;
        }

        if ( ! is_callable($listener)) {
            throw new InvalidArgumentException('Listeners should be be ListenerInterface, Closure or callable. Received type: ' . gettype($listener));
        }

        return new CallbackListener($listener);
    }

    /**
     * Check weather an event has listeners
     *
     * @param   string  $event
     * @return  boolean
     */
    public function hasListeners($event)
    {
        if ( ! isset($this->listeners[$event])) {
            return false;
        }

        if (count($this->listeners[$event]) === 0) {
            return false;
        }

        return true;
    }

    /**
     * Get all the listeners for an event
     *
     * @param   string  $event
     * @return  ListenerInterface[]
     */
    public function getListeners($event)
    {
        if ( ! $this->hasListeners($event)) {
            return [];
        }

        return $this->listeners[$event];
    }

    /**
     * Emit an event
     *
     * @param   string|AbstractEvent  $event
     * @return  AbstractEvent
     */
    public function emit($event)
    {
        list($name, $event) = $this->prepareEvent($event);
        $listeners = $this->getListeners($name);
        $arguments = func_get_args();
        $arguments[0] = $event;
        $this->invokeListeners($listeners, $event, $arguments);

        return $event;
    }

    /**
     * Emit a batch of events
     *
     * @param   array  $events
     * @return  array
     */
    public function emitBatch(array $events)
    {
        $emit = [$this, 'emit'];

        return array_map($emit, $events);
    }

    /**
     * Invoke the the handle method on a list of listeners
     *
     * @param  array  $listeners
     * @param  AbstractEvent  $event
     * @param  array  $arguments
     */
    protected function invokeListeners(array $listeners, AbstractEvent $event, array $arguments)
    {
        foreach ($listeners as $listener) {
            call_user_func_array([$listener, 'handle'], $arguments);

            if ($event->isPropagationStopped()) {
                break;
            }
        }
    }

    /**
     * Prepare an event for emitting
     *
     * @param   string|AbstractEvent  $event
     * @return  array  [name, AbstractEvent]
     */
    protected function prepareEvent($event)
    {
        // Prepare the event
        $event = $this->ensureEvent($event);
        $name = $event->getName();
        $event->setEmitter($this);

        return [$name, $event];
    }

    /**
     * Ensure event input is of type AbstractEvent or convert it
     *
     * @param   string|AbstractEvent  $event
     * @throws  InvalidArgumentException
     * @return  AbstractEvent
     */
    protected function ensureEvent($event)
    {
        if (is_string($event)) {
            return new Event($event);
        }

        if ( ! $event instanceof AbstractEvent) {
            throw new InvalidArgumentException('Events should be provides as Event instances or string, received type: ' . gettype($event));
        }

        return $event;
    }
}
