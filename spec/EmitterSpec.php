<?php

namespace spec\League\Event;

use League\Event\CallbackListener;
use League\Event\Event;
use League\Event\GeneratorInterface;
use League\Event\ListenerInterface;
use League\Event\ListenerProviderInterface;
use League\Event\Stub\Listener;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EmitterSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('League\Event\Emitter');
        $this->shouldHaveType('League\Event\EmitterInterface');
    }

    public function it_should_accept_listeners()
    {
        $this->addListener('event', function () {})
            ->shouldReturn($this);

        $this->hasListeners('event')->shouldReturn(true);
    }

    public function it_should_use_providers_to_add_listeners(ListenerProviderInterface $provider)
    {
        $provider->provideListeners(Argument::type('League\Event\ListenerAcceptorInterface'))->shouldBeCalled();
        $this->useListenerProvider($provider)->shouldBe($this);
    }

    public function it_should_should_expose_when_an_event_has_listeners()
    {
        $this->addListener('event', function () {});
        $this->hasListeners('event')->shouldReturn(true);
    }

    public function it_should_should_expose_when_an_event_has_no_listeners()
    {
        $this->hasListeners('event')->shouldReturn(false);
    }

    public function it_should_allow_you_to_remove_listeners()
    {
        $callback = function () {};
        $this->addListener('event', $callback);
        $this->addListener('event', $listener = new Listener());
        $this->getListeners('event')->shouldHaveCount(2);
        $this->removeListener('event', $callback);
        $this->getListeners('event')->shouldHaveCount(1);
    }

    public function it_should_allow_you_to_remove_multiple_listeners_at_once()
    {
        $callback = function () {};
        $this->addListener('event', $callback);
        $this->addListener('event', $callback);
        $this->removeAllListeners('event');
        $this->hasListeners('event')->shouldReturn(false);
    }

    public function it_should_throw_an_exception_when_registering_an_invalid_listener()
    {
        $this->shouldThrow('InvalidArgumentException')
            ->duringAddListener('event', 'invalid@callback');
    }

    public function it_should_return_an_empty_array_when_an_event_has_no_listeners()
    {
        $this->getListeners('event')->shouldReturn([]);
    }

    public function it_should_allow_you_to_emit_plain_events()
    {
        $callback = CallbackListener::fromCallable(function () {});
        $this->addListener('event', $callback)->shouldReturn($this);
        $this->emit('event')->shouldReturnAnInstanceOf('League\Event\Event');
    }

    public function it_should_allow_you_to_emit_event_instances(Event $event)
    {
        $event->setEmitter($this)->shouldBeCalled();
        $event->getName()->willReturn('event');
        $event->isPropagationStopped()->willReturn(false);
        $callback = function ($event) {};
        $this->addListener('event', $callback);
        $this->emit($event)->shouldReturn($event);
    }

    public function it_should_allow_batch_emitting(Event $event, ListenerInterface $listener)
    {
        $event->getName()->willReturn('event');
        $event->setEmitter($this)->shouldBeCalled();
        $event->isPropagationStopped()->willReturn(false);
        $listener->handle($event)->shouldBeCalled();
        $this->addListener('event', $listener);
        $this->emitBatch([$event])->shouldReturn([$event]);
    }

    public function it_should_stop_respond_to_stopping_propagation(Event $event)
    {
        $event->setEmitter($this)->shouldBeCalled();
        $event->getName()->willReturn('event');
        $event->isPropagationStopped()->willReturn(true);
        $callback = function ($event) {};
        $this->addListener('event', $callback);
        $this->emit($event)->shouldReturnAnInstanceOf('League\Event\Event');
    }

    public function it_should_throw_an_exception_when_an_invalid_event_type_is_supplied()
    {
        $this->shouldThrow('InvalidArgumentException')
            ->duringEmit(true);
    }

    public function it_should_accept_custom_listeners(ListenerInterface $listener)
    {
        $this->addListener('event', $listener);
        $this->getListeners('event')->shouldContain($listener);
    }

    public function it_should_handle_one_time_listeners()
    {
        $listener = new Listener();
        $this->addOneTimeListener('event', $listener);
        $this->getListeners('event')->shouldContainInstanceOfType('League\Event\OneTimeListener');
        $this->getListeners('event')->shouldNotContain($listener);
        $this->getListeners('event')->shouldHaveCount(1);
        $this->emit('event');
        $this->getListeners('event')->shouldHaveCount(0);
    }

    public function it_should_allow_an_any_listener(ListenerInterface $listener)
    {
        $event = Event::named('event');
        $this->addListener('*', $listener);
        $listener->handle($event)->shouldBeCalled();
        $this->emit($event);
    }

    public function it_should_prioritize_listeners(CallbackListener $first, CallbackListener $second)
    {
        $this->addListener('event', $first, 0);
        $this->addListener('event', $second, 50);
        $this->getListeners('event')->shouldReturn([$second, $first]);
    }

    public function it_should_emit_generator_events(GeneratorInterface $generator, ListenerInterface $listener)
    {
        $event = new Event('name');
        $this->addListener($event->getName(), $listener);
        $listener->handle($event)->shouldBeCalled();
        $generator->releaseEvents()->willReturn([$event]);
        $this->emitGeneratedEvents($generator)->shouldReturn([$event]);
    }

    public function getMatchers()
    {
        return [
            'containInstanceOfType' => function ($subject, $interface) {
                foreach ($subject as $value) {
                    if ($value instanceof $interface) {
                        return true;
                    }
                }

                return false;
            },
        ];
    }
}
