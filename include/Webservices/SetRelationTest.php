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

include_once 'include/Webservices/SetRelation.php';
include_once 'include/Webservices/UnsetRelation.php';

class SetRelationTest extends TestCase {

	public $usrcoma3dot = 10; // testtz

	/**
	 * Method testvtws_setrelation
	 * @test
	 */
	public function testvtws_setrelation() {
		global $current_user, $adb;
		$relateThisId = '1x4817'; // Campaign
		$withTheseIds = array('11x82','11x83','12x1110','12x1111');
		$rs = $adb->query('SELECT count(*) as cnt from vtiger_campaignaccountrel where accountid in (82,83) AND campaignid=4817');
		$this->assertEquals(0, $rs->fields['cnt']);
		$rs = $adb->query('SELECT count(*) as cnt from vtiger_campaigncontrel where contactid in (1110,1111) AND campaignid=4817');
		$this->assertEquals(0, $rs->fields['cnt']);
		$this->assertTrue(vtws_setrelation($relateThisId, $withTheseIds, $current_user));
		$rs = $adb->query('SELECT count(*) as cnt from vtiger_campaignaccountrel where accountid in (82,83) AND campaignid=4817');
		$this->assertEquals(2, $rs->fields['cnt']);
		$rs = $adb->query('SELECT count(*) as cnt from vtiger_campaigncontrel where contactid in (1110,1111) AND campaignid=4817');
		$this->assertEquals(2, $rs->fields['cnt']);
		$this->assertTrue(vtws_unsetrelation($relateThisId, $withTheseIds, $current_user));
		$rs = $adb->query('SELECT count(*) as cnt from vtiger_campaignaccountrel where accountid in (82,83) AND campaignid=4817');
		$this->assertEquals(0, $rs->fields['cnt']);
		$rs = $adb->query('SELECT count(*) as cnt from vtiger_campaigncontrel where contactid in (1110,1111) AND campaignid=4817');
		$this->assertEquals(0, $rs->fields['cnt']);
		//////// cbuuid
		$relateThisId = '16e91c4d141043693fea5eeecf63693fe550894f'; // HelpDesk
		$withTheseIds = array('d66fbee49b3a3f4e81e326918d5b0e6f348f02fa'); // Service Contract
		$rs = $adb->query('SELECT count(*) as cnt from vtiger_crmentityrel where (crmid=2741 AND relcrmid=9782) or (crmid=9782 AND relcrmid=2741)');
		$this->assertEquals(0, $rs->fields['cnt']);
		$this->assertTrue(vtws_setrelation($relateThisId, $withTheseIds, $current_user));
		$rs = $adb->query('SELECT count(*) as cnt from vtiger_crmentityrel where (crmid=2741 AND relcrmid=9782) or (crmid=9782 AND relcrmid=2741)');
		$this->assertEquals(1, $rs->fields['cnt']);
		$this->assertTrue(vtws_unsetrelation($relateThisId, $withTheseIds, $current_user));
		$rs = $adb->query('SELECT count(*) as cnt from vtiger_crmentityrel where (crmid=2741 AND relcrmid=9782) or (crmid=9782 AND relcrmid=2741)');
		$this->assertEquals(0, $rs->fields['cnt']);
	}

	/**
	 * Method testExceptionNoAccessModule
	 * @test
	 */
	public function testExceptionNoAccessModule() {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(11); // no create
		$current_user = $user;
		$pdoID = vtws_getEntityId('cbTermConditions');
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		try {
			vtws_setrelation($pdoID.'x27153', array(), $user);
		} catch (\Throwable $th) {
			$current_user = $holduser;
			throw $th;
		}
	}

	/**
	 * Method testInvalidID
	 * @test
	 */
	public function testInvalidID() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALIDID);
		// 12192 is a quote
		vtws_setrelation(vtws_getEntityId('SalesOrder').'x12192', array(), $current_user);
	}

	/**
	 * Method testExceptionNoAccessRecord
	 * @test
	 */
	public function testExceptionNoAccessRecord() {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrcoma3dot);
		$current_user = $user;
		$pdoID = vtws_getEntityId('Products');
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		try {
			vtws_setrelation($pdoID.'x2633', array(), $user);
		} catch (\Throwable $th) {
			$current_user = $holduser;
			throw $th;
		}
	}
}
?>