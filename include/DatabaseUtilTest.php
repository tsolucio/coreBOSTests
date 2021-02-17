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
		if (get_db_charset($conn)=='utf8' || get_db_charset($conn)=='utf8mb4') {
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
		$this->assertContains(get_db_charset($conn), array('utf8', 'latin1', 'utf8mb4'), 'testget_db_charset');
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

	/**
	 * Method appendFromClauseToQueryProvider
	 */
	public function appendFromClauseToQueryProvider() {
		return array(
			array(
				"SELECT vtiger_account.account_no, vtiger_account.accountname, vtiger_accountbillads.bill_city, vtiger_account.website, vtiger_account.phone, vtiger_crmentity.smownerid, vtiger_crmentity.crmid FROM vtiger_account INNER JOIN vtiger_crmentity AS vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_account.accountid INNER JOIN vtiger_accountbillads ON vtiger_account.accountid = vtiger_accountbillads.accountaddressid INNER JOIN vtiger_accountshipads ON vtiger_account.accountid = vtiger_accountshipads.accountaddressid INNER JOIN vtiger_accountscf ON vtiger_account.accountid = vtiger_accountscf.accountid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_account vtiger_account2 ON vtiger_account.parentid = vtiger_account2.accountid WHERE vtiger_account.accountid>0 AND vtiger_crmentity.deleted = 0 and (vtiger_account.accountname LIKE '%che%' OR vtiger_account.account_no LIKE '%che%' OR vtiger_account.phone LIKE '%che%' OR vtiger_account.website LIKE '%che%' OR vtiger_account.fax LIKE '%che%' OR vtiger_account.tickersymbol LIKE '%che%' OR vtiger_account.otherphone LIKE '%che%' OR vtiger_account.parentid LIKE '%che%' OR vtiger_account.email1 LIKE '%che%' OR vtiger_account.employees LIKE '%che%' OR vtiger_account.email2 LIKE '%che%' OR vtiger_account.ownership LIKE '%che%' OR (vtiger_account.rating IN (select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::rating\" and i18n LIKE \"%che%\") OR vtiger_account.rating LIKE \"%che%\") OR (vtiger_account.industry IN (select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::industry\" and i18n LIKE \"%che%\") OR vtiger_account.industry LIKE \"%che%\") OR vtiger_account.siccode LIKE '%che%' OR (vtiger_account.account_type IN (select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::accounttype\" and i18n LIKE \"%che%\") OR vtiger_account.account_type LIKE \"%che%\") OR vtiger_account.annualrevenue LIKE '%che%' OR vtiger_account.emailoptout LIKE '%che%' OR vtiger_account.notify_owner LIKE '%che%' OR vtiger_crmentity.smownerid LIKE '%che%' OR vtiger_crmentity.createdtime LIKE '%che%' OR vtiger_crmentity.modifiedtime LIKE '%che%' OR vtiger_crmentity.modifiedby LIKE '%che%' OR vtiger_accountbillads.bill_street LIKE '%che%' OR vtiger_accountshipads.ship_street LIKE '%che%' OR vtiger_accountbillads.bill_city LIKE '%che%' OR vtiger_accountshipads.ship_city LIKE '%che%' OR vtiger_accountbillads.bill_state LIKE '%che%' OR vtiger_accountshipads.ship_state LIKE '%che%' OR vtiger_accountbillads.bill_code LIKE '%che%' OR vtiger_accountshipads.ship_code LIKE '%che%' OR vtiger_accountbillads.bill_country LIKE '%che%' OR vtiger_accountshipads.ship_country LIKE '%che%' OR vtiger_accountbillads.bill_pobox LIKE '%che%' OR vtiger_accountshipads.ship_pobox LIKE '%che%' OR vtiger_crmentity.description LIKE '%che%' OR vtiger_accountscf.cf_718 LIKE '%che%' OR vtiger_accountscf.cf_719 LIKE '%che%' OR vtiger_accountscf.cf_720 LIKE '%che%' OR vtiger_accountscf.cf_721 LIKE '%che%' OR vtiger_accountscf.cf_722 LIKE '%che%' OR vtiger_accountscf.cf_723 LIKE '%che%' OR vtiger_accountscf.cf_724 LIKE '%che%' OR vtiger_accountscf.cf_725 LIKE '%che%' OR vtiger_accountscf.cf_726 LIKE '%che%' OR vtiger_accountscf.cf_727 LIKE '%che%' OR vtiger_accountscf.cf_728 LIKE '%che%' OR (vtiger_accountscf.cf_729 IN (select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::cf_729\" and i18n LIKE \"%che%\") OR vtiger_accountscf.cf_729 LIKE \"%che%\") OR (vtiger_accountscf.cf_730 IN (select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::cf_730\" and i18n LIKE \"%che%\") OR vtiger_accountscf.cf_730 LIKE \"%che%\") OR (vtiger_accountscf.cf_731 IN (select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::cf_731\" and i18n LIKE \"%che%\") OR vtiger_accountscf.cf_731 LIKE \"%che%\") OR vtiger_accountscf.cf_732 LIKE '%che%' OR vtiger_account.isconvertedfromlead LIKE '%che%' OR vtiger_account.convertedfromlead LIKE '%che%' OR vtiger_crmentity.smcreatorid LIKE '%che%')",
				'inner join with any string',
				"SELECT vtiger_account.account_no, vtiger_account.accountname, vtiger_accountbillads.bill_city, vtiger_account.website, vtiger_account.phone, vtiger_crmentity.smownerid, vtiger_crmentity.crmid FROM vtiger_account INNER JOIN vtiger_crmentity AS vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_account.accountid INNER JOIN vtiger_accountbillads ON vtiger_account.accountid = vtiger_accountbillads.accountaddressid INNER JOIN vtiger_accountshipads ON vtiger_account.accountid = vtiger_accountshipads.accountaddressid INNER JOIN vtiger_accountscf ON vtiger_account.accountid = vtiger_accountscf.accountid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_account vtiger_account2 ON vtiger_account.parentid = vtiger_account2.accountid inner join with any string WHERE vtiger_account.accountid>0 AND vtiger_crmentity.deleted = 0 and (vtiger_account.accountname LIKE '%che%' OR vtiger_account.account_no LIKE '%che%' OR vtiger_account.phone LIKE '%che%' OR vtiger_account.website LIKE '%che%' OR vtiger_account.fax LIKE '%che%' OR vtiger_account.tickersymbol LIKE '%che%' OR vtiger_account.otherphone LIKE '%che%' OR vtiger_account.parentid LIKE '%che%' OR vtiger_account.email1 LIKE '%che%' OR vtiger_account.employees LIKE '%che%' OR vtiger_account.email2 LIKE '%che%' OR vtiger_account.ownership LIKE '%che%' OR (vtiger_account.rating IN (select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::rating\" and i18n LIKE \"%che%\") OR vtiger_account.rating LIKE \"%che%\") OR (vtiger_account.industry IN (select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::industry\" and i18n LIKE \"%che%\") OR vtiger_account.industry LIKE \"%che%\") OR vtiger_account.siccode LIKE '%che%' OR (vtiger_account.account_type IN (select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::accounttype\" and i18n LIKE \"%che%\") OR vtiger_account.account_type LIKE \"%che%\") OR vtiger_account.annualrevenue LIKE '%che%' OR vtiger_account.emailoptout LIKE '%che%' OR vtiger_account.notify_owner LIKE '%che%' OR vtiger_crmentity.smownerid LIKE '%che%' OR vtiger_crmentity.createdtime LIKE '%che%' OR vtiger_crmentity.modifiedtime LIKE '%che%' OR vtiger_crmentity.modifiedby LIKE '%che%' OR vtiger_accountbillads.bill_street LIKE '%che%' OR vtiger_accountshipads.ship_street LIKE '%che%' OR vtiger_accountbillads.bill_city LIKE '%che%' OR vtiger_accountshipads.ship_city LIKE '%che%' OR vtiger_accountbillads.bill_state LIKE '%che%' OR vtiger_accountshipads.ship_state LIKE '%che%' OR vtiger_accountbillads.bill_code LIKE '%che%' OR vtiger_accountshipads.ship_code LIKE '%che%' OR vtiger_accountbillads.bill_country LIKE '%che%' OR vtiger_accountshipads.ship_country LIKE '%che%' OR vtiger_accountbillads.bill_pobox LIKE '%che%' OR vtiger_accountshipads.ship_pobox LIKE '%che%' OR vtiger_crmentity.description LIKE '%che%' OR vtiger_accountscf.cf_718 LIKE '%che%' OR vtiger_accountscf.cf_719 LIKE '%che%' OR vtiger_accountscf.cf_720 LIKE '%che%' OR vtiger_accountscf.cf_721 LIKE '%che%' OR vtiger_accountscf.cf_722 LIKE '%che%' OR vtiger_accountscf.cf_723 LIKE '%che%' OR vtiger_accountscf.cf_724 LIKE '%che%' OR vtiger_accountscf.cf_725 LIKE '%che%' OR vtiger_accountscf.cf_726 LIKE '%che%' OR vtiger_accountscf.cf_727 LIKE '%che%' OR vtiger_accountscf.cf_728 LIKE '%che%' OR (vtiger_accountscf.cf_729 IN (select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::cf_729\" and i18n LIKE \"%che%\") OR vtiger_accountscf.cf_729 LIKE \"%che%\") OR (vtiger_accountscf.cf_730 IN (select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::cf_730\" and i18n LIKE \"%che%\") OR vtiger_accountscf.cf_730 LIKE \"%che%\") OR (vtiger_accountscf.cf_731 IN (select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::cf_731\" and i18n LIKE \"%che%\") OR vtiger_accountscf.cf_731 LIKE \"%che%\") OR vtiger_accountscf.cf_732 LIKE '%che%' OR vtiger_account.isconvertedfromlead LIKE '%che%' OR vtiger_account.convertedfromlead LIKE '%che%' OR vtiger_crmentity.smcreatorid LIKE '%che%')",
			),
			array(
				'SELECT * FROM vtiger_accounts WHERE accountname like "%t%"',
				'inner join with any string',
				'SELECT * FROM vtiger_accounts inner join with any string WHERE accountname like "%t%"',
			),
			array(
				'SELECT * FROM vtiger_accounts',
				'inner join with any string',
				'SELECT * FROM vtiger_accounts inner join with any string',
			),
			array(
				'SELECT * FROM vtiger_accounts',
				'',
				'SELECT * FROM vtiger_accounts',
			),
			array(
				'SELECT  *  FROM  vtiger_accounts  ',
				'   ',
				'SELECT * FROM vtiger_accounts ',
			),
			array(
				'SELECT * FROM vtiger_accounts where xx in (select somefield from sometable where thereisanotherwhere=true)',
				'inner join with any string',
				'SELECT * FROM vtiger_accounts inner join with any string where xx in (select somefield from sometable where thereisanotherwhere=true)',
			),
		);
	}

	/**
	 * Method testappendFromClauseToQuery
	 * @test
	 * @dataProvider appendFromClauseToQueryProvider
	 */
	public function testappendFromClauseToQuery($query, $condClause, $expected) {
		$this->assertEquals($expected, appendFromClauseToQuery($query, $condClause));
	}

	/**
	 * Method appendConditionClauseToQueryProvider
	 */
	public function appendConditionClauseToQueryProvider() {
		return array(
			array(
				"SELECT vtiger_account.account_no, vtiger_account.accountname, vtiger_accountbillads.bill_city, vtiger_account.website, vtiger_account.phone, vtiger_crmentity.smownerid, vtiger_crmentity.crmid FROM vtiger_account INNER JOIN vtiger_crmentity AS vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_account.accountid INNER JOIN vtiger_accountbillads ON vtiger_account.accountid = vtiger_accountbillads.accountaddressid INNER JOIN vtiger_accountshipads ON vtiger_account.accountid = vtiger_accountshipads.accountaddressid INNER JOIN vtiger_accountscf ON vtiger_account.accountid = vtiger_accountscf.accountid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_account vtiger_account2 ON vtiger_account.parentid = vtiger_account2.accountid WHERE vtiger_account.accountid>0 AND vtiger_crmentity.deleted = 0 and (vtiger_account.accountname LIKE '%che%' OR vtiger_account.account_no LIKE '%che%' OR vtiger_account.phone LIKE '%che%' OR vtiger_account.website LIKE '%che%' OR vtiger_account.fax LIKE '%che%' OR vtiger_account.tickersymbol LIKE '%che%' OR vtiger_account.otherphone LIKE '%che%' OR vtiger_account.parentid LIKE '%che%' OR vtiger_account.email1 LIKE '%che%' OR vtiger_account.employees LIKE '%che%' OR vtiger_account.email2 LIKE '%che%' OR vtiger_account.ownership LIKE '%che%' OR (vtiger_account.rating IN (select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::rating\" and i18n LIKE \"%che%\") OR vtiger_account.rating LIKE \"%che%\") OR (vtiger_account.industry IN (select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::industry\" and i18n LIKE \"%che%\") OR vtiger_account.industry LIKE \"%che%\") OR vtiger_account.siccode LIKE '%che%' OR (vtiger_account.account_type IN (select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::accounttype\" and i18n LIKE \"%che%\") OR vtiger_account.account_type LIKE \"%che%\") OR vtiger_account.annualrevenue LIKE '%che%' OR vtiger_account.emailoptout LIKE '%che%' OR vtiger_account.notify_owner LIKE '%che%' OR vtiger_crmentity.smownerid LIKE '%che%' OR vtiger_crmentity.createdtime LIKE '%che%' OR vtiger_crmentity.modifiedtime LIKE '%che%' OR vtiger_crmentity.modifiedby LIKE '%che%' OR vtiger_accountbillads.bill_street LIKE '%che%' OR vtiger_accountshipads.ship_street LIKE '%che%' OR vtiger_accountbillads.bill_city LIKE '%che%' OR vtiger_accountshipads.ship_city LIKE '%che%' OR vtiger_accountbillads.bill_state LIKE '%che%' OR vtiger_accountshipads.ship_state LIKE '%che%' OR vtiger_accountbillads.bill_code LIKE '%che%' OR vtiger_accountshipads.ship_code LIKE '%che%' OR vtiger_accountbillads.bill_country LIKE '%che%' OR vtiger_accountshipads.ship_country LIKE '%che%' OR vtiger_accountbillads.bill_pobox LIKE '%che%' OR vtiger_accountshipads.ship_pobox LIKE '%che%' OR vtiger_crmentity.description LIKE '%che%' OR vtiger_accountscf.cf_718 LIKE '%che%' OR vtiger_accountscf.cf_719 LIKE '%che%' OR vtiger_accountscf.cf_720 LIKE '%che%' OR vtiger_accountscf.cf_721 LIKE '%che%' OR vtiger_accountscf.cf_722 LIKE '%che%' OR vtiger_accountscf.cf_723 LIKE '%che%' OR vtiger_accountscf.cf_724 LIKE '%che%' OR vtiger_accountscf.cf_725 LIKE '%che%' OR vtiger_accountscf.cf_726 LIKE '%che%' OR vtiger_accountscf.cf_727 LIKE '%che%' OR vtiger_accountscf.cf_728 LIKE '%che%' OR (vtiger_accountscf.cf_729 IN (select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::cf_729\" and i18n LIKE \"%che%\") OR vtiger_accountscf.cf_729 LIKE \"%che%\") OR (vtiger_accountscf.cf_730 IN (select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::cf_730\" and i18n LIKE \"%che%\") OR vtiger_accountscf.cf_730 LIKE \"%che%\") OR (vtiger_accountscf.cf_731 IN (select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::cf_731\" and i18n LIKE \"%che%\") OR vtiger_accountscf.cf_731 LIKE \"%che%\") OR vtiger_accountscf.cf_732 LIKE '%che%' OR vtiger_account.isconvertedfromlead LIKE '%che%' OR vtiger_account.convertedfromlead LIKE '%che%' OR vtiger_crmentity.smcreatorid LIKE '%che%')",
				'vtiger_account.accountid=74',
				'and',
				"SELECT vtiger_account.account_no, vtiger_account.accountname, vtiger_accountbillads.bill_city, vtiger_account.website, vtiger_account.phone, vtiger_crmentity.smownerid, vtiger_crmentity.crmid FROM vtiger_account INNER JOIN vtiger_crmentity AS vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_account.accountid INNER JOIN vtiger_accountbillads ON vtiger_account.accountid = vtiger_accountbillads.accountaddressid INNER JOIN vtiger_accountshipads ON vtiger_account.accountid = vtiger_accountshipads.accountaddressid INNER JOIN vtiger_accountscf ON vtiger_account.accountid = vtiger_accountscf.accountid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_account vtiger_account2 ON vtiger_account.parentid = vtiger_account2.accountid WHERE (vtiger_account.accountid=74) and vtiger_account.accountid>0 AND vtiger_crmentity.deleted = 0 and (vtiger_account.accountname LIKE '%che%' OR vtiger_account.account_no LIKE '%che%' OR vtiger_account.phone LIKE '%che%' OR vtiger_account.website LIKE '%che%' OR vtiger_account.fax LIKE '%che%' OR vtiger_account.tickersymbol LIKE '%che%' OR vtiger_account.otherphone LIKE '%che%' OR vtiger_account.parentid LIKE '%che%' OR vtiger_account.email1 LIKE '%che%' OR vtiger_account.employees LIKE '%che%' OR vtiger_account.email2 LIKE '%che%' OR vtiger_account.ownership LIKE '%che%' OR (vtiger_account.rating IN (select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::rating\" and i18n LIKE \"%che%\") OR vtiger_account.rating LIKE \"%che%\") OR (vtiger_account.industry IN (select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::industry\" and i18n LIKE \"%che%\") OR vtiger_account.industry LIKE \"%che%\") OR vtiger_account.siccode LIKE '%che%' OR (vtiger_account.account_type IN (select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::accounttype\" and i18n LIKE \"%che%\") OR vtiger_account.account_type LIKE \"%che%\") OR vtiger_account.annualrevenue LIKE '%che%' OR vtiger_account.emailoptout LIKE '%che%' OR vtiger_account.notify_owner LIKE '%che%' OR vtiger_crmentity.smownerid LIKE '%che%' OR vtiger_crmentity.createdtime LIKE '%che%' OR vtiger_crmentity.modifiedtime LIKE '%che%' OR vtiger_crmentity.modifiedby LIKE '%che%' OR vtiger_accountbillads.bill_street LIKE '%che%' OR vtiger_accountshipads.ship_street LIKE '%che%' OR vtiger_accountbillads.bill_city LIKE '%che%' OR vtiger_accountshipads.ship_city LIKE '%che%' OR vtiger_accountbillads.bill_state LIKE '%che%' OR vtiger_accountshipads.ship_state LIKE '%che%' OR vtiger_accountbillads.bill_code LIKE '%che%' OR vtiger_accountshipads.ship_code LIKE '%che%' OR vtiger_accountbillads.bill_country LIKE '%che%' OR vtiger_accountshipads.ship_country LIKE '%che%' OR vtiger_accountbillads.bill_pobox LIKE '%che%' OR vtiger_accountshipads.ship_pobox LIKE '%che%' OR vtiger_crmentity.description LIKE '%che%' OR vtiger_accountscf.cf_718 LIKE '%che%' OR vtiger_accountscf.cf_719 LIKE '%che%' OR vtiger_accountscf.cf_720 LIKE '%che%' OR vtiger_accountscf.cf_721 LIKE '%che%' OR vtiger_accountscf.cf_722 LIKE '%che%' OR vtiger_accountscf.cf_723 LIKE '%che%' OR vtiger_accountscf.cf_724 LIKE '%che%' OR vtiger_accountscf.cf_725 LIKE '%che%' OR vtiger_accountscf.cf_726 LIKE '%che%' OR vtiger_accountscf.cf_727 LIKE '%che%' OR vtiger_accountscf.cf_728 LIKE '%che%' OR (vtiger_accountscf.cf_729 IN (select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::cf_729\" and i18n LIKE \"%che%\") OR vtiger_accountscf.cf_729 LIKE \"%che%\") OR (vtiger_accountscf.cf_730 IN (select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::cf_730\" and i18n LIKE \"%che%\") OR vtiger_accountscf.cf_730 LIKE \"%che%\") OR (vtiger_accountscf.cf_731 IN (select translation_key from vtiger_cbtranslation where locale=\"en_us\" and forpicklist=\"Accounts::cf_731\" and i18n LIKE \"%che%\") OR vtiger_accountscf.cf_731 LIKE \"%che%\") OR vtiger_accountscf.cf_732 LIKE '%che%' OR vtiger_account.isconvertedfromlead LIKE '%che%' OR vtiger_account.convertedfromlead LIKE '%che%' OR vtiger_crmentity.smcreatorid LIKE '%che%')",
			),
			array(
				'SELECT * FROM vtiger_accounts WHERE accountname like "%t%"',
				'true',
				'and',
				'SELECT * FROM vtiger_accounts WHERE (true) and accountname like "%t%"',
			),
			array(
				'SELECT * FROM vtiger_accounts',
				'true',
				'and',
				'SELECT * FROM vtiger_accounts WHERE true',
			),
			array(
				'SELECT * FROM vtiger_accounts',
				'',
				'and',
				'SELECT * FROM vtiger_accounts',
			),
			array(
				'SELECT  *  FROM  vtiger_accounts  ',
				'   ',
				'and',
				'SELECT * FROM vtiger_accounts ',
			),
			array(
				'SELECT * FROM vtiger_accounts where xx in (select somefield from sometable where thereisanotherwhere=true)',
				'true',
				'and',
				'SELECT * FROM vtiger_accounts WHERE (true) and xx in (select somefield from sometable where thereisanotherwhere=true)',
			),
			array(
				'SELECT * FROM vtiger_accounts where xx in (select somefield from sometable where thereisanotherwhere=true)',
				'anything != 5',
				'or',
				'SELECT * FROM vtiger_accounts WHERE (anything != 5) or xx in (select somefield from sometable where thereisanotherwhere=true)',
			),
		);
	}

	/**
	 * Method testappendConditionClauseToQuery
	 * @test
	 * @dataProvider appendConditionClauseToQueryProvider
	 */
	public function testappendConditionClauseToQuery($query, $condClause, $glue, $expected) {
		$this->assertEquals($expected, appendConditionClauseToQuery($query, $condClause, $glue));
	}
}
