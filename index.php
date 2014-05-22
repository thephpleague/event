<?php

use League\Event\PriorityEmitter as Emitter;
// use League\Event\Emitter as Emitter;

include __DIR__ . '/vendor/autoload.php';

$emitter = new Emitter;
$callback = function ($event) {
    echo 'callback!';
};

$other = function ($event) {
    echo 'other!';
};

$emitter->addListener('event.name', $callback);
$emitter->addListener('event.name', $callback);
$emitter->addOnceListener('event.name', $other);

$emitter->emit('event.name');
$emitter->emit('event.name');
