---
layout: default
title: Listener Providers
---

# Listener Providers

Listener providers allow for a class based listeners registration.

~~~ php
<?php

use League\Event\ListenerAcceptorInterface;
use League\Event\ListenerProviderInterface;

class MyProvider implements ListenerProviderInterface
{
    public function provideListeners(ListenerAcceptorInterface $acceptor)
    {
        $acceptor->addListener('event', new MyListeners);
    }
}

$emitter->useListenerProvider(new MyProvider);
~~~
