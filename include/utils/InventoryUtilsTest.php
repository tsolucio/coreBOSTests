<?php
/*************************************************************************************************
 * Copyright 2018 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

class testInventoryUtils extends TestCase {

	/**
	 * Method testgetPricesForProducts
	 * @test
	 */
	public function testgetPricesForProducts() {
		$actual = getPricesForProducts(1, 2620, 'Products');
		$expected = array(
			2620 => 117.65000000000001
		);
		$this->assertEquals($expected, $actual);
		$actual = getPricesForProducts(1, array(2620,2627), 'Products');
		$expected = array(
			2620 => 117.65000000000001,
			2627 => 92.5
		);
		$this->assertEquals($expected, $actual);
		$actual = getPricesForProducts(1, 9713, 'Services');
		$expected = array(
			9713 => 45.299999999999997
		);
		$this->assertEquals($expected, $actual);
		$actual = getPricesForProducts(1, array(9713,9718), 'Services');
		$expected = array(
			9713 => 45.299999999999997,
			9718 => 86.799999999999997
		);
		$this->assertEquals($expected, $actual);
		$actual = getPricesForProducts(1, 20, 'Products');
		$expected = array();
		$this->assertEquals($expected, $actual);
		$actual = getPricesForProducts(1, 20, 'Services');
		$expected = array();
		$this->assertEquals($expected, $actual);
		$actual = getPricesForProducts(1, array(2620,9718), 'Services');
		$expected = array(
			9718 => 86.799999999999997
		);
		$this->assertEquals($expected, $actual);
		$actual = getPricesForProducts(1, array(2620,9718), 'Products');
		$expected = array(
			2620 => 117.65000000000001
		);
		$this->assertEquals($expected, $actual);
		$actual = getPricesForProducts(1, 2623, 'Products');
		$expected = array(
			2623 => 111.66
		);
		$this->assertEquals($expected, $actual);
		$actual = getPricesForProducts(1, 9710, 'Services');
		$expected = array(
			9710 => 9.8200000000000003
		);
		$this->assertEquals($expected, $actual);
		$actual = getPricesForProducts(2, 2623, 'Products');
		$expected = array(
			2623 => 122.82600000000001
		);
		$this->assertEquals($expected, $actual);
		$actual = getPricesForProducts(2, 9710, 'Services');
		$expected = array(
			9710 => 108.02000000000001
		);
		$this->assertEquals($expected, $actual);
		///// cost
		$actual = getPricesForProducts(1, 2623, 'Products', false);
		$expected = array(
			2623 => 111.66
		);
		$this->assertEquals($expected, $actual);
		$actual = getPricesForProducts(1, 9710, 'Services', false);
		$expected = array(
			9710 => 9.820000000000000
		);
		$this->assertEquals($expected, $actual);
		$actual = getPricesForProducts(2, 2623, 'Products', false);
		$expected = array(
			2623 => 0.00000000000000
		);
		$this->assertEquals($expected, $actual);
		$actual = getPricesForProducts(2, 9710, 'Services', false);
		$expected = array(
			9710 => 0.00000000000000
		);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * Method testgetPriceDetailsForProduct
	 * @test
	 */
	public function testgetPriceDetailsForProduct() {
		$actual = getPriceDetailsForProduct(2620, 3.89, 'available', 'Products');
		$expected = array(
			0 => array(
				'productid' => 2620,
				'currencylabel' => 'Euro',
				'currencycode' => 'EUR',
				'currencysymbol' => '&euro;',
				'curid' => '1',
				'curname' => 'curname1',
				'check_value' => false,
				'curvalue' => '3.89',
				'conversionrate' => 1.0,
				'is_basecurrency' => true,
			),
			1 => array(
				'productid' => 2620,
				'currencylabel' => 'USA, Dollars',
				'currencycode' => 'USD',
				'currencysymbol' => '$',
				'curid' => '2',
				'curname' => 'curname2',
				'check_value' => false,
				'curvalue' => '4.28',
				'conversionrate' => 1.1,
				'is_basecurrency' => false,
			),
		);
		$this->assertEquals($expected, $actual);
		$actual = getPriceDetailsForProduct(2627, 3.89, 'available', 'Products');
		$expected = array(
			0 => array(
				'productid' => 2627,
				'currencylabel' => 'Euro',
				'currencycode' => 'EUR',
				'currencysymbol' => '&euro;',
				'curid' => '1',
				'curname' => 'curname1',
				'check_value' => false,
				'curvalue' => '3.89',
				'conversionrate' => 1.0,
				'is_basecurrency' => true,
			),
			1 => array(
				'productid' => 2627,
				'currencylabel' => 'USA, Dollars',
				'currencycode' => 'USD',
				'currencysymbol' => '$',
				'curid' => '2',
				'curname' => 'curname2',
				'check_value' => false,
				'curvalue' => '4.28',
				'conversionrate' => 1.1,
				'is_basecurrency' => false,
			),
		);
		$this->assertEquals($expected, $actual);
		$actual = getPriceDetailsForProduct(2633, 3.89, 'available', 'Products');
		$expected = array(
			0 => array(
				'productid' => 2633,
				'currencylabel' => 'Euro',
				'currencycode' => 'EUR',
				'currencysymbol' => '&euro;',
				'curid' => '1',
				'curname' => 'curname1',
				'check_value' => true,
				'curvalue' => '223.00',
				'conversionrate' => 1.0,
				'is_basecurrency' => true,
			),
			1 => array(
				'productid' => 2633,
				'currencylabel' => 'USA, Dollars',
				'currencycode' => 'USD',
				'currencysymbol' => '$',
				'curid' => '2',
				'curname' => 'curname2',
				'check_value' => true,
				'curvalue' => '250.00',
				'conversionrate' => 1.1,
				'is_basecurrency' => false,
			),
		);
		$this->assertEquals($expected, $actual);
		$actual = getPriceDetailsForProduct(2620, 3.89, 'available_associated', 'Products');
		$expected = array();
		$this->assertEquals($expected, $actual);
		$actual = getPriceDetailsForProduct(2627, 3.89, 'available_associated', 'Products');
		$expected = array();
		$this->assertEquals($expected, $actual);
		$actual = getPriceDetailsForProduct(2633, 3.89, 'available_associated', 'Products');
		$expected = array(
			0 => array(
				'productid' => 2633,
				'currencylabel' => 'USA, Dollars',
				'currencycode' => 'USD',
				'currencysymbol' => '$',
				'curid' => '2',
				'curname' => 'curname2',
				'check_value' => true,
				'curvalue' => '250.00',
				'conversionrate' => 1.1,
				'is_basecurrency' => false,
			),
		);
		$this->assertEquals($expected, $actual);
		//////////////////////
		$actual = getPriceDetailsForProduct(9713, 3.89, 'available', 'Services');
		$expected = array(
			0 => array(
				'productid' => 9713,
				'currencylabel' => 'Euro',
				'currencycode' => 'EUR',
				'currencysymbol' => '&euro;',
				'curid' => '1',
				'curname' => 'curname1',
				'check_value' => false,
				'curvalue' => '3.89',
				'conversionrate' => 1.0,
				'is_basecurrency' => true,
			),
			1 => array(
				'productid' => 9713,
				'currencylabel' => 'USA, Dollars',
				'currencycode' => 'USD',
				'currencysymbol' => '$',
				'curid' => '2',
				'curname' => 'curname2',
				'check_value' => false,
				'curvalue' => '4.28',
				'conversionrate' => 1.1,
				'is_basecurrency' => false,
			),
		);
		$this->assertEquals($expected, $actual);
		$actual = getPriceDetailsForProduct(9727, 3.89, 'available', 'Services');
		$expected = array(
			0 => array(
				'productid' => 9727,
				'currencylabel' => 'Euro',
				'currencycode' => 'EUR',
				'currencysymbol' => '&euro;',
				'curid' => '1',
				'curname' => 'curname1',
				'check_value' => true,
				'curvalue' => '37.40',
				'conversionrate' => 1.0,
				'is_basecurrency' => true,
			),
			1 => array(
				'productid' => 9727,
				'currencylabel' => 'USA, Dollars',
				'currencycode' => 'USD',
				'currencysymbol' => '$',
				'curid' => '2',
				'curname' => 'curname2',
				'check_value' => true,
				'curvalue' => '310.00',
				'conversionrate' => 1.1,
				'is_basecurrency' => false,
			),
		);
		$this->assertEquals($expected, $actual);
		$actual = getPriceDetailsForProduct(9713, 3.89, 'available_associated', 'Services');
		$expected = array();
		$this->assertEquals($expected, $actual);
		$actual = getPriceDetailsForProduct(9727, 3.89, 'available_associated', 'Services');
		$expected = array(
			0 => array(
				'productid' => 9727,
				'currencylabel' => 'USA, Dollars',
				'currencycode' => 'USD',
				'currencysymbol' => '$',
				'curid' => '2',
				'curname' => 'curname2',
				'check_value' => true,
				'curvalue' => '310.00',
				'conversionrate' => 1.1,
				'is_basecurrency' => false,
			),
		);
		$this->assertEquals($expected, $actual);
		//////////////////////
		$actual = getPriceDetailsForProduct(20, 3.89, 'available_associated', 'Services');
		$expected = array();
		$this->assertEquals($expected, $actual);
		$actual = getPriceDetailsForProduct(20, 3.89, 'available_associated', 'Services');
		$expected = array();
		$this->assertEquals($expected, $actual);
		//////////////////////
		$actual = getPriceDetailsForProduct('', 3.89, 'available_associated', 'Services');
		$this->assertEquals(array(), $actual);
	}

	/**
	 * Method testgetTaxDetailsForProduct
	 * @test
	 */
	public function testgetTaxDetailsForProduct() {
		$actual = getTaxDetailsForProduct(2620, 'available');
		$expected = array(
		);
		$this->assertEquals($expected, $actual);
		$actual = getTaxDetailsForProduct(2627, 'available');
		$expected = array(
		);
		$this->assertEquals($expected, $actual);
		$actual = getTaxDetailsForProduct(2633, 'available');
		$expected = array(
			0 => array(
				'taxid' => '1',
				'taxname' => 'tax1',
				'taxlabel' => 'VAT',
				'percentage' => '14.500',
				'deleted' => '0',
				'productid' => 2633,
			),
			1 => array(
				'taxid' => '3',
				'taxname' => 'tax3',
				'taxlabel' => 'Service',
				'percentage' => '112.500',
				'deleted' => '0',
				'productid' => 2633,
			),
		);
		$this->assertEquals($expected, $actual);
		///////////  test ALL, if there were some tax deleted it would be different than AVAILABLE
		$actual = getTaxDetailsForProduct(2620, 'all');
		$expected = array(
		);
		$this->assertEquals($expected, $actual);
		$actual = getTaxDetailsForProduct(2627, 'all');
		$expected = array(
		);
		$this->assertEquals($expected, $actual);
		$actual = getTaxDetailsForProduct(2633, 'all');
		$expected = array(
			0 => array(
				'taxid' => '1',
				'taxname' => 'tax1',
				'taxlabel' => 'VAT',
				'percentage' => '14.500',
				'deleted' => '0',
				'productid' => 2633,
			),
			1 => array(
				'taxid' => '3',
				'taxname' => 'tax3',
				'taxlabel' => 'Service',
				'percentage' => '112.500',
				'deleted' => '0',
				'productid' => 2633,
			),
		);
		$this->assertEquals($expected, $actual);
		///////////
		$actual = getTaxDetailsForProduct(2620, 'available_associated');
		$expected = array(
			0 => array(
				'taxid' => '1',
				'taxname' => 'tax1',
				'taxlabel' => 'VAT',
				'percentage' => '4.500',
				'deleted' => '0',
				'productid' => 2620,
			),
			1 => array(
				'taxid' => '2',
				'taxname' => 'tax2',
				'taxlabel' => 'Sales',
				'percentage' => '10.000',
				'deleted' => '0',
				'productid' => 2620,
			),
			2 => array(
				'taxid' => '3',
				'taxname' => 'tax3',
				'taxlabel' => 'Service',
				'percentage' => '12.500',
				'deleted' => '0',
				'productid' => 2620,
			)
		);
		$this->assertEquals($expected, $actual);
		$actual = getTaxDetailsForProduct(2627, 'available_associated');
		$expected = array(
			0 => array(
				'taxid' => '1',
				'taxname' => 'tax1',
				'taxlabel' => 'VAT',
				'percentage' => '4.500',
				'deleted' => '0',
				'productid' => 2627,
			),
			1 => array(
				'taxid' => '2',
				'taxname' => 'tax2',
				'taxlabel' => 'Sales',
				'percentage' => '10.000',
				'deleted' => '0',
				'productid' => 2627,
			),
			2 => array(
				'taxid' => '3',
				'taxname' => 'tax3',
				'taxlabel' => 'Service',
				'percentage' => '12.500',
				'deleted' => '0',
				'productid' => 2627,
			)
		);
		$this->assertEquals($expected, $actual);
		$actual = getTaxDetailsForProduct(2633, 'available_associated');
		$expected = array(
			0 => array(
				'taxid' => '1',
				'taxname' => 'tax1',
				'taxlabel' => 'VAT',
				'percentage' => '14.500',
				'deleted' => '0',
				'productid' => 2633,
			),
			1 => array(
				'taxid' => '2',
				'taxname' => 'tax2',
				'taxlabel' => 'Sales',
				'percentage' => '10.000',
				'deleted' => '0',
				'productid' => 2633,
			),
			2 => array(
				'taxid' => '3',
				'taxname' => 'tax3',
				'taxlabel' => 'Service',
				'percentage' => '112.500',
				'deleted' => '0',
				'productid' => 2633,
			),
		);
		$this->assertEquals($expected, $actual);
		//////////////////////
		$actual = getTaxDetailsForProduct(9713, 'available');
		$expected = array();
		$this->assertEquals($expected, $actual);
		$actual = getTaxDetailsForProduct(9727, 'available');
		$expected = array(
			0 => array(
				'taxid' => '1',
				'taxname' => 'tax1',
				'taxlabel' => 'VAT',
				'percentage' => '14.500',
				'deleted' => '0',
				'productid' => 9727,
			),
			1 => array(
				'taxid' => '3',
				'taxname' => 'tax3',
				'taxlabel' => 'Service',
				'percentage' => '112.500',
				'deleted' => '0',
				'productid' => 9727,
			),
		);
		$this->assertEquals($expected, $actual);
		//////
		$actual = getTaxDetailsForProduct(9713, 'available_associated');
		$expected = array(
			0 => array(
				'taxid' => '1',
				'taxname' => 'tax1',
				'taxlabel' => 'VAT',
				'percentage' => '4.500',
				'deleted' => '0',
				'productid' => 9713,
			),
			1 => array(
				'taxid' => '2',
				'taxname' => 'tax2',
				'taxlabel' => 'Sales',
				'percentage' => '10.000',
				'deleted' => '0',
				'productid' => 9713,
			),
			2 => array(
				'taxid' => '3',
				'taxname' => 'tax3',
				'taxlabel' => 'Service',
				'percentage' => '12.500',
				'deleted' => '0',
				'productid' => 9713,
			)
		);
		$this->assertEquals($expected, $actual);
		$actual = getTaxDetailsForProduct(9727, 'available_associated');
		$expected = array(
			0 => array(
				'taxid' => '1',
				'taxname' => 'tax1',
				'taxlabel' => 'VAT',
				'percentage' => '14.500',
				'deleted' => '0',
				'productid' => 9727,
			),
			1 => array(
				'taxid' => '2',
				'taxname' => 'tax2',
				'taxlabel' => 'Sales',
				'percentage' => '10.000',
				'deleted' => '0',
				'productid' => 9727,
			),
			2 => array(
				'taxid' => '3',
				'taxname' => 'tax3',
				'taxlabel' => 'Service',
				'percentage' => '112.500',
				'deleted' => '0',
				'productid' => 9727,
			)
		);
		$this->assertEquals($expected, $actual);
		//////////////////////
		$actual = getTaxDetailsForProduct(20, 'available_associated');
		$expected = array(
			0 => array(
				'taxid' => '1',
				'taxname' => 'tax1',
				'taxlabel' => 'VAT',
				'percentage' => '4.500',
				'deleted' => '0',
				'productid' => 20,
			),
			1 => array(
				'taxid' => '2',
				'taxname' => 'tax2',
				'taxlabel' => 'Sales',
				'percentage' => '10.000',
				'deleted' => '0',
				'productid' => 20,
			),
			2 => array(
				'taxid' => '3',
				'taxname' => 'tax3',
				'taxlabel' => 'Service',
				'percentage' => '12.500',
				'deleted' => '0',
				'productid' => 20,
			)
		);
		$this->assertEquals($expected, $actual);
		//////////////////////
		$actual = getTaxDetailsForProduct('', 'available_associated');
		$this->assertEquals(array(), $actual);
	}

	/**
	 * Method testgetInventoryTaxType
	 * @test
	 */
	public function testgetInventoryTaxType() {
		$this->assertEquals('group', getInventoryTaxType('Invoice', 2824), 'Invoice group');
		$this->assertEquals('individual', getInventoryTaxType('Invoice', 2902), 'Invoice individual');
		$this->assertEquals('group', getInventoryTaxType('Quotes', 11972), 'Quotes group');
		$this->assertEquals('group', getInventoryTaxType('SalesOrder', 10616), 'SalesOrder group');
		$this->assertEquals('group', getInventoryTaxType('PurchaseOrder', 13378), 'PurchaseOrder group');
		$this->assertEquals('', getInventoryTaxType('PurchaseOrder', 1), 'NotExist');
	}

	/**
	 * Method testgetBaseConversionRateForProduct
	 * @test
	 */
	public function testgetBaseConversionRateForProduct() {
		global $current_user, $adb;
		$hold_user = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(12);
		$current_user = $user;
		$this->assertEquals(0.9090909090909091, getBaseConversionRateForProduct(2620, 'create', 'Products'));
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(1);
		$current_user = $user;
		$this->assertEquals(1, getBaseConversionRateForProduct(2620, 'create', 'Products'));
		$this->assertEquals(1, getBaseConversionRateForProduct(2620, 'edit', 'Products'));
		$adb->query('update vtiger_products set currency_id=2 where productid=2620');
		$this->assertEquals(0.9090909090909091, getBaseConversionRateForProduct(2620, 'edit', 'Products'));
		$adb->query('update vtiger_products set currency_id=1 where productid=2620'); // leave it as it was
		$this->assertEquals(1, getBaseConversionRateForProduct(9716, 'edit', 'Services'));
		$this->assertEquals(1, getBaseConversionRateForProduct(9716, 'edit', 'Products'), 'this one triggers the empty conversion rate');
		$current_user = $hold_user;
	}

	/**
	 * Method getAllTaxesProvider
	 */
	public function getAllTaxesProvider() {
		return array(
			array(
				'available',
				'',
				'',
				'',
				false,
				array(
					array(
						'taxid' => '1',
						'taxname' => 'tax1',
						'taxlabel' => 'VAT',
						'percentage' => '4.500',
						'deleted' => '0',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
					array(
						'taxid' => '2',
						'taxname' => 'tax2',
						'taxlabel' => 'Sales',
						'percentage' => '10.000',
						'deleted' => '0',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
					array(
						'taxid' => '3',
						'taxname' => 'tax3',
						'taxlabel' => 'Service',
						'percentage' => '12.500',
						'deleted' => '0',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
				),
			),
			array(
				'all',
				'',
				'',
				'',
				false,
				array(
					array(
						'taxid' => '1',
						'taxname' => 'tax1',
						'taxlabel' => 'VAT',
						'percentage' => '4.500',
						'deleted' => '0',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
					array(
						'taxid' => '2',
						'taxname' => 'tax2',
						'taxlabel' => 'Sales',
						'percentage' => '10.000',
						'deleted' => '0',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
					array(
						'taxid' => '3',
						'taxname' => 'tax3',
						'taxlabel' => 'Service',
						'percentage' => '12.500',
						'deleted' => '0',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
				),
			),
			array(
				'',
				'',
				'',
				'',
				false,
				array(
					array(
						'taxid' => '1',
						'taxname' => 'tax1',
						'taxlabel' => 'VAT',
						'percentage' => '4.500',
						'deleted' => '0',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
					array(
						'taxid' => '2',
						'taxname' => 'tax2',
						'taxlabel' => 'Sales',
						'percentage' => '10.000',
						'deleted' => '0',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
					array(
						'taxid' => '3',
						'taxname' => 'tax3',
						'taxlabel' => 'Service',
						'percentage' => '12.500',
						'deleted' => '0',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
				),
			),
			////////////////////
			array(
				'available',
				'',
				'',
				'',
				true,
				array(
					array(
						'taxid' => '1',
						'taxname' => 'tax1',
						'taxlabel' => 'VAT',
						'percentage' => '4.500',
						'deleted' => '0',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
					array(
						'taxid' => '2',
						'taxname' => 'tax2',
						'taxlabel' => 'Sales',
						'percentage' => '10.000',
						'deleted' => '0',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
				),
			),
			array(
				'all',
				'',
				'',
				'',
				true,
				array(
					array(
						'taxid' => '1',
						'taxname' => 'tax1',
						'taxlabel' => 'VAT',
						'percentage' => '4.500',
						'deleted' => '0',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
					array(
						'taxid' => '2',
						'taxname' => 'tax2',
						'taxlabel' => 'Sales',
						'percentage' => '10.000',
						'deleted' => '0',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
					array(
						'taxid' => '3',
						'taxname' => 'tax3',
						'taxlabel' => 'Service',
						'percentage' => '12.500',
						'deleted' => '1',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
				),
			),
			array(
				'',
				'',
				'',
				'',
				true,
				array(
					array(
						'taxid' => '1',
						'taxname' => 'tax1',
						'taxlabel' => 'VAT',
						'percentage' => '4.500',
						'deleted' => '0',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
					array(
						'taxid' => '2',
						'taxname' => 'tax2',
						'taxlabel' => 'Sales',
						'percentage' => '10.000',
						'deleted' => '0',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
					array(
						'taxid' => '3',
						'taxname' => 'tax3',
						'taxlabel' => 'Service',
						'percentage' => '12.500',
						'deleted' => '1',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
				),
			),
			////////////////////
			array(
				'available',
				'sh',
				'',
				'',
				false,
				array(
					array(
						'taxid' => '1',
						'taxname' => 'shtax1',
						'taxlabel' => 'VAT',
						'percentage' => '4.500',
						'deleted' => '0',
					),
					array(
						'taxid' => '2',
						'taxname' => 'shtax2',
						'taxlabel' => 'Sales',
						'percentage' => '10.000',
						'deleted' => '0',
					),
					array(
						'taxid' => '3',
						'taxname' => 'shtax3',
						'taxlabel' => 'Service',
						'percentage' => '12.500',
						'deleted' => '0',
					),
				),
			),
			array(
				'all',
				'sh',
				'',
				'',
				false,
				array(
					array(
						'taxid' => '1',
						'taxname' => 'shtax1',
						'taxlabel' => 'VAT',
						'percentage' => '4.500',
						'deleted' => '0',
					),
					array(
						'taxid' => '2',
						'taxname' => 'shtax2',
						'taxlabel' => 'Sales',
						'percentage' => '10.000',
						'deleted' => '0',
					),
					array(
						'taxid' => '3',
						'taxname' => 'shtax3',
						'taxlabel' => 'Service',
						'percentage' => '12.500',
						'deleted' => '0',
					),
				),
			),
			array(
				'',
				'sh',
				'',
				'',
				false,
				array(
					array(
						'taxid' => '1',
						'taxname' => 'shtax1',
						'taxlabel' => 'VAT',
						'percentage' => '4.500',
						'deleted' => '0',
					),
					array(
						'taxid' => '2',
						'taxname' => 'shtax2',
						'taxlabel' => 'Sales',
						'percentage' => '10.000',
						'deleted' => '0',
					),
					array(
						'taxid' => '3',
						'taxname' => 'shtax3',
						'taxlabel' => 'Service',
						'percentage' => '12.500',
						'deleted' => '0',
					),
				),
			),
			////////////////////
			array(
				'available',
				'sh',
				'',
				'',
				true,
				array(
					array(
						'taxid' => '1',
						'taxname' => 'shtax1',
						'taxlabel' => 'VAT',
						'percentage' => '4.500',
						'deleted' => '0',
					),
					array(
						'taxid' => '2',
						'taxname' => 'shtax2',
						'taxlabel' => 'Sales',
						'percentage' => '10.000',
						'deleted' => '0',
					),
				),
			),
			array(
				'all',
				'sh',
				'',
				'',
				true,
				array(
					array(
						'taxid' => '1',
						'taxname' => 'shtax1',
						'taxlabel' => 'VAT',
						'percentage' => '4.500',
						'deleted' => '0',
					),
					array(
						'taxid' => '2',
						'taxname' => 'shtax2',
						'taxlabel' => 'Sales',
						'percentage' => '10.000',
						'deleted' => '0',
					),
					array(
						'taxid' => '3',
						'taxname' => 'shtax3',
						'taxlabel' => 'Service',
						'percentage' => '12.500',
						'deleted' => '1',
					),
				),
			),
			array(
				'',
				'sh',
				'',
				'',
				true,
				array(
					array(
						'taxid' => '1',
						'taxname' => 'shtax1',
						'taxlabel' => 'VAT',
						'percentage' => '4.500',
						'deleted' => '0',
					),
					array(
						'taxid' => '2',
						'taxname' => 'shtax2',
						'taxlabel' => 'Sales',
						'percentage' => '10.000',
						'deleted' => '0',
					),
					array(
						'taxid' => '3',
						'taxname' => 'shtax3',
						'taxlabel' => 'Service',
						'percentage' => '12.500',
						'deleted' => '1',
					),
				),
			),
			////////////////////
			array(
				'available',
				'',
				'edit',
				'11687',
				false,
				array(
					array(
						'taxid' => '1',
						'taxname' => 'tax1',
						'taxlabel' => 'VAT',
						'percentage' => '4.500',
						'deleted' => '0',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
					array(
						'taxid' => '2',
						'taxname' => 'tax2',
						'taxlabel' => 'Sales',
						'percentage' => '10.000',
						'deleted' => '0',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
					array(
						'taxid' => '3',
						'taxname' => 'tax3',
						'taxlabel' => 'Service',
						'percentage' => '12.500',
						'deleted' => '0',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
				),
			),
			array(
				'',
				'',
				'edit',
				'11687',
				false,
				array(
					array(
						'taxid' => '1',
						'taxname' => 'tax1',
						'taxlabel' => 'VAT',
						'percentage' => '4.500',
						'deleted' => '0',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
					array(
						'taxid' => '2',
						'taxname' => 'tax2',
						'taxlabel' => 'Sales',
						'percentage' => '10.000',
						'deleted' => '0',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
					array(
						'taxid' => '3',
						'taxname' => 'tax3',
						'taxlabel' => 'Service',
						'percentage' => '12.500',
						'deleted' => '0',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
				),
			),
			array(
				'',
				'',
				'edit',
				'11687',
				true,
				array(
					array(
						'taxid' => '1',
						'taxname' => 'tax1',
						'taxlabel' => 'VAT',
						'percentage' => '4.500',
						'deleted' => '0',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
					array(
						'taxid' => '2',
						'taxname' => 'tax2',
						'taxlabel' => 'Sales',
						'percentage' => '10.000',
						'deleted' => '0',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
					array(
						'taxid' => '3',
						'taxname' => 'tax3',
						'taxlabel' => 'Service',
						'percentage' => '12.500',
						'deleted' => '1',
						'retention' => '0',
						'default' => '0',
						'qcreate' => '0',
					),
				),
			),
		);
	}

	/**
	 * Method testgetAllTaxes
	 * @test
	 * @dataProvider getAllTaxesProvider
	 */
	public function testgetAllTaxes($available, $sh, $mode, $id, $deactivateTax3, $expected) {
		global $adb;
		if ($deactivateTax3) {
			if ($sh == 'sh') {
				$tablename = 'vtiger_shippingtaxinfo';
			} else {
				$tablename = 'vtiger_inventorytaxinfo';
			}
			$adb->query('update '.$tablename.' set deleted=1 where taxid=3');
		}
		$this->assertEquals($expected, getAllTaxes($available, $sh, $mode, $id));
		if ($deactivateTax3) {
			$adb->query('update '.$tablename.' set deleted=0 where taxid=3');
		}
	}
}