<?php
/*************************************************************************************************
 * Copyright 2018 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

include_once 'include/Webservices/getRelatedModules.php';
class getRelatedModulesTest extends TestCase {
	/**
	 * Method testgetRelatedModulesInfomation
	 * @test
	 */
	public function testgetRelatedModulesInfomation() {
		global $current_user;
		$currentModule = 'Accounts';
		$actual = getRelatedModulesInfomation($currentModule, $current_user);
		$expected = array(
			'Contacts' => array(
				'related_tabid' => '4',
				'related_module' => 'Contacts',
				'label' => 'Contacts',
				'labeli18n' => 'Contacts',
				'actions' => 'add',
				'relationId' => '1',
			),
			'Potentials' => array(
				'related_tabid' => '2',
				'related_module' => 'Potentials',
				'label' => 'Potentials',
				'labeli18n' => 'Opportunities',
				'actions' => 'add',
				'relationId' => '2',
			),
			'Quotes' => array(
				'related_tabid' => '20',
				'related_module' => 'Quotes',
				'label' => 'Quotes',
				'labeli18n' => 'Quotes',
				'actions' => 'add',
				'relationId' => '3',
			),
			'Sales Order' => array(
				'related_tabid' => '22',
				'related_module' => 'SalesOrder',
				'label' => 'Sales Order',
				'labeli18n' => 'Sales Order',
				'actions' => 'add',
				'relationId' => '4',
			),
			'Invoice' => array(
				'related_tabid' => '23',
				'related_module' => 'Invoice',
				'label' => 'Invoice',
				'labeli18n' => 'Invoice',
				'actions' => 'add',
				'relationId' => '5',
			),
			'Activities' => array(
				'related_tabid' => '63',
				'related_module' => 'cbCalendar',
				'label' => 'Activities',
				'labeli18n' => 'Activities',
				'actions' => 'add',
				'relationId' => '6',
			),
			'Emails' => array(
				'related_tabid' => '10',
				'related_module' => 'Emails',
				'label' => 'Emails',
				'labeli18n' => 'Email',
				'actions' => 'add',
				'relationId' => '7',
			),
			'Documents' => array(
				'related_tabid' => '8',
				'related_module' => 'Documents',
				'label' => 'Documents',
				'labeli18n' => 'Documents',
				'actions' => 'add,select',
				'relationId' => '9',
			),
			'HelpDesk' => array(
				'related_tabid' => '13',
				'related_module' => 'HelpDesk',
				'label' => 'HelpDesk',
				'labeli18n' => 'Support Tickets',
				'actions' => 'add',
				'relationId' => '10',
			),
			'Products' => array(
				'related_tabid' => '14',
				'related_module' => 'Products',
				'label' => 'Products',
				'labeli18n' => 'Products',
				'actions' => 'select',
				'relationId' => '11',
			),
			'Campaigns' => array(
				'related_tabid' => '26',
				'related_module' => 'Campaigns',
				'label' => 'Campaigns',
				'labeli18n' => 'Campaigns',
				'actions' => 'select',
				'relationId' => '87',
			),
			'Service Contracts' => array(
				'related_tabid' => '37',
				'related_module' => 'ServiceContracts',
				'label' => 'Service Contracts',
				'labeli18n' => 'Service Contracts',
				'actions' => 'ADD',
				'relationId' => '92',
			),
			'Services' => array(
				'related_tabid' => '38',
				'related_module' => 'Services',
				'label' => 'Services',
				'labeli18n' => 'Services',
				'actions' => 'SELECT',
				'relationId' => '108',
			),
			'CobroPago' => array(
				'related_tabid' => '42',
				'related_module' => 'CobroPago',
				'label' => 'CobroPago',
				'labeli18n' => 'Payments',
				'actions' => 'ADD',
				'relationId' => '116',
			),
			'Assets' => array(
				'related_tabid' => '43',
				'related_module' => 'Assets',
				'label' => 'Assets',
				'labeli18n' => 'Assets',
				'actions' => 'ADD',
				'relationId' => '128',
			),
			'Projects' => array(
				'related_tabid' => '50',
				'related_module' => 'Project',
				'label' => 'Projects',
				'labeli18n' => 'Projects',
				'actions' => 'ADD',
				'relationId' => '137',
			),
			'InventoryDetails' => array(
				'related_tabid' => '57',
				'related_module' => 'InventoryDetails',
				'label' => 'InventoryDetails',
				'labeli18n' => 'Inventory Details',
				'actions' => '',
				'relationId' => '155',
			),
			'cbSurveyDone' => array(
				'related_tabid' => '68',
				'related_module' => 'cbSurveyDone',
				'label' => 'cbSurveyDone',
				'labeli18n' => 'Surveys Done',
				'actions' => 'ADD',
				'relationId' => '178',
			),
			'cbSurveyAnswer' => array(
				'related_tabid' => '69',
				'related_module' => 'cbSurveyAnswer',
				'label' => 'cbSurveyAnswer',
				'labeli18n' => 'Surveys Answer',
				'actions' => 'ADD',
				'relationId' => '182',
			)
		);
		$this->assertEquals($expected, $actual, 'testgetRelatedModulesInfomation get accounts');
		$currentModule = 'Assets';
		$actual = getRelatedModulesInfomation($currentModule, $current_user);
		$expected = array(
			'HelpDesk' => array(
				'related_tabid' => '13',
				'related_module' => 'HelpDesk',
				'label' => 'HelpDesk',
				'labeli18n' => 'Support Tickets',
				'actions' => 'ADD,SELECT',
				'relationId' => '126',
			),
			'Documents' => array(
				'related_tabid' => '8',
				'related_module' => 'Documents',
				'label' => 'Documents',
				'labeli18n' => 'Documents',
				'actions' => 'ADD,SELECT',
				'relationId' => '127',
			)
		);
		$this->assertEquals($expected, $actual, 'testgetRelatedModulesInfomation get assets');
	}
}