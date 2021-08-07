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

require_once 'include/Webservices/ModulePermissionQuery.php';

class ModulePermissionQueryTest extends TestCase {

	/****
	 * TEST Users
	 ****/
	public $testusers = array(
		'usradmin' => 1,
		'usrtestdmy' => 5,
		'usrtestmdy' => 6,
		'usrtestymd' => 7,
		'usrtesttz' => 10,
		'usrnocreate' => 11,
		'usrtestmcurrency' => 12
	);

	/**
	 * Method getModulePermissionQueryProvider
	 */
	public function getModulePermissionQueryProvider() {
		return array(
			////////////
			array('Accounts', $this->testusers['usrnocreate'],
				array(
					'permissonTable' => '',
					'permissionQuery' => '',
					'permissionJoin' => ' ',
				),
			),
			array('cbMap', $this->testusers['usrnocreate'],
				array(
					'permissonTable' => 'vt_tmp_u11',
					'permissionQuery' => "(SELECT 11 as id) UNION (SELECT vtiger_user2role.userid AS userid FROM vtiger_user2role INNER JOIN vtiger_role ON vtiger_role.roleid=vtiger_user2role.roleid WHERE vtiger_role.parentrole like 'H1::H2::H3::H6::%') UNION (SELECT groupid FROM vtiger_groups where groupid in (3,4))",
					'permissionJoin' => ' INNER JOIN vt_tmp_u11 vt_tmp_u11 ON vt_tmp_u11.id = vtiger_crmentity.smownerid ',
				),
			),
			array('Accounts', $this->testusers['usrtestdmy'],
				array(
					'permissonTable' => '',
					'permissionQuery' => '',
					'permissionJoin' => ' ',
				),
			),
			array('cbMap', $this->testusers['usrtestdmy'],
				array(
					'permissonTable' => 'vt_tmp_u5',
					'permissionQuery' => "(SELECT 5 as id) UNION (SELECT vtiger_user2role.userid AS userid FROM vtiger_user2role INNER JOIN vtiger_role ON vtiger_role.roleid=vtiger_user2role.roleid WHERE vtiger_role.parentrole like 'H1::H2::H3::%') UNION (SELECT groupid FROM vtiger_groups where groupid in (4,3))",
					'permissionJoin' => ' INNER JOIN vt_tmp_u5 vt_tmp_u5 ON vt_tmp_u5.id = vtiger_crmentity.smownerid ',
				),
			),
			array('Accounts', $this->testusers['usradmin'],
				array(
					'permissonTable' => '',
					'permissionQuery' => '',
					'permissionJoin' => ' ',
				),
			),
			array('cbMap', $this->testusers['usradmin'],
				array(
					'permissonTable' => '',
					'permissionQuery' => '',
					'permissionJoin' => ' ',
				),
			),
		);
	}

	/**
	 * Method testgetModulePermissionQuery
	 * @test
	 * @dataProvider getModulePermissionQueryProvider
	 */
	public function testgetModulePermissionQuery($module, $userid, $expected) {
		global $current_user;
		$hold_user = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($userid);
		$this->assertEquals($expected, cbwsModulePermissionQuery($module, $user));
		$current_user = $hold_user;
	}

	/**
	 * Method getModulePermissionQueryExceptionProvider
	 */
	public function getModulePermissionQueryExceptionProvider() {
		return array(
			////////////
			array('CustomerPortal', $this->testusers['usrnocreate']),
			array('Portal', $this->testusers['usrnocreate']),
			array('Rss', $this->testusers['usrnocreate']),
			array('CustomerPortal', $this->testusers['usrtestdmy']),
			array('Portal', $this->testusers['usrtestdmy']),
			array('Rss', $this->testusers['usrtestdmy']),
			array('CustomerPortal', $this->testusers['usradmin']),
			array('Portal', $this->testusers['usradmin']),
			array('Rss', $this->testusers['usradmin']),
		);
	}

	/**
	 * Method testgetModulePermissionQueryException
	 * @test
	 * @dataProvider getModulePermissionQueryExceptionProvider
	 */
	public function testgetModulePermissionQueryException($module, $userid) {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('ACCESS_DENIED');
		$hold_user = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($userid);
		$this->assertEquals('', cbwsModulePermissionQuery($module, $user));
		$current_user = $hold_user;
	}
}
