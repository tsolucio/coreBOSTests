<?php
/*************************************************************************************************
 * Copyright 2021 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

class CreateEditTest extends TestCase {

	public $usrnocreate = 11; // nocreate > special profile

	/**
	 * Method testCreateWithNoEditPermission
	 * @test
	 */
	public function testCreateWithNoEditPermission() {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrnocreate);
		$current_user = $user;
		$Module = 'cbCredentials';
		$cbUserID = '19x'.$current_user->id;
		$ObjectValues = array(
			'adapter'=>'GoogleCloudStorage',
			'assigned_user_id' => $cbUserID,
			'description' => 'áçèñtös',
		);
		$actual = vtws_create($Module, $ObjectValues, $current_user);
		$actualValues = array(
			'adapter' => $actual['adapter'],
			'assigned_user_id' => $actual['assigned_user_id'],
			'description' => $actual['description'],
		);
		$this->assertEquals($ObjectValues, $actualValues, 'create credentials record');
		/// end
		$current_user = $holduser;
	}

	/**
	 * Method testEditExceptionNoPermission
	 * @test
	 * @depends testCreateWithNoEditPermission
	 */
	public function testEditExceptionNoPermission() {
		global $current_user, $adb;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrnocreate);
		$current_user = $user;
		$rs = $adb->query('select cbcredentialsid from vtiger_cbcredentials where deleted=0');
		$ObjectValues = array(
			'id' => '58x'.$rs->fields['cbcredentialsid'],
			'description' => 'not valid edit'
		);
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		try {
			vtws_revise($ObjectValues, $current_user);
		} catch (\Throwable $th) {
			$current_user = $holduser;
			throw $th;
		}
	}

	/**
	 * Method testCreateExceptionNoPermission
	 * @test
	 */
	public function testCreateExceptionNoPermission() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$holduser = $current_user;
		$user = new Users();
		///  nocreate
		$user->retrieveCurrentUserInfoFromFile(11); // nocreate
		$current_user = $user;
		$Module = 'cbCompany';
		$cbUserID = '19x'.$current_user->id;
		$ObjectValues = array(
			'companyname'=>'ACME, INC',
			'assigned_user_id' => $cbUserID,
			'description' => 'áçèñtös',
		);
		$_FILES=array();
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		try {
			vtws_create($Module, $ObjectValues, $current_user);
		} catch (\Throwable $th) {
			$current_user = $holduser;
			throw $th;
		}
	}

	/**
	 * Method testEditWithNoCreatePermission
	 * @test
	 */
	public function testEditWithNoCreatePermission() {
		global $current_user, $adb;
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrnocreate);
		$current_user = $user;
		$adb->pquery('update vtiger_crmentity set description=? where crmid=43029', array('anything but valid edit'));
		$ObjectValues = array(
			'id' => '46x43029', // Companies
			'description' => 'valid edit'
		);
		vtws_revise($ObjectValues, $current_user);
		$rs = $adb->query('select description from vtiger_crmentity where crmid=43029');
		$this->assertEquals('valid edit', $rs->fields['description'], 'edit company description');
		$current_user = $holduser;
	}
}
?>