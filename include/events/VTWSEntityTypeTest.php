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
require_once 'include/events/VTWSEntityType.inc';

use PHPUnit\Framework\TestCase;

class VTWSEntityTypeTest extends TestCase {

	/**
	 * Method testVTWSEntityType
	 * @test
	 */
	public function testVTWSEntityType() {
		global $current_user;
		$current_user = Users::getActiveAdminUser();
		$setype = 'Potentials';
		$et = new VTWSEntityType($setype, $current_user);
		$this->assertInstanceOf(VTWSEntityType::class, $et, 'testConstruct class VTWSEntityType');
		$this->assertEquals($setype, $et->getModuleName(), 'ModuleName');
		$this->assertEquals(getTabid($setype), $et->getTabId(), 'tabid');
		$fieldnames = array(
			0 => 'potentialname',
			1 => 'potential_no',
			2 => 'related_to',
			3 => 'amount',
			4 => 'opportunity_type',
			5 => 'closingdate',
			6 => 'leadsource',
			7 => 'nextstep',
			8 => 'assigned_user_id',
			9 => 'sales_stage',
			10 => 'campaignid',
			11 => 'probability',
			12 => 'modifiedtime',
			13 => 'createdtime',
			14 => 'modifiedby',
			15 => 'forecast_amount',
			16 => 'email',
			17 => 'isconvertedfromlead',
			18 => 'convertedfromlead',
			19 => 'created_user_id',
			20 => 'description',
			21 => 'id',
		);
		$this->assertEquals($fieldnames, $et->getFieldNames(), 'FieldNames');
		$ftypes = $et->getFieldTypes();
		$this->assertInstanceOf(VTWSFieldType::class, $ftypes['potential_no'], 'potential_no VTWSFieldType');
		$this->assertEquals(array('type' => 'Number', 'format' => 'Decimal', 'values' => null, 'relatedTo' => null), $ftypes['amount']->toArray(), 'FieldType toArray');
		$this->assertEquals($ftypes['potential_no']->type, $et->getFieldType('potential_no')->type, 'FieldType potential_no');
		$this->assertEquals('String', $et->getFieldType('potential_no')->type, 'FieldType potential_no');
		$this->assertEquals(array('type' => 'String', 'values' => null, 'relatedTo' => null, 'format' => null), (array)$ftypes['potential_no'], 'FieldType ToArray');
		$this->assertInstanceOf(VTWSFieldType::class, $ftypes['amount'], 'amount');
		$this->assertEquals($ftypes['amount']->type, $et->getFieldType('amount')->type, 'FieldType amount');
		$this->assertEquals('String', $et->getFieldType('potential_no')->type, 'FieldType potential_no');
		$this->assertEquals('Number', $et->getFieldType('amount')->type, 'FieldType amount');
		$this->assertEquals('Decimal', $et->getFieldType('amount')->format, 'FieldFormat amount');
		$this->assertEquals(array('type' => 'Number','format'=>'Decimal', 'values' => null, 'relatedTo' => null), (array)$ftypes['amount'], 'FieldType ToArray');
		$flabels = $et->getFieldLabels();
		$fieldlabels = array(
			'potentialname' => 'Opportunity Name',
			'potential_no' => 'Opportunity No',
			'amount' => 'Amount',
			'related_to' => 'Related To',
			'closingdate' => 'Expected Close Date',
			'opportunity_type' => 'Type',
			'nextstep' => 'Next Step',
			'leadsource' => 'Lead Source',
			'sales_stage' => 'Sales Stage',
			'assigned_user_id' => 'Assigned To',
			'probability' => 'Probability',
			'campaignid' => 'Campaign Source',
			'createdtime' => 'Created Time',
			'modifiedtime' => 'Modified Time',
			'modifiedby' => 'Last Modified By',
			'forecast_amount' => 'Forecast Amount',
			'email' => 'Email',
			'isconvertedfromlead' => 'Is Converted From Lead',
			'convertedfromlead' => 'Converted From Lead',
			'created_user_id' => 'Created By',
			'description' => 'Description',
			'id' => 'potentialid',
		);
		$this->assertEquals($fieldlabels, $flabels, 'FieldLabels EN');
		$et->fieldLabels = null;
		$this->assertEquals($fieldlabels['amount'], $et->getFieldLabel('amount'), 'FieldLabel amount EN');
		$this->assertEquals($fieldlabels['leadsource'], $et->getFieldLabel('leadsource'), 'FieldLabel leadsource EN');
		$etacc = VTWSEntityType::forUser('Accounts', $current_user);
		$this->assertInstanceOf(VTWSEntityType::class, $etacc, 'testConstruct class VTWSEntityType with static');
		$this->assertEquals('Accounts', $etacc->getModuleName(), 'ModuleName');
		$this->assertEquals('String', $etacc->getFieldType('account_no')->type, 'FieldType account_no');
		$this->assertEquals('Number', $etacc->getFieldType('employees')->type, 'FieldType employees');
		$this->assertEquals('Integer', $etacc->getFieldType('employees')->format, 'FieldFormat employees');
		$this->assertEquals('Url', $etacc->getFieldType('website')->type, 'FieldType website');
		$this->assertEquals('Phone', $etacc->getFieldType('phone')->type, 'FieldType Phone');
		$this->assertEquals('Time', $etacc->getFieldType('cf_728')->type, 'FieldType Time');
		$this->assertEquals('Select', $etacc->getFieldType('cf_732')->type, 'FieldType Multipicklist');
		$this->assertEquals('Skype', $etacc->getFieldType('cf_727')->type, 'FieldType Skype');
		$etusr = VTWSEntityType::usingGlobalCurrentUser('Users');
		$this->assertInstanceOf(VTWSEntityType::class, $etusr, 'testConstruct class VTWSEntityType with static');
		$this->assertEquals('Users', $etusr->getModuleName(), 'ModuleName');
	}
}
?>