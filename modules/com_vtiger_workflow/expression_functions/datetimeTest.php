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

class workflowfunctionsdatetimeTest extends TestCase {

	/**
	 * Method testtimeDiff
	 * @test
	 */
	public function testtimeDiff() {
		$actual = __vt_time_diff(array('2017-06-20 11:30:30','2017-06-20 10:30:30'));
		$this->assertEquals(3600, $actual);
		$actual = __vt_time_diff(array('2017-06-20 13:30:30','2017-06-20 10:30:30'));
		$this->assertEquals(10800, $actual);
		$actual = __vt_time_diff(array('2017-06-21 02:30:30','2017-06-20 23:30:30'));
		$this->assertEquals(10800, $actual);
		$actual = __vt_time_diff(array('2017-06-20 23:30:30','2017-06-21 03:30:30'));
		$this->assertEquals(-14400, $actual);
		$actual = __vt_time_diffdays(array('2017-06-21 02:30:30','2017-06-20 23:30:30'));
		$this->assertEquals(0, $actual);
		$actual = __vt_time_diffdays(array('2017-06-20 23:30:30','2017-06-21 03:30:30'));
		$this->assertEquals(-1, $actual);
		$actual = __vt_time_diffdays(array('2017-06-25 23:30:30','2017-06-21 03:30:30'));
		$this->assertEquals(4, $actual);
	}

	/**
	 * Method testtimeDiffYears
	 * @test
	 */
	public function testtimeDiffYears() {
		$actual = __cb_time_diffyears(array('2017-06-20 11:30:30','2017-06-20 10:30:30'));
		$this->assertEquals(0, $actual);
		$actual = __cb_time_diffyears(array('2018-06-20 13:30:30','2017-06-20 10:30:30'));
		$this->assertEquals(1, $actual);
		$actual = __cb_time_diffyears(array('1967-01-29 02:30:30','2018-07-22 23:30:30'));
		$this->assertEquals(51, $actual);
		$actual = __cb_time_diffyears(array('2012-02-29 23:30:30','2016-02-29 03:30:30'));
		$this->assertEquals(3, $actual);
		$actual = __cb_time_diffyears(array('2012-02-29 23:30:30','2016-03-01 03:30:30'));
		$this->assertEquals(4, $actual);
		$actual = __cb_time_diffyears(array('2017-06-20 10:30:30','2018-06-20 13:30:30'));
		$this->assertEquals(1, $actual);
		$actual = __cb_time_diffyears(array('2017-06-25 23:30:30'));
		$date = new DateTime('2017-06-25 23:30:30');
		$now = new DateTime();
		$interval = $now->diff($date);
		$this->assertEquals($interval->y, $actual);
	}

	/**
	 * Method testgetWeekdayDifference
	 * @test
	 */
	public function testgetWeekdayDifference() {
		$actual = __cb_getWeekdayDifference(array('2017-06-21','2017-06-20'));
		$this->assertEquals(1, $actual);
		$actual = __cb_getWeekdayDifference(array('2017-06-20','2017-06-21'));
		$this->assertEquals(1, $actual);
		$actual = __cb_getWeekdayDifference(array('2017-06-21','2017-06-21'));
		$this->assertEquals(0, $actual);
		$actual = __cb_getWeekdayDifference(array('2017-06-24','2017-06-24'));
		$this->assertEquals(0, $actual);
		$actual = __cb_getWeekdayDifference(array('2017-06-24','2017-06-25'));
		$this->assertEquals(0, $actual);
		$actual = __cb_getWeekdayDifference(array('2017-06-25','2017-06-21'));
		$this->assertEquals(3, $actual);
		$actual = __cb_getWeekdayDifference(array('2017-06-21','2017-06-25'));
		$this->assertEquals(3, $actual);
		$actual = __cb_getWeekdayDifference(array('2017-07-01','2017-07-17'));
		$this->assertEquals(10, $actual);
	}

	/**
	 * Method testaddDays
	 * @test
	 */
	public function testaddDays() {
		$actual = __vt_add_days(array('2017-06-20',2));
		$this->assertEquals('2017-06-22', $actual);
		$actual = __vt_add_days(array('2017-06-20',12));
		$this->assertEquals('2017-07-02', $actual);
	}

	/**
	 * Method testsubDays
	 * @test
	 */
	public function testsubDays() {
		$actual = __vt_sub_days(array('2017-06-20',2));
		$this->assertEquals('2017-06-18', $actual);
		$actual = __vt_sub_days(array('2017-06-20',12));
		$this->assertEquals('2017-06-08', $actual);
		$actual = __vt_sub_days(array('2017-06-20',22));
		$this->assertEquals('2017-05-29', $actual);
	}

	/**
	 * Method testgetDate
	 * @test
	 */
	public function testgetDate() {
		$actual = __vt_get_date(array('today'));
		$this->assertEquals(date('Y-m-d'), $actual);
		$actual = __vt_get_date(array('invalid'));
		$this->assertEquals(date('Y-m-d'), $actual);
		$actual = __vt_get_date(array('tomorrow'));
		$this->assertEquals(date('Y-m-d', strtotime('+1 day')), $actual);
		$actual = __vt_get_date(array('yesterday'));
		$this->assertEquals(date('Y-m-d', strtotime('-1 day')), $actual);
		$actual = __vt_get_date(array('time'));
		$this->assertEquals(date('H:i:s'), $actual);
		$actual = __vt_get_date(array('TOMORROW'));
		$this->assertEquals(date('Y-m-d', strtotime('+1 day')), $actual);
	}

	/**
	 * Method testformatDate
	 * @test
	 */
	public function testformatDate() {
		$actual = __cb_format_date(array('2017-06-20','d-m-Y'));
		$this->assertEquals('20-06-2017', $actual);
		$actual = __cb_format_date(array('2017-06-20','M'));
		$this->assertEquals('Jun', $actual);
		$actual = __cb_format_date(array('2017-06-20','W H:i:s'));
		$this->assertEquals('25 00:00:00', $actual);
		//// time
		$actual = __cb_format_date(array('2017-06-20 22:30:33','d-m-Y'));
		$this->assertEquals('20-06-2017', $actual);
		$actual = __cb_format_date(array('2017-06-20 22:30:33','M'));
		$this->assertEquals('Jun', $actual);
		$actual = __cb_format_date(array('2017-06-20 22:30:33','W H:i:s'));
		$this->assertEquals('25 22:30:33', $actual);
		$actual = __cb_format_date(array('2017-06-20 22:30:33','d-m-Y H:i:s'));
		$this->assertEquals('20-06-2017 22:30:33', $actual);
		$actual = __cb_format_date(array('2017-06-20 22:30:33','M H:i:s'));
		$this->assertEquals('Jun 22:30:33', $actual);
		// empty date
		$actual = __cb_format_date(array('','d-m-Y H:i:s'));
		$this->assertEquals('', $actual);
	}

	/**
	 * Method testaddTime
	 * @test
	 */
	public function testaddTime() {
		$actual = __vt_add_time(array('20:06:20',22));
		$this->assertEquals('20:28:20', $actual);
		$actual = __vt_add_time(array('20:06:20',-22));
		$this->assertEquals('19:44:20', $actual);
		$actual = __vt_add_time(array('20:06:20',240));
		$this->assertEquals('00:06:20', $actual);
	}

	/**
	 * Method testsubTime
	 * @test
	 */
	public function testsubTime() {
		$actual = __vt_sub_time(array('20:06:20',22));
		$this->assertEquals('19:44:20', $actual);
		$actual = __vt_sub_time(array('20:06:20',-22));
		$this->assertEquals('20:28:20', $actual);
		$actual = __vt_sub_time(array('20:06:20',240));
		$this->assertEquals('16:06:20', $actual);
	}

	/**
	 * Method testnextDate
	 * @test
	 */
	public function testnextDate() {
		$actual = __cb_next_date(array('2017-06-20','15,30','',0));
		$this->assertEquals('2017-06-30', $actual);
		$actual = __cb_next_date(array('2017-06-30','15,30','',0));
		$this->assertEquals('2017-06-30', $actual);
		$actual = __cb_next_date(array('2017-07-01','15,30','',0));
		$this->assertEquals('2017-08-15', $actual);
		$actual = __cb_next_date(array('2017-07-01','15,30','',1));
		$this->assertEquals('2017-07-15', $actual);
		$actual = __cb_next_date(array('2017-07-01','15,30','2017-08-15',0));
		$this->assertEquals('2017-08-30', $actual);
	}

	/**
	 * Method testnextDateLaborable
	 * @test
	 */
	public function testnextDateLaborable() {
		$actual = __cb_next_dateLaborable(array('2017-06-20','15,30','',0));
		$this->assertEquals('2017-06-30', $actual);
		$actual = __cb_next_dateLaborable(array('2017-06-30','15,30','',0));
		$this->assertEquals('2017-06-30', $actual);
		$actual = __cb_next_dateLaborable(array('2017-07-01','15,30','',0));
		$this->assertEquals('2017-07-17', $actual);
		$actual = __cb_next_dateLaborable(array('2017-07-01','15,30','',1));
		$this->assertEquals('2017-07-15', $actual);
		$actual = __cb_next_dateLaborable(array('2017-07-01','15,30','2017-07-17,2017-08-15',0));
		$this->assertEquals('2017-07-18', $actual);
	}
}
?>