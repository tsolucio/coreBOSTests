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

include_once 'include/Webservices/GetRelatedModulesOneToMany.php';
class GetRelatedModulesOneToManyTest extends TestCase {
	/**
	 * Method testGetRelatedModulesOneToMany
	 * @test
	 */
	public function testGetRelatedModulesOneToMany() {
		global $current_user;
		$currentModule = 'Accounts';
		$actual = GetRelatedModulesOneToMany($currentModule, $current_user);
		$expected = array(
			array(
				'label' => 'Organizations',
				'name' => 'Accounts',
				'field' => 'account_id',
			),
			array(
				'label' => 'Leads',
				'name' => 'Leads',
				'field' => 'convertedfromlead',
			),
		);
		$this->assertEquals($expected, $actual, 'GetRelatedModulesOneToMany get accounts');
		$currentModule = 'Assets';
		$actual = GetRelatedModulesOneToMany($currentModule, $current_user);
		$expected = array(
			array(
				'label' => 'Products',
				'name' => 'Products',
				'field' => 'product',
			),
			array(
				'label' => 'Invoice',
				'name' => 'Invoice',
				'field' => 'invoiceid',
			),
			array(
				'label' => 'Organizations',
				'name' => 'Accounts',
				'field' => 'account',
			),
		);
		$this->assertEquals($expected, $actual, 'GetRelatedModulesOneToMany get assets');
		$currentModule = 'Potentials';
		$actual = GetRelatedModulesOneToMany($currentModule, $current_user);
		$expected = array(
			array(
				'label' => 'Organizations',
				'name' => 'Accounts',
				'field' => 'related_to',
			),
			array(
				'label' => 'Contacts',
				'name' => 'Contacts',
				'field' => 'related_to',
			),
			array(
				'label' => 'Campaigns',
				'name' => 'Campaigns',
				'field' => 'campaignid',
			),
			array(
				'label' => 'Leads',
				'name' => 'Leads',
				'field' => 'convertedfromlead',
			),
		);
		$this->assertEquals($expected, $actual, 'GetRelatedModulesOneToMany get Potentials');
		$currentModule = 'Users';
		$actual = GetRelatedModulesOneToMany($currentModule, $current_user);
		$expected = array();
		$this->assertEquals($expected, $actual, 'GetRelatedModulesOneToMany get Users');
	}

	/**
	 * Method testactormodule
	 * @test
	 */
	public function testactormodule() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		GetRelatedModulesOneToMany('AuditTrail', $current_user);
	}

	/**
	 * Method testnonentitymodule
	 * @test
	 */
	public function testnonentitymodule() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		GetRelatedModulesOneToMany('evvtMenu', $current_user);
	}

	/**
	 * Method testemptymodule
	 * @test
	 */
	public function testemptymodule() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		GetRelatedModulesOneToMany('', $current_user);
	}

	/**
	 * Method testinexistentmodule
	 * @test
	 */
	public function testinexistentmodule() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		GetRelatedModulesOneToMany('DoesNotExist', $current_user);
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
		GetRelatedModulesOneToMany('cbTermConditions', $user);
	}
}