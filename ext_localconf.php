<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Phipfel.' . $_EXTKEY,
	'Displaywatchword',
	array(
		'Watchword' => 'list, create',
	),
	// non-cacheable actions
	array(
		'Watchword' => '',
	)
);
