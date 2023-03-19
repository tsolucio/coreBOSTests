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

class VtigerModuleOperation_QueryCPTest extends TestCase {

	public static $vtModuleOperation = null;

	public static function setUpBeforeClass(): void {
		global $adb, $current_user, $log;
		$current_user = Users::getActiveAdminUser();
		$webserviceObject = VtigerWebserviceObject::fromName($adb, 'Accounts');
		self::$vtModuleOperation = new VtigerModuleOperation($webserviceObject, $current_user, $adb, $log);
		coreBOS_Session::set('authenticatedUserIsPortalUser', 1);
		coreBOS_Session::set('authenticatedUserPortalContact', 1084);
	}

	public static function tearDownAfterClass(): void {
		global $current_user;
		$current_user = Users::getActiveAdminUser();
		coreBOS_Session::delete('authenticatedUserIsPortalUser');
		coreBOS_Session::delete('authenticatedUserPortalContact');
	}

	public function testStandardVTQL() {
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select firstname, lastname from Leads order by firstname desc limit 0,2;', $meta, $queryRelatedModules);
		$this->assertEquals("SELECT vtiger_leaddetails.firstname,vtiger_leaddetails.lastname,vtiger_leaddetails.leadid FROM vtiger_leaddetails LEFT JOIN vtiger_crmentity ON vtiger_leaddetails.leadid=vtiger_crmentity.crmid   WHERE  vtiger_crmentity.deleted=0 and vtiger_leaddetails.converted=0 ORDER BY vtiger_leaddetails.firstname DESC LIMIT 0,2;", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select accountname from Accounts;', $meta, $queryRelatedModules);
		$this->assertEquals("SELECT vtiger_account.accountname,vtiger_account.accountid FROM vtiger_account LEFT JOIN vtiger_crmentity ON vtiger_account.accountid=vtiger_crmentity.crmid WHERE (vtiger_account.accountid=74) and vtiger_crmentity.deleted=0 LIMIT 100;", $actual);
	}

	public function testInventoryModules() {
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select vendor_id, pl_net_total, hdnGrandTotal from purchaseorder where (duedate >= '2012-01-01' and duedate <= '2020-12-31');", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_purchaseorder.vendorid, vtiger_purchaseorder.pl_net_total, vtiger_purchaseorder.total, vtiger_purchaseorder.purchaseorderid FROM vtiger_purchaseorder INNER JOIN vtiger_crmentity ON vtiger_purchaseorder.purchaseorderid = vtiger_crmentity.crmid WHERE (vtiger_purchaseorder.contactid=1084) and vtiger_crmentity.deleted=0 AND ( (( vtiger_purchaseorder.duedate >= '2012-01-01') AND ( vtiger_purchaseorder.duedate <= '2020-12-31') )) AND vtiger_purchaseorder.purchaseorderid > 0 ", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select subject from SalesOrder;', $meta, $queryRelatedModules);
		$this->assertEquals("SELECT vtiger_salesorder.subject,vtiger_salesorder.salesorderid FROM vtiger_salesorder LEFT JOIN vtiger_crmentity ON vtiger_salesorder.salesorderid=vtiger_crmentity.crmid WHERE (vtiger_salesorder.accountid=74 or vtiger_salesorder.contactid=1084) and vtiger_crmentity.deleted=0 LIMIT 100;", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select subject from Quotes;', $meta, $queryRelatedModules);
		$this->assertEquals("SELECT vtiger_quotes.subject,vtiger_quotes.quoteid FROM vtiger_quotes LEFT JOIN vtiger_crmentity ON vtiger_quotes.quoteid=vtiger_crmentity.crmid WHERE (vtiger_quotes.accountid=74 or vtiger_quotes.contactid=1084) and vtiger_crmentity.deleted=0 LIMIT 100;", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select subject from Invoice;', $meta, $queryRelatedModules);
		$this->assertEquals("SELECT vtiger_invoice.subject,vtiger_invoice.invoiceid FROM vtiger_invoice LEFT JOIN vtiger_crmentity ON vtiger_invoice.invoiceid=vtiger_crmentity.crmid WHERE (vtiger_invoice.accountid=74 or vtiger_invoice.contactid=1084) and vtiger_crmentity.deleted=0 LIMIT 100;", $actual);
	}

	public function testParenthesis() {
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select projectname,modifiedtime from project where (projectname like '%o%'  and modifiedtime>'2016-06-30 19:11:59');", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_project.projectname, vtiger_crmentity.modifiedtime, vtiger_project.projectid FROM vtiger_project INNER JOIN vtiger_crmentity ON vtiger_project.projectid = vtiger_crmentity.crmid WHERE (vtiger_project.linktoaccountscontacts=74 or vtiger_project.linktoaccountscontacts=1084) and vtiger_crmentity.deleted=0 AND ( (( vtiger_project.projectname LIKE '%o%') AND ( vtiger_crmentity.modifiedtime > '2016-06-30 19:11:59') )) AND vtiger_project.projectid > 0 ", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select projectmilestonename,Project.projectname from projectmilestone;", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_projectmilestone.projectmilestonename, vtiger_projectprojectid.projectname as projectprojectname, vtiger_projectmilestone.projectmilestoneid FROM vtiger_projectmilestone INNER JOIN vtiger_crmentity ON vtiger_projectmilestone.projectmilestoneid = vtiger_crmentity.crmid LEFT JOIN vtiger_project AS vtiger_projectprojectid ON vtiger_projectprojectid.projectid=vtiger_projectmilestone.projectid and vtiger_projectprojectid.linktoaccountscontacts IN (74,1084) WHERE vtiger_crmentity.deleted=0 AND vtiger_projectmilestone.projectmilestoneid > 0 ", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select projectmilestonename,modifiedtime from projectmilestone;", $meta, $queryRelatedModules);
		$this->assertEquals("SELECT vtiger_projectmilestone.projectmilestonename,vtiger_crmentity.modifiedtime,vtiger_projectmilestone.projectmilestoneid FROM vtiger_projectmilestone LEFT JOIN vtiger_crmentity ON vtiger_projectmilestone.projectmilestoneid=vtiger_crmentity.crmid LEFT JOIN vtiger_project AS vtiger_projectprojectid ON vtiger_projectprojectid.projectid=vtiger_projectmilestone.projectid and vtiger_projectprojectid.linktoaccountscontacts IN (74,1084) WHERE vtiger_crmentity.deleted=0 LIMIT 100;", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select cbsurveyanswer_no,cbSurveyDone.cbsurveydone_no from cbSurveyAnswer;", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_cbsurveyanswer.cbsurveyanswer_no, vtiger_cbsurveydonecbsurveydone.cbsurveydone_no as cbsurveydonecbsurveydone_no, vtiger_cbsurveyanswer.cbsurveyanswerid FROM vtiger_cbsurveyanswer INNER JOIN vtiger_crmentity ON vtiger_cbsurveyanswer.cbsurveyanswerid = vtiger_crmentity.crmid LEFT JOIN vtiger_cbsurveydone AS vtiger_cbsurveydonecbsurveydone ON vtiger_cbsurveydonecbsurveydone.cbsurveydoneid=vtiger_cbsurveyanswer.cbsurveydone WHERE (vtiger_cbsurveyanswer.relatedwith=74 or vtiger_cbsurveyanswer.relatedwith=1084) and vtiger_crmentity.deleted=0 AND vtiger_cbsurveyanswer.cbsurveyanswerid > 0 ", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select cbsurveyanswer_no from cbSurveyAnswer;", $meta, $queryRelatedModules);
		$this->assertEquals("SELECT vtiger_cbsurveyanswer.cbsurveyanswer_no,vtiger_cbsurveyanswer.cbsurveyanswerid FROM vtiger_cbsurveyanswer LEFT JOIN vtiger_crmentity ON vtiger_cbsurveyanswer.cbsurveyanswerid=vtiger_crmentity.crmid WHERE (vtiger_cbsurveyanswer.relatedwith=74 or vtiger_cbsurveyanswer.relatedwith=1084) and vtiger_crmentity.deleted=0 LIMIT 100;", $actual);
	}

	public function testQueryCountNull() {
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select count(*) from accounts where accountname != null;', $meta, $queryRelatedModules);
		$this->assertEquals("SELECT COUNT(*) FROM vtiger_account LEFT JOIN vtiger_crmentity ON vtiger_account.accountid=vtiger_crmentity.crmid WHERE (vtiger_account.accountid=74) and (vtiger_account.accountname != null) AND vtiger_crmentity.deleted=0 LIMIT 100;", $actual);
	}

	public function testUsers() {
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select id, account_no, accountname, accounts.accountname from accounts where assigned_user_id !='cbTest testtz' and cf_729 = 'one' limit 0, 10;", $meta, $queryRelatedModules);
		$this->assertEquals(
			"select vtiger_account.accountid, vtiger_account.account_no, vtiger_account.accountname, vtiger_accountaccount_id.accountname as accountsaccountname FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid INNER JOIN vtiger_accountscf ON vtiger_account.accountid = vtiger_accountscf.accountid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_account.parentid WHERE (vtiger_account.accountid=74) and vtiger_crmentity.deleted=0 AND (( (trim(vtiger_users.ename) <> 'cbTest testtz' or vtiger_groups.groupname <> 'cbTest testtz')) AND ( vtiger_accountscf.cf_729 IN ( select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::cf_729\" and i18n = 'one') OR vtiger_accountscf.cf_729 = 'one') ) AND vtiger_account.accountid > 0 limit 0,10",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select id, account_no, accountname, accounts.accountname from accounts where assigned_user_id='cbTest testtz' and cf_729='one' limit 0, 100;", $meta, $queryRelatedModules);
		$this->assertEquals(
			"select vtiger_account.accountid, vtiger_account.account_no, vtiger_account.accountname, vtiger_accountaccount_id.accountname as accountsaccountname FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid INNER JOIN vtiger_accountscf ON vtiger_account.accountid = vtiger_accountscf.accountid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_account.parentid WHERE (vtiger_account.accountid=74) and vtiger_crmentity.deleted=0 AND (( (trim(vtiger_users.ename) = 'cbTest testtz' or vtiger_groups.groupname = 'cbTest testtz')) AND ( vtiger_accountscf.cf_729 IN ( select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::cf_729\" and i18n = 'one') OR vtiger_accountscf.cf_729 = 'one') ) AND vtiger_account.accountid > 0 limit 0,100",
			$actual
		);
	}

	public function testUserQueries() {
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select * from Users;", $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT vtiger_users.user_name,vtiger_users.is_admin,vtiger_users.email1,vtiger_users.status,vtiger_users.first_name,vtiger_users.last_name,vtiger_user2role.roleid,vtiger_users.ename,vtiger_users.currency_id,vtiger_users.currency_grouping_pattern,vtiger_users.currency_decimal_separator,vtiger_users.currency_grouping_separator,vtiger_users.currency_symbol_placement,vtiger_users.no_of_currency_decimals,vtiger_users.lead_view,vtiger_users.activity_view,vtiger_users.signature,vtiger_users.hour_format,vtiger_users.start_hour,vtiger_users.end_hour,vtiger_users.title,vtiger_users.phone_fax,vtiger_users.department,vtiger_users.email2,vtiger_users.phone_work,vtiger_users.secondaryemail,vtiger_users.phone_mobile,vtiger_users.reports_to_id,vtiger_users.phone_home,vtiger_users.phone_other,vtiger_users.date_format,vtiger_users.description,vtiger_users.internal_mailer,vtiger_users.time_zone,vtiger_users.theme,vtiger_users.language,vtiger_users.send_email_to_sender,vtiger_users.address_street,vtiger_users.address_country,vtiger_users.address_city,vtiger_users.address_postalcode,vtiger_users.address_state,vtiger_asteriskextensions.asterisk_extension,vtiger_asteriskextensions.use_asterisk,vtiger_users.id FROM vtiger_users LEFT JOIN vtiger_user2role ON vtiger_users.id=vtiger_user2role.userid LEFT JOIN vtiger_asteriskextensions ON vtiger_users.id=vtiger_asteriskextensions.userid  WHERE  vtiger_users.status='Active' LIMIT 100;",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select id,first_name, status from Users;", $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT vtiger_users.id,vtiger_users.first_name,vtiger_users.status FROM vtiger_users  WHERE  vtiger_users.status='Active' LIMIT 100;",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select id,first_name, status, roleid from Users;", $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT vtiger_users.id,vtiger_users.first_name,vtiger_users.status,vtiger_user2role.roleid FROM vtiger_users LEFT JOIN vtiger_user2role ON vtiger_users.id=vtiger_user2role.userid  WHERE  vtiger_users.status='Active' LIMIT 100;",
			$actual
		);
	}

	public function testEmailQueries() {
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select * from Emails;", $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT vtiger_emaildetails.from_email,vtiger_activity.date_start,vtiger_activity.semodule,vtiger_emaildetails.to_email,vtiger_activity.activitytype,vtiger_emaildetails.cc_email,vtiger_emaildetails.bcc_email,vtiger_crmentity.smownerid,vtiger_emaildetails.idlists,vtiger_email_track.access_count,vtiger_emaildetails.email_flag,vtiger_crmentity.modifiedtime,vtiger_crmentity.modifiedby,vtiger_emaildetails.bounce,vtiger_emaildetails.clicked,vtiger_emaildetails.spamreport,vtiger_emaildetails.delivered,vtiger_emaildetails.dropped,vtiger_emaildetails.open,vtiger_emaildetails.unsubscribe,vtiger_emaildetails.replyto,vtiger_crmentity.createdtime,vtiger_activity.subject,vtiger_attachments.name,vtiger_activity.time_start,vtiger_crmentity.description,vtiger_activity.activityid FROM vtiger_activity LEFT JOIN vtiger_emaildetails ON vtiger_activity.activityid=vtiger_emaildetails.emailid LEFT JOIN vtiger_crmentity ON vtiger_activity.activityid=vtiger_crmentity.crmid LEFT JOIN vtiger_email_track ON vtiger_activity.activityid=vtiger_email_track.mailid LEFT JOIN vtiger_seattachmentsrel ON vtiger_seattachmentsrel.crmid=vtiger_activity.activityid LEFT JOIN vtiger_attachments ON vtiger_seattachmentsrel.attachmentsid=vtiger_attachments.attachmentsid inner join vtiger_seactivityrel on vtiger_seactivityrel.activityid=vtiger_activity.activityid and vtiger_seactivityrel.crmid IN (74,1084) WHERE activitytype='Emails' AND vtiger_crmentity.deleted=0 LIMIT 100;",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select id,from_email, unsubscribe, Contacts.firstname from Emails;", $meta, $queryRelatedModules);
		$this->assertEquals(
			"select vtiger_activity.activityid, vtiger_emaildetails.from_email, vtiger_emaildetails.unsubscribe, vtiger_contactdetailsparent_id.firstname as contactsfirstname FROM vtiger_activity INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid INNER JOIN vtiger_emaildetails ON vtiger_activity.activityid = vtiger_emaildetails.emailid LEFT JOIN vtiger_contactdetails AS vtiger_contactdetailsparent_id ON vtiger_contactdetailsparent_id.contactid=vtiger_emaildetails.idlists inner join vtiger_seactivityrel on vtiger_seactivityrel.activityid=vtiger_activity.activityid and vtiger_seactivityrel.crmid IN (74,1084) WHERE vtiger_crmentity.deleted=0 AND vtiger_activity.activityid > 0 ",
			$actual
		);
	}

	public function testRelationsWithIncorrectSyntax() {
		global $GetRelatedList_ReturnOnlyQuery;
		$GetRelatedList_ReturnOnlyQuery = true;
		///////////  THIS ONE IS INCORRECT BUT PRODUCES CORRECT SQL  !!
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select projecttaskname from projecttask where related.project='33x6613; limit 3", $meta, $queryRelatedModules);
		$this->assertEquals(
			"select vtiger_projecttask.projecttaskname,vtiger_crmentity.cbuuid FROM vtiger_projecttask INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_projecttask.projecttaskid INNER JOIN vtiger_projecttaskcf ON vtiger_projecttaskcf.projecttaskid = vtiger_projecttask.projecttaskid INNER JOIN vtiger_project ON (vtiger_project.projectid = vtiger_projecttask.projectid) and vtiger_project.linktoaccountscontacts IN (74,1084) LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid WHERE vtiger_crmentity.deleted=0 AND vtiger_project.projectid = 6613 limit 3 ",
			$actual
		);
		///////////  THIS ONE IS INCORRECT BUT PRODUCES CORRECT SQL  !!
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select projecttaskname from projecttask where related.project='33x6613'; limit 3", $meta, $queryRelatedModules);
		$this->assertEquals(
			"select vtiger_projecttask.projecttaskname,vtiger_crmentity.cbuuid FROM vtiger_projecttask INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_projecttask.projecttaskid INNER JOIN vtiger_projecttaskcf ON vtiger_projecttaskcf.projecttaskid = vtiger_projecttask.projecttaskid INNER JOIN vtiger_project ON (vtiger_project.projectid = vtiger_projecttask.projectid) and vtiger_project.linktoaccountscontacts IN (74,1084) LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid WHERE vtiger_crmentity.deleted=0 AND vtiger_project.projectid = 6613 limit 3 ",
			$actual
		);
		///////////  THIS ONE IS INCORRECT BUT PRODUCES CORRECT SQL WITH AN UNDESIRED RESULT !!
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select projecttaskname from projecttask where project.id='33x6613; limit 3", $meta, $queryRelatedModules);
		$this->assertEquals(
			"select vtiger_projecttask.projecttaskname, vtiger_projecttask.projecttaskid FROM vtiger_projecttask INNER JOIN vtiger_crmentity ON vtiger_projecttask.projecttaskid = vtiger_crmentity.crmid LEFT JOIN vtiger_project AS vtiger_projectprojectid ON vtiger_projectprojectid.projectid=vtiger_projecttask.projectid INNER JOIN vtiger_project ON (vtiger_project.projectid = vtiger_projecttask.projectid) and vtiger_project.linktoaccountscontacts IN (74,1084) WHERE vtiger_crmentity.deleted=0 AND ((vtiger_projectprojectid.projectid = '6613; limit 3') ) AND vtiger_projecttask.projecttaskid > 0 ",
			$actual
		);
		///////////  THIS ONE IS INCORRECT BUT PRODUCES CORRECT SQL
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select projecttaskname from projecttask where project.id='33x6613'; limit 3", $meta, $queryRelatedModules);
		$this->assertEquals(
			"select vtiger_projecttask.projecttaskname, vtiger_projecttask.projecttaskid FROM vtiger_projecttask INNER JOIN vtiger_crmentity ON vtiger_projecttask.projecttaskid = vtiger_crmentity.crmid LEFT JOIN vtiger_project AS vtiger_projectprojectid ON vtiger_projectprojectid.projectid=vtiger_projecttask.projectid INNER JOIN vtiger_project ON (vtiger_project.projectid = vtiger_projecttask.projectid) and vtiger_project.linktoaccountscontacts IN (74,1084) WHERE vtiger_crmentity.deleted=0 AND ((vtiger_projectprojectid.projectid = '6613') ) AND vtiger_projecttask.projecttaskid > 0 limit 0,3",
			$actual
		);
	}

	public function testRelations() {
		global $GetRelatedList_ReturnOnlyQuery;
		$GetRelatedList_ReturnOnlyQuery = true;
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select vendor_id,subject from purchaseorder where related.products = 14x2620", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_purchaseorder.subject,vtiger_purchaseorder.vendorid,vtiger_crmentity.cbuuid FROM vtiger_purchaseorder INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_purchaseorder.purchaseorderid INNER JOIN vtiger_inventoryproductrel ON vtiger_inventoryproductrel.id = vtiger_purchaseorder.purchaseorderid INNER JOIN vtiger_products ON vtiger_products.productid = vtiger_inventoryproductrel.productid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid left join vtiger_pobillads on vtiger_pobillads.pobilladdressid = vtiger_purchaseorder.purchaseorderid left join vtiger_poshipads on vtiger_poshipads.poshipaddressid = vtiger_purchaseorder.purchaseorderid left join vtiger_purchaseordercf on vtiger_purchaseordercf.purchaseorderid = vtiger_purchaseorder.purchaseorderid WHERE (vtiger_purchaseorder.contactid=1084) and vtiger_crmentity.deleted=0 AND vtiger_products.productid=2620", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select * from products where related.purchaseorder=5x13215", $meta, $queryRelatedModules);
		$this->assertEquals("select  * ,sequence_no FROM vtiger_inventoryproductrel
					left join vtiger_service on serviceid=vtiger_inventoryproductrel.productid
					left join vtiger_products on vtiger_products.productid=vtiger_inventoryproductrel.productid where id=13215", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select id from products where related.purchaseorder=5x13215", $meta, $queryRelatedModules);
		$this->assertEquals("select  vtiger_inventoryproductrel.productid as id ,sequence_no FROM vtiger_inventoryproductrel
					left join vtiger_service on serviceid=vtiger_inventoryproductrel.productid
					left join vtiger_products on vtiger_products.productid=vtiger_inventoryproductrel.productid where id=13215", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select productid from products where related.purchaseorder=5x13215", $meta, $queryRelatedModules);
		$this->assertEquals("select  vtiger_inventoryproductrel.productid ,sequence_no FROM vtiger_inventoryproductrel
					left join vtiger_service on serviceid=vtiger_inventoryproductrel.productid
					left join vtiger_products on vtiger_products.productid=vtiger_inventoryproductrel.productid where id=13215", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select potentialname,Accounts.accountname from Potentials;", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_potential.potentialname, vtiger_accountrelated_to.accountname as accountsaccountname, vtiger_potential.potentialid FROM vtiger_potential INNER JOIN vtiger_crmentity ON vtiger_potential.potentialid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountrelated_to ON vtiger_accountrelated_to.accountid=vtiger_potential.related_to WHERE (vtiger_potential.related_to=74 or vtiger_potential.related_to=1084) and vtiger_crmentity.deleted=0 AND vtiger_potential.potentialid > 0 ", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select potentialname,Accounts.accountname,Contacts.lastname from Potentials;", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_potential.potentialname, vtiger_accountrelated_to.accountname as accountsaccountname, vtiger_contactdetailsrelated_to.lastname as contactslastname, vtiger_potential.potentialid FROM vtiger_potential INNER JOIN vtiger_crmentity ON vtiger_potential.potentialid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountrelated_to ON vtiger_accountrelated_to.accountid=vtiger_potential.related_to LEFT JOIN vtiger_contactdetails AS vtiger_contactdetailsrelated_to ON vtiger_contactdetailsrelated_to.contactid=vtiger_potential.related_to WHERE (vtiger_potential.related_to=74 or vtiger_potential.related_to=1084) and vtiger_crmentity.deleted=0 AND vtiger_potential.potentialid > 0 ", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select ticket_title,Accounts.accountname,Contacts.lastname from HelpDesk;", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_troubletickets.title, vtiger_accountparent_id.accountname as accountsaccountname, vtiger_contactdetailsparent_id.lastname as contactslastname, vtiger_troubletickets.ticketid FROM vtiger_troubletickets INNER JOIN vtiger_crmentity ON vtiger_troubletickets.ticketid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountparent_id ON vtiger_accountparent_id.accountid=vtiger_troubletickets.parent_id LEFT JOIN vtiger_contactdetails AS vtiger_contactdetailsparent_id ON vtiger_contactdetailsparent_id.contactid=vtiger_troubletickets.parent_id WHERE (vtiger_troubletickets.parent_id=74 or vtiger_troubletickets.parent_id=1084) and vtiger_crmentity.deleted=0 AND vtiger_troubletickets.ticketid > 0 ", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select * from projecttask where related.project='33x6613';", $meta, $queryRelatedModules);
		$this->assertEquals(
			"select vtiger_projecttask.projecttaskname,vtiger_projecttask.projecttask_no,vtiger_projecttask.projecttaskpriority,vtiger_projecttask.projecttasktype,vtiger_projecttask.projecttasknumber,vtiger_projecttask.projectid,vtiger_crmentity.smownerid as assigned_user_id,vtiger_crmentity.smownerid,vtiger_users.first_name as owner_firstname, vtiger_users.last_name as owner_lastname,vtiger_projecttask.email,vtiger_projecttask.projecttaskstatus,vtiger_crmentity.smcreatorid as creator,vtiger_crmentity.smcreatorid,vtiger_users.first_name as creator_firstname, vtiger_users.last_name as creator_lastname,vtiger_projecttask.projecttaskprogress,vtiger_projecttask.projecttaskhours,vtiger_projecttask.startdate,vtiger_projecttask.enddate,vtiger_crmentity.createdtime,vtiger_crmentity.modifiedtime,vtiger_crmentity.modifiedby,vtiger_crmentity.description,vtiger_projecttask.projecttaskid,vtiger_crmentity.cbuuid FROM vtiger_projecttask INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_projecttask.projecttaskid INNER JOIN vtiger_projecttaskcf ON vtiger_projecttaskcf.projecttaskid = vtiger_projecttask.projecttaskid INNER JOIN vtiger_project ON (vtiger_project.projectid = vtiger_projecttask.projectid) and vtiger_project.linktoaccountscontacts IN (74,1084) LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid WHERE vtiger_crmentity.deleted=0 AND vtiger_project.projectid = 6613",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select * from projecttask where related.project='33x6613' and projecttaskname='tttt';", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_projecttask.projecttaskname,vtiger_projecttask.projecttask_no,vtiger_projecttask.projecttaskpriority,vtiger_projecttask.projecttasktype,vtiger_projecttask.projecttasknumber,vtiger_projecttask.projectid,vtiger_crmentity.smownerid as assigned_user_id,vtiger_crmentity.smownerid,vtiger_users.first_name as owner_firstname, vtiger_users.last_name as owner_lastname,vtiger_projecttask.email,vtiger_projecttask.projecttaskstatus,vtiger_crmentity.smcreatorid as creator,vtiger_crmentity.smcreatorid,vtiger_users.first_name as creator_firstname, vtiger_users.last_name as creator_lastname,vtiger_projecttask.projecttaskprogress,vtiger_projecttask.projecttaskhours,vtiger_projecttask.startdate,vtiger_projecttask.enddate,vtiger_crmentity.createdtime,vtiger_crmentity.modifiedtime,vtiger_crmentity.modifiedby,vtiger_crmentity.description,vtiger_projecttask.projecttaskid,vtiger_crmentity.cbuuid FROM vtiger_projecttask INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_projecttask.projecttaskid INNER JOIN vtiger_projecttaskcf ON vtiger_projecttaskcf.projecttaskid = vtiger_projecttask.projecttaskid INNER JOIN vtiger_project ON (vtiger_project.projectid = vtiger_projecttask.projectid) and vtiger_project.linktoaccountscontacts IN (74,1084) LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid WHERE vtiger_crmentity.deleted=0 AND vtiger_project.projectid = 6613 and projecttaskname='tttt' ", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select * from documents where related.accounts='11x75';", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_notes.title,vtiger_notes.folderid,vtiger_notes.note_no,vtiger_crmentity.smownerid as assigned_user_id,vtiger_crmentity.smownerid,vtiger_users.first_name as owner_firstname, vtiger_users.last_name as owner_lastname,vtiger_crmentity.createdtime,vtiger_crmentity.modifiedtime,vtiger_crmentity.modifiedby,vtiger_crmentity.smcreatorid as creator,vtiger_crmentity.smcreatorid,vtiger_users.first_name as creator_firstname, vtiger_users.last_name as creator_lastname,vtiger_notes.template,vtiger_notes.template_for,vtiger_notes.mergetemplate,vtiger_notes.notecontent,vtiger_notes.filelocationtype,vtiger_notes.filestatus,vtiger_notes.filename,vtiger_notes.filesize,vtiger_notes.filetype,vtiger_notes.fileversion,vtiger_notes.filedownloadcount,vtiger_notes.notesid,vtiger_crmentity.cbuuid from vtiger_notes inner join vtiger_senotesrel on vtiger_senotesrel.notesid=vtiger_notes.notesid and vtiger_senotesrel.crmid IN (74,1084) left join vtiger_notescf ON vtiger_notescf.notesid=vtiger_notes.notesid inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_notes.notesid and vtiger_crmentity.deleted=0 inner join vtiger_crmobject crm2 on crm2.crmid=vtiger_senotesrel.crmid left join vtiger_groups on vtiger_groups.groupid=vtiger_crmentity.smownerid left join vtiger_seattachmentsrel on vtiger_seattachmentsrel.crmid=vtiger_notes.notesid left join vtiger_attachments on vtiger_seattachmentsrel.attachmentsid=vtiger_attachments.attachmentsid left join vtiger_users on vtiger_crmentity.smownerid=vtiger_users.id where crm2.crmid=75 ", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select * from documents where filelocationtype='E' and related.contacts='12x1084';", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_notes.title,vtiger_notes.folderid,vtiger_notes.note_no,vtiger_crmentity.smownerid as assigned_user_id,vtiger_crmentity.smownerid,vtiger_users.first_name as owner_firstname, vtiger_users.last_name as owner_lastname,vtiger_crmentity.createdtime,vtiger_crmentity.modifiedtime,vtiger_crmentity.modifiedby,vtiger_crmentity.smcreatorid as creator,vtiger_crmentity.smcreatorid,vtiger_users.first_name as creator_firstname, vtiger_users.last_name as creator_lastname,vtiger_notes.template,vtiger_notes.template_for,vtiger_notes.mergetemplate,vtiger_notes.notecontent,vtiger_notes.filelocationtype,vtiger_notes.filestatus,vtiger_notes.filename,vtiger_notes.filesize,vtiger_notes.filetype,vtiger_notes.fileversion,vtiger_notes.filedownloadcount,vtiger_notes.notesid,vtiger_crmentity.cbuuid from vtiger_notes inner join vtiger_senotesrel on vtiger_senotesrel.notesid=vtiger_notes.notesid and vtiger_senotesrel.crmid IN (74,1084) left join vtiger_notescf ON vtiger_notescf.notesid=vtiger_notes.notesid inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_notes.notesid and vtiger_crmentity.deleted=0 inner join vtiger_crmobject crm2 on crm2.crmid=vtiger_senotesrel.crmid left join vtiger_groups on vtiger_groups.groupid=vtiger_crmentity.smownerid left join vtiger_seattachmentsrel on vtiger_seattachmentsrel.crmid=vtiger_notes.notesid left join vtiger_attachments on vtiger_seattachmentsrel.attachmentsid=vtiger_attachments.attachmentsid left join vtiger_users on vtiger_crmentity.smownerid=vtiger_users.id where filelocationtype='E' and crm2.crmid=1084 ", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select * from documents where (related.Contacts='12x1084') AND (filelocationtype LIKE '%I%') LIMIT 5;", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_notes.title,vtiger_notes.folderid,vtiger_notes.note_no,vtiger_crmentity.smownerid as assigned_user_id,vtiger_crmentity.smownerid,vtiger_users.first_name as owner_firstname, vtiger_users.last_name as owner_lastname,vtiger_crmentity.createdtime,vtiger_crmentity.modifiedtime,vtiger_crmentity.modifiedby,vtiger_crmentity.smcreatorid as creator,vtiger_crmentity.smcreatorid,vtiger_users.first_name as creator_firstname, vtiger_users.last_name as creator_lastname,vtiger_notes.template,vtiger_notes.template_for,vtiger_notes.mergetemplate,vtiger_notes.notecontent,vtiger_notes.filelocationtype,vtiger_notes.filestatus,vtiger_notes.filename,vtiger_notes.filesize,vtiger_notes.filetype,vtiger_notes.fileversion,vtiger_notes.filedownloadcount,vtiger_notes.notesid,vtiger_crmentity.cbuuid from vtiger_notes inner join vtiger_senotesrel on vtiger_senotesrel.notesid=vtiger_notes.notesid and vtiger_senotesrel.crmid IN (74,1084) left join vtiger_notescf ON vtiger_notescf.notesid=vtiger_notes.notesid inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_notes.notesid and vtiger_crmentity.deleted=0 inner join vtiger_crmobject crm2 on crm2.crmid=vtiger_senotesrel.crmid left join vtiger_groups on vtiger_groups.groupid=vtiger_crmentity.smownerid left join vtiger_seattachmentsrel on vtiger_seattachmentsrel.crmid=vtiger_notes.notesid left join vtiger_attachments on vtiger_seattachmentsrel.attachmentsid=vtiger_attachments.attachmentsid left join vtiger_users on vtiger_crmentity.smownerid=vtiger_users.id where (crm2.crmid=1084) AND (filelocationtype LIKE '%I%') LIMIT 5 ", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select * from documents where ( related.Contacts='12x1084' or crm2.crmid='11x75') AND (filelocationtype LIKE '%I%') LIMIT 5;", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_notes.title,vtiger_notes.folderid,vtiger_notes.note_no,vtiger_crmentity.smownerid as assigned_user_id,vtiger_crmentity.smownerid,vtiger_users.first_name as owner_firstname, vtiger_users.last_name as owner_lastname,vtiger_crmentity.createdtime,vtiger_crmentity.modifiedtime,vtiger_crmentity.modifiedby,vtiger_crmentity.smcreatorid as creator,vtiger_crmentity.smcreatorid,vtiger_users.first_name as creator_firstname, vtiger_users.last_name as creator_lastname,vtiger_notes.template,vtiger_notes.template_for,vtiger_notes.mergetemplate,vtiger_notes.notecontent,vtiger_notes.filelocationtype,vtiger_notes.filestatus,vtiger_notes.filename,vtiger_notes.filesize,vtiger_notes.filetype,vtiger_notes.fileversion,vtiger_notes.filedownloadcount,vtiger_notes.notesid,vtiger_crmentity.cbuuid from vtiger_notes inner join vtiger_senotesrel on vtiger_senotesrel.notesid=vtiger_notes.notesid and vtiger_senotesrel.crmid IN (74,1084) left join vtiger_notescf ON vtiger_notescf.notesid=vtiger_notes.notesid inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_notes.notesid and vtiger_crmentity.deleted=0 inner join vtiger_crmobject crm2 on crm2.crmid=vtiger_senotesrel.crmid left join vtiger_groups on vtiger_groups.groupid=vtiger_crmentity.smownerid left join vtiger_seattachmentsrel on vtiger_seattachmentsrel.crmid=vtiger_notes.notesid left join vtiger_attachments on vtiger_seattachmentsrel.attachmentsid=vtiger_attachments.attachmentsid left join vtiger_users on vtiger_crmentity.smownerid=vtiger_users.id where ( crm2.crmid=1084 or crm2.crmid = 75 ) AND (filelocationtype LIKE '%I%') LIMIT 5 ", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select * from documents where (related.Contacts='12x1084' or crm2.crmid='11x75') AND (filelocationtype LIKE '%I%') LIMIT 5;", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_notes.title,vtiger_notes.folderid,vtiger_notes.note_no,vtiger_crmentity.smownerid as assigned_user_id,vtiger_crmentity.smownerid,vtiger_users.first_name as owner_firstname, vtiger_users.last_name as owner_lastname,vtiger_crmentity.createdtime,vtiger_crmentity.modifiedtime,vtiger_crmentity.modifiedby,vtiger_crmentity.smcreatorid as creator,vtiger_crmentity.smcreatorid,vtiger_users.first_name as creator_firstname, vtiger_users.last_name as creator_lastname,vtiger_notes.template,vtiger_notes.template_for,vtiger_notes.mergetemplate,vtiger_notes.notecontent,vtiger_notes.filelocationtype,vtiger_notes.filestatus,vtiger_notes.filename,vtiger_notes.filesize,vtiger_notes.filetype,vtiger_notes.fileversion,vtiger_notes.filedownloadcount,vtiger_notes.notesid,vtiger_crmentity.cbuuid from vtiger_notes inner join vtiger_senotesrel on vtiger_senotesrel.notesid=vtiger_notes.notesid and vtiger_senotesrel.crmid IN (74,1084) left join vtiger_notescf ON vtiger_notescf.notesid=vtiger_notes.notesid inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_notes.notesid and vtiger_crmentity.deleted=0 inner join vtiger_crmobject crm2 on crm2.crmid=vtiger_senotesrel.crmid left join vtiger_groups on vtiger_groups.groupid=vtiger_crmentity.smownerid left join vtiger_seattachmentsrel on vtiger_seattachmentsrel.crmid=vtiger_notes.notesid left join vtiger_attachments on vtiger_seattachmentsrel.attachmentsid=vtiger_attachments.attachmentsid left join vtiger_users on vtiger_crmentity.smownerid=vtiger_users.id where (crm2.crmid=1084 or crm2.crmid = 75 ) AND (filelocationtype LIKE '%I%') LIMIT 5 ", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select * from modcomments where related.helpdesk='17x2636';", $meta, $queryRelatedModules);
		$this->assertEquals("select concat(case when (ownertype = 'user') then '19x' else '12x' end,ownerid) as creator, concat(case when (ownertype = 'user') then '19x' else '12x' end,ownerid) as assigned_user_id, 'TicketComments' as setype, createdtime, createdtime as modifiedtime, 0 as id, comments as commentcontent, '17x2636' as related_to, '' as parent_comments, ownertype, case when (ownertype = 'user') then vtiger_users.user_name else vtiger_portalinfo.user_name end as owner_name, case when (ownertype = 'user') then vtiger_users.first_name else '' end as owner_firstname, case when (ownertype = 'user') then vtiger_users.last_name else '' end as owner_lastname, case when (ownertype = 'user') then vtiger_users.user_name else vtiger_portalinfo.user_name end as creator_name, case when (ownertype = 'user') then vtiger_users.first_name else '' end as creator_firstname, case when (ownertype = 'user') then vtiger_users.last_name else '' end as creator_lastname from vtiger_ticketcomments left join vtiger_users on vtiger_users.id = ownerid left join vtiger_portalinfo on vtiger_portalinfo.id = ownerid WHERE (vtiger_modcomments.related_to=74 or vtiger_modcomments.related_to=1084) and ticketid=2636", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select * from modcomments where related.accounts='11x74' and commentcontent like 'hdcc%';", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_modcomments.commentcontent,vtiger_crmentity.smownerid as assigned_user_id,vtiger_crmentity.smownerid,vtiger_users.first_name as owner_firstname, vtiger_users.last_name as owner_lastname,vtiger_modcomments.related_to,vtiger_crmentity.smcreatorid as creator,vtiger_crmentity.smcreatorid,vtiger_users.first_name as creator_firstname, vtiger_users.last_name as creator_lastname,vtiger_crmentity.createdtime,vtiger_crmentity.modifiedtime,vtiger_modcomments.parent_comments,vtiger_modcomments.relatedassignedemail,vtiger_modcomments.modcommentsid,vtiger_crmentity.cbuuid FROM vtiger_modcomments INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_modcomments.modcommentsid INNER JOIN vtiger_modcommentscf ON vtiger_modcommentscf.modcommentsid = vtiger_modcomments.modcommentsid LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid LEFT JOIN vtiger_account ON vtiger_account.accountid = vtiger_modcomments.related_to LEFT JOIN vtiger_contactdetails ON vtiger_contactdetails.contactid = vtiger_modcomments.related_to LEFT JOIN vtiger_leaddetails ON vtiger_leaddetails.leadid = vtiger_modcomments.related_to LEFT JOIN vtiger_potential ON vtiger_potential.potentialid = vtiger_modcomments.related_to LEFT JOIN vtiger_project ON vtiger_project.projectid = vtiger_modcomments.related_to LEFT JOIN vtiger_projecttask ON vtiger_projecttask.projecttaskid = vtiger_modcomments.related_to WHERE (vtiger_modcomments.related_to=74 or vtiger_modcomments.related_to=1084) and vtiger_crmentity.deleted=0 AND vtiger_modcomments.related_to=74 and vtiger_modcomments.commentcontent like 'hdcc%' ", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select * from modcomments;", $meta, $queryRelatedModules);
		$this->assertEquals("SELECT vtiger_modcomments.commentcontent,vtiger_crmentity.smownerid,vtiger_modcomments.related_to,vtiger_crmentity.smcreatorid,vtiger_crmentity.createdtime,vtiger_crmentity.modifiedtime,vtiger_modcomments.parent_comments,vtiger_modcomments.relatedassignedemail,vtiger_modcomments.modcommentsid FROM vtiger_modcomments LEFT JOIN vtiger_crmentity ON vtiger_modcomments.modcommentsid=vtiger_crmentity.crmid WHERE (vtiger_modcomments.related_to=74 or vtiger_modcomments.related_to=1084) and vtiger_crmentity.deleted=0 LIMIT 100;", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select productname from products where related.products='14x2616';", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_productcomponent.*,vtiger_productcomponentcf.*,vtiger_products.productname,vtiger_crmentity.cbuuid  FROM vtiger_productcomponent INNER JOIN vtiger_productcomponentcf ON vtiger_productcomponentcf.productcomponentid = vtiger_productcomponent.productcomponentid INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_productcomponent.productcomponentid INNER JOIN vtiger_products on vtiger_products.productid=vtiger_productcomponent.topdo INNER JOIN vtiger_crmentity cpdo ON cpdo.crmid = vtiger_products.productid LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid WHERE vtiger_crmentity.deleted = 0 AND cpdo.deleted = 0 AND vtiger_productcomponent.frompdo = 2616", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select productname from products where related.contacts='12x1084';", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_products.productname,vtiger_crmentity.cbuuid FROM vtiger_products INNER JOIN vtiger_seproductsrel ON vtiger_seproductsrel.productid=vtiger_products.productid and vtiger_seproductsrel.setype=\"Contacts\" INNER JOIN vtiger_productcf ON vtiger_products.productid = vtiger_productcf.productid INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_products.productid INNER JOIN vtiger_contactdetails ON vtiger_contactdetails.contactid = vtiger_seproductsrel.crmid LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid left join vtiger_producttaxrel on vtiger_producttaxrel.productid = vtiger_products.productid WHERE vtiger_contactdetails.contactid = 1084 and vtiger_crmentity.deleted = 0", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select productname from products where related.contacts='12x1084' and productcategory='Software';", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_products.productname,vtiger_crmentity.cbuuid FROM vtiger_products INNER JOIN vtiger_seproductsrel ON vtiger_seproductsrel.productid=vtiger_products.productid and vtiger_seproductsrel.setype=\"Contacts\" INNER JOIN vtiger_productcf ON vtiger_products.productid = vtiger_productcf.productid INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_products.productid INNER JOIN vtiger_contactdetails ON vtiger_contactdetails.contactid = vtiger_seproductsrel.crmid LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid left join vtiger_producttaxrel on vtiger_producttaxrel.productid = vtiger_products.productid WHERE vtiger_contactdetails.contactid = 1084 and vtiger_crmentity.deleted = 0 and  productcategory='Software' ", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("Select productname from Products where related.Contacts='12x1084' LIMIT 5;", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_products.productname,vtiger_crmentity.cbuuid FROM vtiger_products INNER JOIN vtiger_seproductsrel ON vtiger_seproductsrel.productid=vtiger_products.productid and vtiger_seproductsrel.setype=\"Contacts\" INNER JOIN vtiger_productcf ON vtiger_products.productid = vtiger_productcf.productid INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_products.productid INNER JOIN vtiger_contactdetails ON vtiger_contactdetails.contactid = vtiger_seproductsrel.crmid LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid left join vtiger_producttaxrel on vtiger_producttaxrel.productid = vtiger_products.productid WHERE vtiger_contactdetails.contactid = 1084 and vtiger_crmentity.deleted = 0 LIMIT 5 ", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("Select productname from Products where related.Contacts='12x1084' order by productname LIMIT 5;", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_products.productname,vtiger_crmentity.cbuuid FROM vtiger_products INNER JOIN vtiger_seproductsrel ON vtiger_seproductsrel.productid=vtiger_products.productid and vtiger_seproductsrel.setype=\"Contacts\" INNER JOIN vtiger_productcf ON vtiger_products.productid = vtiger_productcf.productid INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_products.productid INNER JOIN vtiger_contactdetails ON vtiger_contactdetails.contactid = vtiger_seproductsrel.crmid LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid left join vtiger_producttaxrel on vtiger_producttaxrel.productid = vtiger_products.productid WHERE vtiger_contactdetails.contactid = 1084 and vtiger_crmentity.deleted = 0 order by vtiger_products.productname LIMIT 5 ", $actual);

		$actual = self::$vtModuleOperation->wsVTQL2SQL("select Contacts.firstname,Salesorder.subject,amount,paid from cobropago where Contacts.homephone='902886938';", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_contactdetailsparent_id.firstname as contactsfirstname, vtiger_salesorderrelated_id.subject as salesordersubject, vtiger_cobropago.amount, vtiger_cobropago.paid, vtiger_cobropago.cobropagoid FROM vtiger_cobropago INNER JOIN vtiger_crmentity ON vtiger_cobropago.cobropagoid = vtiger_crmentity.crmid LEFT JOIN vtiger_contactsubdetails AS vtiger_contactsubdetailsparent_id ON vtiger_contactsubdetailsparent_id.contactsubscriptionid=vtiger_cobropago.parent_id LEFT JOIN vtiger_contactdetails AS vtiger_contactdetailsparent_id ON vtiger_contactdetailsparent_id.contactid=vtiger_cobropago.parent_id LEFT JOIN vtiger_salesorder AS vtiger_salesorderrelated_id ON vtiger_salesorderrelated_id.salesorderid=vtiger_cobropago.related_id WHERE (vtiger_cobropago.parent_id=74 or vtiger_cobropago.parent_id=1084) and vtiger_crmentity.deleted=0 AND ((vtiger_contactsubdetailsparent_id.homephone = '902886938') ) AND vtiger_cobropago.cobropagoid > 0 ", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select Products.productname,ticket_title from HelpDesk where Products.productname >= 'áé íÑÇ';", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_productsproduct_id.productname as productsproductname, vtiger_troubletickets.title, vtiger_troubletickets.ticketid FROM vtiger_troubletickets INNER JOIN vtiger_crmentity ON vtiger_troubletickets.ticketid = vtiger_crmentity.crmid LEFT JOIN vtiger_products AS vtiger_productsproduct_id ON vtiger_productsproduct_id.productid=vtiger_troubletickets.product_id WHERE (vtiger_troubletickets.parent_id=74 or vtiger_troubletickets.parent_id=1084) and vtiger_crmentity.deleted=0 AND ((vtiger_productsproduct_id.productname >= 'áé íÑÇ') ) AND vtiger_troubletickets.ticketid > 0 ", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select Products.productname,ticket_title from HelpDesk where Products.productname > = 'áé íÑÇ';", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_productsproduct_id.productname as productsproductname, vtiger_troubletickets.title, vtiger_troubletickets.ticketid FROM vtiger_troubletickets INNER JOIN vtiger_crmentity ON vtiger_troubletickets.ticketid = vtiger_crmentity.crmid LEFT JOIN vtiger_products AS vtiger_productsproduct_id ON vtiger_productsproduct_id.productid=vtiger_troubletickets.product_id WHERE (vtiger_troubletickets.parent_id=74 or vtiger_troubletickets.parent_id=1084) and vtiger_crmentity.deleted=0 AND ((vtiger_productsproduct_id.productname >= 'áé íÑÇ') ) AND vtiger_troubletickets.ticketid > 0 ", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select Products.productname,ticket_title from HelpDesk where Products.productname > = 'áé> =íÑÇ';", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_productsproduct_id.productname as productsproductname, vtiger_troubletickets.title, vtiger_troubletickets.ticketid FROM vtiger_troubletickets INNER JOIN vtiger_crmentity ON vtiger_troubletickets.ticketid = vtiger_crmentity.crmid LEFT JOIN vtiger_products AS vtiger_productsproduct_id ON vtiger_productsproduct_id.productid=vtiger_troubletickets.product_id WHERE (vtiger_troubletickets.parent_id=74 or vtiger_troubletickets.parent_id=1084) and vtiger_crmentity.deleted=0 AND ((vtiger_productsproduct_id.productname >= 'áé> =íÑÇ') ) AND vtiger_troubletickets.ticketid > 0 ", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select Products.productname,ticket_title from HelpDesk where Products.productname   >   =   'áé     íÑÇ';", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_productsproduct_id.productname as productsproductname, vtiger_troubletickets.title, vtiger_troubletickets.ticketid FROM vtiger_troubletickets INNER JOIN vtiger_crmentity ON vtiger_troubletickets.ticketid = vtiger_crmentity.crmid LEFT JOIN vtiger_products AS vtiger_productsproduct_id ON vtiger_productsproduct_id.productid=vtiger_troubletickets.product_id WHERE (vtiger_troubletickets.parent_id=74 or vtiger_troubletickets.parent_id=1084) and vtiger_crmentity.deleted=0 AND ((vtiger_productsproduct_id.productname >= 'áé íÑÇ') ) AND vtiger_troubletickets.ticketid > 0 ", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select Products.productname,ticket_title from HelpDesk where Products.productname   >   =   'áé>    =íÑÇ';", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_productsproduct_id.productname as productsproductname, vtiger_troubletickets.title, vtiger_troubletickets.ticketid FROM vtiger_troubletickets INNER JOIN vtiger_crmentity ON vtiger_troubletickets.ticketid = vtiger_crmentity.crmid LEFT JOIN vtiger_products AS vtiger_productsproduct_id ON vtiger_productsproduct_id.productid=vtiger_troubletickets.product_id WHERE (vtiger_troubletickets.parent_id=74 or vtiger_troubletickets.parent_id=1084) and vtiger_crmentity.deleted=0 AND ((vtiger_productsproduct_id.productname >= 'áé> =íÑÇ') ) AND vtiger_troubletickets.ticketid > 0 ", $actual);

		$actual = self::$vtModuleOperation->wsVTQL2SQL("select potentialname from Potentials where related_to='11x75';", $meta, $queryRelatedModules);
		$this->assertEquals("SELECT vtiger_potential.potentialname,vtiger_potential.potentialid FROM vtiger_potential LEFT JOIN vtiger_crmentity ON vtiger_potential.potentialid=vtiger_crmentity.crmid WHERE (vtiger_potential.related_to=74 or vtiger_potential.related_to=1084) and (vtiger_potential.related_to = 75) AND vtiger_crmentity.deleted=0 LIMIT 100;", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select potentialname,Campaigns.campaignname from Potentials where related_to='Chemex Labs Ltd';", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_potential.potentialname, vtiger_campaigncampaignid.campaignname as campaignscampaignname, vtiger_potential.potentialid FROM vtiger_potential INNER JOIN vtiger_crmentity ON vtiger_potential.potentialid = vtiger_crmentity.crmid LEFT JOIN vtiger_account ON vtiger_potential.related_to = vtiger_account.accountid LEFT JOIN vtiger_contactdetails ON vtiger_potential.related_to = vtiger_contactdetails.contactid LEFT JOIN vtiger_campaign AS vtiger_campaigncampaignid ON vtiger_campaigncampaignid.campaignid=vtiger_potential.campaignid WHERE (vtiger_potential.related_to=74 or vtiger_potential.related_to=1084) and vtiger_crmentity.deleted=0 AND (( trim(vtiger_account.accountname) = 'Chemex Labs Ltd' OR trim(CONCAT(vtiger_contactdetails.firstname,' ',vtiger_contactdetails.lastname)) = 'Chemex Labs Ltd') ) AND vtiger_potential.potentialid > 0 ", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select potentialname,Campaigns.campaignname from Potentials where Accounts.id='11x75';", $meta, $queryRelatedModules);
		$this->assertEquals("select vtiger_potential.potentialname, vtiger_campaigncampaignid.campaignname as campaignscampaignname, vtiger_potential.potentialid FROM vtiger_potential INNER JOIN vtiger_crmentity ON vtiger_potential.potentialid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountrelated_to ON vtiger_accountrelated_to.accountid=vtiger_potential.related_to LEFT JOIN vtiger_campaign AS vtiger_campaigncampaignid ON vtiger_campaigncampaignid.campaignid=vtiger_potential.campaignid WHERE (vtiger_potential.related_to=74 or vtiger_potential.related_to=1084) and vtiger_crmentity.deleted=0 AND ((vtiger_accountrelated_to.accountid = '75') ) AND vtiger_potential.potentialid > 0 ", $actual);

		$GetRelatedList_ReturnOnlyQuery = false;
	}

	public function testExtendedConditionQuery() {
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select id, account_no, accountname, Accounts.accountname from accounts where [{"fieldname":"assigned_user_id","operation":"is","value":"cbTest testtz","valuetype":"raw","joincondition":"and","groupid":"0"}]', $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT vtiger_account.accountid, vtiger_account.account_no, vtiger_account.accountname, vtiger_accountaccount_id.accountname as accountsaccountname FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_account.parentid WHERE (vtiger_account.accountid=74) and vtiger_crmentity.deleted=0 AND ( (( (trim(vtiger_users.ename) = 'cbTest testtz' or vtiger_groups.groupname = 'cbTest testtz')) )) AND vtiger_account.accountid > 0",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select firstname from Leads where [{"fieldname":"firstname","operation":"greater than","value":"uppercase(lastname)","valuetype":"expression","joincondition":"and","groupid":"0"}];', $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT vtiger_leaddetails.leadid, vtiger_leaddetails.firstname FROM vtiger_leaddetails  INNER JOIN vtiger_crmentity ON vtiger_leaddetails.leadid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 and vtiger_leaddetails.converted=0 AND   (  (( vtiger_leaddetails.firstname > UPPER(vtiger_leaddetails.lastname)) )) AND vtiger_leaddetails.leadid > 0",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select id, account_no, accountname, Accounts.accountname from accounts where [{"fieldname":"assigned_user_id","operation":"is","value":"cbTest testtz","valuetype":"raw","joincondition":"and","groupid":"0"}] order by account_no', $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT vtiger_account.accountid, vtiger_account.account_no, vtiger_account.accountname, vtiger_accountaccount_id.accountname as accountsaccountname FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_account.parentid WHERE (vtiger_account.accountid=74) and vtiger_crmentity.deleted=0 AND ( (( (trim(vtiger_users.ename) = 'cbTest testtz' or vtiger_groups.groupname = 'cbTest testtz')) )) AND vtiger_account.accountid > 0 order by vtiger_account.account_no",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select id, account_no, accountname, Accounts.accountname from accounts where [{"fieldname":"assigned_user_id","operation":"is","value":"cbTest testtz","valuetype":"raw","joincondition":"and","groupid":"0"}] order by account_no desc limit 5', $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT vtiger_account.accountid, vtiger_account.account_no, vtiger_account.accountname, vtiger_accountaccount_id.accountname as accountsaccountname FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_account.parentid WHERE (vtiger_account.accountid=74) and vtiger_crmentity.deleted=0 AND ( (( (trim(vtiger_users.ename) = 'cbTest testtz' or vtiger_groups.groupname = 'cbTest testtz')) )) AND vtiger_account.accountid > 0 order by vtiger_account.account_no desc limit 5",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select id, account_no, accountname, Accounts.accountname from accounts where [{"fieldname":"assigned_user_id","operation":"is","value":"cbTest testtz","valuetype":"raw","joincondition":"and","groupid":"0"}] limit 5', $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT vtiger_account.accountid, vtiger_account.account_no, vtiger_account.accountname, vtiger_accountaccount_id.accountname as accountsaccountname FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_account.parentid WHERE (vtiger_account.accountid=74) and vtiger_crmentity.deleted=0 AND ( (( (trim(vtiger_users.ename) = 'cbTest testtz' or vtiger_groups.groupname = 'cbTest testtz')) )) AND vtiger_account.accountid > 0 limit 5",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select [{"fieldname":"countres","operation":"is","value":"count(accountname)","valuetype":"expression","joincondition":"and","groupid":"0"}] from accounts where [{"fieldname":"assigned_user_id","operation":"is","value":"cbTest testtz","valuetype":"raw","joincondition":"and","groupid":"0"}] limit 5', $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT COUNT(vtiger_account.accountname) AS countres FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid WHERE (vtiger_account.accountid=74) and vtiger_crmentity.deleted=0 AND ( (( (trim(vtiger_users.ename) = 'cbTest testtz' or vtiger_groups.groupname = 'cbTest testtz')) )) AND vtiger_account.accountid > 0 limit 5",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select [{"fieldname":"countres","operation":"is","value":"count(accountname)","valuetype":"expression","joincondition":"and","groupid":"0"}] from accounts', $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT COUNT(vtiger_account.accountname) AS countres FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid WHERE (vtiger_account.accountid=74) and vtiger_crmentity.deleted=0 AND vtiger_account.accountid > 0",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select [{"fieldname":"countres","operation":"is","value":"count(accountname)","valuetype":"expression","joincondition":"and","groupid":"0"}] from accounts order by 1', $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT COUNT(vtiger_account.accountname) AS countres FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid WHERE (vtiger_account.accountid=74) and vtiger_crmentity.deleted=0 AND vtiger_account.accountid > 0 order by 1",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('SELECT [{"fieldname":"countres","operation":"is","value":"count(ticket_title)","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"ticketstatus","operation":"is","value":"ticketstatus","valuetype":"fieldname","joincondition":"and","groupid":"0"}] FROM HelpDesk WHERE [{"fieldname":"parent_id","operation":"is","value":"74","valuetype":"raw","joincondition":"and","groupid":"0"}] GROUP BY status;', $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT COUNT(vtiger_troubletickets.title) AS countres,vtiger_troubletickets.status FROM vtiger_troubletickets INNER JOIN vtiger_crmentity ON vtiger_troubletickets.ticketid = vtiger_crmentity.crmid LEFT JOIN vtiger_account ON vtiger_troubletickets.parent_id = vtiger_account.accountid LEFT JOIN vtiger_contactdetails ON vtiger_troubletickets.parent_id = vtiger_contactdetails.contactid WHERE (vtiger_troubletickets.parent_id=74 or vtiger_troubletickets.parent_id=1084) and vtiger_crmentity.deleted=0 AND ( (( trim(vtiger_account.accountname) = '74' OR trim(CONCAT(vtiger_contactdetails.firstname,' ',vtiger_contactdetails.lastname)) = '74') )) AND vtiger_troubletickets.ticketid > 0 group by status;",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('SELECT [{"fieldname":"countres","operation":"is","value":"count(ticket_title)","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"ticketstatus","operation":"is","value":"ticketstatus","valuetype":"fieldname","joincondition":"and","groupid":"0"}] FROM HelpDesk WHERE [{"fieldname":"$(parent_id : (Accounts) account_no)","operation":"is","value":"ACC1","valuetype":"raw","joincondition":"and","groupid":"0"}] GROUP BY status;', $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT COUNT(vtiger_troubletickets.title) AS countres,vtiger_troubletickets.status FROM vtiger_troubletickets INNER JOIN vtiger_crmentity ON vtiger_troubletickets.ticketid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountparent_id ON vtiger_accountparent_id.accountid=vtiger_troubletickets.parent_id WHERE (vtiger_troubletickets.parent_id=74 or vtiger_troubletickets.parent_id=1084) and vtiger_crmentity.deleted=0 AND ( ((vtiger_accountparent_id.account_no = 'ACC1') )) AND vtiger_troubletickets.ticketid > 0 group by status;",
			$actual
		);
	}

	public function testOrderByLimit() {
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select firstname from contacts order by firstname;', $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT vtiger_contactdetails.firstname,vtiger_contactdetails.contactid FROM vtiger_contactdetails LEFT JOIN vtiger_crmentity ON vtiger_contactdetails.contactid=vtiger_crmentity.crmid WHERE ((vtiger_contactdetails.accountid=74 or vtiger_contactdetails.contactid=1084)) and vtiger_crmentity.deleted=0 ORDER BY vtiger_contactdetails.firstname LIMIT 100;",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select firstname from contacts order by contact_no;', $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT vtiger_contactdetails.firstname,vtiger_contactdetails.contactid FROM vtiger_contactdetails LEFT JOIN vtiger_crmentity ON vtiger_contactdetails.contactid=vtiger_crmentity.crmid WHERE ((vtiger_contactdetails.accountid=74 or vtiger_contactdetails.contactid=1084)) and vtiger_crmentity.deleted=0 ORDER BY vtiger_contactdetails.contact_no LIMIT 100;",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select firstname from contacts order by account_id;', $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT vtiger_contactdetails.firstname,vtiger_contactdetails.contactid FROM vtiger_contactdetails LEFT JOIN vtiger_crmentity ON vtiger_contactdetails.contactid=vtiger_crmentity.crmid WHERE ((vtiger_contactdetails.accountid=74 or vtiger_contactdetails.contactid=1084)) and vtiger_crmentity.deleted=0 ORDER BY vtiger_contactdetails.accountid LIMIT 100;",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select firstname from contacts order by accountname;', $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT vtiger_contactdetails.firstname,vtiger_contactdetails.contactid FROM vtiger_contactdetails LEFT JOIN vtiger_crmentity ON vtiger_contactdetails.contactid=vtiger_crmentity.crmid WHERE ((vtiger_contactdetails.accountid=74 or vtiger_contactdetails.contactid=1084)) and vtiger_crmentity.deleted=0 LIMIT 100;",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select firstname from contacts order by Accounts.accountname;', $meta, $queryRelatedModules);
		$this->assertEquals(
			"select vtiger_contactdetails.firstname, vtiger_contactdetails.contactid FROM vtiger_contactdetails INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_contactdetails.accountid WHERE ((vtiger_contactdetails.accountid=74 or vtiger_contactdetails.contactid=1084)) and vtiger_crmentity.deleted=0 AND vtiger_contactdetails.contactid > 0 order by vtiger_accountaccount_id.accountname ASC",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select firstname from contacts order by Users.first_name;', $meta, $queryRelatedModules);
		$this->assertEquals(
			"select vtiger_contactdetails.firstname, vtiger_contactdetails.contactid FROM vtiger_contactdetails INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid WHERE ((vtiger_contactdetails.accountid=74 or vtiger_contactdetails.contactid=1084)) and vtiger_crmentity.deleted=0 AND vtiger_contactdetails.contactid > 0 order by vtiger_users.first_name ASC",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select accountname from Accounts where Accounts.accountname='Chemex' order by cf_722;", $meta, $queryRelatedModules);
		$this->assertEquals(
			"select vtiger_account.accountname, vtiger_account.accountid FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid INNER JOIN vtiger_accountscf ON vtiger_account.accountid = vtiger_accountscf.accountid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_account.parentid WHERE (vtiger_account.accountid=74) and vtiger_crmentity.deleted=0 AND ((vtiger_accountaccount_id.accountname = 'Chemex') ) AND vtiger_account.accountid > 0 order by vtiger_accountscf.cf_722 ASC",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select accountname from Accounts order by cf_722;", $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT vtiger_account.accountname,vtiger_account.accountid FROM vtiger_account LEFT JOIN vtiger_accountscf ON vtiger_account.accountid=vtiger_accountscf.accountid LEFT JOIN vtiger_crmentity ON vtiger_account.accountid=vtiger_crmentity.crmid WHERE (vtiger_account.accountid=74) and vtiger_crmentity.deleted=0 ORDER BY vtiger_accountscf.cf_722 LIMIT 100;",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL("select accountname from Accounts order by id;", $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT vtiger_account.accountname,vtiger_account.accountid FROM vtiger_account LEFT JOIN vtiger_crmentity ON vtiger_account.accountid=vtiger_crmentity.crmid WHERE (vtiger_account.accountid=74) and vtiger_crmentity.deleted=0 ORDER BY vtiger_account.accountid LIMIT 100;",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select accountname from Accounts where [{"fieldname":"accountname","operation":"contains","value":"a","valuetype":"raw","joincondition":"and","groupid":"1425054943","groupjoin":""},{"fieldname":"employees","operation":"less than","value":"50","valuetype":"raw","joincondition":"or","groupid":"1425054943","groupjoin":""},{"fieldname":"accountname","operation":"does not contain","value":"a","valuetype":"raw","joincondition":"and","groupid":"21953977466","groupjoin":"or"},{"fieldname":"employees","operation":"greater than","value":"40","valuetype":"raw","joincondition":"","groupid":"21953977466","groupjoin":"or"}] order by employees ASC limit 0,25;', $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT vtiger_account.accountid, vtiger_account.accountname FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid WHERE (vtiger_account.accountid=74) and vtiger_crmentity.deleted=0 AND ( (( vtiger_account.accountname LIKE '%a%') and ( vtiger_account.employees < 50) ) or (( vtiger_account.accountname NOT LIKE '%a%') and ( vtiger_account.employees > 40) )) AND vtiger_account.accountid > 0 order by vtiger_account.employees asc limit 0,25;",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select accountname from Accounts where [{"fieldname":"accountname","operation":"contains","value":"a","valuetype":"raw","joincondition":"and","groupid":"1425054943","groupjoin":""},{"fieldname":"employees","operation":"less than","value":"50","valuetype":"raw","joincondition":"or","groupid":"1425054943","groupjoin":""},{"fieldname":"accountname","operation":"does not contain","value":"a","valuetype":"raw","joincondition":"and","groupid":"21953977466","groupjoin":"or"},{"fieldname":"employees","operation":"greater than","value":"40","valuetype":"raw","joincondition":"","groupid":"21953977466","groupjoin":"or"}] order by id ASC limit 0,25;', $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT vtiger_account.accountid, vtiger_account.accountname FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid WHERE (vtiger_account.accountid=74) and vtiger_crmentity.deleted=0 AND ( (( vtiger_account.accountname LIKE '%a%') and ( vtiger_account.employees < 50) ) or (( vtiger_account.accountname NOT LIKE '%a%') and ( vtiger_account.employees > 40) )) AND vtiger_account.accountid > 0 order by vtiger_account.accountid asc limit 0,25;",
			$actual
		);
	}

	public function testExtendedConditionGroupByQuery() {
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select accountname from accounts where [{"fieldname":"assigned_user_id","operation":"is","value":"cbTest testtz","valuetype":"raw","joincondition":"and","groupid":"0"}] group by accountname', $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT vtiger_account.accountname FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid WHERE (vtiger_account.accountid=74) and vtiger_crmentity.deleted=0 AND ( (( (trim(vtiger_users.ename) = 'cbTest testtz' or vtiger_groups.groupname = 'cbTest testtz')) )) AND vtiger_account.accountid > 0 group by accountname",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select [{"fieldname":"countres","operation":"is","value":"count(accountname)","valuetype":"expression","joincondition":"and","groupid":"0"}] from accounts group by 1;', $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT COUNT(vtiger_account.accountname) AS countres FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid WHERE (vtiger_account.accountid=74) and vtiger_crmentity.deleted=0 AND vtiger_account.accountid > 0 group by 1;",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select [{"fieldname":"countres","operation":"is","value":"count(accountname)","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"bill_city","operation":"is","value":"bill_city","valuetype":"fieldname","joincondition":"and","groupid":"0"}] from accounts group by bill_city;', $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT COUNT(vtiger_account.accountname) AS countres,vtiger_accountbillads.bill_city FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid INNER JOIN vtiger_accountbillads ON vtiger_account.accountid = vtiger_accountbillads.accountaddressid WHERE (vtiger_account.accountid=74) and vtiger_crmentity.deleted=0 AND vtiger_account.accountid > 0 group by bill_city;",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select [{"fieldname":"countres","operation":"is","value":"count(accountname)","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"bill_city","operation":"is","value":"bill_city","valuetype":"fieldname","joincondition":"and","groupid":"0"}] from accounts where [{"fieldname":"accountname","operation":"starts with","value":"a","valuetype":"raw","joincondition":"and","groupid":"0"}] group by bill_city;', $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT COUNT(vtiger_account.accountname) AS countres,vtiger_accountbillads.bill_city FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid INNER JOIN vtiger_accountbillads ON vtiger_account.accountid = vtiger_accountbillads.accountaddressid WHERE (vtiger_account.accountid=74) and vtiger_crmentity.deleted=0 AND ( (( vtiger_account.accountname LIKE 'a%') )) AND vtiger_account.accountid > 0 group by bill_city;",
			$actual
		);
		/////
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select [{"fieldname":"countres","operation":"is","value":"count(ticket_title)","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"ticketstatus","operation":"is","value":"ticketstatus","valuetype":"fieldname","joincondition":"and","groupid":"0"}] from HelpDesk group by status;', $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT COUNT(vtiger_troubletickets.title) AS countres,vtiger_troubletickets.status FROM vtiger_troubletickets INNER JOIN vtiger_crmentity ON vtiger_troubletickets.ticketid = vtiger_crmentity.crmid WHERE (vtiger_troubletickets.parent_id=74 or vtiger_troubletickets.parent_id=1084) and vtiger_crmentity.deleted=0 AND vtiger_troubletickets.ticketid > 0 group by status;",
			$actual
		);
		global $current_user, $adb, $log;
		$holdUser = $current_user;
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile(7); // testymd HelpDesk is private
		$webserviceObject = VtigerWebserviceObject::fromName($adb, 'HelpDesk');
		$vtModuleOperation = new VtigerModuleOperation($webserviceObject, $current_user, $adb, $log);
		$actual = $vtModuleOperation->wsVTQL2SQL('select [{"fieldname":"countres","operation":"is","value":"count(ticket_title)","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"ticketstatus","operation":"is","value":"ticketstatus","valuetype":"fieldname","joincondition":"and","groupid":"0"}] from HelpDesk group by status;', $meta, $queryRelatedModules);
		$current_user = $holdUser;
		$this->assertEquals(
			"SELECT COUNT(vtiger_troubletickets.title) AS countres,vtiger_troubletickets.status FROM vtiger_troubletickets INNER JOIN vtiger_crmentity ON vtiger_troubletickets.ticketid = vtiger_crmentity.crmid INNER JOIN vt_tmp_u7 vt_tmp_u7 ON vt_tmp_u7.id = vtiger_crmentity.smownerid WHERE (vtiger_troubletickets.parent_id=74 or vtiger_troubletickets.parent_id=1084) and vtiger_crmentity.deleted=0 AND vtiger_troubletickets.ticketid > 0 group by status;",
			$actual
		);
	}

	public function testActorQuery() {
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select * from Currency;', $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT vtiger_currency_info.id,vtiger_currency_info.currency_name,vtiger_currency_info.currency_code,vtiger_currency_info.currency_symbol,vtiger_currency_info.conversion_rate,vtiger_currency_info.currency_status,vtiger_currency_info.defaultid,vtiger_currency_info.deleted,vtiger_currency_info.currency_position FROM vtiger_currency_info  WHERE  vtiger_currency_info.deleted=0 LIMIT 100;",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select * from Workflow;', $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT com_vtiger_workflows.workflow_id,com_vtiger_workflows.module_name,com_vtiger_workflows.summary,com_vtiger_workflows.test,com_vtiger_workflows.execution_condition,com_vtiger_workflows.defaultworkflow,com_vtiger_workflows.type,com_vtiger_workflows.schtypeid,com_vtiger_workflows.schtime,com_vtiger_workflows.schdayofmonth,com_vtiger_workflows.schdayofweek,com_vtiger_workflows.schannualdates,com_vtiger_workflows.nexttrigger_time,com_vtiger_workflows.schminuteinterval,com_vtiger_workflows.purpose,com_vtiger_workflows.relatemodule,com_vtiger_workflows.wfstarton,com_vtiger_workflows.wfendon,com_vtiger_workflows.active,com_vtiger_workflows.options,com_vtiger_workflows.cbquestion,com_vtiger_workflows.recordset,com_vtiger_workflows.onerecord,com_vtiger_workflows.multipleschtime,com_vtiger_workflows.workflow_id FROM com_vtiger_workflows   LIMIT 100;",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select * from AuditTrail;', $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT vtiger_audit_trial.auditid,vtiger_audit_trial.userid,vtiger_audit_trial.module,vtiger_audit_trial.action,vtiger_audit_trial.recordid,vtiger_audit_trial.actiondate,vtiger_audit_trial.auditid FROM vtiger_audit_trial   LIMIT 100;",
			$actual
		);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select * from LoginHistory;', $meta, $queryRelatedModules);
		$this->assertEquals(
			"SELECT vtiger_loginhistory.login_id,vtiger_loginhistory.user_name,vtiger_loginhistory.user_ip,vtiger_loginhistory.logout_time,vtiger_loginhistory.login_time,vtiger_loginhistory.status,vtiger_loginhistory.login_id FROM vtiger_loginhistory   LIMIT 100;",
			$actual
		);
	}

	public function testDistinctEVTQL() {
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select distinct firstname, lastname from Leads where (true) order by firstname desc limit 0,2;', $meta, $queryRelatedModules);
		$this->assertEquals("select distinct vtiger_leaddetails.firstname, vtiger_leaddetails.lastname  FROM vtiger_leaddetails  INNER JOIN vtiger_crmentity ON vtiger_leaddetails.leadid = vtiger_crmentity.crmid   WHERE vtiger_crmentity.deleted=0 and vtiger_leaddetails.converted=0 AND vtiger_leaddetails.leadid > 0  order by vtiger_leaddetails.firstname DESC limit 0,2", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select distinct accountname from Accounts where (true);', $meta, $queryRelatedModules);
		$this->assertEquals("select distinct vtiger_account.accountname FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid WHERE (vtiger_account.accountid=74) and vtiger_crmentity.deleted=0 AND vtiger_account.accountid > 0 ", $actual);
		$actual = self::$vtModuleOperation->wsVTQL2SQL('select distinct account_id, Accounts.account_id from accounts;', $meta, $queryRelatedModules);
		$this->assertEquals("select distinct vtiger_account.parentid, vtiger_accountaccount_id.parentid as accountsparentid FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_account.parentid WHERE (vtiger_account.accountid=74) and vtiger_crmentity.deleted=0 AND vtiger_account.accountid > 0 ", $actual);
	}

	public function testDistinctVTQL() {
		$this->expectException('WebServiceException');
		self::$vtModuleOperation->wsVTQL2SQL('select distinct firstname, lastname from Leads;', $meta, $queryRelatedModules);
	}
}
?>
