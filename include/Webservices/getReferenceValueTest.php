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

include_once 'include/Webservices/CustomerPortalWS.php';

class getReferenceValueTest extends TestCase {

	/**
	 * Method testvtws_getReferenceValue
	 * @test
	 */
	public function testvtws_getReferenceValue() {
		global $current_user;
		$docfldwsid = vtws_getEntityId('DocumentFolders');
		$actual = vtws_getReferenceValue(serialize(array('11x74','12x1085','20x2','21x1',$docfldwsid.'x44190')), $current_user);
		$expected = 'a:5:{s:5:"11x74";a:3:{s:6:"module";s:8:"Accounts";s:9:"reference";s:15:"Chemex Labs Ltd";s:6:"cbuuid";s:40:"b0857db0c1dee95300a10982853f5fb1d4e981c1";}s:7:"12x1085";a:3:{s:6:"module";s:8:"Contacts";s:9:"reference";s:15:"Julieta Cropsey";s:6:"cbuuid";s:40:"d9692723137a4f119c900157b38189738e692fc4";}s:4:"20x2";a:3:{s:6:"module";s:6:"Groups";s:9:"reference";s:12:"Team Selling";s:6:"cbuuid";s:0:"";}s:4:"21x1";a:3:{s:6:"module";s:8:"Currency";s:9:"reference";s:13:"Euro : &euro;";s:6:"cbuuid";s:0:"";}s:8:"'.$docfldwsid.'x44190";a:3:{s:6:"module";s:15:"DocumentFolders";s:9:"reference";s:8:"Avengers";s:6:"cbuuid";s:0:"";}}';
		$this->assertEquals($expected, $actual, "testvtws_getReferenceValue");
		$actual = vtws_getReferenceValue(serialize(array('12x1084|11x74', '19x1', '19x7')), $current_user);
		$expected = serialize(array(
			'12x1084' => array(
				'module' => 'Contacts',
				'reference' => 'Lina Schwiebert',
				'cbuuid' => 'a609725772dc91ad733b19e4100cf68bb30195d1',
			),
			'11x74' => array(
				'module' => 'Accounts',
				'reference' => 'Chemex Labs Ltd',
				'cbuuid' => 'b0857db0c1dee95300a10982853f5fb1d4e981c1',
			),
			'19x1' => array(
				'module' => 'Users',
				'reference' => ' Administrator',
				'cbuuid' => '',
			),
			'19x7' => array(
				'module' => 'Users',
				'reference' => 'cbTest testymd',
				'cbuuid' => '',
			),
		));
		$this->assertEquals($expected, $actual, "testvtws_getReferenceValue");
	}
}
?>