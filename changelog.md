# Changelog

## 2.1.1 - 2015-03-30

# Altered

- __Emitter::emitBatch__ now uses a foreach instead of array map to allow better exception handling.

## 2.1.0 - 2015-02-12

### Added

- EmitterAwareInterface: an interface to be EmitterInterface aware.
- EmitterAwareTrait: a default implementation to EmitterAwareInterface

### Changed

- EmitterTrait: The EmitterAware interface was extracted from this, which it now uses.

## 2.0.0 - 2014-12-09

### Added

- EventInterface: an interface is derived from the AbstractEvent class to allow more flexible type hinting and custom implementations. All the code expecting an AbstractEvent now expect an EventInterface implementation, however AbstractEvent covers the most use cases.
- Event::named: named construtor to create string based events
- CallbackListener::fromCallable: create a callback listener from a callable.
- ListenerAcceptorInterface: An interface (distilled from the EmitterInterface) to only focus on accepting listeners.
- ListenerProviderInterface: An interface to focus on providing the Emitter with new listeners.
- EmitterInterface::useListenerProvider: Allows you to use an implementation of the ListenerProviderInterface to add listeners.
- EmitterInterface::releaseGeneratedEvents: Eases the way events are released from GeneratorInterface implementations.

### Altered

- All event typehints have been changed from AbstractEvent to EventInterface

### Removed

- PriorityEmitter: this functionality is now part of the standard emitter.

## 1.0.0 - 2014-10-09

### Altered

- The Emitter now checks if propagation has been stopped before invoking the first listener.
- Renamed ListenerAbstract to AbstractListener


## 0.3.1 - 06-09-2014

### Added

- Wildcard listeners: When specifying `*` as the event name to listen to it will listen to all events. Wildcard listeners will be invoked AFTER named event listeners.

### Fixed

- Various code style fixes.
- Corrected priority emitter sorting.

### Altered

- Listener invocation is now responsible for retrieving the events attached to an event name. [internal]


## 0.3.0 - 23-08-2014

### Added

- EmitterInterface: an interface is derived from the Emitter class to allow more flexible type hinting and custom implementations. All the code expecting an Emitter now expect an EmitterInterface implementation.
