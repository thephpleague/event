---
layout: default
title: Listener Providers
---

# Listener Providers

Listener providers allow for a class based listeners bootstrapping.

~~~ php
<?php

use League\Event\ListenerProviderInterface;

class MyProvider implements ListenerProviderInterface
{
    public function provide(ListenerAcceptorInterface $acceptor)
    {
        $acceptor->addListener('event', new MyListeners);
    }
}

$emitter->useListenerProvider(new MyProvider);
~~~
