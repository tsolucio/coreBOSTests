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

class denormalizeTest extends TestCase {

	/**
	 * Method testDenormMetaInfo
	 * @test
	 */
	public function testDenormMetaInfo() {
		global $adb;
		$cninv = $adb->getColumnNames('vtiger_cbcredentials');
		$this->assertContains('deleted', $cninv, 'Test denorm MetaInfo');
		$this->assertContains('smcreatorid', $cninv, 'Test denorm MetaInfo');
		$this->assertContains('smownerid', $cninv, 'Test denorm MetaInfo');
		$this->assertContains('cbuuid', $cninv, 'Test denorm MetaInfo');
		$this->assertContains('setype', $cninv, 'Test denorm MetaInfo');
		$focus = CRMEntity::getInstance('cbCredentials');
		$this->assertNotContains('crmentity', $focus->tab_name, 'Test denorm MetaInfo');
		$this->assertTrue(empty($focus->tab_name_index['crmentity']), 'Test denorm MetaInfo');
	}

	/**
	 * Method testDenormQuery
	 * @test
	 */
	public function testDenormQuery() {
		global $current_user;
		$queryGenerator = new QueryGenerator('cbCredentials', $current_user);
		$queryGenerator->setFields(array('id'));
		$this->assertEquals(
			'SELECT vtiger_cbcredentials.cbcredentialsid FROM vtiger_cbcredentials   WHERE vtiger_cbcredentials.deleted=0 AND vtiger_cbcredentials.cbcredentialsid > 0',
			$queryGenerator->getQuery()
		);
		$queryGenerator = new QueryGenerator('cbCredentials', $current_user);
		$queryGenerator->setFields(array('id','assigned_user_id'));
		$this->assertEquals(
			'SELECT vtiger_cbcredentials.cbcredentialsid, vtiger_cbcredentials.smownerid FROM vtiger_cbcredentials  LEFT JOIN vtiger_users ON vtiger_cbcredentials.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_cbcredentials.smownerid = vtiger_groups.groupid  WHERE vtiger_cbcredentials.deleted=0 AND vtiger_cbcredentials.cbcredentialsid > 0',
			$queryGenerator->getQuery()
		);
		$queryGenerator = new QueryGenerator('cbCredentials', $current_user);
		$queryGenerator->setFields(array('id','assigned_user_id', 'Users.first_name'));
		$this->assertEquals(
			'SELECT vtiger_cbcredentials.cbcredentialsid, vtiger_cbcredentials.smownerid, vtiger_users.first_name FROM vtiger_cbcredentials  LEFT JOIN vtiger_users ON vtiger_cbcredentials.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_cbcredentials.smownerid = vtiger_groups.groupid  WHERE vtiger_cbcredentials.deleted=0 AND vtiger_cbcredentials.cbcredentialsid > 0',
			$queryGenerator->getQuery()
		);
	}

	/**
	 * Method testDenormCRUD
	 * @test
	 */
	public function testDenormCRUD() {
		global $current_user, $adb;
		$Module = 'cbCredentials';
		$cbUserID = '19x'.$current_user->id;
		$ObjectValues = array(
			'adapter'=>'GoogleCloudStorage',
			'azure_account' => '',
			'azure_key' => '',
			'azure_container' => '',
			'google_clientid' => '',
			'google_project_id' => '',
			'google_bucket' => '',
			'google_client_secret' => '',
			'google_developer_key' => '',
			'google_application_name' => '',
			'google_scopes' => '',
			'google_refresh_token' => '',
			'ftp_host' => 'ftp_host',
			'ftp_port' => '',
			'ftp_path' => '',
			'ftp_password' => '',
			'ftp_username' => '',
			'opencloud_username' => '',
			'opencloud_password' => '',
			'opencloud_projectname' => '',
			'assigned_user_id' => $cbUserID,
			'created_user_id' => $cbUserID,
			'description' => 'áçèñtös',
		);
		$actual = vtws_create($Module, $ObjectValues, $current_user);
		$ObjectValues['cbcredentialsno'] = $actual['cbcredentialsno'];
		$ObjectValues['id'] = $actual['id'];
		$ObjectValues['createdtime'] = $actual['createdtime'];
		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
		$ObjectValues['cbuuid'] = CRMEntity::getUUIDfromWSID($actual['id']);
		$this->assertEquals($ObjectValues, $actual, 'Test denorm create');
		$record = vtws_retrieve($actual['id'], $current_user);
		$actual['created_user_idename'] = array(
			'module' => 'Users',
			'reference' => ' Administrator',
			'cbuuid' => '',
		);
		$actual['assigned_user_idename'] = array(
			'module' => 'Users',
			'reference' => ' Administrator',
			'cbuuid' => '',
		);
		$this->assertEquals($actual, $record, 'Test denorm retrieve');
		sleep(1);
		$ObjectValues['ftp_host'] = 'ftp_host 2';
		$revised = vtws_revise($ObjectValues, $current_user);
		$this->assertEquals($ObjectValues['ftp_host'], $revised['ftp_host'], 'Test denorm revise');
		$this->assertNotEquals($ObjectValues['modifiedtime'], $revised['modifiedtime'], 'Test denorm revise');
		vtws_delete($actual['id'], $current_user);
		list($wsid, $crmid) = explode('x', $actual['id']);
		$r = $adb->pquery('select deleted from vtiger_cbcredentials where crmid=?', array($crmid));
		$deleted = $adb->query_result($r, 0, 'deleted');
		$this->assertEquals(1, $deleted, 'Test denorm deleted');
		$r = $adb->pquery('select deleted from vtiger_crmobject where crmid=?', array($crmid));
		$deleted = $adb->query_result($r, 0, 'deleted');
		$this->assertEquals(1, $deleted, 'Test denorm deleted');
	}
}
