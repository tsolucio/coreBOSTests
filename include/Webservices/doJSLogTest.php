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

include_once 'include/Webservices/doJSLog.php';

class doJSLogTest extends TestCase {

	/**
	 * Method doJSLogProvider
	 * params
	 */
	public function doJSLogProvider() {
		return array(
			array('fatal'),
			array('trace'),
			array('error'),
			array('warn'),
			array('debug'),
			array('info'),
			array(''),
		);
	}

	/**
	 * Method testdoJSLog
	 * @test
	 * @dataProvider doJSLogProvider
	 */
	public function testdoJSLog($level) {
		global $current_user;
		$this->assertTrue(true, 'doJSLog '.$level);
		cbws_jslog($level, 'message: '.$level, $current_user);
	}

	/**
	 * Method testdoJSLogJSON
	 * @test
	 */
	public function testdoJSLogJSON() {
		global $current_user;
		$level = 'fatal';
		$this->assertTrue(true, 'doJSLog JSON '.$level);
		cbws_jslog($level, '{"message": "'.$level.'"}', $current_user);
	}
}
?>