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

class testCommonUtilsgetRAC extends TestCase {

	private $Accountsresults = array(
		'74' => '74',
		'4062' => '142',
		'14729' => '463',
		'4784' => '0',
		'27067' => '0',
		'27152' => '0',
		'2' => '0',
		'14294' => '0',
		'1084' => '74',
		'27177' => '0',
		'26182' => '0',
		'4681' => '0',
		'27119' => '0',
		'2636' => '0',
		'2817' => '123',
		'2816' => '123',
		'2206' => '0',
		'16844' => '0',
		'5138' => '1062',
		'16829' => '0',
		'2616' => '0',
		'5989' => '74',
		'8360' => '460',
		'6860' => '695',
		'13061' => '0',
		'11815' => '123',
		'10569' => '123',
		'9760' => '949',
		'9710' => '0',
		'2216' => '0',
		'29198' => '0',
		'27187' => '0',
		'43029' => '0',
		'43044' => '0',
	);
	private $Contactsresults = array(
		'74' => '0',
		'4062' => '0',
		'14729' => '0',
		'4784' => '0',
		'27067' => '0',
		'27152' => '0',
		'2' => '0',
		'14294' => '0',
		'1084' => '1084',
		'27177' => '0',
		'26182' => '0',
		'4681' => '0',
		'27119' => '0',
		'2636' => '1872',
		'2817' => '1292',
		'2816' => '1292',
		'2206' => '0',
		'16844' => '0',
		'5138' => '0',
		'16829' => '0',
		'2616' => '0',
		'5989' => '0',
		'8360' => '0',
		'6860' => '0',
		'13061' => '1181',
		'11815' => '2013',
		'10569' => '1810',
		'9760' => '0',
		'9710' => '0',
		'2216' => '0',
		'29198' => '1655',
		'27187' => '0',
		'43029' => '0',
		'43044' => '0',
	);

	/**
	 * Method testgetRAC
	 * @test
	 */
	public function testgetRAC() {
		global $adb;
		$recs = $adb->query("SELECT min(vtiger_crmentity.crmid) as id, vtiger_crmentity.setype as setype
			FROM vtiger_crmentity
			INNER JOIN vtiger_tab on vtiger_crmentity.setype = vtiger_tab.name
			where deleted=0 and isentitytype=1 group by setype having setype!='Documents'");
		while ($rec = $adb->fetch_row($recs)) {
			$actual = getRelatedAccountContact($rec['id'], 'Accounts');
			$expected = $this->Accountsresults[$rec['id']];
			$this->assertEquals($expected, $actual, "getRAC Accounts-".$rec['setype'].' '.$rec['id']);
			$actual = getRelatedAccountContact($rec['id'], 'Contacts');
			$expected = $this->Contactsresults[$rec['id']];
			$this->assertEquals($expected, $actual, "getRAC Contacts-".$rec['setype'].' '.$rec['id']);
		}
	}
}
