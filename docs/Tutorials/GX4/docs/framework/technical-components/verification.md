## VerificationService

The `VerificationService` is responsible for verifying whether two arrays contain the same data.
If the second array differs in any way from the first array, all the differences will be
recorded as `VerificationExceptions` and collected in a `VerificationExceptionStack`.
This service is provided through the [DI Container].

The `VerificationExceptionStack` can contain the following types of `VerificationExceptions`:

* `ArrayLengthNotMatchingException`
* `TypeNotMatchingException`
* `ValueMissingException`
* `ValueNotMatchingException`

The `VerificationService` provides three reporting modes:

1) **Log Reporting Mode**: Writes the stack to a log file.
2) **Print Reporting Mode**: Prints a formatted version of the stack.
3) **Transmission Reporting Mode**: Sends data to Gambio's Sentry, if the administrator has consented to sending error reports.

By default, the log reporting mode is enabled.

---

## Verification

### `verify()` Method

The `verify()` method in the `VerificationService` is used to compare and validate arrays of expected and actual values. 
It accepts the following parameters:

1) **expected** (`array`): The array of expected values.
2) **actual** (`array`): The array of actual values to be compared against the expected values.
 
It compares the expected and actual arrays and gathers all the differences, if any, in a `VerificationExceptionStack`. If any difference is spotted, 
a `VerificationExceptionStack` is thrown, which contains all the detected differences.

The `verify()` method in the `VerificationService` performs the following checks:

* It compares the length of the expected and actual arrays and adds an `ArrayLengthNotMatchingException` if they are not equal.
* It iterates through the keys of the expected array and checks if each key exists in the actual array. If a key is missing, it adds a `ValueMissingException`.
* It validates the contents of the values at the corresponding keys in the expected and actual arrays. If the contents do not match, a `ValueNotMatchingException` is added.
* If the contents of an object are being compared, it validates if the content of the objects is identical 
using a loose comparison (**==**). If the objects are not identical, a `ValueNotMatchingException` is added.
---
## Reporting

### `report()` Method

The `VerificationService` provides a `report()` method to handle the reporting 
of a `VerificationExceptionStack`. This method allows you to report the collected
`VerificationExceptions` along with additional context and specify a module name for the report.


The `report()` method is used to report a `VerificationExceptionStack`. It accepts 
the following parameters:

1) stack (`VerificationExceptionStack`): The `VerificationExceptionStack` object 
containing the collected verification exceptions.
2) context (`array|stdClass`, optional): Additional context for the report, 
such as custom information related to the verification process. 
This parameter can be an array or an stdClass object.
3) module (`string`, optional):  The name of the module being reported on. 
If provided, it will be used to differentiate the reports and will also be used as the logfile name. 
If not provided, the default value is set to "VerificationService".

Internally, the `VerificationService` maintains a cache system to ensure that each report is logged or transmitted at most
once within a 24-hour period, preventing excessive duplication of reports.

It's important to note that the `report()` method handles the reporting based 
on the enabled reporting modes.

---

Now that you have a clear understanding of the `verify()` and `report()` method and its parameters, 
let's explore some code samples to see how it can be used in practice.

## Code Samples

### Checking if a reporting mode is currently enabled

```php
/** @var \Gambio\Core\Verification\Service\VerificationService $service */
if ($service->isModeLogEnabled()) {
    // do something ... 
}

if ($service->isModePrintEnabled()) {
    // do something ... 
}

if ($service->isModeTransmissionEnabled()) {
    // do something ... 
}
```

### Enabling reporting mode's

```php
/** @var \Gambio\Core\Verification\Service\VerificationService $service */
$service->enableModeLog();
$service->enableModePrint();
$service->enableModeTransmission(); //  Should only be enabled by Gambio for exception transmission
```

### Disabling reporting mode's

```php
/** @var \Gambio\Core\Verification\Service\VerificationService $service */
$service->disableModeLog();
$service->disableModePrint();
$service->disableModeTransmission();
```

### Verifying and reporting

```php
$expected = ['a' => 1, 'b' => 2, 'c' => true];
$actual   = ['a' => 1, 'b' => 2, 'c' => false];

/** @var \Gambio\Core\Verification\Service\VerificationService $service */
try {
    $service->verify($expected, $actual);
} catch (\Gambio\Core\Verification\Service\Exceptions\VerificationExceptionStack $stack) {
    $customContext = ['timestamp' => time()];
    $moduleName    = 'MyVerificationModule';
    $service->report($stack, $customContext, $moduleName);
}
```