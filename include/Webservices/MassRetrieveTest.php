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

include_once 'include/Webservices/MassRetrieve.php';

class MassRetrieveTest extends TestCase {

	/****
	 * TEST Users decimal configuration
	 * name format is: {decimal_separator}{symbol_position}{grouping}{grouping_symbol}{currency}
	 ****/
	public $usrdota0x = 5; // testdmy
	public $usrcomd0x = 6; // testmdy
	public $usrdotd3com = 7; // testymd
	public $usrcoma3dot = 10; // testtz
	public $usrdota3comdollar = 12; // testmcurrency

	/**
	 * Method testAccounts
	 * @test
	 */
	public function testAccounts() {
		global $current_user;
		$actual = vtws_massretrieve('11x74,11x84,11x999999', $current_user);
		$expected = array(
			'11x74' => array(
				'accountname' => 'Chemex Labs Ltd',
				'account_no' => 'ACC1',
				'website' => 'http://www.chemexlabsltd.com.au',
				'phone' => '03-3608-5660',
				'tickersymbol' => '',
				'fax' => '',
				'account_id' => '11x746',
				'otherphone' => '0487-835-113',
				'employees' => '131',
				'email1' => 'lina@yahoo.com',
				'email2' => '',
				'ownership' => '',
				'industry' => 'Engineering',
				'rating' => 'Active',
				'accounttype' => 'Press',
				'siccode' => '',
				'emailoptout' => '1',
				'annual_revenue' => '3045164.000000',
				'assigned_user_id' => '19x10',
				'notify_owner' => '0',
				'modifiedtime' => '2016-04-02 18:21:14',
				'createdtime' => '2015-03-13 18:24:30',
				'modifiedby' => '19x1',
				'isconvertedfromlead' => '',
				'convertedfromlead' => '',
				'created_user_id' => '19x1',
				'cf_718' => '',
				'cf_719' => '2.00',
				'cf_720' => '0.00',
				'cf_721' => '0.000000',
				'cf_722' => '2016-02-15',
				'cf_723' => '',
				'cf_724' => '',
				'cf_725' => '',
				'cf_726' => '0',
				'cf_727' => '',
				'cf_728' => '00:00:00',
				'cf_729' => 'one',
				'cf_730' => 'oneone',
				'cf_731' => 'oneoneone',
				'cf_732' => 'Adipose 3 |##| Chronos |##| Earth',
				'bill_street' => 'C/ Joan Fuster 12',
				'ship_street' => 'C/ Joan Fuster 12',
				'bill_pobox' => '',
				'ship_pobox' => '',
				'bill_city' => 'Els Poblets',
				'ship_city' => 'Els Poblets',
				'bill_state' => 'Alicante',
				'ship_state' => 'Alicante',
				'bill_code' => '03779',
				'ship_code' => '03779',
				'bill_country' => 'Spain',
				'ship_country' => 'Spain',
				'description' => 'Aut unde est hoc contritum vetustate proverbium: quicum in tenebris? Nec vero alia sunt quaerenda contra Carneadeam illam sententiam. Nemo igitur esse beatus potest. Nummus in Croesi divitiis obscuratur, pars est tamen divitiarum.',
				'id' => '11x74',
				'cbuuid' => 'b0857db0c1dee95300a10982853f5fb1d4e981c1',
				'account_idename' => array(
					'module' => 'Accounts',
					'reference' => 'Rowley Schlimgen Inc',
					'cbuuid' => '88cbf7cc2c70eec1e2c733a6624a8eb427c8eb1e',
				),
				'modifiedbyename' => array(
					'module' => 'Users',
					'reference' => ' Administrator',
					'cbuuid' => '',
				),
				'created_user_idename' => array(
					'module' => 'Users',
					'reference' => ' Administrator',
					'cbuuid' => '',
				),
				'assigned_user_idename' => array(
					'module' => 'Users',
					'reference' => 'cbTest testtz',
					'cbuuid' => '',
				),
			),
			'11x84' => array(
				'accountname' => 'Levinson Axelrod Wheaton',
				'account_no' => 'ACC11',
				'website' => 'http://www.levinsonaxelrodwheaton.com',
				'phone' => '561-470-4574',
				'tickersymbol' => '',
				'fax' => '',
				'account_id' => '',
				'otherphone' => '561-951-9734',
				'employees' => '74',
				'email1' => 'joanna_leinenbach@hotmail.com',
				'email2' => '',
				'ownership' => '',
				'industry' => 'Government',
				'rating' => 'Active',
				'accounttype' => 'Partner',
				'siccode' => '',
				'emailoptout' => '1',
				'annual_revenue' => '793295.000000',
				'assigned_user_id' => '19x7',
				'notify_owner' => '0',
				'modifiedtime' => '2015-08-30 22:09:12',
				'createdtime' => '2015-03-13 19:33:13',
				'modifiedby' => '19x1',
				'isconvertedfromlead' => '',
				'convertedfromlead' => '',
				'created_user_id' => '19x1',
				'cf_718' => '',
				'cf_719' => '',
				'cf_720' => '',
				'cf_721' => '',
				'cf_722' => '',
				'cf_723' => '',
				'cf_724' => '',
				'cf_725' => '',
				'cf_726' => '0',
				'cf_727' => '',
				'cf_728' => '',
				'cf_729' => '',
				'cf_730' => '',
				'cf_731' => '',
				'cf_732' => '',
				'bill_street' => '1 Washington St',
				'ship_street' => '1 Washington St',
				'bill_pobox' => '',
				'ship_pobox' => '',
				'bill_city' => 'Lake Worth',
				'ship_city' => 'Lake Worth',
				'bill_state' => 'FL',
				'ship_state' => 'FL',
				'bill_code' => '33461',
				'ship_code' => '33461',
				'bill_country' => 'United States of America',
				'ship_country' => 'United States of America',
				'description' => ' Ille vero, si insipiens-quo certe, quoniam tyrannus -, numquam beatus; Octavio fuit, cum illam severitatem in eo filio adhibuit, quem in adoptionem D. Et quidem Arcesilas tuus, etsi fuit in disserendo pertinacior, tamen noster fuit; Non enim iam stirpis bonum quaeret, sed animalis. Duo Reges: constructio interrete. Tum ille timide vel potius verecunde: Facio, inquit. Non igitur potestis voluptate omnia dirigentes aut tueri aut retinere virtutem. Hoc etsi multimodis reprehendi potest, tamen accipio, quod dant. Quis istud possit, inquit, negare? Tu vero, inquam, ducas licet, si sequetur; Quid, de quo nulla dissensio est? Videmus igitur ut conquiescere ne infantes quidem possint. 

',
				'id' => '11x84',
				'cbuuid' => 'bcc5c028261a21e68d61518c76059114ef6fff44',
				'modifiedbyename' => array(
					'module' => 'Users',
					'reference' => ' Administrator',
					'cbuuid' => '',
				),
				'created_user_idename' => array(
					'module' => 'Users',
					'reference' => ' Administrator',
					'cbuuid' => '',
				),
				'assigned_user_idename' => array(
					'module' => 'Users',
					'reference' => 'cbTest testymd',
					'cbuuid' => '',
				),
			),
		);
		$this->assertEquals($expected, $actual, 'MassRetrieve');
	}

	/**
	 * Method testActor
	 * @test
	 */
	public function testActor() {
		global $current_user;
		$actual = vtws_massretrieve('21x1,21x2,21x999999', $current_user);
		$expected = array(
			'21x1' => array(
				'id' => '21x1',
				'currency_name' => 'Euro',
				'currency_code' => 'EUR',
				'currency_symbol' => '€',
				'conversion_rate' => '1.000000',
				'currency_status' => 'Active',
				'defaultid' => '-11',
				'deleted' => '0',
				'currency_position' => '1.0$',
			),
			'21x2' => array(
				'id' => '21x2',
				'currency_name' => 'USA, Dollars',
				'currency_code' => 'USD',
				'currency_symbol' => '$',
				'conversion_rate' => '1.100000',
				'currency_status' => 'Active',
				'defaultid' => '0',
				'deleted' => '0',
				'currency_position' => '$1.0',
			),
		);
		$this->assertEquals($expected, $actual, 'MassRetrieve Actor');
	}

	/**
	 * Method testInventoryModule
	 * @test
	 */
	public function testInventoryModule() {
		global $current_user;
		$actual = vtws_massretrieve('7x2958,7x2973', $current_user);
		$expected = array(
			'7x2958' => array(
				'id' => '7x2958',
				'conversion_rate' => '1.000',
				'subject' => 'Rebecca Agee',
				'salesorder_id' => '6x11787',
				'customerno' => '18583789-0',
				'invoice_no' => 'INV13',
				'contact_id' => '12x1471',
				'invoicedate' => '2016-04-02',
				'duedate' => '2016-07-24',
				'vtiger_purchaseorder' => '',
				'txtAdjustment' => '0.000000',
				'exciseduty' => '0.000',
				'hdnSubTotal' => '4544.980000',
				'salescommission' => '0.000',
				'hdnGrandTotal' => '5772.120000',
				'hdnTaxType' => 'group',
				'hdnDiscountPercent' => '0.000',
				'hdnDiscountAmount' => '0.000000',
				'hdnS_H_Amount' => '0.000000',
				'account_id' => '11x2957',
				'invoicestatus' => 'Paid',
				'assigned_user_id' => '19x9',
				'createdtime' => '2015-04-09 22:54:49',
				'modifiedtime' => '2015-11-27 01:55:49',
				'currency_id' => '21x1',
				'modifiedby' => '19x1',
				'created_user_id' => '19x1',
				'bill_street' => '14288 Foster Ave #4121',
				'ship_street' => '14288 Foster Ave #4121',
				'bill_pobox' => '',
				'ship_pobox' => '',
				'bill_city' => 'Jenkintown',
				'ship_city' => 'Jenkintown',
				'bill_state' => 'PA',
				'ship_state' => 'PA',
				'bill_code' => '19046',
				'ship_code' => '19046',
				'bill_country' => 'United States of America',
				'ship_country' => 'United States of America',
				'terms_conditions' => '',
				'tandc' => '',
				'description' => '',
				'pl_gross_total' => '4544.980000',
				'pl_dto_line' => '0.000000',
				'pl_dto_total' => '0.000000',
				'pl_dto_global' => '0.000000',
				'pl_net_total' => '4544.980000',
				'sum_nettotal' => '4544.980000',
				'sum_taxtotal' => '1227.144600',
				'sum_tax1' => '204.524100',
				'sum_taxtotalretention' => '0.000000',
				'sum_tax2' => '454.498000',
				'pl_sh_total' => '0.000000',
				'sum_tax3' => '568.122500',
				'pl_sh_tax' => '0.000000',
				'pl_grand_total' => '5772.120000',
				'pl_adjustment' => '0.000000',
				'cbuuid' => '22c12309c152cfc9ddcf7a9f232d06c4e962b469',
				'salesorder_idename' => array(
					'module' => 'SalesOrder',
					'reference' => 'Ricardo Amegos',
					'cbuuid' => 'cf8d08405e603ec8d925e6220c550b1906f6e03c',
				),
				'contact_idename' => array(
					'module' => 'Contacts',
					'reference' => 'Toi Rollison',
					'cbuuid' => '64e4da7232d6cb8b878f12dfdf9401aae149bcb9',
				),
				'account_idename' => array(
					'module' => 'Accounts',
					'reference' => 'Branford Wire & Mfg Co',
					'cbuuid' => '1ff07272324e0e8c91bf3b60657dfc7f91271d7c',
				),
				'currency_idename' => array(
					'module' => 'Currency',
					'reference' => 'Euro : &euro;',
					'cbuuid' => '',
				),
				'modifiedbyename' => array(
					'module' => 'Users',
					'reference' => ' Administrator',
					'cbuuid' => '',
				),
				'created_user_idename' => array(
					'module' => 'Users',
					'reference' => ' Administrator',
					'cbuuid' => '',
				),
				'assigned_user_idename' => array(
					'module' => 'Users',
					'reference' => 'cbTest testinactive',
					'cbuuid' => '',
				),
				'pdoInformation' => array(
					array(
						'productid' => '9717',
						'wsproductid' => '26x9717',
						'linetype' => 'Services',
						'comment' => '',
						'qty' => '3.000',
						'listprice' => '141.820000',
						'discount' => 0,
						'discount_type' => 0,
						'discount_percentage' => 0,
						'discount_amount' => 0,
					),
					array(
						'productid' => '2620',
						'wsproductid' => '14x2620',
						'linetype' => 'Products',
						'comment' => '',
						'qty' => '10.000',
						'listprice' => '117.650000',
						'discount' => 0,
						'discount_type' => 0,
						'discount_percentage' => 0,
						'discount_amount' => 0,
					),
					array(
						'productid' => '9736',
						'wsproductid' => '26x9736',
						'linetype' => 'Services',
						'comment' => '',
						'qty' => '4.000',
						'listprice' => '138.540000',
						'discount' => 0,
						'discount_type' => 0,
						'discount_percentage' => 0,
						'discount_amount' => 0,
					),
					array(
						'productid' => '9716',
						'wsproductid' => '26x9716',
						'linetype' => 'Services',
						'comment' => '',
						'qty' => '7.000',
						'listprice' => '141.820000',
						'discount' => 0,
						'discount_type' => 0,
						'discount_percentage' => 0,
						'discount_amount' => 0,
					),
					array(
						'productid' => '2616',
						'wsproductid' => '14x2616',
						'linetype' => 'Products',
						'comment' => '',
						'qty' => '9.000',
						'listprice' => '48.610000',
						'discount' => 0,
						'discount_type' => 0,
						'discount_percentage' => 0,
						'discount_amount' => 0,
					),
				),
			),
			'7x2973' => array(
				'id' => '7x2973',
				'conversion_rate' => '1.000',
				'subject' => 'Electric Eve',
				'salesorder_id' => '6x11226',
				'customerno' => '9823190-0',
				'invoice_no' => 'INV15',
				'contact_id' => '12x1953',
				'invoicedate' => '2015-04-03',
				'duedate' => '2015-05-23',
				'vtiger_purchaseorder' => '',
				'txtAdjustment' => '0.000000',
				'exciseduty' => '0.000',
				'hdnSubTotal' => '3586.350000',
				'salescommission' => '0.000',
				'hdnGrandTotal' => '4554.660000',
				'hdnTaxType' => 'group',
				'hdnDiscountPercent' => '0.000',
				'hdnDiscountAmount' => '0.000000',
				'hdnS_H_Amount' => '0.000000',
				'account_id' => '11x2972',
				'invoicestatus' => 'Sent',
				'assigned_user_id' => '19x5',
				'createdtime' => '2015-04-10 03:01:35',
				'modifiedtime' => '2015-11-06 13:38:54',
				'currency_id' => '21x1',
				'modifiedby' => '19x1',
				'created_user_id' => '19x1',
				'bill_street' => '7 Lear Rd',
				'ship_street' => '7 Lear Rd',
				'bill_pobox' => '',
				'ship_pobox' => '',
				'bill_city' => 'Stroud',
				'ship_city' => 'Stroud',
				'bill_state' => 'Hampshire',
				'ship_state' => 'Hampshire',
				'bill_code' => 'GU32 3PQ',
				'ship_code' => 'GU32 3PQ',
				'bill_country' => 'United Kingdom',
				'ship_country' => 'United Kingdom',
				'terms_conditions' => '',
				'tandc' => '',
				'description' => '',
				'pl_gross_total' => '3586.350000',
				'pl_dto_line' => '0.000000',
				'pl_dto_total' => '0.000000',
				'pl_dto_global' => '0.000000',
				'pl_net_total' => '3586.350000',
				'sum_nettotal' => '3586.350000',
				'sum_taxtotal' => '968.314500',
				'sum_tax1' => '161.385750',
				'sum_taxtotalretention' => '0.000000',
				'sum_tax2' => '358.635000',
				'pl_sh_total' => '0.000000',
				'sum_tax3' => '448.293750',
				'pl_sh_tax' => '0.000000',
				'pl_grand_total' => '4554.660000',
				'pl_adjustment' => '0.000000',
				'cbuuid' => '3cadafeb0f458ba80555945bc2eed0c3ba398118',
				'salesorder_idename' => array(
					'module' => 'SalesOrder',
					'reference' => 'Azaziah',
					'cbuuid' => '4f49ef66b1020de6dd6f265bc8289826dcb15bbf',
				),
				'contact_idename' => array(
					'module' => 'Contacts',
					'reference' => 'Valene Madson',
					'cbuuid' => '9f67d22a89ec952a3fafab1ab66f294f2259f173',
				),
				'account_idename' => array(
					'module' => 'Accounts',
					'reference' => 'Central Hrdwr & Elec Corp',
					'cbuuid' => 'da05331163e81b55fe7f8d6777f6342d651b7dc9',
				),
				'currency_idename' => array(
					'module' => 'Currency',
					'reference' => 'Euro : &euro;',
					'cbuuid' => '',
				),
				'modifiedbyename' => array(
					'module' => 'Users',
					'reference' => ' Administrator',
					'cbuuid' => '',
				),
				'created_user_idename' => array(
					'module' => 'Users',
					'reference' => ' Administrator',
					'cbuuid' => '',
				),
				'assigned_user_idename' => array(
					'module' => 'Users',
					'reference' => 'cbTest testdmy',
					'cbuuid' => '',
				),
				'pdoInformation' => array(
					array(
						'productid' => '9717',
						'wsproductid' => '26x9717',
						'linetype' => 'Services',
						'comment' => '',
						'qty' => '3.000',
						'listprice' => '141.820000',
						'discount' => 0,
						'discount_type' => 0,
						'discount_percentage' => 0,
						'discount_amount' => 0,
					),
					array(
						'productid' => '2620',
						'wsproductid' => '14x2620',
						'linetype' => 'Products',
						'comment' => '',
						'qty' => '10.000',
						'listprice' => '117.650000',
						'discount' => 0,
						'discount_type' => 0,
						'discount_percentage' => 0,
						'discount_amount' => 0,
					),
					array(
						'productid' => '9736',
						'wsproductid' => '26x9736',
						'linetype' => 'Services',
						'comment' => '',
						'qty' => '4.000',
						'listprice' => '138.540000',
						'discount' => 0,
						'discount_type' => 0,
						'discount_percentage' => 0,
						'discount_amount' => 0,
					),
					array(
						'productid' => '9716',
						'wsproductid' => '26x9716',
						'linetype' => 'Services',
						'comment' => '',
						'qty' => '7.000',
						'listprice' => '141.820000',
						'discount' => 0,
						'discount_type' => 0,
						'discount_percentage' => 0,
						'discount_amount' => 0,
					),
					array(
						'productid' => '2616',
						'wsproductid' => '14x2616',
						'linetype' => 'Products',
						'comment' => '',
						'qty' => '9.000',
						'listprice' => '48.610000',
						'discount' => 0,
						'discount_type' => 0,
						'discount_percentage' => 0,
						'discount_amount' => 0,
					),
				),
			),
		);
		$this->assertEquals($expected, $actual, 'MassRetrieve');
	}

	/**
	 * Method testMixedWithActor
	 * @test
	 */
	public function testMixedWithActor() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		vtws_massretrieve('11x74,21x1,12x999999', $current_user);
	}

	/**
	 * Method testMixed
	 * @test
	 */
	public function testMixed() {
		global $current_user;
		$actual = vtws_massretrieve('11x74,12x1084,0,', $current_user);
		$expected = array(
			'11x74' => array(
				'phone' => '03-3608-5660',
				'fax' => '',
				'account_id' => '11x746',
				'otherphone' => '0487-835-113',
				'emailoptout' => '1',
				'assigned_user_id' => '19x10',
				'notify_owner' => '0',
				'modifiedtime' => '2016-04-02 18:21:14',
				'createdtime' => '2015-03-13 18:24:30',
				'modifiedby' => '19x1',
				'isconvertedfromlead' => '',
				'convertedfromlead' => '',
				'created_user_id' => '19x1',
				'description' => 'Aut unde est hoc contritum vetustate proverbium: quicum in tenebris? Nec vero alia sunt quaerenda contra Carneadeam illam sententiam. Nemo igitur esse beatus potest. Nummus in Croesi divitiis obscuratur, pars est tamen divitiarum.',
				'id' => '12x74',
				'cbuuid' => 'b0857db0c1dee95300a10982853f5fb1d4e981c1',
				'account_idename' => array(
					'module' => 'Accounts',
					'reference' => 'Rowley Schlimgen Inc',
					'cbuuid' => '88cbf7cc2c70eec1e2c733a6624a8eb427c8eb1e',
				),
				'modifiedbyename' => array(
					'module' => 'Users',
					'reference' => ' Administrator',
					'cbuuid' => '',
				),
				'created_user_idename' => array(
					'module' => 'Users',
					'reference' => ' Administrator',
					'cbuuid' => '',
				),
				'assigned_user_idename' => array(
					'module' => 'Users',
					'reference' => 'cbTest testtz',
					'cbuuid' => '',
				),
				'salutationtype' => '',
				'firstname' => '',
				'contact_no' => '',
				'lastname' => '',
				'mobile' => '',
				'leadsource' => '',
				'homephone' => '',
				'title' => '',
				'department' => '',
				'email' => '',
				'birthday' => '',
				'assistant' => '',
				'contact_id' => '',
				'assistantphone' => '',
				'secondaryemail' => '',
				'donotcall' => '',
				'reference' => '',
				'template_language' => '',
				'portal' => '',
				'support_start_date' => '',
				'support_end_date' => '',
				'mailingstreet' => '',
				'otherstreet' => '',
				'mailingpobox' => '',
				'otherpobox' => '',
				'mailingcity' => '',
				'othercity' => '',
				'mailingstate' => '',
				'otherstate' => '',
				'mailingzip' => '',
				'otherzip' => '',
				'mailingcountry' => '',
				'othercountry' => '',
				'imagename' => '',
				'portalpasswordtype' => '',
				'portalloginuser' => '',
			),
		);
		// junk in > junk out
		$this->assertEquals($expected, $actual, 'MassRetrieve Mixed');
	}

	/**
	 * Method testEmail
	 * @test
	 */
	public function testEmail() {
		global $current_user;
		$actual = vtws_massretrieve('16x26266,16x26207', $current_user);
		$expected = array(
			'16x26266' => array(
				'id' => '16x26266',
				'date_start' => '2015-07-08',
				'from_email' => 'jesusita.flister@hotmail.com',
				'parent_type' => '',
				'saved_toid' => '["noreply@tsolucio.com"]',
				'activitytype' => 'Emails',
				'ccmail' => '["venenatis.vel@tinciduntdui.com"]',
				'bccmail' => '[""]',
				'assigned_user_id' => '19x8',
				'parent_id' => '11x277',
				'access_count' => '7',
				'email_flag' => 'MAILSCANNER',
				'modifiedtime' => '2016-05-06 13:53:38',
				'modifiedby' => '19x1',
				'bounce' => '',
				'clicked' => '',
				'spamreport' => '',
				'delivered' => '',
				'dropped' => '',
				'open' => '',
				'unsubscribe' => '',
				'createdtime' => '2016-04-28 21:46:10',
				'subject' => 'dui. Cras pellentesque. Sed dictum. Proin eget',
				'filename' => '',
				'time_start' => '18:11:25',
				'description' => 'tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam fringilla cursus purus. Nullam scelerisque neque sed sem egestas blandit. Nam nulla magna, malesuada vel, convallis in, cursus et, eros. Proin ultrices. Duis volutpat nunc sit amet metus. Aliquam erat volutpat. Nulla facilisis. Suspendisse commodo tincidunt nibh. Phasellus nulla. Integer vulputate, risus a ultricies adipiscing, enim mi tempor lorem, eget mollis lectus pede et risus. Quisque libero lacus, varius et, euismod et, commodo at, libero. Morbi accumsan laoreet ipsum. Curabitur consequat, lectus sit amet luctus vulputate, nisi sem semper erat, in consectetuer ipsum nunc id enim. Curabitur massa. Vestibulum accumsan neque et nunc. Quisque ornare tortor at risus. Nunc ac sem ut dolor dapibus gravida. Aliquam tincidunt, nunc ac mattis ornare, lectus ante dictum mi, ac mattis velit justo nec ante. Maecenas mi felis, adipiscing fringilla, porttitor vulputate, posuere vulputate, lacus. Cras interdum. Nunc sollicitudin commodo ipsum. Suspendisse non leo. Vivamus nibh dolor, nonummy ac, feugiat non, lobortis quis, pede. Suspendisse dui. Fusce diam nunc, ullamcorper eu, euismod ac, fermentum vel, mauris. Integer sem elit, pharetra ut, pharetra sed, hendrerit a, arcu. Sed et libero. Proin mi. Aliquam gravida mauris ut mi. Duis risus',
				'cbuuid' => 'aa35867949a29939c400833d5c2654511f19a2a4',
				'modifiedbyename' => array(
					'module' => 'Users',
					'reference' => ' Administrator',
					'cbuuid' => '',
				),
				'assigned_user_idename' => array(
					'module' => 'Users',
					'reference' => 'cbTest testes',
					'cbuuid' => '',
				),
				'parent_idename' => array(
					'11x277' => array(
						'module' => 'Accounts',
						'reference' => 'Schoen, Edward J Jr',
						'cbuuid' => '2d0df24c242d41bb5113a0ee7e9a420ba08c98b7',
					),
				),
				'replyto' => '',
			),
			'16x26207' => array(
				'id' => '16x26207',
				'date_start' => '2015-06-08',
				'from_email' => 'anitcher@aol.com',
				'parent_type' => '',
				'saved_toid' => '["noreply@tsolucio.com"]',
				'activitytype' => 'Emails',
				'ccmail' => '[""]',
				'bccmail' => '[""]',
				'assigned_user_id' => '19x5',
				'parent_id' => '12x1329',
				'access_count' => '5',
				'email_flag' => 'MailManager',
				'modifiedtime' => '2016-06-21 18:34:46',
				'modifiedby' => '19x1',
				'bounce' => '',
				'clicked' => '',
				'spamreport' => '',
				'delivered' => '',
				'dropped' => '',
				'open' => '',
				'unsubscribe' => '',
				'createdtime' => '2016-04-25 10:18:37',
				'subject' => 'imperdiet dictum magna. Ut tincidunt',
				'filename' => '',
				'time_start' => '19:13:27',
				'description' => 'posuere at, velit. Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue. Sed molestie. Sed id risus quis diam luctus lobortis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Mauris ut quam vel sapien imperdiet ornare. In faucibus. Morbi vehicula. Pellentesque tincidunt tempus risus. Donec egestas. Duis ac arcu. Nunc mauris. Morbi non sapien molestie orci tincidunt adipiscing. Mauris molestie pharetra nibh. Aliquam ornare, libero at auctor ullamcorper, nisl arcu iaculis enim, sit amet ornare lectus justo eu arcu. Morbi sit amet massa. Quisque porttitor eros nec tellus. Nunc lectus pede, ultrices a, auctor non, feugiat nec, diam. Duis mi enim, condimentum eget, volutpat ornare, facilisis eget, ipsum. Donec sollicitudin adipiscing ligula. Aenean gravida nunc sed pede. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel arcu eu odio tristique pharetra. Quisque ac libero nec ligula consectetuer rhoncus. Nullam velit dui, semper et, lacinia vitae, sodales at, velit. Pellentesque ultricies dignissim lacus. Aliquam rutrum lorem ac risus. Morbi metus. Vivamus euismod urna. Nullam lobortis quam a felis ullamcorper viverra. Maecenas iaculis aliquet diam. Sed',
				'cbuuid' => 'c24bf2c76c78af9b9ced6368b98f215b5358c880',
				'modifiedbyename' => array(
					'module' => 'Users',
					'reference' => ' Administrator',
					'cbuuid' => '',
				),
				'assigned_user_idename' => array(
					'module' => 'Users',
					'reference' => 'cbTest testdmy',
					'cbuuid' => '',
				),
				'parent_idename' => array(
					'12x1329' => array(
						'module' => 'Contacts',
						'reference' => 'Adelle Nitcher',
						'cbuuid' => 'a5e0d1b386c2b7acbc33e86ff05b80dd39a932db',
					),
				),
				'replyto' => '',
			),
		);
		$this->assertEquals($expected, $actual, 'MassRetrieve Emails');
	}

	/**
	 * Method testRetrieveNoAccessRecord
	 * @test
	 */
	public function testRetrieveNoAccessRecord() {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($this->usrcoma3dot);
		$current_user = $user;
		$pdoID = vtws_getEntityId('Products');
		try {
			$actual = vtws_massretrieve($pdoID.'x2633,12x74', $current_user);
		} catch (\Throwable $th) {
			$current_user = $holduser;
			throw $th;
		}
		$expected = array();
		$this->assertEquals($expected, $actual, 'MassRetrieve NoAccessRecord');
	}

	/**
	 * Method testRetrieveNoAccessModule
	 * @test
	 */
	public function testRetrieveNoAccessModule() {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(11); // no create
		$current_user = $user;
		$pdoID = vtws_getEntityId('cbTermConditions');
		try {
			$actual = vtws_massretrieve($pdoID.'x27153', $user);
		} catch (\Throwable $th) {
			$current_user = $holduser;
			throw $th;
		}
		$expected = array();
		$this->assertEquals($expected, $actual, 'MassRetrieve NoAccessModule');
	}
}
?>