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
class cbIntegrationTest extends PHPUnit_Extensions_Selenium2TestCase
{
	public static $browsers = array(
		array(
			'name' => 'Firefox',
			'browserName' => 'firefox',
			'host' => 'localhost',
			'port' => 4444,
			'timeout' => 30000,
			'sessionStrategy' => 'isolated'
		),
		array(
			'name' => 'Chrome',
			'browserName' => 'chrome',
			'host' => 'localhost',
			'port' => 4444,
			'timeout' => 30000,
			'sessionStrategy' => 'isolated'
		),
		//array('browserName' => 'internet explorer'),
	);

	/**
	 * Setup
	 */
	public function setUp() {
		// $this->setBrowser('chrome');
		// $this->setHost('127.0.0.1');
		// $this->setPort(4444);
		$this->setBrowserUrl('http://localhost/coreBOSTest');
	}

	public function waitForcoreBOSFooter($seconds=8) {
		for ($second = 0;$second < $seconds; $second++) {
			try {
				if (substr($this->byCssSelector("td.small > span")->text(),0,18)=="Powered by coreBOS") break;
			} catch (Exception $e) {}
			sleep(1);
		}
	}
}
