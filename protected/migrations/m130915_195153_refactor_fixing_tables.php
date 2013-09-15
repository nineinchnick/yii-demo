<?php

class m130915_195153_refactor_fixing_tables extends CDbMigration
{
	public function safeUp()
	{
		$this->dropTable('{{gold_fixings}}');
		$this->dropTable('{{currency_fixings}}');

		$this->createTable('{{currency_fixings}}', array(
			'id'=>'pk',
			'date'=>'timestamp not null',
			'rate'=>'integer not null',
			'currency_id'=>"integer NOT NULL REFERENCES {{currencies}} (id)",
		));
		$this->createIndex('{{currency_fixings}}_date_currency_id_idx', '{{currency_fixings}}', 'date, currency_id', true);
		$this->createIndex('{{currency_fixings}}_date_idx', '{{currency_fixings}}', 'date');
		$this->createIndex('{{currency_fixings}}_currency_id_idx', '{{currency_fixings}}', 'currency_id');

		$this->createTable('{{precious_metals}}', array(
			'id'=>'pk',
			'name'=>'string NOT NULL',
		));
		$this->insert('{{precious_metals}}', array('name'=>'Gold'));
		$gold_id = Yii::app()->db->getLastInsertID();

		$this->createTable('{{precious_metal_fixings}}', array(
			'id'=>'pk',
			'date'=>'timestamp not null',
			'rate'=>'integer not null',
			'currency_id'=>"integer NOT NULL REFERENCES {{currencies}} (id)",
			'precious_metal_id'=>'integer not null REFERENCES {{precious_metals}} (id)',
		));
		$this->createIndex('{{precious_metal_fixings}}_currency_id_idx', '{{precious_metal_fixings}}', 'currency_id');
		$this->createIndex('{{precious_metal_fixings}}_precious_metal_id_idx', '{{precious_metal_fixings}}', 'precious_metal_id');
		$this->createIndex('{{precious_metal_fixings}}_date_currency_id_precious_metal_id_idx', '{{precious_metal_fixings}}', 'date, currency_id, precious_metal_id', true);
		$this->createIndex('{{precious_metal_fixings}}_date_idx', '{{precious_metal_fixings}}', 'date');


		// now load some data
		$currencyMap = array();
		$currencies = Yii::app()->db->createCommand('SELECT id,code FROM {{currencies}}')->queryAll();
		foreach($currencies as $row) {
			$currencyMap[$row['code']] = $row['id'];
		}
		require('data/financial_data.php');
		foreach($currency as $row) {
			$row['currency_id'] = $currencyMap[$row['currency']];
			unset($row['id']);
			unset($row['currency']);
			$this->insert('{{currency_fixings}}', $row);
		}
		foreach($gold as $row) {
			$row['currency_id'] = $currencyMap[$row['currency']];
			$row['precious_metal_id']=$gold_id;
			unset($row['id']);
			unset($row['currency']);
			$this->insert('{{precious_metal_fixings}}', $row);
		}
	}

	public function safeDown()
	{
		$this->dropTable('{{precious_metal_fixings}}');
		$this->dropTable('{{currency_fixings}}');
		$this->dropTable('{{precious_metals}}');

		$this->createTable('{{currency_fixings}}', array(
			'id'=>'pk',
			'date'=>'timestamp not null',
			'rate'=>'integer not null',
			'currency'=>"char(3) NOT NULL DEFAULT 'USD'",
		));
		$this->createIndex('{{currency_fixings}}_date_currency_idx', '{{currency_fixings}}', 'date, currency', true);
		$this->createIndex('{{currency_fixings}}_date_idx', '{{currency_fixings}}', 'date');
		$this->createTable('{{gold_fixings}}', array(
			'id'=>'pk',
			'date'=>'timestamp not null',
			'rate'=>'integer not null',
			'currency'=>"char(3) NOT NULL DEFAULT 'USD'",
		));
		$this->createIndex('{{gold_fixings}}_date_currency_idx', '{{gold_fixings}}', 'date, currency', true);
		$this->createIndex('{{gold_fixings}}_date_idx', '{{gold_fixings}}', 'date');


		// now load some data
		require('data/financial_data.php');
		foreach($currency as $row) {
			unset($row['id']);
			$this->insert('{{currency_fixings}}', $row);
		}
		foreach($gold as $row) {
			unset($row['id']);
			$this->insert('{{gold_fixings}}', $row);
		}
	}
}
