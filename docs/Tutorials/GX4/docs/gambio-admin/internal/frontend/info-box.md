# Gambio Admin - Info Box

The InfoBox library provides an API to push messages to the GambioAdmin info box. The range of functions is currently
small, but it will be further expanded in the future and adapted to requirements.

## Importing InfoBox module

Due to the build process setup, we can import the InfoBox module from the `core/InfoBox` namespace.

```ts
import InfoBox from 'core/InfoBox';
```

## Using InfoBox module

To use the InfoBox module, we have to initialize the `InfoBox` class. There is a named constructor function `::create`
that will initialize the InfoBox module with all dependencies.  
Afterwards, we can use the `::notifySuccess`, `::notifyInfo` and `::notifyWarning` methods to push messages to the
GambioAdmin info box.

```ts
const infoBox = InfoBox.create();

infoBox.notifySuccess('Success message');
infoBox.notifySuccess('Success message', 'Optional headline');

infoBox.notifyInfo('Info message', 'Info headline');

infoBox.notifyWarning('Warning message', 'Warning headline');
```

