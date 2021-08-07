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

include_once 'include/Webservices/MassUpdate.php';

class MassUpdateTest extends TestCase {

	/**
	 * Method testMassUpdate
	 * @test
	 */
	public function testMassDelete() {
		global $current_user, $adb;
		$current_user = Users::getActiveAdminUser();
		$scrs = $adb->query('select total_units,contract_status from vtiger_servicecontracts where servicecontractsid in (10132,10134)');
		$sc10132TUBefore = $adb->query_result($scrs, 0, 'total_units');
		$sc10132CSBefore = $adb->query_result($scrs, 0, 'contract_status');
		$sc10134TUBefore = $adb->query_result($scrs, 1, 'total_units');
		$sc10134CSBefore = $adb->query_result($scrs, 1, 'contract_status');
		$elements = array(
			array(
				'id' => '25x10132',
				'total_units' => 9.9,
				'contract_status' => 'On Hold',
			),
			array(
				'id' => '25x10134',
				'total_units' => 9.9,
				'contract_status' => 'On Hold',
			),
			array(
				'id' => '25x9999999999',
				'total_units' => 9.9,
				'contract_status' => 'On Hold',
			),
		);
		$expected = array(
			'success_updates' => array(
				array(
					'subject' => 'Penatibus Et Associates',
					'contract_no' => 'SERCON373',
					'sc_related_to' => '12x2075',
					'assigned_user_id' => '19x9',
					'contract_type' => 'Administrative',
					'tracking_unit' => 'Hours',
					'start_date' => '2016-07-26',
					'total_units' => '9.900000',
					'due_date' => '2016-12-07',
					'used_units' => '14.090000',
					'contract_status' => 'On Hold',
					'planned_duration' => '135',
					'contract_priority' => 'Normal',
					'createdtime' => '2015-06-24 12:41:32',
					'created_user_id' => '19x1',
					'id' => '25x10132',
					'cbuuid' => '38af0f7c412da8ecefcbb64fc24f02895b10b973',
					'sc_related_toename' => array(
						'module' => 'Contacts',
						'reference' => 'Roxanne Hedegore',
						'cbuuid' => 'ac0e9792098708705621fbcc8dd90ccb6c3c1b28',
					),
					'created_user_idename' => array(
						'module' => 'Users',
						'reference' => ' Administrator',
						'cbuuid' => '',
					),
					'assigned_user_idename' => array(
						'module' => 'Users',
						'reference' => 'cbTest testinactive',
						'cbuuid' => '',
					),
				),
				array(
					'subject' => 'Purus Duis Elementum Limited',
					'contract_no' => 'SERCON375',
					'sc_related_to' => '11x893',
					'assigned_user_id' => '19x9',
					'contract_type' => 'Services',
					'tracking_unit' => 'Incidents',
					'start_date' => '2015-06-21',
					'total_units' => '9.900000',
					'due_date' => '2016-11-13',
					'used_units' => '12.410000',
					'contract_status' => 'On Hold',
					'planned_duration' => '512',
					'contract_priority' => 'Normal',
					'createdtime' => '2015-06-24 13:20:12',
					'created_user_id' => '19x1',
					'id' => '25x10134',
					'cbuuid' => 'bf29b4cc4e10a4890a185693a4dcc552245a7920',
					'sc_related_toename' => array(
						'module' => 'Accounts',
						'reference' => 'Jurdem, Scott Esq',
						'cbuuid' => '2287ea05a0f5cec2ecff6b72be16e951c041b72b',
					),
					'created_user_idename' => array(
						'module' => 'Users',
						'reference' => ' Administrator',
						'cbuuid' => '',
					),
					'assigned_user_idename' => array(
						'module' => 'Users',
						'reference' => 'cbTest testinactive',
						'cbuuid' => '',
					),
				),
			),
			'failed_updates' => array(
				array(
					'id' => '25x9999999999',
					'code' => 'ACCESS_DENIED',
					'message' => 'Permission to perform the operation is denied',
				)
			),
		);
		$upds = vtws_massupdate($elements, $current_user);
		unset(
			$upds['success_updates'][0]['modifiedby'],
			$upds['success_updates'][0]['modifiedtime'],
			$upds['success_updates'][0]['modifiedbyename'],
			$upds['success_updates'][0]['end_date'],
			$upds['success_updates'][0]['actual_duration'],
			$upds['success_updates'][0]['progress'],
			$upds['success_updates'][1]['modifiedby'],
			$upds['success_updates'][1]['modifiedtime'],
			$upds['success_updates'][1]['modifiedbyename'],
			$upds['success_updates'][1]['end_date'],
			$upds['success_updates'][1]['actual_duration'],
			$upds['success_updates'][1]['progress'],
		);
		$this->assertEquals($expected, $upds);
		$scrs = $adb->query('select total_units,contract_status from vtiger_servicecontracts where servicecontractsid in (10132,10134)');
		$sc10132TUAfter = $adb->query_result($scrs, 0, 'total_units');
		$sc10132CSAfter = $adb->query_result($scrs, 0, 'contract_status');
		$sc10134TUAfter = $adb->query_result($scrs, 1, 'total_units');
		$sc10134CSAfter = $adb->query_result($scrs, 1, 'contract_status');
		$this->assertEquals(9.9, $sc10132TUAfter);
		$this->assertEquals('On Hold', $sc10132CSAfter);
		$this->assertEquals(9.9, $sc10134TUAfter);
		$this->assertEquals('On Hold', $sc10134CSAfter);
		///////////////////
		$elements = array(
			array(
				'id' => '25x10132',
				'total_units' => $sc10132TUBefore,
				'contract_status' => $sc10132CSBefore,
			),
			array(
				'id' => '25x10134',
				'total_units' => $sc10134TUBefore,
				'contract_status' => $sc10134CSBefore,
			),
		);
		$expected = array(
			'success_updates' => array(
				array(
					'subject' => 'Penatibus Et Associates',
					'contract_no' => 'SERCON373',
					'sc_related_to' => '12x2075',
					'assigned_user_id' => '19x9',
					'contract_type' => 'Administrative',
					'tracking_unit' => 'Hours',
					'start_date' => '2016-07-26',
					'total_units' => $sc10132TUBefore,
					'due_date' => '2016-12-07',
					'used_units' => '14.090000',
					'contract_status' => $sc10132CSBefore,
					'planned_duration' => '135',
					'contract_priority' => 'Normal',
					'createdtime' => '2015-06-24 12:41:32',
					'created_user_id' => '19x1',
					'id' => '25x10132',
					'cbuuid' => '38af0f7c412da8ecefcbb64fc24f02895b10b973',
					'sc_related_toename' => array(
						'module' => 'Contacts',
						'reference' => 'Roxanne Hedegore',
						'cbuuid' => 'ac0e9792098708705621fbcc8dd90ccb6c3c1b28',
					),
					'created_user_idename' => array(
						'module' => 'Users',
						'reference' => ' Administrator',
						'cbuuid' => '',
					),
					'assigned_user_idename' => array(
						'module' => 'Users',
						'reference' => 'cbTest testinactive',
						'cbuuid' => '',
					),
				),
				array(
					'subject' => 'Purus Duis Elementum Limited',
					'contract_no' => 'SERCON375',
					'sc_related_to' => '11x893',
					'assigned_user_id' => '19x9',
					'contract_type' => 'Services',
					'tracking_unit' => 'Incidents',
					'start_date' => '2015-06-21',
					'total_units' => $sc10134TUBefore,
					'due_date' => '2016-11-13',
					'used_units' => '12.410000',
					'contract_status' => $sc10134CSBefore,
					'planned_duration' => '512',
					'contract_priority' => 'Normal',
					'createdtime' => '2015-06-24 13:20:12',
					'created_user_id' => '19x1',
					'id' => '25x10134',
					'cbuuid' => 'bf29b4cc4e10a4890a185693a4dcc552245a7920',
					'sc_related_toename' => array(
						'module' => 'Accounts',
						'reference' => 'Jurdem, Scott Esq',
						'cbuuid' => '2287ea05a0f5cec2ecff6b72be16e951c041b72b',
					),
					'created_user_idename' => array(
						'module' => 'Users',
						'reference' => ' Administrator',
						'cbuuid' => '',
					),
					'assigned_user_idename' => array(
						'module' => 'Users',
						'reference' => 'cbTest testinactive',
						'cbuuid' => '',
					),
				),
			),
			'failed_updates' => array(),
		);
		$upds = vtws_massupdate($elements, $current_user);
		unset(
			$upds['success_updates'][0]['modifiedby'],
			$upds['success_updates'][0]['modifiedtime'],
			$upds['success_updates'][0]['modifiedbyename'],
			$upds['success_updates'][0]['end_date'],
			$upds['success_updates'][0]['actual_duration'],
			$upds['success_updates'][0]['progress'],
			$upds['success_updates'][1]['modifiedby'],
			$upds['success_updates'][1]['modifiedtime'],
			$upds['success_updates'][1]['modifiedbyename'],
			$upds['success_updates'][1]['end_date'],
			$upds['success_updates'][1]['actual_duration'],
			$upds['success_updates'][1]['progress'],
		);
		$this->assertEquals($expected, $upds);
		$scrs = $adb->query('select total_units,contract_status from vtiger_servicecontracts where servicecontractsid in (10132,10134)');
		$sc10132TUAfter = $adb->query_result($scrs, 0, 'total_units');
		$sc10132CSAfter = $adb->query_result($scrs, 0, 'contract_status');
		$sc10134TUAfter = $adb->query_result($scrs, 1, 'total_units');
		$sc10134CSAfter = $adb->query_result($scrs, 1, 'contract_status');
		$this->assertEquals($sc10132TUBefore, $sc10132TUAfter);
		$this->assertEquals($sc10132CSBefore, $sc10132CSAfter);
		$this->assertEquals($sc10134TUBefore, $sc10134TUAfter);
		$this->assertEquals($sc10134CSBefore, $sc10134CSAfter);
	}
}
?>