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

include_once 'include/Webservices/ValidateCUR.php';

class ValidateCURTest extends TestCase {

	/**
	 * Method testCreateWithValidation
	 * @test
	 */
	public function testCreateWithValidation() {
		global $current_user;
		$elementType = 'Quotes';
		$element = array(
			'subject' => '',
			'assigned_user_id' => '19x1',
		);
		$actual = cbwsCreateWithValidation($elementType, $element, $current_user);
		$expected = array(
			'wsresult' => array(
				'subject' => array('Subject is required'),
				'quotestage' => array('Quote Stage is required', 'Quote Stage must not exceed 200 characters'),
				'account_id' => array(
					'Organization Name must be an integer',
					'Organization Name is required'
				),
				'bill_street' => array(
					'Billing Address is required',
					'Billing Address must not exceed 250 characters',
				),
				'ship_street' => array(
					'Shipping Address is required',
					'Shipping Address must not exceed 250 characters',
				),
			),
			'wssuccess' => false,
		);
		$this->assertEquals($expected, $actual, 'cbwsValidateInformation');
	}

	/**
	 * Method testUpdateWithValidation
	 * @test
	 */
	public function testUpdateWithValidation() {
		global $current_user;
		$element = array(
			'subject' => '',
			'assigned_user_id' => '19x1',
			'id' => vtws_getEntityId('Quotes').'x11923',
		);
		$actual = cbwsUpdateWithValidation($element, $current_user);
		$expected = array(
			'wsresult' => array(
				'subject' => array('Subject is required'),
				'quotestage' => array('Quote Stage is required', 'Quote Stage must not exceed 200 characters'),
				'account_id' => array(
					'Organization Name must be an integer',
					'Organization Name is required'
				),
				'bill_street' => array(
					'Billing Address is required',
					'Billing Address must not exceed 250 characters',
				),
				'ship_street' => array(
					'Shipping Address is required',
					'Shipping Address must not exceed 250 characters',
				),
			),
			'wssuccess' => false,
		);
		$this->assertEquals($expected, $actual, 'cbwsValidateInformation');
	}

	/**
	 * Method testReviseWithValidation
	 * @test
	 */
	public function testReviseWithValidation() {
		global $current_user;
		$element = array(
			'subject' => '',
			'assigned_user_id' => '19x1',
			'id' => vtws_getEntityId('Quotes').'x11923',
		);
		$actual = cbwsReviseWithValidation($element, $current_user);
		$expected = array(
			'wsresult' => array(
				'subject' => array('Subject is required'),
				'quotestage' => array('Quote Stage is required', 'Quote Stage must not exceed 200 characters'),
				'account_id' => array(
					'Organization Name must be an integer',
					'Organization Name is required'
				),
				'bill_street' => array(
					'Billing Address is required',
					'Billing Address must not exceed 250 characters',
				),
				'ship_street' => array(
					'Shipping Address is required',
					'Shipping Address must not exceed 250 characters',
				),
			),
			'wssuccess' => false,
		);
		$this->assertEquals($expected, $actual, 'cbwsValidateInformation');
	}
}
?>