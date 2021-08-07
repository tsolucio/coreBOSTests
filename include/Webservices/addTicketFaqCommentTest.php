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

include_once 'include/Webservices/addTicketFaqComment.php';

class addTicketFaqCommentTest extends TestCase {

	/**
	 * Method testaddHDcomment
	 * @test
	 */
	public function testaddHDcomment() {
		global $current_user, $adb;
		$comms = $adb->query('select count(*) as cnt from vtiger_ticketcomments WHERE ticketid=2776');
		$commsbefore = $comms->fields['cnt'];
		$values = array(
			'from_portal' => 1,
			'parent_id' => '12x1084',
			'comments' => 'my unit test comment',
		);
		vtws_addTicketFaqComment(vtws_getEntityId('HelpDesk').'x2776', $values, $current_user);
		$comms = $adb->query('select * from vtiger_ticketcomments WHERE ticketid=2776');
		$commsafter = $adb->num_rows($comms);
		$this->assertEquals($commsbefore+1, $commsafter);
		$this->assertEquals(1084, $adb->query_result($comms, $commsafter-1, 'ownerid'));
		$this->assertEquals('my unit test comment', $adb->query_result($comms, $commsafter-1, 'comments'));
		$this->assertEquals('customer', $adb->query_result($comms, $commsafter-1, 'ownertype'));
		//////////////////
		$comms = $adb->query('select count(*) as cnt from vtiger_ticketcomments WHERE ticketid=2776');
		$commsbefore = $comms->fields['cnt'];
		$values = array(
			'from_portal' => 1,
			'parent_id' => '1085',
			'comments' => 'my unit test comment no wsid',
		);
		vtws_addTicketFaqComment(vtws_getEntityId('HelpDesk').'x2776', $values, $current_user);
		$comms = $adb->query('select * from vtiger_ticketcomments WHERE ticketid=2776');
		$commsafter = $adb->num_rows($comms);
		$this->assertEquals($commsbefore+1, $commsafter);
		$this->assertEquals(1085, $adb->query_result($comms, $commsafter-1, 'ownerid'));
		$this->assertEquals('my unit test comment no wsid', $adb->query_result($comms, $commsafter-1, 'comments'));
		$this->assertEquals('customer', $adb->query_result($comms, $commsafter-1, 'ownertype'));
		//////////////////
		$comms = $adb->query('select count(*) as cnt from vtiger_ticketcomments WHERE ticketid=2776');
		$commsbefore = $comms->fields['cnt'];
		$values = array(
			'from_portal' => 0,
			'comments' => 'my unit test user comment',
		);
		vtws_addTicketFaqComment(vtws_getEntityId('HelpDesk').'x2776', $values, $current_user);
		$comms = $adb->query('select * from vtiger_ticketcomments WHERE ticketid=2776');
		$commsafter = $adb->num_rows($comms);
		$this->assertEquals($commsbefore+1, $commsafter);
		$this->assertEquals($current_user->id, $adb->query_result($comms, $commsafter-1, 'ownerid'));
		$this->assertEquals('my unit test user comment', $adb->query_result($comms, $commsafter-1, 'comments'));
		$this->assertEquals('user', $adb->query_result($comms, $commsafter-1, 'ownertype'));
	}

	/**
	 * Method testaddFAQcomment
	 * @test
	 */
	public function testaddFAQcomment() {
		global $current_user, $adb;
		$comms = $adb->query('select count(*) as cnt from vtiger_faqcomments WHERE faqid=4687');
		$commsbefore = $comms->fields['cnt'];
		$values = array(
			'from_portal' => 1,
			'comments' => 'my unit test comment',
		);
		vtws_addTicketFaqComment(vtws_getEntityId('Faq').'x4687', $values, $current_user);
		$comms = $adb->query('select * from vtiger_faqcomments WHERE faqid=4687');
		$commsafter = $adb->num_rows($comms);
		$this->assertEquals($commsbefore+1, $commsafter);
		$this->assertEquals('my unit test comment', $adb->query_result($comms, $commsafter-1, 'comments'));
	}

	/**
	 * Method testinvalidmoduleexception
	 * @test
	 */
	public function testinvalidmoduleexception() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALIDID);
		$values = array(
			'from_portal' => 0,
			'parent_id' => '12x1084',
			'comments' => 'my unit test comment',
		);
		vtws_addTicketFaqComment('11x74', $values, $current_user);
	}

	/**
	 * Method testReadExceptionNoPermission
	 * @test
	 */
	public function testReadExceptionNoPermission() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(5); // testdmy
		$current_user = $user;
		$values = array(
			'from_portal' => 0,
			'parent_id' => '12x1084',
			'comments' => 'my unit test comment',
		);
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		try {
			vtws_addTicketFaqComment(vtws_getEntityId('HelpDesk').'x2776', $values, $current_user);
		} catch (\Throwable $th) {
			$current_user = $holduser;
			throw $th;
		}
	}

	/**
	 * Method testInvalidIDExceptionNoPermission
	 * @test
	 */
	public function testInvalidIDExceptionNoPermission() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$values = array(
			'from_portal' => 0,
			'parent_id' => '12x1084',
			'comments' => 'my unit test comment',
		);
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALIDID);
		try {
			vtws_addTicketFaqComment(vtws_getEntityId('Faq').'x2776', $values, $current_user);
		} catch (\Throwable $th) {
			throw $th;
		}
	}

	/**
	 * Method testRecordNotFoundExceptionNoPermission
	 * @test
	 */
	// public function testRecordNotFoundExceptionNoPermission() {
	// 	global $current_user, $adb;
	// 	$this->expectException(WebServiceException::class);
	// 	$this->expectExceptionCode('INVALID_MODULE');
	// 	$rs = $adb->query('select crmid from vtiger_crmentity where setype="HelpDesk" and deleted=1');
	// 	if ($rs && $adb->num_rows($rs)>0) {
	// 		$deletedHD = $rs->fields['crmid'];
	// 	} else {
	// 		$deletedHD = 0;
	// 	}
	// 	$values = array(
	// 		'from_portal' => 0,
	// 		'parent_id' => '12x1084',
	// 		'comments' => 'my unit test comment',
	// 	);
	// 	$this->expectException(WebServiceException::class);
	// 	$this->expectExceptionCode(WebServiceErrorCode::$RECORDNOTFOUND);
	// 	try {
	// 		vtws_addTicketFaqComment(vtws_getEntityId('HelpDesk').'x'.$deletedHD, $values, $current_user);
	// 	} catch (\Throwable $th) {
	// 		throw $th;
	// 	}
	// }

	/**
	 * Method testmissingcommentexception
	 * @test
	 */
	public function testmissingcommentexception() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$values = array(
			'from_portal' => 0,
			'parent_id' => '12x1084',
			'comments' => '',
		);
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$MANDFIELDSMISSING);
		vtws_addTicketFaqComment(vtws_getEntityId('HelpDesk').'x2776', $values, $current_user);
	}
}
?>