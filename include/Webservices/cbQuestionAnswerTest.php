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

include_once 'include/Webservices/cbQuestion.php';

class cbQuestionAnswerTest extends TestCase {

	/**
	 * Method testquestion
	 * @test
	 */
	public function testquestion() {
		global $current_user, $adb;
		$expected = array(
			'module' => 'Workflow',
			'columns' => 'id,module_name,summary',
			'title' => 'workflow',
			'type' => 'Table',
			'properties' => '',
			'groupings' => [],
		);
		$actual = cbwsGetAnswer(vtws_getEntityId('cbQuestion').'x44079', '', $current_user);
		$answer = $actual['answer'];
		unset($actual['answer']);
		$this->assertEquals($expected, $actual, 'cbQuestion workflow');
		$expectedanswer = array(
			'id' => '50x1',
			'module_name' => 'Invoice',
			'summary' => 'UpdateInventoryProducts On Every Save',
		);
		$this->assertEquals($expectedanswer, $answer[0], 'cbQuestion workflow');
		$this->assertGreaterThan(28, count($answer));
		/////////////////
		$adb->query("update vtiger_cbquestion set qcondition=replace(qcondition, 'ACC1', 'ACC2') where cbquestionid=44080");
		$expected = array(
			'module' => 'HelpDesk',
			'columns' => '[{"fieldname":"countres","operation":"is","value":"count(ticket_title)","valuetype":"expression","joincondition":"and","groupid":"0"},{"fieldname":"ticketstatus","operation":"is","value":"ticketstatus","valuetype":"fieldname","joincondition":"and","groupid":"0"}]',
			'title' => 'Ticket per Status',
			'type' => 'Pie',
			'properties' => '{"key_label":"ticketstatus","key_value":"countres"}',
			'groupings' => [
				'[{"columnname":"vtiger_troubletickets:status:ticketstatus:HelpDesk_Status:V","comparator":"e","value":"Closed","groupid":1,"columncondition":""}]',
				'[{"columnname":"vtiger_troubletickets:status:ticketstatus:HelpDesk_Status:V","comparator":"e","value":"In Progress","groupid":1,"columncondition":""}]',
				'[{"columnname":"vtiger_troubletickets:status:ticketstatus:HelpDesk_Status:V","comparator":"e","value":"Open","groupid":1,"columncondition":""}]',
				'[{"columnname":"vtiger_troubletickets:status:ticketstatus:HelpDesk_Status:V","comparator":"e","value":"Wait For Response","groupid":1,"columncondition":""}]',
			],
			'answer' => array(
				0 => array(
					'countres' => '3',
					'ticketstatus' => 'Closed',
				),
				1 => array(
					'countres' => '1',
					'ticketstatus' => 'In Progress',
				),
				2 => array(
					'countres' => '1',
					'ticketstatus' => 'Open',
				),
				3 => array(
					'countres' => '1',
					'ticketstatus' => 'Wait For Response',
				),
			),
		);
		$params = array(
			'$RECORD$' => '78',
			'$MODULE$' => 'Accounts',
			'$USERID$' => $current_user->id,
		);
		$actual = cbwsGetAnswer(vtws_getEntityId('cbQuestion').'x44080', $params, $current_user);
		$this->assertEquals($expected, $actual, 'cbQuestion chart');
		$adb->query("update vtiger_cbquestion set qcondition=replace(qcondition, 'ACC2', 'ACC1') where cbquestionid=44080");
	}

	/**
	 * Method testinvalidmoduleexception
	 * @test
	 */
	public function testinvalidmoduleexception() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		cbwsGetAnswer('11x74', array(), $current_user);
	}

	/**
	 * Method testReadExceptionNoPermission
	 * @test
	 */
	public function testReadExceptionNoPermission() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(5); // testdmy
		$current_user = $user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		try {
			cbwsGetAnswer(vtws_getEntityId('cbQuestion').'x34030', array(), $current_user);
		} catch (\Throwable $th) {
			$current_user = $holduser;
			throw $th;
		}
	}
}
?>