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
	'Documents' => array(),
	'PBXManager' => array(
		array(
			'fieldlabel' => 'Status',
			'generatedtype' => '',
			'multii18n' => '1',
			'columnname' => 'status',
			'fieldname' => 'status',
			'uitype' => '16',
			'value' =>array(
				'Active' => 'Active',
				'Inactive' => 'Inactive',
			),
		)
	),
	'Accounts' => array(
	0 => array(
		'fieldlabel' => 'Status',
		'generatedtype' => '',
		'multii18n' => '1',
		'columnname' => 'campaignrelstatus',
		'fieldname' => 'campaignrelstatus',
		'uitype' => '16',
		'value' => array(
			'--None--' => '--None--',
			'Contacted - Never Contact Again' => 'Contacted - Never Contact Again',
			'Contacted - Successful' => 'Contacted - Successful',
			'Contacted - Unsuccessful' => 'Contacted - Unsuccessful',
		),
	),
	1 =>
	array (
	'fieldlabel' => 'Type',
	'generatedtype' => '',
	'multii18n' => '1',
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
	2 =>
	array (
	'fieldlabel' => 'industry',
	'generatedtype' => '',
	'multii18n' => '1',
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
	3 =>
	array (
	'fieldlabel' => 'Rating',
	'generatedtype' => '',
	'multii18n' => '1',
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
	4 =>
	array (
	'fieldlabel' => 'PLMain',
	'generatedtype' => '',
	'multii18n' => '1',
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
	5 =>
	array (
	'fieldlabel' => 'PLDep1',
	'generatedtype' => '',
	'multii18n' => '1',
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
	6 =>
	array (
	'fieldlabel' => 'PLDep2',
	'generatedtype' => '',
	'multii18n' => '1',
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
	7 =>
	array (
	'fieldlabel' => 'Planets',
	'generatedtype' => '',
	'multii18n' => '1',
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
	0 => array(
		'fieldlabel' => 'Status',
		'generatedtype' => '',
		'multii18n' => '1',
		'columnname' => 'campaignrelstatus',
		'fieldname' => 'campaignrelstatus',
		'uitype' => '16',
		'value' => array(
			'--None--' => '--None--',
			'Contacted - Never Contact Again' => 'Contacted - Never Contact Again',
			'Contacted - Successful' => 'Contacted - Successful',
			'Contacted - Unsuccessful' => 'Contacted - Unsuccessful',
		),
	),
	1 => array(
		'fieldlabel' => 'portalpasswordtype',
		'generatedtype' => '',
		'multii18n' => '1',
		'columnname' => 'portalpasswordtype',
		'fieldname' => 'portalpasswordtype',
		'uitype' => '16',
		'value' => array(
			'sha512' => 'sha512',
			'sha256' => 'sha256',
			'md5' => 'md5',
			'plaintext' => 'plaintext',
		),
	),
	2 =>
	array (
	'fieldlabel' => 'Lead Source',
	'generatedtype' => '',
	'multii18n' => '1',
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
	3 =>
	array (
	'fieldlabel' => 'Salutation',
	'generatedtype' => '',
	'multii18n' => '1',
	'columnname' => 'salutation',
	'fieldname' => 'salutationtype',
	'uitype' => '15',
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
	4 =>
	array (
	'fieldlabel' => 'Template Language',
	'generatedtype' => '',
	'multii18n' => '1',
	'columnname' => 'template_language',
	'fieldname' => 'template_language',
	'uitype' => '15',
	'value' =>
	array (
		'en' => 'en',
		'de' => 'de',
		'es' => 'es',
		'pt' => 'pt',
		'fr' => 'fr',
		'hu' => 'hu',
		'it' => 'it',
		'nl' => 'nl',
	),
	),
	),
	'HelpDesk' => array(
	0 =>
	array (
	'fieldlabel' => 'Category',
	'generatedtype' => '',
	'multii18n' => '1',
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
	'multii18n' => '1',
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
	'multii18n' => '1',
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
	'multii18n' => '1',
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
	'Documents' => array(),
	'PBXManager' => array(
		array(
			'fieldlabel' => 'Status',
			'generatedtype' => '',
			'multii18n' => '1',
			'columnname' => 'status',
			'fieldname' => 'status',
			'uitype' => '16',
			'value' =>array(
				'Active' => 'Active',
				'Inactive' => 'Inactive',
			),
		)
	),
	'Accounts' => array(
	0 => array(
		'fieldlabel' => 'Status',
		'generatedtype' => '',
		'multii18n' => '1',
		'columnname' => 'campaignrelstatus',
		'fieldname' => 'campaignrelstatus',
		'uitype' => '16',
		'value' => array(
			'--None--' => '--None--',
			'Contacted - Never Contact Again' => 'Contacted - Never Contact Again',
			'Contacted - Successful' => 'Contacted - Successful',
			'Contacted - Unsuccessful' => 'Contacted - Unsuccessful',
		),
	),
	1 =>
	array (
	'fieldlabel' => 'Type',
	'generatedtype' => '',
	'multii18n' => '1',
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
	2 =>
	array (
	'fieldlabel' => 'industry',
	'generatedtype' => '',
	'multii18n' => '1',
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
	3 =>
	array (
	'fieldlabel' => 'Rating',
	'generatedtype' => '',
	'multii18n' => '1',
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
	4 =>
	array (
	'fieldlabel' => 'PLMain',
	'generatedtype' => '',
	'multii18n' => '1',
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
	5 =>
	array (
	'fieldlabel' => 'PLDep1',
	'generatedtype' => '',
	'multii18n' => '1',
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
	6 =>
	array (
	'fieldlabel' => 'PLDep2',
	'generatedtype' => '',
	'multii18n' => '1',
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
	7 =>
	array (
	'fieldlabel' => 'Planets',
	'generatedtype' => '',
	'multii18n' => '1',
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
	0 => array(
		'fieldlabel' => 'Status',
		'generatedtype' => '',
		'multii18n' => '1',
		'columnname' => 'campaignrelstatus',
		'fieldname' => 'campaignrelstatus',
		'uitype' => '16',
		'value' => array(
			'--None--' => '--None--',
			'Contacted - Never Contact Again' => 'Contacted - Never Contact Again',
			'Contacted - Successful' => 'Contacted - Successful',
			'Contacted - Unsuccessful' => 'Contacted - Unsuccessful',
		),
	),
	1 => array(
		'fieldlabel' => 'portalpasswordtype',
		'generatedtype' => '',
		'multii18n' => '1',
		'columnname' => 'portalpasswordtype',
		'fieldname' => 'portalpasswordtype',
		'uitype' => '16',
		'value' => array(
			'sha512' => 'sha512',
			'sha256' => 'sha256',
			'md5' => 'md5',
			'plaintext' => 'plaintext',
		),
	),
	2 =>
	array (
	'fieldlabel' => 'Lead Source',
	'generatedtype' => '',
	'multii18n' => '1',
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
	3 =>
	array (
	'fieldlabel' => 'Salutation',
	'generatedtype' => '',
	'multii18n' => '1',
	'columnname' => 'salutation',
	'fieldname' => 'salutationtype',
	'uitype' => '15',
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
	4 =>
	array (
	'fieldlabel' => 'Template Language',
	'generatedtype' => '',
	'multii18n' => '1',
	'columnname' => 'template_language',
	'fieldname' => 'template_language',
	'uitype' => '15',
	'value' =>
	array (
		'en' => 'en',
		'de' => 'de',
		'es' => 'es',
		'pt' => 'pt',
		'fr' => 'fr',
		'hu' => 'hu',
		'it' => 'it',
		'nl' => 'nl',
	),
	),
	),
	'HelpDesk' => array(
	0 =>
	array (
	'fieldlabel' => 'Category',
	'generatedtype' => '',
	'multii18n' => '1',
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
	'multii18n' => '1',
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
	'multii18n' => '1',
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
	'multii18n' => '1',
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
		$mods = array('Accounts','Contacts','HelpDesk','Documents','PBXManager');
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
			'HelpDesk' => 'HelpDesk',
			'Products' => 'Products',
			'Faq' => 'Faq',
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
			'Messages' => 'Messages',
			'cbPulse' => 'cbPulse',
			'MsgTemplate' => 'MsgTemplate',
			'cbSurveyQuestion' => 'cbSurveyQuestion',
			'Credentials' => 'cbCredentials',
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
		$mods = array('Accounts','Contacts','HelpDesk','PBXManager');
		$expectedPLs = array(
			'Accounts' => array(
				'accounttype' => 'Type',
				'industry' => 'Industry',
				'rating' => 'Rating',
				'cf_729' => 'PLMain',
				'cf_730' => 'PLDep1',
				'cf_731' => 'PLDep2',
				'cf_732' => 'Planets',
				'campaignrelstatus' => 'Status',
							),
			'Contacts' => array(
				'leadsource' => 'Lead Source',
				'salutationtype' => 'Salutation ',
				'template_language' => 'Template Language',
				'campaignrelstatus' => 'Status',
				'portalpasswordtype' => 'portalpasswordtype',
			),
			'HelpDesk' => array(
				'ticketcategories' => 'Category',
				'ticketpriorities' => 'Priority',
				'ticketseverities' => 'Severity',
				'ticketstatus' => 'Status',
			),
			'PBXManager' => array(
				'status' => 'Status',
			),
		);
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
	 * @dataProvider getAllPicklistValuesProvider
	 */
	public function testgetAllPickListValues($fieldname, $lang, $expected_picklists_values) {
		$this->assertEquals($expected_picklists_values, getAllPickListValues($fieldname, $lang), "Test getAllPicklistValues Method on $fieldname");
	}

	/**
	 * Method testgetEditablePicklistValues
	 * @test
	 */
	public function testgetEditablePicklistValues() {
		global $adb;
		$expected = array(
			'Prospecting' => 'Prospecting',
			'Qualification' => 'Qualification',
			'Needs Analysis' => 'Needs Analysis',
			'Value Proposition' => 'Value Proposition',
			'Id. Decision Makers' => 'Id. Decision Makers',
			'Perception Analysis' => 'Perception Analysis',
			'Proposal/Price Quote' => 'Proposal/Price Quote',
			'Negotiation/Review' => 'Negotiation/Review',
		);
		$this->assertEquals($expected, getEditablePicklistValues('sales_stage', false, $adb), "Test getEditablePicklistValues Method on Potentials sales_stage");
		global $current_language;
		$current_language = 'es_es';
		$expected = array(
			'Prospecting' => 'Investigando',
			'Qualification' => 'Valorando',
			'Needs Analysis' => 'Necesita Análisis',
			'Value Proposition' => 'Valorando Proposición',
			'Id. Decision Makers' => 'Identificando Responsable',
			'Perception Analysis' => 'Analizando',
			'Proposal/Price Quote' => 'Presupuesto Propuesto',
			'Negotiation/Review' => 'Negociando/Revisando',
		);
		$this->assertEquals($expected, getEditablePicklistValues('sales_stage', true, $adb), "Test getEditablePicklistValues Method on Potentials sales_stage ES_ES");
		$current_language = 'en_us';
	}

	/**
	 * Method testgetNonEditablePicklistValues
	 * @test
	 */
	public function testgetNonEditablePicklistValues() {
		global $adb;
		$expected = array('Closed Won', 'Closed Lost');
		$this->assertEquals($expected, getNonEditablePicklistValues('sales_stage', array(), $adb), "Test getNonEditablePicklistValues Method on Potentials sales_stage");
		$expected[1] = 'Cerrado Ganado';
		$this->assertEquals(
			$expected,
			getNonEditablePicklistValues('sales_stage', array('Closed Lost' => 'Cerrado Ganado'), $adb),
			"Test getNonEditablePicklistValues Method on Potentials sales_stage with translation"
		);
	}

	/**
	 * Method testhasMultiLanguageSupport
	 * @test
	 */
	public function testhasMultiLanguageSupport() {
		global $adb;
		$this->assertTrue(hasMultiLanguageSupport('sales_stage'), "Test testhasMultiLanguageSupport Method on Potentials sales_stage TRUE");
		$adb->pquery('update vtiger_picklist set multii18n=0 where name=?', array('sales_stage'));
		$this->assertFalse(hasMultiLanguageSupport('sales_stage'), "Test testhasMultiLanguageSupport Method on Potentials sales_stage FALSE");
		$adb->pquery('update vtiger_picklist set multii18n=1 where name=?', array('sales_stage'));
	}

	/**
	 * Method testhasNonEditablePicklistValues
	 * @test
	 */
	public function testhasNonEditablePicklistValues() {
		$this->assertTrue(hasNonEditablePicklistValues('sales_stage'), "Test testhasNonEditablePicklistValues Method on Potentials sales_stage");
		$this->assertFalse(hasNonEditablePicklistValues('industry'), "Test testhasNonEditablePicklistValues Method on Accounts industry");
		$this->assertTrue(hasNonEditablePicklistValues('status'), "Test testhasNonEditablePicklistValues Method on uitype 16 picklist");
		$this->assertFalse(hasNonEditablePicklistValues('doesnotexist'), "Test testhasNonEditablePicklistValues Method on inexistent picklist");
	}

	/**
	 * Method getAllPicklistValuesProvider
	 * params
	 */
	public function getAllPicklistValuesProvider() {
		$expected_accounttype_picklist_values = array(
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
		$expected_industry_picklist_values = array(
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
			'Food &amp; Beverage' => 'Food &amp; Beverage',
		);
		$expected_ticketcategories_picklist_values = array(
			'Big Problem'=> 'Big Problem',
			'Small Problem'=> 'Small Problem',
			'Other Problem'=> 'Other Problem'
		);
		$expected_industry_picklist_values_translated = $expected_industry_picklist_values;
		$expected_industry_picklist_values_translated['Food &amp; Beverage'] = 'Food & Beverage';
		return array(
			array('accounttype', array(), $expected_accounttype_picklist_values),
			array('industry', array(), $expected_industry_picklist_values),
			array('industry', array('Food &amp; Beverage' => 'Food & Beverage'), $expected_industry_picklist_values_translated),
			array('ticketcategories', array(), $expected_ticketcategories_picklist_values),

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
		global $current_user;
		$actual = getAllowedPicklistModules();
		$expected = array(
			'Potentials',
			'Contacts',
			'Accounts',
			'Leads',
			'Documents',
			'Emails',
			'HelpDesk',
			'Products',
			'Faq',
			'Vendors',
			'PriceBooks',
			'Quotes',
			'PurchaseOrder',
			'SalesOrder',
			'Invoice',
			'Campaigns',
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
			'DocumentFolders',
			'pricebookproductrel',
			'AutoNumberPrefix',
		);
		sort($expected);
		sort($actual);
		$this->assertEquals($expected, $actual, "Test getAllowedPicklistModules admin no non-entities");
		$expected = array_merge($expected, array(
			'Dashboard',
			'Home',
			'Reports',
			'Portal',
			'Users',
			'ConfigEditor',
			'Import',
			'MailManager',
			'Mobile',
			'ModTracker',
			'VtigerBackup',
			'WSAPP',
			'CronTasks',
			'Tooltip',
			'Webforms',
			'Calendar4You',
			'evvtMenu',
			'cbAuditTrail',
			'cbLoginHistory',
			'EtiquetasOO',
			'evvtgendoc',
		));
		$actual = getAllowedPicklistModules(1);
		sort($expected);
		sort($actual);
		$this->assertEquals($expected, $actual, "Test getAllowedPicklistModules admin with non-entities");
		$hold = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(11);
		$current_user = $user;
		$expected = array(
			1 => 'Potentials',
			3 => 'Contacts',
			4 => 'Accounts',
			5 => 'Leads',
			6 => 'Documents',
			7 => 'Emails',
			8 => 'HelpDesk',
			9 => 'Products',
			10 => 'Faq',
			11 => 'Vendors',
			12 => 'PriceBooks',
			13 => 'Quotes',
			14 => 'PurchaseOrder',
			15 => 'SalesOrder',
			16 => 'Invoice',
			19 => 'Campaigns',
			26 => 'PBXManager',
			27 => 'ServiceContracts',
			28 => 'Services',
			31 => 'cbupdater',
			32 => 'CobroPago',
			33 => 'Assets',
			35 => 'ModComments',
			36 => 'ProjectMilestone',
			37 => 'ProjectTask',
			38 => 'Project',
			43 => 'GlobalVariable',
			44 => 'InventoryDetails',
			45 => 'cbMap',
			49 => 'cbCalendar',
			50 => 'cbtranslation',
			51 => 'BusinessActions',
			52 => 'cbSurvey',
			53 => 'cbSurveyQuestion',
			54 => 'cbSurveyDone',
			55 => 'cbSurveyAnswer',
			56 => 'cbCompany',
			57 => 'cbCVManagement',
			58 => 'cbQuestion',
			59 => 'ProductComponent',
			60 => 'Messages',
			61 => 'cbPulse',
			64 => 'MsgTemplate',
			65 => 'cbCredentials',
			66 => 'DocumentFolders',
			67 => 'pricebookproductrel',
			68 => 'AutoNumberPrefix',
		);
		$actual = getAllowedPicklistModules();
		$this->assertEquals($expected, $actual, "Test getAllowedPicklistModules nocreate with non-entities");
		$expected = $expected + array(
			0 => 'Dashboard',
			2 => 'Home',
			18 => 'Reports',
			20 => 'Portal',
			21 => 'ConfigEditor',
			22 => 'Import',
			23 => 'MailManager',
			24 => 'Mobile',
			25 => 'ModTracker',
			30 => 'WSAPP',
			41 => 'Webforms',
			42 => 'Calendar4You',
			47 => 'cbAuditTrail',
			48 => 'cbLoginHistory',
			29 => 'VtigerBackup',
			34 => 'CronTasks',
			40 => 'Tooltip',
			46 => 'evvtMenu',
			62 => 'EtiquetasOO',
			63 => 'evvtgendoc',
		);
		$actual = getAllowedPicklistModules(1);
		$this->assertEquals($expected, $actual, 'Test getAllowedPicklistModules nocreate with non-entities');
		$current_user = $hold;
	}

	/**
	 * Method testgetPicklistValuesSpecialUitypes16131614
	 * @test
	 */
	public function testgetPicklistValuesSpecialUitypes16131614() {
		$expected = array(
			0 => array(
				0 => 'Opportunities',
				1 => 'Potentials',
				2 => '',
			),
			2 => array(
				0 => 'Organizations',
				1 => 'Accounts',
				2 => '',
			),
			18 => array(
				0 => 'Services',
				1 => 'Services',
				2 => '',
			),
			20 => array(
				0 => 'Payments',
				1 => 'CobroPago',
				2 => '',
			),
			21 => array(
				0 => 'Assets',
				1 => 'Assets',
				2 => '',
			),
			22 => array(
				0 => 'Comments',
				1 => 'ModComments',
				2 => '',
			),
			23 => array(
				0 => 'Project Milestones',
				1 => 'ProjectMilestone',
				2 => '',
			),
			24 => array(
				0 => 'Project Tasks',
				1 => 'ProjectTask',
				2 => '',
			),
			25 => array(
				0 => 'Projects',
				1 => 'Project',
				2 => '',
			),
			30 => array(
				0 => 'To Dos',
				1 => 'cbCalendar',
				2 => '',
			),
			41 => array(
				0 => 'Messages',
				1 => 'Messages',
				2 => '',
			),
			42 => array(
				0 => 'Pulses',
				1 => 'cbPulse',
				2 => '',
			),
			29 => array(
				0 => 'Terms and Conditions',
				1 => 'cbTermConditions',
				2 => '',
			),
			34 => array(
				0 => 'Survey Questions',
				1 => 'cbSurveyQuestion',
				2 => '',
			),
			40 => array(
				0 => 'Product Components',
				1 => 'ProductComponent',
				2 => '',
			),
			32 => array(
				0 => 'Business Actions',
				1 => 'BusinessActions',
				2 => '',
			),
			28 => array(
				0 => 'Business Maps',
				1 => 'cbMap',
				2 => '',
			),
			39 => array(
				0 => 'Business Question',
				1 => 'cbQuestion',
				2 => '',
			),
			15 => array(
				0 => 'Campaigns',
				1 => 'Campaigns',
				2 => '',
			),
			37 => array(
				0 => 'Companies',
				1 => 'cbCompany',
				2 => '',
			),
			1 => array(
				0 => 'Contacts',
				1 => 'Contacts',
				2 => '',
			),
			19 => array(
				0 => 'coreBOS Updater',
				1 => 'cbupdater',
				2 => '',
			),
			44 => array(
				0 => 'Credentials',
				1 => 'cbCredentials',
				2 => '',
			),
			4 => array(
				0 => 'Documents',
				1 => 'Documents',
				2 => '',
			),
			5 => array(
				0 => 'Email',
				1 => 'Emails',
				2 => '',
			),
			8 => array(
				0 => 'FAQ',
				1 => 'Faq',
				2 => '',
			),
			26 => array(
				0 => 'Global Variables',
				1 => 'GlobalVariable',
				2 => '',
			),
			27 => array(
				0 => 'Inventory Details',
				1 => 'InventoryDetails',
				2 => '',
			),
			14 => array(
				0 => 'Invoice',
				1 => 'Invoice',
				2 => '',
			),
			3 => array(
				0 => 'Leads',
				1 => 'Leads',
				2 => '',
			),
			43 => array(
				0 => 'Message Templates',
				1 => 'MsgTemplate',
				2 => '',
			),
			16 => array(
				0 => 'PBX Manager',
				1 => 'PBXManager',
				2 => '',
			),
			10 => array(
				0 => 'Price Books',
				1 => 'PriceBooks',
				2 => '',
			),
			7 => array(
				0 => 'Products',
				1 => 'Products',
				2 => '',
			),
			12 => array(
				0 => 'Purchase Order',
				1 => 'PurchaseOrder',
				2 => '',
			),
			11 => array(
				0 => 'Quotes',
				1 => 'Quotes',
				2 => '',
			),
			13 => array(
				0 => 'Sales Order',
				1 => 'SalesOrder',
				2 => '',
			),
			17 => array(
				0 => 'Service Contracts',
				1 => 'ServiceContracts',
				2 => '',
			),
			6 => array(
				0 => 'Support Tickets',
				1 => 'HelpDesk',
				2 => '',
			),
			33 => array(
				0 => 'Surveys',
				1 => 'cbSurvey',
				2 => '',
			),
			36 => array(
				0 => 'Surveys Answer',
				1 => 'cbSurveyAnswer',
				2 => '',
			),
			35 => array(
				0 => 'Surveys Done',
				1 => 'cbSurveyDone',
				2 => '',
			),
			31 => array(
				0 => 'Translations',
				1 => 'cbtranslation',
				2 => '',
			),
			9 => array(
				0 => 'Vendors',
				1 => 'Vendors',
				2 => '',
			),
			38 => array(
				0 => 'View Permissions',
				1 => 'cbCVManagement',
				2 => '',
			),
			45 => array(
				0 => 'Document Folders',
				1 => 'DocumentFolders',
				2 => '',
			),
			46 => array (
				0 => 'Price Lists',
				1 => 'pricebookproductrel',
				2 => '',
			),
			47 => array (
				0 => 'Auto Number Prefix',
				1 => 'AutoNumberPrefix',
				2 => '',
			),
		);
		$actual = getPicklistValuesSpecialUitypes('1613', '*', '', '*');
		$this->assertEquals($expected, $actual, "Test getPicklistValuesSpecialUitypes 1613");
		$expected[15][2] = 'selected';
		$actual = getPicklistValuesSpecialUitypes('1613', '*', 'Campaigns', '*');
		$this->assertEquals($expected, $actual, "Test getPicklistValuesSpecialUitypes 1613");
		$_REQUEST['file'] = 'QuickCreate';
		$actual = getPicklistValuesSpecialUitypes('1613', '*', 'Campaigns', '*');
		$this->assertEquals($expected, $actual, "Test getPicklistValuesSpecialUitypes 1613");
		$expected = array(
			0 => array(
				0 => 'Dashboards',
				1 => 'Dashboard',
				2 => '',
			),
			1 => array(
				0 => 'Opportunities',
				1 => 'Potentials',
				2 => '',
			),
			2 => array(
				0 => 'Home',
				1 => 'Home',
				2 => '',
			),
			3 => array(
				0 => 'Contacts',
				1 => 'Contacts',
				2 => '',
			),
			4 => array(
				0 => 'Organizations',
				1 => 'Accounts',
				2 => '',
			),
			5 => array(
				0 => 'Leads',
				1 => 'Leads',
				2 => '',
			),
			6 => array(
				0 => 'Documents',
				1 => 'Documents',
				2 => '',
			),
			7 => array(
				0 => 'Email',
				1 => 'Emails',
				2 => '',
			),
			8 => array(
				0 => 'Support Tickets',
				1 => 'HelpDesk',
				2 => '',
			),
			9 => array(
				0 => 'Products',
				1 => 'Products',
				2 => '',
			),
			10 => array(
				0 => 'FAQ',
				1 => 'Faq',
				2 => '',
			),
			11 => array(
				0 => 'Vendors',
				1 => 'Vendors',
				2 => '',
			),
			12 => array(
				0 => 'Price Books',
				1 => 'PriceBooks',
				2 => '',
			),
			13 => array(
				0 => 'Quotes',
				1 => 'Quotes',
				2 => '',
			),
			14 => array(
				0 => 'Purchase Order',
				1 => 'PurchaseOrder',
				2 => '',
			),
			15 => array(
				0 => 'Sales Order',
				1 => 'SalesOrder',
				2 => '',
			),
			16 => array(
				0 => 'Invoice',
				1 => 'Invoice',
				2 => '',
			),
			17 => array(
				0 => 'Reports',
				1 => 'Reports',
				2 => '',
			),
			18 => array(
				0 => 'Campaigns',
				1 => 'Campaigns',
				2 => '',
			),
			20 => array(
				0 => 'Users',
				1 => 'Users',
				2 => '',
			),
			21 => array(
				0 => 'ConfigEditor',
				1 => 'ConfigEditor',
				2 => '',
			),
			22 => array(
				0 => 'Import',
				1 => 'Import',
				2 => '',
			),
			26 => array(
				0 => 'PBX Manager',
				1 => 'PBXManager',
				2 => '',
			),
			27 => array(
				0 => 'Service Contracts',
				1 => 'ServiceContracts',
				2 => '',
			),
			28 => array(
				0 => 'Services',
				1 => 'Services',
				2 => '',
			),
			29 => array(
				0 => 'Backups',
				1 => 'VtigerBackup',
				2 => '',
			),
			31 => array(
				0 => 'coreBOS Updater',
				1 => 'cbupdater',
				2 => '',
			),
			32 => array(
				0 => 'Payments',
				1 => 'CobroPago',
				2 => '',
			),
			33 => array(
				0 => 'Assets',
				1 => 'Assets',
				2 => '',
			),
			35 => array(
				0 => 'Comments',
				1 => 'ModComments',
				2 => '',
			),
			36 => array(
				0 => 'Project Milestones',
				1 => 'ProjectMilestone',
				2 => '',
			),
			37 => array(
				0 => 'Project Tasks',
				1 => 'ProjectTask',
				2 => '',
			),
			38 => array(
				0 => 'Projects',
				1 => 'Project',
				2 => '',
			),
			49 => array(
				0 => 'To Dos',
				1 => 'cbCalendar',
				2 => '',
			),
			60 => array(
				0 => 'Messages',
				1 => 'Messages',
				2 => '',
			),
			61 => array(
				0 => 'Pulses',
				1 => 'cbPulse',
				2 => '',
			),
			48 => array(
				0 => 'Terms and Conditions',
				1 => 'cbTermConditions',
				2 => '',
			),
			53 => array(
				0 => 'Survey Questions',
				1 => 'cbSurveyQuestion',
				2 => '',
			),
			59 => array(
				0 => 'Product Components',
				1 => 'ProductComponent',
				2 => '',
			),
			51 => array(
				0 => 'Business Actions',
				1 => 'BusinessActions',
				2 => '',
			),
			44 => array(
				0 => 'Business Maps',
				1 => 'cbMap',
				2 => '',
			),
			58 => array(
				0 => 'Business Question',
				1 => 'cbQuestion',
				2 => '',
			),
			39 => array(
				0 => 'ToolTip',
				1 => 'Tooltip',
				2 => '',
			),
			56 => array(
				0 => 'Companies',
				1 => 'cbCompany',
				2 => '',
			),
			65 => array(
				0 => 'Credentials',
				1 => 'cbCredentials',
				2 => '',
			),
			42 => array(
				0 => 'Global Variables',
				1 => 'GlobalVariable',
				2 => '',
			),
			43 => array(
				0 => 'Inventory Details',
				1 => 'InventoryDetails',
				2 => '',
			),
			64 => array(
				0 => 'Message Templates',
				1 => 'MsgTemplate',
				2 => '',
			),
			52 => array(
				0 => 'Surveys',
				1 => 'cbSurvey',
				2 => '',
			),
			55 => array(
				0 => 'Surveys Answer',
				1 => 'cbSurveyAnswer',
				2 => '',
			),
			54 => array(
				0 => 'Surveys Done',
				1 => 'cbSurveyDone',
				2 => '',
			),
			50 => array(
				0 => 'Translations',
				1 => 'cbtranslation',
				2 => '',
			),
			57 => array(
				0 => 'View Permissions',
				1 => 'cbCVManagement',
				2 => '',
			),
			41 => array(
				0 => 'Calendar',
				1 => 'Calendar4You',
				2 => '',
			),
			34 => array(
				0 => 'Cron Tasks',
				1 => 'CronTasks',
				2 => '',
			),
			63 => array(
				0 => 'Generate Documents',
				1 => 'evvtgendoc',
				2 => '',
			),
			23 => array(
				0 => 'Mail Manager',
				1 => 'MailManager',
				2 => '',
			),
			45 => array(
				0 => 'Menu Editor',
				1 => 'evvtMenu',
				2 => '',
			),
			62 => array(
				0 => 'Merge Labels',
				1 => 'EtiquetasOO',
				2 => '',
			),
			24 => array(
				0 => 'Mobile',
				1 => 'Mobile',
				2 => '',
			),
			25 => array(
				0 => 'ModTracker',
				1 => 'ModTracker',
				2 => '',
			),
			19 => array(
				0 => 'Our Sites',
				1 => 'Portal',
				2 => '',
			),
			46 => array(
				0 => 'User Audit Trail',
				1 => 'cbAuditTrail',
				2 => '',
			),
			47 => array(
				0 => 'User Login History',
				1 => 'cbLoginHistory',
				2 => '',
			),
			40 => array(
				0 => 'Webforms',
				1 => 'Webforms',
				2 => '',
			),
			30 => array(
				0 => 'WSAPP',
				1 => 'WSAPP',
				2 => '',
			),
			66 => array(
				0 => 'Document Folders',
				1 => 'DocumentFolders',
				2 => '',
			),
			67 => array(
				0 => 'Price Lists',
				1 => 'pricebookproductrel',
				2 => '',
			),
			68 => array (
				0 => 'Auto Number Prefix',
				1 => 'AutoNumberPrefix',
				2 => '',
			),
		);
		$actual = getPicklistValuesSpecialUitypes('1614', '*', '', '*');
		$this->assertEquals($expected, $actual, "Test getPicklistValuesSpecialUitypes 1613");
	}

	/**
	 * Method testgetPicklistValuesSpecialUitypes1615
	 * @test
	 */
	public function testgetPicklistValuesSpecialUitypes1615() {
		$expected = array(
			0 => array(
				0 => 'Organizations',
				1 => 'Accounts',
				2 => '',
				3 => array(
					'accounttype' => 'Type',
					'industry' => 'Industry',
					'rating' => 'Rating',
					'cf_729' => 'PLMain',
					'cf_730' => 'PLDep1',
					'cf_731' => 'PLDep2',
					'cf_732' => 'Planets',
					'campaignrelstatus' => 'Status',
				),
			),
			1 => array(
				0 => 'Leads',
				1 => 'Leads',
				2 => '',
				3 => array(
					'industry' => 'Industry',
					'leadsource' => 'Lead Source',
					'leadstatus' => 'Lead Status',
					'rating' => 'Rating',
					'salutationtype' => 'Salutation ',
					'campaignrelstatus' => 'Status',
				),
			),
			2 => array(
				0 => 'Contacts',
				1 => 'Contacts',
				2 => '',
				3 => array(
					'leadsource' => 'Lead Source',
					'salutationtype' => 'Salutation ',
					'template_language' => 'Template Language',
					'campaignrelstatus' => 'Status',
					'portalpasswordtype' => 'portalpasswordtype',
				),
			),
			3 => array(
				0 => 'Opportunities',
				1 => 'Potentials',
				2 => '',
				3 => array(
					'leadsource' => 'Lead Source',
					'opportunity_type' => 'Type',
					'sales_stage' => 'Sales Stage',
				),
			),
			4 => array(
				0 => 'Campaigns',
				1 => 'Campaigns',
				2 => '',
				3 => array(
					'campaignstatus' => 'Campaign Status',
					'campaigntype' => 'Campaign Type',
					'expectedresponse' => 'Expected Response',
					'campaignrelstatus' => 'Status',
				),
			),
			5 => array(
				0 => 'Support Tickets',
				1 => 'HelpDesk',
				2 => '',
				3 => array(
					'ticketcategories' => 'Category',
					'ticketpriorities' => 'Priority',
					'ticketseverities' => 'Severity',
					'ticketstatus' => 'Status',
				),
			),
			6 => array(
				0 => 'Products',
				1 => 'Products',
				2 => '',
				3 => array(
					'glacct' => 'GL Account',
					'manufacturer' => 'Manufacturer',
					'productcategory' => 'Product Category',
					'usageunit' => 'Usage Unit',
				),
			),
			7 => array(
				0 => 'FAQ',
				1 => 'Faq',
				2 => '',
				3 => array(
					'faqcategories' => 'Category',
					'faqstatus' => 'Status',
				),
			),
			8 => array(
				0 => 'Vendors',
				1 => 'Vendors',
				2 => '',
				3 => array(
					'glacct' => 'GL Account'
				),
			),
			9 => array(
				0 => 'Quotes',
				1 => 'Quotes',
				2 => '',
				3 => array(
					'carrier' => 'Carrier',
					'quotestage' => 'Quote Stage',
					'hdnTaxType' => 'Tax Type',
				),
			),
			10 => array(
				0 => 'Purchase Order',
				1 => 'PurchaseOrder',
				2 => '',
				3 => array(
					'carrier' => 'Carrier',
					'postatus' => 'Status',
					'hdnTaxType' => 'Tax Type',
				),
			),
			11 => array(
				0 => 'Sales Order',
				1 => 'SalesOrder',
				2 => '',
				3 => array(
					'carrier' => 'Carrier',
					'invoicestatus' => 'Invoice Status',
					'sostatus' => 'Status',
					'hdnTaxType' => 'Tax Type',
					'recurring_frequency' => 'Frequency',
					'payment_duration' => 'Payment Duration',
				),
			),
			12 => array(
				0 => 'Invoice',
				1 => 'Invoice',
				2 => '',
				3 => array(
					'invoicestatus' => 'Status',
					'hdnTaxType' => 'Tax Type',
				),
			),
			13 => array(
				0 => 'Email',
				1 => 'Emails',
				2 => '',
				3 => array(
					'email_flag' => 'Email Flag',
				),
			),
			14 => array(
				0 => 'PBX Manager',
				1 => 'PBXManager',
				2 => '',
				3 => array(
					'status' => 'Status',
				),
			),
			15 => array(
				0 => 'Service Contracts',
				1 => 'ServiceContracts',
				2 => '',
				3 => array(
					'tracking_unit' => 'Tracking Unit',
					'contract_status' => 'Status',
					'contract_priority' => 'Priority',
					'contract_type' => 'Type',
				),
			),
			16 => array(
				0 => 'Services',
				1 => 'Services',
				2 => '',
				3 => array(
					'service_usageunit' => 'Usage Unit',
					'servicecategory' => 'Service Category',
				),
			),
			17 => array(
				0 => 'coreBOS Updater',
				1 => 'cbupdater',
				2 => '',
				3 => array(
					'execstate' => 'execstate'
				),
			),
			18 => array(
				0 => 'Payments',
				1 => 'CobroPago',
				2 => '',
				3 => array(
					'paymentmode' => 'PaymentMode',
					'paymentcategory' => 'Category',
				),
			),
			19 => array(
				0 => 'Assets',
				1 => 'Assets',
				2 => '',
				3 => array(
					'assetstatus' => 'Status'
				),
			),
			20 => array(
				0 => 'Project Milestones',
				1 => 'ProjectMilestone',
				2 => '',
				3 => array(
					'projectmilestonetype' => 'Type'
				),
			),
			21 => array(
				0 => 'Project Tasks',
				1 => 'ProjectTask',
				2 => '',
				3 => array(
					'projecttasktype' => 'Type',
					'projecttaskpriority' => 'Priority',
					'projecttaskprogress' => 'Progress',
					'projecttaskstatus' => 'Status',
				),
			),
			22 => array(
				0 => 'Projects',
				1 => 'Project',
				2 => '',
				3 => array(
					'projectstatus' => 'Status',
					'projecttype' => 'Type',
					'projectpriority' => 'Priority',
					'progress' => 'Progress',
				),
			),
			23 => array(
				0 => 'Global Variables',
				1 => 'GlobalVariable',
				2 => '',
				3 => array(
					'gvname' => 'Name',
					'category' => 'Category',
					'viewtype' => 'View Type',
				),
			),
			24 => array(
				0 => 'Business Maps',
				1 => 'cbMap',
				2 => '',
				3 => array(
					'maptype' => 'Map Type'
				),
			),
			25 => array(
				0 => 'Terms and Conditions',
				1 => 'cbTermConditions',
				2 => '',
				3 => array(
					'formodule' => 'formodule'
				),
			),
			26 => array(
				0 => 'To Dos',
				1 => 'cbCalendar',
				2 => '',
				3 => array(
					'activitytype' => 'Activity Type',
					'eventstatus' => 'Status',
					'taskpriority' => 'Priority',
					'followuptype' => 'Tipo Seguimiento',
					'visibility' => 'Visibility',
					'duration_minutes' => 'Duration Minutes',
					'recurringtype' => 'Recurrence',
				),
			),
			27 => array(
				0 => 'Business Actions',
				1 => 'BusinessActions',
				2 => '',
				3 => array(
					'linktype' => 'linktype'
				),
			),
			28 => array(
				0 => 'Business Question',
				1 => 'cbQuestion',
				2 => '',
				3 => array(
					'qtype' => 'qtype',
					'qstatus' => 'qstatus',
					'querytype' => 'querytype',
				),
			),
			29 => array(
				0 => 'Product Components',
				1 => 'ProductComponent',
				2 => '',
				3 => array(
					'relmode' => 'Relation Mode'
				),
			),
			30 => array(
				0 => 'Messages',
				1 => 'Messages',
				2 => '',
				3 => array(
					'messagetype' => 'Message Type',
					'status_message' => 'Status',
				),
			),
			31 => array(
				0 => 'Pulses',
				1 => 'cbPulse',
				2 => '',
				3 => array(
					'sendmethod' => 'sendmethod',
					'schtypeid' => 'schtypeid',
				),
			),
			32 => array(
				0 => 'Message Templates',
				1 => 'MsgTemplate',
				2 => '',
				3 => array(
					'msgt_type' => 'msgt_type',
					'msgt_status' => 'msgt_status',
					'msgt_language' => 'msgt_language',
					'msgt_category' => 'message category',
					'msgt_fields' => 'msgt_fields',
					'msgt_metavars' => 'msgt_metavars',
				),
			),
			33 => array(
				0 => 'Credentials',
				1 => 'cbCredentials',
				2 => '',
				3 => array(
					'adapter' => 'Adapter',
					'emauth' => 'LBL_REQUIRES_AUTHENT',
				),
			),
			34 => array(
				0 => 'Survey Questions',
				1 => 'cbSurveyQuestion',
				2 => '',
				3 => array(
					'question_type' => 'Type of Question',
				),
			),
		);
		$actual = getPicklistValuesSpecialUitypes('1615', '*', '', '*');
		$this->assertEquals($expected, $actual, "Test getPicklistValuesSpecialUitypes 1615");
	}

	/**
	 * Method testgetPicklistValuesSpecialUitypes1616
	 * @test
	 */
	public function testgetPicklistValuesSpecialUitypes1616() {
		$expected = array(
			array(
			  0 => 'ActiveColumnProducts',
			  1 => '61',
			  2 => 'ActiveColumn (Products)',
			  3 => '',
			),
			array(
			  0 => 'ActiveColumnServices',
			  1 => '62',
			  2 => 'ActiveColumn (Services)',
			  3 => '',
			),
			array(
			  0 => 'AllAssets',
			  1 => '53',
			  2 => 'All (Assets)',
			  3 => '',
			),
			array(
			  0 => 'AllBusiness Actions',
			  1 => '70',
			  2 => 'All (Business Actions)',
			  3 => '',
			),
			array(
			  0 => 'AllBusiness Maps',
			  1 => '63',
			  2 => 'All (Business Maps)',
			  3 => '',
			),
			array(
			  0 => 'AllBusiness Question',
			  1 => '79',
			  2 => 'All (Business Question)',
			  3 => '',
			),
			array(
			  0 => 'AllCampaigns',
			  1 => '29',
			  2 => 'All (Campaigns)',
			  3 => '',
			),
			array(
			  0 => 'AllComments',
			  1 => '54',
			  2 => 'All (Comments)',
			  3 => '',
			),
			array(
				0 => 'AllPrice Lists',
				1 => '95',
				2 => 'All (Price Lists)',
				3 => '',
			),
			array(
			  0 => 'AllCompanies',
			  1 => '75',
			  2 => 'All (Companies)',
			  3 => '',
			),
			array(
			  0 => 'AllAuto Number Prefix',
			  1 => '96',
			  2 => 'All (Auto Number Prefix)',
			  3 => '',
			),
			array(
			  0 => 'AllContacts',
			  1 => '7',
			  2 => 'All (Contacts)',
			  3 => '',
			),
			array(
			  0 => 'AllcoreBOS Updater',
			  1 => '44',
			  2 => 'All (coreBOS Updater)',
			  3 => '',
			),
			array(
			  0 => 'AllCredentials',
			  1 => '93',
			  2 => 'All (Credentials)',
			  3 => '',
			),
			array(
			  0 => 'AllDocument Folders',
			  1 => '94',
			  2 => 'All (Document Folders)',
			  3 => '',
			),
			array(
			  0 => 'AllDocuments',
			  1 => '22',
			  2 => 'All (Documents)',
			  3 => '',
			),
			array(
			  0 => 'AllEmail',
			  1 => '20',
			  2 => 'All (Email)',
			  3 => '',
			),
			array(
			  0 => 'AllFAQ',
			  1 => '28',
			  2 => 'All (FAQ)',
			  3 => '',
			),
			array(
			  0 => 'AllGlobal Variables',
			  1 => '59',
			  2 => 'All (Global Variables)',
			  3 => '',
			),
			array(
			  0 => 'AllInventory Details',
			  1 => '60',
			  2 => 'All (Inventory Details)',
			  3 => '',
			),
			array(
			  0 => 'AllInvoice',
			  1 => '21',
			  2 => 'All (Invoice)',
			  3 => '',
			),
			array(
			  0 => 'AllLeads',
			  1 => '1',
			  2 => 'All (Leads)',
			  3 => '',
			),
			array(
			  0 => 'AllMessage Templates',
			  1 => '91',
			  2 => 'All (Message Templates)',
			  3 => '',
			),
			array(
			  0 => 'AllMessages',
			  1 => '83',
			  2 => 'All (Messages)',
			  3 => '',
			),
			array(
			  0 => 'AllOpportunities',
			  1 => '10',
			  2 => 'All (Opportunities)',
			  3 => '',
			),
			array(
			  0 => 'AllOrganizations',
			  1 => '4',
			  2 => 'All (Organizations)',
			  3 => '',
			),
			array(
			  0 => 'AllPayments',
			  1 => '51',
			  2 => 'All (Payments)',
			  3 => '',
			),
			array(
			  0 => 'AllPBX Manager',
			  1 => '38',
			  2 => 'All (PBX Manager)',
			  3 => '',
			),
			array(
			  0 => 'AllPrice Books',
			  1 => '23',
			  2 => 'All (Price Books)',
			  3 => '',
			),
			array(
			  0 => 'AllProduct Components',
			  1 => '80',
			  2 => 'All (Product Components)',
			  3 => '',
			),
			array(
			  0 => 'AllProducts',
			  1 => '24',
			  2 => 'All (Products)',
			  3 => '',
			),
			array(
			  0 => 'AllProject Milestones',
			  1 => '55',
			  2 => 'All (Project Milestones)',
			  3 => '',
			),
			array(
			  0 => 'AllProject Tasks',
			  1 => '56',
			  2 => 'All (Project Tasks)',
			  3 => '',
			),
			array(
			  0 => 'AllProjects',
			  1 => '57',
			  2 => 'All (Projects)',
			  3 => '',
			),
			array(
			  0 => 'AllPulses',
			  1 => '90',
			  2 => 'All (Pulses)',
			  3 => '',
			),
			array(
			  0 => 'AllPurchase Order',
			  1 => '25',
			  2 => 'All (Purchase Order)',
			  3 => '',
			),
			array(
			  0 => 'AllQuotes',
			  1 => '16',
			  2 => 'All (Quotes)',
			  3 => '',
			),
			array(
			  0 => 'AllSales Order',
			  1 => '26',
			  2 => 'All (Sales Order)',
			  3 => '',
			),
			array(
			  0 => 'AllService Contracts',
			  1 => '42',
			  2 => 'All (Service Contracts)',
			  3 => '',
			),
			array(
			  0 => 'AllServices',
			  1 => '43',
			  2 => 'All (Services)',
			  3 => '',
			),
			array(
			  0 => 'AllSMSNotifier',
			  1 => '58',
			  2 => 'All (SMSNotifier)',
			  3 => '',
			),
			array(
			  0 => 'AllSupport Tickets',
			  1 => '13',
			  2 => 'All (Support Tickets)',
			  3 => '',
			),
			array(
			  0 => 'AllSurvey Questions',
			  1 => '72',
			  2 => 'All (Survey Questions)',
			  3 => '',
			),
			array(
			  0 => 'AllSurveys',
			  1 => '71',
			  2 => 'All (Surveys)',
			  3 => '',
			),
			array(
			  0 => 'AllSurveys Answer',
			  1 => '74',
			  2 => 'All (Surveys Answer)',
			  3 => '',
			),
			array(
			  0 => 'AllSurveys Done',
			  1 => '73',
			  2 => 'All (Surveys Done)',
			  3 => '',
			),
			array(
			  0 => 'AllTerms and Conditions',
			  1 => '65',
			  2 => 'All (Terms and Conditions)',
			  3 => '',
			),
			array(
			  0 => 'AllTo Dos',
			  1 => '66',
			  2 => 'All (To Dos)',
			  3 => '',
			),
			array(
			  0 => 'AllTranslations',
			  1 => '67',
			  2 => 'All (Translations)',
			  3 => '',
			),
			array(
			  0 => 'AllVendors',
			  1 => '27',
			  2 => 'All (Vendors)',
			  3 => '',
			),
			array(
			  0 => 'AllView Permissions',
			  1 => '76',
			  2 => 'All (View Permissions)',
			  3 => '',
			),
			array(
			  0 => 'AppliedcoreBOS Updater',
			  1 => '45',
			  2 => 'Applied (coreBOS Updater)',
			  3 => '',
			),
			array(
			  0 => 'BlockedcoreBOS Updater',
			  1 => '49',
			  2 => 'Blocked (coreBOS Updater)',
			  3 => '',
			),
			array(
			  0 => 'BounceMessages',
			  1 => '85',
			  2 => 'Bounce (Messages)',
			  3 => '',
			),
			array(
			  0 => 'ClickedMessages',
			  1 => '84',
			  2 => 'Clicked (Messages)',
			  3 => '',
			),
			array(
			  0 => 'Contacts AddressContacts',
			  1 => '8',
			  2 => 'Contacts Address (Contacts)',
			  3 => '',
			),
			array(
			  0 => 'ContinuouscoreBOS Updater',
			  1 => '48',
			  2 => 'Continuous (coreBOS Updater)',
			  3 => '',
			),
			array(
			  0 => 'current_userOrganizations',
			  1 => '82',
			  2 => 'current_user (Organizations)',
			  3 => '',
			),
			array(
			  0 => 'current_userPayments',
			  1 => '81',
			  2 => 'current_user (Payments)',
			  3 => '',
			),
			array(
			  0 => 'Default ViewsView Permissions',
			  1 => '77',
			  2 => 'Default Views (View Permissions)',
			  3 => '',
			),
			array(
			  0 => 'DeliveredMessages',
			  1 => '88',
			  2 => 'Delivered (Messages)',
			  3 => '',
			),
			array(
			  0 => 'DialedPBX Manager',
			  1 => '40',
			  2 => 'Dialed (PBX Manager)',
			  3 => '',
			),
			array(
			  0 => 'Drafted FAQFAQ',
			  1 => '31',
			  2 => 'Drafted FAQ (FAQ)',
			  3 => '',
			),
			array(
			  0 => 'DroppedMessages',
			  1 => '89',
			  2 => 'Dropped (Messages)',
			  3 => '',
			),
			array(
			  0 => 'ErrorcoreBOS Updater',
			  1 => '47',
			  2 => 'Error (coreBOS Updater)',
			  3 => '',
			),
			array(
			  0 => 'FilenameQuotes',
			  1 => '64',
			  2 => 'Filename (Quotes)',
			  3 => '',
			),
			array(
			  0 => 'Group ConditionOrganizations',
			  1 => '92',
			  2 => 'Group Condition (Organizations)',
			  3 => '',
			),
			array(
			  0 => 'High Prioriy TicketsSupport Tickets',
			  1 => '15',
			  2 => 'High Prioriy Tickets (Support Tickets)',
			  3 => '',
			),
			array(
			  0 => 'Hot LeadsLeads',
			  1 => '2',
			  2 => 'Hot Leads (Leads)',
			  3 => '',
			),
			array(
			  0 => 'MissedPBX Manager',
			  1 => '39',
			  2 => 'Missed (PBX Manager)',
			  3 => '',
			),
			array(
			  0 => 'New This WeekOrganizations',
			  1 => '6',
			  2 => 'New This Week (Organizations)',
			  3 => '',
			),
			array(
			  0 => 'Open InvoicesInvoice',
			  1 => '35',
			  2 => 'Open Invoices (Invoice)',
			  3 => '',
			),
			array(
			  0 => 'Open Purchase OrdersPurchase Order',
			  1 => '33',
			  2 => 'Open Purchase Orders (Purchase Order)',
			  3 => '',
			),
			array(
			  0 => 'Open QuotesQuotes',
			  1 => '17',
			  2 => 'Open Quotes (Quotes)',
			  3 => '',
			),
			array(
			  0 => 'Open TicketsSupport Tickets',
			  1 => '14',
			  2 => 'Open Tickets (Support Tickets)',
			  3 => '',
			),
			array(
			  0 => 'OpenMessages',
			  1 => '86',
			  2 => 'Open (Messages)',
			  3 => '',
			),
			array(
			  0 => 'Paid InvoicesInvoice',
			  1 => '36',
			  2 => 'Paid Invoices (Invoice)',
			  3 => '',
			),
			array(
			  0 => 'payviewPayments',
			  1 => '52',
			  2 => 'payview (Payments)',
			  3 => '',
			),
			array(
			  0 => 'Pending Sales OrdersSales Order',
			  1 => '37',
			  2 => 'Pending Sales Orders (Sales Order)',
			  3 => '',
			),
			array(
			  0 => 'PendingcoreBOS Updater',
			  1 => '46',
			  2 => 'Pending (coreBOS Updater)',
			  3 => '',
			),
			array(
			  0 => 'PermissionsView Permissions',
			  1 => '78',
			  2 => 'Permissions (View Permissions)',
			  3 => '',
			),
			array(
			  0 => 'PerspectivecoreBOS Updater',
			  1 => '50',
			  2 => 'Perspective (coreBOS Updater)',
			  3 => '',
			),
			array(
			  0 => 'PicklistTranslations',
			  1 => '69',
			  2 => 'Picklist (Translations)',
			  3 => '',
			),
			array(
			  0 => 'Potentials WonOpportunities',
			  1 => '11',
			  2 => 'Potentials Won (Opportunities)',
			  3 => '',
			),
			array(
			  0 => 'Prospect AccountsOrganizations',
			  1 => '5',
			  2 => 'Prospect Accounts (Organizations)',
			  3 => '',
			),
			array(
			  0 => 'ProspectingOpportunities',
			  1 => '12',
			  2 => 'Prospecting (Opportunities)',
			  3 => '',
			),
			array(
			  0 => 'Published FAQFAQ',
			  1 => '32',
			  2 => 'Published FAQ (FAQ)',
			  3 => '',
			),
			array(
			  0 => 'Received Purchase OrdersPurchase Order',
			  1 => '34',
			  2 => 'Received Purchase Orders (Purchase Order)',
			  3 => '',
			),
			array(
			  0 => 'ReceivedPBX Manager',
			  1 => '41',
			  2 => 'Received (PBX Manager)',
			  3 => '',
			),
			array(
			  0 => 'Rejected QuotesQuotes',
			  1 => '18',
			  2 => 'Rejected Quotes (Quotes)',
			  3 => '',
			),
			array(
			  0 => 'This Month LeadsLeads',
			  1 => '3',
			  2 => 'This Month Leads (Leads)',
			  3 => '',
			),
			array(
			  0 => 'Todays BirthdayContacts',
			  1 => '9',
			  2 => 'Todays Birthday (Contacts)',
			  3 => '',
			),
			array(
			  0 => 'UnsubscribeMessages',
			  1 => '87',
			  2 => 'Unsubscribe (Messages)',
			  3 => '',
			),
			array(
			  0 => 'UsersTranslations',
			  1 => '68',
			  2 => 'Users (Translations)',
			  3 => '',
			),
		);
		usort($expected, function ($a, $b) {
			return $a[1] > $b[1] ? 1 : ($a[1] < $b[1] ? -1 : 0);
		});
		$actual = getPicklistValuesSpecialUitypes('1616', '*', '', '*');
		usort($actual, function ($a, $b) {
			return $a[1] > $b[1] ? 1 : ($a[1] < $b[1] ? -1 : 0);
		});
		$this->assertEquals($expected, $actual, 'Test getPicklistValuesSpecialUitypes 1616');
		$actual = getPicklistValuesSpecialUitypes('1616', '*', '87', '*');
		usort($actual, function ($a, $b) {
			return $a[1] > $b[1] ? 1 : ($a[1] < $b[1] ? -1 : 0);
		});
		$idx = array_search('87', array_column($expected, 1));
		$expected[$idx][3]='selected';
		$this->assertEquals($expected, $actual, 'Test getPicklistValuesSpecialUitypes 1616');
	}

	/**
	 * Method testgetPicklistValuesSpecialUitypes33133314
	 * @test
	 */
	public function testgetPicklistValuesSpecialUitypes33133314() {
		$expected = array(
			21 => array (
			  0 => 'Assets',
			  1 => 'Assets',
			  2 => '',
			),
			32 => array (
			  0 => 'Business Actions',
			  1 => 'BusinessActions',
			  2 => '',
			),
			28 => array (
			  0 => 'Business Maps',
			  1 => 'cbMap',
			  2 => '',
			),
			39 => array (
			  0 => 'Business Question',
			  1 => 'cbQuestion',
			  2 => '',
			),
			15 => array (
			  0 => 'Campaigns',
			  1 => 'Campaigns',
			  2 => '',
			),
			22 => array (
			  0 => 'Comments',
			  1 => 'ModComments',
			  2 => '',
			),
			37 => array (
			  0 => 'Companies',
			  1 => 'cbCompany',
			  2 => '',
			),
			1 => array (
			  0 => 'Contacts',
			  1 => 'Contacts',
			  2 => '',
			),
			19 => array (
			  0 => 'coreBOS Updater',
			  1 => 'cbupdater',
			  2 => '',
			),
			44 => array (
			  0 => 'Credentials',
			  1 => 'cbCredentials',
			  2 => '',
			),
			45 => array (
			  0 => 'Document Folders',
			  1 => 'DocumentFolders',
			  2 => '',
			),
			4 => array (
			  0 => 'Documents',
			  1 => 'Documents',
			  2 => '',
			),
			5 => array (
			  0 => 'Email',
			  1 => 'Emails',
			  2 => '',
			),
			8 => array (
			  0 => 'FAQ',
			  1 => 'Faq',
			  2 => '',
			),
			26 => array (
			  0 => 'Global Variables',
			  1 => 'GlobalVariable',
			  2 => '',
			),
			27 => array (
			  0 => 'Inventory Details',
			  1 => 'InventoryDetails',
			  2 => '',
			),
			14 => array (
			  0 => 'Invoice',
			  1 => 'Invoice',
			  2 => '',
			),
			3 => array(
			  0 => 'Leads',
			  1 => 'Leads',
			  2 => '',
			),
			43 => array (
			  0 => 'Message Templates',
			  1 => 'MsgTemplate',
			  2 => '',
			),
			41 => array (
			  0 => 'Messages',
			  1 => 'Messages',
			  2 => '',
			),
			0 => array (
			  0 => 'Opportunities',
			  1 => 'Potentials',
			  2 => '',
			),
			2 => array (
			  0 => 'Organizations',
			  1 => 'Accounts',
			  2 => '',
			),
			20 => array (
			  0 => 'Payments',
			  1 => 'CobroPago',
			  2 => '',
			),
			16 => array (
			  0 => 'PBX Manager',
			  1 => 'PBXManager',
			  2 => '',
			),
			10 => array (
			  0 => 'Price Books',
			  1 => 'PriceBooks',
			  2 => '',
			),
			40 => array (
			  0 => 'Product Components',
			  1 => 'ProductComponent',
			  2 => '',
			),
			7 => array (
			  0 => 'Products',
			  1 => 'Products',
			  2 => '',
			),
			23 => array (
			  0 => 'Project Milestones',
			  1 => 'ProjectMilestone',
			  2 => '',
			),
			24 => array (
			  0 => 'Project Tasks',
			  1 => 'ProjectTask',
			  2 => '',
			),
			25 => array (
			  0 => 'Projects',
			  1 => 'Project',
			  2 => '',
			),
			42 => array (
			  0 => 'Pulses',
			  1 => 'cbPulse',
			  2 => '',
			),
			12 => array (
			  0 => 'Purchase Order',
			  1 => 'PurchaseOrder',
			  2 => '',
			),
			11 => array (
			  0 => 'Quotes',
			  1 => 'Quotes',
			  2 => '',
			),
			13 => array (
			  0 => 'Sales Order',
			  1 => 'SalesOrder',
			  2 => '',
			),
			17 => array (
			  0 => 'Service Contracts',
			  1 => 'ServiceContracts',
			  2 => '',
			),
			18 => array (
			  0 => 'Services',
			  1 => 'Services',
			  2 => '',
			),
			6 => array (
			  0 => 'Support Tickets',
			  1 => 'HelpDesk',
			  2 => '',
			),
			34 => array (
			  0 => 'Survey Questions',
			  1 => 'cbSurveyQuestion',
			  2 => '',
			),
			33 => array (
			  0 => 'Surveys',
			  1 => 'cbSurvey',
			  2 => '',
			),
			36 => array (
			  0 => 'Surveys Answer',
			  1 => 'cbSurveyAnswer',
			  2 => '',
			),
			35 => array (
			  0 => 'Surveys Done',
			  1 => 'cbSurveyDone',
			  2 => '',
			),
			29 => array (
			  0 => 'Terms and Conditions',
			  1 => 'cbTermConditions',
			  2 => '',
			),
			30 => array (
			  0 => 'To Dos',
			  1 => 'cbCalendar',
			  2 => '',
			),
			31 => array (
			  0 => 'Translations',
			  1 => 'cbtranslation',
			  2 => '',
			),
			9 => array (
			  0 => 'Vendors',
			  1 => 'Vendors',
			  2 => '',
			),
			38 => array (
			  0 => 'View Permissions',
			  1 => 'cbCVManagement',
			  2 => '',
			),
			46 => array (
				0 => 'Price Lists',
				1 => 'pricebookproductrel',
				2 => '',
			),
			47 => array (
				0 => 'Auto Number Prefix',
				1 => 'AutoNumberPrefix',
				2 => '',
			),
		);
		$actual = getPicklistValuesSpecialUitypes('3313', '*', '', '*');
		$this->assertEquals($expected, $actual, "Test getPicklistValuesSpecialUitypes 3313");
		$_REQUEST['file'] = 'QuickCreate';
		$actual = getPicklistValuesSpecialUitypes('3313', '*', '', '*');
		$this->assertEquals($expected, $actual, "Test getPicklistValuesSpecialUitypes 3313");
		$expected[15][2] = 'selected';
		$actual = getPicklistValuesSpecialUitypes('3313', '*', 'Campaigns', '*');
		$this->assertEquals($expected, $actual, "Test getPicklistValuesSpecialUitypes 3313");
		$expected[2][2] = 'selected';
		$actual = getPicklistValuesSpecialUitypes('3313', '*', 'Campaigns |##| Accounts', '*');
		$this->assertEquals($expected, $actual, "Test getPicklistValuesSpecialUitypes 3313");
	}

	/**
	 * Method testgetPicklistValuesSpecialUitypes1024
	 * @test
	 */
	public function testgetPicklistValuesSpecialUitypes1024() {
		$expected = array(
			4 => array(
				0 => 'CEO',
				1 => 'H2',
				2 => '',
			),
			3 => array(
				0 => 'NoCreate',
				1 => 'H6',
				2 => '',
			),
			2 => array(
				0 => 'Sales Man',
				1 => 'H5',
				2 => '',
			),
			1 => array(
				0 => 'Sales Manager',
				1 => 'H4',
				2 => '',
			),
			0 => array(
				0 => 'Vice President',
				1 => 'H3',
				2 => '',
			),
		);
		$actual = getPicklistValuesSpecialUitypes('1024', '*', '', '*');
		$this->assertEquals($expected, $actual, 'Test getPicklistValuesSpecialUitypes 1024');
		$_REQUEST['file'] = 'QuickCreate';
		$actual = getPicklistValuesSpecialUitypes('1024', '*', '', '*');
		$this->assertEquals($expected, $actual, 'Test getPicklistValuesSpecialUitypes 1024');
		$expected[1][2] = 'selected';
		$actual = getPicklistValuesSpecialUitypes('1024', '*', 'H4', '*');
		$this->assertEquals($expected, $actual, 'Test getPicklistValuesSpecialUitypes 1024');
		$actual = getPicklistValuesSpecialUitypes('1024', '*', 'H2', 'DetailView');
		$this->assertEquals(
			['<a href="index.php?module=Settings&action=RoleDetailView&roleid=H2">CEO</a>'],
			$actual,
			'Test getPicklistValuesSpecialUitypes 1024'
		);
		$actual = getPicklistValuesSpecialUitypes('1024', '*', 'H2 |##| H4', 'DetailView');
		$this->assertEquals(
			[
				'<a href="index.php?module=Settings&action=RoleDetailView&roleid=H2">CEO</a>',
				'<a href="index.php?module=Settings&action=RoleDetailView&roleid=H4">Sales Manager</a>',
			],
			$actual,
			'Test getPicklistValuesSpecialUitypes 1024'
		);
		global $current_user;
		$hold = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(11);
		$current_user = $user;
		$actual = getPicklistValuesSpecialUitypes('1024', '*', 'H2 |##| H4', 'DetailView');
		$this->assertEquals(
			[
				'CEO',
				'Sales Manager',
			],
			$actual,
			'Test getPicklistValuesSpecialUitypes 1024'
		);
		$current_user = $hold;
	}

	/**
	 * Method testgetPicklistValuesSpecialUitypes1025
	 * @test
	 */
	public function testgetPicklistValuesSpecialUitypes1025() {
		$this->assertTrue(true, 'This field is not correctly implemented yet. Fix it and add tests here');
	}
}
?>
