<?php

namespace League\Event;

trait EmitterTrait
{
    protected $emitter;

    public function setEmitter(Emitter $emitter)
    {
        $this->emitter = $emitter;

        return $this;
    }

    public function getEmitter()
    {
        if ( ! $this->emitter) {
            $this->emitter = new Emitter;
        }

        return $this->emitter;
    }

    public function addListener($event, $listener)
    {
        call_user_func_array([$this->emitter, 'addListener'], func_get_args());

        return $this;
    }

    public function addOneTimeListener($event, $listener)
    {
        call_user_func_array([$this->emitter, 'addOneTimeListener'], func_get_args());

        return $this;
    }

    public function removeListener($event, $listener)
    {
        $emitter = $this->getEmitter();

        call_user_func_array([$emitter, 'removeListener'], func_get_args());

        return $this;
    }

    public function removeAllListeners($event)
    {
        $emitter = $this->getEmitter();
        $emitter->removeAllListeners($event);

        return $this;
    }

    public function emit($event)
    {
        $emitter = $this->getEmitter();

        return call_user_func_array([$emitter, 'emit'], func_get_args());
    }
}
