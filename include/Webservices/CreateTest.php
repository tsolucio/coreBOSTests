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
	var $usrdota0x = 5; // testdmy
	var $usrcomd0x = 6; // testmdy
	var $usrdotd3com = 7; // testymd
	var $usrcoma3dot = 10; // testtz
	var $usrdota3comdollar = 12; // testmcurrency

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
		$ObjectValues['expectedrevenue'] = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['budgetcost'] = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['actualcost'] = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['actualroi'] = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['expectedroi'] = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['createdtime'] = $actual['createdtime'];
		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
		$this->assertEquals($ObjectValues, $actual,'Test currency usrdota0x Correct');
		/////////////////
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
		$ObjectValues['expectedrevenue'] = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['budgetcost'] = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['actualcost'] = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['actualroi'] = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['expectedroi'] = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['createdtime'] = $actual['createdtime'];
		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
		$this->assertEquals($ObjectValues, $actual,'Test currency usrcoma3dot Correct');
		/////////////////
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
		$ObjectValues['expectedrevenue'] = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['budgetcost'] = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['actualcost'] = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['actualroi'] = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['expectedroi'] = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['createdtime'] = $actual['createdtime'];
		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
		$this->assertEquals($ObjectValues, $actual,'Test currency usrcomd0x Correct');
		/////////////////
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
		$ObjectValues['expectedrevenue'] = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['budgetcost'] = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['actualcost'] = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['actualroi'] = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['expectedroi'] = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['createdtime'] = $actual['createdtime'];
		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
		$this->assertEquals($ObjectValues, $actual,'Test currency usrdotd3com Correct');
		/////////////////
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
		$ObjectValues['expectedrevenue'] = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['budgetcost'] = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['actualcost'] = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['actualroi'] = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['expectedroi'] = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$ObjectValues['createdtime'] = $actual['createdtime'];
		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
		$this->assertEquals($ObjectValues, $actual,'Test currency usrdota3comdollar Correct');
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
		$this->assertEquals($ObjectValues, $actual,'Test d-m-Y Correct');
		///  m-d-Y
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
		$this->assertEquals($ObjectValues, $actual,'Test m-d-Y Correct');
		///  Y-m-d
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
		$this->assertEquals($ObjectValues, $actual,'Test Y-m-d Correct');
		/// end
		$current_user = $holduser;
	}

	/**
	 * Method testCreateWithDatesWrong
	 * As of August 2017 these creates do not work anymore.
	 * Now they fail which I think is better than creating the records with incorrect date values.
	 */
// 	public function testCreateWithDatesWrong() {
// 		global $current_user;
// 		$holduser = $current_user;
// 		$user = new Users();
// 		///  d-m-Y
// 		$user->retrieveCurrentUserInfoFromFile(6); // testmdy
// 		$current_user = $user;
// 		$Module = 'Assets';
// 		$cbUserID = '19x'.$current_user->id;
// 		$ObjectValues = array(
// 			'product'=>'14x2618',
// 			'serialnumber'=>'123456789',
// 			'datesold'=>'25-12-2015',  // dmY
// 			'dateinservice'=>'25-12-2015',  // dmY
// 			'assetstatus' => 'In Service',
// 			'tagnumber' => 'tag1',
// 			'invoiceid' => '7x2993',
// 			'shippingmethod' => 'direct',
// 			'shippingtrackingnumber' => '321654',
// 			'assigned_user_id' => $cbUserID,
// 			'created_user_id' => $cbUserID,
// 			'assetname' => 'wfasset',
// 			'account' => '11x174',
// 			'modifiedby' => $cbUserID,
// 			'description' => 'áçèñtös',
// 		);
// 		$actual = vtws_create($Module, $ObjectValues, $current_user);
// 		$ObjectValues['asset_no'] = $actual['asset_no'];
// 		$ObjectValues['id'] = $actual['id'];
// 		$ObjectValues['datesold'] = $ObjectValues['dateinservice'] = '';
// 		$ObjectValues['createdtime'] = $actual['createdtime'];
// 		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
// 		$this->assertEquals($ObjectValues, $actual,'Test d-m-Y Wrong');
// 		///  m-d-Y
// 		$user->retrieveCurrentUserInfoFromFile(5); // testdmy
// 		$current_user = $user;
// 		$Module = 'Assets';
// 		$cbUserID = '19x'.$current_user->id;
// 		$ObjectValues = array(
// 			'product'=>'14x2618',
// 			'serialnumber'=>'123456789',
// 			'datesold'=>'12-25-2015',  // m-d-Y
// 			'dateinservice'=>'12-25-2015',  // m-d-Y
// 			'assetstatus' => 'In Service',
// 			'tagnumber' => 'tag1',
// 			'invoiceid' => '7x2993',
// 			'shippingmethod' => 'direct',
// 			'shippingtrackingnumber' => '321654',
// 			'assigned_user_id' => $cbUserID,
// 			'created_user_id' => $cbUserID,
// 			'assetname' => 'wfasset',
// 			'account' => '11x174',
// 			'modifiedby' => $cbUserID,
// 			'description' => 'áçèñtös',
// 		);
// 		$actual = vtws_create($Module, $ObjectValues, $current_user);
// 		$ObjectValues['asset_no'] = $actual['asset_no'];
// 		$ObjectValues['id'] = $actual['id'];
// 		$ObjectValues['datesold'] = $ObjectValues['dateinservice'] = '';
// 		$ObjectValues['createdtime'] = $actual['createdtime'];
// 		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
// 		$this->assertEquals($ObjectValues, $actual,'Test m-d-Y Wrong');
// 		///  Y-m-d
// 		$user->retrieveCurrentUserInfoFromFile(5); // testdmy
// 		$current_user = $user;
// 		$Module = 'Assets';
// 		$cbUserID = '19x'.$current_user->id;
// 		$ObjectValues = array(
// 			'product'=>'14x2618',
// 			'serialnumber'=>'123456789',
// 			'datesold'=>'2015-12-25',  // Y-m-d
// 			'dateinservice'=>'2015-12-25',  // Y-m-d
// 			'assetstatus' => 'In Service',
// 			'tagnumber' => 'tag1',
// 			'invoiceid' => '7x2993',
// 			'shippingmethod' => 'direct',
// 			'shippingtrackingnumber' => '321654',
// 			'assigned_user_id' => $cbUserID,
// 			'created_user_id' => $cbUserID,
// 			'assetname' => 'wfasset',
// 			'account' => '11x174',
// 			'modifiedby' => $cbUserID,
// 			'description' => 'áçèñtös',
// 		);
// 		$actual = vtws_create($Module, $ObjectValues, $current_user);
// 		$ObjectValues['asset_no'] = $actual['asset_no'];
// 		$ObjectValues['id'] = $actual['id'];
// 		$ObjectValues['createdtime'] = $actual['createdtime'];
// 		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
// 		$this->assertEquals($ObjectValues, $actual,'Test Y-m-d Wrong');
// 		/// end
// 		$current_user = $holduser;
// 	}

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
		$this->assertEquals($ObjectValues, $actual,'Create with relation to helpdesk');
		list($void,$assetid) = explode('x', $actual['id']);
		$rels = $adb->pquery('select * from vtiger_crmentityrel where crmid=? and module=? and relcrmid=? and relmodule=?',
			array($assetid,'Assets','2637','HelpDesk'));
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
		$this->assertEquals($ObjectValues, $actual,'Create salesorder');
		/// end
		$current_user = $holduser;
	}

	/**
	 * Method testCreateDocumentWithAttachment
	 * @test
	 */
	public function testCreateDocumentWithAttachment() {
		global $current_user,$adb;
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
			'filesize'=>$model_filename['size'],
			'fileversion'=>'2',
			'filelocationtype'=>'I',
			'filedownloadcount'=> '0',
			'filestatus'=> '1',
			'folderid' => '22x1',
			'notecontent' => 'áçèñtös',
			'modifiedby' => $cbUserID,
		);
		//$this->expectException('WebServiceException');
		$actual = vtws_create($Module, $ObjectValues, $current_user);
		$ObjectValues['note_no'] = $actual['note_no'];
		$ObjectValues['id'] = $actual['id'];
		$ObjectValues['createdtime'] = $actual['createdtime'];
		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
		unset($ObjectValues['filename']);
		$this->assertEquals($ObjectValues, $actual,'Create Documents');
		$sdoc = vtws_retrievedocattachment($actual['id'], true, $current_user);
		$this->assertEquals($model_filename['content'], $sdoc[$actual['id']]['attachment'],'Document Attachment');
		/// end
		$current_user = $holduser;
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
		$actual = vtws_create($Module, $ObjectValues, $current_user);
		/// end
		$current_user = $holduser;
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
		$actual = vtws_create($Module, $ObjectValues, $current_user);
		/// end
		$current_user = $holduser;
	}

}
?>