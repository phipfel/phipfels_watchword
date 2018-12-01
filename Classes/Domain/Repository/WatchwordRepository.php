<?php
namespace TYPO3\PhipfelsWatchword\Domain\Repository;
use TYPO3\CMS\Core\Utility\GeneralUtility;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Philipp Schumann <ph.schumann@gmx.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * The repository for Watchwords
 */
class WatchwordRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	public function upToDate($storagePID)
	{
		$query = $this->createQuery();

		$query->statement("
			SELECT	COUNT(*) AS CNT
			FROM 	tx_phipfelswatchword_domain_model_watchword
			WHERE	Date_format(Curdate(), '%Y') = Date_format(date, '%Y')
					AND deleted = FALSE
					AND hidden = FALSE
					AND pid = ".$storagePID
		);

		$result = $query->execute(true);

		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($result);

		if($result[0]['CNT'] > 0)
			return true;
		else
			return false;
	}

	public function downloadWatchword($storagePID){
		$currentPath = getcwd().'/';
		$typo3temp = $currentPath.'typo3temp/';
		$newWatchwordLocation = $typo3temp.'Losung'.date("Y").'/';
		$watchwordFile = 'Losung_'.date("Y").'_XML.zip';
		$watchwordFileWithPath = $typo3temp.$watchwordFile;

		//erstelle neues Verzeichnis
		if(!is_dir($newWatchwordLocation))
			mkdir($newWatchwordLocation);

		//download file of current year
		file_put_contents($watchwordFileWithPath, file_get_contents('http://www.brueder-unitaet.de/download/Losung_'.date("Y").'_XML.zip'));

		$zip = zip_open($watchwordFileWithPath);
		if (is_resource($zip)) {
			while (($zipEntry = zip_read($zip)) !== FALSE) {
				if (strpos(zip_entry_name($zipEntry), '/') !== FALSE) {
					$last = strrpos(zip_entry_name($zipEntry), '/');
					$dir = substr(zip_entry_name($zipEntry), 0, $last);
					$file = substr(zip_entry_name($zipEntry), strrpos(zip_entry_name($zipEntry), '/') + 1);
					if (!is_dir($dir)) {
						GeneralUtility::mkdir_deep($newWatchwordLocation . $dir);
					}
					if (strlen(trim($file)) > 0) {
						$return = GeneralUtility::writeFile($newWatchwordLocation . $dir . '/' . $file, zip_entry_read($zipEntry, zip_entry_filesize($zipEntry)));
						if ($return === FALSE) {
							echo 'Could not write file ' . $this->getRelativePath($file);
						}
					}
				} else {
					GeneralUtility::writeFile($newWatchwordLocation . zip_entry_name($zipEntry), zip_entry_read($zipEntry, zip_entry_filesize($zipEntry)));
				}
			}
		} else {
			echo 'Unable to open zip file ' . $this->getRelativePath($zip);
		}

		$watchwordXMLFile = $newWatchwordLocation.'Losungen Free '.date("Y").'.xml';

		if(is_file($watchwordXMLFile)) {
			$xml = simplexml_load_file ($watchwordXMLFile);

			$xmlArray = json_decode (json_encode ($xml), 1);

			//$i = 0;
			foreach ($xmlArray['Losungen'] as $xmlValue) {
				//if($i == 0)
					$this->insertWatchwordRecords ($xmlValue, $storagePID);

				//$i++;
			}
		}
		return 0;
	}

	public function insertWatchwordRecords($xmlArray, $storagePID) {
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$watchword = $objectManager->get('TYPO3\\PhipfelsWatchword\\Domain\\Model\\Watchword');

		//DatumWtagSonntagLosungstextLosungsversLehrtextLehrtextvers
		foreach($xmlArray as $xmlKey => $xmlValue) {
			if($xmlKey == 'Datum') {
				$date = new \DateTime($xmlValue);
				$watchword->setDate($date);
			}
			if($xmlKey == 'Sonntag')
				$watchword->setPublicHoliday($xmlValue);
			if($xmlKey == 'Losungstext')
				$watchword->setWatchword(str_replace('/', '', $xmlValue));
			if($xmlKey == 'Losungsvers')
				$watchword->setWatchwordPassage($xmlValue);
			if($xmlKey == 'Lehrtext')
				$watchword->setInstructiveText(str_replace('/', '', $xmlValue));
			if($xmlKey == 'Lehrtextvers')
				$watchword->setInstructiveTextPassage($xmlValue);
		}

		$watchword->setPid($storagePID);

		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($watchword);

		$this->add($watchword);
	}
}