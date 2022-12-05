<?php
/*************************************************************************************************
 * Copyright 2022 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

class RetrieveUsersTest extends TestCase {

	/****
	 * TEST Users decimal configuration
	 * name format is: {decimal_separator}{symbol_position}{grouping}{grouping_symbol}{currency}
	 ****/
	public $usrdota0x = 5; // testdmy
	public $usrcomd0x = 6; // testmdy
	public $usrdotd3com = 7; // testymd
	public $usrcoma3dot = 10; // testtz
	public $usrdota3comdollar = 12; // testmcurrency

	/**
	 * Method testRetrieve
	 * @test
	 */
	public function testRetrieve() {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x); // testdmy
		$actual = vtws_retrieve('19x'.$this->usrdota0x, $user);
		$expected = array (
			'user_name' => 'testdmy',
			'is_admin' => 'off',
			'email1' => 'noreply@tsolucio.com',
			'status' => 'Active',
			'first_name' => 'cbTest',
			'last_name' => 'testdmy',
			'roleid' => 'H3',
			'currency_id' => '21x1',
			'currency_grouping_pattern' => '123456789',
			'currency_decimal_separator' => '.',
			'currency_grouping_separator' => ',',
			'currency_symbol_placement' => '$1.0',
			'lead_view' => 'Today',
			'activity_view' => 'This Week',
			'signature' => '',
			'hour_format' => '24',
			'start_hour' => '',
			'end_hour' => '',
			'title' => '',
			'phone_fax' => '',
			'department' => '',
			'email2' => '',
			'phone_work' => '',
			'secondaryemail' => '',
			'phone_mobile' => '',
			'reports_to_id' => '',
			'phone_home' => '',
			'phone_other' => '',
			'date_format' => 'dd-mm-yyyy',
			'description' => 'Test user for coreBOSTests',
			'internal_mailer' => '0',
			'time_zone' => 'UTC',
			'theme' => 'softed',
			'language' => 'en_us',
			'address_street' => '',
			'address_country' => '',
			'address_city' => '',
			'address_postalcode' => '',
			'address_state' => '',
			'asterisk_extension' => '',
			'use_asterisk' => '0',
			'rolename' => 'Vice President',
			'currency_idename' => array(
				'module' => 'Currency',
				'reference' => 'Euro : &euro;',
				'cbuuid' => '',
			),
			'ename' => 'cbTest testdmy',
			'no_of_currency_decimals' => '2',
			'send_email_to_sender' => '0',
			'id' => '19x5',
		);
		$this->assertEquals($expected, $actual, 'retrieve user usrdota0x as usrdota0x');
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(1);
		$actual = vtws_retrieve('19x'.$this->usrdota0x, $user);
		$this->assertEquals($expected, $actual, 'retrieve user usrdota0x as admin');
		$expected = array (
			'user_name' => 'admin',
			'is_admin' => 'on',
			'email1' => 'noreply@tsolucio.com',
			'status' => 'Active',
			'first_name' => '',
			'last_name' => 'Administrator',
			'roleid' => 'H2',
			'currency_id' => '21x1',
			'currency_grouping_pattern' => '123,456,789',
			'currency_decimal_separator' => '.',
			'currency_grouping_separator' => ',',
			'currency_symbol_placement' => '$1.0',
			'lead_view' => 'Today',
			'activity_view' => 'This Week',
			'signature' => '',
			'hour_format' => '12',
			'start_hour' => '08:00',
			'end_hour' => '',
			'title' => '',
			'phone_fax' => '',
			'department' => '',
			'email2' => '',
			'phone_work' => '',
			'secondaryemail' => '',
			'phone_mobile' => '',
			'reports_to_id' => '',
			'phone_home' => '',
			'phone_other' => '',
			'date_format' => 'yyyy-mm-dd',
			'description' => '',
			'internal_mailer' => '1',
			'time_zone' => 'UTC',
			'theme' => 'softed',
			'language' => 'en_us',
			'address_street' => '',
			'address_country' => '',
			'address_city' => '',
			'address_postalcode' => '',
			'address_state' => '',
			'asterisk_extension' => '',
			'use_asterisk' => '0',
			'rolename' => 'CEO',
			'currency_idename' => array(
				'module' => 'Currency',
				'reference' => 'Euro : &euro;',
				'cbuuid' => '',
			),
			'ename' => ' Administrator',
			'no_of_currency_decimals' => '2',
			'send_email_to_sender' => '1',
			'id' => '19x1',
		);
		$actual = vtws_retrieve('19x1', $user);
		$this->assertEquals($expected, $actual, 'retrieve user usrdota0x as admin');
		/// end
		$current_user = $holduser;
	}

	/**
	 * Method testRetrieveExceptionNoAccessRecord
	 * @test
	 */
	public function testRetrieveExceptionNoAccessRecord() {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrcoma3dot);
		$current_user = $user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		try {
			vtws_retrieve('19x1', $user);
		} catch (\Throwable $th) {
			$current_user = $holduser;
			throw $th;
		}
	}
}
?>