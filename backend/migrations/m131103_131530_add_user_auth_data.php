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
		$authManager->createOperation("Update Menu","Update a menu");
		
		$authManager->createOperation("Create Menu Item","Create a menu item");
		$authManager->createOperation("Update Menu Item","Update a menu item");
		$authManager->createOperation("Delete Menu Item","Delete a menu item");
		
		$authManager->createOperation("Update Settings","Update site settings");
		
		//Tasks used for grouping
		$role=$authManager->createTask("User");
		$role->addChild("View User");
		$role->addChild("Create User");
		$role->addChild("Update User");
		$role->addChild("Delete User");
		
		$role=$authManager->createTask("Content");
		$role->addChild("View Content");
		$role->addChild("Create Content");
		$role->addChild("Update Content");
		$role->addChild("Delete Content");
		
		$role=$authManager->createTask("Menu");
		$role->addChild("View Menu");
		$role->addChild("Update Menu");
		$role->addChild("Create Menu Item");
		$role->addChild("Update Menu Item");
		$role->addChild("Delete Menu Item");
		
		$role=$authManager->createTask("General");
		$role->addChild("Access Backend");
		
		$role=$authManager->createRole("Anonymous");
		$role->addChild("View Content");
		
		$role=$authManager->createRole("Editor");
		$role->addChild("User");
		$role->addChild("Manage User Groups");
		$role->addChild("Content");
		$role->addChild("Menu");
		$role->addChild("Access Backend");
		
		$role=$authManager->createRole("Admin");
		$role->addChild("User");
		$role->addChild("Content");
		$role->addChild("Menu");
		$role->addChild("General");
		$role->addChild("Update Settings");
		$role->addChild("Update Content Type Structure");
		
		$authManager->assign("Admin",1);
		$authManager->assign("Editor",2);
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