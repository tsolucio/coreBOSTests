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
class testWebservicesUtils extends TestCase {

	/**
	 * Method vtws_getParameterProvider
	 * params
	 */
	public function vtws_getParameterProvider() {
		return array(
			array(array(
					'string' => 'string'
				), 'string', null, 'string', 'string'),
			array(array(
					'string' => 'st"r<in>g'
				), 'string', null, 'st\"r<in>g', 'string with chars1'),
			array(array(
					'string' => "st'r\in>g"
				), 'string', null, "st\'r\\\in>g", 'string with chars2'),
			array(array(
					'string' => 'st"r\in>g'
				), 'string', null, 'st\"r\\\in>g', 'string with chars3'),
			array(array(
					'string' => 'string'
				), 'string', 'notused', 'string', 'string default not used'),
			array(array(
					'string' => 'st"r<in>g'
				), 'string', 'notused', 'st\"r<in>g', 'string with chars1 default not used'),
			array(array(
					'string' => "st'r\in>g"
				), 'string', 'notused', "st\'r\\\in>g", 'string with chars2 default not used'),
			array(array(
					'string' => 'st"r\in>g'
				), 'string', 'notused', 'st\"r\\\in>g', 'string with chars3 default not used'),
			array(array(
					'string' => ''
				), 'string', 'used', 'used', 'string empty default used'),
			array(array(
					'string' => 'st"r<in>g'
				), 'notpresent', 'used', 'used', 'param not presentdefault used'),
			array(array(
					'string' => ''
				), 'string', null, null, 'string empty default NULL'),
			array(array(
					'string' => 'st"r<in>g'
				), 'notpresent', null, null, 'param not presentdefault NULL'),
			///////////////////////////////////
			array(
				array(
					'array' => array(
						'string1' => 'string',
						'string2' => 'st"r<in>g',
						'string3' => "st'r\in>g",
						'string4' => 'st"r\in>g',
					)
				), 'array', null,
				array(
					'string1' => 'string',
					'string2' => 'st\"r<in>g',
					'string3' => "st\'r\\\in>g",
					'string4' => 'st\"r\\\in>g',
				), 'array with strings'),
		);
	}

	/**
	 * Method testvtws_getParameter
	 * @test
	 * @dataProvider vtws_getParameterProvider
	 */
	public function testvtws_getParameter($parameterArray, $paramName, $default, $expected, $message) {
		$actual = vtws_getParameter($parameterArray, $paramName, $default);
		$this->assertEquals($expected, $actual,"testvtws_getParameter $message");
	}

}

?>