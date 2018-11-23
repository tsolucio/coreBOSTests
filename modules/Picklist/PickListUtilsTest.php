<?php
/*************************************************************************************************
 * Copyright 2017 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

class PickListUtilsTest extends TestCase {

	private $role_vicepresident = 'H3';
	private $role_salesman = 'H5';

	private $expectedH3_picklists = array(
	'Accounts' => array(
	0 =>
	array (
	'fieldlabel' => 'Type',
	'generatedtype' => '',
	'columnname' => 'account_type',
	'fieldname' => 'accounttype',
	'uitype' => '15',
	'value' =>
	array (
		'--None--' => '--None--',
		'Analyst' => 'Analyst',
		'Competitor' => 'Competitor',
		'Customer' => 'Customer',
		'Integrator' => 'Integrator',
		'Investor' => 'Investor',
		'Partner' => 'Partner',
		'Press' => 'Press',
		'Prospect' => 'Prospect',
		'Reseller' => 'Reseller',
		'Other' => 'Other',
	),
	),
	1 =>
	array (
	'fieldlabel' => 'industry',
	'generatedtype' => '',
	'columnname' => 'industry',
	'fieldname' => 'industry',
	'uitype' => '15',
	'value' =>
	array (
		'--None--' => '--None--',
		'Apparel' => 'Apparel',
		'Banking' => 'Banking',
		'Biotechnology' => 'Biotechnology',
		'Chemicals' => 'Chemicals',
		'Communications' => 'Communications',
		'Construction' => 'Construction',
		'Consulting' => 'Consulting',
		'Education' => 'Education',
		'Electronics' => 'Electronics',
		'Energy' => 'Energy',
		'Engineering' => 'Engineering',
		'Entertainment' => 'Entertainment',
		'Environmental' => 'Environmental',
		'Finance' => 'Finance',
		'Food & Beverage' => 'Food & Beverage',
		'Government' => 'Government',
		'Healthcare' => 'Healthcare',
		'Hospitality' => 'Hospitality',
		'Insurance' => 'Insurance',
		'Machinery' => 'Machinery',
		'Manufacturing' => 'Manufacturing',
		'Media' => 'Media',
		'Not For Profit' => 'Not For Profit',
		'Recreation' => 'Recreation',
		'Retail' => 'Retail',
		'Shipping' => 'Shipping',
		'Technology' => 'Technology',
		'Telecommunications' => 'Telecommunications',
		'Transportation' => 'Transportation',
		'Utilities' => 'Utilities',
		'Other' => 'Other',
	),
	),
	2 =>
	array (
	'fieldlabel' => 'Rating',
	'generatedtype' => '',
	'columnname' => 'rating',
	'fieldname' => 'rating',
	'uitype' => '15',
	'value' =>
	array (
		'--None--' => '--None--',
		'Acquired' => 'Acquired',
		'Active' => 'Active',
		'Market Failed' => 'Market Failed',
		'Project Cancelled' => 'Project Cancelled',
		'Shutdown' => 'Shutdown',
	),
	),
	3 =>
	array (
	'fieldlabel' => 'PLMain',
	'generatedtype' => '',
	'columnname' => 'cf_729',
	'fieldname' => 'cf_729',
	'uitype' => '15',
	'value' =>
	array (
		'one' => 'one',
		'two' => 'two',
		'three' => 'three',
	),
	),
	4 =>
	array (
	'fieldlabel' => 'PLDep1',
	'generatedtype' => '',
	'columnname' => 'cf_730',
	'fieldname' => 'cf_730',
	'uitype' => '15',
	'value' =>
	array (
		'oneone' => 'oneone',
		'onetwo' => 'onetwo',
		'twoone' => 'twoone',
		'twotwo' => 'twotwo',
		'threeone' => 'threeone',
		'threetwo' => 'threetwo',
	),
	),
	5 =>
	array (
	'fieldlabel' => 'PLDep2',
	'generatedtype' => '',
	'columnname' => 'cf_731',
	'fieldname' => 'cf_731',
	'uitype' => '15',
	'value' =>
	array (
		'oneoneone' => 'oneoneone',
		'oneonetwo' => 'oneonetwo',
		'onetwoone' => 'onetwoone',
		'onetwotwo' => 'onetwotwo',
		'twooneone' => 'twooneone',
		'twoonetwo' => 'twoonetwo',
		'twotwoone' => 'twotwoone',
		'twotwotwo' => 'twotwotwo',
		'threeoneone' => 'threeoneone',
		'threeonetwo' => 'threeonetwo',
		'threetwoone' => 'threetwoone',
		'threetwotwo' => 'threetwotwo',
	),
	),
	6 =>
	array (
	'fieldlabel' => 'Planets',
	'generatedtype' => '',
	'columnname' => 'cf_732',
	'fieldname' => 'cf_732',
	'uitype' => '33',
	'value' =>
	array (
		'Adipose 3' => 'Adipose 3',
		'Barcelona' => 'Barcelona',
		'Chronos' => 'Chronos',
		'Dioscuros' => 'Dioscuros',
		'Earth' => 'Earth',
		'Florana' => 'Florana',
		'Gallifrey' => 'Gallifrey',
		'House' => 'House',
		'Indigo 3' => 'Indigo 3',
		'Jaconda' => 'Jaconda',
		'Karris' => 'Karris',
		'The Library' => 'The Library',
		'Midnight' => 'Midnight',
		'New Alexandria' => 'New Alexandria',
		'Oblivion' => 'Oblivion',
		'Poosh' => 'Poosh',
		'Qualactin' => 'Qualactin',
		'Rit' => 'Rit',
		'Salvak' => 'Salvak',
		'Tara' => 'Tara',
		'Utopia' => 'Utopia',
		'Vandos' => 'Vandos',
		'Woldyhool' => 'Woldyhool',
		'Xeros' => 'Xeros',
		'Yegros Alpha' => 'Yegros Alpha',
		'Zygor' => 'Zygor',
	),
	),
	),
	'Contacts' => array(
	0 =>
	array (
	'fieldlabel' => 'Lead Source',
	'generatedtype' => '',
	'columnname' => 'leadsource',
	'fieldname' => 'leadsource',
	'uitype' => '15',
	'value' =>
	array (
		'--None--' => '--None--',
		'Cold Call' => 'Cold Call',
		'Existing Customer' => 'Existing Customer',
		'Self Generated' => 'Self Generated',
		'Employee' => 'Employee',
		'Partner' => 'Partner',
		'Public Relations' => 'Public Relations',
		'Direct Mail' => 'Direct Mail',
		'Conference' => 'Conference',
		'Trade Show' => 'Trade Show',
		'Web Site' => 'Web Site',
		'Word of mouth' => 'Word of mouth',
		'Other' => 'Other',
	),
	),
	1 =>
	array (
	'fieldlabel' => 'Salutation',
	'generatedtype' => '',
	'columnname' => 'salutation',
	'fieldname' => 'salutationtype',
	'uitype' => '55',
	'value' =>
	array (
		'--None--' => '--None--',
		'Mr.' => 'Mr.',
		'Ms.' => 'Ms.',
		'Mrs.' => 'Mrs.',
		'Dr.' => 'Dr.',
		'Prof.' => 'Prof.',
	),
	),
	),
	'HelpDesk' => array(
	0 =>
	array (
	'fieldlabel' => 'Category',
	'generatedtype' => '',
	'columnname' => 'category',
	'fieldname' => 'ticketcategories',
	'uitype' => '15',
	'value' =>
	array (
		'Big Problem' => 'Big Problem',
		'Small Problem' => 'Small Problem',
		'Other Problem' => 'Other Problem',
	),
	),
	1 =>
	array (
	'fieldlabel' => 'Priority',
	'generatedtype' => '',
	'columnname' => 'priority',
	'fieldname' => 'ticketpriorities',
	'uitype' => '15',
	'value' =>
	array (
		'Low' => 'Low',
		'Normal' => 'Normal',
		'High' => 'High',
		'Urgent' => 'Urgent',
	),
	),
	2 =>
	array (
	'fieldlabel' => 'Severity',
	'generatedtype' => '',
	'columnname' => 'severity',
	'fieldname' => 'ticketseverities',
	'uitype' => '15',
	'value' =>
	array (
		'Minor' => 'Minor',
		'Major' => 'Major',
		'Feature' => 'Feature',
		'Critical' => 'Critical',
	),
	),
	3 =>
	array (
	'fieldlabel' => 'Status',
	'generatedtype' => '',
	'columnname' => 'status',
	'fieldname' => 'ticketstatus',
	'uitype' => '15',
	'value' =>
	array (
		'Open' => 'Open',
		'In Progress' => 'In Progress',
		'Wait For Response' => 'Wait For Response',
		'Closed' => 'Closed',
	),
	),
	));

	private $expectedH5_picklists = array(
	'Accounts' => array(
	0 =>
	array (
	'fieldlabel' => 'Type',
	'generatedtype' => '',
	'columnname' => 'account_type',
	'fieldname' => 'accounttype',
	'uitype' => '15',
	'value' =>
	array (
		'--None--' => '--None--',
		'Analyst' => 'Analyst',
		'Competitor' => 'Competitor',
		'Customer' => 'Customer',
		'Integrator' => 'Integrator',
		'Investor' => 'Investor',
		'Partner' => 'Partner',
		'Press' => 'Press',
		'Prospect' => 'Prospect',
		'Reseller' => 'Reseller',
	),
	),
	1 =>
	array (
	'fieldlabel' => 'industry',
	'generatedtype' => '',
	'columnname' => 'industry',
	'fieldname' => 'industry',
	'uitype' => '15',
	'value' =>
	array (
		'--None--' => '--None--',
		'Apparel' => 'Apparel',
		'Banking' => 'Banking',
		'Biotechnology' => 'Biotechnology',
		'Chemicals' => 'Chemicals',
		'Communications' => 'Communications',
		'Construction' => 'Construction',
		'Consulting' => 'Consulting',
		'Education' => 'Education',
		'Electronics' => 'Electronics',
		'Energy' => 'Energy',
		'Engineering' => 'Engineering',
		'Entertainment' => 'Entertainment',
		'Environmental' => 'Environmental',
		'Finance' => 'Finance',
		'Food & Beverage' => 'Food & Beverage',
		'Government' => 'Government',
		'Healthcare' => 'Healthcare',
		'Hospitality' => 'Hospitality',
		'Insurance' => 'Insurance',
		'Machinery' => 'Machinery',
		'Manufacturing' => 'Manufacturing',
		'Media' => 'Media',
		'Not For Profit' => 'Not For Profit',
		'Recreation' => 'Recreation',
		'Retail' => 'Retail',
		'Shipping' => 'Shipping',
		'Technology' => 'Technology',
		'Telecommunications' => 'Telecommunications',
		'Transportation' => 'Transportation',
		'Utilities' => 'Utilities',
		'Other' => 'Other',
	),
	),
	2 =>
	array (
	'fieldlabel' => 'Rating',
	'generatedtype' => '',
	'columnname' => 'rating',
	'fieldname' => 'rating',
	'uitype' => '15',
	'value' =>
	array (
		'--None--' => '--None--',
		'Acquired' => 'Acquired',
		'Active' => 'Active',
		'Market Failed' => 'Market Failed',
	),
	),
	3 =>
	array (
	'fieldlabel' => 'PLMain',
	'generatedtype' => '',
	'columnname' => 'cf_729',
	'fieldname' => 'cf_729',
	'uitype' => '15',
	'value' =>
	array (
		'one' => 'one',
		'two' => 'two',
		'three' => 'three',
	),
	),
	4 =>
	array (
	'fieldlabel' => 'PLDep1',
	'generatedtype' => '',
	'columnname' => 'cf_730',
	'fieldname' => 'cf_730',
	'uitype' => '15',
	'value' =>
	array (
		'oneone' => 'oneone',
		'onetwo' => 'onetwo',
		'twoone' => 'twoone',
		'twotwo' => 'twotwo',
		'threeone' => 'threeone',
		'threetwo' => 'threetwo',
	),
	),
	5 =>
	array (
	'fieldlabel' => 'PLDep2',
	'generatedtype' => '',
	'columnname' => 'cf_731',
	'fieldname' => 'cf_731',
	'uitype' => '15',
	'value' =>
	array (
		'oneoneone' => 'oneoneone',
		'oneonetwo' => 'oneonetwo',
		'onetwoone' => 'onetwoone',
		'onetwotwo' => 'onetwotwo',
		'twooneone' => 'twooneone',
		'twoonetwo' => 'twoonetwo',
		'twotwoone' => 'twotwoone',
		'twotwotwo' => 'twotwotwo',
		'threeoneone' => 'threeoneone',
		'threeonetwo' => 'threeonetwo',
		'threetwoone' => 'threetwoone',
		'threetwotwo' => 'threetwotwo',
	),
	),
	6 =>
	array (
	'fieldlabel' => 'Planets',
	'generatedtype' => '',
	'columnname' => 'cf_732',
	'fieldname' => 'cf_732',
	'uitype' => '33',
	'value' =>
	array (
		'Adipose 3' => 'Adipose 3',
		'Barcelona' => 'Barcelona',
		'Chronos' => 'Chronos',
		'Dioscuros' => 'Dioscuros',
		'Earth' => 'Earth',
		'Florana' => 'Florana',
		'Gallifrey' => 'Gallifrey',
		'House' => 'House',
		'Indigo 3' => 'Indigo 3',
		'Jaconda' => 'Jaconda',
		'Karris' => 'Karris',
		'The Library' => 'The Library',
		'Midnight' => 'Midnight',
		'New Alexandria' => 'New Alexandria',
		'Oblivion' => 'Oblivion',
		'Poosh' => 'Poosh',
		'Qualactin' => 'Qualactin',
		'Rit' => 'Rit',
		'Salvak' => 'Salvak',
		'Tara' => 'Tara',
		'Utopia' => 'Utopia',
		'Vandos' => 'Vandos',
		'Woldyhool' => 'Woldyhool',
		'Xeros' => 'Xeros',
		'Yegros Alpha' => 'Yegros Alpha',
		'Zygor' => 'Zygor',
	),
	),
	),
	'Contacts' => array(
	0 =>
	array (
	'fieldlabel' => 'Lead Source',
	'generatedtype' => '',
	'columnname' => 'leadsource',
	'fieldname' => 'leadsource',
	'uitype' => '15',
	'value' =>
	array (
		'--None--' => '--None--',
		'Cold Call' => 'Cold Call',
		'Existing Customer' => 'Existing Customer',
		'Self Generated' => 'Self Generated',
		'Employee' => 'Employee',
		'Partner' => 'Partner',
		'Public Relations' => 'Public Relations',
		'Direct Mail' => 'Direct Mail',
		'Conference' => 'Conference',
		'Trade Show' => 'Trade Show',
		'Web Site' => 'Web Site',
		'Word of mouth' => 'Word of mouth',
	),
	),
	1 =>
	array (
	'fieldlabel' => 'Salutation',
	'generatedtype' => '',
	'columnname' => 'salutation',
	'fieldname' => 'salutationtype',
	'uitype' => '55',
	'value' =>
	array (
		'--None--' => '--None--',
		'Mr.' => 'Mr.',
		'Ms.' => 'Ms.',
		'Mrs.' => 'Mrs.',
		'Dr.' => 'Dr.',
		'Prof.' => 'Prof.',
	),
	),
	),
	'HelpDesk' => array(
	0 =>
	array (
	'fieldlabel' => 'Category',
	'generatedtype' => '',
	'columnname' => 'category',
	'fieldname' => 'ticketcategories',
	'uitype' => '15',
	'value' =>
	array (
		'Big Problem' => 'Big Problem',
		'Small Problem' => 'Small Problem',
		'Other Problem' => 'Other Problem',
	),
	),
	1 =>
	array (
	'fieldlabel' => 'Priority',
	'generatedtype' => '',
	'columnname' => 'priority',
	'fieldname' => 'ticketpriorities',
	'uitype' => '15',
	'value' =>
	array (
		'Low' => 'Low',
		'Normal' => 'Normal',
		'High' => 'High',
	),
	),
	2 =>
	array (
	'fieldlabel' => 'Severity',
	'generatedtype' => '',
	'columnname' => 'severity',
	'fieldname' => 'ticketseverities',
	'uitype' => '15',
	'value' =>
	array (
		'Minor' => 'Minor',
		'Major' => 'Major',
		'Feature' => 'Feature',
		'Critical' => 'Critical',
	),
	),
	3 =>
	array (
	'fieldlabel' => 'Status',
	'generatedtype' => '',
	'columnname' => 'status',
	'fieldname' => 'ticketstatus',
	'uitype' => '15',
	'value' =>
	array (
		'Open' => 'Open',
		'In Progress' => 'In Progress',
		'Wait For Response' => 'Wait For Response',
	),
	),
	));

	/**
	 * Method testgetUserFldArray
	 * @test
	 */
	public function testgetUserFldArray() {
		$mods = array('Accounts','Contacts','HelpDesk');
		foreach ($mods as $module) {
			$actual = getUserFldArray($module, $this->role_vicepresident);
			$this->assertEquals($this->expectedH3_picklists[$module], $actual, "$module > H3");
			$actual = getUserFldArray($module, $this->role_salesman);
			$this->assertEquals($this->expectedH5_picklists[$module], $actual, "$module > H5");
		}
	}

	/**
	 * Method testgetPickListModules
	 * @test
	 */
	public function testgetPickListModules() {
		$actual = getPickListModules();
		$expected = array(
			'Potentials' => 'Potentials',
			'Contacts' => 'Contacts',
			'Accounts' => 'Accounts',
			'Leads' => 'Leads',
			'Calendar' => 'Calendar',
			'HelpDesk' => 'HelpDesk',
			'Products' => 'Products',
			'Faq' => 'Faq',
			'Events' => 'Events',
			'Vendors' => 'Vendors',
			'Quotes' => 'Quotes',
			'PurchaseOrder' => 'PurchaseOrder',
			'SalesOrder' => 'SalesOrder',
			'Invoice' => 'Invoice',
			'Campaigns' => 'Campaigns',
			'Service Contracts' => 'ServiceContracts',
			'Services' => 'Services',
			'cbupdater' => 'cbupdater',
			'CobroPago' => 'CobroPago',
			'Assets' => 'Assets',
			'ProjectMilestone' => 'ProjectMilestone',
			'ProjectTask' => 'ProjectTask',
			'Project' => 'Project',
			'GlobalVariable' => 'GlobalVariable',
			'cbMap' => 'cbMap',
			'cbTermConditions' => 'cbTermConditions',
			'cbCalendar' => 'cbCalendar',
			'BusinessActions' => 'BusinessActions',
			'Business Question' => 'cbQuestion',
			'Product Component' => 'ProductComponent',
		);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * Method testgetrole2picklist
	 * @test
	 */
	public function testgetrole2picklist() {
		$actual = getrole2picklist();
		$expected = array(
			'H2' => 'CEO',
			'H3' => 'Vice President',
			'H4' => 'Sales Manager',
			'H5' => 'Sales Man',
			'H6' => 'NoCreate',
		);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * Method testget_available_module_picklist
	 * @test
	 */
	public function testgetAvailableModulePicklist() {
		$mods = array('Accounts','Contacts','HelpDesk');
		$expectedPLs = array(
			'Accounts' => array (
				'accounttype' => 'Type',
				'industry' => 'Industry',
				'rating' => 'Rating',
				'cf_729' => 'PLMain',
				'cf_730' => 'PLDep1',
				'cf_731' => 'PLDep2',
				'cf_732' => 'Planets',
			),
			'Contacts' => array (
				'leadsource' => 'Lead Source',
				'salutationtype' => 'Salutation ',
			),
			'HelpDesk' => array (
				'ticketcategories' => 'Category',
				'ticketpriorities' => 'Priority',
				'ticketseverities' => 'Severity',
				'ticketstatus' => 'Status',
			));
		foreach ($mods as $module) {
			$plentries = getUserFldArray($module, $this->role_vicepresident);
			$actual = get_available_module_picklist($plentries);
			$this->assertEquals($expectedPLs[$module], $actual, "$module > H3");
			$actual = get_available_module_picklist($plentries);
			$this->assertEquals($expectedPLs[$module], $actual, "$module > H5");
		}
	}

	/**
	 * Method testgetAllPickListValues
	 * @test
	 */
	public function testgetAllPickListValues() {
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * Method testgetEditablePicklistValues
	 * @test
	 */
	public function testgetEditablePicklistValues() {
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * Method testgetNonEditablePicklistValues
	 * @test
	 */
	public function testgetNonEditablePicklistValues() {
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * Method getAssignedPicklistValuesProvider
	 * params
	 */
	public function getAssignedPicklistValuesProvider() {
		// Accounts Module Picklist Values
		$expected_accounttype_H1_picklist_values = array(
		'--None--' => '--None--',
		'Analyst' => 'Analyst',
		'Competitor' => 'Competitor',
		'Customer' => 'Customer',
		'Integrator' => 'Integrator',
		'Investor' => 'Investor',
		'Partner' => 'Partner',
		'Press' => 'Press',
		'Prospect' => 'Prospect',
		'Reseller' => 'Reseller',
		'Other' => 'Other'
		);
		$expected_accounttype_H2_picklist_values =  array(
		'--None--' => '--None--',
		'Analyst' => 'Analyst',
		'Competitor' => 'Competitor',
		'Customer' => 'Customer',
		'Integrator' => 'Integrator',
		'Investor' => 'Investor',
		'Partner' => 'Partner',
		'Press' => 'Press',
		'Prospect' => 'Prospect',
		'Reseller' => 'Reseller',
		'Other' => 'Other'
		);
		$expected_accounttype_H3_picklist_values =  array(
		'--None--' => '--None--',
		'Analyst' => 'Analyst',
		'Competitor' => 'Competitor',
		'Customer' => 'Customer',
		'Integrator' => 'Integrator',
		'Investor' => 'Investor',
		'Partner' => 'Partner',
		'Press' => 'Press',
		'Prospect' => 'Prospect',
		'Reseller' => 'Reseller',
		'Other' => 'Other'
		);
		$expected_accounttype_H4_picklist_values =  array(
		'--None--' => '--None--',
		'Analyst' => 'Analyst',
		'Competitor' => 'Competitor',
		'Customer' => 'Customer',
		'Integrator' => 'Integrator',
		'Investor' => 'Investor',
		'Partner' => 'Partner',
		'Press' => 'Press',
		'Prospect' => 'Prospect',
		'Reseller' => 'Reseller',
		'Other' => 'Other'
		);
		$expected_accounttype_H5_picklist_values =  array(
		'--None--' => '--None--',
		'Analyst' => 'Analyst',
		'Competitor' => 'Competitor',
		'Customer' => 'Customer',
		'Integrator' => 'Integrator',
		'Investor' => 'Investor',
		'Partner' => 'Partner',
		'Press' => 'Press',
		'Prospect' => 'Prospect',
		'Reseller' => 'Reseller'
		);
		$expected_accounttype_H6_picklist_values =  array(
		'--None--' => '--None--',
		'Analyst' => 'Analyst',
		'Competitor' => 'Competitor',
		'Customer' => 'Customer',
		'Integrator' => 'Integrator',
		'Investor' => 'Investor',
		'Partner' => 'Partner',
		'Press' => 'Press',
		'Prospect' => 'Prospect',
		'Reseller' => 'Reseller',
		'Other' => 'Other'
		);
		$expected_industry_H1_picklist_values = array(
		'--None--' => '--None--',
		'Apparel' => 'Apparel',
		'Banking' => 'Banking',
		'Biotechnology' => 'Biotechnology',
		'Chemicals' => 'Chemicals',
		'Communications'=> 'Communications',
		'Construction' => 'Construction',
		'Consulting' => 'Consulting',
		'Education' => 'Education',
		'Electronics' => 'Electronics',
		'Energy' => 'Energy',
		'Engineering' => 'Engineering',
		'Entertainment' => 'Entertainment',
		'Environmental' => 'Environmental',
		'Finance' => 'Finance',
		'Food & Beverage' => 'Food & Beverage',
		'Government' => 'Government',
		'Healthcare' => 'Healthcare',
		'Hospitality' => 'Hospitality',
		'Insurance' => 'Insurance',
		'Machinery' => 'Machinery',
		'Manufacturing' => 'Manufacturing',
		'Media' => 'Media',
		'Not For Profit' => 'Not For Profit',
		'Recreation' => 'Recreation',
		'Retail' => 'Retail',
		'Shipping' => 'Shipping',
		'Technology' => 'Technology',
		'Telecommunications' => 'Telecommunications',
		'Transportation' => 'Transportation',
		'Utilities' => 'Utilities',
		'Other' => 'Other'
		);
		$expected_industry_H2_picklist_values = array(
		'--None--' => '--None--',
		'Apparel' => 'Apparel',
		'Banking' => 'Banking',
		'Biotechnology' => 'Biotechnology',
		'Chemicals' => 'Chemicals',
		'Communications'=> 'Communications',
		'Construction' => 'Construction',
		'Consulting' => 'Consulting',
		'Education' => 'Education',
		'Electronics' => 'Electronics',
		'Energy' => 'Energy',
		'Engineering' => 'Engineering',
		'Entertainment' => 'Entertainment',
		'Environmental' => 'Environmental',
		'Finance' => 'Finance',
		'Food & Beverage' => 'Food & Beverage',
		'Government' => 'Government',
		'Healthcare' => 'Healthcare',
		'Hospitality' => 'Hospitality',
		'Insurance' => 'Insurance',
		'Machinery' => 'Machinery',
		'Manufacturing' => 'Manufacturing',
		'Media' => 'Media',
		'Not For Profit' => 'Not For Profit',
		'Recreation' => 'Recreation',
		'Retail' => 'Retail',
		'Shipping' => 'Shipping',
		'Technology' => 'Technology',
		'Telecommunications' => 'Telecommunications',
		'Transportation' => 'Transportation',
		'Utilities' => 'Utilities',
		'Other' => 'Other'
		);
		$expected_industry_H3_picklist_values = array(
		'--None--' => '--None--',
		'Apparel' => 'Apparel',
		'Banking' => 'Banking',
		'Biotechnology' => 'Biotechnology',
		'Chemicals' => 'Chemicals',
		'Communications'=> 'Communications',
		'Construction' => 'Construction',
		'Consulting' => 'Consulting',
		'Education' => 'Education',
		'Electronics' => 'Electronics',
		'Energy' => 'Energy',
		'Engineering' => 'Engineering',
		'Entertainment' => 'Entertainment',
		'Environmental' => 'Environmental',
		'Finance' => 'Finance',
		'Food & Beverage' => 'Food & Beverage',
		'Government' => 'Government',
		'Healthcare' => 'Healthcare',
		'Hospitality' => 'Hospitality',
		'Insurance' => 'Insurance',
		'Machinery' => 'Machinery',
		'Manufacturing' => 'Manufacturing',
		'Media' => 'Media',
		'Not For Profit' => 'Not For Profit',
		'Recreation' => 'Recreation',
		'Retail' => 'Retail',
		'Shipping' => 'Shipping',
		'Technology' => 'Technology',
		'Telecommunications' => 'Telecommunications',
		'Transportation' => 'Transportation',
		'Utilities' => 'Utilities',
		'Other' => 'Other'
		);
		$expected_industry_H4_picklist_values = array(
		'--None--' => '--None--',
		'Apparel' => 'Apparel',
		'Banking' => 'Banking',
		'Biotechnology' => 'Biotechnology',
		'Chemicals' => 'Chemicals',
		'Communications'=> 'Communications',
		'Construction' => 'Construction',
		'Consulting' => 'Consulting',
		'Education' => 'Education',
		'Electronics' => 'Electronics',
		'Energy' => 'Energy',
		'Engineering' => 'Engineering',
		'Entertainment' => 'Entertainment',
		'Environmental' => 'Environmental',
		'Finance' => 'Finance',
		'Food & Beverage' => 'Food & Beverage',
		'Government' => 'Government',
		'Healthcare' => 'Healthcare',
		'Hospitality' => 'Hospitality',
		'Insurance' => 'Insurance',
		'Machinery' => 'Machinery',
		'Manufacturing' => 'Manufacturing',
		'Media' => 'Media',
		'Not For Profit' => 'Not For Profit',
		'Recreation' => 'Recreation',
		'Retail' => 'Retail',
		'Shipping' => 'Shipping',
		'Technology' => 'Technology',
		'Telecommunications' => 'Telecommunications',
		'Transportation' => 'Transportation',
		'Utilities' => 'Utilities',
		'Other' => 'Other'
		);
		$expected_industry_H5_picklist_values = array(
		'--None--' => '--None--',
		'Apparel' => 'Apparel',
		'Banking' => 'Banking',
		'Biotechnology' => 'Biotechnology',
		'Chemicals' => 'Chemicals',
		'Communications'=> 'Communications',
		'Construction' => 'Construction',
		'Consulting' => 'Consulting',
		'Education' => 'Education',
		'Electronics' => 'Electronics',
		'Energy' => 'Energy',
		'Engineering' => 'Engineering',
		'Entertainment' => 'Entertainment',
		'Environmental' => 'Environmental',
		'Finance' => 'Finance',
		'Food & Beverage' => 'Food & Beverage',
		'Government' => 'Government',
		'Healthcare' => 'Healthcare',
		'Hospitality' => 'Hospitality',
		'Insurance' => 'Insurance',
		'Machinery' => 'Machinery',
		'Manufacturing' => 'Manufacturing',
		'Media' => 'Media',
		'Not For Profit' => 'Not For Profit',
		'Recreation' => 'Recreation',
		'Retail' => 'Retail',
		'Shipping' => 'Shipping',
		'Technology' => 'Technology',
		'Telecommunications' => 'Telecommunications',
		'Transportation' => 'Transportation',
		'Utilities' => 'Utilities',
		'Other' => 'Other'
		);
		$expected_industry_H6_picklist_values = array(
		'--None--' => '--None--',
		'Apparel' => 'Apparel',
		'Banking' => 'Banking',
		'Biotechnology' => 'Biotechnology',
		'Chemicals' => 'Chemicals',
		'Communications'=> 'Communications',
		'Construction' => 'Construction',
		'Consulting' => 'Consulting',
		'Education' => 'Education',
		'Electronics' => 'Electronics',
		'Energy' => 'Energy',
		'Engineering' => 'Engineering',
		'Entertainment' => 'Entertainment',
		'Environmental' => 'Environmental',
		'Finance' => 'Finance',
		'Food & Beverage' => 'Food & Beverage',
		'Government' => 'Government',
		'Healthcare' => 'Healthcare',
		'Hospitality' => 'Hospitality',
		'Insurance' => 'Insurance',
		'Machinery' => 'Machinery',
		'Manufacturing' => 'Manufacturing',
		'Media' => 'Media',
		'Not For Profit' => 'Not For Profit',
		'Recreation' => 'Recreation',
		'Retail' => 'Retail',
		'Shipping' => 'Shipping',
		'Technology' => 'Technology',
		'Telecommunications' => 'Telecommunications',
		'Transportation' => 'Transportation',
		'Utilities' => 'Utilities',
		'Other' => 'Other'
		);
		$expected_rating_H1_picklist_values = array(
		'--None--' => '--None--',
		'Acquired' => 'Acquired',
		'Active' => 'Active',
		'Market Failed' => 'Market Failed',
		'Project Cancelled' => 'Project Cancelled',
		'Shutdown' => 'Shutdown'
		);
		$expected_rating_H2_picklist_values = array(
		'--None--' => '--None--',
		'Acquired' => 'Acquired',
		'Active' => 'Active',
		'Market Failed' => 'Market Failed',
		'Project Cancelled' => 'Project Cancelled',
		'Shutdown' => 'Shutdown'
		);
		$expected_rating_H3_picklist_values = array(
		'--None--' => '--None--',
		'Acquired' => 'Acquired',
		'Active' => 'Active',
		'Market Failed' => 'Market Failed',
		'Project Cancelled' => 'Project Cancelled',
		'Shutdown' => 'Shutdown'
		);
		$expected_rating_H4_picklist_values = array(
		'--None--' => '--None--',
		'Acquired' => 'Acquired',
		'Active' => 'Active',
		'Market Failed' => 'Market Failed',
		'Project Cancelled' => 'Project Cancelled',
		'Shutdown' => 'Shutdown'
		);
		$expected_rating_H5_picklist_values = array(
		'--None--' => '--None--',
		'Acquired' => 'Acquired',
		'Active' => 'Active',
		'Market Failed' => 'Market Failed'
		);
		$expected_rating_H6_picklist_values = array(
		'--None--' => '--None--',
		'Acquired' => 'Acquired',
		'Active' => 'Active',
		'Market Failed' => 'Market Failed',
		'Project Cancelled' => 'Project Cancelled',
		'Shutdown' => 'Shutdown'
		);
		$expected_cf_729_H1_picklist_values = array(
		'one' => 'one',
		'two' => 'two',
		'three' => 'three'
		);
		$expected_cf_729_H2_picklist_values = array(
		'one' => 'one',
		'two' => 'two',
		'three' => 'three'
		);
		$expected_cf_729_H3_picklist_values = array(
		'one' => 'one',
		'two' => 'two',
		'three' => 'three'
		);
		$expected_cf_729_H4_picklist_values = array(
		'one' => 'one',
		'two' => 'two',
		'three' => 'three'
		);
		$expected_cf_729_H5_picklist_values = array(
		'one' => 'one',
		'two' => 'two',
		'three' => 'three'
		);
		$expected_cf_729_H6_picklist_values = array(
		'one' => 'one',
		'two' => 'two',
		'three' => 'three'
		);
		$expected_cf_730_H1_picklist_values = array(
		"oneone" => "oneone",
		"onetwo" => "onetwo",
		"twoone" => "twoone",
		"twotwo" => "twotwo",
		"threeone" => "threeone",
		"threetwo" => "threetwo"
		);
		$expected_cf_730_H2_picklist_values = array(
		"oneone" => "oneone",
		"onetwo" => "onetwo",
		"twoone" => "twoone",
		"twotwo" => "twotwo",
		"threeone" => "threeone",
		"threetwo" => "threetwo"
		);
		$expected_cf_730_H3_picklist_values = array(
		"oneone" => "oneone",
		"onetwo" => "onetwo",
		"twoone" => "twoone",
		"twotwo" => "twotwo",
		"threeone" => "threeone",
		"threetwo" => "threetwo"
		);
		$expected_cf_730_H4_picklist_values = array(
		"oneone" => "oneone",
		"onetwo" => "onetwo",
		"twoone" => "twoone",
		"twotwo" => "twotwo",
		"threeone" => "threeone",
		"threetwo" => "threetwo"
		);
		$expected_cf_730_H5_picklist_values = array(
		"oneone" => "oneone",
		"onetwo" => "onetwo",
		"twoone" => "twoone",
		"twotwo" => "twotwo",
		"threeone" => "threeone",
		"threetwo" => "threetwo"
		);
		$expected_cf_730_H6_picklist_values = array(
		"oneone" => "oneone",
		"onetwo" => "onetwo",
		"twoone" => "twoone",
		"twotwo" => "twotwo",
		"threeone" => "threeone",
		"threetwo" => "threetwo"
		);
		$expected_cf_731_H1_picklist_values = array(
		'oneoneone' => 'oneoneone',
		'oneonetwo' => 'oneonetwo',
		'onetwoone' => 'onetwoone',
		'onetwotwo' => 'onetwotwo',
		'twooneone' => 'twooneone',
		'twoonetwo' => 'twoonetwo',
		'twotwoone' => 'twotwoone',
		'twotwotwo' => 'twotwotwo',
		'threeoneone' => 'threeoneone',
		'threeonetwo' => 'threeonetwo',
		'threetwoone' => 'threetwoone',
		'threetwotwo' => 'threetwotwo'
		);
		$expected_cf_731_H2_picklist_values = array(
		'oneoneone' => 'oneoneone',
		'oneonetwo' => 'oneonetwo',
		'onetwoone' => 'onetwoone',
		'onetwotwo' => 'onetwotwo',
		'twooneone' => 'twooneone',
		'twoonetwo' => 'twoonetwo',
		'twotwoone' => 'twotwoone',
		'twotwotwo' => 'twotwotwo',
		'threeoneone' => 'threeoneone',
		'threeonetwo' => 'threeonetwo',
		'threetwoone' => 'threetwoone',
		'threetwotwo' => 'threetwotwo'
		);
		$expected_cf_731_H3_picklist_values = array(
		'oneoneone' => 'oneoneone',
		'oneonetwo' => 'oneonetwo',
		'onetwoone' => 'onetwoone',
		'onetwotwo' => 'onetwotwo',
		'twooneone' => 'twooneone',
		'twoonetwo' => 'twoonetwo',
		'twotwoone' => 'twotwoone',
		'twotwotwo' => 'twotwotwo',
		'threeoneone' => 'threeoneone',
		'threeonetwo' => 'threeonetwo',
		'threetwoone' => 'threetwoone',
		'threetwotwo' => 'threetwotwo'
		);
		$expected_cf_731_H4_picklist_values = array(
		'oneoneone' => 'oneoneone',
		'oneonetwo' => 'oneonetwo',
		'onetwoone' => 'onetwoone',
		'onetwotwo' => 'onetwotwo',
		'twooneone' => 'twooneone',
		'twoonetwo' => 'twoonetwo',
		'twotwoone' => 'twotwoone',
		'twotwotwo' => 'twotwotwo',
		'threeoneone' => 'threeoneone',
		'threeonetwo' => 'threeonetwo',
		'threetwoone' => 'threetwoone',
		'threetwotwo' => 'threetwotwo'
		);
		$expected_cf_731_H5_picklist_values = array(
		'oneoneone' => 'oneoneone',
		'oneonetwo' => 'oneonetwo',
		'onetwoone' => 'onetwoone',
		'onetwotwo' => 'onetwotwo',
		'twooneone' => 'twooneone',
		'twoonetwo' => 'twoonetwo',
		'twotwoone' => 'twotwoone',
		'twotwotwo' => 'twotwotwo',
		'threeoneone' => 'threeoneone',
		'threeonetwo' => 'threeonetwo',
		'threetwoone' => 'threetwoone',
		'threetwotwo' => 'threetwotwo'
		);
		$expected_cf_731_H6_picklist_values = array(
		'oneoneone' => 'oneoneone',
		'oneonetwo' => 'oneonetwo',
		'onetwoone' => 'onetwoone',
		'onetwotwo' => 'onetwotwo',
		'twooneone' => 'twooneone',
		'twoonetwo' => 'twoonetwo',
		'twotwoone' => 'twotwoone',
		'twotwotwo' => 'twotwotwo',
		'threeoneone' => 'threeoneone',
		'threeonetwo' => 'threeonetwo',
		'threetwoone' => 'threetwoone',
		'threetwotwo' => 'threetwotwo'
		);
		$expected_cf_732_H1_picklist_values = array(
		'Adipose 3' => 'Adipose 3',
		'Barcelona' => 'Barcelona',
		'Chronos' => 'Chronos',
		'Dioscuros' => 'Dioscuros',
		'Earth' => 'Earth',
		'Florana' => 'Florana',
		'Gallifrey' => 'Gallifrey',
		'House' => 'House',
		'Indigo 3' => 'Indigo 3',
		'Jaconda' => 'Jaconda',
		'Karris' => 'Karris',
		'The Library' => 'The Library',
		'Midnight' => 'Midnight',
		'New Alexandria' => 'New Alexandria',
		'Oblivion' => 'Oblivion',
		'Poosh' => 'Poosh',
		'Qualactin' => 'Qualactin',
		'Rit' => 'Rit',
		'Salvak' => 'Salvak',
		'Tara' => 'Tara',
		'Utopia' => 'Utopia',
		'Vandos' => 'Vandos',
		'Woldyhool' => 'Woldyhool',
		'Xeros' => 'Xeros',
		'Yegros Alpha' => 'Yegros Alpha',
		'Zygor' => 'Zygor'
		);
		$expected_cf_732_H2_picklist_values = array(
		'Adipose 3' => 'Adipose 3',
		'Barcelona' => 'Barcelona',
		'Chronos' => 'Chronos',
		'Dioscuros' => 'Dioscuros',
		'Earth' => 'Earth',
		'Florana' => 'Florana',
		'Gallifrey' => 'Gallifrey',
		'House' => 'House',
		'Indigo 3' => 'Indigo 3',
		'Jaconda' => 'Jaconda',
		'Karris' => 'Karris',
		'The Library' => 'The Library',
		'Midnight' => 'Midnight',
		'New Alexandria' => 'New Alexandria',
		'Oblivion' => 'Oblivion',
		'Poosh' => 'Poosh',
		'Qualactin' => 'Qualactin',
		'Rit' => 'Rit',
		'Salvak' => 'Salvak',
		'Tara' => 'Tara',
		'Utopia' => 'Utopia',
		'Vandos' => 'Vandos',
		'Woldyhool' => 'Woldyhool',
		'Xeros' => 'Xeros',
		'Yegros Alpha' => 'Yegros Alpha',
		'Zygor' => 'Zygor'
		);
		$expected_cf_732_H3_picklist_values = array(
		'Adipose 3' => 'Adipose 3',
		'Barcelona' => 'Barcelona',
		'Chronos' => 'Chronos',
		'Dioscuros' => 'Dioscuros',
		'Earth' => 'Earth',
		'Florana' => 'Florana',
		'Gallifrey' => 'Gallifrey',
		'House' => 'House',
		'Indigo 3' => 'Indigo 3',
		'Jaconda' => 'Jaconda',
		'Karris' => 'Karris',
		'The Library' => 'The Library',
		'Midnight' => 'Midnight',
		'New Alexandria' => 'New Alexandria',
		'Oblivion' => 'Oblivion',
		'Poosh' => 'Poosh',
		'Qualactin' => 'Qualactin',
		'Rit' => 'Rit',
		'Salvak' => 'Salvak',
		'Tara' => 'Tara',
		'Utopia' => 'Utopia',
		'Vandos' => 'Vandos',
		'Woldyhool' => 'Woldyhool',
		'Xeros' => 'Xeros',
		'Yegros Alpha' => 'Yegros Alpha',
		'Zygor' => 'Zygor'
		);
		$expected_cf_732_H4_picklist_values = array(
		'Adipose 3' => 'Adipose 3',
		'Barcelona' => 'Barcelona',
		'Chronos' => 'Chronos',
		'Dioscuros' => 'Dioscuros',
		'Earth' => 'Earth',
		'Florana' => 'Florana',
		'Gallifrey' => 'Gallifrey',
		'House' => 'House',
		'Indigo 3' => 'Indigo 3',
		'Jaconda' => 'Jaconda',
		'Karris' => 'Karris',
		'The Library' => 'The Library',
		'Midnight' => 'Midnight',
		'New Alexandria' => 'New Alexandria',
		'Oblivion' => 'Oblivion',
		'Poosh' => 'Poosh',
		'Qualactin' => 'Qualactin',
		'Rit' => 'Rit',
		'Salvak' => 'Salvak',
		'Tara' => 'Tara',
		'Utopia' => 'Utopia',
		'Vandos' => 'Vandos',
		'Woldyhool' => 'Woldyhool',
		'Xeros' => 'Xeros',
		'Yegros Alpha' => 'Yegros Alpha',
		'Zygor' => 'Zygor'
		);
		$expected_cf_732_H5_picklist_values = array(
		'Adipose 3' => 'Adipose 3',
		'Barcelona' => 'Barcelona',
		'Chronos' => 'Chronos',
		'Dioscuros' => 'Dioscuros',
		'Earth' => 'Earth',
		'Florana' => 'Florana',
		'Gallifrey' => 'Gallifrey',
		'House' => 'House',
		'Indigo 3' => 'Indigo 3',
		'Jaconda' => 'Jaconda',
		'Karris' => 'Karris',
		'The Library' => 'The Library',
		'Midnight' => 'Midnight',
		'New Alexandria' => 'New Alexandria',
		'Oblivion' => 'Oblivion',
		'Poosh' => 'Poosh',
		'Qualactin' => 'Qualactin',
		'Rit' => 'Rit',
		'Salvak' => 'Salvak',
		'Tara' => 'Tara',
		'Utopia' => 'Utopia',
		'Vandos' => 'Vandos',
		'Woldyhool' => 'Woldyhool',
		'Xeros' => 'Xeros',
		'Yegros Alpha' => 'Yegros Alpha',
		'Zygor' => 'Zygor'
		);
		$expected_cf_732_H6_picklist_values = array(
		'Adipose 3' => 'Adipose 3',
		'Barcelona' => 'Barcelona',
		'Chronos' => 'Chronos',
		'Dioscuros' => 'Dioscuros',
		'Earth' => 'Earth',
		'Florana' => 'Florana',
		'Gallifrey' => 'Gallifrey',
		'House' => 'House',
		'Indigo 3' => 'Indigo 3',
		'Jaconda' => 'Jaconda',
		'Karris' => 'Karris',
		'The Library' => 'The Library',
		'Midnight' => 'Midnight',
		'New Alexandria' => 'New Alexandria',
		'Oblivion' => 'Oblivion',
		'Poosh' => 'Poosh',
		'Qualactin' => 'Qualactin',
		'Rit' => 'Rit',
		'Salvak' => 'Salvak',
		'Tara' => 'Tara',
		'Utopia' => 'Utopia',
		'Vandos' => 'Vandos',
		'Woldyhool' => 'Woldyhool',
		'Xeros' => 'Xeros',
		'Yegros Alpha' => 'Yegros Alpha',
		'Zygor' => 'Zygor'
		);
	  // Contacts Module Picklist Values
		$expected_leadsource_H1_picklist_values = array(
		'--None--' => '--None--',
		'Cold Call' => 'Cold Call',
		'Existing Customer' => 'Existing Customer',
		'Self Generated' => 'Self Generated',
		'Employee' => 'Employee',
		'Partner' => 'Partner',
		'Public Relations' => 'Public Relations',
		'Direct Mail' => 'Direct Mail',
		'Conference' => 'Conference',
		'Trade Show' => 'Trade Show',
		'Web Site' => 'Web Site',
		'Word of mouth' => 'Word of mouth',
		'Other' => 'Other'
		);
		$expected_leadsource_H2_picklist_values = array(
		'--None--' => '--None--',
		'Cold Call' => 'Cold Call',
		'Existing Customer' => 'Existing Customer',
		'Self Generated' => 'Self Generated',
		'Employee' => 'Employee',
		'Partner' => 'Partner',
		'Public Relations' => 'Public Relations',
		'Direct Mail' => 'Direct Mail',
		'Conference' => 'Conference',
		'Trade Show' => 'Trade Show',
		'Web Site' => 'Web Site',
		'Word of mouth' => 'Word of mouth',
		'Other' => 'Other'
		);
		$expected_leadsource_H3_picklist_values = array(
		'--None--' => '--None--',
		'Cold Call' => 'Cold Call',
		'Existing Customer' => 'Existing Customer',
		'Self Generated' => 'Self Generated',
		'Employee' => 'Employee',
		'Partner' => 'Partner',
		'Public Relations' => 'Public Relations',
		'Direct Mail' => 'Direct Mail',
		'Conference' => 'Conference',
		'Trade Show' => 'Trade Show',
		'Web Site' => 'Web Site',
		'Word of mouth' => 'Word of mouth',
		'Other' => 'Other'
		);
		$expected_leadsource_H4_picklist_values = array(
		'--None--' => '--None--',
		'Cold Call' => 'Cold Call',
		'Existing Customer' => 'Existing Customer',
		'Self Generated' => 'Self Generated',
		'Employee' => 'Employee',
		'Partner' => 'Partner',
		'Public Relations' => 'Public Relations',
		'Direct Mail' => 'Direct Mail',
		'Conference' => 'Conference',
		'Trade Show' => 'Trade Show',
		'Web Site' => 'Web Site',
		'Word of mouth' => 'Word of mouth',
		'Other' => 'Other'
		);
		$expected_leadsource_H5_picklist_values = array(
		'--None--' => '--None--',
		'Cold Call' => 'Cold Call',
		'Existing Customer' => 'Existing Customer',
		'Self Generated' => 'Self Generated',
		'Employee' => 'Employee',
		'Partner' => 'Partner',
		'Public Relations' => 'Public Relations',
		'Direct Mail' => 'Direct Mail',
		'Conference' => 'Conference',
		'Trade Show' => 'Trade Show',
		'Web Site' => 'Web Site',
		'Word of mouth' => 'Word of mouth'
		);
		$expected_leadsource_H6_picklist_values = array(
		'--None--' => '--None--',
		'Cold Call' => 'Cold Call',
		'Existing Customer' => 'Existing Customer',
		'Self Generated' => 'Self Generated',
		'Employee' => 'Employee',
		'Partner' => 'Partner',
		'Public Relations' => 'Public Relations',
		'Direct Mail' => 'Direct Mail',
		'Conference' => 'Conference',
		'Trade Show' => 'Trade Show',
		'Web Site' => 'Web Site',
		'Word of mouth' => 'Word of mouth',
		'Other' => 'Other'
		);
		$expected_salutationtype_H1_picklist_values = array(
		'--None--' => '--None--',
		'Mr.' => 'Mr.',
		'Ms.' => 'Ms.',
		'Mrs.' => 'Mrs.',
		'Dr.' => 'Dr.',
		'Prof.' => 'Prof.'
		);
		$expected_salutationtype_H2_picklist_values = array(
		'--None--' => '--None--',
		'Mr.' => 'Mr.',
		'Ms.' => 'Ms.',
		'Mrs.' => 'Mrs.',
		'Dr.' => 'Dr.',
		'Prof.' => 'Prof.'
		);
		$expected_salutationtype_H3_picklist_values = array(
		'--None--' => '--None--',
		'Mr.' => 'Mr.',
		'Ms.' => 'Ms.',
		'Mrs.' => 'Mrs.',
		'Dr.' => 'Dr.',
		'Prof.' => 'Prof.'
		);
		$expected_salutationtype_H4_picklist_values = array(
		'--None--' => '--None--',
		'Mr.' => 'Mr.',
		'Ms.' => 'Ms.',
		'Mrs.' => 'Mrs.',
		'Dr.' => 'Dr.',
		'Prof.' => 'Prof.'
		);
		$expected_salutationtype_H5_picklist_values = array(
		'--None--' => '--None--',
		'Mr.' => 'Mr.',
		'Ms.' => 'Ms.',
		'Mrs.' => 'Mrs.',
		'Dr.' => 'Dr.',
		'Prof.' => 'Prof.'
		);
		$expected_salutationtype_H6_picklist_values = array(
		'--None--' => '--None--',
		'Mr.' => 'Mr.',
		'Ms.' => 'Ms.',
		'Mrs.' => 'Mrs.',
		'Dr.' => 'Dr.',
		'Prof.' => 'Prof.'
		);
	  // HelpDesk Module Picklist Values
		$expected_ticketcategories_H1_picklist_values = array(
		'Big Problem'=> 'Big Problem',
		'Small Problem'=> 'Small Problem',
		'Other Problem'=> 'Other Problem'
		);
		$expected_ticketcategories_H2_picklist_values = array(
		'Big Problem'=> 'Big Problem',
		'Small Problem'=> 'Small Problem',
		'Other Problem'=> 'Other Problem'
		);
		$expected_ticketcategories_H3_picklist_values = array(
		'Big Problem'=> 'Big Problem',
		'Small Problem'=> 'Small Problem',
		'Other Problem'=> 'Other Problem'
		);
		$expected_ticketcategories_H4_picklist_values = array(
		'Big Problem'=> 'Big Problem',
		'Small Problem'=> 'Small Problem',
		'Other Problem'=> 'Other Problem'
		);
		$expected_ticketcategories_H5_picklist_values = array(
		'Big Problem'=> 'Big Problem',
		'Small Problem'=> 'Small Problem',
		'Other Problem'=> 'Other Problem'
		);
		$expected_ticketcategories_H6_picklist_values = array(
		'Big Problem'=> 'Big Problem',
		'Small Problem'=> 'Small Problem',
		'Other Problem'=> 'Other Problem'
		);
		$expected_ticketpriorities_H1_picklist_values = array(
		'Low' => 'Low',
		'Normal'=> 'Normal',
		'High'=> 'High',
		'Urgent'=> 'Urgent'
		);
		$expected_ticketpriorities_H2_picklist_values = array(
		'Low' => 'Low',
		'Normal'=> 'Normal',
		'High'=> 'High',
		'Urgent'=> 'Urgent'
		);
		$expected_ticketpriorities_H3_picklist_values = array(
		'Low' => 'Low',
		'Normal'=> 'Normal',
		'High'=> 'High',
		'Urgent'=> 'Urgent'
		);
		$expected_ticketpriorities_H4_picklist_values = array(
		'Low' => 'Low',
		'Normal'=> 'Normal',
		'High'=> 'High',
		'Urgent'=> 'Urgent'
		);
		$expected_ticketpriorities_H5_picklist_values = array(
		'Low' => 'Low',
		'Normal'=> 'Normal',
		'High'=> 'High'
		);
		$expected_ticketpriorities_H6_picklist_values = array(
		'Low' => 'Low',
		'Normal'=> 'Normal',
		'High'=> 'High',
		'Urgent'=> 'Urgent'
		);
		$expected_ticketseverities_H1_picklist_values = array(
		"Minor" => "Minor",
		"Major" => "Major",
		"Feature" => "Feature",
		"Critical" => "Critical"
		);
		$expected_ticketseverities_H2_picklist_values = array(
		"Minor" => "Minor",
		"Major" => "Major",
		"Feature" => "Feature",
		"Critical" => "Critical"
		);
		$expected_ticketseverities_H3_picklist_values = array(
		"Minor" => "Minor",
		"Major" => "Major",
		"Feature" => "Feature",
		"Critical" => "Critical"
		);
		$expected_ticketseverities_H4_picklist_values = array(
		"Minor" => "Minor",
		"Major" => "Major",
		"Feature" => "Feature",
		"Critical" => "Critical"
		);
		$expected_ticketseverities_H5_picklist_values = array(
		"Minor" => "Minor",
		"Major" => "Major",
		"Feature" => "Feature",
		"Critical" => "Critical"
		);
		$expected_ticketseverities_H6_picklist_values = array(
		"Minor" => "Minor",
		"Major" => "Major",
		"Feature" => "Feature",
		"Critical" => "Critical"
		);
		$expected_ticketstatus_H1_picklist_values = array(
		'Open' => 'Open',
		'In Progress' =>'In Progress',
		'Wait For Response' => 'Wait For Response',
		'Closed' => 'Closed'
		);
		$expected_ticketstatus_H2_picklist_values = array(
		'Open' => 'Open',
		'In Progress' =>'In Progress',
		'Wait For Response' => 'Wait For Response',
		'Closed' => 'Closed'
		);
		$expected_ticketstatus_H3_picklist_values = array(
		'Open' => 'Open',
		'In Progress' =>'In Progress',
		'Wait For Response' => 'Wait For Response',
		'Closed' => 'Closed'
		);
		$expected_ticketstatus_H4_picklist_values = array(
		'Open' => 'Open',
		'In Progress' =>'In Progress',
		'Wait For Response' => 'Wait For Response',
		'Closed' => 'Closed'
		);
		$expected_ticketstatus_H5_picklist_values = array(
		'Open' => 'Open',
		'In Progress' =>'In Progress',
		'Wait For Response' => 'Wait For Response'
		);
		$expected_ticketstatus_H6_picklist_values = array(
		'Open' => 'Open',
		'In Progress' =>'In Progress',
		'Wait For Response' => 'Wait For Response',
		'Closed' => 'Closed'
		);
		return array(
		array('accounttype', 'H1', $expected_accounttype_H1_picklist_values),
		array('accounttype', 'H2', $expected_accounttype_H2_picklist_values),
		array('accounttype', 'H3', $expected_accounttype_H3_picklist_values),
		array('accounttype', 'H4', $expected_accounttype_H4_picklist_values),
		array('accounttype', 'H5', $expected_accounttype_H5_picklist_values),
		array('accounttype', 'H6', $expected_accounttype_H6_picklist_values),
		array('industry', 'H1', $expected_industry_H1_picklist_values),
		array('industry', 'H2', $expected_industry_H2_picklist_values),
		array('industry', 'H3', $expected_industry_H3_picklist_values),
		array('industry', 'H4', $expected_industry_H4_picklist_values),
		array('industry', 'H5', $expected_industry_H5_picklist_values),
		array('industry', 'H6', $expected_industry_H6_picklist_values),
		array('rating', 'H1', $expected_rating_H1_picklist_values),
		array('rating', 'H2', $expected_rating_H2_picklist_values),
		array('rating', 'H3', $expected_rating_H3_picklist_values),
		array('rating', 'H4', $expected_rating_H4_picklist_values),
		array('rating', 'H5', $expected_rating_H5_picklist_values),
		array('rating', 'H6', $expected_rating_H6_picklist_values),
		array('cf_729', 'H1', $expected_cf_729_H1_picklist_values),
		array('cf_729', 'H2', $expected_cf_729_H2_picklist_values),
		array('cf_729', 'H3', $expected_cf_729_H3_picklist_values),
		array('cf_729', 'H4', $expected_cf_729_H4_picklist_values),
		array('cf_729', 'H5', $expected_cf_729_H5_picklist_values),
		array('cf_729', 'H6', $expected_cf_729_H6_picklist_values),
		array('cf_730', 'H1', $expected_cf_730_H1_picklist_values),
		array('cf_730', 'H2', $expected_cf_730_H2_picklist_values),
		array('cf_730', 'H3', $expected_cf_730_H3_picklist_values),
		array('cf_730', 'H4', $expected_cf_730_H4_picklist_values),
		array('cf_730', 'H5', $expected_cf_730_H5_picklist_values),
		array('cf_730', 'H6', $expected_cf_730_H6_picklist_values),
		array('cf_731', 'H1', $expected_cf_731_H1_picklist_values),
		array('cf_731', 'H2', $expected_cf_731_H2_picklist_values),
		array('cf_731', 'H3', $expected_cf_731_H3_picklist_values),
		array('cf_731', 'H4', $expected_cf_731_H4_picklist_values),
		array('cf_731', 'H5', $expected_cf_731_H5_picklist_values),
		array('cf_731', 'H6', $expected_cf_731_H6_picklist_values),
		array('cf_732', 'H1', $expected_cf_732_H1_picklist_values),
		array('cf_732', 'H2', $expected_cf_732_H2_picklist_values),
		array('cf_732', 'H3', $expected_cf_732_H3_picklist_values),
		array('cf_732', 'H4', $expected_cf_732_H4_picklist_values),
		array('cf_732', 'H5', $expected_cf_732_H5_picklist_values),
		array('cf_732', 'H6', $expected_cf_732_H6_picklist_values),
		array('leadsource', 'H1', $expected_leadsource_H1_picklist_values),
		array('leadsource', 'H2', $expected_leadsource_H2_picklist_values),
		array('leadsource', 'H3', $expected_leadsource_H3_picklist_values),
		array('leadsource', 'H4', $expected_leadsource_H4_picklist_values),
		array('leadsource', 'H5', $expected_leadsource_H5_picklist_values),
		array('leadsource', 'H6', $expected_leadsource_H6_picklist_values),
		array('salutationtype', 'H1', $expected_salutationtype_H1_picklist_values),
		array('salutationtype', 'H2', $expected_salutationtype_H2_picklist_values),
		array('salutationtype', 'H3', $expected_salutationtype_H3_picklist_values),
		array('salutationtype', 'H4', $expected_salutationtype_H4_picklist_values),
		array('salutationtype', 'H5', $expected_salutationtype_H5_picklist_values),
		array('salutationtype', 'H6', $expected_salutationtype_H6_picklist_values),
		array('ticketcategories', 'H1', $expected_ticketcategories_H1_picklist_values),
		array('ticketcategories', 'H2', $expected_ticketcategories_H2_picklist_values),
		array('ticketcategories', 'H3', $expected_ticketcategories_H3_picklist_values),
		array('ticketcategories', 'H4', $expected_ticketcategories_H4_picklist_values),
		array('ticketcategories', 'H5', $expected_ticketcategories_H5_picklist_values),
		array('ticketcategories', 'H6', $expected_ticketcategories_H6_picklist_values),
		array('ticketpriorities', 'H1', $expected_ticketpriorities_H1_picklist_values),
		array('ticketpriorities', 'H2', $expected_ticketpriorities_H2_picklist_values),
		array('ticketpriorities', 'H3', $expected_ticketpriorities_H3_picklist_values),
		array('ticketpriorities', 'H4', $expected_ticketpriorities_H4_picklist_values),
		array('ticketpriorities', 'H5', $expected_ticketpriorities_H5_picklist_values),
		array('ticketpriorities', 'H6', $expected_ticketpriorities_H6_picklist_values),
		array('ticketseverities', 'H1', $expected_ticketseverities_H1_picklist_values),
		array('ticketseverities', 'H2', $expected_ticketseverities_H2_picklist_values),
		array('ticketseverities', 'H3', $expected_ticketseverities_H3_picklist_values),
		array('ticketseverities', 'H4', $expected_ticketseverities_H4_picklist_values),
		array('ticketseverities', 'H5', $expected_ticketseverities_H5_picklist_values),
		array('ticketseverities', 'H6', $expected_ticketseverities_H6_picklist_values),
		array('ticketstatus', 'H1', $expected_ticketstatus_H1_picklist_values),
		array('ticketstatus', 'H2', $expected_ticketstatus_H2_picklist_values),
		array('ticketstatus', 'H3', $expected_ticketstatus_H3_picklist_values),
		array('ticketstatus', 'H4', $expected_ticketstatus_H4_picklist_values),
		array('ticketstatus', 'H5', $expected_ticketstatus_H5_picklist_values),
		array('ticketstatus', 'H6', $expected_ticketstatus_H6_picklist_values),
		);
	}

	/**
	 * Method testgetAssignedPicklistValues
	 * @test
	 * @dataProvider getAssignedPicklistValuesProvider
	 */
	public function testgetAssignedPicklistValues($tableName, $roleid, $expected_picklists_values) {
		global $adb;
		$actual = getAssignedPicklistValues($tableName, $roleid, $adb);
		$this->assertEquals($expected_picklists_values, $actual, "Test getAssignedPicklistValues Method on $tableName TableName and RoleId $roleid");
	}

	/**
	 * Method testgetAllowedPicklistModules
	 * @test
	 */
	public function testgetAllowedPicklistModules() {
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * Method testgetPicklistValuesSpecialUitypes
	 * @test
	 */
	public function testgetPicklistValuesSpecialUitypes() {
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}
}
?>
