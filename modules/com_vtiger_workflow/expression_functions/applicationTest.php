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
	 * Method testcleanarrayelements
	 * @test
	 */
	public function testcleanarrayelements() {
		$this->assertFalse(__cb_cleanarrayelements([]));
		$this->assertFalse(__cb_cleanarrayelements([null]));
		$this->assertFalse(__cb_cleanarrayelements([1, '']));
		$a = ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6'];
		$params = array($a, '2,4');
		$expected = ['1' => '1', '3' => '3', '5' => '5', '6' => '6'];
		$this->assertEquals($expected, __cb_cleanarrayelements($params));
		$params[2] = 0;
		$this->assertEquals($expected, __cb_cleanarrayelements($params));
		$params[2] = 'false';
		$this->assertEquals($expected, __cb_cleanarrayelements($params));
		$params = array($a, '1,3,5,6', 1);
		$this->assertEquals($expected, __cb_cleanarrayelements($params));
		$params = array($a, '', 1);
		$this->assertEquals([], __cb_cleanarrayelements($params));
		$params = array($a, '', 0);
		$this->assertEquals($a, __cb_cleanarrayelements($params));
	}

	/**
	 * Method testgetRelatedMassCreateArrayNotConverting
	 * @test
	 */
	public function testgetRelatedMassCreateArrayNotConverting() {
		global $current_user;
		$params = array('Potentials', 74);
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
				"account_id"=> "11x746",
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
				"assigned_user_id" => "19x10",
				"createdtime" => "2015-03-13 18:24:30",
				"modifiedtime" => "2016-04-02 18:21:14",
				"modifiedby" => "19x1",
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
				"created_user_id" => "19x1",
				"id" => '11x74',
				"cbuuid" => "b0857db0c1dee95300a10982853f5fb1d4e981c1"
			)
			],
			[
			  "elementType" => "Potentials",
			  "referenceId" => "13x5660",
			  "element" => array(
				"potentialname" => "Sollicitudin A Consulting",
				"potential_no" => "POT523",
				"related_to" => "@{74}",
				"amount" => "70134.000000",
				"potentialtype" => "Up Sell",
				"closingdate" => "2017-02-24",
				"leadsource" => "--None--",
				"nextstep" => "Contact",
				"assigned_user_id" => "19x10",
				'smownerid' => '10',
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
			  ),
			],
			[
				"elementType" => "Potentials",
				"referenceId" => "13x5900",
				"element" => array(
					'potentialname' => 'Egestas Aliquam Fringilla Corp.',
					'potential_no' => 'POT763',
					'related_to' => '@{74}',
					'amount' => '72100.000000',
					'potentialtype' => 'Cross Sale',
					'closingdate' => '2016-03-14',
					'leadsource' => 'Trade Show',
					'nextstep' => 'Reactivate',
					'assigned_user_id' => '19x5',
					'smownerid' => '5',
					'owner_firstname' => 'cbTest',
					'owner_lastname' => 'testdmy',
					'sales_stage' => 'Closed Lost',
					'campaignid' => '1x5012',
					'probability' => '97.000',
					'modifiedtime' => '2016-06-07 19:17:45',
					'createdtime' => '2015-05-08 14:08:17',
					'modifiedby' => '19x1',
					'forecast_amount' => '69937.000000',
					'email' => 'lina@yahoo.com',
					'isconvertedfromlead' => '0',
					'convertedfromlead' => '',
					'creator' => '1',
					'smcreatorid' => '1',
					'creator_firstname' => 'cbTest',
					'creator_lastname' => 'testdmy',
					'description' => 'ante dictum mi, ac mattis velit justo nec ante. Maecenas mi felis, adipiscing fringilla, porttitor vulputate, posuere vulputate, lacus. Cras interdum. Nunc sollicitudin commodo ipsum. Suspendisse non leo. Vivamus nibh dolor, nonummy ac, feugiat non, lobortis quis, pede. Suspendisse dui. Fusce diam nunc, ullamcorper eu, euismod ac, fermentum vel, mauris. Integer sem elit, pharetra ut, pharetra sed, hendrerit a, arcu. Sed et libero. Proin mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi',
					'potentialid' => '5900',
					'cbuuid' => '8d8d585a318dbdfe1116d0686115de16fb342bb6',
					'id' => '13x5900',
				  ),
			  ]
		  );
		$this->assertEquals($expected, __cb_getRelatedMassCreateArray($params), 'product > Potentials');
	}

	/**
	 * Method testgetRelatedMassCreateArrayConverting
	 * @test
	 */
	public function testgetRelatedMassCreateArrayConverting() {
		global $current_user, $adb;
		$exists = $adb->pquery(
			'select cbmapid
			from vtiger_cbmap
			inner join vtiger_crmentity on crmid=cbmapid
			where mapname=? and deleted=0',
			array('Workflow_Accounts2Project')
		);
		if ($adb->num_rows($exists)>0) {
			vtws_delete(vtws_getEntityId('cbMap').'x'.$adb->query_result($exists, 0, 'cbmapid'), $current_user);
		}
		$exists = $adb->pquery(
			'select cbmapid
			from vtiger_cbmap
			inner join vtiger_crmentity on crmid=cbmapid
			where mapname=? and deleted=0',
			array('Workflow_Potentials2ProjectTask')
		);
		if ($adb->num_rows($exists)>0) {
			vtws_delete(vtws_getEntityId('cbMap').'x'.$adb->query_result($exists, 0, 'cbmapid'), $current_user);
		}
		$params = array('Potentials', 'Project', 'ProjectTask',74);
		$expected =array(
			[
			  "elementType" => "Project",
			  "referenceId" => 74,
			  "element" => array(
				'assigned_user_id' => '',
				'createdtime' => '',
				'modifiedtime' => '',
				'modifiedby' => '',
				'description' => '',
				'created_user_id' => '',
				'projectname' => '',
				'startdate' => '',
				'targetenddate' => '',
				'actualenddate' => '',
				'projectstatus' => '',
				'projecttype' => '',
				'linktoaccountscontacts' => '',
				'project_no' => '',
				'targetbudget' => '',
				'projecturl' => '',
				'projectpriority' => '',
				'progress' => '',
				'email' => '',
				)
			],
			[
			  "elementType" => "ProjectTask",
			  "referenceId" => "13x5660",
			  "element" => array(
				'assigned_user_id' => '',
				'modifiedtime' => '',
				'createdtime' => '',
				'modifiedby' => '',
				'email' => '',
				'description' => '',
				'projecttaskname' => '',
				'projecttasktype' => '',
				'projecttaskpriority' => '',
				'projectid' => '',
				'projecttasknumber' => '',
				'projecttask_no' => '',
				'projecttaskprogress' => '',
				'projecttaskhours' => '',
				'startdate' => '',
				'enddate' => '',
				'projecttaskstatus' => '',
				'created_user_id' => '',
				'related_to' => '@{74}',
			  )
			],
			[
			  "elementType" => "ProjectTask",
			  "referenceId" => "13x5900",
			  "element" => array(
				'assigned_user_id' => '',
				'modifiedtime' => '',
				'createdtime' => '',
				'modifiedby' => '',
				'email' => '',
				'description' => '',
				'projecttaskname' => '',
				'projecttasktype' => '',
				'projecttaskpriority' => '',
				'projectid' => '',
				'projecttasknumber' => '',
				'projecttask_no' => '',
				'projecttaskprogress' => '',
				'projecttaskhours' => '',
				'startdate' => '',
				'enddate' => '',
				'projecttaskstatus' => '',
				'created_user_id' => '',
				'related_to' => '@{74}',
			  )
			]
			);
		$this->assertEquals($expected, __cb_getRelatedMassCreateArrayConverting($params), 'product > Potentials');
		/////////////
		// create mapping
		$mapping = array(
			'mapname' => 'Workflow_Accounts2Project',
			'maptype' => 'Mapping',
			'targetname' => 'Accounts',
			'content' => '<map>
			<originmodule>
			<originname>Project</originname>
			</originmodule>
			<targetmodule>
			<targetname>Acounts</targetname>
			</targetmodule>
			<fields>
			<field>
				<fieldname>projectname</fieldname>
				<Orgfields>
				<Orgfield>
					<OrgfieldName>accountname</OrgfieldName>
				</Orgfield>
				</Orgfields>
			</field>
			<field>
				<fieldname>assigned_user_id</fieldname>
				<Orgfields>
				<Orgfield>
					<OrgfieldName>assigned_user_id</OrgfieldName>
					<OrgfieldID>field</OrgfieldID>
				</Orgfield>
				</Orgfields>
			</field>
			</fields>
		</map>',
			'decription' => '',
			'assigned_user_id' => '19x1',
		);
		vtws_create('cbMap', $mapping, $current_user);
		$mapping = array(
			'mapname' => 'Workflow_Potentials2ProjectTask',
			'maptype' => 'Mapping',
			'targetname' => 'Potentials',
			'content' => '<map>
			<originmodule>
			<originname>ProjectTask</originname>
			</originmodule>
			<targetmodule>
			<targetname>Potentials</targetname>
			</targetmodule>
			<fields>
			<field>
				<fieldname>projecttaskname</fieldname>
				<Orgfields>
				<Orgfield>
					<OrgfieldName>potentialname</OrgfieldName>
				</Orgfield>
				</Orgfields>
			</field>
			<field>
				<fieldname>assigned_user_id</fieldname>
				<Orgfields>
				<Orgfield>
					<OrgfieldName>assigned_user_id</OrgfieldName>
					<OrgfieldID>field</OrgfieldID>
				</Orgfield>
				</Orgfields>
			</field>
			</fields>
		</map>',
			'decription' => '',
			'assigned_user_id' => '19x1',
		);
		vtws_create('cbMap', $mapping, $current_user);
		$params = array('Potentials', 'Project', 'ProjectTask',74);
		$expected =array(
			[
			  "elementType" => "Project",
			  "referenceId" => 74,
			  "element" => array(
				'assigned_user_id' => '19x10',
				'createdtime' => '',
				'modifiedtime' => '',
				'modifiedby' => '',
				'description' => '',
				'created_user_id' => '',
				'projectname' => 'Chemex Labs Ltd',
				'startdate' => '',
				'targetenddate' => '',
				'actualenddate' => '',
				'projectstatus' => '',
				'projecttype' => '',
				'linktoaccountscontacts' => '',
				'project_no' => '',
				'targetbudget' => '',
				'projecturl' => '',
				'projectpriority' => '',
				'progress' => '',
				'email' => '',
				)
			],
			[
			  "elementType" => "ProjectTask",
			  "referenceId" => "13x5660",
			  "element" => array(
				'assigned_user_id' => '19x10',
				'modifiedtime' => '',
				'createdtime' => '',
				'modifiedby' => '',
				'email' => '',
				'description' => '',
				'projecttaskname' => 'Sollicitudin A Consulting',
				'projecttasktype' => '',
				'projecttaskpriority' => '',
				'projectid' => '',
				'projecttasknumber' => '',
				'projecttask_no' => '',
				'projecttaskprogress' => '',
				'projecttaskhours' => '',
				'startdate' => '',
				'enddate' => '',
				'projecttaskstatus' => '',
				'created_user_id' => '',
				'related_to' => '@{74}',
			  )
			],
			[
			  "elementType" => "ProjectTask",
			  "referenceId" => "13x5900",
			  "element" => array(
				'assigned_user_id' => '19x5',
				'modifiedtime' => '',
				'createdtime' => '',
				'modifiedby' => '',
				'email' => '',
				'description' => '',
				'projecttaskname' => 'Egestas Aliquam Fringilla Corp.',
				'projecttasktype' => '',
				'projecttaskpriority' => '',
				'projectid' => '',
				'projecttasknumber' => '',
				'projecttask_no' => '',
				'projecttaskprogress' => '',
				'projecttaskhours' => '',
				'startdate' => '',
				'enddate' => '',
				'projecttaskstatus' => '',
				'created_user_id' => '',
				'related_to' => '@{74}',
			  )
			]
			);
		$this->assertEquals($expected, __cb_getRelatedMassCreateArrayConverting($params), 'product > Potentials');
	}

	/**
	 * Method testapplymaptoarrayelementsandsubarray
	 * @test
	 */
	public function testapplymaptoarrayelementsandsubarray() {
		$json = '[{"id":4999344095477,"admin_graphql_api_id":"gid:\/\/shopify\/Order\/4999344095477","app_id":1354745,"browser_ip":null,"buyer_accepts_marketing":true,"cancel_reason":null,"cancelled_at":null,"cart_token":null,"checkout_id":33286484459765,"checkout_token":"8e34261b56a6a1c66789bc1f23189b75","client_details":{"accept_language":null,"browser_height":null,"browser_ip":null,"browser_width":null,"session_hash":null,"user_agent":null},"closed_at":null,"confirmed":true,"contact_email":"cosimocolaci@libero.it","created_at":"2022-09-06T14:13:35+02:00","currency":"EUR","current_subtotal_price":"84.60","current_subtotal_price_set":{"shop_money":{"amount":"84.60","currency_code":"EUR"},"presentment_money":{"amount":"84.60","currency_code":"EUR"}},"current_total_discounts":"0.00","current_total_discounts_set":{"shop_money":{"amount":"0.00","currency_code":"EUR"},"presentment_money":{"amount":"0.00","currency_code":"EUR"}},"current_total_duties_set":null,"current_total_price":"84.60","current_total_price_set":{"shop_money":{"amount":"84.60","currency_code":"EUR"},"presentment_money":{"amount":"84.60","currency_code":"EUR"}},"current_total_tax":"0.00","current_total_tax_set":{"shop_money":{"amount":"0.00","currency_code":"EUR"},"presentment_money":{"amount":"0.00","currency_code":"EUR"}},"customer_locale":"it","device_id":null,"discount_codes":[],"estimated_taxes":false,"fulfillment_status":null,"gateway":"manual","landing_site":null,"landing_site_ref":null,"location_id":null,"name":"#1102","note":null,"note_attributes":[],"number":102,"order_number":1102,"order_status_url":"https:\/\/contidagostino.it\/61111140597\/orders\/9fb19e91be731952ad5d1965cad9cbd8\/authenticate?key=9f70a5ceb912496a16e092e2d9ba65b1","original_total_duties_set":null,"payment_gateway_names":["manual"],"phone":null,"presentment_currency":"EUR","processed_at":"2022-09-06T14:13:35+02:00","processing_method":"manual","reference":null,"referring_site":null,"source_identifier":null,"source_name":"shopify_draft_order","source_url":null,"subtotal_price":"84.60","subtotal_price_set":{"shop_money":{"amount":"84.60","currency_code":"EUR"},"presentment_money":{"amount":"84.60","currency_code":"EUR"}},"tags":"","tax_lines":[],"taxes_included":true,"test":false,"token":"9fb19e91be731952ad5d1965cad9cbd8","total_discounts":"0.00","total_discounts_set":{"shop_money":{"amount":"0.00","currency_code":"EUR"},"presentment_money":{"amount":"0.00","currency_code":"EUR"}},"total_line_items_price":"84.60","total_line_items_price_set":{"shop_money":{"amount":"84.60","currency_code":"EUR"},"presentment_money":{"amount":"84.60","currency_code":"EUR"}},"total_outstanding":"84.60","total_price":"84.60","total_price_set":{"shop_money":{"amount":"84.60","currency_code":"EUR"},"presentment_money":{"amount":"84.60","currency_code":"EUR"}},"total_price_usd":"84.18","total_shipping_price_set":{"shop_money":{"amount":"0.00","currency_code":"EUR"},"presentment_money":{"amount":"0.00","currency_code":"EUR"}},"total_tax":"0.00","total_tax_set":{"shop_money":{"amount":"0.00","currency_code":"EUR"},"presentment_money":{"amount":"0.00","currency_code":"EUR"}},"total_tip_received":"0.00","total_weight":0,"updated_at":"2022-09-06T14:13:36+02:00","user_id":78724923637,"billing_address":{"first_name":"COSIMO","address1":"VIALE COLLI ANIMEI   279  ( CITOFONARE N.RO 520 )","phone":"+393487333027","city":"Napoli","zip":"80131","province":"Napoli","country":"Italy","last_name":"COLACI","address2":"","company":"","latitude":40.8704855,"longitude":14.2386034,"name":"COSIMO COLACI","country_code":"IT","province_code":"NA"},"customer":{"id":6476096930037,"email":"cosimocolaci@libero.it","accepts_marketing":true,"created_at":"2022-09-06T14:11:33+02:00","updated_at":"2022-09-06T14:11:44+02:00","first_name":"COSIMO","last_name":"COLACI","orders_count":0,"state":"disabled","total_spent":"0.00","last_order_id":null,"note":null,"verified_email":true,"multipass_identifier":null,"tax_exempt":false,"tags":"","last_order_name":null,"currency":"EUR","phone":null,"accepts_marketing_updated_at":"2022-09-06T14:11:44+02:00","marketing_opt_in_level":"single_opt_in","tax_exemptions":[],"sms_marketing_consent":null,"admin_graphql_api_id":"gid:\/\/shopify\/Customer\/6476096930037","default_address":{"id":7958097363189,"customer_id":6476096930037,"first_name":"COSIMO","last_name":"COLACI","company":"","address1":"VIALE COLLI ANIMEI   279  ( CITOFONARE N.RO 520 )","address2":"","city":"Napoli","province":"Napoli","country":"Italy","zip":"80131","phone":"+393487333027","name":"COSIMO COLACI","province_code":"NA","country_code":"IT","country_name":"Italy","default":true}},"discount_applications":[],"fulfillments":[],'
		.'"financial_status":"pending","email":"cosimocolaci@libero.it","title":"for map","line_items":['
		.'{"id":129763,"admin_graphql_api_id":"gid:\/\/shopify\/LineItem\/129763","destination_location":{"id":3545661800693,"country_code":"IT","province_code":"NA","name":"COSIMO COLACI","address1":"VIALE COLLI ANIMEI   279  ( CITOFONARE N.RO 520 )","address2":"","city":"Napoli","zip":"80131"},"fulfillable_quantity":6,"fulfillment_service":"manual","fulfillment_status":null,"gift_card":false,"grams":0,"name":"Ribolla Gialla I.G.P. Venezia Giulia","origin_location":{"id":3358754865397,"country_code":"IT","province_code":"","name":"Conti Dagostino","address1":"","address2":"","city":"","zip":""},"price":"14.10","price_set":{"shop_money":{"amount":"14.10","currency_code":"EUR"},"presentment_money":{"amount":"14.10","currency_code":"EUR"}},"product_exists":true,"product_id":7445892497653,"properties":[],"quantity":6,"requires_shipping":true,"sku":"","taxable":true,"title":"Ribolla Gialla I.G.P. Venezia Giulia","total_discount":"0.00","total_discount_set":{"shop_money":{"amount":"0.00","currency_code":"EUR"},"presentment_money":{"amount":"0.00","currency_code":"EUR"}},"variant_id":42056900706549,"variant_inventory_management":null,"variant_title":"","vendor":"Conti Dagostino Wines","tax_lines":[],"duties":[],"discount_allocations":[]},'
		.'{"id":222222,"admin_graphql_api_id":"gid:\/\/shopify\/LineItem\/222222","destination_location":{"id":3545661800693,"country_code":"IT","province_code":"NA","name":"COSIMO COLACI","address1":"VIALE COLLI ANIMEI   279  ( CITOFONARE N.RO 520 )","address2":"","city":"Napoli","zip":"80131"},"fulfillable_quantity":6,"fulfillment_service":"manual","fulfillment_status":null,"gift_card":true,"grams":0,"name":"TestLine","origin_location":{"id":3358754865397,"country_code":"IT","province_code":"","name":"Conti Dagostino","address1":"","address2":"","city":"","zip":""},"price":"08.22","price_set":{"shop_money":{"amount":"14.10","currency_code":"EUR"},"presentment_money":{"amount":"14.10","currency_code":"EUR"}},"product_exists":true,"product_id":7445892497653,"properties":[],"quantity":2,"requires_shipping":true,"sku":"","taxable":true,"title":"test title Giulia","total_discount":"0.00","total_discount_set":{"shop_money":{"amount":"0.00","currency_code":"EUR"},"presentment_money":{"amount":"0.00","currency_code":"EUR"}},"variant_id":42056900706549,"variant_inventory_management":null,"variant_title":"","vendor":"Conti Dagostino Wines","tax_lines":[],"duties":[],"discount_allocations":[]}'
		.'],"payment_terms":{"id":8628568309,"created_at":"2022-09-06T14:13:35+02:00","due_in_days":null,"payment_schedules":[{"id":9677865205,"amount":"84.60","currency":"EUR","issued_at":null,"due_at":null,"completed_at":null,"created_at":"2022-09-06T14:13:35+02:00","updated_at":"2022-09-06T14:13:35+02:00"}],"payment_terms_name":"Due on receipt","payment_terms_type":"receipt","updated_at":"2022-09-06T14:13:35+02:00"},"refunds":[],"shipping_address":{"first_name":"COSIMO","address1":"VIALE COLLI ANIMEI   279  ( CITOFONARE N.RO 520 )","phone":"+393487333027","city":"Napoli","zip":"80131","province":"Napoli","country":"Italy","last_name":"COLACI","address2":"","company":"","latitude":40.8704855,"longitude":14.2386034,"name":"COSIMO COLACI","country_code":"IT","province_code":"NA"},"shipping_lines":[]}]';
		$array = json_decode($json, true);
		$cleanup = 'destination_location,admin_graphql_api_id,sku,fulfillable_quantity,fulfillment_service,fulfillment_status,gift_card,grams,name,origin_location,price,price_set,product_exists,product_id,properties,requires_shipping,taxable,title,total_discount,total_discount_set,variant_id,variant_inventory_management,variant_title,vendor,tax_lines,duties,discount_allocations';
		$params = [$array, 44991, 'line_items', 44990, $cleanup];
		$expected = [
			[
				'element' => [
					'pdoInfo' => [
						[
							'id' => 129763,
							'quantity' => 6,
							'productid' => 'Ribolla Gialla I.G.P. Venezia Giulia',
							'account_id' => false,
							'cost_gross' => '14.10',
							'description' => 'Ribolla Gialla I.G.P. Venezia Giulia',
						],
						[
							'id' => 222222,
							'quantity' => 2,
							'productid' => 'TestLine',
							'account_id' => true,
							'cost_gross' => '08.22',
							'description' => 'test title Giulia',
						],
					],
					'getorederresponse' => 4999344095477,
					'pl_gross_total' => '84.60',
					'pl_gross_totalcorrect' => '84.60',
					'cf_735' => 'cosimocolaci@libero.it',
					'sostatus' => 'pending',
					'subject' => 'for map',
				],
				'referenceId' => 4999344095477,
				'elementType' => 'SalesOrder',
			]
		];
		$this->assertEquals($expected, __cb_applymaptoarrayelementsandsubarray($params), 'shopify > masscreate');
		/////////  two elements
		$json = '[{"id":4999344095477,"admin_graphql_api_id":"gid:\/\/shopify\/Order\/4999344095477","app_id":1354745,"browser_ip":null,"buyer_accepts_marketing":true,"cancel_reason":null,"cancelled_at":null,"cart_token":null,"checkout_id":33286484459765,"checkout_token":"8e34261b56a6a1c66789bc1f23189b75","client_details":{"accept_language":null,"browser_height":null,"browser_ip":null,"browser_width":null,"session_hash":null,"user_agent":null},"closed_at":null,"confirmed":true,"contact_email":"cosimocolaci@libero.it","created_at":"2022-09-06T14:13:35+02:00","currency":"EUR","current_subtotal_price":"84.60","current_subtotal_price_set":{"shop_money":{"amount":"84.60","currency_code":"EUR"},"presentment_money":{"amount":"84.60","currency_code":"EUR"}},"current_total_discounts":"0.00","current_total_discounts_set":{"shop_money":{"amount":"0.00","currency_code":"EUR"},"presentment_money":{"amount":"0.00","currency_code":"EUR"}},"current_total_duties_set":null,"current_total_price":"84.60","current_total_price_set":{"shop_money":{"amount":"84.60","currency_code":"EUR"},"presentment_money":{"amount":"84.60","currency_code":"EUR"}},"current_total_tax":"0.00","current_total_tax_set":{"shop_money":{"amount":"0.00","currency_code":"EUR"},"presentment_money":{"amount":"0.00","currency_code":"EUR"}},"customer_locale":"it","device_id":null,"discount_codes":[],"estimated_taxes":false,"fulfillment_status":null,"gateway":"manual","landing_site":null,"landing_site_ref":null,"location_id":null,"name":"#1102","note":null,"note_attributes":[],"number":102,"order_number":1102,"order_status_url":"https:\/\/contidagostino.it\/61111140597\/orders\/9fb19e91be731952ad5d1965cad9cbd8\/authenticate?key=9f70a5ceb912496a16e092e2d9ba65b1","original_total_duties_set":null,"payment_gateway_names":["manual"],"phone":null,"presentment_currency":"EUR","processed_at":"2022-09-06T14:13:35+02:00","processing_method":"manual","reference":null,"referring_site":null,"source_identifier":null,"source_name":"shopify_draft_order","source_url":null,"subtotal_price":"84.60","subtotal_price_set":{"shop_money":{"amount":"84.60","currency_code":"EUR"},"presentment_money":{"amount":"84.60","currency_code":"EUR"}},"tags":"","tax_lines":[],"taxes_included":true,"test":false,"token":"9fb19e91be731952ad5d1965cad9cbd8","total_discounts":"0.00","total_discounts_set":{"shop_money":{"amount":"0.00","currency_code":"EUR"},"presentment_money":{"amount":"0.00","currency_code":"EUR"}},"total_line_items_price":"84.60","total_line_items_price_set":{"shop_money":{"amount":"84.60","currency_code":"EUR"},"presentment_money":{"amount":"84.60","currency_code":"EUR"}},"total_outstanding":"84.60","total_price":"84.60","total_price_set":{"shop_money":{"amount":"84.60","currency_code":"EUR"},"presentment_money":{"amount":"84.60","currency_code":"EUR"}},"total_price_usd":"84.18","total_shipping_price_set":{"shop_money":{"amount":"0.00","currency_code":"EUR"},"presentment_money":{"amount":"0.00","currency_code":"EUR"}},"total_tax":"0.00","total_tax_set":{"shop_money":{"amount":"0.00","currency_code":"EUR"},"presentment_money":{"amount":"0.00","currency_code":"EUR"}},"total_tip_received":"0.00","total_weight":0,"updated_at":"2022-09-06T14:13:36+02:00","user_id":78724923637,"billing_address":{"first_name":"COSIMO","address1":"VIALE COLLI ANIMEI   279  ( CITOFONARE N.RO 520 )","phone":"+393487333027","city":"Napoli","zip":"80131","province":"Napoli","country":"Italy","last_name":"COLACI","address2":"","company":"","latitude":40.8704855,"longitude":14.2386034,"name":"COSIMO COLACI","country_code":"IT","province_code":"NA"},"customer":{"id":6476096930037,"email":"cosimocolaci@libero.it","accepts_marketing":true,"created_at":"2022-09-06T14:11:33+02:00","updated_at":"2022-09-06T14:11:44+02:00","first_name":"COSIMO","last_name":"COLACI","orders_count":0,"state":"disabled","total_spent":"0.00","last_order_id":null,"note":null,"verified_email":true,"multipass_identifier":null,"tax_exempt":false,"tags":"","last_order_name":null,"currency":"EUR","phone":null,"accepts_marketing_updated_at":"2022-09-06T14:11:44+02:00","marketing_opt_in_level":"single_opt_in","tax_exemptions":[],"sms_marketing_consent":null,"admin_graphql_api_id":"gid:\/\/shopify\/Customer\/6476096930037","default_address":{"id":7958097363189,"customer_id":6476096930037,"first_name":"COSIMO","last_name":"COLACI","company":"","address1":"VIALE COLLI ANIMEI   279  ( CITOFONARE N.RO 520 )","address2":"","city":"Napoli","province":"Napoli","country":"Italy","zip":"80131","phone":"+393487333027","name":"COSIMO COLACI","province_code":"NA","country_code":"IT","country_name":"Italy","default":true}},"discount_applications":[],"fulfillments":[],'
		.'"financial_status":"pending","email":"cosimocolaci@libero.it","title":"for map","line_items":['
		.'{"id":129763,"admin_graphql_api_id":"gid:\/\/shopify\/LineItem\/129763","destination_location":{"id":3545661800693,"country_code":"IT","province_code":"NA","name":"COSIMO COLACI","address1":"VIALE COLLI ANIMEI   279  ( CITOFONARE N.RO 520 )","address2":"","city":"Napoli","zip":"80131"},"fulfillable_quantity":6,"fulfillment_service":"manual","fulfillment_status":null,"gift_card":false,"grams":0,"name":"Ribolla Gialla I.G.P. Venezia Giulia","origin_location":{"id":3358754865397,"country_code":"IT","province_code":"","name":"Conti Dagostino","address1":"","address2":"","city":"","zip":""},"price":"14.10","price_set":{"shop_money":{"amount":"14.10","currency_code":"EUR"},"presentment_money":{"amount":"14.10","currency_code":"EUR"}},"product_exists":true,"product_id":7445892497653,"properties":[],"quantity":6,"requires_shipping":true,"sku":"","taxable":true,"title":"Ribolla Gialla I.G.P. Venezia Giulia","total_discount":"0.00","total_discount_set":{"shop_money":{"amount":"0.00","currency_code":"EUR"},"presentment_money":{"amount":"0.00","currency_code":"EUR"}},"variant_id":42056900706549,"variant_inventory_management":null,"variant_title":"","vendor":"Conti Dagostino Wines","tax_lines":[],"duties":[],"discount_allocations":[]},'
		.'{"id":222222,"admin_graphql_api_id":"gid:\/\/shopify\/LineItem\/222222","destination_location":{"id":3545661800693,"country_code":"IT","province_code":"NA","name":"COSIMO COLACI","address1":"VIALE COLLI ANIMEI   279  ( CITOFONARE N.RO 520 )","address2":"","city":"Napoli","zip":"80131"},"fulfillable_quantity":6,"fulfillment_service":"manual","fulfillment_status":null,"gift_card":true,"grams":0,"name":"TestLine","origin_location":{"id":3358754865397,"country_code":"IT","province_code":"","name":"Conti Dagostino","address1":"","address2":"","city":"","zip":""},"price":"08.22","price_set":{"shop_money":{"amount":"14.10","currency_code":"EUR"},"presentment_money":{"amount":"14.10","currency_code":"EUR"}},"product_exists":true,"product_id":7445892497653,"properties":[],"quantity":2,"requires_shipping":true,"sku":"","taxable":true,"title":"test title Giulia","total_discount":"0.00","total_discount_set":{"shop_money":{"amount":"0.00","currency_code":"EUR"},"presentment_money":{"amount":"0.00","currency_code":"EUR"}},"variant_id":42056900706549,"variant_inventory_management":null,"variant_title":"","vendor":"Conti Dagostino Wines","tax_lines":[],"duties":[],"discount_allocations":[]}'
		.'],"payment_terms":{"id":8628568309,"created_at":"2022-09-06T14:13:35+02:00","due_in_days":null,"payment_schedules":[{"id":9677865205,"amount":"84.60","currency":"EUR","issued_at":null,"due_at":null,"completed_at":null,"created_at":"2022-09-06T14:13:35+02:00","updated_at":"2022-09-06T14:13:35+02:00"}],"payment_terms_name":"Due on receipt","payment_terms_type":"receipt","updated_at":"2022-09-06T14:13:35+02:00"},"refunds":[],"shipping_address":{"first_name":"COSIMO","address1":"VIALE COLLI ANIMEI   279  ( CITOFONARE N.RO 520 )","phone":"+393487333027","city":"Napoli","zip":"80131","province":"Napoli","country":"Italy","last_name":"COLACI","address2":"","company":"","latitude":40.8704855,"longitude":14.2386034,"name":"COSIMO COLACI","country_code":"IT","province_code":"NA"},"shipping_lines":[]},{"id":4999344095477,"admin_graphql_api_id":"gid:\/\/shopify\/Order\/4999344095477","app_id":1354745,"browser_ip":null,"buyer_accepts_marketing":true,"cancel_reason":null,"cancelled_at":null,"cart_token":null,"checkout_id":33286484459765,"checkout_token":"8e34261b56a6a1c66789bc1f23189b75","client_details":{"accept_language":null,"browser_height":null,"browser_ip":null,"browser_width":null,"session_hash":null,"user_agent":null},"closed_at":null,"confirmed":true,"contact_email":"cosimocolaci@libero.it","created_at":"2022-09-06T14:13:35+02:00","currency":"EUR","current_subtotal_price":"84.60","current_subtotal_price_set":{"shop_money":{"amount":"84.60","currency_code":"EUR"},"presentment_money":{"amount":"84.60","currency_code":"EUR"}},"current_total_discounts":"0.00","current_total_discounts_set":{"shop_money":{"amount":"0.00","currency_code":"EUR"},"presentment_money":{"amount":"0.00","currency_code":"EUR"}},"current_total_duties_set":null,"current_total_price":"84.60","current_total_price_set":{"shop_money":{"amount":"84.60","currency_code":"EUR"},"presentment_money":{"amount":"84.60","currency_code":"EUR"}},"current_total_tax":"0.00","current_total_tax_set":{"shop_money":{"amount":"0.00","currency_code":"EUR"},"presentment_money":{"amount":"0.00","currency_code":"EUR"}},"customer_locale":"it","device_id":null,"discount_codes":[],"estimated_taxes":false,"fulfillment_status":null,"gateway":"manual","landing_site":null,"landing_site_ref":null,"location_id":null,"name":"#1102","note":null,"note_attributes":[],"number":102,"order_number":1102,"order_status_url":"https:\/\/contidagostino.it\/61111140597\/orders\/9fb19e91be731952ad5d1965cad9cbd8\/authenticate?key=9f70a5ceb912496a16e092e2d9ba65b1","original_total_duties_set":null,"payment_gateway_names":["manual"],"phone":null,"presentment_currency":"EUR","processed_at":"2022-09-06T14:13:35+02:00","processing_method":"manual","reference":null,"referring_site":null,"source_identifier":null,"source_name":"shopify_draft_order","source_url":null,"subtotal_price":"84.60","subtotal_price_set":{"shop_money":{"amount":"84.60","currency_code":"EUR"},"presentment_money":{"amount":"84.60","currency_code":"EUR"}},"tags":"","tax_lines":[],"taxes_included":true,"test":false,"token":"9fb19e91be731952ad5d1965cad9cbd8","total_discounts":"0.00","total_discounts_set":{"shop_money":{"amount":"0.00","currency_code":"EUR"},"presentment_money":{"amount":"0.00","currency_code":"EUR"}},"total_line_items_price":"84.60","total_line_items_price_set":{"shop_money":{"amount":"84.60","currency_code":"EUR"},"presentment_money":{"amount":"84.60","currency_code":"EUR"}},"total_outstanding":"84.60","total_price":"84.60","total_price_set":{"shop_money":{"amount":"84.60","currency_code":"EUR"},"presentment_money":{"amount":"84.60","currency_code":"EUR"}},"total_price_usd":"84.18","total_shipping_price_set":{"shop_money":{"amount":"0.00","currency_code":"EUR"},"presentment_money":{"amount":"0.00","currency_code":"EUR"}},"total_tax":"0.00","total_tax_set":{"shop_money":{"amount":"0.00","currency_code":"EUR"},"presentment_money":{"amount":"0.00","currency_code":"EUR"}},"total_tip_received":"0.00","total_weight":0,"updated_at":"2022-09-06T14:13:36+02:00","user_id":78724923637,"billing_address":{"first_name":"COSIMO","address1":"VIALE COLLI ANIMEI   279  ( CITOFONARE N.RO 520 )","phone":"+393487333027","city":"Napoli","zip":"80131","province":"Napoli","country":"Italy","last_name":"COLACI","address2":"","company":"","latitude":40.8704855,"longitude":14.2386034,"name":"COSIMO COLACI","country_code":"IT","province_code":"NA"},"customer":{"id":6476096930037,"email":"cosimocolaci@libero.it","accepts_marketing":true,"created_at":"2022-09-06T14:11:33+02:00","updated_at":"2022-09-06T14:11:44+02:00","first_name":"COSIMO","last_name":"COLACI","orders_count":0,"state":"disabled","total_spent":"0.00","last_order_id":null,"note":null,"verified_email":true,"multipass_identifier":null,"tax_exempt":false,"tags":"","last_order_name":null,"currency":"EUR","phone":null,"accepts_marketing_updated_at":"2022-09-06T14:11:44+02:00","marketing_opt_in_level":"single_opt_in","tax_exemptions":[],"sms_marketing_consent":null,"admin_graphql_api_id":"gid:\/\/shopify\/Customer\/6476096930037","default_address":{"id":7958097363189,"customer_id":6476096930037,"first_name":"COSIMO","last_name":"COLACI","company":"","address1":"VIALE COLLI ANIMEI   279  ( CITOFONARE N.RO 520 )","address2":"","city":"Napoli","province":"Napoli","country":"Italy","zip":"80131","phone":"+393487333027","name":"COSIMO COLACI","province_code":"NA","country_code":"IT","country_name":"Italy","default":true}},"discount_applications":[],"fulfillments":[],'
		.'"financial_status":"pending","email":"cosimocolaci@libero.it","title":"for map","line_items":['
		.'{"id":129763,"admin_graphql_api_id":"gid:\/\/shopify\/LineItem\/129763","destination_location":{"id":3545661800693,"country_code":"IT","province_code":"NA","name":"COSIMO COLACI","address1":"VIALE COLLI ANIMEI   279  ( CITOFONARE N.RO 520 )","address2":"","city":"Napoli","zip":"80131"},"fulfillable_quantity":6,"fulfillment_service":"manual","fulfillment_status":null,"gift_card":false,"grams":0,"name":"Ribolla Gialla I.G.P. Venezia Giulia","origin_location":{"id":3358754865397,"country_code":"IT","province_code":"","name":"Conti Dagostino","address1":"","address2":"","city":"","zip":""},"price":"14.10","price_set":{"shop_money":{"amount":"14.10","currency_code":"EUR"},"presentment_money":{"amount":"14.10","currency_code":"EUR"}},"product_exists":true,"product_id":7445892497653,"properties":[],"quantity":6,"requires_shipping":true,"sku":"","taxable":true,"title":"Ribolla Gialla I.G.P. Venezia Giulia","total_discount":"0.00","total_discount_set":{"shop_money":{"amount":"0.00","currency_code":"EUR"},"presentment_money":{"amount":"0.00","currency_code":"EUR"}},"variant_id":42056900706549,"variant_inventory_management":null,"variant_title":"","vendor":"Conti Dagostino Wines","tax_lines":[],"duties":[],"discount_allocations":[]},'
		.'{"id":222222,"admin_graphql_api_id":"gid:\/\/shopify\/LineItem\/222222","destination_location":{"id":3545661800693,"country_code":"IT","province_code":"NA","name":"COSIMO COLACI","address1":"VIALE COLLI ANIMEI   279  ( CITOFONARE N.RO 520 )","address2":"","city":"Napoli","zip":"80131"},"fulfillable_quantity":6,"fulfillment_service":"manual","fulfillment_status":null,"gift_card":true,"grams":0,"name":"TestLine","origin_location":{"id":3358754865397,"country_code":"IT","province_code":"","name":"Conti Dagostino","address1":"","address2":"","city":"","zip":""},"price":"08.22","price_set":{"shop_money":{"amount":"14.10","currency_code":"EUR"},"presentment_money":{"amount":"14.10","currency_code":"EUR"}},"product_exists":true,"product_id":7445892497653,"properties":[],"quantity":2,"requires_shipping":true,"sku":"","taxable":true,"title":"test title Giulia","total_discount":"0.00","total_discount_set":{"shop_money":{"amount":"0.00","currency_code":"EUR"},"presentment_money":{"amount":"0.00","currency_code":"EUR"}},"variant_id":42056900706549,"variant_inventory_management":null,"variant_title":"","vendor":"Conti Dagostino Wines","tax_lines":[],"duties":[],"discount_allocations":[]}'
		.'],"payment_terms":{"id":8628568309,"created_at":"2022-09-06T14:13:35+02:00","due_in_days":null,"payment_schedules":[{"id":9677865205,"amount":"84.60","currency":"EUR","issued_at":null,"due_at":null,"completed_at":null,"created_at":"2022-09-06T14:13:35+02:00","updated_at":"2022-09-06T14:13:35+02:00"}],"payment_terms_name":"Due on receipt","payment_terms_type":"receipt","updated_at":"2022-09-06T14:13:35+02:00"},"refunds":[],"shipping_address":{"first_name":"COSIMO","address1":"VIALE COLLI ANIMEI   279  ( CITOFONARE N.RO 520 )","phone":"+393487333027","city":"Napoli","zip":"80131","province":"Napoli","country":"Italy","last_name":"COLACI","address2":"","company":"","latitude":40.8704855,"longitude":14.2386034,"name":"COSIMO COLACI","country_code":"IT","province_code":"NA"},"shipping_lines":[]}]';
		$array = json_decode($json, true);
		$cleanup = 'destination_location,admin_graphql_api_id,sku,fulfillable_quantity,fulfillment_service,fulfillment_status,gift_card,grams,name,origin_location,price,price_set,product_exists,product_id,properties,requires_shipping,taxable,title,total_discount,total_discount_set,variant_id,variant_inventory_management,variant_title,vendor,tax_lines,duties,discount_allocations';
		$params = [$array, 44991, 'line_items', 44990, $cleanup];
		$expected = [$expected[0], $expected[0]];
		$this->assertEquals($expected, __cb_applymaptoarrayelementsandsubarray($params), 'shopify > masscreate');
	}
}
?>