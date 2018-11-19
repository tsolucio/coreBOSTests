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

use PHPUnit\Framework\TestCase;

include_once 'include/Webservices/CustomerPortalWS.php';

class testgetReferenceValue extends TestCase {

	/**
	 * Method vtws_getReferenceValue
	 * @test
	 */
	public function testvtws_getReferenceValue() {
		global $current_user;
		$actual = vtws_getReferenceValue(serialize(array('11x74','12x1085','20x2','21x1','22x2')), $current_user);
		$expected = 'a:5:{s:5:"11x74";a:2:{s:6:"module";s:8:"Accounts";s:9:"reference";s:15:"Chemex Labs Ltd";}s:7:"12x1085";a:2:{s:6:"module";s:8:"Contacts";s:9:"reference";s:15:"Julieta Cropsey";}s:4:"20x2";a:2:{s:6:"module";s:6:"Groups";s:9:"reference";s:12:"Team Selling";}s:4:"21x1";a:2:{s:6:"module";s:8:"Currency";s:9:"reference";s:13:"Euro : &euro;";}s:4:"22x2";a:2:{s:6:"module";s:15:"DocumentFolders";s:9:"reference";s:8:"Avengers";}}';
		$this->assertEquals($expected, $actual, "testvtws_getReferenceValue");
	}
}
?>