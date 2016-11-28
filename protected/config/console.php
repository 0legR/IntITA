<?php
$local_config = require(dirname(__FILE__).'/local.php');
// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),
	'import' => array(
		'application.models.*',
		'application.models.user.*',
	),
	// application components
	'components'=>array(

		// database settings are configured in database.php
		'db'=>$local_config['db'],
        'dbForum'=>$local_config['dbForum'],

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),

	),
);
