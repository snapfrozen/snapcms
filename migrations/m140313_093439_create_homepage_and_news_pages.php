<?php

class m140313_093439_create_homepage_and_news_pages extends CDbMigration
{
	public function up()
	{
		//First make sure all tables are created
		$data = ContentType::findAll();
		foreach($data as $ct) 
		{ 
			$ct->checkForErrors();
			if($ct->hasSchemaErrors()) 
			{
				if(!$ct->tableExists()) {
					$ct->createTable();
				}
				if($ct->tableExists() && $ct->fieldsExist() !== true) 
				{
					$ct->createFields();
				}
			}
		}
		
		$this->insert('{{content}}', array(
			'id'=>'1',
			'title'=>'Welcome to My Website',
			'type'=>'homepage',
			'published' => '1',
			'created_by' => '1', //Admin
			'updated_by' => '1', //Admin
			'created' => new CDbExpression('NOW()'),
			'updated' => new CDbExpression('NOW()'),
		));
		$this->insert('{{content_homepage}}', array(
			'content_id'=>'1',
			'content'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut euismod vestibulum turpis, at consequat mi tincidunt non. Nulla consectetur ligula congue purus faucibus venenatis. Integer ac facilisis nunc. Nullam sodales lacus erat, dictum sollicitudin nunc tincidunt nec. Suspendisse potenti. Nam nec tincidunt metus. Nunc at odio iaculis, fringilla lectus ut, semper dui. Nullam pulvinar varius elementum. Cras dignissim risus a leo mattis, a lacinia ligula luctus. Fusce vitae placerat tellus, sed laoreet augue. Donec pulvinar dui sed enim sollicitudin consequat. Donec ut scelerisque ligula. Donec nec semper purus. Quisque ac consequat mauris. Suspendisse vulputate neque feugiat auctor convallis. Aenean ut erat euismod, volutpat mi non, varius odio.',
			'content_2'=>'Nunc eu laoreet nibh, vitae hendrerit urna. Sed egestas sapien vitae sem suscipit, et blandit justo sagittis. Integer ut posuere sapien, non dictum est. Morbi lobortis ut eros convallis dictum. Sed leo odio, cursus sit amet tincidunt at, ultrices a purus. Integer vestibulum luctus urna sed suscipit. Integer non massa fermentum, egestas lorem in, congue urna. Vestibulum ligula diam, egestas sed nulla sed, consectetur laoreet massa. In leo ligula, elementum ac mattis quis, congue et neque. Donec nulla arcu, consectetur vitae pharetra vitae, posuere eget tellus. In leo purus, lacinia non libero sed, mattis sollicitudin ante. ',
			'meta_keywords' => 'some,keywords,here',
			'meta_description' => 'A meta description can go here',
		));
		
		$this->insert('{{content}}', array(
			'id'=>'2',
			'title'=>'News',
			'path'=>'/news',
			'type'=>'news_list',
			'published' => '1',
			'created_by' => '1', //Admin
			'updated_by' => '1', //Admin
			'created' => new CDbExpression('NOW()'),
			'updated' => new CDbExpression('NOW()'),
		));
		$this->insert('{{content_news_list}}', array(
			'content_id'=>'2',
			'content'=>'',
			'meta_keywords' => 'some,keywords,here',
			'meta_description' => 'A meta description can go here',
		));
		$this->insert('{{menu_items}}', array(
			'title'=>'News',
			'menu_id' => 'main_menu',
			'content_id'=>'2',
			'created' => new CDbExpression('NOW()'),
			'updated' => new CDbExpression('NOW()'),
		));
		$this->insert('{{menu_items}}', array(
			'title'=>'Contact',
			'menu_id' => 'main_menu',
			'external_path' => '/site/contact',
			'created' => new CDbExpression('NOW()'),
			'updated' => new CDbExpression('NOW()'),
		));
		
		//Not sure why this doen't work?
		Yii::log('SnapCMS installed.','info','installation');
	}

	public function down()
	{
		echo "m140313_093439_create_homepage_and_news_pages does not support migration down.\n";
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