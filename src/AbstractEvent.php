<?php

namespace League\Event;

abstract class AbstractEvent
{
    /**
     * @var  boolean  $propagationStopped
     */
    protected $propagationStopped = false;

    /**
     * @var  Emitter  $emitter
     */
    protected $emitter;

    /**
     * Set the Emitter
     *
     * @param   EmitterInterface  $emitter
     * @return  $this
     */
    public function setEmitter(EmitterInterface $emitter)
    {
        $this->emitter = $emitter;

        return $this;
    }

    /**
     * Get the Emitter
     *
     * @return  EmitterInterface
     */
    public function getEmitter()
    {
        return $this->emitter;
    }

    /**
     * Stop event propagation
     *
     * @return  $this
     */
    public function stopPropagation()
    {
        $this->propagationStopped = true;

        return $this;
    }

    /**
     * Check weather propagation was stopped
     *
     * @return  boolean
     */
    public function isPropagationStopped()
    {
        return $this->propagationStopped;
    }

    /**
     * Get the event name
     *
     * @return  string  event name
     */
    public function getName()
    {
        return get_class($this);
    }
}
