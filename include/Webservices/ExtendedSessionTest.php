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

include_once 'include/Webservices/ExtendSession.php';

class ExtendedSessionTest extends TestCase {

	/**
	 * Method testNoSession
	 * @test
	 */
	public function testNoSession() {
		global $application_unique_key;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$hid = isset($_SESSION['authenticated_user_id']) ? $_SESSION['authenticated_user_id'] : null;
		unset($_SESSION['app_unique_key'], $_SESSION['authenticated_user_id']);
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$AUTHFAILURE);
		vtws_extendSession();
		$_SESSION['authenticated_user_id'] = $hid;
		$_SESSION['app_unique_key'] = $application_unique_key;
	}

	/**
	 * Method testExtendSession
	 * @test
	 */
	public function testExtendSession() {
		global $API_VERSION, $current_user, $application_unique_key;
		$hid = isset($_SESSION['authenticated_user_id']) ? $_SESSION['authenticated_user_id'] : null;
		$_SESSION['authenticated_user_id'] = $current_user->id;
		$_SESSION['app_unique_key'] = $application_unique_key;
		$vtigerVersion = vtws_getVtigerVersion();
		$actual = vtws_extendSession('SessionManagerStub');
		$this->assertEquals(1, SessionManagerStub::$set_count);
		$this->assertEquals(
			array(
				'sessionName' => 'SmgrStubSessionID',
				'userId' => vtws_getEntityId('Users').'x'.$current_user->id,
				'version' => $API_VERSION,
				'vtigerVersion' => $vtigerVersion,
			),
			$actual
		);
		$_SESSION['authenticated_user_id'] = $hid;
	}
}
?>