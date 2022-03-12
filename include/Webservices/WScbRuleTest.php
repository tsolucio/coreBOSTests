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

include_once 'include/Webservices/cbRule.php';

class WScbRuleTest extends TestCase {

	/**
	 * Method testrule
	 * @test
	 */
	public function testrule() {
		global $current_user;
		$params = json_encode(array(
			'record_id' => '74',
		));
		$actual = cbws_cbRule(vtws_getEntityId('cbMap').'x34033', $params, $current_user);
		$this->assertEquals(141, $actual, 'cbRule');
		$actual = cbws_cbRule('employee + 10', $params, $current_user);
		$this->assertEquals(141, $actual, 'cbRule');
	}

	/**
	 * Method testinvalidmoduleexception
	 * @test
	 */
	public function testinvalidmoduleexception() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		cbws_cbRule('11x74', array(), $current_user);
	}

	/**
	 * Method testinvalidmapnameexceptionnotexist
	 * @test
	 */
	public function testinvalidmapnameexceptionnotexist() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		cbws_cbRule('map does not exist', array(), $current_user);
	}

	/**
	 * Method testinvalidcbuuidmapnameexception
	 * @test
	 */
	public function testinvalidcbuuidmapnameexception() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		cbws_cbRule('0123456789012345678901234567890123456789', array(), $current_user);
	}

	/**
	 * Method testReadExceptionNoPermission
	 * @test
	 */
	public function testReadExceptionNoPermission() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(5); // testdmy
		$current_user = $user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		try {
			cbws_cbRule(vtws_getEntityId('cbMap').'x34030', array(), $current_user);
		} catch (\Throwable $th) {
			$current_user = $holduser;
			throw $th;
		}
	}

	/**
	 * Method testInvalidContextException
	 * @test
	 */
	public function testInvalidContextException() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALIDID);
		try {
			cbws_cbRule(vtws_getEntityId('cbMap').'x34033', '{incorrect JSON', $current_user);
		} catch (\Throwable $th) {
			throw $th;
		}
	}
}
?>