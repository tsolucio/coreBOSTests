<?php
/*************************************************************************************************
 * Copyright 2020 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
 * The MIT License (MIT)
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute,
 * sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or
 * substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT
 * NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *************************************************************************************************/
include_once 'modules/Mobile/api/ws/Utils.php';

use PHPUnit\Framework\TestCase;

class MobileWSUtilsTest extends TestCase {

	/**
	 * Method getModuleColumnTableByFieldNamesProvider
	 */
	public function getModuleColumnTableByFieldNamesProvider() {
		return array(
			array(
				'Potentials',
				array('email', 'potentialname', 'createdtime'),
				array(
					'email' => array(
						'column' => 'email',
						'table' => 'vtiger_potential',
					),
					'potentialname' => array(
						'column' => 'potentialname',
						'table' => 'vtiger_potential',
					),
					'createdtime' => array(
						'column' => 'createdtime',
						'table' => 'vtiger_crmentity',
					),
				),
			),
			array(
				'HelpDesk',
				array('ticketpriorities', 'assigned_user_id'),
				array(
					'ticketpriorities' => array(
						'column' => 'priority',
						'table' => 'vtiger_troubletickets',
					),
					'assigned_user_id' => array(
						'column' => 'smownerid',
						'table' => 'vtiger_crmentity',
					),
				),
			),
			array(
				'HelpDesk',
				array('fieldoesnotexist', 'assigned_user_id'),
				array('assigned_user_id' => array('column' => 'smownerid', 'table' => 'vtiger_crmentity')),
			),
			array(
				'HelpDesk',
				array('fieldoesnotexist'),
				array(),
			),
			array(
				'ModuleDoesNotExist',
				array('ticketpriorities', 'smownerid'),
				array(),
			),
		);
	}

	/**
	 * Method testgetModuleColumnTableByFieldNames
	 * @test
	 * @dataProvider getModuleColumnTableByFieldNamesProvider
	 */
	public function testgetModuleColumnTableByFieldNames($module, $fieldnames, $expected) {
		$actual = crmtogo_WS_Utils::getModuleColumnTableByFieldNames($module, $fieldnames);
		$this->assertEquals($expected, $actual, $module);
	}
}
?>