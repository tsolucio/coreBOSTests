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
	}

	public function testsanitizeCurrencyFieldsForDB() {
		global $current_user, $adb, $log;
		$rowsql = array(
			'inventorydetails_no' => 'InvDet-000000145',
			'productid' => 2616,
			'related_to' => 2973,
			'account_id' => 2972,
			'contact_id' => 1953,
			'vendor_id' => 2419,
			'sequence_no' => 1,
			'lineitem_id' => 145,
			'quantity' => 9.000,
			'listprice' => '48.610000',
			'tax_percent' => 0,
			'extgross' => '437.490000',
			'discount_percent' => 0,
			'discount_amount' => 0,
			'extnet' => '1437.490000',
			'linetax' => 0,
			'linetotal' => '437.490000',
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
			'id_tax1_perc' => '4.500000',
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
			'vendor_id' => 2419,
			'sequence_no' => 1,
			'lineitem_id' => 145,
			'quantity' => 9.000,
			'listprice' => '48.610000',
			'tax_percent' => 0,
			'extgross' => '437.490000',
			'discount_percent' => 0,
			'discount_amount' => 0,
			'extnet' => '1,437.490000',
			'linetax' => 0,
			'linetotal' => '437.490000',
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
			'id_tax1_perc' => '4.500000',
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
			'vendor_id' => 2419,
			'sequence_no' => 1,
			'lineitem_id' => 145,
			'quantity' => 9.000,
			'listprice' => '48,610000',
			'tax_percent' => 0,
			'extgross' => '437,490000',
			'discount_percent' => 0,
			'discount_amount' => 0,
			'extnet' => '1.437,490000',
			'linetax' => 0,
			'linetotal' => '437,490000',
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
			'id_tax1_perc' => '4,500000',
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
}
?>