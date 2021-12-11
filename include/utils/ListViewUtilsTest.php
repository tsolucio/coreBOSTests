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

class ListViewUtilsTest extends TestCase {

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
	private $documentcreated = false;

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

	/**
	 * Method textlength_checkProvider
	 * params
	 */
	public function textlength_checkProvider() {
		return array(
			array('smaller40', 0, 'smaller40'),
			array('line1<br>line2', 0, 'line1&lt;br&gt;line2'),
			array('this one is a little bigger than the 40 default cut size', 0, 'this one is a little bigger than the 40 ...'),
			array('smaller40', 20, 'smaller40'),
			array('line1<br>line2', 20, 'line1&lt;br&gt;line2'),
			array('this one is a little bigger than the 40 default cut size', 20, 'this one is a little...'),
			array('word on cut size', 10, 'word on cu...'),
			array('word <strong>on</strong> cut size', 10, 'word &lt;stro...'),
			array('word <strong>on</strong> cut size', 100, 'word &lt;strong&gt;on&lt;/strong&gt; cut size'),
			array('probability>50', 10, 'probabilit...'),
			array('probability>50', 20, 'probability&gt;50'),
			array('probability>50', 12, 'probability&gt;...'),
			array('probability<50', 10, 'probabilit...'),
			array('probability<50', 20, 'probability&lt;50'),
			array('probability<50', 12, 'probability&lt;...'),
			array('probability&gt;50', 0, 'probability&gt;50'),
			array('probability&lt;50', 0, 'probability&lt;50'),
			array('<SvG/onLoad=confirm(document.cookie)', 0, '&lt;SvG/onLoad=confirm(document.cookie)'),
		);
	}

	/**
	 * Method testtextlength_check
	 * @test
	 * @dataProvider textlength_checkProvider
	 */
	public function testtextlength_check($inputtext, $cutsize, $expected) {
		$this->assertEquals($expected, textlength_check($inputtext, $cutsize), 'textlength_check: '.$inputtext);
	}

	/**
	 * Method getFirstModuleProvider
	 * params
	 */
	public function getFirstModuleProvider() {
		return array(
			array('', '', ''),
			array('', 'doesnotexist', ''),
			array('doesnotexist', '', ''),
			array('doesnotexist', 'doesnotexist', ''),
			array('cbCalendar', 'doesnotexist', ''),
			array('doesnotexist', 'dtend', ''),
			array('cbCalendar', 'dtend', ''),
			array('cbCalendar', 'rel_id', 'Accounts'),
			array('Potentials', 'related_to', 'Accounts'),
			array('Potentials', 'campaignid', 'Campaigns'),
			array('CobroPago', 'related_id', 'Invoice'),
			array('HelpDesk', 'parent_id', 'Accounts'),
		);
	}

	/**
	 * Method testgetFirstModule
	 * @test
	 * @dataProvider getFirstModuleProvider
	 */
	public function testgetFirstModule($module, $fieldname, $expected) {
		$this->assertEquals($expected, getFirstModule($module, $fieldname), 'getFirstModule');
	}

	/**
	 * Method getFirstFieldForModuleProvider
	 * params
	 */
	public function getFirstFieldForModuleProvider() {
		return array(
			array('', '', ''),
			array('', 'doesnotexist', ''),
			array('doesnotexist', '', ''),
			array('doesnotexist', 'doesnotexist', ''),
			array('cbCalendar', 'doesnotexist', ''),
			array('doesnotexist', 'cbCalendar', ''),
			array('cbCalendar', 'cbCalendar', 'relatedwith'),
			array('cbCalendar', 'Accounts', 'rel_id'),
			array('Potentials', 'Accounts', 'related_to'),
			array('Potentials', 'Campaigns', 'campaignid'),
			array('CobroPago', 'Invoice', 'related_id'),
			array('HelpDesk', 'Accounts', 'parent_id'),
			array('InventoryDetails', 'Invoice', 'related_to'),
			array('InventoryDetails', 'PurchaseOrder', 'related_to'),
		);
	}

	/**
	 * Method testgetFirstFieldForModule
	 * @test
	 * @dataProvider getFirstFieldForModuleProvider
	 */
	public function testgetFirstFieldForModule($module, $relmodule, $expected) {
		$this->assertEquals($expected, getFirstFieldForModule($module, $relmodule), 'getFirstFieldForModule');
	}

	/**
	 * Method getRelatedToProvider
	 * params
	 */
	public function getRelatedToProvider() {
		return array(
			array('Emails', 'select 26736 as activityid', 0, "<a href='index.php?module=Accounts&action=DetailView&record=74'>Chemex Labs Ltd</a><span type='vtlib_metainfo' vtrecordid='74' vtfieldname='accountname' vtmodule='Accounts' style='display:none;'></span>"),
			array('Emails', 'select 26784 as activityid', 0, 'Multiple'),
			array(
				'Documents',
				'select vtiger_notes.notesid
					from vtiger_notes
					inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_notes.notesid
					inner join vtiger_senotesrel on vtiger_senotesrel.notesid=vtiger_notes.notesid
					where deleted=0 and vtiger_senotesrel.crmid=75 limit 1',
				0,
				"<a href='index.php?module=Accounts&action=DetailView&record=75'>Atrium Marketing Inc</a><span type='vtlib_metainfo' vtrecordid='75' vtfieldname='accountname' vtmodule='Accounts' style='display:none;'></span>"
			),
			array(
				'Documents',
				'select vtiger_notes.notesid
					from vtiger_notes
					inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_notes.notesid
					inner join vtiger_senotesrel on vtiger_senotesrel.notesid=vtiger_notes.notesid
					where deleted=0 and vtiger_senotesrel.crmid=74 limit 1',
				0,
				'Multiple'
			),
			array('Products', 'select 2627 as productid', 0, "<a href='index.php?module=Contacts&action=DetailView&record=1104'>Amber Windell</a><span type='vtlib_metainfo' vtrecordid='1104' vtfieldname='firstname' vtmodule='Contacts' style='display:none;'></span>"),
			array('cbCalendar', 'select 29396 as activityid', 0, "<a href='index.php?module=Accounts&action=DetailView&record=77'>Sherpa Corp</a><span type='vtlib_metainfo' vtrecordid='77' vtfieldname='accountname' vtmodule='Accounts' style='display:none;'></span>"),
			array('HelpDesk', 'select 843 as parent_id', 0, "<img src=\"themes/images/Accounts.gif\" alt=\"Organizations\" title=\"Organizations\" border=0 align=center><a href='index.php?module=Accounts&action=DetailView&record=843'>Lynema, Cliff Cpa</a><span type='vtlib_metainfo' vtrecordid='843' vtfieldname='accountname' vtmodule='Accounts' style='display:none;'></span>"),
			array('Invoice', 'select 1 as activityid', 0, ''),
			array('Invoice', 'select 1', 0, 'Multiple'),
			array('HelpDesk', 'select 843 as parent_id', 1, ''),
		);
	}

	/**
	 * Method testgetRelatedTo
	 * @test
	 * @dataProvider getRelatedToProvider
	 */
	public function testgetRelatedTo($module, $list_query, $rset, $expected) {
		global $adb, $current_user;
		if (!$this->documentcreated) {
			$this->documentcreated = true;
			$Module = 'Documents';
			$ObjectValues = array(
				'assigned_user_id' => '19x1',
				'created_user_id' => '19x1',
				'notes_title' => 'create doc for get related to test with account 75',
				'filename'=>'somewhere in the world',
				'filetype'=>'',
				'filesize'=> 0,
				'fileversion'=>'2',
				'filelocationtype'=>'E',
				'filedownloadcount'=> '0',
				'filestatus'=> '1',
				'folderid' => '22x1',
				'notecontent' => 'áçèñtös',
				'modifiedby' => '19x1',
				'template' => '0',
				'template_for' => '',
				'mergetemplate' => '0',
				'relations' => array('11x75'),
			);
			$_FILES=array();
			vtws_create($Module, $ObjectValues, $current_user);
			$ObjectValues = array(
				'assigned_user_id' => '19x1',
				'created_user_id' => '19x1',
				'notes_title' => 'create doc for get related to test with account 74 and contact 1084',
				'filename'=>'somewhere in the world',
				'filetype'=>'',
				'filesize'=> 0,
				'fileversion'=>'2',
				'filelocationtype'=>'E',
				'filedownloadcount'=> '0',
				'filestatus'=> '1',
				'folderid' => '22x1',
				'notecontent' => 'áçèñtös',
				'modifiedby' => '19x1',
				'template' => '0',
				'template_for' => '',
				'mergetemplate' => '0',
				'relations' => array('11x74','12x1084'),
			);
			$_FILES=array();
			vtws_create($Module, $ObjectValues, $current_user);
			$adb->query('insert into vtiger_seproductsrel values (1104, 2627, "Contacts");');
		}
		$list_result = $adb->query($list_query);
		$this->assertEquals($expected, getRelatedTo($module, $list_result, $rset), 'getRelatedTo');
	}
}