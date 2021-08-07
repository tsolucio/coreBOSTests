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

include_once 'include/validation/Validations.php';

class ValidationsTest extends TestCase {

	/**
	 * Method validateRelatedModuleExistsProvider
	 * params
	 */
	public function validateRelatedModuleExistsProvider() {
		$prodfields = array(
			'record' => 2619,
			'module' => 'Products',
		);
		$accfields = array(
			'record' => 74,
			'module' => 'Accounts',
		);
		return array(
			array('productname', array('Accounts'), $prodfields, false, 'product-account'),
			array('productname', array('SalesOrder'), $prodfields, true, 'product-salesorder'),
			array('accountname', array('Assets'), $accfields, false, 'account-assets'),
			array('accountname', array('Contacts'), $accfields, true, 'account-contact'),
		);
	}

	/**
	 * Method testvalidateRelatedModuleExists
	 * @test
	 * @dataProvider validateRelatedModuleExistsProvider
	 */
	public function testvalidateRelatedModuleExists($field, $params, $fields, $expected, $message) {
		$actual = validateRelatedModuleExists($field, '', $params, $fields);
		$this->assertEquals($expected, $actual, "validateRelatedModuleExists $message");
	}
}