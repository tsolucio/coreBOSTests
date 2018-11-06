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
			'modifiedbyename' => array(
				'module' => 'Users',
				'reference' => ' Administrator',
			),
			'created_user_idename' => array (
				'module' => 'Users',
				'reference' => ' Administrator',
			),
			'assigned_user_idename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testmcurrency',
			),
		);
		$this->assertEquals($expected, $actual, 'retrieve campaign usrdota0x');
		$user->retrieveCurrentUserInfoFromFile($this->usrcomd0x);
		$actual = vtws_retrieve($campaignID.'x4973', $user);
		$this->assertEquals($expected, $actual, 'retrieve campaign usrcomd0x');
		$user->retrieveCurrentUserInfoFromFile($this->usrcoma3dot);
		$actual = vtws_retrieve($campaignID.'x4973', $user);
		$this->assertEquals($expected, $actual, 'retrieve campaign usrcoma3dot');
		$user->retrieveCurrentUserInfoFromFile($this->usrdota3comdollar);
		$actual = vtws_retrieve($campaignID.'x4973', $user);
		$this->assertEquals($expected, $actual, 'retrieve campaign usrdota3comdollar');
		/// end
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
			'product_idename' => array(
				'module' => 'Products',
				'reference' => 'New Arrival Metal Aluminum Case for iPhone 6',
			),
			'modifiedbyename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testdmy',
			),
			'created_user_idename' => array (
				'module' => 'Users',
				'reference' => ' Administrator',
			),
			'assigned_user_idename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testdmy',
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
			'product_idename' => array(
				'module' => 'Products',
				'reference' => 'New Arrival Metal Aluminum Case for iPhone 6',
			),
			'modifiedbyename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testmdy',
			),
			'created_user_idename' => array (
				'module' => 'Users',
				'reference' => ' Administrator',
			),
			'assigned_user_idename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testdmy',
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
			'product_idename' => array(
				'module' => 'Products',
				'reference' => 'New Arrival Metal Aluminum Case for iPhone 6',
			),
			'modifiedbyename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testmdy',
			),
			'created_user_idename' => array (
				'module' => 'Users',
				'reference' => ' Administrator',
			),
			'assigned_user_idename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testdmy',
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
			'product_idename' => array(
				'module' => 'Products',
				'reference' => 'New Arrival Metal Aluminum Case for iPhone 6',
			),
			'modifiedbyename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testdmy',
			),
			'created_user_idename' => array (
				'module' => 'Users',
				'reference' => ' Administrator',
			),
			'assigned_user_idename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testdmy',
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
			'product_idename' => array(
				'module' => 'Products',
				'reference' => 'New Arrival Metal Aluminum Case for iPhone 6',
			),
			'modifiedbyename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testdmy',
			),
			'created_user_idename' => array (
				'module' => 'Users',
				'reference' => ' Administrator',
			),
			'assigned_user_idename' => array(
				'module' => 'Users',
				'reference' => 'cbTest testdmy',
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