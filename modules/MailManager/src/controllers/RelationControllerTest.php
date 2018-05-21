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
include_once 'modules/MailManager/src/controllers/Controller.php';
include_once 'modules/MailManager/src/controllers/RelationController.php';

use PHPUnit\Framework\TestCase;
class testMailManager_RelationController extends TestCase {

	/**
	 * Method getbuildSearchQueryProvidor
	 */
	public function getbuildSearchQueryProvidor() {
		return array(
			array('Potentials','text','EMAIL',"SELECT potentialname FROM Potentials WHERE  email LIKE '%text%'  order by createdtime desc limit 0,6;",'Potential search text'),
			array('Potentials','1','BOOLEAN',"SELECT potentialname FROM Potentials WHERE  isconvertedfromlead LIKE '%1%'  order by createdtime desc limit 0,6;",'Potential search text'),
		);
	}

	/**
	 * Method testbuildSearchQuery
	 * @test
	 * @dataProvider getbuildSearchQueryProvidor
	 */
	public function testbuildSearchQuery($module, $text, $type, $expected, $msg) {
		$rc = new MailManager_RelationController();
		$actual = $rc->buildSearchQuery($module, $text, $type);
		$this->assertEquals($expected,$actual,$msg);
	}

}

?>