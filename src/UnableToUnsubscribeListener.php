<?php

declare(strict_types=1);

namespace League\Event;

use LogicException;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;

class UnableToUnsubscribeListener extends LogicException
{
    public static function becauseTheListenerProviderIsNotARegistry(
        ListenerProviderInterface $configuredListenerProvider
    ): UnableToUnsubscribeListener {
        $providerClass = get_class($configuredListenerProvider);

        return new UnableToUnsubscribeListener(
            "Unable to remove listener because the configured listener provider {$providerClass} is not an instance of "
            . ListenerRegistry::class
        );
    }
    public static function becauseTheEventDispatcherIsNotARegistry(
        EventDispatcherInterface $configuredListenerProvider
    ): UnableToUnsubscribeListener {
        $providerClass = get_class($configuredListenerProvider);

        return new UnableToUnsubscribeListener(
            "Unable to remove listener because the internal dispatcher {$providerClass} is not an instance of "
            . ListenerRegistry::class
        );
    }
}
