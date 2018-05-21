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
class VtigerCRMActorMetaTest extends TestCase {

	/**
	 * Method testVtigerCRMActorMeta
	 * @test
	 */
	public function testVtigerCRMActorMeta() {
		global $current_user, $adb, $log;
		$webserviceObject = VtigerWebserviceObject::fromId($adb, '11x75');
		$handlerPath = $webserviceObject->getHandlerPath();
		$handlerClass = $webserviceObject->getHandlerClass();
		require_once $handlerPath;
		$obj = new VtigerCRMActorMeta('vtiger_account', $webserviceObject, $adb, $current_user);
		$this->assertEquals('VtigerCRMActorMeta',  get_class($obj), 'Class instantiated correctly');
		$this->assertEquals('Accounts', $obj->getEntityName(), 'module name');
		$this->assertEquals(11, $obj->getEntityId(), 'module ID');
	}

	/**
	 * Method testexists
	 * @test
	 */
	public function testexists() {
		global $current_user, $adb, $log;
		$webserviceObject = VtigerWebserviceObject::fromId($adb, '11x75');
		$handlerPath = $webserviceObject->getHandlerPath();
		$handlerClass = $webserviceObject->getHandlerClass();
		require_once $handlerPath;
		$obj = new VtigerCRMActorMeta('vtiger_account', $webserviceObject, $adb, $current_user);
		$this->assertTrue($obj->exists(75), 'VtigerCRMObject exists true');
		// this method looks for the record on the main table so other IDs return false
		$this->assertFalse($obj->exists(1175), 'VtigerCRMObject exists not the same module!!'); // Contact
		$this->assertFalse($obj->exists(-75), 'VtigerCRMObject exists false');
	}
}
?>