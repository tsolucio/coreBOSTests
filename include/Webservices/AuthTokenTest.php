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

class AuthTokenTest extends TestCase {

	/**
	 * Method testchallengewrong
	 * @test
	 */
	public function testchallengewrong() {
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('AUTHENTICATION_REQUIRED');
		vtws_getchallenge('user_does_not_exist');
	}

	/**
	 * Method testchallengeempty
	 * @test
	 */
	public function testchallengeempty() {
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('AUTHENTICATION_REQUIRED');
		vtws_getchallenge('');
	}

	/**
	 * Method testvtws_getchallenge
	 * @test
	 */
	public function testvtws_getchallenge() {
		global $adb;
		$adb->query('DELETE FROM vtiger_ws_userauthtoken WHERE userid=1');
		$actual = vtws_getchallenge('admin');
		$this->assertEquals(array('token', 'serverTime', 'expireTime'), array_keys($actual));
		$get_token = $adb->pquery('SELECT * FROM vtiger_ws_userauthtoken WHERE userid=?', array(1));
		$this->assertEquals($get_token->fields['token'], $actual['token']);
		$this->assertEquals($get_token->fields['expiretime'], $actual['expireTime']);
		$actualupd = vtws_getchallenge('admin');
		$this->assertEquals(array('token', 'serverTime', 'expireTime'), array_keys($actualupd));
		$get_token = $adb->pquery('SELECT * FROM vtiger_ws_userauthtoken WHERE userid=?', array(1));
		$this->assertEquals($get_token->fields['token'], $actualupd['token']);
		$this->assertEquals($get_token->fields['expiretime'], $actualupd['expireTime']);
		$this->assertEquals($actual['token'], $actualupd['token']);
		$this->assertEquals($actual['expireTime'], $actualupd['expireTime']);
		$this->assertEqualsWithDelta($actual['serverTime'], $actualupd['serverTime'], 4);
		sleep(1);
		$new_expire_time = time()-(60*120); // simulate passing of time
		$adb->pquery('UPDATE vtiger_ws_userauthtoken SET expiretime=? WHERE userid=?', array($new_expire_time, 1));
		$actualupd = vtws_getchallenge('admin');
		$this->assertEquals(array('token', 'serverTime', 'expireTime'), array_keys($actualupd));
		$get_token = $adb->pquery('SELECT * FROM vtiger_ws_userauthtoken WHERE userid=?', array(1));
		$this->assertEquals($get_token->fields['token'], $actualupd['token']);
		$this->assertEquals($get_token->fields['expiretime'], $actualupd['expireTime']);
		$this->assertNotEquals($actual['token'], $actualupd['token']);
		$this->assertNotEquals($actual['expireTime'], $actualupd['expireTime']);
		$this->assertNotEquals($actual['serverTime'], $actualupd['serverTime']);
	}

	/**
	 * Method testContact
	 * @test
	 */
	public function testContact() {
		global $adb;
		$adb->query('DELETE FROM vtiger_ws_userauthtoken WHERE userid=-1085');
		$actual = vtws_getchallenge('julieta@yahoo.com');
		$this->assertEquals(array('token', 'serverTime', 'expireTime'), array_keys($actual));
		$get_token = $adb->pquery('SELECT * FROM vtiger_ws_userauthtoken WHERE userid=?', array(-1085));
		$this->assertEquals($get_token->fields['token'], $actual['token']);
		$this->assertEquals($get_token->fields['expiretime'], $actual['expireTime']);
	}
}
?>