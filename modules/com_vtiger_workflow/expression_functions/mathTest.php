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
		$actual = __vt_add(array(2017,'a23'));
		$this->assertEquals(2017, $actual);
		$actual = __vt_add(array('a2017',23));
		$this->assertEquals(23, $actual);
		$actual = __vt_add(array('a2017','a23'));
		$this->assertEquals(0, $actual);
		$actual = __vt_add(array('3,2',23));
		$this->assertEquals(23, $actual);
		$actual = __vt_add(array('3.2',23));
		$this->assertEquals(26.2, $actual);
		////////////////
		$actual = __vt_sub(array(2017));
		$this->assertEquals(-2017, $actual);
		$actual = __vt_sub(array(2017,23));
		$this->assertEquals(1994, $actual);
		$actual = __vt_sub(array(2017,'a23'));
		$this->assertEquals(2017, $actual);
		$actual = __vt_sub(array('a2017',23));
		$this->assertEquals(23, $actual);
		$actual = __vt_sub(array('a2017','a23'));
		$this->assertEquals(0, $actual);
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

	//test number formating
	public function testnumberformatingfunction() {
		$actual = __cb_number_format(array());
		$this->assertEquals('', $actual);
		$actual = __cb_number_format(array(1234.56));
		$this->assertNotEquals("1,23456", $actual);
		$actual = __cb_number_format(array(1234.56,1));
		$this->assertEquals("1,234.6", $actual);
		$actual = __cb_number_format(array(12345,2,"."));
		$this->assertEquals("12,345.00", $actual);
		$actual = __cb_number_format(array(1234,3,".",','));
		$this->assertEquals("1,234.000", $actual);
		$actual = __cb_number_format(array(123,4,",".'.'));
		$this->assertEquals("123,.0000", $actual);

		//less than 100
		$actual = __cb_number_format(array(10));
		$this->assertEquals("10", $actual);
		$actual = __cb_number_format(array(22,1));
		$this->assertEquals("22.0", $actual);
		$actual = __cb_number_format(array(45,2,','));
		$this->assertNotEquals("4500", $actual);
		$actual = __cb_number_format(array(38,3,",",'.'));
		$this->assertEquals("38,000", $actual);
		$actual = __cb_number_format(array(99,4,".",':'));
		$this->assertEquals("99.0000", $actual);

		//number with decimals
		$actual = __cb_number_format(array(999.999999));
		$this->assertNotEquals("999", $actual);
		$actual = __cb_number_format(array(999.999999,1));
		$this->assertEquals("1,000.0", $actual);
		$actual = __cb_number_format(array(999.999999,2,'.'));
		$this->assertEquals("1,000.00", $actual);
		$actual = __cb_number_format(array(999.999999,3,",",'.'));
		$this->assertEquals("1.000,000", $actual);
		$actual = __cb_number_format(array(999.999999,4,".",','));
		$this->assertEquals("1,000.0000", $actual);
		$actual = __cb_number_format(array(999394394.999999,5,",",'.'));
		$this->assertEquals("999.394.395,00000", $actual);
		$actual = __cb_number_format(array(99923456785433.999999,6,".",':'));
		$this->assertEquals("99:923:456:785:434.000000", $actual);
	}
}
?>