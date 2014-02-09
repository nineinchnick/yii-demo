<?php /*
@var $this CController
@var $locale string
@var $records integer
@var $faker \Faker\Generator
@var $documentor \Faker\Documentor
*/

Yii::import('vendors.nineinchnick.yii-exporter.*');

/**
 * - open up a temporary zip file
 * - for each provider
 * -   create an array data provider and column configuration
 * -   save a temp csv file
 * -   add to zip and close it
 * - send the zip and remove it
 */

$file = tempnam(sys_get_temp_dir(), "zip"); 
$zip = new ZipArchive(); 
$zip->open($file, ZipArchive::OVERWRITE); 

foreach(array_reverse($faker->getProviders()) as $provider) {
	// prepare columns
	$refl = new \ReflectionObject($provider);
	$providerClass = get_class($provider);
	$shortClass = $refl->getShortName();
	$columns = array();
	foreach ($refl->getMethods(\ReflectionMethod::IS_PUBLIC) as $reflmethod) {
		if ($reflmethod->getDeclaringClass()->getName() == 'Faker\Provider\Base' && $providerClass != 'Faker\Provider\Base') {
			continue;
		}
		$methodName = $reflmethod->name;
		if ($reflmethod->isConstructor() || ($providerClass == 'Faker\Provider\Base' && $methodName == 'optional') || ($providerClass == 'Faker\Provider\Image' && $methodName == 'image')) {
			continue;
		}

		$columns[] = array(
			'name' => $methodName,
			'header' => $methodName,
			'type' => 'text',
		);
	}

	// generate data
	$data = array();
	for ($i = 0; $i < $records; $i++) {
		$row = array();
		foreach($columns as $column) {
			$value = $faker->format($column['name']);
			if (is_array($value)) {
				$row[$column['name']] = join(', ', $value);
			} elseif ($value instanceof DateTime) {
				$row[$column['name']] = $value->format('Y-m-d H:i:s');
			} else {
				$row[$column['name']] = $value;
			}
		}
		$data[] = $row;
	}

	// export data as csv
	$widget = $this->createWidget('vendors.nineinchnick.yii-exporter.CsvView', array(
		'dataColumnClass' => 'vendors.nineinchnick.edatatables.EDataColumn',
		'columns'   => $columns,
		'filename'  => $shortClass,
		'fileExt'   => 'csv',
		'dataProvider' => new CArrayDataProvider($data, array('pagination'=>false)),
		'disableBuffering' => false,
		'disableHttpHeaders' => true,
	));
	ob_start();
	ob_implicit_flush(false);
	$widget->run();
	$file_contents = ob_get_clean();

	$zip->addFromString("{$shortClass}_{$records}_{$locale}.csv", $file_contents);
}

$zip->close(); 

// Stream the file to the client 
header("Content-Type: application/zip"); 
//header("Content-Length: " . filesize($file)); 
header("Content-Disposition: attachment; filename=\"faker_{$records}_{$locale}.zip\""); 
readfile($file); 

unlink($file); 

