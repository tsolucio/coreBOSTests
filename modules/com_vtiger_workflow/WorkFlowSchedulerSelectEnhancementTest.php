<?php
/*************************************************************************************************
 * Copyright 2018 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

include_once 'modules/com_vtiger_workflow/include.inc';
include_once 'modules/com_vtiger_workflow/WorkFlowScheduler.php';

class WorkFlowSchedulerSelectEnhancementTest extends TestCase {

	private $defaultWF = array(
		'workflow_id' => 0,
		'module_name' => 'Accounts',
		'summary' => '',
		'test' => '',
		'execution_condition' => 6, // VTWorkflowManager::$ON_SCHEDULE
		'schtypeid' => '',
		'schtime' => '08:08:08',
		'schdayofmonth' => '[3]',
		'schdayofweek' => '[3]',
		'schannualdates' => '["2018-10-08"]',
		'schminuteinterval' => '3',
		'defaultworkflow' => 0,
		'nexttrigger_time' => '',
	);

	/**
	 * Method testGetWorkFlowQuerySimple
	 * @test
	 */
	public function testGetWorkFlowQuerySimple() {
		global $adb;
		$workflowScheduler = new WorkFlowScheduler($adb);
		$workflow = new Workflow();
		$wfvals = $this->defaultWF;
		$wfvals['module_name'] = 'Contacts';
		$wfvals['test'] = '[{"fieldname":"firstname","operation":"greater than","value":"uppercase(lastname)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_contactdetails.contactid FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_contactdetails.firstname > UPPER(vtiger_contactdetails.lastname)) )) AND vtiger_contactdetails.contactid > 0";
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"upperfirstname","operation":"is","value":"uppercase(firstname)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT UPPER(vtiger_contactdetails.firstname) AS upperfirstname FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_contactdetails.firstname > UPPER(vtiger_contactdetails.lastname)) )) AND vtiger_contactdetails.contactid > 0";
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"lastname","operation":"is","value":"lastname","valuetype":"fieldname","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT vtiger_contactdetails.lastname FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_contactdetails.firstname > UPPER(vtiger_contactdetails.lastname)) )) AND vtiger_contactdetails.contactid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"upperfirstname","operation":"is","value":"uppercase(firstname)","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"lastname","operation":"is","value":"lastname","valuetype":"fieldname","joincondition":"and","groupid":"0"},{"fieldname":"account_id : (Accounts) accountname","operation":"is","value":"Accounts.accountname","valuetype":"fieldname","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT UPPER(vtiger_contactdetails.firstname) AS upperfirstname,vtiger_contactdetails.lastname,vtiger_accountaccount_id.accountname as accountsaccountname FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_contactdetails.accountid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_contactdetails.firstname > UPPER(vtiger_contactdetails.lastname)) )) AND vtiger_contactdetails.contactid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"upperres","operation":"greater than","value":"uppercase(lastname)","valuetype":"expression","joincondition":"and","groupid":"0"}, {"fieldname":"id","operation":"is","value":"id","valuetype":"fieldname","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT UPPER(vtiger_contactdetails.lastname) AS upperres,vtiger_contactdetails.contactid FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_contactdetails.firstname > UPPER(vtiger_contactdetails.lastname)) )) AND vtiger_contactdetails.contactid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"concatres","operation":"is","value":"concat(firstname ,\' \' , lastname )","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT concat(vtiger_contactdetails.firstname,\' \',vtiger_contactdetails.lastname) AS concatres FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_contactdetails.firstname > UPPER(vtiger_contactdetails.lastname)) )) AND vtiger_contactdetails.contactid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"coalesceres","operation":"is","value":"coalesce(isconvertedfromlead , convertedfromlead)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT coalesce(vtiger_contactdetails.isconvertedfromlead,vtiger_contactdetails.convertedfromlead) AS coalesceres FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_contactdetails.firstname > UPPER(vtiger_contactdetails.lastname)) )) AND vtiger_contactdetails.contactid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['module_name'] = 'Invoice';
		$wfvals['test'] = '[{"fieldname":"invoicestatus","operation":"is","value":"Created","valuetype":"fieldname","joincondition":"and","groupid":"0"}]';
		$wfvals['select_expressions'] = '[{"fieldname":"powerres","operation":"is","value":"power(sum_nettotal, 2)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT pow(vtiger_invoice.sum_nettotal,2) AS powerres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"roundres","operation":"is","value":"round(sum_nettotal, 1)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT round(vtiger_invoice.sum_nettotal,1) AS roundres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"ceilres","operation":"is","value":"ceil(sum_nettotal)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT CEILING(vtiger_invoice.sum_nettotal) AS ceilres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"floorres","operation":"is","value":"floor(sum_nettotal)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT FLOOR(vtiger_invoice.sum_nettotal) AS floorres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"modulores","operation":"is","value":"modulo(exciseduty,txtadjustment)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT MOD(vtiger_invoice.exciseduty,vtiger_invoice.adjustment) AS modulores FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"substringres","operation":"is","value":"substring(subject, 2, 4)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT SUBSTRING(vtiger_invoice.subject,2,4) AS substringres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"stringlengthres","operation":"is","value":"stringlength(subject)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT LENGTH(vtiger_invoice.subject) AS stringlengthres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"lowercaseres","operation":"is","value":"lowercase(subject)","valuetype":"expression","joincondition":"and","groupid":"0"}]';;
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT LOWER(vtiger_invoice.subject) AS lowercaseres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"stringpositionres","operation":"is","value":"stringposition(subject, \'x\')","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT INSTR(vtiger_invoice.subject,\'x\') AS stringpositionres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"stringreplaceres","operation":"is","value":"stringreplace(subject, \'x\', \'a\')","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT REPLACE(vtiger_invoice.subject,\'x\',\'a\') AS stringreplaceres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
	}

	/**
	 * Method testWorkflowQueryRelatedModules
	 * @test
	 */
	public function testWorkflowQueryRelatedModules() {
		global $adb;
		$workflowScheduler = new WorkFlowScheduler($adb);
		$workflow = new Workflow();
		$wfvals = $this->defaultWF;
		$wfvals['module_name'] = 'Contacts';
		$wfvals['test'] = '[{"fieldname":"firstname","operation":"greater than","value":"uppercase(lastname)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$wfvals['select_expressions'] = '[{"fieldname":"account_id : (Accounts) accountname","operation":"is","value":"Accounts.accountname","valuetype":"fieldname","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT vtiger_accountaccount_id.accountname as accountsaccountname FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_contactdetails.accountid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_contactdetails.firstname > UPPER(vtiger_contactdetails.lastname)) )) AND vtiger_contactdetails.contactid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"uppercaseaccountname","operation":"is","value":"uppercase($(account_id : (Accounts) accountname))","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT UPPER(vtiger_accountaccount_id.accountname) AS uppercaseaccountname FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_contactdetails.accountid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_contactdetails.firstname > UPPER(vtiger_contactdetails.lastname)) )) AND vtiger_contactdetails.contactid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"concatres","operation":"is","value":"concat($(account_id : (Accounts) accountname), \' \', lastname)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT concat(vtiger_accountaccount_id.accountname,\' \',vtiger_contactdetails.lastname) AS concatres FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_contactdetails.accountid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_contactdetails.firstname > UPPER(vtiger_contactdetails.lastname)) )) AND vtiger_contactdetails.contactid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"concatres","operation":"is","value":"concat($(account_id : (Accounts) accountname), \' \', $(account_id : (Accounts) website))","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT concat(vtiger_accountaccount_id.accountname,\' \',vtiger_accountaccount_id.website) AS concatres FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_contactdetails.accountid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_contactdetails.firstname > UPPER(vtiger_contactdetails.lastname)) )) AND vtiger_contactdetails.contactid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"substringres","operation":"is","value":"substring(concat($(account_id : (Accounts) accountname), \' \', $(account_id : (Accounts) website)), 5, 30)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT SUBSTRING(concat(vtiger_accountaccount_id.accountname,\' \',vtiger_accountaccount_id.website),5,30) AS substringres FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_contactdetails.accountid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_contactdetails.firstname > UPPER(vtiger_contactdetails.lastname)) )) AND vtiger_contactdetails.contactid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"calculationres","operation":"is","value":"$(account_id : (Accounts) accountname) + lastname","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT vtiger_accountaccount_id.accountname+vtiger_contactdetails.lastname AS calculationres FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_contactdetails.accountid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_contactdetails.firstname > UPPER(vtiger_contactdetails.lastname)) )) AND vtiger_contactdetails.contactid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"calculationres","operation":"is","value":"round(($(account_id : (Accounts) accountname) + lastname), 2)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT round((vtiger_accountaccount_id.accountname+vtiger_contactdetails.lastname),2) AS calculationres FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_contactdetails.accountid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_contactdetails.firstname > UPPER(vtiger_contactdetails.lastname)) )) AND vtiger_contactdetails.contactid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"ifelseres","operation":"is","value":"ifelse($(account_id : (Accounts) accountname)>=$(account_id : (Accounts) website), $(account_id : (Accounts) accountname), $(account_id : (Accounts) website))","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT IF((vtiger_accountaccount_id.accountname>=vtiger_accountaccount_id.website),vtiger_accountaccount_id.accountname,vtiger_accountaccount_id.website) AS ifelseres FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_contactdetails.accountid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_contactdetails.firstname > UPPER(vtiger_contactdetails.lastname)) )) AND vtiger_contactdetails.contactid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"ifelseres","operation":"is","value":"ifelse($(account_id : (Accounts) accountname)>=firstname, $(account_id : (Accounts) accountname), firstname)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT IF((vtiger_accountaccount_id.accountname>=vtiger_contactdetails.firstname),vtiger_accountaccount_id.accountname,vtiger_contactdetails.firstname) AS ifelseres FROM vtiger_contactdetails  INNER JOIN vtiger_crmentity ON vtiger_contactdetails.contactid = vtiger_crmentity.crmid LEFT JOIN vtiger_account AS vtiger_accountaccount_id ON vtiger_accountaccount_id.accountid=vtiger_contactdetails.accountid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_contactdetails.firstname > UPPER(vtiger_contactdetails.lastname)) )) AND vtiger_contactdetails.contactid > 0';
		$this->assertEquals($expected, $actual);
	}

	/**
	 * Method testWorkflowQueryMath
	 * @test
	 */
	public function testWorkflowQueryMath() {
		global $adb;
		$workflowScheduler = new WorkFlowScheduler($adb);
		$workflow = new Workflow();
		$wfvals = $this->defaultWF;
		$wfvals['module_name'] = 'Invoice';
		$wfvals['test'] = '[{"fieldname":"invoicestatus","operation":"is","value":"Created","valuetype":"fieldname","joincondition":"and","groupid":"0"}]';
		$wfvals['select_expressions'] = '[{"fieldname":"sumres","operation":"is","value":"txtadjustment+exciseduty","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT vtiger_invoice.adjustment+vtiger_invoice.exciseduty AS sumres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"subres","operation":"is","value":"txtadjustment-exciseduty","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT vtiger_invoice.adjustment-vtiger_invoice.exciseduty AS subres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"divres","operation":"is","value":"txtadjustment/exciseduty","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT vtiger_invoice.adjustment/vtiger_invoice.exciseduty AS divres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"mulres","operation":"is","value":"txtadjustment*exciseduty","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT vtiger_invoice.adjustment*vtiger_invoice.exciseduty AS mulres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"combres","operation":"is","value":"(txtadjustment+exciseduty)*2","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT (vtiger_invoice.adjustment+vtiger_invoice.exciseduty)*2 AS combres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"boolres","operation":"is","value":"(txtadjustment>=exciseduty)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT (vtiger_invoice.adjustment>=vtiger_invoice.exciseduty) AS boolres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"ceilres","operation":"is","value":"ceil(txtadjustment+exciseduty)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT CEILING((vtiger_invoice.adjustment+vtiger_invoice.exciseduty)) AS ceilres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
	}

	/**
	 * Method testWorkflowQueryIfElse
	 * @test
	 */
	public function testWorkflowIfElse() {
		global $adb;
		$workflowScheduler = new WorkFlowScheduler($adb);
		$workflow = new Workflow();
		$wfvals = $this->defaultWF;
		$wfvals['module_name'] = 'Invoice';
		$wfvals['test'] = '[{"fieldname":"invoicestatus","operation":"is","value":"Created","valuetype":"fieldname","joincondition":"and","groupid":"0"}]';
		$wfvals['select_expressions'] = '[{"fieldname":"ifelseres","operation":"is","value":"ifelse(txtadjustment>=exciseduty, 1, 2)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT IF((vtiger_invoice.adjustment>=vtiger_invoice.exciseduty),1,2) AS ifelseres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"ifelseres","operation":"is","value":"ifelse(txtadjustment>=exciseduty, exciseduty, txtadjustment)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT IF((vtiger_invoice.adjustment>=vtiger_invoice.exciseduty),vtiger_invoice.exciseduty,vtiger_invoice.adjustment) AS ifelseres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"ifelseres","operation":"is","value":"ifelse(1>=2, 1, 2)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT IF((1>=2),1,2) AS ifelseres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"ifelseres","operation":"is","value":"ifelse(1>2, ifelse(1>2, \'a\', \'b\'), ifelse(\'c\'>\'d\', \'e\', \'f\'))","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT IF((1>2),IF((1>2),\'a\',\'b\'),IF((\'c\'>\'d\'),\'e\',\'f\')) AS ifelseres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
	}

	/**
	 * Method testWorkflowRecursive
	 * @test
	 */
	public function testWorkflowRecursive() {
		global $adb;
		$workflowScheduler = new WorkFlowScheduler($adb);
		$workflow = new Workflow();
		$wfvals = $this->defaultWF;
		$wfvals['module_name'] = 'Invoice';
		$wfvals['test'] = '[{"fieldname":"invoicestatus","operation":"is","value":"Created","valuetype":"fieldname","joincondition":"and","groupid":"0"}]';
		$wfvals['select_expressions'] = '[{"fieldname":"recursiveres","operation":"is","value":"uppercase(concat(subject ,\' \' , invoice_no ))","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT UPPER(concat(vtiger_invoice.subject,\' \',vtiger_invoice.invoice_no)) AS recursiveres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"recursiveres","operation":"is","value":"power(modulo(exciseduty,txtadjustment),2)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT pow(MOD(vtiger_invoice.exciseduty,vtiger_invoice.adjustment),2) AS recursiveres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
	}

	/**
	 * Method testWorkflowDateTime
	 * @test
	 */
	public function testWorkFlowDateTime() {
		global $adb;
		$workflowScheduler = new WorkFlowScheduler($adb);
		$workflow = new Workflow();
		$wfvals = $this->defaultWF;
		$wfvals['module_name'] = 'Invoice';
		$wfvals['test'] = '[{"fieldname":"invoicestatus","operation":"is","value":"Created","valuetype":"fieldname","joincondition":"and","groupid":"0"}]';
		$wfvals['select_expressions'] = '[{"fieldname":"timediffres","operation":"is","value":"time_diff(duedate, invoicedate)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT timediff(vtiger_invoice.duedate,vtiger_invoice.invoicedate) AS timediffres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"timediffres","operation":"is","value":"time_diff(createdtime)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT timediff(now(),vtiger_crmentity.createdtime) AS timediffres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"timediffdaysres","operation":"is","value":"time_diffdays(duedate, invoicedate)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT datediff(vtiger_invoice.duedate,vtiger_invoice.invoicedate) AS timediffdaysres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"timediffdaysres","operation":"is","value":"time_diffdays(createdtime)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT datediff(now(),vtiger_crmentity.createdtime) AS timediffdaysres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"timediffyearsres","operation":"is","value":"time_diffyears(duedate,createdtime)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT TIMESTAMPDIFF(YEAR,vtiger_invoice.duedate,vtiger_crmentity.createdtime) AS timediffyearsres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"timediffyearsres","operation":"is","value":"time_diffyears(createdtime)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT TIMESTAMPDIFF(YEAR,now(),vtiger_crmentity.createdtime) AS timediffyearsres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"adddaysres","operation":"is","value":"add_days(duedate, 10)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT ADDDATE(vtiger_invoice.duedate,10) AS adddaysres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"subdaysres","operation":"is","value":"sub_days(duedate, 10)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT SUBDATE(vtiger_invoice.duedate,10) AS subdaysres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"addmonthsres","operation":"is","value":"add_months(duedate,5)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT DATE_ADD(vtiger_invoice.duedate,INTERVAL 5 month) AS addmonthsres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"submonthesres","operation":"is","value":"sub_months(duedate,5)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT DATE_SUB(vtiger_invoice.duedate,INTERVAL 5 month) AS submonthesres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"addtimeres","operation":"is","value":"add_time(duedate,30)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT DATE_ADD(vtiger_invoice.duedate,INTERVAL 30 MINUTE) AS addtimeres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"subtimeres","operation":"is","value":"sub_time(duedate,30)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT DATE_SUB(vtiger_invoice.duedate,INTERVAL 30 MINUTE) AS subtimeres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
	}

	/**
	 * Method testWorkFlowAggregations
	 * @test
	 */
	public function testWorkFlowAggregations() {
		global $adb;
		$workflowScheduler = new WorkFlowScheduler($adb);
		$workflow = new Workflow();
		$wfvals = $this->defaultWF;
		$wfvals['module_name'] = 'Invoice';
		$wfvals['test'] = '[{"fieldname":"invoicestatus","operation":"is","value":"Created","valuetype":"fieldname","joincondition":"and","groupid":"0"}]';
		$wfvals['select_expressions'] = '[{"fieldname":"sumres","operation":"is","value":"sum(sum_nettotal)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT SUM(vtiger_invoice.sum_nettotal) AS sumres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"minres","operation":"is","value":"min(sum_nettotal)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT MIN(vtiger_invoice.sum_nettotal) AS minres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"maxres","operation":"is","value":"max(sum_nettotal)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT MAX(vtiger_invoice.sum_nettotal) AS maxres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"avgres","operation":"is","value":"avg(sum_nettotal)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT AVG(vtiger_invoice.sum_nettotal) AS avgres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"sumres","operation":"is","value":"sum(sum_nettotal)","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"minres","operation":"is","value":"min(sum_nettotal)","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"maxres","operation":"is","value":"max(sum_nettotal)","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"avgres","operation":"is","value":"avg(sum_nettotal)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT SUM(vtiger_invoice.sum_nettotal) AS sumres,MIN(vtiger_invoice.sum_nettotal) AS minres,MAX(vtiger_invoice.sum_nettotal) AS maxres,AVG(vtiger_invoice.sum_nettotal) AS avgres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"countres","operation":"is","value":"count(subject)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT COUNT(vtiger_invoice.subject) AS countres FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.invoicestatus IN (
								select translation_key
								from vtiger_cbtranslation
								where locale="en_us" and forpicklist="Invoice::invoicestatus" and i18n = \'Created\') OR vtiger_invoice.invoicestatus = \'Created\') )) AND vtiger_invoice.invoiceid > 0';
		$this->assertEquals($expected, $actual);
	}

	/**
	 * Method testWorkFlowNoConditions
	 * @test
	 */
	public function testWorkFlowNoConditions() {
		global $adb;
		$workflowScheduler = new WorkFlowScheduler($adb);
		$workflow = new Workflow();
		$wfvals = $this->defaultWF;
		$wfvals['module_name'] = 'Accounts';
		$wfvals['test'] = '';
		$wfvals['select_expressions'] = '[{"fieldname":"countres","operation":"is","value":"count(accountname)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = 'SELECT COUNT(vtiger_account.accountname) AS countres FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND vtiger_account.accountid > 0';
		$this->assertEquals($expected, $actual);
	}
}