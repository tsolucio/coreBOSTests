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

class VtigerModuleOperationTest extends TestCase {

	/**
	 * Method testInstantiateAndCache
	 * @test
	 */
	public function testInstantiateAndCache() {
		global $adb, $log, $current_user;
		// we empty the cache before starting
		$webserviceObject = VtigerWebserviceObject::fromName($adb, 'HelpDesk');
		$handlerPath = $webserviceObject->getHandlerPath();
		require_once $handlerPath;
		$handler = new VtigerModuleOperation($webserviceObject, $current_user, $adb, $log);
		$handler->emptyCache();
		// now we start
		$webserviceObject = VtigerWebserviceObject::fromName($adb, 'HelpDesk');
		$handlerPath = $webserviceObject->getHandlerPath();
		require_once $handlerPath;
		$handler = new VtigerModuleOperation($webserviceObject, $current_user, $adb, $log);
		$startCache = $handler->getCache();
		$this->assertInstanceOf(VtigerModuleOperation::class, $handler, 'testConstruct class VtigerModuleOperation');
		$this->assertEquals(13, $handler->getTabId());
		$this->assertInstanceOf(VtigerCRMObjectMeta::class, $handler->getMeta(), 'testConstruct class VtigerModuleOperation META');
		$helpdeskMeta = $handler->getMeta();
		$expected = array('HelpDesk' => array($current_user->id => $helpdeskMeta));
		$this->assertEquals($expected, $startCache);
		$webserviceObject = VtigerWebserviceObject::fromName($adb, 'Assets');
		$handlerPath = $webserviceObject->getHandlerPath();
		require_once $handlerPath;
		$handler = new VtigerModuleOperation($webserviceObject, $current_user, $adb, $log);
		$assetCache = $handler->getCache();
		$this->assertEquals(43, $handler->getTabId());
		$expected['Assets'] = array($current_user->id => $handler->getMeta());
		$this->assertEquals($expected, $assetCache);
		$assetCache = $handler->getCache('Assets');
		$this->assertEquals($handler->getMeta(), $assetCache);
		$assetCache = $handler->emptyCache('Assets');
		$actualCache = $handler->getCache();
		$this->assertEquals($startCache, $actualCache);
		$actualCache = $handler->getCache('HelpDesk');
		$this->assertEquals($startCache['HelpDesk'][$current_user->id], $actualCache);
		$handler->emptyCache();
		$actualCache = $handler->getCache();
		$this->assertEquals(array(), $actualCache);
	}
}
?>
