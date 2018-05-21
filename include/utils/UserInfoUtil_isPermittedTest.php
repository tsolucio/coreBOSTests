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
 * Test the coreBOS Permission system via isPermitted function
 */
use PHPUnit\Framework\TestCase;
class testUserInfoUtil_isPermittedTest extends TestCase {

	/****
	 * TEST Users
	 ****/
	var $testusers = array(
		'usrtestdmy' => 5,
		'usrtestmdy' => 6,
		'usrtestymd' => 7,
		'usrtesttz' => 10,
		'usrnocreate' => 11,
		'usrtestmcurrency' => 12
	);
	var $actionmappingWithRecord = array(
	  'Save',
	  'DetailViewAjax',
	  'EditView',
	  'Delete',
	  'DetailView',
	  'ConvertLead',
	);
	var $actionmappingWithRecordSpecial = array(
	  'SavePriceBook',
	  'SaveVendor',
	  'PriceBookEditView',
	  'VendorEditView',
	  'DeletePriceBook',
	  'DeleteVendor',
	  'PriceBookDetailView',
	  'VendorDetailView',
	);
	var $actionmappingWithoutRecord = array(
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
	var $testmodules = array(
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
	var $testrecords = array(
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
					if ($uname == 'usrnocreate' and in_array($action, array('QuickCreate','Export','Import','CreateView'))) {
						$expected = 'no';
					} else {
						$expected = 'yes';
					}
					if ($uname == 'usrnocreate' and $action == 'Merge' and in_array($mname,array('Accounts','Contacts','Leads','HelpDesk'))) {
						$expected = 'no';
					}
					if ($uname == 'usrnocreate' and in_array($action,array('Import','Export')) and in_array($mname,array('Quotes','PriceBooks'))) {
						$expected = 'yes';
					}
					if ($mname=='Documents' and $action=='Import') {
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
					if ($action=='ConvertLead' and $mname != 'Leads') {
						continue;
					}
					foreach ($mrecords as $crmid) {
						if ($mname=='Products' or $mname=='HelpDesk') {
							$ownerrs = $adb->pquery('select smownerid from vtiger_crmentity where crmid=?',array($crmid));
							$owner = $adb->query_result($ownerrs, 0, 0);
							if ($owner==$uid) {
								$expected = 'yes';
							} else {
								$expected = 'no';
							}
						} else {
							$expected = 'yes';
						}
						if ($action=='ConvertLead' and $uname != 'usrnocreate') {
							$expected = 'yes';
						}
						if ($uname == 'usrnocreate' and in_array($action,array('DetailViewAjax','EditView','Delete','Save'))) {
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
	 * Method testpermittedActions
	 * @test
	 * @dataProvider permittedActionsProvidor
	 */
	public function testpermittedActions($testuser,$actionname,$module,$crmid,$expected,$message) {
		global $current_user;
		$hold_user = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($testuser);
		$current_user = $user;
		if (!empty($crmid) and is_numeric($crmid)) {
			$actual = isPermitted($module, $actionname, $crmid);
		} else {
			$actual = isPermitted($module, $actionname);
		}
		$this->assertEquals($expected, $actual, "testpermittedActions $message");
		$current_user = $hold_user;
	}

}
?>