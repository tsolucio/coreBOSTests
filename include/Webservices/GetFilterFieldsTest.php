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

include_once 'include/Webservices/GetFilterFields.php';

class testWSGetFilterFields extends TestCase {

	/**
	 * Method testGetFilterFields
	 * @test
	 */
	public function testGetFilterFields() {
		global $current_user;
		// this function is tested in getRelatedModules, we add here two cases not included there for coverage
		$expected = array(
			'fields'=>array('first_name', 'last_name', 'email1'),
			'linkfields'=>array('first_name', 'last_name'),
			'pagesize' => intval(GlobalVariable::getVariable('Application_ListView_PageSize', 20, 'Users')),
		);
		$this->assertEquals($expected, vtws_getfilterfields('Users', $current_user), 'GetFilterFields');
	}

	/**
	 * Method testextension
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testextension() {
		global $current_user;
		$this->assertEquals('', vtws_getfilterfields('evvtMenu', $current_user), 'GetFilterFields on extension');
	}
}
?>