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

class testCurrencyField extends TestCase {

	/****
	 * TEST Users decimal configuration
	 * name format is: {decimal_separator}{symbol_position}{grouping}{grouping_symbol}{currency}
	 ****/
	private $usrdota0x = 5; // testdmy 2 decimal places
	private $usrcomd0x = 6; // testmdy 3 decimal places
	private $usrdotd3com = 7; // testymd 4 decimal places
	private $usrcoma3dot = 10; // testtz 5 decimal places
	private $usrdota3comdollar = 12; // testmcurrency 6 decimal places

	/**
	 * Method testgetCurrencyInformation
	 * @test
	 */
	public function testgetCurrencyInformation() {
		global $current_user;
		$hold_user = $current_user;
		$user = new Users();
		$testcurrency = 42654016.022589;
		$currencyField = new CurrencyField($testcurrency);
		$converted2Dollar = $testcurrency * 1.1; // 46919417.6248479
		$converted = convertToDollar(46919417.6248479, 1.1);
		$this->assertEquals(round(42654016.022589,6), round($converted, 6), 'convertToDollar UTILS');
		$converted = convertFromDollar(42654016.022589, 1.1);
		$this->assertEquals(round(46919417.6248479, 2), $converted, 'convertFromDollar UTILS');
		$converted = CurrencyField::convertToDollar(46919417.6248479, 1.1);
		$this->assertEquals(round(42654016.022589,CurrencyField::$maxNumberOfDecimals), round($converted,CurrencyField::$maxNumberOfDecimals), 'convertToDollar CLASS');
		$converted = CurrencyField::convertFromDollar(42654016.022589, 1.1);
		$this->assertEquals(round(46919417.6248479,CurrencyField::$maxNumberOfDecimals), $converted, 'convertFromDollar CLASS');
		$dbCurrency = CurrencyField::getDBCurrencyId();
		$this->assertEquals(1, $dbCurrency, 'getDBCurrencyId');
		$this->assertEquals(3, $currencyField->numberOfDecimal, 'numberOfDecimal');
		$currencyField->setNumberofDecimals(6);
		$this->assertEquals(6, $currencyField->numberOfDecimal, 'set numberOfDecimal');
		$currencyField->numberOfDecimal = 4;
		$this->assertEquals(4, $currencyField->numberOfDecimal, 'assign numberOfDecimal');
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x); // symbol in front
		$current_user = $user;
		$formattedCurrencyValue = CurrencyField::appendCurrencySymbol($testcurrency, 'S');
		$this->assertEquals("S$testcurrency", $formattedCurrencyValue,'appendCurrencySymbol in front');
		$formattedCurrencyValue = CurrencyField::appendCurrencySymbol($testcurrency, 'S','1.0$');
		$this->assertEquals($testcurrency.'S', $formattedCurrencyValue,'appendCurrencySymbol in back');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x);
		$currencyField->initialize($user);
		$this->assertEquals('123456789', $currencyField->currencyFormat, 'currencyFormat usrdota0x');
		$this->assertEquals(',', $currencyField->currencySeparator, 'currencySeparator usrdota0x');
		$this->assertEquals('.', $currencyField->decimalSeparator, 'decimalSeparator usrdota0x');
		$this->assertEquals(1, $currencyField->currencyId, 'currencyId usrdota0x');
		$this->assertEquals('&euro;', $currencyField->currencySymbol, 'currencySymbol usrdota0x');
		$this->assertEquals(1, $currencyField->conversionRate, 'conversionRate usrdota0x');
		$this->assertEquals('1.0$', $currencyField->currencySymbolPlacement, 'currencySymbolPlacement usrdota0x');
		$this->assertEquals(2, $currencyField->numberOfDecimal, 'numberOfDecimal usrdota0x');
		
		$user->retrieveCurrentUserInfoFromFile($this->usrcomd0x);
		$currencyField->initialize($user);
		$this->assertEquals('123456789', $currencyField->currencyFormat, 'currencyFormat usrcomd0x');
		$this->assertEquals('.', $currencyField->currencySeparator, 'currencySeparator usrcomd0x');
		$this->assertEquals(',', $currencyField->decimalSeparator, 'decimalSeparator usrcomd0x');
		$this->assertEquals(1, $currencyField->currencyId, 'currencyId usrcomd0x');
		$this->assertEquals('&euro;', $currencyField->currencySymbol, 'currencySymbol usrcomd0x');
		$this->assertEquals(1, $currencyField->conversionRate, 'conversionRate usrcomd0x');
		$this->assertEquals('1.0$', $currencyField->currencySymbolPlacement, 'currencySymbolPlacement usrcomd0x');
		$this->assertEquals(3, $currencyField->numberOfDecimal, 'numberOfDecimal usrcomd0x');

		$user->retrieveCurrentUserInfoFromFile($this->usrdotd3com);
		$currencyField->initialize($user);
		$this->assertEquals('123,456,789', $currencyField->currencyFormat, 'currencyFormat usrdotd3com');
		$this->assertEquals(',', $currencyField->currencySeparator, 'currencySeparator usrdotd3com');
		$this->assertEquals('.', $currencyField->decimalSeparator, 'decimalSeparator usrdotd3com');
		$this->assertEquals(1, $currencyField->currencyId, 'currencyId usrdotd3com');
		$this->assertEquals('&euro;', $currencyField->currencySymbol, 'currencySymbol usrdotd3com');
		$this->assertEquals(1, $currencyField->conversionRate, 'conversionRate usrdotd3com');
		$this->assertEquals('1.0$', $currencyField->currencySymbolPlacement, 'currencySymbolPlacement usrdotd3com');
		$this->assertEquals(4, $currencyField->numberOfDecimal, 'numberOfDecimal usrdotd3com');

		$user->retrieveCurrentUserInfoFromFile($this->usrcoma3dot);
		$currencyField->initialize($user);
		$this->assertEquals('123,456,789', $currencyField->currencyFormat, 'currencyFormat usrcoma3dot');
		$this->assertEquals('.', $currencyField->currencySeparator, 'currencySeparator usrcoma3dot');
		$this->assertEquals(',', $currencyField->decimalSeparator, 'decimalSeparator usrcoma3dot');
		$this->assertEquals(1, $currencyField->currencyId, 'currencyId usrcoma3dot');
		$this->assertEquals('&euro;', $currencyField->currencySymbol, 'currencySymbol usrcoma3dot');
		$currencySymbol = $currencyField->getCurrencySymbol();
		$this->assertEquals('&euro;', $currencySymbol, 'currencySymbol usrcoma3dot method');
		$this->assertEquals(1, $currencyField->conversionRate, 'conversionRate usrcoma3dot');
		$this->assertEquals('1.0$', $currencyField->currencySymbolPlacement, 'currencySymbolPlacement usrcoma3dot');
		$this->assertEquals(5, $currencyField->numberOfDecimal, 'numberOfDecimal usrcoma3dot');

		$user->retrieveCurrentUserInfoFromFile($this->usrdota3comdollar);
		$currencyField->initialize($user);
		$this->assertEquals('123,456,789', $currencyField->currencyFormat, 'currencyFormat usrdota3comdollar');
		$this->assertEquals(',', $currencyField->currencySeparator, 'currencySeparator usrdota3comdollar');
		$this->assertEquals('.', $currencyField->decimalSeparator, 'decimalSeparator usrdota3comdollar');
		$this->assertEquals(2, $currencyField->currencyId, 'currencyId usrdota3comdollar');
		$this->assertEquals('$', $currencyField->currencySymbol, 'currencySymbol usrdota3comdollar');
		$currencySymbol = $currencyField->getCurrencySymbol();
		$this->assertEquals('$', $currencySymbol, 'currencySymbol usrdota3comdollar method');
		$this->assertEquals(1.1, $currencyField->conversionRate, 'conversionRate usrdota3comdollar');
		$this->assertEquals('$1.0', $currencyField->currencySymbolPlacement, 'currencySymbolPlacement usrdota3comdollar');
		$this->assertEquals(6, $currencyField->numberOfDecimal, 'numberOfDecimal usrdota3comdollar');
		// End
		$current_user = $hold_user;
	}

	/**
	 * Method testconvertToUserFormat
	 * @test
	 */
	public function testconvertToUserFormat() {
		$user = new Users();
		$testcurrency = 42654016.022589;
		$currencyField = new CurrencyField($testcurrency);
		//Without decimals
		$testcurrencyNoDecimals = 42654016;
		$currencyFieldNoDecimals = new CurrencyField($testcurrencyNoDecimals);
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$testcurrencyrounded = round($testcurrency,$currencyField->numberOfDecimal);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDisplayValue usrdota0x');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertEquals($testcurrencyrounded.'&euro;', $formattedCurrencyValue,'getDisplayValueWithSymbol usrdota0x');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat noskip usrdota0x');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat skip usrdota0x');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrcomd0x);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$testcurrencyrounded = round($testcurrency,$currencyField->numberOfDecimal);
		$testcurrencyrounded = str_replace('.', ',', $testcurrencyrounded);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDisplayValue usrcomd0x');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertEquals($testcurrencyrounded.'&euro;', $formattedCurrencyValue,'getDisplayValueWithSymbol usrcomd0x');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat noskip usrcomd0x');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat skip usrcomd0x');
		$formattedCurrencyValueNoDecimals = $currencyFieldNoDecimals->getDisplayValue($user);
		$this->assertEquals('42654016,000', $formattedCurrencyValueNoDecimals,'getDisplayValue usrcomd0x for value without decimals');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrdotd3com);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$testcurrencyrounded = number_format($testcurrency,$currencyField->numberOfDecimal,'.',',');
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDisplayValue usrdotd3com');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertEquals($testcurrencyrounded.'&euro;', $formattedCurrencyValue,'getDisplayValueWithSymbol usrdotd3com');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat noskip usrdotd3com');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat skip usrdotd3com');
		$formattedCurrencyValueNoDecimals = $currencyFieldNoDecimals->getDisplayValue($user);
		$this->assertEquals('42,654,016.0000', $formattedCurrencyValueNoDecimals,'getDisplayValue usrdotd3com for value without decimals');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrcoma3dot);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$testcurrencyrounded = number_format($testcurrency,$currencyField->numberOfDecimal,',','.');
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDisplayValue usrcoma3dot');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertEquals($testcurrencyrounded.'&euro;', $formattedCurrencyValue,'getDisplayValueWithSymbol usrcoma3dot');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat noskip usrcoma3dot');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat skip usrcoma3dot');
		$formattedCurrencyValueNoDecimals = $currencyFieldNoDecimals->getDisplayValue($user);
		$this->assertEquals('42.654.016,00000', $formattedCurrencyValueNoDecimals,'getDisplayValue usrcoma3dot for value without decimals');
		/////////////////
		$converted2Dollar = $testcurrency * 1.1; // 46919417.6248479
		$user->retrieveCurrentUserInfoFromFile($this->usrdota3comdollar);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$testcurrencyrounded = number_format($converted2Dollar,$currencyField->numberOfDecimal,'.',',');
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDisplayValue usrdota3comdollar');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertEquals('$'.$testcurrencyrounded, $formattedCurrencyValue,'getDisplayValueWithSymbol usrdota3comdollar');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat noskip usrdota3comdollar');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$testcurrencyrounded = number_format($testcurrency,$currencyField->numberOfDecimal,'.',',');
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat skip usrdota3comdollar');
	}
	/**
	 * Method testconvertToUserFormatZero
	 * @test
	 */
	public function testconvertToUserFormatRealZero() {
		$user = new Users();
		$testcurrency = 0;
		$testcurrencyrounded = '0';
		$currencyField = new CurrencyField($testcurrency);
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$this->assertSame($testcurrencyrounded, $formattedCurrencyValue,'getDisplayValue REAL zero usrdota0x');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertSame($testcurrencyrounded.'&euro;', $formattedCurrencyValue,'getDisplayValueWithSymbol REAL zero usrdota0x');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertSame($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat noskip REAL zero usrdota0x');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertSame($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat skip REAL zero usrdota0x');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrcomd0x);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$this->assertSame($testcurrencyrounded, $formattedCurrencyValue,'getDisplayValue REAL zero usrcomd0x');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertSame($testcurrencyrounded.'&euro;', $formattedCurrencyValue,'getDisplayValueWithSymbol REAL zero usrcomd0x');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertSame($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat noskip REAL zero usrcomd0x');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertSame($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat skip REAL zero usrcomd0x');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrdotd3com);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$this->assertSame($testcurrencyrounded, $formattedCurrencyValue,'getDisplayValue REAL zero usrdotd3com');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertSame($testcurrencyrounded.'&euro;', $formattedCurrencyValue,'getDisplayValueWithSymbol REAL zero usrdotd3com');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertSame($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat noskip REAL zero usrdotd3com');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertSame($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat skip REAL zero usrdotd3com');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrcoma3dot);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$this->assertSame($testcurrencyrounded, $formattedCurrencyValue,'getDisplayValue REAL zero usrcoma3dot');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertSame($testcurrencyrounded.'&euro;', $formattedCurrencyValue,'getDisplayValueWithSymbol REAL zero usrcoma3dot');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertSame($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat noskip REAL zero usrcoma3dot');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertSame($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat skip REAL zero usrcoma3dot');
		/////////////////
		$converted2Dollar = $testcurrency * 1.1;
		$user->retrieveCurrentUserInfoFromFile($this->usrdota3comdollar);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$this->assertSame($testcurrencyrounded, $formattedCurrencyValue,'getDisplayValue REAL zero usrdota3comdollar');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertSame('$'.$testcurrencyrounded, $formattedCurrencyValue,'getDisplayValueWithSymbol REAL zero usrdota3comdollar');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertSame($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat noskip REAL zero usrdota3comdollar');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertSame($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat skip REAL zero usrdota3comdollar');
	}

	/**
	 * Method testconvertToDBFormatRealZero
	 * @test
	 */
	public function testconvertToDBFormatRealZero() {
		$user = new Users();
		$testcurrency = 0;
		$currencyField = new CurrencyField($testcurrency);
		$testcurrencyrounded = '0';
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x);
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, false);
		$this->assertSame(0.0, $formattedCurrencyValue,'getDBInsertedValue noskip Real zero usrdota0x');
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, true);
		$this->assertSame($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue skip Real zero usrdota0x');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, false);
		$this->assertSame(0.0, $formattedCurrencyValue,'convertToDBFormat noskip Real zero usrdota0x');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, true);
		$this->assertSame($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat skip Real zero usrdota0x');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrcomd0x);
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, false);
		$this->assertSame(0.0, $formattedCurrencyValue,'getDBInsertedValue noskip Real zero usrcomd0x');
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, true);
		$this->assertSame($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue skip Real zero usrcomd0x');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, false);
		$this->assertSame(0.0, $formattedCurrencyValue,'convertToDBFormat noskip Real zero usrcomd0x');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, true);
		$this->assertSame($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat skip Real zero usrcomd0x');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrdotd3com);
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, false);
		$this->assertSame(0.0, $formattedCurrencyValue,'getDBInsertedValue noskip Real zero usrdotd3com');
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, true);
		$this->assertSame($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue skip Real zero usrdotd3com');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, false);
		$this->assertSame(0.0, $formattedCurrencyValue,'convertToDBFormat noskip Real zero usrdotd3com');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, true);
		$this->assertSame($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat skip Real zero usrdotd3com');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrcoma3dot);
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, false);
		$this->assertSame(0.0, $formattedCurrencyValue,'getDBInsertedValue noskip Real zero usrcoma3dot');
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, true);
		$this->assertSame($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue skip Real zero usrcoma3dot');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, false);
		$this->assertSame(0.0, $formattedCurrencyValue,'convertToDBFormat noskip Real zero usrcoma3dot');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, true);
		$this->assertSame($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat skip Real zero usrcoma3dot');
	}

	/**
	 * Method testconvertToUserFormatZero
	 * @test
	 */
	public function testconvertToUserFormatZero() {
		$user = new Users();
		$testcurrency = 0.022589;
		$currencyField = new CurrencyField($testcurrency);
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$testcurrencyrounded = round($testcurrency,$currencyField->numberOfDecimal);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDisplayValue zero usrdota0x');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertEquals($testcurrencyrounded.'&euro;', $formattedCurrencyValue,'getDisplayValueWithSymbol zero usrdota0x');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat noskip zero usrdota0x');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat skip zero usrdota0x');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrcomd0x);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$testcurrencyrounded = round($testcurrency,$currencyField->numberOfDecimal);
		$testcurrencyrounded = str_replace('.', ',', $testcurrencyrounded);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDisplayValue zero usrcomd0x');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertEquals($testcurrencyrounded.'&euro;', $formattedCurrencyValue,'getDisplayValueWithSymbol zero usrcomd0x');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat noskip zero usrcomd0x');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat skip zero usrcomd0x');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrdotd3com);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$testcurrencyrounded = number_format($testcurrency,$currencyField->numberOfDecimal,'.',',');
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDisplayValue zero usrdotd3com');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertEquals($testcurrencyrounded.'&euro;', $formattedCurrencyValue,'getDisplayValueWithSymbol zero usrdotd3com');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat noskip zero usrdotd3com');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat skip zero usrdotd3com');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrcoma3dot);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$testcurrencyrounded = number_format($testcurrency,$currencyField->numberOfDecimal,',','.');
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDisplayValue zero usrcoma3dot');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertEquals($testcurrencyrounded.'&euro;', $formattedCurrencyValue,'getDisplayValueWithSymbol zero usrcoma3dot');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat noskip zero usrcoma3dot');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat skip zero usrcoma3dot');
		/////////////////
		$converted2Dollar = $testcurrency * 1.1;
		$user->retrieveCurrentUserInfoFromFile($this->usrdota3comdollar);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$testcurrencyrounded = number_format($converted2Dollar,$currencyField->numberOfDecimal,'.',',');
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDisplayValue zero usrdota3comdollar');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertEquals('$'.$testcurrencyrounded, $formattedCurrencyValue,'getDisplayValueWithSymbol zero usrdota3comdollar');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat noskip zero usrdota3comdollar');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$testcurrencyrounded = number_format($testcurrency,$currencyField->numberOfDecimal,'.',',');
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat skip zero usrdota3comdollar');
	}

	/**
	 * Method testconvertToUserFormatNegative
	 * @test
	 */
	public function testconvertToUserFormatNegative() {
		$user = new Users();
		$testcurrency = -42654016.022589;
		$currencyField = new CurrencyField($testcurrency);
		//Without decimals
		$testcurrencyNoDecimals = -42654016;
		$currencyFieldNoDecimals = new CurrencyField($testcurrencyNoDecimals);
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$testcurrencyrounded = round($testcurrency,$currencyField->numberOfDecimal);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDisplayValue Negative usrdota0x');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertEquals($testcurrencyrounded.'&euro;', $formattedCurrencyValue,'getDisplayValueWithSymbol Negative usrdota0x');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat noskip Negative usrdota0x');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat skip Negative usrdota0x');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrcomd0x);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$testcurrencyrounded = round($testcurrency,$currencyField->numberOfDecimal);
		$testcurrencyrounded = str_replace('.', ',', $testcurrencyrounded);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDisplayValue Negative usrcomd0x');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertEquals($testcurrencyrounded.'&euro;', $formattedCurrencyValue,'getDisplayValueWithSymbol Negative usrcomd0x');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat noskip Negative usrcomd0x');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat skip Negative usrcomd0x');
		$formattedCurrencyValueNoDecimals = $currencyFieldNoDecimals->getDisplayValue($user);
		$this->assertEquals('-42654016,000', $formattedCurrencyValueNoDecimals,'getDisplayValue Negative usrcomd0x for value without decimals');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrdotd3com);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$testcurrencyrounded = number_format($testcurrency,$currencyField->numberOfDecimal,'.',',');
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDisplayValue Negative usrdotd3com');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertEquals($testcurrencyrounded.'&euro;', $formattedCurrencyValue,'getDisplayValueWithSymbol Negative usrdotd3com');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat noskip Negative usrdotd3com');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat skip Negative usrdotd3com');
		$formattedCurrencyValueNoDecimals = $currencyFieldNoDecimals->getDisplayValue($user);
		$this->assertEquals('-42,654,016.0000', $formattedCurrencyValueNoDecimals,'getDisplayValue Negative usrdotd3com for value without decimals');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrcoma3dot);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$testcurrencyrounded = number_format($testcurrency,$currencyField->numberOfDecimal,',','.');
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDisplayValue Negative usrcoma3dot');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertEquals($testcurrencyrounded.'&euro;', $formattedCurrencyValue,'getDisplayValueWithSymbol Negative usrcoma3dot');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat noskip Negative usrcoma3dot');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat skip Negative usrcoma3dot');
		$formattedCurrencyValueNoDecimals = $currencyFieldNoDecimals->getDisplayValue($user);
		$this->assertEquals('-42.654.016,00000', $formattedCurrencyValueNoDecimals,'getDisplayValue Negative usrcoma3dot for value without decimals');
		/////////////////
		$converted2Dollar = $testcurrency * 1.1; // 46919417.6248479
		$user->retrieveCurrentUserInfoFromFile($this->usrdota3comdollar);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$testcurrencyrounded = number_format($converted2Dollar,$currencyField->numberOfDecimal,'.',',');
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDisplayValue Negative usrdota3comdollar');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertEquals('$'.$testcurrencyrounded, $formattedCurrencyValue,'getDisplayValueWithSymbol Negative usrdota3comdollar');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat noskip Negative usrdota3comdollar');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$testcurrencyrounded = number_format($testcurrency,$currencyField->numberOfDecimal,'.',',');
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToUserFormat skip Negative usrdota3comdollar');
	}

	/**
	 * Method testconvertToDBFormat
	 * @test
	 */
	public function testconvertToDBFormat() {
		$user = new Users();
		$testcurrency = 42654016.022589;
		$currencyField = new CurrencyField($testcurrency);
		$testcurrencyrounded = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x);
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue noskip usrdota0x');
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue skip usrdota0x');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat noskip usrdota0x');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat skip usrdota0x');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrcomd0x);
		$testcurrency = '42654016,022589';
		$currencyField = new CurrencyField($testcurrency);
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue noskip usrcomd0x');
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue skip usrcomd0x');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat noskip usrcomd0x');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat skip usrcomd0x');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrdotd3com);
		$testcurrency = '42,654,016.022589';
		$currencyField = new CurrencyField($testcurrency);
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue noskip usrdotd3com');
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue skip usrdotd3com');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat noskip usrdotd3com');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat skip usrdotd3com');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrcoma3dot);
		$testcurrency = '42.654.016,022589';
		$currencyField = new CurrencyField($testcurrency);
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue noskip usrcoma3dot');
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue skip usrcoma3dot');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat noskip usrcoma3dot');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat skip usrcoma3dot');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrdota3comdollar);
		$testcurrency = 42654016.022589;
		$currencyField = new CurrencyField('46,919,417.624848');
		$currencyField->initialize($user);
		$testcurrencyrounded = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$converted2Dollar = $testcurrency * $currencyField->conversionRate; // 46919417,624848
		$converted2DollarRounded = round($converted2Dollar,CurrencyField::$maxNumberOfDecimals);
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, false);
		$numdec = pow(10, CurrencyField::$maxNumberOfDecimals);
		$truncexpected = floor($testcurrencyrounded * $numdec) / $numdec;
		$truncactual = floor($formattedCurrencyValue * $numdec) / $numdec;
		$this->assertEquals($truncexpected, $truncactual,'getDBInsertedValue noskip usrdota3comdollar');
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, true);
		$this->assertEquals($converted2DollarRounded, $formattedCurrencyValue,'getDBInsertedValue skip usrdota3comdollar');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($converted2Dollar, $user, false);
		$truncexpected = floor($testcurrencyrounded * $numdec) / $numdec;
		$truncactual = floor($formattedCurrencyValue * $numdec) / $numdec;
		$this->assertEquals($truncexpected, $truncactual,'convertToDBFormat noskip usrdota3comdollar');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($converted2Dollar, $user, true);
		$this->assertEquals($converted2DollarRounded, $formattedCurrencyValue,'convertToDBFormat skip usrdota3comdollar');
		/////////////////
		// currency symbol not supported as input
		$currencyField = new CurrencyField('$46,919,417.624848');
		$formattedCurrencyValue = @$currencyField->getDBInsertedValue($user, false);
		$this->assertEquals(0, $formattedCurrencyValue,'getDBInsertedValue noskip usrdota3comdollar WITH SYMBOL');
	}

	/**
	 * Method testconvertToDBFormatZero
	 * @test
	 */
	public function testconvertToDBFormatZero() {
		$user = new Users();
		$testcurrency = 0.022589;
		$currencyField = new CurrencyField($testcurrency);
		$testcurrencyrounded = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x);
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue noskip zero usrdota0x');
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue skip zero usrdota0x');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat noskip zero usrdota0x');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat skip zero usrdota0x');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrcomd0x);
		$testcurrency = '0,022589';
		$currencyField = new CurrencyField($testcurrency);
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue noskip zero usrcomd0x');
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue skip zero usrcomd0x');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat noskip zero usrcomd0x');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat skip zero usrcomd0x');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrdotd3com);
		$testcurrency = '0.022589';
		$currencyField = new CurrencyField($testcurrency);
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue noskip zero usrdotd3com');
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue skip zero usrdotd3com');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat noskip zero usrdotd3com');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat skip zero usrdotd3com');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrcoma3dot);
		$testcurrency = '0,022589';
		$currencyField = new CurrencyField($testcurrency);
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue noskip zero usrcoma3dot');
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue skip zero usrcoma3dot');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat noskip zero usrcoma3dot');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat skip zero usrcoma3dot');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrdota3comdollar);
		$testcurrency = 0.022589;
		$currencyField = new CurrencyField('0.0248479');
		$currencyField->initialize($user);
		$testcurrencyrounded = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$converted2Dollar = $testcurrency * $currencyField->conversionRate;
		$converted2DollarRounded = round($converted2Dollar,CurrencyField::$maxNumberOfDecimals);
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, false);
		$numdec = pow(10, CurrencyField::$maxNumberOfDecimals);
		$truncexpected = floor($testcurrencyrounded * $numdec) / $numdec;
		$truncactual = floor($formattedCurrencyValue * $numdec) / $numdec;
		$this->assertEquals("$truncexpected", $formattedCurrencyValue,'getDBInsertedValue noskip zero usrdota3comdollar');
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, true);
		$formattedCurrencyValuerounded = round($formattedCurrencyValue,CurrencyField::$maxNumberOfDecimals);
		$this->assertEquals("$converted2DollarRounded", $formattedCurrencyValuerounded,'getDBInsertedValue skip zero usrdota3comdollar');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($converted2Dollar, $user, false);
		$truncexpected = floor($testcurrencyrounded * $numdec) / $numdec;
		$truncactual = floor($formattedCurrencyValue * $numdec) / $numdec;
		$this->assertEquals("$truncexpected", $formattedCurrencyValue,'convertToDBFormat noskip zero usrdota3comdollar');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($converted2Dollar, $user, true);
		$this->assertEquals("$converted2DollarRounded", $formattedCurrencyValuerounded,'convertToDBFormat skip zero usrdota3comdollar');
	}

	/**
	 * Method testconvertToDBFormatNegative
	 * @test
	 */
	public function testconvertToDBFormatNegative() {
		$user = new Users();
		$testcurrency = -42654016.022589;
		$currencyField = new CurrencyField($testcurrency);
		$testcurrencyrounded = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x);
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue noskip Negative usrdota0x');
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue skip Negative usrdota0x');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat noskip Negative usrdota0x');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat skip Negative usrdota0x');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrcomd0x);
		$testcurrency = '-42654016,022589';
		$currencyField = new CurrencyField($testcurrency);
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue noskip Negative usrcomd0x');
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue skip Negative usrcomd0x');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat noskip Negative usrcomd0x');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat skip Negative usrcomd0x');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrdotd3com);
		$testcurrency = '-42,654,016.022589';
		$currencyField = new CurrencyField($testcurrency);
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue noskip Negative usrdotd3com');
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue skip Negative usrdotd3com');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat noskip Negative usrdotd3com');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat skip Negative usrdotd3com');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrcoma3dot);
		$testcurrency = '-42.654.016,022589';
		$currencyField = new CurrencyField($testcurrency);
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue noskip Negative usrcoma3dot');
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue skip Negative usrcoma3dot');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat noskip Negative usrcoma3dot');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat skip Negative usrcoma3dot');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrdota3comdollar);
		$testcurrency = -42654016.022589;
		$currencyField = new CurrencyField('-46,919,417.624848');
		$currencyField->initialize($user);
		$testcurrencyrounded = round($testcurrency,CurrencyField::$maxNumberOfDecimals);
		$converted2Dollar = $testcurrency * $currencyField->conversionRate; // 46919417,624848
		$converted2DollarRounded = round($converted2Dollar,CurrencyField::$maxNumberOfDecimals);
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, false);
		$numdec = pow(10, CurrencyField::$maxNumberOfDecimals);
		$truncexpected = -42654016.02259; // floor($testcurrencyrounded * $numdec) / $numdec;
		$truncactual = floor($formattedCurrencyValue * $numdec) / $numdec;
		$this->assertEquals($truncexpected, $truncactual,'getDBInsertedValue noskip Negative usrdota3comdollar');
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, true);
		$this->assertEquals($converted2DollarRounded, $formattedCurrencyValue,'getDBInsertedValue skip Negative usrdota3comdollar');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($converted2Dollar, $user, false);
		$truncexpected = -42654016.02259; // floor($testcurrencyrounded * $numdec) / $numdec;
		$truncactual = floor($formattedCurrencyValue * $numdec) / $numdec;
		$this->assertEquals($truncexpected, $truncactual,'convertToDBFormat noskip Negative usrdota3comdollar');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($converted2Dollar, $user, true);
		$this->assertEquals($converted2DollarRounded, $formattedCurrencyValue,'convertToDBFormat skip Negative usrdota3comdollar');
		/////////////////
		// currency symbol not supported as input
		$currencyField = new CurrencyField('$-46,919,417.624848');
		$formattedCurrencyValue = @$currencyField->getDBInsertedValue($user, false);
		$this->assertEquals(0, $formattedCurrencyValue,'getDBInsertedValue noskip Negative usrdota3comdollar WITH SYMBOL');
	}

	/**
	 * Method getDecimalsFromTypeOfDataProvider
	 * params
	 */
	public function getDecimalsFromTypeOfDataProvider() {
		return array(
			array('NN~O',$this->usrdota0x,2,'usrdota0x - 2'),
			array('NN~O',$this->usrcomd0x,3,'usrcomd0x - 3'),
			array('NN~O',$this->usrdotd3com,4,'usrdotd3com - 4'),
			array('NN~O',$this->usrcoma3dot,5,'usrcoma3dot - 5'),
			array('NN~O',$this->usrdota3comdollar,6,'usrdota3comdollar - 6'),
			array('N~O',$this->usrdota0x,2,'usrdota0x - 2'),
			array('N~O',$this->usrcomd0x,3,'usrcomd0x - 3'),
			array('N~O',$this->usrdotd3com,4,'usrdotd3com - 4'),
			array('N~O',$this->usrcoma3dot,5,'usrcoma3dot - 5'),
			array('N~O',$this->usrdota3comdollar,6,'usrdota3comdollar - 6'),

			array('N~O~',$this->usrdota0x,2,'usrdota0x - 2'),
			array('N~O~',$this->usrcomd0x,3,'usrcomd0x - 3'),
			array('N~O~',$this->usrdotd3com,4,'usrdotd3com - 4'),
			array('N~O~',$this->usrcoma3dot,5,'usrcoma3dot - 5'),
			array('N~O~',$this->usrdota3comdollar,6,'usrdota3comdollar - 6'),
			array('N~O~18',$this->usrdota0x,2,'usrdota0x - 2'),
			array('N~O~18',$this->usrcomd0x,3,'usrcomd0x - 3'),
			array('N~O~18',$this->usrdotd3com,4,'usrdotd3com - 4'),
			array('N~O~18',$this->usrcoma3dot,5,'usrcoma3dot - 5'),
			array('N~O~18',$this->usrdota3comdollar,6,'usrdota3comdollar - 6'),
			array('N~O~18~',$this->usrdota0x,2,'usrdota0x - 2'),
			array('N~O~18~',$this->usrcomd0x,3,'usrcomd0x - 3'),
			array('N~O~18~',$this->usrdotd3com,4,'usrdotd3com - 4'),
			array('N~O~18~',$this->usrcoma3dot,5,'usrcoma3dot - 5'),
			array('N~O~18~',$this->usrdota3comdollar,6,'usrdota3comdollar - 6'),
			array('N~O~18,',$this->usrdota0x,2,'usrdota0x - 2'),
			array('N~O~18,',$this->usrcomd0x,3,'usrcomd0x - 3'),
			array('N~O~18,',$this->usrdotd3com,4,'usrdotd3com - 4'),
			array('N~O~18,',$this->usrcoma3dot,5,'usrcoma3dot - 5'),
			array('N~O~18,',$this->usrdota3comdollar,6,'usrdota3comdollar - 6'),

			array('NN~O~8,2',$this->usrdota0x,2,'usrdota0x - 2'),
			array('NN~O~8,2',$this->usrcomd0x,2,'usrcomd0x - 3'),
			array('NN~O~8,2',$this->usrdotd3com,2,'usrdotd3com - 4'),
			array('NN~O~8,2',$this->usrcoma3dot,2,'usrcoma3dot - 5'),
			array('NN~O~8,2',$this->usrdota3comdollar,2,'usrdota3comdollar - 6'),
			array('N~O~8,4',$this->usrdota0x,4,'usrdota0x - 2'),
			array('N~O~8,4',$this->usrcomd0x,4,'usrcomd0x - 3'),
			array('N~O~8,4',$this->usrdotd3com,4,'usrdotd3com - 4'),
			array('N~O~8,4',$this->usrcoma3dot,4,'usrcoma3dot - 5'),
			array('N~O~8,4',$this->usrdota3comdollar,4,'usrdota3comdollar - 6'),
			array('N~O~2~2',$this->usrdota0x,2,'usrdota0x - 2'),
			array('N~O~2~2',$this->usrcomd0x,2,'usrcomd0x - 3'),
			array('N~O~2~2',$this->usrdotd3com,2,'usrdotd3com - 4'),
			array('N~O~2~2',$this->usrcoma3dot,2,'usrcoma3dot - 5'),
			array('N~O~2~2',$this->usrdota3comdollar,2,'usrdota3comdollar - 6'),

			array('I~M',$this->usrdota0x,0,'usrdota0x - 2'),
			array('I~M',$this->usrcomd0x,0,'usrcomd0x - 3'),
			array('I~M',$this->usrdotd3com,0,'usrdotd3com - 4'),
			array('I~M',$this->usrcoma3dot,0,'usrcoma3dot - 5'),
			array('I~M',$this->usrdota3comdollar,0,'usrdota3comdollar - 6'),
			array('C~M',$this->usrdota0x,0,'usrdota0x - 2'),
			array('C~M',$this->usrcomd0x,0,'usrcomd0x - 3'),
			array('C~M',$this->usrdotd3com,0,'usrdotd3com - 4'),
			array('C~M',$this->usrcoma3dot,0,'usrcoma3dot - 5'),
			array('C~M',$this->usrdota3comdollar,0,'usrdota3comdollar - 6'),
			array('V~O',$this->usrdota0x,0,'usrdota0x - 2'),
			array('V~O',$this->usrcomd0x,0,'usrcomd0x - 3'),
			array('V~O',$this->usrdotd3com,0,'usrdotd3com - 4'),
			array('V~O',$this->usrcoma3dot,0,'usrcoma3dot - 5'),
			array('V~O',$this->usrdota3comdollar,0,'usrdota3comdollar - 6'),
		);
	}

	/**
	 * Method testgetDecimalsFromTypeOfData
	 * @test
	 * @dataProvider getDecimalsFromTypeOfDataProvider
	 */
	public function testgetDecimalsFromTypeOfData($typeofdata,$userid,$expected,$userformat) {
		global $current_user;
		$huser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($userid);
		$current_user = $user;
		$actual = CurrencyField::getDecimalsFromTypeOfData($typeofdata);
		$this->assertEquals($expected, $actual,"getDecimalsFromTypeOfData $typeofdata $userformat");
		$current_user = $huser;
	}

	/**
	 * Method testgetDecimalsFromTypeOfData
	 * @test
	 */
	public function testgetMultiCurrencyInfoFrom() {
		include_once 'include/utils/InventoryUtils.php';
		$actual = CurrencyField::getMultiCurrencyInfoFrom('Invoice',3446); // USD
		$expected = array(
			'currency_id' => '2',
			'conversion_rate' => '1.100',
			'currency_name' => 'USA, Dollars',
			'currency_code' => 'USD',
			'currency_symbol' => '$',
			'currency_position' => '$1.0',
		);
		$this->assertEquals($expected, $actual,"getMultiCurrencyInfoFrom Invoice USD");
		$actual = CurrencyField::getMultiCurrencyInfoFrom('Invoice',3419); // EUR
		$expected = array(
			'currency_id' => '1',
			'conversion_rate' => '1.000',
			'currency_name' => 'Euro',
			'currency_code' => 'EUR',
			'currency_symbol' => '&euro;',
			'currency_position' => '1.0$',
		);
		$this->assertEquals($expected, $actual,"getMultiCurrencyInfoFrom Invoice EUR");
		$actual = getInventoryCurrencyInfo('Invoice',3446); // USD
		$expected = array(
			'currency_id' => '2',
			'conversion_rate' => '1.100',
			'currency_name' => 'USA, Dollars',
			'currency_code' => 'USD',
			'currency_symbol' => '$',
			'currency_position' => '$1.0',
		);
		$this->assertEquals($expected, $actual,"getInventoryCurrencyInfo Invoice USD");
		$actual = getInventoryCurrencyInfo('Invoice',3419); // EUR
		$expected = array(
			'currency_id' => '1',
			'conversion_rate' => '1.000',
			'currency_name' => 'Euro',
			'currency_code' => 'EUR',
			'currency_symbol' => '&euro;',
			'currency_position' => '1.0$',
		);
		$this->assertEquals($expected, $actual,"getInventoryCurrencyInfo Invoice EUR");
		$actual = CurrencyField::getMultiCurrencyInfoFrom('SalesOrder',11172);
		$expected = array(
			'currency_id' => '1',
			'conversion_rate' => '1.000',
			'currency_name' => 'Euro',
			'currency_code' => 'EUR',
			'currency_symbol' => '&euro;',
			'currency_position' => '1.0$',
		);
		$this->assertEquals($expected, $actual,"getMultiCurrencyInfoFrom SalesOrder");
		$actual = CurrencyField::getMultiCurrencyInfoFrom('Quotes',12418);
		$expected = array(
			'currency_id' => '1',
			'conversion_rate' => '1.000',
			'currency_name' => 'Euro',
			'currency_code' => 'EUR',
			'currency_symbol' => '&euro;',
			'currency_position' => '1.0$',
		);
		$this->assertEquals($expected, $actual,"getMultiCurrencyInfoFrom Quotes");
		$actual = CurrencyField::getMultiCurrencyInfoFrom('PurchaseOrder',13656);
		$expected = array(
			'currency_id' => '1',
			'conversion_rate' => '1.000',
			'currency_name' => 'Euro',
			'currency_code' => 'EUR',
			'currency_symbol' => '&euro;',
			'currency_position' => '1.0$',
		);
		$this->assertEquals($expected, $actual,"getMultiCurrencyInfoFrom PurchaseOrder");
	}

}
?>