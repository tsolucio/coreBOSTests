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

class VTJsonConditionTest extends PHPUnit_Framework_TestCase {

	/**
	 * Method testPicklistConditions
	 * @test
	 */
	public function testPicklistConditions() {
		$adminUser = Users::getActiveAdminUser();
		$entityCache = new VTEntityCache($adminUser);
		$entityId = '11x74'; // planets=cf_732 is multipicklist, plmain=cf_729 are picklists
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$cs = new VTJsonCondition();
		/////////////////////////
		$testexpression = '[{"fieldname":"cf_729","operation":"is","value":"one","valuetype":"rawtext","joincondition":"and","groupid":"0"},{"fieldname":"cf_732","operation":"is","value":"House","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertFalse($actual);
		/////////////////////////
		$testexpression = '[{"fieldname":"cf_729","operation":"is","value":"one","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertTrue($actual);
		/////////////////////////
		$testexpression = '[{"fieldname":"cf_732","operation":"is","value":"House","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertFalse($actual);
		/////////////////////////
		$testexpression = '[{"fieldname":"cf_732","operation":"is","value":"Earth","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertTrue($actual);
		/////////////////////////
		$testexpression = '[{"fieldname":"cf_732","operation":"is not","value":"House","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertTrue($actual);
		/////////////////////////
		$testexpression = '[{"fieldname":"cf_732","operation":"is not","value":"Earth","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertFalse($actual);
		/////////////////////////
	}

}
