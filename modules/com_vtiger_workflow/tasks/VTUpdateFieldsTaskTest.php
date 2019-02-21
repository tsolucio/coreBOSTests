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

class VTUpdateFieldsTaskTest extends TestCase {

	/**
	 * Method testCorrectUpdate
	 * @test
	 */
	public function testCorrectUpdate() {
		global $adb, $current_user;
		$preValues = CRMEntity::getInstance('InventoryDetails');
		$preValues->retrieve_entity_info(2823, 'InventoryDetails');
		unset($preValues->column_fields['modifiedtime']);
		// Using Inventory Lines existing workflow update task we force a launch and check the update result
		$taskId = 14; // line complete inventory details update task
		$InventoryDetailsWSID = '36x';
		$entityId = $InventoryDetailsWSID.'2823';
		// we make sure the line completed value is false and the quantity and units received are the same so the task is launched
		$adb->pquery('update vtiger_inventorydetails set line_completed=?, units_delivered_received=3, quantity=3 where inventorydetailsid=?', array('0',2823));
		// now we launch the task
		$util = new VTWorkflowUtils();
		$adminUser = $util->adminUser();
		$current_user = $adminUser;
		$tm = new VTTaskManager($adb);
		$task = $tm->retrieveTask($taskId);
		$this->assertInstanceOf(VTUpdateFieldsTask::class, $task, 'test retrieveTask');
		list($moduleId, $crmId) = explode('x', $entityId);
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$task->doTask($entity);
		$rs = $adb->pquery('select line_completed from vtiger_inventorydetails where inventorydetailsid=?', array($crmId));
		$actual = $adb->query_result($rs, 0, 0);
		$expected = '1';
		$this->assertEquals($expected, $actual, 'Task update field');
		// Teardown
		$util->revertUser();
		$postValues = CRMEntity::getInstance('InventoryDetails');
		$postValues->retrieve_entity_info(2823, 'InventoryDetails');
		unset($postValues->column_fields['modifiedtime']);
		$this->assertEquals($preValues, $postValues, 'Task update record does not change');
		// Now with normal user that has restricted access to some fields
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(6); // testmdy
		$holduser = $current_user;
		$current_user = $user;
		$preValues = CRMEntity::getInstance('InventoryDetails');
		$preValues->retrieve_entity_info(2823, 'InventoryDetails');
		unset($preValues->column_fields['modifiedtime']);
		$adb->pquery('update vtiger_inventorydetails set line_completed=?, units_delivered_received=3, quantity=3 where inventorydetailsid=?', array('0',2823));
		$tm = new VTTaskManager($adb);
		$task = $tm->retrieveTask($taskId);
		$this->assertInstanceOf(VTUpdateFieldsTask::class, $task, 'test retrieveTask');
		list($moduleId, $crmId) = explode('x', $entityId);
		$entity = new VTWorkflowEntity($current_user, $entityId);
		$task->doTask($entity);
		$rs = $adb->pquery('select line_completed from vtiger_inventorydetails where inventorydetailsid=?', array($crmId));
		$actual = $adb->query_result($rs, 0, 0);
		$expected = '1';
		$this->assertEquals($expected, $actual, 'Task update field');
		// Teardown
		$postValues = CRMEntity::getInstance('InventoryDetails');
		$postValues->retrieve_entity_info(2823, 'InventoryDetails');
		unset($postValues->column_fields['modifiedtime']);
		$this->assertEquals($preValues, $postValues, 'Task update record does not change');
		$current_user = $holduser;
	}

	public function testCorrectUpdateAssignedTo() {
		global $adb, $current_user;

		$taskId = 28; //  Update Assigned to  task id
		$HelpDeskWSID = '17x';
		$lastcrmid='2780';// the id of the last HelpDesk Record partially created due to the error on the next wf
		$preValues = CRMEntity::getInstance('HelpDesk');
		$preValues->retrieve_entity_info($lastcrmid, 'HelpDesk');
		unset($preValues->column_fields['assigned_user_id'], $preValues->column_fields['modifiedtime']);
		$adb->pquery('update vtiger_crmentity set smownerid=? where crmid=?', array('1',$lastcrmid));
		$entityId = $HelpDeskWSID.$lastcrmid;
		$util = new VTWorkflowUtils();
		$adminUser = $util->adminUser();
		$current_user = $adminUser;
		$tm = new VTTaskManager($adb);
		$task = $tm->retrieveTask($taskId);
		$this->assertInstanceOf(VTUpdateFieldsTask::class, $task, 'test retrieveTask');
		list($moduleId, $crmId) = explode('x', $entityId);
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$task->doTask($entity);
		$actual=$entity->get('assigned_user_id');
		$expected = '19x8';
		$this->assertEquals($expected, $actual, 'Task update field assigned_user_id');
		//execute the wf task for HelpDesk_notifyOwnerOnTicketChange to test the value of assigned_user_id
		$taskId = 9;
		$util = new VTWorkflowUtils();
		$adminUser = $util->adminUser();
		$current_user = $adminUser;
		$tm = new VTTaskManager($adb);
		$task = $tm->retrieveTask($taskId);
		$this->assertInstanceOf(VTEntityMethodTask::class, $task, 'test retrieveTask');
		list($moduleId, $crmId) = explode('x', $entityId);
		$task->doTask($entity);
		$actual=$entity->get('assigned_user_id');
		$expected = '19x8';
		$this->assertEquals($expected, $actual, 'Task update field assigned_user_id');
		// Teardown
		$util->revertUser();
		$postValues = CRMEntity::getInstance('HelpDesk');
		$postValues->retrieve_entity_info($lastcrmid, 'HelpDesk');
		unset($postValues->column_fields['assigned_user_id'], $postValues->column_fields['modifiedtime']);
		$this->assertEquals($preValues, $postValues, 'HelpDesk update record does not change');
		// Now with normal user
		$taskId = 28; //  Update Assigned to  task id
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(6); // testmdy
		$holduser = $current_user;
		$current_user = $user;
		$adb->pquery('update vtiger_crmentity set smownerid=? where crmid=?', array('6', $lastcrmid));
		$preValues = CRMEntity::getInstance('HelpDesk');
		$preValues->retrieve_entity_info($lastcrmid, 'HelpDesk');
		unset($preValues->column_fields['assigned_user_id'], $preValues->column_fields['modifiedtime']);
		$tm = new VTTaskManager($adb);
		$task = $tm->retrieveTask($taskId);
		$this->assertInstanceOf(VTUpdateFieldsTask::class, $task, 'test retrieveTask');
		list($moduleId, $crmId) = explode('x', $entityId);
		$entity = new VTWorkflowEntity($current_user, $entityId);
		$task->doTask($entity);
		$actual=$entity->get('assigned_user_id');
		$expected = '19x8';
		$this->assertEquals($expected, $actual, 'Task update field assigned_user_id');
		// Teardown
		$adb->pquery('update vtiger_crmentity set smownerid=? where crmid=?', array('6', $lastcrmid));
		$postValues = CRMEntity::getInstance('HelpDesk');
		$postValues->retrieve_entity_info($lastcrmid, 'HelpDesk');
		unset($postValues->column_fields['assigned_user_id'], $postValues->column_fields['modifiedtime']);
		$this->assertEquals($preValues, $postValues, 'HelpDesk update record does not change');
		$current_user = $holduser;
	}

	public function testCorrectUpdateRelatedTo() {
		global $adb, $current_user;

		$util = new VTWorkflowUtils();
		$adminUser = $util->adminUser();
		$current_user = $adminUser;
		$taskId = 34; // Update related records
		$CobroPagoWSID = '28x';
		$cypid = '14501';// the id of the CobroPago Record
		$entityId = $CobroPagoWSID.$cypid;
		$preValues = array();
		$preValues['CobroPago'] = CRMEntity::getInstance('CobroPago');
		$preValues['CobroPago']->retrieve_entity_info($cypid, 'CobroPago');
		$preValues['Products'] = CRMEntity::getInstance('Products');
		$preValues['Products']->retrieve_entity_info(2633, 'Products');
		$prePdoPrices = getPriceDetailsForProduct(2633, 3.89, 'available', 'Products');
		$preTaxDetails = getTaxDetailsForProduct(2633, 'available_associated');
		for ($i=0; $i<count($preTaxDetails); $i++) {
			$tax_value = getProductTaxPercentage($preTaxDetails[$i]['taxname'], 2633);
			$preTaxDetails[$i]['percentage'] = $tax_value;
			$preTaxDetails[$i]['check_value'] = 1;
			if ($tax_value == '') {
				$preTaxDetails[$i]['check_value'] = 0;
				$preTaxDetails[$i]['percentage'] = getTaxPercentage($preTaxDetails[$i]['taxname']);
			}
		}
		$preValues['Vendors'] = CRMEntity::getInstance('Vendors');
		$preValues['Vendors']->retrieve_entity_info(2350, 'Vendors');
		unset($preValues['CobroPago']->column_fields['modifiedtime'], $preValues['Vendors']->column_fields['modifiedtime'], $preValues['Products']->column_fields['modifiedtime']);
		$orgValVendorspobox = $preValues['Vendors']->column_fields['pobox'];
		$orgValVendorscountry = $preValues['Vendors']->column_fields['country'];
		$orgValProductsunit_price = $preValues['Products']->column_fields['unit_price'];

		$tm = new VTTaskManager($adb);
		$task = $tm->retrieveTask($taskId);
		$this->assertInstanceOf(VTUpdateFieldsTask::class, $task, 'test retrieveTask');
		list($moduleId, $crmId) = explode('x', $entityId);
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$task->doTask($entity);
		$postValues = array();
		$postValues['CobroPago'] = CRMEntity::getInstance('CobroPago');
		$postValues['CobroPago']->retrieve_entity_info($cypid, 'CobroPago');
		$postValues['Products'] = CRMEntity::getInstance('Products');
		$postValues['Products']->retrieve_entity_info(2633, 'Products');
		$postValues['Vendors'] = CRMEntity::getInstance('Vendors');
		$postValues['Vendors']->retrieve_entity_info(2350, 'Vendors');
		unset($postValues['CobroPago']->column_fields['modifiedtime'], $postValues['Vendors']->column_fields['modifiedtime'], $postValues['Products']->column_fields['modifiedtime']);
		$this->assertEquals('wfupdated', $postValues['Vendors']->column_fields['pobox'], 'workflow action Vendors');
		$this->assertEquals('ab', $postValues['Vendors']->column_fields['country'], 'workflow action Vendors');
		$this->assertEquals(3.89, $postValues['Products']->column_fields['unit_price'], 'workflow action Products');
		$postValues['Vendors']->column_fields['pobox'] = $orgValVendorspobox; // undo workflow action
		$postValues['Vendors']->column_fields['country'] = $orgValVendorscountry; // undo workflow action
		$postValues['Products']->column_fields['unit_price'] = $orgValProductsunit_price; // undo workflow action
		$this->assertEquals($preValues['CobroPago'], $postValues['CobroPago'], 'CyP after update');
		$this->assertEquals($preValues['Vendors'], $postValues['Vendors'], 'Vendors after update');
		$this->assertEquals($preValues['Products'], $postValues['Products'], 'Products after update');
		// undo workflow
		$adb->pquery('update vtiger_vendor set pobox=?, country=? where vendorid=?', array($orgValVendorspobox, $orgValVendorscountry, 2350));
		$adb->pquery('update vtiger_products set unit_price=? where productid=?', array($orgValProductsunit_price, 2633));

		// Now with normal user
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(6); // testmdy
		$holduser = $current_user;
		$current_user = $user;

		$tm = new VTTaskManager($adb);
		$task = $tm->retrieveTask($taskId);
		$this->assertInstanceOf(VTUpdateFieldsTask::class, $task, 'test retrieveTask');
		list($moduleId, $crmId) = explode('x', $entityId);
		$entity = new VTWorkflowEntity($current_user, $entityId);
		$task->doTask($entity);
		$current_user = $holduser;
		$postValues = array();
		$postValues['CobroPago'] = CRMEntity::getInstance('CobroPago');
		$postValues['CobroPago']->retrieve_entity_info($cypid, 'CobroPago');
		$postValues['Products'] = CRMEntity::getInstance('Products');
		$postValues['Products']->retrieve_entity_info(2633, 'Products');
		$postPdoPrices = getPriceDetailsForProduct(2633, 3.89, 'available', 'Products');
		$postTaxDetails = getTaxDetailsForProduct(2633, 'available_associated');
		for ($i=0; $i<count($postTaxDetails); $i++) {
			$tax_value = getProductTaxPercentage($preTaxDetails[$i]['taxname'], 2633);
			$postTaxDetails[$i]['percentage'] = $tax_value;
			$postTaxDetails[$i]['check_value'] = 1;
			if ($tax_value == '') {
				$postTaxDetails[$i]['check_value'] = 0;
				$postTaxDetails[$i]['percentage'] = getTaxPercentage($postTaxDetails[$i]['taxname']);
			}
		}
		$postValues['Vendors'] = CRMEntity::getInstance('Vendors');
		$postValues['Vendors']->retrieve_entity_info(2350, 'Vendors');
		unset($postValues['CobroPago']->column_fields['modifiedtime'], $postValues['Vendors']->column_fields['modifiedtime'], $postValues['Products']->column_fields['modifiedtime']);
		$this->assertEquals('wfupdated', $postValues['Vendors']->column_fields['pobox'], 'workflow action Vendors normal user');
		$this->assertEquals('ab', $postValues['Vendors']->column_fields['country'], 'workflow action Vendors');
		$this->assertEquals(3.89, $postValues['Products']->column_fields['unit_price'], 'workflow action Products normal user');
		$postValues['Vendors']->column_fields['pobox'] = $orgValVendorspobox; // undo workflow action
		$postValues['Vendors']->column_fields['country'] = $orgValVendorscountry; // undo workflow action
		$postValues['Products']->column_fields['unit_price'] = $orgValProductsunit_price; // undo workflow action
		$this->assertEquals($preValues['CobroPago'], $postValues['CobroPago'], 'CyP after update');
		$this->assertEquals($preValues['Vendors'], $postValues['Vendors'], 'Vendors after update');
		$this->assertEquals($preValues['Products'], $postValues['Products'], 'Products after update');
		$this->assertEquals(3.89, $postPdoPrices[0]['curvalue'], 'Product Prices after update');
		$postPdoPrices[0]['curvalue'] = $orgValProductsunit_price;
		$this->assertEquals($prePdoPrices, $postPdoPrices, 'Product Prices after update');
		$this->assertEquals($preTaxDetails, $postTaxDetails, 'Product Taxes after update');
		// Teardown
		$util->revertUser();
		$adb->pquery('update vtiger_crmentity set smownerid=? where crmid=?', array('6', $cypid));
		$adb->pquery('update vtiger_vendor set pobox=?, country=? where vendorid=?', array($orgValVendorspobox, $orgValVendorscountry, 2350));
		$adb->pquery('update vtiger_products set unit_price=? where productid=?', array($orgValProductsunit_price, 2633));
	}
}
