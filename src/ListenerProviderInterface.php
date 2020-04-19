<?php

namespace League\Event;

use Psr\EventDispatcher\ListenerProviderInterface as PsrListenerProviderInterface;

interface ListenerProviderInterface extends PsrListenerProviderInterface
{
    /**
     * Provide event
     *
     * @param ListenerAcceptorInterface $listenerAcceptor
     *
     * @return $this
     */
    public function provideListeners(ListenerAcceptorInterface $listenerAcceptor);
}
