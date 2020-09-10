<?php
/*************************************************************************************************
 * Copyright 2020 MajorLabel -- This file is a part of TSOLUCIO coreBOS Tests.
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

class AvoidClearingLinesTest extends TestCase {

	/**
	 * Method saveSalesOrderAjaxWithoutLines
	 * @test
	 */
	public function saveSalesOrderAjaxWithoutLines() {
		global $current_user, $adb;
		$record = '10569';
		$expected = 0;

		include_once 'modules/SalesOrder/SalesOrder.php';
		$so = new SalesOrder();
		$so->id = $record;
		$so->mode = 'edit';
		$so->retrieve_entity_info($record, 'SalesOrder');

		$handler = vtws_getModuleHandlerFromName('SalesOrder', $current_user);
		$meta = $handler->getMeta();
		$so->column_fields = DataTransform::sanitizeRetrieveEntityInfo($so->column_fields, $meta);

		$_REQUEST['action'] = 'SomethingThatWontMeanAjax';
		$_REQUEST['ajxaction'] = 'SomethingThatWontMeanAjax';
		$_REQUEST['taxtype'] = 'group';

		$so->save('SalesOrder');
		$q = "SELECT COUNT(*) AS nooflines FROM vtiger_inventoryproductrel WHERE id = ?";
		$r = $adb->pquery($q, array($record));
		$actual = (int)$adb->query_result($r, 0, 'nooflines');

		$this->assertGreaterThan(
			$expected,
			$actual,
			'SO1 has no inventorylines. The inventorylines are not protected from badly formed AJAX actions'
		);
	}
}