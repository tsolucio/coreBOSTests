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

include_once 'modules/com_vtiger_workflow/VTWorkflowUtils.php';

class VTWorkflowUtilsTest extends TestCase {

	/**
	 * Method testgetModulesListAndvtGetModules
	 * @test
	 */
	public function testgetModulesListAndvtGetModules() {
		global $adb;
		$expected = '<option value="all" selected>--All--</option><option value="Assets">Assets</option><option value="AutoNumberPrefix">Auto Number Prefix</option><option value="BusinessActions">Business Actions</option><option value="cbMap">Business Maps</option><option value="cbQuestion">Business Question</option><option value="Campaigns">Campaigns</option><option value="ModComments">Comments</option><option value="cbCompany">Companies</option><option value="Contacts">Contacts</option><option value="cbupdater">coreBOS Updater</option><option value="cbCredentials">Credentials</option><option value="DocumentFolders">Document Folders</option><option value="Documents">Documents</option><option value="Emails">Email</option><option value="Faq">FAQ</option><option value="GlobalVariable">Global Variables</option><option value="InventoryDetails">Inventory Details</option><option value="Invoice">Invoice</option><option value="Leads">Leads</option><option value="MsgTemplate">Message Templates</option><option value="Messages">Messages</option><option value="Potentials">Opportunities</option><option value="Accounts">Organizations</option><option value="CobroPago">Payments</option><option value="PriceBooks">Price Books</option><option value="pricebookproductrel">Price Lists</option><option value="ProductComponent">Product Components</option><option value="Products">Products</option><option value="ProjectMilestone">Project Milestones</option><option value="ProjectTask">Project Tasks</option><option value="Project">Projects</option><option value="cbPulse">Pulses</option><option value="PurchaseOrder">Purchase Order</option><option value="Quotes">Quotes</option><option value="SalesOrder">Sales Order</option><option value="ServiceContracts">Service Contracts</option><option value="Services">Services</option><option value="HelpDesk">Support Tickets</option><option value="cbSurveyQuestion">Survey Questions</option><option value="cbSurvey">Surveys</option><option value="cbSurveyAnswer">Surveys Answer</option><option value="cbSurveyDone">Surveys Done</option><option value="cbTermConditions">Terms and Conditions</option><option value="cbCalendar">To Dos</option><option value="cbtranslation">Translations</option><option value="Vendors">Vendors</option><option value="cbCVManagement">View Permissions</option>';
		$this->assertEquals($expected, VTWorkflowUtils::getModulesList($adb, ''));
		$expected = '<option value="all">--All--</option><option value="Assets" selected>Assets</option><option value="AutoNumberPrefix">Auto Number Prefix</option><option value="BusinessActions">Business Actions</option><option value="cbMap">Business Maps</option><option value="cbQuestion">Business Question</option><option value="Campaigns">Campaigns</option><option value="ModComments">Comments</option><option value="cbCompany">Companies</option><option value="Contacts">Contacts</option><option value="cbupdater">coreBOS Updater</option><option value="cbCredentials">Credentials</option><option value="DocumentFolders">Document Folders</option><option value="Documents">Documents</option><option value="Emails">Email</option><option value="Faq">FAQ</option><option value="GlobalVariable">Global Variables</option><option value="InventoryDetails">Inventory Details</option><option value="Invoice">Invoice</option><option value="Leads">Leads</option><option value="MsgTemplate">Message Templates</option><option value="Messages">Messages</option><option value="Potentials">Opportunities</option><option value="Accounts">Organizations</option><option value="CobroPago">Payments</option><option value="PriceBooks">Price Books</option><option value="pricebookproductrel">Price Lists</option><option value="ProductComponent">Product Components</option><option value="Products">Products</option><option value="ProjectMilestone">Project Milestones</option><option value="ProjectTask">Project Tasks</option><option value="Project">Projects</option><option value="cbPulse">Pulses</option><option value="PurchaseOrder">Purchase Order</option><option value="Quotes">Quotes</option><option value="SalesOrder">Sales Order</option><option value="ServiceContracts">Service Contracts</option><option value="Services">Services</option><option value="HelpDesk">Support Tickets</option><option value="cbSurveyQuestion">Survey Questions</option><option value="cbSurvey">Surveys</option><option value="cbSurveyAnswer">Surveys Answer</option><option value="cbSurveyDone">Surveys Done</option><option value="cbTermConditions">Terms and Conditions</option><option value="cbCalendar">To Dos</option><option value="cbtranslation">Translations</option><option value="Vendors">Vendors</option><option value="cbCVManagement">View Permissions</option>';
		$this->assertEquals($expected, VTWorkflowUtils::getModulesList($adb, 'Assets'));
	}
}
