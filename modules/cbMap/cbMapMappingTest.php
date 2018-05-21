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

use PHPUnit\Framework\TestCase;
class cbMapMappingTest extends TestCase {

	/**
	 * Method testcbMapMapping
	 * @test
	 */
	public function testcbMapMapping() {
		$cbmap = cbMap::getMapByID(34030);
		$actual = $cbmap->getMapArray(); // convertMap2Array
		$expected = array(
			'origin' => 'Invoice',
			'target' => 'CobroPago',
			'fields' => array (
				'amount' => array (
					'merge' => array (
						0 => array (
							'' => 'hdnGrandTotal',
						),
					),
				'master' => false,
				),
			),
		);
		$this->assertEquals($expected,$actual,"convert Map to Array");
		$ifocus = CRMEntity::getInstance('Invoice');
		$ifocus->retrieve_entity_info(2816, 'Invoice');
		$actual = $cbmap->Mapping($ifocus->column_fields,array('sentin'=>'notmodified','amount'=>'will be modified'));
		$expected = array(
			'sentin' => 'notmodified',
			'amount' => '1890.930000',
		);
		$this->assertEquals($expected,$actual,"Mapping: process Map");
	}

}
