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
			array('DoesNotExist', 1, $usersadmin),
			array('', 1, $usersadmin),
			array('HelpDesk', $this->usrdota0x, $usersadmin),
			array('DoesNotExist', $this->usrdota0x, $usersadmin),
			array('', $this->usrdota0x, $usersadmin),
			array('HelpDesk', $this->usrinactive, $usersadmin),
			array('DoesNotExist', $this->usrinactive, $usersadmin),
			array('', $this->usrinactive, $usersadmin),
			array('HelpDesk', $this->usrnocreate, $usersadmin),
			array('DoesNotExist', $this->usrnocreate, $usersadmin),
			array('', $this->usrnocreate, $usersadmin),
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
			array('DoesNotExist', 1, $usersadmin),
			array('', 1, $usersadmin),
			array('HelpDesk', $this->usrdota0x, $usersadmin),
			array('DoesNotExist', $this->usrdota0x, $usersadmin),
			array('', $this->usrdota0x, $usersadmin),
			array('HelpDesk', $this->usrinactive, $usersadmin),
			array('DoesNotExist', $this->usrinactive, $usersadmin),
			array('', $this->usrinactive, $usersadmin),
			array('HelpDesk', $this->usrnocreate, $usersadmin),
			array('DoesNotExist', $this->usrnocreate, $usersadmin),
			array('', $this->usrnocreate, $usersadmin),
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
	 * Method testvtyiicpng_getWSEntityId
	 * @test
	 * @dataProvider vtws_getReferenceValueProvider
	 */
	public function testvtws_getReferenceValue($ids, $expected) {
		global $current_user;
		$this->assertEquals($expected, vtws_getReferenceValue($ids, $current_user));
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
}
?>