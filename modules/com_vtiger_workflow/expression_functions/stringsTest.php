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

class workflowfunctionsstringsTest extends TestCase {

	/**
	 * Method teststringfunctions
	 * @test
	 */
	public function teststringfunctions() {
		$actual = __vt_uppercase(array('2017aBcDeF','not used'));
		$this->assertEquals('2017ABCDEF', $actual);
		$actual = __vt_uppercase(array(''));
		$this->assertEquals('', $actual);
		$actual = __vt_uppercase(array());
		$this->assertEquals('', $actual);
		$actual = __vt_uppercase(array(0));
		$this->assertEquals(0, $actual);
		/////////////////
		$actual = __vt_lowercase(array('2017aBcDeF','not used'));
		$this->assertEquals('2017abcdef', $actual);
		$actual = __vt_lowercase(array(''));
		$this->assertEquals('', $actual);
		$actual = __vt_lowercase(array());
		$this->assertEquals('', $actual);
		$actual = __vt_lowercase(array(0));
		$this->assertEquals(0, $actual);
		/////////////////
		$actual = __vt_uppercasefirst(array('aBc 2017 DeF','not used'));
		$this->assertEquals('ABc 2017 DeF', $actual);
		$actual = __vt_uppercasefirst(array(''));
		$this->assertEquals('', $actual);
		$actual = __vt_uppercasefirst(array());
		$this->assertEquals('', $actual);
		$actual = __vt_uppercasefirst(array(0));
		$this->assertEquals(0, $actual);
		/////////////////
		$actual = __vt_uppercasewords(array('2017 aBc DeF','not used'));
		$this->assertEquals('2017 Abc Def', $actual);
		$actual = __vt_uppercasewords(array(''));
		$this->assertEquals('', $actual);
		$actual = __vt_uppercasewords(array());
		$this->assertEquals('', $actual);
		$actual = __vt_uppercasewords(array(0));
		$this->assertEquals(0, $actual);
		/////////////////
		$actual = __vt_concat(array('2017 aBc DeF','not used'));
		$this->assertEquals('2017 aBc DeFnot used', $actual);
		$actual = __vt_concat(array('2017 aBc DeF','not used',' used'));
		$this->assertEquals('2017 aBc DeFnot used used', $actual);
		$actual = __vt_concat(array(''));
		$this->assertEquals('', $actual);
		$actual = __vt_concat(array());
		$this->assertEquals('', $actual);
		$actual = __vt_concat(array(0));
		$this->assertEquals(0, $actual);
		/////////////////
		$actual = __cb_num2str(array('2017.34','en'));
		$this->assertEquals('TWO THOUSAND SEVENTEEN point THIRTY FOUR', $actual);
	}

	/**
	 * Method testsubstring
	 * @test
	 */
	public function testsubstring() {
		$actual = __vt_substring(array('2017-06-20 11:30:30','2017-06-20 10:30:30','2017-06-20 11:30:30','2017-06-20 10:30:30'));
		$this->assertEquals('2017-06-20 11:30:30', $actual);
		$actual = __vt_substring(array('2017-06-20 11:30:30'));
		$this->assertEquals('2017-06-20 11:30:30', $actual);
		$actual = __vt_substring(array('2017-06-20 10:30:30',10,2));
		$this->assertEquals(' 1', $actual);
		$actual = __vt_substring(array('2017-06-20 10:30:30',10));
		$this->assertEquals(' 10:30:30', $actual);
		$actual = __vt_substring(array('',10));
		$this->assertEquals('', $actual);
	}

	/**
	 * Method testcoalesce
	 * @test
	 */
	public function testcoalesce() {
		$actual = __cb_coalesce(array('2017-06-20 11:30:30','2017-06-20 10:30:30'));
		$this->assertEquals('2017-06-20 11:30:30', $actual);
		$actual = __cb_coalesce(array('','2017-06-20 10:30:30','default'));
		$this->assertEquals('2017-06-20 10:30:30', $actual);
		$actual = __cb_coalesce(array(null,'2017-06-20 10:30:30','default'));
		$this->assertEquals('2017-06-20 10:30:30', $actual);
		$actual = __cb_coalesce(array(0,'2017-06-20 10:30:30','default'));
		$this->assertEquals('2017-06-20 10:30:30', $actual);
		$actual = __cb_coalesce(array('','','default'));
		$this->assertEquals('default', $actual);
		$actual = __cb_coalesce(array(null,'','default'));
		$this->assertEquals('default', $actual);
		$actual = __cb_coalesce(array('',null,'default'));
		$this->assertEquals('default', $actual);
		$actual = __cb_coalesce(array('0',null,'default'));
		$this->assertEquals('default', $actual);
	}

}
?>