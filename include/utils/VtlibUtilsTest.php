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

class VtlibUtilsTest extends TestCase {

	/**
	 * Method vtlib_purifyProvider
	 * params
	 */
	public function vtlib_purifyProvider() {
		return array(
			array('Normal string',false,'Normal string','normal string'),
			array('Numbers 012-345,678.9',false,'Numbers 012-345,678.9','Numbers 012-345,678.9'),
			array('Special character string áçèñtös ÑÇ',false,'Special character string áçèñtös ÑÇ','Special character string with áçèñtös'),
			array('!"·$%&/();,:.=?¿*_-|@#€',false,'!"·$%&/();,:.=?¿*_-|@#€','special string with symbols'),
			array('Greater > Lesser < ',false,'Greater &gt; Lesser &lt; ','Greater > Lesser <(space)'),
			array('Greater > Lesser <',false,'Greater &gt; Lesser &lt;','Greater > Lesser <'),
			array('> Greater > Lesser < ',false,'&gt; Greater &gt; Lesser &lt; ','> Greater Lesser <(space)'),
			array('"\'',false,'"\'','special string with quotes'),
			array('<b>Bold HTML</b>',false,'<b>Bold HTML</b>','Bold HTML'),
			array('<td width="25%" align="right" class="dvtCellLabel"><input type="hidden" value="1" id="hdtxt_IsAdmin">Modified Time</td>',false,'Modified Time','HTML table cell'),
			array('<table><tr><td width="25%" align="right" class="dvtCellLabel"><input type="hidden" value="1" id="hdtxt_IsAdmin">Modified Time</td></tr></table>',false,'<table><tr><td width="25%" align="right" class="dvtCellLabel">Modified Time</td></tr></table>','HTML table cell'),
			array('<table><tr><td width="25%" align="right" class="dvtCellLabel"><form action="index.php" method="post"><input type="hidden" value="1" id="hdtxt_IsAdmin">Modified Time</form></td></tr></table>',false,'<table><tr><td width="25%" align="right" class="dvtCellLabel">Modified Time</td></tr></table>','HTML table cell'),
			array('<script>...NEVER PUT UNTRUSTED DATA HERE...</script>',false,'','XSS direct'),
			array('<!--...NEVER PUT UNTRUSTED DATA HERE...-->',false,'','XSS html comment'),
			array('<div ...NEVER PUT UNTRUSTED DATA HERE...=test />',false,'<div></div>','XSS div attribute'),
			array('<NEVER PUT UNTRUSTED DATA HERE... href="/test" />',false,'','XSS tag name'),
			array('<style>...NEVER PUT UNTRUSTED DATA HERE...</style>',false,'','XSS direct CSS'),
			array(' or (true);delete from table;',false,' or (true);delete from table;','XSS SQL'),
			array('&amp;&aacute;&lt;&gt;&ntilde;',false,'&á&lt;&gt;ñ','HTML Codes'),
			array(array('&amp;&aacute;&lt;&gt;&ntilde;','<script>...NEVER PUT UNTRUSTED DATA HERE...</script>'),false,array('&á&lt;&gt;ñ',''),'array test'),
			array('<div onclick="alert(\'hi\')" />',false,'<div></div>','XSS div onclick attribute'),
			array('<div onmousemove="alert(\'hi\')" />',false,'<div></div>','XSS div onmousemove attribute'),
			array('<div onreset="alert(\'hi\')" />',false,'<div></div>','XSS div onreset attribute'),
			array('<div ondblclick="alert(\'hi\')" />',false,'<div></div>','XSS div ondblclick attribute'),
			array('<div onscroll="alert(\'hi\')" />',false,'<div></div>','XSS div onscroll attribute'),
			array('<div onfinish="alert(\'hi\')" />',false,'<div></div>','XSS div onfinish attribute'),

			array('Normal string (T)',true,'Normal string (T)','normal string (true)'),
			array('Numbers 012-345,678.9 (T)',true,'Numbers 012-345,678.9 (T)','Numbers 012-345,678.9 (true)'),
			array('Special character string áçèñtös ÑÇ (T)',true,'Special character string áçèñtös ÑÇ (T)','Special character string with áçèñtös (true)'),
			array('!"·$%&/();,:.=?¿*_-|@#€ (T)',true,'!"·$%&/();,:.=?¿*_-|@#€ (T)','special string with symbols (true)'),
			array('Greater > Lesser (T) < ',true,'Greater > Lesser (T) < ','Greater > Lesser <(space) (true)'),
			array('Greater > Lesser (T) <',true,'Greater > Lesser (T) <','Greater > Lesser < (true)'),
			array('> Greater > Lesser (T) < ',true,'> Greater > Lesser (T) < ','> Greater Lesser <(space) (true)'),
			array('"\' (T)',true,'"\' (T)','special string with quotes (true)'),
			array('<b>Bold HTML (T)</b>',true,'<b>Bold HTML (T)</b>','Bold HTML (true)'),
			array('<td width="25%" align="right" class="dvtCellLabel"><input type="hidden" value="1" id="hdtxt_IsAdmin">Modified Time</td> (T)',true,'<td width="25%" align="right" class="dvtCellLabel"><input type="hidden" value="1" id="hdtxt_IsAdmin">Modified Time</td> (T)','HTML table cell (true)'),
			array('<script>...NEVER PUT UNTRUSTED DATA HERE (T)...</script>',true,'<script>...NEVER PUT UNTRUSTED DATA HERE (T)...</script>','XSS direct (true)'),
			array('<!--...NEVER PUT UNTRUSTED DATA HERE (T)...-->',true,'<!--...NEVER PUT UNTRUSTED DATA HERE (T)...-->','XSS html comment (true)'),
			array('<div ...NEVER PUT UNTRUSTED DATA HERE (T)...=test />',true,'<div ...NEVER PUT UNTRUSTED DATA HERE (T)...=test />','XSS div attribute (true)'),
			array('<NEVER PUT UNTRUSTED DATA HERE (T)... href="/test" />',true,'<NEVER PUT UNTRUSTED DATA HERE (T)... href="/test" />','XSS tag name (true)'),
			array('<style>...NEVER PUT UNTRUSTED DATA HERE (T)...</style>',true,'<style>...NEVER PUT UNTRUSTED DATA HERE (T)...</style>','XSS direct CSS (true)'),
			array(' or (true);delete from table; (T)',true,' or (true);delete from table; (T)','XSS SQL (true)'),
			array('&amp;&aacute;&lt;&gt;&ntilde; (T)',true,'&&aacute;&lt;&gt;&ntilde; (T)','HTML Codes (true)'),
			array(array('&amp;&aacute;&lt;&gt;&ntilde; (T)','<script>...NEVER PUT UNTRUSTED DATA HERE (T)...</script>'),true,array('&&aacute;&lt;&gt;&ntilde; (T)','<script>...NEVER PUT UNTRUSTED DATA HERE (T)...</script>'),'array test (true)'),
			array('<div onclick="alert(\'hi\')" />',true,'<div onclick="alert(\'hi\')" />','XSS div onclick attribute'),
			array('<div onmousemove="alert(\'hi\')" />',true,'<div onmousemove="alert(\'hi\')" />','XSS div onmousemove attribute (true)'),

			// test $ignore cache
			array('> Greater > Lesser < ',false,'&gt; Greater &gt; Lesser &lt; ','> Greater Lesser <(space)'),
			array('> Greater > Lesser < ',true,'> Greater > Lesser < ','> Greater Lesser <(space) (true)'),

			// test ampersand on first call and cached
			array('string has ampersand: &amp; & ',false,'string has ampersand: & & ','has ampersand'),
			array('string has ampersand: &amp; & ',false,'string has ampersand: & & ','has ampersand (cached)'),

			// test url
			array('http://localhost',false,'http://localhost','url'),
			array('https://corebos.org',false,'https://corebos.org','urls'),
			array('<a href="https://corebos.org"></a>',false,'<a href="https://corebos.org"></a>','a href'),
			array('<a href="javascript:alert(document.domain)">XSShref1</a>',false,'<a>XSShref1</a>','JS XSS a href'),
			array('<a href="javascript&colon;alert(document.domain)">XSShref2</a>',false,'<a>XSShref2</a>','JS XSS a href'),
			array("<a href=\"javascript:display('javascript:alert(document.domain)','feedlist_1')\">test</a>",false,'<a>test</a>','javascript'),
			array('&forrecord=xss%22%20autofocus/onfocus=%22alert(5)%22%20id=%27xxx', false, '&forrecord=xss%22%20autofocus/onfocus=%22alert(5)%22%20id=%27xxx', 'javascript'),
			array(
				'<p><svg onmouseover="alert(1)">.svg &lt;<script>alert(\'xss\')<!--a-->a.png
				<noscript><p title="</noscript><img src=x onerror=alert(document.domain)>">.jpg
				<img src=\'1\' onerror=\'alert(1)\' <
				</svg></p></svg></p></svg></p></svg></p></svg></p></svg></p></svg></p>',
				false,
				'<p>.svg &lt;</p>',
				'XSS'
			)
		);
	}

	/**
	 * Method testvtlib_purify
	 * @test
	 * @dataProvider vtlib_purifyProvider
	 */
	public function testvtlib_purify($input, $ignore, $expected, $message) {
		$actual = vtlib_purify($input, $ignore);
		$this->assertEquals($expected, $actual, "testvtlib_purify $message");
	}

	/**
	 * Method vtlib_isEntityModuleProvider
	 * params
	 */
	public function vtlib_isEntityModuleProvider() {
		return array(
			array('Accounts', true),
			array('Assets', true),
			array('EtiquetasOO', false),
			array('evvtMenu', false),
			array('Products', true),
			array('HelpDesk', true),
		);
	}

	/**
	 * Method testvtlib_isEntityModule
	 * @test
	 * @dataProvider vtlib_isEntityModuleProvider
	 */
	public function testvtlib_isEntityModule($mname, $expected) {
		$this->assertEquals($expected, vtlib_isEntityModule($mname), "vtlib_isEntityModule $mname");
	}

	/**
	 * Method isModuleActiveProvider
	 * params
	 */
	public function isModuleActiveProvider() {
		return array(
			array('Accounts', true),
			array('Assets', true),
			array('EtiquetasOO', true),
			array('SMSNotifier', false),
			array('cbAuditTrail', true),
			array('InexistentModule', false),
			array('', false),
			array(0, false),
			array(6, false),
		);
	}

	/**
	 * Method testisModuleActive
	 * @test
	 * @dataProvider isModuleActiveProvider
	 */
	public function testisModuleActive($mname, $expected) {
		$this->assertEquals($expected, vtlib_isModuleActive($mname), "vtlib_isModuleActive $mname");
	}
}
