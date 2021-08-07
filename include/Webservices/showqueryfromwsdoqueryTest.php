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

include_once 'include/Webservices/showqueryfromwsdoquery.php';

class showqueryfromwsdoqueryTest extends TestCase {

	/**
	 * Method testshowquery
	 * @test
	 */
	public function testshowquery() {
		global $current_user;
		$actual = showqueryfromwsdoquery('select cbtandcno from cbTermConditions', $current_user);
		$expected = array(
			'sql' => 'SELECT vtiger_cbtandc.cbtandcno,vtiger_cbtandc.cbtandcid FROM vtiger_cbtandc LEFT JOIN vtiger_crmentity ON vtiger_cbtandc.cbtandcid=vtiger_crmentity.crmid   WHERE  vtiger_crmentity.deleted=0 LIMIT 100',
			'status' => 'OK',
			'msg' => 'The query executed with no error',
		);
		$this->assertEquals($expected, $actual, 'query OK');
		// I couldn't find a query with an error so we can't cover that part (which is correct)
	}

	/**
	 * Method testinexistentfield
	 * @test
	 */
	public function testinexistentfield() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		showqueryfromwsdoquery('select nofield from cbTermConditions', $current_user);
	}

	/**
	 * Method testinexistentmodule
	 * @test
	 */
	public function testinexistentmodule() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		showqueryfromwsdoquery('select * from doesnotexist', $current_user);
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
		showqueryfromwsdoquery('select * from cbTermConditions', $user);
	}
}
?>