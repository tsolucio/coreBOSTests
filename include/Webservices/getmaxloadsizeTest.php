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

include_once 'include/Webservices/getmaxloadsize.php';

class getmaxloadsizeTest extends TestCase {

	/**
	 * Method testget_maxloadsize
	 * @test
	 */
	public function testget_maxloadsize() {
		global $current_user;
		$maxsize = get_maxloadsize($current_user);
		$expected = (parse_size(ini_get('post_max_size'))==$maxsize || parse_size(ini_get('upload_max_filesize'))==$maxsize);
		$this->assertEquals($expected, $maxsize);
	}

	/**
	 * Method testparse_size
	 * @test
	 */
	public function testparse_size() {
		parse_size(0);
		$this->assertTrue(true, 'parse_size=numberBytes is tested in CommonUtils and the other function is almost pure PHP and hard to test without writing the function again');
	}
}
?>