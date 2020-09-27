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
use PHPUnit\Framework\TestCase;

class ReportsTest extends TestCase {

	/**
	 * Method sgetColumnstoTotalHTMLProvider
	 * params
	 */
	public function sgetColumnstoTotalHTMLProvider() {
		$accounts = array(
			array(
				'label' => array(
					0 => 'Organizations -Number'
				),
				'checkboxes' => array(
					0 => array('name' => 'cb:vtiger_accountscf:cf_719:Number_SUM:2'),
					1 => array('name' => 'cb:vtiger_accountscf:cf_719:Number_AVG:3'),
					2 => array('name' => 'cb:vtiger_accountscf:cf_719:Number_MIN:4'),
					3 => array('name' => 'cb:vtiger_accountscf:cf_719:Number_MAX:5'),
				),
			),
			array(
				'label' => array(
					0 => 'Organizations -Percent'
				),
				'checkboxes' => array(
					0 => array('name' => 'cb:vtiger_accountscf:cf_720:Percent_SUM:2'),
					1 => array('name' => 'cb:vtiger_accountscf:cf_720:Percent_AVG:3'),
					2 => array('name' => 'cb:vtiger_accountscf:cf_720:Percent_MIN:4'),
					3 => array('name' => 'cb:vtiger_accountscf:cf_720:Percent_MAX:5'),
				),
			),
			array(
				'label' => array(
					0 => 'Organizations -Currency'
				),
				'checkboxes' => array(
					0 => array('name' => 'cb:vtiger_accountscf:cf_721:Currency_SUM:2'),
					1 => array('name' => 'cb:vtiger_accountscf:cf_721:Currency_AVG:3'),
					2 => array('name' => 'cb:vtiger_accountscf:cf_721:Currency_MIN:4'),
					3 => array('name' => 'cb:vtiger_accountscf:cf_721:Currency_MAX:5'),
				),
			),
			array(
				'label' => array(
					0 => 'Organizations -Employees'
				),
				'checkboxes' => array(
					0 => array('name' => 'cb:vtiger_account:employees:Employees_SUM:2'),
					1 => array('name' => 'cb:vtiger_account:employees:Employees_AVG:3'),
					2 => array('name' => 'cb:vtiger_account:employees:Employees_MIN:4'),
					3 => array('name' => 'cb:vtiger_account:employees:Employees_MAX:5'),
				),
			),
			array(
				'label' => array(
					0 => 'Organizations -Time'
				),
				'checkboxes' => array(
					0 => array('name' => 'cb:vtiger_accountscf:cf_728:Time_SUM:2'),
					1 => array('name' => 'cb:vtiger_accountscf:cf_728:Time_AVG:3'),
					2 => array('name' => 'cb:vtiger_accountscf:cf_728:Time_MIN:4'),
					3 => array('name' => 'cb:vtiger_accountscf:cf_728:Time_MAX:5'),
				),
			),
			array(
				'label' => array(
					0 => 'Organizations -Annual Revenue'
				),
				'checkboxes' => array(
					0 => array('name' => 'cb:vtiger_account:annualrevenue:Annual Revenue_SUM:2'),
					1 => array('name' => 'cb:vtiger_account:annualrevenue:Annual Revenue_AVG:3'),
					2 => array('name' => 'cb:vtiger_account:annualrevenue:Annual Revenue_MIN:4'),
					3 => array('name' => 'cb:vtiger_account:annualrevenue:Annual Revenue_MAX:5'),
				),
			),
		);
		$helpdesk = array(
			array(
				'label' => array(
					0 => 'Support Tickets -Hours'
				),
				'checkboxes' => array(
					0 => array('name' => 'cb:vtiger_troubletickets:hours:Hours_SUM:2'),
					1 => array('name' => 'cb:vtiger_troubletickets:hours:Hours_AVG:3'),
					2 => array('name' => 'cb:vtiger_troubletickets:hours:Hours_MIN:4'),
					3 => array('name' => 'cb:vtiger_troubletickets:hours:Hours_MAX:5'),
				),
			),
			array(
				'label' => array(
					0 => 'Support Tickets -Days'
				),
				'checkboxes' => array(
					0 => array('name' => 'cb:vtiger_troubletickets:days:Days_SUM:2'),
					1 => array('name' => 'cb:vtiger_troubletickets:days:Days_AVG:3'),
					2 => array('name' => 'cb:vtiger_troubletickets:days:Days_MIN:4'),
					3 => array('name' => 'cb:vtiger_troubletickets:days:Days_MAX:5'),
				),
			),
		);
		$assets = array();
		$cbcalendar = array(
			array(
				'label' => array(
					0 => 'To Dos -Send Reminder'
				),
				'checkboxes' => array(
					0 => array('name' => 'cb:vtiger_activity_reminder:reminder_time:Send Reminder_SUM:2'),
					1 => array('name' => 'cb:vtiger_activity_reminder:reminder_time:Send Reminder_AVG:3'),
					2 => array('name' => 'cb:vtiger_activity_reminder:reminder_time:Send Reminder_MIN:4'),
					3 => array('name' => 'cb:vtiger_activity_reminder:reminder_time:Send Reminder_MAX:5'),
				),
			),
			array(
				'label' => array(
					0 => 'To Dos -Time Start (System Time)'
				),
				'checkboxes' => array(
					0 => array('name' => 'cb:vtiger_activity:time_start:Time Start_SUM:2'),
					1 => array('name' => 'cb:vtiger_activity:time_start:Time Start_AVG:3'),
					2 => array('name' => 'cb:vtiger_activity:time_start:Time Start_MIN:4'),
					3 => array('name' => 'cb:vtiger_activity:time_start:Time Start_MAX:5'),
				),
			),
			array(
				'label' => array(
					0 => 'To Dos -End Time (System Time)'
				),
				'checkboxes' => array(
					0 => array('name' => 'cb:vtiger_activity:time_end:End Time_SUM:2'),
					1 => array('name' => 'cb:vtiger_activity:time_end:End Time_AVG:3'),
					2 => array('name' => 'cb:vtiger_activity:time_end:End Time_MIN:4'),
					3 => array('name' => 'cb:vtiger_activity:time_end:End Time_MAX:5'),
				),
			),
			array(
				'label' => array(
					0 => 'To Dos -Duration'
				),
				'checkboxes' => array(
					0 => array('name' => 'cb:vtiger_activity:duration_hours:Duration_SUM:2'),
					1 => array('name' => 'cb:vtiger_activity:duration_hours:Duration_AVG:3'),
					2 => array('name' => 'cb:vtiger_activity:duration_hours:Duration_MIN:4'),
					3 => array('name' => 'cb:vtiger_activity:duration_hours:Duration_MAX:5'),
				),
			),
			array(
				'label' => array(
					0 => 'To Dos -Duration Minutes'
				),
				'checkboxes' => array(
					0 => array('name' => 'cb:vtiger_activity:duration_minutes:Duration Minutes_SUM:2'),
					1 => array('name' => 'cb:vtiger_activity:duration_minutes:Duration Minutes_AVG:3'),
					2 => array('name' => 'cb:vtiger_activity:duration_minutes:Duration Minutes_MIN:4'),
					3 => array('name' => 'cb:vtiger_activity:duration_minutes:Duration Minutes_MAX:5'),
				),
			),
		);
		$empty = array();
		$notexist = array();
		return array(
			array('Accounts', $accounts),
			array('HelpDesk', $helpdesk),
			array('Assets', $assets),
			array('cbCalendar', $cbcalendar),
			array('', $empty),
			array('DoesNotExist', $notexist),
		);
	}

	/**
	 * Method testsgetColumnstoTotalHTML
	 * @test
	 * @dataProvider sgetColumnstoTotalHTMLProvider
	 */
	public function testsgetColumnstoTotalHTML($module, $expected) {
		$rep = new Reports('');
		$this->assertEquals($expected, $rep->sgetColumnstoTotalHTML($module));
	}

	/**
	 * Method getColumnsListbyBlockProvider
	 * params
	 */
	public function getColumnsListbyBlockProvider() {
		$accounts = array(
			'vtiger_account:accountname:Accounts_Account_Name:accountname:V' => 'Account Name',
			'vtiger_account:account_no:Accounts_Account_No:account_no:V' => 'Account No',
			'vtiger_account:website:Accounts_Website:website:V' => 'Website',
			'vtiger_account:phone:Accounts_Phone:phone:V' => 'Phone',
			'vtiger_account:tickersymbol:Accounts_Ticker_Symbol:tickersymbol:V' => 'Ticker Symbol',
			'vtiger_account:fax:Accounts_Fax:fax:V' => 'Fax',
			'vtiger_account:parentid:Accounts_Member_Of:account_id:V' => 'Member Of',
			'vtiger_account:otherphone:Accounts_Other_Phone:otherphone:V' => 'Other Phone',
			'vtiger_account:employees:Accounts_Employees:employees:I' => 'Employees',
			'vtiger_account:email1:Accounts_Email:email1:V' => 'Email',
			'vtiger_account:email2:Accounts_Other_Email:email2:V' => 'Other Email',
			'vtiger_account:ownership:Accounts_Ownership:ownership:V' => 'Ownership',
			'vtiger_account:industry:Accounts_industry:industry:V' => 'industry',
			'vtiger_account:rating:Accounts_Rating:rating:V' => 'Rating',
			'vtiger_account:account_type:Accounts_Type:accounttype:V' => 'Type',
			'vtiger_account:siccode:Accounts_SIC_Code:siccode:V' => 'SIC Code',
			'vtiger_account:emailoptout:Accounts_Email_Opt_Out:emailoptout:C' => 'Email Opt Out',
			'vtiger_account:annualrevenue:Accounts_Annual_Revenue:annual_revenue:N' => 'Annual Revenue',
			'vtiger_usersAccounts:user_name:Accounts_Assigned_To:assigned_user_id:V' => 'Assigned To',
			'vtiger_account:notify_owner:Accounts_Notify_Owner:notify_owner:C' => 'Notify Owner',
			'vtiger_crmentityAccounts:modifiedtime:Accounts_Modified_Time:modifiedtime:DT' => 'Modified Time',
			'vtiger_crmentityAccounts:createdtime:Accounts_Created_Time:createdtime:DT' => 'Created Time',
			'vtiger_crmentityAccounts:modifiedby:Accounts_Last_Modified_By:modifiedby:V' => 'Last Modified By',
			'vtiger_account:isconvertedfromlead:Accounts_Is_Converted_From_Lead:isconvertedfromlead:C' => 'Is Converted From Lead',
			'vtiger_account:convertedfromlead:Accounts_Converted_From_Lead:convertedfromlead:V' => 'Converted From Lead',
			'vtiger_crmentityAccounts:smcreatorid:Accounts_Created_By:created_user_id:V' => 'Created By',
		);
		$helpdesk = array(
			'vtiger_troubletickets:title:HelpDesk_Title:ticket_title:V' => 'Title',
			'vtiger_troubletickets:from_mailscanner:HelpDesk_From_mailscanner:from_mailscanner:C' => 'From mailscanner',
			'vtiger_troubletickets:parent_id:HelpDesk_Related_To:parent_id:V' => 'Related To',
			'vtiger_usersHelpDesk:user_name:HelpDesk_Assigned_To:assigned_user_id:V' => 'Assigned To',
			'vtiger_troubletickets:product_id:HelpDesk_Product_Name:product_id:V' => 'Product Name',
			'vtiger_troubletickets:priority:HelpDesk_Priority:ticketpriorities:V' => 'Priority',
			'vtiger_troubletickets:status:HelpDesk_Status:ticketstatus:V' => 'Status',
			'vtiger_troubletickets:severity:HelpDesk_Severity:ticketseverities:V' => 'Severity',
			'vtiger_troubletickets:hours:HelpDesk_Hours:hours:N' => 'Hours',
			'vtiger_crmentityHelpDesk:createdtime:HelpDesk_Created_Time:createdtime:DT' => 'Created Time',
			'vtiger_troubletickets:category:HelpDesk_Category:ticketcategories:V' => 'Category',
			'vtiger_troubletickets:days:HelpDesk_Days:days:I' => 'Days',
			'vtiger_troubletickets:update_log:HelpDesk_Update_History:update_log:V' => 'Update History',
			'vtiger_crmentityHelpDesk:modifiedtime:HelpDesk_Modified_Time:modifiedtime:DT' => 'Modified Time',
			'vtiger_troubletickets:ticket_no:HelpDesk_Ticket_No:ticket_no:V' => 'Ticket No',
			'vtiger_troubletickets:from_portal:HelpDesk_From_Portal:from_portal:C' => 'From Portal',
			'vtiger_crmentityHelpDesk:modifiedby:HelpDesk_Last_Modified_By:modifiedby:V' => 'Last Modified By',
			'vtiger_troubletickets:email:HelpDesk_Email:email:E' => 'Email',
			'vtiger_troubletickets:commentadded:HelpDesk_Comment_Added:commentadded:C' => 'Comment Added',
			'vtiger_crmentityHelpDesk:smcreatorid:HelpDesk_Created_By:created_user_id:V' => 'Created By',
		);
		$helpdesk2 = array(
			'vtiger_troubletickets:title:HelpDesk_Title:ticket_title:V' => 'Title',
			'vtiger_troubletickets:solution:HelpDesk_Solution:solution:V' => 'Solution',
			'vtiger_troubletickets:from_mailscanner:HelpDesk_From_mailscanner:from_mailscanner:C' => 'From mailscanner',
			'vtiger_troubletickets:parent_id:HelpDesk_Related_To:parent_id:V' => 'Related To',
			'vtiger_usersHelpDesk:user_name:HelpDesk_Assigned_To:assigned_user_id:V' => 'Assigned To',
			'vtiger_troubletickets:product_id:HelpDesk_Product_Name:product_id:V' => 'Product Name',
			'vtiger_troubletickets:priority:HelpDesk_Priority:ticketpriorities:V' => 'Priority',
			'vtiger_troubletickets:status:HelpDesk_Status:ticketstatus:V' => 'Status',
			'vtiger_troubletickets:severity:HelpDesk_Severity:ticketseverities:V' => 'Severity',
			'vtiger_troubletickets:hours:HelpDesk_Hours:hours:N' => 'Hours',
			'vtiger_crmentityHelpDesk:createdtime:HelpDesk_Created_Time:createdtime:DT' => 'Created Time',
			'vtiger_troubletickets:category:HelpDesk_Category:ticketcategories:V' => 'Category',
			'vtiger_troubletickets:days:HelpDesk_Days:days:I' => 'Days',
			'vtiger_troubletickets:update_log:HelpDesk_Update_History:update_log:V' => 'Update History',
			'vtiger_crmentityHelpDesk:modifiedtime:HelpDesk_Modified_Time:modifiedtime:DT' => 'Modified Time',
			'vtiger_troubletickets:ticket_no:HelpDesk_Ticket_No:ticket_no:V' => 'Ticket No',
			'vtiger_troubletickets:from_portal:HelpDesk_From_Portal:from_portal:C' => 'From Portal',
			'vtiger_crmentityHelpDesk:modifiedby:HelpDesk_Last_Modified_By:modifiedby:V' => 'Last Modified By',
			'vtiger_troubletickets:email:HelpDesk_Email:email:E' => 'Email',
			'vtiger_troubletickets:commentadded:HelpDesk_Comment_Added:commentadded:C' => 'Comment Added',
			'vtiger_crmentityHelpDesk:smcreatorid:HelpDesk_Created_By:created_user_id:V' => 'Created By',
		);
		$invoice = array(
			'vtiger_inventoryproductrelInvoice:productid:Invoice_Product Name:productid:V' => 'Product Name',
			'vtiger_inventoryproductrelInvoice:serviceid:Invoice_Service Name:serviceid:V' => 'Service Name',
			'vtiger_inventoryproductrelInvoice:listprice:Invoice_List Price:listprice:N' => 'List Price',
			'vtiger_inventoryproductrelInvoice:discount:Invoice_Discount:discount:N' => 'Discount',
			'vtiger_inventoryproductrelInvoice:quantity:Invoice_Quantity:quantity:N' => 'Quantity',
			'vtiger_inventoryproductrelInvoice:comment:Invoice_Comments:comment:V' => 'Comments',
		);
		$cbcalendar = array(
			'vtiger_activity:subject:cbCalendar_Subject:subject:V' => 'Subject',
			'vtiger_activity_reminder:reminder_time:cbCalendar_Send_Reminder:reminder_time:I' => 'Send Reminder',
			'vtiger_userscbCalendar:user_name:cbCalendar_Assigned_To:assigned_user_id:V' => 'Assigned To',
			'vtiger_activity:dtstart:cbCalendar_Start_Date_Time:dtstart:DT' => 'Start Date Time',
			'vtiger_activity:date_start:cbCalendar_Start_Date_and_Time:date_start:DT' => 'Start Date & Time',
			'vtiger_activity:time_start:cbCalendar_Time_Start:time_start:T' => 'Time Start',
			'vtiger_activity:dtend:cbCalendar_Due_Date:dtend:D' => 'Due Date',
			'vtiger_activity:due_date:cbCalendar_End_Date:due_date:D' => 'End Date',
			'vtiger_activity:time_end:cbCalendar_End_Time:time_end:T' => 'End Time',
			'vtiger_activity:recurringtype:cbCalendar_Recurrence:recurringtype:O' => 'Recurrence',
			'vtiger_activity:rel_id:cbCalendar_Related_To:rel_id:I' => 'Related To',
			'vtiger_activity:cto_id:cbCalendar_Contact_Name:cto_id:I' => 'Contact Name',
			'vtiger_activity:eventstatus:cbCalendar_Status:eventstatus:V' => 'Status',
			'vtiger_activity:priority:cbCalendar_Priority:taskpriority:V' => 'Priority',
			'vtiger_activity:sendnotification:cbCalendar_Send_Notification:sendnotification:C' => 'Send Notification',
			'vtiger_crmentitycbCalendar:createdtime:cbCalendar_Created_Time:createdtime:DT' => 'Created Time',
			'vtiger_crmentitycbCalendar:modifiedtime:cbCalendar_Modified_Time:modifiedtime:DT' => 'Modified Time',
			'vtiger_activity:activitytype:cbCalendar_Activity_Type:activitytype:V' => 'Activity Type',
			'vtiger_activity:visibility:cbCalendar_Visibility:visibility:V' => 'Visibility',
			'vtiger_activity:duration_hours:cbCalendar_Duration:duration_hours:I' => 'Duration',
			'vtiger_activity:duration_minutes:cbCalendar_Duration_Minutes:duration_minutes:I' => 'Duration Minutes',
			'vtiger_activity:location:cbCalendar_Location:location:V' => 'Location',
			'vtiger_activity:notime:cbCalendar_No_Time:notime:C' => 'No Time',
			'vtiger_activity:relatedwith:cbCalendar_Related_with:relatedwith:I' => 'Related with',
			'vtiger_crmentitycbCalendar:smcreatorid:cbCalendar_Created_By:created_user_id:V' => 'Created By',
			'vtiger_crmentitycbCalendar:modifiedby:cbCalendar_Last_Modified_By:modifiedby:V' => 'Last Modified By',
		);
		$empty = array();
		$notexist = array();
		return array(
			array('Accounts', 9, $accounts),
			array('HelpDesk', 25, $helpdesk),
			array('HelpDesk', '25,29', $helpdesk2),
			array('Invoice', 70, $invoice),
			array('cbCalendar', 135, $cbcalendar),
			array('', 0, $empty),
			array('DoesNotExist', 0, $notexist),
		);
	}

	/**
	 * Method testsgetColumnsListbyBlock
	 * @test
	 * @dataProvider getColumnsListbyBlockProvider
	 */
	public function testgetColumnsListbyBlock($module, $block, $expected) {
		$rep = new Reports('');
		$this->assertEquals($expected, $rep->getColumnsListbyBlock($module, $block));
	}

	/**
	 * Method getaccesfieldProvider
	 * params
	 */
	public function getaccesfieldProvider() {
		$accounts = array(
			'campaignrelstatus',
			'accountname',
			'account_no',
			'website',
			'phone',
			'tickersymbol',
			'fax',
			'account_id',
			'otherphone',
			'employees',
			'email1',
			'email2',
			'ownership',
			'industry',
			'rating',
			'accounttype',
			'siccode',
			'emailoptout',
			'annual_revenue',
			'assigned_user_id',
			'notify_owner',
			'modifiedtime',
			'createdtime',
			'modifiedby',
			'isconvertedfromlead',
			'convertedfromlead',
			'created_user_id',
			'cf_718',
			'cf_719',
			'cf_720',
			'cf_721',
			'cf_722',
			'cf_723',
			'cf_724',
			'cf_725',
			'cf_726',
			'cf_727',
			'cf_728',
			'bill_street',
			'ship_street',
			'bill_pobox',
			'ship_pobox',
			'bill_city',
			'ship_city',
			'bill_state',
			'ship_state',
			'bill_code',
			'ship_code',
			'bill_country',
			'ship_country',
			'description',
			'cf_729',
			'cf_730',
			'cf_731',
			'cf_732',
		);
		$helpdesk = array(
			'ticket_title',
			'from_mailscanner',
			'parent_id',
			'assigned_user_id',
			'product_id',
			'ticketpriorities',
			'ticketstatus',
			'ticketseverities',
			'createdtime',
			'hours',
			'ticketcategories',
			'days',
			'update_log',
			'modifiedtime',
			'ticket_no',
			'from_portal',
			'modifiedby',
			'email',
			'commentadded',
			'created_user_id',
			'description',
			'solution',
			'comments',
		);
		$accountshelpdesk = array(
			'campaignrelstatus',
			'accountname',
			'account_no',
			'website',
			'phone',
			'tickersymbol',
			'fax',
			'account_id',
			'otherphone',
			'employees',
			'email1',
			'email2',
			'ownership',
			'industry',
			'rating',
			'accounttype',
			'siccode',
			'emailoptout',
			'annual_revenue',
			'assigned_user_id',
			'notify_owner',
			'modifiedtime',
			'createdtime',
			'modifiedby',
			'isconvertedfromlead',
			'convertedfromlead',
			'created_user_id',
			'cf_718',
			'cf_719',
			'cf_720',
			'cf_721',
			'cf_722',
			'cf_723',
			'cf_724',
			'cf_725',
			'cf_726',
			'cf_727',
			'cf_728',
			'bill_street',
			'ship_street',
			'bill_pobox',
			'ship_pobox',
			'bill_city',
			'ship_city',
			'bill_state',
			'ship_state',
			'bill_code',
			'ship_code',
			'bill_country',
			'ship_country',
			'description',
			'cf_729',
			'cf_730',
			'cf_731',
			'cf_732',
			'ticket_title',
			'from_mailscanner',
			'parent_id',
			'assigned_user_id',
			'product_id',
			'ticketpriorities',
			'ticketstatus',
			'ticketseverities',
			'createdtime',
			'hours',
			'ticketcategories',
			'days',
			'update_log',
			'modifiedtime',
			'ticket_no',
			'from_portal',
			'modifiedby',
			'email',
			'commentadded',
			'created_user_id',
			'description',
			'solution',
			'comments',
		);
		$assets = array(
			'asset_no',
			'product',
			'serialnumber',
			'assigned_user_id',
			'datesold',
			'dateinservice',
			'assetstatus',
			'tagnumber',
			'invoiceid',
			'shippingmethod',
			'shippingtrackingnumber',
			'assetname',
			'account',
			'createdtime',
			'modifiedtime',
			'modifiedby',
			'created_user_id',
			'description',
		);
		$cbcalendar = array(
			'subject',
			'reminder_time',
			'assigned_user_id',
			'dtstart',
			'date_start',
			'time_start',
			'dtend',
			'due_date',
			'time_end',
			'recurringtype',
			'rel_id',
			'cto_id',
			'eventstatus',
			'taskpriority',
			'sendnotification',
			'createdtime',
			'modifiedtime',
			'activitytype',
			'visibility',
			'duration_hours',
			'duration_minutes',
			'location',
			'notime',
			'relatedwith',
			'created_user_id',
			'modifiedby',
			'description',
			'followupdt',
			'followuptype',
			'followupcreate',
		);
		$empty = array();
		$notexist = array();
		return array(
			array('Accounts', '', $accounts),
			array('HelpDesk', '', $helpdesk),
			array('Accounts', 'HelpDesk', $accountshelpdesk),
			array('Assets', '', $assets),
			array('cbCalendar', '', $cbcalendar),
			array('', '', $empty),
			array('DoesNotExist', 'DoesNotExist', $notexist),
		);
	}

	/**
	 * Method testgetaccesfield
	 * @test
	 * @dataProvider getaccesfieldProvider
	 */
	public function testgetaccesfield($pmodule, $smodule, $expected) {
		$rep = new Reports('');
		$rep->primodule = $pmodule;
		$rep->secmodule = $smodule;
		sort($expected);
		$actual = $rep->getaccesfield();
		sort($actual);
		$this->assertEquals($expected, $actual);
	}
}
