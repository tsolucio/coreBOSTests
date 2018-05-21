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

/**
 * NOTE: This class is really a wrapper for direct PHP functions so I won't test
 *   construct, init nor destroy
 */
use PHPUnit\Framework\TestCase;
class testSession extends TestCase {

	/**
	 * Method testSessionExists
	 * @test
	 */
	public function testSessionExists() {
		global $site_URL;
		$purl = parse_url($site_URL);
		$expsiteurl = preg_replace('/[^A-Za-z0-9\-]/', '', $purl['host'].$purl['path'].(isset($purl['port'])?$purl['port']:''));
		$this->assertEquals($expsiteurl, session_name(),"testSessionExists");
	}

	/**
	 * Method testSessionCRUD
	 * @test
	 */
	public function testSessionCRUD() {
		$this->assertEquals(false, coreBOS_Session::has('cbtestSessionSavingRetrieving'),"testSessionSavingRetrieving search non existent");
		$this->assertEquals('default value', coreBOS_Session::get('cbtestSessionSavingRetrieving','default value'),"testSessionSavingRetrieving retrieve non existent > get default");
		coreBOS_Session::set('cbtestSessionSavingRetrieving','testing');
		$this->assertEquals('testing', coreBOS_Session::get('cbtestSessionSavingRetrieving','exists'),"testSessionSavingRetrieving retrieve existent");
		$this->assertEquals('testing', $_SESSION['cbtestSessionSavingRetrieving'],"direct retrieve existent");
		coreBOS_Session::set('cbtestSessionSavingRetrieving','testingupdate');
		$this->assertEquals('testingupdate', coreBOS_Session::get('cbtestSessionSavingRetrieving','exists'),"testSessionSavingRetrieving retrieve existent update");
		coreBOS_Session::delete('cbtestSessionSavingRetrieving');
		$this->assertEquals(false, coreBOS_Session::has('cbtestSessionSavingRetrieving'),"testSessionSavingRetrieving search non existent after delete");
		$_SESSION['directset1'] = 'directset1';
		$this->assertEquals('directset1', coreBOS_Session::get('directset1','exists'),"directset1 retrieve existent");
	}

	/**
	 * Method testSessionCRUDArray
	 * @test
	 */
// 	public function testSessionCRUDArray() {
// 		$this->assertEquals(false, coreBOS_Session::has('cbtest1^cbtest2'),"testSessionCRUDArray search non existent");
// 		$this->assertEquals('default value', coreBOS_Session::get('cbtest1^cbtest2','default value'),"testSessionCRUDArray retrieve non existent > get default");
// 		coreBOS_Session::set('cbtest1^cbtest2','testing');
// 		$this->assertEquals('testing', coreBOS_Session::get('cbtest1^cbtest2','exists'),"testSessionCRUDArray retrieve existent");
// 		coreBOS_Session::set('cbtest1^cbtest2','testingupdate');
// 		$this->assertEquals('testingupdate', coreBOS_Session::get('cbtest1^cbtest2','exists'),"testSessionCRUDArray retrieve existent update");
// 		coreBOS_Session::delete('cbtest1^cbtest2');
// 		$this->assertEquals(false, coreBOS_Session::has('cbtest1^cbtest2'),"testSessionCRUDArray search non existent after delete");
// 		$this->assertEquals(true, coreBOS_Session::has('cbtest1'),"testSessionCRUDArray search non existent after delete");
// 		coreBOS_Session::set('cbtest1^cbtest2','testing');
// 		coreBOS_Session::set('cbtest1^cbtest3','testing3');
// 		$this->assertEquals('testing3', coreBOS_Session::get('cbtest1^cbtest3','exists'),"testSessionCRUDArray retrieve existent update");
// 		$this->assertEquals('testing3', $_SESSION['cbtest1']['cbtest3'],"array 3 direct retrieve existent");
// 		coreBOS_Session::set('cbtest1^cbtest3^cbtest4','testing4');
// 		$this->assertEquals('testing4', coreBOS_Session::get('cbtest1^cbtest3^cbtest4','exists'),"testSessionCRUDArray retrieve existent update");
// 		$this->assertEquals('testing4', $_SESSION['cbtest1']['cbtest3']['cbtest4'],"array 4 direct retrieve existent");
// 		$this->assertEquals(true, coreBOS_Session::has('cbtest1'),"testSessionCRUDArray search non existent after delete");
// 		$this->assertEquals(true, coreBOS_Session::has('cbtest1^cbtest3'),"testSessionCRUDArray search non existent after delete");
// 		$this->assertEquals(true, coreBOS_Session::has('cbtest1^cbtest3^cbtest4'),"testSessionCRUDArray search non existent after delete");
// 		coreBOS_Session::delete('cbtest1^cbtest3');
// 		$this->assertEquals(true, coreBOS_Session::has('cbtest1'),"testSessionCRUDArray search non existent after delete");
// 		$this->assertEquals(true, coreBOS_Session::has('cbtest1^cbtest2'),"testSessionCRUDArray search non existent after delete");
// 		$this->assertEquals(false, coreBOS_Session::has('cbtest1^cbtest3'),"testSessionCRUDArray search non existent after delete");
// 		$this->assertEquals(false, coreBOS_Session::has('cbtest1^cbtest3^cbtest4'),"testSessionCRUDArray search non existent after delete");
// 		$_SESSION['directset1']['directset2'] = 'directset2';
// 		$this->assertEquals('directset2', coreBOS_Session::get('directset1^directset2','exists'),"directset1 retrieve existent");
// 		coreBOS_Session::delete('directset1');
// 	}

	/**
	 * Method testDeleteStartsWith
	 * @test
	 */
// 	public function testDeleteStartsWith() {
// 		$sessionAtStart = $_SESSION;
// 		coreBOS_Session::set('ispt:cbtest1','testing');
// 		coreBOS_Session::set('ispt:cbtest2','testing');
// 		$expected = $sessionAtStart;
// 		$expected['ispt:cbtest1'] = 'testing';
// 		$expected['ispt:cbtest2'] = 'testing';
// 		$this->assertEquals($expected, $_SESSION, "testDeleteStartsWith initial");
// 		coreBOS_Session::deleteStartsWith('ispt:cbtest');
// 		$this->assertEquals($sessionAtStart, $_SESSION, "testDeleteStartsWith deleted");
// 	}

	/**
	 * Method testSessionMerge
	 * @test
	 */
// 	public function testSessionMerge() {
// 		$sessionAtStart = $_SESSION;
// 		coreBOS_Session::set('cbtest1^cbtest1','testing');
// 		coreBOS_Session::set('cbtest1^cbtest2','testingupdate');
// 		coreBOS_Session::set('cbtest1^cbtest3^cbtest4','testing4');
// 		coreBOS_Session::set('cbtest2^cbtest2','testing');
// 		coreBOS_Session::set('cbtest3','testing3');
// 		$expectedstart = array(
// 			'cbtest1' => array(
// 				'cbtest1' => 'testing',
// 				'cbtest2' => 'testingupdate',
// 				'cbtest3' => array(
// 					'cbtest4' => 'testing4',
// 				),
// 			),
// 			'cbtest2' => array(
// 				'cbtest2' => 'testing',
// 			),
// 			'cbtest3' => 'testing3',
// 		);
// 		$expectedstart = array_merge($sessionAtStart, $expectedstart);
// 		$this->assertEquals($expectedstart, $_SESSION, "testSessionMerge setting");
// 		$values = array(
// 			'cbtest1' => 'no array',
// 			'cbtest2' => 'na 2',
// 		);
// 		coreBOS_Session::merge($values,true);
// 		$expected = array(
// 			'cbtest1' => 'no array',
// 			'cbtest2' => 'na 2',
// 			'cbtest3' => 'testing3',
// 		);
// 		$expected = array_merge($sessionAtStart, $expected);
// 		$this->assertEquals($expected, $_SESSION,"testSessionMerge overwrite");
// 		$sn = coreBOS_Session::getSessionName();
// 		session_name($sn);
// 		@session_start();
// 		$_SESSION = $expectedstart;
// 		$values = array(
// 			'cbtest1' => 'no array',
// 			'cbtest2' => 'na 2',
// 			'cbtest4' => 'addedvalue',
// 		);
// 		coreBOS_Session::merge($values,false);
// 		$expected = $expectedstart;
// 		$expected['cbtest4'] = 'addedvalue';
// 		$this->assertEquals($expected, $_SESSION,"testSessionMerge add only");
// 	}

	/**
	 * Method getSessionNameProvider
	 * params
	 */
	public function getSessionNameProvider() {
		global $site_URL;
		$purl = parse_url($site_URL);
		$expsiteurl = preg_replace('/[^A-Za-z0-9\-]/', '', $purl['host'].$purl['path'].(isset($purl['port'])?$purl['port']:''));
		return array(
			array('Normal string','Normalstring','normal string'),
			array('Numbers 012-345,678.9','Numbers0123456789','Numbers 012-345,678.9'),
			array('012-345,678.9','cb0123456789','Only Numbers 012-345,678.9'),
			array('192.168.0.2:8080','cb192168028080','IP Address'),
			array('Special character string áçèñtös ÑÇ','Specialcharacterstringts','Special character string with áçèñtös'),
			array('!"·$%&/();,:.=?¿*_-|@#€','','special string with only symbols'),
			array('',$expsiteurl,'empty string'),
		);
	}

	/**
	 * Method testgetSessionName
	 * @test
	 * @dataProvider getSessionNameProvider
	 */
	public function testgetSessionName($input,$expected,$message) {
		$actual = coreBOS_Session::getSessionName($input,true);
		$this->assertEquals($expected, $actual,"testgetSessionName Normal $message");
		coreBOS_Session::setSessionName('override');
		$actual = coreBOS_Session::getSessionName($input);
		$this->assertEquals('override', $actual,"testgetSessionName Override $message");
	}

	/**
	 * Method testgetSessionNameCache
	 * @test
	 */
	public function testgetSessionNameCache() {
		$actual = coreBOS_Session::getSessionName();
		$expected = coreBOS_Session::getSessionName('anything');
		$this->assertEquals($expected, $actual,"getSessionNameCache");
	}

}
