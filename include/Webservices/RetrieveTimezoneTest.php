<?php
/*************************************************************************************************
 * Copyright 2022 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

class RetrieveTimezoneTest extends TestCase {

	public $usrutc = 6; // testmdy
	public $usrutc1 = 10; // testtz
	public $usrutc3 = 13; // testtz-3

	public static function tearDownAfterClass(): void {
		global $current_user;
		$current_user = Users::getActiveAdminUser();
	}

	/**
	 * Method testDefaultRetrieve
	 * @test
	 */
	public function testDefaultRetrieve() {
		global $current_user, $adb;
		$holduser = $current_user;
		$calID = vtws_getEntityId('cbCalendar');
		$expected = array (
			'reminder_time' => '0',
			'subject' => 'Prism (Robbie)',
			'assigned_user_id' => '19x6',
			'date_start' => '2016-07-11',
			'dtstart' => '2016-07-11 09:23:00',
			'time_start' => '09:23:00',
			'due_date' => '2016-07-11',
			'dtend' => '2016-07-11 12:26:00',
			'time_end' => '12:26:00',
			'recurringtype' => '--None--',
			'rel_id' => '17x2649',
			'cto_id' => '12x1697',
			'eventstatus' => 'Held',
			'taskpriority' => 'High',
			'sendnotification' => '0',
			'createdtime' => '2015-08-27 00:04:35',
			'modifiedtime' => '2015-09-22 17:38:25',
			'activitytype' => 'Meeting',
			'duration_hours' => '0',
			'visibility' => '',
			'duration_minutes' => '0',
			'location' => 'Brecknockshire',
			'notime' => '0',
			'relatedwith' => '',
			'created_user_id' => '19x1',
			'modifiedby' => '19x1',
			'description' => 'Mauris nulla. Integer urna. Vivamus molestie dapibus ligula. Aliquam erat volutpat. Nulla dignissim. Maecenas ornare egestas ligula. Nullam',
			'followupdt' => '',
			'followuptype' => '',
			'followupcreate' => '',
			'id' => '39x15139',
			'cbuuid' => '1428a7fe386a0fc2603c296154fa9bd6e0f6ab15',
			'cto_idename' => array (
				'module' => 'Contacts',
				'reference' => 'Shelia Plues',
				'cbuuid' => '8561ba1f2316d6f10bed7635a90910dcc29ea510',
			),
			'created_user_idename' => array (
				'module' => 'Users',
				'reference' => ' Administrator',
				'cbuuid' => '',
			),
			'modifiedbyename' => array (
				'module' => 'Users',
				'reference' => ' Administrator',
				'cbuuid' => '',
			),
			'assigned_user_idename' => array (
				'module' => 'Users',
				'reference' => 'cbTest testmdy',
				'cbuuid' => '',
			),
		);
		// We always get values in database format
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrutc);
		$adb->pquery('update vtiger_crmentity set smownerid=? where crmid=?', array($this->usrutc, 15139));
		$actual = vtws_retrieve($calID.'x15139', $current_user);
		$this->assertEquals($expected, $actual, 'retrieve calendar utc');
		/////////////
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrutc1);
		$adb->pquery('update vtiger_crmentity set smownerid=? where crmid=?', array($this->usrutc1, 15139));
		$expected['assigned_user_id'] = '19x'.$this->usrutc1;
		$expected['assigned_user_idename']['reference'] = 'cbTest testtz';
		$actual = vtws_retrieve($calID.'x15139', $current_user);
		$this->assertEquals($expected, $actual, 'retrieve calendar utc+1');
		/////////////
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrutc3);
		$adb->pquery('update vtiger_crmentity set smownerid=? where crmid=?', array($this->usrutc3, 15139));
		$expected['assigned_user_id'] = '19x'.$this->usrutc3;
		$expected['assigned_user_idename']['reference'] = 'cbTest testtz-3';
		$actual = vtws_retrieve($calID.'x15139', $current_user);
		$this->assertEquals($expected, $actual, 'retrieve calendar utc+3');
		/////////////
		/////////////
		$cmpID = vtws_getEntityId('Campaigns');
		$expected = array (
			'campaignname' => 'Viet Nam',
			'campaign_no' => 'CAM166',
			'assigned_user_id' => '19x12',
			'campaignstatus' => 'Completed',
			'campaigntype' => 'Webinar',
			'product_id' => '14x2618',
			'targetaudience' => 'Rookies',
			'closingdate' => '2015-09-21',
			'sponsor' => 'Finance',
			'targetsize' => '31670',
			'createdtime' => '2015-04-29 10:07:52',
			'numsent' => '1923',
			'modifiedtime' => '2015-06-07 11:14:51',
			'modifiedby' => '19x1',
			'created_user_id' => '19x1',
			'budgetcost' => '6318.000000',
			'actualcost' => '1890.000000',
			'expectedresponse' => 'Good',
			'expectedrevenue' => '7833.000000',
			'expectedsalescount' => '9738',
			'actualsalescount' => '8876',
			'expectedresponsecount' => '5623',
			'actualresponsecount' => '5145',
			'expectedroi' => '8854.000000',
			'actualroi' => '4113.000000',
			'description' => 'convallis dolor. Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam, elementum at, egestas a, scelerisque',
			'id' => '1x4949',
			'cbuuid' => '7ad06a979248c7b4e30a96287c60d1959893c87c',
			'modifiedbyename' => array (
				'module' => 'Users',
				'reference' => ' Administrator',
				'cbuuid' => '',
			),
			'created_user_idename' => array (
				'module' => 'Users',
				'reference' => ' Administrator',
				'cbuuid' => '',
			),
			'assigned_user_idename' => array (
				'module' => 'Users',
				'reference' => 'cbTest testmcurrency',
				'cbuuid' => '',
			),
		);
		// We always get values in database format
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrutc);
		$actual = vtws_retrieve($cmpID.'x4949', $current_user);
		$this->assertEquals($expected, $actual, 'retrieve campaign utc');
		/////////////
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrutc1);
		$actual = vtws_retrieve($cmpID.'x4949', $current_user);
		$this->assertEquals($expected, $actual, 'retrieve calendar utc+1');
		/// end
		$current_user = $holduser;
	}

	/**
	 * Method testDefaultQuery
	 * @test
	 */
	public function testDefaultQuery() {
		global $adb, $current_user, $log;
		$holdUser = $current_user;
		$calID = vtws_getEntityId('cbCalendar');
		$adb->pquery('update vtiger_crmentity set smownerid=? where crmid=?', array($this->usrutc, 15139));
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrutc);
		$query = "select dtstart,modifiedtime from cbCalendar where id='".$calID."x15139';";
		$actual = vtws_query($query, $current_user);
		$this->assertEquals(
			array(
				0 => array(
					'dtstart' => '2016-07-11 09:23:00',
					'modifiedtime' => '2015-09-22 17:38:25',
					'id' => '39x15139',
				),
			),
			$actual
		);
		/////////////
		$adb->pquery('update vtiger_crmentity set smownerid=? where crmid=?', array($this->usrutc1, 15139));
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrutc1);
		vtws_query($query, $current_user, true);
		$actual = vtws_query($query, $current_user);
		$this->assertEquals(
			array(
				0 => array(
					'dtstart' => '2016-07-11 09:23:00',
					'modifiedtime' => '2015-09-22 17:38:25',
					'id' => '39x15139',
				),
			),
			$actual
		);
		/////////////
		$adb->pquery('update vtiger_crmentity set smownerid=? where crmid=?', array($this->usrutc3, 15139));
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrutc3); // testtz-3 'time_zone'=>'America/Argentina/Buenos_Aires'
		vtws_query($query, $current_user, true);
		$actual = vtws_query($query, $current_user);
		$this->assertEquals(
			array(
				0 => array(
					'dtstart' => '2016-07-11 09:23:00',
					'modifiedtime' => '2015-09-22 17:38:25',
					'id' => '39x15139',
				),
			),
			$actual
		);
		$adb->pquery('update vtiger_crmentity set smownerid=? where crmid=?', array($this->usrutc, 15139));
		/////////////
		/////////////
		$cmpID = vtws_getEntityId('Campaigns');
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrutc);
		$query = "select budgetcost,actualcost,expectedsalescount,expectedrevenue from Campaigns where id='".$cmpID."x4949';";
		$actual = vtws_query($query, $current_user);
		$this->assertEquals(
			array(
				0 => array(
					'budgetcost' => '6318.000000',
					'actualcost' => '1890.000000',
					'expectedsalescount' => '9738',
					'expectedrevenue' => '7833.000000',
					'id' => '1x4949',
				),
			),
			$actual
		);
		/////////////
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrutc1);
		vtws_query($query, $current_user, true);
		$actual = vtws_query($query, $current_user);
		$this->assertEquals(
			array(
				0 => array(
					'budgetcost' => '6318.000000',
					'actualcost' => '1890.000000',
					'expectedsalescount' => '9738',
					'expectedrevenue' => '7833.000000',
					'id' => '1x4949',
				),
			),
			$actual
		);
		$current_user = $holdUser;
	}

	/**
	 * Method testGVRetrieve
	 * @test
	 */
	public function testGVRetrieve() {
		global $current_user, $adb;
		$current_user = Users::getActiveAdminUser();
		$calID = vtws_getEntityId('cbCalendar');
		$usrwsid = vtws_getEntityId('Users').'x'.$current_user->id;
		$expected = array (
			'reminder_time' => '0',
			'subject' => 'Prism (Robbie)',
			'assigned_user_id' => '19x6',
			'date_start' => '07-11-2016',
			'dtstart' => '07-11-2016 09:23',
			'time_start' => '09:23:00',
			'due_date' => '07-11-2016',
			'dtend' => '07-11-2016 12:26',
			'time_end' => '12:26:00',
			'recurringtype' => '--None--',
			'rel_id' => '17x2649',
			'cto_id' => '12x1697',
			'eventstatus' => 'Held',
			'taskpriority' => 'High',
			'sendnotification' => '0',
			'createdtime' => '08-27-2015 00:04',
			'modifiedtime' => '09-22-2015 17:38',
			'activitytype' => 'Meeting',
			'duration_hours' => '0',
			'visibility' => '',
			'duration_minutes' => '0',
			'location' => 'Brecknockshire',
			'notime' => '0',
			'relatedwith' => '',
			'created_user_id' => '19x1',
			'modifiedby' => '19x1',
			'description' => 'Mauris nulla. Integer urna. Vivamus molestie dapibus ligula. Aliquam erat volutpat. Nulla dignissim. Maecenas ornare egestas ligula. Nullam',
			'followupdt' => '',
			'followuptype' => '',
			'followupcreate' => '',
			'id' => '39x15139',
			'cbuuid' => '1428a7fe386a0fc2603c296154fa9bd6e0f6ab15',
			'cto_idename' => array (
				'module' => 'Contacts',
				'reference' => 'Shelia Plues',
				'cbuuid' => '8561ba1f2316d6f10bed7635a90910dcc29ea510',
			),
			'created_user_idename' => array (
				'module' => 'Users',
				'reference' => ' Administrator',
				'cbuuid' => '',
			),
			'modifiedbyename' => array (
				'module' => 'Users',
				'reference' => ' Administrator',
				'cbuuid' => '',
			),
			'assigned_user_idename' => array (
				'module' => 'Users',
				'reference' => 'cbTest testmdy',
				'cbuuid' => '',
			),
		);
		// We always get values in database format
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrutc);
		$adb->pquery('update vtiger_crmentity set smownerid=? where crmid=?', array($this->usrutc, 15139));
		GlobalVariable::$currentScript = 'RetrieveTimezoneTest';
		GlobalVariable::$scriptOverride['RetrieveTimezoneTest']['Webservice_Return_FormattedValues'] = 1;
		$actual = vtws_retrieve($calID.'x15139', $current_user);
		$this->assertEquals($expected, $actual, 'retrieve calendar utc');
		/////////////
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrutc1);
		$adb->pquery('update vtiger_crmentity set smownerid=? where crmid=?', array($this->usrutc1, 15139));
		$expected['assigned_user_id'] = '19x'.$this->usrutc1;
		$expected['assigned_user_idename']['reference'] = 'cbTest testtz';
		$expected['date_start'] = '2016-07-11';
		$expected['dtstart'] = '2016-07-11 11:23';
		$expected['due_date'] = '2016-07-11';
		$expected['dtend'] = '2016-07-11 14:26';
		$expected['createdtime'] = '2015-08-27 02:04';
		$expected['modifiedtime'] = '2015-09-22 19:38';
		$actual = vtws_retrieve($calID.'x15139', $current_user);
		$this->assertEquals($expected, $actual, 'retrieve calendar utc+1');
		/////////////
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrutc3);
		$adb->pquery('update vtiger_crmentity set smownerid=? where crmid=?', array($this->usrutc3, 15139));
		$expected['assigned_user_id'] = '19x'.$this->usrutc3;
		$expected['assigned_user_idename']['reference'] = 'cbTest testtz-3';
		$expected['date_start'] = '2016-07-11';
		$expected['dtstart'] = '2016-07-11 06:23';
		$expected['due_date'] = '2016-07-11';
		$expected['dtend'] = '2016-07-11 09:26';
		$expected['createdtime'] = '2015-08-26 21:04';
		$expected['modifiedtime'] = '2015-09-22 14:38';
		$actual = vtws_retrieve($calID.'x15139', $current_user);
		$this->assertEquals($expected, $actual, 'retrieve calendar utc+3');
		/////////////
		/////////////
		$cmpID = vtws_getEntityId('Campaigns');
		$expected = array (
			'campaignname' => 'Viet Nam',
			'campaign_no' => 'CAM166',
			'assigned_user_id' => '19x12',
			'campaignstatus' => 'Completed',
			'campaigntype' => 'Webinar',
			'product_id' => '14x2618',
			'targetaudience' => 'Rookies',
			'closingdate' => '09-21-2015',
			'sponsor' => 'Finance',
			'targetsize' => '31670',
			'createdtime' => '04-29-2015 10:07',
			'numsent' => '1923,000000',
			'modifiedtime' => '06-07-2015 11:14',
			'modifiedby' => '19x1',
			'created_user_id' => '19x1',
			'budgetcost' => '6318,000000',
			'actualcost' => '1890,000000',
			'expectedresponse' => 'Good',
			'expectedrevenue' => '7833,000000',
			'expectedsalescount' => '9738',
			'actualsalescount' => '8876',
			'expectedresponsecount' => '5623',
			'actualresponsecount' => '5145',
			'expectedroi' => '8854,000000',
			'actualroi' => '4113,000000',
			'description' => 'convallis dolor. Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam, elementum at, egestas a, scelerisque',
			'id' => '1x4949',
			'cbuuid' => '7ad06a979248c7b4e30a96287c60d1959893c87c',
			'modifiedbyename' => array (
				'module' => 'Users',
				'reference' => ' Administrator',
				'cbuuid' => '',
			),
			'created_user_idename' => array (
				'module' => 'Users',
				'reference' => ' Administrator',
				'cbuuid' => '',
			),
			'assigned_user_idename' => array (
				'module' => 'Users',
				'reference' => 'cbTest testmcurrency',
				'cbuuid' => '',
			),
		);
		// We always get values in database format
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrutc);
		$actual = vtws_retrieve($cmpID.'x4949', $current_user);
		$this->assertEquals($expected, $actual, 'retrieve campaign utc');
		/////////////
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrutc1);
		$expected['closingdate']= '2015-09-21';
		$expected['createdtime']= '2015-04-29 12:07';
		$expected['modifiedtime']= '2015-06-07 13:14';
		$expected['numsent']= '1.923,000000';
		$expected['budgetcost']= '6.318,000000';
		$expected['actualcost']= '1.890,000000';
		$expected['expectedrevenue']= '7.833,000000';
		$expected['expectedroi']= '8.854,000000';
		$expected['actualroi']= '4.113,000000';
		$actual = vtws_retrieve($cmpID.'x4949', $current_user);
		$this->assertEquals($expected, $actual, 'retrieve calendar utc+1');
		/// end
		GlobalVariable::$currentScript = null;
		GlobalVariable::$scriptOverride['RetrieveTimezoneTest'] = null;
		$current_user = Users::getActiveAdminUser();
	}

	/**
	 * Method testGVQuery
	 * @test
	 */
	public function testGVQuery() {
		global $adb, $current_user, $log;
		$calID = vtws_getEntityId('cbCalendar');
		$holdUser = $current_user;
		$usrwsid = vtws_getEntityId('Users').'x'.$current_user->id;
		$rec =  array(
			'default_check' => '1',
			'mandatory' => '1',
			'blocked' => '0',
			'module_list' => '',
			'category' => 'Application',
			'in_module_list' => '0',
			'assigned_user_id' => $usrwsid,
			'gvname' => 'Webservice_Return_FormattedValues',
			'value' => 1,
		);
		$adb->pquery('update vtiger_crmentity set smownerid=? where crmid=?', array($this->usrutc, 15139));
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrutc);
		$query = "select dtstart,modifiedtime from cbCalendar where id='".$calID."x15139';";
		GlobalVariable::$currentScript = 'RetrieveTimezoneTest';
		GlobalVariable::$scriptOverride['RetrieveTimezoneTest']['Webservice_Return_FormattedValues'] = 1;
		vtws_query($query, $current_user, true);
		$actual = vtws_query($query, $current_user);
		$this->assertEquals(
			array(
				0 => array(
					'dtstart' => '07-11-2016 09:23',
					'modifiedtime' => '09-22-2015 17:38',
					'id' => '39x15139',
				),
			),
			$actual
		);
		/////////////
		$adb->pquery('update vtiger_crmentity set smownerid=? where crmid=?', array($this->usrutc1, 15139));
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrutc1);
		vtws_query($query, $current_user, true);
		$actual = vtws_query($query, $current_user);
		$this->assertEquals(
			array(
				0 => array(
					'dtstart' => '2016-07-11 11:23',
					'modifiedtime' => '2015-09-22 19:38',
					'id' => '39x15139',
				),
			),
			$actual
		);
		/////////////
		$adb->pquery('update vtiger_crmentity set smownerid=? where crmid=?', array($this->usrutc3, 15139));
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrutc3); // testtz-3 'time_zone'=>'America/Argentina/Buenos_Aires'
		vtws_query($query, $current_user, true);
		$actual = vtws_query($query, $current_user);
		$this->assertEquals(
			array(
				0 => array(
					'dtstart' => '2016-07-11 06:23',
					'modifiedtime' => '2015-09-22 14:38',
					'id' => '39x15139',
				),
			),
			$actual
		);
		$adb->pquery('update vtiger_crmentity set smownerid=? where crmid=?', array($this->usrutc, 15139));
		/////////////
		/////////////
		$cmpID = vtws_getEntityId('Campaigns');
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrutc);
		$query = "select budgetcost,actualcost,expectedsalescount,expectedrevenue from Campaigns where id='".$cmpID."x4949';";
		$actual = vtws_query($query, $current_user);
		$this->assertEquals(
			array(
				0 => array(
					'budgetcost' => '6318,000000',
					'actualcost' => '1890,000000',
					'expectedsalescount' => '9738',
					'expectedrevenue' => '7833,000000',
					'id' => '1x4949',
				),
			),
			$actual
		);
		/////////////
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrutc1);
		vtws_query($query, $current_user, true);
		$actual = vtws_query($query, $current_user);
		$this->assertEquals(
			array(
				0 => array(
					'budgetcost' => '6.318,000000',
					'actualcost' => '1.890,000000',
					'expectedsalescount' => '9738',
					'expectedrevenue' => '7.833,000000',
					'id' => '1x4949',
				),
			),
			$actual
		);
		GlobalVariable::$currentScript = null;
		GlobalVariable::$scriptOverride['RetrieveTimezoneTest'] = null;
		$current_user = $holdUser;
	}
}
?>