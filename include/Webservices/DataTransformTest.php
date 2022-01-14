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

class DataTransformTest extends TestCase {

	/****
	 * TEST Users decimal configuration
	 * name format is: {decimal_separator}{symbol_position}{grouping}{grouping_symbol}{currency}
	 ****/
	private $usrdota0x = 5; // testdmy 2 decimal places
	private $usrcomd0x = 6; // testmdy 3 decimal places
	private $usrdotd3com = 7; // testymd 4 decimal places
	private $usrcoma3dot = 10; // testtz 5 decimal places
	private $usrdota3comdollar = 12; // testmcurrency 6 decimal places

	/**
	 * Method testsanitizeReferences
	 * @test
	 */
	public function testsanitizeReferences() {
		global $current_user, $adb,$log;
		$current_user = Users::getActiveAdminUser();
		$testrecord = 4062;
		$testmodule = 'Assets';
		$webserviceObject = VtigerWebserviceObject::fromName($adb, $testmodule);
		$handlerPath = $webserviceObject->getHandlerPath();
		$handlerClass = $webserviceObject->getHandlerClass();
		require_once $handlerPath;
		$handler = new $handlerClass($webserviceObject, $current_user, $adb, $log);
		$meta = $handler->getMeta();
		$focus = CRMEntity::getInstance($testmodule);
		$focus->id = $testrecord;
		$focus->retrieve_entity_info($testrecord, $testmodule);
		$expected = $focus->column_fields;
		$expected['product'] = '14x2622';
		$expected['invoiceid'] = '7x3882';
		$expected['account'] = '11x142';
		$expected['modifiedby'] = '19x1';
		$expected['created_user_id'] = '19x1';
		$actual = DataTransform::sanitizeReferences($focus->column_fields, $meta);
		$this->assertEquals($expected, $actual, 'sanitizeReferences Assets');
		///////////////
		$testrecord = 16829;
		$testmodule = 'PriceBooks';
		$webserviceObject = VtigerWebserviceObject::fromName($adb, $testmodule);
		$handlerPath = $webserviceObject->getHandlerPath();
		$handlerClass = $webserviceObject->getHandlerClass();
		require_once $handlerPath;
		$handler = new $handlerClass($webserviceObject, $current_user, $adb, $log);
		$meta = $handler->getMeta();
		$focus = CRMEntity::getInstance($testmodule);
		$focus->id = $testrecord;
		$focus->retrieve_entity_info($testrecord, $testmodule);
		$expected = $focus->column_fields;
		$expected['currency_id'] = '21x1';
		$expected['modifiedby'] = '19x1';
		$expected['created_user_id'] = '19x1';
		$actual = DataTransform::sanitizeReferences($focus->column_fields, $meta);
		$this->assertEquals($expected, $actual, 'sanitizeReferences PriceBooks');
		///////////////
		$testrecord = 5321;
		$testmodule = 'Potentials';
		$webserviceObject = VtigerWebserviceObject::fromName($adb, $testmodule);
		$handlerPath = $webserviceObject->getHandlerPath();
		$handlerClass = $webserviceObject->getHandlerClass();
		require_once $handlerPath;
		$handler = new $handlerClass($webserviceObject, $current_user, $adb, $log);
		$meta = $handler->getMeta();
		$focus = CRMEntity::getInstance($testmodule);
		$focus->id = $testrecord;
		$focus->retrieve_entity_info($testrecord, $testmodule);
		$expected = $focus->column_fields;
		$expected['related_to'] = '11x658';
		$expected['campaignid'] = '1x4972';
		$expected['convertedfromlead'] = null;
		$expected['modifiedby'] = '19x1';
		$expected['created_user_id'] = '19x1';
		$actual = DataTransform::sanitizeReferences($focus->column_fields, $meta);
		$this->assertEquals($expected, $actual, 'sanitizeReferences Potentials');
		///////////////
		$testrecord = 5322;
		$testmodule = 'Potentials';
		$webserviceObject = VtigerWebserviceObject::fromName($adb, $testmodule);
		$handlerPath = $webserviceObject->getHandlerPath();
		$handlerClass = $webserviceObject->getHandlerClass();
		require_once $handlerPath;
		$handler = new $handlerClass($webserviceObject, $current_user, $adb, $log);
		$meta = $handler->getMeta();
		$focus = CRMEntity::getInstance($testmodule);
		$focus->id = $testrecord;
		$focus->retrieve_entity_info($testrecord, $testmodule);
		$expected = $focus->column_fields;
		$expected['related_to'] = '12x1614';
		$expected['campaignid'] = null;
		$expected['convertedfromlead'] = null;
		$expected['modifiedby'] = '19x1';
		$expected['created_user_id'] = '19x1';
		$actual = DataTransform::sanitizeReferences($focus->column_fields, $meta);
		$this->assertEquals($expected, $actual, 'sanitizeReferences Potentials');
		///////////////
		$testrecord = 26784;
		$testmodule = 'Emails';
		$webserviceObject = VtigerWebserviceObject::fromName($adb, $testmodule);
		$handlerPath = $webserviceObject->getHandlerPath();
		$handlerClass = $webserviceObject->getHandlerClass();
		require_once $handlerPath;
		$handler = new $handlerClass($webserviceObject, $current_user, $adb, $log);
		$meta = $handler->getMeta();
		$focus = CRMEntity::getInstance($testmodule);
		$focus->id = $testrecord;
		$focus->retrieve_entity_info($testrecord, $testmodule);
		$expected = $focus->column_fields;
		$expected['parent_id'] = '12x1084|11x74';
		$expected['modifiedby'] = '19x1';
		$actual = DataTransform::sanitizeReferences($focus->column_fields, $meta);
		$this->assertEquals($expected, $actual, 'sanitizeReferences Emails');
		///////////////
		$testrecord = 14340;
		$testmodule = 'CobroPago';
		$webserviceObject = VtigerWebserviceObject::fromName($adb, $testmodule);
		$handlerPath = $webserviceObject->getHandlerPath();
		$handlerClass = $webserviceObject->getHandlerClass();
		require_once $handlerPath;
		$handler = new $handlerClass($webserviceObject, $current_user, $adb, $log);
		$meta = $handler->getMeta();
		$focus = CRMEntity::getInstance($testmodule);
		$focus->id = $testrecord;
		$focus->retrieve_entity_info($testrecord, $testmodule);
		$expected = $focus->column_fields;
		$expected['parent_id'] = '11x87';
		$expected['related_id'] = '7x3349';
		$expected['reports_to_id'] = '';
		$expected['created_user_id'] = '19x1';
		$actual = DataTransform::sanitizeReferences($focus->column_fields, $meta);
		$this->assertEquals($expected, $actual, 'sanitizeReferences CobroPago');
		// test empty uitype 101
		$focus->column_fields['reports_to_id'] = '';
		$expected['reports_to_id'] = '';
		$actual = DataTransform::sanitizeReferences($focus->column_fields, $meta);
		$this->assertEquals($expected, $actual, 'sanitizeReferences CobroPago');
	}

	/**
	 * Method testsanitizeReferencesUUID
	 * @test
	 */
	public function testsanitizeReferencesUUID() {
		global $current_user, $adb,$log;
		$current_user = Users::getActiveAdminUser();
		$testrecord = 4062;
		$testmodule = 'Assets';
		$webserviceObject = VtigerWebserviceObject::fromName($adb, $testmodule);
		$handlerPath = $webserviceObject->getHandlerPath();
		$handlerClass = $webserviceObject->getHandlerClass();
		require_once $handlerPath;
		$handler = new $handlerClass($webserviceObject, $current_user, $adb, $log);
		$meta = $handler->getMeta();
		$focus = CRMEntity::getInstance($testmodule);
		$focus->id = $testrecord;
		$focus->retrieve_entity_info($testrecord, $testmodule);
		$expected = $focus->column_fields;
		$expected['product'] = '321dcfe3e3d45e08441ed92d4a729786d36d26bf';
		$expected['invoiceid'] = '91fbb92510ca2e475d436aa570c6343d57ab4a0f';
		$expected['account'] = '4ae76e55719a634946147da7b9fb3f89463fcfcc';
		$expected['modifiedby'] = '19x1';
		$expected['created_user_id'] = '19x1';
		$actual = DataTransform::sanitizeReferences($focus->column_fields, $meta, true);
		$this->assertEquals($expected, $actual, 'sanitizeReferences Assets');
		///////////////
		$testrecord = 16829;
		$testmodule = 'PriceBooks';
		$webserviceObject = VtigerWebserviceObject::fromName($adb, $testmodule);
		$handlerPath = $webserviceObject->getHandlerPath();
		$handlerClass = $webserviceObject->getHandlerClass();
		require_once $handlerPath;
		$handler = new $handlerClass($webserviceObject, $current_user, $adb, $log);
		$meta = $handler->getMeta();
		$focus = CRMEntity::getInstance($testmodule);
		$focus->id = $testrecord;
		$focus->retrieve_entity_info($testrecord, $testmodule);
		$expected = $focus->column_fields;
		$expected['currency_id'] = '21x1';
		$expected['modifiedby'] = '19x1';
		$expected['created_user_id'] = '19x1';
		$actual = DataTransform::sanitizeReferences($focus->column_fields, $meta, true);
		$this->assertEquals($expected, $actual, 'sanitizeReferences PriceBooks');
		///////////////
		$testrecord = 5321;
		$testmodule = 'Potentials';
		$webserviceObject = VtigerWebserviceObject::fromName($adb, $testmodule);
		$handlerPath = $webserviceObject->getHandlerPath();
		$handlerClass = $webserviceObject->getHandlerClass();
		require_once $handlerPath;
		$handler = new $handlerClass($webserviceObject, $current_user, $adb, $log);
		$meta = $handler->getMeta();
		$focus = CRMEntity::getInstance($testmodule);
		$focus->id = $testrecord;
		$focus->retrieve_entity_info($testrecord, $testmodule);
		$expected = $focus->column_fields;
		$expected['related_to'] = '809876fcb6788815c260f0d874866e266c14ff1e';
		$expected['campaignid'] = 'fcb846c8b2d9221acc5d9b16ee01b9fd42b57266';
		$expected['convertedfromlead'] = '';
		$expected['modifiedby'] = '19x1';
		$expected['created_user_id'] = '19x1';
		$actual = DataTransform::sanitizeReferences($focus->column_fields, $meta, true);
		$this->assertEquals($expected, $actual, 'sanitizeReferences PriceBooks');
		///////////////
		$testrecord = 5322;
		$testmodule = 'Potentials';
		$webserviceObject = VtigerWebserviceObject::fromName($adb, $testmodule);
		$handlerPath = $webserviceObject->getHandlerPath();
		$handlerClass = $webserviceObject->getHandlerClass();
		require_once $handlerPath;
		$handler = new $handlerClass($webserviceObject, $current_user, $adb, $log);
		$meta = $handler->getMeta();
		$focus = CRMEntity::getInstance($testmodule);
		$focus->id = $testrecord;
		$focus->retrieve_entity_info($testrecord, $testmodule);
		$expected = $focus->column_fields;
		$expected['related_to'] = 'e0f16d1bb41acecb1725303ac4cd530fd4641028';
		$expected['campaignid'] = '';
		$expected['convertedfromlead'] = '';
		$expected['modifiedby'] = '19x1';
		$expected['created_user_id'] = '19x1';
		$actual = DataTransform::sanitizeReferences($focus->column_fields, $meta, true);
		$this->assertEquals($expected, $actual, 'sanitizeReferences PriceBooks');
		///////////////
		$testrecord = 26784;
		$testmodule = 'Emails';
		$webserviceObject = VtigerWebserviceObject::fromName($adb, $testmodule);
		$handlerPath = $webserviceObject->getHandlerPath();
		$handlerClass = $webserviceObject->getHandlerClass();
		require_once $handlerPath;
		$handler = new $handlerClass($webserviceObject, $current_user, $adb, $log);
		$meta = $handler->getMeta();
		$focus = CRMEntity::getInstance($testmodule);
		$focus->id = $testrecord;
		$focus->retrieve_entity_info($testrecord, $testmodule);
		$expected = $focus->column_fields;
		$expected['parent_id'] = 'a609725772dc91ad733b19e4100cf68bb30195d1|b0857db0c1dee95300a10982853f5fb1d4e981c1';
		$expected['modifiedby'] = '19x1';
		$actual = DataTransform::sanitizeReferences($focus->column_fields, $meta, true);
		$this->assertEquals($expected, $actual, 'sanitizeReferences Emails');
	}

	public function testsanitizeCurrencyFieldsForDB() {
		global $current_user, $adb, $log;
		$rowsql = array(
			'inventorydetails_no' => 'InvDet-000000145',
			'productid' => 2616,
			'related_to' => 2973,
			'account_id' => 2972,
			'contact_id' => 1953,
			'vendor_id' => '',
			'sequence_no' => 1,
			'lineitem_id' => 145,
			'quantity' => '9',
			'listprice' => '',
			'tax_percent' => '',
			'extgross' => '437.490000',
			'discount_percent' => 0,
			'discount_amount' => 0,
			'extnet' => '1437.490000',
			'linetax' => 0,
			'linetotal' => '',
			'units_delivered_received' => 0,
			'line_completed' => 0,
			'assigned_user_id' => 1,
			'createdtime' => '10-04-2015 05:09',
			'modifiedtime' => '09-08-2015 16:12',
			'description' => '',
			'cost_price' => '22.330000',
			'cost_gross' => '198',
			'total_stock' => '',
			'created_user_id' => 1,
			'id_tax1_perc' => '',
			'id_tax2_perc' => '10.000000',
			'id_tax3_perc' => '12.500000',
			'record_id' => 2978,
			'record_module' => 'InventoryDetails',
		);
		$rowdota3com = array(
			'inventorydetails_no' => 'InvDet-000000145',
			'productid' => 2616,
			'related_to' => 2973,
			'account_id' => 2972,
			'contact_id' => 1953,
			'vendor_id' => '',
			'sequence_no' => 1,
			'lineitem_id' => 145,
			'quantity' => '9',
			'listprice' => '',
			'tax_percent' => '',
			'extgross' => '437.490000',
			'discount_percent' => 0,
			'discount_amount' => 0,
			'extnet' => '1,437.490000',
			'linetax' => 0,
			'linetotal' => '',
			'units_delivered_received' => 0,
			'line_completed' => 0,
			'assigned_user_id' => 1,
			'createdtime' => '10-04-2015 05:09',
			'modifiedtime' => '09-08-2015 16:12',
			'description' => '',
			'cost_price' => '22.330000',
			'cost_gross' => 198,
			'total_stock' => '',
			'created_user_id' => 1,
			'id_tax1_perc' => '',
			'id_tax2_perc' => '10.000000',
			'id_tax3_perc' => '12.500000',
			'record_id' => 2978,
			'record_module' => 'InventoryDetails',
		);
		$rowcoma3dot = array(
			'inventorydetails_no' => 'InvDet-000000145',
			'productid' => 2616,
			'related_to' => 2973,
			'account_id' => 2972,
			'contact_id' => 1953,
			'vendor_id' => '',
			'sequence_no' => 1,
			'lineitem_id' => 145,
			'quantity' => 9.000,
			'listprice' => '',
			'tax_percent' => '',
			'extgross' => '437,490000',
			'discount_percent' => 0,
			'discount_amount' => 0,
			'extnet' => '1.437,490000',
			'linetax' => 0,
			'linetotal' => '',
			'units_delivered_received' => 0,
			'line_completed' => 0,
			'assigned_user_id' => 1,
			'createdtime' => '10-04-2015 05:09',
			'modifiedtime' => '09-08-2015 16:12',
			'description' => '',
			'cost_price' => '22,330000',
			'cost_gross' => 198,
			'total_stock' => '',
			'created_user_id' => 1,
			'id_tax1_perc' => '',
			'id_tax2_perc' => '10,000000',
			'id_tax3_perc' => '12,500000',
			'record_id' => 2978,
			'record_module' => 'InventoryDetails',
		);
		$hcu = $current_user;
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrcoma3dot);

		$testmodule = 'InventoryDetails';
		$webserviceObject = VtigerWebserviceObject::fromName($adb, $testmodule);
		$handlerPath = $webserviceObject->getHandlerPath();
		$handlerClass = $webserviceObject->getHandlerClass();
		require_once $handlerPath;
		$handler = new $handlerClass($webserviceObject, $current_user, $adb, $log);
		$meta = $handler->getMeta();

		$actual = DataTransform::sanitizeCurrencyFieldsForDB($rowcoma3dot, $meta);
		$this->assertEquals($rowsql, $actual, 'sanitizeCurrencyFieldsForDB InventoryDetails usrcoma3dot');
		$actual = DataTransform::sanitizeDateFieldsForDB($rowcoma3dot, $meta);
		$expected = $rowcoma3dot;
		$expected['createdtime'] = '2015-04-10 03:09';
		$expected['modifiedtime'] = '2015-08-09 14:12';
		$this->assertEquals($expected, $actual, 'sanitizeDateFieldsForDB InventoryDetails usrcoma3dot');

		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrdotd3com);

		$testmodule = 'InventoryDetails';
		$webserviceObject = VtigerWebserviceObject::fromName($adb, $testmodule);
		$handlerPath = $webserviceObject->getHandlerPath();
		$handlerClass = $webserviceObject->getHandlerClass();
		require_once $handlerPath;
		$handler = new $handlerClass($webserviceObject, $current_user, $adb, $log);
		$meta = $handler->getMeta();

		$actual = DataTransform::sanitizeCurrencyFieldsForDB($rowdota3com, $meta);
		$this->assertEquals($rowsql, $actual, 'sanitizeCurrencyFieldsForDB InventoryDetails usrdotd3com');

		$current_user = $hcu;
	}

	public function testsanitizeDateFields() {
		global $current_user, $adb, $log;
		$hcu = $current_user;
		$current_user = Users::getActiveAdminUser(); // Y-m-d
		$testrecord = 4062;
		$testmodule = 'Assets';
		$webserviceObject = VtigerWebserviceObject::fromName($adb, $testmodule);
		$handlerPath = $webserviceObject->getHandlerPath();
		$handlerClass = $webserviceObject->getHandlerClass();
		require_once $handlerPath;
		$handler = new $handlerClass($webserviceObject, $current_user, $adb, $log);
		$meta = $handler->getMeta();
		$focus = CRMEntity::getInstance($testmodule);
		$focus->id = $testrecord;
		$focus->retrieve_entity_info($testrecord, $testmodule);
		$expected = $focus->column_fields;
		$expected['createdtime'] = '2015-04-20 21:07';
		$expected['modifiedtime'] = '2016-06-09 23:33';
		$actual = DataTransform::sanitizeDateFieldsForDB($focus->column_fields, $meta);
		$this->assertEquals($expected, $actual, 'sanitizeDateFieldsForDB Assets admin');
		$actual = DataTransform::sanitizeDateFieldsForInsert($focus->column_fields, $meta);
		$this->assertEquals($expected, $actual, 'sanitizeDateFieldsForInsert Assets admin');

		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrdota0x); // testdmy 2 decimal places
		$actual = DataTransform::sanitizeDateFieldsForDB($focus->column_fields, $meta);
		$expected['createdtime'] = '2015-04-20 21:07';
		$expected['modifiedtime'] = '2016-06-09 23:33';
		$this->assertEquals($expected, $actual, 'sanitizeDateFieldsForDB Assets usrdota0x');
		$actual = DataTransform::sanitizeDateFieldsForInsert($focus->column_fields, $meta);
		$expected['datesold'] = '13-05-2016';
		$expected['dateinservice'] = '21-05-2015';
		$expected['createdtime'] = '20-04-2015 21:07';
		$expected['modifiedtime'] = '09-06-2016 23:33';
		$this->assertEquals($expected, $actual, 'sanitizeDateFieldsForInsert Assets');
		$formattedFor_dmy = $expected;
		$actual = DataTransform::sanitizeDateFieldsForDB($expected, $meta);
		$expected = $focus->column_fields;
		$expected['createdtime'] = '2015-04-20 21:07';
		$expected['modifiedtime'] = '2016-06-09 23:33';
		$this->assertEquals($expected, $actual, 'sanitizeDateFieldsForDB Assets usrdota0x');

		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrcomd0x); // testmdy 3 decimal places
		$actual = DataTransform::sanitizeDateFieldsForDB($focus->column_fields, $meta);
		$expected = $focus->column_fields;
		$expected['createdtime'] = '2015-04-20 21:07';
		$expected['modifiedtime'] = '2016-06-09 23:33';
		$this->assertEquals($expected, $actual, 'sanitizeDateFieldsForDB Assets usrcomd0x');
		$actual = DataTransform::sanitizeDateFieldsForInsert($focus->column_fields, $meta);
		$expected['datesold'] = '05-13-2016';
		$expected['dateinservice'] = '05-21-2015';
		$expected['createdtime'] = '04-20-2015 21:07';
		$expected['modifiedtime'] = '06-09-2016 23:33';
		$this->assertEquals($expected, $actual, 'sanitizeDateFieldsForInsert Assets');
		$actual = DataTransform::sanitizeDateFieldsForDB($expected, $meta);
		$expected = $focus->column_fields;
		$expected['createdtime'] = '2015-04-20 21:07';
		$expected['modifiedtime'] = '2016-06-09 23:33';
		$this->assertEquals($expected, $actual, 'sanitizeDateFieldsForDB Assets usrdota0x');

		// enters wrong > comes out wrong
		$actual = DataTransform::sanitizeDateFieldsForInsert($formattedFor_dmy, $meta);
		$expected['datesold'] = '05-2016-13';
		$expected['dateinservice'] = '05-2015-21';
		$expected['createdtime'] = '04-20-2015 21:07';
		$expected['modifiedtime'] = '06-09-2016 23:33';
		$this->assertEquals($expected, $actual, 'sanitizeDateFieldsForInsert Assets');

		$current_user = $hcu;
	}

	/**
	 * Method testsanitizeRetrieveEntityInfo
	 * @test
	 */
	public function testsanitizeRetrieveEntityInfo() {
		global $current_user, $adb, $log;
		$hcu = $current_user;
		$current_user = new Users();
		$current_user->retrieveCurrentUserInfoFromFile($this->usrcoma3dot);
		$invalues = array(
			'inventorydetails_no' => 'InvDet-000000007',
			'productid' => '2634',
			'related_to' => '2816',
			'account_id' => '123',
			'contact_id' => '1292',
			'vendor_id' => 0,
			'sequence_no' => '7',
			'lineitem_id' => '7',
			'quantity' => 10.000,
			'listprice' => 78.700000, // does not have access to this field
			'tax_percent' => 0,
			'extgross' => 787.000000000,
			'discount_percent' => 0.0000000000,
			'discount_amount' => 0,
			'extnet' => 787.0000000000000000,
			'linetax' => 0,
			'linetotal' => 787.00, // does not have access to this field
			'units_delivered_received' => 3,
			'line_completed' => 0,
			'assigned_user_id' => '11',
			'description' => 'áçèñtös',
			'cost_price' => '56.45',
			'cost_gross' => 560.000000,
			'total_stock' => 295.000000,
			'created_user_id' => 1,
			'id_tax1_perc' => 4.500, // does not have access to this field
			'id_tax2_perc' => 10.000,
			'id_tax3_perc' => 12.500,
			'record_id' => 2823,
			'record_module' => 'InventoryDetails',
		);
		$expected = array(
			'inventorydetails_no' => 'InvDet-000000007',
			'productid' => '2634',
			'related_to' => '2816',
			'account_id' => '123',
			'contact_id' => '1292',
			'vendor_id' => 0,
			'sequence_no' => '7',
			'lineitem_id' => '7',
			'quantity' => '10,000000',
			'listprice' => 78.700000, // does not have access to this field
			'tax_percent' => 0,
			'extgross' => '787,000000',
			'discount_percent' => 0.0,
			'discount_amount' => 0,
			'extnet' => '787,000000',
			'linetax' => 0,
			'linetotal' => 787.00, // does not have access to this field
			'units_delivered_received' => '3,000000',
			'line_completed' => 0,
			'assigned_user_id' => '11',
			'description' => 'áçèñtös',
			'cost_price' => '56,450000',
			'cost_gross' => '560,000000',
			'total_stock' => '295,000000',
			'created_user_id' => '1',
			'id_tax1_perc' => 4.500, // does not have access to this field
			'id_tax2_perc' => '10,000000',
			'id_tax3_perc' => '12,500000',
			'record_id' => 2823,
			'record_module' => 'InventoryDetails',
		);
		$handler = vtws_getModuleHandlerFromName('InventoryDetails', $current_user);
		$meta = $handler->getMeta();
		$actual = DataTransform::sanitizeRetrieveEntityInfo($invalues, $meta);
		$this->assertEquals($expected, $actual, 'sanitizeRetrieveEntityInfo InventoryDetails usrcoma3dot');
		$current_user = $hcu;
	}

	/**
	 * Method testsanitizeReferencesForDB
	 * @test
	 */
	public function testsanitizeReferencesForDB() {
		global $current_user, $adb,$log;
		$current_user = Users::getActiveAdminUser();
		$testrecord = 4062;
		$testmodule = 'Assets';
		$webserviceObject = VtigerWebserviceObject::fromName($adb, $testmodule);
		$handlerPath = $webserviceObject->getHandlerPath();
		$handlerClass = $webserviceObject->getHandlerClass();
		require_once $handlerPath;
		$handler = new $handlerClass($webserviceObject, $current_user, $adb, $log);
		$meta = $handler->getMeta();
		$expected = $record = vtws_retrieve($testrecord, $current_user);
		$expected['product'] = '2622';
		$expected['invoiceid'] = '3882';
		$expected['account'] = '142';
		$expected['modifiedby'] = '1';
		$expected['assigned_user_id'] = '7';
		$expected['created_user_id'] = '1';
		$actual = DataTransform::sanitizeReferencesForDB($record, $meta);
		$actual = DataTransform::sanitizeOwnerFieldsForDB($actual, $meta);
		$this->assertEquals($expected, $actual, 'sanitizeReferencesForDB Assets');
		///////////////
		$testrecord = 16829;
		$testmodule = 'PriceBooks';
		$webserviceObject = VtigerWebserviceObject::fromName($adb, $testmodule);
		$handlerPath = $webserviceObject->getHandlerPath();
		$handlerClass = $webserviceObject->getHandlerClass();
		require_once $handlerPath;
		$handler = new $handlerClass($webserviceObject, $current_user, $adb, $log);
		$meta = $handler->getMeta();
		$expected = $record = vtws_retrieve($testrecord, $current_user);
		$expected['currency_id'] = '1';
		$expected['modifiedby'] = '1';
		$expected['created_user_id'] = '1';
		$actual = DataTransform::sanitizeReferencesForDB($record, $meta);
		$this->assertEquals($expected, $actual, 'sanitizeReferencesForDB PriceBooks');
		///////////////
		$testrecord = 5321;
		$testmodule = 'Potentials';
		$webserviceObject = VtigerWebserviceObject::fromName($adb, $testmodule);
		$handlerPath = $webserviceObject->getHandlerPath();
		$handlerClass = $webserviceObject->getHandlerClass();
		require_once $handlerPath;
		$handler = new $handlerClass($webserviceObject, $current_user, $adb, $log);
		$meta = $handler->getMeta();
		$expected = $record = vtws_retrieve($testrecord, $current_user);
		$expected['related_to'] = '658';
		$expected['campaignid'] = '4972';
		$expected['convertedfromlead'] = null;
		$expected['assigned_user_id'] = '12';
		$expected['modifiedby'] = '1';
		$expected['created_user_id'] = '1';
		$actual = DataTransform::sanitizeReferencesForDB($record, $meta);
		$actual = DataTransform::sanitizeOwnerFieldsForDB($actual, $meta);
		$this->assertEquals($expected, $actual, 'sanitizeReferencesForDB Potentials');
		///////////////
		$testrecord = 5322;
		$testmodule = 'Potentials';
		$webserviceObject = VtigerWebserviceObject::fromName($adb, $testmodule);
		$handlerPath = $webserviceObject->getHandlerPath();
		$handlerClass = $webserviceObject->getHandlerClass();
		require_once $handlerPath;
		$handler = new $handlerClass($webserviceObject, $current_user, $adb, $log);
		$meta = $handler->getMeta();
		$expected = $record = vtws_retrieve($testrecord, $current_user);
		$expected['related_to'] = '1614';
		$expected['campaignid'] = null;
		$expected['convertedfromlead'] = null;
		$expected['assigned_user_id'] = '9';
		$expected['modifiedby'] = '1';
		$expected['created_user_id'] = '1';
		$actual = DataTransform::sanitizeReferencesForDB($record, $meta);
		$actual = DataTransform::sanitizeOwnerFieldsForDB($actual, $meta);
		$this->assertEquals($expected, $actual, 'sanitizeReferencesForDB Potentials');
		///////////////
		$testrecord = 26784;
		$testmodule = 'Emails';
		$webserviceObject = VtigerWebserviceObject::fromName($adb, $testmodule);
		$handlerPath = $webserviceObject->getHandlerPath();
		$handlerClass = $webserviceObject->getHandlerClass();
		require_once $handlerPath;
		$handler = new $handlerClass($webserviceObject, $current_user, $adb, $log);
		$meta = $handler->getMeta();
		$expected = $record = vtws_retrieve($testrecord, $current_user);
		$expected['parent_id'] = '1084|74';
		$expected['assigned_user_id'] = '10';
		$expected['modifiedby'] = '1';
		$actual = DataTransform::sanitizeReferencesForDB($record, $meta);
		$actual = DataTransform::sanitizeOwnerFieldsForDB($actual, $meta);
		$this->assertEquals($expected, $actual, 'sanitizeReferencesForDB Emails');
		///////////////
		$testrecord = 14340;
		$testmodule = 'CobroPago';
		$webserviceObject = VtigerWebserviceObject::fromName($adb, $testmodule);
		$handlerPath = $webserviceObject->getHandlerPath();
		$handlerClass = $webserviceObject->getHandlerClass();
		require_once $handlerPath;
		$handler = new $handlerClass($webserviceObject, $current_user, $adb, $log);
		$meta = $handler->getMeta();
		$expected = $record = vtws_retrieve($testrecord, $current_user);
		$expected['parent_id'] = '87';
		$expected['related_id'] = '3349';
		$expected['reports_to_id'] = '';
		$expected['assigned_user_id'] = '12';
		$expected['created_user_id'] = '1';
		$actual = DataTransform::sanitizeReferencesForDB($record, $meta);
		$actual = DataTransform::sanitizeOwnerFieldsForDB($actual, $meta);
		$this->assertEquals($expected, $actual, 'sanitizeReferencesForDB CobroPago');
		// test empty uitype 101
		$record['reports_to_id'] = '';
		$expected['reports_to_id'] = '';
		$actual = DataTransform::sanitizeReferencesForDB($record, $meta);
		$actual = DataTransform::sanitizeOwnerFieldsForDB($actual, $meta);
		$this->assertEquals($expected, $actual, 'sanitizeReferencesForDB CobroPago');
	}
}
?>