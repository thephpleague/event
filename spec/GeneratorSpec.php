<?php

namespace spec\League\Event;

use PhpSpec\ObjectBehavior;
use stdClass;

class GeneratorSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('League\Event\Generator');
    }

    public function it_should_accept_an_event_object()
    {
        $this->addEvent(new stdClass())->shouldReturn($this);
    }

    public function it_should_release_events()
    {
        $event = new stdClass();
        $this->releaseEvents()->shouldHaveCount(0);
        $this->addEvent($event);
        $this->releaseEvents()->shouldContain($event);
        $this->releaseEvents()->shouldHaveCount(0);
    }
}
