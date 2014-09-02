<?php

namespace spec\League\Event;

use PhpSpec\ObjectBehavior;
use League\Event\Emitter;

class EventSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('name');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('League\Event\Event');
        $this->shouldHaveType('League\Event\AbstractEvent');
    }

    function it_should_have_a_name()
    {
        $this->getName()->shouldReturn('name');
    }

    function it_should_allow_propagation_to_be_stopped()
    {
        $this->stopPropagation()->shouldReturn($this);
        $this->isPropagationStopped()->shouldReturn(true);
    }

    function it_should_expose_an_emitter(Emitter $emitter)
    {
        $this->setEmitter($emitter);
        $this->getEmitter()->shouldReturn($emitter);
    }
}
