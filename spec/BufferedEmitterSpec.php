<?php

namespace spec\League\Event;

use League\Event\Event;
use League\Event\EventInterface;
use League\Event\ListenerInterface;
use League\Event\Stub\SpyListener;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BufferedEmitterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('League\Event\BufferedEmitter');
    }

    public function it_should_buffer_events(ListenerInterface $listener)
    {
        $event = new Event('event');
        $listener->handle($event)->shouldBeCalled();
        $this->emit($event);
        $this->addListener('event', $listener);
        $this->emitBufferedEvents();
    }

    public function it_should_buffer_batched_events(ListenerInterface $listener)
    {
        $event = new Event('event');
        $listener->handle($event)->shouldBeCalled();
        $this->emitBatch([$event]);
        $this->addListener('event', $listener);
        $this->emitBufferedEvents();
    }
}
