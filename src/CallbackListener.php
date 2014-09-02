<?php

namespace League\Event;

class CallbackListener implements ListenerInterface
{
    /**
     * The callback.
     *
     * @var callable
     */
    protected $callback;

    /**
     * Create a new instance.
     *
     * @param callable $callback
     *
     * @return void
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * Get the callback.
     *
     * @return callable
     */
    public function getCallback()
    {
        return $this->callback;
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
        call_user_func_array($this->callback, func_get_args());
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
        if ($listener instanceof CallbackListener) {
            $listener = $listener->getCallback();
        }

        return $this->callback === $listener;
    }
}
