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

use PHPUnit\Framework\TestCase;

class WSCreateTest extends TestCase {

	/****
	 * TEST Users decimal configuration
	 * name format is: {decimal_separator}{symbol_position}{grouping}{grouping_symbol}{currency}
	 ****/
	public $usrdota0x = 5; // testdmy
	public $usrcomd0x = 6; // testmdy
	public $usrdotd3com = 7; // testymd
	public $usrcoma3dot = 10; // testtz
	public $usrdota3comdollar = 12; // testmcurrency

	/**
	 * Method testCreateWithCurrencyCorrect
	 * @test
	 */
	public function testCreateWithCurrencyCorrect() {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		$testcurrency = 12345.6743218;
		///////////
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x); // testdmy
		$current_user = $user;
		$Module = 'Campaigns';
		$cbUserID = '19x'.$current_user->id;
		$ObjectValues = array(
			'campaignname'=>'wfcpg-usrdota0x',
			'campaigntype' => 'Referral Program',
			'product_id'=>'14x2618',
			'campaignstatus' => 'Planning',
			'closingdate'=>'25-12-2015',
			'assigned_user_id' => $cbUserID,
			'created_user_id' => $cbUserID,
			'numsent'=>'2015',
			'sponsor' => 'Trade Show',
			'targetaudience' => 'Visitors',
			'targetsize' => '2200',
			'expectedresponse' => 'Good',
			'expectedrevenue'=>$testcurrency,
			'budgetcost'=>$testcurrency,
			'actualcost'=>$testcurrency,
			'actualroi'=>$testcurrency,
			'expectedroi'=>$testcurrency,
			'expectedresponsecount'=>'1234',
			'expectedsalescount'=>'234',
			'actualresponsecount'=>'2123',
			'actualsalescount'=>'1674',
			'modifiedby' => $cbUserID,
			'description' => 'áçèñtös',
		);
		$actual = vtws_create($Module, $ObjectValues, $current_user);
		$ObjectValues['campaign_no'] = $actual['campaign_no'];
		$ObjectValues['id'] = $actual['id'];
		$ObjectValues['closingdate'] = '2015-12-25';
		$ObjectValues['expectedrevenue'] = round($testcurrency, CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['budgetcost'] = round($testcurrency, CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['actualcost'] = round($testcurrency, CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['actualroi'] = round($testcurrency, CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['expectedroi'] = round($testcurrency, CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['createdtime'] = $actual['createdtime'];
		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
		$ObjectValues['cbuuid'] = CRMEntity::getUUIDfromWSID($actual['id']);
		$this->assertEquals($ObjectValues, $actual, 'Test currency usrdota0x Correct');
		/////////////////
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrcoma3dot); // testtz
		$current_user = $user;
		$Module = 'Campaigns';
		$cbUserID = '19x'.$current_user->id;
		$ObjectValues = array(
			'campaignname'=>'wfcpg-usrcoma3dot',
			'campaigntype' => 'Referral Program',
			'product_id'=>'14x2618',
			'campaignstatus' => 'Planning',
			'closingdate'=>'2015-12-25',
			'assigned_user_id' => $cbUserID,
			'created_user_id' => $cbUserID,
			'numsent'=>'2015',
			'sponsor' => 'Trade Show',
			'targetaudience' => 'Visitors',
			'targetsize' => '2200',
			'expectedresponse' => 'Good',
			'expectedrevenue'=>'12.345,6743218',
			'budgetcost'=>'12.345,6743218',
			'actualcost'=>'12.345,6743218',
			'actualroi'=>'12.345,6743218',
			'expectedroi'=>'12.345,6743218',
			'expectedresponsecount'=>'1234',
			'expectedsalescount'=>'234',
			'actualresponsecount'=>'2123',
			'actualsalescount'=>'1674',
			'modifiedby' => $cbUserID,
			'description' => 'áçèñtös',
		);
		$actual = vtws_create($Module, $ObjectValues, $current_user);
		$ObjectValues['campaign_no'] = $actual['campaign_no'];
		$ObjectValues['id'] = $actual['id'];
		$ObjectValues['closingdate'] = '2015-12-25';
		$ObjectValues['expectedrevenue'] = round($testcurrency, CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['budgetcost'] = round($testcurrency, CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['actualcost'] = round($testcurrency, CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['actualroi'] = round($testcurrency, CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['expectedroi'] = round($testcurrency, CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['createdtime'] = $actual['createdtime'];
		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
		$ObjectValues['cbuuid'] = CRMEntity::getUUIDfromWSID($actual['id']);
		$this->assertEquals($ObjectValues, $actual, 'Test currency usrcoma3dot Correct');
		/////////////////
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrcomd0x); // testmdy
		$current_user = $user;
		$Module = 'Campaigns';
		$cbUserID = '19x'.$current_user->id;
		$ObjectValues = array(
			'campaignname'=>'wfcpg-usrcomd0x',
			'campaigntype' => 'Referral Program',
			'product_id'=>'14x2618',
			'campaignstatus' => 'Planning',
			'closingdate'=>'12-25-2015',
			'assigned_user_id' => $cbUserID,
			'created_user_id' => $cbUserID,
			'numsent'=>'2015',
			'sponsor' => 'Trade Show',
			'targetaudience' => 'Visitors',
			'targetsize' => '2200',
			'expectedresponse' => 'Good',
			'expectedrevenue'=>'12345,6743218',
			'budgetcost'=>'12345,6743218',
			'actualcost'=>'12345,6743218',
			'actualroi'=>'12345,6743218',
			'expectedroi'=>'12345,6743218',
			'expectedresponsecount'=>'1234',
			'expectedsalescount'=>'234',
			'actualresponsecount'=>'2123',
			'actualsalescount'=>'1674',
			'modifiedby' => $cbUserID,
			'description' => 'áçèñtös',
		);
		$actual = vtws_create($Module, $ObjectValues, $current_user);
		$ObjectValues['campaign_no'] = $actual['campaign_no'];
		$ObjectValues['id'] = $actual['id'];
		$ObjectValues['closingdate'] = '2015-12-25';
		$ObjectValues['expectedrevenue'] = round($testcurrency, CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['budgetcost'] = round($testcurrency, CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['actualcost'] = round($testcurrency, CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['actualroi'] = round($testcurrency, CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['expectedroi'] = round($testcurrency, CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['createdtime'] = $actual['createdtime'];
		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
		$ObjectValues['cbuuid'] = CRMEntity::getUUIDfromWSID($actual['id']);
		$this->assertEquals($ObjectValues, $actual, 'Test currency usrcomd0x Correct');
		/////////////////
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrdotd3com); // testymd
		$current_user = $user;
		$Module = 'Campaigns';
		$cbUserID = '19x'.$current_user->id;
		$ObjectValues = array(
			'campaignname'=>'wfcpg-usrdotd3com',
			'campaigntype' => 'Referral Program',
			'product_id'=>'14x2618',
			'campaignstatus' => 'Planning',
			'closingdate'=>'2015-12-25',
			'assigned_user_id' => $cbUserID,
			'created_user_id' => $cbUserID,
			'numsent'=>'2015',
			'sponsor' => 'Trade Show',
			'targetaudience' => 'Visitors',
			'targetsize' => '2200',
			'expectedresponse' => 'Good',
			'expectedrevenue'=>'12,345.6743218',
			'budgetcost'=>'12,345.6743218',
			'actualcost'=>'12,345.6743218',
			'actualroi'=>'12,345.6743218',
			'expectedroi'=>'12,345.6743218',
			'expectedresponsecount'=>'1234',
			'expectedsalescount'=>'234',
			'actualresponsecount'=>'2123',
			'actualsalescount'=>'1674',
			'modifiedby' => $cbUserID,
			'description' => 'áçèñtös',
		);
		$actual = vtws_create($Module, $ObjectValues, $current_user);
		$ObjectValues['campaign_no'] = $actual['campaign_no'];
		$ObjectValues['id'] = $actual['id'];
		$ObjectValues['closingdate'] = '2015-12-25';
		$ObjectValues['expectedrevenue'] = round($testcurrency, CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['budgetcost'] = round($testcurrency, CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['actualcost'] = round($testcurrency, CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['actualroi'] = round($testcurrency, CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['expectedroi'] = round($testcurrency, CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['createdtime'] = $actual['createdtime'];
		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
		$ObjectValues['cbuuid'] = CRMEntity::getUUIDfromWSID($actual['id']);
		$this->assertEquals($ObjectValues, $actual, 'Test currency usrdotd3com Correct');
		/////////////////
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrdota3comdollar); // testmcurrency
		$current_user = $user;
		$Module = 'Campaigns';
		$cbUserID = '19x'.$current_user->id;
		$ObjectValues = array(
			'campaignname'=>'wfcpg-usrdota3comdollar',
			'campaigntype' => 'Referral Program',
			'product_id'=>'14x2618',
			'campaignstatus' => 'Planning',
			'closingdate'=>'12-25-2015',
			'assigned_user_id' => $cbUserID,
			'created_user_id' => $cbUserID,
			'numsent'=>'2015',
			'sponsor' => 'Trade Show',
			'targetaudience' => 'Visitors',
			'targetsize' => '2200',
			'expectedresponse' => 'Good',
			'expectedrevenue'=>'13,580.24175398', // dollars at 1.1 conversion rate
			'budgetcost'=>'13,580.24175398',
			'actualcost'=>'13,580.24175398',
			'actualroi'=>'13,580.24175398',
			'expectedroi'=>'13,580.24175398',
			'expectedresponsecount'=>'1234',
			'expectedsalescount'=>'234',
			'actualresponsecount'=>'2123',
			'actualsalescount'=>'1674',
			'modifiedby' => $cbUserID,
			'description' => 'áçèñtös',
		);
		$actual = vtws_create($Module, $ObjectValues, $current_user);
		$ObjectValues['campaign_no'] = $actual['campaign_no'];
		$ObjectValues['id'] = $actual['id'];
		$ObjectValues['closingdate'] = '2015-12-25';
		$ObjectValues['expectedrevenue'] = round($testcurrency, CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['budgetcost'] = round($testcurrency, CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['actualcost'] = round($testcurrency, CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['actualroi'] = round($testcurrency, CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['expectedroi'] = round($testcurrency, CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['createdtime'] = $actual['createdtime'];
		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
		$ObjectValues['cbuuid'] = CRMEntity::getUUIDfromWSID($actual['id']);
		$this->assertEquals($ObjectValues, $actual, 'Test currency usrdota3comdollar Correct');
		/// end
		$current_user = $holduser;
	}


	/**
	 * Method testCreateWithDatesCorrect
	 * @test
	 */
	public function testCreateWithDatesCorrect() {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		///  d-m-Y
		$user->retrieveCurrentUserInfoFromFile(5); // testdmy
		$current_user = $user;
		$Module = 'Assets';
		$cbUserID = '19x'.$current_user->id;
		$ObjectValues = array(
			'product'=>'14x2618',
			'serialnumber'=>'123456789',
			'datesold'=>'25-12-2015',
			'dateinservice'=>'25-12-2015',
			'assetstatus' => 'In Service',
			'tagnumber' => 'tag1',
			'invoiceid' => '7x2993',
			'shippingmethod' => 'direct',
			'shippingtrackingnumber' => '321654',
			'assigned_user_id' => $cbUserID,
			'created_user_id' => $cbUserID,
			'assetname' => 'wfasset-testdmy',
			'account' => '11x174',
			'modifiedby' => $cbUserID,
			'description' => 'áçèñtös',
		);
		$actual = vtws_create($Module, $ObjectValues, $current_user);
		$ObjectValues['asset_no'] = $actual['asset_no'];
		$ObjectValues['id'] = $actual['id'];
		$ObjectValues['datesold'] = '2015-12-25';
		$ObjectValues['dateinservice'] = '2015-12-25';
		$ObjectValues['createdtime'] = $actual['createdtime'];
		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
		$ObjectValues['cbuuid'] = CRMEntity::getUUIDfromWSID($actual['id']);
		$this->assertEquals($ObjectValues, $actual, 'Test d-m-Y Correct');
		///  m-d-Y
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(6); // testmdy
		$current_user = $user;
		$Module = 'Assets';
		$cbUserID = '19x'.$current_user->id;
		$ObjectValues = array(
			'product'=>'14x2618',
			'serialnumber'=>'123456789',
			'datesold'=>'12-25-2015',
			'dateinservice'=>'12-25-2015',
			'assetstatus' => 'In Service',
			'tagnumber' => 'tag1',
			'invoiceid' => '7x2993',
			'shippingmethod' => 'direct',
			'shippingtrackingnumber' => '321654',
			'assigned_user_id' => $cbUserID,
			'created_user_id' => $cbUserID,
			'assetname' => 'wfasset-testmdy',
			'account' => '11x174',
			'modifiedby' => $cbUserID,
			'description' => 'áçèñtös',
		);
		$actual = vtws_create($Module, $ObjectValues, $current_user);
		$ObjectValues['asset_no'] = $actual['asset_no'];
		$ObjectValues['id'] = $actual['id'];
		$ObjectValues['datesold'] = '2015-12-25';
		$ObjectValues['dateinservice'] = '2015-12-25';
		$ObjectValues['createdtime'] = $actual['createdtime'];
		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
		$ObjectValues['cbuuid'] = CRMEntity::getUUIDfromWSID($actual['id']);
		$this->assertEquals($ObjectValues, $actual, 'Test m-d-Y Correct');
		///  Y-m-d
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(7); // testymd
		$current_user = $user;
		$Module = 'Assets';
		$cbUserID = '19x'.$current_user->id;
		$ObjectValues = array(
			'product'=>'14x2618',
			'serialnumber'=>'123456789',
			'datesold'=>'2015-12-25',
			'dateinservice'=>'2015-12-25',
			'assetstatus' => 'In Service',
			'tagnumber' => 'tag1',
			'invoiceid' => '7x2993',
			'shippingmethod' => 'direct',
			'shippingtrackingnumber' => '321654',
			'assigned_user_id' => $cbUserID,
			'created_user_id' => $cbUserID,
			'assetname' => 'wfasset-testymd',
			'account' => '11x174',
			'modifiedby' => $cbUserID,
			'description' => 'áçèñtös',
		);
		$actual = vtws_create($Module, $ObjectValues, $current_user);
		$ObjectValues['asset_no'] = $actual['asset_no'];
		$ObjectValues['id'] = $actual['id'];
		$ObjectValues['createdtime'] = $actual['createdtime'];
		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
		$ObjectValues['cbuuid'] = CRMEntity::getUUIDfromWSID($actual['id']);
		$this->assertEquals($ObjectValues, $actual, 'Test Y-m-d Correct');
		/// end
		$current_user = $holduser;
	}

	/**
	 * Method testCreateWithDatesWrong
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testCreateWithDatesWrong() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$DATABASEQUERYERROR);
		$Module = 'Assets';
		$cbUserID = '19x'.$current_user->id;
		$ObjectValues = array(
			'product'=>'14x2618',
			'serialnumber'=>'123456789',
			'datesold'=>'25-12-2015',  // dmY
			'dateinservice'=>'25-12-2015',  // dmY
			'assetstatus' => 'In Service',
			'tagnumber' => 'tag1',
			'invoiceid' => '7x2993',
			'shippingmethod' => 'direct',
			'shippingtrackingnumber' => '321654',
			'assigned_user_id' => $cbUserID,
			'created_user_id' => $cbUserID,
			'assetname' => 'wfasset',
			'account' => '11x174',
			'modifiedby' => $cbUserID,
			'description' => 'áçèñtös',
		);
		vtws_create($Module, $ObjectValues, $current_user);
	}

	/**
	 * Method testCreateWithRelation
	 * @test
	 */
	public function testCreateWithRelation() {
		global $current_user,$adb;
		$holduser = $current_user;
		$user = new Users();
		///  Y-m-d
		$user->retrieveCurrentUserInfoFromFile(7); // testymd
		$current_user = $user;
		$Module = 'Assets';
		$cbUserID = '19x'.$current_user->id;
		$ObjectValues = array(
			'product'=>'14x2618',
			'serialnumber'=>'123456789',
			'datesold'=>'2015-12-25',  // Y-m-d
			'dateinservice'=>'2015-12-25',  // Y-m-d
			'assetstatus' => 'In Service',
			'tagnumber' => 'tag1',
			'invoiceid' => '7x2993',
			'shippingmethod' => 'direct',
			'shippingtrackingnumber' => '321654',
			'assigned_user_id' => $cbUserID,
			'created_user_id' => $cbUserID,
			'assetname' => 'wfasset-related',
			'account' => '11x174',
			'modifiedby' => $cbUserID,
			'description' => 'áçèñtös',
			'relations' => array('17x2637'),
		);
		$actual = vtws_create($Module, $ObjectValues, $current_user);
		unset($ObjectValues['relations']);
		$ObjectValues['asset_no'] = $actual['asset_no'];
		$ObjectValues['id'] = $actual['id'];
		$ObjectValues['createdtime'] = $actual['createdtime'];
		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
		$ObjectValues['cbuuid'] = CRMEntity::getUUIDfromWSID($actual['id']);
		$this->assertEquals($ObjectValues, $actual, 'Create with relation to helpdesk');
		list($void,$assetid) = explode('x', $actual['id']);
		$rels = $adb->pquery(
			'select * from vtiger_crmentityrel where crmid=? and module=? and relcrmid=? and relmodule=?',
			array($assetid,'Assets','2637','HelpDesk')
		);
		$this->assertEquals(1, $adb->num_rows($rels), 'Asset-HelpDesk related');
		///////////////  cbuuid
		$ObjectValues = array(
			'product'=>'668d624d92e450119f769142036e7e235ec030c7',
			'serialnumber'=>'123456789',
			'datesold'=>'2015-12-25',  // Y-m-d
			'dateinservice'=>'2015-12-25',  // Y-m-d
			'assetstatus' => 'In Service',
			'tagnumber' => 'tag1',
			'invoiceid' => '94eecf43924619e49ef9afbeddcb9c69cbda2dd8',
			'shippingmethod' => 'direct',
			'shippingtrackingnumber' => '321654',
			'assigned_user_id' => $cbUserID,
			'created_user_id' => $cbUserID,
			'assetname' => 'wfasset-related',
			'account' => '29518def3b1c45c25c3803691f79b8de93205888',
			'modifiedby' => $cbUserID,
			'description' => 'áçèñtös',
			'relations' => array('8bd86b7bbb66f4af297ada68b5b8200cbf825d74'),
		);
		$actual = vtws_create($Module, $ObjectValues, $current_user);
		unset($ObjectValues['relations']);
		$ObjectValues['asset_no'] = $actual['asset_no'];
		$ObjectValues['id'] = $actual['id'];
		$ObjectValues['createdtime'] = $actual['createdtime'];
		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
		$ObjectValues['cbuuid'] = CRMEntity::getUUIDfromWSID($actual['id']);
		$ObjectValues['product'] = '14x2618';
		$ObjectValues['invoiceid'] = '7x2993';
		$ObjectValues['account'] = '11x174';
		$this->assertEquals($ObjectValues, $actual, 'Create with relation to helpdesk');
		list($void,$assetid) = explode('x', $actual['id']);
		$rels = $adb->pquery(
			'select * from vtiger_crmentityrel where crmid=? and module=? and relcrmid=? and relmodule=?',
			array($assetid,'Assets','2637','HelpDesk')
		);
		$this->assertEquals(1, $adb->num_rows($rels), 'Asset-HelpDesk related');
		/// end
		$current_user = $holduser;
	}

	/**
	 * Method testCreateInventoryModule
	 * @test
	 */
	public function testCreateInventoryModule() {
		global $current_user,$adb;
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(7); // testymd
		$current_user = $user;
		$Module = 'SalesOrder';
		$cbUserID = '19x'.$current_user->id;
		$ObjectValues = array(
			'assigned_user_id' => $cbUserID,
			'created_user_id' => $cbUserID,
			'subject' => 'REST invoiceSubject',
			'bill_city' => 'Drachten',
			'bill_code' => '9205BB',
			'bill_country' => 'Netherlands',
			'bill_pobox' => '',
			'bill_state' => 'áçèñtös',
			'bill_street' => 'schuur 86',
			'carrier' => '',
			'contact_id' => '',
			'conversion_rate' => '1.000',
			'currency_id' => '21x1',
			'customerno' => '',
			'description' => 'Producten in deze verkooporder: 2 X Heart of David - songbook 2',
			'duedate' => '2014-11-06',
			'enable_recurring' => '0',
			'end_period' => '',
			'exciseduty' => '0.000',
			'invoicestatus' => 'Approved',
			'payment_duration' => '',
			'pending' => '',
			'potential_id' => '',
			'vtiger_purchaseorder' => '',
			'quote_id' => '',
			'recurring_frequency' => '',
			'salescommission' => '0.000',
			'ship_city' => 'schuur 86',
			'ship_code' => '9205BB',
			'ship_country' => 'Netherlands',
			'ship_pobox' => '',
			'ship_state' => '',
			'ship_street' => 'Drachten',
			'account_id' => '11x174',
			'sostatus' => 'Approved',
			'start_period' => '',
			'salesorder_no' => '',
			'terms_conditions' => '',
			'modifiedby' => $cbUserID,
			'discount_type_final' => 'percentage',  //  zero/amount/percentage
			'hdnDiscountAmount' => '20.000000',  // only used if 'discount_type_final' == 'amount'
			'hdnDiscountPercent' => '10.000',  // only used if 'discount_type_final' == 'percentage'
			'shipping_handling_charge' => 15,
			'shtax1' => 0,   // apply this tax, MUST exist in the application with this internal taxname
			'shtax2' => 8,   // apply this tax, MUST exist in the application with this internal taxname
			'shtax3' => 0,   // apply this tax, MUST exist in the application with this internal taxname
			'adjustmentType' => 'add',  //  none/add/deduct
			'adjustment' => '40.000',
			'taxtype' => 'group',  // group or individual  taxes are obtained from the application
			'invoiced' => 0,
			'pdoInformation' => array(
			  array(
				"productid"=>2618,
				"comment"=>'cmt1',
				"qty"=>1,
				"listprice"=>10,
				'discount'=>0,  // 0 no discount, 1 discount
				"discount_type"=>0,  //  amount/percentage
				"discount_percentage"=>0,  // not needed nor used if type is amount
				"discount_amount"=>0,  // not needed nor used if type is percentage
			  ),
			  array(
				"productid"=>2619,
				"qty"=>2,
				"comment"=>'cmt2',
				"listprice"=>10,
				'discount'=>1,
				"discount_type"=>'percentage',  //  amount/percentage
				"discount_percentage"=>2,
				"discount_amount"=>0
			  ),
			),
		);
		$_FILES=array();
		$actual = vtws_create($Module, $ObjectValues, $current_user);
		$ObjectValues['salesorder_no'] = $actual['salesorder_no'];
		$ObjectValues['id'] = $actual['id'];
		$ObjectValues['invoicestatus'] = '';
		unset($ObjectValues['shtax1']);
		unset($ObjectValues['shtax2']);
		unset($ObjectValues['shtax3']);
		unset($ObjectValues['adjustmentType']);
		unset($ObjectValues['adjustment']);
		unset($ObjectValues['taxtype']);
		unset($ObjectValues['discount_type_final']);
		unset($ObjectValues['shipping_handling_charge']);
		unset($ObjectValues['pdoInformation']);
		$ObjectValues['createdtime'] = $actual['createdtime'];
		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
		$ObjectValues['txtAdjustment'] = '40.000000';
		$ObjectValues['hdnGrandTotal'] = '90.030000';
		$ObjectValues['hdnSubTotal'] = '29.600000';
		$ObjectValues['hdnTaxType'] = 'group';
		$ObjectValues['hdnS_H_Amount'] = '15.000000';
		$ObjectValues['tandc'] = '';
		$ObjectValues['pl_gross_total'] = '30.000000';
		$ObjectValues['pl_dto_line'] = '0.400000';
		$ObjectValues['pl_dto_total'] = '3.360000';
		$ObjectValues['pl_dto_global'] = '2.960000';
		$ObjectValues['pl_net_total'] = '26.640000';
		$ObjectValues['sum_nettotal'] = '29.600000';
		$ObjectValues['sum_taxtotal'] = '7.192800';
		$ObjectValues['sum_tax1'] = '1.198800';
		$ObjectValues['sum_taxtotalretention'] = '0.000000';
		$ObjectValues['sum_tax2'] = '2.664000';
		$ObjectValues['pl_sh_total'] = '15.000000';
		$ObjectValues['sum_tax3'] = '3.330000';
		$ObjectValues['pl_sh_tax'] = '1.200000';
		$ObjectValues['pl_grand_total'] = '90.030000';
		$ObjectValues['pl_adjustment'] = '40.000000';
		$ObjectValues['cbuuid'] = CRMEntity::getUUIDfromWSID($actual['id']);
		$this->assertEquals($ObjectValues, $actual, 'Create salesorder');
		/// end
		$current_user = $holduser;
	}

	/**
	 * Method testCreateEmailWithAttachment
	 * @test
	 */
	public function testCreateEmailWithAttachment() {
		global $current_user,$adb;
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(7); // testymd
		$current_user = $user;
		$Module = 'Emails';
		$cbUserID = '19x'.$current_user->id;
		// get file and file information
		// if you are using PHP 5.2 (!) you need to install finfo via PECL
		$finfo = finfo_open(FILEINFO_MIME); // return mime type ala mimetype extension.
		$filename = 'themes/images/Cron.png';
		$mtype = finfo_file($finfo, $filename);
		$model_filename=array(
			'name'=>basename($filename),  // no slash nor paths in the name
			'size'=>filesize($filename),
			'type'=>$mtype,
			'content'=>base64_encode(file_get_contents($filename))
		);
		$ObjectValues = array(
			'assigned_user_id' => $cbUserID,
			'date_start' => '2020-03-03',
			'time_start' => '22:22',
			'files'=>array($model_filename),
			'from_email'=>'email@domain.tld',
			'parent_type'=> 'Accounts',
			'saved_toid'=> 'julieta@yahoo.com,felix_hirpara@cox.net,lina@yahoo.com',
			'activitytype' => 'Emails',
			'subject' => 'áçèñtös',
			'ccmail' => 'noemail@domain.tld',
			'related' => array('12x1084', '11x74'), // 'parent_id' => '1084@80|74@9|',
			'email_flag' => 'SENT',
			'bccmail' => '',
			'access_count' => '',
			'modifiedby' => '19x7',
			'spamreport' => '1',
			'bounce' => '0',
			'clicked' => '0',
			'delivered' => '0',
			'dropped' => '0',
			'open' => '2',
			'unsubscribe' => '0',
			'description' => 'This is the body of the email áçèñtös.',
			'filename' => '',
		);
		$email = $ObjectValues;
		$_FILES=array();
		$actual = vtws_create($Module, $ObjectValues, $current_user);
		$ObjectValues['id'] = $actual['id'];
		$ObjectValues['parent_id'] = '12x1084|11x74';
		$ObjectValues['saved_toid'] = '["julieta@yahoo.com","felix_hirpara@cox.net","lina@yahoo.com"]';
		$ObjectValues['ccmail'] = '["noemail@domain.tld"]';
		$ObjectValues['bccmail'] = '[""]';
		$ObjectValues['replyto'] = 'noreply@tsolucio.com';
		$ObjectValues['createdtime'] = $actual['createdtime'];
		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
		$ObjectValues['cbuuid'] = CRMEntity::getUUIDfromWSID($actual['id']);
		unset($ObjectValues['files'], $ObjectValues['related']);
		$this->assertEquals($ObjectValues, $actual, 'Create Email');
		$sdoc = vtws_retrieve($actual['id'], $current_user);
		$expected = $ObjectValues;
		$expected['parent_idename'] = array(
			'12x1084' => array(
				'module' => 'Contacts',
				'reference' => 'Lina Schwiebert',
				'cbuuid' => 'a609725772dc91ad733b19e4100cf68bb30195d1',
			),
			'11x74' => array(
				'module' => 'Accounts',
				'reference' => 'Chemex Labs Ltd',
				'cbuuid' => 'b0857db0c1dee95300a10982853f5fb1d4e981c1',
			),
		);
		$expected['modifiedbyename'] = array(
			'module' => 'Users',
			'reference' => 'cbTest testymd',
			'cbuuid' => '',
		);
		$expected['assigned_user_idename'] = array(
			'module' => 'Users',
			'reference' => 'cbTest testymd',
			'cbuuid' => '',
		);
		$expected['relations'] = array();
		$this->assertEquals($expected, $sdoc, 'Email Retrieve');
		$email['subject'] = 'áçèñtös UPDATED';
		$email['id'] = $actual['id'];
		$email['spamreport'] = $expected['spamreport'] = '2';
		$email['bounce'] = $expected['bounce'] = '2';
		$email['clicked'] = $expected['clicked'] = '4';
		$email['modifiedby'] = $expected['modifiedby'] = '19x5';
		$expected['modifiedbyename']['reference'] = 'cbTest testdmy';
		$actual = vtws_update($email, $current_user);
		unset($actual['modifiedtime'], $expected['modifiedtime']);
		$this->assertEquals($expected, $actual, 'Email after Update');
		/// end
		$current_user = $holduser;
	}

	/**
	 * Method testCreateDocumentWithAttachment
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testCreateDocumentWithAttachment() {
		global $current_user, $site_URL;
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(7); // testymd
		$current_user = $user;
		$Module = 'Documents';
		$cbUserID = '19x'.$current_user->id;
		// get file and file information
		// if you are using PHP 5.2 (!) you need to install finfo via PECL
		$finfo = finfo_open(FILEINFO_MIME); // return mime type ala mimetype extension.
		$filename = 'themes/images/Cron.png';
		$mtype = finfo_file($finfo, $filename);
		$model_filename=array(
			'name'=>basename($filename),  // no slash nor paths in the name
			'size'=>filesize($filename),
			'type'=>$mtype,
			'content'=>base64_encode(file_get_contents($filename))
		);
		$ObjectValues = array(
			'assigned_user_id' => $cbUserID,
			'created_user_id' => $cbUserID,
			'notes_title' => 'REST Test create doc',
			'filename'=>$model_filename,
			'filetype'=>$model_filename['type'],
			'filesize'=> (string)$model_filename['size'],
			'fileversion'=>'2',
			'filelocationtype'=>'I',
			'filedownloadcount'=> '0',
			'filestatus'=> '1',
			'folderid' => '22x1',
			'notecontent' => 'áçèñtös',
			'modifiedby' => $cbUserID,
			'template' => '0',
			'template_for' => '',
			'mergetemplate' => '0',
		);
		//$this->expectException('WebServiceException');
		$_FILES=array();
		$actual = vtws_create($Module, $ObjectValues, $current_user);
		$ObjectValues['note_no'] = $actual['note_no'];
		$ObjectValues['id'] = $actual['id'];
		$ObjectValues['createdtime'] = $actual['createdtime'];
		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
		$ObjectValues['cbuuid'] = CRMEntity::getUUIDfromWSID($actual['id']);
		$ObjectValues['filename'] = 'Cron.png';
		$ObjectValues['relations'] = array();
		$ObjectValues['_downloadurl'] = $actual['_downloadurl']; // 'http://localhost/coreBOSTest/storage/2020/June/week3/44181_Cron.png';
		$filelocation = substr($actual['_downloadurl'], strpos($actual['_downloadurl'], 'storage'));
		$docid = $actual['id'];
		$this->assertRegExp('/^'.str_replace('/', '\\/', $site_URL).'\/storage.+\/week[0-5]?\/[0-9]+_Cron.png$/', $actual['_downloadurl']);
		$this->assertEquals($ObjectValues, $actual, 'Create Documents');
		$sdoc = vtws_retrievedocattachment($actual['id'], true, $current_user);
		$this->assertEquals($model_filename['content'], $sdoc[$actual['id']]['attachment'], 'Document Attachment');
		$sdoc = vtws_retrieve($actual['id'], $current_user);
		unset($sdoc['note_no'], $sdoc['modifiedtime'], $sdoc['_downloadurl']);
		$expected = array(
			'notes_title' => 'REST Test create doc',
			'folderid' => '22x1',
			'assigned_user_id' => '19x7',
			'createdtime' => $actual['createdtime'],
			'modifiedby' => '19x7',
			'created_user_id' => '19x7',
			'template' => '0',
			'template_for' => '',
			'mergetemplate' => '0',
			'notecontent' => 'áçèñtös',
			'filelocationtype' => 'I',
			'filestatus' => '1',
			'filesize' => '5271',
			'filetype' => 'image/png; charset=binary',
			'fileversion' => '2',
			'filedownloadcount' => '1',
			'id' => $actual['id'],
			'cbuuid' => $actual['cbuuid'],
			'relations' => array(),
			'filename' => 'Cron.png',
			'folderidename' => array(
				'module' => 'DocumentFolders',
				'reference' => 'Default',
				'cbuuid' => '',
			),
			'modifiedbyename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testymd',
				'cbuuid' => '',
			),
			'created_user_idename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testymd',
				'cbuuid' => '',
			),
			'assigned_user_idename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testymd',
				'cbuuid' => '',
			),
		);
		$this->assertEquals($expected, $sdoc, 'Document Retrieve');
		$sdoc['notes_title'] = $expected['notes_title'] = 'REST Test create doc UPDATED';
		$actual = vtws_update($sdoc, $current_user);
		unset($actual['note_no'], $actual['modifiedtime'], $actual['_downloadurl']);
		$this->assertEquals($expected, $actual, 'Document after Update');
		/// end
		$current_user = $holduser;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		@unlink($filelocation);
		vtws_retrievedocattachment($docid, true, $current_user);
	}

	/**
	 * Method testCreateHelpDeskWithAttachment
	 * @test
	 */
	public function testCreateHelpDeskWithAttachment() {
		global $current_user,$adb, $log;
		$current_user = Users::getActiveAdminUser();
		$Module = 'HelpDesk';
		$cbUserID = '19x'.$current_user->id;
		// empty cache
		$webserviceObject = VtigerWebserviceObject::fromName($adb, 'HelpDesk');
		$handlerPath = $webserviceObject->getHandlerPath();
		require_once $handlerPath;
		$handler = new VtigerModuleOperation($webserviceObject, $current_user, $adb, $log);
		$handler->emptyCache();
		unset(VTCacheUtils::$_fieldinfo_cache[13], VTCacheUtils::$_module_columnfields_cache[$Module]);
		// We are going to take the long way around here
		// we need HelpDesk to have an image field and we want to test the default picklist value (a picklist with no value in element but with a default value in the database)
		// so we are going to test the vtlib CRUD on fields and blocks here
		// we add an image field to the HelpDesk module
		$modhd = Vtiger_Module::getInstance($Module);
		$blkhd = Vtiger_Block::getInstance('LBL_BLOCK_TEST', $modhd);
		if ($blkhd) {
			// already there so we delete it
			$blkhd->delete(true);
		}
		$fldhd = Vtiger_Field::getInstance('hdimage', $modhd);
		if ($fldhd) {
			// already there so we delete it
			$fldhd->delete(true);
		}
		unset(VTCacheUtils::$_fieldinfo_cache[13], VTCacheUtils::$_module_columnfields_cache[$Module]);
		$hdBlocksBeforeAdding = Vtiger_Block::getAllForModule($modhd);
		$hdColsBeforeAdding = array_keys(getColumnFields($Module));
		$blkhd = new Vtiger_Block();
		$blkhd->label = 'LBL_BLOCK_TEST';
		$modhd->addBlock($blkhd);
		$hdBlocksAfterAdding = Vtiger_Block::getAllForModule($modhd);
		$expected = $hdBlocksBeforeAdding;
		$expected[] = $blkhd;
		$this->assertEquals($expected, $hdBlocksAfterAdding, 'Create Block');
		$fieldInstance = new Vtiger_Field();
		$fieldInstance->name = 'hdimage';
		$fieldInstance->label = 'hdimage';
		$fieldInstance->columntype = 'varchar(103)';
		$fieldInstance->uitype = 69;
		$fieldInstance->displaytype = 1;
		$fieldInstance->typeofdata = 'V~O';
		$fieldInstance->quickcreate = 0;
		$blkhd->addField($fieldInstance);
		$expected = $hdColsBeforeAdding;
		$expected[] = 'hdimage';
		unset(VTCacheUtils::$_fieldinfo_cache[13], VTCacheUtils::$_module_columnfields_cache[$Module]);
		$hdColsAfterAdding = array_keys(getColumnFields($Module));
		$this->assertEquals($expected, $hdColsAfterAdding, 'Create Field');
		// we update the priority field by adding a default value
		$adb->query("UPDATE vtiger_field SET defaultvalue='' where fieldid=158");
		$priorityBeforeUpdate = Vtiger_Field::getInstance(158, $modhd);
		$priorityBeforeUpdate->defaultvalue = 'High';
		$priorityBeforeUpdate->save();
		$priorityAfterUpdate = Vtiger_Field::getInstance(158, $modhd);
		$this->assertEquals($priorityBeforeUpdate, $priorityAfterUpdate, 'Update Field');
		$this->assertEquals('High', $priorityAfterUpdate->defaultvalue, 'Update Field');
		// now we have the field and default value we can test web service create

		// get file and file information
		$finfo = finfo_open(FILEINFO_MIME); // return mime type ala mimetype extension.
		$filename = 'themes/images/Cron.png';
		$mtype = finfo_file($finfo, $filename);
		$model_filename = array(
			'name'=>basename($filename),  // no slash nor paths in the name
			'size'=>filesize($filename),
			'type'=>$mtype,
			'content'=>base64_encode(file_get_contents($filename))
		);
		$ObjectValues = array(
			'assigned_user_id' => $cbUserID,
			'created_user_id' => $cbUserID,
			'modifiedby' => $cbUserID,
			'attachments'=>array('hdimage' => $model_filename),
			'ticket_title' => 'WS Create Test with attachment',
			'parent_id' => '11x74',
			'product_id' => '14x2618',
			//'ticketpriorities' => 'Urgent',  // test default picklist value
			'ticketstatus' => 'Open',
			'ticketseverities' => 'Major',
			'hours' => '31.000000',
			'ticketcategories' => 'Big Problem',
			'days' => '3',
			'from_portal' => '0',
			'commentadded' => '',
			'description' => 'Videamus animi partes, quarum est conspectus illustrior',
			'solution' => '',
		);
		$_FILES=array();
		unset(VTCacheUtils::$_fieldinfo_cache[13], VTCacheUtils::$_module_columnfields_cache[$Module]);
		$actual = vtws_create($Module, $ObjectValues, $current_user);
		$ObjectValues['ticket_no'] = $actual['ticket_no'];
		$ObjectValues['assigned_user_id'] = '19x8';
		$ObjectValues['id'] = $actual['id'];
		$ObjectValues['createdtime'] = $actual['createdtime'];
		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
		$ObjectValues['cbuuid'] = CRMEntity::getUUIDfromWSID($actual['id']);
		$ObjectValues['ticketpriorities'] = 'High';
		$ObjectValues['hdimage'] = 'Cron.png';
		$ObjectValues['commentadded'] = '0';
		$ObjectValues['from_mailscanner'] = '0';
		$ObjectValues['email'] = 'lina@yahoo.com';
		$this->assertEquals('Ticket created. Assigned to user  Administrator -- ', substr($actual['update_log'], 0, 51), 'Create HelpDesk update log');
		$ObjectValues['update_log'] = $actual['update_log'];
		unset($ObjectValues['attachments']);
		$this->assertEquals($ObjectValues, $actual, 'Create HelpDesk');
		$shd = vtws_retrieve($actual['id'], $current_user);
		$ObjectValues['parent_idename'] = array(
			'module' => 'Accounts',
			'reference' => 'Chemex Labs Ltd',
			'cbuuid' => 'b0857db0c1dee95300a10982853f5fb1d4e981c1',
		);
		$ObjectValues['product_idename'] = array(
			'module' => 'Products',
			'reference' => 'Protective Case Cover for iPhone 6',
			'cbuuid' => '668d624d92e450119f769142036e7e235ec030c7',
		);
		$ObjectValues['modifiedbyename'] = array(
			'module' => 'Users',
			'reference' => ' Administrator',
			'cbuuid' => '',
		);
		$ObjectValues['created_user_idename'] = array(
			'module' => 'Users',
			'reference' => ' Administrator',
			'cbuuid' => '',
		);
		$ObjectValues['assigned_user_idename'] = array(
			'module' => 'Users',
			'reference' => 'cbTest testes',
			'cbuuid' => '',
		);
		$this->assertEquals('storage/20', substr($shd['hdimageimageinfo']['path'], 0, 10), 'Create HelpDesk image');
		$this->assertEquals('Cron.png', $shd['hdimageimageinfo']['name'], 'Create HelpDesk image');
		$this->assertEquals('_Cron.png', substr($shd['hdimageimageinfo']['fullpath'], -9), 'Create HelpDesk image');
		$this->assertEquals('image/png; charset=binary', $shd['hdimageimageinfo']['type'], 'Create HelpDesk image');
		$ObjectValues['hdimageimageinfo'] = $shd['hdimageimageinfo'];
		$this->assertEquals($ObjectValues, $shd, 'Create HelpDesk');
		///////////////////////////////////////////
		///////////////////////////////////////////
		// now we test with an Invalid/Insecure Image
		try {
			$filename = 'build/coreBOSTests/database/924495-agri90.png';
			$mtype = finfo_file($finfo, $filename);
			$model_filename = array(
				'name'=>basename($filename),  // no slash nor paths in the name
				'size'=>filesize($filename),
				'type'=>$mtype,
				'content'=>base64_encode(file_get_contents($filename))
			);
			$ObjectValues = array(
				'assigned_user_id' => $cbUserID,
				'created_user_id' => $cbUserID,
				'modifiedby' => $cbUserID,
				'attachments'=>array('hdimage' => $model_filename),
				'ticket_title' => 'WS Create Test with insecure attachment',
				'parent_id' => '11x74',
				'product_id' => '14x2618',
				//'ticketpriorities' => 'Urgent',  // test default picklist value
				'ticketstatus' => 'Open',
				'ticketseverities' => 'Major',
				'hours' => '31.000000',
				'ticketcategories' => 'Big Problem',
				'days' => '3',
				'from_portal' => '0',
				'commentadded' => '',
				'description' => 'Videamus animi partes, quarum est conspectus illustrior',
				'solution' => '',
			);
			$_FILES=array();
			unset(VTCacheUtils::$_fieldinfo_cache[13], VTCacheUtils::$_module_columnfields_cache[$Module]);
			vtws_create($Module, $ObjectValues, $current_user);
			$this->assertTrue(false);
		} catch (WebServiceException $e) {
			$this->assertEquals($e->code, WebServiceErrorCode::$VALIDATION_FAILED, 'Create HelpDesk insecure image exception');
			$this->assertEquals($e->message, getTranslatedString('LBL_IMAGESECURITY_ERROR'), 'Create HelpDesk insecure image exception');
		}
		///////////////////////////////////////////
		///////////////////////////////////////////
		// now we have to test the delete block and field API
		$fldhd = Vtiger_Field::getInstance('hdimage', $modhd);
		$fldhd->delete(true);
		$blkhd->delete(false);
		unset(VTCacheUtils::$_fieldinfo_cache[13], VTCacheUtils::$_module_columnfields_cache[$Module]);
		$hdColsAfterDeleting = array_keys(getColumnFields($Module));
		$hdBlocksAfterDeleting = Vtiger_Block::getAllForModule($modhd);
		$this->assertEqualsCanonicalizing($hdColsBeforeAdding, $hdColsAfterDeleting, 'Delete Field');
		$this->assertEqualsCanonicalizing($hdBlocksBeforeAdding, $hdBlocksAfterDeleting, 'Delete Block');
		$adb->query("UPDATE vtiger_field SET defaultvalue='' where fieldid=158");
		$handler->emptyCache();
	}

	/**
	 * Method testCreateExceptionNoWrite
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testCreateExceptionNoWrite() {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		///  nocreate
		$user->retrieveCurrentUserInfoFromFile(11); // nocreate
		$current_user = $user;
		$Module = 'Assets';
		$cbUserID = '19x'.$current_user->id;
		$ObjectValues = array(
			'product'=>'14x2618',
			'serialnumber'=>'123456789',
			'datesold'=>'25-12-2015',
			'dateinservice'=>'25-12-2015',
			'assetstatus' => 'In Service',
			'tagnumber' => 'tag1',
			'invoiceid' => '7x2993',
			'shippingmethod' => 'direct',
			'shippingtrackingnumber' => '321654',
			'assigned_user_id' => $cbUserID,
			'created_user_id' => $cbUserID,
			'assetname' => 'wfasset-testdmy',
			'account' => '11x174',
			'modifiedby' => $cbUserID,
			'description' => 'áçèñtös',
		);
		$_FILES=array();
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		try {
			vtws_create($Module, $ObjectValues, $current_user);
		} catch (\Throwable $th) {
			$current_user = $holduser;
			throw $th;
		}
	}

	/**
	 * Method testCreateExceptionNoPermission
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testCreateExceptionNoPermission() {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		///  nocreate
		$user->retrieveCurrentUserInfoFromFile(11); // nocreate
		$current_user = $user;
		$Module = 'cbTermConditions';
		$cbUserID = '19x'.$current_user->id;
		$ObjectValues = array(
			'reference'=>'create test',
			'formodule'=>'Invoice',
			'isdefault' => '0',
			'assigned_user_id' => $cbUserID,
			'created_user_id' => $cbUserID,
			'modifiedby' => $cbUserID,
			'tandc' => 'áçèñtös',
			'description' => 'áçèñtös',
		);
		$_FILES=array();
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		try {
			vtws_create($Module, $ObjectValues, $current_user);
		} catch (\Throwable $th) {
			$current_user = $holduser;
			throw $th;
		}
	}

	/**
	 * Method testCreateExceptionMissingMandatory
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testCreateExceptionMissingMandatory() {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		///  missing mandatory field
		$user->retrieveCurrentUserInfoFromFile(7); // testymd
		$current_user = $user;
		$Module = 'Assets';
		$cbUserID = '19x'.$current_user->id;
		$ObjectValues = array(
			'product'=>'14x2618',
			'serialnumber'=>'123456789',
			'datesold'=>'2015-12-25',
			'dateinservice'=>'2015-12-25',
			'assetstatus' => 'In Service',
			'tagnumber' => 'tag1',
			'invoiceid' => '7x2993',
			'shippingmethod' => 'direct',
			'shippingtrackingnumber' => '321654',
			'assigned_user_id' => $cbUserID,
			'created_user_id' => $cbUserID,
			'assetname' => 'wfasset-testymd',
			//'account' => '11x174',  // mandatory
			'modifiedby' => $cbUserID,
			'description' => 'áçèñtös',
		);
		$_FILES=array();
		$actual = vtws_create($Module, $ObjectValues, $current_user);
		/// end
		$current_user = $holduser;
	}

	/**
	 * Method testCreateExceptionWrongAsignedUserId
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testCreateExceptionWrongAsignedUserId() {
		global $current_user;
		$Module = 'Project';
		$cbUserID = '11x1084';
		$ObjectValues = array(
			'projectname'=>'Test WS Create',
			'assigned_user_id' => $cbUserID
		);
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$REFERENCEINVALID);
		vtws_create($Module, $ObjectValues, $current_user);
	}

	/**
	 * Method testCreateInventoryModuleTaxTypeIndividual
	 * @test
	 */
	public function testCreateInventoryModuleTaxTypeIndividual() {
		global $current_user,$adb;
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(7); // testymd
		$current_user = $user;
		$Module = 'SalesOrder';
		$cbUserID = '19x'.$current_user->id;
		$ObjectValues = array(
			'assigned_user_id' => $cbUserID,
			'created_user_id' => $cbUserID,
			'subject' => 'REST invoiceSubject',
			'bill_city' => 'Drachten',
			'bill_code' => '9205BB',
			'bill_country' => 'Netherlands',
			'bill_pobox' => '',
			'bill_state' => 'áçèñtös',
			'bill_street' => 'schuur 86',
			'carrier' => '',
			'contact_id' => '',
			'conversion_rate' => '1.000',
			'currency_id' => '21x1',
			'customerno' => '',
			'description' => 'Producten in deze verkooporder: 2 X Heart of David - songbook 2',
			'duedate' => '2014-11-06',
			'enable_recurring' => '0',
			'end_period' => '',
			'exciseduty' => '0.000',
			'invoicestatus' => 'Approved',
			'payment_duration' => '',
			'pending' => '',
			'potential_id' => '',
			'vtiger_purchaseorder' => '',
			'quote_id' => '',
			'recurring_frequency' => '',
			'salescommission' => '0.000',
			'ship_city' => 'schuur 86',
			'ship_code' => '9205BB',
			'ship_country' => 'Netherlands',
			'ship_pobox' => '',
			'ship_state' => '',
			'ship_street' => 'Drachten',
			'account_id' => '11x174',
			'sostatus' => 'Approved',
			'start_period' => '',
			'salesorder_no' => '',
			'terms_conditions' => '',
			'modifiedby' => $cbUserID,
			'discount_type_final' => 'percentage',  //  zero/amount/percentage
			'hdnDiscountAmount' => '20.000000',  // only used if 'discount_type_final' == 'amount'
			'hdnDiscountPercent' => '10.000',  // only used if 'discount_type_final' == 'percentage'
			'shipping_handling_charge' => 15,
			'shtax1' => 0,   // apply this tax, MUST exist in the application with this internal taxname
			'shtax2' => 8,   // apply this tax, MUST exist in the application with this internal taxname
			'shtax3' => 0,   // apply this tax, MUST exist in the application with this internal taxname
			'adjustmentType' => 'add',  //  none/add/deduct
			'adjustment' => '40.000',
			'taxtype' => 'individual',  // group or individual  taxes are obtained from the application
			'invoiced' => 0,
			'pdoInformation' => array(
			  array(
				"productid"=>2633,
				"comment"=>'cmt1',
				"qty"=>1,
				"listprice"=>10,
				'discount'=>0,  // 0 no discount, 1 discount
				"discount_type"=>0,  //  amount/percentage
				"discount_percentage"=>0,  // not needed nor used if type is amount
				"discount_amount"=>0,  // not needed nor used if type is percentage
			  ),
			  array(
				"productid"=>9752,
				"qty"=>2,
				"comment"=>'cmt2',
				"listprice"=>10,
				'discount'=>1,
				"discount_type"=>'percentage',  //  amount/percentage
				"discount_percentage"=>2,
				"discount_amount"=>0
			  ),
			),
		);
		$_FILES=array();
		$actual = vtws_create($Module, $ObjectValues, $current_user);
		$ObjectValues['salesorder_no'] = $actual['salesorder_no'];
		$ObjectValues['id'] = $actual['id'];
		$ObjectValues['invoicestatus'] = '';
		unset($ObjectValues['shtax1']);
		unset($ObjectValues['shtax2']);
		unset($ObjectValues['shtax3']);
		unset($ObjectValues['adjustmentType']);
		unset($ObjectValues['adjustment']);
		unset($ObjectValues['taxtype']);
		unset($ObjectValues['discount_type_final']);
		unset($ObjectValues['shipping_handling_charge']);
		unset($ObjectValues['pdoInformation']);
		$ObjectValues['createdtime'] = $actual['createdtime'];
		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
		$ObjectValues['txtAdjustment'] = '40.000000';
		$ObjectValues['hdnGrandTotal'] = '117.130000';
		$ObjectValues['hdnSubTotal'] = '67.700000';
		$ObjectValues['hdnTaxType'] = 'individual';
		$ObjectValues['hdnS_H_Amount'] = '15.000000';
		$ObjectValues['tandc'] = '';
		$ObjectValues['pl_gross_total'] = '30.000000';
		$ObjectValues['pl_dto_line'] = '0.400000';
		$ObjectValues['pl_dto_total'] = '7.170000';
		$ObjectValues['pl_dto_global'] = '6.770000';
		$ObjectValues['pl_net_total'] = '22.830000';
		$ObjectValues['sum_nettotal'] = '29.600000';
		$ObjectValues['sum_taxtotal'] = '37.592000';
		$ObjectValues['sum_tax1'] = '4.292000';
		$ObjectValues['sum_taxtotalretention'] = '0.000000';
		$ObjectValues['sum_tax2'] = '0.000000';
		$ObjectValues['pl_sh_total'] = '15.000000';
		$ObjectValues['sum_tax3'] = '33.300000';
		$ObjectValues['pl_sh_tax'] = '1.200000';
		$ObjectValues['pl_grand_total'] = '117.130000';
		$ObjectValues['pl_adjustment'] = '40.000000';
		$ObjectValues['cbuuid'] = CRMEntity::getUUIDfromWSID($actual['id']);
		$this->assertEquals($ObjectValues, $actual, 'Create salesorder');
		/// end
		// undo workflow
		$adb->pquery('update vtiger_service set website=? where serviceid=?', array('', 9752));
		$adb->pquery('update vtiger_crmentity set modifiedby=1 where crmid=?', array(9752));
		$adb->pquery('update vtiger_products set mfr_part_no=? where productid=?', array('', 2633));
		$current_user = $holduser;
	}
}
?>