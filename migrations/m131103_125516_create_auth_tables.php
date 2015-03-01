<?php

class m131103_125516_create_auth_tables extends CDbMigration
{
	public function up()
	{
		$this->createTable('{{auth_item}}', array(
            'name' => 'varchar(64)',
            'type' => 'integer NOT NULL',
			'description' => 'text',
			'bizrule' => 'text',
			'data' => 'text',
			'PRIMARY KEY (name)'
        ));
		
		$this->createTable('{{auth_item_child}}', array(
            'parent' => 'varchar(64)',
            'child' => 'varchar(64)',
			'PRIMARY KEY (parent,child)'
        ));
		
		$this->addForeignKey('fk_aic_aip', '{{auth_item_child}}', 'parent', '{{auth_item}}', 'name', 'CASCADE', 'CASCADE');
		$this->addForeignKey('fk_aic_aic', '{{auth_item_child}}', 'child', '{{auth_item}}', 'name', 'CASCADE', 'CASCADE');
		
		$this->createTable('{{auth_assignment}}', array(
            'itemname' => 'varchar(64) NOT NULL',
			'userid' => 'varchar(64) NOT NULL',
			'bizrule' => 'text',
			'data' => 'text',
			'PRIMARY KEY (itemname,userid)'
        ));
		
		$this->addForeignKey('fk_aa_ai', '{{auth_assignment}}', 'itemname', '{{auth_item}}', 'name', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
		echo "m131103_125516_create_auth_tables does not support migration down.\n";
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