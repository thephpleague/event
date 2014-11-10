<?php

namespace spec\League\Event;

use League\Event\EventInterface;
use PhpSpec\ObjectBehavior;

class GeneratorSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('League\Event\Generator');
    }

    public function it_should_accept_an_event_object(EventInterface $event)
    {
        $this->addEvent($event)->shouldReturn($this);
    }

    public function it_should_release_events(EventInterface $event)
    {
        $this->releaseEvents()->shouldHaveCount(0);
        $this->addEvent($event);
        $this->releaseEvents()->shouldContain($event);
        $this->releaseEvents()->shouldHaveCount(0);
    }
}
