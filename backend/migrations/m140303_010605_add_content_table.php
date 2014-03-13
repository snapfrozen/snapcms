<?php

class m140303_010605_add_content_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('{{content}}', array(
			'id' => 'pk',
			'title' => 'string NOT NULL',
			'type' => 'varchar(50) NOT NULL',
			'published' => 'TINYINT(1) NOT NULL DEFAULT 1',
			'publish_on' => 'DATETIME',
			'unpublish_on' => 'DATETIME',
			'created_by' => 'INT(11)',
			'updated_by' => 'INT(11)',
			'created' => 'DATETIME',
			'updated' => 'DATETIME',
		));
		$this->addForeignKey('fk_content_usercreated', '{{content}}', 'created_by', '{{users}}', 'id', 'SET NULL', 'CASCADE');
		$this->addForeignKey('fk_content_userupdated', '{{content}}', 'updated_by', '{{users}}', 'id', 'SET NULL', 'CASCADE');
	}

	public function down()
	{
		echo "m140303_013605_add_content_table does not support migration down.\n";
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
