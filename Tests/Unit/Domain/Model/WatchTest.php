<?php

namespace TYPO3\PhipfelsWatchword\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Philipp Schumann <ph.schumann@gmx.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class \TYPO3\PhipfelsWatchword\Domain\Model\Watchword.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Philipp Schumann <ph.schumann@gmx.de>
 */
class WatchwordTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \TYPO3\PhipfelsWatchword\Domain\Model\Watchword
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = new \TYPO3\PhipfelsWatchword\Domain\Model\Watchword();
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getDateReturnsInitialValueForDateTime() {
		$this->assertEquals(
			NULL,
			$this->subject->getDate()
		);
	}

	/**
	 * @test
	 */
	public function setDateForDateTimeSetsDate() {
		$dateTimeFixture = new \DateTime();
		$this->subject->setDate($dateTimeFixture);

		$this->assertAttributeEquals(
			$dateTimeFixture,
			'date',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getPublicHolidayReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getPublicHoliday()
		);
	}

	/**
	 * @test
	 */
	public function setPublicHolidayForStringSetsPublicHoliday() {
		$this->subject->setPublicHoliday('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'publicHoliday',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getWatchwordReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getWatchword()
		);
	}

	/**
	 * @test
	 */
	public function setWatchwordForStringSetsWatchword() {
		$this->subject->setWatchword('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'watchword',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getWatchwordPassageReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getWatchwordPassage()
		);
	}

	/**
	 * @test
	 */
	public function setWatchwordPassageForStringSetsWatchwordPassage() {
		$this->subject->setWatchwordPassage('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'watchwordPassage',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getInstructiveTextReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getInstructiveText()
		);
	}

	/**
	 * @test
	 */
	public function setInstructiveTextForStringSetsInstructiveText() {
		$this->subject->setInstructiveText('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'instructiveText',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getInstructiveTextPassageReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getInstructiveTextPassage()
		);
	}

	/**
	 * @test
	 */
	public function setInstructiveTextPassageForStringSetsInstructiveTextPassage() {
		$this->subject->setInstructiveTextPassage('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'instructiveTextPassage',
			$this->subject
		);
	}
}
