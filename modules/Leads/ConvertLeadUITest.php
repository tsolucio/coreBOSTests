<?php
/*************************************************************************************************
 * Copyright 2017 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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
require_once 'modules/Leads/ConvertLeadUI.php';
use PHPUnit\Framework\TestCase;
class ConvertLeadUITest extends TestCase {

	/**
	 * Method testgetMappedFieldValue
	 * @test
	 */
	public function testgetMappedFieldValue() {
		global $current_user;
		$record = '4196';
		$uiinfo = new ConvertLeadUI($record, $current_user);
		$actual = $uiinfo->getMappedFieldValue('Accounts','accountname',0);
		$expected = 'T M Byxbee Company Pc';
		$this->assertEquals($expected, $actual, 'ConvertLeadUI Accounts accountname');
		$actual = $uiinfo->getMappedFieldValue('Accounts','industry',1);
		$expected = 'Biotechnology';
		$this->assertEquals($expected, $actual, 'ConvertLeadUI Accounts industry');
		$actual = $uiinfo->getMappedFieldValue('Potentials','potentialname',0);
		$expected = 'T M Byxbee Company Pc';
		$this->assertEquals($expected, $actual, 'ConvertLeadUI Potentials potentialname');
		$actual = $uiinfo->getMappedFieldValue('Potentials','closingdate',1);
		$expected = '';
		$this->assertEquals($expected, $actual, 'ConvertLeadUI Potentials closingdate');
		$actual = $uiinfo->getMappedFieldValue('Potentials','sales_stage',1);
		$expected = '';
		$this->assertEquals($expected, $actual, 'ConvertLeadUI Potentials sales_stage');
		$actual = $uiinfo->getMappedFieldValue('Potentials','amount',1);
		$expected = '';
		$this->assertEquals($expected, $actual, 'ConvertLeadUI Potentials amount');
		$actual = $uiinfo->getMappedFieldValue('Contacts','lastname',0);
		$expected = 'Rim';
		$this->assertEquals($expected, $actual, 'ConvertLeadUI Contacts lastname');
		$actual = $uiinfo->getMappedFieldValue('Contacts','firstname',0);
		$expected = 'Gladys';
		$this->assertEquals($expected, $actual, 'ConvertLeadUI Contacts firstname');
		$actual = $uiinfo->getMappedFieldValue('Contacts','email',0);
		$expected = 'gladys.rim@rim.org';
		$this->assertEquals($expected, $actual, 'ConvertLeadUI Contacts email');
	}


}
