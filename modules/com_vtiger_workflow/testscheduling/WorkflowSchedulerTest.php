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

class WorkflowSchedulerTest extends PHPUnit_Framework_TestCase {

	/**
	 * Method testschedulingwf
	 * params
	 */
	public function testschedulingwf() {
    global $adb;

	$test=new WorkFlowScheduler($adb);
	$test->queueScheduledWorkflowTasks();
		
	$query1=$adb->query("select * from com_vtiger_workflowtask_queue");
	$norows1=$adb->num_rows($query1);
	$query2=$adb->query("select * from vtiger_contactdetails left join vtiger_crmentity on contactid=crmid where deleted=0");
	$norows2=$adb->num_rows($query2);
	$expectedResult=$norows2;
	$this->assertEquals($expectedResult,$norows1);
	}
}
