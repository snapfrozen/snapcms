<?php

class m131103_101810_create_users_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('{{users}}', array(
            'id' => 'pk',
            'first_name' => 'string NOT NULL',
			'last_name' => 'string',
			'email' => 'string NOT NULL',
			'password' => 'string NOT NULL',
			'image' => 'string',
			'bio' => 'string',
			'created' => 'DATETIME',
			'updated' => 'DATETIME',
        ));
		
		$this->insert('{{users}}', array(
			'first_name'=>'SnapCMS',
			'last_name'=>'Admin',
			'email' => 'admin@admin.com',
			'password' => SnapUtil::doHash('password'),
		));
		$this->insert('{{users}}', array(
			'first_name'=>'SnapCMS',
			'last_name'=>'Editor',
			'email' => 'editor@editor.com',
			'password' => SnapUtil::doHash('password'),
		));
	}

	public function down()
	{
		echo "m131103_101810_create_users_table does not support migration down.\n";
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