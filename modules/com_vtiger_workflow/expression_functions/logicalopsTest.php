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

class workflowfunctionslogicalopsTest extends TestCase {

	/**
	 * Method testisnumfunction
	 * @test
	 */
	public function testisnumfunction() {
		$this->assertTrue(__cb_is_numeric(array(2017)), 'is numeric true');
		$this->assertFalse(__cb_is_numeric(array('kkk')), 'is numeric false');
	}

	/**
	 * Method testisstrfunction
	 * @test
	 */
	public function testisstrfunction() {
		$this->assertFalse(__cb_is_string(array(2017)), 'is string false');
		$this->assertTrue(__cb_is_string(array('kkk')), 'is string true');
	}

	/**
	 * Method testORANDfunctions
	 * @test
	 */
	public function testORANDfunctions() {
		$this->assertTrue(__cb_or(array(true, true)), 'or');
		$this->assertTrue(__cb_or(array(true, false)), 'or');
		$this->assertTrue(__cb_or(array(false, true)), 'or');
		$this->assertFalse(__cb_or(array(false, false)), 'or');
		$this->assertTrue(__cb_or(array(1, 1)), 'or');
		$this->assertTrue(__cb_or(array(1, 0)), 'or');
		$this->assertTrue(__cb_or(array(0, 1)), 'or');
		$this->assertFalse(__cb_or(array(0, 0)), 'or');
		$this->assertTrue(__cb_or(array('a', 'a')), 'or');
		$this->assertTrue(__cb_or(array('a', '')), 'or');
		$this->assertTrue(__cb_or(array('', 'a')), 'or');
		$this->assertFalse(__cb_or(array('', '')), 'or');
		////
		$this->assertTrue(__cb_and(array(true, true)), 'and');
		$this->assertFalse(__cb_and(array(true, false)), 'and');
		$this->assertFalse(__cb_and(array(false, true)), 'and');
		$this->assertFalse(__cb_and(array(false, false)), 'and');
		$this->assertTrue(__cb_and(array(1, 1)), 'and');
		$this->assertFalse(__cb_and(array(1, 0)), 'and');
		$this->assertFalse(__cb_and(array(0, 1)), 'and');
		$this->assertFalse(__cb_and(array(0, 0)), 'and');
		$this->assertTrue(__cb_and(array('a', 'a')), 'and');
		$this->assertFalse(__cb_and(array('a', '')), 'and');
		$this->assertFalse(__cb_and(array('', 'a')), 'and');
		$this->assertFalse(__cb_and(array('', '')), 'and');
	}

	/**
	 * Method testexistsfunction
	 * @test
	 */
	public function testexistsfunction() {
		global $current_user;
		$entityCache = new VTEntityCache($current_user);
		$entityData = $entityCache->forId('11x74');
		$params = array('accountname', 'J A Associates', $entityData);
		$this->assertTrue(__cb_exists($params), 'exists true');
		$params = array('accountname', 'No account with this name', $entityData);
		$this->assertFalse(__cb_exists($params), 'exists false');
	}

	/**
	 * Method testexistsrelatedfunction
	 * @test
	 */
	public function testexistsrelatedfunction() {
		global $current_user;
		$entityCache = new VTEntityCache($current_user);
		$entityData = $entityCache->forId('11x74');
		$params = array('Contacts', 'firstname', 'Lina', $entityData);
		$this->assertTrue(__cb_existsrelated($params), 'exists related true');
		$params = array('Contacts', 'firstname', 'no contact with this name', $entityData);
		$this->assertFalse(__cb_existsrelated($params), 'exists related false');
		$params = array('Assets', 'assetname', 'No asset related', $entityData);
		$this->assertFalse(__cb_existsrelated($params), 'exists related false');
		////////////////
		$params = array('Contacts', 'title', 'VP Supply Chain', $entityData);
		$this->assertTrue(__cb_existsrelated($params), 'exists related VP Supply Chain');
		$params = array('Contacts', 'title', 'VP Supply Chain', '[firstname,e,Lina,or]', $entityData);
		$this->assertTrue(__cb_existsrelated($params), 'exists related VP Supply Chain with firstname true');
		$params = array('Contacts', 'title', 'VP Supply Chain', '[firstname,c,s,or]', $entityData);
		$this->assertFalse(__cb_existsrelated($params), 'exists related VP Supply Chain with firstname false');
	}

	/**
	 * Method testallrelatedarefunction
	 * @test
	 */
	public function testallrelatedarefunction() {
		global $current_user;
		$entityCache = new VTEntityCache($current_user);
		$entityData = $entityCache->forId('11x74');
		$params = array('Contacts', 'title', 'Owner', $entityData);
		$this->assertFalse(__cb_allrelatedare($params), 'all related are false');
		$params = array('Contacts', 'notify_owner', '0', $entityData);
		$this->assertTrue(__cb_allrelatedare($params), 'all related are true');
		$params = array('Assets', 'assetname', 'No asset related', $entityData);
		$this->assertTrue(__cb_allrelatedare($params), 'all related are false');
		////////////////
		$params = array('Contacts', 'title', 'VP Supply Chain', $entityData);
		$this->assertFalse(__cb_allrelatedare($params), 'all related are VP Supply Chain');
		$params = array('Contacts', 'title', 'VP Supply Chain', '[lastname,c,w,or]', $entityData);
		$this->assertTrue(__cb_allrelatedare($params), 'all related are VP Supply Chain with lastname contains w true');
		$params = array('Contacts', 'title', 'VP Supply Chain', '[firstname,c,a,and],[firstname,k,nar,and]', $entityData);
		$this->assertTrue(__cb_allrelatedare($params), 'all related are VP Supply Chain with firstname false');
	}

	/**
	 * Method testrelatedevaluationsfunction
	 * @test
	 */
	public function testrelatedevaluationsfunction() {
		$this->assertTrue(true, 'tested through testexistsrelatedfunction and testallrelatedarefunction');
	}
}
?>