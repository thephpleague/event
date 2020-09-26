<?php
declare(strict_types=1);

namespace League\Event;

class OneTimeListener implements ListenerInterface, EmitterAwareInterface
{
    use EmitterAwareBehaviour;

    /**
     * The listener instance.
     *
     * @var ListenerInterface
     */
    protected $listener;

    /**
     * Create a new one time listener instance.
     *
     * @param ListenerInterface $listener
     * @param EmitterInterface  $emitter
     */
    public function __construct(ListenerInterface $listener, EmitterInterface $emitter)
    {
        $this->listener = $listener;
        $this->setEmitter($emitter);
    }

    /**
     * Get the wrapped listener.
     *
     * @return ListenerInterface
     */
    public function getWrappedListener()
    {
        return $this->listener;
    }

    /**
     * @inheritdoc
     */
    public function handle($event)
    {
        $name = $event instanceof HasEventNameInterface
            ? $event->getName()
            : get_class($event);
        $this->getEmitter()->removeListener($name, $this->listener);

        return call_user_func_array([$this->listener, 'handle'], func_get_args());
    }

    /**
     * @inheritdoc
     */
    public function isListener($listener)
    {
        if ($listener instanceof OneTimeListener) {
            $listener = $listener->getWrappedListener();
        }

        return $this->listener->isListener($listener);
    }
}
