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
		global $root_directory;
		$this->assertTrue(isInsideApplication('modules'),"isInsideApplication modules");
		$this->assertTrue(isInsideApplication('modules/cbupdater'),"isInsideApplication modules/cbupdater");
		$this->assertTrue(isInsideApplication('modules/cbupdater/cbupdater.php'),"isInsideApplication modules/cbupdater/cbupdater.php");
		$this->assertFalse(isInsideApplication('/etc'),"isInsideApplication /etc");
		$this->assertFalse(isInsideApplication('..'),"isInsideApplication ..");
		$this->assertFalse(isInsideApplication('&#046;&#046;'),"isInsideApplication encoded ..");
		$this->assertFalse(isInsideApplication('modules\cbupdater\cbupdater.php'),"isInsideApplication modules\cbupdater\cbupdater.php");
		$this->assertFalse(isInsideApplication('../modules/cbupdater/cbupdater.php'),"isInsideApplication ../modules/cbupdater/cbupdater.php");
		$this->assertFalse(isInsideApplication('modules/../../../../etc'),"isInsideApplication modules/../../../../etc");
		$this->assertFalse(isInsideApplication('\etc'),"isInsideApplication \etc");
		$this->assertFalse(isInsideApplication('modules\\cbupdater\\cbupdater.php'),"isInsideApplication modules\\cbupdater\\cbupdater.php");
		$this->assertFalse(isInsideApplication('modules\\\\cbupdater\\\\cbupdater.php'),'isInsideApplication modules\\\\cbupdater\\\\cbupdater.php');
		$this->assertTrue(isInsideApplication($root_directory.'index.php'),'isInsideApplication $root_directory');
		$this->assertFalse(isInsideApplication('\\etc'),'isInsideApplication \\etc');
	}

	/**
	 * Method testisFileAccessible
	 * @test
	 */
	function testisFileAccessible() {
		$this->assertTrue(true,"isFileAccessible tested in testisInsideApplication");
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

	/**
	 * Method testgetMergedDescriptionProvidor
	 * params
	 */
	function testgetMergedDescriptionProvidor() {
		$lang = return_module_language('en_us', 'Reports');
		$mes = date('m')-1;
		return array(
			array('Description $leads-firstname$',4260,'Leads','Description Timothy','Lead name alone'),
			array('Description $users-user_name$',5,'Users','Description testdmy','User name alone'),
			array('Description $leads-firstname$ $users-user_name$',4260,'Leads','Description Timothy $users-user_name$','Lead name + user name'),
			array('Description $leads-firstname$ $users-user_name$',5,'Users','Description $leads-firstname$ testdmy','User name + lead name'),
			array('Description $leads-firstname$ $users-user_name$',0,'Leads','Description $leads-firstname$ $users-user_name$','Empty ID'),
			array('Description $leads-firstname$ $users-user_name$',5,'','Description $leads-firstname$ $users-user_name$','Empty Entity'),
			array('$leads-firstname$  Firstname

$leads-lastname$  Last Name

$leads-email$

Email',4260,'Leads','Timothy  Firstname

Mulqueen  Last Name

timothy_mulqueen@mulqueen.org

Email','Multiple vars and lines'),
			array('Dear 

Thank you for your confidence in our ability to serve you. 
We are glad to be given the chance to serve you.I look ',5,'Users','Dear 

Thank you for your confidence in our ability to serve you. 
We are glad to be given the chance to serve you.I look ','Just text'),
			array('<table align="center" border="0" cellpadding="0" cellspacing="0" style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; font-weight: normal; text-decoration: none; background-color: rgb(122, 122, 254);" width="700">
				<tr>
					<td align="center" rowspan="4">$logo$</td>
					<td align="center">&nbsp;</td>
				</tr>
				<td style="font-family: Arial,Helvetica,sans-serif; font-size: 14px; color: rgb(22, 72, 134); font-weight: bolder; line-height: 15px;">Dear $contact_name$,</td>
				<tr>
					<td><br />
					User ID : <font color="#990000"><strong> $login_name$</strong></font></td>
				</tr>
				<tr>
					<td>Password: <font color="#990000"><strong> $password$</strong></font></td>
				</tr>
				<tr>
					<td align="center"><strong>$URL$</strong></td>
				</tr>
			</table>',1086,'Contacts','<table align="center" border="0" cellpadding="0" cellspacing="0" style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; font-weight: normal; text-decoration: none; background-color: rgb(122, 122, 254);" width="700">
				<tr>
					<td align="center" rowspan="4">$logo$</td>
					<td align="center">&nbsp;</td>
				</tr>
				<td style="font-family: Arial,Helvetica,sans-serif; font-size: 14px; color: rgb(22, 72, 134); font-weight: bolder; line-height: 15px;">Dear $contact_name$,</td>
				<tr>
					<td><br />
					User ID : <font color="#990000"><strong> $login_name$</strong></font></td>
				</tr>
				<tr>
					<td>Password: <font color="#990000"><strong> $password$</strong></font></td>
				</tr>
				<tr>
					<td align="center"><strong>$URL$</strong></td>
				</tr>
			</table>','HTML and inexistent variables'),
			array('Contact name: $contacts-lastname$
Contact Image: $contacts-imagename$
Contact Image Field: $contacts-imagename_fullpath$',1086,'Contacts','Contact name: Hirpara
Contact Image: 
Contact Image Field: $contacts-imagename_fullpath$','Contact Image'),
			array('Contact name: $contacts-lastname$
Current Date: $custom-currentdate$',1086,'Contacts','Contact name: Hirpara
Current Date: '.$lang['MONTH_STRINGS'][$mes].date(" j, Y"),'General variables'),
		);
	}

	/**
	 * Method testgetMergedDescription
	 * @test
	 * @dataProvider testgetMergedDescriptionProvidor
	 */
	function testgetMergedDescription($description, $id, $parent_type, $expected, $msg) {
		$this->assertEquals($expected, getMergedDescription($description, $id, $parent_type), $msg);
	}

	/**
	 * Method testgetReturnPathProvidor
	 * params
	 */
	function testgetReturnPathProvidor() {
		return array(
			array('tsolucio.com','','info@tsolucio.com','normal'),
			array('ispconfig.tsolucio.com','','info@tsolucio.com','superdomain'),
			array('isp.ispconfig.tsolucio.com','','info@tsolucio.com','super superdomain'),
			array('localhost','','','localhost'),
			array('192.168.0.190','','info@[192.168.0.190]','ip'),
			array('tsolucio.cloud','','info@tsolucio.cloud','tld idn'),
			array('tld','','info@tld','only one'),
			array('http://tld','','info@tld','http'),
			array('tld:port','','info@tld','port'),
			/////////////////
			array('tsolucio.com','noreply@tsolucio.com','info@tsolucio.com','normal from'),
			array('ispconfig.tsolucio.com','noreply@tsolucio.com','noreply@tsolucio.com','superdomain from'),
			array('isp.ispconfig.tsolucio.com','noreply@tsolucio.com','noreply@tsolucio.com','super superdomain from'),
			array('localhost','noreply@tsolucio.com','noreply@tsolucio.com','localhost from'),
			array('192.168.0.190','noreply@tsolucio.com','info@[192.168.0.190]','ip from'),
			array('tsolucio.cloud','noreply@tsolucio.com','info@tsolucio.cloud','tld idn from'),
			array('tld','noreply@tsolucio.com','info@tld','only one from'),
			array('http://tld','noreply@tsolucio.com','info@tld','http from'),
			array('tld:port','noreply@tsolucio.com','info@tld','port from'),
			/////////////////
			array('tsolucio.com','ggg@tld','info@tsolucio.com','normal from tld'),
			array('ispconfig.tsolucio.com','ggg@tld','info@tsolucio.com','superdomain from tld'),
			array('isp.ispconfig.tsolucio.com','ggg@tld','info@tsolucio.com','super superdomain tld'),
			array('localhost','ggg@tld','ggg@tld','localhost from tld'),
			array('192.168.0.190','ggg@tld','info@[192.168.0.190]','ip from tld'),
			array('tsolucio.cloud','ggg@tld','info@tsolucio.cloud','tld idn from tld'),
			array('tld','ggg@tld','info@tld','only one from tld'),
			array('http://tld','ggg@tld','info@tld','http from tld'),
			array('tld:port','ggg@tld','info@tld','port from tld'),
		);
	}

	/**
	 * Method testgetReturnPath
	 * @test
	 * @dataProvider testgetReturnPathProvidor
	 */
	function testgetReturnPath($host, $from_email, $expected, $msg) {
		$this->assertEquals($expected, getReturnPath($host, $from_email), $msg);
	}

	/**
	 * Method testgetrecurringObjValueProvidor
	 * params
	 */
	function testgetrecurringObjValueProvidor() {
		return array(
		array(null,null,null,null,null,null,
			null,null,null,null,null,null,null,null,null,
			null,null,null,null,'no data'),
		array('--None--',null,null,null,null,null,
			null,null,null,null,null,null,null,null,null,
			null,null,null,null,'no data --None--'),
		////////////////////
		array('Daily','2017-01-01','2017-01-10',null,'15:00','16:00',
			null,null,null,null,null,null,null,null,null,
			null,null,2,array('2017-01-01','2017-01-03','2017-01-05','2017-01-07','2017-01-09'),'every 2 days'),
		array('Daily','2017-01-01','2017-01-10',null,'15:00','16:00',
			null,null,null,null,null,null,null,null,null,
			null,null,3,array('2017-01-01','2017-01-04','2017-01-07','2017-01-10'),'every 3 days'),
		array('Yearly','2017-01-01','2021-01-10',null,'15:00','16:00',
			null,null,null,null,null,null,null,null,null,
			null,null,2,array('2017-01-01','2019-01-01','2021-01-01'),'every 2 years'),
		array('Yearly','2017-01-01','2021-01-10',null,'15:00','16:00',
			null,null,null,null,null,null,null,null,null,
			null,null,3,array('2017-01-01','2020-01-01'),'every 3 years'),
		////////////////////
		array('Daily','2017-01-01',null,'2017-01-10','15:00','16:00',
			null,null,null,null,null,null,null,null,null,
			null,null,2,array('2017-01-01','2017-01-03','2017-01-05','2017-01-07','2017-01-09'),'every 2 days'),
		array('Daily','2017-01-01',null,'2017-01-10','15:00','16:00',
			null,null,null,null,null,null,null,null,null,
			null,null,3,array('2017-01-01','2017-01-04','2017-01-07','2017-01-10'),'every 3 days'),
		array('Yearly','2017-01-01',null,'2021-01-10','15:00','16:00',
			null,null,null,null,null,null,null,null,null,
			null,null,2,array('2017-01-01','2019-01-01','2021-01-01'),'every 2 years'),
		array('Yearly','2017-01-01',null,'2021-01-10','15:00','16:00',
			null,null,null,null,null,null,null,null,null,
			null,null,3,array('2017-01-01','2020-01-01'),'every 3 years'),
		////////////////////
		array('Weekly','2017-01-01','2017-01-20',null,'15:00','16:00',
			null,1,null,1,null,1,null,null,null,
			null,null,1,array('2017-01-01','2017-01-02','2017-01-04','2017-01-06','2017-01-09','2017-01-11','2017-01-13'),'every M-X-V days'),
		array('Weekly','2017-01-01','2017-01-20',null,'15:00','16:00',
			null,1,null,1,null,1,null,null,null,
			null,null,2,array('2017-01-01','2017-01-09','2017-01-11','2017-01-13'),'every 2 weeks M-X-V days'),
		array('Weekly','2017-01-01','2017-01-20',null,'15:00','16:00',
			null,1,null,1,null,1,null,null,null,
			null,null,3,array('2017-01-01'),'every 3 weeks M-X-V days'),
		array('Weekly','2017-01-01','2017-01-30',null,'15:00','16:00',
			null,1,null,1,null,1,null,null,null,
			null,null,3,array('2017-01-01','2017-01-16','2017-01-18','2017-01-20'),'every 3 weeks M-X-V days'),
		////////////////////
		array('Monthly','2017-01-01','2017-04-20',null,'15:00','16:00',
			null,null,null,null,null,null,null,'date',null,
			null,null,1,array('2017-01-01','2017-02-01','2017-03-01','2017-04-01'),'once a month'),
		array('Monthly','2017-01-01','2017-04-20',null,'15:00','16:00',
			null,null,null,null,null,null,null,'date',null,
			null,null,2,array('2017-01-01','2017-03-01'),'once every two months'),
		array('Monthly','2017-01-01','2017-04-20',null,'15:00','16:00',
			null,null,null,null,null,null,null,'date',4,
			null,null,1,array('2017-01-01','2017-01-04','2017-02-04','2017-03-04','2017-04-04'),'once a month on the fourth'),
		array('Monthly','2017-01-01','2017-04-20',null,'15:00','16:00',
			null,null,null,null,null,null,null,'date',4,
			null,null,2,array('2017-01-01','2017-01-04','2017-03-04'),'once every two months on the fourth'),
		////////////////////
		array('Monthly','2017-01-01','2017-04-20',null,'15:00','16:00',
			null,null,null,null,null,null,null,'day',null,
			'second',3,1,array('2017-01-01','2017-01-11','2017-02-08','2017-03-08','2017-04-12'),'second X month'),
		array('Monthly','2017-01-01','2017-04-20',null,'15:00','16:00',
			null,null,null,null,null,null,null,'day',null,
			'second',3,2,array('2017-01-01','2017-01-11','2017-03-08'),'second X every two months'),
		array('Monthly','2017-01-01','2017-04-20',null,'15:00','16:00',
			null,null,null,null,null,null,null,'day',null,
			'second',2,1,array('2017-01-01','2017-01-10','2017-02-14','2017-03-14','2017-04-11'),'second T once a month'),
		array('Monthly','2017-01-01','2017-04-20',null,'15:00','16:00',
			null,null,null,null,null,null,null,'day',null,
			'second',2,2,array('2017-01-01','2017-01-10','2017-03-14'),'second X once every two months'),
		);
	}

	/**
	 * Method testgetrecurringObjValue
	 * @test
	 * @dataProvider testgetrecurringObjValueProvidor
	 */
	function testgetrecurringObjValue($recurringtype,$date_start,$calendar_repeat_limit_date,$due_date,$time_start,$time_end,
			$sun_flag,$mon_flag,$tue_flag,$wed_flag,$thu_flag,$fri_flag,$sat_flag,$repeatMonth,$repeatMonth_date,
			$repeatmonth_daytype,$repeatMonth_day,$repeat_frequency,$expected,$msg) {
		$_REQUEST['recurringtype'] = $recurringtype;
		$_REQUEST['date_start'] = $date_start;
		$_REQUEST['calendar_repeat_limit_date'] = $calendar_repeat_limit_date;
		$_REQUEST['due_date'] = $due_date;
		$_REQUEST['time_start'] = $time_start;
		$_REQUEST['time_end'] = $time_end;
		$_REQUEST['sun_flag'] = $sun_flag;
		$_REQUEST['mon_flag'] = $mon_flag;
		$_REQUEST['tue_flag'] = $tue_flag;
		$_REQUEST['wed_flag'] = $wed_flag;
		$_REQUEST['thu_flag'] = $thu_flag;
		$_REQUEST['fri_flag'] = $fri_flag;
		$_REQUEST['sat_flag'] = $sat_flag;
		$_REQUEST['repeatMonth'] = $repeatMonth;
		$_REQUEST['repeatMonth_date'] = $repeatMonth_date;
		$_REQUEST['repeatMonth_daytype'] = $repeatmonth_daytype;
		$_REQUEST['repeatMonth_day'] = $repeatMonth_day;
		$_REQUEST['repeat_frequency'] = $repeat_frequency;
		$actual = getrecurringObjValue();
		if (!is_null($expected)) {
			$this->assertEquals($expected, $actual->recurringdates, $msg);
		} else {
			$this->assertEquals($expected, $actual, $msg);
		}
	}

	/**
	 * Method testgetSalesEntityType
	 * @test
	 */
	function testgetSalesEntityType() {
		$this->assertEquals('Accounts', getSalesEntityType('74'), 'Accounts setype');
		$this->assertEquals('CobroPago', getSalesEntityType('14335'), 'Payment setype');
		$this->assertEquals('Contacts', getSalesEntityType('1090'), 'Contacts setype');
	}

	/**
	 * Method testUserCount
	 * @test
	 */
	function testUserCount() {
		$expected = array(
			'user' => 10,
			'admin' => 1,
			'nonadmin' => 9,
		);
		$this->assertEquals($expected, UserCount(), 'User count');
	}

	/**
	 * Method testpicklistHasDependency
	 * @test
	 */
	function testpicklistHasDependency() {
		$this->assertTrue(picklistHasDependency('cf_729', 'Accounts'), 'picklist dependency on Accounts CF');
		$this->assertFalse(picklistHasDependency('industry', 'Accounts'), 'picklist dependency on Accounts industry');
	}
}
