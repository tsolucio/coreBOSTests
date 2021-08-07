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

include_once 'include/Webservices/GetFilterByModule.php';

class GetFilterByModuleTest extends TestCase {

	/**
	 * Method getfiltersbymoduleProvider
	 * params
	 */
	public function getfiltersbymoduleProvider() {
		$today = date('Y-m-d');
		$edoc = array(
			'html' => "<option value='22'>All</option>",
			'filters' => array(
				22 => array(
					'name' => 'All',
					'status' => '0',
					'advcriteria' => '[]',
					'stdcriteria' => '',
					'advcriteriaWQL' => '',
					'advcriteriaEVQL' => '',
					'stdcriteriaWQL' => '',
					'stdcriteriaEVQL' => '',
					'fields' => array(
						0 => 'note_no',
						1 => 'notes_title',
						2 => 'filename',
						3 => 'modifiedtime',
						4 => 'assigned_user_id',
					),
					'default' => true,
				),
			),
			'linkfields' => array('notes_title'),
			'pagesize' => 40
		);
		$east = array(
			'html' => "<option value='53'>All</option>",
			'filters' => array(
				53 => array(
					'name' => 'All',
					'status' => '0',
					'advcriteria' => '[]',
					'stdcriteria' => '',
					'advcriteriaWQL' => '',
					'advcriteriaEVQL' => '',
					'stdcriteriaWQL' => '',
					'stdcriteriaEVQL' => '',
					'fields' => array(
						0 => 'asset_no',
						1 => 'assetname',
						2 => 'account',
						3 => 'product',
					),
					'default' => true,
				),
			),
			'linkfields' => array('assetname'),
			'pagesize' => 40
		);
		$eusr = array(
			'html' => '',
			'filters' => array(),
			'linkfields' => array('last_name'),
			'pagesize' => 40
		);
		$ecto = array(
			'html' => "<option value='7'>All</option><option value='8'>Contacts Address</option><option value='9'>Todays Birthday</option>",
			'filters' => array(
				7 => array(
					'name' => 'All',
					'status' => '0',
					'advcriteria' => '[]',
					'stdcriteria' => '',
					'advcriteriaWQL' => '',
					'advcriteriaEVQL' => '',
					'stdcriteriaWQL' => '',
					'stdcriteriaEVQL' => '',
					'fields' => array(
						0 => 'contact_no',
						1 => 'firstname',
						2 => 'lastname',
						3 => 'title',
						4 => 'account_id',
						5 => 'email',
						6 => 'phone',
						7 => 'assigned_user_id',
					),
					'default' => true,
				),
				8 => array(
					'name' => 'Contacts Address',
					'status' => '3',
					'advcriteria' => '[]',
					'stdcriteria' => '',
					'advcriteriaWQL' => '',
					'advcriteriaEVQL' => '',
					'stdcriteriaWQL' => '',
					'stdcriteriaEVQL' => '',
					'fields' => array(
						0 => 'firstname',
						1 => 'lastname',
						2 => 'mailingstreet',
						3 => 'mailingcity',
						4 => 'mailingstate',
						5 => 'mailingzip',
						6 => 'mailingcountry',
					),
					'default' => false,
				),
				9 => array(
					'name' => 'Todays Birthday',
					'status' => '3',
					'advcriteria' => '[]',
					'stdcriteria' => "DATE_FORMAT(vtiger_contactsubdetails.birthday, '%m%d') BETWEEN DATE_FORMAT('".$today." 00:00:00', '%m%d') and DATE_FORMAT('".$today." 23:59:00', '%m%d')",
					'advcriteriaWQL' => '',
					'advcriteriaEVQL' => '',
					'stdcriteriaWQL' => "DATE_FORMAT(vtiger_contactsubdetails.birthday, '%m%d') BETWEEN DATE_FORMAT('".$today." 00:00:00', '%m%d') and DATE_FORMAT('".$today." 23:59:00', '%m%d')",
					'stdcriteriaEVQL' => '{"fieldname":"birthday","operation":"between","value":"'.$today.','.$today.'","valuetype":"rawtext","joincondition":"and","groupid":1297208112}',
					'fields' => array(
						0 => 'firstname',
						1 => 'lastname',
						2 => 'title',
						3 => 'assigned_user_id',
					),
					'default' => false,
				),
			),
			'linkfields' => array('firstname', 'lastname'),
			'pagesize' => 40
		);
		return array(
			array('Documents', $edoc, 'Documents'),
			array('Users', $eusr, 'Users'),
			array('Assets', $east, 'Assets'),
			array('Contacts', $ecto, 'Contacts'),
		);
	}

	/**
	 * Method testgetfiltersbymodule
	 * @test
	 * @dataProvider getfiltersbymoduleProvider
	 */
	public function testgetfiltersbymodule($module, $expected, $message) {
		global $current_user;
		$current_user = Users::getActiveAdminUser();
		$actual = getfiltersbymodule($module, $current_user);
		if ($module == 'Contacts') {
			$aEVQL = json_decode($actual['filters'][9]['stdcriteriaEVQL'], true);
			$eEVQL = json_decode($expected['filters'][9]['stdcriteriaEVQL'], true);
			$eEVQL['groupid'] = $aEVQL['groupid'];
			$expected['filters'][9]['stdcriteriaEVQL'] = json_encode($eEVQL);
		}
		$this->assertEquals($expected, $actual, "getfiltersbymodule $message");
	}

	/**
	 * Method testactormodule
	 * @test
	 */
	public function testactormodule() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		getfiltersbymodule('AuditTrail', $current_user);
	}

	/**
	 * Method testnonentitymodule
	 * @test
	 */
	public function testnonentitymodule() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		getfiltersbymodule('evvtMenu', $current_user);
	}

	/**
	 * Method testemptymodule
	 * @test
	 */
	public function testemptymodule() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		getfiltersbymodule('', $current_user);
	}

	/**
	 * Method testinexistentmodule
	 * @test
	 */
	public function testinexistentmodule() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		getfiltersbymodule('DoesNotExist', $current_user);
	}

	/**
	 * Method testnopermissionmodule
	 * @test
	 */
	public function testnopermissionmodule() {
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(11); // nocreate > no access to cbTermConditions
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		getfiltersbymodule('cbTermConditions', $user);
	}
}
?>