<?php

namespace spec\League\Event\Stub;

use League\Event\EmitterInterface;
use League\Event\ListenerAcceptorInterface;
use League\Event\ListenerInterface;
use League\Event\ListenerProviderInterface;
use PhpSpec\ObjectBehavior;

class EmitterTraitSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('League\Event\Stub\EmitterTrait');
        $this->shouldUseTrait('League\Event\EmitterTrait');
    }

    public function it_should_allow_removal_of_the_emitter(EmitterInterface $emitter)
    {
        $this->setEmitter($emitter);
        $this->setEmitter(null)->getEmitter()->shouldNotEqual($emitter);
    }

    public function it_should_expose_an_emitter()
    {
        $this->getEmitter()->shouldHaveType('League\Event\EmitterInterface');
    }

    public function it_should_accept_an_emitter_and_store_it(EmitterInterface $emitter)
    {
        $this->setEmitter($emitter)->shouldReturn($this);
        $this->getEmitter()->shouldReturn($emitter);
    }

    public function it_should_forward_remove_listener_calls(EmitterInterface $emitter, ListenerInterface $listener)
    {
        $emitter->removeListener('event', $listener)->shouldBeCalled();
        $this->setEmitter($emitter);
        $this->removeListener('event', $listener);
    }

    public function it_should_forward_remove_all_listeners_calls(EmitterInterface $emitter)
    {
        $emitter->removeAllListeners('event')->shouldBeCalled();
        $this->setEmitter($emitter);
        $this->removeAllListeners('event');
    }

    public function it_should_forward_add_listener_calls(EmitterInterface $emitter, ListenerInterface $listener)
    {
        $emitter->addListener('event', $listener, ListenerAcceptorInterface::P_NORMAL)->shouldBeCalled();
        $this->setEmitter($emitter);
        $this->addListener('event', $listener);
    }

    public function it_should_forward_add_one_time_listener_calls(EmitterInterface $emitter, ListenerInterface $listener)
    {
        $emitter->addOneTimeListener('event', $listener, ListenerAcceptorInterface::P_NORMAL)->shouldBeCalled();
        $this->setEmitter($emitter);
        $this->addOneTimeListener('event', $listener);
    }

    public function it_should_accept_listener_providers(EmitterInterface $emitter, ListenerProviderInterface $provider)
    {
        $this->setEmitter($emitter);
        $emitter->useListenerProvider($provider)->shouldBeCalled();
        $this->useListenerProvider($provider);
    }

    public function it_should_forward_emit_calls(EmitterInterface $emitter)
    {
        $emitter->emit('event')->shouldBeCalled();
        $this->setEmitter($emitter);
        $this->emit('event');
    }

    public function getMatchers()
    {
        return [
            'useTrait' => function ($subject, $trait) {
                return class_uses($subject, $trait);
            }
        ];
    }
}
