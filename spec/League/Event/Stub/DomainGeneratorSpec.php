<?php

namespace spec\League\Event\Stub;

use League\Event\EventInterface;
use PhpSpec\ObjectBehavior;

class DomainGeneratorSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('League\Event\Stub\DomainGenerator');
        $this->shouldHaveType('League\Event\GeneratorInterface');
    }

    public function it_should_record_an_event_internally(EventInterface $event)
    {
        $this->recordAnEvent($event);
        $this->releaseEvents()->shouldReturn([$event]);
    }
}
