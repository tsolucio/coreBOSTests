<?php
/*************************************************************************************************
 * Copyright 2018 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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
require_once 'modules/WSAPP/Handlers/vtigerCRMHandler.php';
use PHPUnit\Framework\TestCase;

class vtigerCRMHandlerTest extends TestCase {

	/**
	 * Method testfillNonExistingMandatoryPicklistValues
	 * @test
	 */
	public function testfillNonExistingMandatoryPicklistValues() {
		global $current_user;
		$vt = new vtigerCRMHandler('');
		$vt->setUser($current_user);
		$expected = array();
		$update = array();
		$this->assertEquals($expected, $vt->fillNonExistingMandatoryPicklistValues($update));
		$update = array(
			'11x74'=>array(
				'accountname' => 'Acme, Inc',
				'assigned_user_id' => '19x5',
				'module' => 'Accounts',
			),
		);
		$expected = $update;
		$this->assertEquals($expected, $vt->fillNonExistingMandatoryPicklistValues($update));
		$update = array(
			'13x5138'=>array(
				'potentialname' => 'Acme, Inc',
				'assigned_user_id' => '19x5',
				'module' => 'Potentials',
			),
		);
		$expected = $update;
		$expected['13x5138']['sales_stage'] = 'Prospecting';
		$this->assertEquals($expected, $vt->fillNonExistingMandatoryPicklistValues($update));
		$update = array(
			'11x74'=>array(
				'accountname' => 'Acme, Inc',
				'assigned_user_id' => '19x5',
				'module' => 'Accounts',
			),
			'13x5138'=>array(
				'potentialname' => 'Acme, Inc',
				'assigned_user_id' => '19x5',
				'module' => 'Potentials',
			),
		);
		$expected = $update;
		$expected['13x5138']['sales_stage'] = 'Prospecting';
		$this->assertEquals($expected, $vt->fillNonExistingMandatoryPicklistValues($update));
		$update = array(
			'11x74'=>array(
				'accountname' => 'Acme, Inc',
				'assigned_user_id' => '19x5',
				'module' => 'Accounts',
			),
			'13x5138'=>array(
				'potentialname' => 'Acme, Inc',
				'assigned_user_id' => '19x5',
				'module' => 'Potentials',
			),
			'11x75'=>array(
				'accountname' => 'MyAcc, Inc',
				'assigned_user_id' => '19x8',
				'module' => 'Accounts',
			),
			'13x5142'=>array(
				'potentialname' => 'MyAcc, Inc',
				'assigned_user_id' => '19x8',
				'module' => 'Potentials',
			),
		);
		$expected = $update;
		$expected['13x5138']['sales_stage'] = 'Prospecting';
		$expected['13x5142']['sales_stage'] = 'Prospecting';
		$this->assertEquals($expected, $vt->fillNonExistingMandatoryPicklistValues($update));
	}

	/**
	 * Method testtranslateReferenceFieldNamesToIds
	 * @test
	 */
	public function testtranslateReferenceFieldNamesToIds() {
		global $current_user;
		$vt = new vtigerCRMHandler('');
		$vt->setUser($current_user);
		$expected = array(
			'74' => array('module'=>'Accounts', 'accountname' => 'Chemex', 'account_id' => '11x80'),
			'76' => array('module'=>'Accounts', 'accountname' => 'Another', 'account_id' => '11x802'),
			'1084' => array('module'=>'Contacts', 'firstname' => 'ctofname', 'created_user_id' => '19x5', 'account_id' => '11x80'),
		);
		$records = array(
			'74' => array('module'=>'Accounts', 'accountname' => 'Chemex', 'account_id' => 'Simpson, Fred B Esq'),
			'76' => array('module'=>'Accounts', 'accountname' => 'Another', 'account_id' => 'Jin Shin Travel Agency'),
			'1084' => array('module'=>'Contacts', 'firstname' => 'ctofname', 'created_user_id' => 'cbTest testdmy', 'account_id' => 'Simpson, Fred B Esq'),
		);
		$this->assertEquals($expected, $vt->translateReferenceFieldNamesToIds($records, $current_user));
	}
}
