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
 * Test the coreBOS Permission system via isPermitted function
 */
class testUserInfoUtil_isPermittedTest extends PHPUnit_Framework_TestCase {

	/****
	 * TEST Users
	 ****/
	var $testusers = array(
		'usrtestdmy' => 5,
		'usrtestmdy' => 6,
		'usrtestymd' => 7,
		'usrtesttz' => 10,
		'usrnocreate' => 11,
		'usrtestmcurrency' => 12
	);
	var $profiles = array(
		'1' => 'Administrator',
		'2' => 'Sales Profile',
		'3' => 'Support Profile',
		'4' => 'Guest Profile',
		'5' => 'NoCreate',
		'6' => 'TestUserDefaultProfile',
	);

	/**
	 * Method getTabsPermissionProvidor
	 * params
	 */
	public function getTabsPermissionProvidor() {
		$return = array();
		$profiles =  Array (
			1 => '0',
			2 => '0',
			4 => '0',
			6 => '0',
			7 => '0',
			8 => '0',
			9 => '0',
			10 => '0',
			13 => '0',
			14 => '0',
			15 => '0',
			18 => '0',
			19 => '0',
			20 => '0',
			21 => '0',
			22 => '0',
			23 => '0',
			24 => '0',
			25 => '0',
			26 => '0',
			27 => '0',
			30 => '0',
			31 => '0',
			32 => '0',
			33 => '0',
			34 => '0',
			35 => '0',
			36 => '0',
			37 => '0',
			38 => '0',
			39 => '0',
			40 => '0',
			41 => '0',
			42 => '0',
			43 => '0',
			44 => '0',
			47 => '0',
			48 => '0',
			49 => '0',
			50 => '0',
			51 => '0',
			53 => '0',
			54 => '0',
			55 => '0',
			56 => '0',
			57 => '0',
			58 => '0',
		);
		$expected = array(
			'1' => $profiles,
			'2' => $profiles,
			'3' => $profiles,
			'4' => $profiles,
			'5' => $profiles,
			'6' => $profiles,
		);
		foreach ($this->profiles as $pid => $pname) {
			$return[] = array($pid,$expected[$pid],$pname);
		}
		return $return;
	}

	/**
	 * Method testgetTabsPermission
	 * @test
	 * @dataProvider getTabsPermissionProvidor
	 */
	public function testgetTabsPermission($profile,$expected,$message) {
		global $current_user;
		$actual = getTabsPermission($profile);
		$this->assertEquals($expected, $actual, "testgetTabsPermission $message");
	}

	/**
	 * Method getAllTabsPermissionProvidor
	 * params
	 */
	public function getAllTabsPermissionProvidor() {
		$return = array();
		$profiles =  Array (
			1 => '0',
			2 => '0',
			4 => '0',
			6 => '0',
			7 => '0',
			8 => '0',
			9 => '0',
			10 => '0',
			13 => '0',
			14 => '0',
			15 => '0',
			18 => '0',
			19 => '0',
			20 => '0',
			21 => '0',
			22 => '0',
			23 => '0',
			24 => '0',
			25 => '0',
			26 => '0',
			27 => '0',
			30 => '0',
			31 => '0',
			32 => '0',
			33 => '0',
			34 => '0',
			35 => '0',
			36 => '0',
			37 => '0',
			38 => '0',
			39 => '0',
			40 => '0',
			41 => '0',
			42 => '0',
			43 => '0',
			44 => '0',
			47 => '0',
			48 => '0',
			49 => '0',
			50 => '0',
			51 => '0',
			53 => '0',
			54 => '0',
			55 => '0',
			56 => '0',
			57 => '0',
			58 => '0',
			3 => '0',
			16 => '0',
			45 => '0',
			46 => '0',
			52 => '0',
		);
		$prof4 = $profiles;
		$prof4[45] = $prof4[46] = $prof4[52] = '1';
		$prof56 = $prof4;
		unset($prof56[3]);
		$expected = array(
			'1' => $profiles,
			'2' => $profiles,
			'3' => $profiles,
			'4' => $prof4,
			'5' => $prof56,
			'6' => $prof56,
		);
		foreach ($this->profiles as $pid => $pname) {
			$return[] = array($pid,$expected[$pid],$pname);
		}
		return $return;
	}

	/**
	 * Method testgetAllTabsPermission
	 * @test
	 * @dataProvider getAllTabsPermissionProvidor
	 */
	public function testgetAllTabsPermission($profile,$expected,$message) {
		global $current_user;
		$actual = getAllTabsPermission($profile);
		$this->assertEquals($expected, $actual, "testgetAllTabsPermission $message");
	}

}
?>