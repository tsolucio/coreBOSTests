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
class VTUpdateFieldsTaskTest extends PHPUnit_Framework_TestCase {

	/**
	 * Method testCorrectUpdate
	 * @test
	 */
	public function testCorrectUpdate() {
		global $adb, $current_user;
		// Using Inventory Lines existing workflow update task we force a launch and check the update result
		$taskId = 14; // line complete inventory details update task
		$InventoryDetailsWSID = '36x';
		$entityId = $InventoryDetailsWSID.'2823';
		// we make sure the line completed value is false and the quantity and units received are the same so the task is launched
		$adb->pquery('update vtiger_inventorydetails set line_completed=?, units_delivered_received=3, quantity=3 where inventorydetailsid=?',array('0',2823));
		// now we launch the task
		$util = new VTWorkflowUtils();
		$adminUser = $util->adminUser();
		$current_user = $adminUser;
		$tm = new VTTaskManager($adb);
		$task = $tm->retrieveTask($taskId);
		$this->assertInstanceOf(VTUpdateFieldsTask::class,$task,"test retrieveTask");
		list($moduleId, $crmId) = explode('x', $entityId);
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$task->doTask($entity);
		$rs = $adb->pquery('select line_completed from vtiger_inventorydetails where inventorydetailsid=?',array($crmId));
		$actual = $adb->query_result($rs, 0, 0);
		$expected = '1';
		$this->assertEquals($expected, $actual,'Task update field');
		// Teardown
		$util->revertUser();
	}

}
