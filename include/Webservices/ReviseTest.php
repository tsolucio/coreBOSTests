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
class WSReviseTest extends TestCase {

	/****
	 * TEST Users decimal configuration
	 * name format is: {decimal_separator}{symbol_position}{grouping}{grouping_symbol}{currency}
	 ****/
	var $usrdota0x = 5; // testdmy
	var $usrcomd0x = 6; // testmdy
	var $usrdotd3com = 7; // testymd
	var $usrcoma3dot = 10; // testtz
	var $usrdota3comdollar = 12; // testmcurrency

	/**
	 * Method testReviseWithCheckboxes
	 * @test
	 */
	public function testReviseWithCheckboxes() {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		///////////
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x); // testdmy
		$current_user = $user;
		$cbUserID = '19x'.$current_user->id;
		$ObjectValues = array(
			'salutationtype' => '',
			'firstname' => 'Lemuel',
			'contact_no' => 'CON58',
			'phone' => '631-748-6479',
			'lastname' => 'Latzke',
			'mobile' => '631-291-4976',
			'account_id' => '11x131',
			'homephone' => '',
			'leadsource' => 'Conference',
			'otherphone' => '',
			'title' => 'Director',
			'fax' => '',
			'department' => 'Manufacturing',
			'birthday' => '1973-04-03',
			'email' => 'lemuel.latzke@gmail.com',
			'contact_id' => '',
			'assistant' => '',
			'secondaryemail' => '',
			'assistantphone' => '',
			'donotcall' => '0',
			'emailoptout' => '0',
			'assigned_user_id' => '19x6',
			'reference' => '0',
			'notify_owner' => '0',
			'createdtime' => '2015-03-23 20:10:12',
			'modifiedtime' => '2016-03-25 01:28:44',
			'modifiedby' => '19x1',
			'isconvertedfromlead' => '',
			'convertedfromlead' => '',
			'created_user_id' => '19x1',
			'portal' => '0',
			'support_start_date' => '',
			'support_end_date' => '',
			'mailingstreet' => '70 Euclid Ave #722',
			'otherstreet' => '70 Euclid Ave #722',
			'mailingcity' => 'Bohemia',
			'othercity' => 'Bohemia',
			'mailingstate' => 'NY',
			'otherstate' => 'NY',
			'mailingzip' => '11716',
			'otherzip' => '11716',
			'mailingcountry' => 'United States of America',
			'othercountry' => 'United States of America',
			'mailingpobox' => '',
			'otherpobox' => '',
			'description' => ' Estne, quaeso, inquam, sitienti in bibendo voluptas? Duarum enim vitarum nobis erunt instituta capienda. Respondeat totidem verbis. Quod, inquit, quamquam voluptatibus quibusdam est saepe iucundius, tamen expetitur propter voluptatem. Duo Reges: constructio interrete. Nihilo magis. Miserum hominem! Si dolor summum malum est, dici aliter non potest. Nec lapathi suavitatem acupenseri Galloni Laelius anteponebat, sed suavitatem ipsam neglegebat; Dempta enim aeternitate nihilo beatior Iuppiter quam Epicurus; 

',
			'imagename' => '',
			'id' => '12x1150', // Contacts
		);
		$updateValues = array(
			'otherphone' => '123456789',
			'donotcall' => 0,
			'emailoptout' => 1,
			'reference' => '1',
			'notify_owner' => '0',
			'id' => '12x1150',
		);
		$_FILES = array();
		$actual = vtws_revise($updateValues, $current_user);
		$expected = $ObjectValues;
		$expected['otherphone'] = '123456789';
		$expected['donotcall'] = '0';
		$expected['emailoptout'] = '1';
		$expected['reference'] = '1';
		$expected['notify_owner'] = '0';
		$expected['modifiedtime'] = $actual['modifiedtime'];
		$expected['modifiedby'] = $actual['modifiedby'];
		$this->assertEquals($expected, $actual, 'Test checkbox usrdota0x Correct');
		/// end
		$current_user = $holduser;
	}

}
?>