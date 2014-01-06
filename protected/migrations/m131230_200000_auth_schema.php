<?php

class m131230_200000_auth_schema extends CDbMigration
{
	public function safeUp()
	{
		$schema = $this->dbConnection->schema;
		$this->createTable('{{auth_item}}', array(
			'name'		=> 'character varying(64) not null',
			'type'		=> 'integer not null',
			'description'=>'text',
			'bizrule'	=> 'text',
			'data'		=> 'text',
			'PRIMARY KEY(name)',
		));
		$this->createTable('{{auth_assignment}}', array(
			'itemname'	=> 'character varying(64) not null REFERENCES '.$schema->quoteTableName('{{auth_item}}').' (name) ON DELETE CASCADE ON UPDATE CASCADE',
			'bizrule'	=> 'text',
			'data'		=> 'text',
			'userid'	=> 'integer not null REFERENCES '.$schema->quoteTableName('{{users}}').' (id) ON DELETE CASCADE ON UPDATE CASCADE',
		));
		$this->createTable('{{auth_item_child}}', array(
			'parent'=>'character varying(64) not null REFERENCES '.$schema->quoteTableName('{{auth_item}}').' (name) ON DELETE CASCADE ON UPDATE CASCADE',
			'child'=>'character varying(64) not null REFERENCES '.$schema->quoteTableName('{{auth_item}}').' (name) ON DELETE CASCADE ON UPDATE CASCADE',
			'PRIMARY KEY(parent, child)',
		));
	}

	public function safeDown()
	{
		$this->dropTable('{{auth_item_child}}');
		$this->dropTable('{{auth_assignment}}');
		$this->dropTable('{{auth_item}');
	}
}

