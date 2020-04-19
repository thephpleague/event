<?php

namespace League\Event;

use Psr\EventDispatcher\StoppableEventInterface;

interface EventInterface extends StoppableEventInterface
{
    /**
     * Set the Emitter.
     *
     * @param EmitterInterface $emitter
     *
     * @return $this
     */
    public function setEmitter(EmitterInterface $emitter);

    /**
     * Get the Emitter.
     *
     * @return EmitterInterface
     */
    public function getEmitter();

    /**
     * Stop event propagation.
     *
     * @return $this
     */
    public function stopPropagation();

    /**
     * Get the event name.
     *
     * @return string
     */
    public function getName();
}
