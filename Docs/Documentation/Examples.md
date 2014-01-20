Examples
========

The following are a few basic examples for use with the **Cake Markup Language**.

Output Content
--------------

Output a string of text to the View using the **cake** namespace.

```html
<cake:out value="Hello World" />
```

A default value can be set for when the original value is empty.

```html
<cake:out value="" default="It was empty!" />
```

Encoding of the value can also be disabled, as well as new lines converted to *HTML* line breaks.

```html
<cake:out value="&quot;Hello\nWorld&quot;" safe="false" nl2br="true" />
```

Commenting Markup
-----------------

Comment out markup using the special *comment* tags.

```html
<!--comment-->
<cake:out value="Hello World" />
<!--/comment-->
```

Setting the Layout
------------------

Change the layout for the View at runtime.

```html
<cake:layout name="default" />
```

Layouts can also be ".cml" files by setting the *renderLayout* option to *true* in the **Parser** component settings array.

Setting the Content Type
------------------------

Change the content type of the View at runtime.

```html
<cake:type value="text/plain" />
```

Using View Variables
--------------------

Include View variables with the *%{variable}* syntax.

```html
<div id="example" class="%{class}">
	Hello World
</div>
```

Arrays and objects can also be traversed using dot notation.

```html
<div class="product">
	<cake:out value="%{products.kitchen.oven}" />
</div>
```

Variables may also be injected as references, for example:

```html
<cake:out value="%{products[product.type].name}" />
```

This would use the value of *%{product.type}* as the key for *%{products}*.

Reading View variables is defined at compile time. For direct references at runtime you can use the *&{variable}* syntax. However, keep in mind that this will only be able to access variables previously defined in the Controller.

```html
<cake:element name="example" vars="['something' => &{value}]" />
```

Short array syntax is the default format for defining arrays and objects within the **CakeML** markup attributes.

```php
array('param' => 'value') -> ['param' => 'value']
```

**IMPORTANT:** View variables can be injected both in the **CakeML** markup, as well as directly in the View itself.

Debugging View Variables
------------------------

Debug a View variable within your View.

```html
<cake:debug var="example" />
```

Using Translations
------------------

Include an internationalized string with the *#{literal}* syntax.

```html
<cake:out value="#{Products}" />
```

Translations can also accept *sprintf* values sepearated by the "|" symbol. These can also be View variables.

```html
<cake:out value="#{Hello, %s|%{name}}" />
```

Translation domain can also be specified by separating the domain with a "^" symbol.

```html
<cake:out value="#{users^Hello, %s|%{name}}" />
```

Creating a Link
---------------

Create a *CakePHP* link to an internal controller and action.

```html
<cake:link url="['controller' => 'example', 'action' => 'test', 123]" value="Click me!" />
```

Create a link to an external resource with a confirm message.

```html
<cake:link url="http://cakedc.com" value="CakeDC" confirm="OK to leave this site?" />
```

**IMPORTANT:** The arguments for a link URL are specified in short array syntax.

Generating a Form
-----------------

Create a *CakePHP* form with a custom submit button.

```html
<cake:form model="Example" submit="['label' => 'Update', 'div' => ['class' => 'glass-pill']]">
	<cake:input field="Example.field" options="['type' => 'text']" />
</cake:form>
```

**IMPORTANT:** The options for forms and inputs are specified short array syntax.

Defining a View Block
---------------------

Create a View block with content.

```html
<cake:block name="example">
	This will be in my block
</cake:block>
```

You can also append or prepend to an existing View block.

```html
<cake:append name="example" value="Something more" />
```

Or by defining the content within the block itself.

```html
<cake:append name="example">
	Something else to add
</cake:append>
```

Fetching a View Block
---------------------

When fetching a View block, a default value can be used if the block is empty.

```html
<cake:fetch name="example" />
```

When fetching a View block, a default value can be used if the block is empty.

```html
<cake:fetch name="example" default="Hello World" />
```

Additionally, the result from a View block can be stored in a View variable.

```html
<cake:fetch name="example" default="Hello World" set="block" />

<cake:out value="%{block}" />
```

Embedding an Element
--------------------

Add an element to the View, passing arguments with View variables.

```html
<cake:element name="example" vars="['name' => %{name}]" />
```

**IMPORTANT:** The arguments for an element are specified in short array syntax.

Elements can also be ".cml" files via the *parse* attribute set to "true", or by setting the *renderElement* option to *true* in the **Parser** component settings array. Using the *renderElement* setting will affect elements globally, which can be countered by setting the *parse* attribute to "false" to revert back to using a normal ".ctp" file on a specific element.

Using a Helper
--------------

Properties of a helper can be accessed via the *get* attribute of the **helper** element.

```html
<cake:helper name="Form" get="requestType" />
```

Methods on helpers can also be called via the *call* attribute, optionally passing arguments.

```html
<cake:helper name="Html" call="image" args="['/img/example.jpg', ['alt' => 'Hello World']]" />
```

Additionally, the result from a helper can be stored in a View variable.

```html
<cake:helper name="Example" call="getSomething" set="something" />

<cake:out value="%{something}" />
```

**IMPORTANT:** The arguments for a helper method are specified in short array syntax.

Defining Variables
------------------

Variables can be defined by using the **var** element using the **php** namespace.

```html
<php:var name="example" expr="'Hello World'" />
```

As the value is a *string* it must be defined with quotes in the *expr* attribute, otherwise a *constant* is assumed.

**IMPORTANT:** It is generally bad practice to define variables in the View, with the preference being that they are always defined or resolved previously in the Controller.

If, Elseif and Else
-------------------

Conditional **if**, **elseif** and **else** statements allow logical expressions and checks.

```html
<php:if expr="%{test} === 1">
	You chose number 1
<php:elseif expr="%{test} &gt; 1" />
	You chose a number greater than 1
<php:else />
	You chose a number less than 1
</php:if>
```

Switch Statements
-----------------

The **switch** statement is constructed very similar to *PHP* syntax.

```html
<php:switch var="test">
	<php:case expr="1">
		You chose number 1
		<php:break />
	</php:case>
	<php:case expr="2">
		You chose number 2
		<php:break />
	</php:case>
	<php:default>
		You chose another number
	</php:default>
</php:switch>
```

**IMPORTANT:** The **break** statements act as in *PHP*, allowing you to cascade **cases** in their absence.

Index Based Loop Statement
--------------------------

Create a simple **for** loop.

```html
<php:for var="products">
	<cake:out value="Product %{COUNT}. %{VALUE}" />
</php:for>
```

Create custom View variables and set a specific index to start at.

```html
<php:for var="products" index="i" value="name" start="3">
	<cake:out value="Product: %{name}" />
</php:for>
```

Display a default value when the View varibale is empty.

```html
<php:for var="products" default="No products available">
	<cake:out value="Product %{COUNT}. %{VALUE}" />
</php:for>
```

**IMPORTANT:** The **for** loops automatically create the View variables *INDEX*, *VALUE* and *COUNT*.

Member Based Loop Statement
---------------------------

Create a simple **foreach** loop.

```html
<php:foreach var="clients">
	<cake:out value="%{COUNT}. %{KEY}: %{VALUE}" />
</php:foreach>
```

Create custom View variables for the key and value.

```html
<php:foreach var="clients" key="code" value="client">
	<cake:out value="%{COUNT}. %{code}: %{client}" />
</php:foreach>
```

Display a default value when the View varibale is empty.

```html
<php:foreach var="clients" default="No clients found">
	<cake:out value="%{COUNT}. %{KEY}: %{VALUE}" />
</php:foreach>
```

**IMPORTANT:** The **foreach** loops automatically create the View variables *KEY*, *VALUE* and *COUNT*.

