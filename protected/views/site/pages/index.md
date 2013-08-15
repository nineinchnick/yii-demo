# Demo modifications

This demo is based on a default web app generated using the Yii framework.

This page presents the list of modifications and widgets/extensions installed here.

## Resources

All source code is available in a [public GitHub repository](https://github.com/nineinchnick/yii-demo).

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


## Usr module

Replaces login actions, views and form models from the demo.

[Read more](/site/page?view=usr).

## Nfy module

Demo of a notifications system.

[Read more](/site/page?view=nfy).

## EDataTables extension

A grid view widget, replacing CGridView.

[Read more](/site/page?view=edatatables).

