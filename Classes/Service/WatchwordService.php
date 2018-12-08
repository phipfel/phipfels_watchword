<?php

namespace Phipfel\PhipfelsWatchword\Service;


use Phipfel\PhipfelsWatchword\Domain\Model\Watchword;
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
 * WatchwordService
 */
class WatchwordService {
    /**
     * watchwordRepository
     *
     * @var \Phipfel\PhipfelsWatchword\Domain\Repository\WatchwordRepository
     * @inject
     */
    protected $watchwordRepository;

    /**
     * @var \Phipfel\PhipfelsWatchword\Utility\WatchwordSettings
     * @inject
     */
    protected $watchwordSettings;

    /**
     * @return Watchword
     */
    public function getCurrentWatchword() {
        $watchwords = $this->watchwordRepository->getCurrentWatchword($this->watchwordSettings->getStoragePid());
        if (sizeof($watchwords) !== 1) {
            return null;
        }

        return $watchwords[0];
    }

    /**
     * @return bool
     */
    public function isUpToDate() {
        return $this->watchwordRepository->getWatchwordCountForCurrentYear($this->watchwordSettings->getStoragePid()) > 0 ? true : false;
    }

    /**
     * Downloads XML-file, create folders and start insert into database
     */
    public function downloadWatchword() {
        $typo3temp = PATH_site . '/typo3temp/';
        $watchwordFolder = $typo3temp . 'phipfels_watchword/';
        $currentYear = date("Y");

        //general watchword-folder: xyz/typo3temp/ -> phipfels_watchword/
        if (!is_dir($watchwordFolder)) {
            GeneralUtility::mkdir_deep($watchwordFolder);
        }

        //folder for the current year: xyz/typo3temp/phipfels_watchword/ -> e.g. 2018/
        $newWatchwordLocation = $watchwordFolder . $currentYear . '/';
        $newWatchwordFilename = 'Losung_' . $currentYear . '_XML.zip';
        $newWatchwordFileWithPath = $newWatchwordLocation . $newWatchwordFilename;

        //create new watchword-direcotry if none exists
        if (!is_dir($newWatchwordLocation)) {
            GeneralUtility::mkdir_deep($newWatchwordLocation);
        }

        //download file for current year
        file_put_contents($newWatchwordFileWithPath, file_get_contents('http://www.brueder-unitaet.de/download/Losung_' . $currentYear . '_XML.zip'));

        $zip = zip_open($newWatchwordFileWithPath);
        if (is_resource($zip)) {
            while (($zipEntry = zip_read($zip))) {
                if (strpos(zip_entry_name($zipEntry), '/')) {
                    $last = strrpos(zip_entry_name($zipEntry), '/');
                    $dir = substr(zip_entry_name($zipEntry), 0, $last);
                    $file = substr(zip_entry_name($zipEntry), strrpos(zip_entry_name($zipEntry), '/') + 1);

                    if (!is_dir($dir)) {
                        GeneralUtility::mkdir_deep($newWatchwordLocation . $dir);
                    }
                    if (strlen(trim($file)) > 0) {
                        $return = GeneralUtility::writeFile($newWatchwordLocation . $dir . '/' . $file, zip_entry_read($zipEntry, zip_entry_filesize($zipEntry)));
                        if (!$return) {
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

        $watchwordXMLFile = $newWatchwordLocation . 'Losungen Free ' . $currentYear . '.xml';

        if (is_file($watchwordXMLFile)) {
            $xml = simplexml_load_file($watchwordXMLFile);

            $xmlArray = json_decode(json_encode($xml), 1);

            foreach ($xmlArray['Losungen'] as $xmlValue) {
                $this->insertWatchwordRecord($xmlValue);
            }
        }
    }

    /**
     * Triggers insert into database
     *
     * @param $xmlArray
     * @throws \Exception
     */
    protected function insertWatchwordRecord($xmlArray) {
        $watchword = new Watchword();

        foreach ($xmlArray as $xmlKey => $xmlValue) {
            if ($xmlKey == 'Datum') {
                $date = new \DateTime($xmlValue, new \DateTimeZone('UTC'));
                $watchword->setDate($date);
            } else if ($xmlKey == 'Sonntag') {
                $watchword->setPublicHoliday($xmlValue);
            } else if ($xmlKey == 'Losungstext') {
                $watchword->setWatchword(str_replace('/', '', $xmlValue));
            } else if ($xmlKey == 'Losungsvers') {
                $watchword->setWatchwordPassage($xmlValue);
            } else if ($xmlKey == 'Lehrtext') {
                $watchword->setInstructiveText(str_replace('/', '', $xmlValue));
            } else if ($xmlKey == 'Lehrtextvers') {
                $watchword->setInstructiveTextPassage($xmlValue);
            }
        }

        $watchword->setPid($this->watchwordSettings->getStoragePid());

        $this->watchwordRepository->insertWatchwordRecord($watchword);
    }
}