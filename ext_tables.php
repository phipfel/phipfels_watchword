<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'TYPO3.' . $_EXTKEY,
	'Displaywatchword',
	'Herrnhuter Losung'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Herrnhuter Losung');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_phipfelswatchword_domain_model_watchword', 'EXT:phipfels_watchword/Resources/Private/Language/locallang_csh_tx_phipfelswatchword_domain_model_watchword.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_phipfelswatchword_domain_model_watchword');