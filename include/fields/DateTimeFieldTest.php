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
class tstDateTimeField extends TestCase {

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
		$holduser = $current_user;
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

		$testdate = '2018-02-05 09:00';
		$fmtdate = $dt->convertTimeZone($testdate,'UTC','Europe/Amsterdam');
		$expectedDateTime = new DateTime('2018-02-05 10:00:00', new DateTimeZone('Europe/Amsterdam'));
		$this->assertEquals($expectedDateTime, $fmtdate,'d');

		$testdate = '2016-02-25 33:30:00';
		$fmtdate = $dt->convertTimeZone($testdate,'UTC','UTC');
		$expectedDateTime = new DateTime('2016-02-25 00:00:00', new DateTimeZone('UTC'));
		$this->assertEquals($expectedDateTime, $fmtdate,'d');

		$testdate = '2016-02-25 19:30';
		$fmtdate = $dt->convertTimeZone($testdate,'UTC','UTC');
		$expectedDateTime = new DateTime('2016-02-25 19:30:00', new DateTimeZone('UTC'));
		$this->assertEquals($expectedDateTime, $fmtdate,'d');

		$testdate = '3 Jun 2016';
		$fmtdate = $dt->convertTimeZone($testdate,'UTC','UTC');
		$expectedDateTime = new DateTime('2016-06-03 00:00:00', new DateTimeZone('UTC'));
		$this->assertEquals($expectedDateTime, $fmtdate,'d');

		$testdate = '10:30';
		$fmtdate = $dt->convertTimeZone($testdate,'UTC','UTC');
		$expectedDateTime = new DateTime(date('Y-m-d').' 10:30:00', new DateTimeZone('UTC'));
		$this->assertEquals($expectedDateTime, $fmtdate,'d');

		$testdate = '190:30';
		$fmtdate = $dt->convertTimeZone($testdate,'UTC','UTC');
		$expectedDateTime = new DateTime(date('Y-m-d').' 00:00:00', new DateTimeZone('UTC'));
		$this->assertEquals($expectedDateTime, $fmtdate,'d');

		$testdate = '2016-02-25 190:30';
		$fmtdate = $dt->convertTimeZone($testdate,'UTC','UTC');
		$expectedDateTime = new DateTime('2016-02-25 00:00:00', new DateTimeZone('UTC'));
		$this->assertEquals($expectedDateTime, $fmtdate,'d');

		$testdate = '25-02-2016 20:30:00'; // works only because PHP knows how to transform it
		$fmtdate = $dt->convertTimeZone($testdate,'UTC','UTC');
		$expectedDateTime = new DateTime('2016-02-25 20:30:00', new DateTimeZone('UTC'));
		$this->assertEquals($expectedDateTime, $fmtdate,'d');
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
	 * Method testgetDisplayDateTimeValueComponents
	 * @test
	 */
	public function testgetDisplayDateTimeValueComponents() {
		global $current_user;
		$holduser = $current_user;
		$expectedDateTime = array(
			'year' => '2016',
			'month' => '02',
			'day' => '25',
			'hour' => '20',
			'minute' => '30',
			'second' => '00',
		);
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(5); // testdmy
		$dt = new DateTimeField('25-02-2016 20:30:00');
		$fmtdate = $dt->getDisplayDateTimeValueComponents($user);
		$this->assertEquals($expectedDateTime, $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(6); // testmdy
		$current_user = $user;
		$dt = new DateTimeField('02-25-2016 20:30:00');
		$fmtdate = $dt->getDisplayDateTimeValueComponents($user);
		$this->assertEquals($expectedDateTime, $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(7); // testymd
		$dt = new DateTimeField('2016-02-25 20:30:00');
		$fmtdate = $dt->getDisplayDateTimeValueComponents($user);
		$this->assertEquals($expectedDateTime, $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(10); // testtz  TimeZone Ymd +1 Madrid
		$dt = new DateTimeField('2016-02-25 20:30:00');
		$fmtdate = $dt->getDisplayDateTimeValueComponents($user);
		$expectedDateTime['hour'] = '21';
		$this->assertEquals($expectedDateTime, $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(10); // testtz  TimeZone Ymd +1 Madrid
		$dt = new DateTimeField('2016-02-25 00:30:00');
		$fmtdate = $dt->getDisplayDateTimeValueComponents($user);
		$expectedDateTime['hour'] = '01';
		$this->assertEquals($expectedDateTime, $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(13); // testtz-3  TimeZone Ymd -3 Buenos Aires
		$dt = new DateTimeField('2016-02-25 23:30:00');
		$fmtdate = $dt->getDisplayDateTimeValueComponents($user);
		$expectedDateTime['hour'] = '20';
		$this->assertEquals($expectedDateTime, $fmtdate);
		$dt = new DateTimeField('2016-02-26 02:30:00');
		$fmtdate = $dt->getDisplayDateTimeValueComponents($user);
		$expectedDateTime['hour'] = '23';
		$this->assertEquals($expectedDateTime, $fmtdate);
		$current_user = $holduser;
	}

	/**
	 * Method testgetDBInsertDateTimeValueComponents
	 * @test
	 */
	public function testgetDBInsertDateTimeValueComponents() {
		global $current_user;
		$holduser = $current_user;
		$expectedDateTime = array(
			'year' => '2016',
			'month' => '02',
			'day' => '25',
			'hour' => '20',
			'minute' => '30',
			'second' => '00',
		);
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(5); // testdmy
		$dt = new DateTimeField('25-02-2016 20:30:00');
		$fmtdate = $dt->getDBInsertDateTimeValueComponents($user);
		$this->assertEquals($expectedDateTime, $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(6); // testmdy
		$current_user = $user;
		$dt = new DateTimeField('02-25-2016 20:30:00');
		$fmtdate = $dt->getDBInsertDateTimeValueComponents($user);
		$this->assertEquals($expectedDateTime, $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(7); // testymd
		$dt = new DateTimeField('2016-02-25 20:30:00');
		$fmtdate = $dt->getDBInsertDateTimeValueComponents($user);
		$this->assertEquals($expectedDateTime, $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(10); // testtz  TimeZone Ymd +1 Madrid
		$dt = new DateTimeField('2016-02-25 20:30:00');
		$fmtdate = $dt->getDBInsertDateTimeValueComponents($user);
		$expectedDateTime['hour'] = '19';
		$this->assertEquals($expectedDateTime, $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(10); // testtz  TimeZone Ymd +1 Madrid
		$dt = new DateTimeField('2016-02-25 00:30:00');
		$fmtdate = $dt->getDBInsertDateTimeValueComponents($user);
		$expectedDateTime['hour'] = '23';
		$expectedDateTime['day'] = '24';
		$this->assertEquals($expectedDateTime, $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(13); // testtz-3  TimeZone Ymd -3 Buenos Aires
		$dt = new DateTimeField('2016-02-25 23:30:00');
		$fmtdate = $dt->getDBInsertDateTimeValueComponents($user);
		$expectedDateTime['hour'] = '02';
		$expectedDateTime['day'] = '26';
		$this->assertEquals($expectedDateTime, $fmtdate);
		$dt = new DateTimeField('2016-02-26 02:30:00');
		$fmtdate = $dt->getDBInsertDateTimeValueComponents($user);
		$expectedDateTime['hour'] = '05';
		$this->assertEquals($expectedDateTime, $fmtdate);
		$current_user = $holduser;
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
	 * Method testconvertToDBFormatFirstDayOfMonth
	 * @test
	 */
	public function testconvertToDBFormatFirstDayOfMonth() {
		global $current_user;
		$user = new Users();
		$testdate = '2016-06-01';
		$user->retrieveCurrentUserInfoFromFile(5); // testdmy
		$dt = new DateTimeField('01-06-2016');
		$fmtdate = $dt->convertToDBFormat('01-06-2016',$user);
		$this->assertEquals($testdate, $fmtdate);
		$fmtdate = $dt->getDBInsertDateValue($user);
		$this->assertEquals($testdate, $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(6); // testmdy
		$dt = new DateTimeField('06-01-2016');
		$fmtdate = $dt->convertToDBFormat('06-01-2016',$user);
		$this->assertEquals($testdate, $fmtdate);
		$fmtdate = $dt->getDBInsertDateValue($user);
		$this->assertEquals($testdate, $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(7); // testymd
		$dt = new DateTimeField('2016-06-01');
		$fmtdate = $dt->convertToDBFormat('2016-06-01',$user);
		$this->assertEquals($testdate, $fmtdate);
		$fmtdate = $dt->getDBInsertDateValue($user);
		$this->assertEquals($testdate, $fmtdate);
	}

	/**
	 * Method testconvertToDBFormatLastDayOfMonth
	 * @test
	 */
	public function testconvertToDBFormatLastDayOfMonth() {
		global $current_user;
		$user = new Users();
		$testdate = '2016-06-30';
		$user->retrieveCurrentUserInfoFromFile(5); // testdmy
		$dt = new DateTimeField('30-06-2016');
		$fmtdate = $dt->convertToDBFormat('30-06-2016',$user);
		$this->assertEquals($testdate, $fmtdate);
		$fmtdate = $dt->getDBInsertDateValue($user);
		$this->assertEquals($testdate, $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(6); // testmdy
		$dt = new DateTimeField('06-30-2016');
		$fmtdate = $dt->convertToDBFormat('06-30-2016',$user);
		$this->assertEquals($testdate, $fmtdate);
		$fmtdate = $dt->getDBInsertDateValue($user);
		$this->assertEquals($testdate, $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(7); // testymd
		$dt = new DateTimeField('2016-06-30');
		$fmtdate = $dt->convertToDBFormat('2016-06-30',$user);
		$this->assertEquals($testdate, $fmtdate);
		$fmtdate = $dt->getDBInsertDateValue($user);
		$this->assertEquals($testdate, $fmtdate);
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
		$user->retrieveCurrentUserInfoFromFile(10); // testtz  TimeZone Ymd +1 Madrid
		$dt = new DateTimeField('2016-02-25 20:30:00');
		$fmtdate = $dt->convertToDBTimeZone('2016-02-25 20:30:00',$user);
		$expectedDateTime = new DateTime('2016-02-25 19:30:00', new DateTimeZone('UTC'));
		$this->assertEquals($expectedDateTime, $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(10); // testtz  TimeZone Ymd +1 Madrid
		$dt = new DateTimeField('2016-02-25 00:30:00');
		$fmtdate = $dt->convertToDBTimeZone('2016-02-25 00:30:00',$user);
		$expectedDateTime = new DateTime('2016-02-24 23:30:00', new DateTimeZone('UTC'));
		$this->assertEquals($expectedDateTime, $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(13); // testtz-3  TimeZone Ymd -3 Buenos Aires
		$dt = new DateTimeField('2016-02-25 23:30:00');
		$fmtdate = $dt->convertToDBTimeZone('2016-02-25 23:30:00',$user);
		$expectedDateTime = new DateTime('2016-02-26 02:30:00', new DateTimeZone('UTC'));
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

	/**
	 * Method testconvertToDBFormatISO
	 * @test
	 */
	public function testconvertToDBFormatISO() {
		global $current_user;
		$user = new Users();
		$testdate = '2016-02-25';
		$user->retrieveCurrentUserInfoFromFile(5); // testdmy
		$dt = new DateTimeField($testdate);
		$fmtdate = $dt->convertToDBFormat($testdate,$user);
		$this->assertEquals($testdate, $fmtdate);
		$fmtdate = $dt->getDBInsertDateValue($user);
		$this->assertEquals($testdate, $fmtdate);
		$fmtdate = $dt->getDBInsertTimeValue($user);
		$this->assertEquals('00:00:00', $fmtdate);
		$fmtdate = $dt->getDBInsertDateTimeValue($user);
		$this->assertEquals($testdate.' 00:00:00', $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(6); // testmdy
		$fmtdate = $dt->convertToDBFormat($testdate,$user);
		$this->assertEquals($testdate, $fmtdate);
		$fmtdate = $dt->getDBInsertDateValue($user);
		$this->assertEquals($testdate, $fmtdate);
		$fmtdate = $dt->getDBInsertTimeValue($user);
		$this->assertEquals('00:00:00', $fmtdate);
		$fmtdate = $dt->getDBInsertDateTimeValue($user);
		$this->assertEquals($testdate.' 00:00:00', $fmtdate);
		$user->retrieveCurrentUserInfoFromFile(7); // testymd
		$fmtdate = $dt->convertToDBFormat($testdate,$user);
		$this->assertEquals($testdate, $fmtdate);
		$fmtdate = $dt->getDBInsertDateValue($user);
		$this->assertEquals($testdate, $fmtdate);
		$fmtdate = $dt->getDBInsertTimeValue($user);
		$this->assertEquals('00:00:00', $fmtdate);
		$fmtdate = $dt->getDBInsertDateTimeValue($user);
		$this->assertEquals($testdate.' 00:00:00', $fmtdate);
	}

	/**
	 * Method testformatUserTimeString
	 * @test
	 */
	public function testformatUserTimeString() {
		$this->assertEquals('01:15', DateTimeField::formatUserTimeString('01:15',24), 'normal 24 time lt 12');
		$this->assertEquals('13:15', DateTimeField::formatUserTimeString('13:15',24), 'normal 24 time gt 12');
		$this->assertEquals('01:15', DateTimeField::formatUserTimeString('1:15',24), 'missing number 24 time');
		$this->assertEquals('01:15AM', DateTimeField::formatUserTimeString('01:15',12), 'normal 12 time lt 12');
		$this->assertEquals('01:15PM', DateTimeField::formatUserTimeString('13:15',12), 'normal 12 time gt 12');
		$this->assertEquals('01:15AM', DateTimeField::formatUserTimeString('1:15',12), 'missing number 12 time');
		//////////////////
		$this->assertEquals('01:15', DateTimeField::formatUserTimeString('2017-09-02 01:15',24), 'normal 24 time lt 12 with date');
		$this->assertEquals('13:15', DateTimeField::formatUserTimeString('2017-09-02 13:15',24), 'normal 24 time gt 12 with date');
		$this->assertEquals('01:15', DateTimeField::formatUserTimeString('2017-09-02 1:15',24), 'missing number 24 time with date');
		$this->assertEquals('01:15AM', DateTimeField::formatUserTimeString('2017-09-02 01:15',12), 'normal 12 time lt 12 with date');
		$this->assertEquals('01:15PM', DateTimeField::formatUserTimeString('2017-09-02 13:15',12), 'normal 12 time gt 12 with date');
		$this->assertEquals('01:15AM', DateTimeField::formatUserTimeString('2017-09-02 1:15',12), 'missing number 12 time with date');
		//////////////////
		$this->assertEquals('01:05', DateTimeField::formatUserTimeString(array('hour'=>'1','minute'=>'5'),24), 'missing number 24 time with array');
		$this->assertEquals('01:05PM', DateTimeField::formatUserTimeString(array('hour'=>'13','minute'=>'5'),12), 'normal 24 time gt 12 with array');
		$this->assertEquals('01:05AM', DateTimeField::formatUserTimeString(array('hour'=>'1','minute'=>'5'),12), 'missing number 12 time with array');
	}

	/**
	 * Method testformatDatebaseTimeString
	 * @test
	 */
	public function testformatDatebaseTimeString() {
		$this->assertEquals('01:15', DateTimeField::formatDatebaseTimeString('01:15',24), 'normal 24 time lt 12');
		$this->assertEquals('01:15', DateTimeField::formatDatebaseTimeString('1:15',24), 'missing number 24 time');
		$this->assertEquals('13:15', DateTimeField::formatDatebaseTimeString('13:15',24), 'normal 24 time gt 12');
		$this->assertEquals('01:15', DateTimeField::formatDatebaseTimeString('01:15','am'), 'normal am time');
		$this->assertEquals('01:15', DateTimeField::formatDatebaseTimeString('1:15','am'), 'missing number am time');
		$this->assertEquals('13:15', DateTimeField::formatDatebaseTimeString('01:15','pm'), 'normal pm time');
		$this->assertEquals('13:15', DateTimeField::formatDatebaseTimeString('1:15','pm'), 'missing number pm time');
		$this->assertEquals('00:15', DateTimeField::formatDatebaseTimeString('12:15','am'), 'normal am 12 time');
		$this->assertEquals('13:15', DateTimeField::formatDatebaseTimeString('12:15','pm'), 'normal pm 12 time');
		//////////////////
		$this->assertEquals('2017-09-02 01:15', DateTimeField::formatDatebaseTimeString('2017-09-02 01:15',24), 'normal 24 time lt 12');
		$this->assertEquals('2017-09-02 01:15', DateTimeField::formatDatebaseTimeString('2017-09-02 1:15',24), 'missing number 24 time');
		$this->assertEquals('2017-09-02 13:15', DateTimeField::formatDatebaseTimeString('2017-09-02 13:15',24), 'normal 24 time gt 12');
		$this->assertEquals('2017-09-02 01:15', DateTimeField::formatDatebaseTimeString('2017-09-02 01:15','am'), 'normal am time');
		$this->assertEquals('2017-09-02 01:15', DateTimeField::formatDatebaseTimeString('2017-09-02 1:15','am'), 'missing number am time');
		$this->assertEquals('2017-09-02 13:15', DateTimeField::formatDatebaseTimeString('2017-09-02 01:15','pm'), 'normal pm time');
		$this->assertEquals('2017-09-02 13:15', DateTimeField::formatDatebaseTimeString('2017-09-02 1:15','pm'), 'missing number pm time');
		$this->assertEquals('2017-09-02 00:15', DateTimeField::formatDatebaseTimeString('2017-09-02 12:15','am'), 'normal am 12 time');
		$this->assertEquals('2017-09-02 13:15', DateTimeField::formatDatebaseTimeString('2017-09-02 12:15','pm'), 'normal pm 12 time');
	}

	/**
	 * Method testtwoDigit
	 * @test
	 */
	public function testtwoDigit() {
		$this->assertEquals('01', DateTimeField::twoDigit('1'), 'normal string');
		$this->assertEquals('01', DateTimeField::twoDigit('01'), 'correct string');
		$this->assertEquals('01', DateTimeField::twoDigit(1), 'normal num');
		$this->assertEquals('0k', DateTimeField::twoDigit('k'), 'k');
		$this->assertEquals('0k', DateTimeField::twoDigit(' k '), 'space k');
		$this->assertEquals('kk', DateTimeField::twoDigit('kk'), 'kk');
		$this->assertEquals('kk', DateTimeField::twoDigit('kkkk'), 'kkkk');
	}

	/**
	 * Method testsanitizeTime
	 * @test
	 */
	public function testsanitizeTime() {
		$this->assertEquals('00:00:00', DateTimeField::sanitizeTime(''), 'empty');
		$this->assertEquals('00:00:00', DateTimeField::sanitizeTime(0), 'empty 0');
		$this->assertEquals('00:01:00', DateTimeField::sanitizeTime('1'), 'minutes bad');
		$this->assertEquals('00:08:00', DateTimeField::sanitizeTime(8), 'minutes bad');
		$this->assertEquals('00:01:00', DateTimeField::sanitizeTime('01'), 'minutes correct');
		$this->assertEquals('01:00:00', DateTimeField::sanitizeTime('1:00'), 'hour bad');
		$this->assertEquals('01:00:00', DateTimeField::sanitizeTime('01:00'), 'hour correct');
		$this->assertEquals('01:00:00', DateTimeField::sanitizeTime('1:00:00'), 'seconds bad');
		$this->assertEquals('01:00:00', DateTimeField::sanitizeTime('01:00:00'), 'seconds correct');
		$this->assertEquals('01:01:00', DateTimeField::sanitizeTime('1:1'), 'hour/min bad');
		$this->assertEquals('01:10:00', DateTimeField::sanitizeTime('01:10'), 'hour/min correct');
		$this->assertEquals('01:01:00', DateTimeField::sanitizeTime('1:1:00'), 'seconds bad');
		$this->assertEquals('01:10:00', DateTimeField::sanitizeTime('01:10:00'), 'seconds correct');
		$this->assertEquals('01:01:01', DateTimeField::sanitizeTime('1:1:1'), 'hour/min bad');
		$this->assertEquals('01:01:01', DateTimeField::sanitizeTime('01:01:1'), 'hour/min bad');
		$this->assertEquals('01:01:01', DateTimeField::sanitizeTime('01:1:01'), 'hour/min bad');
		$this->assertEquals('01:01:01', DateTimeField::sanitizeTime('01:1:1'), 'hour/min bad');
		$this->assertEquals('01:01:01', DateTimeField::sanitizeTime('1:01:1'), 'hour/min bad');
	}

}
?>