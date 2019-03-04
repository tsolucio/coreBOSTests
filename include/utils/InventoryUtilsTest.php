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
				'check_value' => false,
				'curvalue' => '250',
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
				'check_value' => false,
				'curvalue' => '250',
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
				'check_value' => false,
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
				'check_value' => false,
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
}
