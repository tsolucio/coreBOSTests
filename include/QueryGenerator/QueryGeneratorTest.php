<?php
/*************************************************************************************************
 * Copyright 2016 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

class QueryGeneratorTest extends PHPUnit_Framework_TestCase {

	public function testAccountId() {
		global $current_user;
		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id'));
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,'SELECT vtiger_account.accountid FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND vtiger_account.accountid > 0');
	}

	public function testQueryWithCustomField() {
		global $current_user,$adb;
		$cnacc=$adb->getColumnNames('vtiger_accountscf');
		if (empty($cnacc) or count($cnacc)<=1) {
			$this->markTestSkipped('no custom fields');
		} else {
			$cf = $cnacc[1];
			$queryGenerator = new QueryGenerator('Accounts', $current_user);
			$queryGenerator->setFields(array('id',$cf));
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,"SELECT vtiger_account.accountid, vtiger_accountscf.$cf FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid INNER JOIN vtiger_accountscf ON vtiger_account.accountid = vtiger_accountscf.accountid  WHERE vtiger_crmentity.deleted=0 AND vtiger_account.accountid > 0");
		}
	}

	public function testQueryWithInvalidField() {
		global $current_user;
		$cf = 'cf_91'; // there will never be a custom field with such a low number
		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id',$cf));
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,'SELECT vtiger_account.accountid FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND vtiger_account.accountid > 0');
	}

	public function testQueryIndividualParts() {
		global $current_user;
		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id','accountname'));
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,'SELECT vtiger_account.accountid, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND vtiger_account.accountid > 0');
		$this->assertEquals($queryGenerator->getSelectClauseColumnSQL(),'vtiger_account.accountid, vtiger_account.accountname');
		$this->assertEquals($queryGenerator->getFromClause(),' FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid ');
		$this->assertEquals($queryGenerator->getWhereClause(),' WHERE vtiger_crmentity.deleted=0 AND vtiger_account.accountid > 0');
	}

	public function testQueryConditions() {
		global $current_user;
		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id','website','accountname'));
		$queryGenerator->addCondition('website',array('www.edfggrouplimited.com','www.gooduivtiger.com'),'i');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_account.accountid, vtiger_account.website, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_account.website IN ('www.edfggrouplimited.com','www.gooduivtiger.com'))  AND vtiger_account.accountid > 0");

		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id','website','accountname'));
		$queryGenerator->addCondition('website',array('www.edfggrouplimited.com','www.gooduivtiger.com'),'ni');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_account.accountid, vtiger_account.website, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_account.website  NOT IN ('www.edfggrouplimited.com','www.gooduivtiger.com'))  AND vtiger_account.accountid > 0");

		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id','accountname'));
		$queryGenerator->addCondition('accountname','EDFG','c');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_account.accountid, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_account.accountname LIKE '%EDFG%')  AND vtiger_account.accountid > 0");

		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id','accountname'));
		$queryGenerator->addCondition('accountname','EDFG','c');
		$queryGenerator->addCondition('employees','4','g','or');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_account.accountid, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_account.accountname LIKE '%EDFG%')  or ( vtiger_account.employees > 4)  AND vtiger_account.accountid > 0");

		$queryGenerator = new QueryGenerator('Project', $current_user);
		$queryGenerator->setFields(array('id','projectname','startdate','targetenddate'));
		$queryGenerator->addCondition('startdate','2015-04-16','b');
		$queryGenerator->addCondition('targetenddate','2015-06-16','a','OR');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.startdate, vtiger_project.targetenddate FROM vtiger_project  INNER JOIN vtiger_crmentity ON vtiger_project.projectid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_project.startdate < '2015-04-16')  OR ( vtiger_project.targetenddate > '2015-06-16')  AND vtiger_project.projectid > 0");

		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id','accountname'));
		$queryGenerator->startGroup();  // parenthesis to enclose our OR condition between the two groups
		$queryGenerator->startGroup();  // start first group
		$queryGenerator->addCondition('accountname','EDFG','c');
		$queryGenerator->addCondition('employees','4','g','or');
		$queryGenerator->endGroup();  // end first group
		$queryGenerator->startGroup('or');  // start second group joining with OR glue
		$queryGenerator->addCondition('accountname','3m','c');
		$queryGenerator->addCondition('employees','4','l','or');
		$queryGenerator->endGroup();  // end second groupd
		$queryGenerator->endGroup();  // end enclosing parenthesis
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_account.accountid, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_account.accountname LIKE '%EDFG%')  or ( vtiger_account.employees > 4) ) or (( vtiger_account.accountname LIKE '%3m%')  or ( vtiger_account.employees < 4) )) AND vtiger_account.accountid > 0");

		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id','accountname'));
		$queryGenerator->addCondition('employees','','y');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_account.accountid, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_account.employees IS NULL OR vtiger_account.employees = '')  AND vtiger_account.accountid > 0");

		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id','accountname'));
		$queryGenerator->addCondition('employees','','ny');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_account.accountid, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_account.employees IS NOT NULL AND vtiger_account.employees != '')  AND vtiger_account.accountid > 0");

		$queryGenerator = new QueryGenerator('SalesOrder', $current_user);
		$queryGenerator->setFields(array('id','subject'));
		$queryGenerator->addCondition('duedate', array(0=>'2006-01-01',1=>'2016-01-01'), 'bw',$queryGenerator::$AND);
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_salesorder.salesorderid, vtiger_salesorder.subject FROM vtiger_salesorder  INNER JOIN vtiger_crmentity ON vtiger_salesorder.salesorderid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_salesorder.duedate BETWEEN '2006-01-01' AND '2016-01-01')  AND vtiger_salesorder.salesorderid > 0");
	}

	public function testQueryRelatedConditions() {
		global $current_user;
		$queryGenerator = new QueryGenerator('Contacts', $current_user);
		$queryGenerator->setFields(array('id','firstname'));
		$queryGenerator->addReferenceModuleFieldCondition('Accounts', 'account_id', 'accountname', 'EDFG', 'c');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_contactdetails.contactid, vtiger_contactdetails.firstname FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_contactdetails.accountid  WHERE vtiger_crmentity.deleted=0 AND (vtiger_accountaccount_id.accountname LIKE '%EDFG%')  AND vtiger_contactdetails.contactid > 0");

		$queryGenerator = new QueryGenerator('Contacts', $current_user);
		$queryGenerator->setFields(array('id','firstname','Accounts.accountname','Accounts.id'));
		$queryGenerator->addReferenceModuleFieldCondition('Accounts', 'account_id', 'id', '1047', 'e');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_contactdetails.contactid, vtiger_contactdetails.firstname, vtiger_accountaccount_id.accountname as accountsaccountname FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_contactdetails.accountid  WHERE vtiger_crmentity.deleted=0 AND (vtiger_accountaccount_id.accountid = '1047')  AND vtiger_contactdetails.contactid > 0");

		$queryGenerator = new QueryGenerator('Contacts', $current_user);
		$queryGenerator->setFields(array('id','firstname','Accounts.phone'));
		$queryGenerator->addReferenceModuleFieldCondition('Accounts', 'account_id', 'phone', '841', 'c');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_contactdetails.contactid, vtiger_contactdetails.firstname, vtiger_accountaccount_id.phone as accountsphone FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_contactdetails.accountid  WHERE vtiger_crmentity.deleted=0 AND (vtiger_accountaccount_id.phone LIKE '%841%')  AND vtiger_contactdetails.contactid > 0");

		$queryGenerator = new QueryGenerator('Contacts', $current_user);
		$queryGenerator->setFields(array('id','firstname','Accounts.phone'));
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_contactdetails.contactid, vtiger_contactdetails.firstname, vtiger_accountaccount_id.phone as accountsphone FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_contactdetails.accountid  WHERE vtiger_crmentity.deleted=0 AND vtiger_contactdetails.contactid > 0");

		$queryGenerator = new QueryGenerator("Contacts", $current_user);
		$queryGenerator->setFields(array('id','accountname','Accounts.assigned_user_id'));
		$queryGenerator->addReferenceModuleFieldCondition('Accounts', 'account_id', 'accountname', 'EDFG Group Limited', 'exists');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_contactdetails.contactid, vtiger_accountaccount_id.accountname as accountsaccountname, vtiger_crmentityaccount_id.smownerid as smowneraccounts FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_contactdetails.accountid LEFT JOIN vtiger_crmentity AS vtiger_crmentityaccount_id ON vtiger_crmentityaccount_id.crmid=vtiger_contactdetails.accountid  WHERE vtiger_crmentity.deleted=0 AND (SELECT EXISTS(SELECT 1  FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_account.accountname = 'EDFG Group Limited')  AND vtiger_account.accountid > 0))  AND vtiger_contactdetails.contactid > 0");

		$queryGenerator = new QueryGenerator("Invoice", $current_user);
		$queryGenerator->setFields(array('id','subject','Accounts.assigned_user_id','SalesOrder.subject','SalesOrder.account_id'));
		//$queryGenerator->addReferenceModuleFieldCondition('Accounts', 'account_id', 'accountname', 'EDFG Group Limited', 'exists');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_invoice.invoiceid, vtiger_invoice.subject, vtiger_crmentityaccount_id.smownerid as smowneraccounts, vtiger_salesordersalesorder_id.subject as salesordersubject, vtiger_salesordersalesorder_id.accountid as salesorderaccountid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid LEFT JOIN vtiger_crmentity AS vtiger_crmentityaccount_id ON vtiger_crmentityaccount_id.crmid=vtiger_invoice.accountid LEFT JOIN vtiger_salesorder AS vtiger_salesordersalesorder_id ON vtiger_salesordersalesorder_id.salesorderid=vtiger_invoice.salesorderid  WHERE vtiger_crmentity.deleted=0 AND vtiger_invoice.invoiceid > 0");

		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id','accountname','website','Accounts.accountname','Accounts.website'));
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_account.accountid, vtiger_account.accountname, vtiger_account.website, vtiger_accountaccount_id.accountname as accountsaccountname, vtiger_accountaccount_id.website as accountswebsite FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_account.parentid  WHERE vtiger_crmentity.deleted=0 AND vtiger_account.accountid > 0");

		$queryGenerator = new QueryGenerator('Contacts', $current_user);
		$queryGenerator->setFields(array('id','firstname','lastname','Contacts.firstname','Contacts.lastname'));
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_contactdetails.contactid, vtiger_contactdetails.firstname, vtiger_contactdetails.lastname, vtiger_contactdetailscontact_id.firstname as contactsfirstname, vtiger_contactdetailscontact_id.lastname as contactslastname FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid LEFT JOIN vtiger_contactdetails AS vtiger_contactdetailscontact_id ON vtiger_contactdetailscontact_id.contactid=vtiger_contactdetails.reportsto  WHERE vtiger_crmentity.deleted=0 AND vtiger_contactdetails.contactid > 0");
	}

	public function testQueryCalendarEmail() {
		global $current_user;
		$queryGenerator = new QueryGenerator('Calendar', $current_user);
		$queryGenerator->setFields(array('id','subject','activitytype','date_start','due_date','taskstatus'));
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_activity.activityid, vtiger_activity.subject, vtiger_activity.activitytype, vtiger_activity.date_start, vtiger_activity.time_start, vtiger_activity.due_date, vtiger_activity.time_end, vtiger_activity.status, CASE WHEN (vtiger_activity.status not like '') THEN vtiger_activity.status ELSE vtiger_activity.eventstatus END AS status FROM vtiger_activity  INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND vtiger_activity.activityid > 0");

		$queryGenerator = new QueryGenerator('Events', $current_user);
		$queryGenerator->setFields(array('id','subject','activitytype'));
		$queryGenerator->addReferenceModuleFieldCondition('Contacts', 'contact_id', 'firstname', 'Mary', 'c');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_activity.activityid, vtiger_activity.subject, vtiger_activity.activitytype FROM vtiger_activity  INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid LEFT JOIN vtiger_cntactivityrel ON vtiger_cntactivityrel.activityid = vtiger_activity.activityid  LEFT JOIN vtiger_contactdetails AS vtiger_contactdetailscontact_id ON vtiger_contactdetailscontact_id.contactid=vtiger_cntactivityrel.contactid  WHERE vtiger_crmentity.deleted=0 AND (vtiger_contactdetailscontact_id.firstname LIKE '%Mary%')  AND vtiger_activity.activityid > 0");

		$queryGenerator = new QueryGenerator('Emails', $current_user);
		$queryGenerator->setFields(array('id','subject','activitytype'));
		$queryGenerator->addReferenceModuleFieldCondition('Accounts', 'parent_id', 'accountname', 'EDFG', 'c');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_activity.activityid, vtiger_activity.subject, vtiger_activity.activitytype FROM vtiger_activity  INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid INNER JOIN vtiger_emaildetails ON vtiger_activity.activityid = vtiger_emaildetails.emailid  LEFT JOIN vtiger_account AS vtiger_accountparent_id ON vtiger_accountparent_id.accountid=vtiger_emaildetails.idlists and vtiger_crmentity.smownerid=1  WHERE vtiger_crmentity.deleted=0 AND (vtiger_accountparent_id.accountname LIKE '%EDFG%')  AND vtiger_activity.activityid > 0");

		$queryGenerator = new QueryGenerator('Emails', $current_user);
		$queryGenerator->setFields(array('id','subject','activitytype','from_email'));
		$queryGenerator->addReferenceModuleFieldCondition('Accounts', 'parent_id', 'accountname', 'EDFG', 'c');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_activity.activityid, vtiger_activity.subject, vtiger_activity.activitytype, vtiger_emaildetails.from_email FROM vtiger_activity  INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid INNER JOIN vtiger_emaildetails ON vtiger_activity.activityid = vtiger_emaildetails.emailid LEFT JOIN vtiger_account AS vtiger_accountparent_id ON vtiger_accountparent_id.accountid=vtiger_emaildetails.idlists and vtiger_crmentity.smownerid=1  WHERE vtiger_crmentity.deleted=0 AND (vtiger_accountparent_id.accountname LIKE '%EDFG%')  AND vtiger_activity.activityid > 0");
	}

	public function testQueryUsers() {
		global $current_user;
		$queryGenerator = new QueryGenerator('Users', $current_user);
		$queryGenerator->setFields(array('id','username','first_name'));
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_users.id, vtiger_users.first_name FROM vtiger_users  WHERE vtiger_users.status='Active' AND vtiger_users.id > 0");

		$queryGenerator = new QueryGenerator('Users', $current_user);
		$queryGenerator->setFields(array('id','username','first_name'));
		$queryGenerator->addCondition('id','1','e');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_users.id, vtiger_users.first_name FROM vtiger_users  WHERE vtiger_users.status='Active' AND (vtiger_users.id = '1')  AND vtiger_users.id > 0");

		$queryGenerator = new QueryGenerator('accounts', $current_user);
		$queryGenerator->setFields(array('id','account_no','accountname','accounts.accountname'));
		$queryGenerator->addCondition('assigned_user_id','20x21199','e');
		$queryGenerator->addCondition('rating','Active','e','and');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_account.accountid, vtiger_account.account_no, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid  WHERE vtiger_crmentity.deleted=0 AND ( (trim(CONCAT(vtiger_users.first_name,' ',vtiger_users.last_name)) = '20x21199' or vtiger_groups.groupname = '20x21199'))  and ( vtiger_account.rating = 'Active')  AND vtiger_account.accountid > 0");

		$queryGenerator = new QueryGenerator('accounts', $current_user);
		$queryGenerator->setFields(array('id','account_no','accountname','accounts.accountname'));
		$queryGenerator->addReferenceModuleFieldCondition('Users', 'assigned_user_id', 'email1', 'myemail@mydomain.tld', 'e');
		$queryGenerator->addCondition('rating','Active','e','and');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_account.accountid, vtiger_account.account_no, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid  LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid   WHERE vtiger_crmentity.deleted=0 AND (vtiger_users.email1 = 'myemail@mydomain.tld')  and ( vtiger_account.rating = 'Active')  AND vtiger_account.accountid > 0");

		$queryGenerator = new QueryGenerator('accounts', $current_user);
		$queryGenerator->setFields(array('id','account_no','accountname','accounts.accountname'));
		$queryGenerator->addReferenceModuleFieldCondition('Users', 'assigned_user_id', 'id', '20x21199', 'e');
		$queryGenerator->addCondition('rating','Active','e','and');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_account.accountid, vtiger_account.account_no, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid  LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid   WHERE vtiger_crmentity.deleted=0 AND (vtiger_users.id = '20x21199' or vtiger_groups.groupid = '20x21199')  and ( vtiger_account.rating = 'Active')  AND vtiger_account.accountid > 0");

		$queryGenerator = new QueryGenerator('accounts', $current_user);
		$queryGenerator->setFields(array('id','accountname','Users.first_name','assigned_user_id'));
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_account.accountid, vtiger_account.accountname, vtiger_crmentity.smownerid FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid  WHERE vtiger_crmentity.deleted=0 AND vtiger_account.accountid > 0");
	}

	public function testQueryCustomModule() {
		global $current_user;
		$queryGenerator = new QueryGenerator('CobroPago', $current_user);
		$queryGenerator->setFields(array('id','assigned_user_id', 'first_name'));
		$queryGenerator->addReferenceModuleFieldCondition('Users', 'reports_to_id', 'first_name', 'min', 'c');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_cobropago.cobropagoid, vtiger_crmentity.smownerid FROM vtiger_cobropago  INNER JOIN vtiger_crmentity ON vtiger_cobropago.cobropagoid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid LEFT JOIN vtiger_users AS vtiger_usersreports_to_id ON vtiger_usersreports_to_id.id=vtiger_cobropago.comercialid  WHERE vtiger_crmentity.deleted=0 AND (vtiger_usersreports_to_id.first_name LIKE '%min%')  AND vtiger_cobropago.cobropagoid > 0");

		$queryGenerator = new QueryGenerator('CobroPago', $current_user);
		$queryGenerator->setFields(array('id','assigned_user_id', 'Contacts.firstname','amount','paid'));
		$queryGenerator->addReferenceModuleFieldCondition('Users', 'reports_to_id', 'first_name', '', 'n');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_cobropago.cobropagoid, vtiger_crmentity.smownerid, vtiger_contactdetailsparent_id.firstname as contactsfirstname, vtiger_cobropago.amount, vtiger_cobropago.paid FROM vtiger_cobropago  INNER JOIN vtiger_crmentity ON vtiger_cobropago.cobropagoid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid LEFT JOIN vtiger_users AS vtiger_usersreports_to_id ON vtiger_usersreports_to_id.id=vtiger_cobropago.comercialid LEFT JOIN vtiger_contactdetails AS vtiger_contactdetailsparent_id ON vtiger_contactdetailsparent_id.contactid=vtiger_cobropago.parent_id  WHERE vtiger_crmentity.deleted=0 AND (vtiger_usersreports_to_id.first_name <> '')  AND vtiger_cobropago.cobropagoid > 0");

		$queryGenerator = new QueryGenerator('CobroPago', $current_user);
		$queryGenerator->setFields(array('id','assigned_user_id', 'Contacts.firstname','amount','paid'));
		$queryGenerator->addCondition('reports_to_id','','n','and');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_cobropago.cobropagoid, vtiger_crmentity.smownerid, vtiger_contactdetailsparent_id.firstname as contactsfirstname, vtiger_cobropago.amount, vtiger_cobropago.paid FROM vtiger_cobropago  INNER JOIN vtiger_crmentity ON vtiger_cobropago.cobropagoid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid LEFT JOIN vtiger_users AS vtiger_usersreports_to_id  ON vtiger_cobropago.comercialid = vtiger_usersreports_to_id.id LEFT JOIN vtiger_contactdetails AS vtiger_contactdetailsparent_id ON vtiger_contactdetailsparent_id.contactid=vtiger_cobropago.parent_id  WHERE vtiger_crmentity.deleted=0 AND ( trim(CONCAT(vtiger_usersreports_to_id.first_name,' ',vtiger_usersreports_to_id.last_name)) <> '')  AND vtiger_cobropago.cobropagoid > 0");

		$queryGenerator = new QueryGenerator('CobroPago', $current_user);
		$queryGenerator->setFields(array('id','assigned_user_id', 'accountname'));
		$queryGenerator->addReferenceModuleFieldCondition('Accounts', 'parent_id', 'account_no', '', 'n');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_cobropago.cobropagoid, vtiger_crmentity.smownerid, vtiger_accountparent_id.accountname as accountsaccountname FROM vtiger_cobropago  INNER JOIN vtiger_crmentity ON vtiger_cobropago.cobropagoid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid LEFT JOIN vtiger_account AS vtiger_accountparent_id ON vtiger_accountparent_id.accountid=vtiger_cobropago.parent_id  WHERE vtiger_crmentity.deleted=0 AND (vtiger_accountparent_id.account_no <> '')  AND vtiger_cobropago.cobropagoid > 0");

		$queryGenerator = new QueryGenerator('CobroPago', $current_user);
		$queryGenerator->setFields(array('id','assigned_user_id', 'Contacts.firstname','Salesorder.subject','amount','paid'));
		$queryGenerator->addReferenceModuleFieldCondition('Contacts', 'parent_id', 'homephone', '902886938', 'e');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_cobropago.cobropagoid, vtiger_crmentity.smownerid, vtiger_contactdetailsparent_id.firstname as contactsfirstname, vtiger_cobropago.amount, vtiger_cobropago.paid FROM vtiger_cobropago  INNER JOIN vtiger_crmentity ON vtiger_cobropago.cobropagoid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid LEFT JOIN vtiger_contactsubdetails AS vtiger_contactsubdetailsparent_id ON vtiger_contactsubdetailsparent_id.contactsubscriptionid=vtiger_cobropago.parent_id LEFT JOIN vtiger_contactdetails AS vtiger_contactdetailsparent_id ON vtiger_contactdetailsparent_id.contactid=vtiger_cobropago.parent_id  WHERE vtiger_crmentity.deleted=0 AND (vtiger_contactsubdetailsparent_id.homephone = '902886938')  AND vtiger_cobropago.cobropagoid > 0");
	}

	public function testQueryDocuments() {
		global $current_user;
		$queryGenerator = new QueryGenerator('Documents', $current_user);
		$queryGenerator->setFields(array('id','assigned_user_id', 'notes_title','filename'));
		$queryGenerator->addCondition('filename','app','s');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_notes.notesid, vtiger_crmentity.smownerid, vtiger_notes.title, vtiger_notes.filename FROM vtiger_notes  INNER JOIN vtiger_crmentity ON vtiger_notes.notesid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid INNER JOIN vtiger_attachmentsfolder  ON vtiger_notes.folderid = vtiger_attachmentsfolder.folderid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_notes.filename LIKE 'app%')  AND vtiger_notes.notesid > 0");
	}

	public function testQueryHelpDesk() {
		global $current_user;
		$queryGenerator = new QueryGenerator('HelpDesk', $current_user);
		$queryGenerator->setFields(array('id','ticket_title','ticketstatus'));
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_troubletickets.ticketid, vtiger_troubletickets.title, vtiger_troubletickets.status FROM vtiger_troubletickets  INNER JOIN vtiger_crmentity ON vtiger_troubletickets.ticketid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND vtiger_troubletickets.ticketid > 0");

		$queryGenerator = new QueryGenerator('HelpDesk', $current_user);
		$queryGenerator->setFields(array('id','ticket_title','ticketstatus','Accounts.accountname','Contacts.firstname'));
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_troubletickets.ticketid, vtiger_troubletickets.title, vtiger_troubletickets.status, vtiger_accountparent_id.accountname as accountsaccountname, vtiger_contactdetailsparent_id.firstname as contactsfirstname FROM vtiger_troubletickets  INNER JOIN vtiger_crmentity ON vtiger_troubletickets.ticketid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountparent_id ON vtiger_accountparent_id.accountid=vtiger_troubletickets.parent_id LEFT JOIN vtiger_contactdetails AS vtiger_contactdetailsparent_id ON vtiger_contactdetailsparent_id.contactid=vtiger_troubletickets.parent_id  WHERE vtiger_crmentity.deleted=0 AND vtiger_troubletickets.ticketid > 0");
	}

	public function testQueryConditions2() {
		global $current_user;
		$queryGenerator = new QueryGenerator('Contacts', $current_user);
		$queryGenerator->setFields(array('id','firstname'));
		$queryGenerator->addCondition('firstname', 'joe', 'e');
		$queryGenerator->addCondition('lastname', '133', 'n',$queryGenerator::$AND);
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_contactdetails.contactid, vtiger_contactdetails.firstname FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_contactdetails.firstname = 'joe')  AND ( vtiger_contactdetails.lastname <> '133')  AND vtiger_contactdetails.contactid > 0");

		$queryGenerator = new QueryGenerator('Contacts', $current_user);
		$queryGenerator->setFields(array('id','firstname'));
		$queryGenerator->addCondition('id', '133', 'n',$queryGenerator::$AND);
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_contactdetails.contactid, vtiger_contactdetails.firstname FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND (vtiger_contactdetails.contactid <> '133')  AND vtiger_contactdetails.contactid > 0");

		$queryGenerator = new QueryGenerator('Contacts', $current_user);
		$queryGenerator->setFields(array('id','firstname'));
		$queryGenerator->addCondition('firstname', 'joe', 'e');
		$queryGenerator->addCondition('id', '133', 'n',$queryGenerator::$AND);
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_contactdetails.contactid, vtiger_contactdetails.firstname FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_contactdetails.firstname = 'joe')  AND (vtiger_contactdetails.contactid <> '133')  AND vtiger_contactdetails.contactid > 0");

		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id','accountname'));
		$queryGenerator->addCondition('id', '133', 'n',$queryGenerator::$AND);
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_account.accountid, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND (vtiger_account.accountid <> '133')  AND vtiger_account.accountid > 0");

		$queryGenerator = new QueryGenerator('Contacts', $current_user);
		$queryGenerator->setFields(array('id','firstname'));
		$queryGenerator->addCondition('assigned_user_id','Administrator','e');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_contactdetails.contactid, vtiger_contactdetails.firstname FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid  WHERE vtiger_crmentity.deleted=0 AND ( (trim(CONCAT(vtiger_users.first_name,' ',vtiger_users.last_name)) = 'Administrator' or vtiger_groups.groupname = 'Administrator'))  AND vtiger_contactdetails.contactid > 0");

		$queryGenerator = new QueryGenerator('Contacts', $current_user);
		$queryGenerator->setFields(array('id','accountname','firstname'));
		$queryGenerator->addReferenceModuleFieldCondition('Accounts', 'account_id', 'accountname', 'EDFG Group Limited', 'exists');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_contactdetails.contactid, vtiger_accountaccount_id.accountname as accountsaccountname, vtiger_contactdetails.firstname FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_contactdetails.accountid  WHERE vtiger_crmentity.deleted=0 AND (SELECT EXISTS(SELECT 1  FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_account.accountname = 'EDFG Group Limited')  AND vtiger_account.accountid > 0))  AND vtiger_contactdetails.contactid > 0");
	}

}
?>