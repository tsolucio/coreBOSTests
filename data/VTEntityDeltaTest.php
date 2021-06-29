<?php
/*************************************************************************************************
 * Copyright 2021 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

class VTEntityDeltaTest extends TestCase {

	/**
	 * Method testVTEntityDelta
	 * @test
	 */
	public function testVTEntityDelta() {
		global $adb;
		$entityDelta = new VTEntityDelta();
		$this->assertInstanceOf(VTEntityDelta::class, $entityDelta, 'testConstruct class VTEntityDelta');
		$adb->query('update vtiger_account set employees=13, parentid=438 where accountid=74');
		$entityData = VTEntityData::fromEntityId($adb, '74');
		$entityData->set('employees', 13);
		$entityData->set('account_id', 438);
		$entityDelta->handleEvent('vtiger.entity.beforesave', $entityData);
		$adb->query('update vtiger_account set employees=131, parentid=746 where accountid=74');
		$entityData->set('employees', 131);
		$entityData->set('account_id', 746);
		$entityDelta->handleEvent('vtiger.entity.aftersave', $entityData);
		$this->assertEquals(131, $entityDelta->getCurrentValue('Accounts', 74, 'employees'));
		$this->assertEquals(13, $entityDelta->getOldValue('Accounts', 74, 'employees'));
		$this->assertEquals(13, $entityDelta->getOldEntityValue('Accounts', 74, 'employees'));
		$this->assertEquals(
			array(
				'account_id' => array(
					'oldValue' => '438',
					'currentValue' => '746',
				),
				'employees' => array(
					'oldValue' => '13',
					'currentValue' => '131',
				),
			),
			$entityDelta->getEntityDelta('Accounts', 74)
		);
		$oldEntity = $entityDelta->getOldEntity('Accounts', 74);
		$this->assertInstanceOf(VTEntityData::class, $oldEntity);
		$this->assertInstanceOf(Accounts::class, $oldEntity->focus);
		$this->assertEquals(74, $oldEntity->focus->id);
		$this->assertEquals(13, $oldEntity->focus->column_fields['employees']);
		$newEntity = $entityDelta->getNewEntity('Accounts', 74);
		$this->assertInstanceOf(VTEntityData::class, $newEntity);
		$this->assertInstanceOf(Accounts::class, $newEntity->focus);
		$this->assertEquals(74, $newEntity->focus->id);
		$this->assertEquals(131, $newEntity->focus->column_fields['employees']);
		$this->assertTrue($entityDelta->hasChanged('Accounts', 74, 'employees'));
		$this->assertTrue($entityDelta->hasChanged('Accounts', 74, 'employees', '131'));
		$this->assertFalse($entityDelta->hasChanged('Accounts', 74, 'employees', 999));
		$this->assertFalse($entityDelta->hasChanged('Accounts', 74, 'accountname'));
		$this->assertFalse($entityDelta->hasChanged('Accounts', 74, 'accountname', 'somevalue'));
	}

	// test Products with images
}
?>
