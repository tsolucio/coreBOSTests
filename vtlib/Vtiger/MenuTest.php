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

class vtlibMenuTest extends TestCase {

	/**
	 * Method testInitialize
	 * @test
	 */
	public function testInitialize() {
		$actual = Vtiger_Menu::getInstance('Marketing');
		$this->assertInstanceOf(Vtiger_Menu::class, $actual);
		$expected = array(
			'id'       => 2,
			'label'    => 'Marketing',
			'sequence' => 2,
			'visible'  => 0,
			'menuid'       => 5,
			'menulabel'    => 'Marketing',
			'menusequence' => 2,
			'menuvisible'  => 1,
		);
		$this->assertEquals($expected, $actual->allmenuinfo, "Marketing menu");
		$supportpt = Vtiger_Menu::getInstance(4);
		$expected = array(
			'id'       => 4,
			'label'    => 'Support',
			'sequence' => 4,
			'visible'  => 0,
			'menuid'       => 24,
			'menulabel'    => 'Support',
			'menusequence' => 4,
			'menuvisible'  => 1,
		);
		$this->assertEquals($expected, $supportpt->allmenuinfo, "Support menu from parenttab");
		$supportmn = Vtiger_Menu::getInstance(24);
		$expected['id'] = 24;
		$this->assertEquals($expected, $supportmn->allmenuinfo, "Support menu from evvtmenu");
		$actual = Vtiger_Menu::getInstance(-1);
		$this->assertFalse($actual, "inexistent number");
		$actual = Vtiger_Menu::getInstance("inexistent menu");
		$this->assertFalse($actual, "inexistent menu");
	}

	/**
	 * Method testCreateRemove
	 * @test
	 */
	public function testCreateRemove() {
		global $adb;
		$adb->query('DELETE FROM `vtiger_parenttabrel` WHERE `parenttabid`=1 and `tabid`=6');
		$adb->query("DELETE FROM `vtiger_evvtmenu` WHERE `mparent`=1 and `mtype`='module' and mvalue='Accounts'");
		$actual = Vtiger_Menu::getInstance('My Home Page');
		$this->assertInstanceOf(Vtiger_Menu::class, $actual);
		$homeexpected = array(
			'id'       => 1,
			'label'    => 'My Home Page',
			'sequence' => 1,
			'visible'  => 0,
			'menuid'       => 1,
			'menulabel'    => 'My Home Page',
			'menusequence' => 1,
			'menuvisible'  => 1,
		);
		$this->assertEquals($homeexpected, $actual->allmenuinfo, "Home menu");
		$rsmnu = $adb->query('select * from vtiger_parenttabrel where parenttabid=1 order by sequence');
		$this->assertEquals(3, $adb->num_rows($rsmnu));
		$this->assertEquals('3', $adb->query_result($rsmnu, 0, 'tabid'));
		$this->assertEquals('9', $adb->query_result($rsmnu, 1, 'tabid'));
		$this->assertEquals('63', $adb->query_result($rsmnu, 2, 'tabid'));
		$rsmnu = $adb->query('select * from vtiger_evvtmenu where mparent=1 order by mseq');
		$this->assertEquals(3, $adb->num_rows($rsmnu));
		$this->assertEquals('Home', $adb->query_result($rsmnu, 0, 'mvalue'));
		$this->assertEquals('Calendar4You', $adb->query_result($rsmnu, 1, 'mvalue'));
		$this->assertEquals('cbCalendar', $adb->query_result($rsmnu, 2, 'mvalue'));
		$moduleInstance = Vtiger_Module::getInstance('Accounts');
		$actual->addModule($moduleInstance);
		$rsmnu = $adb->query('select * from vtiger_parenttabrel where parenttabid=1 order by sequence');
		$this->assertEquals(4, $adb->num_rows($rsmnu));
		$this->assertEquals('3', $adb->query_result($rsmnu, 0, 'tabid'));
		$this->assertEquals('9', $adb->query_result($rsmnu, 1, 'tabid'));
		$this->assertEquals('63', $adb->query_result($rsmnu, 2, 'tabid'));
		$this->assertEquals('6', $adb->query_result($rsmnu, 3, 'tabid'));
		$rsmnu = $adb->query('select * from vtiger_evvtmenu where mparent=1 order by mseq');
		$this->assertEquals(4, $adb->num_rows($rsmnu));
		$this->assertEquals('Home', $adb->query_result($rsmnu, 0, 'mvalue'));
		$this->assertEquals('Calendar4You', $adb->query_result($rsmnu, 1, 'mvalue'));
		$this->assertEquals('cbCalendar', $adb->query_result($rsmnu, 2, 'mvalue'));
		$this->assertEquals('Accounts', $adb->query_result($rsmnu, 3, 'mvalue'));
		$actual->removeModule($moduleInstance);
		$rsmnu = $adb->query('select * from vtiger_parenttabrel where parenttabid=1 order by sequence');
		$this->assertEquals(3, $adb->num_rows($rsmnu));
		$this->assertEquals('3', $adb->query_result($rsmnu, 0, 'tabid'));
		$this->assertEquals('9', $adb->query_result($rsmnu, 1, 'tabid'));
		$this->assertEquals('63', $adb->query_result($rsmnu, 2, 'tabid'));
		$rsmnu = $adb->query('select * from vtiger_evvtmenu where mparent=1 order by mseq');
		$this->assertEquals(3, $adb->num_rows($rsmnu));
		$this->assertEquals('Home', $adb->query_result($rsmnu, 0, 'mvalue'));
		$this->assertEquals('Calendar4You', $adb->query_result($rsmnu, 1, 'mvalue'));
		$this->assertEquals('cbCalendar', $adb->query_result($rsmnu, 2, 'mvalue'));
	}
}
?>