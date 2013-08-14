PHP Namespace
=============

The **php** namespace contains tags providing *PHP* language syntax and constructs.

To use the **php** namespace in a View include it in the *$namespaces* setting of the **Cml.Parser** component, for example:

```php
public $components = array(
	'Cml.Parser' => array(
		'namespaces' => array(
			'Cml.Php'
		)
	)
);
```

Once the namespace is available you can access the tags it provides. To use a tag, specify the namespace, followed by the ":" symbol, and then the tag name, for example:

```html
<php:if expr="%{value} === true">
	<span>Hello World</span>
</php:if>
```

The tags available from the **php** namespace are the following:

* [break](Php/Break.md) - Defines a break statement for a case or loop.
* [case](Php/Case.md) - Defines a case for a switch condition.
* [continue](Php/Continue.md) - Defines a continue statement for a loop.
* [default](Php/Default.md) - Defines the default case for a switch condition.
* [echo](Php/Echo.md) - Defines a raw output.
* [else](Php/Else.md) - Defines the alternate outcome of a conditional expression.
* [elseif](Php/Elseif.md) - Defines a subsequent conditional expression.
* [for](Php/For.md) - Defines an index based loop statement.
* [foreach](Php/Foreach.md) - Defines a member based loop statement.
* [if](Php/If.md) - Defines a conditional espression.
* [switch](Php/Switch.md) - Defines a switch condition.
* [var](Php/Var.md) - Defines a variable declaration.
* [while](Php/While.md) - Defines a conditional loop.

