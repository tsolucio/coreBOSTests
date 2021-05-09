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
	 * Method testCorrectUpdateAll
	 * @test
	 */
	public function testCorrectUpdateAll() {
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
		$orgValProductsModBy = $preValues['Products']->column_fields['modifiedby'];

		$_REQUEST = array(
			'hidImagePath' => 'themes/softed/images/',
			'convertmode' => '',
			'pagenumber' => '',
			'module' => 'CobroPago',
			'record' => $cypid,
			'mode' => 'edit',
			'action' => 'Save',
			'saverepeat' => '0',
			'parenttab' => 'ptab',
			'return_module' => 'CobroPago',
			'return_id' => $cypid,
			'return_action' => 'DetailView',
			'return_viewname' => '',
			'createmode' => '',
			'cbcustominfo1' => '',
			'cbcustominfo2' => '',
			'Module_Popup_Edit' => '',
			'search_url' => '',
		);
		$_FILES=array();
		$tm = new VTTaskManager($adb);
		$task = $tm->retrieveTask($taskId);
		$this->assertInstanceOf(VTUpdateFieldsTask::class, $task, 'test updateTask module admin');
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$task->doTask($entity);
		$postValues = array();
		$postValues['CobroPago'] = CRMEntity::getInstance('CobroPago');
		$postValues['CobroPago']->retrieve_entity_info($cypid, 'CobroPago');
		$postValues['Products'] = CRMEntity::getInstance('Products');
		$postValues['Products']->retrieve_entity_info(2633, 'Products');
		$postValues['Vendors'] = CRMEntity::getInstance('Vendors');
		$postValues['Vendors']->retrieve_entity_info(2350, 'Vendors');
		unset(
			$postValues['CobroPago']->column_fields['modifiedtime'],
			$postValues['Vendors']->column_fields['modifiedtime'],
			$postValues['Products']->column_fields['modifiedtime']
		);
		$this->assertEquals('wfupdated', $postValues['Vendors']->column_fields['pobox'], 'workflow action Vendors');
		$this->assertEquals('ab', $postValues['Vendors']->column_fields['country'], 'workflow action Vendors');
		$this->assertEquals(223.00, $postValues['Products']->column_fields['unit_price'], 'workflow action Products');
		$postValues['Vendors']->column_fields['pobox'] = $orgValVendorspobox; // undo workflow action
		$postValues['Vendors']->column_fields['country'] = $orgValVendorscountry; // undo workflow action
		$postValues['Products']->column_fields['unit_price'] = $orgValProductsunit_price; // undo workflow action
		$postValues['Products']->column_fields['modifiedby'] = $orgValProductsModBy; // undo workflow action
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
		$this->assertInstanceOf(VTUpdateFieldsTask::class, $task, 'test updateTask modules user');
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
		$this->assertEquals(223.00, $postValues['Products']->column_fields['unit_price'], 'workflow action Products normal user');
		$postValues['Vendors']->column_fields['pobox'] = $orgValVendorspobox; // undo workflow action
		$postValues['Vendors']->column_fields['country'] = $orgValVendorscountry; // undo workflow action
		$postValues['Products']->column_fields['unit_price'] = $orgValProductsunit_price; // undo workflow action
		$postValues['Products']->column_fields['modifiedby'] = $orgValProductsModBy; // undo workflow action
		$this->assertEquals($preValues['CobroPago'], $postValues['CobroPago'], 'CyP after update');
		$this->assertEquals($preValues['Vendors'], $postValues['Vendors'], 'Vendors after update');
		$this->assertEquals($preValues['Products'], $postValues['Products'], 'Products after update');
		$this->assertEquals(223.00, $postPdoPrices[0]['curvalue'], 'Product Prices after update');
		$postPdoPrices[0]['curvalue'] = $orgValProductsunit_price;
		$this->assertEquals((float) $prePdoPrices, (float) $postPdoPrices, 'Product Prices after update');
		$this->assertEquals($preTaxDetails, $postTaxDetails, 'Product Taxes after update');
		// Teardown
		$adb->pquery('update vtiger_crmentity set smownerid=? where crmid=?', array('6', $cypid));
		$adb->pquery('update vtiger_vendor set pobox=?, country=? where vendorid=?', array($orgValVendorspobox, $orgValVendorscountry, 2350));
		$adb->pquery('update vtiger_products set unit_price=? where productid=?', array($orgValProductsunit_price, 2633));
		$util->revertUser();
		$_REQUEST = array();
	}

	public function testCorrectUpdateRelatedToInventoryModule() {
		global $adb, $current_user;

		$util = new VTWorkflowUtils();
		$adminUser = $util->adminUser();
		$current_user = $adminUser;
		$taskId = 35; // Update related records InventoryDetails
		$InvDetWSID = '36x';
		$preValues = array();
		$preValues['SalesOrder'] = CRMEntity::getInstance('SalesOrder');
		$preValues['SalesOrder']->retrieve_entity_info(10655, 'SalesOrder');
		$preValues['InvDet1'] = CRMEntity::getInstance('InventoryDetails');
		$preValues['InvDet1']->retrieve_entity_info(10656, 'InventoryDetails');
		$preValues['InvDet2'] = CRMEntity::getInstance('InventoryDetails');
		$preValues['InvDet2']->retrieve_entity_info(10657, 'InventoryDetails');
		$preValues['Products'] = CRMEntity::getInstance('Products');
		$preValues['Products']->retrieve_entity_info(2617, 'Products');
		$prePdoPrices = getPriceDetailsForProduct(2617, 3.89, 'available', 'Products');
		$prePdoTaxDetails = getTaxDetailsForProduct(2617, 'available_associated');
		$preValues['Services'] = CRMEntity::getInstance('Services');
		$preValues['Services']->retrieve_entity_info(9752, 'Services');
		$preSrvPrices = getPriceDetailsForProduct(9752, 3.89, 'available', 'Services');
		$preSrvTaxDetails = getTaxDetailsForProduct(9752, 'available_associated');
		unset(
			$preValues['InvDet1']->column_fields['modifiedtime'],
			$preValues['InvDet2']->column_fields['modifiedtime'],
			$preValues['Services']->column_fields['modifiedtime'],
			$preValues['Products']->column_fields['modifiedtime']
		);
		$orgValSrvDesc = $preValues['Services']->column_fields['website'];
		$orgValPdoMfr = $preValues['Products']->column_fields['mfr_part_no'];

		$_REQUEST = array(
			'hidImagePath' => 'themes/softed/images/',
			'convertmode' => '',
			'pagenumber' => '',
			'module' => 'SalesOrder',
			'record' => '10655',
			'mode' => 'edit',
			'action' => 'Save',
			'saverepeat' => '0',
			'parenttab' => 'ptab',
			'return_module' => 'SalesOrder',
			'return_id' => '10655',
			'return_action' => 'DetailView',
			'return_viewname' => '',
			'createmode' => '',
			'cbcustominfo1' => '',
			'cbcustominfo2' => '',
			'Module_Popup_Edit' => '',
			'search_url' => '',
			'subject' => 'Handsaw (Power Tools)',
			'potential_name' => 'Auctor Mauris Company',
			'potential_id' => '5535',
			'customerno' => '777798232-00008',
			'salesorder_no' => 'SO8',
			'quote_name' => 'Obadiah Shaw',
			'quote_id' => '12153',
			'vtiger_purchaseorder' => '',
			'contact_name' => 'Gearldine Gellinger',
			'contact_id' => '1466',
			'duedate' => '2015-05-05',
			'carrier' => 'FedEx',
			'pending' => '',
			'sostatus' => 'Created',
			'salescommission' => '0.000',
			'exciseduty' => '0.000',
			'account_name' => 'Automation Engrg & Mfg Inc',
			'account_id' => '10654',
			'assigntype' => 'U',
			'assigned_user_id' => '11',
			'assigned_group_id' => '3',
			'recurring_frequency' => '--None--',
			'start_period' => '2019-03-03',
			'end_period' => '2019-03-03',
			'payment_duration' => 'Net 30 days',
			'invoicestatus' => 'AutoCreated',
			'bill_street' => '1 Back Canning St',
			'ship_street' => '1 Back Canning St',
			'bill_pobox' => '',
			'ship_pobox' => '',
			'bill_city' => 'Dunblane and Bridge of Allan W',
			'ship_city' => 'Dunblane and Bridge of Allan W',
			'bill_state' => 'Stirling',
			'ship_state' => 'Stirling',
			'bill_code' => 'FK9 4LD',
			'ship_code' => 'FK9 4LD',
			'bill_country' => 'United Kingdom',
			'ship_country' => 'United Kingdom',
			'terms_conditions' => '',
			'tandc_type' => 'cbTermConditions',
			'tandc' => '',
			'tandc_display' => '',
			'description' => '',
			'inventory_currency' => '1',
			'taxtype' => 'group',
			'deleted1' => '0',
			'lineitem_id1' => '1236',
			'hidtax_row_no1' => '',
			'productName1' => 'Design',
			'hdnProductId1' => '9752',
			'lineItemType1' => 'Services',
			'subproduct_ids1' => '',
			'comment1' => '',
			'qty1' => '10.00',
			'listPrice1' => '30.90',
			'discount_type1' => 'zero',
			'discount1' => 'on',
			'discount_percentage1' => '0',
			'discount_amount1' => '0',
			'tax1_percentage1' => '14.500',
			'popup_tax_row1' => '347.63',
			'tax3_percentage1' => '112.500',
			'deleted2' => '0',
			'lineitem_id2' => '1237',
			'hidtax_row_no2' => '1',
			'productName2' => 'New FULL HD 1080P Car Video Recorder With G-Sensor and 24H Parking mode',
			'hdnProductId2' => '2617',
			'lineItemType2' => 'Products',
			'subproduct_ids2' => '',
			'comment2' => '',
			'qty2' => '1.00',
			'listPrice2' => '41.82',
			'discount_type2' => 'zero',
			'discount2' => 'on',
			'discount_percentage2' => '0',
			'discount_amount2' => '0',
			'tax1_percentage2' => '14.500',
			'popup_tax_row2' => '47.05',
			'tax3_percentage2' => '112.500',
			'discount_type_final' => 'zero',
			'discount_final' => 'on',
			'discount_percentage_final' => '0',
			'discount_amount_final' => '0',
			'tax1_group_percentage' => '4.500',
			'tax1_group_amount' => '15.786900000000001',
			'tax2_group_percentage' => '10.000',
			'tax2_group_amount' => '35.082',
			'tax3_group_percentage' => '12.500',
			'tax3_group_amount' => '43.8525',
			'shipping_handling_charge' => '0',
			'shtax1_sh_percent' => '0.00',
			'shtax1_sh_amount' => '0',
			'shtax2_sh_percent' => '0.00',
			'shtax2_sh_amount' => '0',
			'shtax3_sh_percent' => '0.00',
			'shtax3_sh_amount' => '0',
			'adjustmentType' => '+',
			'adjustment' => '0',
			'totalProductCount' => '2',
			'subtotal' => '350.82',
			'total' => '445.54',
		);
		$_FILES=array();
		$tm = new VTTaskManager($adb);
		$task = $tm->retrieveTask($taskId);
		$this->assertInstanceOf(VTUpdateFieldsTask::class, $task, 'test updateTask Inventory Modules admin');
		$entityId = $InvDetWSID.'10656';
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$task->doTask($entity);
		$entityId = $InvDetWSID.'10657';
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$task->doTask($entity);
		$postValues = array();
		$postValues['SalesOrder'] = CRMEntity::getInstance('SalesOrder');
		$postValues['SalesOrder']->retrieve_entity_info(10655, 'SalesOrder');
		$postValues['InvDet1'] = CRMEntity::getInstance('InventoryDetails');
		$postValues['InvDet1']->retrieve_entity_info(10656, 'InventoryDetails');
		$postValues['InvDet2'] = CRMEntity::getInstance('InventoryDetails');
		$postValues['InvDet2']->retrieve_entity_info(10657, 'InventoryDetails');
		$postValues['Products'] = CRMEntity::getInstance('Products');
		$postValues['Products']->retrieve_entity_info(2617, 'Products');
		$pstPdoPrices = getPriceDetailsForProduct(2617, 3.89, 'available', 'Products');
		$pstPdoTaxDetails = getTaxDetailsForProduct(2617, 'available_associated');
		$postValues['Services'] = CRMEntity::getInstance('Services');
		$postValues['Services']->retrieve_entity_info(9752, 'Services');
		$pstSrvPrices = getPriceDetailsForProduct(9752, 3.89, 'available', 'Services');
		$pstSrvTaxDetails = getTaxDetailsForProduct(9752, 'available_associated');
		unset(
			$postValues['InvDet1']->column_fields['modifiedtime'],
			$postValues['InvDet2']->column_fields['modifiedtime'],
			$postValues['Services']->column_fields['modifiedtime'],
			$postValues['Products']->column_fields['modifiedtime']
		);
		$this->assertEquals('testme', $postValues['Services']->column_fields['website'], 'workflow action Service');
		$this->assertEquals('testme', $postValues['Products']->column_fields['mfr_part_no'], 'workflow action Products');
		$postValues['Services']->column_fields['website'] = $orgValSrvDesc; // undo workflow action
		$postValues['Products']->column_fields['mfr_part_no'] = $orgValPdoMfr; // undo workflow action
		$this->assertEquals($preValues['SalesOrder'], $postValues['SalesOrder'], 'SalesOrder after update');
		$this->assertEquals($preValues['InvDet1'], $postValues['InvDet1'], 'InvDet1 after update');
		$this->assertEquals($preValues['InvDet2'], $postValues['InvDet2'], 'InvDet2 after update');
		$this->assertEquals($preValues['Services'], $postValues['Services'], 'Services after update');
		$this->assertEquals($preValues['Products'], $postValues['Products'], 'Products after update');
		// undo workflow
		$adb->pquery('update vtiger_service set website=? where serviceid=?', array($orgValSrvDesc, 9752));
		$adb->pquery('update vtiger_products set mfr_part_no=? where productid=?', array($orgValPdoMfr, 2617));

		// Now with normal user
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(6); // testmdy
		$holduser = $current_user;
		$current_user = $user;

		$preValues = array();
		$preValues['SalesOrder'] = CRMEntity::getInstance('SalesOrder');
		$preValues['SalesOrder']->retrieve_entity_info(10655, 'SalesOrder');
		$preValues['InvDet1'] = CRMEntity::getInstance('InventoryDetails');
		$preValues['InvDet1']->retrieve_entity_info(10656, 'InventoryDetails');
		$preValues['InvDet2'] = CRMEntity::getInstance('InventoryDetails');
		$preValues['InvDet2']->retrieve_entity_info(10657, 'InventoryDetails');
		$preValues['Products'] = CRMEntity::getInstance('Products');
		$preValues['Products']->retrieve_entity_info(2617, 'Products');
		$prePdoPrices = getPriceDetailsForProduct(2617, 3.89, 'available', 'Products');
		$prePdoTaxDetails = getTaxDetailsForProduct(2617, 'available_associated');
		$preValues['Services'] = CRMEntity::getInstance('Services');
		$preValues['Services']->retrieve_entity_info(9752, 'Services');
		$preSrvPrices = getPriceDetailsForProduct(9752, 3.89, 'available', 'Services');
		$preSrvTaxDetails = getTaxDetailsForProduct(9752, 'available_associated');
		unset(
			$preValues['InvDet1']->column_fields['modifiedtime'],
			$preValues['InvDet2']->column_fields['modifiedtime'],
			$preValues['Services']->column_fields['modifiedtime'],
			$preValues['Products']->column_fields['modifiedtime']
		);
		$tm = new VTTaskManager($adb);
		$task = $tm->retrieveTask($taskId);
		$this->assertInstanceOf(VTUpdateFieldsTask::class, $task, 'test updateTask Inventory Modules user');
		$entityId = $InvDetWSID.'10656';
		$entity = new VTWorkflowEntity($current_user, $entityId);
		$task->doTask($entity);
		$entityId = $InvDetWSID.'10657';
		$entity = new VTWorkflowEntity($current_user, $entityId);
		$task->doTask($entity);
		$postValues = array();
		$postValues['SalesOrder'] = CRMEntity::getInstance('SalesOrder');
		$postValues['SalesOrder']->retrieve_entity_info(10655, 'SalesOrder');
		$postValues['InvDet1'] = CRMEntity::getInstance('InventoryDetails');
		$postValues['InvDet1']->retrieve_entity_info(10656, 'InventoryDetails');
		$postValues['InvDet2'] = CRMEntity::getInstance('InventoryDetails');
		$postValues['InvDet2']->retrieve_entity_info(10657, 'InventoryDetails');
		$postValues['Products'] = CRMEntity::getInstance('Products');
		$postValues['Products']->retrieve_entity_info(2617, 'Products');
		$pstPdoPrices = getPriceDetailsForProduct(2617, 3.89, 'available', 'Products');
		$pstPdoTaxDetails = getTaxDetailsForProduct(2617, 'available_associated');
		$postValues['Services'] = CRMEntity::getInstance('Services');
		$postValues['Services']->retrieve_entity_info(9752, 'Services');
		$pstSrvPrices = getPriceDetailsForProduct(9752, 3.89, 'available', 'Services');
		$pstSrvTaxDetails = getTaxDetailsForProduct(9752, 'available_associated');
		unset(
			$postValues['InvDet1']->column_fields['modifiedtime'],
			$postValues['InvDet2']->column_fields['modifiedtime'],
			$postValues['Services']->column_fields['modifiedtime'],
			$postValues['Products']->column_fields['modifiedtime']
		);
		$this->assertEquals('testme', $postValues['Services']->column_fields['website'], 'workflow action Service');
		$this->assertEquals('', $postValues['Products']->column_fields['mfr_part_no'], 'workflow action Products'); // no access to this field
		$postValues['Services']->column_fields['website'] = $orgValSrvDesc; // undo workflow action
		$postValues['Products']->column_fields['mfr_part_no'] = ''; // undo workflow action
		$this->assertEquals($preValues['SalesOrder'], $postValues['SalesOrder'], 'SalesOrder after update');
		$this->assertEquals($preValues['InvDet1'], $postValues['InvDet1'], 'InvDet1 after update');
		$this->assertEquals($preValues['InvDet2'], $postValues['InvDet2'], 'InvDet2 after update');
		$this->assertEquals($preValues['Services'], $postValues['Services'], 'Services after update');
		$this->assertEquals($preValues['Products'], $postValues['Products'], 'Products after update');
		// undo workflow
		$adb->pquery('update vtiger_service set website=? where serviceid=?', array($orgValSrvDesc, 9752));
		$adb->pquery('update vtiger_products set mfr_part_no=? where productid=?', array($orgValPdoMfr, 2617));
		$util->revertUser();
		$_REQUEST = array();
	}
}
