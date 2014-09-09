<?php

namespace spec\League\Event;

use PhpSpec\ObjectBehavior;
use League\Event\CallbackListener;

class PriorityEmitterSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('League\Event\PriorityEmitter');
        $this->shouldHaveType('League\Event\EmitterInterface');
    }

    public function it_should_prioritize_listeners(CallbackListener $first, CallbackListener $second)
    {
        $this->addListener('event', $first, 0);
        $this->addListener('event', $second, 50);
        $this->getListeners('event')->shouldReturn([$second, $first]);
    }

    public function it_should_allow_to_remove_specific_listeners()
    {
        $keep = new CallbackListener(function () {});
        $remove = new CallbackListener(function () {});

        $this->addListener('event', $remove);
        $this->addListener('event', $keep);
        $this->removeListener('event', $remove);
        $this->getListeners('event')->shouldReturn([$keep]);
    }

    public function it_should_return_an_empty_array_when_there_are_no_listeners()
    {
        $this->getListeners('event')->shouldHaveCount(0);
    }

}
