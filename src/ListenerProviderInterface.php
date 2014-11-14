<?php

namespace League\Event;

interface ListenerProviderInterface
{
    /**
     * Provide event
     *
     * @param EmitterInterface $emitter
     * @return void
     */
    public function provideListeners(EmitterInterface $emitter);
} 