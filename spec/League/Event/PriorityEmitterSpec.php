<?php

namespace spec\League\Event;

use PhpSpec\ObjectBehavior;
use League\Event\Event;
use League\Event\CallbackListener;

class PriorityEmitterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('League\Event\PriorityEmitter');
    }

    function it_should_prioritize_listeners(Event $event, CallbackListener $first, CallbackListener $second)
    {
        $event->setEmitter($this)->shouldBeCalled();
        $event->isPropagationStopped()->willReturn(false);
        $event->getName()->willReturn('event');
        $second->handle($event)->will(function () use ($first, $event) {
            $first->handle($event)->shouldBeCalled();
        })->shouldBeCalled();

        $this->addListener('event', $first, 0);
        $this->addListener('event', $second, 50);
        $this->emit($event)->shouldReturn($event);
    }

    function it_should_allow_to_remove_specific_listeners(Event $event, CallbackListener $remove, CallbackListener $keep)
    {
        $event->setEmitter($this)->shouldBeCalled();
        $event->isPropagationStopped()->willReturn(false);
        $event->getName()->willReturn('event');
        $remove->isListener($remove)->willReturn(true);
        $keep->isListener($remove)->willReturn(false);
        $this->addListener('event', $remove);
        $this->addListener('event', $keep);
        $this->removeListener('event', $remove);
        $keep->handle($event)->shouldBeCalled();
        $this->emit($event)->shouldReturn($event);
    }

    function it_should_return_an_empty_array_when_there_are_no_listeners()
    {
        $this->getListeners('event')->shouldHaveCount(0);
    }

}
