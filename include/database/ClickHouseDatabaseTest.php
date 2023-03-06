<?php
/*************************************************************************************************
 * Copyright 2022 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

include_once 'include/database/ClickHouseDatabase.php';

/*
Tables used by test that need to be added to clickhouse
	vtiger_activitytype
	vtiger_activity_view
	vtiger_contactdetails
	vtiger_account
	marvel
	contactinfo
*/

class ClickHouseDatabaseTest extends TestCase {

	/**
	 * @test
	 */
	public function testObjectType() {
		global $cdb;
		$this->assertInstanceOf('ClickHouseDatabase', $cdb);
	}

	/**
	 * @test
	 * @dataProvider queryProvider
	 */
	public function testConvert2Sql($query, $array) {
		global $cdb;
		$convertedSql = $cdb->convert2Sql($query, $array);
		$expectedSql = "SELECT * FROM vtiger_contactdetails WHERE contactid>1084 AND department='Marketing' LIMIT 5";
		$this->assertEquals($expectedSql, $convertedSql);
	}

	/**
	 * @test
	 */
	public function test_change_key_case() {
		global $cdb;
		$array = array("X"=>"a","Y"=>"b","Z"=>"c");
		$result = $cdb->change_key_case($array);
		$this->assertEquals(array("x"=>"a", "y"=>"b", "z"=>"c"), $result);
	}

	/**
	 * @test
	 * @dataProvider recordProvider
	 */
	public function test_query($expected) {
		global $cdb;
		$sql = "SELECT * FROM vtiger_contactdetails WHERE firstname='Felix' AND lastname='Hirpara'";
		$result = $cdb->query($sql);
		$this->assertEquals($result->fields, $expected);
	}

	/**
	 * @test
	 * @dataProvider chRecordProvider
	 */
	public function test_chquery($expected) {
		global $cdb;
		$sql = 'SELECT * FROM contactinfo order by ctoid';
		$result = $cdb->query($sql);
		$rdo = [];
		$idx = 0;
		while ($row = $cdb->fetch_array($result)) {
			$rdo[$idx++] = $row;
		}
		$this->assertEquals($expected, $rdo);
	}

	/**
	 * @test
	 * @dataProvider recordProvider
	 */
	public function test_limitQuery($expected) {
		global $cdb;
		$sql = 'SELECT * FROM vtiger_contactdetails WHERE accountid=74';
		$this->assertEquals($expected, $cdb->limitQuery($sql, 1, 2)->fields);
	}

	/**
	 * @test
	 */
	public function test_getOne() {
		global $cdb;
		$sql = 'SELECT * FROM vtiger_contactdetails WHERE accountid=74';
		$this->assertEquals(1084, $cdb->getOne($sql));
	}

	/**
	 * @test
	 * @dataProvider queryProvider
	 */
	public function test_pquery($query, $array) {
		global $cdb;
		$result = $cdb->pquery($query, $array);
		$array_result = (array)$result;
		$is_empty = empty($array_result) ? true : false;
		$this->assertFalse($is_empty, 'Result object should not be empty');
	}

	/**
	 * @test
	 * here are the data types that correspond to the TYPE number returned by fetch_field.
		numerics
		-------------
		BIT: 16
		TINYINT: 1
		BOOL: 1
		SMALLINT: 2
		MEDIUMINT: 9
		INTEGER: 3
		BIGINT: 8
		SERIAL: 8
		FLOAT: 4
		DOUBLE: 5
		DECIMAL: 246
		NUMERIC: 246
		FIXED: 246

		dates
		------------
		DATE: 10
		DATETIME: 12
		TIMESTAMP: 7
		TIME: 11
		YEAR: 13

		strings & binary
		------------
		CHAR: 254
		VARCHAR: 253
		ENUM: 254
		SET: 254
		BINARY: 254
		VARBINARY: 253
		TINYBLOB: 252
		BLOB: 252
		MEDIUMBLOB: 252
		TINYTEXT: 252
		TEXT: 252
		MEDIUMTEXT: 252
		LONGTEXT: 252
	 */
	public function test_getFieldsDefinition() {
		global $cdb;
		$result = $cdb->pquery('SELECT * FROM marvel', array());
		$filed_defs = $cdb->getFieldsDefinition($result);
		$expected = array(
			'name' => 'name',
			'type' => 'String',
			'default_type' => '',
			'default_expression' => '',
			'comment' => '',
			'codec_expression' => '',
			'ttl_expression' => '',
		);
		$this->assertEquals($expected, (array)$filed_defs[0]);
	}

	/**
	 * @test
	 */
	public function test_sql_quote() {
		global $cdb;
		$this->assertEquals("'hello'", $cdb->sql_quote('hello'));
		$this->assertEquals("'5'", $cdb->sql_quote(5));
		$this->assertEquals("'0.123'", $cdb->sql_quote(0.123));
	}

	/**
	 * @test
	 * @dataProvider queryProvider
	 */
	public function test_getFieldsArray($query, $array) {
		global $cdb;
		$result = $cdb->pquery($query, $array);
		$expected_array  = array(
			'contactid','contact_no','accountid','salutation','firstname','lastname','email','phone','mobile',
			'title','department','fax','reportsto','training','otheremail','secondaryemail','donotcall','emailoptout',
			'imagename','reference','notify_owner','isconvertedfromlead','convertedfromlead','template_language','portalpasswordtype','portalloginuser',
		);
		$this->assertEquals($expected_array, $cdb->getFieldsArray($result));
	}

	/**
	 * @test
	 * @dataProvider queryProvider
	 */
	public function test_getRowCount($query, $array) {
		global $cdb;
		$result = $cdb->pquery($query, $array);
		$this->assertEquals(5, $cdb->getRowCount($result));
	}

	/**
	 * @test
	 * @dataProvider queryProvider
	 */
	public function test_num_fields($query, $array) {
		global $cdb;
		$result = $cdb->pquery($query, $array);
		$this->assertEquals(26, $cdb->num_fields($result));
	}

	/**
	 * @test
	 * @dataProvider recordProvider
	 */
	public function test_fetch_array($expected) {
		global $cdb;
		$result = $cdb->query('select * from vtiger_contactdetails where contactid=1086');
		$this->assertEquals($expected, $cdb->fetch_array($result));
	}

	/**
	 * @test
	 */
	public function testrowGenerator() {
		global $cdb;
		$rs = $cdb->pquery('select accountid from vtiger_account where accountid in (?,?);', array(74, 75));
		$this->assertEquals(['accountid' => 74], $cdb->rowGenerator($rs)->current());
		$this->assertEquals(['accountid' => 75], $cdb->rowGenerator($rs)->current());
		$this->assertNull($cdb->rowGenerator($rs)->current());
	}

	/**
	 * @test
	 * @dataProvider recordProvider
	 */
	public function test_run_query_record_html($expected) {
		global $cdb;
		$result = $cdb->run_query_record_html('select * from vtiger_contactdetails where contactid=1086');
		$this->assertEquals($expected, $result);
	}

	/**
	 * @test
	 */
	public function test_run_query_field() {
		global $cdb;
		$query = 'select * from vtiger_contactdetails where contactid=1086';
		$this->assertEquals('Felix', $cdb->run_query_field($query, 'firstname'));
		$this->assertEquals('Hirpara', $cdb->run_query_field($query, 'lastname'));
	}

	/**
	 * @test
	 */
	public function test_result_get_next_record() {
		global $cdb;
		$values = $this->rawDataProvider();
		$query = 'SELECT * FROM vtiger_contactdetails WHERE contactid>=1086 ORDER BY contactid LIMIT 2';
		$result = $cdb->pquery($query, []);
		$next_rec = $cdb->result_get_next_record($result);
		$this->assertEquals($values[0][1], $next_rec);
		$next_rec = $cdb->result_get_next_record($result);
		$this->assertEquals($values[1][1], $next_rec);
	}

	/**
	 * @test
	 */
	public function test_sql_expr_datalist() {
		global $cdb;
		$expected = " ( 'a','b','c','d' ) ";
		$result = $cdb->sql_expr_datalist(array('a','b','c','d'));
		$this->assertEquals($expected, $result);
	}

	/**
	 * @test
	 */
	public function test_sql_concat() {
		global $cdb;
		$list = array('a','b','c','d');
		$expected = "concat(a,b,c,d)";
		$result = $cdb->sql_concat($list);
		$this->assertEquals($expected, $result);
	}

	/**
	 * @test
	 */
	public function test_sql_insert_data() {
		global $cdb;
		$table = 'contactdetails';
		$data =array(
			"firstname" => "John",
			"lastname"  => "Murphy",
		);

		$query = $cdb->sql_insert_data($table, $data);
		$expected_query = "INSERT INTO contactdetails (firstname,lastname) VALUES ('John','Murphy')";

		$this->assertEquals($expected_query, $query);
	}

	/**
	 * @test
	 * @dataProvider recordProvider
	 */
	public function test_run_query_record($expected) {
		global $cdb;
		$query = 'select * from vtiger_contactdetails where contactid=1086';
		$result = $cdb->run_query_record($query);
		$this->assertEquals($expected, $result);
		$all_records = $cdb->run_query_allrecords($query);
		$this->assertEquals($expected, $all_records[0]);
	}

	/**
	 * @test
	 * @dataProvider resultDataProvider
	 */
	public function test_query_result($row, $col, $expected_val, $result) {
		global $cdb;
		$this->assertEquals($expected_val, $cdb->query_result($result, $row, $col));
	}

	/**
	 * @test
	 * @dataProvider recordProvider
	 */
	public function test_query_result_rowdata($expected) {
		global $cdb;
		$result = $cdb->query('select * from vtiger_contactdetails where contactid=1086');
		$this->assertEquals($expected, $cdb->query_result_rowdata($result, 0));
	}

	/**
	 * @test
	 * @dataProvider resultsDataProvider
	 */
	public function test_fetchByAssoc($needle, $array, $result) {
		global $cdb;
		$this->assertEquals($array, $cdb->fetchByAssoc($result, $needle));
	}

	/**
	 * @test
	 * @dataProvider rawDataProvider
	 */
	public function test_getNextRow($count, $record) {
		global $cdb;
		$query = 'SELECT * FROM vtiger_contactdetails WHERE contactid>=1086 ORDER BY contactid LIMIT 5';
		$result = $cdb->pquery($query, []);
		$cdb->raw_query_result_rowdata($result, 0);
		$next_row = $cdb->getNextRow($result);
		if ($count == 1) {
			$this->assertEquals($record, $next_row);
		} else {
			$this->assertTrue(true);
		}
	}

	/**
	 * @test
	 */
	public function test_field_name() {
		global $cdb;
		$result = $cdb->pquery('select * from vtiger_contactdetails limit 1', []);
		$field = $cdb->field_name($result, 1);
		$expected = array(
			'name' => 'contact_no',
			'type' => 'String',
			'default_type' => '',
			'default_expression' => '',
			'comment' => '',
			'codec_expression' => '',
			'ttl_expression' => '',
		);
		$this->assertEquals($expected, (array)$field);
	}

	/**
	 * @test
	 */
	public function test_formatDate() {
		global $cdb;
		$this->assertEquals("'2016-12-15'", $cdb->formatDate('2016-12-15'));
	}

	/**
	 * @test
	 */
	public function test_getDBDateString() {
		global $cdb;
		$this->assertEquals("DATE_FORMAT(test,'%Y-%m-%d, %H:%i:%s')", $cdb->getDBDateString('test'));
	}

	/**
	 * @test
	 * @dataProvider rawDataProvider
	 */
	public function test_raw_query_result_rowdata($needle, $array) {
		global $cdb;
		$query = 'SELECT * FROM vtiger_contactdetails WHERE contactid>=1086 ORDER BY contactid LIMIT 5';
		$result = $cdb->pquery($query, []);
		$this->assertEquals($array, $cdb->raw_query_result_rowdata($result, $needle));
	}

	/**
	 * @test
	 */
	public function test_requireSingleResult() {
		global $cdb;
		$result = $cdb->requireSingleResult('SELECT 1 FROM vtiger_contactdetails WHERE contactid=1086');
		$this->assertEquals(1, $cdb->getRowCount($result));
		$result = $cdb->requireSingleResult('SELECT 1 FROM vtiger_contactdetails');
		$this->assertEquals('', $result);
	}

	/**
	 * @test
	 * @dataProvider tablesProvider
	 */
	public function test_getColumnNames($table_name, $table_cols) {
		global $cdb;
		$this->assertEquals($table_cols, $cdb->getColumnNames($table_name));
	}

	/**
	 * @test
	 * @dataProvider metaProvider
	 */
	public function test_getMetaColumns($table_name, $table_cols) {
		global $cdb;
		$this->assertEquals($table_cols, $cdb->getMetaColumns($table_name));
	}

	/**
	 * @test
	 */
	public function test_sql_escape_string() {
		global $cdb;
		global $cdb;
		$this->assertEquals('normal string', $cdb->sql_escape_string('normal string'), 'normal string');
		$this->assertEquals("\' OR \'\'=\'", $cdb->sql_escape_string("' OR ''='"));
		$this->assertEquals(
			"Alicia\'; DROP TABLE usuarios; SELECT * FROM datos WHERE nombre LIKE \'%",
			$cdb->sql_escape_string("Alicia'; DROP TABLE usuarios; SELECT * FROM datos WHERE nombre LIKE '%"),
			'SQL Injection'
		);
		$this->assertEquals('', $cdb->sql_escape_string(''), 'empty string');
		$this->assertEquals('', $cdb->sql_escape_string(false), 'false');
		$this->assertEquals(1, $cdb->sql_escape_string(true), 'true');
		$this->assertEquals(0, $cdb->sql_escape_string(0), 'zero');
		$this->assertEquals(1, $cdb->sql_escape_string(1), 'one');
		$this->assertEquals(123, $cdb->sql_escape_string(123), 'number');
		$this->assertEquals(123.456, $cdb->sql_escape_string(123.456), 'decimal');
		$this->assertEquals('NULL', $cdb->sql_escape_string(null), 'Null');
	}

	/**
	 * @test
	 */
	public function test_CreateTable() {
		global $cdb;
		$cdb->write('DROP TABLE IF EXISTS vtiger_tmp;');
		if (empty($cdb->getColumnNames('vtiger_tmp'))) {
			$rdo = $cdb->CreateTable('vtiger_tmp', 'id Int32, name VARCHAR(100), email VARCHAR(100), type VARCHAR(7)');
			$this->assertFalse($rdo->error());
			$cdb->alterTable('vtiger_tmp', 'surname VARCHAR(100)', 'Add_Column');
			$expected_fields = array('id','name','email','type','surname');
			$this->assertEquals($expected_fields, $cdb->getColumnNames('vtiger_tmp'));
			$cdb->alterTable('vtiger_tmp', 'surname', 'Delete_Column');
			$expected_fields = array('id','name','email','type');
			$this->assertEquals($expected_fields, $cdb->getColumnNames('vtiger_tmp'));
		}
		$cdb->write('DROP TABLE IF EXISTS vtiger_tmp;');
	}

	/**
	 * @test
	 */
	public function test_escapeDbName() {
		global $cdb;
		$expected = '`database1`';
		$dbname = $cdb->escapeDbName('database1');
		$this->assertEquals($expected, $dbname);
	}

	/**
	 * @test
	 */
	public function test_toggleCache() {
		global $cdb;
		$cdb->toggleCache(true);
		$cache = $cdb->getCacheInstance();
		$this->assertFalse($cache);
	}

	/*********************************************************************
		DATA PROVIDERS
	**********************************************************************/

	public function chRecordProvider() {
		return array(
			array(array(
				array('ctoid' => 1, 'age' => 23, 'firstn' => 'M', 'lastn' => 'S'),
				array('ctoid' => 2, 'age' => 32, 'firstn' => 'S', 'lastn' => 'M'),
				array('ctoid' => 3, 'age' => 33, 'firstn' => 'A', 'lastn' => 'S'),
			)),
		);
	}

	public function recordProvider() {
		return array(
			array(
				array(
					'contactid' => '1086',
					'contact_no' => 'CON3',
					'accountid' => '74',
					'salutation' => '--None--',
					'firstname' => 'Felix',
					'lastname' => 'Hirpara',
					'email' => 'felix_hirpara@cox.net',
					'phone' => '717-491-5643',
					'mobile' => '717-583-1497',
					'title' => 'Owner',
					'department' => 'Marketing',
					'fax' => '',
					'reportsto' => '1971',
					'training' => '',
					'otheremail' => '',
					'secondaryemail' => '',
					'donotcall' => '0',
					'emailoptout' => '0',
					'imagename' => '',
					'reference' => '0',
					'notify_owner' => '0',
					'isconvertedfromlead' => '',
					'convertedfromlead' => 0,
					'template_language' => '',
					'portalpasswordtype' => '',
					'portalloginuser' => 0,
				),
			),
		);
	}

	// Test random fields returned by Query result
	public function resultDataProvider() {
		global $cdb;
		$query = 'SELECT * FROM vtiger_contactdetails WHERE contactid in (1086,1104,1115,1117,1121) ORDER BY contactid';
		$result = $cdb->pquery($query, []);
		return array(
			array(0, 0, '1086', $result),
			array(0, 1, 'CON3', $result),
			array(1, 4, 'Amber', $result),
			array(2, 4, 'Eva', $result),
			array(3, 4, 'Adolph', $result),
			array(4, 5, 'Besong', $result),
		);
	}

	public function rawDataProvider() {
		return array(
			array(0,
				array(
					'contactid' => '1086',
					'contact_no' => 'CON3',
					'accountid' => '74',
					'salutation' => '--None--',
					'firstname' => 'Felix',
					'lastname' => 'Hirpara',
					'email' => 'felix_hirpara@cox.net',
					'phone' => '717-491-5643',
					'mobile' => '717-583-1497',
					'title' => 'Owner',
					'department' => 'Marketing',
					'fax' => '',
					'reportsto' => '1971',
					'training' => '',
					'otheremail' => '',
					'secondaryemail' => '',
					'donotcall' => '0',
					'emailoptout' => '0',
					'imagename' => '',
					'reference' => '0',
					'notify_owner' => '0',
					'isconvertedfromlead' => null,
					'convertedfromlead' => null,
					'template_language' => null,
					'portalpasswordtype' => null,
					'portalloginuser' => null,
				)
			),
			array(1,
				array(
					'contactid' => 1087,
					'contact_no' => 'CON4',
					'accountid' => 75,
					'salutation' => '',
					'firstname' => 'Lino',
					'lastname' => "Sut'ulovich",
					'email' => 'lino.sutulovich@gmail.com',
					'phone' => '01316-590173',
					'mobile' => '01980-890046',
					'title' => 'Director',
					'department' => 'Finance',
					'fax' => '',
					'reportsto' => 0,
					'training' => '',
					'otheremail' => '',
					'secondaryemail' => '',
					'donotcall' => '0',
					'emailoptout' => '0',
					'imagename' => '',
					'reference' => '0',
					'notify_owner' => '0',
					'isconvertedfromlead' => '',
					'convertedfromlead' => 0,
					'template_language' => '',
					'portalpasswordtype' => '',
					'portalloginuser' => 0,
				),
			),
		);
	}

	public function resultsDataProvider() {
		global $cdb;
		$query = 'SELECT * FROM vtiger_contactdetails WHERE contactid in (1086,1104,1115,1117,1121) ORDER BY contactid';
		$result = $cdb->pquery($query, []);
		return array(
			array(0,
				array(
					'contactid' => 1086,
					'contact_no' => 'CON3',
					'accountid' => 74,
					'salutation' => '--None--',
					'firstname' => 'Felix',
					'lastname' => 'Hirpara',
					'email' => 'felix_hirpara@cox.net',
					'phone' => '717-491-5643',
					'mobile' => '717-583-1497',
					'title' => 'Owner',
					'department' => 'Marketing',
					'fax' => '',
					'reportsto' => 1971,
					'training' => '',
					'otheremail' => '',
					'secondaryemail' => '',
					'donotcall' => '0',
					'emailoptout' => '0',
					'imagename' => '',
					'reference' => '0',
					'notify_owner' => '0',
					'isconvertedfromlead' => '',
					'convertedfromlead' => 0,
					'template_language' => '',
					'portalpasswordtype' => '',
					'portalloginuser' => 0,
				),
				$result
			),
			array(1,
				array(
					'contactid' => 1104,
					'contact_no' => 'CON19',
					'accountid' => 1103,
					'salutation' => '',
					'firstname' => 'Amber',
					'lastname' => 'Windell',
					'email' => 'amber.windell@cox.net',
					'phone' => '604-864-2113',
					'mobile' => '604-902-5812',
					'title' => 'Owner',
					'department' => 'Marketing',
					'fax' => '',
					'reportsto' => 0,
					'training' => '',
					'otheremail' => '',
					'secondaryemail' => '',
					'donotcall' => '0',
					'emailoptout' => '0',
					'imagename' => '',
					'reference' => '0',
					'notify_owner' => '0',
					'isconvertedfromlead' => '',
					'convertedfromlead' => 0,
					'template_language' => '',
					'portalpasswordtype' => '',
					'portalloginuser' => 0,
				),
				$result
			),
			array(2,
				array(
					'contactid' => 1115,
					'contact_no' => 'CON27',
					'accountid' => 1114,
					'salutation' => '',
					'firstname' => 'Eva',
					'lastname' => 'Joulwan',
					'email' => 'eva.joulwan@gmail.com',
					'phone' => '01779-720349',
					'mobile' => '01961-802899',
					'title' => 'VP Supply Chain',
					'department' => 'Marketing',
					'fax' => '',
					'reportsto' => 1658,
					'training' => '',
					'otheremail' => '',
					'secondaryemail' => '',
					'donotcall' => '0',
					'emailoptout' => '0',
					'imagename' => '',
					'reference' => '0',
					'notify_owner' => '0',
					'isconvertedfromlead' => '',
					'convertedfromlead' => 0,
					'template_language' => '',
					'portalpasswordtype' => '',
					'portalloginuser' => 0,
				),
				$result
			),
			array(3,
				array(
					'contactid' => 1117,
					'contact_no' => 'CON29',
					'accountid' => 102,
					'salutation' => '',
					'firstname' => 'Adolph',
					'lastname' => 'Krivanec',
					'email' => 'akrivanec@hotmail.com',
					'phone' => '416-736-1436',
					'mobile' => '416-293-9664',
					'title' => 'Managing Director',
					'department' => 'Marketing',
					'fax' => '',
					'reportsto' => 0,
					'training' => '',
					'otheremail' => '',
					'secondaryemail' => '',
					'donotcall' => '1',
					'emailoptout' => '0',
					'imagename' => '',
					'reference' => '0',
					'notify_owner' => '0',
					'isconvertedfromlead' => '',
					'convertedfromlead' => 0,
					'template_language' => '',
					'portalpasswordtype' => '',
					'portalloginuser' => 0,
				),
				$result
			),
			array(4,
				array(
					'contactid' => 1121,
					'contact_no' => 'CON33',
					'accountid' => 106,
					'salutation' => '',
					'firstname' => 'Chantell',
					'lastname' => 'Besong',
					'email' => 'chantell_besong@gmail.com',
					'phone' => '01607-329400',
					'mobile' => '01218-142767',
					'title' => 'Finance Manager',
					'department' => 'Marketing',
					'fax' => '',
					'reportsto' => 0,
					'training' => '',
					'otheremail' => '',
					'secondaryemail' => '',
					'donotcall' => '1',
					'emailoptout' => '1',
					'imagename' => '',
					'reference' => '0',
					'notify_owner' => '0',
					'isconvertedfromlead' => '',
					'convertedfromlead' => 0,
					'template_language' => '',
					'portalpasswordtype' => '',
					'portalloginuser' => 0,
				),
				$result
			)
		);
	}

	/**
	 * This function returns a sample query and an array of parameters for further testing
	 */
	public function queryProvider() {
		$query = 'SELECT * FROM vtiger_contactdetails WHERE contactid>? AND department=? LIMIT 5';
		$id= 1084;
		$department = 'Marketing';
		$array = [
			array($query,array($id,$department))
		];
		return $array;
	}

	public function tablesProvider() {
		return array(
			array('vtiger_activitytype',
				array(
					0 => 'activitytypeid',
					1 => 'activitytype',
					2 => 'presence',
					3 => 'picklist_valueid',
				)
			),
			array('vtiger_activity_view',
				array(
					0 => 'activity_viewid',
					1 => 'activity_view',
					2 => 'sortorderid',
					3 => 'presence',
				)
			),
		);
	}

	public function metaProvider() {
		$at = array();
		$af = new ADOFieldObject();
		$af->name = 'activitytypeid';
		$af->max_length = -1;
		$af->type = 'Int32';
		$af->scale = null;
		$af->not_null = true;
		$af->primary_key = false;
		$af->auto_increment = false;
		$af->binary = false;
		$af->unsigned = false;
		$af->zerofill = false;
		$af->has_default = false;
		$af->default_type = '';
		$af->default_expression = '';
		$af->comment = '';
		$af->codec_expression = '';
		$af->ttl_expression = '';
		$at['activitytypeid'] = $af;
		$af = new ADOFieldObject();
		$af->name = 'activitytype';
		$af->max_length = 200;
		$af->type = 'String';
		$af->scale = null;
		$af->not_null = true;
		$af->primary_key = false;
		$af->auto_increment = false;
		$af->binary = false;
		$af->unsigned = false;
		$af->zerofill = false;
		$af->has_default = false;
		$af->default_type = '';
		$af->default_expression = '';
		$af->comment = '';
		$af->codec_expression = '';
		$af->ttl_expression = '';
		$at['activitytype'] = $af;
		$af = new ADOFieldObject();
		$af->name = 'presence';
		$af->max_length = -1;
		$af->type = 'Int32';
		$af->scale = null;
		$af->not_null = true;
		$af->primary_key = false;
		$af->auto_increment = false;
		$af->binary = false;
		$af->unsigned = false;
		$af->zerofill = false;
		$af->has_default = false;
		$af->default_type = '';
		$af->default_expression = '';
		$af->comment = '';
		$af->codec_expression = '';
		$af->ttl_expression = '';
		$at['presence'] = $af;
		$af = new ADOFieldObject();
		$af->name = 'picklist_valueid';
		$af->max_length = -1;
		$af->type = 'Int32';
		$af->scale = null;
		$af->not_null = true;
		$af->primary_key = false;
		$af->auto_increment = false;
		$af->binary = false;
		$af->unsigned = false;
		$af->zerofill = false;
		$af->has_default = false;
		$af->default_type = '';
		$af->default_expression = '';
		$af->comment = '';
		$af->codec_expression = '';
		$af->ttl_expression = '';
		$at['picklist_valueid'] = $af;
		$af = new ADOFieldObject();
		$av = array();
		$af->name = 'activity_viewid';
		$af->max_length = -1;
		$af->type = 'Int32';
		$af->scale = null;
		$af->not_null = true;
		$af->primary_key = false;
		$af->auto_increment = false;
		$af->binary = false;
		$af->unsigned = false;
		$af->zerofill = false;
		$af->has_default = false;
		$af->default_type = '';
		$af->default_expression = '';
		$af->comment = '';
		$af->codec_expression = '';
		$af->ttl_expression = '';
		$av['activity_viewid'] = $af;
		$af = new ADOFieldObject();
		$af->name = 'activity_view';
		$af->max_length = 200;
		$af->type = 'String';
		$af->scale = null;
		$af->not_null = true;
		$af->primary_key = false;
		$af->auto_increment = false;
		$af->binary = false;
		$af->unsigned = false;
		$af->zerofill = false;
		$af->has_default = false;
		$af->default_type = '';
		$af->default_expression = '';
		$af->comment = '';
		$af->codec_expression = '';
		$af->ttl_expression = '';
		$av['activity_view'] = $af;
		$af = new ADOFieldObject();
		$af->name = 'presence';
		$af->max_length = -1;
		$af->type = 'Int32';
		$af->scale = null;
		$af->not_null = true;
		$af->primary_key = false;
		$af->auto_increment = false;
		$af->binary = false;
		$af->unsigned = false;
		$af->zerofill = false;
		$af->has_default = false;
		$af->default_type = '';
		$af->default_expression = '';
		$af->comment = '';
		$af->codec_expression = '';
		$af->ttl_expression = '';
		$av['presence'] = $af;
		$af = new ADOFieldObject();
		$af->name = 'sortorderid';
		$af->max_length = -1;
		$af->type = 'Int32';
		$af->scale = null;
		$af->not_null = true;
		$af->primary_key = false;
		$af->auto_increment = false;
		$af->binary = false;
		$af->unsigned = false;
		$af->zerofill = false;
		$af->has_default = false;
		$af->default_type = '';
		$af->default_expression = '';
		$af->comment = '';
		$af->codec_expression = '';
		$af->ttl_expression = '';
		$av['sortorderid'] = $af;
		$au = array();
		$af = new ADOFieldObject();
		$af->name = 'auditid';
		$af->max_length = -1;
		$af->type = 'Int32';
		$af->scale = null;
		$af->not_null = true;
		$af->primary_key = true;
		$af->auto_increment = false;
		$af->binary = false;
		$af->unsigned = false;
		$af->zerofill = false;
		$af->has_default = false;
		$af->default_type = '';
		$af->default_expression = '';
		$af->comment = '';
		$af->codec_expression = '';
		$af->ttl_expression = '';
		$au['auditid'] = $af;
		$af = new ADOFieldObject();
		$af->name = 'userid';
		$af->max_length = -1;
		$af->type = 'Int32';
		$af->scale = null;
		$af->not_null = true;
		$af->primary_key = false;
		$af->auto_increment = false;
		$af->binary = false;
		$af->unsigned = false;
		$af->zerofill = false;
		$af->has_default = false;
		$af->default_type = '';
		$af->default_expression = '';
		$af->comment = '';
		$af->codec_expression = '';
		$af->ttl_expression = '';
		$au['userid'] = $af;
		$af = new ADOFieldObject();
		$af->name = 'module';
		$af->max_length = 200;
		$af->type = 'String';
		$af->scale = null;
		$af->not_null = true;
		$af->primary_key = false;
		$af->auto_increment = false;
		$af->binary = false;
		$af->unsigned = false;
		$af->zerofill = false;
		$af->has_default = false;
		$af->default_type = '';
		$af->default_expression = '';
		$af->comment = '';
		$af->codec_expression = '';
		$af->ttl_expression = '';
		$au['module'] = $af;
		$af = new ADOFieldObject();
		$af->name = 'action';
		$af->max_length = 200;
		$af->type = 'String';
		$af->scale = null;
		$af->not_null = true;
		$af->primary_key = false;
		$af->auto_increment = false;
		$af->binary = false;
		$af->unsigned = false;
		$af->zerofill = false;
		$af->has_default = false;
		$af->default_type = '';
		$af->default_expression = '';
		$af->comment = '';
		$af->codec_expression = '';
		$af->ttl_expression = '';
		$au['action'] = $af;
		$af = new ADOFieldObject();
		$af->name = 'recordid';
		$af->max_length = 200;
		$af->type = 'String';
		$af->scale = null;
		$af->not_null = true;
		$af->primary_key = false;
		$af->auto_increment = false;
		$af->binary = false;
		$af->unsigned = false;
		$af->zerofill = false;
		$af->has_default = false;
		$af->default_type = '';
		$af->default_expression = '';
		$af->comment = '';
		$af->codec_expression = '';
		$af->ttl_expression = '';
		$au['recordid'] = $af;
		$af = new ADOFieldObject();
		$af->name = 'actiondate';
		$af->max_length = -1;
		$af->type = 'DateTime';
		$af->scale = null;
		$af->not_null = true;
		$af->primary_key = false;
		$af->auto_increment = false;
		$af->binary = false;
		$af->unsigned = false;
		$af->zerofill = false;
		$af->has_default = false;
		$af->default_type = '';
		$af->default_expression = '';
		$af->comment = '';
		$af->codec_expression = '';
		$af->ttl_expression = '';
		$au['actiondate'] = $af;
		return array(
			array('vtiger_audit_trial', $au),
			array('vtiger_activitytype', $at),
			array('vtiger_activity_view', $av),
		);
	}
}
?>
