<?php
namespace TYPO3\PhipfelsWatchword\Controller;


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
	 * watchwordRepository
	 *
	 * @var \TYPO3\PhipfelsWatchword\Domain\Repository\WatchwordRepository
	 * @inject
	 */
	protected $watchwordRepository = NULL;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$storagePid = $extbaseFrameworkConfiguration['persistence']['storagePid'];
		$enablePublicHoliays = $extbaseFrameworkConfiguration['features']['enablePublicHoliays'];
		$autoDownload = $extbaseFrameworkConfiguration['features']['autoDownload'];
		$dateFormatFluid = $extbaseFrameworkConfiguration['features']['dateFormatFluid'];

		if(!$this->watchwordRepository->upToDate($storagePid) && $autoDownload)
			$this->watchwordRepository->downloadWatchword($storagePid);

		$watchwords = $this->watchwordRepository->findAll();
		$this->view->assign('watchwords', $watchwords);

		$this->view->assign('enablePublicHolidays', $enablePublicHoliays);
		$this->view->assign('dateFormatFluid', $dateFormatFluid);
	}

}