<?php

namespace spec\League\Event\Stub;

use PhpSpec\ObjectBehavior;
use stdClass;

class DomainGeneratorSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('League\Event\Stub\DomainGenerator');
        $this->shouldHaveType('League\Event\GeneratorInterface');
    }

    public function it_should_record_an_event_internally()
    {
        $this->recordAnEvent($event = new stdClass());
        $this->releaseEvents()->shouldReturn([$event]);
    }
}
