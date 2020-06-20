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

include_once 'include/Webservices/CustomerPortalWS.php';

class testCustomerPortalWS extends TestCase {

	/**
	 * Method vtyiicpng_getWSEntityIdProvider
	 * params
	 */
	public function vtyiicpng_getWSEntityIdProvider() {
		return array(
			array('Contacts', '12x', 'WS ID Contact'),
			array('Accounts', '11x', 'WS ID Account'),
			array('Assets', '29x', 'WS ID Assets'),
			array('DoesNotExist', '0x', 'WS ID DoesNotExist'),
			array('', '0x', 'WS ID empty'),
		);
	}

	/**
	 * Method testvtyiicpng_getWSEntityId
	 * @test
	 * @dataProvider vtyiicpng_getWSEntityIdProvider
	 */
	public function testvtyiicpng_getWSEntityId($module, $expected, $message) {
		$this->assertEquals($expected, vtyiicpng_getWSEntityId($module), "vtyiicpng_getWSEntityId $message");
	}

	/**
	 * Method vtws_getReferenceValueProvider
	 * params
	 */
	public function vtws_getReferenceValueProvider() {
		return array(
			array(serialize(array('12x1084','11x74')), 'a:2:{s:7:"12x1084";a:3:{s:6:"module";s:8:"Contacts";s:9:"reference";s:15:"Lina Schwiebert";s:6:"cbuuid";s:40:"a609725772dc91ad733b19e4100cf68bb30195d1";}s:5:"11x74";a:3:{s:6:"module";s:8:"Accounts";s:9:"reference";s:15:"Chemex Labs Ltd";s:6:"cbuuid";s:40:"b0857db0c1dee95300a10982853f5fb1d4e981c1";}}'),
			array(serialize(array('22x2','20x3','21x1')), 'a:3:{s:4:"22x2";a:3:{s:6:"module";s:15:"DocumentFolders";s:9:"reference";s:8:"Avengers";s:6:"cbuuid";s:0:"";}s:4:"20x3";a:3:{s:6:"module";s:6:"Groups";s:9:"reference";s:15:"Marketing Group";s:6:"cbuuid";s:0:"";}s:4:"21x1";a:3:{s:6:"module";s:8:"Currency";s:9:"reference";s:13:"Euro : &euro;";s:6:"cbuuid";s:0:"";}}'),
			array(serialize(array('22x2|20x3','21x1')), 'a:3:{s:4:"22x2";a:3:{s:6:"module";s:15:"DocumentFolders";s:9:"reference";s:8:"Avengers";s:6:"cbuuid";s:0:"";}s:4:"20x3";a:3:{s:6:"module";s:6:"Groups";s:9:"reference";s:15:"Marketing Group";s:6:"cbuuid";s:0:"";}s:4:"21x1";a:3:{s:6:"module";s:8:"Currency";s:9:"reference";s:13:"Euro : &euro;";s:6:"cbuuid";s:0:"";}}'),
			array(serialize(array('22x2','20x3|21x1')), 'a:3:{s:4:"22x2";a:3:{s:6:"module";s:15:"DocumentFolders";s:9:"reference";s:8:"Avengers";s:6:"cbuuid";s:0:"";}s:4:"20x3";a:3:{s:6:"module";s:6:"Groups";s:9:"reference";s:15:"Marketing Group";s:6:"cbuuid";s:0:"";}s:4:"21x1";a:3:{s:6:"module";s:8:"Currency";s:9:"reference";s:13:"Euro : &euro;";s:6:"cbuuid";s:0:"";}}'),
			array(serialize(array('11x1084','12x74')), 'a:2:{s:7:"11x1084";a:3:{s:6:"module";s:8:"Accounts";s:9:"reference";s:0:"";s:6:"cbuuid";s:0:"";}s:5:"12x74";a:3:{s:6:"module";s:8:"Contacts";s:9:"reference";s:0:"";s:6:"cbuuid";s:0:"";}}'),
			array(serialize(array()), 'a:0:{}'),
			array('', 'a:0:{}'),
		);
	}

	/**
	 * Method testvtyiicpng_getWSEntityId
	 * @test
	 * @dataProvider vtws_getReferenceValueProvider
	 */
	public function testvtws_getReferenceValue($ids, $expected) {
		global $current_user;
		$this->assertEquals($expected, vtws_getReferenceValue($ids, $current_user));
	}

	/**
	 * Method vtws_getUItypeProvider
	 * params
	 */
	public function vtws_getUItypeProvider() {
		return array(
			array('Accounts', array(
				'accountname' => '2',
				'account_no' => '4',
				'phone' => '11',
				'website' => '17',
				'fax' => '11',
				'tickersymbol' => '1',
				'otherphone' => '11',
				'account_id' => '10',
				'email1' => '13',
				'employees' => '7',
				'email2' => '13',
				'ownership' => '1',
				'rating' => '15',
				'industry' => '15',
				'siccode' => '1',
				'accounttype' => '15',
				'annual_revenue' => '71',
				'emailoptout' => '56',
				'notify_owner' => '56',
				'assigned_user_id' => '53',
				'createdtime' => '70',
				'modifiedtime' => '70',
				'modifiedby' => '52',
				'bill_street' => '21',
				'ship_street' => '21',
				'bill_city' => '1',
				'ship_city' => '1',
				'bill_state' => '1',
				'ship_state' => '1',
				'bill_code' => '1',
				'ship_code' => '1',
				'bill_country' => '1',
				'ship_country' => '1',
				'bill_pobox' => '1',
				'ship_pobox' => '1',
				'description' => '19',
				'campaignrelstatus' => '16',
				'cf_718' => '1',
				'cf_719' => '7',
				'cf_720' => '9',
				'cf_721' => '71',
				'cf_722' => '5',
				'cf_723' => '13',
				'cf_724' => '11',
				'cf_725' => '17',
				'cf_726' => '56',
				'cf_727' => '85',
				'cf_728' => '14',
				'cf_729' => '15',
				'cf_730' => '15',
				'cf_731' => '15',
				'cf_732' => '33',
				'isconvertedfromlead' => '56',
				'convertedfromlead' => '10',
				'created_user_id' => '52',
			)),
			array('Assets', array(
				'asset_no' => '4',
				'product' => '10',
				'serialnumber' => '2',
				'datesold' => '5',
				'dateinservice' => '5',
				'assetstatus' => '15',
				'tagnumber' => '2',
				'invoiceid' => '10',
				'shippingmethod' => '2',
				'shippingtrackingnumber' => '2',
				'assigned_user_id' => '53',
				'assetname' => '1',
				'account' => '10',
				'createdtime' => '70',
				'modifiedtime' => '70',
				'modifiedby' => '52',
				'description' => '19',
				'created_user_id' => '52',
			)),
			array('', array()),
			array('DoesNotExist', array()),
		);
	}

	/**
	 * Method testvtws_getUItype
	 * @test
	 * @dataProvider vtws_getUItypeProvider
	 */
	public function testvtws_getUItype($module, $expected) {
		global $current_user;
		$this->assertEquals($expected, vtws_getUItype($module, $current_user));
	}
}
?>