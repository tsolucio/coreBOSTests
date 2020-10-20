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

class SearchGlobalVarTest extends TestCase {

	/**
	 * Method testSearchGlobalVar
	 * @test
	 */
	public function testSearchGlobalVar() {
		$_REQUEST['gvname'] = 'Application_Default_Module';
		$_REQUEST['returnvalidation'] = 0;
		$_REQUEST['gvdefault'] = 'Accounts';
		ob_start();
		include 'modules/GlobalVariable/SearchGlobalVar.php';
		$actual = ob_get_contents();
		ob_clean();
		$this->assertEquals('{"Application_Default_Module":"Home"}', $actual);
		////////////////////
		$_REQUEST['returnvalidation'] = 1;
		include 'modules/GlobalVariable/SearchGlobalVar.php';
		$actual = ob_get_contents();
		ob_clean();
		$expected = '{"Application_Default_Module":"Home","validation":["search for variable \'Application_Default_Module\' with default value of \'Accounts\'","variable found in cache","<h2 align=\'center\'>RESULT: Home<\/H2>"],"timespent":0';
		$this->assertEquals($expected, substr($actual, 0, strlen($expected)));
		////////////////////
		unset($_REQUEST['gvname'], $_REQUEST['gvuserid'], $_REQUEST['gvmodule'], $_REQUEST['returnvalidation']);
		$_REQUEST['gvdefault'] = 'default';
		include 'modules/GlobalVariable/SearchGlobalVar.php';
		$actual = ob_get_contents();
		$this->assertEquals('["default"]', $actual);
		////////////////////
		@ob_end_clean();
		unset($_REQUEST['gvname'], $_REQUEST['gvuserid'], $_REQUEST['gvmodule'], $_REQUEST['returnvalidation'], $_REQUEST['gvdefault']);
	}
}
