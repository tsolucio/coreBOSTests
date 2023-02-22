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
				'relatedfield' => 'account_id',
				'filterFields' => array(
					'fields' => array('contact_no', 'firstname', 'lastname', 'title', 'account_id', 'email', 'phone', 'assigned_user_id'),
					'linkfields' => array('firstname', 'lastname'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relationtype' => '1:N',
			),
			'Potentials' => array(
				'related_tabid' => '2',
				'related_module' => 'Potentials',
				'label' => 'Potentials',
				'labeli18n' => 'Opportunities',
				'actions' => 'add',
				'relationId' => '2',
				'relatedfield' => 'related_to',
				'filterFields' => array(
					'fields' => array('potential_no', 'potentialname', 'related_to', 'sales_stage', 'leadsource', 'closingdate', 'assigned_user_id'),
					'linkfields' => array('potentialname'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relationtype' => '1:N',
			),
			'Quotes' => array(
				'related_tabid' => '20',
				'related_module' => 'Quotes',
				'label' => 'Quotes',
				'labeli18n' => 'Quotes',
				'actions' => 'add',
				'relationId' => '3',
				'relatedfield' => 'account_id',
				'filterFields' => array(
					'fields' => array('quote_no', 'subject', 'quotestage', 'potential_id', 'account_id', 'hdnGrandTotal', 'assigned_user_id'),
					'linkfields' => array('subject'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relationtype' => '1:N',
			),
			'Sales Order' => array(
				'related_tabid' => '22',
				'related_module' => 'SalesOrder',
				'label' => 'Sales Order',
				'labeli18n' => 'Sales Order',
				'actions' => 'add',
				'relationId' => '4',
				'relatedfield' => 'account_id',
				'filterFields' => array(
					'fields' => array('salesorder_no', 'subject', 'account_id', 'quote_id', 'hdnGrandTotal', 'assigned_user_id'),
					'linkfields' => array('subject'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relationtype' => '1:N',
			),
			'Invoice' => array(
				'related_tabid' => '23',
				'related_module' => 'Invoice',
				'label' => 'Invoice',
				'labeli18n' => 'Invoice',
				'actions' => 'add',
				'relationId' => '5',
				'relatedfield' => 'account_id',
				'filterFields' => array(
					'fields' => array('invoice_no', 'subject', 'salesorder_id', 'invoicestatus', 'hdnGrandTotal', 'assigned_user_id'),
					'linkfields' => array('subject'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relationtype' => '1:N',
			),
			'Activities' => array(
				'related_tabid' => '63',
				'related_module' => 'cbCalendar',
				'label' => 'Activities',
				'labeli18n' => 'Activities',
				'actions' => 'add',
				'relationId' => '6',
				'relatedfield' => 'rel_id',
				'filterFields' => array(
					'fields' => array('eventstatus', 'activitytype', 'subject', 'rel_id', 'cto_id', 'dtstart', 'dtend', 'assigned_user_id'),
					'linkfields' => array('subject'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relationtype' => '1:N',
			),
			'Emails' => array(
				'related_tabid' => '10',
				'related_module' => 'Emails',
				'label' => 'Emails',
				'labeli18n' => 'Email',
				'actions' => 'add',
				'relationId' => '7',
				'relatedfield' => null,
				'filterFields' => array(
					'fields' => array('subject', 'saved_toid', 'date_start'),
					'linkfields' => array('subject'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relationtype' => 'N:N',
			),
			'Documents' => array(
				'related_tabid' => '8',
				'related_module' => 'Documents',
				'label' => 'Documents',
				'labeli18n' => 'Documents',
				'actions' => 'add,select',
				'relationId' => '9',
				'relatedfield' => null,
				'filterFields' => array(
					'fields' => array('note_no', 'notes_title', 'filename', 'modifiedtime', 'assigned_user_id'),
					'linkfields' => array('notes_title'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relationtype' => 'N:N',
			),
			'HelpDesk' => array(
				'related_tabid' => '13',
				'related_module' => 'HelpDesk',
				'label' => 'HelpDesk',
				'labeli18n' => 'Support Tickets',
				'actions' => 'add',
				'relationId' => '10',
				'relatedfield' => 'parent_id',
				'filterFields' => array(
					'fields' => array('ticket_no', 'ticket_title', 'parent_id', 'ticketstatus', 'ticketpriorities', 'assigned_user_id'),
					'linkfields' => array('ticket_title'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relationtype' => '1:N',
			),
			'Products' => array(
				'related_tabid' => '14',
				'related_module' => 'Products',
				'label' => 'Products',
				'labeli18n' => 'Products',
				'actions' => 'select',
				'relationId' => '11',
				'relatedfield' => null,
				'filterFields' => array(
					'fields' => array('product_no', 'productname', 'productcode', 'commissionrate', 'qtyinstock', 'qty_per_unit', 'unit_price'),
					'linkfields' => array('productname'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relationtype' => 'N:N',
			),
			'Campaigns' => array(
				'related_tabid' => '26',
				'related_module' => 'Campaigns',
				'label' => 'Campaigns',
				'labeli18n' => 'Campaigns',
				'actions' => 'select',
				'relationId' => '87',
				'relatedfield' => null,
				'filterFields' => array(
					'fields' => array('campaign_no', 'campaignname', 'campaigntype', 'campaignstatus', 'expectedrevenue', 'closingdate', 'assigned_user_id'),
					'linkfields' => array('campaignname'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relationtype' => 'N:N',
			),
			'Service Contracts' => array(
				'related_tabid' => '37',
				'related_module' => 'ServiceContracts',
				'label' => 'Service Contracts',
				'labeli18n' => 'Service Contracts',
				'actions' => 'ADD',
				'relationId' => '92',
				'relatedfield' => 'sc_related_to',
				'filterFields' => array(
					'fields' => array('contract_no', 'subject', 'sc_related_to', 'assigned_user_id', 'start_date', 'due_date', 'progress', 'contract_status'),
					'linkfields' => array('subject'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relationtype' => '1:N',
			),
			'Services' => array(
				'related_tabid' => '38',
				'related_module' => 'Services',
				'label' => 'Services',
				'labeli18n' => 'Services',
				'actions' => 'SELECT',
				'relationId' => '108',
				'relatedfield' => null,
				'filterFields' => array(
					'fields' => array('service_no', 'servicename', 'service_usageunit', 'unit_price', 'qty_per_unit', 'servicecategory', 'assigned_user_id'),
					'linkfields' => array('servicename'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relationtype' => 'N:N',
			),
			'CobroPago' => array(
				'related_tabid' => '42',
				'related_module' => 'CobroPago',
				'label' => 'CobroPago',
				'labeli18n' => 'Payments',
				'actions' => 'ADD',
				'relationId' => '116',
				'relatedfield' => 'parent_id',
				'filterFields' => array(
					'fields' => array('cyp_no', 'reference', 'duedate', 'amount', 'cost', 'benefit', 'paid', 'assigned_user_id'),
					'linkfields' => array('cyp_no'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relationtype' => '1:N',
			),
			'Assets' => array(
				'related_tabid' => '43',
				'related_module' => 'Assets',
				'label' => 'Assets',
				'labeli18n' => 'Assets',
				'actions' => 'ADD',
				'relationId' => '128',
				'relatedfield' => 'account',
				'filterFields' => array(
					'fields' => array('asset_no', 'assetname', 'account', 'product'),
					'linkfields' => array('assetname'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relationtype' => '1:N',
			),
			'Projects' => array(
				'related_tabid' => '50',
				'related_module' => 'Project',
				'label' => 'Projects',
				'labeli18n' => 'Projects',
				'actions' => 'ADD',
				'relationId' => '137',
				'relatedfield' => 'linktoaccountscontacts',
				'filterFields' => array(
					'fields' => array('projectname', 'linktoaccountscontacts', 'startdate', 'targetenddate', 'actualenddate', 'targetbudget', 'progress', 'projectstatus', 'assigned_user_id'),
					'linkfields' => array('projectname'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relationtype' => '1:N',
			),
			'InventoryDetails' => array(
				'related_tabid' => '57',
				'related_module' => 'InventoryDetails',
				'label' => 'InventoryDetails',
				'labeli18n' => 'Inventory Details',
				'actions' => '',
				'relationId' => '155',
				'relatedfield' => 'account_id',
				'filterFields' => array(
					'fields' => array('inventorydetails_no', 'productid', 'related_to', 'account_id', 'contact_id', 'vendor_id', 'quantity', 'listprice', 'linetotal'),
					'linkfields' => array('inventorydetails_no'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relationtype' => '1:N',
			),
			'cbSurveyDone' => array(
				'related_tabid' => '68',
				'related_module' => 'cbSurveyDone',
				'label' => 'cbSurveyDone',
				'labeli18n' => 'Surveys Done',
				'actions' => 'ADD',
				'relationId' => '178',
				'relatedfield' => 'relatewith',
				'filterFields' => array(
					'fields' => array('cbsurveydone_no', 'relatewith', 'cbsurvey', 'surveydonedate', 'assigned_user_id'),
					'linkfields' => array('cbsurveydone_no'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relationtype' => '1:N',
			),
			'cbSurveyAnswer' => array(
				'related_tabid' => '69',
				'related_module' => 'cbSurveyAnswer',
				'label' => 'cbSurveyAnswer',
				'labeli18n' => 'Surveys Answer',
				'actions' => 'ADD',
				'relationId' => '182',
				'relatedfield' => 'relatedwith',
				'filterFields' => array(
					'fields' => array('cbsurveyanswer_no', 'relatedwith', 'cbsurvey', 'cbsurveydone', 'cbsurveyq', 'positive', 'assigned_user_id'),
					'linkfields' => array('cbsurveyanswer_no'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relationtype' => '1:N',
			),
			'cbCompany' => array(
				'related_tabid' => '70',
				'related_module' => 'cbCompany',
				'label' => 'cbCompany',
				'labeli18n' => 'Companies',
				'actions' => 'ADD',
				'relationId' => '188',
				'relatedfield' => 'accid',
				'filterFields' => array(
					'fields' => array('companyname', 'siccode', 'comercialname', 'assigned_user_id'),
					'linkfields' => array('companyname'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relationtype' => '1:N',
			),
			'Messages' => array(
				'related_tabid' => '74',
				'related_module' => 'Messages',
				'label' => 'Messages',
				'labeli18n' => 'Messages',
				'actions' => 'ADD',
				'relationId' => '191',
				'relatedfield' => 'messagesrelatedto',
				'filterFields' => array(
					'fields' => array('messageno', 'assigned_user_id', 'createdtime', 'messagename', 'account_message', 'contact_message', 'campaign_message'),
					'linkfields' => array('messageno'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relationtype' => '1:N',
			),
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
				'filterFields' => array(
					'fields' => array('ticket_no', 'ticket_title', 'parent_id', 'ticketstatus', 'ticketpriorities', 'assigned_user_id'),
					'linkfields' => array('ticket_title'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relatedfield' => null,
				'relationtype' => 'N:N',
			),
			'Documents' => array(
				'related_tabid' => '8',
				'related_module' => 'Documents',
				'label' => 'Documents',
				'labeli18n' => 'Documents',
				'actions' => 'ADD,SELECT',
				'relationId' => '127',
				'filterFields' => array(
					'fields' => array('note_no', 'notes_title', 'filename', 'modifiedtime', 'assigned_user_id'),
					'linkfields' => array('notes_title'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relatedfield' => null,
				'relationtype' => 'N:N',
			)
		);
		$this->assertEquals($expected, $actual, 'testgetRelatedModulesInfomation get assets');
		$currentModule = 'HelpDesk';
		$actual = getRelatedModulesInfomation($currentModule, $current_user);
		$expected = array(
			'Activities' => array(
				'related_tabid' => '63',
				'related_module' => 'cbCalendar',
				'label' => 'Activities',
				'labeli18n' => 'Activities',
				'actions' => 'add,select',
				'relationId' => '54',
				'filterFields' => array(
					'fields' => array('eventstatus', 'activitytype', 'subject', 'rel_id', 'cto_id', 'dtstart', 'dtend', 'assigned_user_id'),
					'linkfields' => array('subject'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relatedfield' => 'rel_id',
				'relationtype' => '1:N',
			),
			'Documents' => array(
				'related_tabid' => '8',
				'related_module' => 'Documents',
				'label' => 'Documents',
				'labeli18n' => 'Documents',
				'actions' => 'add,select',
				'relationId' => '55',
				'filterFields' => array(
					'fields' => array('note_no', 'notes_title', 'filename', 'modifiedtime', 'assigned_user_id'),
					'linkfields' => array('notes_title'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relatedfield' => null,
				'relationtype' => 'N:N',
			),
			'Ticket History' => array(
				'related_tabid' => '0',
				'related_module' => '',
				'label' => 'Ticket History',
				'labeli18n' => 'Ticket History',
				'actions' => '',
				'relationId' => '56',
				'filterFields' => array(
					'fields' => array('ticket_no', 'ticket_title', 'parent_id', 'ticketstatus', 'ticketpriorities', 'assigned_user_id'),
					'linkfields' => array('ticket_title'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relatedfield' => null,
				'relationtype' => 'N:N',
			),
			'Service Contracts' => array(
				'related_tabid' => '37',
				'related_module' => 'ServiceContracts',
				'label' => 'Service Contracts',
				'labeli18n' => 'Service Contracts',
				'actions' => 'ADD,SELECT',
				'relationId' => '94',
				'filterFields' => array(
					'fields' => array('contract_no', 'subject', 'sc_related_to', 'assigned_user_id', 'start_date', 'due_date', 'progress', 'contract_status'),
					'linkfields' => array('subject'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relatedfield' => null,
				'relationtype' => 'N:N',
			),
			'Services' => array(
				'related_tabid' => '38',
				'related_module' => 'Services',
				'label' => 'Services',
				'labeli18n' => 'Services',
				'actions' => 'SELECT',
				'relationId' => '106',
				'filterFields' => array(
					'fields' => array('service_no', 'servicename', 'service_usageunit', 'unit_price', 'qty_per_unit', 'servicecategory', 'assigned_user_id'),
					'linkfields' => array('servicename'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relatedfield' => null,
				'relationtype' => 'N:N',
			),
			'CobroPago' => array(
				'related_tabid' => '42',
				'related_module' => 'CobroPago',
				'label' => 'CobroPago',
				'labeli18n' => 'Payments',
				'actions' => 'ADD',
				'relationId' => '125',
				'filterFields' => array(
					'fields' => array('cyp_no', 'reference', 'duedate', 'amount', 'cost', 'benefit', 'paid', 'assigned_user_id'),
					'linkfields' => array('cyp_no'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relatedfield' => 'related_id',
				'relationtype' => '1:N',
			),
			'Projects' => array(
				'related_tabid' => '50',
				'related_module' => 'Project',
				'label' => 'Projects',
				'labeli18n' => 'Projects',
				'actions' => 'SELECT',
				'relationId' => '139',
				'filterFields' => array(
					'fields' => array('projectname', 'linktoaccountscontacts', 'startdate', 'targetenddate', 'actualenddate', 'targetbudget', 'progress', 'projectstatus', 'assigned_user_id'),
					'linkfields' => array('projectname'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relatedfield' => null,
				'relationtype' => 'N:N',
			),
			'Emails' => array(
				'related_tabid' => '10',
				'related_module' => 'Emails',
				'label' => 'Emails',
				'labeli18n' => 'Email',
				'actions' => 'ADD',
				'relationId' => '149',
				'filterFields' => array(
					'fields' => array('subject', 'saved_toid', 'date_start'),
					'linkfields' => array('subject'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
				'relatedfield' => null,
				'relationtype' => 'N:N',
			)
		);
		$this->assertEquals($expected, $actual, 'testgetRelatedModulesInfomation get HelpDesk');
		$currentModule = 'Users';
		$actual = getRelatedModulesInfomation($currentModule, $current_user);
		$expected = array();
		$this->assertEquals($expected, $actual, 'testgetRelatedModulesInfomation get users');
	}

	/**
	 * Method testactormodule
	 * @test
	 */
	public function testactormodule() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		getRelatedModulesInfomation('AuditTrail', $current_user);
	}

	/**
	 * Method testnonentitymodule
	 * @test
	 */
	public function testnonentitymodule() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		getRelatedModulesInfomation('evvtMenu', $current_user);
	}

	/**
	 * Method testemptymodule
	 * @test
	 */
	public function testemptymodule() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		getRelatedModulesInfomation('', $current_user);
	}

	/**
	 * Method testinexistentmodule
	 * @test
	 */
	public function testinexistentmodule() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		getRelatedModulesInfomation('DoesNotExist', $current_user);
	}

	/**
	 * Method testnopermissionmodule
	 * @test
	 */
	public function testnopermissionmodule() {
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(11); // nocreate > no access to cbTermConditions
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		getRelatedModulesInfomation('cbTermConditions', $user);
	}
}