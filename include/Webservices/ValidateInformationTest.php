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

include_once 'include/Webservices/ValidateInformation.php';
include_once 'include/Webservices/Create.php';
include_once 'include/Webservices/Delete.php';

class testValidateInformation extends TestCase {

	protected static $mapid;

	public static function setUpBeforeClass() {
		global $current_user;
		$cbUserID = '19x'.$current_user->id;
		$ObjectValues = array(
			'mapname'=>'AccountValidation',
			'maptype' => 'Validations',
			'targetname'=>'Accounts',
			'content' => '<map>
			<originmodule>
				<originname>Accounts</originname>
			  </originmodule>
			  <fields>
				<field>
				  <fieldname>accountname</fieldname>
				  <validations>
					<validation>
					  <rule>required</rule>
					</validation>
					<validation>
					  <rule>contains</rule>
					  <restrictions>
					  <restriction>mex</restriction>
					  </restrictions>
					</validation>
				  </validations>
				</field>
				<field>
				  <fieldname>industry</fieldname>
				  <validations>
					<validation>
					  <rule>notDuplicate</rule>
					</validation>
				  </validations>
				</field>
			  </fields>
			</map>',
			'assigned_user_id' => $cbUserID,
			'description' => '',
		);
		$map = vtws_create('cbMap', $ObjectValues, $current_user);
		self::$mapid = $map['id'];
	}

	public static function tearDownAfterClass() {
		global $current_user;
		vtws_delete(self::$mapid, $current_user);
	}

	/**
	 * Method testcbwsValidateInformation
	 * @test
	 */
	public function testcbwsValidateInformation() {
		global $current_user;
		$actual = cbwsValidateInformation('{"module":"Accounts","record":"","cbcustominfo1":"","cbcustominfo2":"","accountname":"nom e x","account_no":"AUTO GEN ON SAVE","website":"","phone":"","tickersymbol":"","fax":"","account_name":"","account_id":"","otherphone":"","employees":"22","email1":"","email2":"","ownership":"","industry":"Apparel","rating":"--None--","accounttype":"","siccode":"","emailoptout":false,"annual_revenue":"0","assigntype":"U","assigned_user_id":"1","assigned_group_id":"3","notify_owner":false,"cf_718":"","cf_719":"0","cf_720":"0","cf_721":"0","cf_722":"","cf_723":"","cf_724":"","cf_725":"","cf_726":false,"cf_727":"","cf_728":"","cf_729":"one","cf_730":"oneone","cf_731":"oneoneone","cf_732[]":"","bill_street":"","ship_street":"","bill_pobox":"","ship_pobox":"","bill_city":"","ship_city":"","bill_state":"","ship_state":"","bill_code":"","ship_code":"","bill_country":"","ship_country":"","description":""}', $current_user);
		$expected = array(
			'wsresult' => array(
				'accountname' => array('Organization Name must contain mex'),
				'industry' => array('Industry Columns cannot be duplicated'),
			),
			'wssuccess' => false,
		);
		$this->assertEquals($expected, $actual, 'cbwsValidateInformation');
		$actual = cbwsValidateInformation('{"module":"Accounts","record":"74","cbcustominfo1":"","cbcustominfo2":"","accountname":"nom e x","account_no":"AUTO GEN ON SAVE","website":"","phone":"","tickersymbol":"","fax":"","account_name":"","account_id":"","otherphone":"","employees":"22","email1":"","email2":"","ownership":"","industry":"Apparel","rating":"--None--","accounttype":"","siccode":"","emailoptout":false,"annual_revenue":"0","assigntype":"U","assigned_user_id":"1","assigned_group_id":"3","notify_owner":false,"cf_718":"","cf_719":"0","cf_720":"0","cf_721":"0","cf_722":"","cf_723":"","cf_724":"","cf_725":"","cf_726":false,"cf_727":"","cf_728":"","cf_729":"one","cf_730":"oneone","cf_731":"oneoneone","cf_732[]":"","bill_street":"","ship_street":"","bill_pobox":"","ship_pobox":"","bill_city":"","ship_city":"","bill_state":"","ship_state":"","bill_code":"","ship_code":"","bill_country":"","ship_country":"","description":""}', $current_user);
		$expected = array(
			'wsresult' => array(
				'accountname' => array('Organization Name must contain mex'),
				'industry' => array('Industry Columns cannot be duplicated'),
			),
			'wssuccess' => false,
		);
		$this->assertEquals($expected, $actual, 'cbwsValidateInformation');
		$actual = cbwsValidateInformation('{"module":"Accounts","record":"","cbcustominfo1":"","cbcustominfo2":"","accountname":"nomex","account_no":"AUTO GEN ON SAVE","website":"","phone":"","tickersymbol":"","fax":"","account_name":"","account_id":"","otherphone":"","employees":"22","email1":"","email2":"","ownership":"","industry":"NOT_THERE","rating":"--None--","accounttype":"","siccode":"","emailoptout":false,"annual_revenue":"0","assigntype":"U","assigned_user_id":"1","assigned_group_id":"3","notify_owner":false,"cf_718":"","cf_719":"0","cf_720":"0","cf_721":"0","cf_722":"","cf_723":"","cf_724":"","cf_725":"","cf_726":false,"cf_727":"","cf_728":"","cf_729":"one","cf_730":"oneone","cf_731":"oneoneone","cf_732[]":"","bill_street":"","ship_street":"","bill_pobox":"","ship_pobox":"","bill_city":"","ship_city":"","bill_state":"","ship_state":"","bill_code":"","ship_code":"","bill_country":"","ship_country":"","description":""}', $current_user);
		$expected = true;
		$this->assertEquals($expected, $actual, 'cbwsValidateInformation');
	}

	public function testInvalidParameter1() {
		global $current_user;
		$this->expectException('WebServiceException');
		$actual = cbwsValidateInformation('', $current_user);
	}

	public function testInvalidParameter2() {
		global $current_user;
		$this->expectException('WebServiceException');
		$actual = cbwsValidateInformation('{"module":"', $current_user);
	}

	public function testInvalidParameter3() {
		global $current_user;
		$this->expectException('WebServiceException');
		$actual = cbwsValidateInformation('{"module":"Accounts","cbcustominfo1":""}', $current_user);
	}

	public function testIncorrectModule() {
		global $current_user;
		$this->expectException('WebServiceException');
		$actual = cbwsValidateInformation('{"module":"Accounts","record":"1084","cbcustominfo1":"","cbcustominfo2":"","accountname":"nomex","account_no":"AUTO GEN ON SAVE","website":"","phone":"","tickersymbol":"","fax":"","account_name":"","account_id":"","otherphone":"","employees":"22","email1":"","email2":"","ownership":"","industry":"NOT_THERE","rating":"--None--","accounttype":"","siccode":"","emailoptout":false,"annual_revenue":"0","assigntype":"U","assigned_user_id":"1","assigned_group_id":"3","notify_owner":false,"cf_718":"","cf_719":"0","cf_720":"0","cf_721":"0","cf_722":"","cf_723":"","cf_724":"","cf_725":"","cf_726":false,"cf_727":"","cf_728":"","cf_729":"one","cf_730":"oneone","cf_731":"oneoneone","cf_732[]":"","bill_street":"","ship_street":"","bill_pobox":"","ship_pobox":"","bill_city":"","ship_city":"","bill_state":"","ship_state":"","bill_code":"","ship_code":"","bill_country":"","ship_country":"","description":""}', $current_user);
	}
}
?>