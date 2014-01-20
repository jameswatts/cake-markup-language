Hello World
===========

The following is a detailed overview of how to create a simple *Hello World* example using the **Cake Markup Language (CakeML)**. It's recommended you read the [Quick Start](Quick-Start.md) guide before attempting this tutorial.

Controller Setup
----------------

To enable **CakeML** for your Views simply include the [Cml.Parser](../../Controller/Component/ParserComponent.php) component in your *$components* array, for example:

```php
public $components = array('Cml.Parser');
```

The **Cml.Parser** component also accepts a settings array, which allows you to configure the component. The setting options available are:

* **namespaces**: Defines an array of namespaces available in the Views
* **helpers**: Defines an array of additional Helpers to include
* **layout**: Defines the layout for **CakeML** to use in this Controller
* **ignoreAction**: Defines an array of actions to ignore, and process as legacy ".ctp" views
* **cacheAction**: Defines the actions to cache and their relevant settings
* **loadConfigure**: If *true*, additionally looks in Configure for View variables
* **loadSession**: If *true*, additionally looks in the session for View variables
* **debug**: If *true*, the internal [debug](../Documentation/Debugging.md) mode will be enabled
* **renderLayout**: If *true*, specifies that all layouts will be ".cml" files
* **renderElement**: If *true*, specifies that all elements will be ".cml" files
* **htmlHelper**: Defines the HTML helper to use, defaults to the core helper
* **formHelper**: Defines the form helper to use, defaults to the core helper
* **paginatorHelper**: Defines the paginator helper to use, defaults to the core helper
* **jsHelper**: Defines the JavaScript helper to use, defaults to the core helper
* **textHelper**: Defines the text helper to use, defaults to the core helper
* **numberHelper**: Defines the number helper to use, defaults to the core helper
* **timeHelper**: Defines the time helper to use, defaults to the core helper
* **cacheHelper**: Defines the cache helper to use, defaults to the core helper

Creating Views
--------------

Once you've setup your Controller you can now create the Views for your actions. All **CakeML** Views are created the same as normal View files, except with the ".cml" extension, for example:

```
/View/Example/test.cml
```

All *PHP* code in this View file will be ignored, and parsed as text. In order to test the plugin, write a simple **CakeML** tag in your file, for example:

```html
<cake:out value="Hello World" />
```

If you're using an IDE or an editor with syntax highlighting, you'll immediately appreciate the formatting of the markup.

Rendered Output
---------------

When you've created your View file, navigate to the Controller and action in the browser to see the result.

```php
/example/test
```

You should now see the standard *CakePHP* layout, with the text "Hello World".

Layouts and Elements
--------------------

Through the settings of the **Cml.Parser** component, both *layouts* and *elements* can also use ".cml" files. This means that the framework can resolve these as static **CakeML** markup, while ignoring all *PHP* code. Layouts can only have this option set globally, meaning that either all of your layouts are ".cml" files with **CakeML** markup, or normal ".ctp" files with *PHP* code. However, although this global setting exists for elements, affecting all elements, these can also be controlled from the markup itself.

```html
<cake:element name="example" parse="true" />
```

By setting the *parse* attribute to *true* the element will use a ".cml" file, instead of a ".ctp" file, interpreting it as static **CakeML** markup, and not *PHP* code. If the global *renderElement* setting has been defined as *true*, setting the *parse* attribute to *false* would have the reverse effect, instead forcing the element to use a ".ctp" file.

```html
<cake:element name="example" parse="false" />
```

For this, you would create your file with a ".cml" extension, for example:

```
app/View/Elements/example.cml
```

This is the same for layout files, which may also be interpreted as **CakeML** markup.

