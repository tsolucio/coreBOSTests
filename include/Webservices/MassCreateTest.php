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
include_once 'include/Webservices/Delete.php';
require_once 'include/Webservices/WebServiceErrorCode.php';

class MassCreateTest extends TestCase {
	/**
	 * Method testMassCreateCorrect
	 * @test
	 */
	public function testMassCreateCorrect() {
		global $current_user, $adb;
		$elements = array (
			array (
				'elementType' => 'HelpDesk',
				'referenceId' => '',
				'element' => array (
					'ticket_title' => 'support ticket MassCreate Test 1',
					'parent_id' => '@{refAccount1}',
					'assigned_user_id' => '19x5',
					'product_id' => '@{refProduct}',
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
					'ticket_title' => 'support ticket MassCreate Test 2',
					'parent_id' => '@{refAccount2}',
					'assigned_user_id' => '19x5',
					'product_id' => '@{refProduct}',
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
					'ticket_title' => 'support ticket MassCreate Test 3',
					'parent_id' => '@{refAccount1}',
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
				'referenceId' => 'refProduct',
				'element' => array (
					'productname' => 'MassCreate Test',
					'website' => 'https://corebos.org',
					'assigned_user_id' => '19x1',
					'description' => 'mass create product test',
			  ),
			),
		);
		$accounts_res = $adb->pquery(
			'select accountid from vtiger_account inner join vtiger_crmentity on crmid=accountid where deleted=0 and accountname like \'%MassCreate Test%\'',
			array()
		);
		$helpdesk_res = $adb->pquery(
			'select ticketid from vtiger_troubletickets inner join vtiger_crmentity on crmid=ticketid where deleted=0 and title like \'%MassCreate Test%\'',
			array()
		);
		$products_res = $adb->pquery(
			'select productid from vtiger_products inner join vtiger_crmentity on crmid=productid where deleted=0 and productname like \'%MassCreate Test%\'',
			array()
		);

		$this->assertEquals(0, $adb->num_rows($accounts_res));
		$this->assertEquals(0, $adb->num_rows($helpdesk_res));
		$this->assertEquals(0, $adb->num_rows($products_res));

		MassCreate($elements, $current_user);

		$accounts_res = $adb->pquery(
			'select accountid from vtiger_account inner join vtiger_crmentity on crmid=accountid where deleted=0 and accountname like \'%MassCreate Test%\'',
			array()
		);
		$helpdesk_res = $adb->pquery(
			'select ticketid from vtiger_troubletickets inner join vtiger_crmentity on crmid=ticketid where deleted=0 and title like \'%MassCreate Test%\'',
			array()
		);
		$products_res = $adb->pquery(
			'select productid from vtiger_products inner join vtiger_crmentity on crmid=productid where deleted=0 and productname like \'%MassCreate Test%\'',
			array()
		);

		// test have been created
		$this->assertEquals(3, $adb->num_rows($accounts_res));
		$this->assertEquals(3, $adb->num_rows($helpdesk_res));
		$this->assertEquals(1, $adb->num_rows($products_res));
		// test have been related
		$accids = array();
		while ($acc = $adb->fetch_array($accounts_res)) {
			$accids[] = $acc['accountid'];
		}
		$pdoids = array();
		while ($pdo = $adb->fetch_array($products_res)) {
			$pdoids[] = $pdo['productid'];
		}
		$helpdesk_res = $adb->pquery(
			'select ticketid from vtiger_troubletickets
			inner join vtiger_crmentity on crmid=ticketid
			where deleted=0 and title like ? and parent_id in (?,?,?) and product_id in (2617,?)',
			array_merge(array('%MassCreate Test%'), $accids, $pdoids)
		);
		$this->assertEquals(3, $adb->num_rows($helpdesk_res));

		// Cleaning
		foreach ($accids as $accid) {
			vtws_delete('11x'.$accid, $current_user);
		}
		if ($helpdesk_res && $adb->num_rows($helpdesk_res) > 0) {
			while ($row = $adb->fetch_array($helpdesk_res)) {
				vtws_delete('17x'.$row['ticketid'], $current_user);
			}
		}
		foreach ($pdoids as $pdoid) {
			vtws_delete('14x'.$pdoid, $current_user);
		}
	}

	/**
	 * Method testMassUpsertSearchOn
	 * @test
	 */
	public function testMassUpsertSearchOn() {
		global $current_user, $adb;
		$elements = array (
			array (
				'elementType' => 'HelpDesk',
				'referenceId' => '',
				'element' => array (
					'ticket_title' => 'support ticket MassUpsert Test 1',
					'parent_id' => '@{refAccount1}',
					'assigned_user_id' => '19x5',
					'product_id' => '14x2617',
					'ticketpriorities' => 'Low',
					'ticketstatus' => 'Open',
					'ticketseverities' => 'Minor',
					'hours' => '1.1',
					'ticketcategories' => 'Small Problem',
					'days' => '1',
					'description' => 'ST mass upsert test 1',
					'solution' => '',
				),
			),
			array (
				'elementType' => 'HelpDesk',
				'referenceId' => '',
				'searchon' => 'ticket_title,product_id',
				'element' => array (
					'ticket_title' => 'support ticket MassUpsert Test 1',
					'parent_id' => '@{refAccount2}',
					'assigned_user_id' => '19x5',
					'product_id' => '14x2617',
					'ticketpriorities' => 'Normal',
					'ticketstatus' => 'Closed',
					'ticketseverities' => 'Major',
					'hours' => '2.2',
					'ticketcategories' => 'Big Problem',
					'days' => '2',
					'description' => 'ST mass upsert test 2',
					'solution' => '2',
				),
			),
			array (
				'elementType' => 'Accounts',
				'referenceId' => 'refAccount1',
				'element' => array (
					'accountname' => 'MassUpsert Test 1',
					'website' => 'https://corebos.org',
					'assigned_user_id' => '19x5',
					'description' => 'mass upsert test',
				),
			),
			array (
				'elementType' => 'Accounts',
				'referenceId' => 'refAccount2',
				'searchon' => 'accountname',
				'element' => array (
					'accountname' => 'Kvoo Radio',
					'cf_725' => 'https://corebos.org',
					'cf_718' => 'mass upsert test',
				),
			),
		);
		$accounts_res = $adb->pquery(
			'select accountid from vtiger_account inner join vtiger_crmentity on crmid=accountid where deleted=0 and accountname like \'%MassUpsert Test%\'',
			array()
		);
		$helpdesk_res = $adb->pquery(
			'select ticketid from vtiger_troubletickets inner join vtiger_crmentity on crmid=ticketid where deleted=0 and title like \'%MassUpsert Test%\'',
			array()
		);

		$this->assertEquals(0, $adb->num_rows($accounts_res));
		$this->assertEquals(0, $adb->num_rows($helpdesk_res));

		MassCreate($elements, $current_user);

		$accounts_res = $adb->pquery(
			'select accountid from vtiger_account inner join vtiger_crmentity on crmid=accountid where deleted=0 and accountname like \'%MassUpsert Test%\'',
			array()
		);
		$helpdesk_res = $adb->pquery(
			'select ticketid from vtiger_troubletickets inner join vtiger_crmentity on crmid=ticketid where deleted=0 and title like \'%MassUpsert Test%\'',
			array()
		);

		// test have been created
		$this->assertEquals(1, $adb->num_rows($accounts_res));
		$this->assertEquals(1, $adb->num_rows($helpdesk_res));
		// test have been related
		$helpdesk_res = $adb->pquery(
			'select ticketid from vtiger_troubletickets
			inner join vtiger_crmentity on crmid=ticketid
			where deleted=0 and title like ? and parent_id=885 and product_id=2617',
			array('%MassUpsert Test%')
		);
		$this->assertEquals(1, $adb->num_rows($helpdesk_res));

		// Cleaning
		$acc = $adb->fetch_array($accounts_res);
		vtws_delete('11x'.$acc['accountid'], $current_user);
		if ($helpdesk_res && $adb->num_rows($helpdesk_res) > 0) {
			while ($row = $adb->fetch_array($helpdesk_res)) {
				vtws_delete('17x'.$row['ticketid'], $current_user);
			}
		}
	}

	/**
	 * Method testMassUpsertCondition
	 * @test
	 */
	public function testMassUpsertCondition() {
		global $current_user, $adb;
		$elements = array (
			array (
				'elementType' => 'HelpDesk',
				'referenceId' => '',
				'searchon' => 'ticket_title,product_id',
				'condition' => 'getWhatToDoForMassCreate',
				'element' => array (
					'ticket_title' => 'ST MassUpsert Test Condition Skip',
					'whattodo' => 'skip',
					'parent_id' => '11x74',
					'assigned_user_id' => '19x5',
					'product_id' => '14x2617',
					'ticketpriorities' => 'Low',
					'ticketstatus' => 'Open',
					'ticketseverities' => 'Minor',
					'hours' => '1.1',
					'ticketcategories' => 'Small Problem',
					'days' => '1',
					'description' => 'ST mass upsert test condition',
					'solution' => '',
				),
			),
			array (
				'elementType' => 'HelpDesk',
				'referenceId' => '',
				'searchon' => 'ticket_title,product_id',
				'condition' => 'getWhatToDoForMassCreate',
				'element' => array (
					'ticket_title' => 'ST MassUpsert Test Condition Create',
					'whattodo' => 'create',
					'parent_id' => '11x74',
					'assigned_user_id' => '19x5',
					'product_id' => '14x2617',
					'ticketpriorities' => 'Normal',
					'ticketstatus' => 'Closed',
					'ticketseverities' => 'Major',
					'hours' => '2.2',
					'ticketcategories' => 'Big Problem',
					'days' => '2',
					'description' => 'ST mass upsert test condition',
					'solution' => '2',
				),
			),
		);
		$helpdesk_res = $adb->pquery(
			'select ticketid from vtiger_troubletickets inner join vtiger_crmentity on crmid=ticketid where deleted=0 and title like \'%ST MassUpsert Test Condition%\'',
			array()
		);
		$this->assertEquals(0, $adb->num_rows($helpdesk_res));

		$r = MassCreate($elements, $current_user);
		$this->assertEquals(2, count($r));
		$this->assertEquals(2, count($r['success_creates']));
		$this->assertEquals(1, count($r['success_creates'][0]));
		$this->assertEquals(0, $r['success_creates'][0]['id']);
		$this->assertEquals(0, count($r['failed_creates']));

		$helpdesk_res = $adb->pquery(
			'select ticketid from vtiger_troubletickets inner join vtiger_crmentity on crmid=ticketid where deleted=0 and title like \'%ST MassUpsert Test Condition%\'',
			array()
		);
		$row = $adb->fetch_array($helpdesk_res);

		// test have been created
		$this->assertEquals(1, $adb->num_rows($helpdesk_res));

		// test Update
		$elements = array (
			array (
				'elementType' => 'HelpDesk',
				'referenceId' => '',
				'searchon' => 'ticket_title',
				'condition' => 'getWhatToDoForMassCreate',
				'element' => array (
					'ticket_title' => 'ST MassUpsert Test Condition Update',
					'whattodo' => 'update',
					'id' => $row['ticketid'],
					'parent_id' => '11x74',
					'assigned_user_id' => '19x8',
					'product_id' => '14x2617',
					'ticketpriorities' => 'Normal',
					'ticketstatus' => 'Closed',
					'ticketseverities' => 'Major',
					'hours' => '4.4',
					'ticketcategories' => 'Big Problem',
					'days' => '2',
					'description' => 'ST mass upsert test condition',
					'solution' => '2',
				),
			),
		);
		$r = MassCreate($elements, $current_user);
		$this->assertEquals(2, count($r));
		$this->assertEquals(1, count($r['success_creates']));
		$this->assertEquals('ST MassUpsert Test Condition Update', $r['success_creates'][0]['ticket_title']);
		$this->assertEquals(0, count($r['failed_creates']));
		$hdres = $adb->pquery(
			'select smownerid,hours,title from vtiger_troubletickets inner join vtiger_crmentity on crmid=ticketid where ticketid=?',
			array($row['ticketid'])
		);
		$hd = $adb->fetch_array($hdres);
		$this->assertEquals(8, $hd['smownerid']);
		$this->assertEquals('4.400000', $hd['hours']);
		$this->assertEquals('ST MassUpsert Test Condition Update', $hd['title']);

		// Cleaning
		vtws_delete('17x'.$row['ticketid'], $current_user);
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
					'parent_id' => '@{refAccount1XX}',
					'assigned_user_id' => '19x5',
					'product_id' => '@{refProduct}',
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
					'parent_id' => '@{refAccount2}',
					'assigned_user_id' => '19x5',
					'product_id' => '@{refProduct}',
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
					'parent_id' => '@{refAccount1XX}',
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
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$REFERENCEINVALID);
		MassCreate($elements, $current_user);
	}

	/**
	 * Method testMassCreateReferenceIndex0
	 * @test
	 */
	public function testMassCreateReferenceIndex0() {
		global $current_user, $adb;
		$elements = array (
			array (
				'elementType' => 'Products',
				'referenceId' => 'refProduct',
				'element' => array (
					'productname' => 'MassCreate Test Index0',
					'website' => 'https://corebos.org',
					'assigned_user_id' => '19x1',
					'description' => 'mass create product test',
				),
			),
			array (
				'elementType' => 'HelpDesk',
				'referenceId' => '',
				'element' => array (
					'ticket_title' => 'support ticket Index0',
					'parent_id' => '11x74',
					'assigned_user_id' => '19x5',
					'product_id' => '@{refProduct}',
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
		);

		$helpdesk_res = $adb->pquery(
			'select ticketid from vtiger_troubletickets inner join vtiger_crmentity on crmid=ticketid where deleted=0 and title like \'%support ticket Index0%\'',
			array()
		);
		$products_res = $adb->pquery(
			'select productid from vtiger_products inner join vtiger_crmentity on crmid=productid where deleted=0 and productname like \'%MassCreate Test Index0%\'',
			array()
		);

		$this->assertEquals(0, $adb->num_rows($helpdesk_res));
		$this->assertEquals(0, $adb->num_rows($products_res));

		MassCreate($elements, $current_user);

		$helpdesk_res = $adb->pquery(
			'select ticketid from vtiger_troubletickets inner join vtiger_crmentity on crmid=ticketid where deleted=0 and title like \'%support ticket Index0%\'',
			array()
		);
		$products_res = $adb->pquery(
			'select productid from vtiger_products inner join vtiger_crmentity on crmid=productid where deleted=0 and productname like \'%MassCreate Test Index0%\'',
			array()
		);

		$this->assertEquals(1, $adb->num_rows($helpdesk_res));
		$this->assertEquals(1, $adb->num_rows($products_res));

		// Cleaning
		if ($helpdesk_res && $adb->num_rows($helpdesk_res) > 0) {
			while ($row = $adb->fetch_array($helpdesk_res)) {
				vtws_delete('17x'.$row['ticketid'], $current_user);
			}
		}
		if ($products_res && $adb->num_rows($products_res) > 0) {
			while ($row = $adb->fetch_array($products_res)) {
				vtws_delete('14x'.$row['productid'], $current_user);
			}
		}
	}

	/**
	 * Method testMassCreateCyclicReference
	 * @test
	 */
	public function testMassCreateCyclicReference() {
		global $current_user;
		$elements = array (
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
			array (
				'elementType' => 'cbCalendar',
				'referenceId' => 'cbcal1',
				'element' => array (
					'subject' => 'MassCreate Test 1',
					'dtstart' => '2020-08-10 02:49',
					'dtend' => '2020-08-10 12:49',
					'assigned_user_id' => '19x1',
					'relatedwith' => '@{cbcal2}',
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
					'relatedwith' => '@{cbcal1}',
					'description' => 'mass create product test',
				),
			),
		);
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$REFERENCEINVALID);
		MassCreate($elements, $current_user);
	}

	/**
	 * Method testMassCreateCyclicReferenceWithOneInMiddle
	 * @test
	 */
	public function testMassCreateCyclicReferenceWithOneInMiddle() {
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
					'relatedwith' => '@{cbcal2}',
					'description' => 'mass create product test',
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
			array (
				'elementType' => 'cbCalendar',
				'referenceId' => 'cbcal2',
				'element' => array (
					'subject' => 'MassCreate Test 2',
					'dtstart' => '2020-08-10 02:49',
					'dtend' => '2020-08-10 12:49',
					'assigned_user_id' => '19x1',
					'relatedwith' => '@{cbcal1}',
					'description' => 'mass create product test',
				),
			),
		);
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$REFERENCEINVALID);
		MassCreate($elements, $current_user);
	}

	/**
	 * Method testMassCreateCyclicReferenceWithCorrectOneInMiddle
	 * @test
	 */
	public function testMassCreateCyclicReferenceWithCorrectOneInMiddle() {
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
					'relatedwith' => '@{cbcal2}',
					'description' => 'mass create product test',
				),
			),
			array (
				'elementType' => 'Products',
				'referenceId' => 'refProduct',
				'element' => array (
					'productname' => 'MassCreate Test',
					'website' => 'https://corebos.org',
					'assigned_user_id' => '19x1',
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
					'relatedwith' => '@{cbcal1}',
					'description' => 'mass create product test',
				),
			),
			array (
				'elementType' => 'HelpDesk',
				'referenceId' => '',
				'element' => array (
					'ticket_title' => 'support ticket Index0',
					'parent_id' => '11x74',
					'assigned_user_id' => '19x5',
					'product_id' => '@{refProduct}',
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
		);
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$REFERENCEINVALID);
		MassCreate($elements, $current_user);
	}

	/**
	 * Method testMassCreateCyclicReferenceIndex0
	 * @test
	 */
	public function testMassCreateCyclicReferenceIndex0() {
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
					'relatedwith' => '@{cbcal2}',
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
					'relatedwith' => '@{cbcal1}',
					'description' => 'mass create product test',
				),
			),
		);
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$REFERENCEINVALID);
		MassCreate($elements, $current_user);
	}

	/**
	 * Method testMassCreateNoPermissionToCreate
	 * @test
	 */
	public function testMassCreateNoPermissionToCreate() {
		$user = new Users();
		///  nocreate
		$user->retrieveCurrentUserInfoFromFile(11); // nocreate

		$elements = array (
			array (
				'elementType' => 'HelpDesk',
				'referenceId' => '',
				'element' => array (
					'ticket_title' => 'support ticket MassCreate Test ss',
					'parent_id' => '11x74',
					'assigned_user_id' => '19x5',
					'product_id' => '@{refProduct}',
					'ticketpriorities' => 'Low',
					'ticketstatus' => 'Open',
					'ticketseverities' => 'Minor',
					'hours' => '1.1',
					'ticketcategories' => 'Small Problem',
					'days' => '1',
					'description' => 'ST mass create test ss',
					'solution' => '',
				),
			),
			array (
				'elementType' => 'Products',
				'referenceId' => 'refProduct',
				'element' => array (
					'productname' => 'MassCreate ssss',
					'website' => 'https://corebos.org',
					'assigned_user_id' => '19x1',
					'description' => 'mass create product test',
				),
			),
		);

		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		MassCreate($elements, $user);
	}

	/**
	 * Method testMassCreateNoPermissionToAccess
	 * @test
	 */
	public function testMassCreateNoPermissionToAccess() {
		$user = new Users();
		///  nocreate
		$user->retrieveCurrentUserInfoFromFile(11); // nocreate

		$elements = array (
			array (
				'elementType' => 'cbTermConditions',
				'referenceId' => '',
				'element' => array (
					'ticket_title' => 'support ticket MassCreate Test ss',
					'parent_id' => '11x74',
					'assigned_user_id' => '19x5',
					'product_id' => '14x95',
					'ticketpriorities' => 'Low',
					'ticketstatus' => 'Open',
					'ticketseverities' => 'Minor',
					'hours' => '1.1',
					'ticketcategories' => 'Small Problem',
					'days' => '1',
					'description' => 'ST mass create test ss',
					'solution' => '',
				),
			),
			array (
				'elementType' => 'Products',
				'referenceId' => 'refProduct',
				'element' => array (
					'productname' => 'MassCreate ssss',
					'website' => 'https://corebos.org',
					'assigned_user_id' => '19x1',
					'description' => 'mass create product test',
				),
			),
		);

		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		MassCreate($elements, $user);
	}

	/**
	 * Method testMassCreateWithMoreThen2RefFields
	 * @test
	 */
	public function testMassCreateWithMoreThen2RefFields() {
		global $current_user, $adb;
		$elements = array (
			array(
				"elementType"=>"Contacts",
				"referenceId"=> "rel_entity_contact_id_0",
				"searchon"=> "firstname,lastname",
				"element"=> array(
					"firstname"=>"Helga",
					"lastname"=>"Adams",
					"assigned_user_id"=> "19x1"
				)
			),
			array(
				"elementType"=>"Accounts",
				"referenceId"=>"rel_entity_account_id_1",
				"searchon"=>"accountname",
				"element"=> array(
					"accountname"=>"Helga",
					"assigned_user_id"=>"19x1",
				)
			),
			array(
				"elementType"=>"Invoice",
				"referenceId"=>"",
				"searchon"=>"",
				"element"=> array(
					"subject"=>"Invoice Helga 2022",
					"contact_id"=>"@{rel_entity_contact_id_0}",
					"account_id"=>"@{rel_entity_account_id_1}",
					"assigned_user_id"=>"19x1",
					"bill_street"=>"New York",
					"ship_street"=>"New York",
				)
			),
			array(
				"elementType"=>"Contacts",
				"referenceId"=>"rel_entity_contact_id_2",
				"searchon"=>"firstname,lastname",
				"element"=> array(
					"firstname"=>"John",
					"lastname"=>"Doe",
					"assigned_user_id"=>"19x1",
				)
			),
			array(
				"elementType"=>"Accounts",
				"referenceId"=>"rel_entity_account_id_3",
				"searchon"=>"accountname",
				"element"=> array(
					"accountname"=>"Doe",
					"assigned_user_id"=>"19x1",
				)
			),
			array(
				"elementType"=>"Invoice",
				"referenceId"=>"",
				"searchon"=>"",
				"element"=> array(
					"subject"=>"Invoice Doe 2022",
					"contact_id"=>"@{rel_entity_contact_id_2}",
					"account_id"=>"@{rel_entity_account_id_3}",
					"assigned_user_id"=>"19x1",
					"bill_street"=>"London",
					"ship_street"=>"London",
				)
			),
			array(
				"elementType"=>"Contacts",
				"referenceId"=>"rel_entity_contact_id_4",
				"searchon"=>"firstname,lastname",
				"element"=> array(
					"firstname"=>"Molli",
					"lastname"=>"Williams",
					"assigned_user_id"=>"19x1",
				)
			),
			array(
				"elementType"=>"Accounts",
				"referenceId"=>"rel_entity_account_id_5",
				"searchon"=>"accountname",
				"element"=> array(
					"accountname"=>"Molli",
					"assigned_user_id"=>"19x1",
				)
			),
			array(
				"elementType"=>"Invoice",
				"referenceId"=>"",
				"searchon"=>"",
				"element"=> array(
					"subject"=>"Invoice Molli 2022",
					"contact_id"=>"@{rel_entity_contact_id_4}",
					"account_id"=>"@{rel_entity_account_id_5}",
					"assigned_user_id"=>"19x1",
					"bill_street"=>"Paris",
					"ship_street"=>"Paris",
				)
			)
		);
		$r = MassCreate($elements, $current_user);
		$this->assertEquals(2, count($r));
		$this->assertEquals(9, count($r['success_creates']));
		$this->assertEquals(0, count($r['failed_creates']));
	}
}
?>