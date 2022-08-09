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

include_once 'include/Webservices/LoginPortal.php';
require_once 'include/Webservices/WebServiceErrorCode.php';

class LoginPortalTest extends TestCase {

	/**
	 * Method testwronguser
	 * @test
	 */
	public function testwronguser() {
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$AUTHREQUIRED);
		vtws_loginportal('user_does_not_exist', 'password');
	}

	/**
	 * Method testnotoken
	 * @test
	 */
	public function testnotoken() {
		global $adb;
		$adb->query('UPDATE vtiger_customerdetails SET support_end_date=CURDATE() + INTERVAL 1 DAY WHERE customerid=1085');
		$adb->query('DELETE FROM vtiger_ws_userauthtoken WHERE userid=-1085');
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALIDTOKEN);
		vtws_loginportal('julieta@yahoo.com', 'no token');
	}

	/**
	 * Method testwrongtoken
	 * @test
	 */
	public function testwrongtoken() {
		vtws_getchallenge('julieta@yahoo.com');
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALIDUSERPWD);
		vtws_loginportal('julieta@yahoo.com', 'invalid token');
	}

	/**
	 * Method testnoportaluser
	 * @test
	 */
	public function testnoportaluser() {
		global $adb;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALIDUSERPWD);
		$adb->query("UPDATE vtiger_contactdetails SET portalpasswordtype='md5',portalloginuser=0 WHERE contactid=1085");
		$token = vtws_getchallenge('julieta@yahoo.com');
		vtws_loginportal('julieta@yahoo.com', md5($token['token'].'5ub1ipv3'));
	}

	/**
	 * Method testinactiveuser
	 * @test
	 */
	public function testinactiveuser() {
		global $adb;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALIDUSER);
		$adb->query("UPDATE vtiger_contactdetails SET portalpasswordtype='md5',portalloginuser=9 WHERE contactid=1085");
		$token = vtws_getchallenge('julieta@yahoo.com');
		vtws_loginportal('julieta@yahoo.com', md5($token['token'].'5ub1ipv3'));
	}

	/**
	 * Method testnoemployeemodule
	 * @test
	 */
	public function testnoemployeemodule() {
		global $adb;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALIDUSERPWD);
		vtws_loginportal('julieta@yahoo.com', '5ub1ipv3', 'employee');
	}

	/**
	 * Method testlogin
	 * @test
	 */
	public function testlogin() {
		global $adb;
		$SessionManagerStub = 'SessionManagerStub';
		SessionManagerStub::$set_count = 0;
		SessionManagerStub::$set_consecutive = false;
		SessionManagerStub::$set_consecutive_count = 0;
		$adb->query("UPDATE vtiger_contactdetails SET portalpasswordtype='md5',portalloginuser=5,template_language='es' WHERE contactid=1085");
		$token = vtws_getchallenge('julieta@yahoo.com');
		$actual = vtws_loginportal('julieta@yahoo.com', md5($token['token'].'5ub1ipv3'), 'Contacts', $SessionManagerStub);
		$expected = array(
			'sessionName' => 'SmgrStubSessionID',
			'user' => array(
				'id' => '19x5',
				'user_name' => 'testdmy',
				'contactid' => '12x1085',
				'language' => 'es',
			)
		);
		unset($actual['user']['accesskey']);
		$this->assertEquals($expected, $actual);
		$this->assertEquals(3, SessionManagerStub::$set_consecutive_count);
		$this->assertTrue(SessionManagerStub::$set_consecutive);
		///////////////////////////
		$adb->query("UPDATE vtiger_contactdetails SET portalpasswordtype='sha256',template_language='fr' WHERE contactid=1085");
		$token = vtws_getchallenge('julieta@yahoo.com');
		$actual = vtws_loginportal('julieta@yahoo.com', hash('sha256', $token['token'].'5ub1ipv3'), 'Contacts', $SessionManagerStub);
		unset($actual['user']['accesskey']);
		$expected['user']['language'] = 'fr';
		$this->assertEquals($expected, $actual);
		///////////////////////////
		$adb->query("UPDATE vtiger_contactdetails SET portalpasswordtype='sha512',template_language='fr' WHERE contactid=1085");
		$token = vtws_getchallenge('julieta@yahoo.com');
		$actual = vtws_loginportal('julieta@yahoo.com', hash('sha512', $token['token'].'5ub1ipv3'), 'Contacts', $SessionManagerStub);
		unset($actual['user']['accesskey']);
		$this->assertEquals($expected, $actual);
		///////////////////////////
		$adb->query("UPDATE vtiger_contactdetails SET portalpasswordtype='plaintext',template_language='fr' WHERE contactid=1085");
		$token = vtws_getchallenge('julieta@yahoo.com');
		$actual = vtws_loginportal('julieta@yahoo.com', $token['token'].'5ub1ipv3', 'Contacts', $SessionManagerStub);
		unset($actual['user']['accesskey']);
		$this->assertEquals($expected, $actual);
	}
}
?>