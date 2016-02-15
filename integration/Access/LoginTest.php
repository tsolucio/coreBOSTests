<?php
/*************************************************************************************************
 * Copyright 2016 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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
require_once 'build/coreBOSTests/integration/cbIntegrationTest.php';

class LoginTest extends cbIntegrationTest
{

	/** 
	 * Method testAdminUser
	 * @test
	 */
	public function testAdminUser()
	{
		$this->url("/index.php");
		$this->byName("user_name")->value("admin");
		$this->byName("user_password")->value("admin");
		$this->byId("submitButton")->click();
		$this->waitForcoreBOSFooter();
		try {
			$result = $this->title();
			$this->assertEquals("Administrator - Home - coreBOS", $result);
		} catch (PHPUnit_Framework_AssertionFailedError $e) {
			array_push($this->verificationErrors, $e->__toString());
		}
		try {
			$element = $this->byId('settingslink');
			$this->assertTrue($element);
			$this->byCssSelector("img[alt=\"Sign Out\"]")->click();
		} catch (PHPUnit_Framework_AssertionFailedError $e) {
			array_push($this->verificationErrors, $e->__toString());
		}
	}

	/** 
	 * Method testNonAdminUser
	 * @test
	 */
	public function testNonAdminUser()
	{
		$this->url("/index.php");
		$this->byName("user_name")->value("testdmy");
		$this->byName("user_password")->value("testdmy");
		$this->byId("submitButton")->click();
		$this->waitForcoreBOSFooter();
		try {
			$result = $this->title();
			$this->assertEquals("cbTest testdmy - Home - coreBOS", $result);
		} catch (PHPUnit_Framework_AssertionFailedError $e) {
			array_push($this->verificationErrors, $e->__toString());
		}
		try {
			try {
				$element = $this->byId('settingslink');
			} catch (PHPUnit_Extensions_Selenium2TestCase_WebDriverException $e) {
				$this->assertEquals(PHPUnit_Extensions_Selenium2TestCase_WebDriverException::NoSuchElement, $e->getCode());
				$this->byCssSelector("img[alt=\"Sign Out\"]")->click();
				return;
			}
			$this->fail('Settings Access shouldn\'t exist.');
			$this->byCssSelector("img[alt=\"Sign Out\"]")->click();
		} catch (PHPUnit_Framework_AssertionFailedError $e) {
			array_push($this->verificationErrors, $e->__toString());
		}
	}

	/**
	 * Method testInactiveNoLogin
	 * @test
	 */
	public function testInactiveNoLogin()
	{
		$this->url("/index.php");
		$this->byName("user_name")->value("testinactive");
		$this->byName("user_password")->value("testinactive");
		 $this->byId("submitButton")->click();
		try {
			$result = $this->byCssSelector("div.errorMessage")->text();
		$this->assertEquals("You must specify a valid username and password.", $result);
		} catch (PHPUnit_Framework_AssertionFailedError $e) {
			array_push($this->verificationErrors, $e->__toString());
		}
		try {
			$result = $this->title();
		$this->assertEquals("coreBOS", $result);
		} catch (PHPUnit_Framework_AssertionFailedError $e) {
			array_push($this->verificationErrors, $e->__toString());
		}
	}

}
