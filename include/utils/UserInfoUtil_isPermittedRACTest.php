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

/**
 * Test the coreBOS Permission system via isPermitted function and RAC Business Rules
 */
use PHPUnit\Framework\TestCase;

class testUserInfoUtil_isPermittedRACTest extends TestCase {

	/****
	 * TEST Users
	 ****/
	public $testusers = array(
		'usrtestdmy' => 5,
		'usrtestmdy' => 6,
		'usrtestymd' => 7,
		'usrtesttz' => 10,
		'usrnocreate' => 11,
		'usrtestmcurrency' => 12
	);
	public $actionmappingWithRecord = array(
	  'Save',
	  'DetailViewAjax',
	  'EditView',
	  'Delete',
	  'DetailView',
	  'ConvertLead',
	);
	public $actionmappingWithRecordSpecial = array(
	  'SavePriceBook',
	  'SaveVendor',
	  'PriceBookEditView',
	  'VendorEditView',
	  'DeletePriceBook',
	  'DeleteVendor',
	  'PriceBookDetailView',
	  'VendorDetailView',
	);
	public $actionmappingWithoutRecord = array(
	  'QuickCreate',
	  'index',
	  'Popup',
	  'TagCloud',
	  'Import',
	  'Export',
	  'CreateView',
	  'Merge',
	  'DuplicatesHandling'
	);
	public $testmodules = array(
		'Potentials',
		'Accounts',
		'Contacts',
		'Vendors',
		'Leads',
		'HelpDesk',
		'Documents',
		'Products',
		'Quotes',
		'PriceBooks'
	);
	public $testrecords = array(
		'Potentials' => array(5138),
		'Accounts' => array(74),
		'Contacts' => array(1084),
		'Vendors' => array(2216),
		'Leads' => array(4196),
		'HelpDesk' => array(2636),
		'Products' => array(2616,2617),
		'Quotes' => array(11815),
		'PriceBooks' => array(16829)
	);

	public static function setUpBeforeClass() {
		global $adb;
		// activate RAC workflow
		$adb->pquery('update com_vtiger_workflows
			set test=REPLACE(test,\'"fieldname":"ticket_no","operation":"starts with","value":"NO","valuetype":"rawtext"\',\'"fieldname":"ticket_no","operation":"starts with","value":"TT","valuetype":"rawtext"\')
			where module_name=? and summary=?', array('HelpDesk','RAC Tickets'));
	}

	public static function tearDownAfterClass() {
		global $adb;
		// deactivate RAC workflow
		$adb->pquery('update com_vtiger_workflows
			set test=REPLACE(test,\'"fieldname":"ticket_no","operation":"starts with","value":"TT","valuetype":"rawtext"\',\'"fieldname":"ticket_no","operation":"starts with","value":"NO","valuetype":"rawtext"\')
			where module_name=? and summary=?', array('HelpDesk','RAC Tickets'));
	}

	/**
	 * Method permittedActionsProvidor
	 * params
	 */
	public function permittedActionsProvidor() {
		global $adb;
		$return = array();
		foreach ($this->testusers as $uname => $uid) {
			foreach ($this->testmodules as $mname) {
				foreach ($this->actionmappingWithoutRecord as $action) {
					if ($uname == 'usrnocreate' && in_array($action, array('QuickCreate','Export','Import','CreateView'))) {
						$expected = 'no';
					} else {
						$expected = 'yes';
					}
					if ($uname == 'usrnocreate' && $action == 'Merge' && in_array($mname, array('Accounts','Contacts','Leads','HelpDesk'))) {
						$expected = 'no';
					}
					if ($uname == 'usrnocreate' && in_array($action, array('Import','Export')) && in_array($mname, array('Quotes','PriceBooks'))) {
						$expected = 'yes';
					}
					if ($mname=='Documents' && $action=='Import') {
						$expected = 'no';
					}
					$test = array($uid,$action,$mname,'',$expected,$uname.' > '. $mname.' '.$action);
					$return[] = $test;
				}
			}
		}
		foreach ($this->testusers as $uname => $uid) {
			foreach ($this->testrecords as $mname => $mrecords) {
				foreach ($this->actionmappingWithRecord as $action) {
					if ($action=='ConvertLead' && $mname != 'Leads') {
						continue;
					}
					foreach ($mrecords as $crmid) {
						if ($mname=='Products' || $mname=='HelpDesk') {
							$ownerrs = $adb->pquery('select smownerid from vtiger_crmentity where crmid=?', array($crmid));
							$owner = $adb->query_result($ownerrs, 0, 0);
							if ($owner==$uid) {
								$expected = 'yes';
							} else {
								$expected = 'no';
							}
						} else {
							$expected = 'yes';
						}
						if ($action=='ConvertLead' && $uname != 'usrnocreate') {
							$expected = 'yes';
						}
						if ($uname == 'usrnocreate' && in_array($action, array('DetailViewAjax','EditView','Delete','Save'))) {
							$expected = 'no';
						}
						$test = array($uid,$action,$mname,$crmid,$expected,$uname.' > '. $mname.' '.$action.' '.$crmid);
						$return[] = $test;
					}
				}
			}
		}
		return $return;
	}

	/**
	 * Method testThatWeHaveNotBrokenAnything
	 * @test
	 * @dataProvider permittedActionsProvidor
	 */
	public function testThatWeHaveNotBrokenAnything($testuser, $actionname, $module, $crmid, $expected, $message) {
		global $current_user;
		$hold_user = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($testuser);
		$current_user = $user;
		if (!empty($crmid) && is_numeric($crmid)) {
			$actual = isPermitted($module, $actionname, $crmid);
		} else {
			$actual = isPermitted($module, $actionname);
		}
		$this->assertEquals($expected, $actual, "testpermittedActions $message");
		$current_user = $hold_user;
	}

	/**
	 * Method testpermittedRAC
	 * @test
	 */
	public function testpermittedRAC() {
		global $current_user;
		$hold_user = $current_user;
		$user = new Users();

		// HelpDesk 2636
		// > smownerid 'usrtestdmy' => 5
		// > Product PRO2 => 2617
		//   > smownerid 'usrtestes' => 8
		// We have tested all other users in testThatWeHaveNotBrokenAnything, only usrtestdmy has access to HelpDesk 2636
		// now we test the user testes who should have access if RAC is active because he has access to Product PRO2 => 2617
		// Deactivate the RAC rule
		self::tearDownAfterClass();
		// test that user testes does not have access to help desk 2636
		$user->retrieveCurrentUserInfoFromFile(8);
		$current_user = $user;
		$actual = isPermitted('HelpDesk', 'DetailView', 2636);
		$this->assertEquals('no', $actual, "testpermittedRAC testes no access HelpDesk 2636");
		// test that user testes has access to product 2617
		$actual = isPermitted('Products', 'DetailView', 2617);
		$this->assertEquals('yes', $actual, "testpermittedRAC testes access Products 2617");
		coreBOS_Session::deleteStartsWith('ispt:HelpDesk%DetailView%2636%8');
		coreBOS_Session::deleteStartsWith('ispt:Products%DetailView%2617%8');
		// Activate the RAC rule
		self::setUpBeforeClass();
		// test that user testes has access to help desk 2636
		$actual = isPermitted('HelpDesk', 'DetailView', 2636);
		$this->assertEquals('yes', $actual, "testpermittedRAC testes RAC access HelpDesk 2636");
		// test that user testes has access to product 2617
		$actual = isPermitted('Products', 'DetailView', 2617);
		$this->assertEquals('yes', $actual, "testpermittedRAC testes access Products 2617");
		// test that other users still don't have access to HelpDesk 2636
		foreach ($this->testusers as $uname => $uid) {
			$user->retrieveCurrentUserInfoFromFile($uid);
			$current_user = $user;
			if ($this->testusers['usrtestdmy']==$uid) {
				$expected = 'yes';
			} else {
				$expected = 'no';
			}
			coreBOS_Session::deleteStartsWith('ispt:HelpDesk%DetailView%2636%'.$uid);
			$actual = isPermitted('HelpDesk', 'DetailView', 2636);
			$this->assertEquals($expected, $actual, "testpermittedRAC $uname RAC no access HelpDesk 2636");
		}
		$current_user = $hold_user;
	}
}
?>