<?php

class m130913_072516_create_fixing_tables extends CDbMigration
{
	public function safeUp()
	{
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

	public function safeDown()
	{
		$this->dropTable('{{gold_fixings}}');
		$this->dropTable('{{currency_fixings}}');
	}
}
