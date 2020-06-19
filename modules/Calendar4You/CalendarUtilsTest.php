<?php
/*************************************************************************************************
 * Copyright 2020 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

include_once 'modules/Calendar4You/CalendarUtils.php';

class CalendarUtilsTest extends TestCase {

	/**
	 * Method getaddITSEventPopupTimeProvider
	 * params
	 */
	public function getaddITSEventPopupTimeProvider() {
		return array(
			array('09:31', '10:26', '12', array('startfmt'=>'am', 'starthour'=>'09', 'startmin'=>'31', 'endfmt'=>'am', 'endhour'=>'10', 'endmin'=>'26'), '12 am'),
			array('21:31', '22:26', '12', array('startfmt'=>'pm', 'starthour'=>'09', 'startmin'=>'31', 'endfmt'=>'pm', 'endhour'=>'10', 'endmin'=>'26'), '12 pm'),
			array('0:31', '0:56', '12', array('startfmt'=>'am', 'starthour'=>'12', 'startmin'=>'31', 'endfmt'=>'am', 'endhour'=>'12', 'endmin'=>'56'), '12 pm'),
			array('0:31', '0:56', '24', array('startfmt'=>'', 'starthour'=>'00', 'startmin'=>'31', 'endfmt'=>'', 'endhour'=>'00', 'endmin'=>'56'), '24 am'),
			array('09:31', '10:26', '24', array('startfmt'=>'', 'starthour'=>'09', 'startmin'=>'31', 'endfmt'=>'', 'endhour'=>'10', 'endmin'=>'26'), '24 am'),
			array('21:31', '22:26', '24', array('startfmt'=>'', 'starthour'=>'21', 'startmin'=>'31', 'endfmt'=>'', 'endhour'=>'22', 'endmin'=>'26'), '24 pm'),
			//////////////////
			array('8:31', '1:26', '12', array('startfmt'=>'am', 'starthour'=>'08', 'startmin'=>'31', 'endfmt'=>'am', 'endhour'=>'01', 'endmin'=>'26'), '12 am'),
			array('8:31', '1:26', '24', array('startfmt'=>'', 'starthour'=>'08', 'startmin'=>'31', 'endfmt'=>'', 'endhour'=>'01', 'endmin'=>'26'), '24 am'),
			array('09:31', '10:26', 'am/pm', array('startfmt'=>'am', 'starthour'=>'09', 'startmin'=>'31', 'endfmt'=>'am', 'endhour'=>'10', 'endmin'=>'26'), '12 am'),
			array('21:31', '22:26', 'am/pm', array('startfmt'=>'pm', 'starthour'=>'09', 'startmin'=>'31', 'endfmt'=>'pm', 'endhour'=>'10', 'endmin'=>'26'), '12 pm'),
			array('8:31', '1:26', '', array('startfmt'=>'', 'starthour'=>'08', 'startmin'=>'31', 'endfmt'=>'', 'endhour'=>'01', 'endmin'=>'26'), '24 am'),
			array('8:1', '1:2', '', array('startfmt'=>'', 'starthour'=>'08', 'startmin'=>'1', 'endfmt'=>'', 'endhour'=>'01', 'endmin'=>'2'), '24 am'),
		);
	}

	/**
	 * Method testgetaddITSEventPopupTime
	 * @test
	 * @dataProvider getaddITSEventPopupTimeProvider
	 */
	public function testgetaddITSEventPopupTime($starttime, $endtime, $format, $expected, $msg) {
		$this->assertEquals($expected, getaddITSEventPopupTime($starttime, $endtime, $format), $msg);
	}
}
