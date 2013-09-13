# Demo modifications

This demo is based on a default web app generated using the Yii framework.

This page presents the list of modifications and widgets/extensions installed here.

## Resources

All source code is available in a [public GitHub repository](https://github.com/nineinchnick/yii-demo).

## Language and theme selector

The main menu contains list of available languages and themes.

Switching happens in a ApplicationConfigBehavior attached to the application that executes an event callback before processing the request.

Flag icons with some css has been imported and some css has been added in the default theme for a drop down in the main menu.

Main menu items definition has been moved to the base Controller class.

## Usr module

Replaces login actions, views and form models from the demo.

[Read more](/site/page?view=usr).

## Nfy module

Demo of a notifications system.

[Read more](/site/page?view=nfy).

## EDataTables extension

A grid view widget, replacing CGridView.

[Read more](/edatatables).

## Exporter

A grid view widget for exporting large amounts of data in various formats like CSV or XML.

[Read more](/site/page?view=exporter).

## MdViewRenderer

A simple view renderer has been added to allow writing static pages, like this one.

This is done by creating a _MdViewRenderer_ file in the _components_ directory with the following class:

~~~
[php]
<?php
class MdViewRenderer extends CViewRenderer
{
	public $fileExtension='.md';

	protected function generateViewFile($sourceFile,$viewFile) {
		$md=new CMarkdown;
		$input = file_get_contents($sourceFile);
		$output = $md->transform($input);
		file_put_contents($viewFile,$output);
	}

	public function renderFile($context,$sourceFile,$data,$return)
	{
		$md=new CMarkdown;
		$md->registerCssFile();
		return parent::renderFile($context,$sourceFile,$data,$return);
	}
}
~~~

The new view renderer will detect view files with the _.md_ extension, transform, cache them and display as html pages. Ordinary views with _.php_ extensions will work as before.

The view renderer needs to be enabled in the configuration, in the components section:

~~~
[php]
	'components'=>array(
		// ...
		'viewRenderer' => array('class'=>'MdViewRenderer'),
	),
~~~

