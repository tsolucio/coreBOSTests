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

class UserInfoUtilTest extends TestCase {

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
	 * Method getTabsPermissionProvider
	 * params
	 */
	public function getTabsPermissionProvider() {
		$return = array();
		$profiles =  array(
			1 => '0',
			2 => '0',
			4 => '0',
			6 => '0',
			7 => '0',
			8 => '0',
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
			74 => '0',
			75 => '0',
			76 => '0',
			77 => '0',
			78 => '0',
			79 => '0',
			80 => '0',
			81 => '0',
			82 => '0',
		);
		$profilenocreate = $profiles;
		$profilenocreate['62'] = '1';
		$expected = array(
			'1' => $profiles,
			'2' => $profiles,
			'3' => $profiles,
			'4' => $profiles,
			'5' => $profilenocreate,
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
	 * @dataProvider getTabsPermissionProvider
	 */
	public function testgetTabsPermission($profile, $expected, $message) {
		global $current_user;
		$actual = getTabsPermission($profile);
		$this->assertEquals($expected, $actual, "testgetTabsPermission $message");
	}

	/**
	 * Method getAllTabsPermissionProvider
	 * params
	 */
	public function getAllTabsPermissionProvider() {
		$return = array();
		$profiles =  array(
			1 => '0',
			2 => '0',
			4 => '0',
			6 => '0',
			7 => '0',
			8 => '0',
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
			74 => '0',
			75 => '0',
			76 => '0',
			77 => '0',
			78 => '0',
			79 => '0',
			80 => '0',
			81 => '0',
			82 => '0',
		);
		$prof4 = $profiles;
		$prof4[45] = $prof4[52] = '1';
		$prof56 = $prof4;
		unset($prof56[3]);
		$prof5 = $prof56;
		$prof5[62] = '1';
		$expected = array(
			'1' => $profiles,
			'2' => $profiles,
			'3' => $profiles,
			'4' => $prof4,
			'5' => $prof5,
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
	 * @dataProvider getAllTabsPermissionProvider
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
			74 => '2',
			75 => '2',
			78 => '3',
			79 => '3',
			80 => '2',
			81 => '2',
			82 => '2',
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
			65 => '3',
			66 => '3',
			67 => '3',
			68 => '3',
			69 => '3',
			70 => '2',
			71 => '3',
			72 => '3',
			73 => '2',
			74 => '2',
			75 => '2',
			78 => '3',
			79 => '3',
			80 => '2',
			81 => '2',
			82 => '2',
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
			0 => '1',
			1 => '5',
			2 => '6',
			3 => '7',
			4 => '8',
			5 => '9',
			6 => '10',
			7 => '12',
			8 => '13',
			9 => '11',
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

	/**
	 * Method getCurrentUserGroupListProvider
	 * params
	 */
	public function getCurrentUserGroupListProvider() {
		return array(
			array(1, array()),
			array(11, array(3, 4)),
			array(5, array(4, 3)),
			array(9, array(4, 3)),
		);
	}

	/**
	 * Method testgetCurrentUserGroupList
	 * @test
	 * @dataProvider getCurrentUserGroupListProvider
	 */
	public function testgetCurrentUserGroupList($userid, $expected) {
		global $current_user;
		$hold_user = $current_user;
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($userid);
		$this->assertEquals($expected, getCurrentUserGroupList(), 'testgetCurrentUserGroupList');
		$current_user = $hold_user;
	}

	/**
	 * Method testfetchUserGroupids
	 * @test
	 * @dataProvider getCurrentUserGroupListProvider
	 */
	public function testfetchUserGroupids($userid, $expected) {
		if ($userid==1) {
			$expected = array(3);
		}
		$this->assertEquals(implode(',', $expected), fetchUserGroupids($userid), 'testfetchUserGroupids');
	}

	/**
	 * Method getSubordinateUsersListProvider
	 * params
	 */
	public function getSubordinateUsersListProvider() {
		return array(
			array(1, array()),
			array(11, array()),
			array(5, array(11)),
			array(9, array(11)),
		);
	}

	/**
	 * Method testgetSubordinateUsersList
	 * @test
	 * @dataProvider getSubordinateUsersListProvider
	 */
	public function testgetSubordinateUsersList($userid, $expected) {
		global $current_user;
		$hold_user = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($userid);
		$current_user = $user;
		$actual=getSubordinateUsersList();
		$this->assertEquals($expected, $actual, 'testgetSubordinateUsersList');
		$current_user = $hold_user;
	}

	/**
	 * Method getSecListViewSecurityParameterProvider
	 * params
	 */
	public function getSecListViewSecurityParameterProvider() {
		return array(
			array(1, 'Leads', " and (vtiger_crmentityLeads.smownerid=1 or vtiger_crmentityLeads.smownerid in (select vtiger_user2role.userid
				from vtiger_user2role
				inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid
				where vtiger_role.parentrole like '::%') or vtiger_crmentityLeads.smownerid in (select shareduserid from vtiger_tmp_read_user_sharing_per where userid=1 and tabid=7) or ( vtiger_groupsLeads.groupid in (select vtiger_tmp_read_group_sharing_per.sharedgroupid
				from vtiger_tmp_read_group_sharing_per
				where userid=1 and tabid=7))) "),
			array(1, 'Accounts', " and (vtiger_crmentityAccounts.smownerid=1 or vtiger_crmentityAccounts.smownerid in (select vtiger_user2role.userid
				from vtiger_user2role
				inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid
				where vtiger_role.parentrole like '::%') or vtiger_crmentityAccounts.smownerid in (select shareduserid from vtiger_tmp_read_user_sharing_per where userid=1 and tabid=6) or ( vtiger_groupsAccounts.groupid in (select vtiger_tmp_read_group_sharing_per.sharedgroupid
				from vtiger_tmp_read_group_sharing_per
				where userid=1 and tabid=6))) "),
			array(1, 'Campaigns', " and (vtiger_crmentityCampaigns.smownerid=1 or vtiger_crmentityCampaigns.smownerid in (select vtiger_user2role.userid
				from vtiger_user2role
				inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid
				where vtiger_role.parentrole like '::%') or vtiger_crmentityCampaigns.smownerid in (select shareduserid from vtiger_tmp_read_user_sharing_per where userid=1 and tabid=26) or ( vtiger_groupsCampaigns.groupid in (select vtiger_tmp_read_group_sharing_per.sharedgroupid
				from vtiger_tmp_read_group_sharing_per
				where userid=1 and tabid=26))) "),
			array(1, 'Assets', " and (vtiger_crmentityAssets.smownerid=1 or vtiger_crmentityAssets.smownerid in (select vtiger_user2role.userid
				from vtiger_user2role
				inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid
				where vtiger_role.parentrole like '::%') or vtiger_crmentityAssets.smownerid in (select shareduserid from vtiger_tmp_read_user_sharing_per where userid=1 and tabid=43) or ( vtiger_groupsAssets.groupid in (select vtiger_tmp_read_group_sharing_per.sharedgroupid
				from vtiger_tmp_read_group_sharing_per
				where userid=1 and tabid=43))) "),
			array(11, 'Leads', " and (vtiger_crmentityLeads.smownerid=11 or vtiger_crmentityLeads.smownerid in (select vtiger_user2role.userid
				from vtiger_user2role
				inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid
				where vtiger_role.parentrole like 'H1::H2::H3::H6::%') or vtiger_crmentityLeads.smownerid in (select shareduserid from vtiger_tmp_read_user_sharing_per where userid=11 and tabid=7) or ( vtiger_groupsLeads.groupid in (3,4) or  vtiger_groupsLeads.groupid in (select vtiger_tmp_read_group_sharing_per.sharedgroupid
				from vtiger_tmp_read_group_sharing_per
				where userid=11 and tabid=7))) "),
			array(11, 'Accounts', " and (vtiger_crmentityAccounts.smownerid=11 or vtiger_crmentityAccounts.smownerid in (select vtiger_user2role.userid
				from vtiger_user2role
				inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid
				where vtiger_role.parentrole like 'H1::H2::H3::H6::%') or vtiger_crmentityAccounts.smownerid in (select shareduserid from vtiger_tmp_read_user_sharing_per where userid=11 and tabid=6) or ( vtiger_groupsAccounts.groupid in (3,4) or  vtiger_groupsAccounts.groupid in (select vtiger_tmp_read_group_sharing_per.sharedgroupid
				from vtiger_tmp_read_group_sharing_per
				where userid=11 and tabid=6))) "),
			array(11, 'Campaigns', " and (vtiger_crmentityCampaigns.smownerid=11 or vtiger_crmentityCampaigns.smownerid in (select vtiger_user2role.userid
				from vtiger_user2role
				inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid
				where vtiger_role.parentrole like 'H1::H2::H3::H6::%') or vtiger_crmentityCampaigns.smownerid in (select shareduserid from vtiger_tmp_read_user_sharing_per where userid=11 and tabid=26) or ( vtiger_groupsCampaigns.groupid in (3,4) or  vtiger_groupsCampaigns.groupid in (select vtiger_tmp_read_group_sharing_per.sharedgroupid
				from vtiger_tmp_read_group_sharing_per
				where userid=11 and tabid=26))) "),
			array(11, 'Assets', " and (vtiger_crmentityAssets.smownerid=11 or vtiger_crmentityAssets.smownerid in (select vtiger_user2role.userid
				from vtiger_user2role
				inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid
				where vtiger_role.parentrole like 'H1::H2::H3::H6::%') or vtiger_crmentityAssets.smownerid in (select shareduserid from vtiger_tmp_read_user_sharing_per where userid=11 and tabid=43) or ( vtiger_groupsAssets.groupid in (3,4) or  vtiger_groupsAssets.groupid in (select vtiger_tmp_read_group_sharing_per.sharedgroupid
				from vtiger_tmp_read_group_sharing_per
				where userid=11 and tabid=43))) "),
			array(5, 'Leads', " and (vtiger_crmentityLeads.smownerid=5 or vtiger_crmentityLeads.smownerid in (select vtiger_user2role.userid
				from vtiger_user2role
				inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid
				where vtiger_role.parentrole like 'H1::H2::H3::%') or vtiger_crmentityLeads.smownerid in (select shareduserid from vtiger_tmp_read_user_sharing_per where userid=5 and tabid=7) or ( vtiger_groupsLeads.groupid in (4,3) or  vtiger_groupsLeads.groupid in (select vtiger_tmp_read_group_sharing_per.sharedgroupid
				from vtiger_tmp_read_group_sharing_per
				where userid=5 and tabid=7))) "),
			array(5, 'Accounts', " and (vtiger_crmentityAccounts.smownerid=5 or vtiger_crmentityAccounts.smownerid in (select vtiger_user2role.userid
				from vtiger_user2role
				inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid
				where vtiger_role.parentrole like 'H1::H2::H3::%') or vtiger_crmentityAccounts.smownerid in (select shareduserid from vtiger_tmp_read_user_sharing_per where userid=5 and tabid=6) or ( vtiger_groupsAccounts.groupid in (4,3) or  vtiger_groupsAccounts.groupid in (select vtiger_tmp_read_group_sharing_per.sharedgroupid
				from vtiger_tmp_read_group_sharing_per
				where userid=5 and tabid=6))) "),
			array(5, 'Campaigns', " and (vtiger_crmentityCampaigns.smownerid=5 or vtiger_crmentityCampaigns.smownerid in (select vtiger_user2role.userid
				from vtiger_user2role
				inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid
				where vtiger_role.parentrole like 'H1::H2::H3::%') or vtiger_crmentityCampaigns.smownerid in (select shareduserid from vtiger_tmp_read_user_sharing_per where userid=5 and tabid=26) or ( vtiger_groupsCampaigns.groupid in (4,3) or  vtiger_groupsCampaigns.groupid in (select vtiger_tmp_read_group_sharing_per.sharedgroupid
				from vtiger_tmp_read_group_sharing_per
				where userid=5 and tabid=26))) "),
			array(5, 'Assets', " and (vtiger_crmentityAssets.smownerid=5 or vtiger_crmentityAssets.smownerid in (select vtiger_user2role.userid
				from vtiger_user2role
				inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid
				where vtiger_role.parentrole like 'H1::H2::H3::%') or vtiger_crmentityAssets.smownerid in (select shareduserid from vtiger_tmp_read_user_sharing_per where userid=5 and tabid=43) or ( vtiger_groupsAssets.groupid in (4,3) or  vtiger_groupsAssets.groupid in (select vtiger_tmp_read_group_sharing_per.sharedgroupid
				from vtiger_tmp_read_group_sharing_per
				where userid=5 and tabid=43))) "),
		);
	}

	/**
	 * Method testgetSecListViewSecurityParameter
	 * @test
	 * @dataProvider getSecListViewSecurityParameterProvider
	 */
	public function testgetSecListViewSecurityParameter($userid, $module, $expected) {
		global $current_user;
		$hold_user = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($userid);
		$current_user = $user;
		$focus = CRMEntity::getInstance($module);
		$actual = $focus->getSecListViewSecurityParameter($module);
		$this->assertEquals($expected, $actual, 'testgetSecListViewSecurityParameter');
		$current_user = $hold_user;
	}

	/**
	 * Method getListViewSecurityParameterProvider
	 * params
	 */
	public function getListViewSecurityParameterProvider() {
		return array(
			array(1, 'Leads', ''),
			array(1, 'Accounts', ''),
			array(1, 'Campaigns', ''),
			array(1, 'Assets', ''),
			array(1, 'CobroPago', ''),
			array(11, 'Leads', ''),
			array(11, 'HelpDesk', " and (vtiger_crmentity.smownerid=11 or vtiger_crmentity.smownerid in (select vtiger_user2role.userid
					from vtiger_user2role
					inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid
					where vtiger_role.parentrole like 'H1::H2::H3::H6::%') or vtiger_crmentity.smownerid in (select shareduserid
					from vtiger_tmp_read_user_sharing_per where userid=11 and tabid=13) or ( vtiger_groups.groupid in (3,4) or  vtiger_groups.groupid in (select vtiger_tmp_read_group_sharing_per.sharedgroupid
				from vtiger_tmp_read_group_sharing_per
				where userid=11 and tabid=13)))"),
			array(11, 'Accounts', ''),
			array(11, 'Campaigns', ''),
			array(11, 'Assets', ''),
			array(11, 'CobroPago', " and (vtiger_crmentity.smownerid=11 or vtiger_crmentity.smownerid in (select vtiger_user2role.userid
					from vtiger_user2role
					inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid
					where vtiger_role.parentrole like 'H1::H2::H3::H6::%') or vtiger_crmentity.smownerid in (select shareduserid
					from vtiger_tmp_read_user_sharing_per where userid=11 and tabid=42) or ( vtiger_groups.groupid in (3,4) or  vtiger_groups.groupid in (select vtiger_tmp_read_group_sharing_per.sharedgroupid
				from vtiger_tmp_read_group_sharing_per
				where userid=11 and tabid=42)))"),
			array(5, 'Leads', ''),
			array(5, 'HelpDesk', " and (vtiger_crmentity.smownerid=5 or vtiger_crmentity.smownerid in (select vtiger_user2role.userid
					from vtiger_user2role
					inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid
					where vtiger_role.parentrole like 'H1::H2::H3::%') or vtiger_crmentity.smownerid in (select shareduserid
					from vtiger_tmp_read_user_sharing_per where userid=5 and tabid=13) or ( vtiger_groups.groupid in (4,3) or  vtiger_groups.groupid in (select vtiger_tmp_read_group_sharing_per.sharedgroupid
				from vtiger_tmp_read_group_sharing_per
				where userid=5 and tabid=13)))"),
			array(5, 'Campaigns', ''),
			array(5, 'Assets', ''),
			array(5, 'CobroPago', " and (vtiger_crmentity.smownerid=5 or vtiger_crmentity.smownerid in (select vtiger_user2role.userid
					from vtiger_user2role
					inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid
					where vtiger_role.parentrole like 'H1::H2::H3::%') or vtiger_crmentity.smownerid in (select shareduserid
					from vtiger_tmp_read_user_sharing_per where userid=5 and tabid=42) or ( vtiger_groups.groupid in (4,3) or  vtiger_groups.groupid in (select vtiger_tmp_read_group_sharing_per.sharedgroupid
				from vtiger_tmp_read_group_sharing_per
				where userid=5 and tabid=42)))"),
		);
	}

	/**
	 * Method testgetListViewSecurityParameter
	 * @test
	 * @dataProvider getListViewSecurityParameterProvider
	 */
	public function testgetListViewSecurityParameter($userid, $module, $expected) {
		global $current_user;
		$hold_user = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($userid);
		$current_user = $user;
		$actual=getListViewSecurityParameter($module);
		$this->assertEquals($expected, $actual, 'testgetListViewSecurityParameter');
		$current_user = $hold_user;
	}

	/**
	 * Method getFieldVisibilityPermissionProvider
	 * params
	 */
	public function getFieldVisibilityPermissionProvider() {
		return array(
			array('Products', 1, 'productcode', '', '0'),
			array('Products', 1, 'productcode', 'readonly', '0'),
			array('Products', 1, 'productcategory', '', '0'),
			array('Products', 1, 'productcategory', 'readonly', '0'),
			array('Products', 11, 'productcode', '', '0'),
			array('Products', 11, 'productcode', 'readonly', '0'),
			array('Products', 11, 'productcategory', '', '0'),
			array('Products', 11, 'productcategory', 'readonly', '0'),
			array('Products', 5, 'productcode', '', '0'),
			array('Products', 5, 'productcode', 'readonly', '0'),
			array('Products', 5, 'productcategory', '', '1'),
			array('Products', 5, 'productcategory', 'readonly', '1'),
			array('Products', 9, 'productcode', '', '0'),
			array('Products', 9, 'productcode', 'readonly', '0'),
			array('Products', 9, 'productcategory', '', '1'),
			array('Products', 9, 'productcategory', 'readonly', '1'),
		);
	}

	/**
	 * Method testgetFieldVisibilityPermission
	 * @test
	 * @dataProvider getFieldVisibilityPermissionProvider
	 */
	public function testgetFieldVisibilityPermission($fld_module, $userid, $fieldname, $accessmode, $expected) {
		global $current_user;
		$hold_user = $current_user;
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($userid);
		$actual=getFieldVisibilityPermission($fld_module, $userid, $fieldname, $accessmode);
		$this->assertEquals($expected, $actual, 'testgetFieldVisibilityPermission');
		$current_user = $hold_user;
	}

	/**
	 * Method getPermittedModuleNamesProvider
	 * params
	 */
	public function getPermittedModuleNamesProvider() {
		$exp1 = array(
			'Dashboard',
			'Potentials',
			'Home',
			'Contacts',
			'Accounts',
			'Leads',
			'Documents',
			'Emails',
			'HelpDesk',
			'Products',
			'Faq',
			'Vendors',
			'PriceBooks',
			'Quotes',
			'PurchaseOrder',
			'SalesOrder',
			'Invoice',
			'Rss',
			'Reports',
			'Campaigns',
			'Portal',
			'Users',
			'ConfigEditor',
			'Import',
			'MailManager',
			'Mobile',
			'ModTracker',
			'PBXManager',
			'ServiceContracts',
			'Services',
			'VtigerBackup',
			'WSAPP',
			'cbupdater',
			'CobroPago',
			'Assets',
			'CronTasks',
			'ModComments',
			'ProjectMilestone',
			'ProjectTask',
			'Project',
			'RecycleBin',
			'Tooltip',
			'Webforms',
			'Calendar4You',
			'GlobalVariable',
			'InventoryDetails',
			'cbMap',
			'evvtMenu',
			'cbAuditTrail',
			'cbLoginHistory',
			'cbTermConditions',
			'cbCalendar',
			'cbtranslation',
			'BusinessActions',
			'cbSurvey',
			'cbSurveyQuestion',
			'cbSurveyDone',
			'cbSurveyAnswer',
			'cbCompany',
			'cbCVManagement',
			'cbQuestion',
			'ProductComponent',
			'Messages',
			'cbPulse',
			'EtiquetasOO',
			'evvtgendoc',
			'MsgTemplate',
			'cbCredentials',
			'DocumentFolders',
			'pricebookproductrel',
			'AutoNumberPrefix',
		);
		$exp2 = array(
			'Dashboard',
			'Potentials',
			'Home',
			'Contacts',
			'Accounts',
			'Leads',
			'Documents',
			'Emails',
			'HelpDesk',
			'Products',
			'Faq',
			'Vendors',
			'PriceBooks',
			'Quotes',
			'PurchaseOrder',
			'SalesOrder',
			'Invoice',
			'Rss',
			'Reports',
			'Campaigns',
			'Portal',
			'ConfigEditor',
			'Import',
			'MailManager',
			'Mobile',
			'ModTracker',
			'PBXManager',
			'ServiceContracts',
			'Services',
			'VtigerBackup',
			'WSAPP',
			'cbupdater',
			'CobroPago',
			'Assets',
			'CronTasks',
			'ModComments',
			'ProjectMilestone',
			'ProjectTask',
			'Project',
			'RecycleBin',
			'Tooltip',
			'Webforms',
			'Calendar4You',
			'GlobalVariable',
			'InventoryDetails',
			'cbMap',
			'evvtMenu',
			'cbAuditTrail',
			'cbLoginHistory',
			'cbTermConditions',
			'cbCalendar',
			'cbtranslation',
			'BusinessActions',
			'cbSurvey',
			'cbSurveyQuestion',
			'cbSurveyDone',
			'cbSurveyAnswer',
			'cbCompany',
			'cbCVManagement',
			'cbQuestion',
			'ProductComponent',
			'Messages',
			'cbPulse',
			'EtiquetasOO',
			'evvtgendoc',
			'MsgTemplate',
			'cbCredentials',
			'DocumentFolders',
			'pricebookproductrel',
			'AutoNumberPrefix',
		);
		$exp11 = $exp2;
		unset($exp11[49]);
		$exp11 = array_values($exp11);
		return array(
			array(1, $exp1),
			array(11, $exp11),
			array(5, $exp2),
			array(9, $exp2),
		);
	}

	/**
	 * Method testgetPermittedModuleNames
	 * @test
	 * @dataProvider getPermittedModuleNamesProvider
	 */
	public function testgetPermittedModuleNames($userid, $expected) {
		global $current_user;
		$hold_user = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($userid);
		$current_user = $user;
		$actual=getPermittedModuleNames();
		$this->assertEquals($expected, $actual, 'testgetPermittedModuleNames');
		$current_user = $hold_user;
	}

	/**
	 * Method getPermittedModuleIdListProvider
	 * params
	 */
	public function getPermittedModuleIdListProvider() {
		$exp1 = array(
			0 => 1,
			1 => 2,
			2 => 3,
			3 => 4,
			4 => 6,
			5 => 7,
			6 => 8,
			7 => 10,
			8 => 13,
			9 => 14,
			10 => 15,
			11 => 18,
			12 => 19,
			13 => 20,
			14 => 21,
			15 => 22,
			16 => 23,
			17 => 24,
			18 => 25,
			19 => 26,
			20 => 27,
			21 => 29,
			22 => 30,
			23 => 31,
			24 => 33,
			25 => 34,
			26 => 35,
			27 => 36,
			28 => 37,
			29 => 38,
			30 => 39,
			31 => 40,
			32 => 41,
			33 => 42,
			34 => 43,
			35 => 44,
			36 => 47,
			37 => 48,
			38 => 49,
			39 => 50,
			40 => 51,
			41 => 53,
			42 => 54,
			43 => 55,
			44 => 56,
			45 => 57,
			46 => 58,
			47 => 59,
			48 => 60,
			49 => 61,
			50 => 62,
			51 => 63,
			52 => 64,
			53 => 65,
			54 => 66,
			55 => 67,
			56 => 68,
			57 => 69,
			58 => 70,
			59 => 71,
			60 => 72,
			61 => 73,
			62 => 74,
			63 => 75,
			64 => 76,
			65 => 77,
			66 => 78,
			67 => 79,
			68 => 80,
			69 => 81,
			70 => 82,
		);
		$exp2 = array(
			0 => 1,
			1 => 2,
			2 => 3,
			3 => 4,
			4 => 6,
			5 => 7,
			6 => 8,
			7 => 10,
			8 => 13,
			9 => 14,
			10 => 15,
			11 => 18,
			12 => 19,
			13 => 20,
			14 => 21,
			15 => 22,
			16 => 23,
			17 => 24,
			18 => 25,
			19 => 26,
			20 => 27,
			21 => 30,
			22 => 31,
			23 => 33,
			24 => 34,
			25 => 35,
			26 => 36,
			27 => 37,
			28 => 38,
			29 => 39,
			30 => 40,
			31 => 41,
			32 => 42,
			33 => 43,
			34 => 44,
			35 => 47,
			36 => 48,
			37 => 49,
			38 => 50,
			39 => 51,
			40 => 53,
			41 => 54,
			42 => 55,
			43 => 56,
			44 => 57,
			45 => 58,
			46 => 59,
			47 => 60,
			48 => 61,
			49 => 62,
			50 => 63,
			51 => 64,
			52 => 65,
			53 => 66,
			54 => 67,
			55 => 68,
			56 => 69,
			57 => 70,
			58 => 71,
			59 => 72,
			60 => 73,
			61 => 74,
			62 => 75,
			63 => 76,
			64 => 77,
			65 => 78,
			66 => 79,
			67 => 80,
			68 => 81,
			69 => 82,
		);
		$exp11 = $exp2;
		unset($exp11[49]);
		$exp11 = array_values($exp11);
		return array(
			array(1, $exp1),
			array(11, $exp11),
			array(5, $exp2),
			array(9, $exp2),
		);
	}

	/**
	 * Method testgetPermittedModuleIdList
	 * @test
	 * @dataProvider getPermittedModuleIdListProvider
	 */
	public function testgetPermittedModuleIdList($userid, $expected) {
		global $current_user;
		$hold_user = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($userid);
		$current_user = $user;
		$actual=getPermittedModuleIdList();
		$this->assertEquals($expected, $actual, 'testgetPermittedModuleIdList');
		$current_user = $hold_user;
	}

	/**
	 * Method testgetAllUserName
	 * @test
	 */
	public function testgetAllUserName() {
		$expected = array(
			1 => ' Administrator',
			5 => 'cbTest testdmy',
			6 => 'cbTest testmdy',
			7 => 'cbTest testymd',
			8 => 'cbTest testes',
			9 => 'cbTest testinactive',
			10 => 'cbTest testtz',
			11 => 'nocreate cbTest',
			12 => 'cbTest testmcurrency',
			13 => 'cbTest testtz-3',
		);
		$this->assertEquals($expected, getAllUserName(), 'testgetAllUserName');
	}
}
?>