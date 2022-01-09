<?php
/*************************************************************************************************
 * Copyright 2020 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

include_once 'include/Webservices/GetTranslation.php';

class GetTranslationTest extends TestCase {

	/**
	 * Method gettranslationProvider
	 * params
	 */
	public function gettranslationProvider() {
		return array(
			array(array('LBL_TOP_AMOUNT', 'LBL_LIST_ACCOUNT_NAME'), 'en_us', 'Accounts', array('Amount', 'Organization Name')),
			array(array('LBL_NAME', 'LBL_CONTACT_NAME'), 'es_es', 'Contacts', array('Nombre:', 'Contacto:')),
			array(array('LBL_DIFFERENT_MACHINE', 'CustomScriptLabel'), 'en_us', 'VtigerBackup', array('Different Machine', 'Translation From Custom Strings for Unit Testing')),
			array(array('LBL_DIFFERENT_MACHINE' => 'DoesNotExist'), 'en_us', 'VtigerBackup', array('LBL_DIFFERENT_MACHINE' => 'Different Machine')),
			array(array('LBL_DIFFERENT_MACHINE' => 'LBL_FTP_LOGIN_FAILED'), 'en_us', 'VtigerBackup', array('LBL_DIFFERENT_MACHINE' => 'FTP login failed')),
			array(array('EtiquetasOO' => ''), 'en_us', 'EtiquetasOO', array('EtiquetasOO' => 'Merge Labels')),
			array(array('EtiquetasOO'), 'en_us', 'EtiquetasOO', array('Merge Labels')),
			array(array('LBL_NAME', 'LBL_CONTACT_NAME'), 'es_es', 'DoesNotExist', array('LBL_NAME', 'Contacto')),
			array(array('LBL_NAME', 'LBL_CONTACT_NAME'), 'DoesNotExist', 'Contacts', array('Name:', 'Contact Name:')),
			array(array(), 'fr_fr', 'Contacts', array()),
		);
	}

	/**
	 * Method testgettranslation
	 * @test
	 * @dataProvider gettranslationProvider
	 */
	public function testgettranslation($totranslate, $portal_language, $module, $expected) {
		global $current_user;
		$this->assertEquals($expected, vtws_gettranslation($totranslate, $portal_language, $module, $current_user));
	}

	/**
	 * Method testNoDefaultLanguage
	 * @test
	 */
	public function testNoDefaultLanguage() {
		global $current_user, $default_language;
		$originalDefaultLanguage = $default_language;
		$default_language = 'DoesNotExist';
		$this->assertEquals(array('LBL_NAME', 'LBL_CONTACT_NAME'), vtws_gettranslation(array('LBL_NAME', 'LBL_CONTACT_NAME'), 'DoesNotExist', 'Contacts', $current_user));
		$default_language = $originalDefaultLanguage;
	}
}
?>