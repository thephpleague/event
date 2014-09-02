<?php

namespace spec\League\Event\Stub;

use PhpSpec\ObjectBehavior;

class DomainEventSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('League\Event\Stub\DomainEvent');
    }

    function it_should_return_the_class_name_as_the_name()
    {
        $this->getName()->shouldBe('League\\Event\\Stub\\DomainEvent');
    }
}
