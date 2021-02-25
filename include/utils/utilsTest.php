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

class testutils extends TestCase {

	/**
	 * Method to_htmlProvider
	 * params
	 */
	public function to_htmlProvider() {
		return array(
			array('Normal string',false,'Normal string','normal string'),
			array('Numbers 012-345,678.9',false,'Numbers 012-345,678.9','Numbers 012-345,678.9'),
			array('Special character string áçèñtös ÑÇ',false,'Special character string &aacute;&ccedil;&egrave;&ntilde;t&ouml;s &Ntilde;&Ccedil;','Special character string with áçèñtös'),
			array('!"·$%&/();,:.=?¿*_-|@#€',false,'!&quot;&middot;$%&amp;/();,:.=?&iquest;*_-|@#&euro;','special string with symbols'),
			array('Greater > Lesser < ',false,'Greater &gt; Lesser &lt; ','Greater > Lesser <(space)'),
			array('Greater > Lesser <',false,'Greater &gt; Lesser &lt;','Greater > Lesser <'),
			array('> Greater > Lesser < ',false,'&gt; Greater &gt; Lesser &lt; ','> Greater Lesser <(space)'),
			array('"\'',false,'&quot;&#039;','special string with quotes'),
			array('<b>Bold HTML</b>',false,'&lt;b&gt;Bold HTML&lt;/b&gt;','Bold HTML'),
			array('<td width="25%" align="right" class="dvtCellLabel"><input type="hidden" value="1" id="hdtxt_IsAdmin">Modified Time</td>',false,'&lt;td width=&quot;25%&quot; align=&quot;right&quot; class=&quot;dvtCellLabel&quot;&gt;&lt;input type=&quot;hidden&quot; value=&quot;1&quot; id=&quot;hdtxt_IsAdmin&quot;&gt;Modified Time&lt;/td&gt;','HTML table cell'),
			array('&amp;&aacute;&lt;&gt;&ntilde;',false,'&amp;amp;&amp;aacute;&amp;lt;&amp;gt;&amp;ntilde;','HTML Codes'),

			array('Normal string (T)',true,'Normal string (T)','normal string (true)'),
			array('Numbers 012-345,678.9 (T)',true,'Numbers 012-345,678.9 (T)','Numbers 012-345,678.9 (true)'),
			array('Special character string áçèñtös ÑÇ (T)',true,'Special character string &aacute;&ccedil;&egrave;&ntilde;t&ouml;s &Ntilde;&Ccedil; (T)','Special character string with áçèñtös (true)'),
			array('!"·$%&/();,:.=?¿*_-|@#€ (T)',true,'!&quot;&middot;$%&amp;/();,:.=?&iquest;*_-|@#&euro; (T)','special string with symbols (true)'),
			array('Greater > Lesser (T) < ',true,'Greater &gt; Lesser (T) &lt; ','Greater > Lesser <(space) (true)'),
			array('Greater > Lesser (T) <',true,'Greater &gt; Lesser (T) &lt;','Greater > Lesser < (true)'),
			array('> Greater > Lesser (T) < ',true,'&gt; Greater &gt; Lesser (T) &lt; ','> Greater Lesser <(space) (true)'),
			array('"\' (T)',true,'&quot;&#039; (T)','special string with quotes (true)'),
			array('<b>Bold HTML (T)</b>',true,'&lt;b&gt;Bold HTML (T)&lt;/b&gt;','Bold HTML (true)'),
			array('<td width="25%" align="right" class="dvtCellLabel"><input type="hidden" value="1" id="hdtxt_IsAdmin">Modified Time</td> (T)',true,'&lt;td width=&quot;25%&quot; align=&quot;right&quot; class=&quot;dvtCellLabel&quot;&gt;&lt;input type=&quot;hidden&quot; value=&quot;1&quot; id=&quot;hdtxt_IsAdmin&quot;&gt;Modified Time&lt;/td&gt; (T)','HTML table cell (true)'),
			array('&amp;&aacute;&lt;&gt;&ntilde; (T)',true,'&amp;amp;&amp;aacute;&amp;lt;&amp;gt;&amp;ntilde; (T)','HTML Codes (true)'),
		);
	}

	/**
	 * Method testto_html
	 * @test
	 * @dataProvider to_htmlProvider
	 */
	public function testto_html($input, $ignore, $expected, $message) {
		$actual = to_html($input, $ignore);
		$this->assertEquals($expected, $actual, "testto_html $message");
	}

	/**
	 * Method vtws_getEntityIdProvider
	 * params
	 */
	public function vtws_getEntityIdProvider() {
		return array(
			array('Contacts', '12', 'WS ID Contact'),
			array('Accounts', '11', 'WS ID Account'),
			array('Assets', '29', 'WS ID Assets'),
			array('DoesNotExist', '0', 'WS ID DoesNotExist'),
			array('', '0', 'WS ID empty'),
		);
	}

	/**
	 * Method testvtws_getEntityId
	 * @test
	 * @dataProvider vtws_getEntityIdProvider
	 */
	public function testvtws_getEntityId($module, $expected, $message) {
		$this->assertEquals($expected, vtws_getEntityId($module), "vtws_getEntityId $message");
	}

	/**
	 * Method testisRecordExists
	 * @test
	 */
	public function testisRecordExists() {
		global $adb;
		$accountWS = vtws_getEntityId('Accounts');
		$userWS = vtws_getEntityId('Users');
		// Not Deleted
		$actual = isRecordExists(80);
		$this->assertEquals(true, $actual, "testisRecordExists not deleted CRM record");
		$actual = isRecordExists(5);
		$this->assertEquals(true, $actual, "testisRecordExists not deleted User record");
		$actual = isRecordExists($accountWS.'x80');
		$this->assertEquals(true, $actual, "testisRecordExists deleted CRM record Webservice");
		$actual = isRecordExists($userWS.'x5');
		$this->assertEquals(true, $actual, "testisRecordExists deleted User record Webservice");
		// Deleted Records
		$adb->query('update vtiger_crmentity set deleted=1 where crmid=80');
		$adb->query('update vtiger_crmobject set deleted=1 where crmid=80');
		$adb->query('update vtiger_users set deleted=1 where id=5');
		$actual = isRecordExists(80);
		$this->assertEquals(false, $actual, "testisRecordExists deleted CRM record");
		$actual = isRecordExists(5);
		// THIS ONE IS WRONG BECAUSE WE CANNOT DISTINGUISH A USER FROM A NORMAL CRM RECORD SO WE FIND cbupdater 5 and return true
		$this->assertEquals(true, $actual, "testisRecordExists deleted User record");
		$actual = isRecordExists(1);
		// THIS ONE IS WRONG, IT RETURNS FALSE BECAUSE THERE IS NO RECORD 1 but there is a user 1
		$this->assertEquals(false, $actual, "testisRecordExists deleted User record");
		$actual = isRecordExists($accountWS.'x80');
		$this->assertEquals(false, $actual, "testisRecordExists deleted CRM record Webservice");
		$adb->query('update vtiger_users set deleted=1 where crmid=5');
		$actual = isRecordExists($userWS.'x5');
		$this->assertEquals(false, $actual, "testisRecordExists deleted User record Webservice");
		// restore DB
		$adb->query('update vtiger_crmentity set deleted=0 where crmid=80');
		$adb->query('update vtiger_crmobject set deleted=0 where crmid=80');
		$adb->query('update vtiger_users set deleted=0 where id=5');
	}

	/**
	 * Method html2utf8Provider
	 * params
	 */
	public function html2utf8Provider() {
		return array(
			array('Normal string','Normal string','normal string'),
			array('Numbers 012-345,678.9','Numbers 012-345,678.9','Numbers 012-345,678.9'),
			array('Special character string áçèñtös ÑÇ','Special character string áçèñtös ÑÇ','Special character string with áçèñtös'),
			array('!"·$%&/();,:.=?¿*_-|@#€','!"·$%&/();,:.=?¿*_-|@#€','special string with symbols'),
			array('Greater > Lesser < ','Greater > Lesser < ','Greater > Lesser <(space)'),
			array('Greater > Lesser <','Greater > Lesser <','Greater > Lesser <'),
			array('&quot;&#039;','&quot;&#039;','special string with quotes'),
			array('<p>I will display &spades;</p>','<p>I will display &spades;</p>','<p>I will display &spades;</p>'),
			array('<p>I will display &#9824;</p>','<p>I will display ♠</p>','<p>I will display &#9824;</p>'),
			array('<p>I will display &#x2660;</p>','<p>I will display &#x2660;</p>','<p>I will display &#x2660;</p>'),
		);
	}

	/**
	 * Method testhtml_to_utf8
	 * @test
	 * @dataProvider html2utf8Provider
	 */
	public function testhtml_to_utf8($data, $expected, $message) {
		$actual = html_to_utf8($data);
		$this->assertEquals($expected, $actual, "testhtml_to_utf8 $message");
	}

	/**
	 * Method getValidDBInsertDateValueProvider
	 * params
	 */
	public function getValidDBInsertDateValueProvider() {
		return array(
			array(7,'2016-06-01','2016-06-01','Fdom testymd'),
			array(7,'2016-06-15','2016-06-15','Mdom testymd'),
			array(7,'2016-06-30','2016-06-30','Ldom testymd'),
			array(5,'01-06-2016','2016-06-01','Fdom testdmy'),
			array(5,'15-06-2016','2016-06-15','Mdom testdmy'),
			array(5,'30-06-2016','2016-06-30','Ldom testdmy'),
			array(6,'06-01-2016','2016-06-01','Fdom testmdy'),
			array(6,'06-15-2016','2016-06-15','Mdom testmdy'),
			array(6,'06-30-2016','2016-06-30','Ldom testmdy'),
			array(7,'1997-03-04','1997-03-04','F1997-03-04 testymd'),
			array(5,'04-03-1997','1997-03-04','F04-03-1997 testdmy'),
			array(6,'03-04-1997','1997-03-04','F03-04-1997 testmdy'),
			///////////////////
			array(7,'2016.06.01','2016-06-01','Fdom testymd'),
			array(7,'2016.06.15','2016-06-15','Mdom testymd'),
			array(7,'2016.06.30','2016-06-30','Ldom testymd'),
			array(5,'01.06.2016','2016-06-01','Fdom testdmy'),
			array(5,'15.06.2016','2016-06-15','Mdom testdmy'),
			array(5,'30.06.2016','2016-06-30','Ldom testdmy'),
			array(6,'06.01.2016','2016-06-01','Fdom testmdy'),
			array(6,'06.15.2016','2016-06-15','Mdom testmdy'),
			array(6,'06.30.2016','2016-06-30','Ldom testmdy'),
			array(7,'2016/06/01','2016-06-01','Fdom testymd'),
			array(7,'2016/06/15','2016-06-15','Mdom testymd'),
			array(7,'2016/06/30','2016-06-30','Ldom testymd'),
			array(5,'01/06/2016','2016-06-01','Fdom testdmy'),
			array(5,'15/06/2016','2016-06-15','Mdom testdmy'),
			array(5,'30/06/2016','2016-06-30','Ldom testdmy'),
			array(6,'06/01/2016','2016-06-01','Fdom testmdy'),
			array(6,'06/15/2016','2016-06-15','Mdom testmdy'),
			array(6,'06/30/2016','2016-06-30','Ldom testmdy'),
			array(7,'2016/06/1','2016-06-01','Fdom testymd'),
			array(7,'2016/6/15','2016-06-15','Mdom testymd'),
			array(5,'1/06/2016','2016-06-01','Fdom testdmy'),
			array(5,'15/6/2016','2016-06-15','Mdom testdmy'),
			array(6,'06/1/2016','2016-06-01','Fdom testmdy'),
			array(6,'6/15/2016','2016-06-15','Mdom testmdy'),
			///////////////////
			array(7,'','','empty in empty out'),
			array(7,'$','','$ in empty out'),
			array(7,'20160601','','junk in empty out'),
			array(7,'2016-0601','','junk in empty out'),
			array(7,'20160.601','','junk in empty out'),
			array(7,'201ç60601','','junk in empty out'),
		);
	}

	/**
	 * Method testgetValidDBInsertDateValue
	 * @test
	 * @dataProvider getValidDBInsertDateValueProvider
	 */
	public function testgetValidDBInsertDateValue($user, $data, $expected, $message) {
		global $current_user;
		$holduser = $current_user;
		$dtuser = new Users();
		$dtuser->retrieveCurrentUserInfoFromFile($user);
		$current_user = $dtuser;
		$actual = getValidDBInsertDateValue($data);
		$this->assertEquals($expected, $actual, "getValidDBInsertDateValue $message");
		$current_user = $holduser;
	}

	/**
	 * Method testgetValidDBInsertDateTimeValue
	 * @test
	 */
	public function testgetValidDBInsertDateTimeValue() {
		// getValidDBInsertDateTimeValue is tested with the testgetValidDBInsertDateValue and DateTimeField class tests
		$this->assertTrue(true);
	}

	/**
	 * Method testgetMailFields
	 * @test
	 */
	public function testgetMailFields() {
		$emailfields = array(
			'tablename' => 'vtiger_account',
			'fieldname' => 'email1',
			'fieldlabel' => 'Email',
		);
		$this->assertEquals($emailfields, getMailFields(getTabid('Accounts')), 'Account Email Field');
		$emailfields = array(
			'tablename' => 'vtiger_contactdetails',
			'fieldname' => 'email',
			'fieldlabel' => 'Email',
		);
		$this->assertEquals($emailfields, getMailFields(getTabid('Contacts')), 'Contact Email Field');
		$emailfields = array(
			'tablename' => 'vtiger_users',
			'fieldname' => 'email1',
			'fieldlabel' => 'Email',
		);
		$this->assertEquals($emailfields, getMailFields(getTabid('Users')), 'Users Email Field');
		$this->assertEquals(array(), getMailFields(getTabid('Assets')), 'Assets Email Fields');
	}

	/**
	 * Method getEmailFieldIdProvider
	 * params
	 */
	public function getEmailFieldIdProvider() {
		return array(
			array('11x74', 9),
			array('12x1084', 80),
			array('19x5', 482),
			array('13x5161', 676),
			array('33x6377', 674),
			array('17x2642', 677),
			array('11x10074', 9), // should fail but since it only looks for module, it find one
			array('29x4062', ''), // no email on this module
			//array('290000x4062', ''), // inexistent module > throws exception, tested in testgetEmailFieldIdExceptionNoModule
		);
	}

	/**
	 * Method testgetEmailFieldId
	 * @test
	 * @dataProvider getEmailFieldIdProvider
	 */
	public function testgetEmailFieldId($crmid, $expected) {
		global $current_user;
		$referenceHandler = vtws_getModuleHandlerFromId($crmid, $current_user);
		$referenceMeta = $referenceHandler->getMeta();
		$this->assertEquals($expected, getEmailFieldId($referenceMeta, $crmid), 'getEmailFieldId');
	}

	/**
	 * Method testgetEmailFieldIdExceptionNoModule
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testgetEmailFieldIdExceptionNoModule() {
		global $current_user;
		$referenceHandler = vtws_getModuleHandlerFromId('290000x4062', $current_user);
		$referenceHandler->getMeta();
	}

	/**
	 * Method testgetModuleForField
	 * @test
	 */
	public function testgetModuleForField() {
		$this->assertEquals('cbCalendar', getModuleForField(810), 'Calendar Field');
		$this->assertEquals('Contacts', getModuleForField(100), 'Contact Field');
		$this->assertEquals('Accounts', getModuleForField(9), 'Account Field');
		$this->assertEquals('Users', getModuleForField(482), 'Users Email Field');
		$this->assertEquals('Users', getModuleForField(-1), 'Users Email Address specification');
	}

	/**
	 * Method testgetCurrentModule
	 * @test
	 */
	public function testgetCurrentModule() {
		global $currentModule;
		$this->assertEquals($currentModule, getCurrentModule(), 'getCurrentModule default');
		$holdcurrentModule = $currentModule;
		$currentModule = '';
		$_REQUEST['module'] = 'doesnotexist';
		$this->assertNull(getCurrentModule(), 'getCurrentModule not exist');
		$_REQUEST['module'] = '../../Accounts';
		$this->assertNull(getCurrentModule(), 'getCurrentModule incorrect');
		$_REQUEST['module'] = 'Accounts';
		$this->assertEquals('Accounts', getCurrentModule(), 'getCurrentModule Accounts no set');
		$this->assertEmpty($currentModule, 'getCurrentModule accounts currentmodule not set');
		$this->assertEquals('Accounts', getCurrentModule(true), 'getCurrentModule Accounts set');
		$this->assertEquals('Accounts', $currentModule, 'getCurrentModule accounts currentmodule set');
		$currentModule = $holdcurrentModule;
	}

	/**
	 * Method testget_themes
	 * @test
	 */
	public function testget_themes() {
		$expected = array(
			'alphagrey' => 'alphagrey',
			'bluelagoon' => 'bluelagoon',
			'softed' => 'softed',
			'woodspice' => 'woodspice',
		);
		$this->assertEquals($expected, get_themes(), 'get_themes');
	}

	/**
	 * Method testisValueInPicklist
	 * @test
	 */
	public function testisValueInPicklist() {
		$this->assertTrue(isValueInPicklist('Banking', 'industry'), 'isValueInPicklist 1');
		$this->assertTrue(isValueInPicklist('In Service', 'assetstatus'), 'isValueInPicklist 1');
		$this->assertFalse(isValueInPicklist('NOTINBanking', 'industry'), 'isValueInPicklist 1');
		$this->assertFalse(isValueInPicklist('NOTInService', 'assetstatus'), 'isValueInPicklist 1');
	}

	/**
	 * Method getDuplicateQueryProvider
	 * params
	 */
	public function getDuplicateQueryProvider() {
		return array(
		array(
			1,
			'cbtranslation',
			'vtiger_cbtranslation.i18n.i18n,vtiger_cbtranslation.locale.locale',
			array('i18n'=> '19', 'locale'=> '32'),
			"SELECT vtiger_cbtranslation.cbtranslationid AS recordid, vtiger_users_last_import.deleted,vtiger_cbtranslation.i18n,vtiger_cbtranslation.locale FROM vtiger_cbtranslation INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_cbtranslation.cbtranslationid INNER JOIN vtiger_cbtranslationcf ON vtiger_cbtranslationcf.cbtranslationid=vtiger_cbtranslation.cbtranslationid INNER JOIN tempcbtranslation1 temptab ON temptab.id=vtiger_cbtranslation.cbtranslationid LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups ON vtiger_groups.groupid=vtiger_crmentity.smownerid LEFT JOIN vtiger_users_last_import ON vtiger_users_last_import.bean_id=vtiger_cbtranslation.cbtranslationid INNER JOIN (SELECT vtiger_cbtranslation.i18n,vtiger_cbtranslation.locale  FROM vtiger_cbtranslation INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_cbtranslation.cbtranslationid INNER JOIN vtiger_cbtranslationcf ON vtiger_cbtranslationcf.cbtranslationid=vtiger_cbtranslation.cbtranslationid INNER JOIN tempcbtranslation12 temptab2 ON temptab2.id=vtiger_cbtranslation.cbtranslationid LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups ON vtiger_groups.groupid=vtiger_crmentity.smownerid  WHERE vtiger_crmentity.deleted = 0 GROUP BY vtiger_cbtranslation.i18n,vtiger_cbtranslation.locale HAVING COUNT(*)>1) AS temp ON  ifnull(vtiger_cbtranslation.i18n,'null') = ifnull(temp.i18n,'null') and  ifnull(vtiger_cbtranslation.locale,'null') = ifnull(temp.locale,'null') WHERE vtiger_crmentity.deleted = 0 ORDER BY vtiger_cbtranslation.i18n,vtiger_cbtranslation.locale,vtiger_cbtranslation.cbtranslationid ASC",
		),
		array(
			1,
			'Assets',
			'vtiger_assets.product.product,vtiger_assets.serialnumber.serialnumber',
			array('product'=> '10', 'serialnumber'=> '1'),
			"SELECT vtiger_assets.assetsid AS recordid, vtiger_users_last_import.deleted,vtiger_assets.product,vtiger_assets.serialnumber FROM vtiger_assets INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_assets.assetsid INNER JOIN vtiger_assetscf ON vtiger_assetscf.assetsid=vtiger_assets.assetsid INNER JOIN tempassets1 temptab ON temptab.id=vtiger_assets.assetsid LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups ON vtiger_groups.groupid=vtiger_crmentity.smownerid LEFT JOIN vtiger_users_last_import ON vtiger_users_last_import.bean_id=vtiger_assets.assetsid INNER JOIN (SELECT vtiger_assets.product,vtiger_assets.serialnumber  FROM vtiger_assets INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_assets.assetsid INNER JOIN vtiger_assetscf ON vtiger_assetscf.assetsid=vtiger_assets.assetsid INNER JOIN tempassets12 temptab2 ON temptab2.id=vtiger_assets.assetsid LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups ON vtiger_groups.groupid=vtiger_crmentity.smownerid  WHERE vtiger_crmentity.deleted = 0 GROUP BY vtiger_assets.product,vtiger_assets.serialnumber HAVING COUNT(*)>1) AS temp ON  ifnull(vtiger_assets.product,'null') = ifnull(temp.product,'null') and  ifnull(vtiger_assets.serialnumber,'null') = ifnull(temp.serialnumber,'null') WHERE vtiger_crmentity.deleted = 0 ORDER BY vtiger_assets.product,vtiger_assets.serialnumber,vtiger_assets.assetsid ASC",
		),
		array(
			1,
			'Contacts',
			'vtiger_contactdetails.firstname.firstname,vtiger_contactsubdetails.email2.email2',
			array('firstname'=> '1', 'email2'=> '13'),
			"SELECT vtiger_contactdetails.contactid AS recordid, vtiger_users_last_import.deleted,vtiger_contactdetails.firstname,vtiger_contactsubdetails.email2 FROM vtiger_contactdetails INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_contactdetails.contactid INNER JOIN vtiger_contactscf ON vtiger_contactscf.contactid=vtiger_contactdetails.contactid INNER JOIN tempcontacts1 temptab ON temptab.id=vtiger_contactdetails.contactid LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups ON vtiger_groups.groupid=vtiger_crmentity.smownerid LEFT JOIN vtiger_users_last_import ON vtiger_users_last_import.bean_id=vtiger_contactdetails.contactid INNER JOIN (SELECT vtiger_contactdetails.firstname,vtiger_contactsubdetails.email2  FROM vtiger_contactdetails INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_contactdetails.contactid INNER JOIN vtiger_contactscf ON vtiger_contactscf.contactid=vtiger_contactdetails.contactid INNER JOIN tempcontacts12 temptab2 ON temptab2.id=vtiger_contactdetails.contactid LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups ON vtiger_groups.groupid=vtiger_crmentity.smownerid  WHERE vtiger_crmentity.deleted = 0 GROUP BY vtiger_contactdetails.firstname,vtiger_contactsubdetails.email2 HAVING COUNT(*)>1) AS temp ON  ifnull(vtiger_contactdetails.firstname,'null') = ifnull(temp.firstname,'null') and  ifnull(vtiger_contactsubdetails.email2,'null') = ifnull(temp.email2,'null') WHERE vtiger_crmentity.deleted = 0 ORDER BY vtiger_contactdetails.firstname,vtiger_contactsubdetails.email2,vtiger_contactdetails.contactid ASC",
		),
		array(
			1,
			'Potentials',
			'vtiger_potentials.amount.amount,vtiger_potentials.forecast.forecast',
			array('amount'=> '71', 'forecast'=> '9'),
			"SELECT vtiger_potential.potentialid AS recordid, vtiger_users_last_import.deleted,vtiger_potentials.amount,vtiger_potentials.forecast FROM vtiger_potential INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_potential.potentialid INNER JOIN vtiger_potentialscf ON vtiger_potentialscf.potentialid=vtiger_potential.potentialid INNER JOIN temppotentials1 temptab ON temptab.id=vtiger_potential.potentialid LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups ON vtiger_groups.groupid=vtiger_crmentity.smownerid LEFT JOIN vtiger_users_last_import ON vtiger_users_last_import.bean_id=vtiger_potential.potentialid INNER JOIN (SELECT vtiger_potentials.amount,vtiger_potentials.forecast  FROM vtiger_potential INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_potential.potentialid INNER JOIN vtiger_potentialscf ON vtiger_potentialscf.potentialid=vtiger_potential.potentialid INNER JOIN temppotentials12 temptab2 ON temptab2.id=vtiger_potential.potentialid LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups ON vtiger_groups.groupid=vtiger_crmentity.smownerid  WHERE vtiger_crmentity.deleted = 0 GROUP BY vtiger_potentials.amount,vtiger_potentials.forecast HAVING COUNT(*)>1) AS temp ON  ifnull(vtiger_potentials.amount,'null') = ifnull(temp.amount,'null') and  ifnull(vtiger_potentials.forecast,'null') = ifnull(temp.forecast,'null') WHERE vtiger_crmentity.deleted = 0 ORDER BY vtiger_potentials.amount,vtiger_potentials.forecast,vtiger_potential.potentialid ASC",
		),
		array(
			1,
			'Accounts',
			'vtiger_account.industry.industry,vtiger_account.phone.phone',
			array('industry'=> '15', 'phone'=> '11'),
			"SELECT vtiger_account.accountid AS recordid, vtiger_users_last_import.deleted,vtiger_account.industry,vtiger_account.phone FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_account.accountid INNER JOIN vtiger_accountscf ON vtiger_accountscf.accountid=vtiger_account.accountid INNER JOIN tempaccounts1 temptab ON temptab.id=vtiger_account.accountid LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups ON vtiger_groups.groupid=vtiger_crmentity.smownerid LEFT JOIN vtiger_users_last_import ON vtiger_users_last_import.bean_id=vtiger_account.accountid INNER JOIN (SELECT vtiger_account.industry,vtiger_account.phone  FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_account.accountid INNER JOIN vtiger_accountscf ON vtiger_accountscf.accountid=vtiger_account.accountid INNER JOIN tempaccounts12 temptab2 ON temptab2.id=vtiger_account.accountid LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups ON vtiger_groups.groupid=vtiger_crmentity.smownerid  WHERE vtiger_crmentity.deleted = 0 GROUP BY vtiger_account.industry,vtiger_account.phone HAVING COUNT(*)>1) AS temp ON  ifnull(vtiger_account.industry,'null') = ifnull(temp.industry,'null') and  ifnull(vtiger_account.phone,'null') = ifnull(temp.phone,'null') WHERE vtiger_crmentity.deleted = 0 ORDER BY vtiger_account.industry,vtiger_account.phone,vtiger_account.accountid ASC",
		),
		///////////////////////////////
		array(
			12,
			'cbtranslation',
			'vtiger_cbtranslation.i18n.i18n,vtiger_cbtranslation.locale.locale',
			array('i18n'=> '19', 'locale'=> '32'),
			"SELECT vtiger_cbtranslation.cbtranslationid AS recordid, vtiger_users_last_import.deleted,vtiger_cbtranslation.i18n,vtiger_cbtranslation.locale FROM vtiger_cbtranslation INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_cbtranslation.cbtranslationid INNER JOIN vtiger_cbtranslationcf ON vtiger_cbtranslationcf.cbtranslationid=vtiger_cbtranslation.cbtranslationid INNER JOIN tempcbtranslation12 temptab ON temptab.id=vtiger_cbtranslation.cbtranslationid LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups ON vtiger_groups.groupid=vtiger_crmentity.smownerid LEFT JOIN vtiger_users_last_import ON vtiger_users_last_import.bean_id=vtiger_cbtranslation.cbtranslationid INNER JOIN (SELECT vtiger_cbtranslation.i18n,vtiger_cbtranslation.locale  FROM vtiger_cbtranslation INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_cbtranslation.cbtranslationid INNER JOIN vtiger_cbtranslationcf ON vtiger_cbtranslationcf.cbtranslationid=vtiger_cbtranslation.cbtranslationid INNER JOIN tempcbtranslation122 temptab2 ON temptab2.id=vtiger_cbtranslation.cbtranslationid LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups ON vtiger_groups.groupid=vtiger_crmentity.smownerid  WHERE vtiger_crmentity.deleted = 0 and (vtiger_crmentity.smownerid=12 or vtiger_crmentity.smownerid in (select vtiger_user2role.userid
					from vtiger_user2role
					inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid
					where vtiger_role.parentrole like 'H1::H2::H3::%') or vtiger_crmentity.smownerid in (select shareduserid
					from vtiger_tmp_read_user_sharing_per where userid=12 and tabid=64) or ( vtiger_groups.groupid in (4,3) or  vtiger_groups.groupid in (select vtiger_tmp_read_group_sharing_per.sharedgroupid
				from vtiger_tmp_read_group_sharing_per
				where userid=12 and tabid=64))) GROUP BY vtiger_cbtranslation.i18n,vtiger_cbtranslation.locale HAVING COUNT(*)>1) AS temp ON  ifnull(vtiger_cbtranslation.i18n,'null') = ifnull(temp.i18n,'null') and  ifnull(vtiger_cbtranslation.locale,'null') = ifnull(temp.locale,'null') WHERE vtiger_crmentity.deleted = 0 and (vtiger_crmentity.smownerid=12 or vtiger_crmentity.smownerid in (select vtiger_user2role.userid
					from vtiger_user2role
					inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid
					where vtiger_role.parentrole like 'H1::H2::H3::%') or vtiger_crmentity.smownerid in (select shareduserid
					from vtiger_tmp_read_user_sharing_per where userid=12 and tabid=64) or ( vtiger_groups.groupid in (4,3) or  vtiger_groups.groupid in (select vtiger_tmp_read_group_sharing_per.sharedgroupid
				from vtiger_tmp_read_group_sharing_per
				where userid=12 and tabid=64))) ORDER BY vtiger_cbtranslation.i18n,vtiger_cbtranslation.locale,vtiger_cbtranslation.cbtranslationid ASC",
		),
		array(
			12,
			'Assets',
			'vtiger_assets.product.product,vtiger_assets.serialnumber.serialnumber',
			array('product'=> '10', 'serialnumber'=> '1'),
			"SELECT vtiger_assets.assetsid AS recordid, vtiger_users_last_import.deleted,vtiger_assets.product,vtiger_assets.serialnumber FROM vtiger_assets INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_assets.assetsid INNER JOIN vtiger_assetscf ON vtiger_assetscf.assetsid=vtiger_assets.assetsid INNER JOIN tempassets12 temptab ON temptab.id=vtiger_assets.assetsid LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups ON vtiger_groups.groupid=vtiger_crmentity.smownerid LEFT JOIN vtiger_users_last_import ON vtiger_users_last_import.bean_id=vtiger_assets.assetsid INNER JOIN (SELECT vtiger_assets.product,vtiger_assets.serialnumber  FROM vtiger_assets INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_assets.assetsid INNER JOIN vtiger_assetscf ON vtiger_assetscf.assetsid=vtiger_assets.assetsid INNER JOIN tempassets122 temptab2 ON temptab2.id=vtiger_assets.assetsid LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups ON vtiger_groups.groupid=vtiger_crmentity.smownerid  WHERE vtiger_crmentity.deleted = 0 GROUP BY vtiger_assets.product,vtiger_assets.serialnumber HAVING COUNT(*)>1) AS temp ON  ifnull(vtiger_assets.product,'null') = ifnull(temp.product,'null') and  ifnull(vtiger_assets.serialnumber,'null') = ifnull(temp.serialnumber,'null') WHERE vtiger_crmentity.deleted = 0 ORDER BY vtiger_assets.product,vtiger_assets.serialnumber,vtiger_assets.assetsid ASC",
		),
		array(
			12,
			'Contacts',
			'vtiger_contactdetails.firstname.firstname,vtiger_contactsubdetails.email2.email2',
			array('firstname'=> '1', 'email2'=> '13'),
			"SELECT vtiger_contactdetails.contactid AS recordid, vtiger_users_last_import.deleted,vtiger_contactdetails.firstname,vtiger_contactsubdetails.email2 FROM vtiger_contactdetails INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_contactdetails.contactid INNER JOIN vtiger_contactscf ON vtiger_contactscf.contactid=vtiger_contactdetails.contactid INNER JOIN tempcontacts12 temptab ON temptab.id=vtiger_contactdetails.contactid LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups ON vtiger_groups.groupid=vtiger_crmentity.smownerid LEFT JOIN vtiger_users_last_import ON vtiger_users_last_import.bean_id=vtiger_contactdetails.contactid INNER JOIN (SELECT vtiger_contactdetails.firstname,vtiger_contactsubdetails.email2  FROM vtiger_contactdetails INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_contactdetails.contactid INNER JOIN vtiger_contactscf ON vtiger_contactscf.contactid=vtiger_contactdetails.contactid INNER JOIN tempcontacts122 temptab2 ON temptab2.id=vtiger_contactdetails.contactid LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups ON vtiger_groups.groupid=vtiger_crmentity.smownerid  WHERE vtiger_crmentity.deleted = 0 GROUP BY vtiger_contactdetails.firstname,vtiger_contactsubdetails.email2 HAVING COUNT(*)>1) AS temp ON  ifnull(vtiger_contactdetails.firstname,'null') = ifnull(temp.firstname,'null') and  ifnull(vtiger_contactsubdetails.email2,'null') = ifnull(temp.email2,'null') WHERE vtiger_crmentity.deleted = 0 ORDER BY vtiger_contactdetails.firstname,vtiger_contactsubdetails.email2,vtiger_contactdetails.contactid ASC",
		),
		array(
			12,
			'Accounts',
			'vtiger_account.industry.industry,vtiger_account.phone.phone',
			array('industry'=> '15', 'phone'=> '11'),
			"SELECT vtiger_account.accountid AS recordid, vtiger_users_last_import.deleted,vtiger_account.industry,vtiger_account.phone FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_account.accountid INNER JOIN vtiger_accountscf ON vtiger_accountscf.accountid=vtiger_account.accountid INNER JOIN tempaccounts12 temptab ON temptab.id=vtiger_account.accountid LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups ON vtiger_groups.groupid=vtiger_crmentity.smownerid LEFT JOIN vtiger_users_last_import ON vtiger_users_last_import.bean_id=vtiger_account.accountid INNER JOIN (SELECT vtiger_account.industry,vtiger_account.phone  FROM vtiger_account INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_account.accountid INNER JOIN vtiger_accountscf ON vtiger_accountscf.accountid=vtiger_account.accountid INNER JOIN tempaccounts122 temptab2 ON temptab2.id=vtiger_account.accountid LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups ON vtiger_groups.groupid=vtiger_crmentity.smownerid  WHERE vtiger_crmentity.deleted = 0 GROUP BY vtiger_account.industry,vtiger_account.phone HAVING COUNT(*)>1) AS temp ON  ifnull(vtiger_account.industry,'null') = ifnull(temp.industry,'null') and  ifnull(vtiger_account.phone,'null') = ifnull(temp.phone,'null') WHERE vtiger_crmentity.deleted = 0 ORDER BY vtiger_account.industry,vtiger_account.phone,vtiger_account.accountid ASC",
		),
		array(
			12,
			'Potentials',
			'vtiger_potentials.amount.amount,vtiger_potentials.forecast.forecast',
			array('amount'=> '71', 'forecast'=> '9'),
			"SELECT vtiger_potential.potentialid AS recordid, vtiger_users_last_import.deleted,vtiger_potentials.amount,vtiger_potentials.forecast FROM vtiger_potential INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_potential.potentialid INNER JOIN vtiger_potentialscf ON vtiger_potentialscf.potentialid=vtiger_potential.potentialid INNER JOIN temppotentials12 temptab ON temptab.id=vtiger_potential.potentialid LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups ON vtiger_groups.groupid=vtiger_crmentity.smownerid LEFT JOIN vtiger_users_last_import ON vtiger_users_last_import.bean_id=vtiger_potential.potentialid INNER JOIN (SELECT vtiger_potentials.amount,vtiger_potentials.forecast  FROM vtiger_potential INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_potential.potentialid INNER JOIN vtiger_potentialscf ON vtiger_potentialscf.potentialid=vtiger_potential.potentialid INNER JOIN temppotentials122 temptab2 ON temptab2.id=vtiger_potential.potentialid LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups ON vtiger_groups.groupid=vtiger_crmentity.smownerid  WHERE vtiger_crmentity.deleted = 0 GROUP BY vtiger_potentials.amount,vtiger_potentials.forecast HAVING COUNT(*)>1) AS temp ON  ifnull(vtiger_potentials.amount,'null') = ifnull(temp.amount,'null') and  ifnull(vtiger_potentials.forecast,'null') = ifnull(temp.forecast,'null') WHERE vtiger_crmentity.deleted = 0 ORDER BY vtiger_potentials.amount,vtiger_potentials.forecast,vtiger_potential.potentialid ASC",
		),
		array(
			1,
			'evvtMenu',
			'vtiger_evvtmenu.mtype.mtype,vtiger_evvtmenu.mvalue.mvalue',
			array('mtype'=> '1', 'mvalue'=> '1'),
			'',
		),
		);
	}

	/**
	 * Method testgetDuplicateQuery
	 * @test
	 * @dataProvider getDuplicateQueryProvider
	 */
	public function testgetDuplicateQuery($userid, $module, $field_values, $ui_type_arr, $expected) {
		global $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($userid);
		$current_user = $user;
		$actual = getDuplicateQuery($module, $field_values, $ui_type_arr);
		$this->assertEquals($expected, $actual, "Test getDuplicatesQuery Method on $module Module");
		$current_user = Users::getActiveAdminUser();
	}

	/**
	 * Method getActionidProvider
	 * params
	 */
	public function getActionidProvider() {
		return array(
			array('SavePriceBook', 0),
			array('PriceBookEditView', 1),
			array('VendorEditView', 1),
			array('DuplicatesHandling', 10),
			array('DoesNotExist', ''),
			array('', ''),
		);
	}

	/**
	 * Method testgetActionid
	 * @test
	 * @dataProvider getActionidProvider
	 */
	public function testgetActionid($action, $expected) {
		$this->assertEquals($expected, getActionid($action), "Test getActionid Method on $action");
	}

	/**
	 * Method getActionnameProvider
	 * params
	 */
	public function getActionnameProvider() {
		return array(
			array(0, 'Save'),
			array(1, 'EditView'),
			array(3, 'index'),
			array(10, 'DuplicatesHandling'),
			array('', ''),
			array(3000, ''),
		);
	}

	/**
	 * Method testgetActionname
	 * @test
	 * @dataProvider getActionnameProvider
	 */
	public function testgetActionname($actionid, $expected) {
		$this->assertEquals($expected, getActionname($actionid), "Test getActionname Method on $actionid");
	}

	/**
	 * Method getRecordOwnerIdProvider
	 * params
	 */
	public function getRecordOwnerIdProvider() {
		return array(
			array(10, array('Users' => 12)),
			array(3106, array('Users' => 9)),
			array(3107, array('Groups' => 2)),
			array(32, array('Users' => 6)),
			array(1084, array('Users' => 11)),
			array('', array()),
			array(3000000000000, array()),
		);
	}

	/**
	 * Method testgetRecordOwnerId
	 * @test
	 * @dataProvider getRecordOwnerIdProvider
	 */
	public function testgetRecordOwnerId($record, $expected) {
		if ($record==3107) {
			global $adb;
			$adb->query('update vtiger_crmentity set smownerid=2 where crmid=3107');
		}
		$this->assertEquals($expected, getRecordOwnerId($record), 'Test getRecordOwnerId');
		if ($record==3107) {
			$adb->query('update vtiger_crmentity set smownerid=5 where crmid=3107');
		}
	}

	/**
	 * Method getProfile2FieldPermissionListProvider
	 * params
	 */
	public function getProfile2FieldPermissionListProvider() {
		$expected_cbtranslation_module_fields = array(
			array('cbtranslation No', '0', '4', '0', '833', '1', 'V~M'),
			array('Locale', '0', '32', '0', '834', '1', 'V~M'),
			array('Module', '0', '1614', '0', '835', '1', 'V~M'),
			array('Key', '0', '1', '0', '836', '1', 'V~M'),
			array('i18n', '0', '19', '0', '837', '1', 'V~0'),
			array('Translates', '0', '10', '0', '838', '1', 'V~0'),
			array('Picklist', '0', '1615', '0', '839', '1', 'V~0'),
			array('Field', '0', '1', '0', '840', '1', 'V~0'),
			array('Proof Read', '0', '56', '0', '841', '1', 'C~0'),
			array('Assigned To', '0', '53', '0', '842', '1', 'V~M'),
			array('Created Time', '0', '70', '0', '843', '2', 'DT~O'),
			array('Modified Time', '0', '70', '0', '844', '2', 'DT~O'),
			array('Created By', '0', '52', '0', '845', '2', 'V~O'),
		);
		$expected_accounts_module_fields = array(
			array('Account Name', '0', '2', '0', '1', '1', 'V~M'),
			array('Account No', '0', '4', '0', '2', '1', 'V~O'),
			array('Phone', '0', '11', '0', '3', '1', 'V~O'),
			array('Website', '0', '17', '0', '4', '1', 'V~O'),
			array('Fax', '0', '11', '0', '5', '1', 'V~O'),
			array('Ticker Symbol', '0', '1', '0', '6', '1', 'V~O' ),
			array('Other Phone', '0', '11', '0', '7', '1', 'V~O'),
			array('Member Of', '0', '10', '0', '8', '1', 'I~O'),
			array('Email', '0', '13', '0', '9', '1', 'E~O'),
			array('Employees', '0', '7', '0', '10', '1', 'I~O'),
			array('Other Email', '0', '13', '0', '11', '1', 'E~O'),
			array('Ownership', '0', '1', '0', '12', '1', 'V~O'),
			array('Rating', '0', '15', '0', '13', '1', 'V~O'),
			array('industry', '0', '15', '0', '14', '1', 'V~O'),
			array('SIC Code', '0', '1', '0', '15', '1', 'V~O'),
			array('Type', '0', '15', '0', '16', '1', 'V~O'),
			array('Annual Revenue', '0', '71', '0', '17', '1', 'N~O'),
			array('Email Opt Out', '0', '56', '0', '18', '1','C~O'),
			array('Notify Owner', '0', '56', '0', '19', '1', 'C~O'),
			array('Assigned To', '0', '53', '0', '20', '1', 'V~M'),
			array('Created Time', '0', '70', '0', '21', '2', 'DT~O'),
			array('Modified Time', '0', '70', '0', '22', '2', 'DT~O'),
			array('Last Modified By', '0', '52', '0', '23', '3', 'V~O'),
			array('Billing Address','0', '21', '0', '24', '1', 'V~O'),
			array('Shipping Address', '0', '21', '0', '25', '1', 'V~O'),
			array('Billing City', '0', '1', '0', '26', '1', 'V~O'),
			array('Shipping City', '0', '1', '0', '27', '1', 'V~O'),
			array('Billing State', '0', '1', '0', '28', '1', 'V~O'),
			array('Shipping State', '0', '1', '0', '29', '1', 'V~O'),
			array('Billing Code', '0', '1', '0', '30', '1', 'V~O'),
			array('Shipping Code', '0', '1', '0', '31', '1', 'V~O'),
			array('Billing Country', '0', '1', '0', '32', '1', 'V~O'),
			array('Shipping Country', '0', '1', '0', '33', '1', 'V~O'),
			array('Billing Po Box', '0', '1', '0', '34', '1', 'V~O'),
			array('Shipping Po Box', '0', '1', '0', '35', '1', 'V~O'),
			array('Description', '0', '19', '0', '36', '1', 'V~O'),
			array('Status', '0', '16', '0', '152', '1', 'V~O'),
			array('Text', '0', '1', '0', '718', '1', 'V~O~LE~50'),
			array('Number', '0', '7', '0', '719', '1', 'NN~O~8,2'),
			array('Percent', '0', '9', '0', '720', '1', 'N~O~2~2'),
			array('Currency', '0', '71', '0', '721', '1', 'N~O~8,2'),
			array('Date', '0', '5', '0', '722', '1', 'D~O'),
			array('Emailcf', '0', '13', '0', '723', '1', 'E~O'),
			array('Phonecf', '0', '11', '0', '724', '1', 'V~O'),
			array('URL', '0', '17', '0', '725', '1', 'V~O'),
			array('Checkbox', '0', '56', '0', '726', '1', 'C~O'),
			array('skypecf', '0', '85', '0', '727', '1', 'V~O'),
			array('Time', '0', '14', '0', '728', '1', 'T~O'),
			array('PLMain', '0', '15', '0', '729', '1', 'V~O'),
			array('PLDep1', '0', '15', '0', '730', '1', 'V~O'),
			array('PLDep2', '0', '15', '0', '731', '1', 'V~O'),
			array('Planets', '0', '33', '0', '732', '1', 'V~O'),
			array('Is Converted From Lead', '0', '56', '0', '752', '2', 'C~O'),
			array('Converted From Lead', '0', '10', '0', '753', '3', 'V~O'),
			array('Created By', '0', '52', '0', '764', '2', 'V~O'),
		);
		$expected_contacts_module_fields = array(
			array('Salutation', '0', '55', '0', '66', '3', 'V~O'),
			array('First Name', '0', '55', '0', '67', '1', 'V~O'),
			array('Contact Id', '0', '4', '0', '68', '1', 'V~O'),
			array('Office Phone', '0', '11', '0', '69', '1', 'V~O'),
			array('Last Name', '0', '255', '0', '70', '1', 'V~M'),
			array('Mobile', '0', '11', '0', '71', '1', 'V~O'),
			array('Account Name', '0', '10', '0', '72', '1', 'I~O'),
			array('Home Phone', '0', '11', '0', '73', '1', 'V~O'),
			array('Lead Source', '0', '15', '0', '74', '1', 'V~O'),
			array('Other Phone', '0', '11', '0', '75', '1', 'V~O'),
			array('Title', '0', '1', '0', '76', '1', 'V~O'),
			array('Fax', '0', '11', '0', '77', '1', 'V~O'),
			array('Department', '0', '1', '0', '78', '1', 'V~O'),
			array('Birthdate', '0', '5', '0', '79', '1', 'D~O'),
			array('Email', '0', '13', '0', '80', '1', 'E~O'),
			array('Reports To', '0', '10', '0', '81', '1', 'V~O'),
			array('Assistant', '0', '1', '0', '82', '1', 'V~O'),
			array('Secondary Email', '0', '13', '0', '83', '1', 'E~O'),
			array('Assistant Phone', '0', '11', '0', '84', '1', 'V~O'),
			array('Do Not Call', '0', '56', '0', '85', '1', 'C~O'),
			array('Email Opt Out', '0', '56', '0', '86', '1', 'C~O'),
			array('Assigned To', '0', '53', '0', '87', '1', 'V~M'),
			array('Reference', '0', '56', '0', '88', '1', 'C~O'),
			array('Notify Owner', '0', '56', '0', '89', '1', 'C~O'),
			array('Created Time', '0', '70', '0', '90', '2', 'DT~O'),
			array('Modified Time', '0', '70', '0', '91', '2', 'DT~O'),
			array('Last Modified By', '0', '52', '0', '92', '3', 'V~O'),
			array('Portal User', '0', '56', '0', '93', '1', 'C~O'),
			array('Support Start Date', '0', '5', '0', '94', '1', 'D~O'),
			array('Support End Date', '0', '5', '0', '95', '1', 'D~O~OTH~GE~support_start_date~Support Start Date'),
			array('Mailing Street', '0', '21', '0', '96', '1', 'V~O'),
			array('Other Street', '0', '21', '0', '97', '1', 'V~O'),
			array('Mailing City', '0', '1', '0', '98', '1', 'V~O'),
			array('Other City', '0', '1', '0', '99', '1', 'V~O'),
			array('Mailing State', '0', '1', '0', '100', '1', 'V~O'),
			array('Other State', '0', '1', '0', '101', '1', 'V~O'),
			array('Mailing Zip', '0', '1', '0', '102', '1', 'V~O'),
			array('Other Zip', '0', '1', '0', '103', '1', 'V~O'),
			array('Mailing Country', '0', '1', '0', '104', '1', 'V~O'),
			array('Other Country', '0', '1', '0', '105', '1', 'V~O'),
			array('Mailing Po Box', '0', '1', '0', '106', '1', 'V~O'),
			array('Other Po Box', '0', '1', '0', '107', '1', 'V~O'),
			array('Contact Image', '0', '69', '0', '108', '1', 'V~O'),
			array('Description', '0', '19', '0', '109', '1', 'V~O'),
			array('Status', '0', '16', '0', '151', '1', 'V~O'),
			array('Is Converted From Lead', '0', '56', '0', '754', '2', 'C~O'),
			array('Converted From Lead', '0', '10', '0', '755', '3', 'V~O'),
			array('Created By', '0', '52', '0', '763', '2', 'V~O'),
			array('Template Language', '0', '15', '0', '1135', '1', 'V~O'),
			array('portalpasswordtype', '0', '16', '0', '1150', '1', 'V~O'),
			array('portalloginuser', '0', '77', '0', '1151', '1', 'I~O'),
		);
		return array(
			array('cbtranslation', '1', $expected_cbtranslation_module_fields),
			array('cbtranslation', '2', $expected_cbtranslation_module_fields),
			array('cbtranslation', '3', $expected_cbtranslation_module_fields),
			array('cbtranslation', '4', $expected_cbtranslation_module_fields),
			array('cbtranslation', '5', $expected_cbtranslation_module_fields),
			array('cbtranslation', '6', $expected_cbtranslation_module_fields),
			array('Accounts', '1', $expected_accounts_module_fields),
			array('Accounts', '2', $expected_accounts_module_fields),
			array('Accounts', '3', $expected_accounts_module_fields),
			array('Accounts', '4', $expected_accounts_module_fields),
			array('Accounts', '5', $expected_accounts_module_fields),
			array('Accounts', '6', $expected_accounts_module_fields),
			array('Contacts', '1', $expected_contacts_module_fields),
			array('Contacts', '2', $expected_contacts_module_fields),
			array('Contacts', '3', $expected_contacts_module_fields),
			array('Contacts', '4', $expected_contacts_module_fields),
			array('Contacts', '5', $expected_contacts_module_fields),
			array('Contacts', '6', $expected_contacts_module_fields),
		);
	}

	/**
	 * Method testgetProfile2FieldPermissionList
	 * @test
	 * @dataProvider getProfile2FieldPermissionListProvider
	 */
	public function testgetProfile2FieldPermissionList($module, $profileid, $expected) {
		$actual = getProfile2FieldPermissionList($module, $profileid);
		$this->assertEquals($expected, $actual, "Test getProfile2FieldPermissionList Method on $module Module and Profileid $profileid");
	}


	/**
	 * Method getProfile2ModuleFieldPermissionListProvider
	 * params
	 */
	public function getProfile2ModuleFieldPermissionListProvider() {
		$expected_cbtranslation_module_fields = array(
			0 => array(0 => 'cbtranslation No', 1 => '0', 2 => '4', 3 => '0', 4 => '833', 5 => '1', 6 => 'V~M', 7 => 'B',),
			1 => array(0 => 'Locale', 1 => '0', 2 => '32', 3 => '0', 4 => '834', 5 => '1', 6 => 'V~M', 7 => 'B',),
			2 => array(0 => 'Module', 1 => '0', 2 => '1614', 3 => '0', 4 => '835', 5 => '1', 6 => 'V~M', 7 => 'B',),
			3 => array(0 => 'Key', 1 => '0', 2 => '1', 3 => '0', 4 => '836', 5 => '1', 6 => 'V~M', 7 => 'B',),
			4 => array(0 => 'i18n', 1 => '0', 2 => '19', 3 => '0', 4 => '837', 5 => '1', 6 => 'V~0', 7 => 'B',),
			5 => array(0 => 'Translates', 1 => '0', 2 => '10', 3 => '0', 4 => '838', 5 => '1', 6 => 'V~0', 7 => 'B',),
			6 => array(0 => 'Picklist', 1 => '0', 2 => '1615', 3 => '0', 4 => '839', 5 => '1', 6 => 'V~0', 7 => 'B',),
			7 => array(0 => 'Field', 1 => '0', 2 => '1', 3 => '0', 4 => '840', 5 => '1', 6 => 'V~0', 7 => 'B',),
			8 => array(0 => 'Proof Read', 1 => '0', 2 => '56', 3 => '0', 4 => '841', 5 => '1', 6 => 'C~0', 7 => 'B',),
			9 => array(0 => 'Assigned To', 1 => '0', 2 => '53', 3 => '0', 4 => '842', 5 => '1', 6 => 'V~M', 7 => 'B',),
			10 => array(0 => 'Created Time', 1 => '0', 2 => '70', 3 => '0', 4 => '843', 5 => '2', 6 => 'DT~O', 7 => 'B',),
			11 => array(0 => 'Modified Time', 1 => '0', 2 => '70', 3 => '0', 4 => '844', 5 => '2', 6 => 'DT~O', 7 => 'B',),
			12 => array(0 => 'Created By', 1 => '0', 2 => '52', 3 => '0', 4 => '845', 5 => '2', 6 => 'V~O', 7 => 'B',),
		);
		$expected_accounts_module_fields = array(
			0 => array(0 => 'Account Name', 1 => '0', 2 => '2', 3 => '0', 4 => '1', 5 => '1', 6 => 'V~M', 7 => 'B',),
			1 => array(0 => 'Account No', 1 => '0', 2 => '4', 3 => '0', 4 => '2', 5 => '1', 6 => 'V~O', 7 => 'B',),
			2 => array(0 => 'Phone', 1 => '0', 2 => '11', 3 => '0', 4 => '3', 5 => '1', 6 => 'V~O', 7 => 'B',),
			3 => array(0 => 'Website', 1 => '0', 2 => '17', 3 => '0', 4 => '4', 5 => '1', 6 => 'V~O', 7 => 'B',),
			4 => array(0 => 'Fax', 1 => '0', 2 => '11', 3 => '0', 4 => '5', 5 => '1', 6 => 'V~O', 7 => 'B',),
			5 => array(0 => 'Ticker Symbol', 1 => '0', 2 => '1', 3 => '0', 4 => '6', 5 => '1', 6 => 'V~O', 7 => 'B',),
			6 => array(0 => 'Other Phone', 1 => '0', 2 => '11', 3 => '0', 4 => '7', 5 => '1', 6 => 'V~O', 7 => 'B',),
			7 => array(0 => 'Member Of', 1 => '0', 2 => '10', 3 => '0', 4 => '8', 5 => '1', 6 => 'I~O', 7 => 'B',),
			8 => array(0 => 'Email', 1 => '0', 2 => '13', 3 => '0', 4 => '9', 5 => '1', 6 => 'E~O', 7 => 'B',),
			9 => array(0 => 'Employees', 1 => '0', 2 => '7', 3 => '0', 4 => '10', 5 => '1', 6 => 'I~O', 7 => 'B',),
			10 => array(0 => 'Other Email', 1 => '0', 2 => '13', 3 => '0', 4 => '11', 5 => '1', 6 => 'E~O', 7 => 'B',),
			11 => array(0 => 'Ownership', 1 => '0', 2 => '1', 3 => '0', 4 => '12', 5 => '1', 6 => 'V~O', 7 => 'B',),
			12 => array(0 => 'Rating', 1 => '0', 2 => '15', 3 => '0', 4 => '13', 5 => '1', 6 => 'V~O', 7 => 'B',),
			13 => array(0 => 'industry', 1 => '0', 2 => '15', 3 => '0', 4 => '14', 5 => '1', 6 => 'V~O', 7 => 'B',),
			14 => array(0 => 'SIC Code', 1 => '0', 2 => '1', 3 => '0', 4 => '15', 5 => '1', 6 => 'V~O', 7 => 'B',),
			15 => array(0 => 'Type', 1 => '0', 2 => '15', 3 => '0', 4 => '16', 5 => '1', 6 => 'V~O', 7 => 'B',),
			16 => array(0 => 'Annual Revenue', 1 => '0', 2 => '71', 3 => '0', 4 => '17', 5 => '1', 6 => 'N~O', 7 => 'B',),
			17 => array(0 => 'Email Opt Out', 1 => '0', 2 => '56', 3 => '0', 4 => '18', 5 => '1', 6 => 'C~O', 7 => 'B',),
			18 => array(0 => 'Notify Owner', 1 => '0', 2 => '56', 3 => '0', 4 => '19', 5 => '1', 6 => 'C~O', 7 => 'B',),
			19 => array(0 => 'Assigned To', 1 => '0', 2 => '53', 3 => '0', 4 => '20', 5 => '1', 6 => 'V~M', 7 => 'B',),
			20 => array(0 => 'Created Time', 1 => '0', 2 => '70', 3 => '0', 4 => '21', 5 => '2', 6 => 'DT~O', 7 => 'B',),
			21 => array(0 => 'Modified Time', 1 => '0', 2 => '70', 3 => '0', 4 => '22', 5 => '2', 6 => 'DT~O', 7 => 'B',),
			22 => array(0 => 'Last Modified By', 1 => '0', 2 => '52', 3 => '0', 4 => '23', 5 => '3', 6 => 'V~O', 7 => 'B',),
			23 => array(0 => 'Billing Address', 1 => '0', 2 => '21', 3 => '0', 4 => '24', 5 => '1', 6 => 'V~O', 7 => 'B',),
			24 => array(0 => 'Shipping Address', 1 => '0', 2 => '21', 3 => '0', 4 => '25', 5 => '1', 6 => 'V~O', 7 => 'B',),
			25 => array(0 => 'Billing City', 1 => '0', 2 => '1', 3 => '0', 4 => '26', 5 => '1', 6 => 'V~O', 7 => 'B',),
			26 => array(0 => 'Shipping City', 1 => '0', 2 => '1', 3 => '0', 4 => '27', 5 => '1', 6 => 'V~O', 7 => 'B',),
			27 => array(0 => 'Billing State', 1 => '0', 2 => '1', 3 => '0', 4 => '28', 5 => '1', 6 => 'V~O', 7 => 'B',),
			28 => array(0 => 'Shipping State', 1 => '0', 2 => '1', 3 => '0', 4 => '29', 5 => '1', 6 => 'V~O', 7 => 'B',),
			29 => array(0 => 'Billing Code', 1 => '0', 2 => '1', 3 => '0', 4 => '30', 5 => '1', 6 => 'V~O', 7 => 'B',),
			30 => array(0 => 'Shipping Code', 1 => '0', 2 => '1', 3 => '0', 4 => '31', 5 => '1', 6 => 'V~O', 7 => 'B',),
			31 => array(0 => 'Billing Country', 1 => '0', 2 => '1', 3 => '0', 4 => '32', 5 => '1', 6 => 'V~O', 7 => 'B',),
			32 => array(0 => 'Shipping Country', 1 => '0', 2 => '1', 3 => '0', 4 => '33', 5 => '1', 6 => 'V~O', 7 => 'B',),
			33 => array(0 => 'Billing Po Box', 1 => '0', 2 => '1', 3 => '0', 4 => '34', 5 => '1', 6 => 'V~O', 7 => 'B',),
			34 => array(0 => 'Shipping Po Box', 1 => '0', 2 => '1', 3 => '0', 4 => '35', 5 => '1', 6 => 'V~O', 7 => 'B',),
			35 => array(0 => 'Description', 1 => '0', 2 => '19', 3 => '0', 4 => '36', 5 => '1', 6 => 'V~O', 7 => 'B',),
			36 => array(0 => 'Status', 1 => '0', 2 => '16', 3 => '0', 4 => '152', 5 => '1', 6 => 'V~O', 7 => 'B',),
			37 => array(0 => 'Text', 1 => '0', 2 => '1', 3 => '0', 4 => '718', 5 => '1', 6 => 'V~O~LE~50', 7 => 'B',),
			38 => array(0 => 'Number', 1 => '0', 2 => '7', 3 => '0', 4 => '719', 5 => '1', 6 => 'NN~O~8,2', 7 => 'B',),
			39 => array(0 => 'Percent', 1 => '0', 2 => '9', 3 => '0', 4 => '720', 5 => '1', 6 => 'N~O~2~2', 7 => 'B',),
			40 => array(0 => 'Currency', 1 => '0', 2 => '71', 3 => '0', 4 => '721', 5 => '1', 6 => 'N~O~8,2', 7 => 'B',),
			41 => array(0 => 'Date', 1 => '0', 2 => '5', 3 => '0', 4 => '722', 5 => '1', 6 => 'D~O', 7 => 'B',),
			42 => array(0 => 'Emailcf', 1 => '0', 2 => '13', 3 => '0', 4 => '723', 5 => '1', 6 => 'E~O', 7 => 'B',),
			43 => array(0 => 'Phonecf', 1 => '0', 2 => '11', 3 => '0', 4 => '724', 5 => '1', 6 => 'V~O', 7 => 'B',),
			44 => array(0 => 'URL', 1 => '0', 2 => '17', 3 => '0', 4 => '725', 5 => '1', 6 => 'V~O', 7 => 'B',),
			45 => array(0 => 'Checkbox', 1 => '0', 2 => '56', 3 => '0', 4 => '726', 5 => '1', 6 => 'C~O', 7 => 'B',),
			46 => array(0 => 'skypecf', 1 => '0', 2 => '85', 3 => '0', 4 => '727', 5 => '1', 6 => 'V~O', 7 => 'B',),
			47 => array(0 => 'Time', 1 => '0', 2 => '14', 3 => '0', 4 => '728', 5 => '1', 6 => 'T~O', 7 => 'B',),
			48 => array(0 => 'PLMain', 1 => '0', 2 => '15', 3 => '0', 4 => '729', 5 => '1', 6 => 'V~O', 7 => 'B',),
			49 => array(0 => 'PLDep1', 1 => '0', 2 => '15', 3 => '0', 4 => '730', 5 => '1', 6 => 'V~O', 7 => 'B',),
			50 => array(0 => 'PLDep2', 1 => '0', 2 => '15', 3 => '0', 4 => '731', 5 => '1', 6 => 'V~O', 7 => 'B',),
			51 => array(0 => 'Planets', 1 => '0', 2 => '33', 3 => '0', 4 => '732', 5 => '1', 6 => 'V~O', 7 => 'B',),
			52 => array(0 => 'Is Converted From Lead', 1 => '0', 2 => '56', 3 => '0', 4 => '752', 5 => '2', 6 => 'C~O', 7 => 'B',),
			53 => array(0 => 'Converted From Lead', 1 => '0', 2 => '10', 3 => '0', 4 => '753', 5 => '3', 6 => 'V~O', 7 => 'B',),
			54 => array(0 => 'Created By', 1 => '0', 2 => '52', 3 => '0', 4 => '764', 5 => '2', 6 => 'V~O', 7 => 'B',),
		);
		$expected_contacts_module_fields = array(
			0 => array(0 => 'Salutation', 1 => '0', 2 => '55', 3 => '0', 4 => '66', 5 => '3', 6 => 'V~O', 7 => 'B',),
			1 => array(0 => 'First Name', 1 => '0', 2 => '55', 3 => '0', 4 => '67', 5 => '1', 6 => 'V~O', 7 => 'B',),
			2 => array(0 => 'Contact Id', 1 => '0', 2 => '4', 3 => '0', 4 => '68', 5 => '1', 6 => 'V~O', 7 => 'B',),
			3 => array(0 => 'Office Phone', 1 => '0', 2 => '11', 3 => '0', 4 => '69', 5 => '1', 6 => 'V~O', 7 => 'B',),
			4 => array(0 => 'Last Name', 1 => '0', 2 => '255', 3 => '0', 4 => '70', 5 => '1', 6 => 'V~M', 7 => 'B',),
			5 => array(0 => 'Mobile', 1 => '0', 2 => '11', 3 => '0', 4 => '71', 5 => '1', 6 => 'V~O', 7 => 'B',),
			6 => array(0 => 'Account Name', 1 => '0', 2 => '10', 3 => '0', 4 => '72', 5 => '1', 6 => 'I~O', 7 => 'B',),
			7 => array(0 => 'Home Phone', 1 => '0', 2 => '11', 3 => '0', 4 => '73', 5 => '1', 6 => 'V~O', 7 => 'B',),
			8 => array(0 => 'Lead Source', 1 => '0', 2 => '15', 3 => '0', 4 => '74', 5 => '1', 6 => 'V~O', 7 => 'B',),
			9 => array(0 => 'Other Phone', 1 => '0', 2 => '11', 3 => '0', 4 => '75', 5 => '1', 6 => 'V~O', 7 => 'B',),
			10 => array(0 => 'Title', 1 => '0', 2 => '1', 3 => '0', 4 => '76', 5 => '1', 6 => 'V~O', 7 => 'B',),
			11 => array(0 => 'Fax', 1 => '0', 2 => '11', 3 => '0', 4 => '77', 5 => '1', 6 => 'V~O', 7 => 'B',),
			12 => array(0 => 'Department', 1 => '0', 2 => '1', 3 => '0', 4 => '78', 5 => '1', 6 => 'V~O', 7 => 'B',),
			13 => array(0 => 'Birthdate', 1 => '0', 2 => '5', 3 => '0', 4 => '79', 5 => '1', 6 => 'D~O', 7 => 'B',),
			14 => array(0 => 'Email', 1 => '0', 2 => '13', 3 => '0', 4 => '80', 5 => '1', 6 => 'E~O', 7 => 'B',),
			15 => array(0 => 'Reports To', 1 => '0', 2 => '10', 3 => '0', 4 => '81', 5 => '1', 6 => 'V~O', 7 => 'B',),
			16 => array(0 => 'Assistant', 1 => '0', 2 => '1', 3 => '0', 4 => '82', 5 => '1', 6 => 'V~O', 7 => 'B',),
			17 => array(0 => 'Secondary Email', 1 => '0', 2 => '13', 3 => '0', 4 => '83', 5 => '1', 6 => 'E~O', 7 => 'B',),
			18 => array(0 => 'Assistant Phone', 1 => '0', 2 => '11', 3 => '0', 4 => '84', 5 => '1', 6 => 'V~O', 7 => 'B',),
			19 => array(0 => 'Do Not Call', 1 => '0', 2 => '56', 3 => '0', 4 => '85', 5 => '1', 6 => 'C~O', 7 => 'B',),
			20 => array(0 => 'Email Opt Out', 1 => '0', 2 => '56', 3 => '0', 4 => '86', 5 => '1', 6 => 'C~O', 7 => 'B',),
			21 => array(0 => 'Assigned To', 1 => '0', 2 => '53', 3 => '0', 4 => '87', 5 => '1', 6 => 'V~M', 7 => 'B',),
			22 => array(0 => 'Reference', 1 => '0', 2 => '56', 3 => '0', 4 => '88', 5 => '1', 6 => 'C~O', 7 => 'B',),
			23 => array(0 => 'Notify Owner', 1 => '0', 2 => '56', 3 => '0', 4 => '89', 5 => '1', 6 => 'C~O', 7 => 'B',),
			24 => array(0 => 'Created Time', 1 => '0', 2 => '70', 3 => '0', 4 => '90', 5 => '2', 6 => 'DT~O', 7 => 'B',),
			25 => array(0 => 'Modified Time', 1 => '0', 2 => '70', 3 => '0', 4 => '91', 5 => '2', 6 => 'DT~O', 7 => 'B',),
			26 => array(0 => 'Last Modified By', 1 => '0', 2 => '52', 3 => '0', 4 => '92', 5 => '3', 6 => 'V~O', 7 => 'B',),
			27 => array(0 => 'Portal User', 1 => '0', 2 => '56', 3 => '0', 4 => '93', 5 => '1', 6 => 'C~O', 7 => 'B',),
			28 => array(0 => 'Support Start Date', 1 => '0', 2 => '5', 3 => '0', 4 => '94', 5 => '1', 6 => 'D~O', 7 => 'B',),
			29 => array(0 => 'Support End Date', 1 => '0', 2 => '5', 3 => '0', 4 => '95', 5 => '1', 6 => 'D~O~OTH~GE~support_start_date~Support Start Date', 7 => 'B',),
			30 => array(0 => 'Mailing Street', 1 => '0', 2 => '21', 3 => '0', 4 => '96', 5 => '1', 6 => 'V~O', 7 => 'B',),
			31 => array(0 => 'Other Street', 1 => '0', 2 => '21', 3 => '0', 4 => '97', 5 => '1', 6 => 'V~O', 7 => 'B',),
			32 => array(0 => 'Mailing City', 1 => '0', 2 => '1', 3 => '0', 4 => '98', 5 => '1', 6 => 'V~O', 7 => 'B',),
			33 => array(0 => 'Other City', 1 => '0', 2 => '1', 3 => '0', 4 => '99', 5 => '1', 6 => 'V~O', 7 => 'B',),
			34 => array(0 => 'Mailing State', 1 => '0', 2 => '1', 3 => '0', 4 => '100', 5 => '1', 6 => 'V~O', 7 => 'B',),
			35 => array(0 => 'Other State', 1 => '0', 2 => '1', 3 => '0', 4 => '101', 5 => '1', 6 => 'V~O', 7 => 'B',),
			36 => array(0 => 'Mailing Zip', 1 => '0', 2 => '1', 3 => '0', 4 => '102', 5 => '1', 6 => 'V~O', 7 => 'B',),
			37 => array(0 => 'Other Zip', 1 => '0', 2 => '1', 3 => '0', 4 => '103', 5 => '1', 6 => 'V~O', 7 => 'B',),
			38 => array(0 => 'Mailing Country', 1 => '0', 2 => '1', 3 => '0', 4 => '104', 5 => '1', 6 => 'V~O', 7 => 'B',),
			39 => array(0 => 'Other Country', 1 => '0', 2 => '1', 3 => '0', 4 => '105', 5 => '1', 6 => 'V~O', 7 => 'B',),
			40 => array(0 => 'Mailing Po Box', 1 => '0', 2 => '1', 3 => '0', 4 => '106', 5 => '1', 6 => 'V~O', 7 => 'B',),
			41 => array(0 => 'Other Po Box', 1 => '0', 2 => '1', 3 => '0', 4 => '107', 5 => '1', 6 => 'V~O', 7 => 'B',),
			42 => array(0 => 'Contact Image', 1 => '0', 2 => '69', 3 => '0', 4 => '108', 5 => '1', 6 => 'V~O', 7 => 'B',),
			43 => array(0 => 'Description', 1 => '0', 2 => '19', 3 => '0', 4 => '109', 5 => '1', 6 => 'V~O', 7 => 'B',),
			44 => array(0 => 'Status', 1 => '0', 2 => '16', 3 => '0', 4 => '151', 5 => '1', 6 => 'V~O', 7 => 'B',),
			45 => array(0 => 'Is Converted From Lead', 1 => '0', 2 => '56', 3 => '0', 4 => '754', 5 => '2', 6 => 'C~O', 7 => 'B',),
			46 => array(0 => 'Converted From Lead', 1 => '0', 2 => '10', 3 => '0', 4 => '755', 5 => '3', 6 => 'V~O', 7 => 'B',),
			47 => array(0 => 'Created By', 1 => '0', 2 => '52', 3 => '0', 4 => '763', 5 => '2', 6 => 'V~O', 7 => 'B',),
			48 => array(0 => 'Template Language', 1 => '0', 2 => '15', 3 => '0', 4 => '1135', 5 => '1', 6 => 'V~O', 7 => 'B',),
			49 => array(0 => 'portalpasswordtype', 1 => '0', 2 => '16', 3 => '0', 4 => '1150', 5 => '1', 6 => 'V~O', 7 => 'B',),
			50 => array(0 => 'portalloginuser', 1 => '0', 2 => '77', 3 => '0', 4 => '1151', 5 => '1', 6 => 'I~O', 7 => 'B',),
		);
		$expected_assets_module_fields = array(
			0 => array(0 => 'Asset No', 1 => '0', 2 => '4', 3 => '0', 4 => '602', 5 => '1', 6 => 'V~O', 7 => 'B',),
			1 => array(0 => 'Product Name', 1 => '0', 2 => '10', 3 => '0', 4 => '603', 5 => '1', 6 => 'V~M', 7 => 'B',),
			2 => array(0 => 'Serial Number', 1 => '0', 2 => '2', 3 => '0', 4 => '604', 5 => '1', 6 => 'V~M', 7 => 'B',),
			3 => array(0 => 'Date Sold', 1 => '0', 2 => '5', 3 => '0', 4 => '605', 5 => '1', 6 => 'D~M', 7 => 'B',),
			4 => array(0 => 'Date in Service', 1 => '0', 2 => '5', 3 => '0', 4 => '606', 5 => '1', 6 => 'D~M~OTH~GE~datesold~Date Sold', 7 => 'B',),
			5 => array(0 => 'Status', 1 => '0', 2 => '15', 3 => '0', 4 => '607', 5 => '1', 6 => 'V~M', 7 => 'B',),
			6 => array(0 => 'Tag Number', 1 => '0', 2 => '2', 3 => '0', 4 => '608', 5 => '1', 6 => 'V~O', 7 => 'B',),
			7 => array(0 => 'Invoice Name', 1 => '0', 2 => '10', 3 => '0', 4 => '609', 5 => '1', 6 => 'V~O', 7 => 'B',),
			8 => array(0 => 'Shipping Method', 1 => '0', 2 => '2', 3 => '0', 4 => '610', 5 => '1', 6 => 'V~O', 7 => 'B',),
			9 => array(0 => 'Shipping Tracking Number', 1 => '0', 2 => '2', 3 => '0', 4 => '611', 5 => '1', 6 => 'V~O', 7 => 'B',),
			10 => array(0 => 'Assigned To', 1 => '0', 2 => '53', 3 => '0', 4 => '612', 5 => '1', 6 => 'V~M', 7 => 'B',),
			11 => array(0 => 'Asset Name', 1 => '0', 2 => '1', 3 => '0', 4 => '613', 5 => '1', 6 => 'V~M', 7 => 'B',),
			12 => array(0 => 'Customer Name', 1 => '0', 2 => '10', 3 => '0', 4 => '614', 5 => '1', 6 => 'V~M', 7 => 'B',),
			13 => array(0 => 'Created Time', 1 => '0', 2 => '70', 3 => '0', 4 => '615', 5 => '2', 6 => 'DT~O', 7 => 'B',),
			14 => array(0 => 'Modified Time', 1 => '0', 2 => '70', 3 => '0', 4 => '616', 5 => '2', 6 => 'DT~O', 7 => 'B',),
			15 => array(0 => 'Last Modified By', 1 => '0', 2 => '52', 3 => '0', 4 => '617', 5 => '3', 6 => 'V~O', 7 => 'B',),
			16 => array(0 => 'Notes', 1 => '0', 2 => '19', 3 => '0', 4 => '618', 5 => '1', 6 => 'V~O', 7 => 'B',),
			17 => array(0 => 'Created By', 1 => '0', 2 => '52', 3 => '0', 4 => '781', 5 => '2', 6 => 'V~O', 7 => 'B',),
		);
		return array(
			array('cbtranslation', '1', $expected_cbtranslation_module_fields),
			array('cbtranslation', '2', $expected_cbtranslation_module_fields),
			array('cbtranslation', '3', $expected_cbtranslation_module_fields),
			array('cbtranslation', '4', $expected_cbtranslation_module_fields),
			array('cbtranslation', '5', $expected_cbtranslation_module_fields),
			array('cbtranslation', '6', $expected_cbtranslation_module_fields),
			array('Accounts', '1', $expected_accounts_module_fields),
			array('Accounts', '2', $expected_accounts_module_fields),
			array('Accounts', '3', $expected_accounts_module_fields),
			array('Accounts', '4', $expected_accounts_module_fields),
			array('Accounts', '5', $expected_accounts_module_fields),
			array('Accounts', '6', $expected_accounts_module_fields),
			array('Contacts', '1', $expected_contacts_module_fields),
			array('Contacts', '2', $expected_contacts_module_fields),
			array('Contacts', '3', $expected_contacts_module_fields),
			array('Contacts', '4', $expected_contacts_module_fields),
			array('Contacts', '5', $expected_contacts_module_fields),
			array('Contacts', '6', $expected_contacts_module_fields),
			array('Assets', '1', $expected_assets_module_fields),
			array('Assets', '2', $expected_assets_module_fields),
			array('Assets', '3', $expected_assets_module_fields),
			array('Assets', '4', $expected_assets_module_fields),
			array('Assets', '5', $expected_assets_module_fields),
			array('Assets', '6', $expected_assets_module_fields),
		);
	}

	/**
	 * Method testgetProfile2ModuleFieldPermissionList
	 * @test
	 * @dataProvider getProfile2ModuleFieldPermissionListProvider
	 */
	public function testgetProfile2ModuleFieldPermissionList($module, $profileid, $expected) {
		$actual = getProfile2ModuleFieldPermissionList($module, $profileid);
		$this->assertEquals($expected, $actual, "Test getProfile2ModuleFieldPermissionList Method on $module Module and Profileid $profileid");
	}

	/**
	 * Method getConvertToMinutesProvider
	 * params
	 */
	public function getConvertToMinutesProvider() {
		return array(
			array('', 0),
			array('0', 0),
			array('1 Minute', 1),
			array('5 Minutes', 5),
			array('15 Minutes', 15),
			array('30 Minutes', 30),
			array('45 Minutes', 45),
			array('1 Hour', 60),
			array('1 Day', 1440),
			array('8 Minutes', 8),
			array('5 Hours', 300),
			array('5 Days', 7200),
		);
	}

		/**
	 * Method testConvertToMinutes
	 * @test
	 * @dataProvider getConvertToMinutesProvider
	 */
	public function testConvertToMinutes($tstring, $expected) {
		$actual = ConvertToMinutes($tstring);
		$this->assertEquals($expected, $actual, "Test ConvertToMinutes $tstring");
	}

	/**
	 * Method sanitizeUploadFileNameProvider
	 * params
	 */
	public function sanitizeUploadFileNameProvider() {
		return array(
			array('normal.ext', 'normal.ext', 'normal.ext'),
			array('name with spaces.ext', 'name_with_spaces.ext', 'spaces'),
			array('normal.ext\\', 'normal.ext', 'normal.ext\\'),
			array('normal.ext/', 'normal.ext_', 'normal.ext/'),
			array('normal.php/', 'normal.php_', 'normal.PHP'),
			array('normal.php', 'normal.phpfile.txt', 'normal.PHP'),
			array('normal.ext/..', 'normal.ext_..', 'normal.ext'),
			array('\\normal.ext', '\\normal.ext', '\\normal.ext'),
			array('/normal.ext', '_normal.ext', '/normal.ext'),
			array('../normal.ext', '.._normal.ext', 'normal.ext'),
		);
	}

	/**
	 * Method testsanitizeUploadFileName
	 * @test
	 * @dataProvider sanitizeUploadFileNameProvider
	 */
	public function testsanitizeUploadFileName($file_name, $expected, $msg) {
		global $upload_badext;
		$this->assertEquals($expected, sanitizeUploadFileName($file_name, $upload_badext), $msg);
	}

	/**
	 * Method get_group_arrayProvider
	 * params
	 */
	public function get_group_arrayProvider() {
		$grp1 = array(
			2 => 'Team Selling',
			3 => 'Marketing Group',
			4 => 'Support Group',
			'' => '',
		);
		$grp2 = array(
			2 => 'Team Selling',
			3 => 'Marketing Group',
			4 => 'Support Group',
		);
		$grp111 = array(
			3 => 'Marketing Group',
			4 => 'Support Group',
			'' => '',
		);
		$grp112 = array(
			3 => 'Marketing Group',
			4 => 'Support Group',
		);
		return array(
			array(1, true, 'Active', '', '', $grp1),
			array(1, true, 'Active', '', 'private', array('' => '')),
			array(1, false, 'Active', '', '', $grp2),
			array(1, false, 'Active', '', 'private', array()),
			array(11, true, 'Active', '', '', $grp1),
			array(11, true, 'Active', '', 'private', $grp111),
			array(11, false, 'Active', '', '', $grp2),
			array(11, false, 'Active', '', 'private', $grp112),
			array(5, true, 'Active', '', '', $grp1),
			array(5, true, 'Active', '', 'private', $grp1),
			array(5, false, 'Active', '', '', $grp2),
			array(5, false, 'Active', '', 'private', $grp2),
			array(9, true, 'Active', '', '', $grp1),
			array(9, true, 'Active', '', 'private', $grp1),
			array(9, false, 'Active', '', '', $grp2),
			array(9, false, 'Active', '', 'private', $grp2),
		);
	}

	/**
	 * Method testget_group_array
	 * @test
	 * @dataProvider get_group_arrayProvider
	 */
	public function testget_group_array($userid, $add_blank, $status, $assigned_user, $private, $expected) {
		global $current_user;
		$hold_user = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($userid);
		$current_user = $user;
		$actual=get_group_array($add_blank, $status, $assigned_user, $private, true);
		$this->assertEquals($expected, $actual, 'testget_group_array');
		$current_user = $hold_user;
	}

	/**
	 * Method getColumnFieldsProvider
	 * params
	 */
	public function getColumnFieldsProvider() {
		$accfinfo = array(
			'accountname' => '',
			'account_no' => '',
			'phone' => '',
			'website' => '',
			'fax' => '',
			'tickersymbol' => '',
			'otherphone' => '',
			'account_id' => '',
			'email1' => '',
			'employees' => '',
			'email2' => '',
			'ownership' => '',
			'rating' => '',
			'industry' => '',
			'siccode' => '',
			'accounttype' => '',
			'annual_revenue' => '',
			'emailoptout' => '',
			'notify_owner' => '',
			'assigned_user_id' => '',
			'createdtime' => '',
			'modifiedtime' => '',
			'modifiedby' => '',
			'bill_street' => '',
			'ship_street' => '',
			'bill_city' => '',
			'ship_city' => '',
			'bill_state' => '',
			'ship_state' => '',
			'bill_code' => '',
			'ship_code' => '',
			'bill_country' => '',
			'ship_country' => '',
			'bill_pobox' => '',
			'ship_pobox' => '',
			'description' => '',
			'campaignrelstatus' => '',
			'cf_718' => '',
			'cf_719' => '',
			'cf_720' => '',
			'cf_721' => '',
			'cf_722' => '',
			'cf_723' => '',
			'cf_724' => '',
			'cf_725' => '',
			'cf_726' => '',
			'cf_727' => '',
			'cf_728' => '',
			'cf_729' => '',
			'cf_730' => '',
			'cf_731' => '',
			'cf_732' => '',
			'isconvertedfromlead' => '',
			'convertedfromlead' => '',
			'created_user_id' => '',
		);
		$accfinfoc = array(
			0 => array(
			  'tabid' => '6',
			  'fieldid' => '1',
			  'fieldname' => 'accountname',
			  'fieldlabel' => 'Account Name',
			  'columnname' => 'accountname',
			  'tablename' => 'vtiger_account',
			  'uitype' => '2',
			  'typeofdata' => 'V~M',
			  'presence' => '0',
			),
			1 => array(
			  'tabid' => '6',
			  'fieldid' => '2',
			  'fieldname' => 'account_no',
			  'fieldlabel' => 'Account No',
			  'columnname' => 'account_no',
			  'tablename' => 'vtiger_account',
			  'uitype' => '4',
			  'typeofdata' => 'V~O',
			  'presence' => '0',
			),
			2 => array(
			  'tabid' => '6',
			  'fieldid' => '3',
			  'fieldname' => 'phone',
			  'fieldlabel' => 'Phone',
			  'columnname' => 'phone',
			  'tablename' => 'vtiger_account',
			  'uitype' => '11',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			3 => array(
			  'tabid' => '6',
			  'fieldid' => '4',
			  'fieldname' => 'website',
			  'fieldlabel' => 'Website',
			  'columnname' => 'website',
			  'tablename' => 'vtiger_account',
			  'uitype' => '17',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			4 => array(
			  'tabid' => '6',
			  'fieldid' => '5',
			  'fieldname' => 'fax',
			  'fieldlabel' => 'Fax',
			  'columnname' => 'fax',
			  'tablename' => 'vtiger_account',
			  'uitype' => '11',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			5 => array(
			  'tabid' => '6',
			  'fieldid' => '6',
			  'fieldname' => 'tickersymbol',
			  'fieldlabel' => 'Ticker Symbol',
			  'columnname' => 'tickersymbol',
			  'tablename' => 'vtiger_account',
			  'uitype' => '1',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			6 => array(
			  'tabid' => '6',
			  'fieldid' => '7',
			  'fieldname' => 'otherphone',
			  'fieldlabel' => 'Other Phone',
			  'columnname' => 'otherphone',
			  'tablename' => 'vtiger_account',
			  'uitype' => '11',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			7 => array(
			  'tabid' => '6',
			  'fieldid' => '8',
			  'fieldname' => 'account_id',
			  'fieldlabel' => 'Member Of',
			  'columnname' => 'parentid',
			  'tablename' => 'vtiger_account',
			  'uitype' => '10',
			  'typeofdata' => 'I~O',
			  'presence' => '2',
			),
			8 => array(
			  'tabid' => '6',
			  'fieldid' => '9',
			  'fieldname' => 'email1',
			  'fieldlabel' => 'Email',
			  'columnname' => 'email1',
			  'tablename' => 'vtiger_account',
			  'uitype' => '13',
			  'typeofdata' => 'E~O',
			  'presence' => '2',
			),
			9 => array(
			  'tabid' => '6',
			  'fieldid' => '10',
			  'fieldname' => 'employees',
			  'fieldlabel' => 'Employees',
			  'columnname' => 'employees',
			  'tablename' => 'vtiger_account',
			  'uitype' => '7',
			  'typeofdata' => 'I~O',
			  'presence' => '2',
			),
			10 => array(
			  'tabid' => '6',
			  'fieldid' => '11',
			  'fieldname' => 'email2',
			  'fieldlabel' => 'Other Email',
			  'columnname' => 'email2',
			  'tablename' => 'vtiger_account',
			  'uitype' => '13',
			  'typeofdata' => 'E~O',
			  'presence' => '2',
			),
			11 => array(
			  'tabid' => '6',
			  'fieldid' => '12',
			  'fieldname' => 'ownership',
			  'fieldlabel' => 'Ownership',
			  'columnname' => 'ownership',
			  'tablename' => 'vtiger_account',
			  'uitype' => '1',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			12 => array(
			  'tabid' => '6',
			  'fieldid' => '13',
			  'fieldname' => 'rating',
			  'fieldlabel' => 'Rating',
			  'columnname' => 'rating',
			  'tablename' => 'vtiger_account',
			  'uitype' => '15',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			13 => array(
			  'tabid' => '6',
			  'fieldid' => '14',
			  'fieldname' => 'industry',
			  'fieldlabel' => 'industry',
			  'columnname' => 'industry',
			  'tablename' => 'vtiger_account',
			  'uitype' => '15',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			14 => array(
			  'tabid' => '6',
			  'fieldid' => '15',
			  'fieldname' => 'siccode',
			  'fieldlabel' => 'SIC Code',
			  'columnname' => 'siccode',
			  'tablename' => 'vtiger_account',
			  'uitype' => '1',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			15 => array(
			  'tabid' => '6',
			  'fieldid' => '16',
			  'fieldname' => 'accounttype',
			  'fieldlabel' => 'Type',
			  'columnname' => 'account_type',
			  'tablename' => 'vtiger_account',
			  'uitype' => '15',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			16 => array(
			  'tabid' => '6',
			  'fieldid' => '17',
			  'fieldname' => 'annual_revenue',
			  'fieldlabel' => 'Annual Revenue',
			  'columnname' => 'annualrevenue',
			  'tablename' => 'vtiger_account',
			  'uitype' => '71',
			  'typeofdata' => 'N~O',
			  'presence' => '2',
			),
			17 => array(
			  'tabid' => '6',
			  'fieldid' => '18',
			  'fieldname' => 'emailoptout',
			  'fieldlabel' => 'Email Opt Out',
			  'columnname' => 'emailoptout',
			  'tablename' => 'vtiger_account',
			  'uitype' => '56',
			  'typeofdata' => 'C~O',
			  'presence' => '2',
			),
			18 => array(
			  'tabid' => '6',
			  'fieldid' => '19',
			  'fieldname' => 'notify_owner',
			  'fieldlabel' => 'Notify Owner',
			  'columnname' => 'notify_owner',
			  'tablename' => 'vtiger_account',
			  'uitype' => '56',
			  'typeofdata' => 'C~O',
			  'presence' => '2',
			),
			19 => array(
			  'tabid' => '6',
			  'fieldid' => '20',
			  'fieldname' => 'assigned_user_id',
			  'fieldlabel' => 'Assigned To',
			  'columnname' => 'smownerid',
			  'tablename' => 'vtiger_crmentity',
			  'uitype' => '53',
			  'typeofdata' => 'V~M',
			  'presence' => '0',
			),
			20 => array(
			  'tabid' => '6',
			  'fieldid' => '21',
			  'fieldname' => 'createdtime',
			  'fieldlabel' => 'Created Time',
			  'columnname' => 'createdtime',
			  'tablename' => 'vtiger_crmentity',
			  'uitype' => '70',
			  'typeofdata' => 'DT~O',
			  'presence' => '0',
			),
			21 => array(
			  'tabid' => '6',
			  'fieldid' => '22',
			  'fieldname' => 'modifiedtime',
			  'fieldlabel' => 'Modified Time',
			  'columnname' => 'modifiedtime',
			  'tablename' => 'vtiger_crmentity',
			  'uitype' => '70',
			  'typeofdata' => 'DT~O',
			  'presence' => '0',
			),
			22 => array(
			  'tabid' => '6',
			  'fieldid' => '23',
			  'fieldname' => 'modifiedby',
			  'fieldlabel' => 'Last Modified By',
			  'columnname' => 'modifiedby',
			  'tablename' => 'vtiger_crmentity',
			  'uitype' => '52',
			  'typeofdata' => 'V~O',
			  'presence' => '0',
			),
			23 => array(
			  'tabid' => '6',
			  'fieldid' => '24',
			  'fieldname' => 'bill_street',
			  'fieldlabel' => 'Billing Address',
			  'columnname' => 'bill_street',
			  'tablename' => 'vtiger_accountbillads',
			  'uitype' => '21',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			24 => array(
			  'tabid' => '6',
			  'fieldid' => '25',
			  'fieldname' => 'ship_street',
			  'fieldlabel' => 'Shipping Address',
			  'columnname' => 'ship_street',
			  'tablename' => 'vtiger_accountshipads',
			  'uitype' => '21',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			25 => array(
			  'tabid' => '6',
			  'fieldid' => '26',
			  'fieldname' => 'bill_city',
			  'fieldlabel' => 'Billing City',
			  'columnname' => 'bill_city',
			  'tablename' => 'vtiger_accountbillads',
			  'uitype' => '1',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			26 => array(
			  'tabid' => '6',
			  'fieldid' => '27',
			  'fieldname' => 'ship_city',
			  'fieldlabel' => 'Shipping City',
			  'columnname' => 'ship_city',
			  'tablename' => 'vtiger_accountshipads',
			  'uitype' => '1',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			27 => array(
			  'tabid' => '6',
			  'fieldid' => '28',
			  'fieldname' => 'bill_state',
			  'fieldlabel' => 'Billing State',
			  'columnname' => 'bill_state',
			  'tablename' => 'vtiger_accountbillads',
			  'uitype' => '1',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			28 => array(
			  'tabid' => '6',
			  'fieldid' => '29',
			  'fieldname' => 'ship_state',
			  'fieldlabel' => 'Shipping State',
			  'columnname' => 'ship_state',
			  'tablename' => 'vtiger_accountshipads',
			  'uitype' => '1',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			29 => array(
			  'tabid' => '6',
			  'fieldid' => '30',
			  'fieldname' => 'bill_code',
			  'fieldlabel' => 'Billing Code',
			  'columnname' => 'bill_code',
			  'tablename' => 'vtiger_accountbillads',
			  'uitype' => '1',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			30 => array(
			  'tabid' => '6',
			  'fieldid' => '31',
			  'fieldname' => 'ship_code',
			  'fieldlabel' => 'Shipping Code',
			  'columnname' => 'ship_code',
			  'tablename' => 'vtiger_accountshipads',
			  'uitype' => '1',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			31 => array(
			  'tabid' => '6',
			  'fieldid' => '32',
			  'fieldname' => 'bill_country',
			  'fieldlabel' => 'Billing Country',
			  'columnname' => 'bill_country',
			  'tablename' => 'vtiger_accountbillads',
			  'uitype' => '1',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			32 => array(
			  'tabid' => '6',
			  'fieldid' => '33',
			  'fieldname' => 'ship_country',
			  'fieldlabel' => 'Shipping Country',
			  'columnname' => 'ship_country',
			  'tablename' => 'vtiger_accountshipads',
			  'uitype' => '1',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			33 => array(
			  'tabid' => '6',
			  'fieldid' => '34',
			  'fieldname' => 'bill_pobox',
			  'fieldlabel' => 'Billing Po Box',
			  'columnname' => 'bill_pobox',
			  'tablename' => 'vtiger_accountbillads',
			  'uitype' => '1',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			34 => array(
			  'tabid' => '6',
			  'fieldid' => '35',
			  'fieldname' => 'ship_pobox',
			  'fieldlabel' => 'Shipping Po Box',
			  'columnname' => 'ship_pobox',
			  'tablename' => 'vtiger_accountshipads',
			  'uitype' => '1',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			35 => array(
			  'tabid' => '6',
			  'fieldid' => '36',
			  'fieldname' => 'description',
			  'fieldlabel' => 'Description',
			  'columnname' => 'description',
			  'tablename' => 'vtiger_crmentity',
			  'uitype' => '19',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			36 => array(
			  'tabid' => '6',
			  'fieldid' => '152',
			  'fieldname' => 'campaignrelstatus',
			  'fieldlabel' => 'Status',
			  'columnname' => 'campaignrelstatus',
			  'tablename' => 'vtiger_campaignrelstatus',
			  'uitype' => '16',
			  'typeofdata' => 'V~O',
			  'presence' => '0',
			),
			37 => array(
			  'tabid' => '6',
			  'fieldid' => '718',
			  'fieldname' => 'cf_718',
			  'fieldlabel' => 'Text',
			  'columnname' => 'cf_718',
			  'tablename' => 'vtiger_accountscf',
			  'uitype' => '1',
			  'typeofdata' => 'V~O~LE~50',
			  'presence' => '2',
			),
			38 => array(
			  'tabid' => '6',
			  'fieldid' => '719',
			  'fieldname' => 'cf_719',
			  'fieldlabel' => 'Number',
			  'columnname' => 'cf_719',
			  'tablename' => 'vtiger_accountscf',
			  'uitype' => '7',
			  'typeofdata' => 'NN~O~8,2',
			  'presence' => '2',
			),
			39 => array(
			  'tabid' => '6',
			  'fieldid' => '720',
			  'fieldname' => 'cf_720',
			  'fieldlabel' => 'Percent',
			  'columnname' => 'cf_720',
			  'tablename' => 'vtiger_accountscf',
			  'uitype' => '9',
			  'typeofdata' => 'N~O~2~2',
			  'presence' => '2',
			),
			40 => array(
			  'tabid' => '6',
			  'fieldid' => '721',
			  'fieldname' => 'cf_721',
			  'fieldlabel' => 'Currency',
			  'columnname' => 'cf_721',
			  'tablename' => 'vtiger_accountscf',
			  'uitype' => '71',
			  'typeofdata' => 'N~O~8,2',
			  'presence' => '2',
			),
			41 => array(
			  'tabid' => '6',
			  'fieldid' => '722',
			  'fieldname' => 'cf_722',
			  'fieldlabel' => 'Date',
			  'columnname' => 'cf_722',
			  'tablename' => 'vtiger_accountscf',
			  'uitype' => '5',
			  'typeofdata' => 'D~O',
			  'presence' => '2',
			),
			42 => array(
			  'tabid' => '6',
			  'fieldid' => '723',
			  'fieldname' => 'cf_723',
			  'fieldlabel' => 'Emailcf',
			  'columnname' => 'cf_723',
			  'tablename' => 'vtiger_accountscf',
			  'uitype' => '13',
			  'typeofdata' => 'E~O',
			  'presence' => '2',
			),
			43 => array(
			  'tabid' => '6',
			  'fieldid' => '724',
			  'fieldname' => 'cf_724',
			  'fieldlabel' => 'Phonecf',
			  'columnname' => 'cf_724',
			  'tablename' => 'vtiger_accountscf',
			  'uitype' => '11',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			44 => array(
			  'tabid' => '6',
			  'fieldid' => '725',
			  'fieldname' => 'cf_725',
			  'fieldlabel' => 'URL',
			  'columnname' => 'cf_725',
			  'tablename' => 'vtiger_accountscf',
			  'uitype' => '17',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			45 => array(
			  'tabid' => '6',
			  'fieldid' => '726',
			  'fieldname' => 'cf_726',
			  'fieldlabel' => 'Checkbox',
			  'columnname' => 'cf_726',
			  'tablename' => 'vtiger_accountscf',
			  'uitype' => '56',
			  'typeofdata' => 'C~O',
			  'presence' => '2',
			),
			46 => array(
			  'tabid' => '6',
			  'fieldid' => '727',
			  'fieldname' => 'cf_727',
			  'fieldlabel' => 'skypecf',
			  'columnname' => 'cf_727',
			  'tablename' => 'vtiger_accountscf',
			  'uitype' => '85',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			47 => array(
			  'tabid' => '6',
			  'fieldid' => '728',
			  'fieldname' => 'cf_728',
			  'fieldlabel' => 'Time',
			  'columnname' => 'cf_728',
			  'tablename' => 'vtiger_accountscf',
			  'uitype' => '14',
			  'typeofdata' => 'T~O',
			  'presence' => '2',
			),
			48 => array(
			  'tabid' => '6',
			  'fieldid' => '729',
			  'fieldname' => 'cf_729',
			  'fieldlabel' => 'PLMain',
			  'columnname' => 'cf_729',
			  'tablename' => 'vtiger_accountscf',
			  'uitype' => '15',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			49 => array(
			  'tabid' => '6',
			  'fieldid' => '730',
			  'fieldname' => 'cf_730',
			  'fieldlabel' => 'PLDep1',
			  'columnname' => 'cf_730',
			  'tablename' => 'vtiger_accountscf',
			  'uitype' => '15',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			50 => array(
			  'tabid' => '6',
			  'fieldid' => '731',
			  'fieldname' => 'cf_731',
			  'fieldlabel' => 'PLDep2',
			  'columnname' => 'cf_731',
			  'tablename' => 'vtiger_accountscf',
			  'uitype' => '15',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			51 => array(
			  'tabid' => '6',
			  'fieldid' => '732',
			  'fieldname' => 'cf_732',
			  'fieldlabel' => 'Planets',
			  'columnname' => 'cf_732',
			  'tablename' => 'vtiger_accountscf',
			  'uitype' => '33',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			52 => array(
			  'tabid' => '6',
			  'fieldid' => '752',
			  'fieldname' => 'isconvertedfromlead',
			  'fieldlabel' => 'Is Converted From Lead',
			  'columnname' => 'isconvertedfromlead',
			  'tablename' => 'vtiger_account',
			  'uitype' => '56',
			  'typeofdata' => 'C~O',
			  'presence' => '2',
			),
			53 => array(
			  'tabid' => '6',
			  'fieldid' => '753',
			  'fieldname' => 'convertedfromlead',
			  'fieldlabel' => 'Converted From Lead',
			  'columnname' => 'convertedfromlead',
			  'tablename' => 'vtiger_account',
			  'uitype' => '10',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			54 => array(
			  'tabid' => '6',
			  'fieldid' => '764',
			  'fieldname' => 'created_user_id',
			  'fieldlabel' => 'Created By',
			  'columnname' => 'smcreatorid',
			  'tablename' => 'vtiger_crmentity',
			  'uitype' => '52',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
		);
		$astfinfo = array(
			'asset_no' => '',
			'product' => '',
			'serialnumber' => '',
			'datesold' => '',
			'dateinservice' => '',
			'assetstatus' => '',
			'tagnumber' => '',
			'invoiceid' => '',
			'shippingmethod' => '',
			'shippingtrackingnumber' => '',
			'assigned_user_id' => '',
			'assetname' => '',
			'account' => '',
			'createdtime' => '',
			'modifiedtime' => '',
			'modifiedby' => '',
			'description' => '',
			'created_user_id' => '',
		);
		$astfinfoc = array(
			0 => array(
			  'tabid' => '43',
			  'fieldid' => '602',
			  'fieldname' => 'asset_no',
			  'fieldlabel' => 'Asset No',
			  'columnname' => 'asset_no',
			  'tablename' => 'vtiger_assets',
			  'uitype' => '4',
			  'typeofdata' => 'V~O',
			  'presence' => '0',
			),
			1 => array(
			  'tabid' => '43',
			  'fieldid' => '603',
			  'fieldname' => 'product',
			  'fieldlabel' => 'Product Name',
			  'columnname' => 'product',
			  'tablename' => 'vtiger_assets',
			  'uitype' => '10',
			  'typeofdata' => 'V~M',
			  'presence' => '2',
			),
			2 => array(
			  'tabid' => '43',
			  'fieldid' => '604',
			  'fieldname' => 'serialnumber',
			  'fieldlabel' => 'Serial Number',
			  'columnname' => 'serialnumber',
			  'tablename' => 'vtiger_assets',
			  'uitype' => '2',
			  'typeofdata' => 'V~M',
			  'presence' => '2',
			),
			3 => array(
			  'tabid' => '43',
			  'fieldid' => '605',
			  'fieldname' => 'datesold',
			  'fieldlabel' => 'Date Sold',
			  'columnname' => 'datesold',
			  'tablename' => 'vtiger_assets',
			  'uitype' => '5',
			  'typeofdata' => 'D~M',
			  'presence' => '2',
			),
			4 => array(
			  'tabid' => '43',
			  'fieldid' => '606',
			  'fieldname' => 'dateinservice',
			  'fieldlabel' => 'Date in Service',
			  'columnname' => 'dateinservice',
			  'tablename' => 'vtiger_assets',
			  'uitype' => '5',
			  'typeofdata' => 'D~M~OTH~GE~datesold~Date Sold',
			  'presence' => '2',
			),
			5 => array(
			  'tabid' => '43',
			  'fieldid' => '607',
			  'fieldname' => 'assetstatus',
			  'fieldlabel' => 'Status',
			  'columnname' => 'assetstatus',
			  'tablename' => 'vtiger_assets',
			  'uitype' => '15',
			  'typeofdata' => 'V~M',
			  'presence' => '2',
			),
			6 => array(
			  'tabid' => '43',
			  'fieldid' => '608',
			  'fieldname' => 'tagnumber',
			  'fieldlabel' => 'Tag Number',
			  'columnname' => 'tagnumber',
			  'tablename' => 'vtiger_assets',
			  'uitype' => '2',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			7 => array(
			  'tabid' => '43',
			  'fieldid' => '609',
			  'fieldname' => 'invoiceid',
			  'fieldlabel' => 'Invoice Name',
			  'columnname' => 'invoiceid',
			  'tablename' => 'vtiger_assets',
			  'uitype' => '10',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			8 => array(
			  'tabid' => '43',
			  'fieldid' => '610',
			  'fieldname' => 'shippingmethod',
			  'fieldlabel' => 'Shipping Method',
			  'columnname' => 'shippingmethod',
			  'tablename' => 'vtiger_assets',
			  'uitype' => '2',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			9 => array(
			  'tabid' => '43',
			  'fieldid' => '611',
			  'fieldname' => 'shippingtrackingnumber',
			  'fieldlabel' => 'Shipping Tracking Number',
			  'columnname' => 'shippingtrackingnumber',
			  'tablename' => 'vtiger_assets',
			  'uitype' => '2',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			10 => array(
			  'tabid' => '43',
			  'fieldid' => '612',
			  'fieldname' => 'assigned_user_id',
			  'fieldlabel' => 'Assigned To',
			  'columnname' => 'smownerid',
			  'tablename' => 'vtiger_crmentity',
			  'uitype' => '53',
			  'typeofdata' => 'V~M',
			  'presence' => '2',
			),
			11 => array(
			  'tabid' => '43',
			  'fieldid' => '613',
			  'fieldname' => 'assetname',
			  'fieldlabel' => 'Asset Name',
			  'columnname' => 'assetname',
			  'tablename' => 'vtiger_assets',
			  'uitype' => '1',
			  'typeofdata' => 'V~M',
			  'presence' => '0',
			),
			12 => array(
			  'tabid' => '43',
			  'fieldid' => '614',
			  'fieldname' => 'account',
			  'fieldlabel' => 'Customer Name',
			  'columnname' => 'account',
			  'tablename' => 'vtiger_assets',
			  'uitype' => '10',
			  'typeofdata' => 'V~M',
			  'presence' => '2',
			),
			13 => array(
			  'tabid' => '43',
			  'fieldid' => '615',
			  'fieldname' => 'createdtime',
			  'fieldlabel' => 'Created Time',
			  'columnname' => 'createdtime',
			  'tablename' => 'vtiger_crmentity',
			  'uitype' => '70',
			  'typeofdata' => 'DT~O',
			  'presence' => '0',
			),
			14 => array(
			  'tabid' => '43',
			  'fieldid' => '616',
			  'fieldname' => 'modifiedtime',
			  'fieldlabel' => 'Modified Time',
			  'columnname' => 'modifiedtime',
			  'tablename' => 'vtiger_crmentity',
			  'uitype' => '70',
			  'typeofdata' => 'DT~O',
			  'presence' => '0',
			),
			15 => array(
			  'tabid' => '43',
			  'fieldid' => '617',
			  'fieldname' => 'modifiedby',
			  'fieldlabel' => 'Last Modified By',
			  'columnname' => 'modifiedby',
			  'tablename' => 'vtiger_crmentity',
			  'uitype' => '52',
			  'typeofdata' => 'V~O',
			  'presence' => '0',
			),
			16 => array(
			  'tabid' => '43',
			  'fieldid' => '618',
			  'fieldname' => 'description',
			  'fieldlabel' => 'Notes',
			  'columnname' => 'description',
			  'tablename' => 'vtiger_crmentity',
			  'uitype' => '19',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
			17 => array(
			  'tabid' => '43',
			  'fieldid' => '781',
			  'fieldname' => 'created_user_id',
			  'fieldlabel' => 'Created By',
			  'columnname' => 'smcreatorid',
			  'tablename' => 'vtiger_crmentity',
			  'uitype' => '52',
			  'typeofdata' => 'V~O',
			  'presence' => '2',
			),
		);
		$hdfinfo = array(
			'ticket_no' => '',
			'assigned_user_id' => '',
			'parent_id' => '',
			'ticketpriorities' => '',
			'product_id' => '',
			'ticketseverities' => '',
			'ticketstatus' => '',
			'ticketcategories' => '',
			'update_log' => '',
			'hours' => '',
			'days' => '',
			'createdtime' => '',
			'modifiedtime' => '',
			'from_portal' => '',
			'modifiedby' => '',
			'ticket_title' => '',
			'description' => '',
			'solution' => '',
			'comments' => '',
			'email' => '',
			'from_mailscanner' => '',
			'commentadded' => '',
			'created_user_id' => '',
		);
		$hdfinfoc = array(
			0 =>  array(
				'tabid' => '13',
				'fieldid' => '155',
				'fieldname' => 'ticket_no',
				'fieldlabel' => 'Ticket No',
				'columnname' => 'ticket_no',
				'tablename' => 'vtiger_troubletickets',
				'uitype' => '4',
				'typeofdata' => 'V~O',
				'presence' => '0',
			),
			1 =>  array(
				'tabid' => '13',
				'fieldid' => '156',
				'fieldname' => 'assigned_user_id',
				'fieldlabel' => 'Assigned To',
				'columnname' => 'smownerid',
				'tablename' => 'vtiger_crmentity',
				'uitype' => '53',
				'typeofdata' => 'V~M',
				'presence' => '0',
			),
			2 =>  array(
				'tabid' => '13',
				'fieldid' => '157',
				'fieldname' => 'parent_id',
				'fieldlabel' => 'Related To',
				'columnname' => 'parent_id',
				'tablename' => 'vtiger_troubletickets',
				'uitype' => '10',
				'typeofdata' => 'I~O',
				'presence' => '0',
			),
			3 =>  array(
				'tabid' => '13',
				'fieldid' => '158',
				'fieldname' => 'ticketpriorities',
				'fieldlabel' => 'Priority',
				'columnname' => 'priority',
				'tablename' => 'vtiger_troubletickets',
				'uitype' => '15',
				'typeofdata' => 'V~O',
				'presence' => '2',
			),
			4 =>  array(
				'tabid' => '13',
				'fieldid' => '159',
				'fieldname' => 'product_id',
				'fieldlabel' => 'Product Name',
				'columnname' => 'product_id',
				'tablename' => 'vtiger_troubletickets',
				'uitype' => '10',
				'typeofdata' => 'I~O',
				'presence' => '2',
			),
			5 =>  array(
				'tabid' => '13',
				'fieldid' => '160',
				'fieldname' => 'ticketseverities',
				'fieldlabel' => 'Severity',
				'columnname' => 'severity',
				'tablename' => 'vtiger_troubletickets',
				'uitype' => '15',
				'typeofdata' => 'V~O',
				'presence' => '2',
			),
			6 =>  array(
				'tabid' => '13',
				'fieldid' => '161',
				'fieldname' => 'ticketstatus',
				'fieldlabel' => 'Status',
				'columnname' => 'status',
				'tablename' => 'vtiger_troubletickets',
				'uitype' => '15',
				'typeofdata' => 'V~M',
				'presence' => '2',
			),
			7 =>  array(
				'tabid' => '13',
				'fieldid' => '162',
				'fieldname' => 'ticketcategories',
				'fieldlabel' => 'Category',
				'columnname' => 'category',
				'tablename' => 'vtiger_troubletickets',
				'uitype' => '15',
				'typeofdata' => 'V~O',
				'presence' => '2',
			),
			8 =>  array(
				'tabid' => '13',
				'fieldid' => '163',
				'fieldname' => 'update_log',
				'fieldlabel' => 'Update History',
				'columnname' => 'update_log',
				'tablename' => 'vtiger_troubletickets',
				'uitype' => '19',
				'typeofdata' => 'V~O',
				'presence' => '0',
			),
			9 =>  array(
				'tabid' => '13',
				'fieldid' => '164',
				'fieldname' => 'hours',
				'fieldlabel' => 'Hours',
				'columnname' => 'hours',
				'tablename' => 'vtiger_troubletickets',
				'uitype' => '7',
				'typeofdata' => 'N~O',
				'presence' => '2',
			),
			10 => array(
				'tabid' => '13',
				'fieldid' => '165',
				'fieldname' => 'days',
				'fieldlabel' => 'Days',
				'columnname' => 'days',
				'tablename' => 'vtiger_troubletickets',
				'uitype' => '1',
				'typeofdata' => 'I~O',
				'presence' => '2',
			),
			11 => array(
				'tabid' => '13',
				'fieldid' => '166',
				'fieldname' => 'createdtime',
				'fieldlabel' => 'Created Time',
				'columnname' => 'createdtime',
				'tablename' => 'vtiger_crmentity',
				'uitype' => '70',
				'typeofdata' => 'DT~O',
				'presence' => '0',
			),
			12 => array(
				'tabid' => '13',
				'fieldid' => '167',
				'fieldname' => 'modifiedtime',
				'fieldlabel' => 'Modified Time',
				'columnname' => 'modifiedtime',
				'tablename' => 'vtiger_crmentity',
				'uitype' => '70',
				'typeofdata' => 'DT~O',
				'presence' => '0',
			),
			13 => array(
				'tabid' => '13',
				'fieldid' => '168',
				'fieldname' => 'from_portal',
				'fieldlabel' => 'From Portal',
				'columnname' => 'from_portal',
				'tablename' => 'vtiger_troubletickets',
				'uitype' => '56',
				'typeofdata' => 'C~O',
				'presence' => '0',
			),
			14 => array(
				'tabid' => '13',
				'fieldid' => '169',
				'fieldname' => 'modifiedby',
				'fieldlabel' => 'Last Modified By',
				'columnname' => 'modifiedby',
				'tablename' => 'vtiger_crmentity',
				'uitype' => '52',
				'typeofdata' => 'V~O',
				'presence' => '0',
			),
			15 => array(
				'tabid' => '13',
				'fieldid' => '170',
				'fieldname' => 'ticket_title',
				'fieldlabel' => 'Title',
				'columnname' => 'title',
				'tablename' => 'vtiger_troubletickets',
				'uitype' => '21',
				'typeofdata' => 'V~M',
				'presence' => '0',
			),
			16 => array(
				'tabid' => '13',
				'fieldid' => '171',
				'fieldname' => 'description',
				'fieldlabel' => 'Description',
				'columnname' => 'description',
				'tablename' => 'vtiger_crmentity',
				'uitype' => '19',
				'typeofdata' => 'V~O',
				'presence' => '2',
			),
			17 => array(
				'tabid' => '13',
				'fieldid' => '172',
				'fieldname' => 'solution',
				'fieldlabel' => 'Solution',
				'columnname' => 'solution',
				'tablename' => 'vtiger_troubletickets',
				'uitype' => '19',
				'typeofdata' => 'V~O',
				'presence' => '0',
			),
			18 => array(
				'tabid' => '13',
				'fieldid' => '173',
				'fieldname' => 'comments',
				'fieldlabel' => 'Add Comment',
				'columnname' => 'comments',
				'tablename' => 'vtiger_ticketcomments',
				'uitype' => '19',
				'typeofdata' => 'V~O',
				'presence' => '0',
			),
			19 => array(
				'tabid' => '13',
				'fieldid' => '677',
				'fieldname' => 'email',
				'fieldlabel' => 'Email',
				'columnname' => 'email',
				'tablename' => 'vtiger_troubletickets',
				'uitype' => '13',
				'typeofdata' => 'E~O',
				'presence' => '2',
			),
			20 => array(
				'tabid' => '13',
				'fieldid' => '717',
				'fieldname' => 'from_mailscanner',
				'fieldlabel' => 'From mailscanner',
				'columnname' => 'from_mailscanner',
				'tablename' => 'vtiger_troubletickets',
				'uitype' => '56',
				'typeofdata' => 'C~O',
				'presence' => '0',
			),
			21 => array(
				'tabid' => '13',
				'fieldid' => '758',
				'fieldname' => 'commentadded',
				'fieldlabel' => 'Comment Added',
				'columnname' => 'commentadded',
				'tablename' => 'vtiger_troubletickets',
				'uitype' => '56',
				'typeofdata' => 'C~O',
				'presence' => '2',
			),
			22 => array(
				'tabid' => '13',
				'fieldid' => '767',
				'fieldname' => 'created_user_id',
				'fieldlabel' => 'Created By',
				'columnname' => 'smcreatorid',
				'tablename' => 'vtiger_crmentity',
				'uitype' => '52',
				'typeofdata' => 'V~O',
				'presence' => '2',
			),
		);
		$pbxfinfo = array(
			'callfrom' => '',
			'callto' => '',
			'timeofcall' => '',
			'status' => '',
			'pbxuuid' => '',
		);
		$pbxfinfoc = array(
			0 => array(
				'tabid' => '36',
				'fieldid' => '525',
				'fieldname' => 'callfrom',
				'fieldlabel' => 'Call From',
				'columnname' => 'callfrom',
				'tablename' => 'vtiger_pbxmanager',
				'uitype' => '2',
				'typeofdata' => 'V~M',
				'presence' => '0',
			),
			1 => array(
				'tabid' => '36',
				'fieldid' => '526',
				'fieldname' => 'callto',
				'fieldlabel' => 'Call To',
				'columnname' => 'callto',
				'tablename' => 'vtiger_pbxmanager',
				'uitype' => '2',
				'typeofdata' => 'V~M',
				'presence' => '0',
			),
			2 => array(
				'tabid' => '36',
				'fieldid' => '527',
				'fieldname' => 'timeofcall',
				'fieldlabel' => 'Time Of Call',
				'columnname' => 'timeofcall',
				'tablename' => 'vtiger_pbxmanager',
				'uitype' => '50',
				'typeofdata' => 'V~O',
				'presence' => '0',
			),
			3 => array(
				'tabid' => '36',
				'fieldid' => '528',
				'fieldname' => 'status',
				'fieldlabel' => 'Status',
				'columnname' => 'status',
				'tablename' => 'vtiger_pbxmanager',
				'uitype' => '16',
				'typeofdata' => 'V~O',
				'presence' => '0',
			),
			4 => array(
				'tabid' => '36',
				'fieldid' => '1134',
				'fieldname' => 'pbxuuid',
				'fieldlabel' => 'PBX UUID',
				'columnname' => 'pbxuuid',
				'tablename' => 'vtiger_pbxmanager',
				'uitype' => '1',
				'typeofdata' => 'V~O',
				'presence' => '2',
			),
		);
		$eoofinfo = array();
		$eoofinfoc = false;
		return array(
			array('Accounts', $accfinfo, $accfinfoc),
			array('Assets', $astfinfo, $astfinfoc),
			array('HelpDesk', $hdfinfo, $hdfinfoc),
			array('PBXmanager', $pbxfinfo, $pbxfinfoc),
			array('EtiquetasOO', $eoofinfo, $eoofinfoc),
		);
	}

	/**
	 * Method testgetColumnFields
	 * @test
	 * @dataProvider getColumnFieldsProvider
	 */
	public function testgetColumnFields($module, $expected, $expectedc) {
		$this->assertEquals($expected, getColumnFields($module), 'getColumnFields '.$module);
		$cachedModuleFields = VTCacheUtils::lookupFieldInfo_Module($module);
		$this->assertEquals($expectedc, $cachedModuleFields, 'lookupFieldInfo_Module cache '.$module);
	}

	/**
	 * Method getModuleSequenceFieldProvider
	 * params
	 */
	public function getModuleSequenceFieldProvider() {
		return array(
			array('Assets', array('name'=>'asset_no','column'=>'asset_no','label'=>'Asset No')),
			array('Accounts', array('name'=>'account_no','column'=>'account_no','label'=>'Account No')),
			array('HelpDesk', array('name'=>'ticket_no','column'=>'ticket_no','label'=>'Ticket No')),
			array('cbupdater', array('name'=>'cbupd_no','column'=>'cbupd_no','label'=>'cbupd_no')),
			array('Calendar', null),
			array('cbCalendar', null),
			array('InexistentModule', null),
			array('', null),
			array('EtiquetasOO', null),
		);
	}

	/**
	 * Method testgetModuleSequenceField
	 * @test
	 * @dataProvider getModuleSequenceFieldProvider
	 */
	public function testgetModuleSequenceField($module, $expected) {
		$this->assertEquals($expected, getModuleSequenceField($module), 'getModuleSequenceField '.$module);
	}

	/**
	 * Method getTableNameForFieldProvider
	 * params
	 */
	public function getTableNameForFieldProvider() {
		return array(
			array('Assets', 'asset_no', 'vtiger_assets'),
			array('Accounts', 'account_no', 'vtiger_account'),
			array('Accounts', 'ship_city', 'vtiger_accountshipads'),
			array('HelpDesk', 'title', 'vtiger_troubletickets'),
			array('HelpDesk', 'ticket_no', 'vtiger_troubletickets'),
			array('cbupdater', 'cbupd_no', 'vtiger_cbupdater'),
			array('cbupdater', 'InexistentField', ''),
			array('Calendar', null, ''),
			array('cbCalendar', null, ''),
			array('InexistentModule', null, ''),
			array('', null, ''),
			array('EtiquetasOO', null, ''),
		);
	}

	/**
	 * Method testgetTableNameForField
	 * @test
	 * @dataProvider getTableNameForFieldProvider
	 */
	public function testgetTableNameForField($module, $fieldname, $expected) {
		$this->assertEquals($expected, getTableNameForField($module, $fieldname), "getTableNameForField $module, $fieldname");
	}

	/**
	 * Method hasEmailFieldProvider
	 * params
	 */
	public function hasEmailFieldProvider() {
		return array(
			array('Assets', false),
			array('Accounts', true),
			array('HelpDesk', true),
			array('Project', true),
			array('cbupdater', false),
			array('Calendar', false),
			array('cbCalendar', false),
			array('InexistentModule', false),
			array('', false),
			array('EtiquetasOO', false),
		);
	}

	/**
	 * Method testhasEmailField
	 * @test
	 * @dataProvider hasEmailFieldProvider
	 */
	public function testhasEmailField($module, $expected) {
		$this->assertEquals($expected, hasEmailField($module), "hasEmailField $module");
	}
}
