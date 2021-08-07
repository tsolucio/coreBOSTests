<?php
/*************************************************************************************************
 * Copyright 2020 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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
require_once 'modules/Reports/Reports.php';
require_once 'modules/Reports/ReportRun.php';
use PHPUnit\Framework\TestCase;

class ReportRunTest extends TestCase {

	protected function setUp(): void {
		global $adb;
		$adb->pquery(
			'insert into vtiger_reportsortcol (sortcolid,reportid,columnname,sortorder) values (?,?,?,?);',
			array(2, 4, 'none', 'Descending')
		);
		$adb->pquery(
			'insert into vtiger_reportsortcol (sortcolid,reportid,columnname,sortorder) values (?,?,?,?);',
			array(3, 4, 'vtiger_leaddetails:leadstatus:Leads_Lead_Status:leadstatus:V', 'Descending')
		);
	}

	protected function tearDown(): void {
		global $adb;
		$adb->pquery(
			'delete from vtiger_reportsortcol where sortcolid=? and reportid=? and columnname=? and sortorder=?;',
			array(2, 4, 'none', 'Descending')
		);
		$adb->pquery(
			'delete from vtiger_reportsortcol where sortcolid=? and reportid=? and columnname=? and sortorder=?;',
			array(3, 4, 'vtiger_leaddetails:leadstatus:Leads_Lead_Status:leadstatus:V', 'Descending')
		);
	}

	/**
	 * Method getSelectedOrderbyListProvider
	 * params
	 */
	public function getSelectedOrderbyListProvider() {
		return array(
			array(4, 'vtiger_leaddetails.leadsource ASC, vtiger_leaddetails.leadstatus DESC', 'vtiger_leaddetails.leadsource Leads_Lead_Source, vtiger_leaddetails.leadstatus Leads_Lead_Status'),
			array(5, 'vtiger_leaddetails.leadstatus ASC', 'vtiger_leaddetails.leadstatus Leads_Lead_Status'),
			array(6, 'vtiger_potential.sales_stage ASC', 'vtiger_potential.sales_stage Potentials_Sales_Stage'),
			array(11, 'vtiger_troubletickets.priority ASC', 'vtiger_troubletickets.priority HelpDesk_Priority'),
		);
	}

	/**
	 * Method testgetSelectedOrderbyList
	 * @test
	 * @dataProvider getSelectedOrderbyListProvider
	 */
	public function testgetSelectedOrderbyList($reportid, $expected, $expectedobl) {
		$rep = new ReportRun($reportid);
		$this->assertEquals('', $rep->orderbylistsql);
		$this->assertEquals($expected, $rep->getSelectedOrderbyList($reportid));
		$this->assertEquals($expectedobl, $rep->orderbylistsql);
	}

	/**
	 * Method getSelectedColumnsListProvider
	 * params
	 */
	public function getSelectedColumnsListProvider() {
		return array(
			array(4, "vtiger_leaddetails.leadsource Leads_Lead_Source, vtiger_leaddetails.leadstatus Leads_Lead_Status, vtiger_leaddetails.firstname 'Leads_First_Name',vtiger_leaddetails.lastname 'Leads_Last_Name',vtiger_leaddetails.company 'Leads_Company',vtiger_leaddetails.email 'Leads_Email'"),
			array(5, "vtiger_leaddetails.leadstatus Leads_Lead_Status, vtiger_leaddetails.firstname 'Leads_First_Name',vtiger_leaddetails.lastname 'Leads_Last_Name',vtiger_leaddetails.company 'Leads_Company',vtiger_leaddetails.email 'Leads_Email',vtiger_leaddetails.leadsource 'Leads_Lead_Source'"),
			array(6, "vtiger_potential.sales_stage Potentials_Sales_Stage, vtiger_potential.potentialname 'Potentials_Potential_Name',vtiger_potential.amount 'Potentials_Amount',vtiger_potential.potentialtype 'Potentials_Type',vtiger_potential.leadsource 'Potentials_Lead_Source'"),
			array(11, "vtiger_troubletickets.priority HelpDesk_Priority, vtiger_troubletickets.title 'HelpDesk_Title',vtiger_troubletickets.severity 'HelpDesk_Severity',vtiger_troubletickets.status 'HelpDesk_Status',vtiger_troubletickets.category 'HelpDesk_Category',vtiger_usersHelpDesk.user_name 'HelpDesk_Assigned_To'"),
		);
	}

	/**
	 * Method testgetSelectedColumnsList
	 * @test
	 * @dataProvider getSelectedColumnsListProvider
	 */
	public function testgetSelectedColumnsList($reportid, $expected) {
		$rep = new ReportRun($reportid);
		$rep->getSelectedOrderbyList($reportid);
		$this->assertEquals($expected, $rep->getSelectedColumnsList($reportid));
	}
}
