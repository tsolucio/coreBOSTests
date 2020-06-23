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

class BlockTest extends TestCase {

	/**
	 * Method testInstantiate
	 * @test
	 */
	public function testInstantiate() {
		$module = Vtiger_Module::getInstance('Accounts');
		$block = Vtiger_Block::getInstance('LBL_ACCOUNT_INFORMATION', $module);
		$this->assertInstanceOf(Vtiger_Block::class, $block, 'testConstruct class Vtiger_Block');
		$this->assertEquals(9, $block->id);
		$module = Vtiger_Module::getInstance('Assets');
		$block = Vtiger_Block::getInstance(103, $module);
		$this->assertEquals('LBL_ASSET_INFORMATION', $block->label);
	}

	/**
	 * Method testCRUD
	 * @test
	 */
	public function testCRUD() {
		$this->assertTrue(true, 'the Create and Delete actions are tested in webservice Create HelpDesk test (testCreateHelpDeskWithAttachment) because we needed them there');
		$this->assertTrue(true, 'blocks cannot be updated and retrieve is done in testInstantiate');
	}
}
?>