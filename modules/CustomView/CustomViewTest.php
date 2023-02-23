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
require_once 'modules/CustomView/CustomView.php';
require_once 'modules/CustomView/ListViewTop.php';
use PHPUnit\Framework\TestCase;

class CustomViewTest extends TestCase {

	/**
	 * Method testgetCVStdFilterSQL
	 * @test
	 */
	public function testgetCVStdFilterSQL() {
		global $current_user;
		$cv = new CustomView();
		$actual = $cv->getCVStdFilterSQL(4);
		$expected = '';
		$this->assertEquals($expected, $actual, 'getCVStdFilterSQL Accounts All');
		$actual = $cv->getCVStdFilterSQL(6);
		$thisweek0 = date('Y-m-d', strtotime('-1 week Sunday'));
		$thisweek1 = date('Y-m-d', strtotime('this Saturday'));
		$expected = "vtiger_crmentity.createdtime BETWEEN '".$thisweek0." 00:00:00' and '".$thisweek1." 23:59:00'";
		$this->assertEquals($expected, $actual, 'getCVStdFilterSQL Accounts New This Week');
		$actual = $cv->getCVStdFilterSQL(5);
		$expected = '';
		$this->assertEquals($expected, $actual, 'getCVStdFilterSQL Accounts Prospect Account');
		////////////////
		$actual = $cv->getCVStdFilterSQL(7);
		$expected = '';
		$this->assertEquals($expected, $actual, 'getCVStdFilterSQL Contacts All');
		$actual = $cv->getCVStdFilterSQL(9);
		$d = date('Y-m-d');
		$expected="DATE_FORMAT(vtiger_contactsubdetails.birthday, '%m%d') BETWEEN DATE_FORMAT('".$d." 00:00:00', '%m%d') and DATE_FORMAT('".$d." 23:59:00', '%m%d')";
		$this->assertEquals($expected, $actual, 'getCVStdFilterSQL Contacts Birthday');
	}

	/**
	 * Method testgetAdvFilterByCvid
	 * @test
	 */
	public function testgetAdvFilterByCvid() {
		global $current_user;
		$cv = new CustomView();
		$actual = $cv->getAdvFilterByCvid(11);
		$expected = array(
			1 => array(
				'columns' => array(
					array(
						'columnname' => 'vtiger_potential:sales_stage:sales_stage:Potentials_Sales_Stage:V',
						'comparator' => 'e',
						'value' => 'Closed Won',
						'column_condition' => '',
					),
				),
				'condition' => '',
			),
		);
		$this->assertEquals($expected, $actual, 'getAdvFilterByCvid Potential Won');
		$actual = $cv->getAdvFilterByCvid(17);
		$expected = array(
			1 => array(
				'columns' => array(
					array(
						'columnname' => 'vtiger_quotes:quotestage:quotestage:Quotes_Quote_Stage:V',
						'comparator' => 'n',
						'value' => 'Accepted',
						'column_condition' => 'and',
					),
					array(
						'columnname' => 'vtiger_quotes:quotestage:quotestage:Quotes_Quote_Stage:V',
						'comparator' => 'n',
						'value' => 'Rejected',
						'column_condition' => '',
					),
				),
				'condition' => '',
			),
		);
		$this->assertEquals($expected, $actual, 'getAdvFilterByCvid Quotes Stage');
		$actual = $cv->getAdvFilterByCvid(45);
		$expected = array(
			1 => array(
				'columns' => array(
					array(
						'columnname' => 'vtiger_cbupdater:execstate:execstate:cbupdater_execstate:V',
						'comparator' => 'e',
						'value' => 'Executed',
						'column_condition' => '',
					),
				),
				'condition' => '',
			),
		);
		$this->assertEquals($expected, $actual, 'getAdvFilterByCvid cbupdater execstate');
		$actual = $cv->getAdvFilterByCvid(92);
		$expected = array(
			1 => array(
				'columns' => array(
					0 => array(
						'columnname' => 'vtiger_account:accountname:accountname:Accounts_Account_Name:V',
						'comparator' => 'c',
						'value' => 'a',
						'column_condition' => 'and',
					),
					1 => array(
						'columnname' => 'vtiger_account:employees:employees:Accounts_Employees:I',
						'comparator' => 'l',
						'value' => '50',
						'column_condition' => '',
					),
				),
				'condition' => 'or',
			),
			2 => array(
				'columns' => array(
					2 => array(
						'columnname' => 'vtiger_account:accountname:accountname:Accounts_Account_Name:V',
						'comparator' => 'k',
						'value' => 'a',
						'column_condition' => 'and',
					),
					3 => array(
						'columnname' => 'vtiger_account:employees:employees:Accounts_Employees:I',
						'comparator' => 'g',
						'value' => '40',
						'column_condition' => '',
					),
				),
				'condition' => '',
			)
		);
		$this->assertEquals($expected, $actual, 'getAdvFilterByCvid  account grouped condition');
	}

	/**
	 * Method testgetAdvFilterByCvidWithCurrentUser
	 * @test
	 */
	public function testgetAdvFilterByCvidWithCurrentUser() {
		global $current_user;
		unset($_REQUEST['action'], $_REQUEST['record']);
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(1); // admin
		$current_user = $user;
		$cv = new CustomView('Accounts');
		$actual = $cv->getAdvFilterByCvid(82);
		$expected = array(
			1 => array(
				'columns' => array(
					array(
						'columnname' => 'vtiger_crmentity:smownerid:assigned_user_id:Accounts_Assigned_To:V',
						'comparator' => 'e',
						'value' => 'Administrator',
						'column_condition' => '',
					),
				),
				'condition' => '',
			),
		);
		$this->assertEquals($expected, $actual, 'getAdvFilterByCvid current_user admin');
		$cv = new CustomView('CobroPago');
		$actual = $cv->getAdvFilterByCvid(81);
		$expected = array(
			1 => array(
				'columns' => array(
					array(
						'columnname' => 'vtiger_cobropago:comercialid:reports_to_id:CobroPago_Comercial:V',
						'comparator' => 'e',
						'value' => 'Administrator',
						'column_condition' => '',
					),
				),
				'condition' => '',
			),
		);
		$this->assertEquals($expected, $actual, 'getAdvFilterByCvid current_user 101 admin');
		//////
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(6); // testmdy
		$current_user = $user;
		$cv = new CustomView('Accounts');
		$actual = $cv->getAdvFilterByCvid(82);
		$expected = array(
			1 => array(
				'columns' => array(
					array(
						'columnname' => 'vtiger_crmentity:smownerid:assigned_user_id:Accounts_Assigned_To:V',
						'comparator' => 'e',
						'value' => 'cbTest testmdy',
						'column_condition' => '',
					),
				),
				'condition' => '',
			),
		);
		$this->assertEquals($expected, $actual, 'getAdvFilterByCvid current_user testmdy');
		$cv = new CustomView('CobroPago');
		$actual = $cv->getAdvFilterByCvid(81);
		$expected = array(
			1 => array(
				'columns' => array(
					array(
						'columnname' => 'vtiger_cobropago:comercialid:reports_to_id:CobroPago_Comercial:V',
						'comparator' => 'e',
						'value' => 'cbTest testmdy',
						'column_condition' => '',
					),
				),
				'condition' => '',
			),
		);
		$this->assertEquals($expected, $actual, 'getAdvFilterByCvid current_user 101 testmdy');
		$current_user = $holduser;
	}

	/**
	 * Method testgetCVAdvFilterSQL
	 * @test
	 */
	public function testgetCVAdvFilterSQL() {
		global $current_user;
		$cv = new CustomView();
		$actual = $cv->getCVAdvFilterSQL(11);
		$expected = "(( vtiger_potential.sales_stage = 'Closed Won' ) )";
		$this->assertEquals($expected, $actual, 'getCVAdvFilterSQL Potential Won');
		$actual = $cv->getCVAdvFilterSQL(17);
		$expected = "(( vtiger_quotes.quotestage != 'Accepted' and vtiger_quotes.quotestage != 'Rejected' ) )";
		$this->assertEquals($expected, $actual, 'getCVAdvFilterSQL Quotes Stage');
		$actual = $cv->getCVAdvFilterSQL(45);
		$expected = "(( vtiger_cbupdater.execstate = 'Executed' ) )";
		$this->assertEquals($expected, $actual, 'getCVAdvFilterSQL cbupdater execstate');
		$actual = $cv->getCVAdvFilterSQL(92);
		$expected = "(( vtiger_account.accountname like '%a%' and vtiger_account.employees < '50' )  or ( vtiger_account.accountname not like '%a%' and vtiger_account.employees > '40' ) )";
		$this->assertEquals($expected, $actual, 'getCVAdvFilterSQL account grouped condition');
	}

	/**
	 * Method getMetricListProvider
	 * params
	 */
	public function getMetricListProvider() {
		$expected_metriclist_admin = array(
			array('id' => '5', 'name' => 'Prospect Accounts', 'module' => 'Accounts', 'user' => ' Administrator', 'count' => ''),
			array('id' => '52', 'name' => 'payview', 'module' => 'CobroPago', 'user' => ' Administrator', 'count' => ''),
			array('id' => '14', 'name' => 'Open Tickets', 'module' => 'HelpDesk', 'user' => ' Administrator', 'count' => ''),
			array('id' => '2', 'name' => 'Hot Leads', 'module' => 'Leads', 'user' => ' Administrator', 'count' => ''),
			array('id' => '11', 'name' => 'Potentials Won', 'module' => 'Potentials', 'user' => ' Administrator', 'count' => ''),
			array('id' => '17','name' => 'Open Quotes', 'module' => 'Quotes', 'user' => ' Administrator', 'count' => ''));

		$expected_metriclist_testmdy = array(
			array('id' => '5', 'name' => 'Prospect Accounts', 'module' => 'Accounts', 'user' => ' Administrator', 'count' => ''),
			array('id' => '52', 'name' => 'payview', 'module' => 'CobroPago', 'user' => ' Administrator', 'count' => ''),
			array('id' => '14', 'name' => 'Open Tickets', 'module' => 'HelpDesk', 'user' => ' Administrator', 'count' => ''),
			array('id' => '2', 'name' => 'Hot Leads', 'module' => 'Leads', 'user' => ' Administrator', 'count' => ''),
			array('id' => '11', 'name' => 'Potentials Won', 'module' => 'Potentials', 'user' => ' Administrator', 'count' => ''),
			array('id' => '17','name' => 'Open Quotes', 'module' => 'Quotes', 'user' => ' Administrator', 'count' => '')
		);
		return array(
			array(1, $expected_metriclist_admin),
			array(6, $expected_metriclist_testmdy)
		);
	}

	/**
	 * Method getCustomViewByCvidProvider
	 * params
	 */
	public function getCustomViewByCvidProvider() {
		$expected_leads_admin_value = array(
			'viewname' => 'All',
			'setdefault' => '1',
			'setmetrics' => '0',
			'userid' => '1',
			'status' => '0',
			'setPrivate' => null,
			'sortfieldbyfirst' => null,
			'sortfieldbysecond' => null,
		);
		$expected_contacts_admin_value = array(
			'viewname' => 'All',
			'setdefault' => '1',
			'setmetrics' => '0',
			'userid' => '1',
			'status' => '0',
			'setPrivate' => null,
			'sortfieldbyfirst' => null,
			'sortfieldbysecond' => null,
		);
		$expected_accounts_admin_value = array(
			'viewname' => 'All',
			'setdefault' => '1',
			'setmetrics' => '0',
			'userid' => '1',
			'status' => '0',
			'setPrivate' => null,
			'sortfieldbyfirst' => null,
			'sortfieldbysecond' => null,
		);
		$expected_potentials_admin_value = array(
			'viewname' => 'All',
			'setdefault' => '1',
			'setmetrics' => '0',
			'userid' => '1',
			'status' => '0',
			'setPrivate' => null,
			'sortfieldbyfirst' => null,
			'sortfieldbysecond' => null,
		);
		$expected_salesorder_admin_value = array(
			'viewname' => 'All',
			'setdefault' => '1',
			'setmetrics' => '0',
			'userid' => '1',
			'status' => '0',
			'setPrivate' => null,
			'sortfieldbyfirst' => null,
			'sortfieldbysecond' => null,
		);
		$expected_leads_testmdy_value = array(
			'viewname' => 'All',
			'setdefault' => '1',
			'setmetrics' => '0',
			'userid' => '1',
			'status' => '0',
			'setPrivate' => null,
			'sortfieldbyfirst' => null,
			'sortfieldbysecond' => null,
		);
		$expected_contacts_testmdy_value = array(
			'viewname' => 'All',
			'setdefault' => '1',
			'setmetrics' => '0',
			'userid' => '1',
			'status' => '0',
			'setPrivate' => null,
			'sortfieldbyfirst' => null,
			'sortfieldbysecond' => null,
		);
		$expected_accounts_testmdy_value = array(
			'viewname' => 'All',
			'setdefault' => '1',
			'setmetrics' => '0',
			'userid' => '1',
			'status' => '0',
			'setPrivate' => null,
			'sortfieldbyfirst' => null,
			'sortfieldbysecond' => null,
		);
		$expected_potentials_testmdy_value = array(
			'viewname' => 'All',
			'setdefault' => '1',
			'setmetrics' => '0',
			'userid' => '1',
			'status' => '0',
			'setPrivate' => null,
			'sortfieldbyfirst' => null,
			'sortfieldbysecond' => null,
		);
		$expected_salesorder_testmdy_value = array(
			'viewname' => 'All',
			'setdefault' => '1',
			'setmetrics' => '0',
			'userid' => '1',
			'status' => '0',
			'setPrivate' => null,
			'sortfieldbyfirst' => null,
			'sortfieldbysecond' => null,
		);
		return array(
			array('Leads', 1, $expected_leads_admin_value),
			array('Contacts', 1, $expected_contacts_admin_value),
			array('Accounts', 1, $expected_accounts_admin_value),
			array('Potentials', 1, $expected_potentials_admin_value),
			array('SalesOrder', 1, $expected_salesorder_admin_value),
			array('Leads', 6, $expected_leads_testmdy_value),
			array('Contacts', 6, $expected_contacts_testmdy_value),
			array('Accounts', 6, $expected_accounts_testmdy_value),
			array('Potentials', 6, $expected_potentials_testmdy_value),
			array('SalesOrder', 6, $expected_salesorder_testmdy_value)
		);
	}

	/**
	 * Method getCustomViewComboProvider
	 * params
	 */
	public function getCustomViewComboProvider() {
		$expected_leads_admin_combo = '<option selected value="1">All</option><option value="2">Hot Leads</option><option value="3">This Month Leads</option>';
		$expected_contacts_admin_combo = '<option selected value="7">All</option><option value="8">Contacts Address</option><option value="9">Todays Birthday</option>';
		$expected_accounts_admin_combo = '<option selected value="4">All</option><option value="5">Prospect Accounts</option><option value="6">New This Week</option><option value="82">current_user</option><option value="92">Group Condition</option>';
		$expected_potentials_admin_combo = '<option selected value="10">All</option><option value="11">Potentials Won</option><option value="12">Prospecting</option>';
		$expected_salesorder_admin_combo = '<option selected value="26">All</option><option value="37">Pending Sales Orders</option>';
		$expected_leads_testmdy_combo = '<option selected value="1">All</option><option disabled>--- Public ---</option><option value="2">Hot Leads [ Administrator] </option><option value="3">This Month Leads [ Administrator] </option>';
		$expected_contacts_testmdy_combo = '<option selected value="7">All</option><option disabled>--- Public ---</option><option value="8">Contacts Address [ Administrator] </option><option value="9">Todays Birthday [ Administrator] </option>';
		$expected_accounts_testmdy_combo = '<option selected value="4">All</option><option disabled>--- Public ---</option><option value="5">Prospect Accounts [ Administrator] </option><option value="6">New This Week [ Administrator] </option><option disabled>--- Others ---</option><option value="92">Group Condition [ Administrator] </option><option value="82">current_user [ Administrator] </option>';
		$expected_potentials_testmdy_combo = '<option selected value="10">All</option><option disabled>--- Public ---</option><option value="11">Potentials Won [ Administrator] </option><option value="12">Prospecting [ Administrator] </option>';
		$expected_salesorder_testmdy_combo = '<option selected value="26">All</option><option disabled>--- Public ---</option><option value="37">Pending Sales Orders [ Administrator] </option>';
		return array(
			array('Leads', 1, $expected_leads_admin_combo),
			array('Contacts', 1,  $expected_contacts_admin_combo),
			array('Accounts', 1, $expected_accounts_admin_combo),
			array('Potentials', 1, $expected_potentials_admin_combo),
			array('SalesOrder', 1, $expected_salesorder_admin_combo),
			array('Leads', 6, $expected_leads_testmdy_combo),
			array('Contacts', 6,  $expected_contacts_testmdy_combo),
			array('Accounts', 6, $expected_accounts_testmdy_combo),
			array('Potentials', 6, $expected_potentials_testmdy_combo),
			array('SalesOrder', 6, $expected_salesorder_testmdy_combo)
		);
	}

	/**
	 * Method testgetCustomViewCombo
	 * @test
	 * @dataProvider getCustomViewComboProvider
	 */
	public function testgetCustomViewCombo($currentModule, $userid, $expected_combo_values) {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($userid);
		$current_user = $user;
		$customView = new CustomView($currentModule);
		$viewid = $customView->getViewId($currentModule);
		$actual = $customView->getCustomViewCombo($viewid);
		$this->assertEquals($expected_combo_values, $actual, "Test getCustomViewCombo Method on $currentModule Module");
		$current_user = $holduser;
	}

	/**
	 * Method testgetCustomViewByCvid
	 * @test
	 * @dataProvider getCustomViewByCvidProvider
	 */
	public function testgetCustomViewByCvid($currentModule, $userid, $expected_cvid_values) {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($userid);
		$current_user = $user;
		$customView = new CustomView($currentModule);
		$viewid = $customView->getViewId($currentModule);
		$actual = $customView->getCustomViewByCvid($viewid);
		$this->assertEquals($expected_cvid_values, $actual, "Test getCustomViewByCvid Method on $currentModule Module");
		$current_user = $holduser;
	}

	/**
	 * Method testgetMetricList
	 * @test
	 * @dataProvider getMetricListProvider
	 */
	public function testgetMetricList($userid, $expected_cvid_values) {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($userid);
		$current_user = $user;
		$actual = getMetricList();
		$this->assertEquals($expected_cvid_values, $actual, "Test getMetricList Method on User with Id: $userid");
		$current_user = $holduser;
	}

	/**
	 * Method getColumnsListbyBlockProvider
	 * params
	 */
	public function getColumnsListbyBlockProvider() {
		$expected_blck_asset = array(
			'vtiger_assets:asset_no:asset_no:Assets_Asset_No:V' => 'Asset No',
			'vtiger_assets:product:product:Assets_Product_Name:V' => 'Product Name',
			'vtiger_assets:serialnumber:serialnumber:Assets_Serial_Number:V' => 'Serial Number',
			'vtiger_crmentity:smownerid:assigned_user_id:Assets_Assigned_To:V' => 'Assigned To',
			'vtiger_assets:datesold:datesold:Assets_Date_Sold:D' => 'Date Sold',
			'vtiger_assets:dateinservice:dateinservice:Assets_Date_in_Service:D' => 'Date in Service',
			'vtiger_assets:assetstatus:assetstatus:Assets_Status:V' => 'Status',
			'vtiger_assets:tagnumber:tagnumber:Assets_Tag_Number:V' => 'Tag Number',
			'vtiger_assets:invoiceid:invoiceid:Assets_Invoice_Name:V' => 'Invoice Name',
			'vtiger_assets:shippingmethod:shippingmethod:Assets_Shipping_Method:V' => 'Shipping Method',
			'vtiger_assets:shippingtrackingnumber:shippingtrackingnumber:Assets_Shipping_Tracking_Number:V' => 'Shipping Tracking Number',
			'vtiger_assets:assetname:assetname:Assets_Asset_Name:V' => 'Asset Name',
			'vtiger_assets:account:account:Assets_Customer_Name:V' => 'Customer Name',
			'vtiger_crmentity:createdtime:createdtime:Assets_Created_Time:DT' => 'Created Time',
			'vtiger_crmentity:modifiedtime:modifiedtime:Assets_Modified_Time:DT' => 'Modified Time',
			'vtiger_crmentity:modifiedby:modifiedby:Assets_Last_Modified_By:V' => 'Last Modified By',
			'vtiger_crmentity:smcreatorid:created_user_id:Assets_Created_By:V' => 'Created By',
		);
		$expected_blck_assetM = array(
			"'vtiger_assets:product:product:Assets_Product_Name:V'",
			"'vtiger_assets:serialnumber:serialnumber:Assets_Serial_Number:V'",
			"'vtiger_crmentity:smownerid:assigned_user_id:Assets_Assigned_To:V'",
			"'vtiger_assets:datesold:datesold:Assets_Date_Sold:D'",
			"'vtiger_assets:dateinservice:dateinservice:Assets_Date_in_Service:D'",
			"'vtiger_assets:assetstatus:assetstatus:Assets_Status:V'",
			"'vtiger_assets:assetname:assetname:Assets_Asset_Name:V'",
			"'vtiger_assets:account:account:Assets_Customer_Name:V'",
		);
		$expected_blck_assetS = array(
			'Product Name',
			'Serial Number',
			'Assigned To',
			'Date Sold',
			'Date in Service',
			'Status',
			'Asset Name',
			'Customer Name',
		);
		$expected_blck_assetD = array(
			'Product Name' => 'M',
			'Serial Number' => 'M',
			'Assigned To' => 'M',
			'Date Sold' => 'M',
			'Date in Service' => 'M',
			'Status' => 'M',
			'Asset Name' => 'M',
			'Customer Name' => 'M',
		);
		$expected_blckHD = array('vtiger_troubletickets:solution:solution:HelpDesk_Solution:V' => 'Solution');
		$expected_blck_cbcal = array(
			'vtiger_activity:subject:subject:cbCalendar_Subject:V' => 'Subject',
			'vtiger_activity_reminder:reminder_time:reminder_time:cbCalendar_Send_Reminder:I' => 'Send Reminder',
			'vtiger_crmentity:smownerid:assigned_user_id:cbCalendar_Assigned_To:V' => 'Assigned To',
			'vtiger_activity:dtstart:dtstart:cbCalendar_Start_Date_Time:DT' => 'Start Date Time',
			'vtiger_activity:date_start:date_start:cbCalendar_Start_Date:DT' => 'Start Date',
			'vtiger_activity:time_start:time_start:cbCalendar_Time_Start:T' => 'Time Start (System Time)',
			'vtiger_activity:dtend:dtend:cbCalendar_Due_Date:D' => 'Due Date',
			'vtiger_activity:due_date:due_date:cbCalendar_End_Date:D' => 'End Date',
			'vtiger_activity:time_end:time_end:cbCalendar_End_Time:T' => 'End Time (System Time)',
			'vtiger_activity:recurringtype:recurringtype:cbCalendar_Recurrence:O' => 'Recurrence',
			'vtiger_activity:rel_id:rel_id:cbCalendar_Related_to:V' => 'Related To',
			'vtiger_activity:cto_id:cto_id:cbCalendar_Contact_Name:V' => 'Contact Name',
			'vtiger_activity:eventstatus:eventstatus:cbCalendar_Status:V' => 'Status',
			'vtiger_activity:priority:taskpriority:cbCalendar_Priority:V' => 'Priority',
			'vtiger_activity:sendnotification:sendnotification:cbCalendar_Send_Notification:C' => 'Send Notification',
			'vtiger_crmentity:createdtime:createdtime:cbCalendar_Created_Time:DT' => 'Created Time',
			'vtiger_crmentity:modifiedtime:modifiedtime:cbCalendar_Modified_Time:DT' => 'Modified Time',
			'vtiger_activity:activitytype:activitytype:cbCalendar_Activity_Type:V' => 'Activity Type',
			'vtiger_activity:visibility:visibility:cbCalendar_Visibility:V' => 'Visibility',
			'vtiger_activity:duration_hours:duration_hours:cbCalendar_Duration:I' => 'Duration',
			'vtiger_activity:duration_minutes:duration_minutes:cbCalendar_Duration_Minutes:I' => 'Duration Minutes',
			'vtiger_activity:location:location:cbCalendar_Location:V' => 'Location',
			'vtiger_activity:notime:notime:cbCalendar_No_Time:C' => 'All Day',
			'vtiger_activity:relatedwith:relatedwith:cbCalendar_Related_with:V' => 'Related To Do',
			'vtiger_crmentity:smcreatorid:created_user_id:cbCalendar_Created_By:V' => 'Created By',
			'vtiger_crmentity:modifiedby:modifiedby:cbCalendar_Last_Modified_By:V' => 'Last Modified By',
		);
		return array(
			array('Assets', 102, true, 1, [], null, null, null, 'asset admin incorrect block'),
			array('Assets', 102, true, 5, [], null, null, null, 'asset user incorrect block'),
			array('Assets', 1000002, true, 1, [], null, null, null, 'asset admin inexistent block'),
			array('Assets', 1000002, true, 5, [], null, null, null, 'asset user  inexistent block'),
			array('Assets', 103, true, 1, $expected_blck_asset, $expected_blck_assetM, $expected_blck_assetS, $expected_blck_assetD, 'asset admin mandatory'),
			array('Assets', 103, true, 5, $expected_blck_asset, $expected_blck_assetM, $expected_blck_assetS, $expected_blck_assetD, 'asset user mandatory'),
			array('Assets', 103, false, 1, $expected_blck_asset, null, null, null, 'asset admin not mandatory'),
			array('Assets', 103, false, 5, $expected_blck_asset, null, null, null, 'asset user not mandatory'),
			array('HelpDesk', 29, true, 1, $expected_blckHD, null, null, null, 'helpdesk admin mandatory'),
			array('HelpDesk', 29, false, 1, $expected_blckHD, null, null, null, 'helpdesk admin not mandatory'),
			array('cbCalendar', 135, false, 1, $expected_blck_cbcal, null, null, null, 'cbcalendar admin not mandatory'),
		);
	}

	/**
	 * Method testgetColumnsListbyBlock
	 * @test
	 * @dataProvider getColumnsListbyBlockProvider
	 */
	public function testgetColumnsListbyBlock($module, $block, $markMandatory, $userid, $expected, $em, $es, $ed, $msg) {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($userid);
		$current_user = $user;
		$customView = new CustomView($module);
		$this->assertEquals($expected, $customView->getColumnsListbyBlock($module, $block, $markMandatory), $msg);
		$this->assertEquals($em, $customView->mandatoryvalues, $msg);
		$this->assertEquals($es, $customView->showvalues, $msg);
		$this->assertEquals($ed, $customView->data_type, $msg);
		$current_user = $holduser;
	}

	/**
	 * Method getModuleColumnsListProvider
	 * params
	 */
	public function getModuleColumnsListProvider() {
		$expected_gv = array(
			'GlobalVariable' => array(
				'Global Variable Information' => array(
					'gvname' => array(
						'label' => 'Name',
						'value' => 'vtiger_globalvariable:gvname:gvname:GlobalVariable_Name:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'default_check' => array(
						'label' => 'Default',
						'value' => 'vtiger_globalvariable:default_check:default_check:GlobalVariable_Default:C',
						'selected' => '',
						'typeofdata' => 'C',
					),
					'value' => array(
						'label' => 'Value',
						'value' => 'vtiger_globalvariable:value:value:GlobalVariable_Value:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'mandatory' => array(
						'label' => 'Mandatory',
						'value' => 'vtiger_globalvariable:mandatory:mandatory:GlobalVariable_Mandatory:C',
						'selected' => '',
						'typeofdata' => 'C',
					),
					'assigned_user_id' => array(
						'label' => 'User',
						'value' => 'vtiger_crmentity:smownerid:assigned_user_id:GlobalVariable_User:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'blocked' => array(
						'label' => 'Blocked',
						'value' => 'vtiger_globalvariable:blocked:blocked:GlobalVariable_Blocked:C',
						'selected' => '',
						'typeofdata' => 'C',
					),
					'module_list' => array(
						'label' => 'Module List',
						'value' => 'vtiger_globalvariable:module_list:module_list:GlobalVariable_Module_List:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'category' => array(
						'label' => 'Category',
						'value' => 'vtiger_globalvariable:category:category:GlobalVariable_Category:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'in_module_list' => array(
						'label' => 'In Module List',
						'value' => 'vtiger_globalvariable:in_module_list:in_module_list:GlobalVariable_In_Module_List:C',
						'selected' => '',
						'typeofdata' => 'C',
					),
					'globalno' => array(
						'label' => 'Global No',
						'value' => 'vtiger_globalvariable:globalno:globalno:GlobalVariable_Globalno:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'createdtime' => array(
						'label' => 'Created Time',
						'value' => 'vtiger_crmentity:createdtime:createdtime:GlobalVariable_Created_Time:DT',
						'selected' => '',
						'typeofdata' => 'DT',
					),
					'modifiedtime' => array(
						'label' => 'Modified Time',
						'value' => 'vtiger_crmentity:modifiedtime:modifiedtime:GlobalVariable_Modified_Time:DT',
						'selected' => '',
						'typeofdata' => 'DT',
					),
					'bmapid' => array(
						'label' => 'Business Map',
						'value' => 'vtiger_globalvariable:bmapid:bmapid:GlobalVariable_cbMap:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'created_user_id' => array(
						'label' => 'Created By',
						'value' => 'vtiger_crmentity:smcreatorid:created_user_id:GlobalVariable_Created_By:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'rolegv' => array(
						'label' => 'Role',
						'value' => 'vtiger_globalvariable:rolegv:rolegv:GlobalVariable_Role:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'viewtype' => array(
						'label' => 'View Type',
						'value' => 'vtiger_globalvariable:viewtype:viewtype:GlobalVariable_View_Type:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
				),
				'Description' => array(
					'description' => array(
						'label' => 'Description',
						'value' => 'vtiger_crmentity:description:description:GlobalVariable_Description:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
				),
			),
			'cbMap' => array(
				'Business Map Information' => array(
					'mapname' => array(
						'label' => 'Map Name',
						'value' => 'vtiger_cbmap:mapname:mapname:cbMap_Map_Name:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'mapnumber' => array(
						'label' => 'Map Number',
						'value' => 'vtiger_cbmap:mapnumber:mapnumber:cbMap_Map_Number:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'maptype' => array(
						'label' => 'Map Type',
						'value' => 'vtiger_cbmap:maptype:maptype:cbMap_Map_Type:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'targetname' => array(
						'label' => 'Target Module',
						'value' => 'vtiger_cbmap:targetname:targetname:cbMap_Target_Module:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'content' => array(
						'label' => 'Content',
						'value' => 'vtiger_cbmap:content:content:cbMap_Content:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'assigned_user_id' => array(
						'label' => 'Assigned To',
						'value' => 'vtiger_crmentity:smownerid:assigned_user_id:cbMap_Assigned_To:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'createdtime' => array(
						'label' => 'Created Time',
						'value' => 'vtiger_crmentity:createdtime:createdtime:cbMap_Created_Time:DT',
						'selected' => '',
						'typeofdata' => 'DT',
					),
					'modifiedtime' => array(
						'label' => 'Modified Time',
						'value' => 'vtiger_crmentity:modifiedtime:modifiedtime:cbMap_Modified_Time:DT',
						'selected' => '',
						'typeofdata' => 'DT',
					),
					'created_user_id' => array(
						'label' => 'Created By',
						'value' => 'vtiger_crmentity:smcreatorid:created_user_id:cbMap_Created_By:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'contentjson' => array(
						'label' => 'ContentJson',
						'value' => 'vtiger_cbmap:contentjson:contentjson:cbMap_ContentJson:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
				),
				'Description' => array(
					'description' => array(
						'label' => 'Description',
						'value' => 'vtiger_crmentity:description:description:cbMap_Description:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
				),
			),
		);
		$expected_tc = array(
			'cbTermConditions' => array(
				'Terms and Conditions Information' => array(
					'cbtandcno' => array(
						'label' => 'Terms and Conditions No',
						'value' => 'vtiger_cbtandc:cbtandcno:cbtandcno:cbTermConditions_TandC_No:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'reference' => array(
						'label' => 'Reference',
						'value' => 'vtiger_cbtandc:reference:reference:cbTermConditions_Reference:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'isdefault' => array(
						'label' => 'Is Default',
						'value' => 'vtiger_cbtandc:isdefault:isdefault:cbTermConditions_Is_Default:C',
						'selected' => '',
						'typeofdata' => 'C',
					),
					'formodule' => array(
						'label' => 'For Module',
						'value' => 'vtiger_cbtandc:formodule:formodule:cbTermConditions_formodule:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'srvcto' => array(
						'label' => 'ServiceContracts',
						'value' => 'vtiger_cbtandc:srvcto:srvcto:cbTermConditions_ServiceContracts:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'copyfrom' => array(
						'label' => 'Copy From',
						'value' => 'vtiger_cbtandc:copyfrom:copyfrom:cbTermConditions_Copy_From:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'assigned_user_id' => array(
						'label' => 'Assigned To',
						'value' => 'vtiger_crmentity:smownerid:assigned_user_id:cbTermConditions_Assigned_To:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'createdtime' => array(
						'label' => 'Created Time',
						'value' => 'vtiger_crmentity:createdtime:createdtime:cbTermConditions_Created_Time:DT',
						'selected' => '',
						'typeofdata' => 'DT',
					),
					'modifiedtime' => array(
						'label' => 'Modified Time',
						'value' => 'vtiger_crmentity:modifiedtime:modifiedtime:cbTermConditions_Modified_Time:DT',
						'selected' => '',
						'typeofdata' => 'DT',
					),
				),
				'Terms and Conditions' => array(
					'tandc' => array(
						'label' => 'Terms and Conditions',
						'value' => 'vtiger_cbtandc:tandc:tandc:cbTermConditions_Terms_and_Conditions:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
				),
				'Description' => array(
					'description' => array(
						'label' => 'Description',
						'value' => 'vtiger_crmentity:description:description:cbTermConditions_Description:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
				),
			),
			'ServiceContracts' => array(
				'Service Contract Information' => array(
					'subject' => array(
						'label' => 'Subject',
						'value' => 'vtiger_servicecontracts:subject:subject:ServiceContracts_Subject:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'contract_no' => array(
						'label' => 'Contract No',
						'value' => 'vtiger_servicecontracts:contract_no:contract_no:ServiceContracts_Contract_No:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'sc_related_to' => array(
						'label' => 'Related to',
						'value' => 'vtiger_servicecontracts:sc_related_to:sc_related_to:ServiceContracts_Related_to:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'assigned_user_id' => array(
						'label' => 'Assigned To',
						'value' => 'vtiger_crmentity:smownerid:assigned_user_id:ServiceContracts_Assigned_To:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'contract_type' => array(
						'label' => 'Type',
						'value' => 'vtiger_servicecontracts:contract_type:contract_type:ServiceContracts_Type:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'tracking_unit' => array(
						'label' => 'Tracking Unit',
						'value' => 'vtiger_servicecontracts:tracking_unit:tracking_unit:ServiceContracts_Tracking_Unit:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'start_date' => array(
						'label' => 'Start Date',
						'value' => 'vtiger_servicecontracts:start_date:start_date:ServiceContracts_Start_Date:D',
						'selected' => '',
						'typeofdata' => 'D',
					),
					'total_units' => array(
						'label' => 'Total Units',
						'value' => 'vtiger_servicecontracts:total_units:total_units:ServiceContracts_Total_Units:N',
						'selected' => '',
						'typeofdata' => 'N',
					),
					'due_date' => array(
						'label' => 'Due Date',
						'value' => 'vtiger_servicecontracts:due_date:due_date:ServiceContracts_Due_date:D',
						'selected' => '',
						'typeofdata' => 'D',
					),
					'used_units' => array(
						'label' => 'Used Units',
						'value' => 'vtiger_servicecontracts:used_units:used_units:ServiceContracts_Used_Units:N',
						'selected' => '',
						'typeofdata' => 'N',
					),
					'end_date' => array(
						'label' => 'End Date',
						'value' => 'vtiger_servicecontracts:end_date:end_date:ServiceContracts_End_Date:D',
						'selected' => '',
						'typeofdata' => 'D',
					),
					'contract_status' => array(
						'label' => 'Status',
						'value' => 'vtiger_servicecontracts:contract_status:contract_status:ServiceContracts_Status:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'planned_duration' => array(
						'label' => 'Planned Duration (in Days)',
						'value' => 'vtiger_servicecontracts:planned_duration:planned_duration:ServiceContracts_Planned_Duration:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'contract_priority' => array(
						'label' => 'Priority',
						'value' => 'vtiger_servicecontracts:priority:contract_priority:ServiceContracts_Priority:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'actual_duration' => array(
						'label' => 'Actual Duration (in Days)',
						'value' => 'vtiger_servicecontracts:actual_duration:actual_duration:ServiceContracts_Actual_Duration:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'progress' => array(
						'label' => 'Progress',
						'value' => 'vtiger_servicecontracts:progress:progress:ServiceContracts_Progress:N',
						'selected' => '',
						'typeofdata' => 'N',
					),
					'createdtime' => array(
						'label' => 'Created Time',
						'value' => 'vtiger_crmentity:createdtime:createdtime:ServiceContracts_Created_Time:DT',
						'selected' => '',
						'typeofdata' => 'DT',
					),
					'modifiedtime' => array(
						'label' => 'Modified Time',
						'value' => 'vtiger_crmentity:modifiedtime:modifiedtime:ServiceContracts_Modified_Time:DT',
						'selected' => '',
						'typeofdata' => 'DT',
					),
					'created_user_id' => array(
						'label' => 'Created By',
						'value' => 'vtiger_crmentity:smcreatorid:created_user_id:ServiceContracts_Created_By:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
					'modifiedby' => array(
						'label' => 'Last Modified By',
						'value' => 'vtiger_crmentity:modifiedby:modifiedby:ServiceContracts_Last_Modified_By:V',
						'selected' => '',
						'typeofdata' => 'V',
					),
				),
			),
		);
		$expected_tcflat = array(
			'cbTermConditions' => array(
				'Terms and Conditions Information' => array(
					'vtiger_cbtandc:cbtandcno:cbtandcno:cbTermConditions_TandC_No:V' => 'Terms and Conditions No',
					'vtiger_cbtandc:reference:reference:cbTermConditions_Reference:V' => 'Reference',
					'vtiger_cbtandc:isdefault:isdefault:cbTermConditions_Is_Default:C' => 'Is Default',
					'vtiger_cbtandc:formodule:formodule:cbTermConditions_formodule:V' => 'For Module',
					'vtiger_cbtandc:srvcto:srvcto:cbTermConditions_ServiceContracts:V' => 'ServiceContracts',
					'vtiger_cbtandc:copyfrom:copyfrom:cbTermConditions_Copy_From:V' => 'Copy From',
					'vtiger_crmentity:smownerid:assigned_user_id:cbTermConditions_Assigned_To:V' => 'Assigned To',
					'vtiger_crmentity:createdtime:createdtime:cbTermConditions_Created_Time:DT' => 'Created Time',
					'vtiger_crmentity:modifiedtime:modifiedtime:cbTermConditions_Modified_Time:DT' => 'Modified Time',
				),
				'Terms and Conditions' => array(
					'vtiger_cbtandc:tandc:tandc:cbTermConditions_Terms_and_Conditions:V' => 'Terms and Conditions',
				),
				'Description' => array(
					'vtiger_crmentity:description:description:cbTermConditions_Description:V' => 'Description',
				),
			),
			'ServiceContracts' => array(
				'Service Contract Information' => array(
					'vtiger_servicecontracts:subject:subject:ServiceContracts_Subject:V' => 'Subject',
					'vtiger_servicecontracts:contract_no:contract_no:ServiceContracts_Contract_No:V' => 'Contract No',
					'vtiger_servicecontracts:sc_related_to:sc_related_to:ServiceContracts_Related_to:V' => 'Related to',
					'vtiger_crmentity:smownerid:assigned_user_id:ServiceContracts_Assigned_To:V' => 'Assigned To',
					'vtiger_servicecontracts:contract_type:contract_type:ServiceContracts_Type:V' => 'Type',
					'vtiger_servicecontracts:tracking_unit:tracking_unit:ServiceContracts_Tracking_Unit:V' => 'Tracking Unit',
					'vtiger_servicecontracts:start_date:start_date:ServiceContracts_Start_Date:D' => 'Start Date',
					'vtiger_servicecontracts:total_units:total_units:ServiceContracts_Total_Units:N' => 'Total Units',
					'vtiger_servicecontracts:due_date:due_date:ServiceContracts_Due_date:D' => 'Due Date',
					'vtiger_servicecontracts:used_units:used_units:ServiceContracts_Used_Units:N' => 'Used Units',
					'vtiger_servicecontracts:end_date:end_date:ServiceContracts_End_Date:D' => 'End Date',
					'vtiger_servicecontracts:contract_status:contract_status:ServiceContracts_Status:V' => 'Status',
					'vtiger_servicecontracts:planned_duration:planned_duration:ServiceContracts_Planned_Duration:V' => 'Planned Duration (in Days)',
					'vtiger_servicecontracts:priority:contract_priority:ServiceContracts_Priority:V' => 'Priority',
					'vtiger_servicecontracts:actual_duration:actual_duration:ServiceContracts_Actual_Duration:V' => 'Actual Duration (in Days)',
					'vtiger_servicecontracts:progress:progress:ServiceContracts_Progress:N' => 'Progress',
					'vtiger_crmentity:createdtime:createdtime:ServiceContracts_Created_Time:DT' => 'Created Time',
					'vtiger_crmentity:modifiedtime:modifiedtime:ServiceContracts_Modified_Time:DT' => 'Modified Time',
					'vtiger_crmentity:smcreatorid:created_user_id:ServiceContracts_Created_By:V' => 'Created By',
					'vtiger_crmentity:modifiedby:modifiedby:ServiceContracts_Last_Modified_By:V' => 'Last Modified By',
				),
			),
		);
		return array(
			array('GlobalVariable', true, 1, $expected_gv, 'GlobalVariable admin'),
			array('GlobalVariable', true, 5, $expected_gv, 'GlobalVariable normal user'),
			array('GlobalVariable', true, 11, $expected_gv, 'GlobalVariable restricted user'),
			array('cbTermConditions', true, 1, $expected_tc, 'cbTermConditions admin'),
			array('cbTermConditions', true, 5, $expected_tc, 'cbTermConditions normal user'),
			array('cbTermConditions', true, 11, $expected_tc, 'cbTermConditions restricted user'),
			array('cbTermConditions', false, 5, $expected_tcflat, 'cbTermConditions normal user assocarray'),
		);
	}

	/**
	 * Method testgetModuleColumnsList
	 * @test
	 * @dataProvider getModuleColumnsListProvider
	 */
	public function testgetModuleColumnsList($module, $assocArray, $userid, $expected, $msg) {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($userid);
		$current_user = $user;
		$customView = new CustomView($module);
		$this->assertEquals($expected, $customView->getModuleColumnsList($module, $assocArray), $msg);
		$current_user = $holduser;
	}

	/**
	 * Method testgetConditionsFromSQL2CV
	 * @test
	 */
	public function testgetConditionsFromSQL2CV() {
		$module = 'Accounts';
		$customView = new CustomView($module);
		$query = 'select * from vtiger_accounts where deleted=0;';
		$moreconds = [];
		$expected = [];
		$this->assertEquals($expected, $customView->getConditionsFromSQL2CV($query, $moreconds), 'no conditions');
		/////////////
		$query = "SELECT vtiger_account.accountname, vtiger_account.phone, vtiger_account.website, vtiger_account.rating, vtiger_crmentity.smownerid, vtiger_account.accountid FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid WHERE vtiger_crmentity.deleted=0 AND ( ( (( vtiger_account.account_type IN ( select translation_key from vtiger_cbtranslation where locale='en_us' and forpicklist='Accounts::accounttype' and i18n = 'Prospect') OR vtiger_account.account_type = 'Prospect') ))) AND vtiger_account.accountid > 0";
		$moreconds = [];
		$expected = array(
			0 => array(
				'columnname' => 'vtiger_account:account_type:accounttype:Accounts_Type:V~O',
				'comparator' => 'e',
				'value' => 'Prospect',
				'groupid' => 4,
				'columncondition' => '',
			),
		);
		$this->assertEquals($expected, $customView->getConditionsFromSQL2CV($query, $moreconds), '1 conditions');
		/////////////
		$query = "SELECT vtiger_account.accountname, vtiger_account.phone, vtiger_account.website, vtiger_account.rating, vtiger_crmentity.smownerid, vtiger_account.accountid FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid WHERE vtiger_crmentity.deleted=0 AND ( ( (( vtiger_account.account_type IN ( select translation_key from vtiger_cbtranslation where locale='en_us' and forpicklist='Accounts::accounttype' and i18n = 'Prospect') OR vtiger_account.account_type = 'Prospect') and ( vtiger_account.website LIKE 'w%') ))) AND vtiger_account.accountid > 0";
		$moreconds = [];
		$expected = array(
			0 => array(
				'columnname' => 'vtiger_account:account_type:accounttype:Accounts_Type:V~O',
				'comparator' => 'e',
				'value' => 'Prospect',
				'groupid' => 4,
				'columncondition' => 'and',
			),
			1 => array(
				'columnname' => 'vtiger_account:website:website:Accounts_Website:V~O',
				'comparator' => 'c',
				'value' => 'w%',
				'groupid' => 5,
				'columncondition' => '',
			),
		);
		$this->assertEquals($expected, $customView->getConditionsFromSQL2CV($query, $moreconds), '2 conditions');
		////////////
		$query = "SELECT vtiger_account.accountname, vtiger_account.phone, vtiger_account.website, vtiger_account.rating, vtiger_crmentity.smownerid, vtiger_account.accountid FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid WHERE vtiger_crmentity.deleted=0 AND ( ( (( vtiger_account.account_type IN ( select translation_key from vtiger_cbtranslation where locale='en_us' and forpicklist='Accounts::accounttype' and i18n <> 'Prospect') AND vtiger_account.account_type <> 'Prospect') and ( vtiger_account.website LIKE 'w%') ))) AND vtiger_account.accountid > 0";
		$moreconds = [];
		$expected = array(
			0 => array(
				'columnname' => 'vtiger_account:account_type:accounttype:Accounts_Type:V~O',
				'comparator' => 'n',
				'value' => 'Prospect',
				'groupid' => 4,
				'columncondition' => 'and',
			),
			1 => array(
				'columnname' => 'vtiger_account:website:website:Accounts_Website:V~O',
				'comparator' => 'c',
				'value' => 'w%',
				'groupid' => 5,
				'columncondition' => '',
			),
		);
		$this->assertEquals($expected, $customView->getConditionsFromSQL2CV($query, $moreconds), '2 conditions one negative');
		////////////
		$query = "SELECT vtiger_account.accountname, vtiger_account.phone, vtiger_account.website, vtiger_account.rating, vtiger_crmentity.smownerid, vtiger_account.accountid FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid WHERE vtiger_crmentity.deleted=0 AND ( ( (( vtiger_account.account_type IN ( select translation_key from vtiger_cbtranslation where locale='en_us' and forpicklist='Accounts::accounttype' and i18n = 'Prospect') OR vtiger_account.account_type = 'Prospect') and ( vtiger_account.website LIKE 'w%') ))) AND vtiger_account.accountid > 0";
		$moreconds = ['columnname' => 'rating', 'comparator' => 'e', 'value' => 'Active', 'columncondition' => ''];
		$expected = array(
			0 => array(
				'columnname' => 'vtiger_account:account_type:accounttype:Accounts_Type:V~O',
				'comparator' => 'e',
				'value' => 'Prospect',
				'groupid' => 4,
				'columncondition' => 'and',
			),
			1 => array(
				'columnname' => 'vtiger_account:website:website:Accounts_Website:V~O',
				'comparator' => 'c',
				'value' => 'w%',
				'groupid' => 5,
				'columncondition' => 'and',
			),
			2 => array(
				'columnname' => 'vtiger_account:rating:rating:Accounts_Rating:V~O',
				'comparator' => 'e',
				'value' => 'Active',
				'groupid' => 1,
				'columncondition' => '',
			),
		);
		$this->assertEquals($expected, $customView->getConditionsFromSQL2CV($query, $moreconds), '2 conditions + forced one');
		////////////
		$query = "SELECT * FROM vtiger_account WHERE vtiger_crmentity.deleted=0";
		$moreconds = ['columnname' => 'rating', 'comparator' => 'e', 'value' => 'Active', 'columncondition' => ''];
		$expected = array(
			0 => array(
				'columnname' => 'vtiger_account:rating:rating:Accounts_Rating:V~O',
				'comparator' => 'e',
				'value' => 'Active',
				'groupid' => 1,
				'columncondition' => '',
			),
		);
		$this->assertEquals($expected, $customView->getConditionsFromSQL2CV($query, $moreconds), 'no conditions + forced one');
		////////////
		$query = "SELECT vtiger_account.accountname, vtiger_account.phone, vtiger_account.website, vtiger_account.rating, vtiger_crmentity.smownerid, vtiger_account.accountid FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid WHERE vtiger_crmentity.deleted=0 AND ( ( (( vtiger_account.website LIKE '%m') ) and (( vtiger_account.accountname NOT LIKE 'c%') ))) AND vtiger_account.accountid > 0";
		$moreconds = [];
		$expected = array(
			0 => array(
				'columnname' => 'vtiger_account:website:website:Accounts_Website:V~O',
				'comparator' => 'c',
				'value' => '%m',
				'groupid' => 4,
				'columncondition' => 'and',
			),
			1 => array(
				'columnname' => 'vtiger_account:accountname:accountname:Accounts_Account_Name:V~M',
				'comparator' => 'k',
				'value' => 'c%',
				'groupid' => 5,
				'columncondition' => '',
			),
		);
		$this->assertEquals($expected, $customView->getConditionsFromSQL2CV($query, $moreconds), 'and grouping');
		////////////
		$query = "SELECT vtiger_account.accountname, vtiger_account.phone, vtiger_account.website, vtiger_account.rating, vtiger_crmentity.smownerid, vtiger_account.accountid FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid WHERE vtiger_crmentity.deleted=0 AND ( ( (( vtiger_account.website LIKE '%m') ) or (( vtiger_account.accountname NOT LIKE 'c%') ))) AND vtiger_account.accountid > 0";
		$moreconds = [];
		$expected = array(
			0 => array(
				'columnname' => 'vtiger_account:website:website:Accounts_Website:V~O',
				'comparator' => 'c',
				'value' => '%m',
				'groupid' => 4,
				'columncondition' => 'or',
			),
			1 => array(
				'columnname' => 'vtiger_account:accountname:accountname:Accounts_Account_Name:V~M',
				'comparator' => 'k',
				'value' => 'c%',
				'groupid' => 5,
				'columncondition' => '',
			),
		);
		$this->assertEquals($expected, $customView->getConditionsFromSQL2CV($query, $moreconds), 'or grouping');
		////////////
		$query = "SELECT vtiger_account.accountname, vtiger_account.phone, vtiger_account.website, vtiger_account.rating, vtiger_crmentity.smownerid, vtiger_account.accountid FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid INNER JOIN vtiger_accountscf ON vtiger_account.accountid = vtiger_accountscf.accountid WHERE vtiger_crmentity.deleted=0 AND (( vtiger_accountscf.cf_722 BETWEEN '2023-01-01' AND '2023-12-31') ) AND vtiger_account.accountid > 0";
		$moreconds = [];
		$expected = array(
			0 => array(
				'columnname' => 'vtiger_accountscf:cf_722:cf_722:Accounts_Date:D~O',
				'comparator' => 'bw',
				'value' => "2023-01-01,'2023-12-31'",
				'groupid' => 2,
				'columncondition' => '',
			),
		);
		$this->assertEquals($expected, $customView->getConditionsFromSQL2CV($query, $moreconds), 'standard data between');
		////////////
		$query = "SELECT * FROM vtiger_account WHERE vtiger_crmentity.deleted=0";
		$moreconds = ['columnname' => 'PLACEFIELD', 'comparator' => 'e', 'value' => 'PLACEVALUE', 'columncondition' => ''];
		$expected = array(
			0 => array(
				'columnname' => '',
				'comparator' => 'e',
				'value' => 'PLACEVALUE',
				'groupid' => 1,
				'columncondition' => '',
			),
		);
		$this->assertEquals($expected, $customView->getConditionsFromSQL2CV($query, $moreconds), 'no conditions + false forced one');
		////////////
		$query = 'SELECT vtiger_contactdetails.lastname, vtiger_crmentity.smownerid, vtiger_accountaccount_id.accountname as accountsaccountname, vtiger_accountaccount_id.phone as accountsphone, vtiger_contactdetails.contactid FROM vtiger_contactdetails INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_contactdetails.accountid ';
		$query.= "WHERE vtiger_crmentity.deleted=0 AND ( ( ((vtiger_accountaccount_id.siccode LIKE '%6%') ))) AND vtiger_contactdetails.contactid > 0 GROUP BY vtiger_contactdetails.lastname";
		$moreconds = ['columnname' => 'PLACEFIELD', 'comparator' => 'e', 'value' => 'PLACEVALUE', 'columncondition' => ''];
		$expected = array(
			0 => array(
				'columnname' => 'vtiger_account:siccode:siccode:Accounts_SIC_Code:V~O',
				'comparator' => 'c',
				'value' => '%6%',
				'groupid' => 4,
				'columncondition' => 'and',
			),
			1 => array(
				'columnname' => '',
				'comparator' => 'e',
				'value' => 'PLACEVALUE',
				'groupid' => 1,
				'columncondition' => '',
			),
		);
		$this->assertEquals($expected, $customView->getConditionsFromSQL2CV($query, $moreconds), 'tisg conditions + false forced one');
		////////////
		$query = 'SELECT vtiger_contactdetails.lastname, vtiger_crmentity.smownerid, vtiger_accountaccount_id.accountname as accountsaccountname, vtiger_accountaccount_id.phone as accountsphone, vtiger_contactdetails.contactid FROM vtiger_contactdetails INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_contactdetails.accountid ';
		$query.= "WHERE crme.deleted=0 AND vtiger_accountaccount_id.siccode LIKE '%6%' AND vtiger_contactdetails.lastname LIKE '%A%' GROUP BY vtiger_contactdetails.lastname";
		$moreconds = ['columnname' => 'PLACEFIELD', 'comparator' => 'e', 'value' => 'PLACEVALUE', 'columncondition' => ''];
		$expected = array(
			0 => array(
				'columnname' => 'vtiger_account:siccode:siccode:Accounts_SIC_Code:V~O',
				'comparator' => 'c',
				'value' => '%6%',
				'groupid' => 1,
				'columncondition' => 'AND',
			),
			1 => array(
				'columnname' => 'vtiger_contactdetails:lastname:lastname:Contacts_Last_Name:V~M',
				'comparator' => 'c',
				'value' => '%A%',
				'groupid' => 1,
				'columncondition' => 'and',
			),
			2 => array(
				'columnname' => '',
				'comparator' => 'e',
				'value' => 'PLACEVALUE',
				'groupid' => 1,
				'columncondition' => '',
			),
		);
		$this->assertEquals($expected, $customView->getConditionsFromSQL2CV($query, $moreconds), 'tisg conditions + false forced one');
	}
}
