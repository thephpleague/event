<?php

namespace spec\League\Event;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use League\Event\ListenerInterface;
use League\Event\AbstractEvent;
use League\Event\Emitter;

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
        $this->getWrappedListener()->shouldHaveType('League\Event\ListenerInterface');
    }

    public function it_should_unregister_and_forward_the_handle_call(AbstractEvent $event, Emitter $emitter)
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
