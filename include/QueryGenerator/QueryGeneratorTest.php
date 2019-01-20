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

/*
 Query with conditions, Supported operators:
    'e'  = value  (equals)
    'n'  <> value  (not equal)
    's'  LIKE $value%  (starts with)
    'ew' LIKE %$value  (ends with)
    'c'  LIKE %$value%  (contains)
    'k'  NOT LIKE %$value% (does not contain)
    'l'  < value (less than)
    'b'  < value (before, only for dates)
    'g'  > value  (greater than)
    'a'  > value  (after, only for dates)
    'm'  <= value  (less or equal)
    'h'  >= value  (greater or equal)
    'y'  or 'empty' NULL or ''  (null or empty)
    'ny' NOT NULL nor ''  (not null nor empty)
    'bw' BETWEEN value1 and value2  (between two dates)
    'i'  or 'in' IN value1,...,valuen  (in set of values)
    'ni' or 'nin' NOT IN value1,...,valuen  (not in set of values)
    There is special support for empty fields and for the Birthday field
*/

use PHPUnit\Framework\TestCase;

class QueryGeneratorTest extends TestCase {

	/****
	 * TEST Users decimal configuration
	 * name format is: {decimal_separator}{symbol_position}{grouping}{grouping_symbol}{currency}
	 ****/
	public $usrdota0x = 5; // testdmy
	public $usrcomd0x = 6; // testmdy
	public $usrdotd3com = 7; // testymd
	public $usrcoma3dot = 10; // testtz
	public $usrdota3comdollar = 12; // testmcurrency

	private function sortQueryColumns($query) {
		$cols = trim(substr($query, 7, stripos($query, ' from ')-7));
		$cols = explode(',', $cols);
		$cols = array_map('trim', $cols);
		sort($cols);
		$cols = implode(',', $cols);
		return substr($query, 0, 6).' '.$cols.substr($query, stripos($query, ' from '));
	}

	public function testAccountId() {
		global $current_user;
		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id'));
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,'SELECT vtiger_account.accountid FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND vtiger_account.accountid > 0');
		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id'));
		$query = $queryGenerator->getQuery(true);
		$this->assertEquals($query,'SELECT DISTINCT vtiger_account.accountid FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND vtiger_account.accountid > 0');
	}

	public function testMyOwnerId() {
		global $current_user;
		$queryGenerator = new QueryGenerator('Project', $current_user);
		$denorm=$queryGenerator->denormalized;
		if ($denorm) {
			$queryGenerator->setFields(array('assigned_user_id'));
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,'SELECT vtiger_project.myownerid FROM vtiger_project  LEFT JOIN vtiger_users ON vtiger_project.myownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_project.myownerid = vtiger_groups.groupid WHERE vtiger_project.mydeleted=0 AND vtiger_project.projectid > 0');
			$queryGenerator = new QueryGenerator('Project', $current_user);
			$queryGenerator->setFields(array('assigned_user_id'));
			$query = $queryGenerator->getQuery(true);
			$this->assertEquals($query,'SELECT DISTINCT vtiger_project.myownerid FROM vtiger_project  LEFT JOIN vtiger_users ON vtiger_project.myownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_project.myownerid = vtiger_groups.groupid WHERE vtiger_project.mydeleted=0 AND vtiger_project.projectid > 0');
		} else {
			$this->assertTrue(true);
		}
	}

	public function testQueryWithCustomField() {
		global $current_user,$adb;
		$cnacc=$adb->getColumnNames('vtiger_accountscf');
		if (empty($cnacc) or count($cnacc)<=1) {
			$this->markTestSkipped('Accounts::no custom fields');
		} else {
			$cf = $cnacc[1];
			$queryGenerator = new QueryGenerator('Accounts', $current_user);
			$queryGenerator->setFields(array('id',$cf));
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,"SELECT vtiger_account.accountid, vtiger_accountscf.$cf FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid INNER JOIN vtiger_accountscf ON vtiger_account.accountid = vtiger_accountscf.accountid  WHERE vtiger_crmentity.deleted=0 AND vtiger_account.accountid > 0");
		}
		$cnqte=$adb->getColumnNames('vtiger_quotescf');
		if (empty($cnqte) or count($cnqte)<=1) {
			$this->markTestSkipped('Quotes::no custom fields');
		} else {
			$cf = $cnqte[1];
			$queryGenerator = new QueryGenerator('Quotes', $current_user);
			$queryGenerator->setFields(array('id',$cf));
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,"SELECT vtiger_quotes.quoteid, vtiger_quotescf.$cf FROM vtiger_quotes  INNER JOIN vtiger_crmentity ON vtiger_quotes.quoteid = vtiger_crmentity.crmid INNER JOIN vtiger_quotescf ON vtiger_quotes.quoteid = vtiger_quotescf.quoteid  WHERE vtiger_crmentity.deleted=0 AND vtiger_quotes.quoteid > 0");
			$queryGenerator = new QueryGenerator('Quotes', $current_user);
			$queryGenerator->setFields(array('id','Documents.filename'));
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,"SELECT vtiger_quotes.quoteid, vtiger_notescf_747.filename as documentsfilename FROM vtiger_quotes  INNER JOIN vtiger_crmentity ON vtiger_quotes.quoteid = vtiger_crmentity.crmid LEFT JOIN vtiger_quotescf ON vtiger_quotescf.quoteid=vtiger_quotes.quoteid LEFT JOIN vtiger_notes AS vtiger_notescf_747 ON vtiger_notescf_747.notesid=vtiger_quotescf.cf_747  WHERE vtiger_crmentity.deleted=0 AND vtiger_quotes.quoteid > 0");
			$queryGenerator = new QueryGenerator('Quotes', $current_user);
			$queryGenerator->setFields(array('id','Documents.filename','Documents.note_no'));
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,"SELECT vtiger_quotes.quoteid, vtiger_notescf_747.filename as documentsfilename, vtiger_notescf_747.note_no as documentsnote_no FROM vtiger_quotes  INNER JOIN vtiger_crmentity ON vtiger_quotes.quoteid = vtiger_crmentity.crmid LEFT JOIN vtiger_quotescf ON vtiger_quotescf.quoteid=vtiger_quotes.quoteid LEFT JOIN vtiger_notes AS vtiger_notescf_747 ON vtiger_notescf_747.notesid=vtiger_quotescf.cf_747  WHERE vtiger_crmentity.deleted=0 AND vtiger_quotes.quoteid > 0");
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

	public function testQueryWithInvalidFieldDenorm() {
		global $current_user;
		$cf = 'cf_91'; // there will never be a custom field with such a low number
		$queryGenerator = new QueryGenerator('Project', $current_user);
		$denorm=$queryGenerator->denormalized;
		$queryGenerator->setFields(array('id',$cf));
		$query = $queryGenerator->getQuery();
		if ($denorm) {
			$this->assertEquals($query,'SELECT vtiger_project.projectid FROM vtiger_project  WHERE vtiger_project.mydeleted=0 AND vtiger_project.projectid > 0');
		} else {
			$this->assertTrue(true);
		}
	}


	public function testQueryWithIncompatibleOperations() {
		global $current_user;
		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id','employees'));
		$queryGenerator->addCondition('employees',131,'s');
		$query = $queryGenerator->getQuery();
		$this->assertEquals("SELECT vtiger_account.accountid, vtiger_account.employees FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_account.employees LIKE '131%')  AND vtiger_account.accountid > 0", $query);
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

	public function testQueryIndividualPartsDenorm() {
		global $current_user;
		$queryGenerator = new QueryGenerator('Project', $current_user);
		$denorm=$queryGenerator->denormalized;
		$queryGenerator->setFields(array('projectname','createdtime'));
		$query = $queryGenerator->getQuery();
		if ($denorm) {
			$this->assertEquals($query,'SELECT vtiger_project.projectname, vtiger_project.mycreatedtime FROM vtiger_project  WHERE vtiger_project.mydeleted=0 AND vtiger_project.projectid > 0');
			$this->assertEquals($queryGenerator->getSelectClauseColumnSQL(),'vtiger_project.projectname, vtiger_project.mycreatedtime');
			$this->assertEquals($queryGenerator->getFromClause(),' FROM vtiger_project  ');
			$this->assertEquals($queryGenerator->getWhereClause(),'WHERE vtiger_project.mydeleted=0 AND vtiger_project.projectid > 0');
		} else {
			$this->assertTrue(true);
		}
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
		$denorm= $queryGenerator->denormalized;
		if ($denorm) {
			$this->assertEquals($query,"SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.startdate, vtiger_project.targetenddate FROM vtiger_project  WHERE vtiger_project.mydeleted=0 AND ( vtiger_project.startdate < '2015-04-16')  OR ( vtiger_project.targetenddate > '2015-06-16')  AND vtiger_project.projectid > 0");
		} else {
			$this->assertEquals($query,"SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.startdate, vtiger_project.targetenddate FROM vtiger_project  INNER JOIN vtiger_crmentity ON vtiger_project.projectid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_project.startdate < '2015-04-16')  OR ( vtiger_project.targetenddate > '2015-06-16')  AND vtiger_project.projectid > 0");
		}

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

		$queryGenerator = new QueryGenerator('Invoice', $current_user);
		$queryGenerator->setFields(array('id','account_id'));
		$queryGenerator->addCondition('id','22','e');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_invoice.invoiceid, vtiger_invoice.accountid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND (vtiger_invoice.invoiceid = '22')  AND vtiger_invoice.invoiceid > 0");

		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id','accountname'));
		$queryGenerator->addCondition('id',array('22','55'),'i');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_account.accountid, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND (vtiger_account.accountid  IN ('22','55'))  AND vtiger_account.accountid > 0");

		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id','accountname'));
		$queryGenerator->addCondition('id',array('22','55'),'ni');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_account.accountid, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND (vtiger_account.accountid  NOT IN ('22','55'))  AND vtiger_account.accountid > 0");
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

		$queryGenerator = new QueryGenerator("Contacts", $current_user);
		$queryGenerator->setFields(array('id','accountname','Accounts.assigned_user_id'));
		$queryGenerator->addReferenceModuleFieldCondition('Accounts', 'account_id', 'id', array('22','55'), 'i');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_contactdetails.contactid, vtiger_accountaccount_id.accountname as accountsaccountname, vtiger_crmentityaccount_id.smownerid as smowneraccounts FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_contactdetails.accountid LEFT JOIN vtiger_crmentity AS vtiger_crmentityaccount_id ON vtiger_crmentityaccount_id.crmid=vtiger_contactdetails.accountid  WHERE vtiger_crmentity.deleted=0 AND (vtiger_accountaccount_id.accountid  IN ('22','55'))  AND vtiger_contactdetails.contactid > 0");

		$queryGenerator = new QueryGenerator("Contacts", $current_user);
		$queryGenerator->setFields(array('id','accountname','Accounts.assigned_user_id'));
		$queryGenerator->addReferenceModuleFieldCondition('Accounts', 'account_id', 'id', array('22','55'), 'ni');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_contactdetails.contactid, vtiger_accountaccount_id.accountname as accountsaccountname, vtiger_crmentityaccount_id.smownerid as smowneraccounts FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_contactdetails.accountid LEFT JOIN vtiger_crmentity AS vtiger_crmentityaccount_id ON vtiger_crmentityaccount_id.crmid=vtiger_contactdetails.accountid  WHERE vtiger_crmentity.deleted=0 AND (vtiger_accountaccount_id.accountid  NOT IN ('22','55'))  AND vtiger_contactdetails.contactid > 0");

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

	public function testQueryRelatedCustomFieldsConditions() {
		global $current_user;
		$queryGenerator = new QueryGenerator('Services', $current_user);
		$queryGenerator->setFields(array('servicename'));
		$queryGenerator->addReferenceModuleFieldCondition('Products', 'cf_802', 'productcategory', 'Hardware', 'e');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_service.servicename FROM vtiger_service  INNER JOIN vtiger_crmentity ON vtiger_service.serviceid = vtiger_crmentity.crmid LEFT JOIN vtiger_servicecf ON vtiger_servicecf.serviceid=vtiger_service.serviceid  LEFT JOIN vtiger_products AS vtiger_productscf_802 ON vtiger_productscf_802.productid=vtiger_servicecf.cf_802  WHERE vtiger_crmentity.deleted=0 AND (vtiger_productscf_802.productcategory = 'Hardware')  AND vtiger_service.serviceid > 0");

		$queryGenerator = new QueryGenerator('Services', $current_user);
		$queryGenerator->setFields(array('servicename','Products.productname'));
		$queryGenerator->addReferenceModuleFieldCondition('Products', 'cf_802', 'productcategory', 'Hardware', 'e');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_service.servicename, vtiger_productscf_802.productname as productsproductname FROM vtiger_service  INNER JOIN vtiger_crmentity ON vtiger_service.serviceid = vtiger_crmentity.crmid LEFT JOIN vtiger_servicecf ON vtiger_servicecf.serviceid=vtiger_service.serviceid  LEFT JOIN vtiger_products AS vtiger_productscf_802 ON vtiger_productscf_802.productid=vtiger_servicecf.cf_802  WHERE vtiger_crmentity.deleted=0 AND (vtiger_productscf_802.productcategory = 'Hardware')  AND vtiger_service.serviceid > 0");

		$queryGenerator = new QueryGenerator('Services', $current_user);
		$queryGenerator->setFields(array('servicename','Products.productname'));
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_service.servicename, vtiger_productscf_802.productname as productsproductname FROM vtiger_service  INNER JOIN vtiger_crmentity ON vtiger_service.serviceid = vtiger_crmentity.crmid LEFT JOIN vtiger_servicecf ON vtiger_servicecf.serviceid=vtiger_service.serviceid LEFT JOIN vtiger_products AS vtiger_productscf_802 ON vtiger_productscf_802.productid=vtiger_servicecf.cf_802  WHERE vtiger_crmentity.deleted=0 AND vtiger_service.serviceid > 0");

		$queryGenerator = new QueryGenerator('Services', $current_user);
		$queryGenerator->setFields(array('servicename','productname'));
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_service.servicename, vtiger_productscf_802.productname as productsproductname FROM vtiger_service  INNER JOIN vtiger_crmentity ON vtiger_service.serviceid = vtiger_crmentity.crmid LEFT JOIN vtiger_servicecf ON vtiger_servicecf.serviceid=vtiger_service.serviceid LEFT JOIN vtiger_products AS vtiger_productscf_802 ON vtiger_productscf_802.productid=vtiger_servicecf.cf_802  WHERE vtiger_crmentity.deleted=0 AND vtiger_service.serviceid > 0");
}

	public function testQueryCalendarEmail() {
		global $current_user;
		$queryGenerator = new QueryGenerator('Calendar', $current_user);
		$queryGenerator->setFields(array('id','subject','activitytype','date_start','due_date','taskstatus'));
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_activity.activityid, vtiger_activity.subject, vtiger_activity.activitytype, vtiger_activity.date_start, vtiger_activity.time_start, vtiger_activity.due_date, vtiger_activity.time_end, vtiger_activity.status, CASE WHEN (vtiger_activity.status not like '') THEN vtiger_activity.status ELSE vtiger_activity.eventstatus END AS status FROM vtiger_activity  INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND vtiger_activity.activityid > 0");

		$queryGenerator = new QueryGenerator('Calendar', $current_user);
		$queryGenerator->setFields(array('id','subject','activitytype','date_start','due_date','taskstatus'));
		$queryGenerator->addCondition('date_start',array(0=>'2006-01-21',1=>'2016-01-11'),'bw');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_activity.activityid, vtiger_activity.subject, vtiger_activity.activitytype, vtiger_activity.date_start, vtiger_activity.time_start, vtiger_activity.due_date, vtiger_activity.time_end, vtiger_activity.status, CASE WHEN (vtiger_activity.status not like '') THEN vtiger_activity.status ELSE vtiger_activity.eventstatus END AS status FROM vtiger_activity  INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_activity.date_start BETWEEN '2006-01-21' AND '2016-01-11')  AND vtiger_activity.activityid > 0");

		$queryGenerator = new QueryGenerator('Events', $current_user);
		$queryGenerator->setFields(array('id','subject','activitytype'));
		$queryGenerator->addReferenceModuleFieldCondition('Contacts', 'contact_id', 'firstname', 'Mary', 'c');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_activity.activityid, vtiger_activity.subject, vtiger_activity.activitytype FROM vtiger_activity  INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid LEFT JOIN vtiger_cntactivityrel ON vtiger_cntactivityrel.activityid=vtiger_activity.activityid  LEFT JOIN vtiger_contactdetails AS vtiger_contactdetailscontact_id ON vtiger_contactdetailscontact_id.contactid=vtiger_cntactivityrel.contactid  WHERE vtiger_crmentity.deleted=0 AND (vtiger_contactdetailscontact_id.firstname LIKE '%Mary%')  AND vtiger_activity.activityid > 0");

		$queryGenerator = new QueryGenerator('Emails', $current_user);
		$queryGenerator->setFields(array('id','subject','activitytype'));
		$queryGenerator->addReferenceModuleFieldCondition('Accounts', 'parent_id', 'accountname', 'EDFG', 'c');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_activity.activityid, vtiger_activity.subject, vtiger_activity.activitytype FROM vtiger_activity  INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid INNER JOIN vtiger_emaildetails ON vtiger_emaildetails.emailid=vtiger_activity.activityid  LEFT JOIN vtiger_account AS vtiger_accountparent_id ON vtiger_accountparent_id.accountid=vtiger_emaildetails.idlists  WHERE vtiger_crmentity.deleted=0 AND (vtiger_accountparent_id.accountname LIKE '%EDFG%')  AND vtiger_activity.activityid > 0");

		$queryGenerator = new QueryGenerator('Emails', $current_user);
		$queryGenerator->setFields(array('id','subject','activitytype','from_email'));
		$queryGenerator->addReferenceModuleFieldCondition('Accounts', 'parent_id', 'accountname', 'EDFG', 'c');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_activity.activityid, vtiger_activity.subject, vtiger_activity.activitytype, vtiger_emaildetails.from_email FROM vtiger_activity  INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid INNER JOIN vtiger_emaildetails ON vtiger_activity.activityid = vtiger_emaildetails.emailid LEFT JOIN vtiger_account AS vtiger_accountparent_id ON vtiger_accountparent_id.accountid=vtiger_emaildetails.idlists  WHERE vtiger_crmentity.deleted=0 AND (vtiger_accountparent_id.accountname LIKE '%EDFG%')  AND vtiger_activity.activityid > 0");

		$queryGenerator = new QueryGenerator('Calendar', $current_user);
		$queryGenerator->setFields(array('id','subject','activitytype','accountname'));
		$queryGenerator->addReferenceModuleFieldCondition('Accounts', 'parent_id', 'accountname', 'EDFG', 'c');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_activity.activityid, vtiger_activity.subject, vtiger_activity.activitytype, vtiger_accountparent_id.accountname as accountsaccountname FROM vtiger_activity  INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid LEFT JOIN vtiger_seactivityrel ON vtiger_seactivityrel.activityid=vtiger_activity.activityid  LEFT JOIN vtiger_account AS vtiger_accountparent_id ON vtiger_accountparent_id.accountid=vtiger_seactivityrel.crmid  WHERE vtiger_crmentity.deleted=0 AND (vtiger_accountparent_id.accountname LIKE '%EDFG%')  AND vtiger_activity.activityid > 0");

		$queryGenerator = new QueryGenerator('Calendar', $current_user);
		$queryGenerator->setFields(array('id','subject','activitytype','Accounts.phone'));
		$queryGenerator->addReferenceModuleFieldCondition('Accounts', 'parent_id', 'accountname', 'EDFG', 'c');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_activity.activityid, vtiger_activity.subject, vtiger_activity.activitytype, vtiger_accountparent_id.phone as accountsphone FROM vtiger_activity  INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid LEFT JOIN vtiger_seactivityrel ON vtiger_seactivityrel.activityid=vtiger_activity.activityid  LEFT JOIN vtiger_account AS vtiger_accountparent_id ON vtiger_accountparent_id.accountid=vtiger_seactivityrel.crmid  WHERE vtiger_crmentity.deleted=0 AND (vtiger_accountparent_id.accountname LIKE '%EDFG%')  AND vtiger_activity.activityid > 0");

		$queryGenerator = new QueryGenerator('Events', $current_user);
		$queryGenerator->setFields(array('id','subject','activitytype')); //,'Contacts.firstname'));
		$queryGenerator->addReferenceModuleFieldCondition('Contacts', 'contact_id', 'id', '33', 'e');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_activity.activityid, vtiger_activity.subject, vtiger_activity.activitytype FROM vtiger_activity  INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid LEFT JOIN vtiger_cntactivityrel ON vtiger_cntactivityrel.activityid=vtiger_activity.activityid  LEFT JOIN vtiger_contactdetails AS vtiger_contactdetailscontact_id ON vtiger_contactdetailscontact_id.contactid=vtiger_cntactivityrel.contactid  WHERE vtiger_crmentity.deleted=0 AND (vtiger_contactdetailscontact_id.contactid = '33')  AND vtiger_activity.activityid > 0");

		$queryGenerator = new QueryGenerator('Calendar', $current_user);
		$queryGenerator->setFields(array('id','subject','activitytype','Accounts.phone'));
		$queryGenerator->addReferenceModuleFieldCondition('Accounts', 'parent_id', 'id', '22', 'e');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_activity.activityid, vtiger_activity.subject, vtiger_activity.activitytype, vtiger_accountparent_id.phone as accountsphone FROM vtiger_activity  INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid LEFT JOIN vtiger_seactivityrel ON vtiger_seactivityrel.activityid=vtiger_activity.activityid  LEFT JOIN vtiger_account AS vtiger_accountparent_id ON vtiger_accountparent_id.accountid=vtiger_seactivityrel.crmid  WHERE vtiger_crmentity.deleted=0 AND (vtiger_accountparent_id.accountid = '22')  AND vtiger_activity.activityid > 0",'Calendar-Account');

		$queryGenerator = new QueryGenerator('Calendar', $current_user);
		$queryGenerator->setFields(array('id','HelpDesk.ticket_title'));  // include link field to force join
		$queryGenerator->addReferenceModuleFieldCondition('HelpDesk', 'parent_id', 'id', '8953', 'e');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_activity.activityid, vtiger_troubleticketsparent_id.title as helpdesktitle FROM vtiger_activity  INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid LEFT JOIN vtiger_seactivityrel ON vtiger_seactivityrel.activityid=vtiger_activity.activityid  LEFT JOIN vtiger_troubletickets AS vtiger_troubleticketsparent_id ON vtiger_troubleticketsparent_id.ticketid=vtiger_seactivityrel.crmid  WHERE vtiger_crmentity.deleted=0 AND (vtiger_troubleticketsparent_id.ticketid = '8953')  AND vtiger_activity.activityid > 0",'Calendar-HelpDesk');

		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x);
		$queryGenerator = new QueryGenerator('Emails', $user);
		$queryGenerator->setFields(array('id','subject','activitytype'));
		$queryGenerator->addReferenceModuleFieldCondition('Accounts', 'parent_id', 'accountname', 'EDFG', 'c');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_activity.activityid, vtiger_activity.subject, vtiger_activity.activitytype FROM vtiger_activity  INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid INNER JOIN vtiger_emaildetails ON vtiger_emaildetails.emailid=vtiger_activity.activityid  LEFT JOIN vtiger_account AS vtiger_accountparent_id ON vtiger_accountparent_id.accountid=vtiger_emaildetails.idlists INNER JOIN vt_tmp_u5 vt_tmp_u5 ON vt_tmp_u5.id = vtiger_crmentity.smownerid  WHERE vtiger_crmentity.deleted=0 AND (vtiger_accountparent_id.accountname LIKE '%EDFG%')  AND vtiger_activity.activityid > 0");

		$queryGenerator = new QueryGenerator('Emails', $user);
		$queryGenerator->setFields(array('id','subject','activitytype','from_email'));
		$queryGenerator->addReferenceModuleFieldCondition('Accounts', 'parent_id', 'accountname', 'EDFG', 'c');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_activity.activityid, vtiger_activity.subject, vtiger_activity.activitytype, vtiger_emaildetails.from_email FROM vtiger_activity  INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid INNER JOIN vtiger_emaildetails ON vtiger_activity.activityid = vtiger_emaildetails.emailid LEFT JOIN vtiger_account AS vtiger_accountparent_id ON vtiger_accountparent_id.accountid=vtiger_emaildetails.idlists INNER JOIN vt_tmp_u5 vt_tmp_u5 ON vt_tmp_u5.id = vtiger_crmentity.smownerid  WHERE vtiger_crmentity.deleted=0 AND (vtiger_accountparent_id.accountname LIKE '%EDFG%')  AND vtiger_activity.activityid > 0");

		$queryGenerator = new QueryGenerator('Emails', $holduser);
		$queryGenerator->setFields(array('*'));
		$query = $queryGenerator->getQuery();
		$query = $this->sortQueryColumns($query);
		$this->assertEquals($query, 'SELECT vtiger_activity.activityid,vtiger_activity.activitytype,vtiger_activity.date_start,vtiger_activity.semodule,vtiger_activity.subject,vtiger_activity.time_start,vtiger_crmentity.createdtime,vtiger_crmentity.description,vtiger_crmentity.modifiedby,vtiger_crmentity.modifiedtime,vtiger_crmentity.smownerid,vtiger_email_track.access_count,vtiger_emaildetails.bcc_email,vtiger_emaildetails.cc_email,vtiger_emaildetails.email_flag,vtiger_emaildetails.from_email,vtiger_emaildetails.idlists,vtiger_emaildetails.to_email FROM vtiger_activity  INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid INNER JOIN vtiger_emaildetails ON vtiger_activity.activityid = vtiger_emaildetails.emailid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid INNER JOIN vtiger_email_track ON vtiger_activity.activityid = vtiger_email_track.mailid LEFT JOIN vtiger_users AS vtiger_usersparent_id  ON vtiger_emaildetails.idlists = vtiger_usersparent_id.id LEFT JOIN vtiger_groups AS vtiger_groupsparent_id  ON vtiger_emaildetails.idlists = vtiger_groupsparent_id.groupid LEFT JOIN vtiger_users AS vtiger_usersmodifiedby  ON vtiger_crmentity.modifiedby = vtiger_usersmodifiedby.id LEFT JOIN vtiger_groups AS vtiger_groupsmodifiedby  ON vtiger_crmentity.modifiedby = vtiger_groupsmodifiedby.groupid  WHERE vtiger_crmentity.deleted=0 AND vtiger_activity.activityid > 0');
		$current_user = $holduser;
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
		$queryGenerator->addCondition('assigned_user_id', '20x21199', 'e');
		$queryGenerator->addCondition('rating', 'Active', 'e', 'and');
		$query = $queryGenerator->getQuery();
		$this->assertEquals(
			$query,
			"SELECT vtiger_account.accountid, vtiger_account.account_no, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid  WHERE vtiger_crmentity.deleted=0 AND ( (trim(CONCAT(vtiger_users.first_name,' ',vtiger_users.last_name)) = '20x21199' or vtiger_groups.groupname = '20x21199'))  and ( vtiger_account.rating IN (
								select translation_key
								from vtiger_cbtranslation
								where locale=\"en_us\" and forpicklist=\"accounts::rating\" and i18n = 'Active') OR vtiger_account.rating = 'Active')  AND vtiger_account.accountid > 0"
		);

		$queryGenerator = new QueryGenerator('accounts', $current_user);
		$queryGenerator->setFields(array('id','account_no','accountname','accounts.accountname'));
		$queryGenerator->addReferenceModuleFieldCondition('Users', 'assigned_user_id', 'email1', 'myemail@mydomain.tld', 'e');
		$queryGenerator->addCondition('rating', 'Active', 'e', 'and');
		$query = $queryGenerator->getQuery();
		$this->assertEquals(
			$query,
			"SELECT vtiger_account.accountid, vtiger_account.account_no, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid  LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid   WHERE vtiger_crmentity.deleted=0 AND (vtiger_users.email1 = 'myemail@mydomain.tld')  and ( vtiger_account.rating IN (
								select translation_key
								from vtiger_cbtranslation
								where locale=\"en_us\" and forpicklist=\"accounts::rating\" and i18n = 'Active') OR vtiger_account.rating = 'Active')  AND vtiger_account.accountid > 0"
		);

		$queryGenerator = new QueryGenerator('accounts', $current_user);
		$queryGenerator->setFields(array('id','account_no','accountname','accounts.accountname'));
		$queryGenerator->addReferenceModuleFieldCondition('Users', 'assigned_user_id', 'id', '20x21199', 'e');
		$queryGenerator->addCondition('rating', 'Active', 'e', 'and');
		$query = $queryGenerator->getQuery();
		$this->assertEquals(
			$query,
			"SELECT vtiger_account.accountid, vtiger_account.account_no, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid  LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid   WHERE vtiger_crmentity.deleted=0 AND (vtiger_users.id = '20x21199' or vtiger_groups.groupid = '20x21199')  and ( vtiger_account.rating IN (
								select translation_key
								from vtiger_cbtranslation
								where locale=\"en_us\" and forpicklist=\"accounts::rating\" and i18n = 'Active') OR vtiger_account.rating = 'Active')  AND vtiger_account.accountid > 0"
		);

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
		$denorm = $queryGenerator->denormalized;
		if ($denorm) {
			$this->assertEquals($query,"SELECT vtiger_cobropago.cobropagoid, vtiger_cobropago.myownerid FROM vtiger_cobropago  LEFT JOIN vtiger_users ON vtiger_cobropago.myownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_cobropago.myownerid = vtiger_groups.groupid LEFT JOIN vtiger_users AS vtiger_usersreports_to_id ON vtiger_usersreports_to_id.id=vtiger_cobropago.comercialid  WHERE vtiger_cobropago.mydeleted=0 AND (vtiger_usersreports_to_id.first_name LIKE '%min%')  AND vtiger_cobropago.cobropagoid > 0");

			$queryGenerator = new QueryGenerator('CobroPago', $current_user);
			$queryGenerator->setFields(array('id','assigned_user_id', 'Contacts.firstname','amount','paid'));
			$queryGenerator->addReferenceModuleFieldCondition('Users', 'reports_to_id', 'first_name', '', 'n');
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,"SELECT vtiger_cobropago.cobropagoid, vtiger_cobropago.myownerid, vtiger_contactdetailsparent_id.firstname as contactsfirstname, vtiger_cobropago.amount, vtiger_cobropago.paid FROM vtiger_cobropago  LEFT JOIN vtiger_users ON vtiger_cobropago.myownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_cobropago.myownerid = vtiger_groups.groupid LEFT JOIN vtiger_users AS vtiger_usersreports_to_id ON vtiger_usersreports_to_id.id=vtiger_cobropago.comercialid LEFT JOIN vtiger_contactdetails AS vtiger_contactdetailsparent_id ON vtiger_contactdetailsparent_id.contactid=vtiger_cobropago.parent_id  WHERE vtiger_cobropago.mydeleted=0 AND (vtiger_usersreports_to_id.first_name <> '')  AND vtiger_cobropago.cobropagoid > 0");

			$queryGenerator = new QueryGenerator('CobroPago', $current_user);
			$queryGenerator->setFields(array('id','assigned_user_id', 'Contacts.firstname','amount','paid'));
			$queryGenerator->addCondition('reports_to_id','','n','and');
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,"SELECT vtiger_cobropago.cobropagoid, vtiger_cobropago.myownerid, vtiger_contactdetailsparent_id.firstname as contactsfirstname, vtiger_cobropago.amount, vtiger_cobropago.paid FROM vtiger_cobropago  LEFT JOIN vtiger_users ON vtiger_cobropago.myownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_cobropago.myownerid = vtiger_groups.groupid LEFT JOIN vtiger_users AS vtiger_usersreports_to_id  ON vtiger_cobropago.comercialid = vtiger_usersreports_to_id.id LEFT JOIN vtiger_contactdetails AS vtiger_contactdetailsparent_id ON vtiger_contactdetailsparent_id.contactid=vtiger_cobropago.parent_id  WHERE vtiger_cobropago.mydeleted=0 AND ( trim(CONCAT(vtiger_usersreports_to_id.first_name,' ',vtiger_usersreports_to_id.last_name)) <> '')  AND vtiger_cobropago.cobropagoid > 0");

			$queryGenerator = new QueryGenerator('CobroPago', $current_user);
			$queryGenerator->setFields(array('id','assigned_user_id', 'accountname'));
			$queryGenerator->addReferenceModuleFieldCondition('Accounts', 'parent_id', 'account_no', '', 'n');
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,"SELECT vtiger_cobropago.cobropagoid, vtiger_cobropago.myownerid, vtiger_accountparent_id.accountname as accountsaccountname FROM vtiger_cobropago  LEFT JOIN vtiger_users ON vtiger_cobropago.myownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_cobropago.myownerid = vtiger_groups.groupid LEFT JOIN vtiger_account AS vtiger_accountparent_id ON vtiger_accountparent_id.accountid=vtiger_cobropago.parent_id  WHERE vtiger_cobropago.mydeleted=0 AND (vtiger_accountparent_id.account_no <> '')  AND vtiger_cobropago.cobropagoid > 0");

			$queryGenerator = new QueryGenerator('CobroPago', $current_user);
			$queryGenerator->setFields(array('id','assigned_user_id', 'Contacts.firstname','Salesorder.subject','amount','paid'));
			$queryGenerator->addReferenceModuleFieldCondition('Contacts', 'parent_id', 'homephone', '902886938', 'e');
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,"SELECT vtiger_cobropago.cobropagoid, vtiger_cobropago.myownerid, vtiger_contactdetailsparent_id.firstname as contactsfirstname, vtiger_cobropago.amount, vtiger_cobropago.paid FROM vtiger_cobropago  LEFT JOIN vtiger_users ON vtiger_cobropago.myownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_cobropago.myownerid = vtiger_groups.groupid LEFT JOIN vtiger_contactsubdetails AS vtiger_contactsubdetailsparent_id ON vtiger_contactsubdetailsparent_id.contactsubscriptionid=vtiger_cobropago.parent_id LEFT JOIN vtiger_contactdetails AS vtiger_contactdetailsparent_id ON vtiger_contactdetailsparent_id.contactid=vtiger_cobropago.parent_id  WHERE vtiger_cobropago.mydeleted=0 AND (vtiger_contactsubdetailsparent_id.homephone = '902886938')  AND vtiger_cobropago.cobropagoid > 0");

			$queryGenerator = new QueryGenerator('CobroPago', $current_user);
			$queryGenerator->setFields(array('id','HelpDesk.ticket_title'));  // include link field to force join
			$queryGenerator->addReferenceModuleFieldCondition('HelpDesk', 'related_id', 'id', '8953', 'e');
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,"SELECT vtiger_cobropago.cobropagoid, vtiger_troubleticketsrelated_id.title as helpdesktitle FROM vtiger_cobropago  LEFT JOIN vtiger_troubletickets AS vtiger_troubleticketsrelated_id ON vtiger_troubleticketsrelated_id.ticketid=vtiger_cobropago.related_id  WHERE vtiger_cobropago.mydeleted=0 AND (vtiger_troubleticketsrelated_id.ticketid = '8953')  AND vtiger_cobropago.cobropagoid > 0",'CobroPago-HelpDesk');

			$queryGenerator = new QueryGenerator('CobroPago', $current_user);
			$queryGenerator->setFields(array('id'));
			$queryGenerator->addReferenceModuleFieldCondition('HelpDesk', 'related_id', 'id', '8953', 'e');
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,"SELECT vtiger_cobropago.cobropagoid FROM vtiger_cobropago  LEFT JOIN vtiger_troubletickets AS vtiger_troubleticketsrelated_id ON vtiger_troubleticketsrelated_id.ticketid=vtiger_cobropago.related_id  WHERE vtiger_cobropago.mydeleted=0 AND (vtiger_troubleticketsrelated_id.ticketid = '8953')  AND vtiger_cobropago.cobropagoid > 0",'CobroPago-HelpDesk');
		} else {
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

			$queryGenerator = new QueryGenerator('CobroPago', $current_user);
			$queryGenerator->setFields(array('id','HelpDesk.ticket_title'));  // include link field to force join
			$queryGenerator->addReferenceModuleFieldCondition('HelpDesk', 'related_id', 'id', '8953', 'e');
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,"SELECT vtiger_cobropago.cobropagoid, vtiger_troubleticketsrelated_id.title as helpdesktitle FROM vtiger_cobropago  INNER JOIN vtiger_crmentity ON vtiger_cobropago.cobropagoid = vtiger_crmentity.crmid LEFT JOIN vtiger_troubletickets AS vtiger_troubleticketsrelated_id ON vtiger_troubleticketsrelated_id.ticketid=vtiger_cobropago.related_id  WHERE vtiger_crmentity.deleted=0 AND (vtiger_troubleticketsrelated_id.ticketid = '8953')  AND vtiger_cobropago.cobropagoid > 0",'CobroPago-HelpDesk');

			$queryGenerator = new QueryGenerator('CobroPago', $current_user);
			$queryGenerator->setFields(array('id'));
			$queryGenerator->addReferenceModuleFieldCondition('HelpDesk', 'related_id', 'id', '8953', 'e');
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,"SELECT vtiger_cobropago.cobropagoid FROM vtiger_cobropago  INNER JOIN vtiger_crmentity ON vtiger_cobropago.cobropagoid = vtiger_crmentity.crmid LEFT JOIN vtiger_troubletickets AS vtiger_troubleticketsrelated_id ON vtiger_troubleticketsrelated_id.ticketid=vtiger_cobropago.related_id  WHERE vtiger_crmentity.deleted=0 AND (vtiger_troubleticketsrelated_id.ticketid = '8953')  AND vtiger_cobropago.cobropagoid > 0",'CobroPago-HelpDesk');
		}
	}

	public function testQueryDocuments() {
		global $current_user;
		$queryGenerator = new QueryGenerator('Documents', $current_user);
		$queryGenerator->setFields(array('id','assigned_user_id', 'notes_title','filename'));
		$queryGenerator->addCondition('filename','app','s');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_notes.notesid, vtiger_crmentity.smownerid, vtiger_notes.title, vtiger_notes.filename FROM vtiger_notes  INNER JOIN vtiger_crmentity ON vtiger_notes.notesid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid LEFT JOIN vtiger_attachmentsfolder  ON vtiger_notes.folderid = vtiger_attachmentsfolder.folderid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_notes.filename LIKE 'app%')  AND vtiger_notes.notesid > 0");
		$queryGenerator = new QueryGenerator('Documents', $current_user);
		$queryGenerator->setFields(array('id','assigned_user_id', 'notes_title','filename'));
		$queryGenerator->addReferenceModuleFieldCondition('Users', 'assigned_user_id', 'id', '20x21199', 'e');
		$queryGenerator->addCondition('filename','app','s', QueryGenerator::$AND);
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_notes.notesid, vtiger_crmentity.smownerid, vtiger_notes.title, vtiger_notes.filename FROM vtiger_notes  INNER JOIN vtiger_crmentity ON vtiger_notes.notesid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid LEFT JOIN vtiger_attachmentsfolder  ON vtiger_notes.folderid = vtiger_attachmentsfolder.folderid LEFT JOIN vtiger_users AS vtiger_usersassigned_user_id ON vtiger_usersassigned_user_id.id=vtiger_crmentity.smownerid  WHERE vtiger_crmentity.deleted=0 AND (vtiger_users.id = '20x21199' or vtiger_groups.groupid = '20x21199')  AND ( vtiger_notes.filename LIKE 'app%')  AND vtiger_notes.notesid > 0");
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

		$queryGenerator = new QueryGenerator('Contacts', $current_user);
		$queryGenerator->setFields(array('id','phone','firstname'));
		$queryGenerator->addCondition('phone', '', 'y');
		$query = $queryGenerator->getQuery();
		$this->assertEquals("SELECT vtiger_contactdetails.contactid, vtiger_contactdetails.phone, vtiger_contactdetails.firstname FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_contactdetails.phone IS NULL OR vtiger_contactdetails.phone = '')  AND vtiger_contactdetails.contactid > 0",$query);

		$queryGenerator = new QueryGenerator('Potentials', $current_user);
		$queryGenerator->setFields(array('id','potentialname','Contacts.firstname'));
		$queryGenerator->addReferenceModuleFieldCondition('Contacts', 'related_to', 'phone', '', 'y');
		$query = $queryGenerator->getQuery();
		$this->assertEquals("SELECT vtiger_potential.potentialid, vtiger_potential.potentialname, vtiger_contactdetailsrelated_to.firstname as contactsfirstname FROM vtiger_potential  INNER JOIN vtiger_crmentity ON vtiger_potential.potentialid = vtiger_crmentity.crmid LEFT JOIN vtiger_contactdetails AS vtiger_contactdetailsrelated_to ON vtiger_contactdetailsrelated_to.contactid=vtiger_potential.related_to  WHERE vtiger_crmentity.deleted=0 AND (vtiger_contactdetailsrelated_to.phone IS NULL OR vtiger_contactdetailsrelated_to.phone = '')  AND vtiger_potential.potentialid > 0",$query);
	}

	public function testMultiValueQueryConditions() {
		global $current_user;
		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id','accountname'));
		$queryGenerator->addCondition('employees', '133,144', 'e',$queryGenerator::$AND); // THIS IS AN INCORRECT CONDITION
		$query = $queryGenerator->getQuery();
		// THIS IS INCORRECT SQL DUE TO AN INCORRECT CONDITION
		$this->assertEquals($query,"SELECT vtiger_account.accountid, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_account.employees = 133,144)  AND vtiger_account.accountid > 0");

		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id','accountname'));
		$queryGenerator->addCondition('employees', '133.144', 'e',$queryGenerator::$AND);
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_account.accountid, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_account.employees = 133.144)  AND vtiger_account.accountid > 0");

		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id','accountname'));
		$queryGenerator->addCondition('accountname', '133,144', 'c',$queryGenerator::$AND);
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_account.accountid, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_account.accountname LIKE '%133%' OR vtiger_account.accountname LIKE '%144%')  AND vtiger_account.accountid > 0");

		$queryGenerator = new QueryGenerator('Contacts', $current_user);
		$queryGenerator->setFields(array('id','firstname'));
		$queryGenerator->addCondition('firstname', 'joe', 'e');
		$queryGenerator->addCondition('leadsource', '133,144', 'k', $queryGenerator::$AND);
		$query = $queryGenerator->getQuery();
		$this->assertEquals(
			$query,
			"SELECT vtiger_contactdetails.contactid, vtiger_contactdetails.firstname FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid INNER JOIN vtiger_contactsubdetails ON vtiger_contactdetails.contactid = vtiger_contactsubdetails.contactsubscriptionid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_contactdetails.firstname = 'joe')  AND ( vtiger_contactsubdetails.leadsource IN (
								select translation_key
								from vtiger_cbtranslation
								where locale=\"en_us\" and forpicklist=\"Contacts::leadsource\" and i18n NOT LIKE '%133%') AND vtiger_contactsubdetails.leadsource NOT LIKE '%133%' AND vtiger_contactsubdetails.leadsource IN (
								select translation_key
								from vtiger_cbtranslation
								where locale=\"en_us\" and forpicklist=\"Contacts::leadsource\" and i18n NOT LIKE '%144%') AND vtiger_contactsubdetails.leadsource NOT LIKE '%144%')  AND vtiger_contactdetails.contactid > 0"
		);

		$queryGenerator = new QueryGenerator('Contacts', $current_user);
		$queryGenerator->setFields(array('id','firstname'));
		$queryGenerator->addCondition('firstname', 'joe', 'e');
		$queryGenerator->addCondition('leadsource', '133,144', 'n', $queryGenerator::$AND);
		$query = $queryGenerator->getQuery();
		$this->assertEquals(
			$query,
			"SELECT vtiger_contactdetails.contactid, vtiger_contactdetails.firstname FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid INNER JOIN vtiger_contactsubdetails ON vtiger_contactdetails.contactid = vtiger_contactsubdetails.contactsubscriptionid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_contactdetails.firstname = 'joe')  AND ( vtiger_contactsubdetails.leadsource IN (
								select translation_key
								from vtiger_cbtranslation
								where locale=\"en_us\" and forpicklist=\"Contacts::leadsource\" and i18n <> '133') AND vtiger_contactsubdetails.leadsource <> '133' AND vtiger_contactsubdetails.leadsource IN (
								select translation_key
								from vtiger_cbtranslation
								where locale=\"en_us\" and forpicklist=\"Contacts::leadsource\" and i18n <> '144') AND vtiger_contactsubdetails.leadsource <> '144')  AND vtiger_contactdetails.contactid > 0"
		);

		$queryGenerator = new QueryGenerator('accounts', $current_user);
		$queryGenerator->setFields(array('id','account_no','accountname','accounts.accountname'));
		$queryGenerator->addCondition('assigned_user_id','20x21199,20x1234','c');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_account.accountid, vtiger_account.account_no, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid  WHERE vtiger_crmentity.deleted=0 AND ( (trim(CONCAT(vtiger_users.first_name,' ',vtiger_users.last_name)) LIKE '%20x21199%' or vtiger_groups.groupname LIKE '%20x21199%') OR (trim(CONCAT(vtiger_users.first_name,' ',vtiger_users.last_name)) LIKE '%20x1234%' or vtiger_groups.groupname LIKE '%20x1234%'))  AND vtiger_account.accountid > 0");

		$queryGenerator = new QueryGenerator('accounts', $current_user);
		$queryGenerator->setFields(array('id','account_no','accountname','accounts.accountname'));
		$queryGenerator->addCondition('assigned_user_id','20x21199,20x1234','n');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_account.accountid, vtiger_account.account_no, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid  WHERE vtiger_crmentity.deleted=0 AND ( (trim(CONCAT(vtiger_users.first_name,' ',vtiger_users.last_name)) <> '20x21199' or vtiger_groups.groupname <> '20x21199') AND (trim(CONCAT(vtiger_users.first_name,' ',vtiger_users.last_name)) <> '20x1234' or vtiger_groups.groupname <> '20x1234'))  AND vtiger_account.accountid > 0");

		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id','accountname'));
		$queryGenerator->addCondition('accountname', '133,144', 'k',$queryGenerator::$AND);
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_account.accountid, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_account.accountname NOT LIKE '%133%' AND vtiger_account.accountname NOT LIKE '%144%')  AND vtiger_account.accountid > 0");

		$queryGenerator = new QueryGenerator('Contacts', $current_user);
		$queryGenerator->setFields(array('id','firstname'));
		$queryGenerator->addCondition('firstname', 'joe', 'e');
		$queryGenerator->addCondition('lastname', '133,144', 'n', $queryGenerator::$AND);
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_contactdetails.contactid, vtiger_contactdetails.firstname FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_contactdetails.firstname = 'joe')  AND ( vtiger_contactdetails.lastname <> '133' AND vtiger_contactdetails.lastname <> '144')  AND vtiger_contactdetails.contactid > 0");
	}

	public function testQueryCurrency() {
		global $current_user;
		$holdcuser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x);
		$current_user = $user;
		$queryGenerator = new QueryGenerator('Products', $user);
		$queryGenerator->setFields(array('id','unit_price'));
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_products.productid, vtiger_products.unit_price FROM vtiger_products  INNER JOIN vtiger_crmentity ON vtiger_products.productid = vtiger_crmentity.crmid INNER JOIN vt_tmp_u5 vt_tmp_u5 ON vt_tmp_u5.id = vtiger_crmentity.smownerid  WHERE vtiger_crmentity.deleted=0 AND vtiger_products.productid > 0");
		$queryGenerator = new QueryGenerator('Campaigns', $user);
		$queryGenerator->setFields(array('id','expectedrevenue'));
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_campaign.campaignid, vtiger_campaign.expectedrevenue FROM vtiger_campaign  INNER JOIN vtiger_crmentity ON vtiger_campaign.campaignid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND vtiger_campaign.campaignid > 0");
		/////////
		$queryGenerator = new QueryGenerator('Products', $user);
		$queryGenerator->setFields(array('id','unit_price'));
		$queryGenerator->addCondition('unit_price', '22125', 'g');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_products.productid, vtiger_products.unit_price FROM vtiger_products  INNER JOIN vtiger_crmentity ON vtiger_products.productid = vtiger_crmentity.crmid INNER JOIN vt_tmp_u5 vt_tmp_u5 ON vt_tmp_u5.id = vtiger_crmentity.smownerid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_products.unit_price > 22125)  AND vtiger_products.productid > 0");
		$queryGenerator = new QueryGenerator('Campaigns', $user);
		$queryGenerator->setFields(array('id','expectedrevenue'));
		$queryGenerator->addCondition('expectedrevenue', '22125', 'g');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_campaign.campaignid, vtiger_campaign.expectedrevenue FROM vtiger_campaign  INNER JOIN vtiger_crmentity ON vtiger_campaign.campaignid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_campaign.expectedrevenue > 22125)  AND vtiger_campaign.campaignid > 0");
		$queryGenerator = new QueryGenerator('Products', $user);
		$queryGenerator->setFields(array('id','unit_price'));
		$queryGenerator->addCondition('unit_price', '22125.25', 'g');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_products.productid, vtiger_products.unit_price FROM vtiger_products  INNER JOIN vtiger_crmentity ON vtiger_products.productid = vtiger_crmentity.crmid INNER JOIN vt_tmp_u5 vt_tmp_u5 ON vt_tmp_u5.id = vtiger_crmentity.smownerid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_products.unit_price > 22125.25)  AND vtiger_products.productid > 0");
		$queryGenerator = new QueryGenerator('Campaigns', $user);
		$queryGenerator->setFields(array('id','expectedrevenue'));
		$queryGenerator->addCondition('expectedrevenue', '22125.25', 'g');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_campaign.campaignid, vtiger_campaign.expectedrevenue FROM vtiger_campaign  INNER JOIN vtiger_crmentity ON vtiger_campaign.campaignid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_campaign.expectedrevenue > 22125.25)  AND vtiger_campaign.campaignid > 0");
		/////////
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrcomd0x);
		$current_user = $user;
		$queryGenerator = new QueryGenerator('Products', $user);
		$queryGenerator->setFields(array('id','unit_price'));
		$queryGenerator->addCondition('unit_price', '22125', 'g');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_products.productid, vtiger_products.unit_price FROM vtiger_products  INNER JOIN vtiger_crmentity ON vtiger_products.productid = vtiger_crmentity.crmid INNER JOIN vt_tmp_u6 vt_tmp_u6 ON vt_tmp_u6.id = vtiger_crmentity.smownerid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_products.unit_price > 22125)  AND vtiger_products.productid > 0","currency 72 usrcomd0x no decimals");
		$queryGenerator = new QueryGenerator('Campaigns', $user);
		$queryGenerator->setFields(array('id','expectedrevenue'));
		$queryGenerator->addCondition('expectedrevenue', '22125', 'g');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_campaign.campaignid, vtiger_campaign.expectedrevenue FROM vtiger_campaign  INNER JOIN vtiger_crmentity ON vtiger_campaign.campaignid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_campaign.expectedrevenue > 22125)  AND vtiger_campaign.campaignid > 0","currency 71 usrcomd0x no decimals");
		$queryGenerator = new QueryGenerator('Products', $user);
		$queryGenerator->setFields(array('id','unit_price'));
		$queryGenerator->addCondition('unit_price', '22125,25', 'g');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_products.productid, vtiger_products.unit_price FROM vtiger_products  INNER JOIN vtiger_crmentity ON vtiger_products.productid = vtiger_crmentity.crmid INNER JOIN vt_tmp_u6 vt_tmp_u6 ON vt_tmp_u6.id = vtiger_crmentity.smownerid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_products.unit_price > 22125.25)  AND vtiger_products.productid > 0","currency 72 usrcomd0x decimals");
		$queryGenerator = new QueryGenerator('Campaigns', $user);
		$queryGenerator->setFields(array('id','expectedrevenue'));
		$queryGenerator->addCondition('expectedrevenue', '22125,25', 'g');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_campaign.campaignid, vtiger_campaign.expectedrevenue FROM vtiger_campaign  INNER JOIN vtiger_crmentity ON vtiger_campaign.campaignid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_campaign.expectedrevenue > 22125.25)  AND vtiger_campaign.campaignid > 0","currency 71 usrcomd0x decimals");
		/////////
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrcoma3dot);
		$current_user = $user;
		$queryGenerator = new QueryGenerator('Products', $user);
		$queryGenerator->setFields(array('id','unit_price'));
		$queryGenerator->addCondition('unit_price', '22125', 'g');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_products.productid, vtiger_products.unit_price FROM vtiger_products  INNER JOIN vtiger_crmentity ON vtiger_products.productid = vtiger_crmentity.crmid INNER JOIN vt_tmp_u10 vt_tmp_u10 ON vt_tmp_u10.id = vtiger_crmentity.smownerid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_products.unit_price > 22125)  AND vtiger_products.productid > 0","currency 72 usrcoma3dot no decimals");
		$queryGenerator = new QueryGenerator('Campaigns', $user);
		$queryGenerator->setFields(array('id','expectedrevenue'));
		$queryGenerator->addCondition('expectedrevenue', '22125', 'g');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_campaign.campaignid, vtiger_campaign.expectedrevenue FROM vtiger_campaign  INNER JOIN vtiger_crmentity ON vtiger_campaign.campaignid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_campaign.expectedrevenue > 22125)  AND vtiger_campaign.campaignid > 0","currency 71 usrcoma3dot no decimals");
		$queryGenerator = new QueryGenerator('Products', $user);
		$queryGenerator->setFields(array('id','unit_price'));
		$queryGenerator->addCondition('unit_price', '22.125,25', 'g');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_products.productid, vtiger_products.unit_price FROM vtiger_products  INNER JOIN vtiger_crmentity ON vtiger_products.productid = vtiger_crmentity.crmid INNER JOIN vt_tmp_u10 vt_tmp_u10 ON vt_tmp_u10.id = vtiger_crmentity.smownerid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_products.unit_price > 22125.25)  AND vtiger_products.productid > 0","currency 72 usrcoma3dot decimals");
		$queryGenerator = new QueryGenerator('Campaigns', $user);
		$queryGenerator->setFields(array('id','expectedrevenue'));
		$queryGenerator->addCondition('expectedrevenue', '22.125,25', 'g');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_campaign.campaignid, vtiger_campaign.expectedrevenue FROM vtiger_campaign  INNER JOIN vtiger_crmentity ON vtiger_campaign.campaignid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_campaign.expectedrevenue > 22125.25)  AND vtiger_campaign.campaignid > 0","currency 71 usrcoma3dot decimals");
		/////////
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrdota3comdollar);
		$current_user = $user;
		$queryGenerator = new QueryGenerator('Products', $user);
		$queryGenerator->setFields(array('id','unit_price'));
		$queryGenerator->addCondition('unit_price', '22125', 'g');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_products.productid, vtiger_products.unit_price FROM vtiger_products  INNER JOIN vtiger_crmentity ON vtiger_products.productid = vtiger_crmentity.crmid INNER JOIN vt_tmp_u12 vt_tmp_u12 ON vt_tmp_u12.id = vtiger_crmentity.smownerid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_products.unit_price > 22125)  AND vtiger_products.productid > 0","currency 72 usrdota3comdollar no decimals");
		$queryGenerator = new QueryGenerator('Campaigns', $user);
		$queryGenerator->setFields(array('id','expectedrevenue'));
		$queryGenerator->addCondition('expectedrevenue', '24,337.5', 'g');  // dollars to get 22125 euros
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_campaign.campaignid, vtiger_campaign.expectedrevenue FROM vtiger_campaign  INNER JOIN vtiger_crmentity ON vtiger_campaign.campaignid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_campaign.expectedrevenue > 22125)  AND vtiger_campaign.campaignid > 0","currency 71 usrdota3comdollar no decimals");
		$queryGenerator = new QueryGenerator('Products', $user);
		$queryGenerator->setFields(array('id','unit_price'));
		$queryGenerator->addCondition('unit_price', '22,125.25', 'g');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_products.productid, vtiger_products.unit_price FROM vtiger_products  INNER JOIN vtiger_crmentity ON vtiger_products.productid = vtiger_crmentity.crmid INNER JOIN vt_tmp_u12 vt_tmp_u12 ON vt_tmp_u12.id = vtiger_crmentity.smownerid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_products.unit_price > 22125.25)  AND vtiger_products.productid > 0","currency 72 usrdota3comdollar decimals");
		$queryGenerator = new QueryGenerator('Campaigns', $user);
		$queryGenerator->setFields(array('id','expectedrevenue'));
		$queryGenerator->addCondition('expectedrevenue', '24,337.775', 'g');  // dollars to get 22125.25 euros
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,"SELECT vtiger_campaign.campaignid, vtiger_campaign.expectedrevenue FROM vtiger_campaign  INNER JOIN vtiger_crmentity ON vtiger_campaign.campaignid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_campaign.expectedrevenue > 22125.25)  AND vtiger_campaign.campaignid > 0","currency 71 usrdota3comdollar decimals");
		$current_user = $holdcuser;
	}

	public function testQueryDate() {
		global $current_user;
		$holdcuser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x); // testdmy
		$current_user = $user;
		$queryGenerator = new QueryGenerator('Project', $user);
		$queryGenerator->setFields(array('id','projectname','startdate','targetenddate'));
		$queryGenerator->addCondition('startdate','16-04-2015','b');
		$queryGenerator->addCondition('targetenddate','16-06-2015','a','OR');
		$query = $queryGenerator->getQuery();
		$denorm=$queryGenerator->denormalized;
		if ($denorm) {
			$this->assertEquals($query,"SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.startdate, vtiger_project.targetenddate FROM vtiger_project  WHERE vtiger_project.mydeleted=0 AND ( vtiger_project.startdate < '2015-04-16')  OR ( vtiger_project.targetenddate > '2015-06-16')  AND vtiger_project.projectid > 0","testdmy");
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','startdate','targetenddate'));
			$queryGenerator->addCondition('startdate','04-16-2015','b');
			$queryGenerator->addCondition('targetenddate','06-16-2015','a','OR');
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,"SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.startdate, vtiger_project.targetenddate FROM vtiger_project  WHERE vtiger_project.mydeleted=0 AND ( vtiger_project.startdate < '2015-16-04')  OR ( vtiger_project.targetenddate > '2015-16-06')  AND vtiger_project.projectid > 0","testdmy WRONG");
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','startdate','targetenddate'));
			$queryGenerator->addCondition('startdate',array(0=>'16-04-2015',1=>'16-06-2015'), 'bw');
			$query = $queryGenerator->getQuery();
			$sqlresult = "SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.startdate, vtiger_project.targetenddate FROM vtiger_project  WHERE vtiger_project.mydeleted=0 AND ( vtiger_project.startdate BETWEEN '2015-04-16' AND '2015-06-16')  AND vtiger_project.projectid > 0";
			$this->assertEquals($sqlresult,$query,"date between testdmy");
			/////////
			$user = new Users();
			$user->retrieveCurrentUserInfoFromFile($this->usrcomd0x); // testmdy
			$current_user = $user;
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','startdate','targetenddate'));
			$queryGenerator->addCondition('startdate','04-16-2015','b');
			$queryGenerator->addCondition('targetenddate','06-16-2015','a','OR');
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,"SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.startdate, vtiger_project.targetenddate FROM vtiger_project  WHERE vtiger_project.mydeleted=0 AND ( vtiger_project.startdate < '2015-04-16')  OR ( vtiger_project.targetenddate > '2015-06-16')  AND vtiger_project.projectid > 0","testmdy");
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','startdate','targetenddate'));
			$queryGenerator->addCondition('startdate','16-04-2015','b');
			$queryGenerator->addCondition('targetenddate','16-06-2015','a','OR');
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,"SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.startdate, vtiger_project.targetenddate FROM vtiger_project  WHERE vtiger_project.mydeleted=0 AND ( vtiger_project.startdate < '2015-16-04')  OR ( vtiger_project.targetenddate > '2015-16-06')  AND vtiger_project.projectid > 0","testmdy WRONG");
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','startdate','targetenddate'));
			$queryGenerator->addCondition('startdate',array(0=>'04-16-2015',1=>'06-16-2015'), 'bw');
			$query = $queryGenerator->getQuery();
			$sqlresult = "SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.startdate, vtiger_project.targetenddate FROM vtiger_project  WHERE vtiger_project.mydeleted=0 AND ( vtiger_project.startdate BETWEEN '2015-04-16' AND '2015-06-16')  AND vtiger_project.projectid > 0";
			$this->assertEquals($sqlresult,$query,"date between testmdy");
			/////////
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','startdate','targetenddate'));
			$queryGenerator->addCondition('startdate',array(0=>'04-21-2017',1=>'05-02-2017'), 'bw');
			$query = $queryGenerator->getQuery();
			$sqlresult = "SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.startdate, vtiger_project.targetenddate FROM vtiger_project  WHERE vtiger_project.mydeleted=0 AND ( vtiger_project.startdate BETWEEN '2017-04-21' AND '2017-05-02')  AND vtiger_project.projectid > 0";
			$this->assertEquals($sqlresult,$query,"date july between testmdy");
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','startdate','targetenddate'));
			$queryGenerator->addCondition('startdate',array(0=>'07-01-2017',1=>'07-31-2017'), 'bw');
			$query = $queryGenerator->getQuery();
			$sqlresult = "SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.startdate, vtiger_project.targetenddate FROM vtiger_project  WHERE vtiger_project.mydeleted=0 AND ( vtiger_project.startdate BETWEEN '2017-07-01' AND '2017-07-31')  AND vtiger_project.projectid > 0";
			$this->assertEquals($sqlresult,$query,"date july between testmdy");
			/////////
			$user = new Users();
			$user->retrieveCurrentUserInfoFromFile($this->usrdotd3com); // testymd
			$current_user = $user;
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','startdate','targetenddate'));
			$queryGenerator->addCondition('startdate','2015-04-16','b');
			$queryGenerator->addCondition('targetenddate','2015-06-16','a','OR');
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,"SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.startdate, vtiger_project.targetenddate FROM vtiger_project  WHERE vtiger_project.mydeleted=0 AND ( vtiger_project.startdate < '2015-04-16')  OR ( vtiger_project.targetenddate > '2015-06-16')  AND vtiger_project.projectid > 0","testymd");
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','startdate','targetenddate'));
			$queryGenerator->addCondition('startdate',array(0=>'2015-04-16',1=>'2015-06-16'), 'bw');
			$query = $queryGenerator->getQuery();
			$sqlresult = "SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.startdate, vtiger_project.targetenddate FROM vtiger_project  WHERE vtiger_project.mydeleted=0 AND ( vtiger_project.startdate BETWEEN '2015-04-16' AND '2015-06-16')  AND vtiger_project.projectid > 0";
			$this->assertEquals($sqlresult,$query,"date between testymd");
			/////////
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','createdtime'));
			$queryGenerator->addCondition('createdtime','2015-04-16 10:00','b');
			$queryGenerator->addCondition('createdtime','2015-06-16 08:00','a','OR');
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,"SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.mycreatedtime FROM vtiger_project  WHERE vtiger_project.mydeleted=0 AND ( vtiger_project.mycreatedtime < '2015-04-16 10:00:00')  OR ( vtiger_project.mycreatedtime > '2015-06-16 08:00:00')  AND vtiger_project.projectid > 0","testtz");
			$user = new Users();
			$user->retrieveCurrentUserInfoFromFile($this->usrcoma3dot); // testtz
			$current_user = $user;
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','createdtime'));
			$queryGenerator->addCondition('createdtime','2015-04-16 10:00','b');
			$queryGenerator->addCondition('createdtime','2015-06-16 08:00','a','OR');
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,"SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.mycreatedtime FROM vtiger_project  WHERE vtiger_project.mydeleted=0 AND ( vtiger_project.mycreatedtime < '2015-04-16 08:00:00')  OR ( vtiger_project.mycreatedtime > '2015-06-16 06:00:00')  AND vtiger_project.projectid > 0","testtz");
			$current_user = $holdcuser;
			$queryGenerator = new QueryGenerator('Project', $current_user);
			$queryGenerator->setFields(array('id','projectname','createdtime'));
			$queryGenerator->addCondition('startdate','2015-04-16','g');
			$query = $queryGenerator->getQuery();
			$this->assertEquals("SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.mycreatedtime FROM vtiger_project  WHERE vtiger_project.mydeleted=0 AND ( vtiger_project.startdate > '2015-04-16')  AND vtiger_project.projectid > 0",$query,"test incompatible fecha g Ymd");
			$queryGenerator = new QueryGenerator('Project', $current_user);
			$queryGenerator->setFields(array('id','projectname','createdtime'));
			$queryGenerator->addCondition('startdate','1997-04-04','a');
			$query = $queryGenerator->getQuery();
			$this->assertEquals("SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.mycreatedtime FROM vtiger_project  WHERE vtiger_project.mydeleted=0 AND ( vtiger_project.startdate > '1997-04-04')  AND vtiger_project.projectid > 0",$query,"test old date ymd");
			$holduser = $current_user;
			$user = new Users();
			$user->retrieveCurrentUserInfoFromFile($this->usrdota0x);
			$current_user = $user;
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','createdtime'));
			$queryGenerator->addCondition('startdate','16-04-2015','g');
			$query = $queryGenerator->getQuery();
			$this->assertEquals("SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.mycreatedtime FROM vtiger_project  WHERE vtiger_project.mydeleted=0 AND ( vtiger_project.startdate > '2015-04-16')  AND vtiger_project.projectid > 0",$query,"test incompatible fecha g dmY");
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','createdtime'));
			$queryGenerator->addCondition('startdate','16-04-2015','a');
			$query = $queryGenerator->getQuery();
			$this->assertEquals("SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.mycreatedtime FROM vtiger_project  WHERE vtiger_project.mydeleted=0 AND ( vtiger_project.startdate > '2015-04-16')  AND vtiger_project.projectid > 0",$query,"test incompatible fecha g dmY");
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','createdtime'));
			$queryGenerator->addCondition('startdate','04-04-1997','a');
			$query = $queryGenerator->getQuery();
			$this->assertEquals("SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.mycreatedtime FROM vtiger_project  WHERE vtiger_project.mydeleted=0 AND ( vtiger_project.startdate > '1997-04-04')  AND vtiger_project.projectid > 0",$query,"test incompatible fecha g dmY");
			$current_user = $holduser;
		} else {
			$this->assertEquals($query,"SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.startdate, vtiger_project.targetenddate FROM vtiger_project  INNER JOIN vtiger_crmentity ON vtiger_project.projectid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_project.startdate < '2015-04-16')  OR ( vtiger_project.targetenddate > '2015-06-16')  AND vtiger_project.projectid > 0","testdmy");
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','startdate','targetenddate'));
			$queryGenerator->addCondition('startdate','04-16-2015','b');
			$queryGenerator->addCondition('targetenddate','06-16-2015','a','OR');
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,"SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.startdate, vtiger_project.targetenddate FROM vtiger_project  INNER JOIN vtiger_crmentity ON vtiger_project.projectid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_project.startdate < '2015-16-04')  OR ( vtiger_project.targetenddate > '2015-16-06')  AND vtiger_project.projectid > 0","testdmy WRONG");
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','startdate','targetenddate'));
			$queryGenerator->addCondition('startdate',array(0=>'16-04-2015',1=>'16-06-2015'), 'bw');
			$query = $queryGenerator->getQuery();
			$sqlresult = "SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.startdate, vtiger_project.targetenddate FROM vtiger_project  INNER JOIN vtiger_crmentity ON vtiger_project.projectid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_project.startdate BETWEEN '2015-04-16' AND '2015-06-16')  AND vtiger_project.projectid > 0";
			$this->assertEquals($sqlresult,$query,"date between testdmy");
			/////////
			$user = new Users();
			$user->retrieveCurrentUserInfoFromFile($this->usrcomd0x); // testmdy
			$current_user = $user;
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','startdate','targetenddate'));
			$queryGenerator->addCondition('startdate','04-16-2015','b');
			$queryGenerator->addCondition('targetenddate','06-16-2015','a','OR');
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,"SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.startdate, vtiger_project.targetenddate FROM vtiger_project  INNER JOIN vtiger_crmentity ON vtiger_project.projectid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_project.startdate < '2015-04-16')  OR ( vtiger_project.targetenddate > '2015-06-16')  AND vtiger_project.projectid > 0","testmdy");
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','startdate','targetenddate'));
			$queryGenerator->addCondition('startdate','16-04-2015','b');
			$queryGenerator->addCondition('targetenddate','16-06-2015','a','OR');
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,"SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.startdate, vtiger_project.targetenddate FROM vtiger_project  INNER JOIN vtiger_crmentity ON vtiger_project.projectid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_project.startdate < '2015-16-04')  OR ( vtiger_project.targetenddate > '2015-16-06')  AND vtiger_project.projectid > 0","testmdy WRONG");
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','startdate','targetenddate'));
			$queryGenerator->addCondition('startdate',array(0=>'04-16-2015',1=>'06-16-2015'), 'bw');
			$query = $queryGenerator->getQuery();
			$sqlresult = "SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.startdate, vtiger_project.targetenddate FROM vtiger_project  INNER JOIN vtiger_crmentity ON vtiger_project.projectid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_project.startdate BETWEEN '2015-04-16' AND '2015-06-16')  AND vtiger_project.projectid > 0";
			$this->assertEquals($sqlresult,$query,"date between testmdy");
			/////////
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','startdate','targetenddate'));
			$queryGenerator->addCondition('startdate',array(0=>'04-21-2017',1=>'05-02-2017'), 'bw');
			$query = $queryGenerator->getQuery();
			$sqlresult = "SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.startdate, vtiger_project.targetenddate FROM vtiger_project  INNER JOIN vtiger_crmentity ON vtiger_project.projectid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_project.startdate BETWEEN '2017-04-21' AND '2017-05-02')  AND vtiger_project.projectid > 0";
			$this->assertEquals($sqlresult,$query,"date july between testmdy");
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','startdate','targetenddate'));
			$queryGenerator->addCondition('startdate',array(0=>'07-01-2017',1=>'07-31-2017'), 'bw');
			$query = $queryGenerator->getQuery();
			$sqlresult = "SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.startdate, vtiger_project.targetenddate FROM vtiger_project  INNER JOIN vtiger_crmentity ON vtiger_project.projectid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_project.startdate BETWEEN '2017-07-01' AND '2017-07-31')  AND vtiger_project.projectid > 0";
			$this->assertEquals($sqlresult,$query,"date july between testmdy");
			/////////
			$user = new Users();
			$user->retrieveCurrentUserInfoFromFile($this->usrdotd3com); // testymd
			$current_user = $user;
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','startdate','targetenddate'));
			$queryGenerator->addCondition('startdate','2015-04-16','b');
			$queryGenerator->addCondition('targetenddate','2015-06-16','a','OR');
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,"SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.startdate, vtiger_project.targetenddate FROM vtiger_project  INNER JOIN vtiger_crmentity ON vtiger_project.projectid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_project.startdate < '2015-04-16')  OR ( vtiger_project.targetenddate > '2015-06-16')  AND vtiger_project.projectid > 0","testymd");
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','startdate','targetenddate'));
			$queryGenerator->addCondition('startdate',array(0=>'2015-04-16',1=>'2015-06-16'), 'bw');
			$query = $queryGenerator->getQuery();
			$sqlresult = "SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_project.startdate, vtiger_project.targetenddate FROM vtiger_project  INNER JOIN vtiger_crmentity ON vtiger_project.projectid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_project.startdate BETWEEN '2015-04-16' AND '2015-06-16')  AND vtiger_project.projectid > 0";
			$this->assertEquals($sqlresult,$query,"date between testymd");
			/////////
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','createdtime'));
			$queryGenerator->addCondition('createdtime','2015-04-16 10:00','b');
			$queryGenerator->addCondition('createdtime','2015-06-16 08:00','a','OR');
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,"SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_crmentity.createdtime FROM vtiger_project  INNER JOIN vtiger_crmentity ON vtiger_project.projectid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_crmentity.createdtime < '2015-04-16 10:00:00')  OR ( vtiger_crmentity.createdtime > '2015-06-16 08:00:00')  AND vtiger_project.projectid > 0","testtz");
			$user = new Users();
			$user->retrieveCurrentUserInfoFromFile($this->usrcoma3dot); // testtz
			$current_user = $user;
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','createdtime'));
			$queryGenerator->addCondition('createdtime','2015-04-16 10:00','b');
			$queryGenerator->addCondition('createdtime','2015-06-16 08:00','a','OR');
			$query = $queryGenerator->getQuery();
			$this->assertEquals($query,"SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_crmentity.createdtime FROM vtiger_project  INNER JOIN vtiger_crmentity ON vtiger_project.projectid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_crmentity.createdtime < '2015-04-16 08:00:00')  OR ( vtiger_crmentity.createdtime > '2015-06-16 06:00:00')  AND vtiger_project.projectid > 0","testtz");
			$current_user = $holdcuser;
			$queryGenerator = new QueryGenerator('Project', $current_user);
			$queryGenerator->setFields(array('id','projectname','createdtime'));
			$queryGenerator->addCondition('startdate','2015-04-16','g');
			$query = $queryGenerator->getQuery();
			$this->assertEquals("SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_crmentity.createdtime FROM vtiger_project  INNER JOIN vtiger_crmentity ON vtiger_project.projectid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_project.startdate > '2015-04-16')  AND vtiger_project.projectid > 0",$query,"test incompatible fecha g Ymd");
			$queryGenerator = new QueryGenerator('Project', $current_user);
			$queryGenerator->setFields(array('id','projectname','createdtime'));
			$queryGenerator->addCondition('startdate','1997-04-04','a');
			$query = $queryGenerator->getQuery();
			$this->assertEquals("SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_crmentity.createdtime FROM vtiger_project  INNER JOIN vtiger_crmentity ON vtiger_project.projectid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_project.startdate > '1997-04-04')  AND vtiger_project.projectid > 0",$query,"test old date ymd");
			$holduser = $current_user;
			$user = new Users();
			$user->retrieveCurrentUserInfoFromFile($this->usrdota0x);
			$current_user = $user;
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','createdtime'));
			$queryGenerator->addCondition('startdate','16-04-2015','g');
			$query = $queryGenerator->getQuery();
			$this->assertEquals("SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_crmentity.createdtime FROM vtiger_project  INNER JOIN vtiger_crmentity ON vtiger_project.projectid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_project.startdate > '2015-04-16')  AND vtiger_project.projectid > 0",$query,"test incompatible fecha g dmY");
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','createdtime'));
			$queryGenerator->addCondition('startdate','16-04-2015','a');
			$query = $queryGenerator->getQuery();
			$this->assertEquals("SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_crmentity.createdtime FROM vtiger_project  INNER JOIN vtiger_crmentity ON vtiger_project.projectid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_project.startdate > '2015-04-16')  AND vtiger_project.projectid > 0",$query,"test incompatible fecha g dmY");
			$queryGenerator = new QueryGenerator('Project', $user);
			$queryGenerator->setFields(array('id','projectname','createdtime'));
			$queryGenerator->addCondition('startdate','04-04-1997','a');
			$query = $queryGenerator->getQuery();
			$this->assertEquals("SELECT vtiger_project.projectid, vtiger_project.projectname, vtiger_crmentity.createdtime FROM vtiger_project  INNER JOIN vtiger_crmentity ON vtiger_project.projectid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_project.startdate > '1997-04-04')  AND vtiger_project.projectid > 0",$query,"test incompatible fecha g dmY");
			$current_user = $holduser;
		}
	}

	public function testQueryBirthDate() {
		global $current_user;
		$holdcuser = $current_user;
		$sqlresult = "SELECT vtiger_contactdetails.contactid, vtiger_contactdetails.firstname, vtiger_contactsubdetails.birthday FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid INNER JOIN vtiger_contactsubdetails ON vtiger_contactdetails.contactid = vtiger_contactsubdetails.contactsubscriptionid  WHERE vtiger_crmentity.deleted=0 AND ( DATE_FORMAT(vtiger_contactsubdetails.birthday,'%m%d') < DATE_FORMAT('2015-04-16', '%m%d'))  OR ( DATE_FORMAT(vtiger_contactsubdetails.birthday,'%m%d') > DATE_FORMAT('2015-06-16', '%m%d'))  AND vtiger_contactdetails.contactid > 0";
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrdotd3com); // testymd
		$current_user = $user;
		$queryGenerator = new QueryGenerator('Contacts', $user);
		$queryGenerator->setFields(array('id','firstname','birthday'));
		$queryGenerator->addCondition('birthday','2015-04-16','b');
		$queryGenerator->addCondition('birthday','2015-06-16','a','OR');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,$sqlresult,"Birthday testymd");
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x); // testdmy
		$current_user = $user;
		$queryGenerator = new QueryGenerator('Contacts', $user);
		$queryGenerator->setFields(array('id','firstname','birthday'));
		$queryGenerator->addCondition('birthday','16-04-2015','b');
		$queryGenerator->addCondition('birthday','16-06-2015','a','OR');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,$sqlresult,"Birthday testdmy");
		$user->retrieveCurrentUserInfoFromFile($this->usrcomd0x); // testmdy
		$current_user = $user;
		$queryGenerator = new QueryGenerator('Contacts', $user);
		$queryGenerator->setFields(array('id','firstname','birthday'));
		$queryGenerator->addCondition('birthday','04-16-2015','b');
		$queryGenerator->addCondition('birthday','06-16-2015','a','OR');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,$sqlresult,"Birthday testmdy");
		//////////////////
		$sqlresult = "SELECT vtiger_contactdetails.contactid, vtiger_contactdetails.firstname, vtiger_contactsubdetails.birthday FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid INNER JOIN vtiger_contactsubdetails ON vtiger_contactdetails.contactid = vtiger_contactsubdetails.contactsubscriptionid  WHERE vtiger_crmentity.deleted=0 AND ( DATE_FORMAT(vtiger_contactsubdetails.birthday,'%m%d') BETWEEN DATE_FORMAT('2006-01-21', '%m%d') AND DATE_FORMAT('2016-01-11', '%m%d'))  AND vtiger_contactdetails.contactid > 0";
		$user->retrieveCurrentUserInfoFromFile($this->usrdotd3com); // testymd
		$current_user = $user;
		$queryGenerator = new QueryGenerator('Contacts', $user);
		$queryGenerator->setFields(array('id','firstname','birthday'));
		$queryGenerator->addCondition('birthday',array(0=>'2006-01-21',1=>'2016-01-11'), 'bw');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,$sqlresult,"Birthday between testymd");
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x); // testdmy
		$current_user = $user;
		$queryGenerator = new QueryGenerator('Contacts', $user);
		$queryGenerator->setFields(array('id','firstname','birthday'));
		$queryGenerator->addCondition('birthday',array(0=>'21-01-2006',1=>'11-01-2016'), 'bw');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,$sqlresult,"Birthday testdmy");
		$user->retrieveCurrentUserInfoFromFile($this->usrcomd0x); // testmdy
		$current_user = $user;
		$queryGenerator = new QueryGenerator('Contacts', $user);
		$queryGenerator->setFields(array('id','firstname','birthday'));
		$queryGenerator->addCondition('birthday',array(0=>'01-21-2006',1=>'01-11-2016'), 'bw');
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,$sqlresult,"Birthday testmdy");
		$current_user = $holdcuser;
	}

	public function testQueryStringWithCommas() {
		global $current_user;
		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id','accountname'));
		$queryGenerator->addCondition('accountname','Hermar Inc','e');
		$query = $queryGenerator->getQuery();
		$sqlresult = "SELECT vtiger_account.accountid, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_account.accountname = 'Hermar Inc')  AND vtiger_account.accountid > 0";
		$this->assertEquals($sqlresult,$query,"String no commas");
		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id','accountname'));
		$queryGenerator->addCondition('accountname','Hermar, Inc','e');
		$query = $queryGenerator->getQuery();
		$sqlresult = "SELECT vtiger_account.accountid, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_account.accountname = 'Hermar, Inc')  AND vtiger_account.accountid > 0";
		$this->assertEquals($sqlresult,$query,"String with commas");
	}

	public function testQueryHasConditions() {
		global $current_user;
		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id','accountname'));
		$this->assertFalse($queryGenerator->hasWhereConditions(),'Does not have conditions');
		$queryGenerator->addCondition('accountname','Hermar Inc','e');
		$this->assertTrue($queryGenerator->hasWhereConditions(),'Has conditions');
		$queryGenerator->addCondition('accountname','Hermar, Inc','e',QueryGenerator::$OR);
		$this->assertTrue($queryGenerator->hasWhereConditions(),'Has conditions');
		$query = $queryGenerator->getQuery();
		$sqlresult = "SELECT vtiger_account.accountid, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_account.accountname = 'Hermar Inc')  OR ( vtiger_account.accountname = 'Hermar, Inc')  AND vtiger_account.accountid > 0";
		$this->assertEquals($sqlresult,$query,"Query Has Conditions");
	}

	public function testQueryInitCustomView() {
		global $current_user;
		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->initForCustomViewById(5); // Prospect Accounts
		$query = $queryGenerator->getQuery();
		$sqlresult = "SELECT vtiger_account.accountname, vtiger_account.phone, vtiger_account.website, vtiger_account.rating, vtiger_crmentity.smownerid, vtiger_account.accountid FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_account.account_type IN (
								select translation_key
								from vtiger_cbtranslation
								where locale=\"en_us\" and forpicklist=\"Accounts::accounttype\" and i18n = 'Prospect') OR vtiger_account.account_type = 'Prospect') )) AND vtiger_account.accountid > 0";
		$this->assertEquals($sqlresult, $query, "Init CV Prospect Accounts (5)");
		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->initForCustomViewById(5); // Prospect Accounts
		$queryGenerator->addCondition('accountname','Hermar, Inc','e',QueryGenerator::$AND);
		$query = $queryGenerator->getQuery();
		$sqlresult = "SELECT vtiger_account.accountname, vtiger_account.phone, vtiger_account.website, vtiger_account.rating, vtiger_crmentity.smownerid, vtiger_account.accountid FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_account.account_type IN (
								select translation_key
								from vtiger_cbtranslation
								where locale=\"en_us\" and forpicklist=\"Accounts::accounttype\" and i18n = 'Prospect') OR vtiger_account.account_type = 'Prospect') )) AND ( vtiger_account.accountname = 'Hermar, Inc')  AND vtiger_account.accountid > 0";
		$this->assertEquals($sqlresult, $query, "Init CV Prospect Accounts (5)");
	}

	public function testQueryJoinWithInitialGlue() {
		global $current_user;
		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id','accountname'));
		$queryGenerator->startGroup($queryGenerator::$OR);
		$queryGenerator->addCondition('accountname','Hermar Inc','e');
		$queryGenerator->endGroup();
		$query = $queryGenerator->getQuery();
		$sqlresult = "SELECT vtiger_account.accountid, vtiger_account.accountname FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (( vtiger_account.accountname = 'Hermar Inc') ) AND vtiger_account.accountid > 0";
		$this->assertEquals($sqlresult,$query,"Query With Initial OR");
	}

	public function testQueryOnSeparateSpecialTables() {
		global $current_user;
		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id','bill_street','ship_country'));
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,'SELECT vtiger_account.accountid, vtiger_accountbillads.bill_street, vtiger_accountshipads.ship_country FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid INNER JOIN vtiger_accountbillads ON vtiger_account.accountid = vtiger_accountbillads.accountaddressid INNER JOIN vtiger_accountshipads ON vtiger_account.accountid = vtiger_accountshipads.accountaddressid  WHERE vtiger_crmentity.deleted=0 AND vtiger_account.accountid > 0');
		$queryGenerator = new QueryGenerator('Invoice', $current_user);
		$queryGenerator->setFields(array('id','bill_street','ship_country'));
		$query = $queryGenerator->getQuery();
		$this->assertEquals($query,'SELECT vtiger_invoice.invoiceid, vtiger_invoicebillads.bill_street, vtiger_invoiceshipads.ship_country FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid INNER JOIN vtiger_invoicebillads ON vtiger_invoice.invoiceid = vtiger_invoicebillads.invoicebilladdressid INNER JOIN vtiger_invoiceshipads ON vtiger_invoice.invoiceid = vtiger_invoiceshipads.invoiceshipaddressid  WHERE vtiger_crmentity.deleted=0 AND vtiger_invoice.invoiceid > 0');
	}

	public function testAsteriskQuery() {
		global $current_user;
		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('*'));
		$query = $queryGenerator->getQuery();
		$query = $this->sortQueryColumns($query);
		$this->assertEquals('SELECT vtiger_account.account_no,vtiger_account.account_type,vtiger_account.accountid,vtiger_account.accountname,vtiger_account.annualrevenue,vtiger_account.convertedfromlead,vtiger_account.email1,vtiger_account.email2,vtiger_account.emailoptout,vtiger_account.employees,vtiger_account.fax,vtiger_account.industry,vtiger_account.isconvertedfromlead,vtiger_account.notify_owner,vtiger_account.otherphone,vtiger_account.ownership,vtiger_account.parentid,vtiger_account.phone,vtiger_account.rating,vtiger_account.siccode,vtiger_account.tickersymbol,vtiger_account.website,vtiger_accountbillads.bill_city,vtiger_accountbillads.bill_code,vtiger_accountbillads.bill_country,vtiger_accountbillads.bill_pobox,vtiger_accountbillads.bill_state,vtiger_accountbillads.bill_street,vtiger_accountscf.cf_718,vtiger_accountscf.cf_719,vtiger_accountscf.cf_720,vtiger_accountscf.cf_721,vtiger_accountscf.cf_722,vtiger_accountscf.cf_723,vtiger_accountscf.cf_724,vtiger_accountscf.cf_725,vtiger_accountscf.cf_726,vtiger_accountscf.cf_727,vtiger_accountscf.cf_728,vtiger_accountscf.cf_729,vtiger_accountscf.cf_730,vtiger_accountscf.cf_731,vtiger_accountscf.cf_732,vtiger_accountshipads.ship_city,vtiger_accountshipads.ship_code,vtiger_accountshipads.ship_country,vtiger_accountshipads.ship_pobox,vtiger_accountshipads.ship_state,vtiger_accountshipads.ship_street,vtiger_crmentity.createdtime,vtiger_crmentity.description,vtiger_crmentity.modifiedby,vtiger_crmentity.modifiedtime,vtiger_crmentity.smcreatorid,vtiger_crmentity.smownerid FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid INNER JOIN vtiger_accountscf ON vtiger_account.accountid = vtiger_accountscf.accountid INNER JOIN vtiger_accountbillads ON vtiger_account.accountid = vtiger_accountbillads.accountaddressid INNER JOIN vtiger_accountshipads ON vtiger_account.accountid = vtiger_accountshipads.accountaddressid LEFT JOIN vtiger_users AS vtiger_usersmodifiedby  ON vtiger_crmentity.modifiedby = vtiger_usersmodifiedby.id LEFT JOIN vtiger_groups AS vtiger_groupsmodifiedby  ON vtiger_crmentity.modifiedby = vtiger_groupsmodifiedby.groupid LEFT JOIN vtiger_users AS vtiger_userscreated_user_id  ON vtiger_crmentity.smcreatorid = vtiger_userscreated_user_id.id LEFT JOIN vtiger_groups AS vtiger_groupscreated_user_id  ON vtiger_crmentity.smcreatorid = vtiger_groupscreated_user_id.groupid  WHERE vtiger_crmentity.deleted=0 AND vtiger_account.accountid > 0', $query);
		$queryGenerator->setFields(array('id','*','bill_street'));
		$query = $queryGenerator->getQuery();
		$query = $this->sortQueryColumns($query);
		$this->assertEquals('SELECT vtiger_account.account_no,vtiger_account.account_type,vtiger_account.accountid,vtiger_account.accountname,vtiger_account.annualrevenue,vtiger_account.convertedfromlead,vtiger_account.email1,vtiger_account.email2,vtiger_account.emailoptout,vtiger_account.employees,vtiger_account.fax,vtiger_account.industry,vtiger_account.isconvertedfromlead,vtiger_account.notify_owner,vtiger_account.otherphone,vtiger_account.ownership,vtiger_account.parentid,vtiger_account.phone,vtiger_account.rating,vtiger_account.siccode,vtiger_account.tickersymbol,vtiger_account.website,vtiger_accountbillads.bill_city,vtiger_accountbillads.bill_code,vtiger_accountbillads.bill_country,vtiger_accountbillads.bill_pobox,vtiger_accountbillads.bill_state,vtiger_accountbillads.bill_street,vtiger_accountscf.cf_718,vtiger_accountscf.cf_719,vtiger_accountscf.cf_720,vtiger_accountscf.cf_721,vtiger_accountscf.cf_722,vtiger_accountscf.cf_723,vtiger_accountscf.cf_724,vtiger_accountscf.cf_725,vtiger_accountscf.cf_726,vtiger_accountscf.cf_727,vtiger_accountscf.cf_728,vtiger_accountscf.cf_729,vtiger_accountscf.cf_730,vtiger_accountscf.cf_731,vtiger_accountscf.cf_732,vtiger_accountshipads.ship_city,vtiger_accountshipads.ship_code,vtiger_accountshipads.ship_country,vtiger_accountshipads.ship_pobox,vtiger_accountshipads.ship_state,vtiger_accountshipads.ship_street,vtiger_crmentity.createdtime,vtiger_crmentity.description,vtiger_crmentity.modifiedby,vtiger_crmentity.modifiedtime,vtiger_crmentity.smcreatorid,vtiger_crmentity.smownerid FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid INNER JOIN vtiger_accountscf ON vtiger_account.accountid = vtiger_accountscf.accountid INNER JOIN vtiger_accountbillads ON vtiger_account.accountid = vtiger_accountbillads.accountaddressid INNER JOIN vtiger_accountshipads ON vtiger_account.accountid = vtiger_accountshipads.accountaddressid LEFT JOIN vtiger_users AS vtiger_usersmodifiedby  ON vtiger_crmentity.modifiedby = vtiger_usersmodifiedby.id LEFT JOIN vtiger_groups AS vtiger_groupsmodifiedby  ON vtiger_crmentity.modifiedby = vtiger_groupsmodifiedby.groupid LEFT JOIN vtiger_users AS vtiger_userscreated_user_id  ON vtiger_crmentity.smcreatorid = vtiger_userscreated_user_id.id LEFT JOIN vtiger_groups AS vtiger_groupscreated_user_id  ON vtiger_crmentity.smcreatorid = vtiger_groupscreated_user_id.groupid  WHERE vtiger_crmentity.deleted=0 AND vtiger_account.accountid > 0', $query);
	}

	public function testgetOrderByColumn() {
		global $current_user;
		$queryGenerator = new QueryGenerator('Accounts', $current_user);
		$queryGenerator->setFields(array('id','bill_street','ship_country'));
		$queryOB = $queryGenerator->getOrderByColumn('bill_street');
		$this->assertEquals($queryOB,'vtiger_accountbillads.bill_street');
		$queryOB = $queryGenerator->getOrderByColumn('assigned_user_id');
		$this->assertEquals($queryOB,'COALESCE(CONCAT(vtiger_users.first_name,vtiger_users.last_name),vtiger_groups.groupname)');
		///////////////
		$queryGenerator = new QueryGenerator('Documents', $current_user);
		$queryGenerator->setFields(array('id','filename'));
		$queryOB = $queryGenerator->getOrderByColumn('folderid');
		$this->assertEquals($queryOB,'vtiger_attachmentsfolder.foldername');
		///////////////
		$queryGenerator = new QueryGenerator('Project', $current_user);
		$queryGenerator->setFields(array('id','projectname','projectstatus'));
		$queryOB = $queryGenerator->getOrderByColumn('projectstatus');
		$this->assertEquals($queryOB,'vtiger_project.projectstatus');
		$queryGenerator->addWhereField('linktoaccountscontacts');
		$queryOB = $queryGenerator->getOrderByColumn('linktoaccountscontacts');
		$this->assertEquals($queryOB,"COALESCE(vtiger_account.accountname,concat(vtiger_contactdetails.firstname,' ',vtiger_contactdetails.lastname))");
		///////////////
		$queryGenerator = new QueryGenerator('Invoice', $current_user);
		$queryGenerator->setFields(array('id','bill_street','ship_country'));
		$queryOB = $queryGenerator->getOrderByColumn('bill_street');
		$this->assertEquals($queryOB,'vtiger_invoicebillads.bill_street');
		$queryGenerator->addWhereField('currency_id');
		$queryOB = $queryGenerator->getOrderByColumn('currency_id');
		$this->assertEquals($queryOB,'vtiger_currency_info.currency_name');
		$queryGenerator->addWhereField('account_id');
		$queryOB = $queryGenerator->getOrderByColumn('account_id');
		$this->assertEquals($queryOB,'vtiger_account.accountname');
		///////////////
		$queryOB = $queryGenerator->getOrderByColumn('smownerid');
		$this->assertEquals($queryOB,'COALESCE(CONCAT(vtiger_users.first_name,vtiger_users.last_name),vtiger_groups.groupname)');
		$queryOB = $queryGenerator->getOrderByColumn('smcreatorid');
		$this->assertEquals($queryOB,"CONCAT(vtiger_userscreated_user_id.first_name,' ',vtiger_userscreated_user_id.last_name)");
	}
}
?>
