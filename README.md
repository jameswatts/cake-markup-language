Cake Markup Language (CakeML)
=============================

The **Cake Markup Language** is a *CakePHP* plugin which provides abstraction of the View layer by replacing procedural *PHP* code with an *XML* based markup.

Using **CakeML** helps keep your View code clean and organized, while also maintaining a strict *MVC* convention by limiting application logic in the View layer.

The main features of the plugin include:

* **Familiar Syntax:** The syntax used for the **CakeML** markup is identical to that used for *XHTML*, so there's no new formatting or patterns to learn, and any IDE or code editor capable of highlighting *XML* will also do so for your View files.
* **Ready for Designers:** Due to the common syntax your View files become even more accessible to designers and non-developers, allowing them to introduce code themselves without any previous technical knowledge.
* **Simple Templating:** The plugin provides basic template logic out-of-the-box, such as if/elseif/else conditional statements, foreach loops and switches, as well as the View blocks already available in *CakePHP* for creating dynamic content.
* **Internal Debugging:** By enabling debug mode on the Parser component you can quickly review the compiled View before it's processed, giving you a clear idea of the generated code before it's rendered as the output.
* **Extensible by Design:** As the markup tags used in **CakeML** are grouped together under a common namespace, you can easily import your own custom or *third-party* namespaces from a *CakePHP* plugin, allowing you to reuse tags in other applications.
* **Plug and Play:** Using the plugin is as simple as including the Parser component, which doesn't limit you from still using the normal ".ctp" files, as you can even use both formats for different Views in the same Controller.
* **Compatibility:** All of the View features currently in *CakePHP* are still available, such as *themes*, *layouts*, *elements*, *content blocks* and *helpers*.

To start using the **Cake Markup Language** it's as easy as including the *ParserComponent* from the plugin in your Controller, for example:

```php
public $components = array(
	'Cml.Parser' => array(
		'ignoreAction' => array('example') // allow "example" action to continue using "example.ctp"
	)
);
```

View files using **CakeML** are saved with the ".cml" extension, differenciating them from standard ".ctp" templates. To create a view, simply include the **CakeML** markup along with your static *HMTL*, *CSS* and *JavaScript* client code.

```html
<div id="example">
	<cake:out value="Hello World" />
</div>
```

You can also use conditional statements with the **php** namespace, as well as View variables, to create dynamic content. For example, by setting ```$this->set("text", "Hello World");``` from your Controller, you can then read it in the View using ```%{variable}```, also displaying it conditionally with the following:

```html
<php:if expr="!empty(%{text})">
	<cake:out value="%{text}" />
<php:else />
	<cake:out value="Nothing here" />
</php:if>
```

However, the same can also be acheived by just using the *default* attribute:

```html
<cake:out value="%{text}" default="Nothing here" />
```

More complex operations include **for**, **foreach** and **while** loops, which provide the ability of rapid templating, including automatic variable declaration.

```html
<php:foreach var="products">
	<cake:out value="%{COUNT}. %{KEY} = &quot;%{VALUE}&quot;" safe="true" />
</php:foreach>
```

The **cake** namespace also provides many tags for common usage, such as including *elements*, for example:

```html
<cake:element name="" options="['example' => %{value}]" />
```

You can also easily create *links*, which in the following examples use ```#{literal}``` to load a translated string, as well as including additional *HTML* content.

```html
<cake:link value="#{Read more}" url="['controller' => 'Posts', 'action' => 'view', %{postId}]" />

<cake:link url="['controller' => 'Posts', 'action' => 'view', %{postId}]">
	<span>#{Read more}</span>
</cake:link>
```

Probably the most important feature is forms, which can also be generated quickly.

```html
<cake:form model="Example" submit="#{Send}" options="['action' => 'add']">
	<cake:input field="Example.column" options="['type' => 'number']" />
</cake:form>
```

The **cake** namespace also allows you to access any core or *third-party* helper, which means no change is needed to use your existing helpers.

```html
<cake:helper name="Helper" get="property" />

<cake:helper name="Helper" call="method" args="['Hello World']" set="returnValue" />
<cake:out value="%{HtmlDiv}" safe="0" />
```

To get working quickly check out the [Quick Start](Docs/Tutorials/Quick-Start.md) or [Hello World](Docs/Tutorials/Hello-World.md) tutorials from the [documentation](Docs/Home.md).

Requirements
------------

* CakePHP 2+
* PHP 5.3+

Documentation
-------------

Full documentation is included with the plugin, and can be found in the [Docs](Docs/Home.md) directory of this repository.

Support
-------

For support, bugs and feature requests, please use the [issues](https://github.com/jameswatts/cake-markup-language/issues) section of this repository.

Contributing
------------

If you'd like to contribute new features, enhancements or bug fixes to the code base just follow these steps:

* Create a [GitHub](https://github.com/signup/free) account, if you don't own one already
* Then, [fork](https://help.github.com/articles/fork-a-repo) the [Cake Markup Language](https://github.com/jameswatts/cake-markup-language) repository to your account
* Create a new [branch](https://help.github.com/articles/creating-and-deleting-branches-within-your-repository) from the *develop* branch in your forked repository
* Modify the existing code, or add new code to your branch, making sure you follow the [CakePHP Coding Standards](http://book.cakephp.org/2.0/en/contributing/cakephp-coding-conventions.html)
* Modify or add [unit tests](http://book.cakephp.org/2.0/en/development/testing.html) which confirm the correct functionality of your code (requires [PHPUnit](http://www.phpunit.de/manual/current/en/installation.html) 3.5+)
* Consider using the [CakePHP Code Sniffer](https://github.com/cakephp/cakephp-codesniffer) to check the quality of your code
* When ready, make a [pull request](http://help.github.com/send-pull-requests/) to the main repository

There may be some discussion reagrding your contribution to the repository before any code is merged in, so be prepared to provide feedback on your contribution if required.

A list of contributors to the **Cake Markup Language** can be found [here](https://github.com/jameswatts/cake-markup-language/contributors).

Licence
-------

Copyright 2013 James Watts (CakeDC). All rights reserved.

Licensed under the MIT License. Redistributions of the source code included in this repository must retain the copyright notice found in each file.

Acknowledgements
----------------

A special thanks to [Larry Masters](https://github.com/phpnut), the founder of [CakePHP](http://cakephp.org), as well as the entire [CakeDC](http://cakedc.com) team for their feedback and support.

