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

use PHPUnit\Framework\TestCase;

class PreserveGlobalTest extends TestCase {

	/**
	 * Method testpreserveGlobalOneVariable
	 * @test
	 */
	public function testpreserveGlobalOneVariable() {
		global $current_language;
		$this->assertEquals('en_us', $current_language, 'initial language');
		$data = VTWS_PreserveGlobal::getGlobalData();
		$this->assertEquals(array(), $data, 'initial data array is empty');
		$return = VTWS_PreserveGlobal::preserveGlobal('current_language', 'es_es');
		$this->assertEquals('es_es', $return, 'change language to es_es preserveGlobal');
		$this->assertEquals('es_es', $current_language, 'language is es_es');
		$data = VTWS_PreserveGlobal::getGlobalData();
		$expected = array('current_language' => array(0 => "en_us"));
		$this->assertEquals($expected, $data, 'data array contains initial current language en_us');
		$return = VTWS_PreserveGlobal::restore('current_language');
		$this->assertEquals(null, $return, 'restore has no return value');
		$this->assertEquals('en_us', $current_language, 'current language is en_us again');
		$data = VTWS_PreserveGlobal::getGlobalData();
		$this->assertEquals(array(), $data, 'data array is empty after restore');
		$return = VTWS_PreserveGlobal::getGlobal('current_language');
		$this->assertEquals('en_us', $current_language, 'language is en_us');
		$data = VTWS_PreserveGlobal::getGlobalData();
		$expected = array('current_language' => array(0 => "en_us"));
		$this->assertEquals($expected, $data, 'data array contains initial current language en_us');
		$return = VTWS_PreserveGlobal::flush();
		$this->assertEquals(null, $return, 'flush has no return value');
		$data = VTWS_PreserveGlobal::getGlobalData();
		$this->assertEquals(array(), $data, 'data array is empty after flush');
		$this->assertEquals('en_us', $current_language, 'language is still en_us after flush');
	}

	/**
	 * Method testpreserveGlobalTwoVariables
	 * @test
	 */
	public function testpreserveGlobalTwoVariables() {
		global $current_language, $coreBOS_app_name;
		$this->assertEquals('en_us', $current_language, 'initial language');
		$this->assertEquals('coreBOS', $coreBOS_app_name, 'coreBOS_app_name');
		$data = VTWS_PreserveGlobal::getGlobalData();
		$this->assertEquals(array(), $data, 'initial data array is empty');
		$return = VTWS_PreserveGlobal::preserveGlobal('current_language', 'es_es');
		$this->assertEquals('es_es', $return, 'change language to es_es preserveGlobal');
		$this->assertEquals('es_es', $current_language, 'language is es_es');
		$return = VTWS_PreserveGlobal::preserveGlobal('coreBOS_app_name', 'coreBOSTest');
		$this->assertEquals('coreBOSTest', $return, 'change appname to coreBOSTest preserveGlobal');
		$this->assertEquals('coreBOSTest', $coreBOS_app_name, 'appname is coreBOSTest');
		$data = VTWS_PreserveGlobal::getGlobalData();
		$expected = array('current_language' => array(0 => "en_us"),'coreBOS_app_name'=>array(0 => 'coreBOS'));
		$this->assertEquals($expected, $data, 'data array contains initial current language en_us and initial appname coreBOS');
		VTWS_PreserveGlobal::restore('current_language');
		$this->assertEquals('en_us', $current_language, 'current language is en_us again');
		$data = VTWS_PreserveGlobal::getGlobalData();
		$this->assertEquals(array('coreBOS_app_name'=>array(0 => 'coreBOS')), $data, 'data array is appname after restore');
		VTWS_PreserveGlobal::restore('coreBOS_app_name');
		$this->assertEquals('coreBOS', $coreBOS_app_name, 'appname is coreBOS again');
		$data = VTWS_PreserveGlobal::getGlobalData();
		$this->assertEquals(array(), $data, 'data array is empty after restore');
		$return = VTWS_PreserveGlobal::getGlobal('current_language');
		$return = VTWS_PreserveGlobal::getGlobal('coreBOS_app_name');
		$data = VTWS_PreserveGlobal::getGlobalData();
		$expected = array('current_language' => array(0 => "en_us"),'coreBOS_app_name'=>array(0 => 'coreBOS'));
		$this->assertEquals($expected, $data, 'data array contains initial current language en_us and initial appname coreBOS');
		VTWS_PreserveGlobal::flush();
		$data = VTWS_PreserveGlobal::getGlobalData();
		$this->assertEquals(array(), $data, 'data array is empty after flush');
		$this->assertEquals('en_us', $current_language, 'language is still en_us after flush');
		$this->assertEquals('coreBOS', $coreBOS_app_name, 'appname is still coreBOS after flush');
	}

	/**
	 * Method testpreserveNullVariable
	 * @test
	 */
	public function testpreserveNullVariable() {
		global $currentModule;
		$holdCM = $currentModule;
		$currentModule = null;
		$this->assertEquals(null, $currentModule, 'initial current module is empty');
		$data = VTWS_PreserveGlobal::getGlobalData();
		$this->assertEquals(array(), $data, 'initial data array is empty');
		$return = VTWS_PreserveGlobal::preserveGlobal('currentModule', 'Accounts');
		$this->assertEquals('Accounts', $return, 'change currentModule to Accounts');
		$this->assertEquals('Accounts', $currentModule, 'currentModule is Accounts');
		$data = VTWS_PreserveGlobal::getGlobalData();
		$this->assertEquals(array(), $data, 'data array is emtpy: no null values saved'); // array('currentModule' => array(0 => null));
		$return = VTWS_PreserveGlobal::restore('currentModule');
		$this->assertEquals('Accounts', $currentModule, 'current module stays assigned with last value'); // not sure this is correct but the application expects this
		$data = VTWS_PreserveGlobal::getGlobalData();
		$this->assertEquals(array(), $data, 'data array is empty after restore');
		$currentModule = $holdCM;
	}
}
