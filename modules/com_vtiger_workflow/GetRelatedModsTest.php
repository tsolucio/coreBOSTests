<?php
/*************************************************************************************************
 * Copyright 2021 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

class GetRelatedModsTest extends TestCase {

	/**
	 * Method testScriptGetRelatedMods
	 * @test
	 */
	public function testScriptGetRelatedMods() {
		global $current_user;
		if (empty($current_user)) {
			$current_user = Users::getActiveAdminUser();
		}
		/////////////////////////
		unset($_REQUEST['currentmodule']);
		ob_start();
		include 'modules/com_vtiger_workflow/getrelatedmods.php';
		$actual = ob_get_contents();
		ob_end_clean();
		$expected = '';
		$this->assertEquals($expected, $actual, 'no parameter');
		/////////////////////////
		$_REQUEST['currentmodule'] = 'HelpDesk';
		ob_start();
		include 'modules/com_vtiger_workflow/getrelatedmods.php';
		$actual = ob_get_contents();
		ob_end_clean();
		$expected = '<option value="Documents">Documents</option><option value="ServiceContracts">Service Contracts</option><option value="Services">Services</option><option value="Project">Projects</option>';
		$this->assertEquals($expected, $actual, 'helpdesk relations');
		/////////////////////////
		$_REQUEST['currentmodule'] = 'Assets';
		ob_start();
		include 'modules/com_vtiger_workflow/getrelatedmods.php';
		$actual = ob_get_contents();
		ob_end_clean();
		$expected = '<option value="HelpDesk">Support Tickets</option><option value="Documents">Documents</option>';
		$this->assertEquals($expected, $actual, 'assets relations');
		/////////////////////////
		$_REQUEST['currentmodule'] = 'HelpDesk';
		$_REQUEST['reltype'] = 'garbage';
		ob_start();
		include 'modules/com_vtiger_workflow/getrelatedmods.php';
		$actual = ob_get_contents();
		ob_end_clean();
		$expected = '';
		$this->assertEquals($expected, $actual, 'helpdesk relations garbage');
		/////////////////////////
		$_REQUEST['currentmodule'] = 'Assets';
		$_REQUEST['reltype'] = 'garbage';
		ob_start();
		include 'modules/com_vtiger_workflow/getrelatedmods.php';
		$actual = ob_get_contents();
		ob_end_clean();
		$expected = '';
		$this->assertEquals($expected, $actual, 'assets relations garbage');
		/////////////////////////
		$_REQUEST['currentmodule'] = 'HelpDesk';
		$_REQUEST['reltype'] = 'N:N';
		ob_start();
		include 'modules/com_vtiger_workflow/getrelatedmods.php';
		$actual = ob_get_contents();
		ob_end_clean();
		$expected = '<option value="Documents">Documents</option><option value="ServiceContracts">Service Contracts</option><option value="Services">Services</option><option value="Project">Projects</option>';
		$this->assertEquals($expected, $actual, 'helpdesk relations N:N');
		/////////////////////////
		$_REQUEST['currentmodule'] = 'Assets';
		$_REQUEST['reltype'] = 'N:N';
		ob_start();
		include 'modules/com_vtiger_workflow/getrelatedmods.php';
		$actual = ob_get_contents();
		ob_end_clean();
		$expected = '<option value="HelpDesk">Support Tickets</option><option value="Documents">Documents</option>';
		$this->assertEquals($expected, $actual, 'assets relations N:N');
		/////////////////////////
		$_REQUEST['currentmodule'] = 'HelpDesk';
		$_REQUEST['reltype'] = '1:N';
		ob_start();
		include 'modules/com_vtiger_workflow/getrelatedmods.php';
		$actual = ob_get_contents();
		ob_end_clean();
		$expected = '<option value="cbCalendar">Activities</option><option value="CobroPago">Payments</option>';
		$this->assertEquals($expected, $actual, 'helpdesk relations 1:N');
		/////////////////////////
		$_REQUEST['currentmodule'] = 'Assets';
		$_REQUEST['reltype'] = '1:N';
		ob_start();
		include 'modules/com_vtiger_workflow/getrelatedmods.php';
		$actual = ob_get_contents();
		ob_end_clean();
		$expected = '';
		$this->assertEquals($expected, $actual, 'assets relations 1:N');
		/////////////////////////
		$_REQUEST['currentmodule'] = 'HelpDesk';
		$_REQUEST['reltype'] = '*';
		ob_start();
		include 'modules/com_vtiger_workflow/getrelatedmods.php';
		$actual = ob_get_contents();
		ob_end_clean();
		$expected = '<option value="cbCalendar">Activities</option><option value="Documents">Documents</option><option value="ServiceContracts">Service Contracts</option><option value="Services">Services</option><option value="CobroPago">Payments</option><option value="Project">Projects</option>';
		$this->assertEquals($expected, $actual, 'helpdesk relations *');
		/////////////////////////
		$_REQUEST['currentmodule'] = 'Assets';
		$_REQUEST['reltype'] = '*';
		ob_start();
		include 'modules/com_vtiger_workflow/getrelatedmods.php';
		$actual = ob_get_contents();
		ob_end_clean();
		$expected = '<option value="HelpDesk">Support Tickets</option><option value="Documents">Documents</option>';
		$this->assertEquals($expected, $actual, 'assets relations *');
		/////////////////////////
		unset($_REQUEST['currentmodule'], $_REQUEST['reltype']);
	}
}
