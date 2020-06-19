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

include_once 'modules/com_vtiger_workflow/tasks/RunWebserviceWorkflowTask.inc';

class RunWebserviceWorkflowTaskTest extends TestCase {

	/**
	 * Method substituteSettingProvider
	 * params
	 */
	public function substituteSettingProvider() {
		$lastLogin = coreBOS_Settings::getSetting('cbodLastLoginTime1', '');
		return array(
			array('http://url.tld/1', 'http://url.tld/1'),
			array('getSetting(cbodLastLoginTime1)', $lastLogin),
			array('thingsinfrontgetSetting(cbodLastLoginTime1)', 'thingsinfront'.$lastLogin),
			array('getSetting(cbodLastLoginTime1)thingsinback', $lastLogin.'thingsinback'),
			array('thingsinfrontgetSetting(cbodLastLoginTime1)thingsinback', 'thingsinfront'.$lastLogin.'thingsinback'),
			array('thi(ng)sinfrontgetSetting(cbodLastLoginTime1)thing(si)nback', 'thi(ng)sinfront'.$lastLogin.'thing(si)nback'),
		);
	}

	/**
	 * Method testsubstituteSetting
	 * @test
	 * @dataProvider substituteSettingProvider
	 */
	public function testsubstituteSetting($url, $expected) {
		$rwftsk = new RunWebserviceWorkflowTask();
		$this->assertEquals($expected, $rwftsk->substituteSetting($url));
	}
}
