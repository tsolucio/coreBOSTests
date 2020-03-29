<?php
/*************************************************************************************************
 * Copyright 2019 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

class testDatabaseUtil extends TestCase {

	/****
	 * TEST Users decimal configuration
	 * name format is: {decimal_separator}{symbol_position}{grouping}{grouping_symbol}{currency}
	 ****/
	public $usrdota0x = 5; // testdmy
	public $usrcomd0x = 6; // testmdy
	public $usrdotd3com = 7; // testymd
	public $usrcoma3dot = 10; // testtz
	public $usrdota3comdollar = 12; // testmcurrency

	/**
	 * Method testcheck_db_utf8_support
	 * @test
	 */
	public function testcheck_db_utf8_support() {
		global $dbconfig;
		$db_hostname = $dbconfig['db_hostname'];
		$db_username = $dbconfig['db_username'];
		$db_password = $dbconfig['db_password'];
		$conn = NewADOConnection('mysqli');
		$conn->Connect($db_hostname, $db_username, $db_password);
		if (get_db_charset($conn)=='utf8') {
			$this->assertTrue(check_db_utf8_support($conn), 'testcheck_db_utf8_support');
		} else {
			$this->assertFalse(check_db_utf8_support($conn), 'testcheck_db_utf8_support');
		}
		$conn->Close();
	}

	/**
	 * Method testget_db_charset
	 * @test
	 */
	public function testget_db_charset() {
		global $dbconfig;
		$db_hostname = $dbconfig['db_hostname'];
		$db_username = $dbconfig['db_username'];
		$db_password = $dbconfig['db_password'];
		$conn = NewADOConnection('mysqli');
		$conn->Connect($db_hostname, $db_username, $db_password);
		// counting here that the DB configuration is correct
		$this->assertContains(get_db_charset($conn), array('utf8', 'latin1'), 'testget_db_charset');
		$conn->Close();
	}

	/**
	 * Method mkSQLDataProvider
	 */
	public function mkSQLDataProvider() {
		return array(
			array(
				"select accountname, employees from vtiger_account where accountname like '%che%'",
				'employees',
				array(
				'max' => "SELECT max(employees) as max from vtiger_account where accountname like '%che%'",
				'min' => "SELECT min(employees) as min from vtiger_account where accountname like '%che%'",
				'sum' => "SELECT sum(employees) as sum from vtiger_account where accountname like '%che%'",
				'avg' => "SELECT avg(employees) as avg from vtiger_account where accountname like '%che%'",
				'tot' => "SELECT sum(employees) AS total from vtiger_account where accountname like '%che%'",
				'cnt' => "SELECT count(*) AS count from vtiger_account where accountname like '%che%'",
				'ful' => "SELECT count(*) AS count FROM (select accountname, employees from vtiger_account where accountname like '%che%') as sqlcount",
				),
				'account employees'
			),
			array(
				"select account_type, employees from vtiger_account where accountname like '%che%' order by account_type",
				'employees',
				array(
				'max' => "SELECT max(employees) as max from vtiger_account where accountname like '%che%' order by account_type",
				'min' => "SELECT min(employees) as min from vtiger_account where accountname like '%che%' order by account_type",
				'sum' => "SELECT sum(employees) as sum from vtiger_account where accountname like '%che%' order by account_type",
				'avg' => "SELECT avg(employees) as avg from vtiger_account where accountname like '%che%' order by account_type",
				'tot' => "SELECT sum(employees) AS total from vtiger_account where accountname like '%che%' order by account_type",
				'cnt' => "SELECT count(*) AS count from vtiger_account where accountname like '%che%'",
				'ful' => "SELECT count(*) AS count FROM (select account_type, employees from vtiger_account where accountname like '%che%') as sqlcount",
				),
				'account_type employees order by'
			),
			array(
				"select account_type, count(employees) from vtiger_account where accountname like '%che%' group by account_type",
				'employees',
				array(
				'max' => "SELECT max(employees) as max from vtiger_account where accountname like '%che%' group by account_type",
				'min' => "SELECT min(employees) as min from vtiger_account where accountname like '%che%' group by account_type",
				'sum' => "SELECT sum(employees) as sum from vtiger_account where accountname like '%che%' group by account_type",
				'avg' => "SELECT avg(employees) as avg from vtiger_account where accountname like '%che%' group by account_type",
				'tot' => "SELECT sum(employees) AS total from vtiger_account where accountname like '%che%' group by account_type",
				'cnt' => "SELECT count(*) AS count from vtiger_account where accountname like '%che%'",
				'ful' => "SELECT count(*) AS count FROM (select account_type, count(employees) from vtiger_account where accountname like '%che%' group by account_type) as sqlcount",
				),
				'account_type employees group by'
			),
			array(
				"select account_type, count(employees) from vtiger_account where accountname like '%che%' group by account_type order by account_type",
				'employees',
				array(
				'max' => "SELECT max(employees) as max from vtiger_account where accountname like '%che%' group by account_type order by account_type",
				'min' => "SELECT min(employees) as min from vtiger_account where accountname like '%che%' group by account_type order by account_type",
				'sum' => "SELECT sum(employees) as sum from vtiger_account where accountname like '%che%' group by account_type order by account_type",
				'avg' => "SELECT avg(employees) as avg from vtiger_account where accountname like '%che%' group by account_type order by account_type",
				'tot' => "SELECT sum(employees) AS total from vtiger_account where accountname like '%che%' group by account_type order by account_type",
				'cnt' => "SELECT count(*) AS count from vtiger_account where accountname like '%che%'",
				'ful' => "SELECT count(*) AS count FROM (select account_type, count(employees) from vtiger_account where accountname like '%che%' group by account_type) as sqlcount",
				),
				'account_type employees group and order by'
			),
			array(
				"SELECT vtiger_account.accountid, vtiger_account.accountname, vtiger_crmentity.smownerid, vtiger_accountscf.cf_718, vtiger_accountscf.cf_719
					FROM vtiger_account
					INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid
					LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id
					LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid
					INNER JOIN vtiger_accountscf ON vtiger_account.accountid = vtiger_accountscf.accountid
					WHERE vtiger_crmentity.deleted=0 AND ( (( vtiger_account.account_type IN
					( select translation_key from vtiger_cbtranslation where locale=\"pt_br\" and forpicklist=\"Accounts::account_type\" and i18n <> 'Separado para Distribuir')
					AND vtiger_account.account_type <> 'Separado para Distribuir') and ( vtiger_account.rating IN
					( select translation_key from vtiger_cbtranslation where locale=\"pt_br\" and forpicklist=\"Accounts::rating\" and i18n = 'Aberto') OR vtiger_account.rating = 'Aberto')
					or ( vtiger_account.rating IN ( select translation_key from vtiger_cbtranslation where locale=\"pt_br\" and forpicklist=\"Accounts::rating\" and i18n = 'Notificado')
					OR vtiger_account.rating = 'Notificado') )) AND vtiger_account.accountid > 0",
				'employees',
				array(
				'max' => "SELECT max(employees) as max FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid INNER JOIN vtiger_accountscf ON vtiger_account.accountid = vtiger_accountscf.accountid WHERE vtiger_crmentity.deleted=0 AND ( (( vtiger_account.account_type IN ( select translation_key from vtiger_cbtranslation where locale=\"pt_br\" and forpicklist=\"Accounts::account_type\" and i18n <> 'Separado para Distribuir') AND vtiger_account.account_type <> 'Separado para Distribuir') and ( vtiger_account.rating IN ( select translation_key from vtiger_cbtranslation where locale=\"pt_br\" and forpicklist=\"Accounts::rating\" and i18n = 'Aberto') OR vtiger_account.rating = 'Aberto') or ( vtiger_account.rating IN ( select translation_key from vtiger_cbtranslation where locale=\"pt_br\" and forpicklist=\"Accounts::rating\" and i18n = 'Notificado') OR vtiger_account.rating = 'Notificado') )) AND vtiger_account.accountid > 0",
				'min' => "SELECT min(employees) as min FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid INNER JOIN vtiger_accountscf ON vtiger_account.accountid = vtiger_accountscf.accountid WHERE vtiger_crmentity.deleted=0 AND ( (( vtiger_account.account_type IN ( select translation_key from vtiger_cbtranslation where locale=\"pt_br\" and forpicklist=\"Accounts::account_type\" and i18n <> 'Separado para Distribuir') AND vtiger_account.account_type <> 'Separado para Distribuir') and ( vtiger_account.rating IN ( select translation_key from vtiger_cbtranslation where locale=\"pt_br\" and forpicklist=\"Accounts::rating\" and i18n = 'Aberto') OR vtiger_account.rating = 'Aberto') or ( vtiger_account.rating IN ( select translation_key from vtiger_cbtranslation where locale=\"pt_br\" and forpicklist=\"Accounts::rating\" and i18n = 'Notificado') OR vtiger_account.rating = 'Notificado') )) AND vtiger_account.accountid > 0",
				'sum' => "SELECT sum(employees) as sum FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid INNER JOIN vtiger_accountscf ON vtiger_account.accountid = vtiger_accountscf.accountid WHERE vtiger_crmentity.deleted=0 AND ( (( vtiger_account.account_type IN ( select translation_key from vtiger_cbtranslation where locale=\"pt_br\" and forpicklist=\"Accounts::account_type\" and i18n <> 'Separado para Distribuir') AND vtiger_account.account_type <> 'Separado para Distribuir') and ( vtiger_account.rating IN ( select translation_key from vtiger_cbtranslation where locale=\"pt_br\" and forpicklist=\"Accounts::rating\" and i18n = 'Aberto') OR vtiger_account.rating = 'Aberto') or ( vtiger_account.rating IN ( select translation_key from vtiger_cbtranslation where locale=\"pt_br\" and forpicklist=\"Accounts::rating\" and i18n = 'Notificado') OR vtiger_account.rating = 'Notificado') )) AND vtiger_account.accountid > 0",
				'avg' => "SELECT avg(employees) as avg FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid INNER JOIN vtiger_accountscf ON vtiger_account.accountid = vtiger_accountscf.accountid WHERE vtiger_crmentity.deleted=0 AND ( (( vtiger_account.account_type IN ( select translation_key from vtiger_cbtranslation where locale=\"pt_br\" and forpicklist=\"Accounts::account_type\" and i18n <> 'Separado para Distribuir') AND vtiger_account.account_type <> 'Separado para Distribuir') and ( vtiger_account.rating IN ( select translation_key from vtiger_cbtranslation where locale=\"pt_br\" and forpicklist=\"Accounts::rating\" and i18n = 'Aberto') OR vtiger_account.rating = 'Aberto') or ( vtiger_account.rating IN ( select translation_key from vtiger_cbtranslation where locale=\"pt_br\" and forpicklist=\"Accounts::rating\" and i18n = 'Notificado') OR vtiger_account.rating = 'Notificado') )) AND vtiger_account.accountid > 0",
				'tot' => "SELECT sum(employees) AS total FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid INNER JOIN vtiger_accountscf ON vtiger_account.accountid = vtiger_accountscf.accountid WHERE vtiger_crmentity.deleted=0 AND ( (( vtiger_account.account_type IN ( select translation_key from vtiger_cbtranslation where locale=\"pt_br\" and forpicklist=\"Accounts::account_type\" and i18n <> 'Separado para Distribuir') AND vtiger_account.account_type <> 'Separado para Distribuir') and ( vtiger_account.rating IN ( select translation_key from vtiger_cbtranslation where locale=\"pt_br\" and forpicklist=\"Accounts::rating\" and i18n = 'Aberto') OR vtiger_account.rating = 'Aberto') or ( vtiger_account.rating IN ( select translation_key from vtiger_cbtranslation where locale=\"pt_br\" and forpicklist=\"Accounts::rating\" and i18n = 'Notificado') OR vtiger_account.rating = 'Notificado') )) AND vtiger_account.accountid > 0",
				'cnt' => "SELECT count(*) AS count FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid INNER JOIN vtiger_accountscf ON vtiger_account.accountid = vtiger_accountscf.accountid WHERE vtiger_crmentity.deleted=0 AND ( (( vtiger_account.account_type IN ( select translation_key from vtiger_cbtranslation where locale=\"pt_br\" and forpicklist=\"Accounts::account_type\" and i18n <> 'Separado para Distribuir') AND vtiger_account.account_type <> 'Separado para Distribuir') and ( vtiger_account.rating IN ( select translation_key from vtiger_cbtranslation where locale=\"pt_br\" and forpicklist=\"Accounts::rating\" and i18n = 'Aberto') OR vtiger_account.rating = 'Aberto') or ( vtiger_account.rating IN ( select translation_key from vtiger_cbtranslation where locale=\"pt_br\" and forpicklist=\"Accounts::rating\" and i18n = 'Notificado') OR vtiger_account.rating = 'Notificado') )) AND vtiger_account.accountid > 0",
				'ful' => "SELECT count(*) AS count FROM (SELECT vtiger_account.accountid, vtiger_account.accountname, vtiger_crmentity.smownerid, vtiger_accountscf.cf_718, vtiger_accountscf.cf_719 FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_account.accountid = vtiger_crmentity.crmid LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid INNER JOIN vtiger_accountscf ON vtiger_account.accountid = vtiger_accountscf.accountid WHERE vtiger_crmentity.deleted=0 AND ( (( vtiger_account.account_type IN ( select translation_key from vtiger_cbtranslation where locale=\"pt_br\" and forpicklist=\"Accounts::account_type\" and i18n <> 'Separado para Distribuir') AND vtiger_account.account_type <> 'Separado para Distribuir') and ( vtiger_account.rating IN ( select translation_key from vtiger_cbtranslation where locale=\"pt_br\" and forpicklist=\"Accounts::rating\" and i18n = 'Aberto') OR vtiger_account.rating = 'Aberto') or ( vtiger_account.rating IN ( select translation_key from vtiger_cbtranslation where locale=\"pt_br\" and forpicklist=\"Accounts::rating\" and i18n = 'Notificado') OR vtiger_account.rating = 'Notificado') )) AND vtiger_account.accountid > 0) as sqlcount",
				),
				'subqueries'
			),
		);
	}

	/**
	 * Method testmkMaxQuery
	 * @test
	 * @dataProvider mkSQLDataProvider
	 */
	public function testmkMaxQuery($query, $field, $expected, $msg) {
		global $adb;
		$mksql = mkMaxQuery($query, $field);
		$this->assertEquals($expected['max'], $mksql, $msg);
		$rs = $adb->query($mksql);
		$this->assertTrue($rs !== false);
	}

	/**
	 * Method testmkMinQuery
	 * @test
	 * @dataProvider mkSQLDataProvider
	 */
	public function testmkMinQuery($query, $field, $expected, $msg) {
		global $adb;
		$mksql = mkMinQuery($query, $field);
		$this->assertEquals($expected['min'], $mksql, $msg);
		$rs = $adb->query($mksql);
		$this->assertTrue($rs !== false);
	}

	/**
	 * Method testmkSumQuery
	 * @test
	 * @dataProvider mkSQLDataProvider
	 */
	public function testmkSumQuery($query, $field, $expected, $msg) {
		global $adb;
		$mksql = mkSumQuery($query, $field);
		$this->assertEquals($expected['sum'], $mksql, $msg);
		$rs = $adb->query($mksql);
		$this->assertTrue($rs !== false);
	}

	/**
	 * Method testmkAvgQuery
	 * @test
	 * @dataProvider mkSQLDataProvider
	 */
	public function testmkAvgQuery($query, $field, $expected, $msg) {
		global $adb;
		$mksql = mkAvgQuery($query, $field);
		$this->assertEquals($expected['avg'], $mksql, $msg);
		$rs = $adb->query($mksql);
		$this->assertTrue($rs !== false);
	}

	/**
	 * Method testmkTotQuery
	 * @test
	 * @dataProvider mkSQLDataProvider
	 */
	public function testmkTotQuery($query, $field, $expected, $msg) {
		global $adb;
		$mksql = mkTotQuery($query, $field);
		$this->assertEquals($expected['tot'], $mksql, $msg);
		$rs = $adb->query($mksql);
		$this->assertTrue($rs !== false);
	}

	/**
	 * Method testmkCountQuery
	 * @test
	 * @dataProvider mkSQLDataProvider
	 */
	public function testmkCountQuery($query, $field, $expected, $msg) {
		global $adb;
		$mksql = mkCountQuery($query);
		$this->assertEquals($expected['cnt'], $mksql, $msg);
		$rs = $adb->query($mksql);
		$this->assertTrue($rs !== false);
	}

	/**
	 * Method testmkCountFullQuery
	 * @test
	 * @dataProvider mkSQLDataProvider
	 */
	public function testmkCountFullQuery($query, $field, $expected, $msg) {
		global $adb;
		$mksql = mkCountWithFullQuery($query);
		$this->assertEquals($expected['ful'], $mksql, $msg);
		$rs = $adb->query($mksql);
		$this->assertTrue($rs !== false);
	}


	/**
	 * Method stripTailCommandsFromQueryProvider
	 */
	public function stripTailCommandsFromQueryProvider() {
		return array(
			array(
				'select * from vtiger_accounts where accountname like "%t%"',
				true,
				'select * from vtiger_accounts where accountname like "%t%"',
			),
			array(
				'select * from vtiger_accounts where accountname like "%t%" limit 1',
				true,
				'select * from vtiger_accounts where accountname like "%t%"',
			),
			array(
				'select * from vtiger_accounts where accountname like "%t%" limit 1,1',
				true,
				'select * from vtiger_accounts where accountname like "%t%"',
			),
			array(
				'select * from vtiger_accounts where accountname like "%t%" order by 1',
				true,
				'select * from vtiger_accounts where accountname like "%t%"',
			),
			array(
				'select * from vtiger_accounts where accountname like "%t%" order by 1 limit 1',
				true,
				'select * from vtiger_accounts where accountname like "%t%"',
			),
			array(
				'select * from vtiger_accounts where accountname like "%t%" group by accountname',
				true,
				'select * from vtiger_accounts where accountname like "%t%"',
			),
			array(
				'select * from vtiger_accounts where accountname like "%t%" group by accountname limit 1',
				true,
				'select * from vtiger_accounts where accountname like "%t%"',
			),
			array(
				'select * from vtiger_accounts where accountname like "%t%" group by accountname order by 1',
				true,
				'select * from vtiger_accounts where accountname like "%t%"',
			),
			array(
				'select * from vtiger_accounts where accountname like "%t%" group by accountname order by 1 limit 1',
				true,
				'select * from vtiger_accounts where accountname like "%t%"',
			),
			array(
				'select * from vtiger_accounts where accountname like "%t%"',
				false,
				'select * from vtiger_accounts where accountname like "%t%"',
			),
			array(
				'select * from vtiger_accounts where accountname like "%t%" limit 1',
				false,
				'select * from vtiger_accounts where accountname like "%t%"',
			),
			array(
				'select * from vtiger_accounts where accountname like "%t%" limit 1,1',
				false,
				'select * from vtiger_accounts where accountname like "%t%"',
			),
			array(
				'select * from vtiger_accounts where accountname like "%t%" order by 1',
				false,
				'select * from vtiger_accounts where accountname like "%t%"',
			),
			array(
				'select * from vtiger_accounts where accountname like "%t%" order by 1 limit 1',
				false,
				'select * from vtiger_accounts where accountname like "%t%"',
			),
			array(
				'select * from vtiger_accounts where accountname like "%t%" group by accountname',
				false,
				'select * from vtiger_accounts where accountname like "%t%" group by accountname',
			),
			array(
				'select * from vtiger_accounts where accountname like "%t%" group by accountname limit 1',
				false,
				'select * from vtiger_accounts where accountname like "%t%" group by accountname',
			),
			array(
				'select * from vtiger_accounts where accountname like "%t%" group by accountname order by 1',
				false,
				'select * from vtiger_accounts where accountname like "%t%" group by accountname',
			),
			array(
				'select * from vtiger_accounts where accountname like "%t%" group by accountname order by 1 limit 1',
				false,
				'select * from vtiger_accounts where accountname like "%t%" group by accountname',
			),
		);
	}

	/**
	 * Method teststripTailCommandsFromQuery
	 * @test
	 * @dataProvider stripTailCommandsFromQueryProvider
	 */
	public function teststripTailCommandsFromQuery($query, $groupby, $expected) {
		$this->assertEquals($expected, stripTailCommandsFromQuery($query, $groupby));
	}
}
