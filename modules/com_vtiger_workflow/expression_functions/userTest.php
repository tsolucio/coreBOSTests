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

class userTest extends TestCase {

	/**
	 * Method testGetUserIDandName
	 * @test
	 */
	public function testGetUserIDandName() {
		global $current_user;
		$hold_user = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(5);
		$current_user = $user;
		$this->assertEquals('19x5', __getCurrentUserID(), 'Current User ID 5');
		$this->assertEquals('testdmy', __getCurrentUserName(array()), 'Current User Name 5');
		$this->assertEquals('cbTest testdmy', __getCurrentUserName(array('full')), 'Current User Name full 5');
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(11);
		$current_user = $user;
		$this->assertEquals('19x11', __getCurrentUserID(), 'Current User ID 11');
		$this->assertEquals('nocreate', __getCurrentUserName(array()), 'Current User Name 11');
		$this->assertEquals('nocreate cbTest', __getCurrentUserName(array('full')), 'Current User Name full 11');
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(1);
		$current_user = $user;
		$this->assertEquals('19x1', __getCurrentUserID(), 'Current User ID 1');
		$this->assertEquals('admin', __getCurrentUserName(array()), 'Current User Name 1');
		$this->assertEquals('Administrator', __getCurrentUserName(array('full')), 'Current User Name full 1');
		$current_user = $hold_user;
	}

	/**
	 * Method ConvertProvider
	 * params
	 */
	public function getCurrentUserFieldProvider() {
		return array(
			array(1, 'email1', 'noreply@tsolucio.com'),
			array(1, 'first_name', ''),
			array(1, 'doesnotexist', ''),
			array(1, '', ''),
			array(1, 'roleid', 'H2'),
			array(1, 'parentrole', 'H1'),
			array(1, 'parentrolename', 'Organisation'),
			array(1, 'rolename', 'CEO'),
			array(5, 'email1', 'noreply@tsolucio.com'),
			array(5, 'first_name', 'cbTest'),
			array(5, 'doesnotexist', ''),
			array(5, '', ''),
			array(5, 'roleid', 'H3'),
			array(5, 'parentrole', 'H2'),
			array(5, 'parentrolename', 'CEO'),
			array(5, 'rolename', 'Vice President'),
			array(11, 'roleid', 'H6'),
			array(11, 'parentrole', 'H3'),
			array(11, 'parentrolename', 'Vice President'),
			array(11, 'rolename', 'NoCreate'),
		);
	}

	/**
	 * Method testGetCurrentUserField
	 * @test
	 * @dataProvider getCurrentUserFieldProvider
	 */
	public function testGetCurrentUserField($userid, $f, $expected) {
		global $current_user;
		$hold_user = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($userid);
		$current_user = $user;
		$this->assertEquals($expected, __getCurrentUserField(array($f)), 'Current User Field');
		$current_user = $hold_user;
	}
}
?>