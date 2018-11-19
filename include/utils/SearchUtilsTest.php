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

class testSearchUtils extends TestCase {

	/**
	 * Method testgetAdvancedSearchValue
	 * @test
	 */
	public function testgetAdvancedSearchValue() {
		global $currentModule, $current_user;
		$ulang = $current_user->language;
		$current_user->language = 'en_us';
		$currentModule = 'Accounts';
		$expected = "vtiger_account.accountname like '%wo%'";
		$actual = getAdvancedSearchValue('vtiger_account', 'accountname', 'c', 'wo', 'V');
		$this->assertEquals($expected, $actual, 'testgetAdvancedSearchValue');
		$expected = "( trim(CONCAT(vtiger_users.first_name,' ',vtiger_users.last_name)) like '%ad%' OR vtiger_groups.groupname like '%ad%')";
		$actual = getAdvancedSearchValue('vtiger_crmentity', 'smownerid', 'c', 'ad', 'V');
		$this->assertEquals($expected, $actual, 'testgetAdvancedSearchValue');
		$expected = "vtiger_account.industry IN (select translation_key from vtiger_cbtranslation
					where locale=\"en_us\" and forpicklist=\"Accounts::industry\" and i18n  = 'Apparel') OR vtiger_account.industry = 'Apparel'";
		$actual = getAdvancedSearchValue('vtiger_account', 'industry', 'e', 'Apparel', 'V');
		$this->assertEquals($expected, $actual, 'testgetAdvancedSearchValue');
		$current_user->language = 'es_es';
		$expected = "vtiger_account.industry IN (select translation_key from vtiger_cbtranslation
					where locale=\"es_es\" and forpicklist=\"Accounts::industry\" and i18n  = 'Apparel') OR vtiger_account.industry = 'Apparel'";
		$actual = getAdvancedSearchValue('vtiger_account', 'industry', 'e', 'Apparel', 'V');
		$this->assertEquals($expected, $actual, 'testgetAdvancedSearchValue');
		$expected = "vtiger_account.industry IN (select translation_key from vtiger_cbtranslation
					where locale=\"es_es\" and forpicklist=\"Accounts::industry\" and i18n  = 'Ropa') OR vtiger_account.industry = 'Ropa'";
		$actual = getAdvancedSearchValue('vtiger_account', 'industry', 'e', 'Ropa', 'V');
		$this->assertEquals($expected, $actual, 'testgetAdvancedSearchValue');
		$expected = "vtiger_account.industry IN (select translation_key from vtiger_cbtranslation
					where locale=\"es_es\" and forpicklist=\"Accounts::industry\" and i18n  like '%Ropa%') OR vtiger_account.industry like '%Ropa%'";
		$actual = getAdvancedSearchValue('vtiger_account', 'industry', 'c', 'Ropa', 'V');
		$this->assertEquals($expected, $actual, 'testgetAdvancedSearchValue');
		$current_user->language = $ulang;
	}
}
