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

class WSUtilsTest extends TestCase {

	/****
	 * TEST Users decimal configuration
	 * name format is: {decimal_separator}{symbol_position}{grouping}{grouping_symbol}{currency}
	 ****/
	private $usrdota0x = 5; // testdmy 2 decimal places
	private $usrcomd0x = 6; // testmdy 3 decimal places
	private $usrdotd3com = 7; // testymd 4 decimal places
	private $usrcoma3dot = 10; // testtz 5 decimal places
	private $usrdota3comdollar = 12; // testmcurrency 6 decimal places
	private $usrinactive = 9; // inactive user
	private $usrnocreate = 11; // restricted user

	/**
	 * Method vtws_getUsersInTheSameGroupProvider
	 * params
	 */
	public function vtws_getUsersInTheSameGroupProvider() {
		$grpsadmin = array(
			5 => 'cbTest testdmy',
			6 => 'cbTest testmdy',
			7 => 'cbTest testymd',
			8 => 'cbTest testes',
			9 => 'cbTest testinactive',
			10 => 'cbTest testtz',
			12 => 'cbTest testmcurrency',
			13 => 'cbTest testtz-3',
			11 => 'nocreate cbTest',
		);
		$grpsusrcoma3dot = array(
			5 => 'cbTest testdmy',
			6 => 'cbTest testmdy',
			7 => 'cbTest testymd',
			8 => 'cbTest testes',
			9 => 'cbTest testinactive',
			12 => 'cbTest testmcurrency',
			13 => 'cbTest testtz-3',
			11 => 'nocreate cbTest',
			1 => ' Administrator',
		);
		$grpsusrinactive = array(
			5 => 'cbTest testdmy',
			6 => 'cbTest testmdy',
			7 => 'cbTest testymd',
			8 => 'cbTest testes',
			10 => 'cbTest testtz',
			12 => 'cbTest testmcurrency',
			13 => 'cbTest testtz-3',
			11 => 'nocreate cbTest',
			1 => ' Administrator',
		);
		$grpsusrnocreate = array(
			5 => 'cbTest testdmy',
			6 => 'cbTest testmdy',
			7 => 'cbTest testymd',
			8 => 'cbTest testes',
			9 => 'cbTest testinactive',
			12 => 'cbTest testmcurrency',
			13 => 'cbTest testtz-3',
			10 => 'cbTest testtz',
			1 => ' Administrator',
		);
		$grps = array();
		return array(
			array('1', $grpsadmin),
			array($this->usrcoma3dot, $grpsusrcoma3dot),
			array($this->usrinactive, $grpsusrinactive),
			array($this->usrnocreate, $grpsusrnocreate),
			array('0', $grps),
			array('', $grps),
		);
	}

	/**
	 * Method testvtws_getUsersInTheSameGroup
	 * @test
	 * @dataProvider vtws_getUsersInTheSameGroupProvider
	 */
	public function testvtws_getUsersInTheSameGroup($entityId, $expected) {
		$this->assertEquals($expected, vtws_getUsersInTheSameGroup($entityId), "getUsersInTheSameGroup $entityId");
	}

	/**
	 * Method vtws_getParameterProvider
	 * params
	 */
	public function vtws_getParameterProvider() {
		return array(
			array(array(
					'string' => 'string'
				), 'string', null, 'string', 'string'),
			array(array(
					'string' => 'st"r<in>g'
				), 'string', null, 'st\"r<in>g', 'string with chars1'),
			array(array(
					'string' => "st'r\in>g"
				), 'string', null, "st\'r\\\in>g", 'string with chars2'),
			array(array(
					'string' => 'st"r\in>g'
				), 'string', null, 'st\"r\\\in>g', 'string with chars3'),
			array(array(
					'string' => 'string'
				), 'string', 'notused', 'string', 'string default not used'),
			array(array(
					'string' => 'st"r<in>g'
				), 'string', 'notused', 'st\"r<in>g', 'string with chars1 default not used'),
			array(array(
					'string' => "st'r\in>g"
				), 'string', 'notused', "st\'r\\\in>g", 'string with chars2 default not used'),
			array(array(
					'string' => 'st"r\in>g'
				), 'string', 'notused', 'st\"r\\\in>g', 'string with chars3 default not used'),
			array(array(
					'string' => ''
				), 'string', 'used', 'used', 'string empty default used'),
			array(array(
					'string' => 'st"r<in>g'
				), 'notpresent', 'used', 'used', 'param not presentdefault used'),
			array(array(
					'string' => ''
				), 'string', null, null, 'string empty default NULL'),
			array(array(
					'string' => 'st"r<in>g'
				), 'notpresent', null, null, 'param not presentdefault NULL'),
			///////////////////////////////////
			array(
				array(
					'array' => array(
						'string1' => 'string',
						'string2' => 'st"r<in>g',
						'string3' => "st'r\in>g",
						'string4' => 'st"r\in>g',
					)
				), 'array', null,
				array(
					'string1' => 'string',
					'string2' => 'st\"r<in>g',
					'string3' => "st\'r\\\in>g",
					'string4' => 'st\"r\\\in>g',
				), 'array with strings'),
		);
	}

	/**
	 * Method testvtws_getParameter
	 * @test
	 * @dataProvider vtws_getParameterProvider
	 */
	public function testvtws_getParameter($parameterArray, $paramName, $default, $expected, $message) {
		$actual = vtws_getParameter($parameterArray, $paramName, $default);
		$this->assertEquals($expected, $actual, "testvtws_getParameter $message");
	}

	/**
	 * Method testvtws_getWsIdForFilteredRecord
	 * @test
	 */
	public function testvtws_getWsIdForFilteredRecord() {
		global $current_user;
		$actual = vtws_getWsIdForFilteredRecord('Accounts', array(), $current_user);
		$expected = '11x74';
		$this->assertEquals($expected, $actual);
		//////////////////////////
		$conds = array(
			array(
				array(
					'field' => 'subject',
					'op' => 'e',
					'value' => 'Lou Monkton',
					'glue' => '',
				),
			),
		);
		$actual = vtws_getWsIdForFilteredRecord('Quotes', $conds, $current_user);
		$expected = '4x11945';
		$this->assertEquals($expected, $actual);
		//////////////////////////
		$conds = array(
			array(
				array(
					'field' => 'subject',
					'op' => 'e',
					'value' => 'anyval',
					'glue' => 'or',
				),
				array(
					'field' => 'pl_gross_total',
					'op' => 'g',
					'value' => '20',
					'glue' => '',
				),
			),
		);
		$actual = vtws_getWsIdForFilteredRecord('Quotes', $conds, $current_user);
		$expected = '4x11815';
		$this->assertEquals($expected, $actual);
		//////////////////////////
		$conds = array(
			array(
				array(
					'field' => 'subject',
					'op' => 'e',
					'value' => 'anyval',
					'glue' => 'or',
				),
			),
		);
		$actual = vtws_getWsIdForFilteredRecord('Quotes', $conds, $current_user);
		$expected = null;
		$this->assertEquals($expected, $actual);
	}

	/**
	 * Method vtws_getEntityIdProvider
	 * params
	 */
	public function vtws_getEntityIdProvider() {
		return array(
			array('Users', '19'),
			array('Accounts', '11'),
			array('Assets', '29'),
			array('cbCalendar', '39'),
			array('NonExistent', '0'),
			array('', '0'),
		);
	}

	/**
	 * Method testvtws_getEntityId
	 * @test
	 * @dataProvider vtws_getEntityIdProvider
	 */
	public function testvtws_getEntityId($entityName, $expected) {
		$actual = vtws_getEntityId($entityName, $expected);
		$this->assertEquals($expected, $actual, "vtws_getEntityId $entityName");
	}

	/**
	 * Method testgetWSIDInvalidID
	 * @test
	 */
	public function testgetWSIDInvalidID() {
		$this->assertEquals('0x0', vtws_getWSID('testgetWSIDInvalidID'), 'getWSID invalid ID');
	}

	/**
	 * Method testrunQueryAsTransaction
	 * @test
	 */
	public function testrunQueryAsTransaction() {
		$actual = vtws_runQueryAsTransaction(
			'select accountname from vtiger_account where accountid=?',
			['74'],
			$result
		);
		$this->assertTrue($actual);
		$this->assertEquals('Chemex Labs Ltd', $result->fields['accountname']);
		$actual = vtws_runQueryAsTransaction(
			'select accountname fromvtiger_accountwhere accountid=?',
			['74'],
			$result
		);
		$this->assertFalse($actual);
		$this->assertFalse($result);
	}

	/**
	 * Method testgetOwnerType
	 * @test
	 */
	public function testgetOwnerType() {
		$this->assertEquals('Groups', vtws_getOwnerType(3));
		$this->assertEquals('Users', vtws_getOwnerType(11));
	}

	/**
	 * Method testgetOwnerTypeException
	 * @test
	 */
	public function testgetOwnerTypeException() {
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALIDID);
		vtws_getOwnerType(74);
	}

	/**
	 * Method testgetCalendarEntityType
	 * @test
	 */
	public function testgetCalendarEntityType() {
		$this->assertEquals('cbCalendar', vtws_getCalendarEntityType('testgetWSIDInvalidID'), 'testgetCalendarEntityType');
	}

	/**
	 * Method vtws_getEntityNameProvider
	 * params
	 */
	public function vtws_getEntityNameProvider() {
		return array(
			array('19', 'Users'),
			array('11', 'Accounts'),
			array('29', 'Assets'),
			array('39', 'cbCalendar'),
			array('0', ''),
			array('', ''),
		);
	}

	/**
	 * Method testvtws_getEntityName
	 * @test
	 * @dataProvider vtws_getEntityNameProvider
	 */
	public function testvtws_getEntityName($entityId, $expected) {
		$actual = vtws_getEntityName($entityId);
		$this->assertEquals($expected, $actual, "vtws_getEntityName $entityId");
	}

	/**
	 * Method testvtws_getModuleHandlerFromName
	 * @test
	 */
	public function testvtws_getModuleHandlerFromName() {
		// tested in VtigerWebserviceObjectTest > here just check it returns the object
		global $adb, $current_user, $log;
		$webserviceObject = VtigerWebserviceObject::fromName($adb, 'Accounts');
		require_once 'include/Webservices/VtigerModuleOperation.php';
		$expected = new VtigerModuleOperation($webserviceObject, $current_user, $adb, $log);
		$handler = vtws_getModuleHandlerFromName('Accounts', $current_user, false);
		$this->assertEquals($expected, $handler, 'vtws_getModuleHandlerFromName Accounts');
	}

	/**
	 * Method testgetActorModules
	 * @test
	 */
	public function testgetActorModules() {
		$expected = array(
			0 => 'Groups',
			1 => 'Currency',
			2 => 'Workflow',
			3 => 'AuditTrail',
			4 => 'LoginHistory',
			5 => 'ModTracker',
		);
		$this->assertEquals($expected, vtws_getActorModules(), 'vtws_getActorModules');
	}

	/**
	 * Method testisRoleBasedPicklist
	 * @test
	 */
	public function testisRoleBasedPicklist() {
		$this->assertFalse(vtws_isRoleBasedPicklist('payment_duration'), 'isRoleBasedPicklist');
		$this->assertFalse(vtws_isRoleBasedPicklist('currency_symbol_placement'), 'isRoleBasedPicklist');
		$this->assertFalse(vtws_isRoleBasedPicklist('email2'), 'isRoleBasedPicklist');
		$this->assertTrue(vtws_isRoleBasedPicklist('opportunity_type'), 'isRoleBasedPicklist');
		$this->assertTrue(vtws_isRoleBasedPicklist('paymentmode'), 'isRoleBasedPicklist');
	}

	/**
	 * Method testgetWebserviceTranslatedStringForLanguage
	 * @test
	 */
	public function testgetWebserviceTranslatedStringForLanguage() {
		$this->assertNull(vtws_getWebserviceTranslatedStringForLanguage('DoesNotExist', 'fr_fr'));
	}

	/**
	 * Method testgetWebserviceCurrentLanguage
	 * @test
	 */
	public function testgetWebserviceCurrentLanguage() {
		global $default_language, $current_language;
		$originalCurLang = $current_language;
		$current_language = '';
		$this->assertEquals($default_language, vtws_getWebserviceCurrentLanguage());
		$current_language = $originalCurLang;
	}

	/**
	 * Method testgetWebserviceDefaultLanguage
	 * @test
	 */
	public function testgetWebserviceDefaultLanguage() {
		global $default_language;
		$this->assertEquals($default_language, vtws_getWebserviceDefaultLanguage());
	}

	/**
	 * Method testgetWebserviceEntities
	 * @test
	 */
	public function testgetWebserviceEntities() {
		$expected = array(
			'module'=>array(
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
				'SMSNotifier',
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
			),
			'entity'=>array(
				0 => 'Groups',
				1 => 'Currency',
				2 => 'CompanyDetails',
				3 => 'Workflow',
				4 => 'AuditTrail',
				5 => 'LoginHistory',
				6 => 'Zendesk',
				7 => 'ModTracker',
				8 => 'contactinfo',
			),
		);
		$this->assertEquals($expected, vtws_getWebserviceEntities());
	}

	/**
	 * Method testgetQueableCommands
	 * @test
	 */
	public function testgetQueableCommands() {
		$expected = array(
			'create',
			'update',
			'describe',
			'convertlead',
			'revise',
			'getrelatedmodulesinfomation',
			'executeworkflow',
			'massdelete',
			'upsert',
			'executeworkflowwithcontext',
			'gendoc_convert',
			'massupdate',
			'masscreate',
		);
		$this->assertEquals($expected, vtws_getQueableCommands());
	}
}
?>