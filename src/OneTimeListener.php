<?php

namespace League\Event;

class OneTimeListener implements ListenerInterface
{
    /**
     * The listener instance.
     *
     * @var ListenerInterface
     */
    protected $listener;

    /**
     * Create a new instance.
     *
     * @param ListenerInterface $listener
     *
     * @return void
     */
    public function __construct(ListenerInterface $listener)
    {
        $this->listener = $listener;
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
     * Handle an event.
     *
     * @param AbstractEvent $event
     *
     * @return void
     */
    public function handle(AbstractEvent $event)
    {
        $name = $event->getName();
        $emitter = $event->getEmitter();
        $emitter->removeListener($name, $this->listener);

        return call_user_func_array([$this->listener, 'handle'], func_get_args());
    }

    /**
     * Check weather the listener is the given parameter.
     *
     * @param mixed $listener
     *
     * @return bool
     */
    public function isListener($listener)
    {
        if ($listener instanceof OneTimeListener) {
            $listener = $listener->getWrappedListener();
        }

        return $this->listener->isListener($listener);
    }
}
