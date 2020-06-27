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

class GlobalVariableTest extends TestCase {

	/**
	 * Method testgetVariable
	 * @test
	 */
	public function testgetVariable() {
		global $current_user, $installationStrings, $adb;
		$actual = GlobalVariable::getVariable('does not matter at all', 'we always get this');
		$this->assertEquals('we always get this', $actual, 'GV::getVariable undefined variable');
		$holdCU = $current_user->id;
		$current_user->id = 0;
		$actual = GlobalVariable::getVariable('Debug_ListView_Query', 'we always get this');
		$current_user->id = $holdCU;
		$this->assertEquals('we always get this', $actual, 'GV::getVariable no user context');
		$actual = GlobalVariable::getVariable('Application_Permit_Assign_Up', 'defval');
		$this->assertEquals('defval', $actual, 'GV::getVariable not found > default');
		$actual = GlobalVariable::getVariable('Debug_ListView_Query', 'defval', 'Assets', 1);
		$this->assertEquals('0', $actual, 'GV::getVariable exists');
		$key = 'gvcacheDebug_ListView_QueryAssets1';
		VTCacheUtils::emptyCachedInformation($key);
		$adb->query("update vtiger_globalvariable set value='[[Use Description]]' where globalvariableid=34018");
		$adb->query("update vtiger_crmentity set description='Using Description!' where crmid=34018");
		$actual = GlobalVariable::getVariable('Debug_ListView_Query', 'defval', 'Assets', 1);
		$this->assertEquals('Using Description!', $actual, 'GV::getVariable [[Use Description]]');
		$adb->query("update vtiger_globalvariable set value='0' where globalvariableid=34018");
		$adb->query("update vtiger_crmentity set description='' where crmid=34018");
		$installationStrings = array();
		$actual = GlobalVariable::getVariable('Debug_ListView_Query', 'we always get this');
		unset($installationStrings, $GLOBALS['installationStrings']);
		$this->assertEquals('we always get this', $actual, 'GV::getVariable installationStrings');
	}

	/**
	 * Method testisAppliable
	 * @test
	 */
	public function testisAppliable() {
		global $current_user;
		unset($installationStrings, $GLOBALS['installationStrings']);
		$user = $current_user->id;
		$record = 4196;
		$actual = GlobalVariable::isAppliable('not numeric', 'Accounts', $user);
		$this->assertFalse($actual, 'GV::isAppliable not numeric record');
		$actual = GlobalVariable::isAppliable($record, 'Accounts', 'not numeric');
		$this->assertFalse($actual, 'GV::isAppliable not numeric user');
		$actual = GlobalVariable::isAppliable($record, 'Accounts', $user);
		$this->assertFalse($actual, 'GV::isAppliable var not found');
		$record = 27120;
		$actual = GlobalVariable::isAppliable($record, 'Accounts');
		$this->assertTrue($actual, 'GV::isAppliable > no user');
		$actual = GlobalVariable::isAppliable($record);
		$this->assertTrue($actual, 'GV::isAppliable > no user nor module');
		$actual = GlobalVariable::isAppliable($record, '', $user);
		$this->assertTrue($actual, 'GV::isAppliable > user, no module');
		$actual = GlobalVariable::isAppliable($record, 'Accounts', $user); // default so it applies to all modules
		$this->assertTrue($actual, 'GV::isAppliable default no module list');
		$actual = GlobalVariable::isAppliable($record, 'HelpDesk', $user); // default so it applies to all modules
		$this->assertTrue($actual, 'GV::isAppliable default no module list');
		$record = 34018;
		$actual = GlobalVariable::isAppliable($record, 'Accounts', 11);
		$this->assertFalse($actual, 'GV::isAppliable > no user');
		$actual = GlobalVariable::isAppliable($record, 'Accounts', 1);
		// this one should be true but the GV is incorrectly defined inmodulelist=true but no module selected
		$this->assertFalse($actual, 'GV::isAppliable > no user');
	}
}
