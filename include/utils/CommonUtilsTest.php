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

class testCommonUtils extends PHPUnit_Framework_TestCase {

	/****
	 * TEST Users
	 ****/
	var $testusers = array(
		'usrtestdmy' => 5,
		'usrtestmdy' => 6,
		'usrtestymd' => 7,
		'usrtesttz' => 10,
		'usrnocreate' => 11,
		'usrtestmcurrency' => 12
	);

	/**
	 * Method testgetCurrencyName
	 * @test
	 */
	public function testgetCurrencyName() {
		$actual = getCurrencyName(1,false);
		$this->assertEquals('Euro', $actual,"currency name 1 no symbol");
		$actual = getCurrencyName(1,true);
		$this->assertEquals('Euro : &euro;', $actual,"currency name 1 symbol");
		$actual = getCurrencyName(2,false);
		$this->assertEquals('USA, Dollars', $actual,"currency name 2 no symbol");
		$actual = getCurrencyName(2,true);
		$this->assertEquals('USA, Dollars : $', $actual,"currency name 2 symbol");
	}

	/**
	 * Method testgetCurrencyName
	 * @test
	 */
	public function testgetCurrencySymbolandCRate() {
		$actual = getCurrencySymbolandCRate(1);
		$expected = array(
			'rate' => '1.0',
			'symbol' => '&euro;',
			'position' => '1.0$',
		);
		$this->assertEquals($expected, $actual,"currency symrate 1");
		$actual = getCurrencySymbolandCRate(2);
		$expected = array(
			'rate' => '1.10',
			'symbol' => '$',
			'position' => '$1.0',
		);
		$this->assertEquals($expected, $actual,"currency symrate 2");
	}

	/**
	 * Method testgetBasic_Advance_SearchURL
	 * @test
	 */
	public function testgetBasic_Advance_SearchURL() {
		$actualRequest = $_REQUEST;
		$_REQUEST = array (
		  'module' => 'Home',
		  'action' => 'HomeAjax',
		  'file' => 'HomeWidgetBlockList',
		  'widgetInfoList' => '[{"widgetId":14,"widgetType":"Default"},{"widgetId":15,"widgetType":"Tag Cloud"}]',
		  'query' => 'true',
		  'searchtype' => 'advance',
		  'advft_criteria' => '[{"groupid":1,"columnname":"vtiger_faq:status:faqstatus:Faq_Status:V","comparator":"n","value":"Obsolete","columncondition":null}]',
		  'advft_criteria_groups' => '{"1":{"groupcondition":null}}',
		);
		$actual = getBasic_Advance_SearchURL();
		$expected = '&query=true&searchtype=advance';
		$this->assertEquals($expected, $actual,"getBasic_Advance_SearchURL 1");
		$_REQUEST = array (
		  'search_field' => 'firstname',
		  'searchtype' => 'BasicSearch',
		  'search_text' => 'lina',
		  'parenttab' => 'ptab',
		  'query' => 'true',
		  'file' => 'index',
		  'module' => 'Contacts',
		  'action' => 'ContactsAjax',
		  'ajax' => 'true',
		  'search' => 'true',
		);
		$actual = getBasic_Advance_SearchURL();
		$expected = '&query=true&searchtype=BasicSearch&search_field=firstname&search_text=lina';
		$this->assertEquals($expected, $actual,"getBasic_Advance_SearchURL 2");
		$_REQUEST = array (
		  'search_field' => 'account_id',
		  'searchtype' => 'BasicSearch',
		  'search_text' => '&',
		  'parenttab' => 'ptab',
		  'query' => 'true',
		  'file' => 'index',
		  'module' => 'Contacts',
		  'action' => 'ContactsAjax',
		  'ajax' => 'true',
		  'search' => 'true',
		);
		$actual = getBasic_Advance_SearchURL();
		$expected = '&query=true&searchtype=BasicSearch&search_field=account_id&search_text=&amp;';
		$this->assertEquals($expected, $actual,"getBasic_Advance_SearchURL 3");
		$_REQUEST = array (
		  'advft_criteria' => '[{"groupid":"1","columnname":"vtiger_contactdetails:firstname:firstname:Contacts_First_Name:V","comparator":"c","value":"lina","columncondition":"and"},{"groupid":"1","columnname":"vtiger_contactdetails:accountid:account_id:Contacts_Account_Name:V","comparator":"c","value":"&","columncondition":""}]',
		  'advft_criteria_groups' => '[null,{"groupcondition":""}]',
		  'searchtype' => 'advance',
		  'query' => 'true',
		  'file' => 'index',
		  'module' => 'Contacts',
		  'action' => 'ContactsAjax',
		  'ajax' => 'true',
		  'search' => 'true',
		);
		$actual = getBasic_Advance_SearchURL();
		$expected = '&query=true&searchtype=advance';
		$this->assertEquals($expected, $actual,"getBasic_Advance_SearchURL 4");
		$_REQUEST = array (
		  'advft_criteria' => '[{"groupid":"1","columnname":"vtiger_accountscf:cf_722:cf_722:Accounts_Date:D","comparator":"e","value":"$","columncondition":""}]',
		  'advft_criteria_groups' => '[null,{"groupcondition":""}]',
		  'searchtype' => 'advance',
		  'query' => 'true',
		  'file' => 'index',
		  'module' => 'Accounts',
		  'action' => 'AccountsAjax',
		  'ajax' => 'true',
		  'search' => 'true',
		);
		$actual = getBasic_Advance_SearchURL();
		$expected = '&query=true&searchtype=advance';
		$this->assertEquals($expected, $actual,"getBasic_Advance_SearchURL 5");
		$_REQUEST = array (
		  'search_field' => 'account_id',
		  'searchtype' => 'BasicSearch',
		  'search_text' => '& li',
		  'parenttab' => 'ptab',
		  'query' => 'true',
		  'file' => 'index',
		  'module' => 'Contacts',
		  'action' => 'ContactsAjax',
		  'ajax' => 'true',
		  'search' => 'true',
		);
		$actual = getBasic_Advance_SearchURL();
		$expected = '&query=true&searchtype=BasicSearch&search_field=account_id&search_text=&amp; li';
		$this->assertEquals($expected, $actual,"getBasic_Advance_SearchURL 6");
		$_REQUEST = $actualRequest;
	}

	/**
	 * Method testisInsideApplication
	 * @test
	 */
	function testisInsideApplication() {
		$this->assertTrue(isInsideApplication('modules'),"isInsideApplication modules");
		$this->assertTrue(isInsideApplication('modules/cbupdater'),"isInsideApplication modules/cbupdater");
		$this->assertTrue(isInsideApplication('modules/cbupdater/cbupdater.php'),"isInsideApplication modules/cbupdater/cbupdater.php");
		$this->assertFalse(isInsideApplication('/etc'),"isInsideApplication /etc");
		$this->assertFalse(isInsideApplication('..'),"isInsideApplication ..");
	}

	/**
	 * Method testbr2nlProvidor
	 * params
	 */
	function testbr2nlProvidor() {
		return array(
			array('line1','line1','br2nl one line'),
			array('line1<br>line2','line1<br>line2','br2nl two lines <br>'),
			array('line1<br/>line2','line1<br/>line2','br2nl two lines <br/>'),
			array('line1
line2','line1\nline2','br2nl two lines nl'),
			array('line1line2','line1\rline2','br2nl two lines cr'),
			array('line2
line2','line2\r\nline2','br2nl two lines crnl'),
			array('line1
line2','line1\n\rline2','br2nl two lines nlcr'),
			array("line1\nline2",'line1\nline2','br2nl two lines nl'),
			array("line1\rline2",'line1\rline2','br2nl two lines cr'),
			array("line1\r\nline2",'line1\r\nline2','br2nl two lines crnl'),
			array("line1\n\rline2",'line1\n\rline2','br2nl two lines nlcr'),
			array("line1'line2",'line1 line2','br2nl two lines singlequote'),
			array('line1"line2','line1 line2','br2nl two lines doublequote'),
		);
	}

	/**
	 * Method testbr2nl
	 * @test
	 * @dataProvider testbr2nlProvidor
	 */
	function testbr2nl($input, $expected, $msg) {
		$this->assertEquals($expected, br2nl($input), $msg);
	}

	/**
	 * Method testgetUserslist1
	 * @test
	 */
	function testgetUserslist1() {
		global $current_user, $module;
		$module = 'Utilities';
		$hold_user = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(1);
		$current_user = $user;
		$actual = getUserslist(true);
		$expected = '<option value=1 selected> Administrator</option><option value=11 >nocreate cbTest</option><option value=5 >cbTest testdmy</option><option value=8 >cbTest testes</option><option value=12 >cbTest testmcurrency</option><option value=6 >cbTest testmdy</option><option value=10 >cbTest testtz</option><option value=13 >cbTest testtz-3</option><option value=7 >cbTest testymd</option>';
		$this->assertEquals($expected, $actual, 'getUserslist admin true');
		$actual = getUserslist(false);
		$expected = '<option value=1> Administrator</option><option value=11>nocreate cbTest</option><option value=5>cbTest testdmy</option><option value=8>cbTest testes</option><option value=12>cbTest testmcurrency</option><option value=6>cbTest testmdy</option><option value=10>cbTest testtz</option><option value=13>cbTest testtz-3</option><option value=7>cbTest testymd</option>';
		$this->assertEquals($expected, $actual, 'getUserslist admin false');
		$actual = getUserslist(true,5);
		$expected = '<option value=1 > Administrator</option><option value=11 >nocreate cbTest</option><option value=5 selected>cbTest testdmy</option><option value=8 >cbTest testes</option><option value=12 >cbTest testmcurrency</option><option value=6 >cbTest testmdy</option><option value=10 >cbTest testtz</option><option value=13 >cbTest testtz-3</option><option value=7 >cbTest testymd</option>';
		$this->assertEquals($expected, $actual, 'getUserslist admin false');
		$current_user = $hold_user;
	}

	/**
	 * Method testgetUserslist5
	 * @test
	 */
	function testgetUserslist2() {
		// Cannot be executed together with testgetUserslist1 due to cache
// 		global $current_user, $module;
// 		$module = 'Utilities';
// 		$hold_user = $current_user;
// 		$user = new Users();
// 		$user->retrieveCurrentUserInfoFromFile($this->testusers['usrtestdmy']);
// 		$current_user = $user;
// 		$actual = getUserslist(true);
// 		$expected = '<option value=11 >nocreate cbTest</option><option value=5 selected>cbTest testdmy</option>';
// 		$this->assertEquals($expected, $actual, 'getUserslist testdmy true');
// 		$actual = getUserslist(false);
// 		$expected = '<option value=11>nocreate cbTest</option><option value=5>cbTest testdmy</option>';
// 		$this->assertEquals($expected, $actual, 'getUserslist testdmy false');
// 		$current_user = $hold_user;
	}
}
