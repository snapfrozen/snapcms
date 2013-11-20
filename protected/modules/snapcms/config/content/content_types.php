<?php
return array(
	'page' => array (
		'id' => 'page',
		'name' => 'Page',
		'fields' => array(
			'content' => 'text',
			'meta_keywords' => 'string',
			'meta_description' => 'string',
		),
		'rules' => array (
			array('content', 'length', 'max'=>255),
			array('event_start, event_end', 'date', 'format'=>'m/d/Y'),
		),
		'inputTypes' => array (
			'file' => 'fileField',
			'meta_description' => 'textArea',
		)
	),
	'news' => array (
		'id' => 'news',
		'name' => 'News',
		'fields' => array(
			'content' => 'text',
			'image' => 'string',
			'file' => 'string',
			'meta_keywords' => 'string',
			'meta_description' => 'string',
		),
		'rules' => array (
			array('file, meta_keywords, meta_description', 'length', 'max'=>255),
			array('file', 'file'),
			array('image', 'file', 'types'=>'jpg, jpeg, gif, png'),
			array('content', 'safe'),
		),
		'inputTypes' => array (
			'image' => 'imageField',
			'file' => 'fileField',
			//'content' => 'textArea',
		)
	),
);