<?php
/*************************************************************************************************
 * Copyright 2021 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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
include_once 'modules/evvtgendoc/OpenDocument.php';
use PHPUnit\Framework\TestCase;

class GenDocCompileTest extends TestCase {

	/**
	 * Method testgetRelatedCRMIDs
	 * @test
	 */
	public function testgetRelatedCRMIDs() {
		$this->assertEquals(
			array(
				'entries' => array(
					'43952' => '43952',
					'43953' => '43953',
					'43954' => '43954',
				),
			),
			getRelatedCRMIDs('select crmid from vtiger_crmentity where setype="MsgTemplate" limit 3', false),
			'accounts no sort'
		);
		$this->assertEquals(
			array(
				'entries' => array(
					'43952' => '43952',
					'43953' => '43953',
					'43954' => '43954',
				)
			),
			getRelatedCRMIDs(
				'select crmid from vtiger_crmentity where setype="MsgTemplate"',
				array('cname' => 'crmid', 'order' => 'asc limit 3')
			),
			'accounts sort asc'
		);
		$this->assertEquals(
			array(
				'entries' => array(
					'44159' => '44159',
					'44158' => '44158',
					'44157' => '44157',
				)
			),
			getRelatedCRMIDs(
				'select crmid from vtiger_crmentity where setype="MsgTemplate"',
				array('cname' => 'crmid', 'order' => 'desc limit 3')
			),
			'accounts sort desc'
		);
		$this->assertEquals(
			array('entries' => array()),
			getRelatedCRMIDs('invalid SQL limit 3', false),
			'error sql'
		);
	}
}
