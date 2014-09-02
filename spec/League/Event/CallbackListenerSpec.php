<?php

namespace spec\League\Event;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CallbackListenerSpec extends ObjectBehavior
{
    protected $callback;

    public function let()
    {
        $this->callback = function () {};
        $this->beConstructedWith($this->callback);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('League\Event\CallbackListener');
    }

    public function it_should_identify_itself_by_callback()
    {
        $this->isListener($this->callback)->shouldReturn(true);
        $this->isListener($this)->shouldReturn(true);
    }
}
