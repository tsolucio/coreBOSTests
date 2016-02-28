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

class tstDateTimeField extends PHPUnit_Framework_TestCase {

	/**
	 * Method testconvertToUserFormat
	 * @test
	 */
	public function testconvertToUserFormat() {
		global $current_user;
		$user = new Users();
		$testdate = '2016-02-25';
		$dt = new DateTimeField($testdate);
		$user->retrieveCurrentUserInfoFromFile(5); // testdmy
		$fmtdate = $dt->convertToUserFormat($testdate,$user);
		$this->assertEquals('25-02-2016', $fmtdate);
		$fmtdate = $dt->getDisplayDate($user);
		$this->assertEquals('25-02-2016', $fmtdate);
		$fmtdate = $dt->getDisplayTime($user);
		$this->assertEquals('00:00:00', $fmtdate);
		$fmtdate = $dt->getDisplayDateTimeValue($user);
		$this->assertEquals('25-02-2016 00:00:00', $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(6); // testmdy
		$fmtdate = $dt->convertToUserFormat($testdate,$user);
		$this->assertEquals('02-25-2016', $fmtdate);
		$fmtdate = $dt->getDisplayDate($user);
		$this->assertEquals('02-25-2016', $fmtdate);
		$fmtdate = $dt->getDisplayTime($user);
		$this->assertEquals('00:00:00', $fmtdate);
		$fmtdate = $dt->getDisplayDateTimeValue($user);
		$this->assertEquals('02-25-2016 00:00:00', $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(7); // testymd
		$fmtdate = $dt->convertToUserFormat($testdate,$user);
		$this->assertEquals('2016-02-25', $fmtdate);
		$fmtdate = $dt->getDisplayDate($user);
		$this->assertEquals('2016-02-25', $fmtdate);
		$fmtdate = $dt->getDisplayTime($user);
		$this->assertEquals('00:00:00', $fmtdate);
		$fmtdate = $dt->getDisplayDateTimeValue($user);
		$this->assertEquals('2016-02-25 00:00:00', $fmtdate);
		/// current user
		switch ($current_user->date_format) {
			case 'dd-mm-yyyy':
				$edate = '25-02-2016';
				break;
			case 'mm-dd-yyyy':
				$edate = '02-25-2016';
				break;
			case 'yyyy-mm-dd':
				$edate = '2016-02-25';
				break;
			default:
				$edate = '2016-02-25';
				break;
		}
		$fmtdate = $dt->convertToUserFormat($testdate);
		$this->assertEquals($edate, $fmtdate);
		$fmtdate = $dt->getDisplayDate();
		$this->assertEquals($edate, $fmtdate);
		$fmtdate = $dt->getDisplayTime();
		$this->assertEquals('00:00:00', $fmtdate);
		$fmtdate = $dt->getDisplayDateTimeValue();
		$this->assertEquals($edate.' 00:00:00', $fmtdate);
	}

	/**
	 * Method testconvertToUserTimeZone
	 * @test
	 */
	public function testconvertToUserTimeZone() {
		global $current_user;
		$user = new Users();
		$testdate = '2016-02-25 20:30:00';
		$dt = new DateTimeField($testdate);
		$user->retrieveCurrentUserInfoFromFile(7); // testymd
		$fmtdate = $dt->convertToUserTimeZone($testdate,$user);
		$expectedDateTime = new DateTime('2016-02-25 20:30:00', new DateTimeZone('UTC'));
		$this->assertEquals($expectedDateTime, $fmtdate,'a');
		$user->retrieveCurrentUserInfoFromFile(10); // testtz  TimeZone
		$fmtdate = $dt->convertToUserTimeZone($testdate,$user);
		$expectedDateTime = new DateTime('2016-02-25 20:30:00', new DateTimeZone('Europe/London'));
		$this->assertEquals($expectedDateTime, $fmtdate,'b');
		//////////////
		$fmtdate = $dt->convertTimeZone($testdate,'UTC','Europe/Kiev');
		$expectedDateTime = new DateTime('2016-02-25 22:30:00', new DateTimeZone('Europe/Kiev'));
		$this->assertEquals($expectedDateTime, $fmtdate,'c');
	}

	/**
	 * Method testconvertToUserFormatTime
	 * @test
	 */
	public function testconvertToUserFormatTime() {
		global $current_user;
		$user = new Users();
		$testdate = '2016-02-25 20:30:00';
		$dt = new DateTimeField($testdate);
		$user->retrieveCurrentUserInfoFromFile(5); // testdmy
		$fmtdate = $dt->convertToUserFormat($testdate,$user);
		$this->assertEquals('25-02-2016 20:30:00', $fmtdate);
		$fmtdate = $dt->getDisplayDate($user);
		$this->assertEquals('25-02-2016', $fmtdate);
		$fmtdate = $dt->getDisplayTime($user);
		$this->assertEquals('20:30:00', $fmtdate);
		$fmtdate = $dt->getDisplayDateTimeValue($user);
		$this->assertEquals('25-02-2016 20:30:00', $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(6); // testmdy
		$fmtdate = $dt->convertToUserFormat($testdate,$user);
		$this->assertEquals('02-25-2016 20:30:00', $fmtdate);
		$fmtdate = $dt->getDisplayDate($user);
		$this->assertEquals('02-25-2016', $fmtdate);
		$fmtdate = $dt->getDisplayTime($user);
		$this->assertEquals('20:30:00', $fmtdate);
		$fmtdate = $dt->getDisplayDateTimeValue($user);
		$this->assertEquals('02-25-2016 20:30:00', $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(7); // testymd
		$fmtdate = $dt->convertToUserFormat($testdate,$user);
		$this->assertEquals('2016-02-25 20:30:00', $fmtdate);
		$fmtdate = $dt->getDisplayDate($user);
		$this->assertEquals('2016-02-25', $fmtdate);
		$fmtdate = $dt->getDisplayTime($user);
		$this->assertEquals('20:30:00', $fmtdate);
		$fmtdate = $dt->getDisplayDateTimeValue($user);
		$this->assertEquals('2016-02-25 20:30:00', $fmtdate);
		/// current user
		switch ($current_user->date_format) {
			case 'dd-mm-yyyy':
				$edate = '25-02-2016';
				break;
			case 'mm-dd-yyyy':
				$edate = '02-25-2016';
				break;
			case 'yyyy-mm-dd':
				$edate = '2016-02-25';
				break;
			default:
				$edate = '2016-02-25';
				break;
		}
		$fmtdate = $dt->convertToUserFormat($testdate);
		$this->assertEquals($edate.' 20:30:00', $fmtdate);
		$fmtdate = $dt->getDisplayDate();
		$this->assertEquals($edate, $fmtdate);
		$fmtdate = $dt->getDisplayTime();
		$this->assertEquals('20:30:00', $fmtdate);
		$fmtdate = $dt->getDisplayDateTimeValue();
		$this->assertEquals($edate.' 20:30:00', $fmtdate);
		//////////
		$user->retrieveCurrentUserInfoFromFile(10); // testtz  TimeZone
		$fmtdate = $dt->convertToUserFormat($testdate,$user);
		$this->assertEquals('2016-02-25 20:30:00', $fmtdate);
		$fmtdate = $dt->getDisplayDate($user);
		$this->assertEquals('2016-02-25', $fmtdate);
		$fmtdate = $dt->getDisplayTime($user);
		$this->assertEquals('21:30:00', $fmtdate);
		$fmtdate = $dt->getDisplayDateTimeValue($user);
		$this->assertEquals('2016-02-25 21:30:00', $fmtdate);
	}

	/**
	 * Method testgetPHPDateFormat
	 * @test
	 */
	public function testgetPHPDateFormat() {
		global $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(5); // testdmy
		$fmtdate = DateTimeField::getPHPDateFormat($user);
		$this->assertEquals('dd-mm-yyyy', $user->date_format);
		$this->assertEquals('d-m-Y', $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(6); // testmdy
		$fmtdate = DateTimeField::getPHPDateFormat($user);
		$this->assertEquals('mm-dd-yyyy', $user->date_format);
		$this->assertEquals('m-d-Y', $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(7); // testymd
		$fmtdate = DateTimeField::getPHPDateFormat($user);
		$this->assertEquals('yyyy-mm-dd', $user->date_format);
		$this->assertEquals('Y-m-d', $fmtdate);
	}

	/**
	 * Method testgetDBTimeZone
	 * @test
	 */
	public function testgetDBTimeZone() {
		global $default_timezone;
		$apptz = DateTimeField::getDBTimeZone();
		$this->assertEquals($default_timezone, $apptz);
	}

	/**
	 * Method testconvertToDBFormat
	 * @test
	 */
	public function testconvertToDBFormat() {
		global $current_user;
		$user = new Users();
		$testdate = '2016-02-25';
		$user->retrieveCurrentUserInfoFromFile(5); // testdmy
		$dt = new DateTimeField('25-02-2016');
		$fmtdate = $dt->convertToDBFormat('25-02-2016',$user);
		$this->assertEquals($testdate, $fmtdate);
		$fmtdate = $dt->getDBInsertDateValue($user);
		$this->assertEquals($testdate, $fmtdate);
		$fmtdate = $dt->getDBInsertTimeValue($user);
		$this->assertEquals('00:00:00', $fmtdate);
		$fmtdate = $dt->getDBInsertDateTimeValue($user);
		$this->assertEquals($testdate.' 00:00:00', $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(6); // testmdy
		$dt = new DateTimeField('02-25-2016');
		$fmtdate = $dt->convertToDBFormat('02-25-2016',$user);
		$this->assertEquals($testdate, $fmtdate);
		$fmtdate = $dt->getDBInsertDateValue($user);
		$this->assertEquals($testdate, $fmtdate);
		$fmtdate = $dt->getDBInsertTimeValue($user);
		$this->assertEquals('00:00:00', $fmtdate);
		$fmtdate = $dt->getDBInsertDateTimeValue($user);
		$this->assertEquals($testdate.' 00:00:00', $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(7); // testymd
		$dt = new DateTimeField('2016-02-25');
		$fmtdate = $dt->convertToDBFormat('2016-02-25',$user);
		$this->assertEquals($testdate, $fmtdate);
		$fmtdate = $dt->getDBInsertDateValue($user);
		$this->assertEquals($testdate, $fmtdate);
		$fmtdate = $dt->getDBInsertTimeValue($user);
		$this->assertEquals('00:00:00', $fmtdate);
		$fmtdate = $dt->getDBInsertDateTimeValue($user);
		$this->assertEquals($testdate.' 00:00:00', $fmtdate);
		/// current user
		switch ($current_user->date_format) {
			case 'dd-mm-yyyy':
				$tdate = '25-02-2016';
				break;
			case 'mm-dd-yyyy':
				$tdate = '02-25-2016';
				break;
			case 'yyyy-mm-dd':
				$tdate = '2016-02-25';
				break;
			default:
				$tdate = '2016-02-25';
				break;
		}
		$dt = new DateTimeField($tdate);
		$fmtdate = $dt->convertToDBFormat($tdate);
		$this->assertEquals($testdate, $fmtdate);
		$fmtdate = $dt->getDBInsertDateValue();
		$this->assertEquals($testdate, $fmtdate);
		$fmtdate = $dt->getDBInsertTimeValue();
		$this->assertEquals('00:00:00', $fmtdate);
		$fmtdate = $dt->getDBInsertDateTimeValue();
		$this->assertEquals($testdate.' 00:00:00', $fmtdate);
	}

	/**
	 * Method testconvertToDBTimeZone
	 * @test
	 */
	public function testconvertToDBTimeZone() {
		global $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(5); // testdmy
		$dt = new DateTimeField('25-02-2016 20:30:00');
		$fmtdate = $dt->convertToDBTimeZone('25-02-2016 20:30:00',$user);
		$expectedDateTime = new DateTime('2016-02-25 20:30:00', new DateTimeZone('UTC'));
		$this->assertEquals($expectedDateTime, $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(6); // testmdy
		$dt = new DateTimeField('02-25-2016 20:30:00');
		$fmtdate = $dt->convertToDBTimeZone('02-25-2016 20:30:00',$user);
		$expectedDateTime = new DateTime('2016-02-25 20:30:00', new DateTimeZone('UTC'));
		$this->assertEquals($expectedDateTime, $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(7); // testymd
		$dt = new DateTimeField('2016-02-25 20:30:00');
		$fmtdate = $dt->convertToDBTimeZone('2016-02-25 20:30:00',$user);
		$expectedDateTime = new DateTime('2016-02-25 20:30:00', new DateTimeZone('UTC'));
		$this->assertEquals($expectedDateTime, $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(10); // testtz  TimeZone Ymd
		$dt = new DateTimeField('2016-02-25 20:30:00');
		$fmtdate = $dt->convertToDBTimeZone('2016-02-25 20:30:00',$user);
		$expectedDateTime = new DateTime('2016-02-25 19:30:00', new DateTimeZone('UTC'));
		$this->assertEquals($expectedDateTime, $fmtdate);
		/// current user
		switch ($current_user->date_format) {
			case 'dd-mm-yyyy':
				$tdate = '25-02-2016 20:30:00';
				break;
			case 'mm-dd-yyyy':
				$tdate = '02-25-2016 20:30:00';
				break;
			case 'yyyy-mm-dd':
				$tdate = '2016-02-25 20:30:00';
				break;
			default:
				$tdate = '2016-02-25 20:30:00';
				break;
		}
		$dt = new DateTimeField('2016-02-25 20:30:00');
		$fmtdate = $dt->convertToDBTimeZone('2016-02-25 20:30:00');
		$expectedDateTime = new DateTime('2016-02-25 20:30:00', new DateTimeZone('UTC'));
		$this->assertEquals($expectedDateTime, $fmtdate);
	}

}
?>