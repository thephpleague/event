<?php

namespace League\Event;

trait EmitterTrait
{
    protected $emitter;


    /**
     * Set the emitter
     *
     * @param   Emitter|null $emitter
     * @return  $this
     */
    public function setEmitter(EmitterInterface $emitter = null)
    {
        $this->emitter = $emitter;

        return $this;
    }

    /**
     * Get the Emitter
     *
     * @return Emitter
     */
    public function getEmitter()
    {
        if ( ! $this->emitter) {
            $this->emitter = new Emitter;
        }

        return $this->emitter;
    }

    /**
     * Add a listener
     *
     * @param   string  $event
     * @param   mixes   $listener
     * @return  $this
     */
    public function addListener($event, $listener)
    {
        $emitter = $this->getEmitter();

        call_user_func_array([$emitter, 'addListener'], func_get_args());

        return $this;
    }

    /**
     * Add a one time listener
     *
     * @param   string  $event
     * @param   mixes   $listener
     * @return  $this
     */
    public function addOneTimeListener($event, $listener)
    {
        $emitter = $this->getEmitter();

        call_user_func_array([$emitter, 'addOneTimeListener'], func_get_args());

        return $this;
    }

    /**
     * Remove a listeners
     *
     * @param   string  $event
     * @param   mixed   $listener
     * @return  $this
     */
    public function removeListener($event, $listener)
    {
        $emitter = $this->getEmitter();

        call_user_func_array([$emitter, 'removeListener'], func_get_args());

        return $this;
    }

    /**
     * Remove all listeners for an event
     *
     * @param   string  $event
     * @return  $this
     */
    public function removeAllListeners($event)
    {
        $emitter = $this->getEmitter();
        $emitter->removeAllListeners($event);

        return $this;
    }

    /**
     * Emit an event
     *
     * @param   string  $event
     * @return  mixed
     */
    public function emit($event)
    {
        $emitter = $this->getEmitter();

        return call_user_func_array([$emitter, 'emit'], func_get_args());
    }
}
