<?php
return array(
	'basic' => array (
		'id' => 'basic',
		'name' => 'Basic Content',
		'fields' => array(
			'content' => 'text',
			'file' => 'string',
			'image' => 'string',
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
	'event' => array (
		'id' => 'event',
		'name' => 'Event',
		'fields' => array(
			'content' => 'text',
			'event_start' => 'datetime',
			'event_end' => 'datetime',
		),
		'rules' => array (
			array('content', 'length', 'max'=>255),
			array('event_start, event_end', 'date', 'format'=>'m/d/Y'),
		),
		'inputTypes' => array (
			'file' => 'fileField',
		)
	),
	'homepage' => array (
		'id' => 'homepage',
		'name' => 'Home Page',
		'fields' => array(
			'meta_keywords' => 'string',
			'meta_description' => 'string',
			'content' => 'text',
			'secondary_content' => 'text',
		),
		'rules' => array (
			array('meta_keywords, meta_description', 'length', 'max'=>255),
			array('content, secondary_content', 'safe'),
		),
		'inputTypes' => array (
			'file' => 'fileField',
		)
	),
);