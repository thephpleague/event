<?php

namespace League\Event;

trait EmitterTrait
{
    /**
     * The emitter instance.
     *
     * @var EmitterInterface|null
     */
    protected $emitter;

    /**
     * Set the Emitter.
     *
     * @param EmitterInterface $emitter
     *
     * @return $this
     */
    public function setEmitter(EmitterInterface $emitter = null)
    {
        $this->emitter = $emitter;

        return $this;
    }

    /**
     * Get the Emitter.
     *
     * @return EmitterInterface
     */
    public function getEmitter()
    {
        if ( ! $this->emitter) {
            $this->emitter = new Emitter();
        }

        return $this->emitter;
    }

    /**
     * Add a listener for an event.
     *
     * The first parameter should be the event name, and the second should be
     * the event listener. It may implement the League\Event\ListenerInterface
     * or simply be "callable".
     *
     * @param string                     $event
     * @param ListenerInterface|callable $listener
     *
     * @return $this
     */
    public function addListener($event, $listener)
    {
        $this->getEmitter()->addListener($event, $listener);

        return $this;
    }

    /**
     * Add a one time listener for an event.
     *
     * The first parameter should be the event name, and the second should be
     * the event listener. It may implement the League\Event\ListenerInterface
     * or simply be "callable".
     *
     * @param string                     $event
     * @param ListenerInterface|callable $listener
     *
     * @return $this
     */
    public function addOneTimeListener($event, $listener)
    {
        $this->getEmitter()->addOneTimeListener($event, $listener);

        return $this;
    }

    /**
     * Remove a specific listener for an event.
     *
     * The first parameter should be the event name, and the second should be
     * the event listener. It may implement the League\Event\ListenerInterface
     * or simply be "callable".
     *
     * @param string                     $event
     * @param ListenerInterface|callable $listener
     *
     * @return $this
     */
    public function removeListener($event, $listener)
    {
        $this->getEmitter()->removeListener($event, $listener);

        return $this;
    }

    /**
     * Remove all listeners for an event.
     *
     * The first parameter should be the event name. All event listeners will
     * be removed.
     *
     * @param string $event
     *
     * @return $this
     */
    public function removeAllListeners($event)
    {
        $this->getEmitter()->removeAllListeners($event);

        return $this;
    }

    /**
     * Check weather an event has listeners.
     *
     * The first parameter should be the event name. We'll return true if the
     * event has one or more registered even listeners, and false otherwise.
     *
     * @param string $event
     *
     * @return bool
     */
    public function hasListeners($event)
    {
        return $this->getEmitter()->hasListeners($event);
    }

    /**
     * Get all the listeners for an event.
     *
     * The first parameter should be the event name. We'll return an array of
     * all the registered even listeners, or an empty array if there are none.
     *
     * @param string $event
     *
     * @return array
     */
    public function getListeners($event)
    {
        return $this->getEmitter()->getListeners($event);
    }

    /**
     * Emit an event.
     *
     * @param string|AbstractEvent $event
     *
     * @return AbstractEvent
     */
    public function emit($event)
    {
        return $this->getEmitter()->emit($event);
    }

    /**
     * Emit a batch of events.
     *
     * @param array $events
     *
     * @return array
     */
    public function emitBatch(array $events)
    {
        return $this->getEmitter()->emitBatch($events);
    }
}
