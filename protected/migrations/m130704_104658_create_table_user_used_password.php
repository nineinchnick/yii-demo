<?php

class m130704_104658_create_table_user_used_password extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('{{user_used_password}}', array(
			'id'=>'pk',
			'user_id'=>'integer NOT NULL REFERENCES {{user}} (id) ON UPDATE CASCADE ON DELETE CASCADE',
			'password'=>'string NOT NULL',
			'set_on'=>'timestamp NOT NULL',
		));
		$this->createIndex('{{user_used_password}}_user_id_idx', '{{user_used_password}}', 'user_id');
	}

	public function safeDown()
	{
		$this->dropTable('{{user_used_password}}');
	}
}

