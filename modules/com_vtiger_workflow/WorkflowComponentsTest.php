<?php
/*************************************************************************************************
 * Copyright 2017 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

$_REQUEST['mode'] = 'donothing';
include_once 'modules/com_vtiger_workflow/WorkflowComponents.php';
unset($_REQUEST['mode']);

use PHPUnit\Framework\TestCase;
class WorkflowComponentsTest extends TestCase {

	/**
	 * Method testvtJsonDependentModules
	 * @test
	 */
	public function testvtJsonDependentModules() {
		global $adb, $current_user;
		ob_start();
		vtJsonDependentModules($adb, array('modulename' => 'Invoice'));
		$depmods_str = ob_get_clean();
		$expected = '{"count":5,"entities":{"CobroPago":{"fieldname":"related_id","modulelabel":"Payments"},"Assets":{"fieldname":"invoiceid","modulelabel":"Assets"},"InventoryDetails":{"fieldname":"related_to","modulelabel":"Inventory Details"},"cbCalendar":{"fieldname":"rel_id","modulelabel":"To Dos"},"cbtranslation":{"fieldname":"translates","modulelabel":"Translations"}}}';
		$this->assertEquals($expected, $depmods_str, 'Invoice deps string');
		$depmods_arr = json_decode($depmods_str, true);
		$expected = array(
			'count' => 5,
			'entities' => array(
				'CobroPago' => array(
					'fieldname' => 'related_id',
					'modulelabel' => getTranslatedString('CobroPago','CobroPago')
				),
				'Assets' => array(
					'fieldname' => 'invoiceid',
					'modulelabel' => getTranslatedString('Assets','Assets')
				),
				'InventoryDetails' => array(
					'fieldname' => 'related_to',
					'modulelabel' => getTranslatedString('InventoryDetails','InventoryDetails')
				),
				'cbCalendar' => array(
					'fieldname' => 'rel_id',
					'modulelabel' => getTranslatedString('cbCalendar','cbCalendar')
				),
				'cbtranslation' => array(
					'fieldname' => 'translates',
					'modulelabel' => getTranslatedString('cbtranslation','cbtranslation')
				),
			)
		);
		$this->assertEquals($expected, $depmods_arr, 'Invoice deps array');
		ob_start();
		vtJsonDependentModules($adb, array('modulename' => 'SalesOrder'));
		$depmods_str = ob_get_clean();
		$expected = '{"count":4,"entities":{"CobroPago":{"fieldname":"related_id","modulelabel":"Payments"},"InventoryDetails":{"fieldname":"related_to","modulelabel":"Inventory Details"},"cbCalendar":{"fieldname":"rel_id","modulelabel":"To Dos"},"cbtranslation":{"fieldname":"translates","modulelabel":"Translations"}}}';
		$this->assertEquals($expected, $depmods_str, 'SalesOrder deps string');
		$depmods_arr = json_decode($depmods_str, true);
		$expected = array(
			'count' => 4,
			'entities' => array(
				'CobroPago' => array(
					'fieldname' => 'related_id',
					'modulelabel' => getTranslatedString('CobroPago','CobroPago')
				),
				'InventoryDetails' => array(
					'fieldname' => 'related_to',
					'modulelabel' => getTranslatedString('InventoryDetails','InventoryDetails')
				),
				'cbCalendar' => array(
					'fieldname' => 'rel_id',
					'modulelabel' => getTranslatedString('cbCalendar','cbCalendar')
				),
				'cbtranslation' => array(
					'fieldname' => 'translates',
					'modulelabel' => getTranslatedString('cbtranslation','cbtranslation')
				),
			)
		);
		$this->assertEquals($expected, $depmods_arr, 'SalesOrder deps array');
	}

}
