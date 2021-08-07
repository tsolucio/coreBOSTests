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

include_once 'include/Webservices/getRelatedRecordsThroughModule.php';

class getRelatedRecordsThroughModuleTest extends TestCase {

	/**
	 * Method testProductsInventory
	 * @test
	 */
	public function testProductsInventory() {
		global $current_user;
		////////////////////////////
		$qparams = array(
			'productDiscriminator' => '',
			'columns' => 'projecttaskname, projecttaskpriority, id',
		);
		$actual = getRelatedRecordsThroughModule('11x361', 'ProjectTask', 'Accounts', 'Project', $qparams, $current_user);
		$expected= array(
			'records' => array(
				array(
					0 => 'Commander Morton',
					1 => 'high',
					2 => '6913',
					'cbuuid' => '2ddd50735c768f4b66d6fdfa0c8490f63aebe94c',
					'id' => '32x6913',
					3 => '2ddd50735c768f4b66d6fdfa0c8490f63aebe94c',
					'projecttaskname' => 'Commander Morton',
					'projecttaskpriority' => 'high',
					'projecttaskid' => '6913',
				),
				array(
					0 => 'Marcus Arlington III',
					1 => 'low',
					2 => '7142',
					'cbuuid' => '3f1e4668a0ba3bcb447ace6e0229f2c252d354a2',
					'id' => '32x7142',
					3 => '3f1e4668a0ba3bcb447ace6e0229f2c252d354a2',
					'projecttaskname' => 'Marcus Arlington III',
					'projecttaskpriority' => 'low',
					'projecttaskid' => '7142',
				),
			),
		);
		$this->assertEquals($expected, $actual, 'Accounts-Project-ProjectTask');
	}
}
?>