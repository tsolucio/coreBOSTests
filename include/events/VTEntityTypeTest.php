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
class VTEntityTypeTest extends TestCase {

	/**
	 * Method testVTEntityType
	 * @test
	 */
	public function testVTEntityType() {
		global $current_user, $adb;
		$setype = 'Potentials';
		$et = new VTEntityType($adb,$setype);
		$this->assertInstanceOf(VTEntityType::class,$et,"testConstruct class VTEntityType");
		$this->assertEquals($setype, $et->getModuleName(), 'ModuleName');
		$this->assertEquals(getTabid($setype), $et->getTabId(), 'tabid');
		$fieldnames = array(
			0 => 'potentialname',
			1 => 'potential_no',
			2 => 'amount',
			3 => 'related_to',
			4 => 'closingdate',
			5 => 'opportunity_type',
			6 => 'nextstep',
			7 => 'leadsource',
			8 => 'sales_stage',
			9 => 'assigned_user_id',
			10 => 'probability',
			11 => 'campaignid',
			12 => 'createdtime',
			13 => 'modifiedtime',
			14 => 'modifiedby',
			15 => 'description',
			16 => 'forecast_amount',
			17 => 'email',
			18 => 'isconvertedfromlead',
			19 => 'convertedfromlead',
			20 => 'created_user_id',
		);
		$this->assertEquals($fieldnames, $et->getFieldNames(), 'FieldNames');
		$fieldtypes = array();
		$ftypes = $et->getFieldTypes();
		$this->assertInstanceOf(VTFieldType::class,$ftypes['potential_no'],"potential_no");
		$this->assertEquals($ftypes['potential_no']->type, $et->getFieldType('potential_no')->type, 'FieldType potential_no');
		$this->assertEquals('String', $et->getFieldType('potential_no')->type, 'FieldType potential_no');
		$this->assertEquals(array('type' => 'String'),(array)$ftypes['potential_no'],'FieldType ToArray');
		$this->assertInstanceOf(VTFieldType::class,$ftypes['amount'],"amount");
		$this->assertEquals($ftypes['amount']->type, $et->getFieldType('amount')->type, 'FieldType amount');
		$this->assertEquals('Number', $et->getFieldType('amount')->type, 'FieldType amount');
		$this->assertEquals(array('type' => 'Number'),(array)$ftypes['amount'],'FieldType ToArray');
		///////////////
		$setype = 'Invoice';
		$et = new VTEntityType($adb,$setype);
		$this->assertInstanceOf(VTEntityType::class,$et,"testConstruct class VTEntityType");
		$this->assertEquals($setype, $et->getModuleName(), 'ModuleName');
		$this->assertEquals(getTabid($setype), $et->getTabId(), 'tabid');
		$fieldnames = array(
			0 => 'subject',
			1 => 'salesorder_id',
			2 => 'customerno',
			3 => 'contact_id',
			4 => 'invoicedate',
			5 => 'duedate',
			6 => 'vtiger_purchaseorder',
			7 => 'txtAdjustment',
			8 => 'salescommission',
			9 => 'exciseduty',
			10 => 'hdnSubTotal',
			11 => 'hdnGrandTotal',
			12 => 'hdnTaxType',
			13 => 'hdnDiscountPercent',
			14 => 'hdnDiscountAmount',
			15 => 'hdnS_H_Amount',
			16 => 'account_id',
			17 => 'invoicestatus',
			18 => 'assigned_user_id',
			19 => 'createdtime',
			20 => 'modifiedtime',
			21 => 'modifiedby',
			22 => 'currency_id',
			23 => 'conversion_rate',
			24 => 'bill_street',
			25 => 'ship_street',
			26 => 'bill_city',
			27 => 'ship_city',
			28 => 'bill_state',
			29 => 'ship_state',
			30 => 'bill_code',
			31 => 'ship_code',
			32 => 'bill_country',
			33 => 'ship_country',
			34 => 'bill_pobox',
			35 => 'ship_pobox',
			36 => 'description',
			37 => 'terms_conditions',
			38 => 'invoice_no',
			39 => 'created_user_id',
			40 => 'tandc',
			41 => 'pl_gross_total',
			42 => 'pl_dto_line',
			43 => 'pl_dto_global',
			44 => 'pl_dto_total',
			45 => 'pl_net_total',
			46 => 'pl_sh_total',
			47 => 'pl_sh_tax',
			48 => 'pl_adjustment',
			49 => 'pl_grand_total',
			50 => 'sum_nettotal',
			51 => 'sum_tax1',
			52 => 'sum_tax2',
			53 => 'sum_tax3',
			54 => 'sum_taxtotal',
			55 => 'sum_taxtotalretention',
		);
		$this->assertEquals($fieldnames, $et->getFieldNames(), 'FieldNames');
		$fieldtypes = array();
		$ftypes = $et->getFieldTypes();
		$this->assertInstanceOf(VTFieldType::class,$ftypes['account_id'],"account_id");
		$this->assertEquals($ftypes['account_id']->type, $et->getFieldType('account_id')->type, 'FieldType account_id');
		$this->assertEquals('Related', $et->getFieldType('account_id')->type, 'FieldType account_id');
		$this->assertEquals('Accounts', $et->getFieldType('account_id')->relatedTo, 'FieldType account_id relatedTo');
	}

}
?>