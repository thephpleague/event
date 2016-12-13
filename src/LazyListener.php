<?php

namespace League\Event;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;

class LazyListener implements ListenerInterface
{
    /**
     * @var string
     */
    private $alias;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var ListenerInterface
     */
    private $listener;

    public function __construct($alias, ContainerInterface $container)
    {
        $this->alias = $alias;
        $this->container = $container;
    }

    public function handle(EventInterface $event)
    {
        $this->getListener()->handle($event);
    }

    /**
     * @return ListenerInterface
     */
    private function getListener()
    {
        if ($this->listener === null) {
            try {
                $listener = $this->container->get($this->alias);
            } catch (ContainerException $exception) {
                throw new \BadMethodCallException(sprintf(
                    'Could not fetch listener with alias "%s" from container',
                    $this->alias
                ));
            }

            if (!$listener instanceof ListenerInterface) {
                throw new \BadMethodCallException(sprintf(
                    'Service with alias "%s" does not implement the ListenerInterface',
                    $this->alias
                ));
            }

            $this->listener = $listener;
        }

        return $this->listener;
    }

    public function isListener($listener)
    {
        if ($listener instanceof LazyListener) {
            return $this === $listener;
        }

        if ($this->listener !== null) {
            return $this->listener === $listener;
        }

        return false;
    }

    /**
     * @param string             $alias
     * @param ContainerInterface $container
     * @return static
     */
    public static function fromAlias($alias, ContainerInterface $container)
    {
        return new static($alias, $container);
    }
}
