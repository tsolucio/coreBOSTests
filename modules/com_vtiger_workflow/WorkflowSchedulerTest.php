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

use PHPUnit\Framework\TestCase;
class WorkflowSchedulerTest extends TestCase {

	/**
	 * Method testschedulingwf
	 * params
	 */
	public function testschedulingwf() {
		global $adb;

		$minuteintervals = array(5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55);
		$minlength = count($minuteintervals);
		for ($z = 0; $z < $minlength; $z++) {
			$currmininterval = $minuteintervals[$z];

			$wm = new VTWorkflowManager($adb);
			$modw = "Contacts";
			$wf = $wm->newWorkflow($modw);
			$wf->description = "testby" . $currmininterval;
			$wf->test = "";
			$wf->executionConditionAsLabel("ON_SCHEDULE");
			$wf->schtypeid = '8';
			$wf->schminuteinterval = $currmininterval;
			$wm->save($wf);

			$workflowid_to_evaluate = $wf->id;
			$util = new VTWorkflowUtils();
			$adminUser = $util->adminUser();
			$entityCache = new VTEntityCache($adminUser);
			$wfs = new VTWorkflowManager($adb);
			$result = $adb->pquery('select * from com_vtiger_workflows where workflow_id=?', array($workflowid_to_evaluate));
			$workflows = $wfs->getWorkflowsForResult($result);
			$workflow = $workflows[$workflowid_to_evaluate];

			if ($workflows[$workflowid_to_evaluate]->executionCondition == VTWorkflowManager::$ON_SCHEDULE) {
				//echo "Scheduled: SQL for affected records: ";
				$workflowScheduler = new WorkFlowScheduler($adb);
				$query = $workflowScheduler->getWorkflowQuery($workflow);
				//echo " $query ";
				$wfcandidatesrs = $adb->pquery('SELECT * FROM com_vtiger_workflows WHERE workflow_id = ?', array($workflowid_to_evaluate));

				while ($cwf = $adb->fetch_array($wfcandidatesrs)) {
					//echo 'Parameters of workflow being tested: ';
					//echo $cwf['summary'].' '.$cwf['module_name'].' '.$cwf['nexttrigger_time'].' ';
				}
				$ntt = $workflow->getNextTriggerTime();
				//echo 'Next trigger time if launched now: '.$ntt;
				$currenttime = date("Y-m-d H:i:s");
				$currtime = strtotime($currenttime);
				$dateafter = date("Y-m-d H:i:s", strtotime("+$currmininterval minutes", $currtime));
				//echo 'date after five minutes: '.date("Y-m-d H:i:s", strtotime("+$currmininterval minutes", $currtime));
				$this->assertEquals($ntt, $dateafter);
			}
			$wm->delete($workflowid_to_evaluate); // cleanup
		}
	}

}
