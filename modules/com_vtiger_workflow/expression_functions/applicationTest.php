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

class applicationTest extends TestCase {

	/**
	 * Method testevaluateRule
	 * @test
	 */
	public function testevaluateRule() {
		global $current_user;
		$entityCache = new VTEntityCache($current_user);
		$entityData = $entityCache->forId('11x74');
		$params = array(34038, $entityData);
		$actual = __cb_evaluateRule($params);
		$this->assertEquals('Chemex Labs Ltd', $actual, 'account name query');
		$params = array(34031, $entityData);
		$actual = __cb_evaluateRule($params);
		$this->assertEquals('THIS STRING', $actual, 'account name query');
		$actual = __cb_evaluateRule(array());
		$this->assertEquals(0, $actual, 'account name query');
		$actual = __cb_evaluateRule(array(11));
		$this->assertEquals(0, $actual, 'account name query');
		$actual = __cb_evaluateRule(array(11, $entityData));
		$this->assertEquals(0, $actual, 'account name query');
		$actual = __cb_evaluateRule(array(11, 11, $entityData));
		$this->assertEquals(0, $actual, 'account name query');
	}

	/**
	 * Method testgetfromcontext
	 * @test
	 */
	public function testgetfromcontext() {
		$this->assertTrue(true, 'tested in wfExecExpressionTest.php');
	}

	/**
	 * Method testgetfromcontextsearching
	 * @test
	 */
	public function testgetfromcontextsearching() {
		$this->assertTrue(true, 'tested in wfExecExpressionTest.php');
	}

	/**
	 * Method testsetfromcontext
	 * @test
	 */
	public function testsetfromcontext() {
		$this->assertTrue(true, 'tested in wfExecExpressionTest.php');
	}

	/**
	 * Method testgetfromcontextvalueinarrayobject
	 * @test
	 */
	public function testgetfromcontextvalueinarrayobject() {
		$array = array(
			'one' => 1,
			'two' => array(
				'two' => 2,
			),
			'three' => array(
				'three' => array(
					'three' => 3,
				),
			),
		);
		$this->assertEquals(1, __cb_getfromcontextvalueinarrayobject($array, 'one'));
		$this->assertEquals(2, __cb_getfromcontextvalueinarrayobject($array, 'two.two'));
		$this->assertEquals(3, __cb_getfromcontextvalueinarrayobject($array, 'three.three.three'));
		$this->assertEquals('', __cb_getfromcontextvalueinarrayobject(array(), 'one.two'));
		$this->assertEquals('', __cb_getfromcontextvalueinarrayobject($array, 'one.two'));
		$object = json_decode('{"one":1,"two" :[{"two":2}],"three":[[{"three":3}]]}');
		$this->assertEquals(1, __cb_getfromcontextvalueinarrayobject($object, 'one'));
		$this->assertEquals(2, __cb_getfromcontextvalueinarrayobject($object, 'two.0.two'));
		$this->assertEquals(3, __cb_getfromcontextvalueinarrayobject($object, 'three.0.three.0.three'));
		$this->assertEquals('', __cb_getfromcontextvalueinarrayobject(false, 'one.two'));
		$this->assertEquals('', __cb_getfromcontextvalueinarrayobject($object, 'one.two'));
	}

	/**
	 * Method testgetidof
	 * @test
	 */
	public function testgetidof() {
		$this->assertEquals(74, __cb_getidof(array('Accounts', 'accountname', 'Chemex Labs Ltd')), 'accounts');
		$this->assertEquals(1094, __cb_getidof(array('Contacts', 'mobile', '561-951-9734')), 'contacts');
		$this->assertEquals(0, __cb_getidof(array('Contacts', 'mobile', 'does not exist')), 'contacts');
	}

	/**
	 * Method testgetrelatedids
	 * @test
	 */
	public function testgetrelatedids() {
		global $current_user;
		$entityCache = new VTEntityCache($current_user);
		$entityData = $entityCache->forId('11x74');
		$params = array('Contacts', $entityData);
		$expected = array('12x1084', '12x1086', '12x1088', '12x1090', '12x1092', '12x1094');
		$this->assertEquals($expected, __cb_getrelatedids($params), 'accounts > contacts');
		$params = array('SalesOrder', $entityData);
		$expected = array('6x10746');
		$this->assertEquals($expected, __cb_getrelatedids($params), 'accounts > SalesOrder');
		$params = array('cbCalendar', $entityData);
		$expected = array();
		$this->assertEquals($expected, __cb_getrelatedids($params), 'accounts > cbCalendar');
		$params = array('NonExistent', $entityData);
		$expected = array();
		$this->assertEquals($expected, __cb_getrelatedids($params), 'accounts > NonExistent');
		$params = array('', $entityData);
		$expected = array();
		$this->assertEquals($expected, __cb_getrelatedids($params), 'accounts > empty');
		///// any record relations
		$params = array('HelpDesk', 943, $entityData);
		$expected = array('17x2645');
		$this->assertEquals($expected, __cb_getrelatedids($params), 'accounts > helpdesk');
		$params = array('HelpDesk', 2105, $entityData);
		$expected = array('17x2640');
		$this->assertEquals($expected, __cb_getrelatedids($params), 'contacts > helpdesk');
	}

	/**
	 * Method testexecuteSQL
	 * @test
	 */
	public function testexecuteSQL() {
		$params = array('select accountname from vtiger_account where otherphone=?', '248-697-7722');
		$expected = array(['accountname' => 'Sebring & Co']);
		$this->assertEquals($expected, __cb_executesql($params), 'accountname');
		$params = array('select accountname,siccode from vtiger_account where accountname like "%Sebring%"');
		$expected = array(
			['accountname' => 'Sebring & Co', 'siccode' => ''],
			['accountname' => 'Sebring & Co', 'siccode' => ''],
		);
		$this->assertEquals($expected, __cb_executesql($params), 'accountname');
		$params = array('select accountname,siccode from vtiger_account where accountname like ? and email1=?', '%Sebring%', 'cherry@lietz.com');
		$expected = array(
			['accountname' => 'Sebring & Co', 'siccode' => ''],
		);
		$this->assertEquals($expected, __cb_executesql($params), 'accountname');
	}
}
?>