<?php

class m140303_011754_add_menu_items extends CDbMigration
{
	public function up()
	{
		$this->createTable('{{menu_items}}', array(
			'id' => 'pk',
			'path' => 'string UNIQUE NOT NULL',
			'title' => 'string NOT NULL',
			'menu_id' => 'varchar(50)',
			'parent' => 'int',
			'content_id' => 'int',
			'sort' => 'int',
			'external_path' => 'string',
			'created' => 'DATETIME',
			'updated' => 'DATETIME',
		));
		$this->addForeignKey('fk_menu_items_content', '{{menu_items}}', 'content_id', '{{content}}', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('fk_menu_items_parent', '{{menu_items}}', 'parent', '{{menu_items}}', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
		echo "m140303_011754_add_menu_items does not support migration down.\n";
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
