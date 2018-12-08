<?php

namespace Phipfel\PhipfelsWatchword\Controller;


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
 * WatchwordController
 */
class WatchwordController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * watchwordService
     *
     * @var \Phipfel\PhipfelsWatchword\Service\WatchwordService
     * @inject
     */
    protected $watchwordService;

    /**
     * @var \Phipfel\PhipfelsWatchword\Utility\WatchwordSettings
     * @inject
     */
    protected $watchwordSettings;

    /**
     * action list
     *
     * @return void
     */
    public function listAction() {
        $storagePidNotSet = true;
        if ($this->watchwordSettings->getStoragePid() !== '') {
            $storagePidNotSet = false;
            if (!$this->watchwordService->isUpToDate() && $this->watchwordSettings->isAutoDownloadEnabled()) {
                $this->watchwordService->downloadWatchword();
            }
        }

        // Set View-Variables
        $this->view->assign('storagePidNotSet', $storagePidNotSet);
        $this->view->assign('watchword', $this->watchwordService->getCurrentWatchword());
        $this->view->assign('enablePublicHolidays', $this->watchwordSettings->arePublicHolidaysEnabled());
        $this->view->assign('dateFormatFluid', $this->watchwordSettings->getDateFormat());
    }
}