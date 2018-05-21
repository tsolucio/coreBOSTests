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
class VTEventConditionTest extends TestCase {

	/************
	 * The accepted grammer is:
	 *  comparision | inclause
	 * where
	 *   comparision is: SYMBOL == value
	 *   inclause is: SYMBOL IN listelement
	 *   listelement is: [ value (, value )* ]
	 *   SYMBOL can be: (a fieldname) | moduleName | id
	 ************/

	/**
	 * Method testVTEventCondition
	 * @test
	 */
	public function testVTEventCondition() {
		global $current_user, $adb;
		$setype = 'Accounts';
		$entityData = VTEntityData::fromEntityId($adb, 74); // Chemex test account
		/// Construct
		$condition = new VTEventCondition('');
		$this->assertInstanceOf(VTEventCondition::class,$condition,"testConstruct class VTEventCondition");
		$this->assertNull($condition->expr,' parsed expression is null');
		$this->assertTrue($condition->test($entityData),' no expression is true');
		//// inclause
		$condition = new VTEventCondition("moduleName in ['Contacts', 'Potentials']");
		$expectedexpr = array (
			0 => 'in',
			1 => new VTEventConditionSymbol('moduleName'),
			2 => array (
				0 => 'list',
				1 => 'Contacts',
				2 => 'Potentials',
			),
		);
		$this->assertEquals($expectedexpr,$condition->expr,' parsed expression moduleName in');
		$this->assertFalse($condition->test($entityData),' NOT IN module list');
		$condition = new VTEventCondition("moduleName in ['Contacts', 'Accounts']");
		$this->assertTrue($condition->test($entityData),' IN module list');
		/// comparision
		$condition = new VTEventCondition("moduleName == 'Contacts'");
		$expectedexpr = array (
			0 => '==',
			1 => new VTEventConditionSymbol('moduleName'),
			2 => 'Contacts',
		);
		$this->assertEquals($expectedexpr,$condition->expr,' parsed expression moduleName ==');
		$this->assertFalse($condition->test($entityData),' moduleName == Contacts');
		$condition = new VTEventCondition("moduleName == 'Accounts'");
		$this->assertTrue($condition->test($entityData),' moduleName == Accounts');
		///// others
		$condition = new VTEventCondition("employees == '131'");
		$this->assertTrue($condition->test($entityData)," employees == '131'");
		$condition = new VTEventCondition("employees == '127'");
		$this->assertFalse($condition->test($entityData)," employees == '127'");
		$condition = new VTEventCondition("id == '740'");
		$this->assertFalse($condition->test($entityData)," id == '74'");
		$condition = new VTEventCondition("id == '74'");
		$this->assertTrue($condition->test($entityData)," id == '74'");
		$condition = new VTEventCondition("rating in ['Active','Acquired']");
		$this->assertTrue($condition->test($entityData)," rating in ['Active','Acquired']");
	}

}
?>