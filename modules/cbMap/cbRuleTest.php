<?php
/*************************************************************************************************
 * Copyright 2017 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

function superDifficultDecision($decider1, $decider2) {
	if (!is_numeric($decider1)) {
		$decider1 = 0;
	}
	if (!is_numeric($decider2)) {
		$decider2 = 0;
	}
	return ($decider1 + $decider2 > 10);
}

use PHPUnit\Framework\TestCase;

class cbRuleTest extends TestCase {

	/**
	 * Method testInvalidContext
	 * @test
	 */
	public function testInvalidContext() {
		$this->assertFalse(coreBOS_Rule::evaluate(27078, '11x1'));
	}

	/**
	 * Method testInsecureContext
	 * @test
	 */
	public function testInsecureContext() {
		global $current_user;
		$this->assertEquals(
			'yes',
			coreBOS_Rule::evaluate(
				'isPermitted_ConditionExpression',
				array(
					'record_id' => '11x74',
					'permitted_module' => 'Accounts',
					'permitted_action' => 'EditView',
					'permitted_record' => '11x74',
				)
			)
		);
		$this->assertEquals(
			'yes',
			coreBOS_Rule::evaluate(
				'isPermitted_ConditionExpression',
				array(
					'record_id' => '11x74',
					'permitted_module' => "Accounts'.system('cat /etc/passwd').'",
					'permitted_action' => 'EditView',
					'permitted_record' => '11x74',
				)
			)
		);
		$this->assertEquals(
			'yes',
			coreBOS_Rule::evaluate(
				'isPermitted_ConditionExpression',
				array(
					'record_id' => '11x74',
					'permitted_module' => "\'.system(\"cat /etc/passwd\").",
					'permitted_action' => ");//EditView",
					'permitted_record' => '11x74',
				)
			)
		);
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(11); // nocreate
		$current_user = $user;
		$this->assertEquals(
			'no',
			coreBOS_Rule::evaluate(
				'isPermitted_ConditionExpression',
				array(
					'record_id' => '11x74',
					'permitted_module' => 'Accounts',
					'permitted_action' => 'EditView',
					'permitted_record' => '11x74',
				)
			)
		);
		$this->assertEquals(
			'yes',
			coreBOS_Rule::evaluate(
				'isPermitted_ConditionExpression',
				array(
					'record_id' => '11x74',
					'permitted_module' => "Accounts'.system('cat /etc/passwd').'",
					'permitted_action' => 'EditView',
					'permitted_record' => '11x74',
				)
			)
		);
		$this->assertEquals(
			'no',
			coreBOS_Rule::evaluate(
				'isPermitted_ConditionExpression',
				array(
					'record_id' => '11x74',
					'permitted_module' => "\'.system(\"cat /etc/passwd\").",
					'permitted_action' => ");//EditView",
					'permitted_record' => '11x74',
				)
			)
		);
		$this->assertEquals(
			'no',
			coreBOS_Rule::evaluate(
				'isPermitted_ConditionExpression',
				array(
					'record_id' => '4062',
					'permitted_module' => 'SMSNOtifier',
					'permitted_action' => 'EditView',
					'permitted_record' => '4062',
				)
			)
		);
		$current_user = Users::getActiveAdminUser();
	}

	/**
	 * Method testExceptionAccessDeniedInvalidID
	 * @test
	 */
	public function testExceptionAccessDeniedInvalidID() {
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('ACCESS_DENIED');
		coreBOS_Rule::evaluate(27078, 'aaa1x1bbb');
	}

	/**
	 * Method testExceptionAccessDenied
	 * @test
	 */
	public function testExceptionAccessDenied() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('ACCESS_DENIED');
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(7); // testymd
		$current_user = $user;
		coreBOS_Rule::evaluate(27078, '14x2616');
		$current_user = $holduser;
	}

	/**
	 * Method testExceptionInvalidBMNonExistent
	 * @test
	 */
	public function testExceptionInvalidBMNonExistent() {
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_BUSINESSMAP');
		coreBOS_Rule::evaluate(1, '11x74');
	}

	/**
	 * Method testExceptionInvalidBMIncorrectType
	 * @test
	 */
	public function testExceptionInvalidBMIncorrectType() {
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_BUSINESSMAP');
		coreBOS_Rule::evaluate(34030, '11x74');
	}

	/**
	 * Method ConditionQueryProvider
	 * params
	 */
	public function ConditionQueryProvider() {
		return array(
			array(34038,'11x74','Chemex Labs Ltd','Accountname query'),
			array(34039,'29x4062',array(
				0 => array (
					'assetname' => 'Lisatoni, Jean Esq :: U8 Smart Watch',
					'asset_no' => 'AST-000002',
					'productsproductname' => 'U8 Smart Watch',
				),
				1 => array (
					'assetname' => 'Mccoy, Joy Reynolds Esq :: cheap in stock muti-color lipstick',
					'asset_no' => 'AST-000044',
					'productsproductname' => 'cheap in stock muti-color lipstick',
				),
			),'Assets query'),
			array(34040,'29x4062',2,'Assets query count'),
		);
	}

	/**
	 * Method testConditionQuery
	 * @test
	 * @dataProvider ConditionQueryProvider
	 */
	public function testConditionQuery($conditionid, $contextid, $expected, $msg) {
		global $current_user;
		$current_user = Users::getActiveAdminUser();
		$this->assertEquals($expected, coreBOS_Rule::evaluate($conditionid, $contextid), $msg);
	}

	/**
	 * Method ConditionExpressionProvider
	 * params
	 */
	public function ConditionExpressionProvider() {
		return array(
			array(27078,'17x2636','yes','RAC Ticket Depending on Products'),
			array('Ticket Account','17x2637','Chemex Labs Ltd','Ticket account name'),
			array('UpperCase String','17x2636','THIS STRING','UpperCase String'),
			array('UpperCase String','11x74','THIS STRING','UpperCase String'),
			array('accountname','11x74','Chemex Labs Ltd','Account Name'),
			array(34033,'11x74','141','employee + 10'),
			array(34034,'11x74','true','employee TF'),
			array(34036,'11x74',true,'superDifficultDecisionFixed'),
			array(34037,'11x74',false,'superDifficultDecisionDynamic'),
		);
	}

	/**
	 * Method testConditionExpression
	 * @test
	 * @dataProvider ConditionExpressionProvider
	 */
	public function testConditionExpression($conditionid, $contextid, $expected, $msg) {
		global $current_user;
		$current_user = Users::getActiveAdminUser();
		$this->assertEquals($expected, coreBOS_Rule::evaluate($conditionid, $contextid), $msg);
	}
}
