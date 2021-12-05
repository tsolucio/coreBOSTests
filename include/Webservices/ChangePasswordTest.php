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

include_once 'include/Webservices/ChangePassword.php';
require_once 'include/Webservices/WebServiceErrorCode.php';
include_once 'include/Webservices/Login.php';

class ChangePasswordTest extends TestCase {

	/**
	 * Method testinsecurepassword
	 * @test
	 */
	public function testinsecurepassword() {
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(5); // testdmy
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$PASSWORDNOTSTRONG);
		vtws_changePassword('19x5', 'incorrect', 'newPassword', 'confirmPassword', $user);
	}

	/**
	 * Method testincorrectoldpassword
	 * @test
	 */
	public function testincorrectoldpassword() {
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(5); // testdmy
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALIDOLDPASSWORD);
		vtws_changePassword('19x5', 'incorrect', 'newPa$$wo4d', 'confirmPassword', $user);
	}

	/**
	 * Method testemptyoldpassword
	 * @test
	 */
	public function testemptyoldpassword() {
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(5); // testdmy
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALIDOLDPASSWORD);
		vtws_changePassword('19x5', '', 'newPa$$wo4d', 'confirmPassword', $user);
	}

	/**
	 * Method testnonexistentuser
	 * @test
	 */
	public function testnonexistentuser() {
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$user = Users::getActiveAdminUser();
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALIDUSER);
		vtws_changePassword(99999, 'oldPassword', 'newPassword', 'confirmPassword', $user);
	}

	/**
	 * Method testnotsamenonadminuser
	 * @test
	 */
	public function testnotsamenonadminuser() {
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(5); // testdmy
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		vtws_changePassword(11, 'oldPassword', 'newPassword', 'confirmPassword', $user);
	}

	/**
	 * Method testinactiveuser
	 * @test
	 */
	public function testinactiveuser() {
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$user = Users::getActiveAdminUser();
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALIDUSER);
		vtws_changePassword('19x9', 'oldPassword', 'newPassword', 'confirmPassword', $user);
	}

	/**
	 * Method testdifferentnewpassword
	 * @test
	 */
	public function testdifferentnewpassword() {
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$user = Users::getActiveAdminUser();
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$CHANGEPASSWORDFAILURE);
		vtws_changePassword('19x5', 'testdmy', 'newPa$$wo4d', 'confirmPassword', $user);
	}

	/**
	 * Method testchangepassword
	 * @test
	 */
	public function testchangepassword() {
		global $adb;
		$adb->query("DELETE FROM password_history WHERE crmid=5 and crmtype='U'");
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(5); // testdmy
		$accesskey = vtws_getUserAccessKey(5);
		$this->assertTrue($user->verifyPassword('testdmy'));
		$actual = vtws_changePassword('19x5', 'testdmy', 'newPa$$wo4d', 'newPa$$wo4d', $user);
		$expected = array(
			'message' => 'Changed password successfully. Save your new Access Key, you will not see it again.',
			'accesskey' => getSingleFieldValue('vtiger_users', 'accesskey', 'id', 5),
		);
		$this->assertEquals($expected, $actual);
		$this->assertTrue($user->verifyPassword('newPa$$wo4d'));
		$user->change_password('newPa$$wo4d', 'testdmy');
		$this->assertTrue($user->verifyPassword('testdmy'));
		// restore accesskey
		$adb->pquery('update vtiger_users set accesskey=? where id=5', array($accesskey));
	}
}
?>