<?php

namespace League\Event;

use InvalidArgumentException;

class Emitter implements EmitterInterface
{
    /**
     * The registered listeners.
     *
     * @var array
     */
    protected $listeners = [];

    /**
     * {@inheritdoc}
     */
    public function addListener($event, $listener)
    {
        $listener = $this->ensureListener($listener);

        if ( ! isset($this->listeners[$event])) {
            $this->listeners[$event] = [];
        }

        $this->listeners[$event][] = $listener;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addOneTimeListener($event, $listener)
    {
        $listener = $this->ensureListener($listener);
        $listener = new OneTimeListener($listener);

        return $this->addListener($event, $listener);
    }

    /**
     * {@inheritdoc}
     */
    public function removeListener($event, $listener)
    {
        $listeners = $this->getListeners($event);

        $filter = function ($registered) use ($listener) {
            /** @var ListenerInterface  $registered */
            return ! $registered->isListener($listener);
        };

        $this->listeners[$event] = array_filter($listeners, $filter);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeAllListeners($event)
    {
        if ($this->hasListeners($event)) {
            unset($this->listeners[$event]);
        }

        return $this;
    }

    /**
     * Ensure the input is a listener.
     *
     * @param ListenerInterface|callable $listener
     *
     * @throws InvalidArgumentException
     *
     * @return ListenerInterface
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
     * {@inheritdoc}
     */
    public function hasListeners($event)
    {
        if ( ! isset($this->listeners[$event]) || count($this->listeners[$event]) === 0) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getListeners($event)
    {
        if ( ! $this->hasListeners($event)) {
            return [];
        }

        return $this->listeners[$event];
    }

    /**
     * {@inheritdoc}
     */
    public function emit($event)
    {
        list($name, $event) = $this->prepareEvent($event);
        $arguments = [$event] + func_get_args();
        $this->invokeListeners($name, $event, $arguments);
        $this->invokeListeners('*', $event, $arguments);

        return $event;
    }

    /**
     * {@inheritdoc}
     */
    public function emitBatch(array $events)
    {
        $emit = [$this, 'emit'];

        return array_map($emit, $events);
    }

    /**
     * Invoke the listeners for an event.
     *
     * @param string        $name
     * @param AbstractEvent $event
     * @param array         $arguments
     *
     * @return void
     */
    protected function invokeListeners($name, AbstractEvent $event, array $arguments)
    {
        $listeners = $this->getListeners($name);

        foreach ($listeners as $listener) {
            if ($event->isPropagationStopped()) {
                break;
            }

            call_user_func_array([$listener, 'handle'], $arguments);
        }
    }

    /**
     * Prepare an event for emitting.
     *
     * @param string|AbstractEvent $event
     *
     * @return array
     */
    protected function prepareEvent($event)
    {
        $event = $this->ensureEvent($event);
        $name = $event->getName();
        $event->setEmitter($this);

        return [$name, $event];
    }

    /**
     * Ensure event input is of type AbstractEvent or convert it.
     *
     * @param string|AbstractEvent $event
     *
     * @throws InvalidArgumentException
     *
     * @return AbstractEvent
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
