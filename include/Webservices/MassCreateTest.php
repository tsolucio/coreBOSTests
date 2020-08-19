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

use PHPUnit\Framework\TestCase;

include_once 'include/Webservices/MassCreate.php';

class testWSMassCreate extends TestCase {
	/**
	 * Method testMassCreate
	 * @test
	 */
	public function testMassCreate() {
		global $current_user;
		$elements = array (
			array (
				'elementType' => 'HelpDesk',
				'referenceId' => '',
				'element' => array (
					'ticket_title' => 'support ticket 1',
					'parent_id' => '@{refAccount1.id}',
					'assigned_user_id' => '19x5',
					'product_id' => '@{refProduct.id}',
					'ticketpriorities' => 'Low',
					'ticketstatus' => 'Open',
					'ticketseverities' => 'Minor',
					'hours' => '1.1',
					'ticketcategories' => 'Small Problem',
					'days' => '1',
					'description' => 'ST mass create test 1',
					'solution' => '',
				),
			),
			array (
				'elementType' => 'HelpDesk',
				'referenceId' => '',
				'element' => array (
					'ticket_title' => 'support ticket 2',
					'parent_id' => '@{refAccount2.id}',
					'assigned_user_id' => '19x5',
					'product_id' => '@{refProduct.id}',
					'ticketpriorities' => 'Low',
					'ticketstatus' => 'Open',
					'ticketseverities' => 'Minor',
					'hours' => '1.1',
					'ticketcategories' => 'Small Problem',
					'days' => '1',
					'description' => 'ST mass create test 2',
					'solution' => '',
				),
			),
			array (
				'elementType' => 'HelpDesk',
				'referenceId' => '',
				'element' => array (
					'ticket_title' => 'support ticket 3',
					'parent_id' => '@{refAccount1.id}',
					'assigned_user_id' => '19x5',
					'product_id' => '14x2617',
					'ticketpriorities' => 'Low',
					'ticketstatus' => 'Open',
					'ticketseverities' => 'Minor',
					'hours' => '1.1',
					'ticketcategories' => 'Small Problem',
					'days' => '1',
					'description' => 'ST mass create test 3',
					'solution' => '',
				),
			),
			array (
				'elementType' => 'Accounts',
				'referenceId' => 'refAccount1',
				'element' => array (
					'accountname' => 'MassCreate Test 1',
					'website' => 'https://corebos.org',
					'assigned_user_id' => '19x5',
					'description' => 'mass create test',
				),
			),
			array (
				'elementType' => 'Accounts',
				'referenceId' => 'refAccount2',
				'element' => array (
					'accountname' => 'MassCreate Test 2',
					'website' => 'https://corebos.org',
					'assigned_user_id' => '19x5',
					'description' => 'mass create test',
				),
			),
			array (
				'elementType' => 'Accounts',
				'referenceId' => '',
				'element' => array (
					'accountname' => 'MassCreate Test',
					'website' => 'https://corebos.org',
					'assigned_user_id' => '19x1',
					'description' => 'mass create just another account with no relations',
			  ),
			),
			array (
				'elementType' => 'Products',
				'referenceId' => '',
				'element' => array (
					'productname' => 'MassCreate Test',
					'website' => 'https://corebos.org',
					'assigned_user_id' => '19x1',
					'description' => 'mass create product test',
			  ),
			),
		);
		$actual = MassCreate($elements, $current_user);
		$expected_success = 7;
		$expected_fail = 0;
		$this->assertEquals($expected_success, count($actual['success_creates']), 'MassCreate with Reference - Success');
		$this->assertEquals($expected_fail, count($actual['failed_creates']), 'MassCreate with Reference -  Failed');
	}

	/**
	 * Method testMassCreateWrongReference
	 * @test
	 */
	public function testMassCreateWrongReference() {
		global $current_user;
		$elements = array (
			array (
				'elementType' => 'HelpDesk',
				'referenceId' => '',
				'element' => array (
					'ticket_title' => 'support ticket 1',
					'parent_id' => '@{refAccount1XX.id}',
					'assigned_user_id' => '19x5',
					'product_id' => '@{refProduct.id}',
					'ticketpriorities' => 'Low',
					'ticketstatus' => 'Open',
					'ticketseverities' => 'Minor',
					'hours' => '1.1',
					'ticketcategories' => 'Small Problem',
					'days' => '1',
					'description' => 'ST mass create test 1',
					'solution' => '',
				),
			),
			array (
				'elementType' => 'HelpDesk',
				'referenceId' => '',
				'element' => array (
					'ticket_title' => 'support ticket 2',
					'parent_id' => '@{refAccount2.id}',
					'assigned_user_id' => '19x5',
					'product_id' => '@{refProduct.id}',
					'ticketpriorities' => 'Low',
					'ticketstatus' => 'Open',
					'ticketseverities' => 'Minor',
					'hours' => '1.1',
					'ticketcategories' => 'Small Problem',
					'days' => '1',
					'description' => 'ST mass create test 2',
					'solution' => '',
				),
			),
			array (
				'elementType' => 'HelpDesk',
				'referenceId' => '',
				'element' => array (
					'ticket_title' => 'support ticket 3',
					'parent_id' => '@{refAccount1XX.id}',
					'assigned_user_id' => '19x5',
					'product_id' => '14x2617',
					'ticketpriorities' => 'Low',
					'ticketstatus' => 'Open',
					'ticketseverities' => 'Minor',
					'hours' => '1.1',
					'ticketcategories' => 'Small Problem',
					'days' => '1',
					'description' => 'ST mass create test 3',
					'solution' => '',
				),
			),
			array (
				'elementType' => 'Accounts',
				'referenceId' => 'refAccount1',
				'element' => array (
					'accountname' => 'MassCreate Test 1',
					'website' => 'https://corebos.org',
					'assigned_user_id' => '19x5',
					'description' => 'mass create test',
				),
			),
			array (
				'elementType' => 'Accounts',
				'referenceId' => 'refAccount2',
				'element' => array (
					'accountname' => 'MassCreate Test 2',
					'website' => 'https://corebos.org',
					'assigned_user_id' => '19x5',
					'description' => 'mass create test',
				),
			),
			array (
				'elementType' => 'Accounts',
				'referenceId' => '',
				'element' => array (
					'accountname' => 'MassCreate Test',
					'website' => 'https://corebos.org',
					'assigned_user_id' => '19x1',
					'description' => 'mass create just another account with no relations',
			  ),
			),
			array (
				'elementType' => 'Products',
				'referenceId' => '',
				'element' => array (
					'productname' => 'MassCreate Test',
					'website' => 'https://corebos.org',
					'assigned_user_id' => '19x1',
					'description' => 'mass create product test',
			  ),
			),
		);
		$actual = MassCreate($elements, $current_user);
		$expected_success = 5;
		$expected_fail = 2;
		$this->assertEquals($expected_success, count($actual['success_creates']), 'MassCreate with Wrong Reference - Success');
		$this->assertEquals($expected_fail, count($actual['failed_creates']), 'MassCreate with Wrong Reference -  Failed');
	}

	/**
	 * Method testMassCreatecbCalendar
	 * @test
	 */
	public function testMassCreatecbCalendar() {
		global $current_user;
		$elements = array (
			array (
				'elementType' => 'cbCalendar',
				'referenceId' => 'cbcal1',
				'element' => array (
					'subject' => 'MassCreate Test 1',
					'dtstart' => '2020-08-10 02:49',
					'dtend' => '2020-08-10 12:49',
					'assigned_user_id' => '19x1',
					'relatedwith' => '@{cbcal2.id}',
					'description' => 'mass create product test',
				),
			),
			array (
				'elementType' => 'cbCalendar',
				'referenceId' => 'cbcal2',
				'element' => array (
					'subject' => 'MassCreate Test 2',
					'dtstart' => '2020-08-10 02:49',
					'dtend' => '2020-08-10 12:49',
					'assigned_user_id' => '19x1',
					'relatedwith' => '@{cbcal1.id}',
					'description' => 'mass create product test',
				),
			),
		);
		$actual = MassCreate($elements, $current_user);
		$expected_success = 2;
		$expected_fail = 0;
		$this->assertEquals($expected_success, count($actual['success_creates']), 'MassCreate cbCalendar - Success');
		$this->assertEquals($expected_fail, count($actual['failed_creates']), 'MassCreate cbCalendar -  Failed');
		$this->assertEquals("", $actual['success_creates'][0]['relatedwith'], 'MassCreate cbCalendar -  Empty relation');
	}
}
?>