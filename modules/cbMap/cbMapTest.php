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
class cbMapTest extends TestCase {

	var $usrtestes = 8;

	/**
	 * Method testcbMapModule
	 * @test
	 */
	public function testcbMapModule() {
		$cbmapid = 27067;
		$cbmapxml = '<map>
  <originmodule>
    <originid>50</originid>
    <originname>Project</originname>
  </originmodule>
  <relatedlists>
    <relatedlist>
      <modulename>ProjectTask</modulename>
      <c>0</c>
      <r>1</r> 
      <u>0</u>
      <d>0</d>
      <s>0</s>
    </relatedlist>
    <relatedlist>
      <modulename>ProjectMilestone</modulename>
      <c>0</c>
      <r>1</r> 
      <u>0</u>
      <d>0</d>
      <s>0</s>
    </relatedlist>
  </relatedlists>
  </map>';
		$cbmap = cbMap::getMapByID($cbmapid);
		$this->assertInstanceOf(cbMap::class,$cbmap,"getMapByID class cbMap");
		$this->assertEquals($cbmapid, $cbmap->column_fields['record_id'],"getMapByID cbMap ID");
		$this->assertEquals($cbmapxml, decode_html($cbmap->column_fields['content']),"getMapByID cbMap XML");
		$cbmap = cbMap::getMapByName('RACProjectClosed');
		$this->assertInstanceOf(cbMap::class,$cbmap,"getMapByName class cbMap");
		$this->assertEquals($cbmapid, $cbmap->column_fields['record_id'],"getMapByName cbMap ID");
		$this->assertEquals($cbmapxml, decode_html($cbmap->column_fields['content']),"getMapByName cbMap XML");
		$cbmap = cbMap::getMapByName('RACProjectClosed','Record Access Control');
		$this->assertInstanceOf(cbMap::class,$cbmap,"getMapByName class cbMap");
		$this->assertEquals($cbmapid, $cbmap->column_fields['record_id'],"getMapByName cbMap ID");
		$this->assertEquals($cbmapxml, decode_html($cbmap->column_fields['content']),"getMapByName cbMap XML");
		$cbmap = cbMap::getMapByName('RACProjectClosed','NonExistentMapType');
		$this->assertNull($cbmap,"getMapByName nonexistent type");
		$cbmap = cbMap::getMapIdByName('RACProjectClosed');
		$this->assertEquals($cbmapid,$cbmap,"getMapIdByName");
		$cbmap = cbMap::getMapIdByName('NonExistentMapName');
		$this->assertEquals(0,$cbmap,"getMapIdByName");
		// getMapArray
		$cbmap = cbMap::getMapByID(34030);
		$actual = $cbmap->getMapArray();
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
		$this->assertEquals($expected,$actual,"getMapArray");
	}

}
