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

include_once 'include/Webservices/GetRelatedModulesManytoOne.php';
class GetRelatedModulesManyToOneTest extends TestCase {
	/**
	 * Method testGetRelatedModulesManyToOne
	 * @test
	 */
	public function testGetRelatedModulesManyToOne() {
		global $current_user;
		$currentModule = 'cbSurvey';
		$actual = getRelatedModulesManytoOne($currentModule, $current_user);
		$expected = array(
			array(
				'label' => 'Survey Questions',
				'name' => 'cbSurveyQuestion',
				'field' => 'cbsurvey',
			),
			array(
				'label' => 'Surveys Done',
				'name' => 'cbSurveyDone',
				'field' => 'cbsurvey',
			),
			array(
				'label' => 'Surveys Answer',
				'name' => 'cbSurveyAnswer',
				'field' => 'cbsurvey',
			),
		);
		$this->assertEquals($expected, $actual, 'getRelatedModulesManytoOne get accounts');
		$currentModule = 'Assets';
		$actual = getRelatedModulesManytoOne($currentModule, $current_user);
		$expected = array(
			array(
				'label' => 'Payments',
				'name' => 'CobroPago',
				'field' => 'related_id',
			),
			array(
				'label' => 'Translations',
				'name' => 'cbtranslation',
				'field' => 'translates',
			),
		);
		$this->assertEquals($expected, $actual, 'getRelatedModulesManytoOne get assets');
		$currentModule = 'Potentials';
		$actual = getRelatedModulesManytoOne($currentModule, $current_user);
		$expected = array(
			array(
				'label' => 'Quotes',
				'name' => 'Quotes',
				'field' => 'potential_id',
			),
			array(
				'label' => 'Sales Order',
				'name' => 'SalesOrder',
				'field' => 'potential_id',
			),
			array(
				'label' => 'Payments',
				'name' => 'CobroPago',
				'field' => 'related_id',
			),
			array(
				'label' => 'Comments',
				'name' => 'ModComments',
				'field' => 'related_to',
			),
			array(
				'label' => 'To Dos',
				'name' => 'cbCalendar',
				'field' => 'rel_id',
			),
			array(
				'label' => 'Translations',
				'name' => 'cbtranslation',
				'field' => 'translates',
			),
			array(
				'label' => 'Messages',
				'name' => 'Messages',
				'field' => 'messagesrelatedto',
			),
		);
		$this->assertEquals($expected, $actual, 'getRelatedModulesManytoOne get Potentials');
		$currentModule = 'Users';
		$actual = getRelatedModulesManytoOne($currentModule, $current_user);
		$expected = array();
		$this->assertEquals($expected, $actual, 'getRelatedModulesManytoOne get Users');
	}

	/**
	 * Method testactormodule
	 * @test
	 */
	public function testactormodule() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		getRelatedModulesManytoOne('AuditTrail', $current_user);
	}

	/**
	 * Method testnonentitymodule
	 * @test
	 */
	public function testnonentitymodule() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		getRelatedModulesManytoOne('evvtMenu', $current_user);
	}

	/**
	 * Method testemptymodule
	 * @test
	 */
	public function testemptymodule() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		getRelatedModulesManytoOne('', $current_user);
	}

	/**
	 * Method testinexistentmodule
	 * @test
	 */
	public function testinexistentmodule() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		getRelatedModulesManytoOne('DoesNotExist', $current_user);
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
		getRelatedModulesManytoOne('cbTermConditions', $user);
	}
}