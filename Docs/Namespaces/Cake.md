Cake Namespace
==============

The **cake** namespace contains tags providing framework specific functionality.

To use the **cake** namespace in a View include it in the *$namespaces* setting of the **Cml.Parser** component, for example:

```php
public $components = array(
	'Cml.Parser' => array(
		'namespaces' => array(
			'Cml.Cake'
		)
	)
);
```

Once the namespace is available you can access the tags it provides. To use a tag, specify the namespace, followed by the ":" symbol, and then the tag name, for example:

```html
<cake:out value="Hello World" />
```

The tags available from the **cake** namespace are the following:

* [append](Cake/Append.md) - Appends content to a View block.
* [assign](Cake/Assign.md) - Assigns content to a View block.
* [block](Cake/Block.md) - Outputs or captures a View block.
* [button](Cake/Button.md) - Creates a form button.
* [charset](Cake/Charset.md) - Defines the View's character set.
* [checkbox](Cake/Checkbox.md) - Creates a checkbox input.
* [crumbs](Cake/Crumbs.md) - Creates a bread crumbs list.
* [datetime](Cake/Datetime.md) - Create a date-time input.
* [day](Cake/Day.md) - Creates a days input.
* [debug](Cake/Debug.md) - Outputs the debug of a View variable.
* [download](Cake/Download.md) - Defines the View as a download.
* [element](Cake/Element.md) - Outputs or captures an element.
* [error](Cake/Error.md) - Creates an error message.
* [extend](Cake/Extend.md) - Extends a View.
* [fetch](Cake/Fetch.md) - Fetches a View block.
* [file](Cake/File.md) - Creates a file input.
* [form](Cake/Form.md) - Creates a *CakePHP* form.
* [get](Cake/Get.md) - Gets a View variable.
* [header](Cake/Header.md) - Gets a *HTTP* header.
* [helper](Cake/Helper.md) - Accesses a helper.
* [hidden](Cake/Hidden.md) - Creates a hidden input.
* [hour](Cake/Hour.md) - Creates an hours input.
* [image](Cake/Image.md) - Creates an image element.
* [input](Cake/Input.md) - Creates a form input.
* [inputs](Cake/Inputs.md) - Creates a collection of inputs.
* [is](Cake/Is.md) - Determines if the request *is* something.
* [label](Cake/Label.md) - Creates a form label.
* [layout](Cake/Layout.md) - Defines the View layout.
* [link](Cake/Link.md) - Creates an anchor element.
* [log](Cake/Log.md) - Writes to a log file.
* [meridian](Cake/Meridian.md) - Creates a meridian input.
* [minute](Cake/Minute.md) - Creates a minutes input.
* [month](Cake/Month.md) - Creates a months input.
* [out](Cake/Out.md) - Outputs a value, encoded by default.
* [post_button](Cake/PostButton.md) - Creates a post button.
* [post_link](Cake/PostLink.md) - Creates a post link.
* [prepend](Cake/Prepend.md) - Prepends content to a View block.
* [radio](Cake/Radio.md) - Creates a radio button input.
* [request_action](Cake/RequestAction.md) - Performs a request to an action.
* [secure](Cake/Secure.md) - Defines the form security.
* [select](Cake/Select.md) - Creates a select input.
* [set](Cake/Set.md) - Sets a View variable.
* [submit](Cake/Submit.md) - Creates a submit button.
* [textarea](Cake/Textarea.md) - Creates a textarea.
* [type](Cake/Type.md) - Defines the content type of the View.
* [year](Cake/Year.md) - Creates a years input.

