<?php
/*************************************************************************************************
 * Copyright 2022 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

class VtigerWebserviceObjectTest extends TestCase {

	/**
	 * Method testvtws_getModuleHandlerFromUsers
	 * @test
	 */
	public function testvtws_getModuleHandlerFromUsers() {
		global $adb;
		$webserviceObject = VtigerWebserviceObject::fromName($adb, 'Accounts');
		$this->assertEquals('VtigerWebserviceObject', get_class($webserviceObject), 'Class instantiated correctly');
		$this->assertEquals('Accounts', $webserviceObject->getEntityName(), 'module name');
		$this->assertEquals('11', $webserviceObject->getEntityId(), 'module ID');
		$this->assertEquals('include/Webservices/VtigerModuleOperation.php', $webserviceObject->getHandlerPath(), 'path name');
		$this->assertEquals('VtigerModuleOperation', $webserviceObject->getHandlerClass(), 'class name');
		$webserviceObject = VtigerWebserviceObject::fromName($adb, 'Users');
		$this->assertEquals('VtigerWebserviceObject', get_class($webserviceObject), 'Class instantiated correctly');
		$this->assertEquals('Users', $webserviceObject->getEntityName(), 'module name');
		$this->assertEquals('19', $webserviceObject->getEntityId(), 'module ID');
		$this->assertEquals('include/Webservices/VtigerModuleOperation.php', $webserviceObject->getHandlerPath(), 'path name');
		$this->assertEquals('VtigerModuleOperation', $webserviceObject->getHandlerClass(), 'class name');
	}

	/**
	 * Method vtws_getModuleHandlerFromNameProvider
	 * params
	 */
	public function vtws_getModuleHandlerFromNameProvider() {
		$users = [1, 5, 11];
		$modules = ['Accounts', 'Users', 'Assets', 'cbCalendar', 'Documents', 'AuditTrail'];
		$expected = [
			'Accounts' => ['path' => 'include/Webservices/VtigerModuleOperation.php', 'class' => 'VtigerModuleOperation'],
			'Users' => ['path' => 'include/Webservices/VtigerModuleOperation.php', 'class' => 'VtigerModuleOperation'],
			'Assets' => ['path' => 'include/Webservices/VtigerModuleOperation.php', 'class' => 'VtigerModuleOperation'],
			'cbCalendar' => ['path' => 'include/Webservices/VtigerModuleOperation.php', 'class' => 'VtigerModuleOperation'],
			'Documents' => ['path' => 'include/Webservices/VtigerDocumentOperation.php', 'class' => 'VtigerDocumentOperation'],
			'AuditTrail' => ['path' => 'include/Webservices/VtigerActorOperation.php', 'class' => 'VtigerActorOperation'],
		];
		$work = [];
		foreach ($users as $uid) {
			foreach ($modules as $mod) {
				$work[] = [$mod, $uid, $expected[$mod]];
			}
		}
		return $work;
	}

	/**
	 * Method testvtws_getModuleHandlerFromName
	 * @test
	 * @dataProvider vtws_getModuleHandlerFromNameProvider
	 */
	public function testvtws_getModuleHandlerFromName($name, $userid, $expected) {
		global $adb, $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($userid);
		$holdUser = $current_user;
		$current_user = $user;
		$webserviceObject = VtigerWebserviceObject::fromName($adb, $name);
		$this->assertEquals('VtigerWebserviceObject', get_class($webserviceObject), 'Class instantiated correctly');
		$this->assertEquals($name, $webserviceObject->getEntityName(), 'module name');
		$this->assertEquals($expected['path'], $webserviceObject->getHandlerPath(), 'path name');
		$this->assertEquals($expected['class'], $webserviceObject->getHandlerClass(), 'class name');
		$current_user = $holdUser;
	}

	/**
	 * Method vtws_getModuleHandlerFromIdProvider
	 * params
	 */
	public function vtws_getModuleHandlerFromIdProvider() {
		$users = [1, 5, 11];
		$ids = ['11x74', '19x5', '29x4062', '39x15845', '51x1', '15xjunk'];
		$expected = [
			'11x74' => ['path' => 'include/Webservices/VtigerModuleOperation.php', 'class' => 'VtigerModuleOperation'],
			'19x5' => ['path' => 'include/Webservices/VtigerModuleOperation.php', 'class' => 'VtigerModuleOperation'],
			'29x4062' => ['path' => 'include/Webservices/VtigerModuleOperation.php', 'class' => 'VtigerModuleOperation'],
			'39x15845' => ['path' => 'include/Webservices/VtigerModuleOperation.php', 'class' => 'VtigerModuleOperation'],
			'51x1' => ['path' => 'include/Webservices/VtigerActorOperation.php', 'class' => 'VtigerActorOperation'],
			'15xjunk' => ['path' => 'include/Webservices/VtigerDocumentOperation.php', 'class' => 'VtigerDocumentOperation'],
		];
		$work = [];
		foreach ($users as $uid) {
			foreach ($ids as $id) {
				$work[] = [$id, $uid, $expected[$id]];
			}
		}
		return $work;
	}

	/**
	 * Method testvtws_getModuleHandlerFromId
	 * @test
	 * @dataProvider vtws_getModuleHandlerFromIdProvider
	 */
	public function testvtws_getModuleHandlerFromId($entityId, $userid, $expected) {
		global $adb, $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($userid);
		$holdUser = $current_user;
		$current_user = $user;
		$webserviceObject = VtigerWebserviceObject::fromId($adb, $entityId);
		$this->assertEquals('VtigerWebserviceObject', get_class($webserviceObject), 'Class instantiated correctly');
		list($entityId,$void) = explode('x', $entityId);
		$this->assertEquals($entityId, $webserviceObject->getEntityId(), 'module ID');
		$this->assertEquals($expected['path'], $webserviceObject->getHandlerPath(), 'path name');
		$this->assertEquals($expected['class'], $webserviceObject->getHandlerClass(), 'class name');
		$current_user = $holdUser;
	}

	/**
	 * Method testvtws_getModuleHandlerFromQuery
	 * @test
	 */
	public function testvtws_getModuleHandlerFromQuery() {
		global $adb;
		$webserviceObject = VtigerWebserviceObject::fromQuery($adb, 'select * from Accounts;');
		$this->assertEquals('VtigerWebserviceObject', get_class($webserviceObject), 'Class instantiated correctly');
		$this->assertEquals('Accounts', $webserviceObject->getEntityName(), 'module name');
		$this->assertEquals('11', $webserviceObject->getEntityId(), 'module ID');
		$this->assertEquals('include/Webservices/VtigerModuleOperation.php', $webserviceObject->getHandlerPath(), 'path name');
		$this->assertEquals('VtigerModuleOperation', $webserviceObject->getHandlerClass(), 'class name');
		$webserviceObject = VtigerWebserviceObject::fromQuery($adb, 'select * from Documents;');
		$this->assertEquals('VtigerWebserviceObject', get_class($webserviceObject), 'Class instantiated correctly');
		$this->assertEquals('Documents', $webserviceObject->getEntityName(), 'module name');
		$this->assertEquals('15', $webserviceObject->getEntityId(), 'module ID');
		$this->assertEquals('include/Webservices/VtigerDocumentOperation.php', $webserviceObject->getHandlerPath(), 'path name');
		$this->assertEquals('VtigerDocumentOperation', $webserviceObject->getHandlerClass(), 'class name');
	}

	/**
	 * Method vtws_getModuleHandlerFromNameExceptionProvider
	 * params
	 */
	public function vtws_getModuleHandlerFromNameExceptionProvider() {
		$users = [1, 5, 11];
		$modules = ['RSS', 'notexist', ''];
		$work = [];
		foreach ($users as $uid) {
			foreach ($modules as $mod) {
				$work[] = [$mod];
			}
		}
		return $work;
	}

	/**
	 * Method testinvalidmoduleexception
	 * @test
	 * @dataProvider vtws_getModuleHandlerFromNameExceptionProvider
	 */
	public function testinvalidmoduleexception($name) {
		global $adb;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		VtigerWebserviceObject::fromName($adb, $name);
	}
}
?>