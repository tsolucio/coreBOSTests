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

class ModuleTypesTest extends TestCase {

	/****
	 * TEST Users decimal configuration
	 * name format is: {decimal_separator}{symbol_position}{grouping}{grouping_symbol}{currency}
	 ****/
	public $usradmin = 1;
	public $usrdota0x = 5; // testdmy
	public $usrcomd0x = 6; // testmdy
	public $usrdotd3com = 7; // testymd
	public $usrinactive = 9;
	public $usrnocreate = 11;

	/**
	 * Method testvtws_listtypesNull
	 * @test
	 */
	public function testvtws_listtypesNull() {
		global $current_user;
		$current_user = Users::getActiveAdminUser();
		$actual = vtws_listtypes(null, $current_user);
		$expected = array (
			'types' => array (
			'Campaigns',
			'Vendors',
			'Faq',
			'Quotes',
			'PurchaseOrder',
			'SalesOrder',
			'Invoice',
			'PriceBooks',
			'Leads',
			'Accounts',
			'Contacts',
			'Potentials',
			'Products',
			'Documents',
			'Emails',
			'HelpDesk',
			'Users',
			'DocumentFolders',
			'PBXManager',
			'ServiceContracts',
			'Services',
			'cbupdater',
			'CobroPago',
			'Assets',
			'ModComments',
			'ProjectMilestone',
			'ProjectTask',
			'Project',
			'GlobalVariable',
			'InventoryDetails',
			'cbMap',
			'cbTermConditions',
			'cbCalendar',
			'cbtranslation',
			'BusinessActions',
			'cbSurvey',
			'cbSurveyQuestion',
			'cbSurveyDone',
			'cbSurveyAnswer',
			'cbCompany',
			'cbCVManagement',
			'cbQuestion',
			'ProductComponent',
			'Messages',
			'cbPulse',
			'MsgTemplate',
			'cbCredentials',
			'pricebookproductrel',
			'AutoNumberPrefix',
			'Groups',
			'Currency',
			'CompanyDetails',
			'Workflow',
			'AuditTrail',
			'LoginHistory',
			'ModTracker',
			'contactinfo',
			),
			'information' => array(
			'Campaigns' => array(
				'isEntity' => true,
				'label' => 'Campaigns',
				'singular' => 'Campaign',
			),
			'Vendors' => array(
				'isEntity' => true,
				'label' => 'Vendors',
				'singular' => 'Vendor',
			),
			'Faq' => array(
				'isEntity' => true,
				'label' => 'FAQ',
				'singular' => 'Faq',
			),
			'Quotes' => array(
				'isEntity' => true,
				'label' => 'Quotes',
				'singular' => 'Quote',
			),
			'PurchaseOrder' => array(
				'isEntity' => true,
				'label' => 'Purchase Order',
				'singular' => 'Purchase Order',
			),
			'SalesOrder' => array(
				'isEntity' => true,
				'label' => 'Sales Order',
				'singular' => 'Sales Order',
			),
			'Invoice' => array(
				'isEntity' => true,
				'label' => 'Invoice',
				'singular' => 'Invoice',
			),
			'PriceBooks' => array(
				'isEntity' => true,
				'label' => 'Price Books',
				'singular' => 'PriceBook',
			),
			'Leads' => array(
				'isEntity' => true,
				'label' => 'Leads',
				'singular' => 'Lead',
			),
			'Accounts' => array(
				'isEntity' => true,
				'label' => 'Organizations',
				'singular' => 'Organization',
			),
			'Contacts' => array(
				'isEntity' => true,
				'label' => 'Contacts',
				'singular' => 'Contact',
			),
			'Potentials' => array(
				'isEntity' => true,
				'label' => 'Opportunities',
				'singular' => 'Opportunity',
			),
			'Products' => array(
				'isEntity' => true,
				'label' => 'Products',
				'singular' => 'Product',
			),
			'Documents' => array(
				'isEntity' => true,
				'label' => 'Documents',
				'singular' => 'Document',
			),
			'Emails' => array(
				'isEntity' => true,
				'label' => 'Email',
				'singular' => 'Email',
			),
			'HelpDesk' => array(
				'isEntity' => true,
				'label' => 'Support Tickets',
				'singular' => 'Support Ticket',
			),
			'Users' => array(
				'isEntity' => true,
				'label' => 'Users',
				'singular' => 'User',
			),
			'PBXManager' => array(
				'isEntity' => true,
				'label' => 'PBX Manager',
				'singular' => 'PBX Manager',
			),
			'ServiceContracts' => array(
				'isEntity' => true,
				'label' => 'Service Contracts',
				'singular' => 'Service Contract',
			),
			'Services' => array(
				'isEntity' => true,
				'label' => 'Services',
				'singular' => 'Service',
			),
			'cbupdater' => array(
				'isEntity' => true,
				'label' => 'coreBOS Updater',
				'singular' => 'coreBOS Updater',
			),
			'CobroPago' => array(
				'isEntity' => true,
				'label' => 'Payments',
				'singular' => 'Payment',
			),
			'Assets' => array(
				'isEntity' => true,
				'label' => 'Assets',
				'singular' => 'Asset',
			),
			'ModComments' => array(
				'isEntity' => true,
				'label' => 'Comments',
				'singular' => 'Comment',
			),
			'ProjectMilestone' => array(
				'isEntity' => true,
				'label' => 'Project Milestones',
				'singular' => 'Project Milestone',
			),
			'ProjectTask' => array(
				'isEntity' => true,
				'label' => 'Project Tasks',
				'singular' => 'Project Task',
			),
			'Project' => array(
				'isEntity' => true,
				'label' => 'Projects',
				'singular' => 'Project',
			),
			'GlobalVariable' => array(
				'isEntity' => true,
				'label' => 'Global Variables',
				'singular' => 'Global Variable',
			),
			'InventoryDetails' => array(
				'isEntity' => true,
				'label' => 'Inventory Details',
				'singular' => 'Inventory Details',
			),
			'cbMap' => array(
				'isEntity' => true,
				'label' => 'Business Maps',
				'singular' => 'Business Map',
			),
			'cbTermConditions' => array(
				'isEntity' => true,
				'label' => 'Terms and Conditions',
				'singular' => 'Terms and Conditions',
			),
			'cbCalendar' => array(
				'isEntity' => true,
				'label' => 'To Dos',
				'singular' => 'To Do',
			),
			'cbtranslation' => array(
				'isEntity' => true,
				'label' => 'Translations',
				'singular' => 'Translation',
			),
			'BusinessActions' => array(
				'isEntity' => true,
				'label' => 'Business Actions',
				'singular' => 'Business Action',
			),
			'cbSurvey' => array(
				'isEntity' => true,
				'label' => 'Surveys',
				'singular' => 'Survey',
			),
			'cbSurveyQuestion' => array(
				'isEntity' => true,
				'label' => 'Survey Questions',
				'singular' => 'Survey Question',
			),
			'cbSurveyDone' => array(
				'isEntity' => true,
				'label' => 'Surveys Done',
				'singular' => 'Survey Done',
			),
			'cbSurveyAnswer' => array(
				'isEntity' => true,
				'label' => 'Surveys Answer',
				'singular' => 'Survey Answer',
			),
			'cbCompany' => array(
				'isEntity' => true,
				'label' => 'Companies',
				'singular' => 'Company',
			),
			'cbCVManagement' => array(
				'isEntity' => true,
				'label' => 'View Permissions',
				'singular' => 'View Permission',
			),
			'cbQuestion' => array(
				'isEntity' => true,
				'label' => 'Business Question',
				'singular' => 'Business Question',
			),
			'ProductComponent' => array(
				'isEntity' => true,
				'label' => 'Product Components',
				'singular' => 'Product Component',
			),
			'Messages' => array(
				'isEntity' => true,
				'label' => 'Messages',
				'singular' => 'Message',
			),
			'cbPulse' => array(
				'isEntity' => true,
				'label' => 'Pulses',
				'singular' => 'Pulse',
			),
			'MsgTemplate' => array(
				'isEntity' => true,
				'label' => 'Message Templates',
				'singular' => 'Message Template',
			),
			'Groups' => array(
				'isEntity' => false,
				'label' => 'Groups',
				'singular' => 'Groups',
			),
			'Currency' => array(
				'isEntity' => false,
				'label' => 'Currency',
				'singular' => 'Currency',
			),
			'DocumentFolders' => array(
				'isEntity' => true,
				'label' => 'Document Folders',
				'singular' => 'Document Folder',
			),
			'CompanyDetails' => array(
				'isEntity' => false,
				'label' => 'CompanyDetails',
				'singular' => 'CompanyDetails',
			),
			'Workflow' => array(
				'isEntity' => false,
				'label' => 'Workflow',
				'singular' => 'Workflow',
			),
			'AuditTrail' => array(
				'isEntity' => false,
				'label' => 'AuditTrail',
				'singular' => 'AuditTrail',
			),
			'LoginHistory' => array(
				'isEntity' => false,
				'label' => 'LoginHistory',
				'singular' => 'LoginHistory',
			),
			'ModTracker' => array(
				'isEntity' => false,
				'label' => 'ModTracker',
				'singular' => 'ModTracker',
			),
			'cbCredentials' => array(
				'isEntity' => true,
				'label' => 'Credentials',
				'singular' => 'Credential',
			),
			'pricebookproductrel' => array(
				'isEntity' => true,
				'label' => 'Price Lists',
				'singular' => 'Price List',
			),
			'AutoNumberPrefix' => array(
				'isEntity' => true,
				'label' => 'Auto Number Prefix',
				'singular' => 'Auto Number Prefix',
			),
			'contactinfo' => array(
				'isEntity' => false,
				'label' => 'contactinfo',
				'singular' => 'contactinfo',
			),
			),
		);
		$this->assertEquals($expected, $actual, 'null admin');
		///////////////
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x); // testdmy
		$actual = vtws_listtypes(null, $user);
		array_splice($expected['types'], 16, 1);
		unset($expected['information']['Users']);
		$this->assertEquals($expected, $actual, 'null user');
		///////////////
		// $user->retrieveCurrentUserInfoFromFile($this->usrinactive);
		// $actual = vtws_listtypes(null, $user);
		// $this->assertEquals($expected, $actual, 'null user');
		$current_user = Users::getActiveAdminUser();
	}

	/**
	 * Method testvtws_listtypesField
	 * @test
	 */
	public function testvtws_listtypesField() {
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usradmin);
		$actual = vtws_listtypes(array('phone'), $user);
		$expected = array (
			'types' => array (
			'Vendors',
			'Leads',
			'Accounts',
			'Contacts',
			'cbCompany',
			),
			'information' => array(
			'Vendors' => array(
				'isEntity' => true,
				'label' => 'Vendors',
				'singular' => 'Vendor',
			),
			'Leads' => array(
				'isEntity' => true,
				'label' => 'Leads',
				'singular' => 'Lead',
			),
			'Accounts' => array(
				'isEntity' => true,
				'label' => 'Organizations',
				'singular' => 'Organization',
			),
			'Contacts' => array(
				'isEntity' => true,
				'label' => 'Contacts',
				'singular' => 'Contact',
			),
			'cbCompany' => array(
				'isEntity' => true,
				'label' => 'Companies',
				'singular' => 'Company',
			),
			),
		);
		$this->assertEquals($expected, $actual, 'field admin');
		///////////////
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x); // testdmy
		$actual = vtws_listtypes(array('phone'), $user);
		$this->assertEquals($expected, $actual, 'field user');
		///////////////
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrinactive);
		$actual = vtws_listtypes(array('phone'), $user);
		$this->assertEquals($expected, $actual, 'field user');
	}


	/**
	 * Method testvtws_listtypesFields
	 * @test
	 */
	public function testvtws_listtypesFields() {
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usradmin);
		$actual = vtws_listtypes(array('phone','url'), $user);
		$expected = array (
			'types' => array (
			'Vendors',
			'Leads',
			'Accounts',
			'Contacts',
			'Products',
			'Services',
			'Project',
			'cbSurvey',
			'cbCompany',
			),
			'information' => array(
			'Vendors' => array(
				'isEntity' => true,
				'label' => 'Vendors',
				'singular' => 'Vendor',
			),
			'Leads' => array(
				'isEntity' => true,
				'label' => 'Leads',
				'singular' => 'Lead',
			),
			'Accounts' => array(
				'isEntity' => true,
				'label' => 'Organizations',
				'singular' => 'Organization',
			),
			'Contacts' => array(
				'isEntity' => true,
				'label' => 'Contacts',
				'singular' => 'Contact',
			),
			'cbCompany' => array(
				'isEntity' => true,
				'label' => 'Companies',
				'singular' => 'Company',
			),
			'Products' => array(
				'isEntity' => true,
				'label' => 'Products',
				'singular' => 'Product',
			),
			'Services' => array(
				'isEntity' => true,
				'label' => 'Services',
				'singular' => 'Service',
			),
			'Project' =>  array(
				'isEntity' => true,
				'label' => 'Projects',
				'singular' => 'Project',
			),
			'cbSurvey' => array(
				'isEntity' => true,
				'label' => 'Surveys',
				'singular' => 'Survey',
			),
			),
		);
		$this->assertEquals($expected, $actual, 'fields admin');
		///////////////
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x); // testdmy
		$actual = vtws_listtypes(array('phone','url'), $user);
		array_splice($expected['types'], 4, 1); // products because this user cannot access the url field
		unset($expected['information']['Products']);
		$this->assertEquals($expected, $actual, 'fields user');
		///////////////
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrinactive);
		$actual = vtws_listtypes(array('phone','url'), $user);
		$this->assertEquals($expected, $actual, 'fields user');
	}
}
