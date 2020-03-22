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

/*/////////////////////////////////////////////////////
REVISE is almost a stub for UPDATE so testing UPDATE validates both
The only difference is that REVISE does not require the presence of mandatory fields, so we will test only that
/////////////////////////////////////////////////////*/

use PHPUnit\Framework\TestCase;

class WSRetrieveUpdateReviseTest extends TestCase {

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
	 * Method testRetrieve
	 * @test
	 */
	public function testRetrieve() {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		$campaignID = vtws_getEntityId('Campaigns');
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x); // testdmy
		$actual = vtws_retrieve($campaignID.'x4973', $user);
		// We always get values in database format
		$expected = array (
			'campaignname' => 'Netherlands',
			'campaign_no' => 'CAM190',
			'campaigntype' => 'Partners',
			'product_id' => '',
			'campaignstatus' => 'Cancelled',
			'closingdate' => '2016-06-15',
			'assigned_user_id' => '19x12',
			'numsent' => '1225',
			'sponsor' => 'Marketing',
			'targetaudience' => 'Mass',
			'targetsize' => '21809',
			'createdtime' => '2015-04-29 15:25:59',
			'modifiedtime' => '2015-05-15 07:04:31',
			'modifiedby' => '19x1',
			'expectedresponse' => '--None--',
			'expectedrevenue' => '7273.000000',
			'budgetcost' => '8889.000000',
			'actualcost' => '225.000000',
			'expectedresponsecount' => '10276',
			'expectedsalescount' => '2928',
			'expectedroi' => '5461.000000',
			'actualresponsecount' => '7152',
			'actualsalescount' => '2024',
			'actualroi' => '3274.000000',
			'description' => 'Nunc mauris elit, dictum eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur dictum. Phasellus in felis. Nulla tempor augue ac ipsum. Phasellus vitae mauris sit amet lorem semper auctor. Mauris vel turpis. Aliquam adipiscing lobortis risus. In mi pede, nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque. Sed eget lacus. Mauris non dui nec urna suscipit nonummy. Fusce',
			'created_user_id' => '19x1',
			'id' => '1x4973',
			'cbuuid' => '559516a535b92c36ab3be0b15486056303052e24',
			'modifiedbyename' => array(
				'module' => 'Users',
				'reference' => ' Administrator',
				'cbuuid' => '',
			),
			'created_user_idename' => array (
				'module' => 'Users',
				'reference' => ' Administrator',
				'cbuuid' => '',
			),
			'assigned_user_idename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testmcurrency',
				'cbuuid' => '',
			),
		);
		$this->assertEquals($expected, $actual, 'retrieve campaign usrdota0x');
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrcomd0x);
		$actual = vtws_retrieve($campaignID.'x4973', $user);
		$this->assertEquals($expected, $actual, 'retrieve campaign usrcomd0x');
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrcoma3dot);
		$actual = vtws_retrieve($campaignID.'x4973', $user);
		$this->assertEquals($expected, $actual, 'retrieve campaign usrcoma3dot');
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrdota3comdollar);
		$actual = vtws_retrieve($campaignID.'x4973', $user);
		$this->assertEquals($expected, $actual, 'retrieve campaign usrdota3comdollar');
		///////////////
		$pdoID = vtws_getEntityId('Products');
		$user = new Users();
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrcomd0x);
		$current_user = $user;
		$actual = vtws_retrieve($pdoID.'x2633', $user);
		unset($actual['modifiedtime'], $actual['modifiedby'], $actual['modifiedbyename']);
		// We always get values in database format
		$expected = array (
			'assigned_user_id' => '19x6',
			'createdtime' => '2015-04-06 17:00:58',
			'description' => 'Teneo, inquit, finem illi videri nihil dolere. Quonam modo? Sin te auctoritas commovebat, nobisne omnibus et Platoni ipsi nescio quem illum anteponebas? Cum praesertim illa perdiscere ludus esset.',
			'created_user_id' => '19x1',
			'id' => '14x2633',
			'productname' => 'Leagoo Lead 3s Mobile Phone',
			'product_no' => 'PRO18',
			'discontinued' => '1',
			'productcode' => '',
			'sales_start_date' => '2015-07-10',
			'start_date' => '2012-12-31',
			'sales_end_date' => '2024-08-03',
			'expiry_date' => '2025-08-24',
			'vendor_id' => '2x2363',
			'mfr_part_no' => '',
			'productsheet' => '',
			'glacct' => '302-Rental-Income',
			'unit_price' => '223.000000',
			'commissionrate' => '0.000',
			'taxclass' => '',
			'cost_price' => '200.000000',
			'usageunit' => 'M',
			'qty_per_unit' => '0.00',
			'qtyinstock' => '6.000',
			'reorderlevel' => '0',
			'qtyindemand' => '0',
			'divisible' => '0',
			'imagename' => '',
			'cbuuid' => '61221bff1c0ff171674aca18d81903db1afe0a41',
			'vendor_idename' => array(
				'module' => 'Vendors',
				'reference' => 'E Zaks & Co',
				'cbuuid' => 'ccfcc045d88404261dad730cf1aa0b11468ab89c',
			),
			'created_user_idename' => array (
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
		$this->assertEquals($expected, $actual, 'retrieve product usrdota0x');
		/// end
		$current_user = $holduser;
	}

	/**
	 * Method testRetrieveException
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testRetrieveException() {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrcoma3dot);
		$current_user = $user;
		$pdoID = vtws_getEntityId('Products');
		$actual = vtws_retrieve($pdoID.'x2633', $user);
		$current_user = $holduser;
	}

	/** Method to restore test update record to it's original values */
	public function restoreUpdateRecord() {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x);
		$current_user = $user;
		$currentValues = array (
			'campaignname' => 'Spain',
			'campaign_no' => 'CAM202',
			'campaigntype' => 'Referral Program',
			'product_id' => '14x2625',
			'campaignstatus' => 'Planning',
			'closingdate' => '2016-04-12',
			'assigned_user_id' => '19x5',
			'numsent' => '8275',
			'sponsor' => 'Marketing',
			'targetaudience' => 'CEOs',
			'targetsize' => '72770',
			'createdtime' => '2015-04-29 17:50:27',
			'modifiedtime' => '2016-01-08 20:04:38',
			'modifiedby' => '19x1',
			'created_user_id' => '19x1',
			'expectedresponse' => 'Good',
			'expectedrevenue' => '9064.000000',
			'budgetcost' => '6294.000000',
			'actualcost' => '4441.000000',
			'expectedresponsecount' => '7868',
			'expectedsalescount' => '5302',
			'expectedroi' => '3613.000000',
			'actualresponsecount' => '5577',
			'actualsalescount' => '7734',
			'actualroi' => '5021.000000',
			'description' => 'Phasellus at augue id ante dictum cursus. Nunc mauris elit, dictum eu, eleifend',
			'id' => '1x4985',
		);
		// Restore record
		vtws_update($currentValues, $user);
		$current_user = $holduser;
	}

	/**
	 * Method testUpdate
	 * @test
	 */
	public function testUpdate() {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		///////////
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x);
		$current_user = $user;
		$campaignID = vtws_getEntityId('Campaigns');
		$currentValues = array (
			'campaignname' => 'Spain',
			'campaign_no' => 'CAM202',
			'campaigntype' => 'Referral Program',
			'product_id' => '14x2625',
			'campaignstatus' => 'Planning',
			'closingdate' => '2016-04-12',
			'assigned_user_id' => '19x5',
			'numsent' => '8275',
			'sponsor' => 'Marketing',
			'targetaudience' => 'CEOs',
			'targetsize' => '72770',
			'createdtime' => '2015-04-29 17:50:27',
			'modifiedtime' => '2016-01-08 20:04:38',
			'modifiedby' => '19x1',
			'created_user_id' => '19x1',
			'expectedresponse' => 'Good',
			'expectedrevenue' => '9064.000000',
			'budgetcost' => '6294.000000',
			'actualcost' => '4441.000000',
			'expectedresponsecount' => '7868',
			'expectedsalescount' => '5302',
			'expectedroi' => '3613.000000',
			'actualresponsecount' => '5577',
			'actualsalescount' => '7734',
			'actualroi' => '5021.000000',
			'description' => 'Phasellus at augue id ante dictum cursus. Nunc mauris elit, dictum eu, eleifend',
			'id' => '1x4985',
			'cbuuid' => '5261bade9b0ee17c0ff2c44fdff1f71e1dd733bf',
			'product_idename' => array(
				'module' => 'Products',
				'reference' => 'New Arrival Metal Aluminum Case for iPhone 6',
				'cbuuid' => 'efdf5dc4d4aab1a3bd158e3324554e4d54bbc27f',
			),
			'modifiedbyename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testdmy',
				'cbuuid' => '',
			),
			'created_user_idename' => array (
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
		$newValuesCompleteusrdota0x = array (
			'campaignname' => 'Spain áçèñtös <>',
			'campaign_no' => 'CAM202',
			'campaigntype' => 'Referral Program',
			'product_id' => '14x2625',
			'campaignstatus' => 'Planning',
			'closingdate' => '2016-04-12',
			'assigned_user_id' => '19x5',
			'numsent' => '8275',
			'sponsor' => 'Marketing',
			'targetaudience' => 'CEOs',
			'targetsize' => '72770',
			'createdtime' => '2015-04-29 17:50:27',
			'created_user_id' => '19x1',
			'expectedresponse' => 'Good',
			'expectedrevenue' => '9064.000000',
			'budgetcost' => '6294.000000',
			'actualcost' => '4441.000000',
			'expectedresponsecount' => '7868',
			'expectedsalescount' => '5302',
			'expectedroi' => '3613.000000',
			'actualresponsecount' => '5577',
			'actualsalescount' => '7734',
			'actualroi' => '5021.000000',
			'description' => '<p><IMG SRC=javascript:alert(String.fromCharCode(88,83,83))/><<SCRIPT>alert("XSS");//<</SCRIPT><IMG """><SCRIPT>alert("XSS")</SCRIPT>script>alert("Ahh, once again bypassed your system, sorry :( *evil laugh*");<<SCRIPT>alert("XSS");//<</SCRIPT><IMG """><SCRIPT>alert("XSS")</SCRIPT>/script><img SRC="jav ascript:alert(\'XSS\');" style="height:512px;width:512px;" alt="human_head_reference_picture_front - Copy.jpg" /><img onerror="sfs" aalt="" src="http://{siteURL}.com/assets/images/human_head_reference_picture_front%20-%20Copy.jpg" style="height:512px; width:512px" /></p>',
			'id' => '1x4985',
			'cbuuid' => '5261bade9b0ee17c0ff2c44fdff1f71e1dd733bf',
			'product_idename' => array(
				'module' => 'Products',
				'reference' => 'New Arrival Metal Aluminum Case for iPhone 6',
				'cbuuid' => 'efdf5dc4d4aab1a3bd158e3324554e4d54bbc27f',
			),
			'modifiedbyename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testmdy',
				'cbuuid' => '',
			),
			'created_user_idename' => array (
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
		$newValuesPartialusrdota0x = array (
			'campaignname' => 'Spain áçèñtös <>',
			'closingdate' => '2016-04-12',
			'assigned_user_id' => '19x5',
			'description' => '<p><IMG SRC=javascript:alert(String.fromCharCode(88,83,83))/><<SCRIPT>alert("XSS");//<</SCRIPT><IMG """><SCRIPT>alert("XSS")</SCRIPT>script>alert("Ahh, once again bypassed your system, sorry :( *evil laugh*");<<SCRIPT>alert("XSS");//<</SCRIPT><IMG """><SCRIPT>alert("XSS")</SCRIPT>/script><img SRC="jav ascript:alert(\'XSS\');" style="height:512px;width:512px;" alt="human_head_reference_picture_front - Copy.jpg" /><img onerror="sfs" aalt="" src="http://{siteURL}.com/assets/images/human_head_reference_picture_front%20-%20Copy.jpg" style="height:512px; width:512px" /></p>',
			'id' => '1x4985',
		);
		$newValuesCompleteusrcomd0x = array (
			'campaignname' => 'Spain áçèñtös <>',
			'campaign_no' => 'CAM202',
			'campaigntype' => 'Referral Program',
			'product_id' => '14x2625',
			'campaignstatus' => 'Planning',
			'closingdate' => '04-12-2016',
			'assigned_user_id' => '19x5',
			'numsent' => '8275',
			'sponsor' => 'Marketing',
			'targetaudience' => 'CEOs',
			'targetsize' => '72770',
			'createdtime' => '04-29-2015 17:50:27',
			'created_user_id' => '19x1',
			'expectedresponse' => 'Good',
			'expectedrevenue' => '9064,000000',
			'budgetcost' => '6294,000000',
			'actualcost' => '4441,000000',
			'expectedresponsecount' => '7868',
			'expectedsalescount' => '5302',
			'expectedroi' => '3613,000000',
			'actualresponsecount' => '5577',
			'actualsalescount' => '7734',
			'actualroi' => '5021,000000',
			'description' => '<p><IMG SRC=javascript:alert(String.fromCharCode(88,83,83))/><<SCRIPT>alert("XSS");//<</SCRIPT><IMG """><SCRIPT>alert("XSS")</SCRIPT>script>alert("Ahh, once again bypassed your system, sorry :( *evil laugh*");<<SCRIPT>alert("XSS");//<</SCRIPT><IMG """><SCRIPT>alert("XSS")</SCRIPT>/script><img SRC="jav ascript:alert(\'XSS\');" style="height:512px;width:512px;" alt="human_head_reference_picture_front - Copy.jpg" /><img onerror="sfs" aalt="" src="http://{siteURL}.com/assets/images/human_head_reference_picture_front%20-%20Copy.jpg" style="height:512px; width:512px" /></p>',
			'id' => '1x4985',
			'cbuuid' => '5261bade9b0ee17c0ff2c44fdff1f71e1dd733bf',
			'product_idename' => array(
				'module' => 'Products',
				'reference' => 'New Arrival Metal Aluminum Case for iPhone 6',
				'cbuuid' => 'efdf5dc4d4aab1a3bd158e3324554e4d54bbc27f',
			),
			'modifiedbyename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testmdy',
				'cbuuid' => '',
			),
			'created_user_idename' => array (
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
		$newValuesPartialusrcomd0x = array (
			'campaignname' => 'Spain áçèñtös <>',
			'closingdate' => '04-12-2016',
			'assigned_user_id' => '19x5',
			'description' => '<p><IMG SRC=javascript:alert(String.fromCharCode(88,83,83))/><<SCRIPT>alert("XSS");//<</SCRIPT><IMG """><SCRIPT>alert("XSS")</SCRIPT>script>alert("Ahh, once again bypassed your system, sorry :( *evil laugh*");<<SCRIPT>alert("XSS");//<</SCRIPT><IMG """><SCRIPT>alert("XSS")</SCRIPT>/script><img SRC="jav ascript:alert(\'XSS\');" style="height:512px;width:512px;" alt="human_head_reference_picture_front - Copy.jpg" /><img onerror="sfs" aalt="" src="http://{siteURL}.com/assets/images/human_head_reference_picture_front%20-%20Copy.jpg" style="height:512px; width:512px" /></p>',
			'id' => '1x4985',
		);
		$newValuesCompleteusrcoma3dot = array (
			'campaignname' => 'Spain áçèñtös <>',
			'campaign_no' => 'CAM202',
			'campaigntype' => 'Referral Program',
			'product_id' => '14x2625',
			'campaignstatus' => 'Planning',
			'closingdate' => '2016-04-12',
			'assigned_user_id' => '19x5',
			'numsent' => '8.275',
			'sponsor' => 'Marketing',
			'targetaudience' => 'CEOs',
			'targetsize' => '72770',
			'createdtime' => '2015-04-29 17:50:27',
			'created_user_id' => '19x1',
			'expectedresponse' => 'Good',
			'expectedrevenue' => '9.064,000000',
			'budgetcost' => '6.294,000000',
			'actualcost' => '4.441,000000',
			'expectedresponsecount' => '7868',
			'expectedsalescount' => '5302',
			'expectedroi' => '3.613,000000',
			'actualresponsecount' => '5577',
			'actualsalescount' => '7734',
			'actualroi' => '5.021,000000',
			'description' => '<p><IMG SRC=javascript:alert(String.fromCharCode(88,83,83))/><<SCRIPT>alert("XSS");//<</SCRIPT><IMG """><SCRIPT>alert("XSS")</SCRIPT>script>alert("Ahh, once again bypassed your system, sorry :( *evil laugh*");<<SCRIPT>alert("XSS");//<</SCRIPT><IMG """><SCRIPT>alert("XSS")</SCRIPT>/script><img SRC="jav ascript:alert(\'XSS\');" style="height:512px;width:512px;" alt="human_head_reference_picture_front - Copy.jpg" /><img onerror="sfs" aalt="" src="http://{siteURL}.com/assets/images/human_head_reference_picture_front%20-%20Copy.jpg" style="height:512px; width:512px" /></p>',
			'id' => '1x4985',
			'cbuuid' => '5261bade9b0ee17c0ff2c44fdff1f71e1dd733bf',
			'product_idename' => array(
				'module' => 'Products',
				'reference' => 'New Arrival Metal Aluminum Case for iPhone 6',
				'cbuuid' => 'efdf5dc4d4aab1a3bd158e3324554e4d54bbc27f',
			),
			'modifiedbyename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testdmy',
				'cbuuid' => '',
			),
			'created_user_idename' => array (
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
		// Complete
		vtws_update($newValuesCompleteusrdota0x, $user);
		$actual = vtws_retrieve($campaignID.'x4985', $user);
		$expected = $newValuesCompleteusrdota0x;
		$expected['modifiedby'] = '19x'.$user->id;
		$expected['modifiedbyename']['reference'] = 'cbTest testdmy';
		unset($actual['modifiedtime']);
		$this->assertEquals($expected, $actual, 'retrieve after Complete update usrdota0x');
		$this->restoreUpdateRecord(); // Restore record
		// Partial
		vtws_update($newValuesPartialusrdota0x, $user);
		$actual = vtws_retrieve($campaignID.'x4985', $user);
		$expected = $newValuesCompleteusrdota0x;
		$expected['modifiedby'] = '19x'.$user->id;
		$expected['modifiedbyename']['reference'] = 'cbTest testdmy';
		unset($actual['modifiedtime']);
		$this->assertEquals($expected, $actual, 'retrieve after Partial update usrdota0x');
		$this->restoreUpdateRecord(); // Restore record
		///////////
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrcomd0x);
		$current_user = $user;
		// Complete
		vtws_update($newValuesCompleteusrcomd0x, $user);
		$actual = vtws_retrieve($campaignID.'x4985', $user);
		$expected = $newValuesCompleteusrdota0x;
		$expected['modifiedby'] = '19x'.$user->id;
		unset($actual['modifiedtime']);
		$this->assertEquals($expected, $actual, 'retrieve after Complete update usrcomd0x');
		$this->restoreUpdateRecord(); // Restore record
		// Partial
		vtws_update($newValuesPartialusrcomd0x, $user);
		$actual = vtws_retrieve($campaignID.'x4985', $user);
		$expected = $newValuesCompleteusrdota0x;
		$expected['modifiedby'] = '19x'.$user->id;
		unset($actual['modifiedtime']);
		$this->assertEquals($expected, $actual, 'retrieve after Partial update usrcomd0x');
		$this->restoreUpdateRecord(); // Restore record
		///////////
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrcoma3dot);
		$current_user = $user;
		// Complete
		vtws_update($newValuesCompleteusrcoma3dot, $user);
		$actual = vtws_retrieve($campaignID.'x4985', $user);
		$expected = $newValuesCompleteusrdota0x;
		$expected['modifiedby'] = '19x'.$user->id;
		$expected['modifiedbyename']['reference'] = 'cbTest testtz';
		unset($actual['modifiedtime']);
		$this->assertEquals($expected, $actual, 'retrieve after Complete update usrcoma3dot');
		$this->restoreUpdateRecord(); // Restore record
		// Partial
		vtws_update($newValuesPartialusrdota0x, $user);
		$actual = vtws_retrieve($campaignID.'x4985', $user);
		$expected = $newValuesCompleteusrdota0x;
		$expected['modifiedby'] = '19x'.$user->id;
		$expected['modifiedbyename']['reference'] = 'cbTest testtz';
		unset($actual['modifiedtime']);
		$this->assertEquals($expected, $actual, 'retrieve after Partial update usrcoma3dot');
		$this->restoreUpdateRecord(); // Restore record
		/// end
		$current_user = $holduser;
	}

	/**
	 * Method testUpdateException
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testUpdateException() {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x);
		$current_user = $user;
		// Missing mandatory fields
		$newValuesPartial = array (
			'campaignname' => 'Spain áçèñtös <>',
			//'closingdate' => '2016-04-12',
			//'assigned_user_id' => '19x5',
			'description' => '<p><IMG SRC=javascript:alert(String.fromCharCode(88,83,83))/><<SCRIPT>alert("XSS");//<</SCRIPT><IMG """><SCRIPT>alert("XSS")</SCRIPT>script>alert("Ahh, once again bypassed your system, sorry :( *evil laugh*");<<SCRIPT>alert("XSS");//<</SCRIPT><IMG """><SCRIPT>alert("XSS")</SCRIPT>/script><img SRC="jav ascript:alert(\'XSS\');" style="height:512px;width:512px;" alt="human_head_reference_picture_front - Copy.jpg" /><img onerror="sfs" aalt="" src="http://{siteURL}.com/assets/images/human_head_reference_picture_front%20-%20Copy.jpg" style="height:512px; width:512px" /></p>',
			'id' => '1x4985',
		);
		// Partial
		vtws_update($newValuesPartial, $user);
		/// end
		$current_user = $holduser;
	}

	/**
	 * Method testUpdateUUID
	 * @test
	 */
	public function testUpdateUUID() {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		///////////
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x);
		$current_user = $user;
		$assetID = vtws_getEntityId('Assets');
		$cbUserID = '19x'.$current_user->id;
		$currentValues = array (
			'asset_no' => 'AST-000057',
			'createdtime' => '2015-04-21 14:10:39',
			'product'=>'14x2620',
			'serialnumber'=>'ABCD-123456',
			'datesold'=>'2016-04-11',  // Y-m-d
			'dateinservice'=>'2015-12-08',  // Y-m-d
			'assetstatus' => 'In Service',
			'tagnumber' => '',
			'invoiceid' => '7x2902',
			'shippingmethod' => '',
			'shippingtrackingnumber' => '',
			'assigned_user_id' => $cbUserID,
			'created_user_id' => '19x1',
			'assetname' => 'Perrysburg Animal Care Inc :: Car Sunshade Windshield Cover / Car Snow Cover',
			'account' => '11x138',
			'description' => ' Morbo gravissimo affectus, exul, orbus, egens, torqueatur eculeo: quem hunc appellas, Zeno? Fortemne possumus dicere eundem illum Torquatum? Dicet pro me ipsa virtus nec dubitabit isti vestro beato M. Duo Reges: constructio interrete. Hoc ne statuam quidem dicturam pater aiebat, si loqui posset. Ut aliquid scire se gaudeant? Omnia contraria, quos etiam insanos esse vultis. At modo dixeras nihil in istis rebus esse, quod interesset. 

',
			'id' => '29x4124',
			'cbuuid' => '35eec5e421b97c8feb3045e6476dbff6a2aeb920',
			'productename' => array(
				'module' => 'Products',
				'reference' => 'Car Sunshade Windshield Cover / Car Snow Cover',
				'cbuuid' => '08b6499c06f49c16689928879243b21e61928a5c',
			),
			'invoiceidename' => array(
				'module' => 'Invoice',
				'reference' => 'Dream Master',
				'cbuuid' => '0c1030cf9b87def60ddd4354ba7b62ec8257c05d',
			),
			'accountename' => array(
				'module' => 'Accounts',
				'reference' => 'Perrysburg Animal Care Inc',
				'cbuuid' => 'dd574403238a3e69a2015a381465ddd5ad348443',
			),
			'created_user_idename' => array (
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
		$realValues = vtws_retrieve('35eec5e421b97c8feb3045e6476dbff6a2aeb920', $user);
		unset($realValues['modifiedtime'], $realValues['modifiedby'], $realValues['modifiedbyename']);
		$this->assertEquals($currentValues, $realValues, 'retrieve before update');
		$newValues = array (
			'product'=>'0a3c5c965d2c42e246349fee0e919ef22f4c80d3',
			'invoiceid' => 'dc68fcd9960bdbaf677d7fc8a9b274730cf4b30c',
			'account' => 'c96bc3d37a773ddf9aa2e75b4ca02a25e5a356a4',
			'assetname' => 'Spain áçèñtös <>',
			'description' => '<p><IMG SRC=javascript:alert(String.fromCharCode(88,83,83))/><<SCRIPT>alert("XSS");//<</SCRIPT><IMG """><SCRIPT>alert("XSS")</SCRIPT>script>alert("Ahh, once again bypassed your system, sorry :( *evil laugh*");<<SCRIPT>alert("XSS");//<</SCRIPT><IMG """><SCRIPT>alert("XSS")</SCRIPT>/script><img SRC="jav ascript:alert(\'XSS\');" style="height:512px;width:512px;" alt="human_head_reference_picture_front - Copy.jpg" /><img onerror="sfs" aalt="" src="http://{siteURL}.com/assets/images/human_head_reference_picture_front%20-%20Copy.jpg" style="height:512px; width:512px" /></p>',
			'id' => '35eec5e421b97c8feb3045e6476dbff6a2aeb920',
		);
		vtws_revise($newValues, $user);
		$realValues = vtws_retrieve('35eec5e421b97c8feb3045e6476dbff6a2aeb920', $user);
		$expected = $currentValues;
		$expected['modifiedby'] = '19x5';
		$expected['product'] = '14x2617';
		$expected['invoiceid'] = '7x3021';
		$expected['account'] = '11x131';
		$expected['assetname'] = $newValues['assetname'];
		$expected['description'] = $newValues['description'];
		$expected['productename']['reference'] = 'New FULL HD 1080P Car Video Recorder With G-Sensor and 24H Parking mode';
		$expected['productename']['cbuuid'] = '0a3c5c965d2c42e246349fee0e919ef22f4c80d3';
		$expected['accountename']['reference'] = 'Computer Repair Service';
		$expected['accountename']['cbuuid'] = 'c96bc3d37a773ddf9aa2e75b4ca02a25e5a356a4';
		$expected['invoiceidename']['reference'] = 'Ept-Rass';
		$expected['invoiceidename']['cbuuid'] = 'dc68fcd9960bdbaf677d7fc8a9b274730cf4b30c';
		unset($realValues['modifiedtime'], $realValues['modifiedbyename']);
		$this->assertEquals($expected, $realValues, 'retrieve after update');
		vtws_update($currentValues, $user);
		$realValues = vtws_retrieve('35eec5e421b97c8feb3045e6476dbff6a2aeb920', $user);
		$expected = $currentValues;
		$expected['modifiedby'] = '19x5';
		unset($realValues['modifiedtime'], $realValues['modifiedbyename']);
		$this->assertEquals($expected, $realValues, 'retrieve before update');
		/// end
		$current_user = $holduser;
	}

	/**
	 * Method testRevise
	 * @test
	 */
	public function testRevise() {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		///////////
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x);
		$current_user = $user;
		$campaignID = vtws_getEntityId('Campaigns');
		$currentValues = array (
			'campaignname' => 'Spain',
			'campaign_no' => 'CAM202',
			'campaigntype' => 'Referral Program',
			'product_id' => '14x2625',
			'campaignstatus' => 'Planning',
			'closingdate' => '2016-04-12',
			'assigned_user_id' => '19x5',
			'numsent' => '8275',
			'sponsor' => 'Marketing',
			'targetaudience' => 'CEOs',
			'targetsize' => '72770',
			'createdtime' => '2015-04-29 17:50:27',
			'modifiedtime' => '2016-01-08 20:04:38',
			'modifiedby' => '19x1',
			'created_user_id' => '19x1',
			'expectedresponse' => 'Good',
			'expectedrevenue' => '9064.000000',
			'budgetcost' => '6294.000000',
			'actualcost' => '4441.000000',
			'expectedresponsecount' => '7868',
			'expectedsalescount' => '5302',
			'expectedroi' => '3613.000000',
			'actualresponsecount' => '5577',
			'actualsalescount' => '7734',
			'actualroi' => '5021.000000',
			'description' => 'Phasellus at augue id ante dictum cursus. Nunc mauris elit, dictum eu, eleifend',
			'id' => '1x4985',
		);
		$newValuesComplete = array (
			'campaignname' => 'Spain áçèñtös <>',
			'campaign_no' => 'CAM202',
			'campaigntype' => 'Referral Program',
			'product_id' => '14x2625',
			'campaignstatus' => 'Planning',
			'closingdate' => '2016-04-12',
			'assigned_user_id' => '19x5',
			'numsent' => '8275',
			'sponsor' => 'Marketing',
			'targetaudience' => 'CEOs',
			'targetsize' => '72770',
			'createdtime' => '2015-04-29 17:50:27',
			'created_user_id' => '19x1',
			'expectedresponse' => 'Good',
			'expectedrevenue' => '9064.000000',
			'budgetcost' => '6294.000000',
			'actualcost' => '4441.000000',
			'expectedresponsecount' => '7868',
			'expectedsalescount' => '5302',
			'expectedroi' => '3613.000000',
			'actualresponsecount' => '5577',
			'actualsalescount' => '7734',
			'actualroi' => '5021.000000',
			'description' => '<p><IMG SRC=javascript:alert(String.fromCharCode(88,83,83))/><<SCRIPT>alert("XSS");//<</SCRIPT><IMG """><SCRIPT>alert("XSS")</SCRIPT>script>alert("Ahh, once again bypassed your system, sorry :( *evil laugh*");<<SCRIPT>alert("XSS");//<</SCRIPT><IMG """><SCRIPT>alert("XSS")</SCRIPT>/script><img SRC="jav ascript:alert(\'XSS\');" style="height:512px;width:512px;" alt="human_head_reference_picture_front - Copy.jpg" /><img onerror="sfs" aalt="" src="http://{siteURL}.com/assets/images/human_head_reference_picture_front%20-%20Copy.jpg" style="height:512px; width:512px" /></p>',
			'id' => '1x4985',
			'cbuuid' => '5261bade9b0ee17c0ff2c44fdff1f71e1dd733bf',
			'product_idename' => array(
				'module' => 'Products',
				'reference' => 'New Arrival Metal Aluminum Case for iPhone 6',
				'cbuuid' => 'efdf5dc4d4aab1a3bd158e3324554e4d54bbc27f',
			),
			'modifiedbyename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testdmy',
				'cbuuid' => '',
			),
			'created_user_idename' => array (
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
		// Missing mandatory fields
		$newValuesPartial = array (
			'campaignname' => 'Spain áçèñtös <>',
			//'closingdate' => '2016-04-12',
			//'assigned_user_id' => '19x5',
			'description' => '<p><IMG SRC=javascript:alert(String.fromCharCode(88,83,83))/><<SCRIPT>alert("XSS");//<</SCRIPT><IMG """><SCRIPT>alert("XSS")</SCRIPT>script>alert("Ahh, once again bypassed your system, sorry :( *evil laugh*");<<SCRIPT>alert("XSS");//<</SCRIPT><IMG """><SCRIPT>alert("XSS")</SCRIPT>/script><img SRC="jav ascript:alert(\'XSS\');" style="height:512px;width:512px;" alt="human_head_reference_picture_front - Copy.jpg" /><img onerror="sfs" aalt="" src="http://{siteURL}.com/assets/images/human_head_reference_picture_front%20-%20Copy.jpg" style="height:512px; width:512px" /></p>',
			'id' => '1x4985',
		);
		// Partial
		vtws_revise($newValuesPartial, $user);
		$actual = vtws_retrieve($campaignID.'x4985', $user);
		$expected = $newValuesComplete;
		$expected['modifiedby'] = '19x'.$user->id;
		unset($actual['modifiedtime']);
		$this->assertEquals($expected, $actual, 'retrieve after REVISE Partial update');
		$this->restoreUpdateRecord(); // Restore record
		/// end
		$current_user = $holduser;
	}

	/**
	 * Method testUpdateWithWrongValues
	 * @test
	 */
	public function testUpdateWithWrongValues() {
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * Method testUpdateInventoryModule
	 * @test
	 */
	public function testUpdateInventoryModule() {
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}
}
?>