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
class testRequest extends TestCase {

	var $testdata = array();
	var $requeststrip;
	var $requestnotstrip;

	public function setup() {
		$this->testdata = array(
			'usrtestdmy' => 5,
			'RETURN_MODULE' => 'Accounts',
			'RETURN_VIEW' => 7,
			'return_return_action' => 'Save',
			'booleanT' => 'true',
			'booleanF' => 'false',
			'script' => 'Script: <script>alert("hi");</script> done',
			'sqlinjection' => '; select 1 from marvel;',
			'simplequotes' => "quote: 'hi' done",
			'doublequotes' => 'quote: "hi" done',
			'return_httpresponsesplit' => 'first'.chr(13).chr(10).'second',
			'slashes' => "slash: \\' ".' \\" \\\ ',
			'jsonarray' => '[1,2,3]',
			'jsonobject' => '{"1":"one","2":"two","3":"three"}',
			'notjson' => '[1],2,3',
			'empty' => '',
			'RETURN_EMPTY' => '',
			'RETURN_ZERO' => 0,
		);
		$this->requeststrip = new Vtiger_Request($this->testdata,$this->testdata);
		$this->requestnotstrip = new Vtiger_Request($this->testdata,$this->testdata,false);
	}

	/**
	 * Method testConstruct
	 * @test
	 */
	public function testConstruct() {
		$this->assertInstanceOf(Vtiger_Request::class,$this->requeststrip,"testConstruct class strip");
		$this->assertInstanceOf(Vtiger_Request::class,$this->requestnotstrip,"testConstruct class not strip");
	}

	/**
	 * Method testGetAllAndInfoSaved
	 * @test
	 */
	public function testGetAllAndInfoSaved() {
		$this->assertEquals($this->testdata, $this->requeststrip->getAllRaw(), "testGetInfo RAW strip");
		$this->assertEquals($this->testdata, $this->requestnotstrip->getAllRaw(), "testGetInfo RAW not strip");
		$expected = array(
			'usrtestdmy' => 5,
			'RETURN_MODULE' => 'Accounts',
			'RETURN_VIEW' => 7,
			'return_return_action' => 'Save',
			'booleanT' => 'true',
			'booleanF' => 'false',
			'script' => 'Script:  done',
			'sqlinjection' => '; select 1 from marvel;',
			'simplequotes' => "quote: 'hi' done",
			'doublequotes' => 'quote: "hi" done',
			'return_httpresponsesplit' => 'first'.chr(10).'second',
			'slashes' => "slash: ' ".' " \ ',
			'jsonarray' => array(1,2,3),
			'jsonobject' => array("1"=>"one","2"=>"two","3"=>"three"),
			'notjson' => '[1],2,3',
			'empty' => '',
			'RETURN_EMPTY' => '',
			'RETURN_ZERO' => 0,
		);
		$this->assertEquals($expected, $this->requeststrip->getAll(), "testGetInfo strip");
		$expected['slashes'] = "slash: \\' ".' \\" \\\ ';
		$this->assertEquals($expected, $this->requestnotstrip->getAll(), "testGetInfo not strip");
	}

	/**
	 * Method testGet
	 * @test
	 */
	public function testGet() {
		$this->assertEquals(5, $this->requeststrip->get('usrtestdmy'), "testGet number");
		$this->assertSame('Accounts', $this->requeststrip->get('RETURN_MODULE'), "testGet string");
		$this->assertSame('Script:  done', $this->requeststrip->get('script'), "testGet purify");
		$this->assertSame(5, $this->requeststrip->getRaw('usrtestdmy'), "testGetRaw number");
		$this->assertSame('Accounts', $this->requeststrip->getRaw('RETURN_MODULE'), "testGetRaw string");
		$this->assertSame('Script: <script>alert("hi");</script> done', $this->requeststrip->getRaw('script'), "testGetRaw purify");
		$this->assertTrue($this->requeststrip->getBoolean('booleanT'), "testGetBoolean true");
		$this->assertFalse($this->requeststrip->getBoolean('booleanF'), "testGetBoolean false");
		$this->assertFalse($this->requeststrip->getBoolean('RETURN_MODULE'), "testGetBoolean string");
		$this->assertFalse($this->requeststrip->getBoolean('usrtestdmy'), "testGetBoolean number");
		$this->assertSame('; select 1 from marvel;', $this->requeststrip->get('sqlinjection'), "testGet SQL");
		$this->assertSame("quote: 'hi' done", $this->requeststrip->get('simplequotes'), "testGet simple quotes");
		$this->assertSame('quote: "hi" done', $this->requeststrip->get('doublequotes'), "testGet double quotes");
		$this->assertSame('first'.chr(10).'second', $this->requeststrip->get('return_httpresponsesplit'), "testGet return_httpresponsesplit");
		$this->assertSame("slash: ' ".' " \ ', $this->requeststrip->get('slashes'), "testGet slashes");
		$this->assertEquals(array(1,2,3), $this->requeststrip->get('jsonarray'), "testGet jsonarray");
		$this->assertSame(array("1"=>"one","2"=>"two","3"=>"three"), $this->requeststrip->get('jsonobject'), "testGet jsonobject");
		$this->assertSame('[1],2,3', $this->requeststrip->get('notjson'), "testGet notjson");
		$this->assertSame('', $this->requeststrip->get('empty'), "testGet empty");
	}

	/**
	 * Method testHelpers
	 * @test
	 */
	public function testHelpers() {
		$this->assertTrue($this->requeststrip->has('booleanT'), "testhas true");
		$this->assertFalse($this->requeststrip->has('nothere'), "testhas false");
		$this->assertTrue($this->requeststrip->isEmpty('empty'), "testempty true");
		$this->assertTrue($this->requeststrip->isEmpty('nothere'), "testempty true not exist");
		$this->assertFalse($this->requeststrip->isEmpty('usrtestdmy'), "testempty false");
	}

	/**
	 * Method testSet
	 * @test
	 */
	public function testSet() {
		$this->assertFalse($this->requeststrip->has('nothere'), "testhas false");
		$this->requeststrip->set('nothere','setit');
		$this->assertTrue($this->requeststrip->has('nothere'), "testhas set");
		@$this->assertEmpty($_REQUEST['nothere'], "testempty REQUEST");
		$this->requeststrip->delete('nothere');
		$this->assertFalse($this->requeststrip->has('nothere'), "testhas false deleted");
		$this->requeststrip->setGlobal('nothere','setit');
		$this->assertTrue($this->requeststrip->has('nothere'), "testhas set global");
		$this->assertSame('setit',$_REQUEST['nothere'], "testNOTempty REQUEST");
	}

	/**
	 * Method testDefault
	 * @test
	 */
	public function testDefault() {
		$this->assertFalse($this->requeststrip->has('nothere'), "testDefault false");
		$this->assertSame('', $this->requeststrip->get('nothere'), "testDefault empty");
		$this->assertSame('default', $this->requeststrip->get('nothere','default'), "testDefault empty direct default");
		$all_before = $this->requeststrip->getAll();
		$this->requeststrip->setDefault('nothere','setdefault');
		$all_after = $this->requeststrip->getAll();
		$this->assertFalse($this->requeststrip->has('nothere'), "testDefault has false");
		$this->assertSame('setdefault', $this->requeststrip->get('nothere'), "testDefault setdefault");
		$this->assertNotSame($all_before, $all_after, "testDefault GetAll setdefault different");
		$all_before['nothere'] = 'setdefault';
		$this->assertEquals($all_before, $all_after, "testDefault GetAll setdefault same");
	}

	/**
	 * Method testReturnURL
	 * @test
	 */
	public function testReturnURL() {
		$actual = $this->requeststrip->getReturnURL();
		$this->assertSame("return_module=Accounts&return_view=7&return_action=Save&httpresponsesplit=first%0Asecond&return_empty=&return_zero=0",$actual, "testGetReturnURL");
	}

}
