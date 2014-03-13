<?php

class m140313_090412_add_config_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('{{config}}', array(
            'config_loc' => 'string',
            'value' => 'string',
			'PRIMARY KEY(config_loc)'
        ));
	}

	public function down()
	{
		echo "m140313_090412_add_config_table does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}