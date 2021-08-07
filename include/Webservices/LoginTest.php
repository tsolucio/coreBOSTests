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

include_once 'include/Webservices/AuthToken.php';
include_once 'include/Webservices/Login.php';
require_once 'include/Webservices/WebServiceErrorCode.php';

class LoginTest extends TestCase {

	/**
	 * Method testwronguser
	 * @test
	 */
	public function testwronguser() {
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$AUTHREQUIRED);
		vtws_login('user_does_not_exist', 'password');
	}

	/**
	 * Method testnotoken
	 * @test
	 */
	public function testnotoken() {
		global $adb;
		$adb->query('DELETE FROM vtiger_ws_userauthtoken WHERE userid=1');
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALIDTOKEN);
		vtws_login('admin', 'no token');
	}

	/**
	 * Method testwrongtoken
	 * @test
	 */
	public function testwrongtoken() {
		vtws_getchallenge('admin');
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALIDUSERPWD);
		vtws_login('admin', 'invalid token');
	}

	/**
	 * Method testnokey
	 * @test
	 */
	public function testnokey() {
		global $adb;
		$usr = $adb->query('Select accesskey FROM vtiger_users WHERE id=5');
		$accesskey = $usr->fields['accesskey'];
		$adb->query('update vtiger_users set accesskey="" WHERE id=5');
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSKEYUNDEFINED);
		try {
			vtws_getchallenge('testdmy');
			vtws_login('testdmy', 'invalid token');
		} catch (\Throwable $th) {
			$adb->pquery('update vtiger_users set accesskey=? WHERE id=5', array($accesskey));
			throw $th;
		}
		$adb->pquery('update vtiger_users set accesskey=? WHERE id=5', array($accesskey));
	}

	/**
	 * Method testinactiveuser
	 * @test
	 */
	public function testinactiveuser() {
		$token = vtws_getchallenge('testinactive');
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$AUTHREQUIRED);
		vtws_login('testinactive', md5($token['token'].'1AfgXxwVqMKSKGBM'));
	}

	/**
	 * Method testloginaccesskey
	 * @test
	 */
	public function testloginaccesskey() {
		$token = vtws_getchallenge('admin');
		$actual = vtws_login('admin', md5($token['token'].'cdYTBpiMR9RfGgO'));
		$expected = new Users();
		$expected->retrieveCurrentUserInfoFromFile(1);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * Method testloginpassword
	 * @test
	 */
	public function testloginpassword() {
		$token = vtws_getchallenge('admin');
		$actual = vtws_login('admin', $token['token'].'admin');
		$expected = new Users();
		$expected->retrieveCurrentUserInfoFromFile(1);
		$this->assertEquals($expected, $actual);
	}
}
?>