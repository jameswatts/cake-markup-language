Hello World
===========

The following is a detailed overview of how to create a simple *Hello World* example using the **Cake Markup Language (CakeML)**. It's recommended you read the [Quick Start](Quick-Start.md) guide before attempting this tutorial.

Controller Setup
----------------

To enable **CakeML** for your Views simply include the **Cml.Parser** component in your *$components* array, for example:

```php
public $components = array('Cml.Parser');
```

The **Cml.Parser** component also accepts a settings array, which allows you to configure the component. The setting options available are:

* **namespaces**: Defines the namespaces available in the Views
* **helpers**: Defines an array of additional Helpers to use
* **layout**: Defines the layout for **CakeML** to use in this Controller
* **ignoreAction**: Defines an array of actions to ignore, and process as legacy ".ctp" views
* **cacheAction**: Defines the actions to cache and their relevant settings
* **htmlHelper**: Defines the HTML helper to use, defaults to the core helper
* **formHelper**: Defines the form helper to use, defaults to the core helper

Creating Views
--------------

Once you've setup your Controller you can now create the Views for your actions. All **CakeML** Views are created the same as normal View, except with the ".cml" extension, for example:

```
/View/Example/test.cml
```

All *PHP* code in this View file will be ignored, and parsed as text. In order to test the plugin, write a simple **CakeML** tag in your file, for example:

```html
<cake:out value="Hello World" />
```

Rendered Output
---------------

When you've created your View file navigate to the Controller and action in the browser to see the result.

```php
/example/test
```

You should now see the standard *CakePHP* layout, with the text "Hello World". If you now view the source code of that page you'll see how the elements were created, without ever having actually written a single line of HTML.

