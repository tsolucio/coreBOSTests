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

class testCurrencyField extends PHPUnit_Framework_TestCase {

	/****
	 * TEST Users decimal configuration
	 * name format is: {decimal_separator}{symbol_position}{grouping}{grouping_symbol}{currency}
	 ****/
	var $usrdota0x = 5; // testdmy
	var $usrcomd0x = 6; // testmdy
	var $usrdotd3com = 7; // testymd
	var $usrcoma3dot = 10; // testtz
	var $usrdota3comdollar = 12; // testmcurrency

	/**
	 * Method testgetCurrencyInformation
	 * @test
	 */
	public function testgetCurrencyInformation() {
		$testcurrency = 42654016.022589;
		$converted2Dollar = $testcurrency * 1.1; // 46919417.6248479
		$converted = convertToDollar(46919417.6248479, 1.1);
		$this->assertEquals(round(42654016.022589,6), round($converted,6), 'convertToDollar');
		$converted = convertFromDollar(42654016.022589, 1.1);
		$this->assertEquals(round(46919417.6248479,2), $converted, 'convertFromDollar');
		$dbCurrency = CurrencyField::getDBCurrencyId();
		$this->assertEquals(1, $dbCurrency, 'getDBCurrencyId');
		$currencyField = new CurrencyField($testcurrency);
		$this->assertEquals(3, $currencyField->numberOfDecimal, 'numberOfDecimal');
		$currencyField->setNumberofDecimals(6);
		$this->assertEquals(6, $currencyField->numberOfDecimal, 'set numberOfDecimal');
		$currencyField->numberOfDecimal = 4;
		$this->assertEquals(4, $currencyField->numberOfDecimal, 'assign numberOfDecimal');
		$formattedCurrencyValue = CurrencyField::appendCurrencySymbol($testcurrency, 'S');
		$this->assertEquals("S$testcurrency", $formattedCurrencyValue,'appendCurrencySymbol in front');
		$formattedCurrencyValue = CurrencyField::appendCurrencySymbol($testcurrency, 'S','1.0$');
		$this->assertEquals($testcurrency.'S', $formattedCurrencyValue,'appendCurrencySymbol in back');
		/////////////////
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x);
		$currencyField->initialize($user);
		$this->assertEquals('123456789', $currencyField->currencyFormat, 'currencyFormat usrdota0x');
		$this->assertEquals(',', $currencyField->currencySeparator, 'currencySeparator usrdota0x');
		$this->assertEquals('.', $currencyField->decimalSeparator, 'decimalSeparator usrdota0x');
		$this->assertEquals(1, $currencyField->currencyId, 'currencyId usrdota0x');
		$this->assertEquals('&euro;', $currencyField->currencySymbol, 'currencySymbol usrdota0x');
		$this->assertEquals(1, $currencyField->conversionRate, 'conversionRate usrdota0x');
		$this->assertEquals('$1.0', $currencyField->currencySymbolPlacement, 'currencySymbolPlacement usrdota0x');
		
		$user->retrieveCurrentUserInfoFromFile($this->usrcomd0x);
		$currencyField->initialize($user);
		$this->assertEquals('123456789', $currencyField->currencyFormat, 'currencyFormat usrcomd0x');
		$this->assertEquals('.', $currencyField->currencySeparator, 'currencySeparator usrcomd0x');
		$this->assertEquals(',', $currencyField->decimalSeparator, 'decimalSeparator usrcomd0x');
		$this->assertEquals(1, $currencyField->currencyId, 'currencyId usrcomd0x');
		$this->assertEquals('&euro;', $currencyField->currencySymbol, 'currencySymbol usrcomd0x');
		$this->assertEquals(1, $currencyField->conversionRate, 'conversionRate usrcomd0x');
		$this->assertEquals('1.0$', $currencyField->currencySymbolPlacement, 'currencySymbolPlacement usrcomd0x');

		$user->retrieveCurrentUserInfoFromFile($this->usrdotd3com);
		$currencyField->initialize($user);
		$this->assertEquals('123,456,789', $currencyField->currencyFormat, 'currencyFormat usrdotd3com');
		$this->assertEquals(',', $currencyField->currencySeparator, 'currencySeparator usrdotd3com');
		$this->assertEquals('.', $currencyField->decimalSeparator, 'decimalSeparator usrdotd3com');
		$this->assertEquals(1, $currencyField->currencyId, 'currencyId usrdotd3com');
		$this->assertEquals('&euro;', $currencyField->currencySymbol, 'currencySymbol usrdotd3com');
		$this->assertEquals(1, $currencyField->conversionRate, 'conversionRate usrdotd3com');
		$this->assertEquals('1.0$', $currencyField->currencySymbolPlacement, 'currencySymbolPlacement usrdotd3com');

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
		$this->assertEquals('$1.0', $currencyField->currencySymbolPlacement, 'currencySymbolPlacement usrcoma3dot');

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
	}

	/**
	 * Method testconvertToUserFormat
	 * @test
	 */
	public function testconvertToUserFormat() {
		$user = new Users();
		$testcurrency = 42654016.022589;
		$currencyField = new CurrencyField($testcurrency);
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$this->assertEquals('42654016.02', $formattedCurrencyValue,'getDisplayValue usrdota0x');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertEquals('&euro;42654016.02', $formattedCurrencyValue,'getDisplayValueWithSymbol usrdota0x');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertEquals('42654016.02', $formattedCurrencyValue,'convertToUserFormat noskip usrdota0x');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrency, $formattedCurrencyValue,'convertToUserFormat skip usrdota0x');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrcomd0x);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$this->assertEquals('42654016,02', $formattedCurrencyValue,'getDisplayValue usrcomd0x');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertEquals('42654016,02&euro;', $formattedCurrencyValue,'getDisplayValueWithSymbol usrcomd0x');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertEquals('42654016,02', $formattedCurrencyValue,'convertToUserFormat noskip usrcomd0x');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertEquals('42654016,022589', $formattedCurrencyValue,'convertToUserFormat skip usrcomd0x');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrdotd3com);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$this->assertEquals('42,654,016.02', $formattedCurrencyValue,'getDisplayValue usrdotd3com');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertEquals('42,654,016.02&euro;', $formattedCurrencyValue,'getDisplayValueWithSymbol usrdotd3com');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertEquals('42,654,016.02', $formattedCurrencyValue,'convertToUserFormat noskip usrdotd3com');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertEquals('42,654,016.022589', $formattedCurrencyValue,'convertToUserFormat skip usrdotd3com');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrcoma3dot);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$this->assertEquals('42.654.016,02', $formattedCurrencyValue,'getDisplayValue usrcoma3dot');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertEquals('&euro;42.654.016,02', $formattedCurrencyValue,'getDisplayValueWithSymbol usrcoma3dot');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertEquals('42.654.016,02', $formattedCurrencyValue,'convertToUserFormat noskip usrcoma3dot');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertEquals('42.654.016,022589', $formattedCurrencyValue,'convertToUserFormat skip usrcoma3dot');
		/////////////////
		$converted2Dollar = $testcurrency * 1.1; // 46919417.6248479
		$user->retrieveCurrentUserInfoFromFile($this->usrdota3comdollar);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$this->assertEquals('46,919,417.62', $formattedCurrencyValue,'getDisplayValue usrdota3comdollar');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertEquals('$46,919,417.62', $formattedCurrencyValue,'getDisplayValueWithSymbol usrdota3comdollar');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertEquals('46,919,417.62', $formattedCurrencyValue,'convertToUserFormat noskip usrdota3comdollar');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertEquals('42,654,016.022589', $formattedCurrencyValue,'convertToUserFormat skip usrdota3comdollar');
	}

	/**
	 * Method testconvertToUserFormatNegative
	 * @test
	 */
	public function testconvertToUserFormatNegative() {
		$user = new Users();
		$testcurrency = -42654016.022589;
		$currencyField = new CurrencyField($testcurrency);
		$user->retrieveCurrentUserInfoFromFile($this->usrdota0x);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$this->assertEquals('-42654016.02', $formattedCurrencyValue,'getDisplayValue Negative usrdota0x');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertEquals('&euro;-42654016.02', $formattedCurrencyValue,'getDisplayValueWithSymbol Negative usrdota0x');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertEquals('-42654016.02', $formattedCurrencyValue,'convertToUserFormat noskip Negative usrdota0x');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertEquals($testcurrency, $formattedCurrencyValue,'convertToUserFormat skip Negative usrdota0x');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrcomd0x);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$this->assertEquals('-42654016,02', $formattedCurrencyValue,'getDisplayValue Negative usrcomd0x');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertEquals('-42654016,02&euro;', $formattedCurrencyValue,'getDisplayValueWithSymbol Negative usrcomd0x');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertEquals('-42654016,02', $formattedCurrencyValue,'convertToUserFormat noskip Negative usrcomd0x');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertEquals('-42654016,022589', $formattedCurrencyValue,'convertToUserFormat skip Negative usrcomd0x');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrdotd3com);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$this->assertEquals('-42,654,016.02', $formattedCurrencyValue,'getDisplayValue Negative usrdotd3com');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertEquals('-42,654,016.02&euro;', $formattedCurrencyValue,'getDisplayValueWithSymbol Negative usrdotd3com');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertEquals('-42,654,016.02', $formattedCurrencyValue,'convertToUserFormat noskip Negative usrdotd3com');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertEquals('-42,654,016.022589', $formattedCurrencyValue,'convertToUserFormat skip Negative usrdotd3com');
		/////////////////
		$user->retrieveCurrentUserInfoFromFile($this->usrcoma3dot);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$this->assertEquals('-42.654.016,02', $formattedCurrencyValue,'getDisplayValue Negative usrcoma3dot');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertEquals('&euro;-42.654.016,02', $formattedCurrencyValue,'getDisplayValueWithSymbol Negative usrcoma3dot');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertEquals('-42.654.016,02', $formattedCurrencyValue,'convertToUserFormat noskip Negative usrcoma3dot');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertEquals('-42.654.016,022589', $formattedCurrencyValue,'convertToUserFormat skip Negative usrcoma3dot');
		/////////////////
		$converted2Dollar = $testcurrency * 1.1; // 46919417.6248479
		$user->retrieveCurrentUserInfoFromFile($this->usrdota3comdollar);
		$formattedCurrencyValue = $currencyField->getDisplayValue($user);
		$this->assertEquals('-46,919,417.62', $formattedCurrencyValue,'getDisplayValue Negative usrdota3comdollar');
		$formattedCurrencyValue = $currencyField->getDisplayValueWithSymbol($user);
		$this->assertEquals('$-46,919,417.62', $formattedCurrencyValue,'getDisplayValueWithSymbol Negative usrdota3comdollar');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, false);
		$this->assertEquals('-46,919,417.62', $formattedCurrencyValue,'convertToUserFormat noskip Negative usrdota3comdollar');
		$formattedCurrencyValue = CurrencyField::convertToUserFormat($testcurrency, $user, true);
		$this->assertEquals('-42,654,016.022589', $formattedCurrencyValue,'convertToUserFormat skip Negative usrdota3comdollar');
	}

	/**
	 * Method testconvertToDBFormat
	 * @test
	 */
	public function testconvertToDBFormat() {
		$user = new Users();
		$testcurrency = 42654016.022589;
		$currencyField = new CurrencyField($testcurrency);
		$testcurrencyrounded = round($testcurrency,$currencyField->numberOfDecimal);
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
		$testcurrencyrounded = round($testcurrency,$currencyField->numberOfDecimal);
		$converted2Dollar = $testcurrency * 1.1; // 46919417,624848
		$converted2DollarRounded = round($converted2Dollar,$currencyField->numberOfDecimal);
		$currencyField = new CurrencyField('46,919,417.624848');
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue noskip usrdota3comdollar');
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, true);
		$this->assertEquals($converted2DollarRounded, $formattedCurrencyValue,'getDBInsertedValue skip usrdota3comdollar');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($converted2Dollar, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat noskip usrdota3comdollar');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($converted2Dollar, $user, true);
		$this->assertEquals($converted2DollarRounded, $formattedCurrencyValue,'convertToDBFormat skip usrdota3comdollar');
		/////////////////
		// currency symbol not supported as input
		$currencyField = new CurrencyField('$46,919,417.624848');
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, false);
		$this->assertEquals(0, $formattedCurrencyValue,'getDBInsertedValue noskip usrdota3comdollar WITH SYMBOL');
	}

	/**
	 * Method testconvertToDBFormatNegative
	 * @test
	 */
	public function testconvertToDBFormatNegative() {
		$user = new Users();
		$testcurrency = -42654016.022589;
		$currencyField = new CurrencyField($testcurrency);
		$testcurrencyrounded = round($testcurrency,$currencyField->numberOfDecimal);
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
		$testcurrencyrounded = round($testcurrency,$currencyField->numberOfDecimal);
		$converted2Dollar = $testcurrency * 1.1; // 46919417,624848
		$converted2DollarRounded = round($converted2Dollar,$currencyField->numberOfDecimal);
		$currencyField = new CurrencyField('-46,919,417.624848');
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'getDBInsertedValue noskip Negative usrdota3comdollar');
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, true);
		$this->assertEquals($converted2DollarRounded, $formattedCurrencyValue,'getDBInsertedValue skip Negative usrdota3comdollar');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($converted2Dollar, $user, false);
		$this->assertEquals($testcurrencyrounded, $formattedCurrencyValue,'convertToDBFormat noskip Negative usrdota3comdollar');
		$formattedCurrencyValue = CurrencyField::convertToDBFormat($converted2Dollar, $user, true);
		$this->assertEquals($converted2DollarRounded, $formattedCurrencyValue,'convertToDBFormat skip Negative usrdota3comdollar');
		/////////////////
		// currency symbol not supported as input
		$currencyField = new CurrencyField('$-46,919,417.624848');
		$formattedCurrencyValue = $currencyField->getDBInsertedValue($user, false);
		$this->assertEquals(0, $formattedCurrencyValue,'getDBInsertedValue noskip Negative usrdota3comdollar WITH SYMBOL');
	}

}
?>