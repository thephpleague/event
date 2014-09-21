# Changelog


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

- Listener invovation is now responsible for retrieving the events attached to an event name. [internal]


## 0.3.0 - 23-08-2014

### Added

- EmitterInterface: an interface is derived from the Emitter class to allow more flexible type hinting and custom implementations. All the code expecting an Emitter now expect an EmitterInterface implementation.
