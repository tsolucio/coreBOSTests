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

include_once 'include/Webservices/Delete.php';

class testWSDelete extends TestCase {

	/**
	 * Method testvtws_delete
	 * @test
	 */
	public function testvtws_delete() {
		global $current_user, $adb;
		$id = '30x18907'; // ModComments
		$rs = $adb->query('SELECT deleted from vtiger_crmentity where crmid=18907');
		$this->assertEquals(0, $rs->fields['deleted']);
		vtws_delete($id, $current_user);
		$rs = $adb->query('SELECT deleted from vtiger_crmentity where crmid=18907');
		$this->assertEquals(1, $rs->fields['deleted']);
		$rs = $adb->query('UPDATE vtiger_crmentity set deleted=0 where crmid=18907');
		$rs = $adb->query('UPDATE vtiger_crmobject set deleted=0 where crmid=18907');
		//////// cbuuid
		$id = 'bce42373c7b4c5f4e1a283c8d6bbb4beaf0e72cc'; // ModComments
		$rs = $adb->query('SELECT deleted from vtiger_crmentity where crmid=18907');
		$this->assertEquals(0, $rs->fields['deleted']);
		vtws_delete($id, $current_user);
		$rs = $adb->query('SELECT deleted from vtiger_crmentity where crmid=18907');
		$this->assertEquals(1, $rs->fields['deleted']);
		$rs = $adb->query('UPDATE vtiger_crmentity set deleted=0 where crmid=18907');
		$rs = $adb->query('UPDATE vtiger_crmobject set deleted=0 where crmid=18907');
	}

	/**
	 * Method testDeleteUser
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testDeleteUser() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		vtws_delete('19x5', $current_user);
	}

	/**
	 * Method testDeleteExceptionNoModuleAccess
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testDeleteExceptionNoModuleAccess() {
		$user = new Users();
		///  nocreate
		$user->retrieveCurrentUserInfoFromFile(11); // nocreate
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		vtws_delete(vtws_getEntityId('cbTermConditions').'x27153', $user);
	}

	/**
	 * Method testDeleteExceptionNoPermission
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testDeleteExceptionNoPermission() {
		$user = new Users();
		///  nocreate
		$user->retrieveCurrentUserInfoFromFile(11); // nocreate
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		vtws_delete(vtws_getEntityId('Campaigns').'x4789', $user);
	}

	/**
	 * Method testDeleteExceptionWrongID
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testDeleteExceptionWrongID() {
		$user = new Users();
		///  nocreate
		$user->retrieveCurrentUserInfoFromFile(11); // nocreate
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALIDID);
		vtws_delete(vtws_getEntityId('cbQuestion').'x74', $user);
	}
}
?>