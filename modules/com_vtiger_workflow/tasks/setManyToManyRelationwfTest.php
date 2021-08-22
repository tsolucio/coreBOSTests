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

include_once 'modules/com_vtiger_workflow/tasks/setManyToManyRelationwf.inc';

class setManyToManyRelationwfTest extends TestCase {

	/**
	 * Method testsetMM
	 * @test
	 */
	public function testsetMM() {
		global $adb, $current_user;
		$entityId = '12x2021';
		$crmId = 2021;
		// we make sure there are no related products
		$adb->pquery('delete from vtiger_seproductsrel where crmid=?', array($crmId));
		// now we launch the task
		$util = new VTWorkflowUtils();
		$adminUser = $util->adminUser();
		$current_user = $adminUser;
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$task = new setManyToManyRelationwf();
		$task->relAction = 'addrel';
		$task->idlist = '2619,2620';
		$task->doTask($entity);
		$rs = $adb->pquery('select 1 from vtiger_seproductsrel where crmid=?', array($crmId));
		$this->assertEquals(2, $adb->num_rows($rs), 'Task set related');
		$task->relAction = 'delrel';
		$entity->WorkflowContext['SetManyToManyRelation_Records'] = array(2619,2620);
		$task->doTask($entity);
		$rs = $adb->pquery('select 1 from vtiger_seproductsrel where crmid=?', array($crmId));
		$this->assertEquals(0, $adb->num_rows($rs), 'Task del related');
		$task->relAction = 'addrel';
		$entity->WorkflowContext['SetManyToManyRelation_Records'] = '2619,2620,2621';
		$task->doTask($entity);
		$rs = $adb->pquery('select 1 from vtiger_seproductsrel where crmid=?', array($crmId));
		$this->assertEquals(3, $adb->num_rows($rs), 'Task set related');
		$task->relAction = 'delAllrel';
		unset($entity->WorkflowContext['SetManyToManyRelation_Records']);
		$task->idlist = '2619';
		$task->doTask($entity);
		$rs = $adb->pquery('select 1 from vtiger_seproductsrel where crmid=?', array($crmId));
		$this->assertEquals(0, $adb->num_rows($rs), 'Task del all related');
		// Teardown
		$util->revertUser();
	}

	/**
	 * Method testsetMMwithContextRecord
	 * @test
	 */
	public function testsetMMwithContextRecord() {
		global $adb, $current_user;
		$entityId = '12x2021';
		$crmId = 2021;
		$crmId2 = 2022;
		// we make sure there are no related products
		$adb->pquery('delete from vtiger_seproductsrel where crmid=?', array($crmId));
		$adb->pquery('delete from vtiger_seproductsrel where crmid=?', array($crmId2));
		// now we launch the task
		$util = new VTWorkflowUtils();
		$adminUser = $util->adminUser();
		$current_user = $adminUser;
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$task = new setManyToManyRelationwf();
		$task->relAction = 'addrel';
		$task->idlist = '2619,2620';
		$entity->WorkflowContext['SetManyToManyRelation_Record'] = $crmId2;
		$task->doTask($entity);
		$rs = $adb->pquery('select 1 from vtiger_seproductsrel where crmid=?', array($crmId));
		$this->assertEquals(0, $adb->num_rows($rs), 'Task set related');
		$rs = $adb->pquery('select 1 from vtiger_seproductsrel where crmid=?', array($crmId2));
		$this->assertEquals(2, $adb->num_rows($rs), 'Task set related');
		$task->relAction = 'delrel';
		$entity->WorkflowContext['SetManyToManyRelation_Record'] = $crmId2;
		$task->doTask($entity);
		$rs = $adb->pquery('select 1 from vtiger_seproductsrel where crmid=?', array($crmId));
		$this->assertEquals(0, $adb->num_rows($rs), 'Task del related');
		$rs = $adb->pquery('select 1 from vtiger_seproductsrel where crmid=?', array($crmId2));
		$this->assertEquals(0, $adb->num_rows($rs), 'Task del related');
		$task->relAction = 'addrel';
		$entity->WorkflowContext['SetManyToManyRelation_Records'] = '2619,2620,2621';
		$entity->WorkflowContext['SetManyToManyRelation_Record'] = $crmId2;
		$task->doTask($entity);
		$rs = $adb->pquery('select 1 from vtiger_seproductsrel where crmid=?', array($crmId));
		$this->assertEquals(0, $adb->num_rows($rs), 'Task del related');
		$rs = $adb->pquery('select 1 from vtiger_seproductsrel where crmid=?', array($crmId2));
		$this->assertEquals(3, $adb->num_rows($rs), 'Task set related');
		$task->relAction = 'delAllrel';
		unset($entity->WorkflowContext['SetManyToManyRelation_Records']);
		$task->idlist = '2619';
		$task->doTask($entity);
		$rs = $adb->pquery('select 1 from vtiger_seproductsrel where crmid=?', array($crmId));
		$this->assertEquals(0, $adb->num_rows($rs), 'Task del all related');
		$rs = $adb->pquery('select 1 from vtiger_seproductsrel where crmid=?', array($crmId2));
		$this->assertEquals(0, $adb->num_rows($rs), 'Task set related');
		// Teardown
		$util->revertUser();
	}
}
