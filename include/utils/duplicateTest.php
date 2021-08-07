<?php
/*************************************************************************************************
 * Copyright 2019 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

class duplicateTest extends TestCase {

	/**
	 * Method getUIType10DependentModulesProvider
	 * params
	 */
	public function getUIType10DependentModulesProvider() {
		return array(
			array('Accounts', array(
				'Potentials' => array(
					'tablename' => 'vtiger_potential',
					'columname' => 'related_to',
				),
				'HelpDesk' => array(
					'tablename' => 'vtiger_troubletickets',
					'columname' => 'parent_id',
				),
				'ServiceContracts' => array(
					'tablename' => 'vtiger_servicecontracts',
					'columname' => 'sc_related_to',
				),
				'CobroPago' => array(
					'tablename' => 'vtiger_cobropago',
					'columname' => 'parent_id',
				),
				'Assets' => array(
					'tablename' => 'vtiger_assets',
					'columname' => 'account',
				),
				'ModComments' => array(
					'tablename' => 'vtiger_modcomments',
					'columname' => 'related_to',
				),
				'Project' => array(
					'tablename' => 'vtiger_project',
					'columname' => 'linktoaccountscontacts',
				),
				'InventoryDetails' => array(
					'tablename' => 'vtiger_inventorydetails',
					'columname' => 'account_id',
				),
				'cbCalendar' => array(
					'tablename' => 'vtiger_activity',
					'columname' => 'rel_id',
				),
				'cbtranslation' => array(
					'tablename' => 'vtiger_cbtranslation',
					'columname' => 'translates',
				),
				'cbSurveyDone' => array(
					'tablename' => 'vtiger_cbsurveydone',
					'columname' => 'relatewith',
				),
				'cbSurveyAnswer' => array(
					'tablename' => 'vtiger_cbsurveyanswer',
					'columname' => 'relatedwith',
				),
				'cbCompany' => array(
					'tablename' => 'vtiger_cbcompany',
					'columname' => 'accid',
				),
				'Messages' => array(
					'tablename' => 'vtiger_messages',
					'columname' => 'account_message',
				),
				'Accounts' => array(
					'tablename' => 'vtiger_account',
					'columname' => 'parentid',
				),
				'Contacts' => array(
					'tablename' => 'vtiger_contactdetails',
					'columname' => 'accountid',
				),
				'Quotes' => array(
					'tablename' => 'vtiger_quotes',
					'columname' => 'accountid',
				),
				'SalesOrder' => array(
					'tablename' => 'vtiger_salesorder',
					'columname' => 'accountid',
				),
				'Invoice' => array(
					'tablename' => 'vtiger_invoice',
					'columname' => 'accountid',
				),
			), 'Accounts'),
			array('Assets', array(
				'CobroPago' => array(
					'tablename' => 'vtiger_cobropago',
					'columname' => 'related_id',
				),
				'cbtranslation' => array(
					'tablename' => 'vtiger_cbtranslation',
					'columname' => 'translates',
				),
			), 'Assets'),
			array('Vendors', array(
				'Products' => array(
					'tablename' => 'vtiger_products',
					'columname' => 'vendor_id',
				),
				'PurchaseOrder' => array(
					'tablename' => 'vtiger_purchaseorder',
					'columname' => 'vendorid',
				),
				'CobroPago' => array(
					'tablename' => 'vtiger_cobropago',
					'columname' => 'parent_id',
				),
				'InventoryDetails' => array(
					'tablename' => 'vtiger_inventorydetails',
					'columname' => 'vendor_id',
				),
				'cbCalendar' => array(
					'tablename' => 'vtiger_activity',
					'columname' => 'rel_id',
				),
				'cbtranslation' => array(
					'tablename' => 'vtiger_cbtranslation',
					'columname' => 'translates',
				),
				'Messages' => array(
					'tablename' => 'vtiger_messages',
					'columname' => 'messagesrelatedto',
				),
			), 'Vendors'),
			array('Campaigns', array(
				'CobroPago' => array(
					'tablename' => 'vtiger_cobropago',
					'columname' => 'related_id',
				),
				'cbtranslation' => array(
					'tablename' => 'vtiger_cbtranslation',
					'columname' => 'translates',
				),
				'Potentials' => array(
					'tablename' => 'vtiger_potential',
					'columname' => 'campaignid',
				),
				'cbCalendar' => array(
					'tablename' => 'vtiger_activity',
					'columname' => 'rel_id',
				),
				'Messages' => array(
					'tablename' => 'vtiger_messages',
					'columname' => 'campaign_message',
				),
			), 'Campaigns'),
			array('HelpDesk', array(
				'CobroPago' => array(
					'tablename' => 'vtiger_cobropago',
					'columname' => 'related_id',
				),
				'cbtranslation' => array(
					'tablename' => 'vtiger_cbtranslation',
					'columname' => 'translates',
				),
				'cbCalendar' => array(
					'tablename' => 'vtiger_activity',
					'columname' => 'rel_id',
				),
				'Messages' => array(
					'tablename' => 'vtiger_messages',
					'columname' => 'messagesrelatedto',
				),
			), 'HelpDesk'),
			array('Potentials', array(
				'CobroPago' => array(
					'tablename' => 'vtiger_cobropago',
					'columname' => 'related_id',
				),
				'cbtranslation' => array(
					'tablename' => 'vtiger_cbtranslation',
					'columname' => 'translates',
				),
				'cbCalendar' => array(
					'tablename' => 'vtiger_activity',
					'columname' => 'rel_id',
				),
				'Messages' => array(
					'tablename' => 'vtiger_messages',
					'columname' => 'messagesrelatedto',
				),
				'Quotes' => array(
					'tablename' => 'vtiger_quotes',
					'columname' => 'potentialid',
				),
				'SalesOrder' => array(
					'tablename' => 'vtiger_salesorder',
					'columname' => 'potentialid',
				),
				'ModComments' => array(
					'tablename' => 'vtiger_modcomments',
					'columname' => 'related_to',
				),
			), 'Potentials'),
		);
	}

	/**
	 * Method testgetUIType10DependentModules
	 * @test
	 * @dataProvider getUIType10DependentModulesProvider
	 */
	public function testgetUIType10DependentModules($module, $expected, $message) {
		$actual = getUIType10DependentModules($module);
		$this->assertEquals($expected, $actual, "testgetUIType10DependentModules $message");
	}
}
