<?php

namespace League\Event;

trait EmitterAwareBehaviour
{
    /**
     * The emitter instance.
     *
     * @var EmitterInterface|null
     */
    protected $emitter;

    public function setEmitter(EmitterInterface $emitter = null)
    {
        $this->emitter = $emitter;

        return $this;
    }

    public function getEmitter()
    {
        return $this->emitter;
    }
}