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

include_once 'include/Webservices/ProcessMap.php';

class ProcessMapTest extends TestCase {

	/**
	 * Method testInstance
	 * @test
	 */
	public function testInstance() {
		$obj = new cbwsProcessMapWorker(34030, array());
		$this->assertEquals('cbwsProcessMapWorker', get_class($obj), 'Class instantiated correctly');
		$this->assertEquals('cbMap', get_class($obj->mapobj), 'Class instantiated correctly');
		$this->assertEquals('Mapping', $obj->maptype, 'map type');
		$this->assertEquals(array(), $obj->parameters, 'parameters');
	}

	/**
	 * Method testprocessmap
	 * @test
	 */
	public function testprocessmap() {
		global $current_user;
		$params = array(
			'infields' => array(
				'record_id' => vtws_getEntityId('Invoice').'x2924',
			),
			'outfields' => array(),
		);
		$actual = cbwsProcessMap(vtws_getEntityId('cbMap').'x34030', $params, $current_user);
		$expected = array('amount' => '4572.810000', 'reference' => 'Acquired ---');
		$this->assertEquals($expected, $actual, 'cbwsProcessMap');
		///////////////
		$params = array(
			'infields' => array(
				'record_id' => vtws_getEntityId('Invoice').'x2924',
			),
			'outfields' => array(
				'record_id' => vtws_getEntityId('CobroPago').'x14301',
			),
		);
		$actual = cbwsProcessMap(vtws_getEntityId('cbMap').'x34030', $params, $current_user);
		$expected = array(
			'amount' => '4572.810000',
			'assigned_user_id' => '8',
			'cyp_no' => 'PAY-0000008',
			'reference' => 'Acquired ---',
			'parent_id' => '152',
			'related_id' => '3250',
			'register' => '2015-07-22',
			'duedate' => '2015-07-26',
			'paymentdate' => '2016-07-23',
			'paid' => '0',
			'credit' => '1',
			'paymentmode' => 'Transfer',
			'paymentcategory' => 'Travel',
			'cost' => '50.00',
			'benefit' => '44.00',
			'createdtime' => '2015-08-16 00:18:07',
			'modifiedtime' => '2015-09-08 21:10:55',
			'reports_to_id' => '0',
			'description' => 'faucibus id, libero. Donec consectetuer mauris id sapien. Cras dolor dolor, tempus non, lacinia at, iaculis quis, pede. Praesent eu dui. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean eget magna. Suspendisse tristique neque venenatis lacus. Etiam bibendum fermentum metus. Aenean sed pede nec ante blandit viverra.',
			'created_user_id' => '1',
			'record_id' => '14301',
			'record_module' => 'CobroPago',
			'cbuuid' => 'a727266d77dc73da6c2721bb5d2d8bd371b78122',
		);
		$this->assertEquals($expected, $actual, 'cbwsProcessMap');
		///////////////
		$params = array(
			'infields' => array(
				'record_id' => '2924',
			),
			'outfields' => array(
				'record_id' => '14301',
			),
		);
		$actual = cbwsProcessMap(vtws_getEntityId('cbMap').'x34030', $params, $current_user);
		$expected = array(
			'amount' => '4572.810000',
			'assigned_user_id' => '8',
			'cyp_no' => 'PAY-0000008',
			'reference' => 'Acquired ---',
			'parent_id' => '152',
			'related_id' => '3250',
			'register' => '2015-07-22',
			'duedate' => '2015-07-26',
			'paymentdate' => '2016-07-23',
			'paid' => '0',
			'credit' => '1',
			'paymentmode' => 'Transfer',
			'paymentcategory' => 'Travel',
			'cost' => '50.00',
			'benefit' => '44.00',
			'createdtime' => '2015-08-16 00:18:07',
			'modifiedtime' => '2015-09-08 21:10:55',
			'reports_to_id' => '0',
			'description' => 'faucibus id, libero. Donec consectetuer mauris id sapien. Cras dolor dolor, tempus non, lacinia at, iaculis quis, pede. Praesent eu dui. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean eget magna. Suspendisse tristique neque venenatis lacus. Etiam bibendum fermentum metus. Aenean sed pede nec ante blandit viverra.',
			'created_user_id' => '1',
			'record_id' => '14301',
			'record_module' => 'CobroPago',
			'cbuuid' => 'a727266d77dc73da6c2721bb5d2d8bd371b78122',
		);
		$this->assertEquals($expected, $actual, 'cbwsProcessMap');
		///////////////
		$params = array(
			'infields' => array(
				'record_id' => vtws_getEntityId('Invoice').'x2924',
			),
			'outfields' => array(
				'record_id' => vtws_getEntityId('CobroPago').'x14301',
				'assigned_user_id' => '8',
				'cyp_no' => 'PAY-0000008',
				'reference' => 'Grace Darling',
				'parent_id' => '152',
			),
		);
		$actual = cbwsProcessMap(vtws_getEntityId('cbMap').'x34030', $params, $current_user);
		$expected = array(
			'assigned_user_id' => '8',
			'cyp_no' => 'PAY-0000008',
			'reference' => 'Acquired ---',
			'parent_id' => '152',
			'record_id' => vtws_getEntityId('CobroPago').'x14301',
			'amount' => '4572.810000',
		);
		$this->assertEquals($expected, $actual, 'cbwsProcessMap');
	}

	/**
	 * Method testnonsupportedmap
	 * @test
	 */
	public function testnonsupportedmap() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$OPERATIONNOTSUPPORTED);
		cbwsProcessMap(vtws_getEntityId('cbMap').'x34031', array(), $current_user);
	}

	/**
	 * Method testinvalidmoduleexception
	 * @test
	 */
	public function testinvalidmoduleexception() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		cbwsProcessMap('11x74', array(), $current_user);
	}

	/**
	 * Method testReadExceptionNoPermission
	 * @test
	 */
	public function testReadExceptionNoPermission() {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(5); // testdmy
		$current_user = $user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		try {
			cbwsProcessMap(vtws_getEntityId('cbMap').'x34030', array(), $current_user);
		} catch (\Throwable $th) {
			$current_user = $holduser;
			throw $th;
		}
	}

	/**
	 * Method testInvalidIDExceptionMissinginfields
	 * @test
	 */
	public function testInvalidIDExceptionMissinginfields() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$MANDFIELDSMISSING);
		try {
			cbwsProcessMap(vtws_getEntityId('cbMap').'x34030', array(), $current_user);
		} catch (\Throwable $th) {
			throw $th;
		}
	}

	/**
	 * Method testInvalidIDExceptionMissingrecord
	 * @test
	 */
	public function testInvalidIDExceptionMissingrecord() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$MANDFIELDSMISSING);
		try {
			cbwsProcessMap(vtws_getEntityId('cbMap').'x34030', array('infields'=>array('field'=>'value')), $current_user);
		} catch (\Throwable $th) {
			throw $th;
		}
	}
}
?>