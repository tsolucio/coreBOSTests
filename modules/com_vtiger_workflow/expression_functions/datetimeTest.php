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
include_once 'modules/com_vtiger_workflow/expression_functions/cbexpSQL.php';
use PHPUnit\Framework\TestCase;

class workflowfunctionsdatetimeTest extends TestCase {
	/**
	 * Method testisHolidayDate
	 * @test
	 */
	public function testisHolidayDate() {
		$actual = __cb_isHolidayDate(array('2021-06-20', 0, '2021-06-16, 2021-06-17, 2021-06-18, 2021-06-19, 2021-06-20'));
		$this->assertEquals(true, $actual);
		$actual = __cb_isHolidayDate(array('2021-07-24', 1, '2021-06-16, 2021-06-17, 2021-06-18, 2021-06-19, 2021-06-20'));
		$this->assertEquals(true, $actual);
		$actual = __cb_isHolidayDate(array('2021-06-16', 0, '2021-06-16, 2021-06-17, 2021-06-18, 2021-06-19, 2021-06-20'));
		$this->assertEquals(true, $actual);
		$actual = __cb_isHolidayDate(array('2021-06-15', 0, '2021-06-16, 2021-06-17, 2021-06-18, 2021-06-19, 2021-06-20'));
		$this->assertEquals(false, $actual);
		$actual = __cb_isHolidayDate(array('2021-06-11', 1));
		$this->assertEquals(false, $actual);
		$actual = __cb_isHolidayDate(array('', 1));
		$this->assertEquals(false, $actual);
		$actual = __cb_isHolidayDate(array('2021-06-11', 0));
		$this->assertEquals(false, $actual);
		$actual = __cb_isHolidayDate(array('2021-07-26', 1, '2021-06-16, 2021-06-17, 2021-06-18, 2021-06-19, 2021-06-20'));
		$this->assertEquals(false, $actual);
		$actual = __cb_isHolidayDate(array('2021-06-27', 0));
		$this->assertEquals(true, $actual);
	}
}
?>
