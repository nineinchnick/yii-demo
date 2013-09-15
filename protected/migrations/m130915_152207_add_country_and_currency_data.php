<?php

class m130915_152207_add_country_and_currency_data extends CDbMigration
{
	public function safeUp()
	{
		// create structures
		$this->createTable('{{currencies}}', array(
			'id'=>'pk',
			'name'=>'text NOT NULL',
			'code'=>'char(3) NOT NULL',
			'number'=>'integer',
			'minor_unit'=>'integer',
			'withdrawn_date'=>'string',
			'comment'=>'text',
		));
		// DS,Dial,Entity,FIFA,FIPS,GAUL,IOC,ISO3166-1-Alpha-2,ISO3166-1-Alpha-3,ISO3166-1-numeric,
		// ITU,MARC,WMO,currency_alphabetic_code,currency_minor_unit,currency_name,currency_numeric_code,currency_short_name_en,is_independent,short_name_en,short_name_fr
		$this->createTable('{{countries}}', array(
			'id'=>'pk',
			'name'=>'text NOT NULL', // 2 Entity
			'short_name'=>'varchar(255) NOT NULL', // 19 short_name_en
			'french_short_name'=>'string', // 20 short_name_fr
			'short_code'=>'char(2) NOT NULL', // 7 ISO3166-1-Alpha-2
			'code'=>'char(3) NOT NULL', // 8 ISO3166-1-Alpha-3
			'telephone_prefix'=>'string', // 1 Dial
			'currency_id'=>'integer REFERENCES {{currencies}} (id) ON DELETE RESTRICT ON UPDATE CASCADE DEFERRABLE INITIALLY DEFERRED',
			'is_independent'=>'boolean NOT NULL DEFAULT YES', // 18
		));
		$this->createTable('{{country_codes}}', array(
			'country_id'=>'integer NOT NULL PRIMARY KEY REFERENCES {{countries}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
			'numeric_code'=>'string', // 9 ISO3166-1-numeric
			'vehicle_code'=>'string', // 0 DS
			'fifa_code'=>'string', // 3 FIFA
			'fips_code'=>'string', // 4 FIPS
			'gaul_code'=>'string', // 5 GAUL
			'ioc_code'=>'string', // 6 IOC
			'itu_code'=>'string', // 10 ITU
			'marc_code'=>'string', // 11 MARC
			'wmo_code'=>'string', // 12 WMO
		));

		$this->createIndex('{{countries}}_currency_id_idx','{{countries}}','currency_id',true);
		$this->createIndex('{{countries}}_code_idx','{{countries}}','code',true);
		$this->createIndex('{{currencies}}_code_idx','{{currencies}}','code',true);


		// import data
		$countryCurrencyMap = array();
		$countryCurrencyMapReverse = array();
		if (($handle = fopen("data/country-codes-comprehensive.csv", "r")) !== FALSE) {
			$header = fgetcsv($handle, 1000, ",");
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				foreach($data as $i=>$col) {
					$data[$i]=trim($col);
					if ($data[$i]=='')
						$data[$i]=null;
				}
				$this->insert('{{countries}}', array(
					'name'				=> $data[2],
					'short_name'		=> $data[19],
					'french_short_name'	=> $data[20],
					'short_code'		=> $data[7],
					'code'				=> $data[8],
					'telephone_prefix'	=> $data[1],
					'is_independent'	=> $data[18]=='Yes',
				));
				$country_id = Yii::app()->db->getLastInsertID();
				$countryCurrencyMap[$data[16]] = $country_id;
				$this->insert('{{country_codes}}', array(
					'country_id'=>$country_id,
					'numeric_code'=>$data[9],
					'vehicle_code'=>$data[0],
					'fifa_code'=>$data[3],
					'fips_code'=>$data[4],
					'gaul_code'=>$data[5],
					'ioc_code'=>$data[6],
					'itu_code'=>$data[10],
					'marc_code'=>$data[11],
					'wmo_code'=>$data[12],
				));
			}
			fclose($handle);
		}
		if (($handle = fopen("data/codes-all.csv", "r")) !== FALSE) {
			$header = fgetcsv($handle, 1000, ",");
			$currencies = array();
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				foreach($data as $i=>$col) {
					$data[$i]=trim($col);
					if ($data[$i]=='')
						$data[$i]=null;
				}
				if ($data[2]===null || isset($currencies[$data[2]])) continue;
				$this->insert('{{currencies}}', array(
					'name'=>$data[1],
					'code'=>$data[2],
					'number'=>$data[3]=='—' ? null : $data[3],
					'minor_unit'=>$data[4] == 'N.A.' ? null : $data[4],
					//'country_id'=>$countryCurrencyMap[$data[3]],
					'withdrawn_date'=>isset($data[5])?$data[5] : null,
					'comment'=>isset($data[6])?$data[6] : null,
				));
				$currencies[$data[2]] = Yii::app()->db->getLastInsertID();
				if (isset($countryCurrencyMap[$data[3]]))
					$countryCurrencyMapReverse[$countryCurrencyMap[$data[3]]] = Yii::app()->db->getLastInsertID();
			}
			fclose($handle);
		}
		// fill currency ids in countries
		foreach($countryCurrencyMapReverse as $country_id => $currency_id) {
			$this->update('{{countries}}', array('currency_id'=>$currency_id), 'id = '.$country_id);
		}
	}

	public function safeDown()
	{
		$this->dropTable('{{country_codes}}');
		$this->dropTable('{{countries}}');
		$this->dropTable('{{currencies}}');
	}
}
