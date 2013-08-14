Debugging
=========

The **Cake Markup Language** provides 2 options to debug your View at both runtime and compile time. These allow you to inspect your View as well as the View variables passed from the Controller.

Runtime
-------

The **cake** namespace provides a **debug** tag, which allows you to output the content of a View variable the same way you would with the **debug()** function.

To use it, simply add it to your View and specify the name of the View variable to inspect, for example:

```html
<cake:debug var="example" />
```

This will then output the value of the View variable in a readable format.

Compile Time
------------

It's also possible to hault the **CakeML** parser at compile time, therefore allowing you to see the compiled View before it's processed by the *PHP* interpreter.

To enable the compile time debugger set the "debug" setting of the **Cml.Parser** component to *true* in your Controller, for example:

```php
public $components = array(
	'Cml.Parser' => array(
		'debug' => true
	)
);
```

This will output the raw View before processing, including the parsed **CakeML** markup.

When the compile time debugger is enabled and an error occurs, this is specified in the debugger output. If the origin of the error is the View itself the line number of the code will also be highlighted. These line numbers can also be manually selected, to easily pass line number references as a URL.

