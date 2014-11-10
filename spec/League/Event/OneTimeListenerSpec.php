<?php

namespace spec\League\Event;

use League\Event\Emitter;
use League\Event\EventInterface;
use League\Event\ListenerInterface;
use PhpSpec\ObjectBehavior;

class OneTimeListenerSpec extends ObjectBehavior
{
    protected $listener;

    public function let(ListenerInterface $listener)
    {
        $this->listener = $listener;
        $this->beConstructedWith($this->listener);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('League\Event\OneTimeListener');
    }

    public function it_should_expose_the_wrapped_listener()
    {
        $this->getWrappedListener()->shouldReturn($this->listener);
    }

    public function it_should_unregister_and_forward_the_handle_call(EventInterface $event, Emitter $emitter)
    {
        $event->getName()->willReturn('event');
        $event->getEmitter()->willReturn($emitter);
        $emitter->removeListener('event', $this->listener)->shouldBeCalled();
        $this->listener->handle($event)->shouldBeCalled();
        $this->handle($event);
    }

    public function it_should_identify_itself()
    {
        $this->listener->isListener($this->listener)->willReturn(true);
        $this->isListener($this)->shouldReturn(true);
        $this->isListener($this->listener)->shouldReturn(true);
    }
}
