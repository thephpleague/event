<?php
namespace League\Event;

interface EmitterInterface
{
    /**
     * Add a listener to for an event
     *
     * @param   string                     $event event name
     * @param   ListenerInterface|callable $listener
     * @return  $this
     */
    public function addListener($event, $listener);

    /**
     * Add a listener to for an event
     *
     * @param   string                     $event event name
     * @param   ListenerInterface|callable $listener
     * @return  $this
     */
    public function addOneTimeListener($event, $listener);

    /**
     * Remove a specific listener for an event
     *
     * @param   string                     $event event name
     * @param   ListenerInterface|callable $listener
     * @return  $this
     */
    public function removeListener($event, $listener);

    /**
     * Remove all listeners for an event
     *
     * @param   string                     $event event name
     * @return  $this
     */
    public function removeAllListeners($event);

    /**
     * Check weather an event has listeners
     *
     * @return  boolean
     */
    public function hasListeners($event);

    /**
     * Get all the listeners for an event
     *
     * @return  array
     */
    public function getListeners($event);

    /**
     * Emit an event
     *
     * @param   string|AbstractEvent
     * @return  false|AbstractEvent
     */
    public function emit($event);

    /**
     * Emit a batch of events
     *
     * @param   array $events
     * @return  array
     */
    public function emitBatch(array $events);
}