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
class testSession extends PHPUnit_Framework_TestCase {

	/**
	 * Method testSessionExists
	 * @test
	 */
	public function testSessionExists() {
		global $site_URL;
		$purl = parse_url($site_URL);
		$expsiteurl = preg_replace('/[^A-Za-z0-9\-]/', '', $purl['host'].$purl['path']);
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
		coreBOS_Session::set('cbtestSessionSavingRetrieving','testingupdate');
		$this->assertEquals('testingupdate', coreBOS_Session::get('cbtestSessionSavingRetrieving','exists'),"testSessionSavingRetrieving retrieve existent update");
		coreBOS_Session::delete('cbtestSessionSavingRetrieving');
		$this->assertEquals(false, coreBOS_Session::has('cbtestSessionSavingRetrieving'),"testSessionSavingRetrieving search non existent after delete");
	}

	/**
	 * Method getSessionNameProvider
	 * params
	 */
	public function getSessionNameProvider() {
		global $site_URL;
		$purl = parse_url($site_URL);
		$expsiteurl = preg_replace('/[^A-Za-z0-9\-]/', '', $purl['host'].$purl['path']);
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
		$actual = coreBOS_Session::getSessionName($input);
		$this->assertEquals($expected, $actual,"getSessionNameProvider $message");
	}

}
