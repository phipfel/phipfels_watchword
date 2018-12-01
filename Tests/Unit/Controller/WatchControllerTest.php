<?php
namespace TYPO3\PhipfelsWatchword\Tests\Unit\Controller;
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
 * Test case for class TYPO3\PhipfelsWatchword\Controller\WatchwordController.
 *
 * @author Philipp Schumann <ph.schumann@gmx.de>
 */
class WatchwordControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \TYPO3\PhipfelsWatchword\Controller\WatchwordController
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = $this->getMock('TYPO3\\PhipfelsWatchword\\Controller\\WatchwordController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllWatchwordesFromRepositoryAndAssignsThemToView() {

		$allWatchwordes = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$watchwordRepository = $this->getMock('TYPO3\\PhipfelsWatchword\\Domain\\Repository\\WatchwordRepository', array('findAll'), array(), '', FALSE);
		$watchwordRepository->expects($this->once())->method('findAll')->will($this->returnValue($allWatchwordes));
		$this->inject($this->subject, 'watchwordRepository', $watchwordRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('watchwordes', $allWatchwordes);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}
}
