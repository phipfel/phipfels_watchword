<?php

namespace Phipfel\PhipfelsWatchword\Utility;


use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

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
 * WatchwordSettings
 */
class WatchwordSettings {

    /**
     * Settings
     *
     * @var array
     */
    protected $settings = [];

    /**
     * Returns the StoragePID
     *
     * @return int
     */
    public function getStoragePid() {
        return $this->settings['persistence']['storagePid'];
    }

    /**
     * Returns the information whether the holidays should be displayed or not
     *
     * @return bool
     */
    public function arePublicHolidaysEnabled() {
        return $this->settings['features']['enablePublicHoliays'];
    }

    /**
     * Returns the information whether the automatic download is enabled or not
     *
     * @return bool
     */
    public function isAutoDownloadEnabled() {
        return $this->settings['features']['autoDownload'];
    }

    /**
     * Returns the dateFormat-String
     *
     * @return string
     */
    public function getDateFormat() {
        return $this->settings['features']['dateFormatFluid'];
    }

    /**
     * Inject settings via ConfigurationManager.
     *
     * @param ConfigurationManagerInterface $configurationManager
     */
    public function injectConfigurationManager(ConfigurationManagerInterface $configurationManager) {
        $this->settings = $configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
        );
    }
}