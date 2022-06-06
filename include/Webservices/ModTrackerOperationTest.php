<?php
/*************************************************************************************************
 * Copyright 2020 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

include_once 'include/Webservices/ModTrackerOperation.php';

class ModTrackerOperationTest extends TestCase {

	/**
	 * Method testInstance
	 * @test
	 */
	public function testInstance() {
		global $current_user, $adb, $log;
		$webserviceObject = VtigerWebserviceObject::fromName($adb, 'ModTracker');
		$obj = new ModTrackerOperation($webserviceObject, $current_user, $adb, $log);
		$this->assertEquals('ModTrackerOperation', get_class($obj), 'Class instantiated correctly');
	}

	/**
	 * Method testRetrieve
	 * @test
	 */
	public function testRetrieve() {
		global $current_user, $adb, $log;
		$webserviceObject = VtigerWebserviceObject::fromName($adb, 'ModTracker');
		$obj = new ModTrackerOperation($webserviceObject, $current_user, $adb, $log);
		$actual = $obj->retrieve('57x2');
		$expected = array(
			'id' => '57x2',
			'crmid' => '11x74',
			'module' => 'Accounts',
			'whodid' => '19x1',
			'changedon' => '2016-03-15 14:40:50.000000',
			'status' => '0',
			'fieldname' => 'cf_732',
			'prevalue' => '',
			'postvalue' => 'Adipose 3 |##| Chronos |##| Earth',
		);
		$this->assertEquals($expected, $actual, 'ModTracker Retrieve');
	}

	/**
	 * Method testMassRetrieve
	 * @test
	 */
	public function testMassRetrieve() {
		global $current_user, $adb, $log;
		$webserviceObject = VtigerWebserviceObject::fromName($adb, 'ModTracker');
		$obj = new ModTrackerOperation($webserviceObject, $current_user, $adb, $log);
		$actual = $obj->massRetrieve(['57x2','57x4']);
		$expected = array(
			array(
				'id' => '57x2',
				'crmid' => '11x74',
				'module' => 'Accounts',
				'whodid' => '19x1',
				'changedon' => '2016-03-15 14:40:50.000000',
				'status' => '0',
				'fieldname' => 'cf_732',
				'prevalue' => '',
				'postvalue' => 'Adipose 3 |##| Chronos |##| Earth',
			),
			array(
				'id' => '57x4',
				'crmid' => '12x1094',
				'module' => 'Contacts',
				'whodid' => '19x1',
				'changedon' => '2016-04-02 18:14:42.000000',
				'status' => '2',
				'fieldname' => 'account_id',
				'prevalue' => '84',
				'postvalue' => '74',
			),
		);
		$this->assertEquals($expected, $actual, 'ModTracker massRetrieve');
	}

	/**
	 * Method testRetrieveNotFound
	 * @test
	 */
	public function testRetrieveNotFound() {
		global $current_user, $adb, $log;
		$webserviceObject = VtigerWebserviceObject::fromName($adb, 'ModTracker');
		$obj = new ModTrackerOperation($webserviceObject, $current_user, $adb, $log);
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$RECORDNOTFOUND);
		$obj->retrieve('57x9999999999');
	}

	/**
	 * Method testgetSQL
	 * @test
	 */
	public function testgetSQL() {
		global $current_user, $adb, $log;
		$webserviceObject = VtigerWebserviceObject::fromName($adb, 'ModTracker');
		$obj = new ModTrackerOperation($webserviceObject, $current_user, $adb, $log);
		$actual = $obj->wsVTQL2SQL("select * from ModTracker where crmid='11x113';", $meta, $qrel);
		$expected = 'SELECT vtiger_modtracker_basic.id,vtiger_modtracker_basic.crmid,vtiger_modtracker_basic.module,vtiger_modtracker_basic.whodid,vtiger_modtracker_basic.changedon,vtiger_modtracker_basic.status,vtiger_modtracker_detail.fieldname,vtiger_modtracker_detail.prevalue,vtiger_modtracker_detail.postvalue FROM vtiger_modtracker_basic LEFT JOIN vtiger_modtracker_detail ON vtiger_modtracker_basic.id=vtiger_modtracker_detail.id  WHERE (vtiger_modtracker_basic.crmid = 113)  LIMIT 100;';
		$this->assertEquals($expected, $actual, 'ModTracker wsVTQL2SQL');
	}

	/**
	 * Method testQuery
	 * @test
	 */
	public function testQuery() {
		global $current_user, $adb, $log;
		$webserviceObject = VtigerWebserviceObject::fromName($adb, 'ModTracker');
		$obj = new ModTrackerOperation($webserviceObject, $current_user, $adb, $log);
		$actual = $obj->query("select * from ModTracker where crmid='11x113';");
		$expected = array(
			array(
				'id' => '57x18',
				'crmid' => '11x113',
				'module' => 'Accounts',
				'whodid' => '19x1',
				'changedon' => '2017-07-06 23:35:21.000000',
				'status' => '2',
				'fieldname' => 'assigned_user_id',
				'prevalue' => '10',
				'postvalue' => '1',
			),
			array(
				'id' => '57x18',
				'crmid' => '11x113',
				'module' => 'Accounts',
				'whodid' => '19x1',
				'changedon' => '2017-07-06 23:35:21.000000',
				'status' => '2',
				'fieldname' => 'cf_719',
				'prevalue' => '',
				'postvalue' => '0.00',
			),
			array(
				'id' => '57x18',
				'crmid' => '11x113',
				'module' => 'Accounts',
				'whodid' => '19x1',
				'changedon' => '2017-07-06 23:35:21.000000',
				'status' => '2',
				'fieldname' => 'cf_720',
				'prevalue' => '',
				'postvalue' => '0.00',
			),
			array(
				'id' => '57x18',
				'crmid' => '11x113',
				'module' => 'Accounts',
				'whodid' => '19x1',
				'changedon' => '2017-07-06 23:35:21.000000',
				'status' => '2',
				'fieldname' => 'cf_721',
				'prevalue' => '',
				'postvalue' => '0.000000',
			),
			array(
				'id' => '57x18',
				'crmid' => '11x113',
				'module' => 'Accounts',
				'whodid' => '19x1',
				'changedon' => '2017-07-06 23:35:21.000000',
				'status' => '2',
				'fieldname' => 'cf_728',
				'prevalue' => '',
				'postvalue' => '00:00:00',
			),
		);
		$this->assertEquals($expected, $actual, 'ModTracker Query');
		$this->assertEquals(5, $obj->getQueryTotalRows(), 'ModTracker getQueryTotalRows');
	}

	/**
	 * Method testIncorrectQuerySyntax
	 * @test
	 */
	public function testIncorrectQuerySyntax() {
		global $current_user, $adb, $log;
		$webserviceObject = VtigerWebserviceObject::fromName($adb, 'ModTracker');
		$obj = new ModTrackerOperation($webserviceObject, $current_user, $adb, $log);
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$QUERYSYNTAX);
		$obj->query('select * from ModTracker where crmid=113');
	}

	/**
	 * Method testIncorrectQueryID
	 * @test
	 */
	public function testIncorrectQueryID() {
		global $current_user, $adb, $log;
		$webserviceObject = VtigerWebserviceObject::fromName($adb, 'ModTracker');
		$obj = new ModTrackerOperation($webserviceObject, $current_user, $adb, $log);
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALIDID);
		$obj->query('select * from ModTracker where crmid=113;');
	}

	/**
	 * Method testDescribe
	 * @test
	 */
	public function testDescribe() {
		global $current_user, $adb, $log;
		$webserviceObject = VtigerWebserviceObject::fromName($adb, 'ModTracker');
		$obj = new ModTrackerOperation($webserviceObject, $current_user, $adb, $log);
		$actual = $obj->describe('ModTracker');
		$expected = array(
			'label'=>getTranslatedString('ModTracker', 'ModTracker'),
			'label_raw'=>'ModTracker',
			'name'=>'ModTracker',
			'createable'=>false,
			'updateable'=>false,
			'deleteable'=>false,
			'retrieveable'=>true,
			'fields'=>array(
				array(
					'name' => 'id',
					'label' => 'id',
					'label_raw' => 'id',
					'mandatory' => false,
					'editable' => false,
					'type' => array('name' => 'autogenerated'),
					'nullable' => false,
					'default' => '',
				),
				array(
					'name' => 'crmid',
					'label' => 'crmid',
					'label_raw' => 'crmid',
					'mandatory' => false,
					'type' => array(
						'name' => 'reference',
						'refersTo' => array(
							'Assets',
							'AutoNumberPrefix',
							'BusinessActions',
							'cbMap',
							'cbQuestion',
							'Campaigns',
							'ModComments',
							'cbCompany',
							'Contacts',
							'cbupdater',
							'cbCredentials',
							'DocumentFolders',
							'Documents',
							'Faq',
							'GlobalVariable',
							'InventoryDetails',
							'Invoice',
							'Leads',
							'MsgTemplate',
							'Messages',
							'Potentials',
							'Accounts',
							'CobroPago',
							'PBXManager',
							'PriceBooks',
							'pricebookproductrel',
							'ProductComponent',
							'Products',
							'ProjectMilestone',
							'ProjectTask',
							'Project',
							'cbPulse',
							'PurchaseOrder',
							'Quotes',
							'SalesOrder',
							'ServiceContracts',
							'Services',
							'SMSNotifier',
							'HelpDesk',
							'cbSurveyQuestion',
							'cbSurvey',
							'cbSurveyAnswer',
							'cbSurveyDone',
							'cbTermConditions',
							'cbCalendar',
							'cbtranslation',
							'Vendors',
							'cbCVManagement',
						),
						'picklistValues' => array(
							array(
								'value' => '22x11',
								'label' => 'Application Templates',
							),
							array(
								'value' => '22x2',
								'label' => 'Avengers',
							),
							array(
								'value' => '22x1',
								'label' => 'Default',
							),
							array(
								'value' => '22x10',
								'label' => 'Excalibur',
							),
							array(
								'value' => '22x6',
								'label' => 'Fantastic Four',
							),
							array(
								'value' => '22x7',
								'label' => 'Guardians',
							),
							array(
								'value' => '22x8',
								'label' => 'Omega Flight',
							),
							array(
								'value' => '22x9',
								'label' => 'S.H.I.E.L.D.',
							),
							array(
								'value' => '22x4',
								'label' => 'The Defenders',
							),
							array(
								'value' => '22x5',
								'label' => 'The Invaders',
							),
							array(
								'value' => '22x3',
								'label' => 'X-Men',
							),
						),
					),
					'nullable' => true,
					'editable' => true,
				),
				array(
					'name' => 'module',
					'label' => 'module',
					'label_raw' => 'module',
					'mandatory' => false,
					'type' => array('name' => 'string'),
					'nullable' => true,
					'editable' => true,
				),
				array(
					'name' => 'whodid',
					'label' => 'User Name',
					'label_raw' => 'whodid',
					'mandatory' => false,
					'type' => array(
						'name' => 'reference',
						'refersTo' => array('Users'),
					),
					'nullable' => true,
					'editable' => true,
				),
				array(
					'name' => 'changedon',
					'label' => 'Modified On',
					'label_raw' => 'changedon',
					'mandatory' => false,
					'type' => array('name' => 'datetime'),
					'nullable' => true,
					'editable' => true,
				),
				array(
					'name' => 'status',
					'label' => 'status',
					'label_raw' => 'status',
					'mandatory' => false,
					'type' => array('name' => 'integer'),
					'nullable' => true,
					'editable' => true,
					'default' => 0,
				),
				array(
					'name' => 'fieldname',
					'label' => 'fieldname',
					'label_raw' => 'fieldname',
					'mandatory' => false,
					'type' => array('name' => 'string'),
					'nullable' => false,
					'editable' => true,
				),
				array(
					'name' => 'prevalue',
					'label' => 'prevalue',
					'label_raw' => 'prevalue',
					'mandatory' => false,
					'type' => array('name' => 'text'),
					'nullable' => true,
					'editable' => true,
				),
				array(
					'name' => 'postvalue',
					'label' => 'postvalue',
					'label_raw' => 'postvalue',
					'mandatory' => false,
					'type' => array('name' => 'text'),
					'nullable' => true,
					'editable' => true,
				),
			),
			'idPrefix'=>'57',
			'isEntity'=>false,
			'labelFields'=>'',
		);
		$this->assertEquals($expected, $actual, 'ModTracker Describe');
	}

	/**
	 * Method testgetFilterFields
	 * @test
	 */
	public function testgetFilterFields() {
		global $current_user, $adb, $log;
		$webserviceObject = VtigerWebserviceObject::fromName($adb, 'ModTracker');
		$obj = new ModTrackerOperation($webserviceObject, $current_user, $adb, $log);
		$actual = $obj->getFilterFields('ModTracker');
		$expected = array(
			'fields'=> array('id','module','crmid','fieldname','prevalue','postvalue','first_name','last_name'),
			'linkfields'=>array('id'),
			'pagesize' => intval(GlobalVariable::getVariable('Application_ListView_PageSize', 20, 'ModTracker')),
		);
		$this->assertEquals($expected, $actual, 'ModTracker getFilterFields');
	}

	/**
	 * Method testCreateException
	 * @test
	 */
	public function testCreateException() {
		global $current_user, $adb, $log;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$OPERATIONNOTSUPPORTED);
		$webserviceObject = VtigerWebserviceObject::fromName($adb, 'ModTracker');
		$obj = new ModTrackerOperation($webserviceObject, $current_user, $adb, $log);
		$obj->create('ModTracker', array());
	}

	/**
	 * Method testUpdateException
	 * @test
	 */
	public function testUpdateException() {
		global $current_user, $adb, $log;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$OPERATIONNOTSUPPORTED);
		$webserviceObject = VtigerWebserviceObject::fromName($adb, 'ModTracker');
		$obj = new ModTrackerOperation($webserviceObject, $current_user, $adb, $log);
		$obj->update(array());
	}

	/**
	 * Method testReviseException
	 * @test
	 */
	public function testReviseException() {
		global $current_user, $adb, $log;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$OPERATIONNOTSUPPORTED);
		$webserviceObject = VtigerWebserviceObject::fromName($adb, 'ModTracker');
		$obj = new ModTrackerOperation($webserviceObject, $current_user, $adb, $log);
		$obj->revise(array());
	}

	/**
	 * Method testDeleteException
	 * @test
	 */
	public function testDeleteException() {
		global $current_user, $adb, $log;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$OPERATIONNOTSUPPORTED);
		$webserviceObject = VtigerWebserviceObject::fromName($adb, 'ModTracker');
		$obj = new ModTrackerOperation($webserviceObject, $current_user, $adb, $log);
		$obj->delete('id');
	}
}
?>