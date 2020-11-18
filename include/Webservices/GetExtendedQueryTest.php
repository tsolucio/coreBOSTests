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
include_once 'include/Webservices/GetExtendedQuery.php';

use PHPUnit\Framework\TestCase;

class GetExtendedQueryTest extends TestCase {

	/****
	 * TEST Users decimal configuration
	 * name format is: {decimal_separator}{symbol_position}{grouping}{grouping_symbol}{currency}
	 ****/
	private $usrdota0x = 5; // testdmy 2 decimal places
	private $usrcomd0x = 6; // testmdy 3 decimal places
	private $usrdotd3com = 7; // testymd 4 decimal places
	private $usrcoma3dot = 10; // testtz 5 decimal places
	private $usrdota3comdollar = 12; // testmcurrency 6 decimal places

	/**
	 * Method test__FQNExtendedQueryGetQuery
function __FQNExtendedQueryGetQuery($q, $user) {
	 * @test
	 */
	public function test__FQNExtendedQueryGetQuery() {
		$user = Users::getActiveAdminUser();
		/////////////////////////
		$q = 'select accountname from Accounts';
		$actual = __FQNExtendedQueryGetQuery($q, $user);
		$expected = 'select vtiger_account.accountname, vtiger_account.accountid  FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid   WHERE vtiger_crmentity.deleted=0 AND vtiger_account.accountid > 0 ';
		$this->assertEquals($expected, $actual[0], 'query');
		$this->assertIsArray($actual[1]);
		$this->assertEquals(0, count($actual[1]));
		/////////////////////////
		$q = 'select accountname,Users.first_name from Accounts';
		$actual = __FQNExtendedQueryGetQuery($q, $user);
		$expected = 'select vtiger_account.accountname, vtiger_users.first_name, vtiger_account.accountid  FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid  LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid    WHERE vtiger_crmentity.deleted=0 AND vtiger_account.accountid > 0 ';
		$this->assertEquals($expected, $actual[0], 'query with user');
		$this->assertIsArray($actual[1]);
		$this->assertArrayHasKey('Users', $actual[1]);
		/////////////////////////
		$q = 'select amount,UsersSec.first_name from CobroPago';
		$actual = __FQNExtendedQueryGetQuery($q, $user);
		$expected = 'select vtiger_cobropago.amount, vtiger_usersreports_to_id.first_name as userssecfirst_name, vtiger_cobropago.cobropagoid  FROM vtiger_cobropago  INNER JOIN vtiger_crmentity ON vtiger_cobropago.cobropagoid = vtiger_crmentity.crmid LEFT JOIN vtiger_users AS vtiger_usersreports_to_id ON vtiger_usersreports_to_id.id=vtiger_cobropago.comercialid   WHERE vtiger_crmentity.deleted=0 AND vtiger_cobropago.cobropagoid > 0 ';
		$this->assertEquals($expected, $actual[0], 'query with second user');
		$this->assertIsArray($actual[1]);
		$this->assertArrayHasKey('Users', $actual[1]);
		/////////////////////////
		$q = 'select amount,Users.first_name, UsersSec.first_name from CobroPago';
		$actual = __FQNExtendedQueryGetQuery($q, $user);
		$expected = 'select vtiger_cobropago.amount, vtiger_users.first_name, vtiger_usersreports_to_id.first_name as userssecfirst_name, vtiger_cobropago.cobropagoid  FROM vtiger_cobropago  INNER JOIN vtiger_crmentity ON vtiger_cobropago.cobropagoid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid  LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid  LEFT JOIN vtiger_users AS vtiger_usersreports_to_id ON vtiger_usersreports_to_id.id=vtiger_cobropago.comercialid   WHERE vtiger_crmentity.deleted=0 AND vtiger_cobropago.cobropagoid > 0 ';
		$this->assertEquals($expected, $actual[0], 'query with both users user');
		$this->assertIsArray($actual[1]);
		$this->assertArrayHasKey('Users', $actual[1]);
	}

	/**
	 * Method FQNProcessConditionProvider
	 * params
	 */
	public function FQNProcessConditionProvider() {
		return array(
			array('productname=22','productname = 22'),
			array('Products.productname=22','Products.productname = 22'),
			array('productname            =          22','productname            = 22'),
			array('Products.productname     =    22','Products.productname     = 22'),
			array("firstname like '%o%'","firstname like '%o%'"),
			array(" website in ('www.edfggrouplimited.com','www.gooduivtiger.com')"," website in ('www.edfggrouplimited.com','www.gooduivtiger.com')"),
			array(" website in('www.edfggrouplimited.com','www.gooduivtiger.com')"," website in('www.edfggrouplimited.com','www.gooduivtiger.com')"),
			array(" website in('www.edfggrouplimited.com', 'www.gooduivtiger.com')"," website in('www.edfggrouplimited.com', 'www.gooduivtiger.com')"),
			array(" Accounts.website in ('www.edfggrouplimited.com','www.gooduivtiger.com')"," Accounts.website in ('www.edfggrouplimited.com','www.gooduivtiger.com')"),
			array("accountname != 'PK UNA'","accountname != 'PK UNA'"),
			array("id not in ('12x1084','12x1085')","id not in ('12x1084','12x1085')"),
			array(" Assets.assetname LIKE '%exy%'"," Assets.assetname LIKE '%exy%'"),
			array("accountname != null","accountname != null"),
			array("assigned_user_id !='cbTest testtz'","assigned_user_id != 'cbTest testtz'"),
			array("cf_729 = 'one'","cf_729 = 'one'"),
			array("related.helpdesk='17x2636'","related.helpdesk = '17x2636'"),
			array("employees>=17","employees >= 17"),
			// Values on the left side are not supported because we cannot guarantee correct detection in all cases, for example:
			// 'Hello!' != accountname
			// '22=11+11' = productcode
		);
	}

	/**
	 * Method test__FQNExtendedQueryProcessCondition
	 * @test
	 * @dataProvider FQNProcessConditionProvider
	 */
	public function test__FQNExtendedQueryProcessCondition($condition, $expected) {
		$this->assertEquals($expected, __FQNExtendedQueryProcessCondition($condition), 'ProcessCondition PriceBooks');
	}
}
?>