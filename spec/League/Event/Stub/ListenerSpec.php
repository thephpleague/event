<?php

namespace spec\League\Event\Stub;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use League\Event\Event;
use League\Event\Emitter;

class ListenerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('League\Event\Stub\Listener');
        $this->shouldHaveType('League\Event\ListenerInterface');
    }

    function it_should_handle_an_event(Event $event)
    {
        $event->stopPropagation()->shouldBeCalled();
        $this->handle($event)->shouldReturn(null);
    }

    function it_should_identify_itself()
    {
        $this->isListener($this)->shouldReturn(true);
    }
}
