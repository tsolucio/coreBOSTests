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

class applicationTest extends TestCase {

	/**
	 * Method testevaluateRule
	 * @test
	 */
	public function testevaluateRule() {
		global $current_user;
		$entityCache = new VTEntityCache($current_user);
		$entityData = $entityCache->forId('11x74');
		$params = array(34038, $entityData);
		$actual = __cb_evaluateRule($params);
		$this->assertEquals('Chemex Labs Ltd', $actual, 'account name query');
		$params = array(34031, $entityData);
		$actual = __cb_evaluateRule($params);
		$this->assertEquals('THIS STRING', $actual, 'account name query');
		$actual = __cb_evaluateRule(array());
		$this->assertEquals(0, $actual, 'account name query');
		$actual = __cb_evaluateRule(array(11));
		$this->assertEquals(0, $actual, 'account name query');
		$actual = __cb_evaluateRule(array(11, $entityData));
		$this->assertEquals(0, $actual, 'account name query');
		$actual = __cb_evaluateRule(array(11, 11, $entityData));
		$this->assertEquals(0, $actual, 'account name query');
	}

	/**
	 * Method testgetfromcontext
	 * @test
	 */
	public function testgetfromcontext() {
		$this->assertTrue(true, 'tested in wfExecExpressionTest.php');
	}

	/**
	 * Method testgetfromcontextsearching
	 * @test
	 */
	public function testgetfromcontextsearching() {
		$this->assertTrue(true, 'tested also in wfExecExpressionTest.php');
		global $current_user;
		$entity = new VTWorkflowEntity($current_user, '11x74');
		$values = array(
			'one' => 1,
			'two' => array(
				['one' => 1, 'two' => 1, 'three' => 1,],
				['one' => 2, 'two' => 2, 'three' => 2,],
				['one' => 3, 'two' => 3, 'three' => 3,],
			),
			'three' => array(
				['one' => 2, 'two' => 2, 'three' => 2,],
			),
		);
		$entity->WorkflowContext = $values;
		$param = array(
			'notthere',
			'',
			'',
			'',
			$entity,
		);
		$this->assertEquals('', __cb_getfromcontextsearching($param));
		$param = array(
			'two',
			'two',
			3,
			'three',
			$entity,
		);
		$this->assertEquals(3, __cb_getfromcontextsearching($param));
		$param = array(
			'two',
			'two',
			1,
			'three',
			$entity,
		);
		$this->assertEquals(1, __cb_getfromcontextsearching($param));
		$param = array(
			'two',
			'two',
			4,
			'three',
			$entity,
		);
		$this->assertEquals('', __cb_getfromcontextsearching($param));
		$param = array(
			'two,three',
			'two',
			2,
			'three',
			$entity,
		);
		$this->assertEquals('{"two":2,"three":2}', __cb_getfromcontextsearching($param));
	}

	/**
	 * Method testsetfromcontext
	 * @test
	 */
	public function testsetfromcontext() {
		$this->assertTrue(true, 'tested in wfExecExpressionTest.php');
	}

	/**
	 * Method testgetfromcontextvalueinarrayobject
	 * @test
	 */
	public function testgetfromcontextvalueinarrayobject() {
		$array = array(
			'one' => 1,
			'two' => array(
				'two' => 2,
			),
			'three' => array(
				'three' => array(
					'three' => 3,
				),
			),
		);
		$this->assertEquals(1, __cb_getfromcontextvalueinarrayobject($array, 'one'));
		$this->assertEquals(2, __cb_getfromcontextvalueinarrayobject($array, 'two.two'));
		$this->assertEquals(3, __cb_getfromcontextvalueinarrayobject($array, 'three.three.three'));
		$this->assertEquals('', __cb_getfromcontextvalueinarrayobject(array(), 'one.two'));
		$this->assertEquals('', __cb_getfromcontextvalueinarrayobject($array, 'one.two'));
		$object = json_decode('{"one":1,"two" :[{"two":2}],"three":[[{"three":3}]]}');
		$this->assertEquals(1, __cb_getfromcontextvalueinarrayobject($object, 'one'));
		$this->assertEquals(2, __cb_getfromcontextvalueinarrayobject($object, 'two.0.two'));
		$this->assertEquals(3, __cb_getfromcontextvalueinarrayobject($object, 'three.0.three.0.three'));
		$this->assertEquals('', __cb_getfromcontextvalueinarrayobject(false, 'one.two'));
		$this->assertEquals('', __cb_getfromcontextvalueinarrayobject($object, 'one.two'));
	}

	/**
	 * Method testgetidof
	 * @test
	 */
	public function testgetidof() {
		$this->assertEquals(74, __cb_getidof(array('Accounts', 'accountname', 'Chemex Labs Ltd')), 'accounts');
		$this->assertEquals(1094, __cb_getidof(array('Contacts', 'mobile', '561-951-9734')), 'contacts');
		$this->assertEquals(0, __cb_getidof(array('Contacts', 'mobile', 'does not exist')), 'contacts');
	}

	/**
	 * Method testgetrelatedids
	 * @test
	 */
	public function testgetrelatedids() {
		global $current_user;
		$entityCache = new VTEntityCache($current_user);
		$entityData = $entityCache->forId('11x74');
		$params = array('Contacts', $entityData);
		$expected = array('12x1084', '12x1086', '12x1088', '12x1090', '12x1092', '12x1094');
		$this->assertEquals($expected, __cb_getrelatedids($params), 'accounts > contacts');
		$params = array('SalesOrder', $entityData);
		$expected = array('6x10746');
		$this->assertEquals($expected, __cb_getrelatedids($params), 'accounts > SalesOrder');
		$params = array('cbCalendar', $entityData);
		$expected = array();
		$this->assertEquals($expected, __cb_getrelatedids($params), 'accounts > cbCalendar');
		$params = array('NonExistent', $entityData);
		$expected = array();
		$this->assertEquals($expected, __cb_getrelatedids($params), 'accounts > NonExistent');
		$params = array('', $entityData);
		$expected = array();
		$this->assertEquals($expected, __cb_getrelatedids($params), 'accounts > empty');
		///// any record relations
		$params = array('HelpDesk', 943, $entityData);
		$expected = array('17x2645');
		$this->assertEquals($expected, __cb_getrelatedids($params), 'accounts > helpdesk');
		$params = array('HelpDesk', 2105, $entityData);
		$expected = array('17x2640');
		$this->assertEquals($expected, __cb_getrelatedids($params), 'contacts > helpdesk');
	}

	/**
	 * Method testexecuteSQL
	 * @test
	 */
	public function testexecuteSQL() {
		$params = array('select accountname from vtiger_account where otherphone=?', '248-697-7722');
		$expected = array(['accountname' => 'Sebring & Co']);
		$this->assertEquals($expected, __cb_executesql($params), 'accountname');
		$params = array('select accountname,siccode from vtiger_account where accountname like "%Sebring%"');
		$expected = array(
			['accountname' => 'Sebring & Co', 'siccode' => ''],
			['accountname' => 'Sebring & Co', 'siccode' => ''],
		);
		$this->assertEquals($expected, __cb_executesql($params), 'accountname');
		$params = array('select accountname,siccode from vtiger_account where accountname like ? and email1=?', '%Sebring%', 'cherry@lietz.com');
		$expected = array(
			['accountname' => 'Sebring & Co', 'siccode' => ''],
		);
		$this->assertEquals($expected, __cb_executesql($params), 'accountname');
	}

	/**
	 * Method testgetRelatedMassCreateArray
	 * @test
	 */
	public function testgetRelatedMassCreateArray() {
		global $current_user,$log;
		$entityCache = new VTEntityCache($current_user);
		$entityData = $entityCache->forId('11x74');
		$params = array('Potentials',74);
		$expected =array(
			[
			  "elementType" => "Accounts",
			  "referenceId" => 74,
			  "element" => array(
				"accountname" => "Chemex Labs Ltd",
				"account_no" => "ACC1",
				"phone" => "03-3608-5660",
				"website" =>"http://www.chemexlabsltd.com.au",
				"fax" =>"",
				"tickersymbol"=> "",
				"otherphone"=> "0487-835-113",
				"account_id"=> "746",
				"email1" => "lina@yahoo.com",
				"employees" => "131",
				"email2" => "",
				"ownership" =>"",
				"rating" => "Active",
				"industry" => "Engineering",
				"siccode" => "",
				"accounttype" => "Press",
				"annual_revenue" => "3045164.000000",
				"emailoptout" => "1",
				"notify_owner" => "0",
				"assigned_user_id" => "10",
				"createdtime" => "2015-03-13 18:24:30",
				"modifiedtime" => "2016-04-02 18:21:14",
				"modifiedby" => "1",
				"bill_street" => "C/ Joan Fuster 12",
				"ship_street" => "C/ Joan Fuster 12",
				"bill_city" => "Els Poblets",
				"ship_city" => "Els Poblets",
				"bill_state" => "Alicante",
				"ship_state" => "Alicante",
				"bill_code" => "03779",
				"ship_code" => "03779",
				"bill_country" => "Spain",
				"ship_country" => "Spain",
				"bill_pobox" => "",
				"ship_pobox" => "",
				"description" => "Aut unde est hoc contritum vetustate proverbium: quicum in tenebris? Nec vero alia sunt quaerenda contra Carneadeam illam sententiam. Nemo igitur esse beatus potest. Nummus in Croesi divitiis obscuratur, pars est tamen divitiarum.",
				"campaignrelstatus" => "",
				"cf_718" => "",
				"cf_719" => "2.00",
				"cf_720" => "0.00",
				"cf_721" => "0.000000",
				"cf_722" => "2016-02-15",
				"cf_723" => "",
				"cf_724" => "",
				"cf_725" => "",
				"cf_726" => "0",
				"cf_727" => "",
				"cf_728" => "00:00:00",
				"cf_729" => "one",
				"cf_730" => "oneone",
				"cf_731" => "oneoneone",
				"cf_732" => "Adipose 3 |##| Chronos |##| Earth",
				"isconvertedfromlead" => "",
				"convertedfromlead" => "",
				"created_user_id" => "1",
				"record_id" => 74,
				"record_module" => "Accounts",
				"cbuuid" => "b0857db0c1dee95300a10982853f5fb1d4e981c1"
			)
			],
			[
			  "elementType" => "Potentials",
			  "referenceId" => "13x5660",
			  "element" => array(
				"0" => "Sollicitudin A Consulting",
				"1" => "POT523",
				"2" => "74",
				"3" => "70134.000000",
				"4" => "Up Sell",
				"5" => "2017-02-24",
				"6" => "--None--",
				"7" => "Contact",
				"8" => "10",
				"9" => "10",
				"10" => "cbTest",
				"11" => "testtz",
				"12" => "Proposal/Price Quote",
				"13" => "0",
				"14" => "96.000",
				"15" => "2015-07-23 05:59:14",
				"16" => "2015-05-06 07:59:40",
				"17" => "1",
				"18" => "67328.640000",
				"19" => "lina@yahoo.com",
				"20" => "0",
				"21" => "",
				"22" => "1",
				"23" => "1",
				"24" => "cbTest",
				"25" => "testtz",
				"26" => "sollicitudin commodo ipsum. Suspendisse non leo. Vivamus nibh dolor, nonummy ac, feugiat non, lobortis quis, pede. Suspendisse dui. Fusce diam nunc, ullamcorper eu, euismod ac, fermentum vel, mauris. Integer sem elit, pharetra ut, pharetra sed, hendrerit a, arcu. Sed et libero. Proin mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam auctor, velit eget laoreet posuere, enim nisl elementum purus, accumsan interdum",
				"27" => "5660",
				"28" => "fdc6762d518a617b0f27b05c974743b2dfe806e9",
				"potentialname" => "Sollicitudin A Consulting",
				"potential_no" => "POT523",
				"related_to" => "@{74}",
				"amount" => "70134.000000",
				"potentialtype" => "Up Sell",
				"closingdate" => "2017-02-24",
				"leadsource" => "--None--",
				"nextstep" => "Contact",
				"assigned_user_id" => "19x10",
				"smownerid" => "10",
				"owner_firstname" => "cbTest",
				"owner_lastname" => "testtz",
				"sales_stage" => "Proposal/Price Quote",
				"campaignid" => "",
				"probability" => "96.000",
				"modifiedtime" => "2015-07-23 05:59:14",
				"createdtime" => "2015-05-06 07:59:40",
				"modifiedby" => "19x1",
				"forecast_amount" => "67328.640000",
				"email" => "lina@yahoo.com",
				"isconvertedfromlead" => "0",
				"convertedfromlead" => "",
				"creator" => "1",
				"smcreatorid" => "1",
				"creator_firstname" => "cbTest",
				"creator_lastname" => "testtz",
				"description" => "sollicitudin commodo ipsum. Suspendisse non leo. Vivamus nibh dolor, nonummy ac, feugiat non, lobortis quis, pede. Suspendisse dui. Fusce diam nunc, ullamcorper eu, euismod ac, fermentum vel, mauris. Integer sem elit, pharetra ut, pharetra sed, hendrerit a, arcu. Sed et libero. Proin mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam auctor, velit eget laoreet posuere, enim nisl elementum purus, accumsan interdum",
				"potentialid" => "5660",
				"cbuuid" => "fdc6762d518a617b0f27b05c974743b2dfe806e9",
				"id" => "13x5660"
			  )
			]
			);
		$this->assertEquals($expected, __cb_getRelatedMassCreateArray($params), 'product > Potentials');
	}

	/**
	 * Method testgetRelatedMassCreateArrayConverting
	 * @test
	 */
	public function testgetRelatedMassCreateArrayConverting() {
		global $current_user,$log;
		$entityCache = new VTEntityCache($current_user);
		$entityData = $entityCache->forId('11x74');
		$params = array('Potentials', 'Projects', 'ProjectTasks',74);
		$expected =array(
			[
			  "elementType" => "Accounts",
			  "referenceId" => 74,
			  "element" => array(
				"accountname" => "Chemex Labs Ltd",
				"account_no" => "ACC1",
				"phone" => "03-3608-5660",
				"website" =>"http://www.chemexlabsltd.com.au",
				"fax" =>"",
				"tickersymbol"=> "",
				"otherphone"=> "0487-835-113",
				"account_id"=> "746",
				"email1" => "lina@yahoo.com",
				"employees" => "131",
				"email2" => "",
				"ownership" =>"",
				"rating" => "Active",
				"industry" => "Engineering",
				"siccode" => "",
				"accounttype" => "Press",
				"annual_revenue" => "3045164.000000",
				"emailoptout" => "1",
				"notify_owner" => "0",
				"assigned_user_id" => "10",
				"createdtime" => "2015-03-13 18:24:30",
				"modifiedtime" => "2016-04-02 18:21:14",
				"modifiedby" => "1",
				"bill_street" => "C/ Joan Fuster 12",
				"ship_street" => "C/ Joan Fuster 12",
				"bill_city" => "Els Poblets",
				"ship_city" => "Els Poblets",
				"bill_state" => "Alicante",
				"ship_state" => "Alicante",
				"bill_code" => "03779",
				"ship_code" => "03779",
				"bill_country" => "Spain",
				"ship_country" => "Spain",
				"bill_pobox" => "",
				"ship_pobox" => "",
				"description" => "Aut unde est hoc contritum vetustate proverbium: quicum in tenebris? Nec vero alia sunt quaerenda contra Carneadeam illam sententiam. Nemo igitur esse beatus potest. Nummus in Croesi divitiis obscuratur, pars est tamen divitiarum.",
				"campaignrelstatus" => "",
				"cf_718" => "",
				"cf_719" => "2.00",
				"cf_720" => "0.00",
				"cf_721" => "0.000000",
				"cf_722" => "2016-02-15",
				"cf_723" => "",
				"cf_724" => "",
				"cf_725" => "",
				"cf_726" => "0",
				"cf_727" => "",
				"cf_728" => "00:00:00",
				"cf_729" => "one",
				"cf_730" => "oneone",
				"cf_731" => "oneoneone",
				"cf_732" => "Adipose 3 |##| Chronos |##| Earth",
				"isconvertedfromlead" => "",
				"convertedfromlead" => "",
				"created_user_id" => "1",
				"record_id" => 74,
				"record_module" => "Accounts",
				"cbuuid" => "b0857db0c1dee95300a10982853f5fb1d4e981c1"
			)
			],
			[
			  "elementType" => "Potentials",
			  "referenceId" => "13x5660",
			  "element" => array(
				"0" => "Sollicitudin A Consulting",
				"1" => "POT523",
				"2" => "74",
				"3" => "70134.000000",
				"4" => "Up Sell",
				"5" => "2017-02-24",
				"6" => "--None--",
				"7" => "Contact",
				"8" => "10",
				"9" => "10",
				"10" => "cbTest",
				"11" => "testtz",
				"12" => "Proposal/Price Quote",
				"13" => "0",
				"14" => "96.000",
				"15" => "2015-07-23 05:59:14",
				"16" => "2015-05-06 07:59:40",
				"17" => "1",
				"18" => "67328.640000",
				"19" => "lina@yahoo.com",
				"20" => "0",
				"21" => "",
				"22" => "1",
				"23" => "1",
				"24" => "cbTest",
				"25" => "testtz",
				"26" => "sollicitudin commodo ipsum. Suspendisse non leo. Vivamus nibh dolor, nonummy ac, feugiat non, lobortis quis, pede. Suspendisse dui. Fusce diam nunc, ullamcorper eu, euismod ac, fermentum vel, mauris. Integer sem elit, pharetra ut, pharetra sed, hendrerit a, arcu. Sed et libero. Proin mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam auctor, velit eget laoreet posuere, enim nisl elementum purus, accumsan interdum",
				"27" => "5660",
				"28" => "fdc6762d518a617b0f27b05c974743b2dfe806e9",
				"potentialname" => "Sollicitudin A Consulting",
				"potential_no" => "POT523",
				"related_to" => "@{74}",
				"amount" => "70134.000000",
				"potentialtype" => "Up Sell",
				"closingdate" => "2017-02-24",
				"leadsource" => "--None--",
				"nextstep" => "Contact",
				"assigned_user_id" => "19x10",
				"smownerid" => "10",
				"owner_firstname" => "cbTest",
				"owner_lastname" => "testtz",
				"sales_stage" => "Proposal/Price Quote",
				"campaignid" => "",
				"probability" => "96.000",
				"modifiedtime" => "2015-07-23 05:59:14",
				"createdtime" => "2015-05-06 07:59:40",
				"modifiedby" => "19x1",
				"forecast_amount" => "67328.640000",
				"email" => "lina@yahoo.com",
				"isconvertedfromlead" => "0",
				"convertedfromlead" => "",
				"creator" => "1",
				"smcreatorid" => "1",
				"creator_firstname" => "cbTest",
				"creator_lastname" => "testtz",
				"description" => "sollicitudin commodo ipsum. Suspendisse non leo. Vivamus nibh dolor, nonummy ac, feugiat non, lobortis quis, pede. Suspendisse dui. Fusce diam nunc, ullamcorper eu, euismod ac, fermentum vel, mauris. Integer sem elit, pharetra ut, pharetra sed, hendrerit a, arcu. Sed et libero. Proin mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam auctor, velit eget laoreet posuere, enim nisl elementum purus, accumsan interdum",
				"potentialid" => "5660",
				"cbuuid" => "fdc6762d518a617b0f27b05c974743b2dfe806e9",
				"id" => "13x5660"
			  )
			],
			[
			  "elementType" => "Potentials",
			  "referenceId" => "13x5900",
			  "element" => array(
				"0" => "Egestas Aliquam Fringilla Corp.",
				"1" => "POT763",
				"2" => "74",
				"3" => "72100.000000",
				"4" => "Cross Sale",
				"5" => "2016-03-14",
				"6" => "Trade Show",
				"7" => "Reactivate",
				"8" => "5",
				"9" => "5",
				"10"=> "cbTest",
				"11"=> "testdmy",
				"12"=> "Closed Lost",
				"13"=> "5012",
				"14"=> "97.000",
				"15"=> "2016-06-07 19:17:45",
				"16"=> "2015-05-08 14:08:17",
				"17"=> "1",
				"18"=> "69937.000000",
				"19"=> "lina@yahoo.com",
				"20"=> "0",
				"21"=> "",
				"22"=> "1",
				"23"=> "1",
				"24"=> "cbTest",
				"25"=> "testdmy",
				"26"=> "ante dictum mi, ac mattis velit justo nec ante. Maecenas mi felis, adipiscing fringilla, porttitor vulputate, posuere vulputate, lacus. Cras interdum. Nunc sollicitudin commodo ipsum. Suspendisse non leo. Vivamus nibh dolor, nonummy ac, feugiat non, lobortis quis, pede. Suspendisse dui. Fusce diam nunc, ullamcorper eu, euismod ac, fermentum vel, mauris. Integer sem elit, pharetra ut, pharetra sed, hendrerit a, arcu. Sed et libero. Proin mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi",
				"27"=> "5900",
				"28"=> "8d8d585a318dbdfe1116d0686115de16fb342bb6",
				"potentialname" => "Egestas Aliquam Fringilla Corp.",
				"potential_no" => "POT763",
				"related_to" => "@{74}",
				"amount" => "72100.000000",
				"potentialtype" => "Cross Sale",
				"closingdate" => "2016-03-14",
				"leadsource" => "Trade Show",
				"nextstep" => "Reactivate",
				"assigned_user_id" => "19x5",
				"smownerid" => "5",
				"owner_firstname" => "cbTest",
				"owner_lastname" => "testdmy",
				"sales_stage" => "Closed Lost",
				"campaignid" => "1x5012",
				"probability" => "97.000",
				"modifiedtime" => "2016-06-07 19:17:45",
				"createdtime" => "2015-05-08 14:08:17",
				"modifiedby" => "19x1",
				"forecast_amount" => "69937.000000",
				"email" => "lina@yahoo.com",
				"isconvertedfromlead" => "0",
				"convertedfromlead" => "",
				"creator" => "1",
				"smcreatorid" => "1",
				"creator_firstname" => "cbTest",
				"creator_lastname" => "testdmy",
				"description" => "ante dictum mi, ac mattis velit justo nec ante. Maecenas mi felis, adipiscing fringilla, porttitor vulputate, posuere vulputate, lacus. Cras interdum. Nunc sollicitudin commodo ipsum. Suspendisse non leo. Vivamus nibh dolor, nonummy ac, feugiat non, lobortis quis, pede. Suspendisse dui. Fusce diam nunc, ullamcorper eu, euismod ac, fermentum vel, mauris. Integer sem elit, pharetra ut, pharetra sed, hendrerit a, arcu. Sed et libero. Proin mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi",
				"potentialid" => "5900",
				"cbuuid" => "8d8d585a318dbdfe1116d0686115de16fb342bb6",
				"id" => "13x5900"
			  )
			]
			);
		$this->assertEquals($expected, __cb_getRelatedMassCreateArrayConverting($params), 'product > Potentials');
	}
}
?>