Overview
========

The **Cake Markup Language** is a *CakePHP* plugin which provides abstraction of the View layer by replacing procedural *PHP* code with an *XML* based markup.

Using **CakeML** helps keep your View code clean and organized, while also maintaining a strict *MVC* convention by limiting application logic in the View layer.

Features
--------

* **Familiar Syntax:** The syntax used for the **CakeML** markup is identical to that used for *XHTML*, so there's no new formatting or patterns to learn, and any IDE or code editor capable of highlighting *XML* will also do so for your View files.
* **Ready for Designers:** Due to the common syntax your View files become even more accessible to designers and non-developers, allowing them to introduce code themselves without any previous technical knowledge.
* **Simple Templating:** The plugin provides basic template logic out-of-the-box, such as if/elseif/else conditional statements, foreach loops and switches, as well as the View blocks already available in *CakePHP* for creating dynamic content.
* **Internal Debugging:** By enabling debug mode on the Parser component you can quickly review the compiled View before it's processed, giving you a clear idea of the generated code before it's rendered as the output.
* **Extensible by Design:** As the markup tags used in **CakeML** are grouped together under a common namespace, you can easily import your own custom or *third-party* namespaces from a *CakePHP* plugin, allowing you to reuse tags in other applications.
* **Plug and Play:** Using the plugin is as simple as including the Parser component, which doesn't limit you from still using the normal ".ctp" files, as you can even use both formats for different Views in the same Controller.
* **Compatibility:** All of the View features currently in *CakePHP* are still available, such as *themes*, *layouts*, *elements*, *content blocks* and *helpers*.

License
-------

Copyright 2013 James Watts (CakeDC). All rights reserved.

Licensed under the MIT License. Redistributions of the source code included in this repository must retain the copyright notice found in each file.

Support
-------

For support, bugs and feature requests, please create a new [issue](https://github.com/jameswatts/cake-markup-language/issues).

Contributing
------------

If you'd like to contribute new features, enhancements or bug fixes to the code base just follow these steps:

* Create a [GitHub](https://github.com/signup/free) account, if you don't own one already
* Then, [fork](https://help.github.com/articles/fork-a-repo) the [Cake Markup Langauge](https://github.com/jameswatts/cake-markup-language) repository to your account
* Create a new [branch](https://help.github.com/articles/creating-and-deleting-branches-within-your-repository) from the *master* branch in your forked repository
* Modify the existing code, or add new code to your branch, making sure you follow the [CakePHP Coding Standards](http://book.cakephp.org/2.0/en/contributing/cakephp-coding-conventions.html)
* Modify or add [unit tests](http://book.cakephp.org/2.0/en/development/testing.html) which confirm the correct functionality of your code (requires [PHPUnit](http://www.phpunit.de/manual/current/en/installation.html) 3.5+)
* Consider using the [CakePHP Code Sniffer](https://github.com/cakephp/cakephp-codesniffer) to check the quality of your code
* When ready, make a [pull request](http://help.github.com/send-pull-requests/) to the main repository

There may be some discussion reagrding your contribution to the repository before any code is merged in, so be prepared to provide feedback on your contribution if required.

A list of contributors to the **Cake Markup Language** can bee found [here](https://github.com/jameswatts/cake-markup-language/contributors).

