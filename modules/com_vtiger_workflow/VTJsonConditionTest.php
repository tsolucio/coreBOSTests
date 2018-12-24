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

class VTJsonConditionTest extends TestCase {

	/**
	 * Method testRelatedEmptyConditions
	 * @test
	 */
	public function testRelatedEmptyConditions() {
		$adminUser = Users::getActiveAdminUser();
		$entityCache = new VTEntityCache($adminUser);
		$entityId = '13x5140'; // potential related to contact
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$cs = new VTJsonCondition();
		/////////////////////////
		$testexpression = '[{"fieldname":"related_to : (Accounts) accountname","operation":"is empty","value":"","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertTrue($actual);
		$testexpression = '[{"fieldname":"related_to : (Contacts) lastname","operation":"is empty","value":"","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertFalse($actual);
		/////////////////////////
		$testexpression = '[{"fieldname":"related_to : (Accounts) accountname","operation":"is","value":"","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertTrue($actual);
		$testexpression = '[{"fieldname":"related_to : (Accounts) accountname","operation":"is","value":"M D & W Railway","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertFalse($actual);
		$testexpression = '[{"fieldname":"related_to : (Accounts) accountname","operation":"is","value":"FALSEM D & W Railway","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertFalse($actual);
		$testexpression = '[{"fieldname":"related_to : (Contacts) lastname","operation":"is","value":"","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertFalse($actual);
		$testexpression = '[{"fieldname":"related_to : (Contacts) lastname","operation":"is","value":"Conquest","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertTrue($actual);
		$testexpression = '[{"fieldname":"related_to : (Contacts) lastname","operation":"is","value":"FALSEConquest","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertFalse($actual);
		/////////////////////////
		$testexpression = '[{"fieldname":"related_to : (Accounts) accountname","operation":"is not empty","value":"","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertFalse($actual);
		$testexpression = '[{"fieldname":"related_to : (Contacts) lastname","operation":"is not empty","value":"","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertTrue($actual);
		/////////////////////////
		/////////////////////////
		$entityId = '13x5141'; // potential related to account
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$cs = new VTJsonCondition();
		/////////////////////////
		$testexpression = '[{"fieldname":"related_to : (Accounts) accountname","operation":"is empty","value":"","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertFalse($actual);
		$testexpression = '[{"fieldname":"related_to : (Contacts) lastname","operation":"is empty","value":"","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertTrue($actual);
		/////////////////////////
		$testexpression = '[{"fieldname":"related_to : (Accounts) accountname","operation":"is","value":"","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertFalse($actual);
		$testexpression = '[{"fieldname":"related_to : (Accounts) accountname","operation":"is","value":"M D & W Railway","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertTrue($actual);
		$testexpression = '[{"fieldname":"related_to : (Accounts) accountname","operation":"is","value":"FALSEM D & W Railway","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertFalse($actual);
		$testexpression = '[{"fieldname":"related_to : (Contacts) lastname","operation":"is","value":"","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertTrue($actual);
		$testexpression = '[{"fieldname":"related_to : (Contacts) lastname","operation":"is","value":"Conquest","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertFalse($actual);
		$testexpression = '[{"fieldname":"related_to : (Contacts) lastname","operation":"is","value":"FALSEConquest","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertFalse($actual);
		/////////////////////////
		$testexpression = '[{"fieldname":"related_to : (Accounts) accountname","operation":"is not empty","value":"","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertTrue($actual);
		$testexpression = '[{"fieldname":"related_to : (Contacts) lastname","operation":"is not empty","value":"","valuetype":"rawtext","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertFalse($actual);
		/////////////////////////
		/////////////////////////
		$entityId = '7x3907'; // Invoice related to SO
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$cs = new VTJsonCondition();
		$testexpression = '[{"fieldname":"salesorder_id : (SalesOrder) pl_grand_total","operation":"greater than or equal to","value":"$(salesorder_id : (SalesOrder) pl_net_total) ","valuetype":"fieldname","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertTrue($actual);
		$cs = new VTJsonCondition();
		$testexpression = '[{"fieldname":"salesorder_id : (SalesOrder) recurring_frequency","operation":"is not","value":"$(salesorder_id : (SalesOrder) sostatus) ","valuetype":"fieldname","joincondition":"and","groupid":"0"}]';
		$actual = $cs->evaluate($testexpression, $entityCache, $entityId);
		$this->assertTrue($actual);
	}

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
