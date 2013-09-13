<?php

class FetchCurrencyRatesCommand extends CConsoleCommand
{
	public function actionFetchMissingFixings($currency) {
		$lastDate = Yii::app()->db->createCommand()
			->select('max(date)')
			->from('{{currency_fixings}}')
			->where(array('and','currency = :currency'))->queryScalar(array(':currency'=>$currency));
		if (!$lastDate)
			$lastDate = '2002-01-01';
		$today = new DateTime;
		$lastDate = new DateTime($lastDate);
		$oneDay = new DateInterval('P1D');


		$stmt = Yii::app()->db->createCommand("INSERT INTO {{currency_fixings}} (currency, date, rate) VALUES ('$currency', :date, :rate)");
		$fixingList = file_get_contents('http://nbp.pl/Kursy/xml/dir.txt');

		while($lastDate->add($oneDay) < $today) {
			echo "Sprawdzam dla ".$lastDate->format('Y-m-d');
			$filename = $this->getFixingFilename($lastDate, $fixingList);
			echo " $filename\n";
			$fixing = $this->fetchFixing($filename, array($currency));
			if ($fixing === null || !isset($fixing[$currency])) {
				continue;
			}

			$stmt->execute(array(
				':date'=>$lastDate->format('Y-m-d'),
				':rate'=>$fixing[$currency],
			));
			echo $lastDate->format('Y-m-d').' '.$fixing[$currency]."\n";
		}
	}

	public function fetchFixing($filename, $currencies = array('USD')) {
        if ($filename === null) {
			return null;
		}

        $tresc = @file_get_contents($filename);

        if (!$tresc) {
			return null;
		}

		$xml = new SimpleXMLElement($tresc);
		$output = array();
		foreach ($xml->pozycja as $pozycja) {
			if (!in_array((string)$pozycja->kod_waluty, $currencies)) continue;

			$output[(string)$pozycja->kod_waluty] = str_replace(',','',$pozycja->kurs_sredni);
		}
		return $output;
	}

	private function getFixingFilename(DateTime $date, $subject = null) {
		if ($subject === null) {
			$subject = file_get_contents('http://nbp.pl/Kursy/xml/dir.txt');
		} 
		$pattern = '/^a\d{3}z'.$date->format('ymd').'/m';
		if (preg_match_all($pattern, $subject, $matches)) {
			return 'http://nbp.pl/kursy/xml/'.reset($matches[0]).'.xml';
		}
		return null;
	}

	public function actionExport() {
		$currency = Yii::app()->db->createCommand('SELECT * FROM {{currency_fixings}}')->queryAll();
		$gold = Yii::app()->db->createCommand('SELECT * FROM {{gold_fixings}}')->queryAll();
		file_put_contents('data/export.php', "<?php\n\$currency = ".var_export($currency,true).";\n\$gold = ".var_export($gold,true).";\n");
	}
}
