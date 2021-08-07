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

include_once 'include/Webservices/MassDelete.php';

class MassDeleteTest extends TestCase {

	/**
	 * Method testMassDelete
	 * @test
	 */
	public function testMassDelete() {
		global $current_user, $adb;
		// we create two records that we are going to delete
		$acc = vtws_create(
			'Accounts',
			array(
				'accountname'=>'going to be deleted',
				'assigned_user_id' => '19x1',
			),
			$current_user
		);
		$cto = vtws_create(
			'Contacts',
			array(
				'firstname'=>'going to be deleted',
				'lastname'=>'going to be deleted',
				'assigned_user_id' => '19x1',
			),
			$current_user
		);
		$ars = $adb->pquery(
			'select 1 from vtiger_account inner join vtiger_crmentity on crmid=accountid where deleted=0 and accountname=?',
			array('going to be deleted')
		);
		$this->assertEquals(1, $adb->num_rows($ars));
		$crs = $adb->pquery(
			'select 1 from vtiger_contactdetails inner join vtiger_crmentity on crmid=contactid where deleted=0 and firstname=?',
			array('going to be deleted')
		);
		$this->assertEquals(1, $adb->num_rows($crs));
		$dels = MassDelete($acc['id'].','.$cto['id'].',,11x99999999', $current_user);
		$expected = array(
			'success_deletes' => array($acc['id'], $cto['id']),
			'failed_deletes' => array(array(
				'id' => '11x99999999',
				'code' => 'ACCESS_DENIED',
				'message' => 'Permission to perform the operation is denied'
			))
		);
		$this->assertEquals($expected, $dels);
		$ars = $adb->pquery(
			'select 1 from vtiger_account inner join vtiger_crmentity on crmid=accountid where deleted=0 and accountname=?',
			array('going to be deleted')
		);
		$this->assertEquals(0, $adb->num_rows($ars));
		$crs = $adb->pquery(
			'select 1 from vtiger_contactdetails inner join vtiger_crmentity on crmid=contactid where deleted=0 and firstname=?',
			array('going to be deleted')
		);
		$this->assertEquals(0, $adb->num_rows($crs));
	}
}
?>