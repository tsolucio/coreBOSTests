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

class VtigerCRMObjectMetaTest extends TestCase {

	/**
	 * Method testVtigerCRMObjectMeta
	 * @test
	 */
	public function testVtigerCRMObjectMeta() {
		global $current_user, $adb;
		$webserviceObject = VtigerWebserviceObject::fromId($adb, '11x74');
		$obj = new VtigerCRMObjectMeta($webserviceObject, $current_user);
		$this->assertEquals('VtigerCRMObjectMeta', get_class($obj), 'Class instantiated correctly');
		$this->assertEquals('Accounts', $obj->getTabName(), 'module name');
		$this->assertEquals(6, $obj->getTabId(), 'module ID');
	}

	/**
	 * Method getNameFieldsProvidor
	 * params
	 */
	public function getNameFieldsProvidor() {
		return array(
			array('11x74', 'accountname'),
			array('12x1084', 'firstname,lastname'),
			array('17x2699', 'ticket_title'),
			array('29x4134', 'assetname'),
			array('10x4592', 'firstname,lastname'),
			array('14x2618', 'productname'),
		);
	}

	/**
	 * Method testgetNameFields
	 * @test
	 * @dataProvider getNameFieldsProvidor
	 */
	public function testgetNameFields($wsid, $expected) {
		global $current_user, $adb;
		$webserviceObject = VtigerWebserviceObject::fromId($adb, $wsid);
		$obj = new VtigerCRMObjectMeta($webserviceObject, $current_user);
		$this->assertEquals($expected, $obj->getNameFields(), 'getNameFields');
	}
}
?>