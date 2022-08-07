<?php
/*************************************************************************************************
 * Copyright 2021 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

include_once 'modules/com_vtiger_workflow/tasks/wfExecExpression.php';

class wfExecExpressionTest extends TestCase {

	private $JSONResponse = '{
		"message": "Successful",
		"status": 200,
		"data": [
			{
				"fleet_id": 824297,
				"fleet_name": "Gaetano Sanfilippo",
				"fields": {
					"app_optional_fields": [
						{
							"label": "accept",
							"value": "1"
						},
						{
							"label": "notes",
							"value": 1,
							"required": 1
						},
						{
							"label": "images",
							"value": 1,
							"required": 1
						}
					],
					"custom_field": [
						{
							"label": "total_fare",
							"display_name": "total fare",
							"data_type": "Number",
							"app_side": "2",
							"required": 0,
							"value": 0,
							"data": "8.42",
							"input": "",
							"before_start": 0,
							"template_id": "Pickup"
						},
						{
							"label": "payment_method",
							"display_name": "payment method",
							"data_type": "Text",
							"app_side": "2",
							"required": 0,
							"value": 0,
							"data": 8,
							"input": "",
							"before_start": 0,
							"template_id": "Pickup"
						},
						{
							"label": "Payment_Type",
							"display_name": "Payment Type",
							"data_type": "Dropdown",
							"app_side": "2",
							"required": 0,
							"value": 0,
							"data": "Pay by cash,Pay by card",
							"input": "Pay by cash,Pay by card",
							"before_start": 0,
							"template_id": "Pickup",
							"dropdown": [
								{
									"id": 0,
									"value": "Pay by cash"
								},
								{
									"id": 1,
									"value": "Pay by card"
								}
							],
							"fleet_data": "Pay by cash"
						}
					],
					"extras": {
						"req_popup": [],
						"invoice_html": ""
					},
					"ref_images": [],
					"req_popup": "",
					"tracking_link": "https://jngl.ml/b21bAJb55"
				}
			},
			{
				"fleet_id": 824297,
				"fleet_name": "Gaetano Sanfilippo",
				"fields": {
					"app_optional_fields": [
						{
							"label": "accept",
							"value": "1"
						},
						{
							"label": "notes",
							"value": 1,
							"required": 1
						},
						{
							"label": "images",
							"value": 1,
							"required": 1
						}
					],
					"custom_field": [
						{
							"label": "total_fare",
							"display_name": "total fare",
							"data_type": "Number",
							"app_side": "2",
							"required": 0,
							"value": 0,
							"data": "8.42",
							"input": "",
							"before_start": 0,
							"template_id": "Pickup"
						},
						{
							"label": "payment_method",
							"display_name": "payment method",
							"data_type": "Text",
							"app_side": "2",
							"required": 0,
							"value": 0,
							"data": 8,
							"input": "",
							"before_start": 0,
							"template_id": "Pickup"
						},
						{
							"label": "Payment_Type",
							"display_name": "Payment Type",
							"data_type": "Dropdown",
							"app_side": "2",
							"required": 0,
							"value": 0,
							"data": "Pay by cash,Pay by card",
							"input": "Pay by cash,Pay by card",
							"before_start": 0,
							"template_id": "Pickup",
							"dropdown": [
								{
									"id": 0,
									"value": "Pay by cash"
								},
								{
									"id": 1,
									"value": "Pay by card"
								}
							],
							"fleet_data": "Pay by cash"
						}
					],
					"extras": {
						"req_popup": [],
						"invoice_html": ""
					},
					"ref_images": [],
					"req_popup": "",
					"tracking_link": "https://jngl.ml/Weff207W5"
				}
			}
		]
	}';

	/**
	 * Method execexpProvider
	 * params
	 */
	public function execexpProvider() {
		return array(
			array('', '11x74', array()),
			array('[{"exp":"any string","typ":"rawtext","var":"avar"}]', '11x74', array('avar' => 'any string')),
			array('[{"exp":"any string","typ":"rawtext","var":""}]', '11x74', array()),
			array('[{"exp":"accountname","typ":"fieldname","var":"avar"}]', '11x74', array('avar' => 'Chemex Labs Ltd')),
			array('[{"exp":"uppercase(accountname)","typ":"expression","var":"avar"}]', '11x74', array(
				'avar' => 'CHEMEX LABS LTD',
				'current_row' => array(
					'accountname' => 'Chemex Labs Ltd',
					'account_no' => 'ACC1',
					'website' => 'http://www.chemexlabsltd.com.au',
					'phone' => '03-3608-5660',
					'tickersymbol' => '',
					'fax' => '',
					'account_id' => '11x746',
					'otherphone' => '0487-835-113',
					'employees' => '131',
					'email1' => 'lina@yahoo.com',
					'email2' => '',
					'ownership' => '',
					'industry' => 'Engineering',
					'rating' => 'Active',
					'accounttype' => 'Press',
					'siccode' => '',
					'emailoptout' => '1',
					'annual_revenue' => '3045164.000000',
					'assigned_user_id' => '19x10',
					'notify_owner' => '0',
					'modifiedtime' => '2016-04-02 18:21:14',
					'createdtime' => '2015-03-13 18:24:30',
					'modifiedby' => '19x1',
					'isconvertedfromlead' => '',
					'convertedfromlead' => '',
					'created_user_id' => '19x1',
					'cf_718' => '',
					'cf_719' => '2.00',
					'cf_720' => '0.00',
					'cf_721' => '0.000000',
					'cf_722' => '2016-02-15',
					'cf_723' => '',
					'cf_724' => '',
					'cf_725' => '',
					'cf_726' => '0',
					'cf_727' => '',
					'cf_728' => '00:00:00',
					'cf_729' => 'one',
					'cf_730' => 'oneone',
					'cf_731' => 'oneoneone',
					'cf_732' => 'Adipose 3 |##| Chronos |##| Earth',
					'bill_street' => 'C/ Joan Fuster 12',
					'ship_street' => 'C/ Joan Fuster 12',
					'bill_pobox' => '',
					'ship_pobox' => '',
					'bill_city' => 'Els Poblets',
					'ship_city' => 'Els Poblets',
					'bill_state' => 'Alicante',
					'ship_state' => 'Alicante',
					'bill_code' => '03779',
					'ship_code' => '03779',
					'bill_country' => 'Spain',
					'ship_country' => 'Spain',
					'description' => 'Aut unde est hoc contritum vetustate proverbium: quicum in tenebris? Nec vero alia sunt quaerenda contra Carneadeam illam sententiam. Nemo igitur esse beatus potest. Nummus in Croesi divitiis obscuratur, pars est tamen divitiarum.',
					'id' => '11x74',
					'cbuuid' => 'b0857db0c1dee95300a10982853f5fb1d4e981c1',
					'account_idename' => array(
						'module' => 'Accounts',
						'reference' => 'Rowley Schlimgen Inc',
						'cbuuid' => '88cbf7cc2c70eec1e2c733a6624a8eb427c8eb1e',
					),
					'modifiedbyename' => array(
						'module' => 'Users',
						'reference' => ' Administrator',
						'cbuuid' => '',
					),
					'created_user_idename' => array(
						'module' => 'Users',
						'reference' => ' Administrator',
						'cbuuid' => '',
					),
					'assigned_user_idename' => array(
						'module' => 'Users',
						'reference' => 'cbTest testtz',
						'cbuuid' => '',
					),
				),
			)),
		);
	}

	/**
	 * Method testexecexp
	 * @test
	 * @dataProvider execexpProvider
	 */
	public function testexecexp($expression, $entityId, $expected) {
		global $current_user;
		$rwftsk = new wfExecExpression();
		$rwftsk->wfexeexps = $expression;
		$util = new VTWorkflowUtils();
		$adminUser = $util->adminUser();
		$current_user = $adminUser;
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$entity->WorkflowContext = array();
		$rwftsk->doTask($entity);
		$this->assertEquals($expected, $entity->WorkflowContext);
	}

	/**
	 * Method complexJSONProvider
	 * params
	 */
	public function complexJSONProvider() {
		$context = array(
			'response' => json_decode($this->JSONResponse, true),
		);
		return array(
			array(
				'[{"exp":"setToContext(\'avar\', getFromContext(\'response\'))","typ":"expression","var":""}]',
				'11x74',
				array(
					'response' => $this->JSONResponse,
				),
				array('response' => $this->JSONResponse, 'avar' => $this->JSONResponse)
			),
			array(
				'[{"exp":"setToContext(\'avar\', getFromContext(\'response.message\'))","typ":"expression","var":""}]',
				'11x74',
				$context,
				array('response' => json_decode($this->JSONResponse, true), 'avar' => 'Successful')
			),
			array(
				'[{"exp":"setToContext(\'avar\', getFromContext(\'response.data.0.fleet_id\'))","typ":"expression","var":""}]',
				'11x74',
				$context,
				array('response' => json_decode($this->JSONResponse, true), 'avar' => '824297')
			),
			array(
				'[{"exp":"getFromContext(\'response.data.0.fleet_id\')","typ":"expression","var":"avar"}]',
				'11x74',
				$context,
				array('response' => json_decode($this->JSONResponse, true), 'avar' => '824297')
			),
			array(
				'[{"exp":"getFromContext(\'response.data.0.fields.custom_field\')","typ":"expression","var":"avar"}]',
				'11x74',
				$context,
				array('response' => json_decode($this->JSONResponse, true), 'avar' => array(
					0 => array(
						'label' => 'total_fare',
						'display_name' => 'total fare',
						'data_type' => 'Number',
						'app_side' => '2',
						'required' => 0,
						'value' => 0,
						'data' => '8.42',
						'input' => '',
						'before_start' => 0,
						'template_id' => 'Pickup',
					),
					1 => array(
						'label' => 'payment_method',
						'display_name' => 'payment method',
						'data_type' => 'Text',
						'app_side' => '2',
						'required' => 0,
						'value' => 0,
						'data' => '8',
						'input' => '',
						'before_start' => 0,
						'template_id' => 'Pickup',
					),
					2 => array(
						'label' => 'Payment_Type',
						'display_name' => 'Payment Type',
						'data_type' => 'Dropdown',
						'app_side' => '2',
						'required' => 0,
						'value' => 0,
						'data' => 'Pay by cash,Pay by card',
						'input' => 'Pay by cash,Pay by card',
						'before_start' => 0,
						'template_id' => 'Pickup',
						'dropdown' => array(
							0 => array(
								'id' => 0,
								'value' => 'Pay by cash',
							),
							1 => array(
								'id' => 1,
								'value' => 'Pay by card',
							),
						),
						'fleet_data' => 'Pay by cash',
					),
				))
			),
			array(
				'[{"exp":"getFromContext(\'response.data.0.fields.custom_field.1.display_name\')","typ":"expression","var":"avar"}]',
				'11x74',
				$context,
				array('response' => json_decode($this->JSONResponse, true), 'avar' => 'payment method')
			),
		);
	}

	/**
	 * Method testComplexJSON
	 * @test
	 * @dataProvider complexJSONProvider
	 */
	public function testComplexJSON($expression, $entityId, $context, $expected) {
		global $current_user;
		$rwftsk = new wfExecExpression();
		$rwftsk->wfexeexps = $expression;
		$util = new VTWorkflowUtils();
		$adminUser = $util->adminUser();
		$current_user = $adminUser;
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$entity->WorkflowContext = $context;
		$rwftsk->doTask($entity);
		$this->assertEquals($expected, $entity->WorkflowContext);
	}

	/**
	 * Method complexJSONSearchProvider
	 * params
	 */
	public function complexJSONSearchProvider() {
		$context = array(
			'response' => json_decode($this->JSONResponse, true),
		);
		return array(
			array(
				'[{"exp":"getFromContextSearching(\'response.data.0.fields.custom_field\', \'label\', \'payment_method\', \'data\')","typ":"expression","var":"avar"}]',
				'11x74',
				$context,
				array('response' => json_decode($this->JSONResponse, true), 'avar' => 8)
				// array('response' => json_decode($this->JSONResponse, true), 'avar' => array(
				// 	0 => array(
				// 		'label' => 'total_fare',
				// 		'display_name' => 'total fare',
				// 		'data_type' => 'Number',
				// 		'app_side' => '2',
				// 		'required' => 0,
				// 		'value' => 0,
				// 		'data' => '8.42',
				// 		'input' => '',
				// 		'before_start' => 0,
				// 		'template_id' => 'Pickup',
				// 	),
				// 	1 => array(
				// 		'label' => 'payment_method',
				// 		'display_name' => 'payment method',
				// 		'data_type' => 'Text',
				// 		'app_side' => '2',
				// 		'required' => 0,
				// 		'value' => 0,
				// 		'data' => '8',
				// 		'input' => '',
				// 		'before_start' => 0,
				// 		'template_id' => 'Pickup',
				// 	),
				// 	2 => array(
				// 		'label' => 'Payment_Type',
				// 		'display_name' => 'Payment Type',
				// 		'data_type' => 'Dropdown',
				// 		'app_side' => '2',
				// 		'required' => 0,
				// 		'value' => 0,
				// 		'data' => 'Pay by cash,Pay by card',
				// 		'input' => 'Pay by cash,Pay by card',
				// 		'before_start' => 0,
				// 		'template_id' => 'Pickup',
				// 		'dropdown' => array(
				// 			0 => array(
				// 				'id' => 0,
				// 				'value' => 'Pay by cash',
				// 			),
				// 			1 => array(
				// 				'id' => 1,
				// 				'value' => 'Pay by card',
				// 			),
				// 		),
				// 		'fleet_data' => 'Pay by cash',
				// 	),
				//))
			),
			array(
				'[{"exp":"getFromContextSearching(\'response.data.0.fields.custom_field\', \'label\', \'Payment_Type\', \'dropdown.1.value\')","typ":"expression","var":"avar"}]',
				'11x74',
				$context,
				array('response' => json_decode($this->JSONResponse, true), 'avar' => 'Pay by card')
			),
			array(
				'[{"exp":"getFromContextSearching(\'response.data.0.fields.custom_field\', \'label\', \'Payment_Type\', \'fleet_data\')","typ":"expression","var":"avar"}]',
				'11x74',
				$context,
				array('response' => json_decode($this->JSONResponse, true), 'avar' => 'Pay by cash')
			),
		);
	}

	/**
	 * Method testComplexJSONSearch
	 * @test
	 * @dataProvider complexJSONSearchProvider
	 */
	public function testComplexJSONSearch($expression, $entityId, $context, $expected) {
		global $current_user;
		$rwftsk = new wfExecExpression();
		$rwftsk->wfexeexps = $expression;
		$util = new VTWorkflowUtils();
		$adminUser = $util->adminUser();
		$current_user = $adminUser;
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$entity->WorkflowContext = $context;
		$rwftsk->doTask($entity);
		$this->assertEquals($expected, $entity->WorkflowContext);
	}
}
