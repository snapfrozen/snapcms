<?php

class m131103_131530_add_user_auth_data extends CDbMigration
{
	public function up()
	{
		$authManager=Yii::app()->authManager;
		$authManager->createOperation("Access Backend","Access admin area");
		$authManager->createOperation("Manage User Groups","Updage users groups");
		$authManager->createOperation("Update Content Type Structure","Update the structure of content types");
		
		$authManager->createOperation("Create User","Create a new user");
		$authManager->createOperation("View User","Read user profile information");
		$authManager->createOperation("Update User","Update a users information");
		$authManager->createOperation("Delete User","Remove a user");
		
		$authManager->createOperation("Create Content","Create any content");
		$authManager->createOperation("View Content","View content on the website");
		$authManager->createOperation("Update Content","Update any content");
		$authManager->createOperation("Delete Content","Delete any content");
		
		$authManager->createOperation("View Menu","View a menu in the admin area");
		$authManager->createOperation("Create Menu","Create a menu");
		$authManager->createOperation("Update Menu","Update a menu");
		$authManager->createOperation("Delete Menu","Delete any content");
		
		$authManager->createOperation("Create Menu Item","Create a menu item");
		$authManager->createOperation("Update Menu Item","Update a menu item");
		$authManager->createOperation("Delete Menu Item","Delete a menu item");
		
		//Tasks used for grouping
		$role=$authManager->createTask("User");
		$role->addChild("View User");
		$role->addChild("Create User");
		$role->addChild("Update User");
		$role->addChild("Delete User");
		$role->addChild("Manage User Groups");
		
		$role=$authManager->createTask("Content");
		$role->addChild("View Content");
		$role->addChild("Create User");
		$role->addChild("Update Content");
		$role->addChild("Delete Content");
		$role->addChild("Update Content Type Structure");
		
		$role=$authManager->createTask("Menu");
		$role->addChild("View Menu");
		$role->addChild("Create Menu");
		$role->addChild("Update Menu");
		$role->addChild("Delete Menu");
		$role->addChild("Create Menu Item");
		$role->addChild("Update Menu Item");
		$role->addChild("Delete Menu Item");
		
		$role=$authManager->createTask("General");
		$role->addChild("Access Backend");
		
		//Assign operations
		$role=$authManager->createRole("Anonymous");
		$role->addChild("View Content");
		
		$role=$authManager->createRole("Member");
		$role->addChild("View User");
		$role->addChild("Access Backend");
		
		$role=$authManager->createRole("Admin");
		$role->addChild("User");
		$role->addChild("Content");
		$role->addChild("Menu");
		$role->addChild("General");
		
		$authManager->assign("Admin",1);
	}

	public function down()
	{
		echo "m131103_131530_add_user_auth_data does not support migration down.\n";
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