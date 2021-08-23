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
require_once 'modules/PriceBooks/PriceBooks.php';
use PHPUnit\Framework\TestCase;

class PriceBooksTest extends TestCase {

	/**
	 * Method testConstruct
	 * @test
	 */
	public function testConstruct() {
		$crmentity = CRMEntity::getInstance('PriceBooks');
		$this->assertInstanceOf(PriceBooks::class, $crmentity, 'testConstruct');
	}

	/**
	 * Method testget_pricebook_noproduct
	 * @test
	 */
	public function testgetPricebookNoproduct() {
		$pb = CRMEntity::getInstance('PriceBooks');
		$this->assertEquals(true, $pb->get_pricebook_noproduct(2620));
		$this->assertEquals(false, $pb->get_pricebook_noproduct(2622));
		$this->assertEquals(true, $pb->get_pricebook_noproduct(2635));
		$this->assertEquals(true, $pb->get_pricebook_noproduct(9753));
		$this->assertEquals(true, $pb->get_pricebook_noproduct(9758));
		$this->assertEquals(true, $pb->get_pricebook_noproduct(9759));
	}
}
