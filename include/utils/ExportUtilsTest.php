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

include 'include/utils/ExportUtils.php';
use PHPUnit\Framework\TestCase;

class testExportUtils extends TestCase {

		/**
	 * Method getPermittedBlocksProvidor
	 * params
	 */
	public function getPermittedBlocksProvidor() {
		return array(
			array('Accounts', 'create_view', '(9, 10, 127, 11, 12)'),
			array('Accounts', 'edit_view', '(9, 10, 127, 11, 12)'),
			array('Accounts', 'detail_view', '(9, 10, 127, 11, 12)'),
			array('Assets', 'create_view', '(103, 104, 105)'),
			array('Assets', 'edit_view', '(103, 104, 105)'),
			array('Assets', 'detail_view', '(103, 104, 105)'),
			array('Products', 'create_view', '(31, 32, 33, 34, 35, 36)'),
			array('Products', 'edit_view', '(31, 32, 33, 34, 35, 36)'),
			array('Products', 'detail_view', '(31, 32, 33, 34, 35, 36)'),
			array('HelpDesk', 'create_view', '(25, 26, 27, 28, 29)'),
			array('HelpDesk', 'edit_view', '(25, 26, 27, 28, 29, 30)'),
			array('HelpDesk', 'detail_view', '(25, 26, 27, 28, 29, 30)'),
		);
	}

	/**
	 * Method testgetPermittedBlocks
	 * @test
	 * @dataProvider getPermittedBlocksProvidor
	 */
	public function testgetPermittedBlocks($module, $disp_view, $expected) {
		$actual = getPermittedBlocks($module, $disp_view);
		$this->assertEquals($expected, $actual, 'testgetPermittedBlocks');
	}
}