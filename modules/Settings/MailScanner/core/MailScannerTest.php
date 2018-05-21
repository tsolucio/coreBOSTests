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
require_once 'modules/Settings/MailScanner/core/MailScanner.php';
use PHPUnit\Framework\TestCase;
class MailScannerTest extends TestCase {

	/**
	 * Method toIntegerProvidor
	 * params
	 */
	public function toIntegerProvidor() {
		return array(
			array('1', true),
			array('2e', false),
			array('e2', false),
			array('e2e', false),
			array('Please help', false),
			array('92.45', false),
			array('1025', true),
			array('10279', true),
			array('1025370', true),
			array('46,353', false),
		);
	}

	/**
	 * Method testtoInteger
	 * @test
	 * @dataProvider toIntegerProvidor
	 */
	public function testtoInteger($val, $expected) {
		$vtms = new Vtiger_MailScanner('');
		$this->assertEquals($expected, $vtms->__toInteger($val));
	}
}
