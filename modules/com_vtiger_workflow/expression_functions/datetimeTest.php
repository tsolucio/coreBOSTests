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

class datetimeTest extends TestCase {
	/****
	 * TEST Users decimal configuration
	 * name format is: {decimal_separator}{symbol_position}{grouping}{grouping_symbol}{currency}
	 ****/
	public $usrdota0x = 5; // testdmy
	public $usrcomd0x = 6; // testmdy
	public $usrdotd3com = 7; // testymd
	public $usrcoma3dot = 10; // testtz
	public $usrdota3comdollar = 12; // testmcurrency

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
	 * Method testnetworkholidaydays
	 * @test
	 */
	public function testnetworkholidaydays() {
		global $adb;
		$actual = __cb_networkdays(array('2017-06-21','2017-06-20', ''));
		$this->assertEquals(2, $actual);
		$s = new VTEXpressionSymbol('2017-06-21', 'string');
		$e = new VTEXpressionSymbol('2017-06-20', 'string');
		$sql = cbexpsql_networkdays(array($s,$e, ''), '');
		$rdo = $adb->query($sql);
		$this->assertEquals(2, $adb->query_result($rdo, 0, 0));
		$actual = __cb_holidaydifference(array('2017-06-21','2017-06-20', 0, ''));
		$this->assertEquals(1, $actual);
		$actual = __cb_holidaydifference(array('2017-06-21','2017-06-20', 1, ''));
		$this->assertEquals(1, $actual);
		$actual = __cb_networkdays(array('2017-06-20','2017-06-21', ''));
		$this->assertEquals(2, $actual);
		$s = new VTEXpressionSymbol('2017-06-20', 'string');
		$e = new VTEXpressionSymbol('2017-06-21', 'string');
		$sql = cbexpsql_networkdays(array($s,$e, ''), '');
		$rdo = $adb->query($sql);
		$this->assertEquals(2, $adb->query_result($rdo, 0, 0));
		$actual = __cb_holidaydifference(array('2017-06-20','2017-06-21', 0, ''));
		$this->assertEquals(1, $actual);
		$actual = __cb_holidaydifference(array('2017-06-20','2017-06-21', 1, ''));
		$this->assertEquals(1, $actual);
		$actual = __cb_networkdays(array('2017-06-21','2017-06-21', ''));
		$this->assertEquals(1, $actual);
		$s = new VTEXpressionSymbol('2017-06-21', 'string');
		$e = new VTEXpressionSymbol('2017-06-21', 'string');
		$sql = cbexpsql_networkdays(array($s,$e, ''), '');
		$rdo = $adb->query($sql);
		$this->assertEquals(1, $adb->query_result($rdo, 0, 0));
		$actual = __cb_holidaydifference(array('2017-06-21','2017-06-21', 0, ''));
		$this->assertEquals(0, $actual);
		$actual = __cb_holidaydifference(array('2017-06-21','2017-06-21', 1, ''));
		$this->assertEquals(0, $actual);
		$actual = __cb_networkdays(array('2017-06-24','2017-06-24', ''));
		$this->assertEquals(0, $actual);
		$s = new VTEXpressionSymbol('2017-06-24', 'string');
		$e = new VTEXpressionSymbol('2017-06-24', 'string');
		$sql = cbexpsql_networkdays(array($s,$e, ''), '');
		$rdo = $adb->query($sql);
		$this->assertEquals(0, $adb->query_result($rdo, 0, 0));
		$actual = __cb_holidaydifference(array('2017-06-24','2017-06-24', 0, ''));
		$this->assertEquals(0, $actual);
		$actual = __cb_holidaydifference(array('2017-06-24','2017-06-24', 1, ''));
		$this->assertEquals(0, $actual);
		$actual = __cb_networkdays(array('2017-06-24','2017-06-25', ''));
		$this->assertEquals(0, $actual);
		$s = new VTEXpressionSymbol('2017-06-24', 'string');
		$e = new VTEXpressionSymbol('2017-06-25', 'string');
		$sql = cbexpsql_networkdays(array($s,$e, ''), '');
		$rdo = $adb->query($sql);
		$this->assertEquals(0, $adb->query_result($rdo, 0, 0));
		$actual = __cb_holidaydifference(array('2017-06-24','2017-06-25', 0, ''));
		$this->assertEquals(0, $actual);
		$actual = __cb_holidaydifference(array('2017-06-24','2017-06-25', 1, ''));
		$this->assertEquals(1, $actual);
		$actual = __cb_networkdays(array('2017-06-25','2017-06-21', ''));
		$this->assertEquals(3, $actual);
		$s = new VTEXpressionSymbol('2017-06-25', 'string');
		$e = new VTEXpressionSymbol('2017-06-21', 'string');
		$sql = cbexpsql_networkdays(array($s,$e, ''), '');
		$rdo = $adb->query($sql);
		$this->assertEquals(3, $adb->query_result($rdo, 0, 0));
		$actual = __cb_holidaydifference(array('2017-06-25','2017-06-21', 0, ''));
		$this->assertEquals(3, $actual);
		$actual = __cb_holidaydifference(array('2017-06-25','2017-06-21', 1, ''));
		$this->assertEquals(4, $actual);
		$actual = __cb_networkdays(array('2017-06-21','2017-06-25', ''));
		$this->assertEquals(3, $actual);
		$s = new VTEXpressionSymbol('2017-06-21', 'string');
		$e = new VTEXpressionSymbol('2017-06-25', 'string');
		$sql = cbexpsql_networkdays(array($s,$e, ''), '');
		$rdo = $adb->query($sql);
		$this->assertEquals(3, $adb->query_result($rdo, 0, 0));
		$actual = __cb_holidaydifference(array('2017-06-21','2017-06-25', 0, ''));
		$this->assertEquals(3, $actual);
		$actual = __cb_holidaydifference(array('2017-06-21','2017-06-25', 1, ''));
		$this->assertEquals(4, $actual);
		$actual = __cb_networkdays(array('2017-07-01','2017-07-17', ''));
		$this->assertEquals(11, $actual);
		$s = new VTEXpressionSymbol('2017-07-01', 'string');
		$e = new VTEXpressionSymbol('2017-07-17', 'string');
		$sql = cbexpsql_networkdays(array($s,$e, ''), '');
		$rdo = $adb->query($sql);
		$this->assertEquals(11, $adb->query_result($rdo, 0, 0));
		$actual = __cb_holidaydifference(array('2017-07-01','2017-07-17', 0, ''));
		$this->assertEquals(10, $actual);
		$actual = __cb_holidaydifference(array('2017-07-01','2017-07-17', 1, ''));
		$this->assertEquals(13, $actual);
	}

	/**
	 * Method networkdaysprovidor
	 */
	public function networkdaysprovidor() {
		$p1d = new DateInterval('P1D');
		$st = new DateTime('2017-06-19');
		$ed = new DateTime('2017-06-27');
		$results = array(
			1,2,3,4,5,5,5,6, // L
			2,1,2,3,4,4,4,5, // M
			3,2,1,2,3,3,3,4, // X
			4,3,2,1,2,2,2,3, // J
			5,4,3,2,1,1,1,2, // V
			5,4,3,2,1,0,0,1, // S
			5,4,3,2,1,0,0,1, // D
			6,5,4,3,2,1,1,1, // L
		);
		$tests = array();
		$sdaterange = new DatePeriod($st, $p1d, $ed);
		$edaterange = new DatePeriod($st, $p1d, $ed);
		$r = 0;
		foreach ($sdaterange as $sdate) {
			foreach ($edaterange as $edate) {
				$tests[] = array($sdate->format('Y-m-d'), $edate->format('Y-m-d'), $results[$r]);
				$r++;
			}
		}
		$st = new DateTime('2017-07-01');
		$ed = new DateTime('2017-07-21');
		$results = array(
			0,0,1,2,3,4,5,5,5,6,7,8,9,10,10,10,11,12,13,14,
			0,1,2,3,4,5,5,5,6,7,8,9,10,10,10,11,12,13,14,
			1,2,3,4,5,5,5,6,7,8,9,10,10,10,11,12,13,14,
			1,2,3,4,4,4,5,6,7,8,9,9,9,10,11,12,13,
			1,2,3,3,3,4,5,6,7,8,8,8,9,10,11,12,
			1,2,2,2,3,4,5,6,7,7,7,8,9,10,11,
			1,1,1,2,3,4,5,6,6,6,7,8,9,10,
			0,0,1,2,3,4,5,5,5,6,7,8,9,
			0,1,2,3,4,5,5,5,6,7,8,9,
			1,2,3,4,5,5,5,6,7,8,9,
			1,2,3,4,4,4,5,6,7,8,
			1,2,3,3,3,4,5,6,7,
			1,2,2,2,3,4,5,6,
			1,1,1,2,3,4,5,
			0,0,1,2,3,4,
			0,1,2,3,4,
			1,2,3,4,
			1,2,3,
			1,2,
			1,
		);
		$sdaterange = new DatePeriod($st, $p1d, $ed);
		$r = 0;
		foreach ($sdaterange as $sdate) {
			$edaterange = new DatePeriod($sdate, $p1d, $ed);
			foreach ($edaterange as $edate) {
				$tests[] = array($sdate->format('Y-m-d'), $edate->format('Y-m-d'), $results[$r]);
				$r++;
			}
		}
		return $tests;
	}

	/**
	 * Method testnetworkdays
	 * @test
	 * @dataProvider networkdaysprovidor
	 */
	public function testnetworkdays($st, $ed, $expected) {
		global $adb;
		$actual = __cb_networkdays(array($st,$ed, ''));
		$this->assertEquals($expected, $actual);
		$s = new VTEXpressionSymbol($st, 'string');
		$e = new VTEXpressionSymbol($ed, 'string');
		$sql = cbexpsql_networkdays(array($s,$e, ''), '');
		$rdo = $adb->query($sql);
		$this->assertEquals($expected, $adb->query_result($rdo, 0, 0));
	}

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

	/**
	 * Method testaddDays
	 * @test
	 */
	public function testaddDays() {
		$actual = __vt_add_days(array('2017-06-20',2));
		$this->assertEquals('2017-06-22', $actual);
		$actual = __vt_add_days(array('2017-06-20',12));
		$this->assertEquals('2017-07-02', $actual);
		global $current_user;
		$hold = $current_user;
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrdota0x);
		$actual = __vt_add_days(array('20-06-2017',2));
		$this->assertEquals('2017-06-22', $actual);
		$actual = __vt_add_days(array('20-06-2017',12));
		$this->assertEquals('2017-07-02', $actual);
		$actual = __vt_add_days(array('2017-06-20',2));
		$this->assertEquals('2017-06-22', $actual);
		$actual = __vt_add_days(array('2017-06-20',12));
		$this->assertEquals('2017-07-02', $actual);
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrcomd0x);
		$actual = __vt_add_days(array('06-20-2017',2));
		$this->assertEquals('2017-06-22', $actual);
		$actual = __vt_add_days(array('06-20-2017',12));
		$this->assertEquals('2017-07-02', $actual);
		$actual = __vt_add_days(array('2017-06-20',2));
		$this->assertEquals('2017-06-22', $actual);
		$actual = __vt_add_days(array('2017-06-20',12));
		$this->assertEquals('2017-07-02', $actual);
		/////////////////
		$current_user = $hold;
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
		global $current_user;
		$hold = $current_user;
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrdota0x);
		$actual = __vt_sub_days(array('20-06-2017',2));
		$this->assertEquals('2017-06-18', $actual);
		$actual = __vt_sub_days(array('20-06-2017',12));
		$this->assertEquals('2017-06-08', $actual);
		$actual = __vt_sub_days(array('20-06-2017',22));
		$this->assertEquals('2017-05-29', $actual);
		$actual = __vt_sub_days(array('2017-06-20',2));
		$this->assertEquals('2017-06-18', $actual);
		$actual = __vt_sub_days(array('2017-06-20',12));
		$this->assertEquals('2017-06-08', $actual);
		$actual = __vt_sub_days(array('2017-06-20',22));
		$this->assertEquals('2017-05-29', $actual);
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrcomd0x);
		$actual = __vt_sub_days(array('06-20-2017',2));
		$this->assertEquals('2017-06-18', $actual);
		$actual = __vt_sub_days(array('06-20-2017',12));
		$this->assertEquals('2017-06-08', $actual);
		$actual = __vt_sub_days(array('06-20-2017',22));
		$this->assertEquals('2017-05-29', $actual);
		$actual = __vt_sub_days(array('2017-06-20',2));
		$this->assertEquals('2017-06-18', $actual);
		$actual = __vt_sub_days(array('2017-06-20',12));
		$this->assertEquals('2017-06-08', $actual);
		$actual = __vt_sub_days(array('2017-06-20',22));
		$this->assertEquals('2017-05-29', $actual);
		/////////////////
		$current_user = $hold;
	}

	/**
	 * Method testgetDate
	 * @test
	 */
	public function testgetDate() {
		$actual = __vt_get_date(array('now'));
		$this->assertEquals(date('Y-m-d H:i:s'), $actual);
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

	/**
	 * Method testaddworkdays
	 * @test
	 */
	public function testaddworkdays() {
		$actual = __cb_add_workdays(array('2017-06-20',10,1,''));
		$this->assertEquals('2017-07-01', $actual);
		$actual = __cb_add_workdays(array('2017-06-20',10,0,''));
		$this->assertEquals('2017-07-04', $actual);
		$actual = __cb_add_workdays(array('2017-06-30',10,1,''));
		$this->assertEquals('2017-07-12', $actual);
		$actual = __cb_add_workdays(array('2017-06-30',10,0,''));
		$this->assertEquals('2017-07-14', $actual);
		$actual = __cb_add_workdays(array('2017-07-01',10,1,''));
		$this->assertEquals('2017-07-13', $actual);
		$actual = __cb_add_workdays(array('2017-07-01',10,0,''));
		$this->assertEquals('2017-07-14', $actual);
		////////////
		$actual = __cb_add_workdays(array('2017-06-20',10,1,'2017-06-27,2017-07-04'));
		$this->assertEquals('2017-07-03', $actual);
		$actual = __cb_add_workdays(array('2017-06-20',10,0,'2017-06-27,2017-07-04'));
		$this->assertEquals('2017-07-06', $actual);
		$actual = __cb_add_workdays(array('2017-06-30',10,1,'2017-06-27,2017-07-04'));
		$this->assertEquals('2017-07-13', $actual);
		$actual = __cb_add_workdays(array('2017-06-30',10,0,'2017-06-27,2017-07-04'));
		$this->assertEquals('2017-07-17', $actual);
		$actual = __cb_add_workdays(array('2017-07-01',10,1,'2017-06-27,2017-07-04'));
		$this->assertEquals('2017-07-14', $actual);
		$actual = __cb_add_workdays(array('2017-07-01',10,0,'2017-06-27,2017-07-04'));
		$this->assertEquals('2017-07-17', $actual);
	}

	/**
	 * Method testsubworkdays
	 * @test
	 */
	public function testsubworkdays() {
		$actual = __cb_sub_workdays(array('2020-10-02',10,1,''));
		$this->assertEquals('2020-09-21', $actual);
		$actual = __cb_sub_workdays(array('2020-10-02',10,0,''));
		$this->assertEquals('2020-09-18', $actual);
		/////////////
		$actual = __cb_sub_workdays(array('2020-10-02',10,1,'2020-09-28,2020-10-01'));
		$this->assertEquals('2020-09-18', $actual);
		$actual = __cb_sub_workdays(array('2020-10-02',10,0,'2020-09-28,2020-10-01'));
		$this->assertEquals('2020-09-16', $actual);
	}
}
?>
