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

class DataTransformTest extends PHPUnit_Framework_TestCase {

	/****
	 * TEST Users decimal configuration
	 * name format is: {decimal_separator}{symbol_position}{grouping}{grouping_symbol}{currency}
	 ****/
	var $usrdota0x = 5; // testdmy 2 decimal places
	var $usrcomd0x = 6; // testmdy 3 decimal places
	var $usrdotd3com = 7; // testymd 4 decimal places
	var $usrcoma3dot = 10; // testtz 5 decimal places
	var $usrdota3comdollar = 12; // testmcurrency 6 decimal places

	/**
	 * Method testsanitizeReferences
	 * @test
	 */
	public function testsanitizeReferences() {
		global $current_user, $adb,$log;
		$testrecord = 4062;
		$testmodule = 'Assets';
		$webserviceObject = VtigerWebserviceObject::fromName($adb,$testmodule);
		$handlerPath = $webserviceObject->getHandlerPath();
		$handlerClass = $webserviceObject->getHandlerClass();
		require_once $handlerPath;
		$handler = new $handlerClass($webserviceObject,$current_user,$adb,$log);
		$meta = $handler->getMeta();
		$focus = CRMEntity::getInstance($testmodule);
		$focus->id = $testrecord;
		$focus->retrieve_entity_info($testrecord, $testmodule);
		$expected = $focus->column_fields;
		$expected['product'] = '14x2622';
		$expected['invoiceid'] = '7x3882';
		$expected['account'] = '11x142';
		$expected['modifiedby'] = '19x1';
		$actual = DataTransform::sanitizeReferences($focus->column_fields,$meta);
		$this->assertEquals($expected, $actual,'sanitizeReferences Assets');
		///////////////
		$testrecord = 16829;
		$testmodule = 'PriceBooks';
		$webserviceObject = VtigerWebserviceObject::fromName($adb,$testmodule);
		$handlerPath = $webserviceObject->getHandlerPath();
		$handlerClass = $webserviceObject->getHandlerClass();
		require_once $handlerPath;
		$handler = new $handlerClass($webserviceObject,$current_user,$adb,$log);
		$meta = $handler->getMeta();
		$focus = CRMEntity::getInstance($testmodule);
		$focus->id = $testrecord;
		$focus->retrieve_entity_info($testrecord, $testmodule);
		$expected = $focus->column_fields;
		$expected['currency_id'] = '21x1';
		$expected['modifiedby'] = '19x1';
		$actual = DataTransform::sanitizeReferences($focus->column_fields,$meta);
		$this->assertEquals($expected, $actual,'sanitizeReferences PriceBooks');
	}

}
?>