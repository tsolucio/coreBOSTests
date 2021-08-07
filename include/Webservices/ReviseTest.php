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

include_once 'include/Webservices/Delete.php';

class ReviseTest extends TestCase {

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
	 * Method testReviseWithCheckboxes
	 * @test
	 */
	public function testReviseWithCheckboxes() {
		global $current_user, $adb;
		$holduser = $current_user;
		$user = new Users();
		///////////
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x); // testdmy
		$current_user = $user;
		$cbUserID = '19x'.$current_user->id;
		$ObjectValues = array(
			'salutationtype' => '',
			'firstname' => 'Lemuel',
			'contact_no' => 'CON58',
			'phone' => '631-748-6479',
			'lastname' => 'Latzke',
			'mobile' => '631-291-4976',
			'account_id' => '11x131',
			'homephone' => '',
			'leadsource' => 'Conference',
			'otherphone' => '',
			'title' => 'Director',
			'fax' => '',
			'department' => 'Manufacturing',
			'birthday' => '1973-04-03',
			'email' => 'lemuel.latzke@gmail.com',
			'contact_id' => '',
			'assistant' => '',
			'secondaryemail' => '',
			'assistantphone' => '',
			'donotcall' => '0',
			'emailoptout' => '0',
			'assigned_user_id' => '19x6',
			'reference' => '0',
			'notify_owner' => '0',
			'createdtime' => '2015-03-23 20:10:12',
			'modifiedtime' => '2016-03-25 01:28:44',
			'modifiedby' => '19x1',
			'isconvertedfromlead' => '',
			'convertedfromlead' => '',
			'created_user_id' => '19x1',
			'portal' => '0',
			'support_start_date' => '',
			'support_end_date' => '',
			'mailingstreet' => '70 Euclid Ave #722',
			'otherstreet' => '70 Euclid Ave #722',
			'mailingcity' => 'Bohemia',
			'othercity' => 'Bohemia',
			'mailingstate' => 'NY',
			'otherstate' => 'NY',
			'mailingzip' => '11716',
			'otherzip' => '11716',
			'mailingcountry' => 'United States of America',
			'othercountry' => 'United States of America',
			'mailingpobox' => '',
			'otherpobox' => '',
			'description' => ' Estne, quaeso, inquam, sitienti in bibendo voluptas? Duarum enim vitarum nobis erunt instituta capienda. Respondeat totidem verbis. Quod, inquit, quamquam voluptatibus quibusdam est saepe iucundius, tamen expetitur propter voluptatem. Duo Reges: constructio interrete. Nihilo magis. Miserum hominem! Si dolor summum malum est, dici aliter non potest. Nec lapathi suavitatem acupenseri Galloni Laelius anteponebat, sed suavitatem ipsam neglegebat; Dempta enim aeternitate nihilo beatior Iuppiter quam Epicurus; 

',
			'template_language' => '',
			'imagename' => '',
			'id' => '12x1150', // Contacts
			'cbuuid' => '64a07af78e8b56e8232e875daa23154a9afac000',
			'account_idename' => array(
				'module' => 'Accounts',
				'reference' => 'Computer Repair Service',
				'cbuuid' => 'c96bc3d37a773ddf9aa2e75b4ca02a25e5a356a4',
			),
			'modifiedbyename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testdmy',
				'cbuuid' => '',
			),
			'created_user_idename' => array(
				'module' => 'Users',
				'reference' => ' Administrator',
				'cbuuid' => '',
			),
			'assigned_user_idename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testmdy',
				'cbuuid' => '',
			),
			'portalpasswordtype' => '',
			'portalloginuser' => '',
		);
		$updateValues = array(
			'otherphone' => '123456789',
			'donotcall' => 0,
			'emailoptout' => 1,
			'reference' => '1',
			'notify_owner' => '0',
			'id' => '12x1150',
		);
		$_FILES = array();
		$actual = vtws_revise($updateValues, $current_user);
		$expected = $ObjectValues;
		$expected['otherphone'] = '123456789';
		$expected['donotcall'] = '0';
		$expected['emailoptout'] = '1';
		$expected['reference'] = '1';
		$expected['notify_owner'] = '0';
		$expected['modifiedtime'] = $actual['modifiedtime'];
		$expected['modifiedby'] = $actual['modifiedby'];
		$this->assertEquals($expected, $actual, 'Test checkbox usrdota0x Correct');
		$adb->pquery("update vtiger_contactsubdetails set otherphone='' where contactsubscriptionid=?", array(1150));
		$adb->pquery("update vtiger_contactdetails set donotcall='0', emailoptout='0', reference='0', notify_owner='0' where contactid=?", array(1150));
		/// end
		$current_user = $holduser;
	}

	/**
	 * Method testReviseMultiCurrencyTaxes
	 * @test
	 */
	public function testReviseMultiCurrencyTaxes() {
		global $current_user, $adb;
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrcomd0x); // testmdy
		$current_user = $user;
		$cbUserID = '19x'.$current_user->id;
		///////////  Services
		$ObjectValues = array(
			'servicename' => 'Grocery store',
			'service_no' => 'SER18',
			'service_usageunit' => 'Incidents',
			'discontinued' => '1',
			'qty_per_unit' => '7.00',
			'website' => '',
			'servicecategory' => 'Transportation',
			'assigned_user_id' => '19x5',
			'sales_start_date' => '2015-10-22',
			'sales_end_date' => '2016-04-27',
			'start_date' => '2016-04-09',
			'expiry_date' => '2016-06-30',
			'createdtime' => '2015-06-19 07:09:51',
			'modifiedtime' => '2019-03-03 21:40:36',
			'modifiedby' => '19x1',
			'created_user_id' => '19x1',
			'unit_price' => '37.400000',
			'commissionrate' => '5.000',
			'taxclass' => '',
			'cost_price' => '0.000000',
			'divisible' => '0',
			'cf_802' => '',
			'description' => 'Phasellus at augue id ante dictum cursus. Nunc mauris elit, dictum eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur dictum. Phasellus in felis. Nulla tempor augue ac ipsum. Phasellus vitae mauris sit amet lorem semper auctor. Mauris vel turpis. Aliquam adipiscing lobortis risus. In mi pede, nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque. Sed eget lacus. Mauris non dui nec urna suscipit nonummy. Fusce fermentum fermentum arcu. Vestibulum ante ipsum',
			'id' => '26x9727',
			'cbuuid' => '9d07d2d68cfbc68b8c855b58ee07faea8a5ed3fa',
			'modifiedbyename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testmdy',
				'cbuuid' => '',
			),
			'created_user_idename' => array(
				'module' => 'Users',
				'reference' => ' Administrator',
				'cbuuid' => '',
			),
			'assigned_user_idename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testdmy',
				'cbuuid' => '',
			),
		);
		$prePdoPrices = getPriceDetailsForProduct(9727, 3.89, 'available_associated', 'Services');
		$preTaxDetails = getTaxDetailsForProduct(9727, 'available_associated');
		$updateValues = array(
			'divisible' => '1',
			'commissionrate' => 22,
			'id' => '26x9727',
		);
		$_FILES = array();
		$actual = vtws_revise($updateValues, $current_user);
		$expected = $ObjectValues;
		$expected['divisible'] = '1';
		$expected['commissionrate'] = 22;
		$expected['modifiedtime'] = $actual['modifiedtime'];
		$expected['modifiedby'] = $actual['modifiedby'];
		$this->assertEquals($expected, $actual, 'Test Services usrcomd0x Correct');
		$postPdoPrices = getPriceDetailsForProduct(9727, 3.89, 'available_associated', 'Services');
		$postTaxDetails = getTaxDetailsForProduct(9727, 'available_associated');
		$this->assertEquals($prePdoPrices, $postPdoPrices, 'Test Services usrcomd0x Currency Correct');
		$this->assertEquals($preTaxDetails, $postTaxDetails, 'Test Services usrcomd0x Taxes Correct');
		$adb->pquery("update vtiger_service set divisible='0', commissionrate=5.0 where serviceid=?", array(9727));
		///////////  Products
		$ObjectValues = array(
			'productname' => 'Leagoo Lead 3s Mobile Phone',
			'product_no' => 'PRO18',
			'discontinued' => '1',
			'productcode' => '',
			'sales_start_date' => '2015-07-10',
			//'manufacturer' => 'AltvetPet Inc.', // this user does not have access to this field
			//'productcategory' => 'Software', // this user does not have access to this field
			'start_date' => '2012-12-31',
			'sales_end_date' => '2024-08-03',
			'expiry_date' => '2025-08-24',
			'vendor_id' => '2x2363',
			//'website' => '', // this user does not have access to this field
			//'vendor_part_no' => 'áçèñtös', // this user does not have access to this field
			'mfr_part_no' => '',
			'productsheet' => '',
			'serial_no' => '', // this user does not have access to this field
			'createdtime' => '2015-04-06 17:00:58',
			'glacct' => '302-Rental-Income',
			'modifiedtime' => '2019-02-21 22:12:55',
			'modifiedby' => '19x1',
			'created_user_id' => '19x1',
			'unit_price' => '223.000000',
			'commissionrate' => '0.000',
			'taxclass' => '',
			'cost_price' => '200.000000',
			'usageunit' => 'M',
			'qty_per_unit' => '0.00',
			'qtyinstock' => '6.000',
			'reorderlevel' => '0',
			'assigned_user_id' => '19x6',
			'qtyindemand' => '0',
			'divisible' => '0',
			'imagename' => '',
			'description' => 'Teneo, inquit, finem illi videri nihil dolere. Quonam modo? Sin te auctoritas commovebat, nobisne omnibus et Platoni ipsi nescio quem illum anteponebas? Cum praesertim illa perdiscere ludus esset.',
			'id' => '14x2633',
			'cbuuid' => '61221bff1c0ff171674aca18d81903db1afe0a41',
			'vendor_idename' => array(
				'module' => 'Vendors',
				'reference' => 'E Zaks & Co',
				'cbuuid' => 'ccfcc045d88404261dad730cf1aa0b11468ab89c',
			),
			'modifiedbyename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testmdy',
				'cbuuid' => '',
			),
			'created_user_idename' => array(
				'module' => 'Users',
				'reference' => ' Administrator',
				'cbuuid' => '',
			),
			'assigned_user_idename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testmdy',
				'cbuuid' => '',
			),
		);
		$prePdoPrices = getPriceDetailsForProduct(2633, 3.89, 'available_associated', 'Products');
		$preTaxDetails = getTaxDetailsForProduct(2633, 'available_associated');
		$updateValues = array(
			'productcode' => 'testthis',
			'productsheet' => 'productsheet',
			'serial_no' => '123456789',
			'id' => '14x2633',
		);
		$_FILES = array();
		$actual = vtws_revise($updateValues, $current_user);
		$expected = $ObjectValues;
		$expected['productcode'] = 'testthis';
		$expected['productsheet'] = 'productsheet';
		$expected['modifiedtime'] = $actual['modifiedtime'];
		$expected['modifiedby'] = $actual['modifiedby'];
		$this->assertTrue(!isset($actual['serial_no']), 'user does not have access to this field');
		$actual['serial_no'] = ''; // this user does not have access to this field so it should not update
		$this->assertEquals($expected, $actual, 'Test product usrcomd0x Correct');
		$postPdoPrices = getPriceDetailsForProduct(2633, 3.89, 'available_associated', 'Products');
		$postTaxDetails = getTaxDetailsForProduct(2633, 'available_associated');
		$this->assertEquals($prePdoPrices, $postPdoPrices, 'Test product usrcomd0x Currency Correct');
		$this->assertEquals($preTaxDetails, $postTaxDetails, 'Test product usrcomd0x Taxes Correct');
		$adb->pquery("update vtiger_products set productcode='', productsheet='', serialno='' where productid=?", array(2633));
		/// end
		$current_user = $holduser;
	}

	/**
	 * Method testReviseDeletedRecord
	 * @test
	 */
	public function testReviseDeletedRecord() {
		global $current_user, $adb;
		$adb->query('update vtiger_crmentity set deleted=0 where crmid=12836');
		$adb->query('update vtiger_crmobject set deleted=0 where crmid=12836');
		$quoteid = vtws_getEntityId('Quotes').'x12836';
		$_REQUEST['action'] = 'QuotesAjax';
		vtws_delete($quoteid, $current_user);
		$updateValues = array(
			'id' => $quoteid,
			'subject'=>'Test WS Revise',
		);
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		vtws_revise($updateValues, $current_user);
	}

	/**
	 * Method testReviseExceptionWrongAsignedUserId
	 * @test
	 */
	public function testReviseExceptionWrongAsignedUserId() {
		global $current_user;
		$cbUserID = '11x1084';
		$projectID = '33x5989';
		$updateValues = array(
			'id' => $projectID,
			'projectname'=>'Test WS Revise',
			'assigned_user_id' => $cbUserID
		);
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$REFERENCEINVALID);
		vtws_revise($updateValues, $current_user);
	}
}
?>