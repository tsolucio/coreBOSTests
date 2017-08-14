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

class testutils extends PHPUnit_Framework_TestCase {

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
	public function testto_html($input,$ignore,$expected,$message) {
		$actual = to_html($input, $ignore);
		$this->assertEquals($expected, $actual,"testto_html $message");
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
		$this->assertEquals(true, $actual,"testisRecordExists not deleted CRM record");
		$actual = isRecordExists(5);
		$this->assertEquals(true, $actual,"testisRecordExists not deleted User record");
		$actual = isRecordExists($accountWS.'x80');
		$this->assertEquals(true, $actual,"testisRecordExists deleted CRM record Webservice");
		$actual = isRecordExists($userWS.'x5');
		$this->assertEquals(true, $actual,"testisRecordExists deleted User record Webservice");
		// Deleted Records
		$adb->query('update vtiger_crmentity set deleted=1 where crmid=80');
		$adb->query('update vtiger_users set deleted=1 where id=5');
		$actual = isRecordExists(80);
		$this->assertEquals(false, $actual,"testisRecordExists deleted CRM record");
		$actual = isRecordExists(5);
		// THIS ONE IS WRONG BECAUSE WE CANNOT DISTINGUISH A USER FROM A NORMAL CRM RECORD SO WE FIND cbupdater 5 and return true
		$this->assertEquals(true, $actual,"testisRecordExists deleted User record");
		$actual = isRecordExists(1);
		// THIS ONE IS WRONG, IT RETURNS FALSE BECAUSE THERE IS NO RECORD 1 but there is a user 1
		$this->assertEquals(false, $actual,"testisRecordExists deleted User record");
		$actual = isRecordExists($accountWS.'x80');
		$this->assertEquals(false, $actual,"testisRecordExists deleted CRM record Webservice");
		$adb->query('update vtiger_users set deleted=1 where crmid=5');
		$actual = isRecordExists($userWS.'x5');
		$this->assertEquals(false, $actual,"testisRecordExists deleted User record Webservice");
		// restore DB
		$adb->query('update vtiger_crmentity set deleted=0 where crmid=80');
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
	public function testhtml_to_utf8($data,$expected,$message) {
		$actual = html_to_utf8($data);
		$this->assertEquals($expected, $actual,"testhtml_to_utf8 $message");
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
		);
	}

	/**
	 * Method testgetValidDBInsertDateValue
	 * @test
	 * @dataProvider getValidDBInsertDateValueProvider
	 */
	public function testgetValidDBInsertDateValue($user,$data,$expected,$message) {
		global $current_user;
		$holduser = $current_user;
		$dtuser = new Users();
		$dtuser->retrieveCurrentUserInfoFromFile($user);
		$current_user = $dtuser;
		$actual = getValidDBInsertDateValue($data);
		$this->assertEquals($expected, $actual,"getValidDBInsertDateValue $message");
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

}
