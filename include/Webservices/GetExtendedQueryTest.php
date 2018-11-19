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
	 * Method FQNProcessConditionProvidor
	 * params
	 */
	public function FQNProcessConditionProvidor() {
		return array(
			array('productname=22','productname = 22'),
			array('Products.productname=22','Products.productname = 22'),
			array('productname            =          22','productname            = 22'),
			array('Products.productname     =    22','Products.productname     = 22'),
			array("firstname like '%o%'","firstname like '%o%'"),
			array(" website in ('www.edfggrouplimited.com','www.gooduivtiger.com')"," website in ('www.edfggrouplimited.com','www.gooduivtiger.com')"),
			array(" website in('www.edfggrouplimited.com','www.gooduivtiger.com')"," website in('www.edfggrouplimited.com','www.gooduivtiger.com')"),
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
	 * @dataProvider FQNProcessConditionProvidor
	 */
	public function test__FQNExtendedQueryProcessCondition($condition, $expected) {
		$this->assertEquals($expected, __FQNExtendedQueryProcessCondition($condition), 'ProcessCondition PriceBooks');
	}
}
?>