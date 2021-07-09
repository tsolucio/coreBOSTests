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

class UsersTest extends TestCase {

	/**
	 * Method testis_ActiveUserID
	 * @test
	 */
	public function testis_ActiveUserID() {
		$this->assertTrue(Users::is_ActiveUserID(1), 'is_ActiveUserID(1)');
		$this->assertFalse(Users::is_ActiveUserID(9), 'is_ActiveUserID(1)');
		$this->assertFalse(Users::is_ActiveUserID(-10), 'is_ActiveUserID(1)');
	}

	/**
	 * Method testretrieveCurrentUserInfoFromFile
	 * @test
	 */
	public function testretrieveCurrentUserInfoFromFile() {
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(1);
		$expected = array(
			'user_name' => 'admin',
			'is_admin' => 'on',
			'user_password' => '$1$ad000000$hzXFXvL3XVlnUE/X.1n9t/',
			'confirm_password' => '$1$ad000000$nYTnfhTZRmUP.wQT9y1AE.',
			'first_name' => '',
			'last_name' => 'Administrator',
			'roleid' => 'H2',
			'email1' => 'noreply@tsolucio.com',
			'status' => 'Active',
			'activity_view' => 'This Week',
			'lead_view' => 'Today',
			'hour_format' => '12',
			'end_hour' => '',
			'start_hour' => '08:00',
			'title' => '',
			'phone_work' => '',
			'department' => '',
			'phone_mobile' => '',
			'reports_to_id' => '0',
			'phone_other' => '',
			'email2' => '',
			'phone_fax' => '',
			'secondaryemail' => '',
			'phone_home' => '',
			'date_format' => 'yyyy-mm-dd',
			'signature' => '',
			'description' => '',
			'address_street' => '',
			'address_city' => '',
			'address_state' => '',
			'address_postalcode' => '',
			'address_country' => '',
			'accesskey' => 'cdYTBpiMR9RfGgO',
			'time_zone' => 'UTC',
			'currency_id' => '1',
			'currency_grouping_pattern' => '123,456,789',
			'currency_decimal_separator' => '.',
			'currency_grouping_separator' => ',',
			'currency_symbol_placement' => '$1.0',
			'imagename' => '',
			'internal_mailer' => '1',
			'theme' => 'softed',
			'language' => 'en_us',
			'reminder_interval' => '1 Minute',
			'asterisk_extension' => '',
			'use_asterisk' => '0',
			'send_email_to_sender' => '1',
			'no_of_currency_decimals' => '2',
			'failed_login_attempts' => '0',
			'currency_name' => 'Euro',
			'currency_code' => 'EUR',
			'currency_symbol' => '&#8364;',
			'conv_rate' => '1.000000',
			'imagenameimageinfo' => '',
			'ename' => ' Administrator',
		);
		if (empty($user->column_fields['reports_to_id'])) { // can be empty string or null too
			$user->column_fields['reports_to_id']= '0';
		}
		$this->assertEquals($expected, $user->column_fields, 'retrieveCurrentUserInfoFromFile admin');
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(8);
		$expected = array(
			'user_name' => 'testes',
			'is_admin' => 'off',
			'user_password' => '$1$te000000$W4LF3nSvqNxarBlPysu/v/',
			'confirm_password' => '$1$te000000$W4LF3nSvqNxarBlPysu/v/',
			'first_name' => 'cbTest',
			'last_name' => 'testes',
			'roleid' => 'H3',
			'email1' => 'noreply@tsolucio.com',
			'status' => 'Active',
			'activity_view' => 'This Week',
			'lead_view' => 'Today',
			'hour_format' => '24',
			'end_hour' => '',
			'start_hour' => '',
			'title' => '',
			'phone_work' => '',
			'department' => '',
			'phone_mobile' => '',
			'reports_to_id' => '',
			'phone_other' => '',
			'email2' => '',
			'phone_fax' => '',
			'secondaryemail' => '',
			'phone_home' => '',
			'date_format' => 'dd-mm-yyyy',
			'signature' => '',
			'description' => 'Test user for coreBOSTests',
			'address_street' => '',
			'address_city' => '',
			'address_state' => '',
			'address_postalcode' => '',
			'address_country' => '',
			'accesskey' => 'zTPcqxrq94pZB97U',
			'time_zone' => 'UTC',
			'currency_id' => '1',
			'currency_grouping_pattern' => '123,456,789',
			'currency_decimal_separator' => ',',
			'currency_grouping_separator' => '.',
			'currency_symbol_placement' => '$1.0',
			'imagename' => '',
			'internal_mailer' => '0',
			'theme' => 'softed',
			'language' => 'es_es',
			'reminder_interval' => 'None',
			'asterisk_extension' => '',
			'use_asterisk' => '0',
			'send_email_to_sender' => '0',
			'no_of_currency_decimals' => '2',
			'failed_login_attempts' => '0',
			'currency_name' => 'Euro',
			'currency_code' => 'EUR',
			'currency_symbol' => '&#8364;',
			'conv_rate' => '1.000000',
			'imagenameimageinfo' => '',
			'ename' => 'cbTest testes',
		);
		$this->assertEquals($expected, $user->column_fields, 'retrieveCurrentUserInfoFromFile testes');
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(9);
		$expected = array(
			'user_name' => 'testinactive',
			'is_admin' => 'off',
			'user_password' => '$1$te000000$sVoDGhf/MypKhGyaXkigU0',
			'confirm_password' => '$1$te000000$sVoDGhf/MypKhGyaXkigU0',
			'first_name' => 'cbTest',
			'last_name' => 'testinactive',
			'roleid' => 'H3',
			'email1' => 'noreply@tsolucio.com',
			'status' => 'Inactive',
			'activity_view' => 'This Week',
			'lead_view' => 'Today',
			'hour_format' => '24',
			'end_hour' => '',
			'start_hour' => '',
			'title' => '',
			'phone_work' => '',
			'department' => '',
			'phone_mobile' => '',
			'reports_to_id' => '',
			'phone_other' => '',
			'email2' => '',
			'phone_fax' => '',
			'secondaryemail' => '',
			'phone_home' => '',
			'date_format' => 'yyyy-mm-dd',
			'signature' => '',
			'description' => 'Test user for coreBOSTests',
			'address_street' => '',
			'address_city' => '',
			'address_state' => '',
			'address_postalcode' => '',
			'address_country' => '',
			'accesskey' => '1AfgXxwVqMKSKGBM',
			'time_zone' => 'UTC',
			'currency_id' => '1',
			'currency_grouping_pattern' => '123,456,789',
			'currency_decimal_separator' => '.',
			'currency_grouping_separator' => ',',
			'currency_symbol_placement' => '$1.0',
			'imagename' => '',
			'internal_mailer' => '0',
			'theme' => 'softed',
			'language' => 'en_us',
			'reminder_interval' => 'None',
			'asterisk_extension' => '',
			'use_asterisk' => '0',
			'send_email_to_sender' => '0',
			'no_of_currency_decimals' => '2',
			'failed_login_attempts' => '0',
			'currency_name' => 'Euro',
			'currency_code' => 'EUR',
			'currency_symbol' => '&#8364;',
			'conv_rate' => '1.000000',
			'imagenameimageinfo' => '',
			'ename' => 'cbTest testinactive',
		);
		if ($user->column_fields['currency_symbol']=='€') {
			$expected['currency_symbol']='€';
		}
		$this->assertEquals($expected, $user->column_fields, 'retrieveCurrentUserInfoFromFile inactive');
	}

	/**
	 * Method testverifyPassword
	 * @test
	 */
	public function testverifyPassword() {
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(1);
		$this->assertFalse($user->verifyPassword('not the right one'), 'verifyPassword 1 wrong');
		$this->assertTrue($user->verifyPassword('admin'), 'verifyPassword 1 right');
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(8);
		$this->assertFalse($user->verifyPassword('not the right one'), 'verifyPassword testes wrong');
		$this->assertTrue($user->verifyPassword('testes'), 'verifyPassword testes right');
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(9);
		$this->assertFalse($user->verifyPassword('not the right one'), 'verifyPassword testinactive wrong');
		$this->assertTrue($user->verifyPassword('testinactive'), 'verifyPassword testinactive right');
	}
}
