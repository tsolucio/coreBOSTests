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

use PHPUnit\Framework\TestCase;
class PearDatabaseTest extends TestCase
{
	public function testObjectType() {
		global $adb;
		$this->assertInstanceOf('PearDatabase', $adb);
		return $adb;
	}

	/**
	 *	This function returns a samle query and an aray of parametersfor further testing
	 */
	public function testqueryProvider() {

		$query = "SELECT * FROM vtiger_contactdetails WHERE contactid>? AND department=? LIMIT 5";
		$id= 1084;
		$department = 'Marketing';
		$array = array($query,array($id,$department));

		$this->assertTrue(true);
		return $array;
	}

	/**
	 * @depends testObjectType
	 * @depends testqueryProvider
	 */
	public function testConvert2Sql($adb,$array) {

		$convertedSql = $adb->convert2Sql($array[0],$array[1]);
		$expectedSql = "SELECT * FROM vtiger_contactdetails WHERE contactid>1084 AND department='Marketing' LIMIT 5";
		$this->assertEquals($expectedSql,$convertedSql);
		return $convertedSql;
	}

	/**
	 * @depends testObjectType
	 */
	public function test_change_key_case($adb) {
		$array = array("X"=>"a","Y"=>"b","Z"=>"c");
		$result = $adb->change_key_case($array);
		$this->assertEquals(array("x"=>"a","y"=>"b","z"=>"c"),$result);
	}

	/**
	 * @dataProvider recordProvider
	 * @depends testObjectType
	 */
	public function test_query($expected,$adb) {
		$sql = "SELECT * FROM vtiger_contactdetails WHERE firstname='Felix' AND lastname='Hirpara'";
		$result = $adb->query($sql);
		$this->assertEquals($result->fields,$expected);
	}

	/**
	 * @dataProvider recordProvider
	 * @depends testObjectType
	 */
	public function test_limitQuery($expected,$adb) {
		$sql = "SELECT * FROM vtiger_contactdetails WHERE accountid=74";
		$this->assertEquals($expected,$adb->limitQuery($sql,1,2)->fields);
	}

	/**
	 * @depends testObjectType
	 */
	public function test_getOne($adb) {
		$sql = "SELECT * FROM vtiger_contactdetails WHERE accountid=74";
		$this->assertEquals(1084,$adb->getOne($sql));
	}

	/**
	 * @depends testObjectType
	 * @depends testqueryProvider
	 */
	public function test_pquery($adb,$array) {

		$result = $adb->pquery( $array[0],$array[1] );

		$array_result = (array)$result;
		$is_empty = ( empty($array_result) )?true:false;

		$this->assertFalse($is_empty,"Result object should not be empty");

		return $result;
	}

	/**
	 * @depends testObjectType
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
	public function test_getFieldsDefinition($adb) {
		$sql = "SELECT * FROM marvel";
		$result = $adb->pquery($sql,array());
		$filed_defs = $adb->getFieldsDefinition($result);
		$expected = array(
			'name' => 'name',
			'table' => 'marvel',
			'def' => '',
			'max_length' => 54,
			'not_null' => 1,
			'primary_key' => 0,
			'type' => 253,
			'unsigned' => 0,
			'binary' => 0,
			'orgname' => 'name',
			'orgtable' => 'marvel',
			'db' => $filed_defs[0]->db,
			'catalog' => 'def',
			'length' => 600,
			'charsetnr' => 33,
			'flags' => 4097,
			'decimals' => 0,
			'auto_increment' => 0,
		);
		$this->assertEquals($expected,(array)$filed_defs[0]);
	}

	/**
	 * @depends testObjectType
	 */
	public function test_sql_quote($adb) {
		$this->assertEquals("'hello'",$adb->sql_quote("hello"));
		$this->assertEquals("'5'",$adb->sql_quote(5));
		$this->assertEquals("'0.123'",$adb->sql_quote(0.123));
	}

	/**
	 * @depends testObjectType
	 * @depends test_pquery
	 */
	public function test_getFieldsArray($adb,$result) {
		$fields_array = $adb->getFieldsArray($result);
		$expected_array  = array('contactid','contact_no','accountid','salutation','firstname','lastname','email','phone','mobile',
								  'title','department','fax','reportsto','training','otheremail','secondaryemail','donotcall','emailoptout',
								  'imagename','reference','notify_owner','isconvertedfromlead','convertedfromlead');
		$this->assertEquals($expected_array,$fields_array);
	}

	/**
	 * @depends testObjectType
	 * @depends test_pquery
	 */
	public function test_getRowCount($adb,$result) {
		$num_rows = $adb->getRowCount($result);
		$this->assertEquals(5,$num_rows);
	}

	/**
	 * @depends testObjectType
	 * @depends test_pquery
	 */
	public function test_num_fields($adb,$result) {
		$num_fields = $adb->num_fields($result);
		$this->assertEquals(23,$num_fields);
	}

	/**
	 * @dataProvider recordProvider
	 * @depends testObjectType
	 * @depends test_pquery
	 */
	public function test_fetch_array($expected,$adb,$result) {
		$res = $adb->fetch_array($result);
		$this->assertEquals($expected,$res);
	}

	/**
	 * @dataProvider recordProvider
	 * @depends testObjectType
	 * @depends testConvert2Sql
	 */
	public function test_run_query_record_html($expected,$adb,$query) {
		$result = $adb->run_query_record_html($query);
		$this->assertEquals($expected,$result);
	}

	/**
	 * @depends testConvert2Sql
	 * @depends testObjectType
	 */
	public function test_run_query_field($query,$adb) {
		$this->assertEquals('Felix',$adb->run_query_field($query,'firstname'));
		$this->assertEquals('Hirpara',$adb->run_query_field($query,'lastname'));
	}

	/**
	 * @dataProvider rawDataProvider
	 * @depends testObjectType
	 * @depends test_pquery
	 */
	public function test_result_get_next_record($count,$record,$adb,$result) {
		$next_rec = $adb->result_get_next_record($result);
		if ($count == 2) {
			$this->assertEquals($record,$next_rec);
		} else {
			$this->assertTrue(true);
		}
	}

	/**
	 * @depends testObjectType
	 */
	public function test_sql_expr_datalist($adb) {
		$expected = " ( 'a','b','c','d' ) ";
		$result = $adb->sql_expr_datalist(array('a','b','c','d'));
		$this->assertEquals($expected,$result);
	}

	/**
	 * @depends testObjectType
	 */
	public function test_sql_concat($adb) {
		$list = array('a','b','c','d');
		$expected = "concat(a,b,c,d)";
		$result = $adb->sql_concat($list);
		$this->assertEquals($expected,$result);
	}

	/**
	 * @depends testObjectType
	 */
	public function test_sql_insert_data($adb) {
		$table = 'contactdetails';
		$data =array(
			"firstname" => "John",
			"lastname"  => "Murphy",
		);

		$query = $adb->sql_insert_data($table,$data);
		$expected_query = "INSERT INTO contactdetails (firstname,lastname) VALUES ('John','Murphy')";

		$this->assertEquals($expected_query,$query);
	}

	/**
	 * @dataProvider recordProvider
	 * @depends testObjectType
	 * @depends testConvert2Sql
	 */
	public function test_run_query_record($expected,$adb,$query) {

		$result = $adb->run_query_record($query);
		$this->assertEquals($expected,$result);

		$all_records = $adb->run_query_allrecords($query);
		$this->assertEquals($expected,$all_records[0]);
	}

	/**
	 * @dataProvider resultDataProvider
	 * @depends testObjectType
	 * @depends test_pquery
	 */
	public function test_query_result($row,$col,$expected_val,$adb,$result) {
		$this->assertEquals( $expected_val, $adb->query_result($result,$row,$col) );
	}

	/**
	 * @dataProvider recordProvider
	 * @depends testObjectType
	 * @depends test_pquery
	 */
	public function test_query_result_rowdata($expected,$adb,$result) {
		$row = $adb->query_result_rowdata($result,0);
		$this->assertEquals($expected,$row);
	}

	/**
	 * @dataProvider resultsDataProvider
	 * @depends testObjectType
	 * @depends test_pquery
	 */
	public function test_fetchByAssoc($needle,$array,$adb,$result) {
		$this->assertEquals($array,$adb->fetchByAssoc($result,$needle) );
	}

	/**
	 * @dataProvider rawDataProvider
	 * @depends test_pquery
	 * @depends testObjectType
	 */
	public function test_getNextRow($count,$record,$result,$adb) {
		$data = $adb->raw_query_result_rowdata($result,0);
		$next_row = $adb->getNextRow($result);
		if ($count == 1) {
			$this->assertEquals($record,$next_row);
		} else {
			$this->assertTrue(true);
		}
	}

	/**
	 * @depends test_pquery
	 * @depends testObjectType
	 */
	public function test_field_name($result,$adb) {
		$field = $adb->field_name($result,1);
		$expected = array(
			'name' => 'contact_no',
			'table' => 'vtiger_contactdetails',
			'def' => '',
			'max_length' => 5,
			'type' => 253,
			'unsigned' => 0,
			'not_null' => 1,
			'primary_key' => 0,
			'binary' => 0,
			'length' => 300,
			'orgname' => 'contact_no',
			'orgtable' => 'vtiger_contactdetails',
			'db' => $field->db,
			'catalog' => 'def',
			'charsetnr' => 33,
			'flags' => 4097,
			'decimals' => 0,
			'auto_increment' => 0,
		);
		$this->assertEquals($expected,(array)$field);
	}

	/**
	 * @depends testObjectType
	 */
	public function test_formatDate($adb) {
		$expected = "'2016-12-15'";
		$formated_date = $adb->formatDate("2016-12-15");
		$this->assertEquals($expected,$formated_date);
	}

	/**
	 * @depends testObjectType
	 */
	public function test_getDBDateString($adb) {
		$result = $adb->getDBDateString("test");
		$expected = "DATE_FORMAT(test,'%Y-%m-%d, %H:%i:%s')";
		$this->assertEquals($expected,$result);
	}

	/**
	 * @dataProvider rawDataProvider
	 * @depends testObjectType
	 * @depends test_pquery
	 */
	public function test_raw_query_result_rowdata($needle,$array,$adb,$result) {
		$this->assertEquals($array,$adb->raw_query_result_rowdata($result,$needle) );
	}

	/**
	 * @depends testObjectType
	 * @depends test_pquery
	 */
	public function test_getAffectedRowCount($adb,$result) {
		$this->assertEquals(5,$adb->getAffectedRowCount($result) );
	}

	/**
	 * @dataProvider recordProvider
	 * @depends testObjectType
	 */
	public function test_requireSingleResult($expected,$adb) {
		$result = $adb->requireSingleResult("SELECT * FROM vtiger_contactdetails WHERE firstname='Felix'");
		$this->assertEquals($expected,$result->fields);
	}

	/**
	 * @dataProvider tablesProvider
	 * @depends testObjectType
	 */
	public function test_getColumnNames($table_name,$table_cols,$adb) {
		$this->assertEquals($table_cols,$adb->getColumnNames($table_name) );
	}

	/**
	 * @depends testObjectType
	 */
	public function test_sql_escape_string($adb) {
		$this->assertEquals('normal string',$adb->sql_escape_string('normal string'),'normal string');
		$this->assertEquals("\' OR \'\'=\'",$adb->sql_escape_string("' OR ''='") );
		$this->assertEquals("Alicia\'; DROP TABLE usuarios; SELECT * FROM datos WHERE nombre LIKE \'%",$adb->sql_escape_string("Alicia'; DROP TABLE usuarios; SELECT * FROM datos WHERE nombre LIKE '%"),'SQL Injection');
		$this->assertEquals('',$adb->sql_escape_string(''),'empty string');
		$this->assertEquals('',$adb->sql_escape_string(false),'false');
		$this->assertEquals(1,$adb->sql_escape_string(true),'true');
		$this->assertEquals(0,$adb->sql_escape_string(0),'zero');
		$this->assertEquals(1,$adb->sql_escape_string(1),'one');
		$this->assertEquals(123,$adb->sql_escape_string(123),'number');
		$this->assertEquals(123.456,$adb->sql_escape_string(123.456),'decimal');
		$this->assertEquals('NULL',$adb->sql_escape_string(null),'Null');
	}

	/**
	 * @depends testObjectType
	 */
	public function test_CreteTable($adb) {
		$adb->query('DROP TABLE vtiger_tmp;');
		if (empty($adb->getColumnNames('vtiger_tmp'))) {
			$this->assertEquals(2, $adb->CreateTable('vtiger_tmp','id INTEGER, name VARCHAR(100), email VARCHAR(100), type VARCHAR(7)'));
		}
	}

	/**
	 * @depends testObjectType
	 */
	public function test_alterTable($adb) {
		$adb->alterTable("vtiger_tmp", "surname VARCHAR(100)", "Add_Column");
		$expected_fields = array("id","name","email","type","surname");
		$this->assertEquals($expected_fields,$adb->getColumnNames("vtiger_tmp"));
	}

	/**
	 * @depends testObjectType
	 */
	public function test_escapeDbName($adb) {
		$expected = "`database1`";
		$dbname = $adb->escapeDbName("database1");
		$this->assertEquals($expected,$dbname);
	}

	/**
	 * @depends testObjectType
	 */
	public function test_toggleCache($adb) {
		$adb->toggleCache(true);
		$cache = $adb->getCacheInstance();
		$this->assertFalse($cache);
	}

	/**
	 * @depends testObjectType
	 * @depends test_pquery
	 * @depends testConvert2Sql
	 */
// 	public function test_cacheInstance($adb,$result,$sql) {
// 		$cache = new PearDatabaseCache($adb);
// 		$cache->cacheResult($result,$sql);
// 		var_dump($cache);
// 	}

	/*********************************************************************
                                     DATA PROVIDERS
	**********************************************************************/
	public function recordProvider() {
		return array(
			array(
				array(
					0 => '1086',
					'contactid' => '1086',
					1 => 'CON3',
					'contact_no' => 'CON3',
					2 => '74',
					'accountid' => '74',
					3 => '--None--',
					'salutation' => '--None--',
					4 => 'Felix',
					'firstname' => 'Felix',
					5 => 'Hirpara',
					'lastname' => 'Hirpara',
					6 => 'felix_hirpara@cox.net',
					'email' => 'felix_hirpara@cox.net',
					7 => '717-491-5643',
					'phone' => '717-491-5643',
					8 => '717-583-1497',
					'mobile' => '717-583-1497',
					9 => 'Owner',
					'title' => 'Owner',
					10 => 'Marketing',
					'department' => 'Marketing',
					11 => '',
					'fax' => '',
					12 => '1971',
					'reportsto' => '1971',
					13 => '',
					'training' => '',
					14 => '',
					'otheremail' => '',
					15 => '',
					'secondaryemail' => '',
					16 => '0',
					'donotcall' => '0',
					17 => '0',
					'emailoptout' => '0',
					18 => '',
					'imagename' => '',
					19 => '0',
					'reference' => '0',
					20 => '0',
					'notify_owner' => '0',
					21 => null,
					'isconvertedfromlead' => null,
					22 => null,
					'convertedfromlead' => null,
				),
			),
		);
	}

	public function resultDataProvider() {
		// Test random fields returned by Query result
		return array(
			array(0,0,'1086'),
			array(0,1,'CON3'),
			array(1,4,'Amber'),
			array(2,4,'Eva'),
			array(3,4,'Adolph'),
			array(4,5,'Besong'),
		);
	}

	public function rawDataProvider() {
		return array(
			array(0,
				array(
					0 => '1086',
					'contactid' => '1086',
					1 => 'CON3',
					'contact_no' => 'CON3',
					2 => '74',
					'accountid' => '74',
					3 => '--None--',
					'salutation' => '--None--',
					4 => 'Felix',
					'firstname' => 'Felix',
					5 => 'Hirpara',
					'lastname' => 'Hirpara',
					6 => 'felix_hirpara@cox.net',
					'email' => 'felix_hirpara@cox.net',
					7 => '717-491-5643',
					'phone' => '717-491-5643',
					8 => '717-583-1497',
					'mobile' => '717-583-1497',
					9 => 'Owner',
					'title' => 'Owner',
					10 => 'Marketing',
					'department' => 'Marketing',
					11 => '',
					'fax' => '',
					12 => '1971',
					'reportsto' => '1971',
					13 => '',
					'training' => '',
					14 => '',
					'otheremail' => '',
					15 => '',
					'secondaryemail' => '',
					16 => '0',
					'donotcall' => '0',
					17 => '0',
					'emailoptout' => '0',
					18 => '',
					'imagename' => '',
					19 => '0',
					'reference' => '0',
					20 => '0',
					'notify_owner' => '0',
					21 => null,
					'isconvertedfromlead' => null,
					22 => null,
					'convertedfromlead' => null,
				)
			),
			array(1,
				array(
					0 => '1104',
					'contactid' => '1104',
	                1 => 'CON19',
	                'contact_no' => 'CON19',
	                2 => '1103',
	                'accountid' => '1103',
	                3 => '',
	                'salutation' => '',
	                4 => 'Amber',
	                'firstname' => 'Amber',
	                5 => 'Windell',
	                'lastname' => 'Windell',
	                6 => 'amber.windell@cox.net',
	                'email' => 'amber.windell@cox.net',
	                7 => '604-864-2113',
	                'phone' => '604-864-2113',
	                8 => '604-902-5812',
	                'mobile' => '604-902-5812',
	                9 => 'Owner',
	                'title' => 'Owner',
	                10 => 'Marketing',
	                'department' => 'Marketing',
	                11 => '',
	                'fax' => '',
	                12 => '0',
	                'reportsto' => '0',
	                13 => '',
	                'training' => '',
	                14 => '',
	                'otheremail' => '',
	                15 => '',
	                'secondaryemail' => '',
	                16 => '0',
	                'donotcall' => '0',
	                17 => '0',
	                'emailoptout' => '0',
	                18 => '',
	                'imagename' => '',
	                19 => '0',
	                'reference' => '0',
	                20 => '0',
	                'notify_owner' => '0',
					21 => null,
					'isconvertedfromlead' => null,
					22 => null,
					'convertedfromlead' => null,
				),
			),
		);
	}

	public function resultsDataProvider() {
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
					'isconvertedfromlead' => '',
					'convertedfromlead' => '',
			)
			),
			array(1,
				array(
					'contactid' => '1104',
	                'contact_no' => 'CON19',
	                'accountid' => '1103',
	                'salutation' => '',
	                'firstname' => 'Amber',
	                'lastname' => 'Windell',
	                'email' => 'amber.windell@cox.net',
	                'phone' => '604-864-2113',
	                'mobile' => '604-902-5812',
	                'title' => 'Owner',
	                'department' => 'Marketing',
	                'fax' => '',
	                'reportsto' => '0',
	                'training' => '',
	                'otheremail' => '',
	                'secondaryemail' => '',
	                'donotcall' => '0',
	                'emailoptout' => '0',
	                'imagename' => '',
	                'reference' => '0',
	                'notify_owner' => '0',
					'isconvertedfromlead' => '',
					'convertedfromlead' => '',
				),
			),
			array(2,
				array(
					'contactid' => '1115',
					'contact_no' => 'CON27',
					'accountid' => '1114',
					'salutation' => '',
					'firstname' => 'Eva',
					'lastname' => 'Joulwan',
					'email' => 'eva.joulwan@gmail.com',
					'phone' => '01779-720349',
					'mobile' => '01961-802899',
					'title' => 'VP Supply Chain',
					'department' => 'Marketing',
					'fax' => '',
					'reportsto' => '1658',
					'training' => '',
					'otheremail' => '',
					'secondaryemail' => '',
					'donotcall' => '0',
					'emailoptout' => '0',
					'imagename' => '',
					'reference' => '0',
					'notify_owner' => '0',
					'isconvertedfromlead' => '',
					'convertedfromlead' => '',
				),
			),
			array(3,
				array(
					'contactid' => '1117',
					'contact_no' => 'CON29',
					'accountid' => '102',
					'salutation' => '',
					'firstname' => 'Adolph',
					'lastname' => 'Krivanec',
					'email' => 'akrivanec@hotmail.com',
					'phone' => '416-736-1436',
					'mobile' => '416-293-9664',
					'title' => 'Managing Director',
					'department' => 'Marketing',
					'fax' => '',
					'reportsto' => '0',
					'training' => '',
					'otheremail' => '',
					'secondaryemail' => '',
					'donotcall' => '1',
					'emailoptout' => '0',
					'imagename' => '',
					'reference' => '0',
					'notify_owner' => '0',
					'isconvertedfromlead' => '',
					'convertedfromlead' => '',
				),
			),
			array(4,
				array(
					'contactid' => '1121',
					'contact_no' => 'CON33',
					'accountid' => '106',
					'salutation' => '',
					'firstname' => 'Chantell',
					'lastname' => 'Besong',
					'email' => 'chantell_besong@gmail.com',
					'phone' => '01607-329400',
					'mobile' => '01218-142767',
					'title' => 'Finance Manager',
					'department' => 'Marketing',
					'fax' => '',
					'reportsto' => '0',
					'training' => '',
					'otheremail' => '',
					'secondaryemail' => '',
					'donotcall' => '1',
					'emailoptout' => '1',
					'imagename' => '',
					'reference' => '0',
					'notify_owner' => '0',
					'isconvertedfromlead' => '',
					'convertedfromlead' => '',
				),
			)
		);
	}

	public function tablesProvider() {
		return array(
			array("vtiger_activitytype",
				array(
					0 => "activitytypeid",
					1 => "activitytype",
					2 => "presence",
					3 => "picklist_valueid",
				)
			),
			array("vtiger_activity_view",
				array(
					0 => "activity_viewid",
					1 => "activity_view",
					2 => "sortorderid",
					3 => "presence",
				)
			),
		);
	}

}

?>
