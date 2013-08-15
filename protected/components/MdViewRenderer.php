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
