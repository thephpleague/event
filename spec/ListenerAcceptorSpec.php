<?php

namespace spec\League\Event;

use League\Event\EmitterInterface;
use PhpSpec\ObjectBehavior;

class ListenerAcceptorSpec extends ObjectBehavior
{
    protected $emitter;

    public function let(EmitterInterface $emitter)
    {
        $this->emitter = $emitter;
        $this->beConstructedWith($emitter);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('League\Event\ListenerAcceptor');
        $this->shouldHaveType('League\Event\ListenerAcceptorInterface');
    }

    public function it_should_delegate_addListener_calls()
    {
        $event = 'event';
        $listener = function () {};
        $priority = 100;
        $this->emitter->addListener($event, $listener, $priority)->shouldBeCalled();
        $this->addListener($event, $listener, $priority)->shouldBe($this);
    }

    public function it_should_delegate_addOneTimeListener_calls()
    {
        $event = 'event';
        $listener = function () {};
        $priority = 100;
        $this->emitter->addOneTimeListener($event, $listener, $priority)->shouldBeCalled();
        $this->addOneTimeListener($event, $listener, $priority)->shouldBe($this);
    }
}
