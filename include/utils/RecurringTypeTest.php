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
class testRecurringType extends TestCase {

	var $monday = 1;
	var $tuesday = 2;
	var $wednesday = 3;
	var $thursday = 4;
	var $friday = 5;
	var $saturday = 6;
	var $sunday = 7;
	var $first = 1;
	var $second = 2;
	var $third = 3;
	var $last = 4;
	var $stubRT = array(
					'date_start' => '2016-05-05',
					'due_date' => '2016-09-09',
					'time_start' => '15:00',
					'time_end' => '16:00',
					'recurringtype' => 'Monthly',
					'wed_flag' => 'on',
					'repeatMonth' => 'day',
					'repeatMonth_date' => '',
					'repeatMonth_daytype' => 'first',
					'repeat_frequency' => '1',
				);

	public function setup() {
		$darr = array('day' => 1, 'month' => 1, 'year' => 2016);
		$this->dateObj[1] = new vt_DateTime($darr, true);
		$darr = array('day' => 15, 'month' => 1, 'year' => 2016);
		$this->dateObj[2] = new vt_DateTime($darr, true);
		$darr = array('day' => 29, 'month' => 1, 'year' => 2016);
		$this->dateObj[3] = new vt_DateTime($darr, true);
		$darr = array('day' => 1, 'month' => 2, 'year' => 2016);
		$this->dateObj[4] = new vt_DateTime($darr, true);
		$this->rtobj = $this->getrecurringObjValue($this->stubRT);
	}

	/**
	 * Method getFistdayofmonthProvider
	 * params
	 */
	public function getFistdayofmonthProvider() {
		return array(
			array(1,$this->monday,4,'monday'),
			array(1,$this->tuesday,5,'tuesday'),
			array(1,$this->wednesday,6,'wednesday'),
			array(1,$this->thursday,7,'thursday'),
			array(1,$this->friday,1,'friday'),
			array(1,$this->saturday,2,'saturday'),
			array(1,$this->sunday,3,'sunday'),
			array(2,$this->monday,4,'monday'),
			array(2,$this->tuesday,5,'tuesday'),
			array(2,$this->wednesday,6,'wednesday'),
			array(2,$this->thursday,7,'thursday'),
			array(2,$this->friday,1,'friday'),
			array(2,$this->saturday,2,'saturday'),
			array(2,$this->sunday,3,'sunday'),
			array(3,$this->monday,4,'monday'),
			array(3,$this->tuesday,5,'tuesday'),
			array(3,$this->wednesday,6,'wednesday'),
			array(3,$this->thursday,7,'thursday'),
			array(3,$this->friday,1,'friday'),
			array(3,$this->saturday,2,'saturday'),
			array(3,$this->sunday,3,'sunday'),
			array(4,$this->monday,1,'monday'),
			array(4,$this->tuesday,2,'tuesday'),
			array(4,$this->wednesday,3,'wednesday'),
			array(4,$this->thursday,4,'thursday'),
			array(4,$this->friday,5,'friday'),
			array(4,$this->saturday,6,'saturday'),
			array(4,$this->sunday,7,'sunday'),
		);
	}

	/**
	 * Method testgetFistdayofmonth
	 * @dataProvider getFistdayofmonthProvider
	 * @test
	 */
	public function testgetFistdayofmonth($date2use,$dow,$expected,$msg) {
		$actual = $this->rtobj->getFistdayofmonth($dow, $this->dateObj[$date2use]);
		$this->assertEquals($expected, $actual->get_Date(), "testgetFistdayofmonth $msg of date ($date2use)");
	}

	/**
	 * Method getLastdayofmonthProvider
	 * params
	 */
	public function getLastdayofmonthProvider() {
		return array(
			array(1,$this->monday,28,'monday'),
			array(1,$this->tuesday,29,'tuesday'),
			array(1,$this->wednesday,30,'wednesday'),
			array(1,$this->thursday,31,'thursday'),
			array(1,$this->friday,1,'friday'),
			array(1,$this->saturday,26,'saturday'),
			array(1,$this->sunday,27,'sunday'),
			array(2,$this->monday,11,'monday'),
			array(2,$this->tuesday,12,'tuesday'),
			array(2,$this->wednesday,13,'wednesday'),
			array(2,$this->thursday,14,'thursday'),
			array(2,$this->friday,15,'friday'),
			array(2,$this->saturday,9,'saturday'),
			array(2,$this->sunday,10,'sunday'),
			array(3,$this->monday,25,'monday'),
			array(3,$this->tuesday,26,'tuesday'),
			array(3,$this->wednesday,27,'wednesday'),
			array(3,$this->thursday,28,'thursday'),
			array(3,$this->friday,29,'friday'),
			array(3,$this->saturday,23,'saturday'),
			array(3,$this->sunday,24,'sunday'),
			array(4,$this->monday,1,'monday'),
			array(4,$this->tuesday,26,'tuesday'),
			array(4,$this->wednesday,27,'wednesday'),
			array(4,$this->thursday,28,'thursday'),
			array(4,$this->friday,29,'friday'),
			array(4,$this->saturday,30,'saturday'),
			array(4,$this->sunday,31,'sunday'),
		);
	}

	/**
	 * Method testgetLastdayofmonth
	 * @dataProvider getLastdayofmonthProvider
	 * @test
	 */
	public function testgetLastdayofmonth($date2use,$dow,$expected,$msg) {
		$actual = $this->rtobj->getLastdayofmonth($dow, $this->dateObj[$date2use]);
		$this->assertEquals($expected, $actual->get_Date(), "testgetLastdayofmonth $msg of date ($date2use)");
	}

	/**
	 * Method getDayOfWeekPerWeekPositionInMonthProvider
	 * params
	 */
	public function getDayOfWeekPerWeekPositionInMonthProvider() {
		return array(
			array(1,$this->monday,$this->first,4,'first monday'),
			array(1,$this->tuesday,$this->first,5,'first tuesday'),
			array(1,$this->wednesday,$this->first,6,'first wednesday'),
			array(1,$this->thursday,$this->first,7,'first thursday'),
			array(1,$this->friday,$this->first,1,'first friday'),
			array(1,$this->saturday,$this->first,2,'first saturday'),
			array(1,$this->sunday,$this->first,3,'first sunday'),
			array(1,$this->monday,$this->second,11,'second monday'),
			array(1,$this->tuesday,$this->second,12,'second tuesday'),
			array(1,$this->wednesday,$this->second,13,'second wednesday'),
			array(1,$this->thursday,$this->second,14,'second thursday'),
			array(1,$this->friday,$this->second,8,'second friday'),
			array(1,$this->saturday,$this->second,9,'second saturday'),
			array(1,$this->sunday,$this->second,10,'second sunday'),
			array(1,$this->monday,$this->third,18,'third monday'),
			array(1,$this->tuesday,$this->third,19,'third tuesday'),
			array(1,$this->wednesday,$this->third,20,'third wednesday'),
			array(1,$this->thursday,$this->third,21,'third thursday'),
			array(1,$this->friday,$this->third,15,'third friday'),
			array(1,$this->saturday,$this->third,16,'third saturday'),
			array(1,$this->sunday,$this->third,17,'third sunday'),
			array(1,$this->monday,$this->last,25,'last monday'),
			array(1,$this->tuesday,$this->last,26,'last tuesday'),
			array(1,$this->wednesday,$this->last,27,'last wednesday'),
			array(1,$this->thursday,$this->last,28,'last thursday'),
			array(1,$this->friday,$this->last,29,'last friday'),
			array(1,$this->saturday,$this->last,30,'last saturday'),
			array(1,$this->sunday,$this->last,31,'last sunday'),
			array(4,$this->monday,$this->first,1,'first monday'),
			array(4,$this->tuesday,$this->first,2,'first tuesday'),
			array(4,$this->wednesday,$this->first,3,'first wednesday'),
			array(4,$this->thursday,$this->first,4,'first thursday'),
			array(4,$this->friday,$this->first,5,'first friday'),
			array(4,$this->saturday,$this->first,6,'first saturday'),
			array(4,$this->sunday,$this->first,7,'first sunday'),
			array(4,$this->monday,$this->second,8,'second monday'),
			array(4,$this->tuesday,$this->second,9,'second tuesday'),
			array(4,$this->wednesday,$this->second,10,'second wednesday'),
			array(4,$this->thursday,$this->second,11,'second thursday'),
			array(4,$this->friday,$this->second,12,'second friday'),
			array(4,$this->saturday,$this->second,13,'second saturday'),
			array(4,$this->sunday,$this->second,14,'second sunday'),
			array(4,$this->monday,$this->third,15,'third monday'),
			array(4,$this->tuesday,$this->third,16,'third tuesday'),
			array(4,$this->wednesday,$this->third,17,'third wednesday'),
			array(4,$this->thursday,$this->third,18,'third thursday'),
			array(4,$this->friday,$this->third,19,'third friday'),
			array(4,$this->saturday,$this->third,20,'third saturday'),
			array(4,$this->sunday,$this->third,21,'third sunday'),
			array(4,$this->monday,$this->last,29,'last monday'),
			array(4,$this->tuesday,$this->last,23,'last tuesday'),
			array(4,$this->wednesday,$this->last,24,'last wednesday'),
			array(4,$this->thursday,$this->last,25,'last thursday'),
			array(4,$this->friday,$this->last,26,'last friday'),
			array(4,$this->saturday,$this->last,27,'last saturday'),
			array(4,$this->sunday,$this->last,28,'last sunday'),
		);
	}

	/**
	 * Method testgetDayOfWeekPerWeekPositionInMonth
	 * @dataProvider getDayOfWeekPerWeekPositionInMonthProvider
	 * @test
	 */
	public function testgetDayOfWeekPerWeekPositionInMonth($date2use,$dow,$position,$expected,$msg) {
		$actual = $this->rtobj->getDayOfWeekPerWeekPositionInMonth($dow, $this->dateObj[$date2use]->getYear(), $this->dateObj[$date2use]->getMonth(), $position);
		$this->assertEquals($expected, $actual, "testgetDayOfWeekPerWeekPositionInMonth $msg of date ($date2use)");
	}

	/**
	 * Method getRecurringTypeProvider
	 * params
	 */
	public function getRecurringTypeProvider() {
		return array(
			array(
				array(
					'date_start' => '2016-05-05',
					'due_date' => '2016-09-09',
					'time_start' => '15:00',
					'time_end' => '16:00',
					'recurringtype' => 'Monthly',
					'wed_flag' => 'on',
					'repeatMonth' => 'day',
					'repeatMonth_date' => '',
					'repeatMonth_daytype' => 'first',
					'repeat_frequency' => '1',
				)
			),
		);
	}

	/**
	 * Function to get RecurringType object
	 * param array of setup values
	 *   date_start
	 *   calendar_repeat_limit_date | due_date
	 *   time_start
	 *   time_end
	 *   recurringtype:  Weekly | Monthly
	 *   sun_flag | mon_flag | tue_flag | wed_flag | thu_flag | fri_flag | sat_flag
	 *   repeatMonth {month} | date | day
	 *   repeatMonth_date  {date}
	 *   repeatMonth_day: 1-6
	 *   repeatMonth_daytype  first | second | third | last
	 *   repeat_frequency [1-14]
	 * return $recurObj - Object of class RecurringType
	 */
	function getrecurringObjValue($rtsetup) {
		$recurring_data = array();
		$startDate = $rtsetup['date_start'];
		if (!empty($rtsetup['calendar_repeat_limit_date'])) {
			$endDate = $rtsetup['calendar_repeat_limit_date'];
		} else {
			$endDate = $rtsetup['due_date'];
		}
		$startTime = $rtsetup['time_start'];
		$endTime = $rtsetup['time_end'];

		$recurring_data['startdate'] = $startDate;
		$recurring_data['starttime'] = $startTime;
		$recurring_data['enddate'] = $endDate;
		$recurring_data['endtime'] = $endTime;

		$recurring_data['type'] = $rtsetup['recurringtype'];
		if ($rtsetup['recurringtype'] == 'Weekly') {
			if (isset($rtsetup['sun_flag']) && $rtsetup['sun_flag'] != null)
				$recurring_data['sun_flag'] = true;
			if (isset($rtsetup['mon_flag']) && $rtsetup['mon_flag'] != null)
				$recurring_data['mon_flag'] = true;
			if (isset($rtsetup['tue_flag']) && $rtsetup['tue_flag'] != null)
				$recurring_data['tue_flag'] = true;
			if (isset($rtsetup['wed_flag']) && $rtsetup['wed_flag'] != null)
				$recurring_data['wed_flag'] = true;
			if (isset($rtsetup['thu_flag']) && $rtsetup['thu_flag'] != null)
				$recurring_data['thu_flag'] = true;
			if (isset($rtsetup['fri_flag']) && $rtsetup['fri_flag'] != null)
				$recurring_data['fri_flag'] = true;
			if (isset($rtsetup['sat_flag']) && $rtsetup['sat_flag'] != null)
				$recurring_data['sat_flag'] = true;
		}
		elseif ($rtsetup['recurringtype'] == 'Monthly') {
			if (isset($rtsetup['repeatMonth']) && $rtsetup['repeatMonth'] != null)
				$recurring_data['repeatmonth_type'] = $rtsetup['repeatMonth'];
			if ($recurring_data['repeatmonth_type'] == 'date') {
				if (isset($rtsetup['repeatMonth_date']) && $rtsetup['repeatMonth_date'] != null)
					$recurring_data['repeatmonth_date'] = $rtsetup['repeatMonth_date'];
				else
					$recurring_data['repeatmonth_date'] = 1;
			}
			elseif ($recurring_data['repeatmonth_type'] == 'day') {
				$recurring_data['repeatmonth_daytype'] = vtlib_purify($rtsetup['repeatMonth_daytype']);
				$rdm = (isset($rtsetup['repeatMonth_day']) ? $rtsetup['repeatMonth_day'] : '');
				switch ($rdm) {
					case 0 :
						$recurring_data['sun_flag'] = true;
						break;
					case 1 :
						$recurring_data['mon_flag'] = true;
						break;
					case 2 :
						$recurring_data['tue_flag'] = true;
						break;
					case 3 :
						$recurring_data['wed_flag'] = true;
						break;
					case 4 :
						$recurring_data['thu_flag'] = true;
						break;
					case 5 :
						$recurring_data['fri_flag'] = true;
						break;
					case 6 :
						$recurring_data['sat_flag'] = true;
						break;
				}
			}
		}
		if (isset($rtsetup['repeat_frequency']) && $rtsetup['repeat_frequency'] != null)
			$recurring_data['repeat_frequency'] = $rtsetup['repeat_frequency'];

		$recurObj = RecurringType::fromUserRequest($recurring_data);
		return $recurObj;
	}

}
