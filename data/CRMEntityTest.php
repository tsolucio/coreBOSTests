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
use PHPUnit\Framework\TestCase;

class testCRMEntity extends TestCase {

	public $testrecords = array(
		'Potentials' => array(
			'crmid' => 5138,
			'wsid' => '13x5138',
			'cbuuid' => 'fc8623c17e5710570af29bedda8f044988742c8c',
		),
		'Accounts' => array(
			'crmid' => 74,
			'wsid' => '11x74',
			'cbuuid' => 'b0857db0c1dee95300a10982853f5fb1d4e981c1',
		),
		'Contacts' => array(
			'crmid' => 1084,
			'wsid' => '12x1084',
			'cbuuid' => 'a609725772dc91ad733b19e4100cf68bb30195d1',
		),
		'Vendors' => array(
			'crmid' => 2216,
			'wsid' => '2x2216',
			'cbuuid' => '37421220f3791680f7330903973cf93350133564',
		),
		'Leads' => array(
			'crmid' => 4196,
			'wsid' => '10x4196',
			'cbuuid' => 'e7eeeceff12bfdbcf008565bea4bf7da208431cb',
		),
		'HelpDesk' => array(
			'crmid' => 2636,
			'wsid' => '17x2636',
			'cbuuid' => '0f0cadb035d9b1d6e053ebaece544df9abd73912',
		),
		'Products' => array(
			'crmid' => 2617,
			'wsid' => '14x2617',
			'cbuuid' => '0a3c5c965d2c42e246349fee0e919ef22f4c80d3',
		),
		'Quotes' => array(
			'crmid' => 11815,
			'wsid' => '4x11815',
			'cbuuid' => 'b34a8837bbe3119eb2c39c184a6d800e6d84e722',
		),
		'PriceBooks' => array(
			'crmid' => 16829,
			'wsid' => '8x16829',
			'cbuuid' => '9e0519cb84180edba2d798d83836ec41e7600dd0',
		),
	);

	/**
	 * Method testConstruct
	 * @test
	 */
	public function testConstruct() {
		$crmentity = CRMEntity::getInstance('Accounts');
		$this->assertInstanceOf(CRMEntity::class, $crmentity, 'testConstruct');
	}

	/**
	 * Method testbuildSearchQueryForFieldTypes
	 * @test
	 */
	public function testbuildSearchQueryForFieldTypes() {
		$crmentity = CRMEntity::getInstance('Accounts');
		$actual = $crmentity->buildSearchQueryForFieldTypes(11, '123-654-987');
		$expected = "select crmid as id, phone,fax,otherphone,cf_724, accountname as name  FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid AND deleted = 0  INNER JOIN vtiger_accountscf on vtiger_account.accountid = vtiger_accountscf.accountid WHERE phone = '123-654-987' OR fax = '123-654-987' OR otherphone = '123-654-987' OR cf_724 = '123-654-987'";
		$this->assertEquals($expected, $actual, 'testbuildSearchQueryForFieldTypes account phone');
		$actual = $crmentity->buildSearchQueryForFieldTypes(56, '1');
		$expected = "select crmid as id, emailoptout,notify_owner,cf_726,isconvertedfromlead, accountname as name  FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid AND deleted = 0  INNER JOIN vtiger_accountscf on vtiger_account.accountid = vtiger_accountscf.accountid WHERE emailoptout = '1' OR notify_owner = '1' OR cf_726 = '1' OR isconvertedfromlead = '1'";
		$this->assertEquals($expected, $actual, 'testbuildSearchQueryForFieldTypes account checkbox');
	}

	/**
	 * Method testgetUUID
	 * @test
	 */
	public function testgetUUID() {
		$crmentity = CRMEntity::getInstance('Accounts');
		$crmentity->column_fields['record_module'] = 'setype';
		$crmentity->column_fields['record_id'] = 'crmid';
		$crmentity->column_fields['created_user_id'] = 'smcreatorid';
		$crmentity->column_fields['assigned_user_id'] = 'smownerid';
		$crmentity->column_fields['createdtime'] = 'createdtime';
		$actual = $crmentity->getUUID();
		$expected = '83802810bcf89c1027461dc29312ae9ce9e9de0e';
		$this->assertEquals($expected, $actual, 'getUUID test 1');
		$crmentity->column_fields['record_module'] = 'setypeC';
		$crmentity->column_fields['record_id'] = 'crmid';
		$crmentity->column_fields['created_user_id'] = 'smcreatorid';
		$crmentity->column_fields['assigned_user_id'] = 'smownerid';
		$crmentity->column_fields['createdtime'] = 'createdtime';
		$actual = $crmentity->getUUID();
		$expected = '1dafedd6346ad999aa0106dedeb63c96d41a5e13';
		$this->assertEquals($expected, $actual, 'getUUID test 2');
	}

	/**
	 * Method testgetUUIDfromCRMIDandViceversa
	 * @test
	 */
	public function testgetUUIDfromCRMIDandViceversa() {
		foreach ($this->testrecords as $module => $values) {
			$actual = CRMEntity::getUUIDfromCRMID($values['crmid']);
			$this->assertEquals($values['cbuuid'], $actual, 'getUUIDfromCRMID '.$module);
			$actual = CRMEntity::getCRMIDfromUUID($values['cbuuid']);
			$this->assertEquals($values['crmid'], $actual, 'getCRMIDfromUUID '.$module);
		}
		$actual = CRMEntity::getUUIDfromCRMID('');
		$this->assertEquals('', $actual, 'getUUIDfromCRMID Empty');
		$actual = CRMEntity::getCRMIDfromUUID('');
		$this->assertEquals('', $actual, 'getCRMIDfromUUID Empty');
	}

	/**
	 * Method testgetUUIDfromWSIDandViceversa
	 * @test
	 */
	public function testgetUUIDfromWSIDandViceversa() {
		foreach ($this->testrecords as $module => $values) {
			$actual = CRMEntity::getUUIDfromWSID($values['wsid']);
			$this->assertEquals($values['cbuuid'], $actual, 'getUUIDfromWSID '.$module);
			$actual = CRMEntity::getWSIDfromUUID($values['cbuuid']);
			$this->assertEquals($values['wsid'], $actual, 'getWSIDfromUUID '.$module);
		}
		$actual = CRMEntity::getUUIDfromWSID('21x2');
		$this->assertEquals('', $actual, 'getUUIDfromWSID Currency');
		$actual = CRMEntity::getUUIDfromWSID('19x5');
		$this->assertEquals('', $actual, 'getUUIDfromWSID User');
		$actual = CRMEntity::getUUIDfromWSID('20x3');
		$this->assertEquals('', $actual, 'getUUIDfromWSID Group');
		$actual = CRMEntity::getUUIDfromWSID('22x2');
		$this->assertEquals('', $actual, 'getUUIDfromWSID Document Folder');
		$actual = CRMEntity::getUUIDfromWSID('');
		$this->assertEquals('', $actual, 'getUUIDfromWSID Empty');
		$actual = CRMEntity::getWSIDfromUUID('');
		$this->assertEquals('', $actual, 'getWSIDfromUUID Empty');
	}
}
