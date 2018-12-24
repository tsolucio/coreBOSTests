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

class workflowfunctionsmathTest extends TestCase {

	/**
	 * Method testmathfunctions
	 * @test
	 */
	public function testmathfunctions() {
		$actual = __vt_add(array(2017));
		$this->assertEquals(2017, $actual);
		$actual = __vt_add(array(2017,23));
		$this->assertEquals(2040, $actual);
		////////////////
		$actual = __vt_sub(array(2017));
		$this->assertEquals(-2017, $actual);
		$actual = __vt_sub(array(2017,23));
		$this->assertEquals(1994, $actual);
		////////////////
		$actual = __vt_mul(array(2017));
		$this->assertEquals(0, $actual);
		$actual = __vt_mul(array(2017,2));
		$this->assertEquals(2017*2, $actual);
		////////////////
		$actual = __vt_div(array(2017));
		$this->assertEquals(0, $actual);
		$actual = __vt_div(array(2017,23));
		$this->assertEquals(2017/23, $actual);
		$actual = __vt_div(array(2017,0));
		$this->assertEquals(0, $actual);
		////////////////
		$actual = __cb_modulo(array(2017));
		$this->assertEquals(0, $actual);
		$actual = __cb_modulo(array(2017,23));
		$this->assertEquals(2017%23, $actual);
		$actual = __cb_modulo(array(2017,0));
		$this->assertEquals(0, $actual);
		////////////////
		$actual = __vt_ceil(array(2017));
		$this->assertEquals(2017.0, $actual);
		$actual = __vt_ceil(array(2017.25));
		$this->assertEquals(2018.0, $actual);
		$actual = __vt_ceil(array('2017,23'));
		$this->assertEquals(0, $actual);
		////////////////
		$actual = __vt_floor(array(2017));
		$this->assertEquals(2017.0, $actual);
		$actual = __vt_floor(array(2017.25));
		$this->assertEquals(2017.0, $actual);
		$actual = __vt_floor(array('2017,23'));
		$this->assertEquals(0, $actual);
		////////////////
		$actual = __vt_round(array(2017));
		$this->assertEquals(2017, $actual);
		$actual = __vt_round(array('xx2017'));
		$this->assertEquals('xx2017', $actual);
		$actual = __vt_round(array(2017.23));
		$this->assertEquals(2017, $actual);
		$actual = __vt_round(array(2017.23,1));
		$this->assertEquals(2017.2, $actual);
		$actual = __vt_round(array(2017.23556,2));
		$this->assertEquals(2017.24, $actual);
		$actual = __vt_round(array());
		$this->assertEquals(0, $actual);
		////////////////
	}
}
?>