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

class testWSGetFilterByModule extends TestCase {

	/**
	 * Method getfiltersbymoduleProvider
	 * params
	 */
	public function getfiltersbymoduleProvider() {
		$edoc = array(
			'html' => "<option value='22'>All</option>",
			'filters' => array(
				22 => array(
					'name' => 'All',
					'status' => '0',
					'advcriteria' => '[]',
					'stdcriteria' => '',
				),
			),
			'linkfields' => array('notes_title'),
		);
		$east = array(
			'html' => "<option value='53'>All</option>",
			'filters' => array(
				53 => array(
					'name' => 'All',
					'status' => '0',
					'advcriteria' => '[]',
					'stdcriteria' => '',
				),
			),
			'linkfields' => array('assetname'),
		);
		$ecto = array(
			'html' => "<option value='7'>All</option><option value='8'>Contacts Address</option><option value='9'>Todays Birthday</option>",
			'filters' => array(
				7 => array(
					'name' => 'All',
					'status' => '0',
					'advcriteria' => '[]',
					'stdcriteria' => '',
				),
				8 => array(
					'name' => 'Contacts Address',
					'status' => '3',
					'advcriteria' => '[]',
					'stdcriteria' => '',
				),
				9 => array(
					'name' => 'Todays Birthday',
					'status' => '3',
					'advcriteria' => '[]',
					'stdcriteria' => "DATE_FORMAT(vtiger_contactsubdetails.birthday, '%m%d') BETWEEN DATE_FORMAT('2020-06-21 00:00:00', '%m%d') and DATE_FORMAT('2020-06-21 23:59:00', '%m%d')",
				),
			),
			'linkfields' => array('firstname', 'lastname'),
		);
		return array(
			array('Documents', $edoc, 'Documents'),
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
		$this->assertEquals($expected, getfiltersbymodule($module, $current_user), "getfiltersbymodule $message");
	}

	/**
	 * Method testactormodule
	 * @test
	 * @expectedException WebServiceException
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
	 * @expectedException WebServiceException
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
	 * @expectedException WebServiceException
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
	 * @expectedException WebServiceException
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
	 * @expectedException WebServiceException
	 */
	public function testnopermissionmodule() {
		global $current_user;
		// $this->expectException(WebServiceException::class);
		// $this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		$this->markTestIncomplete(
			'Have to configure a module with no access, update the DB and this test'
		);
		//getfiltersbymodule('Have to configure a module with no access, update the DB and this test', $current_user);
	}
}
?>