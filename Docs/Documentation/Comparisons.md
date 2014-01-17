Comparisons
===========

The following are a few comparisons of the **Cake Markup Language** versus standard code in *CakePHP*.

Output
------

Output an escaped string of text.

```html
<cake:out value="Hello World" />
```

```php
<?php echo h('Hello World'); ?>
```

Output a View variable.

```html
%{example}
```

```php
<?php echo $example; ?>
```

Output a translation literal.

```html
#{Hello World}
```

```php
<?php echo __('Hello World'); ?>
```

Output a domain specific translation literal.

```html
#{example^Hello World}
```

```php
<?php echo __d('example', 'Hello World'); ?>
```

Links
-----

Create a link to a Controller and action.

```html
<cake:link url="['controller' => 'example', 'action' => 'test', 123]" value="#{Click here}" />
```

```php
<?php echo $this->Html->link(__('Click here'), array('controller' => 'example', 'action' => 'test', 123)); ?>
```

Create a link with an image.

```html
<cake:link url="['controller' => 'example', 'action' => 'test', 123]">
	<cake:image path="example.jpg" options="['alt' => #{Click here}]" />
</cake:link>
```

```php
<?php echo $this->Html->link($this->Html->image('example.jpg', array('alt' => __('Click here'))), array('controller' => 'example', 'action' => 'test', 123)); ?>
```

Forms
-----

Create a form with a custom submit button.

```html
<cake:form model="Example" submit="['label' => 'Update', 'div' => ['class' => 'glass-pill']]">
	<cake:input field="Example.field" options="['type' => 'text']" />
</cake:form>
```

```php
<?php
$this->Form->create('Example');
$this->Form->input('Example.field', array('type' => 'text'));
$this->Form->end(array('label' => 'Update', 'div' => array('class' => 'glass-pill')));
?>
```

View Blocks
-----------

Create a new View block.

```html
<cake:block name="example">
	Hello World
</cake:block>
```

```php
<?php $this->start('example'); ?>
	Hello World
<?php $this->end(); ?>
```

Append to an existing View block.

```html
<cake:append name="example">
	Hello World
</cake:append>
```

```php
<?php $this->append('example'); ?>
	Hello World
<?php $this->end(); ?>
```

Fetching a View block.

```html
<cake:fetch name="example" />
```

```php
<?php echo $this->fetch('example'); ?>
```

Elements
--------

Include an element.

```html
<cake:element name="example" vars="['something' => %{example}]" />
```

```php
<?php echo $this->element('example', array('something' => $example)); ?>
```

Logic
-----

Simple condition checking.

```html
<php:if expr="%{example} > 0">
	#{You won a prize!}
</php:if>
```

```php
<?php
if ($example > 0) {
	echo __('You won a prize!');
}
?>
```

```php
<?php if ($example > 0): ?>
	<?php echo __('You won a prize!'); ?>
<?php endif; ?>
```

Iterating over an array of values.

```html
<php:for var="items" default="#{No items available}">
	#{Item} %{COUNT}: <cake:out value="%{VALUE}" />
</php:for>
```

```php
<?php
if (count($items) > 0) {
	for ($i = 0; $i < count($items); $i++) {
		echo __('Item') . ' ' . ($i+1) . ': ' . h($items[$i]);
	}
} else {
	echo __('No items available');
}
?>
```

```php
<?php if (count($items) > 0): ?>
	<?php for ($i = 0; $i < count($items); $i++): ?>
		<?php echo __('Item') . ' ' . ($i+1) . ': ' . h($items[$i]); ?>
	<?php endfor; ?>
<?php else: ?>
	<?php echo __('No items available'); ?>
<?php endif; ?>
```

