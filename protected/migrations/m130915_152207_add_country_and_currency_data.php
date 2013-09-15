<?php

class m130915_152207_add_country_and_currency_data extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('{{currencies}}', array(
			'id'=>'pk',
			'name'=>'text NOT NULL',
			'country_id'=>'integer NOT NULL',
			'code'=>'char(3) NOT NULL',
			'number'=>'integer NOT NULL',
			'withdrawn_date'=>'string',
			'comment'=>'text',
		));
		$this->createTable('{{countries}}', array(
			'id'=>'pk',
			'name'=>'text NOT NULL', // Entity
			'short_name'=>'string NOT NULL', // short_name_en
			'french_short_name'=>'string', // short_name_fr
			'short_code'=>'char(2) NOT NULL', // ISO3166-1-Alpha-2
			'code'=>'char(3) NOT NULL', // ISO3166-1-Alpha-3
			'telephone_prefix'=>'string', // Dial
			'currency_id'=>'integer NOT NULL',
			'is_independent'=>'boolean NOT NULL DEFAULT YES',
		));
		$this->createTable('{{country_codes}}', array(
			'country_id'=>'integer NOT NULL',
			'vehicle_code'=>'string', // DS
			'fifa_code'=>'string', // FIFA
			'fips_code'=>'string', // FIPS
			'gaul_code'=>'string', // GAUL
			'ioc_code'=>'string', // IOC
			'itu_code'=>'string', // ITU
			'marc_code'=>'string', // MARC
			'wmo_code'=>'string', // WMO
			'ISO3166-1_numeric_code'=>'string', // ISO3166-1-numeric
		));
	}

	public function safeDown()
	{
		$this->dropTable('{{country_codes}}');
		$this->dropTable('{{countries}}');
		$this->dropTable('{{currencies}}');
	}
}
