<?php

class m150414_024202_menu_icon extends CDbMigration
{
	public function up()
	{
        $this->addColumn('{{menu_items}}', 'icon', 'VARCHAR(30)');
	}

	public function down()
	{
		$this->dropColumn('{{menu_items}}', 'icon');
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