<?php

namespace Phipfel\PhipfelsWatchword\Domain\Repository;


use Phipfel\PhipfelsWatchword\Domain\Model\Watchword;

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

    /**
     * @param int $storagePID
     * @return integer Count of available watchwords for the current year
     */
    public function getWatchwordCountForCurrentYear($storagePID) {
        $query = $this->createQuery();

        $query->statement("
			SELECT	COUNT(*) AS CNT
			FROM 	tx_phipfelswatchword_domain_model_watchword
			WHERE	DATE_FORMAT(CURDATE(), '%Y') = DATE_FORMAT(date, '%Y')
					AND deleted = FALSE
					AND hidden = FALSE
					AND pid = " . $storagePID
        );

        return $query->execute(true)[0]['CNT'];
    }

    /**
     * @param int $storagePID
     * @return Watchword watchword for the current day
     */
    public function getCurrentWatchword($storagePID) {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals('date', date("Y-m-d")),
                $query->equals('deleted', FALSE),
                $query->equals('hidden', FALSE),
                $query->equals('pid', $storagePID)
            )
        );
        return $query->execute();
    }

    /**
     * Inserts watchword into database
     *
     * @param Watchword $watchword
     * @return void
     */
    public function insertWatchwordRecord($watchword) {
        $this->add($watchword);
    }
}