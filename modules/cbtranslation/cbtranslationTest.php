<?php
/*************************************************************************************************
 * Copyright 2017 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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
require_once 'modules/cbtranslation/cbtranslation.php';
use PHPUnit\Framework\TestCase;
class cbtranslationTest extends TestCase {

	var $usrtestes = 8;

	/**
	 * Method testgetLanguage
	 * @test
	 */
	public function testgetLanguage() {
		global $current_user, $default_language;
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'es,en;q=0.8,en-US;q=0.6';
		$hold_user = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(1);
		$current_user = $user;
		$this->assertEquals('en_us', cbtranslation::getLanguage(), 'getLanguage admin');
		$user->retrieveCurrentUserInfoFromFile(8);
		$current_user = $user;
		$this->assertEquals('es_es', cbtranslation::getLanguage(), 'getLanguage testes');
		$current_user = null;
		$this->assertEquals('es_es', cbtranslation::getLanguage(), 'getLanguage nouser');
		unset($_SERVER['HTTP_ACCEPT_LANGUAGE']);
		$this->assertEquals($default_language, cbtranslation::getLanguage(), 'getLanguage nouser nobrowser');
		$current_user = $hold_user;
	}

	/**
	 * Method testgetShortLanguageName
	 * @test
	 */
	public function testgetShortLanguageName() {
		global $current_language;
		$this->assertEquals('en', cbtranslation::getShortLanguageName(), 'getShortLanguageName no parameter');
		$this->assertEquals('en', cbtranslation::getShortLanguageName('en_us'), 'getShortLanguageName en_us');
		$this->assertEquals('es', cbtranslation::getShortLanguageName('es_es'), 'getShortLanguageName es_es');
	}

	/**
	 * Method testget
	 * @test
	 */
	public function testget() {
		// $key, $module, $options
		$this->assertEquals('friend', cbtranslation::get('friend'), 'get friend main');
		$this->assertEquals('A friend', cbtranslation::get('friend','Users'), 'get friend users');
		$this->assertEquals('A friend', cbtranslation::get('friend','Users',array('language'=>'en_us')), 'get friend users en_us');
		$this->assertEquals('Un amigo', cbtranslation::get('friend','Users',array('language'=>'es_es')), 'get friend users es_es');
		$this->assertEquals('Some friends', cbtranslation::get('friend','Users',array('language'=>'en_us','count'=>2)), 'get friend users en_us plural');
		$this->assertEquals('Unos amigos', cbtranslation::get('friend','Users',array('language'=>'es_es','count'=>2)), 'get friend users es_es plural');
		$this->assertEquals('A boyfriend', cbtranslation::get('friend','Users',array('language'=>'en_us','context'=>'male')), 'get friend users en_us context');
		$this->assertEquals('Un amigo', cbtranslation::get('friend','Users',array('language'=>'es_es','context'=>'male')), 'get friend users es_es context');
		$this->assertEquals('A girlfriend', cbtranslation::get('friend','Users',array('language'=>'en_us','context'=>'female')), 'get friend users en_us context');
		$this->assertEquals('Una amiga', cbtranslation::get('friend','Users',array('language'=>'es_es','context'=>'female')), 'get friend users es_es context');
		$this->assertEquals('%d boyfriends', cbtranslation::get('friend','Users',array('language'=>'en_us','context'=>'male','count'=>2)), 'get friend users en_us context count');
		$this->assertEquals('%d amigos', cbtranslation::get('friend','Users',array('language'=>'es_es','context'=>'male','count'=>2)), 'get friend users es_es context count');
		$this->assertEquals('%d girlfriends', cbtranslation::get('friend','Users',array('language'=>'en_us','context'=>'female','count'=>2)), 'get friend users en_us context count');
		$this->assertEquals('%d amigas', cbtranslation::get('friend','Users',array('language'=>'es_es','context'=>'female','count'=>2)), 'get friend users es_es context count');
		$this->assertEquals('2 boyfriends', cbtranslation::get('friend','Users',array('language'=>'en_us','context'=>'male','count'=>2),2), 'get friend users en_us context count 2');
		$this->assertEquals('2 amigos', cbtranslation::get('friend','Users',array('language'=>'es_es','context'=>'male','count'=>2),2), 'get friend users es_es context count 2');
		$this->assertEquals('2 girlfriends', cbtranslation::get('friend','Users',array('language'=>'en_us','context'=>'female','count'=>2),2), 'get friend users en_us context count 2');
		$this->assertEquals('2 amigas', cbtranslation::get('friend','Users',array('language'=>'es_es','context'=>'female','count'=>2),2), 'get friend users es_es context count 2');
		$this->assertEquals('A boyfriend', cbtranslation::get('friend','Users',array('language'=>'en_us','context'=>'male','count'=>1),1), 'get friend users en_us context count 1');
		$this->assertEquals('Un amigo', cbtranslation::get('friend','Users',array('language'=>'es_es','context'=>'male','count'=>1),1), 'get friend users es_es context count 1');
		$this->assertEquals('A girlfriend', cbtranslation::get('friend','Users',array('language'=>'en_us','context'=>'female','count'=>1),1), 'get friend users en_us context count 1');
		$this->assertEquals('Una amiga', cbtranslation::get('friend','Users',array('language'=>'es_es','context'=>'female','count'=>1),1), 'get friend users es_es context count 1');
		// country
		$this->assertEquals('2 girlfriends from England', cbtranslation::get('friendcountry','Users',array('language'=>'en_us','context'=>'female','count'=>2),2,'England'), 'get friend country users en_us context count 2');
		$this->assertEquals('2 amigas de España', cbtranslation::get('friendcountry','Users',array('language'=>'es_es','context'=>'female','count'=>2),2,'España'), 'get friend country users es_es context count 2');
		$this->assertEquals('1 girlfriend from England', cbtranslation::get('friendcountry','Users',array('language'=>'en_us','context'=>'female','count'=>1),1,'England'), 'get friend country users en_us context count 1');
		$this->assertEquals('1 amiga de España', cbtranslation::get('friendcountry','Users',array('language'=>'es_es','context'=>'female','count'=>1),1,'España'), 'get friend country users es_es context count 1');
	}

	/**
	 * Method testgetRecordValue
	 * @test
	 */
	public function testgetRecordValue() {
		$this->assertEquals('Sexy Leggings', cbtranslation::get('Sexy Leggings'), 'getRecordValue main');
		$this->assertEquals('Sexy Leggings', cbtranslation::get('Sexy Leggings','Products'), 'getRecordValue Products');
		$this->assertEquals('Leggings Sexy', cbtranslation::get('Sexy Leggings','Products',array('language'=>'es_es')), 'getRecordValue Products es');
		$this->assertEquals('Leggings Sexy for productname field', cbtranslation::get('Sexy Leggings','Products',array('language'=>'es_es','field'=>'productname')), 'getRecordValue Products es productname');
	}

	/**
	 * Method testgetPicklistValues
	 * @test
	 */
	public function testgetPicklistValues() {
		$expected = array('--None--','Acquired','Active','Market Failed','Project Cancelled','Shutdown',);
		$this->assertEquals($expected, cbtranslation::getPicklistValues('en_us','Accounts','rating'), 'getPicklistValues en accounts rating');
		$expected = array('Adquirido','Activo','Mercado Inmaduro','Cancelado','Suspendido','-----');
		$this->assertEquals($expected, cbtranslation::getPicklistValues('es_es','Accounts','rating'), 'getPicklistValues es accounts rating');
	}

	/**
	 * Method testgetPluralizedKey
	 * @test
	 */
	public function testgetPluralizedKey() {
		$langs = array(
			'en_us' => array('LBL_USER_PLURAL','LBL_USER','LBL_USER_PLURAL','LBL_USER_PLURAL','LBL_USER_PLURAL','LBL_USER_PLURAL','LBL_USER_PLURAL','LBL_USER_PLURAL','LBL_USER_PLURAL','LBL_USER_PLURAL'),
			'es_es' => array('LBL_USER_PLURAL','LBL_USER','LBL_USER_PLURAL','LBL_USER_PLURAL','LBL_USER_PLURAL','LBL_USER_PLURAL','LBL_USER_PLURAL','LBL_USER_PLURAL','LBL_USER_PLURAL','LBL_USER_PLURAL'),
			'ru' => array('LBL_USER_2','LBL_USER_0','LBL_USER_1','LBL_USER_1','LBL_USER_1','LBL_USER_2','LBL_USER_2','LBL_USER_2','LBL_USER_2','LBL_USER_2'),
			'ro' => array('LBL_USER_1','LBL_USER_0','LBL_USER_1','LBL_USER_1','LBL_USER_1','LBL_USER_1','LBL_USER_1','LBL_USER_1','LBL_USER_1','LBL_USER_1'),
		);
		foreach ($langs as $lang => $expected) {
			for ($count=0;$count<10;$count++) {
				$actual = cbtranslation::getPluralizedKey('LBL_USER', $lang, $count);
				$this->assertEquals($expected[$count], $actual, 'getPluralizedKey '.$lang.' '.$count);
			}
		}
	}

}
