<?php

namespace League\Event;

interface PropagationAwareInterface
{
    /**
     * Stop event propagation.
     *
     * @return $this
     */
    public function stopPropagation();

    /**
     * Check whether propagation was stopped.
     *
     * @return bool
     */
    public function isPropagationStopped();
}