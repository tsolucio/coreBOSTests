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
require_once 'modules/CustomView/CustomView.php';
use PHPUnit\Framework\TestCase;

class CustomViewTest extends TestCase {

	/**
	 * Method testgetCVStdFilterSQL
	 * @test
	 */
	public function testgetCVStdFilterSQL() {
		global $current_user;
		$cv = new CustomView();
		$actual = $cv->getCVStdFilterSQL(4);
		$expected = '';
		$this->assertEquals($expected, $actual, 'getCVStdFilterSQL Accounts All');
		$actual = $cv->getCVStdFilterSQL(6);
		$thisweek0 = date('Y-m-d', strtotime('-1 week Sunday'));
		$thisweek1 = date('Y-m-d', strtotime('this Saturday'));
		$expected = "vtiger_crmentity.createdtime BETWEEN '".$thisweek0." 00:00:00' and '".$thisweek1." 23:59:00'";
		$this->assertEquals($expected, $actual, 'getCVStdFilterSQL Accounts New This Week');
		$actual = $cv->getCVStdFilterSQL(5);
		$expected = '';
		$this->assertEquals($expected, $actual, 'getCVStdFilterSQL Accounts Prospect Account');
		////////////////
		$actual = $cv->getCVStdFilterSQL(7);
		$expected = '';
		$this->assertEquals($expected, $actual, 'getCVStdFilterSQL Contacts All');
		$actual = $cv->getCVStdFilterSQL(9);
		$d = date('Y-m-d');
		$expected="DATE_FORMAT(vtiger_contactsubdetails.birthday, '%m%d') BETWEEN DATE_FORMAT('".$d." 00:00:00', '%m%d') and DATE_FORMAT('".$d." 23:59:00', '%m%d')";
		$this->assertEquals($expected, $actual, 'getCVStdFilterSQL Contacts Birthday');
	}

	/**
	 * Method testgetAdvFilterByCvid
	 * @test
	 */
	public function testgetAdvFilterByCvid() {
		global $current_user;
		$cv = new CustomView();
		$actual = $cv->getAdvFilterByCvid(11);
		$expected = array(
			1 => array(
				'columns' => array(
					array(
						'columnname' => 'vtiger_potential:sales_stage:sales_stage:Potentials_Sales_Stage:V',
						'comparator' => 'e',
						'value' => 'Closed Won',
						'column_condition' => '',
					),
				),
				'condition' => '',
			),
		);
		$this->assertEquals($expected, $actual, 'getAdvFilterByCvid Potential Won');
		$actual = $cv->getAdvFilterByCvid(17);
		$expected = array(
			1 => array(
				'columns' => array(
					array(
						'columnname' => 'vtiger_quotes:quotestage:quotestage:Quotes_Quote_Stage:V',
						'comparator' => 'n',
						'value' => 'Accepted',
						'column_condition' => 'and',
					),
					array(
						'columnname' => 'vtiger_quotes:quotestage:quotestage:Quotes_Quote_Stage:V',
						'comparator' => 'n',
						'value' => 'Rejected',
						'column_condition' => '',
					),
				),
				'condition' => '',
			),
		);
		$this->assertEquals($expected, $actual, 'getAdvFilterByCvid Quotes Stage');
		$actual = $cv->getAdvFilterByCvid(45);
		$expected = array(
			1 => array(
				'columns' => array(
					array(
						'columnname' => 'vtiger_cbupdater:execstate:execstate:cbupdater_execstate:V',
						'comparator' => 'e',
						'value' => 'Executed',
						'column_condition' => '',
					),
				),
				'condition' => '',
			),
		);
		$this->assertEquals($expected, $actual, 'getAdvFilterByCvid cbupdater execstate');
	}
}
