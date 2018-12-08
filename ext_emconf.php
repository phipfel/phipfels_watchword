<?php

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Herrnhuter Losung',
	'description' => 'Contains the current watchword from the Herrnhuter Brüdergemeine / Losungen',
	'category' => 'plugin',
	'author' => 'Philipp Schumann',
	'author_email' => 'ph.schumann@gmx.de',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'clearCacheOnLoad' => true,
	'version' => '2.0.1',
	'constraints' => array(
		'depends' => array(
			'typo3' => '9.0.0-9.99.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
    'autoload' => [
        'psr-4' => [
            'Phipfel\\PhipfelsWatchword\\' => 'Classes'
        ]
    ],
);