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

include_once 'include/Webservices/RelatedModuleMeta.php';

class RelatedModuleMetaTest extends TestCase {

	/**
	 * Method testState
	 * @test
	 */
	public function testState() {
		$obj = RelatedModuleMeta::getInstance('Products', 'Quotes');
		$this->assertEquals('RelatedModuleMeta', get_class($obj), 'Class instantiated correctly');
	}

	/**
	 * Method getRelationMetaProvider
	 * params
	 */
	public function getRelationMetaProvider() {
		return array(
			array('Products', 'Quotes', array(
				'relationTable' => 'vtiger_inventoryproductrel',
				'Products' => 'productid',
				'Quotes' => 'id',
			)),
			array('Products', 'PurchaseOrder', array(
				'relationTable' => 'vtiger_inventoryproductrel',
				'Products' => 'productid',
				'PurchaseOrder' => 'id',
			)),
			array('Invoice', 'Products', array(
				'relationTable' => 'vtiger_inventoryproductrel',
				'Products' => 'productid',
				'Invoice' => 'id',
			)),
			array('Campaigns', 'Contacts', array(
				'relationTable' => 'vtiger_campaigncontrel',
				'Campaigns' => 'campaignid',
				'Contacts' => 'contactid',
			)),
			array('Contacts', 'Campaigns', array(
				'relationTable' => 'vtiger_campaigncontrel',
				'Campaigns' => 'campaignid',
				'Contacts' => 'contactid',
			)),
			array('Contacts', 'Vendors', null),
		);
	}

	/**
	 * Method testgetRelationMeta
	 * @test
	 * @dataProvider getRelationMetaProvider
	 */
	public function testgetRelationMeta($module, $relatedModule, $expected) {
		$obj = RelatedModuleMeta::getInstance($module, $relatedModule);
		$this->assertEquals($expected, $obj->getRelationMeta());
	}
}
?>