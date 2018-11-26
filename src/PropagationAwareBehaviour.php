<?php

namespace League\Event;

trait PropagationAwareBehaviour
{
    /**
     * Has propagation stopped?
     *
     * @var bool
     */
    protected $propagationStopped = false;

    public function stopPropagation()
    {
        $this->propagationStopped = true;

        return $this;
    }

    public function isPropagationStopped()
    {
        return $this->propagationStopped;
    }
}