<?php
/*************************************************************************************************
 * Copyright 2018 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

include_once 'include/Webservices/ExecuteWorkflow.php';

class testExecuteWorkflow extends TestCase {

	/**
	 * Method testcbwsExecuteWorkflow
	 * @test
	 */
	public function testcbwsExecuteWorkflow() {
		global $current_user, $adb;
		$adb->query('TRUNCATE com_vtiger_workflowtask_queue');
		$wsid = vtws_getEntityId('cbCalendar').'x';
		cbwsExecuteWorkflow(26, '["'.$wsid.'14729","'.$wsid.'14731"]', $current_user);
		$rs = $adb->query('select * from com_vtiger_workflowtask_queue order by entity_id');
		$cnt = 0;
		$expected = array(
			1 => $wsid.'14729',
			2 => $wsid.'14731',
		);
		while ($wftsk = $adb->fetch_array($rs)) {
			$cnt++;
			$this->assertEquals($expected[$cnt], $wftsk['entity_id'], 'task row');
		}
		$this->assertEquals(2, $cnt, 'task count');
		//////////////////////
		$wsid = vtws_getEntityId('HelpDesk').'x';
		$ownerbefore = 5;
		$rs = $adb->pquery('update vtiger_crmentity set smownerid=? where crmid=?', array($ownerbefore, 2642));
		cbwsExecuteWorkflow(27, '["'.$wsid.'2642"]', $current_user);
		$rs = $adb->pquery('select smownerid from vtiger_crmentity where crmid=?', array(2642));
		$ownerafter = $adb->query_result($rs, 0, 0);
		$this->assertEquals(8, $ownerafter, 'task count');
	}

	public function testInvalidParameter1() {
		global $current_user;
		$this->expectException('WebServiceException');
		$actual = cbwsExecuteWorkflow('xx', '', $current_user);
	}

	public function testInvalidParameter2() {
		global $current_user;
		$this->expectException('WebServiceException');
		$actual = cbwsExecuteWorkflow(26, '{"module":"', $current_user);
	}
}
?>