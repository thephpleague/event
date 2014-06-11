<?php

use League\Event\Emitter as Emitter;
use League\Event\ListenerAbstract;
include __DIR__ . '/vendor/autoload.php';

class MyListener extends ListenerAbstract
{
    public function handle(EventAbstract $event)
    {
        // handle it
    }
}

$emitter = new Emitter;
$callback = function ($event) {
    echo 'callback!';
};

$other = function ($event) {
    echo 'other!';
};

$emitter->addListener('event.name', $callback);
$emitter->addListener('event.name', $callback);
$emitter->addOneTimeListener('event.name', $other);
$emitter->removeListener('event.name', $callback);

$emitter->emit('event.name');
$emitter->emit('event.name');
