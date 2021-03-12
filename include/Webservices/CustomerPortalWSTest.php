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

include_once 'include/Webservices/CustomerPortalWS.php';

class testCustomerPortalWS extends TestCase {

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
	 * Method testgetPortalUserDateFormat
	 * @test
	 */
	public function testgetPortalUserDateFormat() {
		$user = Users::getActiveAdminUser();
		$this->assertEquals('yyyy-mm-dd', vtws_getPortalUserDateFormat($user), 'getPortalUserDateFormat admin');
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x); // dmY
		$this->assertEquals('dd-mm-yyyy', vtws_getPortalUserDateFormat($user), 'getPortalUserDateFormat testdmy');
		$user->column_fields['date_format'] = '';
		$this->assertEquals('yyyy-mm-dd', vtws_getPortalUserDateFormat($user), 'getPortalUserDateFormat testdmy with no defined format');
	}

	/**
	 * Method testgetPortalUserInfo
	 * @test
	 */
	public function testgetPortalUserInfo() {
		$user = Users::getActiveAdminUser();
		$expected = array(
			'date_format' => 'yyyy-mm-dd',
			'first_name' => '',
			'last_name' => 'Administrator',
			'email1' => 'noreply@tsolucio.com',
			'id' => '19x1',
			'is_admin' => 'on',
			'language' => 'en_us',
			'currency_grouping_pattern' => '123,456,789',
			'currency_decimal_separator' => '.',
			'currency_grouping_separator' => ',',
			'currency_symbol_placement' => '$1.0',
			'roleid' => 'H2',
			'rolename' => 'CEO',
		);
		$this->assertEquals($expected, vtws_getPortalUserInfo($user), 'vtws_getPortalUserInfo admin');
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x); // dmY
		$expected = array(
			'date_format' => 'dd-mm-yyyy',
			'first_name' => 'cbTest',
			'last_name' => 'testdmy',
			'email1' => 'noreply@tsolucio.com',
			'id' => '19x'.$this->usrdota0x,
			'is_admin' => 'off',
			'language' => 'en_us',
			'currency_grouping_pattern' => '123456789',
			'currency_decimal_separator' => '.',
			'currency_grouping_separator' => ',',
			'currency_symbol_placement' => '$1.0',
			'roleid' => 'H3',
			'rolename' => 'Vice President',
		);
		$this->assertEquals($expected, vtws_getPortalUserInfo($user), 'vtws_getPortalUserInfo testdmy');
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(8); // testes
		$expected = array(
			'date_format' => 'dd-mm-yyyy',
			'first_name' => 'cbTest',
			'last_name' => 'testes',
			'email1' => 'noreply@tsolucio.com',
			'id' => '19x8',
			'is_admin' => 'off',
			'language' => 'es_es',
			'currency_grouping_pattern' => '123,456,789',
			'currency_decimal_separator' => ',',
			'currency_grouping_separator' => '.',
			'currency_symbol_placement' => '$1.0',
			'roleid' => 'H3',
			'rolename' => 'Vice President',
		);
		$this->assertEquals($expected, vtws_getPortalUserInfo($user), 'vtws_getPortalUserInfo testdmy');
	}

	/**
	 * Method getAssignedUserListProvider
	 * params
	 */
	public function getAssignedUserListProvider() {
		$usersadmin = '[{"userid":"19x1","username":"Administrator"},{"userid":"19x11","username":"nocreate cbTest"},{"userid":"19x5","username":"cbTest testdmy"},{"userid":"19x8","username":"cbTest testes"},{"userid":"19x12","username":"cbTest testmcurrency"},{"userid":"19x6","username":"cbTest testmdy"},{"userid":"19x10","username":"cbTest testtz"},{"userid":"19x13","username":"cbTest testtz-3"},{"userid":"19x7","username":"cbTest testymd"}]';
		return array(
			array('HelpDesk', 1, $usersadmin),
			array('DoesNotExist', 1, '[]'),
			array('', 1, '[]'),
			array('HelpDesk', $this->usrdota0x, $usersadmin),
			array('DoesNotExist', $this->usrdota0x, '[]'),
			array('', $this->usrdota0x, '[]'),
			array('HelpDesk', $this->usrinactive, $usersadmin),
			array('DoesNotExist', $this->usrinactive, '[]'),
			array('', $this->usrinactive, '[]'),
			array('HelpDesk', $this->usrnocreate, $usersadmin),
			array('cbTermConditions', $this->usrnocreate, '[]'),
			array('DoesNotExist', $this->usrnocreate, '[]'),
			array('', $this->usrnocreate, '[]'),
		);
	}

	/**
	 * Method testgetAssignedUserList
	 * @test
	 * @dataProvider getAssignedUserListProvider
	 */
	public function testgetAssignedUserList($module, $userid, $expected) {
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($userid);
		$this->assertEquals($expected, vtws_getAssignedUserList($module, $user), 'getAssignedUserList');
	}

	/**
	 * Method getAssignedGroupListProvider
	 * params
	 */
	public function getAssignedGroupListProvider() {
		$usersadmin = '[{"groupid":"20x3","groupname":"Marketing Group"},{"groupid":"20x4","groupname":"Support Group"},{"groupid":"20x2","groupname":"Team Selling"}]';
		return array(
			array('HelpDesk', 1, $usersadmin),
			array('DoesNotExist', 1, '[]'),
			array('', 1, '[]'),
			array('HelpDesk', $this->usrdota0x, $usersadmin),
			array('DoesNotExist', $this->usrdota0x, '[]'),
			array('', $this->usrdota0x, '[]'),
			array('HelpDesk', $this->usrinactive, $usersadmin),
			array('DoesNotExist', $this->usrinactive, '[]'),
			array('', $this->usrinactive, '[]'),
			array('HelpDesk', $this->usrnocreate, $usersadmin),
			array('cbTermConditions', $this->usrnocreate, '[]'),
			array('DoesNotExist', $this->usrnocreate, '[]'),
			array('', $this->usrnocreate, '[]'),
		);
	}

	/**
	 * Method testgetAssignedGroupList
	 * @test
	 * @dataProvider getAssignedGroupListProvider
	 */
	public function testgetAssignedGroupList($module, $userid, $expected) {
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($userid);
		$this->assertEquals($expected, vtws_getAssignedGroupList($module, $user), 'getAssignedGroupList');
	}

	/**
	 * Method getPicklistValuesProvider
	 * params
	 */
	public function getPicklistValuesProvider() {
		$docs = 'a:1:{s:8:"folderid";a:11:{s:4:"22x1";s:7:"Default";s:4:"22x2";s:8:"Avengers";s:4:"22x3";s:5:"X-Men";s:4:"22x4";s:13:"The Defenders";s:4:"22x5";s:12:"The Invaders";s:4:"22x6";s:14:"Fantastic Four";s:4:"22x7";s:9:"Guardians";s:4:"22x8";s:12:"Omega Flight";s:4:"22x9";s:12:"S.H.I.E.L.D.";s:5:"22x10";s:9:"Excalibur";s:5:"22x11";s:21:"Application Templates";}}';
		$asset = 'a:1:{s:11:"assetstatus";a:2:{s:10:"In Service";s:10:"In Service";s:14:"Out-of-service";s:14:"Out-of-service";}}';
		$hd = 'a:4:{s:16:"ticketcategories";a:3:{s:11:"Big Problem";s:11:"Big Problem";s:13:"Small Problem";s:13:"Small Problem";s:13:"Other Problem";s:13:"Other Problem";}s:16:"ticketpriorities";a:4:{s:3:"Low";s:3:"Low";s:6:"Normal";s:6:"Normal";s:4:"High";s:4:"High";s:6:"Urgent";s:6:"Urgent";}s:16:"ticketseverities";a:4:{s:5:"Minor";s:5:"Minor";s:5:"Major";s:5:"Major";s:7:"Feature";s:7:"Feature";s:8:"Critical";s:8:"Critical";}s:12:"ticketstatus";a:4:{s:4:"Open";s:4:"Open";s:11:"In Progress";s:11:"In Progress";s:17:"Wait For Response";s:17:"Wait For Response";s:6:"Closed";s:6:"Closed";}}';
		$empty = 'a:0:{}';
		return array(
			array('Documents', $docs),
			array('Assets', $asset),
			array('HelpDesk', $hd),
			array('DoesNotExist', $empty),
			array('', $empty),
		);
	}

	/**
	 * Method testgetPicklistValues
	 * @test
	 * @dataProvider getPicklistValuesProvider
	 */
	public function testgetPicklistValues($module, $expected) {
		global $current_user;
		$this->assertEquals($expected, vtws_getPicklistValues($module, $current_user), 'getPicklistValues');
	}

	/**
	 * Method vtyiicpng_getWSEntityIdProvider
	 * params
	 */
	public function vtyiicpng_getWSEntityIdProvider() {
		return array(
			array('Contacts', '12x', 'WS ID Contact'),
			array('Accounts', '11x', 'WS ID Account'),
			array('Assets', '29x', 'WS ID Assets'),
			array('DoesNotExist', '0x', 'WS ID DoesNotExist'),
			array('', '0x', 'WS ID empty'),
		);
	}

	/**
	 * Method testvtyiicpng_getWSEntityId
	 * @test
	 * @dataProvider vtyiicpng_getWSEntityIdProvider
	 */
	public function testvtyiicpng_getWSEntityId($module, $expected, $message) {
		$this->assertEquals($expected, vtyiicpng_getWSEntityId($module), "vtyiicpng_getWSEntityId $message");
	}

	/**
	 * Method testfindByPortalUserName
	 * @test
	 */
	public function testfindByPortalUserName() {
		$this->assertTrue(vtws_findByPortalUserName('julieta@yahoo.com'), 'findByPortalUserName julieta');
		$this->assertFalse(vtws_findByPortalUserName('notthere'), 'findByPortalUserName notthere');
		$this->assertFalse(vtws_findByPortalUserName("hackit'; select 1;"), 'findByPortalUserName hackit');
	}

	/**
	 * Method testAuthenticateContact
	 * @test
	 */
	public function testAuthenticateContact() {
		$this->assertEquals('12x1085', vtws_AuthenticateContact('julieta@yahoo.com', '5ub1ipv3'), 'AuthenticateContact OK');
		$this->assertFalse(vtws_AuthenticateContact('julieta@yahoo.com', 's'), 'AuthenticateContact incorrect password');
		$this->assertFalse(vtws_AuthenticateContact("hackit'; select 1;", '5ub1ipv3'), 'AuthenticateContact incorrect user');
		vtws_changePortalUserPassword('julieta@yahoo.com', '$newPass', '5ub1ipv3');
		$this->assertFalse(vtws_AuthenticateContact('julieta@yahoo.com', '5ub1ipv3'), 'AuthenticateContact NOK');
		$this->assertEquals('12x1085', vtws_AuthenticateContact('julieta@yahoo.com', '$newPass'), 'AuthenticateContact OK');
		vtws_changePortalUserPassword('julieta@yahoo.com', '5ub1ipv3', '$newPass');
		$this->assertEquals('12x1085', vtws_AuthenticateContact('julieta@yahoo.com', '5ub1ipv3'), 'AuthenticateContact OK');
	}

	/**
	 * Method testchangePortalUserPassword
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testchangePortalUserPassword() {
		$this->expectException(WebServiceException::class);
		vtws_changePortalUserPassword("hackit'; select 1;", '$newPass', '5ub1ipv3');
	}

	/**
	 * Method testchangePortalUserPasswordWrongOldPassword
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testchangePortalUserPasswordWrongOldPassword() {
		$this->expectException(WebServiceException::class);
		vtws_changePortalUserPassword('julieta@yahoo.com', '$newPass', 'notoldpassword');
	}

	/**
	 * Method vtws_getReferenceValueProvider
	 * params
	 */
	public function vtws_getReferenceValueProvider() {
		return array(
			array(serialize(array('12x1084','11x74')), 'a:2:{s:7:"12x1084";a:3:{s:6:"module";s:8:"Contacts";s:9:"reference";s:15:"Lina Schwiebert";s:6:"cbuuid";s:40:"a609725772dc91ad733b19e4100cf68bb30195d1";}s:5:"11x74";a:3:{s:6:"module";s:8:"Accounts";s:9:"reference";s:15:"Chemex Labs Ltd";s:6:"cbuuid";s:40:"b0857db0c1dee95300a10982853f5fb1d4e981c1";}}'),
			array(serialize(array('22x2','20x3','21x1')), 'a:3:{s:4:"22x2";a:3:{s:6:"module";s:15:"DocumentFolders";s:9:"reference";s:8:"Avengers";s:6:"cbuuid";s:0:"";}s:4:"20x3";a:3:{s:6:"module";s:6:"Groups";s:9:"reference";s:15:"Marketing Group";s:6:"cbuuid";s:0:"";}s:4:"21x1";a:3:{s:6:"module";s:8:"Currency";s:9:"reference";s:13:"Euro : &euro;";s:6:"cbuuid";s:0:"";}}'),
			array(serialize(array('22x2|20x3','21x1')), 'a:3:{s:4:"22x2";a:3:{s:6:"module";s:15:"DocumentFolders";s:9:"reference";s:8:"Avengers";s:6:"cbuuid";s:0:"";}s:4:"20x3";a:3:{s:6:"module";s:6:"Groups";s:9:"reference";s:15:"Marketing Group";s:6:"cbuuid";s:0:"";}s:4:"21x1";a:3:{s:6:"module";s:8:"Currency";s:9:"reference";s:13:"Euro : &euro;";s:6:"cbuuid";s:0:"";}}'),
			array(serialize(array('22x2','20x3|21x1')), 'a:3:{s:4:"22x2";a:3:{s:6:"module";s:15:"DocumentFolders";s:9:"reference";s:8:"Avengers";s:6:"cbuuid";s:0:"";}s:4:"20x3";a:3:{s:6:"module";s:6:"Groups";s:9:"reference";s:15:"Marketing Group";s:6:"cbuuid";s:0:"";}s:4:"21x1";a:3:{s:6:"module";s:8:"Currency";s:9:"reference";s:13:"Euro : &euro;";s:6:"cbuuid";s:0:"";}}'),
			array(serialize(array('11x1084','12x74')), 'a:2:{s:7:"11x1084";a:3:{s:6:"module";s:8:"Accounts";s:9:"reference";s:0:"";s:6:"cbuuid";s:0:"";}s:5:"12x74";a:3:{s:6:"module";s:8:"Contacts";s:9:"reference";s:0:"";s:6:"cbuuid";s:0:"";}}'),
			array(serialize(array()), 'a:0:{}'),
			array('', 'a:0:{}'),
		);
	}

	/**
	 * Method testvtws_getReferenceValue
	 * @test
	 * @dataProvider vtws_getReferenceValueProvider
	 */
	public function testvtws_getReferenceValue($ids, $expected) {
		global $current_user;
		$this->assertEquals($expected, vtws_getReferenceValue($ids, $current_user));
	}

	/**
	 * Method evvt_strip_html_linksProvider
	 * params
	 */
	public function evvt_strip_html_linksProvider() {
		return array(
			array('no url in this text', 'no url in this text'),
			array('this one <a href="has a link">right here</a>', 'this one right here'),
			array('this one <a href="has a link">right here</a> and another one <a href=\'single quoted\'>here</a>', 'this one right here and another one here'),
			array('', ''),
		);
	}

	/**
	 * Method testevvt_strip_html_links
	 * @test
	 * @dataProvider evvt_strip_html_linksProvider
	 */
	public function testevvt_strip_html_links($text, $expected) {
		$this->assertEquals($expected, evvt_strip_html_links($text));
	}

	/**
	 * Method vtws_getUItypeProvider
	 * params
	 */
	public function vtws_getUItypeProvider() {
		return array(
			array('Accounts', array(
				'accountname' => '2',
				'account_no' => '4',
				'phone' => '11',
				'website' => '17',
				'fax' => '11',
				'tickersymbol' => '1',
				'otherphone' => '11',
				'account_id' => '10',
				'email1' => '13',
				'employees' => '7',
				'email2' => '13',
				'ownership' => '1',
				'rating' => '15',
				'industry' => '15',
				'siccode' => '1',
				'accounttype' => '15',
				'annual_revenue' => '71',
				'emailoptout' => '56',
				'notify_owner' => '56',
				'assigned_user_id' => '53',
				'createdtime' => '70',
				'modifiedtime' => '70',
				'modifiedby' => '52',
				'bill_street' => '21',
				'ship_street' => '21',
				'bill_city' => '1',
				'ship_city' => '1',
				'bill_state' => '1',
				'ship_state' => '1',
				'bill_code' => '1',
				'ship_code' => '1',
				'bill_country' => '1',
				'ship_country' => '1',
				'bill_pobox' => '1',
				'ship_pobox' => '1',
				'description' => '19',
				'campaignrelstatus' => '16',
				'cf_718' => '1',
				'cf_719' => '7',
				'cf_720' => '9',
				'cf_721' => '71',
				'cf_722' => '5',
				'cf_723' => '13',
				'cf_724' => '11',
				'cf_725' => '17',
				'cf_726' => '56',
				'cf_727' => '85',
				'cf_728' => '14',
				'cf_729' => '15',
				'cf_730' => '15',
				'cf_731' => '15',
				'cf_732' => '33',
				'isconvertedfromlead' => '56',
				'convertedfromlead' => '10',
				'created_user_id' => '52',
			)),
			array('Assets', array(
				'asset_no' => '4',
				'product' => '10',
				'serialnumber' => '2',
				'datesold' => '5',
				'dateinservice' => '5',
				'assetstatus' => '15',
				'tagnumber' => '2',
				'invoiceid' => '10',
				'shippingmethod' => '2',
				'shippingtrackingnumber' => '2',
				'assigned_user_id' => '53',
				'assetname' => '1',
				'account' => '10',
				'createdtime' => '70',
				'modifiedtime' => '70',
				'modifiedby' => '52',
				'description' => '19',
				'created_user_id' => '52',
			)),
			array('', array()),
			array('DoesNotExist', array()),
		);
	}

	/**
	 * Method testvtws_getUItype
	 * @test
	 * @dataProvider vtws_getUItypeProvider
	 */
	public function testvtws_getUItype($module, $expected) {
		global $current_user;
		$this->assertEquals($expected, vtws_getUItype($module, $current_user));
	}

	/**
	 * Method testgetAllUserName
	 * @test
	 */
	public function testgetAllUserName() {
		global $current_user;
		$expected = array(
			'19x1' => ' Administrator',
			'19x5' => 'cbTest testdmy',
			'19x6' => 'cbTest testmdy',
			'19x7' => 'cbTest testymd',
			'19x8' => 'cbTest testes',
			'19x9' => 'cbTest testinactive',
			'19x10' => 'cbTest testtz',
			'19x11' => 'nocreate cbTest',
			'19x12' => 'cbTest testmcurrency',
			'19x13' => 'cbTest testtz-3',
		);
		$this->assertEquals($expected, vtws_getAllUsers($current_user), 'testgetAllUserName');
	}

	/**
	 * Method PortalModuleRestrictionsProvider
	 * params
	 */
	public function PortalModuleRestrictionsProvider() {
		$accountId = '74';
		$contactId = '1084';
		return array(
			array('Contacts', '', '1084', 0, "(vtiger_contactdetails.accountid=-1 or vtiger_contactdetails.contactid=1084)"),
			array('Accounts', '', '1084', 0, "vtiger_account.accountid=-1"),
			array('AnythingElse', '', '1084', 0, ''),
			////////////////
			array('Contacts', '74', '1084', 0, "(vtiger_contactdetails.accountid=$accountId or vtiger_contactdetails.contactid=1084)"),
			array('Accounts', '74', '1084', 0, "vtiger_account.accountid=$accountId"),
			array('Quotes', '74', '1084', 0, "vtiger_quotes.accountid=$accountId or vtiger_quotes.contactid=$contactId"),
			array('SalesOrder', '74', '1084', 0, "vtiger_salesorder.accountid=$accountId or vtiger_salesorder.contactid=$contactId"),
			array('ServiceContracts', '74', '1084', 0, "vtiger_servicecontracts.sc_related_to=$accountId or vtiger_servicecontracts.sc_related_to=$contactId"),
			array('Invoice', '74', '1084', 0, "vtiger_invoice.accountid=$accountId or vtiger_invoice.contactid=$contactId"),
			array('HelpDesk', '74', '1084', 0, "vtiger_troubletickets.parent_id=$accountId or vtiger_troubletickets.parent_id=$contactId"),
			array('Assets', '74', '1084', 0, "vtiger_assets.account=$accountId"),
			array('Project', '74', '1084', 0, "vtiger_project.linktoaccountscontacts=$accountId or vtiger_project.linktoaccountscontacts=$contactId"),
			array('Products', '74', '1084', 0, ''),
			array('Services', '74', '1084', 0, ''),
			array('Faq', '74', '1084', 0, "faqstatus='Published'"),
			array('Documents', '74', '1084', 0, array(
				'clause' => ' inner join vtiger_senotesrel on vtiger_senotesrel.notesid=vtiger_notes.notesid and vtiger_senotesrel.crmid IN (74,1084)',
				'noconditions' => ' inner join vtiger_senotesrel on vtiger_senotesrel.notesid=vtiger_notes.notesid',
			)),
			array('Potentials', '74', '1084', 0, 'vtiger_potential.related_to=74 or vtiger_potential.related_to=1084'),
			array('CobroPago', '74', '1084', 0, 'vtiger_cobropago.parent_id=74 or vtiger_cobropago.parent_id=1084'),
			array('AnythingElse', '74', '1084', 0, ''),
			////////////////
			array('Contacts', '74', '1084', 1, "(vtiger_contactdetails.accountid=$accountId or vtiger_contactdetails.contactid IN (1084,1086,1088,1090,1092,1094))"),
			array('Accounts', '74', '1084', 1, "vtiger_account.accountid=$accountId"),
			array('Quotes', '74', '1084', 1, "vtiger_quotes.accountid=$accountId or vtiger_quotes.contactid IN (1084,1086,1088,1090,1092,1094)"),
			array('SalesOrder', '74', '1084', 1, "vtiger_salesorder.accountid=$accountId or vtiger_salesorder.contactid IN (1084,1086,1088,1090,1092,1094)"),
			array('ServiceContracts', '74', '1084', 1, "vtiger_servicecontracts.sc_related_to=$accountId or vtiger_servicecontracts.sc_related_to IN (1084,1086,1088,1090,1092,1094)"),
			array('Invoice', '74', '1084', 1, "vtiger_invoice.accountid=$accountId or vtiger_invoice.contactid IN (1084,1086,1088,1090,1092,1094)"),
			array('HelpDesk', '74', '1084', 1, "vtiger_troubletickets.parent_id=$accountId or vtiger_troubletickets.parent_id IN (1084,1086,1088,1090,1092,1094)"),
			array('Assets', '74', '1084', 1, "vtiger_assets.account=$accountId"),
			array('Project', '74', '1084', 1, "vtiger_project.linktoaccountscontacts=$accountId or vtiger_project.linktoaccountscontacts IN (1084,1086,1088,1090,1092,1094)"),
			array('Products', '74', '1084', 1, ''),
			array('Services', '74', '1084', 1, ''),
			array('Faq', '74', '1084', 1, "faqstatus='Published'"),
			array('Documents', '74', '1084', 1, array(
				'clause' => ' inner join vtiger_senotesrel on vtiger_senotesrel.notesid=vtiger_notes.notesid and vtiger_senotesrel.crmid IN (74,1084,1086,1088,1090,1092,1094)',
				'noconditions' => ' inner join vtiger_senotesrel on vtiger_senotesrel.notesid=vtiger_notes.notesid',
			)),
			array('Potentials', '74', '1084', 1, "vtiger_potential.related_to=74 or vtiger_potential.related_to IN (1084,1086,1088,1090,1092,1094)"),
			array('CobroPago', '74', '1084', 1, "vtiger_cobropago.parent_id=74 or vtiger_cobropago.parent_id IN (1084,1086,1088,1090,1092,1094)"),
			array('AnythingElse', '74', '1084', 1, ''),
			////////////////
			array('Contacts', '74', '1084', 2, "(vtiger_contactdetails.accountid IN (74,746) or vtiger_contactdetails.contactid IN (1084,1086,1088,1090,1092,1094))"),
			array('Accounts', '74', '1084', 2, "vtiger_account.accountid IN (74,746)"),
			array('Quotes', '74', '1084', 2, "vtiger_quotes.accountid IN (74,746) or vtiger_quotes.contactid IN (1084,1086,1088,1090,1092,1094)"),
			array('SalesOrder', '74', '1084', 2, "vtiger_salesorder.accountid IN (74,746) or vtiger_salesorder.contactid IN (1084,1086,1088,1090,1092,1094)"),
			array('ServiceContracts', '74', '1084', 2, "vtiger_servicecontracts.sc_related_to IN (74,746) or vtiger_servicecontracts.sc_related_to IN (1084,1086,1088,1090,1092,1094)"),
			array('Invoice', '74', '1084', 2, "vtiger_invoice.accountid IN (74,746) or vtiger_invoice.contactid IN (1084,1086,1088,1090,1092,1094)"),
			array('HelpDesk', '74', '1084', 2, "vtiger_troubletickets.parent_id IN (74,746) or vtiger_troubletickets.parent_id IN (1084,1086,1088,1090,1092,1094)"),
			array('Assets', '74', '1084', 2, "vtiger_assets.account IN (74,746)"),
			array('Project', '74', '1084', 2, "vtiger_project.linktoaccountscontacts IN (74,746) or vtiger_project.linktoaccountscontacts IN (1084,1086,1088,1090,1092,1094)"),
			array('Products', '74', '1084', 2, ''),
			array('Services', '74', '1084', 2, ''),
			array('Faq', '74', '1084', 2, "faqstatus='Published'"),
			array('Documents', '74', '1084', 2, array(
				'clause' => ' inner join vtiger_senotesrel on vtiger_senotesrel.notesid=vtiger_notes.notesid and vtiger_senotesrel.crmid IN (74,746,1084,1086,1088,1090,1092,1094)',
				'noconditions' => ' inner join vtiger_senotesrel on vtiger_senotesrel.notesid=vtiger_notes.notesid',
			)),
			array('Potentials', '74', '1084', 2, "vtiger_potential.related_to IN (74,746) or vtiger_potential.related_to IN (1084,1086,1088,1090,1092,1094)"),
			array('CobroPago', '74', '1084', 2, "vtiger_cobropago.parent_id IN (74,746) or vtiger_cobropago.parent_id IN (1084,1086,1088,1090,1092,1094)"),
			array('AnythingElse', '74', '1084', 2, ''),
			////////////////
			array('Contacts', '74', '1084', 3, "(vtiger_contactdetails.accountid IN (74,746) or vtiger_contactdetails.contactid IN (1084,1086,1088,1090,1092,1094))"),
			array('Accounts', '74', '1084', 3, "vtiger_account.accountid IN (74,746)"),
			array('Quotes', '74', '1084', 3, "vtiger_quotes.accountid IN (74,746) or vtiger_quotes.contactid IN (1084,1086,1088,1090,1092,1094)"),
			array('SalesOrder', '74', '1084', 3, "vtiger_salesorder.accountid IN (74,746) or vtiger_salesorder.contactid IN (1084,1086,1088,1090,1092,1094)"),
			array('ServiceContracts', '74', '1084', 3, "vtiger_servicecontracts.sc_related_to IN (74,746) or vtiger_servicecontracts.sc_related_to IN (1084,1086,1088,1090,1092,1094)"),
			array('Invoice', '74', '1084', 3, "vtiger_invoice.accountid IN (74,746) or vtiger_invoice.contactid IN (1084,1086,1088,1090,1092,1094)"),
			array('HelpDesk', '74', '1084', 3, "vtiger_troubletickets.parent_id IN (74,746) or vtiger_troubletickets.parent_id IN (1084,1086,1088,1090,1092,1094)"),
			array('Assets', '74', '1084', 3, "vtiger_assets.account IN (74,746)"),
			array('Project', '74', '1084', 3, "vtiger_project.linktoaccountscontacts IN (74,746) or vtiger_project.linktoaccountscontacts IN (1084,1086,1088,1090,1092,1094)"),
			array('Products', '74', '1084', 3, ''),
			array('Services', '74', '1084', 3, ''),
			array('Faq', '74', '1084', 3, "faqstatus='Published'"),
			array('Documents', '74', '1084', 3, array(
				'clause' => ' inner join vtiger_senotesrel on vtiger_senotesrel.notesid=vtiger_notes.notesid and vtiger_senotesrel.crmid IN (74,746,1084,1086,1088,1090,1092,1094)',
				'noconditions' => ' inner join vtiger_senotesrel on vtiger_senotesrel.notesid=vtiger_notes.notesid',
			)),
			array('Potentials', '74', '1084', 3, "vtiger_potential.related_to IN (74,746) or vtiger_potential.related_to IN (1084,1086,1088,1090,1092,1094)"),
			array('CobroPago', '74', '1084', 3, "vtiger_cobropago.parent_id IN (74,746) or vtiger_cobropago.parent_id IN (1084,1086,1088,1090,1092,1094)"),
			array('AnythingElse', '74', '1084', 3, ''),
			////////////////
			array('Contacts', '74', '1084', 4, "(vtiger_contactdetails.accountid IN (74,746) or vtiger_contactdetails.contactid IN (1084,1086,1088,1090,1092,1094,1829))"),
			array('Accounts', '74', '1084', 4, "vtiger_account.accountid IN (74,746)"),
			array('Quotes', '74', '1084', 4, "vtiger_quotes.accountid IN (74,746) or vtiger_quotes.contactid IN (1084,1086,1088,1090,1092,1094,1829)"),
			array('SalesOrder', '74', '1084', 4, "vtiger_salesorder.accountid IN (74,746) or vtiger_salesorder.contactid IN (1084,1086,1088,1090,1092,1094,1829)"),
			array('ServiceContracts', '74', '1084', 4, "vtiger_servicecontracts.sc_related_to IN (74,746) or vtiger_servicecontracts.sc_related_to IN (1084,1086,1088,1090,1092,1094,1829)"),
			array('Invoice', '74', '1084', 4, "vtiger_invoice.accountid IN (74,746) or vtiger_invoice.contactid IN (1084,1086,1088,1090,1092,1094,1829)"),
			array('HelpDesk', '74', '1084', 4, "vtiger_troubletickets.parent_id IN (74,746) or vtiger_troubletickets.parent_id IN (1084,1086,1088,1090,1092,1094,1829)"),
			array('Assets', '74', '1084', 4, "vtiger_assets.account IN (74,746)"),
			array('Project', '74', '1084', 4, "vtiger_project.linktoaccountscontacts IN (74,746) or vtiger_project.linktoaccountscontacts IN (1084,1086,1088,1090,1092,1094,1829)"),
			array('Products', '74', '1084', 4, ''),
			array('Services', '74', '1084', 4, ''),
			array('Faq', '74', '1084', 4, "faqstatus='Published'"),
			array('Documents', '74', '1084', 4, array(
				'clause' => ' inner join vtiger_senotesrel on vtiger_senotesrel.notesid=vtiger_notes.notesid and vtiger_senotesrel.crmid IN (74,746,1084,1086,1088,1090,1092,1094,1829)',
				'noconditions' => ' inner join vtiger_senotesrel on vtiger_senotesrel.notesid=vtiger_notes.notesid',
			)),
			array('Potentials', '74', '1084', 4, "vtiger_potential.related_to IN (74,746) or vtiger_potential.related_to IN (1084,1086,1088,1090,1092,1094,1829)"),
			array('CobroPago', '74', '1084', 4, "vtiger_cobropago.parent_id IN (74,746) or vtiger_cobropago.parent_id IN (1084,1086,1088,1090,1092,1094,1829)"),
			array('AnythingElse', '74', '1084', 4, ''),
			////////////////
		);
	}

	/**
	 * Method testPortalModuleRestrictions
	 * @test
	 * @dataProvider PortalModuleRestrictionsProvider
	 */
	public function testPortalModuleRestrictions($module, $accountId, $contactId, $companyAccess, $expected) {
		$this->assertEquals($expected, evvt_PortalModuleRestrictions($module, $accountId, $contactId, $companyAccess));
	}

	/**
	 * Method getSearchResultsProvider
	 * params
	 */
	public function getSearchResultsProvider() {
		$eaccpdouser1 = array(
			array(
				'Account No' => 'ACC1',
				'Account Name' => 'Chemex Labs Ltd',
				'City' => 'Els Poblets',
				'Website' => 'http://www.chemexlabsltd.com.au',
				'Phone' => '03-3608-5660',
				'Assigned To' => 'cbTest testtz',
				'id' => '11x74',
				'search_module_name' => 'Accounts',
			),
			array(
				'Product No' => 'PRO7',
				'Product Name' => 'cheap in stock muti-color lipstick',
				'Part Number' => '',
				'Commission Rate' => '0.000',
				'Quantity In Stock' => '282.000',
				'Qty/Unit' => '0.00',
				'Unit Price' => '&euro;177.51',
				'id' => '14x2622',
				'search_module_name' => 'Products',
			),
		);
		$eaccpdouser5 = array(
			array(
				'Account No' => 'ACC1',
				'Account Name' => 'Chemex Labs Ltd',
				'City' => 'Els Poblets',
				'Website' => 'http://www.chemexlabsltd.com.au',
				'Phone' => '03-3608-5660',
				'Assigned To' => 'cbTest testtz',
				'id' => '11x74',
				'search_module_name' => 'Accounts',
			),
		);
		$edocs = array();
		return array(
			array('', '', 'put anything here', 1, array()),
			array('che', '', '', 1, array()),
			array('che', '', 'not an array', 1, array()),
			array('che', '', array('userId' => '', 'accountId' => '11x0', 'contactId' => '12x0'), 1, array()),
			array('che', '', array('userId' => '19x1', 'accountId' => '', 'contactId' => '12x0'), 1, array()),
			array('che', '', array('userId' => '19x1', 'accountId' => '11x0', 'contactId' => ''), 1, array()),
			array('che', '', array('userId' => '19x1', 'accountId' => '11x0', 'contactId' => '12x0'), 5, array()),
			///
			array('che', 'Accounts,Products', array('userId' => '19x1', 'accountId' => '11x74', 'contactId' => '12x1084'), 1, $eaccpdouser1),
			array('che', 'Accounts,Products', array('userId' => '19x5', 'accountId' => '11x74', 'contactId' => '12x1084'), 5, $eaccpdouser5),
			array('che', 'Documents', array('userId' => '19x5', 'accountId' => '11x74', 'contactId' => '12x1084'), 5, $edocs),
			array('he', 'Accounts,cbTermConditions', array('userId' => '19x11', 'accountId' => '11x74', 'contactId' => '12x1084'), 11, $eaccpdouser5),
		);
	}

	/**
	 * Method testgetSearchResults
	 * @test
	 * @dataProvider getSearchResultsProvider
	 */
	public function testgetSearchResults($query, $search_onlyin, $restrictionids, $userid, $expected) {
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($userid);
		$this->assertEquals($expected, cbwsgetSearchResults($query, $search_onlyin, $restrictionids, $user));
	}

	/**
	 * Method testgetSearchResultsLimit
	 * @test
	 */
	public function testgetSearchResultsLimit() {
		global $current_user;
		$current_user = Users::getActiveAdminUser();
		$actual = cbwsgetSearchResults('che', '', array('userId' => '19x1', 'accountId' => '11x74', 'contactId' => '12x1084'), $current_user);
		$this->assertGreaterThan(100, count($actual));
		$actual1 = cbwsgetSearchResults('che', '', array('userId' => '19x1', 'accountId' => '11x74', 'contactId' => '12x1084', 'limit' => 50), $current_user);
		$this->assertEquals(50, count($actual1));
		$actual2 = cbwsgetSearchResults('che', '', array('userId' => '19x1', 'accountId' => '11x74', 'contactId' => '12x1084', 'limit' => 50), $current_user);
		$this->assertEquals(50, count($actual2));
		$this->assertNotEquals($actual1, $actual2);
	}

	/**
	 * Method testgetSearchResultsSerialized
	 * @test
	 */
	public function testgetSearchResultsSerialized() {
		global $current_user;
		$current_user = Users::getActiveAdminUser();
		$eaccpdouser5 = array(
			array(
				'Account No' => 'ACC1',
				'Account Name' => 'Chemex Labs Ltd',
				'City' => 'Els Poblets',
				'Website' => 'http://www.chemexlabsltd.com.au',
				'Phone' => '03-3608-5660',
				'Assigned To' => 'cbTest testtz',
				'id' => '11x74',
				'search_module_name' => 'Accounts',
			),
		);
		$actual = vtws_getSearchResults('che', 'Accounts,Products', array('userId' => '19x5', 'accountId' => '11x74', 'contactId' => '12x1084'), $current_user);
		$this->assertEquals(serialize($eaccpdouser5), $actual);
		$actual = vtws_getSearchResults('che', 'Documents', array('userId' => '19x5', 'accountId' => '11x74', 'contactId' => '12x1084'), $current_user);
		$this->assertEquals(serialize(array()), $actual);
	}

	/**
	 * Method testgetSearchResultsWithTotals
	 * @test
	 */
	public function testgetSearchResultsWithTotals() {
		global $current_user;
		$current_user = Users::getActiveAdminUser();
		$eaccpdouser1 = array(
			'records' => array(
				array(
					'Account No' => 'ACC1',
					'Account Name' => 'Chemex Labs Ltd',
					'City' => 'Els Poblets',
					'Website' => 'http://www.chemexlabsltd.com.au',
					'Phone' => '03-3608-5660',
					'Assigned To' => 'cbTest testtz',
					'id' => '11x74',
					'search_module_name' => 'Accounts',
				),
				array(
					'Product No' => 'PRO7',
					'Product Name' => 'cheap in stock muti-color lipstick',
					'Part Number' => '',
					'Commission Rate' => '0.000',
					'Quantity In Stock' => '282.000',
					'Qty/Unit' => '0.00',
					'Unit Price' => '&euro;177.51',
					'id' => '14x2622',
					'search_module_name' => 'Products',
				),
			),
			'totals' => array(
				'Accounts' => 1,
				'Products' => 1,
			),
		);
		$eaccpdouser5 = array(
			'records' => array(
				array(
					'Account No' => 'ACC1',
					'Account Name' => 'Chemex Labs Ltd',
					'City' => 'Els Poblets',
					'Website' => 'http://www.chemexlabsltd.com.au',
					'Phone' => '03-3608-5660',
					'Assigned To' => 'cbTest testtz',
					'id' => '11x74',
					'search_module_name' => 'Accounts',
				),
			),
			'totals' => array(
				'Accounts' => 1,
				'Products' => 0,
			),
		);
		$edocs = array(
			'records' => array(),
			'totals' => array(
				'Documents' => 0,
			),
		);
		$actual = cbwsgetSearchResultsWithTotals('che', 'Accounts,Products', array('userId' => '19x1', 'accountId' => '11x74', 'contactId' => '12x1084'), $current_user);
		$this->assertEquals($eaccpdouser1, $actual);
		$actual = cbwsgetSearchResultsWithTotals('che', 'Accounts,Products', array('userId' => '19x5', 'accountId' => '11x74', 'contactId' => '12x1084'), $current_user);
		$this->assertEquals($eaccpdouser5, $actual);
		$actual = cbwsgetSearchResultsWithTotals('che', 'Documents', array('userId' => '19x5', 'accountId' => '11x74', 'contactId' => '12x1084'), $current_user);
		$this->assertEquals($edocs, $actual);
	}

	/**
	 * Method getFieldAutocompleteProvider
	 * params
	 */
	public function getFieldAutocompleteProvider() {
		$admin = Users::getActiveAdminUser();
		$ruser = new Users();
		$ruser->retrieveCurrentUserInfoFromFile($this->usrnocreate);
		$ea1 = array(
			array('crmid' => '11x74', 'crmfields' => array('accountname' => 'Chemex Labs Ltd')),
			array('crmid' => '11x148', 'crmfields' => array('accountname' => 'Deloitte & Touche')),
			array('crmid' => '11x235', 'crmfields' => array('accountname' => 'Cheek, John D Esq')),
			array('crmid' => '11x352', 'crmfields' => array('accountname' => 'Orourke, Denise Michelle Esq')),
			array('crmid' => '11x427', 'crmfields' => array('accountname' => 'Cheyenne Business Equipment')),
		);
		$ea2 = array(
			array('crmid' => '11x74', 'crmfields' => array('accountname' => 'Chemex Labs Ltd')),
			array('crmid' => '11x75', 'crmfields' => array('accountname' => 'Atrium Marketing Inc')),
			array('crmid' => '11x76', 'crmfields' => array('accountname' => 'American Speedy Printing Ctrs')),
			array('crmid' => '11x77', 'crmfields' => array('accountname' => 'Sherpa Corp')),
		);
		$ec1 = array(
			array('crmid' => '12x1084', 'crmfields' => array('firstname' => 'Lina', 'lastname' => 'Schwiebert')),
			array('crmid' => '12x1630', 'crmfields' => array('firstname' => 'Maile', 'lastname' => 'Linahan')),
		);
		$ec2 = array(
			array('crmid' => '12x1084', 'crmfields' => array('lastname' => 'Schwiebert')),
			array('crmid' => '12x1630', 'crmfields' => array('lastname' => 'Linahan')),
		);
		$eh1 = array(
			array('crmid' => '17x2636', 'crmfields' => array('ticket_title' => 'Problem about cannot hear your salesperson on asterix calls')),
			array('crmid' => '17x2640', 'crmfields' => array('ticket_title' => 'Problem about product quality not as expected')),
		);
		return array(
			array('', '', '', '', '', '', $admin, array()),
			array('', '', 'Accounts', '', '', '', $admin, array()),
			array('', '', 'SMSNotifier', '', '', '', $admin, array()),
			array('', '', 'AnythingElse', '', '', '', $admin, array()),
			array('', '', 'cbTermConditions', 'reference', '', '', $ruser, array()),
			array('che', 'contains', 'Accounts', 'accountname', '', 5, $admin, $ea1),
			array('', '', 'Accounts', 'accountname', '', 4, $admin, $ea2),
			array('che', 'eq', 'Accounts', 'accountname', '', 4, $admin, array()),
			array('lina', 'startswith', 'Contacts', 'firstname,lastname', '', 4, $admin, $ec1),
			array('lina', 'startswith', 'Contacts', 'firstname,lastname', 'lastname', 0, $admin, $ec2),
			array('lina Schwie', 'startswith', 'Contacts', 'firstname,lastname', '', 4, $admin, array()),
			array('Problem', 'contains', 'HelpDesk', 'ticket_title', '', 2, $admin, $eh1),
		);
	}

	/**
	 * Method testgetFieldAutocomplete
	 * @test
	 * @dataProvider getFieldAutocompleteProvider
	 */
	public function testgetFieldAutocomplete($term, $filter, $searchinmodule, $fields, $returnfields, $limit, $user, $expected) {
		$this->assertEquals($expected, getFieldAutocomplete($term, $filter, $searchinmodule, $fields, $returnfields, $limit, $user));
	}

	/**
	 * Method getFieldAutocompleteQueryProvider
	 * params
	 */
	public function getFieldAutocompleteQueryProvider() {
		$admin = Users::getActiveAdminUser();
		$ruser = new Users();
		$ruser->retrieveCurrentUserInfoFromFile($this->usrnocreate);
		$ea1 = "SELECT vtiger_account.accountname, vtiger_account.accountid FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (( vtiger_account.accountname LIKE '%che%') ) AND vtiger_account.accountid > 0 limit 0, 5";
		$ea2 = "SELECT vtiger_account.accountname, vtiger_account.accountid FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (( vtiger_account.accountname LIKE '%%%') ) AND vtiger_account.accountid > 0 limit 0, 4";
		$ea3 = "SELECT vtiger_account.accountname, vtiger_account.accountid FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (( vtiger_account.accountname = 'che') ) AND vtiger_account.accountid > 0 limit 0, 4";
		$ec1 = "SELECT vtiger_contactdetails.firstname, vtiger_contactdetails.lastname, vtiger_contactdetails.contactid FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (( vtiger_contactdetails.firstname LIKE 'lina%')  OR ( vtiger_contactdetails.lastname LIKE 'lina%') ) AND vtiger_contactdetails.contactid > 0 limit 0, 4";
		$ec2 = "SELECT vtiger_contactdetails.lastname, vtiger_contactdetails.firstname, vtiger_contactdetails.contactid FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (( vtiger_contactdetails.firstname LIKE 'lina%')  OR ( vtiger_contactdetails.lastname LIKE 'lina%') ) AND vtiger_contactdetails.contactid > 0 limit 0, 30";
		$ec3 = "SELECT vtiger_contactdetails.firstname, vtiger_contactdetails.lastname, vtiger_contactdetails.contactid FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (( vtiger_contactdetails.firstname LIKE 'lina Schwie%')  OR ( vtiger_contactdetails.lastname LIKE 'lina Schwie%') ) AND vtiger_contactdetails.contactid > 0 limit 0, 4";
		$eh1 = "SELECT vtiger_troubletickets.title, vtiger_troubletickets.ticketid FROM vtiger_troubletickets  INNER JOIN vtiger_crmentity ON vtiger_troubletickets.ticketid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (( vtiger_troubletickets.title LIKE '%Problem%') ) AND vtiger_troubletickets.ticketid > 0 limit 0, 2";
		return array(
			array('che', 'contains', 'Accounts', 'accountname', '', 5, $admin, $ea1),
			array('', '', 'Accounts', 'accountname', '', 4, $admin, $ea2),
			array('che', 'eq', 'Accounts', 'accountname', '', 4, $admin, $ea3),
			array('lina', 'startswith', 'Contacts', 'firstname,lastname', '', 4, $admin, $ec1),
			array('lina', 'startswith', 'Contacts', 'firstname,lastname', 'lastname', 0, $admin, $ec2),
			array('lina Schwie', 'startswith', 'Contacts', 'firstname,lastname', '', 4, $admin, $ec3),
			array('Problem', 'contains', 'HelpDesk', 'ticket_title', '', 2, $admin, $eh1),
		);
	}

	/**
	 * Method testgetFieldAutocompleteQuery
	 * @test
	 * @dataProvider getFieldAutocompleteQueryProvider
	 */
	public function testgetFieldAutocompleteQuery($term, $filter, $searchinmodule, $fields, $returnfields, $limit, $user, $expected) {
		$this->assertEquals($expected, getFieldAutocompleteQuery($term, $filter, $searchinmodule, $fields, $returnfields, $limit, $user));
	}
}
?>