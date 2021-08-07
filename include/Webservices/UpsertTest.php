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

include_once 'include/Webservices/upsert.php';

class UpsertTest extends TestCase {

	/**
	 * Method testupsert
	 * @test
	 */
	public function testupsert() {
		global $current_user, $adb;
		$aname = uniqid();
		$rs = $adb->pquery('select count(*) as cnt from vtiger_account where accountname=?', array($aname));
		$this->assertTrue($rs->fields['cnt']==0);
		$element = array(
			'accountname' => $aname,
			'phone' => 'mystrange_phone_number',
			'assigned_user_id' => '19x1',
			'account_id' => '11x74',
			'id' => '11x74', // this is ignored as we create
		);
		$rec = vtws_upsert('Accounts', $element, 'accountname', 'accountname,phone', $current_user);
		$rs = $adb->pquery('select count(*) as cnt from vtiger_account where accountname=?', array($aname));
		$this->assertTrue($rs->fields['cnt']==1);
		$element = array(
			'accountname' => 'updated with upsert',
			'phone' => 'phone_number_strange',
			'assigned_user_id' => '19x1',
			'id' => $rec['id'],
		);
		$rec = vtws_upsert('Accounts', $element, 'id', 'accountname,phone', $current_user);
		$rs = $adb->pquery('select count(*) as cnt from vtiger_account where accountname=?', array($aname));
		$this->assertTrue($rs->fields['cnt']==0);
		$rs = $adb->pquery('select count(*) as cnt from vtiger_account where accountname=? and phone=?', array('updated with upsert', 'phone_number_strange'));
		$this->assertTrue($rs->fields['cnt']>0);
		$element = array(
			'accountname' => 'updated with upsert cbuuid',
			'phone' => 'phone_number_strange',
			'assigned_user_id' => '19x1',
			'cbuuid' => $rec['cbuuid'],
		);
		$rec = vtws_upsert('Accounts', $element, 'cbuuid', 'accountname,phone', $current_user);
		$rs = $adb->pquery('select count(*) as cnt from vtiger_account where accountname=?', array('updated with upsert'));
		$this->assertTrue($rs->fields['cnt']==0);
		$rs = $adb->pquery('select count(*) as cnt from vtiger_account where accountname=? and phone=?', array('updated with upsert cbuuid', 'phone_number_strange'));
		$this->assertTrue($rs->fields['cnt']>0);
		$element = array(
			'accountname' => 'updated with upsert account_id',
			'phone' => 'phone_number_strange',
			'assigned_user_id' => '19x1',
			'account_id' => '11x74',
			'cbuuid' => $rec['cbuuid'],
		);
		$rec = vtws_upsert('Accounts', $element, 'account_id,phone', 'accountname,phone', $current_user);
		$rs = $adb->pquery('select count(*) as cnt from vtiger_account where accountname=?', array('updated with upsert cbuuid'));
		$this->assertTrue($rs->fields['cnt']==0);
		$rs = $adb->pquery('select count(*) as cnt from vtiger_account where accountname=? and phone=?', array('updated with upsert account_id', 'phone_number_strange'));
		$this->assertTrue($rs->fields['cnt']>0);
		list($wsid, $crmid) = explode('x', $rec['id']);
		$adb->pquery('update vtiger_account set accountname=?,phone=? where accountid=?', array($aname, $aname, $crmid)); // change it so we can repeate the test
	}

	/**
	 * Method testupsertcreateexception
	 * @test
	 */
	public function testupsertcreateexception() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$MANDFIELDSMISSING);
		$element = array(
			'accountname' => uniqid(),
			'phone' => 'mystrange_phone_number',
		);
		vtws_upsert('Accounts', $element, 'accountname', 'accountname,phone', $current_user);
	}

	/**
	 * Method testgetOwnerTypeException
	 * @test
	 */
	public function testgetOwnerTypeException() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$SEARCH_VALUE_NOT_PROVIDED);
		$element = array(
			'accountname' => uniqid(),
			'phone' => 'mystrange_phone_number',
		);
		vtws_upsert('Accounts', $element, 'fielddoesnotexist', 'phone', $current_user);
	}
}
?>