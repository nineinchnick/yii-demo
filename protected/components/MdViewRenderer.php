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
