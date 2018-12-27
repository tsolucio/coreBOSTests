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

class WorkFlowSchedulerQueryTest extends TestCase {

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
	 * Method testgetWorkflowQueryFunctions
	 * @test
	 */
	public function testgetWorkflowQueryFunctions() {
		global $adb;
		$yesterday = date('Y-m-d', strtotime('-1 day'));
		$tenDaysFromNow = date('Y-m-d', strtotime('+11 day'));
		$workflowScheduler = new WorkFlowScheduler($adb);
		$workflow = new Workflow();
		$wfvals = $this->defaultWF;
		$wfvals['module_name'] = 'Invoice';
		$wfvals['test'] = '[{"fieldname":"exciseduty","operation":"greater than or equal to","value":"sum_nettotal","valuetype":"fieldname","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.exciseduty >= vtiger_invoice.sum_nettotal) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'query fields');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"exciseduty","operation":"greater than or equal to","value":"$(salesorder_id : (SalesOrder) sum_nettotal)","valuetype":"fieldname","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid LEFT JOIN vtiger_salesorder AS vtiger_salesordersalesorder_id ON vtiger_salesordersalesorder_id.salesorderid=vtiger_invoice.salesorderid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.exciseduty >= vtiger_salesordersalesorder_id.sum_nettotal) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'query field reference');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"salesorder_id : (SalesOrder) pl_gross_total","operation":"greater than or equal to","value":"sum_nettotal","valuetype":"fieldname","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid LEFT JOIN vtiger_salesorder AS vtiger_salesordersalesorder_id ON vtiger_salesordersalesorder_id.salesorderid=vtiger_invoice.salesorderid  WHERE vtiger_crmentity.deleted=0 AND   (  ((vtiger_salesordersalesorder_id.pl_gross_total >= vtiger_invoice.sum_nettotal) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'query reference field');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"salesorder_id : (SalesOrder) pl_gross_total","operation":"greater than or equal to","value":"$(salesorder_id : (SalesOrder) sum_nettotal) ","valuetype":"fieldname","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid LEFT JOIN vtiger_salesorder AS vtiger_salesordersalesorder_id ON vtiger_salesordersalesorder_id.salesorderid=vtiger_invoice.salesorderid  WHERE vtiger_crmentity.deleted=0 AND   (  ((vtiger_salesordersalesorder_id.pl_gross_total >= vtiger_salesordersalesorder_id.sum_nettotal) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'query reference reference');
		//////////////////////
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"pl_gross_total","operation":"greater than or equal to","value":"$(salesorder_id : (SalesOrder) sum_nettotal) ","valuetype":"fieldname","joincondition":"and","groupid":"0"},{"fieldname":"subject","operation":"is","value":"concat(subject ,\' \' , invoice_no )","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"invoicedate","operation":"in less than","value":"10","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid LEFT JOIN vtiger_salesorder AS vtiger_salesordersalesorder_id ON vtiger_salesordersalesorder_id.salesorderid=vtiger_invoice.salesorderid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.pl_gross_total >= vtiger_salesordersalesorder_id.sum_nettotal)  and ( vtiger_invoice.subject = concat(vtiger_invoice.subject,' ',vtiger_invoice.invoice_no))  and ( vtiger_invoice.invoicedate BETWEEN '".$yesterday."' AND '".$tenDaysFromNow."') )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'concat');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"pl_gross_total","operation":"greater than or equal to","value":"$(salesorder_id : (SalesOrder) sum_nettotal) ","valuetype":"fieldname","joincondition":"and","groupid":"0"},{"fieldname":"subject","operation":"is","value":"concat(subject ,\' \' , $(salesorder_id : (SalesOrder) sum_nettotal) )","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"invoicedate","operation":"in less than","value":"10","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid LEFT JOIN vtiger_salesorder AS vtiger_salesordersalesorder_id ON vtiger_salesordersalesorder_id.salesorderid=vtiger_invoice.salesorderid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.pl_gross_total >= vtiger_salesordersalesorder_id.sum_nettotal)  and ( vtiger_invoice.subject = concat(vtiger_invoice.subject,' ',vtiger_salesordersalesorder_id.sum_nettotal))  and ( vtiger_invoice.invoicedate BETWEEN '".$yesterday."' AND '".$tenDaysFromNow."') )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'concat');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"subject","operation":"is","value":"concat(subject ,\' \' , $(salesorder_id : (SalesOrder) sum_nettotal) )","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid LEFT JOIN vtiger_salesorder AS vtiger_salesordersalesorder_id ON vtiger_salesordersalesorder_id.salesorderid=vtiger_invoice.salesorderid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.subject = concat(vtiger_invoice.subject,' ',vtiger_salesordersalesorder_id.sum_nettotal)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'concat');
		//////////////////////
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"salesorder_id : (SalesOrder) pl_gross_total","operation":"greater than or equal to","value":"$(salesorder_id : (SalesOrder) sum_nettotal) ","valuetype":"fieldname","joincondition":"and","groupid":"0"},{"fieldname":"subject","operation":"is","value":"coalesce(subject ,\' \' , invoice_no )","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"invoicedate","operation":"in less than","value":"10","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid LEFT JOIN vtiger_salesorder AS vtiger_salesordersalesorder_id ON vtiger_salesordersalesorder_id.salesorderid=vtiger_invoice.salesorderid  WHERE vtiger_crmentity.deleted=0 AND   (  ((vtiger_salesordersalesorder_id.pl_gross_total >= vtiger_salesordersalesorder_id.sum_nettotal)  and ( vtiger_invoice.subject = coalesce(vtiger_invoice.subject,' ',vtiger_invoice.invoice_no))  and ( vtiger_invoice.invoicedate BETWEEN '".$yesterday."' AND '".$tenDaysFromNow."') )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'coalesce');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"salesorder_id : (SalesOrder) pl_gross_total","operation":"greater than or equal to","value":"$(salesorder_id : (SalesOrder) sum_nettotal) ","valuetype":"fieldname","joincondition":"and","groupid":"0"},{"fieldname":"subject","operation":"is","value":"time_diff(duedate, createdtime)","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"invoicedate","operation":"in less than","value":"10","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid LEFT JOIN vtiger_salesorder AS vtiger_salesordersalesorder_id ON vtiger_salesordersalesorder_id.salesorderid=vtiger_invoice.salesorderid  WHERE vtiger_crmentity.deleted=0 AND   (  ((vtiger_salesordersalesorder_id.pl_gross_total >= vtiger_salesordersalesorder_id.sum_nettotal)  and ( vtiger_invoice.subject = timediff(vtiger_invoice.duedate,vtiger_crmentity.createdtime))  and ( vtiger_invoice.invoicedate BETWEEN '".$yesterday."' AND '".$tenDaysFromNow."') )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'timediff 2 params');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"salesorder_id : (SalesOrder) pl_gross_total","operation":"greater than or equal to","value":"$(salesorder_id : (SalesOrder) sum_nettotal) ","valuetype":"fieldname","joincondition":"and","groupid":"0"},{"fieldname":"subject","operation":"is","value":"time_diff(createdtime)","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"invoicedate","operation":"in less than","value":"10","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid LEFT JOIN vtiger_salesorder AS vtiger_salesordersalesorder_id ON vtiger_salesordersalesorder_id.salesorderid=vtiger_invoice.salesorderid  WHERE vtiger_crmentity.deleted=0 AND   (  ((vtiger_salesordersalesorder_id.pl_gross_total >= vtiger_salesordersalesorder_id.sum_nettotal)  and ( vtiger_invoice.subject = timediff(now(),vtiger_crmentity.createdtime))  and ( vtiger_invoice.invoicedate BETWEEN '".$yesterday."' AND '".$tenDaysFromNow."') )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'timediff 1 param');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"salesorder_id : (SalesOrder) pl_gross_total","operation":"greater than or equal to","value":"$(salesorder_id : (SalesOrder) sum_nettotal) ","valuetype":"fieldname","joincondition":"and","groupid":"0"},{"fieldname":"subject","operation":"is","value":"time_diffdays(duedate,createdtime)","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"invoicedate","operation":"in less than","value":"10","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid LEFT JOIN vtiger_salesorder AS vtiger_salesordersalesorder_id ON vtiger_salesordersalesorder_id.salesorderid=vtiger_invoice.salesorderid  WHERE vtiger_crmentity.deleted=0 AND   (  ((vtiger_salesordersalesorder_id.pl_gross_total >= vtiger_salesordersalesorder_id.sum_nettotal)  and ( vtiger_invoice.subject = datediff(vtiger_invoice.duedate,vtiger_crmentity.createdtime))  and ( vtiger_invoice.invoicedate BETWEEN '".$yesterday."' AND '".$tenDaysFromNow."') )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'timediffdays 2 params');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"salesorder_id : (SalesOrder) pl_gross_total","operation":"greater than or equal to","value":"$(salesorder_id : (SalesOrder) sum_nettotal) ","valuetype":"fieldname","joincondition":"and","groupid":"0"},{"fieldname":"subject","operation":"is","value":"time_diffdays(createdtime)","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"invoicedate","operation":"in less than","value":"10","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid LEFT JOIN vtiger_salesorder AS vtiger_salesordersalesorder_id ON vtiger_salesordersalesorder_id.salesorderid=vtiger_invoice.salesorderid  WHERE vtiger_crmentity.deleted=0 AND   (  ((vtiger_salesordersalesorder_id.pl_gross_total >= vtiger_salesordersalesorder_id.sum_nettotal)  and ( vtiger_invoice.subject = datediff(now(),vtiger_crmentity.createdtime))  and ( vtiger_invoice.invoicedate BETWEEN '".$yesterday."' AND '".$tenDaysFromNow."') )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'timediffdays 1 param');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"salesorder_id : (SalesOrder) pl_gross_total","operation":"greater than or equal to","value":"$(salesorder_id : (SalesOrder) sum_nettotal) ","valuetype":"fieldname","joincondition":"and","groupid":"0"},{"fieldname":"subject","operation":"is","value":"time_diffyears(duedate,createdtime)","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"invoicedate","operation":"in less than","value":"10","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid LEFT JOIN vtiger_salesorder AS vtiger_salesordersalesorder_id ON vtiger_salesordersalesorder_id.salesorderid=vtiger_invoice.salesorderid  WHERE vtiger_crmentity.deleted=0 AND   (  ((vtiger_salesordersalesorder_id.pl_gross_total >= vtiger_salesordersalesorder_id.sum_nettotal)  and ( vtiger_invoice.subject = TIMESTAMPDIFF(YEAR,vtiger_invoice.duedate,vtiger_crmentity.createdtime))  and ( vtiger_invoice.invoicedate BETWEEN '".$yesterday."' AND '".$tenDaysFromNow."') )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'timediffyears 2 params');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"salesorder_id : (SalesOrder) pl_gross_total","operation":"greater than or equal to","value":"$(salesorder_id : (SalesOrder) sum_nettotal) ","valuetype":"fieldname","joincondition":"and","groupid":"0"},{"fieldname":"subject","operation":"is","value":"time_diffyears(createdtime)","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"invoicedate","operation":"in less than","value":"10","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid LEFT JOIN vtiger_salesorder AS vtiger_salesordersalesorder_id ON vtiger_salesordersalesorder_id.salesorderid=vtiger_invoice.salesorderid  WHERE vtiger_crmentity.deleted=0 AND   (  ((vtiger_salesordersalesorder_id.pl_gross_total >= vtiger_salesordersalesorder_id.sum_nettotal)  and ( vtiger_invoice.subject = TIMESTAMPDIFF(YEAR,now(),vtiger_crmentity.createdtime))  and ( vtiger_invoice.invoicedate BETWEEN '".$yesterday."' AND '".$tenDaysFromNow."') )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'timediffyears 1 param');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"salesorder_id : (SalesOrder) pl_gross_total","operation":"greater than or equal to","value":"$(salesorder_id : (SalesOrder) sum_nettotal) ","valuetype":"fieldname","joincondition":"and","groupid":"0"},{"fieldname":"subject","operation":"is","value":"translate(createdtime)","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"invoicedate","operation":"in less than","value":"10","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid LEFT JOIN vtiger_salesorder AS vtiger_salesordersalesorder_id ON vtiger_salesordersalesorder_id.salesorderid=vtiger_invoice.salesorderid  WHERE vtiger_crmentity.deleted=0 AND   (  ((vtiger_salesordersalesorder_id.pl_gross_total >= vtiger_salesordersalesorder_id.sum_nettotal)  and ( vtiger_invoice.subject = TRUE)  and ( vtiger_invoice.invoicedate BETWEEN '".$yesterday."' AND '".$tenDaysFromNow."') )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'UNSUPPORTED FUNCTIONS');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"salesorder_id : (SalesOrder) pl_gross_total","operation":"greater than or equal to","value":"$(salesorder_id : (SalesOrder) sum_nettotal) ","valuetype":"fieldname","joincondition":"and","groupid":"0"},{"fieldname":"subject","operation":"is","value":"add_days(duedate,22)","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"invoicedate","operation":"in less than","value":"10","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid LEFT JOIN vtiger_salesorder AS vtiger_salesordersalesorder_id ON vtiger_salesordersalesorder_id.salesorderid=vtiger_invoice.salesorderid  WHERE vtiger_crmentity.deleted=0 AND   (  ((vtiger_salesordersalesorder_id.pl_gross_total >= vtiger_salesordersalesorder_id.sum_nettotal)  and ( vtiger_invoice.subject = ADDDATE(vtiger_invoice.duedate,22))  and ( vtiger_invoice.invoicedate BETWEEN '".$yesterday."' AND '".$tenDaysFromNow."') )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'add days');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"salesorder_id : (SalesOrder) pl_gross_total","operation":"greater than or equal to","value":"$(salesorder_id : (SalesOrder) sum_nettotal) ","valuetype":"fieldname","joincondition":"and","groupid":"0"},{"fieldname":"subject","operation":"is","value":"sub_days(duedate,22)","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"invoicedate","operation":"in less than","value":"10","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid LEFT JOIN vtiger_salesorder AS vtiger_salesordersalesorder_id ON vtiger_salesordersalesorder_id.salesorderid=vtiger_invoice.salesorderid  WHERE vtiger_crmentity.deleted=0 AND   (  ((vtiger_salesordersalesorder_id.pl_gross_total >= vtiger_salesordersalesorder_id.sum_nettotal)  and ( vtiger_invoice.subject = SUBDATE(vtiger_invoice.duedate,22))  and ( vtiger_invoice.invoicedate BETWEEN '".$yesterday."' AND '".$tenDaysFromNow."') )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'sub days');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"salesorder_id : (SalesOrder) pl_gross_total","operation":"greater than or equal to","value":"$(salesorder_id : (SalesOrder) sum_nettotal) ","valuetype":"fieldname","joincondition":"and","groupid":"0"},{"fieldname":"subject","operation":"is","value":"add_months(duedate,12)","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"invoicedate","operation":"in less than","value":"10","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid LEFT JOIN vtiger_salesorder AS vtiger_salesordersalesorder_id ON vtiger_salesordersalesorder_id.salesorderid=vtiger_invoice.salesorderid  WHERE vtiger_crmentity.deleted=0 AND   (  ((vtiger_salesordersalesorder_id.pl_gross_total >= vtiger_salesordersalesorder_id.sum_nettotal)  and ( vtiger_invoice.subject = DATE_ADD(vtiger_invoice.duedate,INTERVAL 12 month))  and ( vtiger_invoice.invoicedate BETWEEN '".$yesterday."' AND '".$tenDaysFromNow."') )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'add months');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"salesorder_id : (SalesOrder) pl_gross_total","operation":"greater than or equal to","value":"$(salesorder_id : (SalesOrder) sum_nettotal) ","valuetype":"fieldname","joincondition":"and","groupid":"0"},{"fieldname":"subject","operation":"is","value":"sub_months(duedate,12)","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"invoicedate","operation":"in less than","value":"10","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid LEFT JOIN vtiger_salesorder AS vtiger_salesordersalesorder_id ON vtiger_salesordersalesorder_id.salesorderid=vtiger_invoice.salesorderid  WHERE vtiger_crmentity.deleted=0 AND   (  ((vtiger_salesordersalesorder_id.pl_gross_total >= vtiger_salesordersalesorder_id.sum_nettotal)  and ( vtiger_invoice.subject = DATE_SUB(vtiger_invoice.duedate,INTERVAL 12 month))  and ( vtiger_invoice.invoicedate BETWEEN '".$yesterday."' AND '".$tenDaysFromNow."') )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'sub months');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"salesorder_id : (SalesOrder) pl_gross_total","operation":"greater than or equal to","value":"$(salesorder_id : (SalesOrder) sum_nettotal) ","valuetype":"fieldname","joincondition":"and","groupid":"0"},{"fieldname":"subject","operation":"is","value":"add_time(duedate,12)","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"invoicedate","operation":"in less than","value":"10","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid LEFT JOIN vtiger_salesorder AS vtiger_salesordersalesorder_id ON vtiger_salesordersalesorder_id.salesorderid=vtiger_invoice.salesorderid  WHERE vtiger_crmentity.deleted=0 AND   (  ((vtiger_salesordersalesorder_id.pl_gross_total >= vtiger_salesordersalesorder_id.sum_nettotal)  and ( vtiger_invoice.subject = DATE_ADD(vtiger_invoice.duedate,INTERVAL 12 MINUTE))  and ( vtiger_invoice.invoicedate BETWEEN '".$yesterday."' AND '".$tenDaysFromNow."') )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'add minutes');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"salesorder_id : (SalesOrder) pl_gross_total","operation":"greater than or equal to","value":"$(salesorder_id : (SalesOrder) sum_nettotal) ","valuetype":"fieldname","joincondition":"and","groupid":"0"},{"fieldname":"subject","operation":"is","value":"sub_time(duedate,12)","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"invoicedate","operation":"in less than","value":"10","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid LEFT JOIN vtiger_salesorder AS vtiger_salesordersalesorder_id ON vtiger_salesordersalesorder_id.salesorderid=vtiger_invoice.salesorderid  WHERE vtiger_crmentity.deleted=0 AND   (  ((vtiger_salesordersalesorder_id.pl_gross_total >= vtiger_salesordersalesorder_id.sum_nettotal)  and ( vtiger_invoice.subject = DATE_SUB(vtiger_invoice.duedate,INTERVAL 12 MINUTE))  and ( vtiger_invoice.invoicedate BETWEEN '".$yesterday."' AND '".$tenDaysFromNow."') )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'sub minutes');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"subject","operation":"is","value":"get_date(\'today\')","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.subject = CURDATE()) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'CURDATE TODAY');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"subject","operation":"is","value":"get_date(\'time\')","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.subject = CURTIME()) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'CURTIME');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"subject","operation":"is","value":"get_date(\'tomorrow\')","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.subject = adddate(CURDATE(),1)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'CURDATE TOMORROW');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"subject","operation":"is","value":"get_date(\'yesterday\')","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.subject = subdate(CURDATE(),1)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'CURDATE YESTERDAY');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"subject","operation":"is","value":"hash(subject,\'md5\')","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.subject = MD5(vtiger_invoice.subject)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'HASH MD5');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"subject","operation":"is","value":"hash(subject)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.subject = SHA(vtiger_invoice.subject)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'HASH MD5');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"subject","operation":"is","value":"getEntityType(account_id)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.subject = (select setype from vtiger_crmentity where vtiger_crmentity.crmid=vtiger_invoice.accountid)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'getEntityType(account_id)');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"subject","operation":"is","value":"getEntityType(\'11x74\')","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.subject = (select setype from vtiger_crmentity where vtiger_crmentity.crmid=74)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'getEntityType(\'11x74\')');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"subject","operation":"is","value":"getEntityType(74)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.subject = (select setype from vtiger_crmentity where vtiger_crmentity.crmid=74)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'getEntityType(74)');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"subject","operation":"is","value":"getEntityType(\'74\')","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.subject = (select setype from vtiger_crmentity where vtiger_crmentity.crmid=74)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'getEntityType(\'74\')');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"subject","operation":"exists","value":"getEntityType(\'11x74\')","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  ((SELECT EXISTS(SELECT 1  FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND ( vtiger_invoice.subject = (select setype from vtiger_crmentity where vtiger_crmentity.crmid=74))  AND vtiger_invoice.invoiceid > 0)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'getEntityType(\'11x74\')');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"subject","operation":"is","value":"uppercase(subject)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.subject = UPPER(vtiger_invoice.subject)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'uppercase field');
		//////////////////////
		$currentModule = 'Leads';
		$wfvals = $this->defaultWF;
		$wfvals['module_name'] = 'Leads';
		$wfvals['test'] = '[{"fieldname":"firstname","operation":"is","value":"uppercase(lastname)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_leaddetails.leadid FROM vtiger_leaddetails  INNER JOIN vtiger_crmentity ON vtiger_leaddetails.leadid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 and vtiger_leaddetails.converted=0 AND   (  (( vtiger_leaddetails.firstname = UPPER(vtiger_leaddetails.lastname)) )) AND vtiger_leaddetails.leadid > 0";
		$this->assertEquals($expected, $actual, 'uppercase field');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"firstname","operation":"greater than","value":"uppercase(lastname)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_leaddetails.leadid FROM vtiger_leaddetails  INNER JOIN vtiger_crmentity ON vtiger_leaddetails.leadid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 and vtiger_leaddetails.converted=0 AND   (  (( vtiger_leaddetails.firstname > UPPER(vtiger_leaddetails.lastname)) )) AND vtiger_leaddetails.leadid > 0";
		$this->assertEquals($expected, $actual, 'uppercase field');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"annualrevenue","operation":"is","value":"3654","valuetype":"raw","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_leaddetails.leadid FROM vtiger_leaddetails  INNER JOIN vtiger_crmentity ON vtiger_leaddetails.leadid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 and vtiger_leaddetails.converted=0 AND   (  (( vtiger_leaddetails.annualrevenue = 3654) )) AND vtiger_leaddetails.leadid > 0";
		$this->assertEquals($expected, $actual, 'product end today');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"annualrevenue","operation":"is","value":"36+54","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_leaddetails.leadid FROM vtiger_leaddetails  INNER JOIN vtiger_crmentity ON vtiger_leaddetails.leadid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 and vtiger_leaddetails.converted=0 AND   (  (( vtiger_leaddetails.annualrevenue = 36+54) )) AND vtiger_leaddetails.leadid > 0";
		$this->assertEquals($expected, $actual, 'product end today');
		//////////////////////
		$currentModule = 'Products';
		$wfvals = $this->defaultWF;
		$wfvals['module_name'] = 'Products';
		$wfvals['test'] = '[{"fieldname":"start_date","operation":"is today","value":"","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_products.productid FROM vtiger_products  INNER JOIN vtiger_crmentity ON vtiger_products.productid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_products.start_date = '".date('Y-m-d')."') )) AND vtiger_products.productid > 0";
		$this->assertEquals($expected, $actual, 'product start is today');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"start_date","operation":"is","value":"get_date(\'today\')","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_products.productid FROM vtiger_products  INNER JOIN vtiger_crmentity ON vtiger_products.productid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_products.start_date = CURDATE()) )) AND vtiger_products.productid > 0";
		$this->assertEquals($expected, $actual, 'product start today');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"expiry_date","operation":"is","value":"get_date(\'today\')","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_products.productid FROM vtiger_products  INNER JOIN vtiger_crmentity ON vtiger_products.productid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_products.expiry_date = CURDATE()) )) AND vtiger_products.productid > 0";
		$this->assertEquals($expected, $actual, 'product end today');
	}

	/**
	 * Method testgetWorkflowQueryFunctionsRecursive
	 * @test
	 */
	public function testgetWorkflowQueryFunctionsRecursive() {
		global $adb, $currentModule;
		$currentModule = 'Invoice';
		$workflowScheduler = new WorkFlowScheduler($adb);
		$workflow = new Workflow();
		$wfvals = $this->defaultWF;
		$wfvals['module_name'] = 'Invoice';
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"subject","operation":"is","value":"uppercase(concat(subject ,\' \' , invoice_no ))","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.subject = UPPER(concat(vtiger_invoice.subject,' ',vtiger_invoice.invoice_no))) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'recursive function');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"subject","operation":"is","value":"power(modulo(exciseduty,txtadjustment),2)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.subject = pow(MOD(vtiger_invoice.exciseduty,vtiger_invoice.adjustment),2)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'recursive function');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"duedate","operation":"is","value":"add_days(get_date(\'today\'), 7)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.duedate = ADDDATE(CURDATE(),7)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'recursive function');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"duedate","operation":"is","value":"add_days(get_date(\'time\'), 7)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.duedate = ADDDATE(CURTIME(),7)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'recursive function');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"duedate","operation":"is","value":"add_days(get_date(\'yesterday\'), 7)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.duedate = ADDDATE(subdate(CURDATE(),1),7)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'recursive function');
	}

		/**
	 * Method testgetWorkflowQueryAggregations
	 * @test
	 */
	public function testgetWorkflowQueryAggregations() {
		global $adb, $currentModule;
		$currentModule = 'Invoice';
		$workflowScheduler = new WorkFlowScheduler($adb);
		$workflow = new Workflow();
		$wfvals = $this->defaultWF;
		$wfvals['module_name'] = 'Invoice';
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"hdnGrandTotal","operation":"less than or equal to","value":"aggregation(\'sum\',\'CobroPago\',\'amount\')","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.total <= (select sum(amount) as aggop  FROM vtiger_cobropago INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_cobropago.cobropagoid LEFT JOIN vtiger_cobropagocf ON vtiger_cobropagocf.cobropagoid = vtiger_cobropago.cobropagoid INNER JOIN vtiger_invoice as vtiger_invoiceaggop ON (vtiger_invoiceaggop.invoiceid = vtiger_cobropago.related_id) LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid WHERE vtiger_crmentity.deleted = 0 AND vtiger_invoiceaggop.invoiceid = vtiger_invoice.invoiceid)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'aggregation sum');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"hdnGrandTotal","operation":"less than or equal to","value":"aggregation(\'min\',\'CobroPago\',\'amount\')","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.total <= (select min(amount) as aggop  FROM vtiger_cobropago INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_cobropago.cobropagoid LEFT JOIN vtiger_cobropagocf ON vtiger_cobropagocf.cobropagoid = vtiger_cobropago.cobropagoid INNER JOIN vtiger_invoice as vtiger_invoiceaggop ON (vtiger_invoiceaggop.invoiceid = vtiger_cobropago.related_id) LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid WHERE vtiger_crmentity.deleted = 0 AND vtiger_invoiceaggop.invoiceid = vtiger_invoice.invoiceid)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'aggregation min');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"hdnGrandTotal","operation":"less than or equal to","value":"aggregation_fields_operation(\'sum\',\'InventoryDetails\',\'quantity*listprice\')","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.total <= (select sum(quantity*listprice) as aggop  FROM vtiger_inventorydetails INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_inventorydetails.inventorydetailsid INNER JOIN vtiger_inventorydetailscf ON vtiger_inventorydetailscf.inventorydetailsid = vtiger_inventorydetails.inventorydetailsid INNER JOIN vtiger_invoice as vtiger_invoiceaggop ON (vtiger_invoiceaggop.invoiceid = vtiger_inventorydetails.related_to) LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid WHERE vtiger_crmentity.deleted = 0 AND vtiger_invoiceaggop.invoiceid = vtiger_invoice.invoiceid)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'aggregation field opertation');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"hdnGrandTotal","operation":"less than or equal to","value":"aggregation(\'time_to_sec\',\'InventoryDetails\',\'quantity*listprice\')","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.total <= (select time_to_sec(quantity*listprice) as aggop  FROM vtiger_inventorydetails INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_inventorydetails.inventorydetailsid INNER JOIN vtiger_inventorydetailscf ON vtiger_inventorydetailscf.inventorydetailsid = vtiger_inventorydetails.inventorydetailsid INNER JOIN vtiger_invoice as vtiger_invoiceaggop ON (vtiger_invoiceaggop.invoiceid = vtiger_inventorydetails.related_to) LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid WHERE vtiger_crmentity.deleted = 0 AND vtiger_invoiceaggop.invoiceid = vtiger_invoice.invoiceid)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'aggregation time');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"hdnGrandTotal","operation":"less than or equal to","value":"aggregate_time(\'InventoryDetails\',\'quantity*listprice\')","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.total <= (select time_to_sec(quantity*listprice) as aggop  FROM vtiger_inventorydetails INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_inventorydetails.inventorydetailsid INNER JOIN vtiger_inventorydetailscf ON vtiger_inventorydetailscf.inventorydetailsid = vtiger_inventorydetails.inventorydetailsid INNER JOIN vtiger_invoice as vtiger_invoiceaggop ON (vtiger_invoiceaggop.invoiceid = vtiger_inventorydetails.related_to) LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid WHERE vtiger_crmentity.deleted = 0 AND vtiger_invoiceaggop.invoiceid = vtiger_invoice.invoiceid)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'aggregation time');
	}

	/**
	 * Method testgetWorkflowQueryAggregationsConditions
	 * @test
	 */
	public function testgetWorkflowQueryAggregationsConditions() {
		global $adb, $currentModule;
		$currentModule = 'Accounts';
		$workflowScheduler = new WorkFlowScheduler($adb);
		$workflow = new Workflow();
		$wfvals = $this->defaultWF;
		$wfvals['module_name'] = 'Accounts';
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"cf_719","operation":"greater than or equal to","value":"aggregation(\'count\',\'SalesOrder\',\'vtiger_salesorder.subject\',\'[duedate,h,2018-01-01,and]\')","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_account.accountid FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid INNER JOIN vtiger_accountscf ON vtiger_account.accountid = vtiger_accountscf.accountid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_accountscf.cf_719 >= (select count(vtiger_salesorder.subject) as aggop  FROM vtiger_salesorder    INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_salesorder.salesorderid    LEFT OUTER JOIN vtiger_quotes ON vtiger_quotes.quoteid = vtiger_salesorder.quoteid    LEFT OUTER JOIN vtiger_account as vtiger_accountaggop ON vtiger_accountaggop.accountid = vtiger_salesorder.accountid    LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid    LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id    WHERE vtiger_crmentity.deleted = 0 AND vtiger_salesorder.accountid = vtiger_account.accountid and (vtiger_crmentity.deleted=0 AND ( vtiger_salesorder.duedate >= '2018-01-01')  AND vtiger_salesorder.salesorderid > 0))) )) AND vtiger_account.accountid > 0";
		$this->assertEquals($expected, $actual, 'aggregation condition count field');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"cf_719","operation":"greater than or equal to","value":"aggregation(\'count\',\'SalesOrder\',\'*\',\'[duedate,h,2018-01-01,and]\')","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_account.accountid FROM vtiger_account  INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid INNER JOIN vtiger_accountscf ON vtiger_account.accountid = vtiger_accountscf.accountid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_accountscf.cf_719 >= (select count(*) as aggop  FROM vtiger_salesorder    INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_salesorder.salesorderid    LEFT OUTER JOIN vtiger_quotes ON vtiger_quotes.quoteid = vtiger_salesorder.quoteid    LEFT OUTER JOIN vtiger_account as vtiger_accountaggop ON vtiger_accountaggop.accountid = vtiger_salesorder.accountid    LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid    LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id    WHERE vtiger_crmentity.deleted = 0 AND vtiger_salesorder.accountid = vtiger_account.accountid and (vtiger_crmentity.deleted=0 AND ( vtiger_salesorder.duedate >= '2018-01-01')  AND vtiger_salesorder.salesorderid > 0))) )) AND vtiger_account.accountid > 0";
		$this->assertEquals($expected, $actual, 'aggregation condition count *');
	}

	/**
	 * Method testgetWorkflowQueryMath
	 * @test
	 */
	public function testgetWorkflowQueryMath() {
		global $adb, $currentModule;
		$currentModule = 'Invoice';
		$workflowScheduler = new WorkFlowScheduler($adb);
		$workflow = new Workflow();
		$wfvals = $this->defaultWF;
		$wfvals['module_name'] = 'Invoice';
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"hdnGrandTotal","operation":"is","value":"txtadjustment+exciseduty","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.total = vtiger_invoice.adjustment+vtiger_invoice.exciseduty) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'mathop sum');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"hdnGrandTotal","operation":"is","value":"(txtadjustment+exciseduty)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.total = vtiger_invoice.adjustment+vtiger_invoice.exciseduty) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'mathop sum parenthesis');
		// //////////////////////
		$wfvals['test'] = '[{"fieldname":"hdnGrandTotal","operation":"is","value":"txtadjustment/exciseduty","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.total = vtiger_invoice.adjustment/vtiger_invoice.exciseduty) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'mathop div');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"hdnGrandTotal","operation":"is","value":"11+22","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.total = 11+22) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'mathop sum nums');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"hdnGrandTotal","operation":"is","value":"(txtadjustment+exciseduty)/10","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.total = (vtiger_invoice.adjustment+vtiger_invoice.exciseduty)/10) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'mathop sum div fields');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"hdnGrandTotal","operation":"is","value":"(11+22)/10","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.total = (11+22)/10) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'mathop sum div nums');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"hdnGrandTotal","operation":"is","value":"(11-22)*10","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.total = (11-22)*10) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'mathop dif mul nums');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"customerno","operation":"is","value":"(txtadjustment>=exciseduty)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.customerno = (vtiger_invoice.adjustment>=vtiger_invoice.exciseduty)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'mathop logical gte');
	}

	/**
	 * Method testgetWorkflowQueryMathExceptionOnEqual
	 * @test
	 * @expectedException Exception
	 */
	public function testgetWorkflowQueryMathExceptionOnEqual() {
		global $adb, $currentModule;
		$currentModule = 'Invoice';
		$workflowScheduler = new WorkFlowScheduler($adb);
		$workflow = new Workflow();
		$wfvals = $this->defaultWF;
		$wfvals['module_name'] = 'Invoice';
		$wfvals['test'] = '[{"fieldname":"customerno","operation":"is","value":"(txtadjustment=exciseduty)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
	}

	/**
	 * Method testgetWorkflowQueryMathFunctions
	 * @test
	 */
	public function testgetWorkflowQueryMathFunctions() {
		global $adb, $currentModule;
		$currentModule = 'Invoice';
		$workflowScheduler = new WorkFlowScheduler($adb);
		$workflow = new Workflow();
		$wfvals = $this->defaultWF;
		$wfvals['module_name'] = 'Invoice';
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"hdnGrandTotal","operation":"is","value":"ceil(txtadjustment+exciseduty)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.total = CEILING((vtiger_invoice.adjustment+vtiger_invoice.exciseduty))) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'mathop func sum');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"hdnGrandTotal","operation":"is","value":"round(txtadjustment*exciseduty, 2)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.total = round((vtiger_invoice.adjustment*vtiger_invoice.exciseduty),2)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'mathop func sum');
	}

	/**
	 * Method testgetWorkflowQueryIfElse
	 * @test
	 */
	public function testgetWorkflowQueryIfElse() {
		global $adb, $currentModule;
		$currentModule = 'Invoice';
		$workflowScheduler = new WorkFlowScheduler($adb);
		$workflow = new Workflow();
		$wfvals = $this->defaultWF;
		$wfvals['module_name'] = 'Invoice';
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"customerno","operation":"is","value":"ifelse(txtadjustment>=exciseduty, \'33062184-2\', 2)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.customerno = IF((vtiger_invoice.adjustment>=vtiger_invoice.exciseduty),'33062184-2',2)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'if-else');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"customerno","operation":"is","value":"ifelse($(salesorder_id : (SalesOrder) sum_nettotal)>=$(salesorder_id : (SalesOrder) pl_gross_total), \'33062184-2\', 2)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.customerno = IF((vtiger_salesordersalesorder_id.sum_nettotal>=vtiger_salesordersalesorder_id.pl_gross_total),'33062184-2',2)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'if-else');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"customerno","operation":"is","value":"ifelse(txtadjustment<=exciseduty, txtadjustment, exciseduty)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.customerno = IF((vtiger_invoice.adjustment<=vtiger_invoice.exciseduty),vtiger_invoice.adjustment,vtiger_invoice.exciseduty)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'if-else');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"customerno","operation":"is","value":"ifelse(22>33, 33062184, 2)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.customerno = IF((22>33),33062184,2)) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'if-else');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"customerno","operation":"is","value":"ifelse(22>33, ifelse(33>22, 111, 333), ifelse(99>55, 4444, 7777))","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.customerno = IF((22>33),IF((33>22),111,333),IF((99>55),4444,7777))) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'if-else');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"customerno","operation":"is","value":"ifelse(22>33, ifelse(33>22, \'111\', \'333\'), ifelse(\'99\'>\'55\', 4444, 7777))","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.customerno = IF((22>33),IF((33>22),111,333),IF((99>55),4444,7777))) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'if-else');
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"customerno","operation":"is","value":"ifelse(22>33, ifelse(33>22, \'aaa\', \'bbb\'), ifelse(\'cc\'>\'dd\', \'ee\', \'ff\'))","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow);
		$expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.customerno = IF((22>33),IF((33>22),'aaa','bbb'),IF(('cc'>'dd'),'ee','ff'))) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'if-else');
	}

	/**
	 * Method testgetWorkflowQuerySelectColumns
	 * @test
	 */
	public function testgetWorkflowQuerySelectColumns() {
		global $adb, $currentModule;
		$currentModule = 'Invoice';
		$workflowScheduler = new WorkFlowScheduler($adb);
		$workflow = new Workflow();
		$wfvals = $this->defaultWF;
		$wfvals['module_name'] = 'Invoice';
		//////////////////////
		$wfvals['test'] = '[{"fieldname":"hdnGrandTotal","operation":"is","value":"ceil(txtadjustment+exciseduty)","valuetype":"expression","joincondition":"and","groupid":"0"}]';
		$workflow->setup($wfvals);
		$actual = $workflowScheduler->getWorkflowQuery($workflow, array('hdnGrandTotal', 'txtAdjustment', 'exciseduty', 'SalesOrder.sum_nettotal'));
		$expected = "SELECT vtiger_invoice.invoiceid, vtiger_invoice.total, vtiger_invoice.adjustment, vtiger_invoice.exciseduty, vtiger_salesordersalesorder_id.sum_nettotal as salesordersum_nettotal FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid LEFT JOIN vtiger_salesorder AS vtiger_salesordersalesorder_id ON vtiger_salesordersalesorder_id.salesorderid=vtiger_invoice.salesorderid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.total = CEILING((vtiger_invoice.adjustment+vtiger_invoice.exciseduty))) )) AND vtiger_invoice.invoiceid > 0";
		$this->assertEquals($expected, $actual, 'select columns');
	}

	/**
	 * Method testgetWorkflowQueryUserPermissions
	 * @test
	 */
	public function testgetWorkflowQueryUserPermissions() {
		global $adb, $currentModule;
		$currentModule = 'HelpDesk';
		$workflowScheduler = new WorkFlowScheduler($adb);
		$workflow = new Workflow();
		$wfvals = $this->defaultWF;
		$wfvals['module_name'] = 'HelpDesk';
		//////////////////////
		$wfvals['select_expressions'] = '[{"fieldname":"countres","operation":"is","value":"count(ticket_title)","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"ticketstatus","operation":"is","value":"ticketstatus","valuetype":"fieldname","joincondition":"and","groupid":"0"}]';
		$wfvals['test'] = '';
		$workflow->setup($wfvals);
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(7); // testymd HelpDesk is private
		$actual = $workflowScheduler->getWorkflowQuery($workflow, array(), true, $user);
		$expected = 'SELECT COUNT(vtiger_troubletickets.title) AS countres,vtiger_troubletickets.status FROM vtiger_troubletickets  INNER JOIN vtiger_crmentity ON vtiger_troubletickets.ticketid = vtiger_crmentity.crmid INNER JOIN vt_tmp_u7 vt_tmp_u7 ON vt_tmp_u7.id = vtiger_crmentity.smownerid  WHERE vtiger_crmentity.deleted=0 AND vtiger_troubletickets.ticketid > 0';
		$this->assertEquals($expected, $actual, 'UserPermissions');
	}

	// /**
	//  * Method testgetWorkflowQueryFieldType
	//  * @test
	//  */
	// public function testgetWorkflowQueryFieldType() {
	// 	global $adb;
	// 	$yesterday = date('Y-m-d', strtotime('-1 day'));
	// 	$tenDaysFromNow = date('Y-m-d', strtotime('+11 day'));
	// 	$workflowScheduler = new WorkFlowScheduler($adb);
	// 	$workflow = new Workflow();
	// 	$wfvals = $this->defaultWF;
	// 	$wfvals['module_name'] = 'Invoice';
	// 	//////////////////////
	// 	// REVERSE OPERATIONS
	// 	// $wfvals['test'] = '[{"fieldname":"getEntityType(\'11x74\')","operation":"is","value":"getEntityType(\'11x74\')","valuetype":"expression","joincondition":"and","groupid":"0"}]';
	// 	// $workflow->setup($wfvals);
	// 	// $actual = $workflowScheduler->getWorkflowQuery($workflow);
	// 	// $expected = "SELECT vtiger_invoice.invoiceid FROM vtiger_invoice  INNER JOIN vtiger_crmentity ON vtiger_invoice.invoiceid = vtiger_crmentity.crmid  WHERE vtiger_crmentity.deleted=0 AND   (  (( vtiger_invoice.subject = (select setype from vtiger_crmentity where crmid=74)) )) AND vtiger_invoice.invoiceid > 0";
	// 	// $this->assertEquals($expected, $actual, 'getEntityType(\'11x74\')');
	// }
}
