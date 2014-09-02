<?php

namespace spec\League\Event\Stub;

use PhpSpec\ObjectBehavior;
use League\Event\Event;

class ListenerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('League\Event\Stub\Listener');
        $this->shouldHaveType('League\Event\ListenerInterface');
    }

    public function it_should_handle_an_event(Event $event)
    {
        $event->stopPropagation()->shouldBeCalled();
        $this->handle($event)->shouldReturn(null);
    }

    public function it_should_identify_itself()
    {
        $this->isListener($this)->shouldReturn(true);
        $this->isListener(false)->shouldReturn(false);
    }
}
