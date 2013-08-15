<?php

class m130815_155154_insert_nfy_channels extends CDbMigration
{
	public function safeUp()
	{
		$this->insert('{{nfy_channels}}', array(
			'name'=>'default',
			'message_template'=>'New notification!',
			'route_class'=>'NfyDbRoute',
			'enabled'=>true,
		));
	}

	public function safeDown()
	{
		$this->delete('{{nfy_channels}}', "name='default'");
	}
}
