<?php

namespace League\Event;

interface ListenerProviderInterface
{
    /**
     * Provide event
     *
     * @param ListenerAwareInterface $listenerAcceptor
     * @return $this
     */
    public function provideListeners(ListenerAwareInterface $listenerAcceptor);
} 