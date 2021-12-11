<?php
/*************************************************************************************************
 * Copyright 2021 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

class CustomFieldUtilTest extends TestCase {

	/**
	 * Method getCustomFieldTypeNameProvider
	 */
	public function getCustomFieldTypeNameProvider() {
		return array(
			array(1, 'Text'),
			array(2, 'Text'),
			array(55, ''),
			array(255, ''),
			array(7, 'Number'),
			array(9, 'Percent'),
			array(5, 'Date'),
			array(23, 'Date'),
			array(13, 'Email'),
			array(11, 'Phone'),
			array(15, 'PickList'),
			array(17, 'LBL_URL'),
			array(56, 'LBL_CHECK_BOX'),
			array(71, 'Currency'),
			array(21, 'LBL_TEXT_AREA'),
			array(19, 'LBL_TEXT_AREA'),
			array(33, 'LBL_MULTISELECT_COMBO'),
			array(85, 'Skype'),
			array(185, ''),
			array(99, ''),
			array(0, ''),
			array('', ''),
			array('whatever', ''),
		);
	}

	/**
	 * Method testgetCustomFieldTypeName
	 * @test
	 * @dataProvider getCustomFieldTypeNameProvider
	 */
	public function testgetCustomFieldTypeName($uitype, $expected) {
		global $mod_strings;
		$mod_strings = return_module_language('en_us', 'Settings');
		$this->assertEquals(
			$expected=='' ? '' : $mod_strings[$expected],
			getCustomFieldTypeName($uitype),
			'getCustomFieldTypeName '.$uitype
		);
	}

	/**
	 * Method getCustomFieldArrayProvider
	 */
	public function getCustomFieldArrayProvider() {
		return array(
			array('Accounts', array(
				'cf_718' => 0,
				'cf_719' => 1,
				'cf_720' => 2,
				'cf_721' => 3,
				'cf_722' => 4,
				'cf_723' => 5,
				'cf_724' => 6,
				'cf_725' => 7,
				'cf_726' => 8,
				'cf_727' => 9,
				'cf_728' => 10,
				'cf_729' => 11,
				'cf_730' => 12,
				'cf_731' => 13,
				'cf_732' => 14,
			)),
			array('Assets', array()),
			array('evvtgendoc', array()),
			array('', array()),
			array('whatever', array()),
		);
	}

	/**
	 * Method testgetCustomFieldArray
	 * @test
	 * @dataProvider getCustomFieldArrayProvider
	 */
	public function testgetCustomFieldArray($module, $expected) {
		$this->assertEquals($expected, getCustomFieldArray($module), 'getCustomFieldArray '.$module);
	}

	/**
	 * Method getCustomFieldDataProvider
	 */
	public function getCustomFieldDataProvider() {
		return array(
			array(6, 22, 'tablename', 'vtiger_crmentity'),
			array(6, 22, 'columnname', 'modifiedtime'),
			array(6, 24, 'tablename', 'vtiger_accountbillads'),
			array(22, 404, 'tablename', 'vtiger_salesorder'),
			array(22, 404, 'fieldname', 'hdnSubTotal'),
			array(22, 4, 'fieldname', ''),
		);
	}

	/**
	 * Method testgetCustomFieldData
	 * @test
	 * @dataProvider getCustomFieldDataProvider
	 */
	public function testgetCustomFieldData($tab, $id, $datatype, $expected) {
		$this->assertEquals($expected, getCustomFieldData($tab, $id, $datatype), 'getCustomFieldData');
	}

	/**
	 * Method getCustomFieldTableInfoProvider
	 */
	public function getCustomFieldTableInfoProvider() {
		return array(
			array('Accounts', array('vtiger_accountscf', 'accountid')),
			array('Assets', array('vtiger_assetscf', 'assetsid')),
			array('Contacts', array('vtiger_contactscf', 'contactid')),
			array('cbCredentials', array('vtiger_cbcredentialscf', 'cbcredentialsid')),
			array('evvtgendoc', array()),
			array('whatever', array()),
			array('', array()),
		);
	}

	/**
	 * Method testgetCustomFieldTableInfo
	 * @test
	 * @dataProvider getCustomFieldTableInfoProvider
	 */
	public function testgetCustomFieldTableInfo($module, $expected) {
		$this->assertEquals($expected, getCustomFieldTableInfo($module), 'getCustomFieldTableInfo '.$module);
	}

	/**
	 * Method getListLeadMappingProvider
	 */
	public function getListLeadMappingProvider() {
		return array(
			array(1, array(
				'accountlabel' => 'Organization Name',
				'contactlabel' => '',
				'potentiallabel' => 'Opportunity Name',
			)),
			array(7, array(
				'accountlabel' => 'Email',
				'contactlabel' => 'Email',
				'potentiallabel' => '',
			)),
			array(20, array(
				'accountlabel' => 'Shipping PO Box',
				'contactlabel' => '',
				'potentiallabel' => '',
			)),
			array(27, array(
				'accountlabel' => '',
				'contactlabel' => 'Secondary Email',
				'potentiallabel' => '',
			)),
			array(9999, array()),
			array(0, array()),
			array('whatever', array()),
			array('', array()),
		);
	}

	/**
	 * Method testgetListLeadMapping
	 * @test
	 * @dataProvider getListLeadMappingProvider
	 */
	public function testgetListLeadMapping($cfid, $expected) {
		$this->assertEquals(
			$expected,
			getListLeadMapping($cfid),
			'getListLeadMapping '.$cfid
		);
	}
}
