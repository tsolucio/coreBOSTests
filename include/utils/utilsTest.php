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

}
