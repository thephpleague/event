<?php

namespace spec\League\Event;

use Interop\Container\ContainerInterface;
use League\Event\EventInterface;
use League\Event\LazyListener;
use League\Event\ListenerInterface;
use League\Event\Stub\ContainerException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin LazyListener
 */
class LazyListenerSpec extends ObjectBehavior
{
    /**
     * @var string
     */
    private $alias;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function let(ContainerInterface $container)
    {
        $alias = 'foo';

        $this->beConstructedWith($alias, $container);

        $this->alias = $alias;
        $this->container = $container;
    }

    public function it_implements_the_listener_interface()
    {
        $this->shouldHaveType('League\Event\ListenerInterface');
    }

    public function it_throws_an_exception_when_container_does_not_provide_listener(EventInterface $event)
    {
        $this->container->get($this->alias)->willThrow(new ContainerException());

        $this->shouldThrow('BadMethodCallException')->duringHandle($event);
    }

    public function it_throws_an_exception_when_listener_is_not_correct_type(EventInterface $event)
    {
        $this->container->get($this->alias)->willReturn(new \stdClass());

        $this->shouldThrow('BadMethodCallException')->duringHandle($event);
    }

    public function it_lets_actual_listener_handle_an_event(EventInterface $event, ListenerInterface $actualListener)
    {
        $this->container->get($this->alias)->willReturn($actualListener);

        $actualListener->handle($event)->shouldBeCalled();

        $this->handle($event);
    }

    public function it_fetches_actual_listener_only_once_when_handling_events(
        EventInterface $event,
        ListenerInterface $actualListener
    ) {
        $this->container->get($this->alias)->willReturn($actualListener)->shouldBeCalledTimes(1);

        $this->handle($event);
        $this->handle($event);
    }

    public function it_identifies_as_itself()
    {
        $this->container->get($this->alias)->shouldBeCalledTimes(0);

        $this->isListener($this->getWrappedObject())->shouldReturn(true);
    }

    public function it_does_not_identify_as_actual_listener_when_it_has_not_been_fetched_yet(ListenerInterface $actualListener)
    {
        $this->container->get($this->alias)->shouldBeCalledTimes(0);

        $this->isListener($actualListener)->shouldReturn(false);
    }

    public function it_identifies_as_actual_listener_when_it_has_been_fetched(EventInterface $event, ListenerInterface $actualListener)
    {
        $this->container->get($this->alias)->willReturn($actualListener)->shouldBeCalledTimes(1);

        $this->handle($event);

        $this->isListener($actualListener)->shouldReturn(true);
    }
}
