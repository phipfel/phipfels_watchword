<?php

namespace Phipfel\PhipfelsWatchword\Domain\Model;


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
 * Watchword
 */
class Watchword extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * date
	 *
	 * @var \DateTime
	 */
	protected $date = NULL;

	/**
	 * serverDate
	 *
	 * @var \DateTime
	 */
	protected $serverDate = NULL;

	/**
	 * publicHoliday
	 *
	 * @var string
	 */
	protected $publicHoliday = '';

	/**
	 * watchword
	 *
	 * @var string
	 */
	protected $watchword = '';

	/**
	 * watchwordPassage
	 *
	 * @var string
	 */
	protected $watchwordPassage = '';

	/**
	 * instructiveText
	 *
	 * @var string
	 */
	protected $instructiveText = '';

	/**
	 * instructiveTextPassage
	 *
	 * @var string
	 */
	protected $instructiveTextPassage = '';

	/**
	 * Returns the date
	 *
	 * @return \DateTime $date
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * Sets the date
	 *
	 * @param \DateTime $date
	 * @return void
	 */
	public function setDate(\DateTime $date) {
		$this->date = $date;
	}

	/**
	 * Returns the current date from server
	 *
	 * @return \DateTime $serverDate
	 */
	public function getServerDate() {
		return date("Y-m-d");
	}

	/**
	 * Returns the publicHoliday
	 *
	 * @return string $publicHoliday
	 */
	public function getPublicHoliday() {
		return $this->publicHoliday;
	}

	/**
	 * Sets the publicHoliday
	 *
	 * @param string $publicHoliday
	 * @return void
	 */
	public function setPublicHoliday($publicHoliday) {
		$this->publicHoliday = $publicHoliday;
	}

	/**
	 * Returns the watchword
	 *
	 * @return string $watchword
	 */
	public function getWatchword() {
		return $this->watchword;
	}

	/**
	 * Sets the watchword
	 *
	 * @param string $watchword
	 * @return void
	 */
	public function setWatchword($watchword) {
		$this->watchword = $watchword;
	}

	/**
	 * Returns the watchwordPassage
	 *
	 * @return string $watchwordPassage
	 */
	public function getWatchwordPassage() {
		return $this->watchwordPassage;
	}

	/**
	 * Sets the watchwordPassage
	 *
	 * @param string $watchwordPassage
	 * @return void
	 */
	public function setWatchwordPassage($watchwordPassage) {
		$this->watchwordPassage = $watchwordPassage;
	}

	/**
	 * Returns the instructiveText
	 *
	 * @return string $instructiveText
	 */
	public function getInstructiveText() {
		return $this->instructiveText;
	}

	/**
	 * Sets the instructiveText
	 *
	 * @param string $instructiveText
	 * @return void
	 */
	public function setInstructiveText($instructiveText) {
		$this->instructiveText = $instructiveText;
	}

	/**
	 * Returns the instructiveTextPassage
	 *
	 * @return string $instructiveTextPassage
	 */
	public function getInstructiveTextPassage() {
		return $this->instructiveTextPassage;
	}

	/**
	 * Sets the instructiveTextPassage
	 *
	 * @param string $instructiveTextPassage
	 * @return void
	 */
	public function setInstructiveTextPassage($instructiveTextPassage) {
		$this->instructiveTextPassage = $instructiveTextPassage;
	}

}