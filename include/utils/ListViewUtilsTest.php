<?php
/*************************************************************************************************
 * Copyright 2016 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

class testListViewUtils extends TestCase {

	/****
	 * TEST Users
	 ****/
	private $testusers = array(
		'usrtestdmy' => 5,
		'usrtestmdy' => 6,
		'usrtestymd' => 7,
		'usrtesttz' => 10,
		'usrnocreate' => 11,
		'usrtestmcurrency' => 12
	);

	/**
	 * Method testgetMergeFields
	 * @test
	 */
	public function testgetMergeFields() {
		global $current_user;
		$flistAcc = '<option value="1">Organization Name</option><option value="3">Phone</option><option value="4">Website</option><option value="5">Fax</option><option value="6">Ticker Symbol</option><option value="7">Other Phone</option><option value="8">Member Of</option><option value="9">Email</option><option value="10">Employees</option><option value="11">Other Email</option><option value="12">Ownership</option><option value="13">Rating</option><option value="14">Industry</option><option value="15">SIC Code</option><option value="16">Type</option><option value="17">Annual Revenue</option><option value="18">Email Opt Out</option><option value="19">Notify Owner</option><option value="20">Assigned To</option><option value="23">Last Modified By</option><option value="24">Billing Address</option><option value="25">Shipping Address</option><option value="26">Billing City</option><option value="27">Shipping City</option><option value="28">Billing State</option><option value="29">Shipping State</option><option value="30">Billing Postal Code</option><option value="31">Shipping Postal Code</option><option value="32">Billing Country</option><option value="33">Shipping Country</option><option value="34">Billing PO Box</option><option value="35">Shipping PO Box</option><option value="36">Description</option><option value="718">Text</option><option value="719">Number</option><option value="720">Percent</option><option value="721">Currency</option><option value="722">Date</option><option value="723">Emailcf</option><option value="724">Phonecf</option><option value="725">URL</option><option value="726">Checkbox</option><option value="727">skypecf</option><option value="728">Time</option><option value="729">PLMain</option><option value="730">PLDep1</option><option value="731">PLDep2</option><option value="732">Planets</option><option value="752">Is Converted From Lead</option><option value="753">Converted From Lead</option><option value="764">Created By</option>';
		$flistLds = '<option value="37">Salutation</option><option value="38">First Name</option><option value="40">Phone</option><option value="41">Last Name</option><option value="42">Mobile</option><option value="43">Organization</option><option value="44">Fax</option><option value="45">Title</option><option value="46">Email</option><option value="47">Lead Source</option><option value="48">Website</option><option value="49">Industry</option><option value="50">Lead Status</option><option value="51">Annual Revenue</option><option value="52">Rating</option><option value="53">No Of Employees</option><option value="54">Assigned To</option><option value="55">Secondary Email</option><option value="58">Last Modified By</option><option value="59">Street</option><option value="60">Postal Code</option><option value="61">City</option><option value="62">Country</option><option value="63">State</option><option value="64">PO Box</option><option value="65">Description</option><option value="751">Email Opt Out</option><option value="765">Created By</option>';
		$holduser = $current_user;
		$current_user = Users::getActiveAdminUser();
		$actual = getMergeFields('Accounts', 'available_fields');
		$this->assertEquals($flistAcc, $actual, "getMergeFields available_fields Accounts");
		$actual = getMergeFields('Accounts', 'fields_to_merge');
		$this->assertEquals('', $actual, "getMergeFields fields_to_merge Accounts");
		$actual = getMergeFields('Leads', 'available_fields');
		$this->assertEquals($flistLds, $actual, "getMergeFields available_fields Leads");
		$actual = getMergeFields('Leads', 'fields_to_merge');
		$this->assertEquals('<option value="38">First Name</option><option value="41">Last Name</option>', $actual, "getMergeFields fields_to_merge Leads");
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->testusers['usrnocreate']);
		$current_user = $user;
		$actual = getMergeFields('Accounts', 'available_fields');
		$this->assertEquals($flistAcc, $actual, "getMergeFields available_fields Accounts");
		$actual = getMergeFields('Accounts', 'fields_to_merge');
		$this->assertEquals('', $actual, "getMergeFields fields_to_merge Accounts");
		$actual = getMergeFields('Leads', 'available_fields');
		$this->assertEquals($flistLds, $actual, "getMergeFields available_fields Leads");
		$actual = getMergeFields('Leads', 'fields_to_merge');
		$this->assertEquals('', $actual, "getMergeFields fields_to_merge Leads");
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->testusers['usrtestdmy']);
		$current_user = $user;
		$actual = getMergeFields('Accounts', 'available_fields');
		$this->assertEquals($flistAcc, $actual, "getMergeFields available_fields Accounts");
		$actual = getMergeFields('Accounts', 'fields_to_merge');
		$this->assertEquals('', $actual, "getMergeFields fields_to_merge Accounts");
		$actual = getMergeFields('Leads', 'available_fields');
		$this->assertEquals($flistLds, $actual, "getMergeFields available_fields Leads");
		$actual = getMergeFields('Leads', 'fields_to_merge');
		$this->assertEquals('', $actual, "getMergeFields fields_to_merge Leads");
		$current_user = $holduser;
	}

}