<?php

class m131228_121127_remove_old_nfy_tables extends CDbMigration
{
	public function safeUp()
	{
		$this->dropTable('{{nfy_queues}}');
		$this->dropTable('{{nfy_subscriptions}}');
		$this->dropTable('{{nfy_messages}}');
		$this->dropTable('{{nfy_channels}}');
	}

	public function safeDown()
	{
		return false;
	}
}
