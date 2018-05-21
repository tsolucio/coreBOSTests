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
require_once 'modules/cbtranslation/number2string.php';
use PHPUnit\Framework\TestCase;
class number2stringTest extends TestCase {

	/**
	 * Method ConvertProvidor
	 * params
	 */
	public function ConvertProvidor() {
		return array(
			array('1', 'en', 'ONE'),
			array('2', 'en', 'TWO'),
			array('5', 'en', 'FIVE'),
			array('8', 'en', 'EIGHT'),
			array('10', 'en', 'TEN'),
			array('1', 'es', 'UNO'),
			array('2', 'es', 'DOS'),
			array('5', 'es', 'CINCO'),
			array('8', 'es', 'OCHO'),
			array('10', 'es', 'DIEZ'),
			array('12', 'en', 'TWELVE'),
			array('22', 'en', 'TWENTY-TWO'),
			array('52', 'en', 'FIFTY TWO'),
			array('82', 'en', 'EIGHTY TWO'),
			array('102', 'en', 'HUNDRED TWO'),
			array('251', 'en', 'TWO HUNDRED FIFTY ONE'),
			array('12', 'es', 'DOCE'),
			array('22', 'es', 'VEINTIDOS'),
			array('52', 'es', 'CINCUENTA Y DOS'),
			array('82', 'es', 'OCHENTA Y DOS'),
			array('102', 'es', 'CIENTO DOS'),
			array('251', 'es', 'DOSCIENTOS CINCUENTA Y UNO'),
			array('92.45', 'es', 'NOVENTA Y DOS coma CUARENTA Y CINCO'),
			array('92.45', 'en', 'NINETY TWO point FOURTY FIVE'),
			array('1025', 'es', 'MIL VEINTICINCO'),
			array('10279', 'es', 'DIEZ MIL DOSCIENTOS SETENTA Y NUEVE'),
			array('1025370', 'es', 'UN MILLON VEINTICINCO MIL TRESCIENTOS SETENTA'),
			array('10251025', 'es', 'DIEZ MILLONES DOSCIENTOS CINCUENTA Y UNO MIL VEINTICINCO'),
			array('251251025', 'es', 'DOSCIENTOS CINCUENTA Y UNO MILLONES DOSCIENTOS CINCUENTA Y UNO MIL VEINTICINCO'),
			array('1025', 'en', 'THOUSAND TWENTY-FIVE'),
			array('10279', 'en', 'TEN THOUSAND TWO HUNDRED SEVENTY NINE'),
			array('1025370', 'en', 'ONE MILLION TWENTY-FIVE THOUSAND THREE HUNDRED SEVENTY'),
			array('10251025', 'en', 'TEN MILLIONS TWO HUNDRED FIFTY ONE THOUSAND TWENTY-FIVE'),
			array('251251025', 'en', 'TWO HUNDRED FIFTY ONE MILLIONS TWO HUNDRED FIFTY ONE THOUSAND TWENTY-FIVE'),
			array('7463.58', 'en', 'SEVEN THOUSAND FOUR HUNDRED SIXTY THREE point FIFTY EIGHT'),
			array('7463.58', 'es', 'SIETE MIL CUATROCIENTOS SESENTA Y TRES coma CINCUENTA Y OCHO'),
			array('463.53', 'en', 'FOUR HUNDRED SIXTY THREE point FIFTY THREE'),
			array('463.53', 'es', 'CUATROCIENTOS SESENTA Y TRES coma CINCUENTA Y TRES'),
			array('46.353', 'en', 'FOURTY SIX point THREE HUNDRED FIFTY THREE'),
			array('46.353', 'es', 'CUARENTA Y SEIS coma TRESCIENTOS CINCUENTA Y TRES'),
		);
	}

	/**
	 * Method testconvert
	 * @test
	 * @dataProvider ConvertProvidor
	 */
	public function testconvert($num, $lang, $expected) {
		$this->assertEquals($expected, number2string::convert($num, $lang));
	}
}
