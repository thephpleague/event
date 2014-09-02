<?php

namespace spec\League\Event\Stub;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DomainEventSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('League\Event\Stub\DomainEvent');
    }

    public function it_should_return_the_class_name_as_the_name()
    {
        $this->getName()->shouldBe('League\\Event\\Stub\\DomainEvent');
    }
}
