<?php
/*************************************************************************************************
 * Copyright 2016 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

class testOperationManagerEnDecode extends TestCase {

	protected static $omEDjson;

	public static function setUpBeforeClass() {
		self::$omEDjson = new OperationManagerEnDecode();
	}

	/**
	 * Method encodeProvider
	 * params
	 */
	public function encodeProvider() {
		return array(
			array('Normal string','"Normal string"','Normal string'),
			array(123.456,123.456,'123.456'),
			array(true,'true','true'),
			array(null,'null','null'),
			array(array('string'),'["string"]','array with string'),
			array(array('string1','string2'),'["string1","string2"]','array with two string'),
			array(array('string',123.456),'["string",123.456]','array with string and number'),
			array(array('string',123.456,true),'["string",123.456,true]','array with string, number and boolean'),
			array(array('string',123.456,true,null),'["string",123.456,true,null]','array with string, number boolean and null'),
			array(array('k1'=>'string1','k2'=>'string2'),'{"k1":"string1","k2":"string2"}','array with keys string'),
			array(array('k1'=>'string','k2'=>123.456,'k3'=>true,'k4'=>null),'{"k1":"string","k2":123.456,"k3":true,"k4":null}','array with keys on string, number boolean and null'),
		);
	}

	/**
	 * Method testencode
	 * @test
	 * @dataProvider encodeProvider
	 */
	public function testencode($input, $expected, $message) {
		$actual = self::$omEDjson->encode($input);
		$this->assertEquals($expected, $actual, "testencode $message");
	}

	/**
	 * Method decodeProvider
	 * params
	 */
	public function decodeProvider() {
		return array(
			array('Normal string','"Normal string"','Normal string'),
			array(123.456,123.456,'123.456'),
			array(true,'true','true'),
			array(null,'null','null'),
			array(array('string'),'["string"]','array with string'),
			array(array('string1','string2'),'["string1","string2"]','array with two string'),
			array(array('string',123.456),'["string",123.456]','array with string and number'),
			array(array('string',123.456,true),'["string",123.456,true]','array with string, number and boolean'),
			array(array('string',123.456,true,null),'["string",123.456,true,null]','array with string, number boolean and null'),
			array(array('k1'=>'string1','k2'=>'string2'),'{"k1":"string1","k2":"string2"}','array with keys string'),
			array(array('k1'=>'string','k2'=>123.456,'k3'=>true,'k4'=>null),'{"k1":"string","k2":123.456,"k3":true,"k4":null}','array with keys on string, number boolean and null'),
		);
	}

	/**
	 * Method testdecode
	 * @test
	 * @dataProvider decodeProvider
	 */
	public function testdecode($expected, $input, $message) {
		$actual = self::$omEDjson->decode($input);
		$this->assertEquals($expected, $actual, "testdecode $message");
	}
}
?>