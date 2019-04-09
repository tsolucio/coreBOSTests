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
		$current_user = $user;
		$current_user = $holduser;
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
			'status' => "0"
		);
		$expected_contacts_admin_value = array(
			'viewname' => 'All',
			'setdefault' => '1',
			'setmetrics' => '0',
			'userid' => '1',
			'status' => "0"
		);
		$expected_accounts_admin_value = array(
			'viewname' => 'All',
			'setdefault' => '1',
			'setmetrics' => '0',
			'userid' => '1',
			'status' => "0"
		);
		$expected_potentials_admin_value = array(
			'viewname' => 'All',
			'setdefault' => '1',
			'setmetrics' => '0',
			'userid' => '1',
			'status' => "0"
		);
		$expected_salesorder_admin_value = array(
			'viewname' => 'All',
			'setdefault' => '1',
			'setmetrics' => '0',
			'userid' => '1',
			'status' => "0"
		);
		$expected_leads_testmdy_value = array(
			'viewname' => 'All',
			'setdefault' => '1',
			'setmetrics' => '0',
			'userid' => '1',
			'status' => "0"
		);
		$expected_contacts_testmdy_value = array(
			'viewname' => 'All',
			'setdefault' => '1',
			'setmetrics' => '0',
			'userid' => '1',
			'status' => "0"
		);
		$expected_accounts_testmdy_value = array(
			'viewname' => 'All',
			'setdefault' => '1',
			'setmetrics' => '0',
			'userid' => '1',
			'status' => "0"
		);
		$expected_potentials_testmdy_value = array(
			'viewname' => 'All',
			'setdefault' => '1',
			'setmetrics' => '0',
			'userid' => '1',
			'status' => "0"
		);
		$expected_salesorder_testmdy_value = array(
			'viewname' => 'All',
			'setdefault' => '1',
			'setmetrics' => '0',
			'userid' => '1',
			'status' => "0"
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
		$expected_accounts_admin_combo = '<option selected value="4">All</option><option value="82">current_user</option><option value="6">New This Week</option><option value="5">Prospect Accounts</option>';
		$expected_potentials_admin_combo = '<option selected value="10">All</option><option value="11">Potentials Won</option><option value="12">Prospecting</option>';
		$expected_salesorder_admin_combo = '<option selected value="26">All</option><option value="37">Pending Sales Orders</option>';
		$expected_leads_testmdy_combo = '<option selected value="1">All</option><option disabled>--- Public ---</option><option value="2">Hot Leads [ Administrator] </option><option value="3">This Month Leads [ Administrator] </option>';
		$expected_contacts_testmdy_combo = '<option selected value="7">All</option><option disabled>--- Public ---</option><option value="8">Contacts Address [ Administrator] </option><option value="9">Todays Birthday [ Administrator] </option>';
		$expected_accounts_testmdy_combo = '<option selected value="4">All</option><option disabled>--- Public ---</option><option value="6">New This Week [ Administrator] </option><option value="5">Prospect Accounts [ Administrator] </option>';
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
}
