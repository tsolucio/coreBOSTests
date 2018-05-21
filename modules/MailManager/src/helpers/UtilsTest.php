<?php
/*************************************************************************************************
 * Copyright 2016 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

include_once 'modules/MailManager/src/helpers/Utils.php';

use PHPUnit\Framework\TestCase;
class testMailManager_Utils extends TestCase {

	/**
	 * Method testsafe_html_string
	 * @test
	 */
	public function testsafe_html_string() {
		// this test is all about htmlpurifier which is redundant with vtlib_purify() test, so we don't repeat it here.
		$this->assertTrue(true);
	}

	/**
	 * Method allowedFileExtensionProvider
	 * params
	 */
	public function allowedFileExtensionProvider() {
		return array(
			array('file.string',true,'string'),
			array('file.php',false,'php'),
			array('file.png',true,'png'),
			array('file.doc',true,'doc'),
			array('file.bin',false,'bin'),
		);
	}

	/**
	 * Method testallowedFileExtension
	 * @test
	 * @dataProvider allowedFileExtensionProvider
	 */
	public function testallowedFileExtension($input,$expected,$message) {
		$actual = MailManager_Utils::allowedFileExtension($input);
		$this->assertEquals($expected, $actual,"testallowedFileExtension $message");
	}

	/**
	 * Method testemitJSON
	 * @test
	 */
	public function testemitJSON() {
		// this test is all about php json encoding which is redundant with Webservice/OperationManagerEnDecode() test, so we don't repeat it here.
		$this->assertTrue(true);
	}

}

?>