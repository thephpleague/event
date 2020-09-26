<?php

declare(strict_types=1);

namespace League\Event;

use LogicException;
use Psr\EventDispatcher\ListenerProviderInterface;

class UnableToSubscribeListener extends LogicException
{
    public static function becauseTheListenerProviderDoesNotAcceptListeners(
        ListenerProviderInterface $configuredListenerProvider
    ): UnableToSubscribeListener {
        $providerClass = get_class($configuredListenerProvider);

        return new UnableToSubscribeListener(
            "Unable to add listener because the configured listener provider {$providerClass} is not an instance of "
            . ListenerAcceptor::class
        );
    }
}
