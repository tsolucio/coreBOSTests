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
use PHPUnit\Framework\TestCase;

class testUserInfoUtil extends TestCase {

	/****
	 * TEST Users
	 ****/
	public $testusers = array(
		'usrtestdmy' => 5,
		'usrtestmdy' => 6,
		'usrtestymd' => 7,
		'usrtesttz' => 10,
		'usrnocreate' => 11,
		'usrtestmcurrency' => 12
	);
	public $profiles = array(
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
		$profiles =  array(
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
			59 => '0',
			60 => '0',
			61 => '0',
			62 => '0',
			63 => '0',
			64 => '0',
			65 => '0',
			66 => '0',
			67 => '0',
			68 => '0',
			69 => '0',
			70 => '0',
			71 => '0',
			72 => '0',
			73 => '0',
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
	public function testgetTabsPermission($profile, $expected, $message) {
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
		$profiles =  array(
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
			52 => '0',
			59 => '0',
			60 => '0',
			61 => '0',
			62 => '0',
			63 => '0',
			64 => '0',
			65 => '0',
			66 => '0',
			67 => '0',
			68 => '0',
			69 => '0',
			70 => '0',
			71 => '0',
			72 => '0',
			73 => '0',
		);
		$prof4 = $profiles;
		$prof4[45] = $prof4[52] = '1';
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
	public function testgetAllTabsPermission($profile, $expected, $message) {
		global $current_user;
		$actual = getAllTabsPermission($profile);
		$this->assertEquals($expected, $actual, "testgetAllTabsPermission $message");
	}

	/**
	 * Method testgetDefaultSharingEditAction
	 * @test
	 */
	public function testgetDefaultSharingEditAction() {
		$actual = getDefaultSharingEditAction();
		$expected = array(
			2 => '2',
			6 => '2',
			7 => '2',
			13 => '3',
			20 => '2',
			21 => '2',
			22 => '2',
			23 => '2',
			26 => '2',
			8 => '2',
			14 => '3',
			36 => '3',
			37 => '2',
			38 => '2',
			41 => '3',
			42 => '3',
			43 => '2',
			47 => '0',
			48 => '2',
			49 => '2',
			50 => '2',
			52 => '2',
			55 => '3',
			56 => '3',
			57 => '2',
			18 => '2',
			58 => '3',
			10 => '3',
			60 => '3',
			61 => '3',
			62 => '2',
			63 => '3',
			64 => '3',
			65 => '3',
			66 => '3',
			67 => '3',
			68 => '3',
			69 => '3',
			70 => '2',
			71 => '3',
			72 => '3',
			73 => '2',
		);
		$this->assertEquals($expected, $actual, "DefaultSharingEditAction");
	}

	/**
	 * Method testgetDefaultSharingAction
	 * @test
	 */
	public function testgetDefaultSharingAction() {
		$actual = getDefaultSharingAction();
		$expected = array(
			2 => '2',
			6 => '2',
			7 => '2',
			13 => '3',
			20 => '2',
			21 => '2',
			22 => '2',
			23 => '2',
			26 => '2',
			8 => '2',
			14 => '3',
			36 => '3',
			37 => '2',
			38 => '2',
			41 => '3',
			42 => '3',
			43 => '2',
			47 => '0',
			48 => '2',
			49 => '2',
			50 => '2',
			52 => '2',
			55 => '3',
			56 => '3',
			57 => '2',
			18 => '2',
			58 => '3',
			10 => '3',
			60 => '3',
			61 => '3',
			62 => '2',
			63 => '3',
			64 => '3',
			9 => '3',
			65 => '3',
			66 => '3',
			67 => '3',
			68 => '3',
			69 => '3',
			70 => '2',
			71 => '3',
			72 => '3',
			73 => '2',
		);
		$this->assertEquals($expected, $actual, "DefaultSharingAction");
	}

	/**
	 * Method testgetRoleInformation
	 * @test
	 */
	public function testgetRoleInformation() {
		$actual = getRoleInformation('H1');
		$expected = array('H1' => array('Organisation', 'H1', '0', null));
		$this->assertEquals($expected, $actual);
		$actual = getRoleInformation('H2');
		$expected = array('H2' => array('CEO', 'H1::H2', '1', 'H1'));
		$this->assertEquals($expected, $actual);
		$actual = getRoleInformation('H3');
		$expected = array('H3' => array('Vice President', 'H1::H2::H3', '2', 'H2'));
		$this->assertEquals($expected, $actual);
		$actual = getRoleInformation('H4');
		$expected = array('H4' => array('Sales Manager', 'H1::H2::H3::H4', '3', 'H3'));
		$this->assertEquals($expected, $actual);
		$actual = getRoleInformation('H5');
		$expected = array('H5' => array('Sales Man', 'H1::H2::H3::H4::H5', '4', 'H4'));
		$this->assertEquals($expected, $actual);
		$actual = getRoleInformation('H6');
		$expected = array('H6' => array('NoCreate', 'H1::H2::H3::H6', '3', 'H3'));
		$this->assertEquals($expected, $actual);
	}

	/**
	 * Method testgetRoleAndSubordinatesHierarchy
	 * @test
	 */
	public function testgetRoleAndSubordinatesHierarchy() {
		$actual = getRoleAndSubordinatesHierarchy();
		$expected = array(
			'H1' => array(
				'H2' => array(
					'H3' => array(
						'H4' => array(
							'H5' => array()
						),
						'H6' => array()
					)
				)
			)
		);
		$this->assertSame($expected, $actual);
	}

	/**
	 * Method testgetAllRoleDetails
	 * @test
	 */
	public function testgetAllRoleDetails() {
		$actual = getAllRoleDetails();
		$expected = array(
			'H1' => array('Organisation', '0', 'H2'),
			'H2' => array('CEO', '1', 'H3'),
			'H3' => array('Vice President', '2', 'H4,H6'),
			'H4' => array('Sales Manager', '3', 'H5'),
			'H5' => array('Sales Man', '4', ''),
			'H6' => array('NoCreate', '3', ''),
		);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * Method testgetAllProfileInfo
	 * @test
	 */
	public function testgetAllProfileInfo() {
		$actual = getAllProfileInfo();
		$expected = array(
			1 => 'Administrator',
			2 => 'Sales Profile',
			3 => 'Support Profile',
			4 => 'Guest Profile',
			5 => 'NoCreate',
			6 => 'TestUserDefaultProfile',
		);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * Method testgetRoleUsers
	 * @test
	 */
	public function testgetRoleUsers() {
		$actual = getRoleUsers('H1');
		$expected = array();
		$this->assertEquals($expected, $actual);
		$actual = getRoleUsers('H2');
		$expected = array(1 => ' Administrator');
		$this->assertEquals($expected, $actual);
		$actual = getRoleUsers('H3');
		$expected = array(
			5 => 'cbTest testdmy',
			6 => 'cbTest testmdy',
			7 => 'cbTest testymd',
			8 => 'cbTest testes',
			9 => 'cbTest testinactive',
			10 => 'cbTest testtz',
			12 => 'cbTest testmcurrency',
			13 => 'cbTest testtz-3',
		);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * Method testgetRoleUserIds
	 * @test
	 */
	public function testgetRoleUserIds() {
		$actual = getRoleUserIds('H1');
		$expected = array();
		$this->assertEquals($expected, $actual);
		$actual = getRoleUserIds('H2');
		$expected = array(1);
		$this->assertEquals($expected, $actual);
		$actual = getRoleUserIds('H3');
		$expected = array(5,6,7,8,9,10,12,13,);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * Method getRoleAndSubordinateUsersProvider
	 * params
	 */
	public function getRoleAndSubordinateUsersProvider() {
		$expected_H1_role_users = array(
			1 => 'admin',
			5 => 'testdmy',
			6 => 'testmdy',
			7 => 'testymd',
			8 => 'testes',
			9 => 'testinactive',
			10 => 'testtz',
			12 => 'testmcurrency',
			13 => 'testtz-3',
			11 => 'nocreate',
		);
		$expected_H2_role_users = array(
			1 => 'admin',
			5 => 'testdmy',
			6 => 'testmdy',
			7 => 'testymd',
			8 => 'testes',
			9 => 'testinactive',
			10 => 'testtz',
			12 => 'testmcurrency',
			13 => 'testtz-3',
			11 => 'nocreate',
		);
		$expected_H3_role_users = array(
			5 => 'testdmy',
			6 => 'testmdy',
			7 => 'testymd',
			8 => 'testes',
			9 => 'testinactive',
			10 => 'testtz',
			12 => 'testmcurrency',
			13 => 'testtz-3',
			11 => 'nocreate',
		);
		$expected_H4_role_users = array();
		$expected_H5_role_users = array();
		$expected_H6_role_users = array(
			11 => 'nocreate',
		);
		return array(
			array('H1', $expected_H1_role_users),
			array('H2', $expected_H2_role_users),
			array('H3', $expected_H3_role_users),
			array('H4', $expected_H4_role_users),
			array('H5', $expected_H5_role_users),
			array('H6', $expected_H6_role_users),
		);
	}

	/**
	 * Method testgetRoleAndSubordinateUsers
	 * @test
	 * @dataProvider getRoleAndSubordinateUsersProvider
	 */
	public function testgetRoleAndSubordinateUsers($roleid, $expected) {
		$actual=getRoleAndSubordinateUsers($roleid);
		$this->assertEquals($expected, $actual, "Test getRoleAndSubordinateUsers Method on $roleid roleid");
	}

	/**
	 * Method getRoleAndSubordinateUserIdsProvider
	 * params
	 */
	public function getRoleAndSubordinateUserIdsProvider() {
		$expected_H1_role_users_ids = array(
			0 => "1",
			1 => "5",
			2 => "6",
			3 => "7",
			4 => "8",
			5 => "9",
			6 => "10",
			7 => "12",
			8 => "13",
			9 => "11",
		);
		$expected_H2_role_users_ids = array(
			0 => '1',
			1 => '5',
			2 => '6',
			3 => '7',
			4 => '8',
			5 => '9',
			6 => '10',
			7 => '12',
			8 => '13',
			9 => '11'
		);
		$expected_H3_role_users_ids = array(
			0 => '5',
			1 => '6',
			2 => '7',
			3 => '8',
			4 => '9',
			5 => '10',
			6 => '12',
			7 => '13',
			8 => '11',
		);
		$expected_H4_role_users_ids = array();
		$expected_H5_role_users_ids = array();
		$expected_H6_role_users_ids = array(
			0 => '11',
		);
		return array(
			array('H1', $expected_H1_role_users_ids),
			array('H2', $expected_H2_role_users_ids),
			array('H3', $expected_H3_role_users_ids),
			array('H4', $expected_H4_role_users_ids),
			array('H5', $expected_H5_role_users_ids),
			array('H6', $expected_H6_role_users_ids),
		);
	}

	/**
	 * Method testgetRoleAndSubordinateUserIds
	 * @test
	 * @dataProvider getRoleAndSubordinateUserIdsProvider
	 */
	public function testgetRoleAndSubordinateUserIds($roleid, $expected) {
		$actual=getRoleAndSubordinateUserIds($roleid);
		$this->assertEquals($expected, $actual, "Test getRoleAndSubordinateUserIds Method on $roleid roleid");
	}
}
?>