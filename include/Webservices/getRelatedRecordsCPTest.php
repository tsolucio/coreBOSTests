<?php
/*************************************************************************************************
 * Copyright 2021 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

include_once 'include/Webservices/GetRelatedRecords.php';

class getRelatedRecordsCPTest extends TestCase {

	public static function setUpBeforeClass(): void {
		global $current_user;
		$current_user = Users::getActiveAdminUser();
		coreBOS_Session::set('authenticatedUserIsPortalUser', 1);
		coreBOS_Session::set('authenticatedUserPortalContact', 1162);
	}

	public static function tearDownAfterClass(): void {
		global $current_user;
		$current_user = Users::getActiveAdminUser();
		coreBOS_Session::delete('authenticatedUserIsPortalUser');
		coreBOS_Session::delete('authenticatedUserPortalContact');
	}

	/**
	 * Method getRelatedRecordsProvider
	 * params
	 */
	public function getRelatedRecordsProvider() {
		return array(
			// array(
			// 	'17x2636', 'HelpDesk', 'ModComments', array(
			// 		'productDiscriminator'=>'',
			// 		//'columns'=>'productname,product_no,id',
			// 		'limit'=>'3',
			// 		'offset'=>'0',
			// 		'orderby'=>''
			// 	),
			// 	1, array(
			// 		'records' => array(
			// 			array(
			// 				0 => '12x1098',
			// 				'creator' => '12x1098',
			// 				1 => '12x1098',
			// 				'assigned_user_id' => '12x1098',
			// 				2 => 'TicketComments',
			// 				'setype' => 'TicketComments',
			// 				3 => '2015-04-02 09:31:46',
			// 				'createdtime' => '2015-04-02 09:31:46',
			// 				4 => '2015-04-02 09:31:46',
			// 				'modifiedtime' => '2015-04-02 09:31:46',
			// 				5 => '0',
			// 				'id' => '0',
			// 				6 => 'mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem ipsum dolor sit amet,',
			// 				'commentcontent' => 'mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem ipsum dolor sit amet,',
			// 				7 => '17x2636',
			// 				'related_to' => '17x2636',
			// 				8 => '',
			// 				'parent_comments' => '',
			// 				9 => 'customer',
			// 				'ownertype' => 'customer',
			// 				10 => '',
			// 				'owner_name' => '',
			// 				11 => '',
			// 				'owner_firstname' => '',
			// 				12 => '',
			// 				'owner_lastname' => '',
			// 				13 => '',
			// 				'creator_name' => '',
			// 				14 => '',
			// 				'creator_firstname' => '',
			// 				15 => '',
			// 				'creator_lastname' => '',
			// 			),
			// 			array(
			// 				0 => '19x11',
			// 				'creator' => '19x11',
			// 				1 => '19x11',
			// 				'assigned_user_id' => '19x11',
			// 				2 => 'TicketComments',
			// 				'setype' => 'TicketComments',
			// 				3 => '2015-06-20 07:43:22',
			// 				'createdtime' => '2015-06-20 07:43:22',
			// 				4 => '2015-06-20 07:43:22',
			// 				'modifiedtime' => '2015-06-20 07:43:22',
			// 				5 => '0',
			// 				'id' => '0',
			// 				6 => 'ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla vulputate dui, nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id nunc interdum feugiat. Sed nec metus facilisis lorem tristique aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero et tristique pellentesque, tellus sem mollis dui, in sodales elit erat vitae risus. Duis a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus mauris a nunc. In at pede. Cras vulputate velit eu sem. Pellentesque ut ipsum ac mi',
			// 				'commentcontent' => 'ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla vulputate dui, nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id nunc interdum feugiat. Sed nec metus facilisis lorem tristique aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero et tristique pellentesque, tellus sem mollis dui, in sodales elit erat vitae risus. Duis a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus mauris a nunc. In at pede. Cras vulputate velit eu sem. Pellentesque ut ipsum ac mi',
			// 				7 => '17x2636',
			// 				'related_to' => '17x2636',
			// 				8 => '',
			// 				'parent_comments' => '',
			// 				9 => 'user',
			// 				'ownertype' => 'user',
			// 				10 => 'nocreate',
			// 				'owner_name' => 'nocreate',
			// 				11 => 'nocreate',
			// 				'owner_firstname' => 'nocreate',
			// 				12 => 'cbTest',
			// 				'owner_lastname' => 'cbTest',
			// 				13 => 'nocreate',
			// 				'creator_name' => 'nocreate',
			// 				14 => 'nocreate',
			// 				'creator_firstname' => 'nocreate',
			// 				15 => 'cbTest',
			// 				'creator_lastname' => 'cbTest',
			// 			),
			// 			array(
			// 				0 => '19x6',
			// 				'creator' => '19x6',
			// 				1 => '19x6',
			// 				'assigned_user_id' => '19x6',
			// 				2 => 'TicketComments',
			// 				'setype' => 'TicketComments',
			// 				3 => '2015-07-22 01:36:20',
			// 				'createdtime' => '2015-07-22 01:36:20',
			// 				4 => '2015-07-22 01:36:20',
			// 				'modifiedtime' => '2015-07-22 01:36:20',
			// 				5 => '0',
			// 				'id' => '0',
			// 				6 => 'lorem fringilla ornare placerat, orci lacus vestibulum lorem, sit amet ultricies sem magna nec quam. Curabitur vel lectus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec dignissim magna a tortor. Nunc commodo auctor velit. Aliquam nisl. Nulla eu neque pellentesque massa lobortis',
			// 				'commentcontent' => 'lorem fringilla ornare placerat, orci lacus vestibulum lorem, sit amet ultricies sem magna nec quam. Curabitur vel lectus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec dignissim magna a tortor. Nunc commodo auctor velit. Aliquam nisl. Nulla eu neque pellentesque massa lobortis',
			// 				7 => '17x2636',
			// 				'related_to' => '17x2636',
			// 				8 => '',
			// 				'parent_comments' => '',
			// 				9 => 'user',
			// 				'ownertype' => 'user',
			// 				10 => 'testmdy',
			// 				'owner_name' => 'testmdy',
			// 				11 => 'cbTest',
			// 				'owner_firstname' => 'cbTest',
			// 				12 => 'testmdy',
			// 				'owner_lastname' => 'testmdy',
			// 				13 => 'testmdy',
			// 				'creator_name' => 'testmdy',
			// 				14 => 'cbTest',
			// 				'creator_firstname' => 'cbTest',
			// 				15 => 'testmdy',
			// 				'creator_lastname' => 'testmdy',
			// 			),
			// 		),
			// 	),
			// 	'HelpDesk Modcomments limit'
			// ),
			array(
				'11x142', 'Accounts', 'Assets', array(
					'productDiscriminator'=>'',
					//'columns'=>'productname,product_no,id',
					'limit'=>'3',
					'offset'=>'0',
				),
				1, array(
					'records' => array(
						array(
							0 => 'AST-000001',
							'asset_no' => 'AST-000001',
							1 => '2622',
							'product' => '14x2622',
							2 => 'ABCD-123456',
							'serialnumber' => 'ABCD-123456',
							3 => '7',
							'assigned_user_id' => '19x7',
							4 => '7',
							'smownerid' => '7',
							5 => 'cbTest',
							'owner_firstname' => 'cbTest',
							6 => 'testymd',
							'owner_lastname' => 'testymd',
							7 => '2016-05-13',
							'datesold' => '2016-05-13',
							8 => '2015-05-21',
							'dateinservice' => '2015-05-21',
							9 => 'In Service',
							'assetstatus' => 'In Service',
							10 => '',
							'tagnumber' => '',
							11 => '3882',
							'invoiceid' => '7x3882',
							12 => '',
							'shippingmethod' => '',
							13 => '',
							'shippingtrackingnumber' => '',
							14 => 'Barter Systems Inc :: cheap in stock muti-color lipstick',
							'assetname' => 'Barter Systems Inc :: cheap in stock muti-color lipstick',
							15 => '142',
							'account' => '11x142',
							16 => '2015-04-20 21:07:35',
							'createdtime' => '2015-04-20 21:07:35',
							17 => '2016-06-09 23:33:56',
							'modifiedtime' => '2016-06-09 23:33:56',
							18 => '1',
							'modifiedby' => '19x1',
							19 => '1',
							'creator' => '1',
							20 => '1',
							'smcreatorid' => '1',
							21 => 'cbTest',
							'creator_firstname' => 'cbTest',
							22 => 'testymd',
							'creator_lastname' => 'testymd',
							23 => ' Neque solum ea communia, verum etiam paria esse dixerunt. Si quicquam extra virtutem habeatur in bonis. Stoicos roga. A primo, ut opinor, animantium ortu petitur origo summi boni. 

',
							'description' => ' Neque solum ea communia, verum etiam paria esse dixerunt. Si quicquam extra virtutem habeatur in bonis. Stoicos roga. A primo, ut opinor, animantium ortu petitur origo summi boni. 

',
							24 => '4062',
							'assetsid' => '4062',
							25 => '0b9a279107bc321b294fa1d0470ee90642ec3271',
							'cbuuid' => '0b9a279107bc321b294fa1d0470ee90642ec3271',
							'id' => '29x4062',
						),
					),
				),
				'Accounts-Assets'
			),
			array(
				'12x1162', 'Contacts', 'SalesOrder', array(
					'productDiscriminator'=>'',
					//'columns'=>'productname,product_no,id',
					'limit'=>'2',
					'offset'=>'0',
					'orderby'=>'subject'
				),
				1, array(
					'records' => array(
						array(
							0 => 'John Grey',
							'subject' => 'John Grey',
							1 => '5927',
							'potentialid' => '5927',
							2 => '370136962-00005',
							'customerno' => '370136962-00005',
							3 => 'SO63',
							'salesorder_no' => 'SO63',
							4 => '',
							'purchaseorder' => '',
							5 => '11836',
							'quoteid' => '11836',
							6 => '1162',
							'contactid' => '1162',
							7 => '2016-06-23',
							'duedate' => '2016-06-23',
							8 => 'USPS',
							'carrier' => 'USPS',
							9 => '',
							'pending' => '',
							10 => 'Credit Invoice',
							'sostatus' => 'Credit Invoice',
							11 => '0.000000',
							'adjustment' => '0.000000',
							12 => '0.000',
							'salescommission' => '0.000',
							13 => '0.000',
							'exciseduty' => '0.000',
							14 => '2071.950000',
							'total' => '2071.950000',
							15 => '1631.460000',
							'subtotal' => '1631.460000',
							16 => 'group',
							'taxtype' => 'group',
							17 => '0.000',
							'discount_percent' => '0.000',
							18 => '0.000000',
							'discount_amount' => '0.000000',
							19 => '0.000000',
							's_h_amount' => '0.000000',
							20 => '172',
							'accountid' => '172',
							21 => '7',
							'assigned_user_id' => '19x7',
							22 => '7',
							'smownerid' => '7',
							23 => 'cbTest',
							'owner_firstname' => 'cbTest',
							24 => 'testymd',
							'owner_lastname' => 'testymd',
							25 => '2015-07-08 22:32:16',
							'createdtime' => '2015-07-08 22:32:16',
							26 => '2016-04-03 12:39:45',
							'modifiedtime' => '2016-04-03 12:39:45',
							27 => '1',
							'currency_id' => '21x1',
							28 => '1.000',
							'conversion_rate' => '1.000',
							29 => '1',
							'modifiedby' => '19x1',
							30 => '1',
							'creator' => '1',
							31 => '1',
							'smcreatorid' => '1',
							32 => 'cbTest',
							'creator_firstname' => 'cbTest',
							33 => 'testymd',
							'creator_lastname' => 'testymd',
							34 => '',
							'invoiced' => '',
							35 => '0',
							'enable_recurring' => '0',
							36 => '--None--',
							'recurring_frequency' => '--None--',
							37 => '',
							'start_period' => '',
							38 => '',
							'end_period' => '',
							39 => '',
							'payment_duration' => '',
							40 => 'AutoCreated',
							'invoice_status' => 'AutoCreated',
							41 => '80 Talbot St',
							'bill_street' => '80 Talbot St',
							42 => '80 Talbot St',
							'ship_street' => '80 Talbot St',
							43 => '',
							'bill_pobox' => '',
							44 => '',
							'ship_pobox' => '',
							45 => 'Edgeley and Cheadle Heath Ward',
							'bill_city' => 'Edgeley and Cheadle Heath Ward',
							46 => 'Edgeley and Cheadle Heath Ward',
							'ship_city' => 'Edgeley and Cheadle Heath Ward',
							47 => 'Cheshire',
							'bill_state' => 'Cheshire',
							48 => 'Cheshire',
							'ship_state' => 'Cheshire',
							49 => 'SK3 9RD',
							'bill_code' => 'SK3 9RD',
							50 => 'SK3 9RD',
							'ship_code' => 'SK3 9RD',
							51 => 'United Kingdom',
							'bill_country' => 'United Kingdom',
							52 => 'United Kingdom',
							'ship_country' => 'United Kingdom',
							53 => '',
							'terms_conditions' => '',
							54 => '',
							'tandc' => '',
							55 => '',
							'description' => '',
							56 => '1631.460000',
							'pl_gross_total' => '1631.460000',
							57 => '0.000000',
							'pl_dto_line' => '0.000000',
							58 => '0.000000',
							'pl_dto_total' => '0.000000',
							59 => '0.000000',
							'pl_dto_global' => '0.000000',
							60 => '1631.460000',
							'pl_net_total' => '1631.460000',
							61 => '1631.460000',
							'sum_nettotal' => '1631.460000',
							62 => '440.494200',
							'sum_taxtotal' => '440.494200',
							63 => '73.415700',
							'sum_tax1' => '73.415700',
							64 => '0.000000',
							'sum_taxtotalretention' => '0.000000',
							65 => '163.146000',
							'sum_tax2' => '163.146000',
							66 => '0.000000',
							'pl_sh_total' => '0.000000',
							67 => '203.932500',
							'sum_tax3' => '203.932500',
							68 => '0.000000',
							'pl_sh_tax' => '0.000000',
							69 => '2071.950000',
							'pl_grand_total' => '2071.950000',
							70 => '0.000000',
							'pl_adjustment' => '0.000000',
							71 => '11338',
							'salesorderid' => '11338',
							72 => 'e467ba83104508535b51f0a356e4eeda73c6cc39',
							'cbuuid' => 'e467ba83104508535b51f0a356e4eeda73c6cc39',
							'id' => '6x11338',
						),
					),
				),
				'HelpDesk Modcomments orderby and limit'
			),
		);
	}

	/**
	 * Method testgetRelatedRecords
	 * @test
	 * @dataProvider getRelatedRecordsProvider
	 */
	public function testgetRelatedRecords($id, $module, $relatedModule, $queryParameters, $userid, $expected, $msg) {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($userid);
		$current_user = $user;
		$actual = getRelatedRecords($id, $module, $relatedModule, $queryParameters, $current_user);
		$this->assertEqualsCanonicalizing($expected, $actual, $msg);
		$current_user = $holduser;
	}

	/**
	 * Method testProductsInventory
	 * @test
	 */
	public function testProductsInventory() {
		global $current_user;
		////////////////////////////
		$qparams = array(
			'productDiscriminator' => 'ProductLineQuotes',
			'columns' => 'productname, servicename, id',
		);
		$actual = getRelatedRecords(vtws_getEntityId('Quotes').'x12192', 'Quotes', 'Products', $qparams, $current_user);
		$expected= array(
			'records' => array(
				array(
					0 => '',
					'productname' => '',
					1 => 'Social and cultural event',
					'productid' => '26x9730',
					2 => '9730',
					'cbuuid' => 'bcb11c59a702245bf8cd6c67b58de37b111c0b1e',
					'id' => '26x9730',
					'servicename' => 'Social and cultural event',
					3 => '1',
					'sequence_no' => '1',
					'linetype' => 'Services',
				),
				array(
					0 => 'Lml-Bc288X 50 288W Curved Led Light Bar Used Cree Chips Off Road Spot Flood Beam New Arrival',
					'productname' => 'Lml-Bc288X 50 288W Curved Led Light Bar Used Cree Chips Off Road Spot Flood Beam New Arrival',
					1 => '',
					'productid' => '14x2630',
					2 => '2630',
					'cbuuid' => 'cf7e5cedb32c9811b6e6d8202982842f22c2ec49',
					'id' => '14x2630',
					'servicename' => '',
					3 => '2',
					'sequence_no' => '2',
					'linetype' => 'Products',
				),
				array(
					0 => 'Protective Case Cover for iPhone 6',
					'productname' => 'Protective Case Cover for iPhone 6',
					1 => '',
					'productid' => '14x2618',
					2 => '2618',
					'cbuuid' => '668d624d92e450119f769142036e7e235ec030c7',
					'id' => '14x2618',
					'servicename' => '',
					3 => '3',
					'sequence_no' => '3',
					'linetype' => 'Products',
				),
				array(
					0 => '',
					'productname' => '',
					1 => 'Set up computers, cell phones, and similar devices',
					'productid' => '26x9738',
					2 => '9738',
					'cbuuid' => 'ef0f50fff37934cc88767e196cc4a6b92d9d46d7',
					'id' => '26x9738',
					'servicename' => 'Set up computers, cell phones, and similar devices',
					3 => '4',
					'sequence_no' => '4',
					'linetype' => 'Services',
				),
				array(
					0 => 'New 3.3 Inch 9W Epistar LED Work Light',
					'productname' => 'New 3.3 Inch 9W Epistar LED Work Light',
					1 => '',
					'productid' => '14x2624',
					2 => '2624',
					'cbuuid' => '9b2f22ca7c009319b1e78f9778fc9f2df84a1aaf',
					'id' => '14x2624',
					'servicename' => '',
					3 => '5',
					'sequence_no' => '5',
					'linetype' => 'Products',
				),
				array(
					0 => 'cheap in stock muti-color lipstick',
					'productname' => 'cheap in stock muti-color lipstick',
					1 => '',
					'productid' => '14x2622',
					2 => '2622',
					'cbuuid' => '321dcfe3e3d45e08441ed92d4a729786d36d26bf',
					'id' => '14x2622',
					'servicename' => '',
					3 => '6',
					'sequence_no' => '6',
					'linetype' => 'Products',
				),
				array(
					0 => 'Car Sunshade Windshield Cover / Car Snow Cover',
					'productname' => 'Car Sunshade Windshield Cover / Car Snow Cover',
					1 => '',
					'productid' => '14x2620',
					2 => '2620',
					'cbuuid' => '08b6499c06f49c16689928879243b21e61928a5c',
					'id' => '14x2620',
					'servicename' => '',
					3 => '7',
					'sequence_no' => '7',
					'linetype' => 'Products',
				),
				array(
					0 => '',
					'productname' => '',
					1 => 'Set up computers, cell phones, and similar devices',
					'productid' => '26x9738',
					2 => '9738',
					'cbuuid' => 'ef0f50fff37934cc88767e196cc4a6b92d9d46d7',
					'id' => '26x9738',
					'servicename' => 'Set up computers, cell phones, and similar devices',
					3 => '8',
					'sequence_no' => '8',
					'linetype' => 'Services',
				),
				array(
					0 => '',
					'productname' => '',
					1 => 'Design',
					'productid' => '26x9752',
					2 => '9752',
					'cbuuid' => '9ad64a8f94fe7c23ee6abff1828e231ec17ae2a5',
					'id' => '26x9752',
					'servicename' => 'Design',
					3 => '9',
					'sequence_no' => '9',
					'linetype' => 'Services',
				),
			),
		);
		$this->assertEquals($expected, $actual, 'Contacts-Products SO');
	}

	/**
	 * Method testProductsModule
	 * @test
	 */
	public function testProductsModule() {
		global $adb, $current_user;
		$adb->query('insert ignore into vtiger_seproductsrel values (1104,2626,"Contacts")');
		$adb->query('insert ignore into vtiger_seproductsrel values (1104,2627,"Contacts")');
		$qparams = array(
			'productDiscriminator' => 'ProductLineNone',
			'columns' => 'productname, id',
		);
		$actual = getRelatedRecords('12x1104', 'Contacts', 'Products', $qparams, $current_user);
		$expected= array(
			'records' => array(
				array(
					0 => 'Manufacturing Japan Movt Stainless Steel Back For Men Bracelet Brand Watch Wrist Wtach Quartz',
					'productname' => 'Manufacturing Japan Movt Stainless Steel Back For Men Bracelet Brand Watch Wrist Wtach Quartz',
					1 => '2626',
					'productid' => '2626',
					2 => '4973deb411bf466e943fc35fef5a2005c6720d3a',
					'cbuuid' => '4973deb411bf466e943fc35fef5a2005c6720d3a',
					'id' => '14x2626',
				),
				array(
					0 => 'Android TV BOX',
					'productname' => 'Android TV BOX',
					1 => '2627',
					'productid' => '2627',
					2 => 'f243a2ee70781bdee2a9cb9b05b1584de3cc6888',
					'cbuuid' => 'f243a2ee70781bdee2a9cb9b05b1584de3cc6888',
					'id' => '14x2627',
				),
			),
		);
		$this->assertEquals($expected, $actual, 'Contacts-Products Direct');
		////////////////////////////
		$qparams = array(
			'productDiscriminator' => 'ProductLineSalesOrder',
			'columns' => 'productname, id',
		);
		$actual = getRelatedRecords('12x1613', 'Contacts', 'Products', $qparams, $current_user);
		$expected= array(
			'records' => array(
				array(
					0 => 'U8 Smart Watch',
					'productname' => 'U8 Smart Watch',
					1 => '2632',
					'productid' => '2632',
					2 => '9a3e0706ebf020baefab732a42f4940462ca1696',
					'cbuuid' => '9a3e0706ebf020baefab732a42f4940462ca1696',
					'id' => '14x2632',
				),
				array(
					0 => 'Protective Case Cover for iPhone 6',
					'productname' => 'Protective Case Cover for iPhone 6',
					1 => '2618',
					'productid' => '2618',
					2 => '668d624d92e450119f769142036e7e235ec030c7',
					'cbuuid' => '668d624d92e450119f769142036e7e235ec030c7',
					'id' => '14x2618',
				),
				array(
					0 => 'New 3.3 Inch 9W Epistar LED Work Light',
					'productname' => 'New 3.3 Inch 9W Epistar LED Work Light',
					1 => '2624',
					'productid' => '2624',
					2 => '9b2f22ca7c009319b1e78f9778fc9f2df84a1aaf',
					'cbuuid' => '9b2f22ca7c009319b1e78f9778fc9f2df84a1aaf',
					'id' => '14x2624',
				),
				array(
					0 => 'cheap in stock muti-color lipstick',
					'productname' => 'cheap in stock muti-color lipstick',
					1 => '2622',
					'productid' => '2622',
					2 => '321dcfe3e3d45e08441ed92d4a729786d36d26bf',
					'cbuuid' => '321dcfe3e3d45e08441ed92d4a729786d36d26bf',
					'id' => '14x2622',
				),
				array(
					0 => 'Car Sunshade Windshield Cover / Car Snow Cover',
					'productname' => 'Car Sunshade Windshield Cover / Car Snow Cover',
					1 => '2620',
					'productid' => '2620',
					2 => '08b6499c06f49c16689928879243b21e61928a5c',
					'cbuuid' => '08b6499c06f49c16689928879243b21e61928a5c',
					'id' => '14x2620',
				),
			),
		);
		$this->assertEquals($expected, $actual, 'Contacts-Products SO');
		////////////////////////////
		$qparams = array(
			'productDiscriminator' => 'ProductLineSalesOrderOnly',
			'columns' => 'productname, id',
		);
		$actual = getRelatedRecords('12x1613', 'Contacts', 'Products', $qparams, $current_user);
		$this->assertEquals($expected, $actual, 'Contacts-Products SO (only)');
		////////////////////////////
		$qparams = array(
			'productDiscriminator' => 'ProductLineQuote',
			'columns' => 'productname, id',
		);
		$actual = getRelatedRecords('12x1613', 'Contacts', 'Products', $qparams, $current_user);
		$expected= array(
			'records' => array(
				array(
					0 => 'Lml-Bc288X 50 288W Curved Led Light Bar Used Cree Chips Off Road Spot Flood Beam New Arrival',
					'productname' => 'Lml-Bc288X 50 288W Curved Led Light Bar Used Cree Chips Off Road Spot Flood Beam New Arrival',
					1 => '2630',
					'productid' => '2630',
					2 => 'cf7e5cedb32c9811b6e6d8202982842f22c2ec49',
					'cbuuid' => 'cf7e5cedb32c9811b6e6d8202982842f22c2ec49',
					'id' => '14x2630',
				),
				array(
					0 => 'Protective Case Cover for iPhone 6',
					'productname' => 'Protective Case Cover for iPhone 6',
					1 => '2618',
					'productid' => '2618',
					2 => '668d624d92e450119f769142036e7e235ec030c7',
					'cbuuid' => '668d624d92e450119f769142036e7e235ec030c7',
					'id' => '14x2618',
				),
				array(
					0 => 'New 3.3 Inch 9W Epistar LED Work Light',
					'productname' => 'New 3.3 Inch 9W Epistar LED Work Light',
					1 => '2624',
					'productid' => '2624',
					2 => '9b2f22ca7c009319b1e78f9778fc9f2df84a1aaf',
					'cbuuid' => '9b2f22ca7c009319b1e78f9778fc9f2df84a1aaf',
					'id' => '14x2624',
				),
				array(
					0 => 'cheap in stock muti-color lipstick',
					'productname' => 'cheap in stock muti-color lipstick',
					1 => '2622',
					'productid' => '2622',
					2 => '321dcfe3e3d45e08441ed92d4a729786d36d26bf',
					'cbuuid' => '321dcfe3e3d45e08441ed92d4a729786d36d26bf',
					'id' => '14x2622',
				),
				array(
					0 => 'Car Sunshade Windshield Cover / Car Snow Cover',
					'productname' => 'Car Sunshade Windshield Cover / Car Snow Cover',
					1 => '2620',
					'productid' => '2620',
					2 => '08b6499c06f49c16689928879243b21e61928a5c',
					'cbuuid' => '08b6499c06f49c16689928879243b21e61928a5c',
					'id' => '14x2620',
				),
			),
		);
		$this->assertEquals($expected, $actual, 'Contacts-Products Quote');
		////////////////////////////
		$qparams = array(
			'productDiscriminator' => 'ProductLineInvoice',
			'columns' => 'productname, id',
		);
		$actual = getRelatedRecords('12x1613', 'Contacts', 'Products', $qparams, $current_user);
		$expected= array(
			'records' => array(
			),
		);
		$this->assertEquals($expected, $actual, 'Contacts-Products Invoice');
		////////////////////////////
		$qparams = array(
			'productDiscriminator' => 'ProductLineAll',
			'columns' => 'productname, id',
		);
		$actual = getRelatedRecords('12x1613', 'Contacts', 'Products', $qparams, $current_user);
		$expected= array(
			'records' => array(
				array(
					0 => 'Lml-Bc288X 50 288W Curved Led Light Bar Used Cree Chips Off Road Spot Flood Beam New Arrival',
					'productname' => 'Lml-Bc288X 50 288W Curved Led Light Bar Used Cree Chips Off Road Spot Flood Beam New Arrival',
					1 => '2630',
					'productid' => '2630',
					2 => 'cf7e5cedb32c9811b6e6d8202982842f22c2ec49',
					'cbuuid' => 'cf7e5cedb32c9811b6e6d8202982842f22c2ec49',
					'id' => '14x2630',
				),
				array(
					0 => 'Protective Case Cover for iPhone 6',
					'productname' => 'Protective Case Cover for iPhone 6',
					1 => '2618',
					'productid' => '2618',
					2 => '668d624d92e450119f769142036e7e235ec030c7',
					'cbuuid' => '668d624d92e450119f769142036e7e235ec030c7',
					'id' => '14x2618',
				),
				array(
					0 => 'New 3.3 Inch 9W Epistar LED Work Light',
					'productname' => 'New 3.3 Inch 9W Epistar LED Work Light',
					1 => '2624',
					'productid' => '2624',
					2 => '9b2f22ca7c009319b1e78f9778fc9f2df84a1aaf',
					'cbuuid' => '9b2f22ca7c009319b1e78f9778fc9f2df84a1aaf',
					'id' => '14x2624',
				),
				array(
					0 => 'cheap in stock muti-color lipstick',
					'productname' => 'cheap in stock muti-color lipstick',
					1 => '2622',
					'productid' => '2622',
					2 => '321dcfe3e3d45e08441ed92d4a729786d36d26bf',
					'cbuuid' => '321dcfe3e3d45e08441ed92d4a729786d36d26bf',
					'id' => '14x2622',
				),
				array(
					0 => 'Car Sunshade Windshield Cover / Car Snow Cover',
					'productname' => 'Car Sunshade Windshield Cover / Car Snow Cover',
					1 => '2620',
					'productid' => '2620',
					2 => '08b6499c06f49c16689928879243b21e61928a5c',
					'cbuuid' => '08b6499c06f49c16689928879243b21e61928a5c',
					'id' => '14x2620',
				),
				array(
					0 => 'U8 Smart Watch',
					'productname' => 'U8 Smart Watch',
					1 => '2632',
					'productid' => '2632',
					2 => '9a3e0706ebf020baefab732a42f4940462ca1696',
					'cbuuid' => '9a3e0706ebf020baefab732a42f4940462ca1696',
					'id' => '14x2632',
				),
			),
		);
		$this->assertEquals($expected, $actual, 'Contacts-Products All');
		////////////////////////////
		$qparams = array(
			'productDiscriminator' => 'ProductLineSalesOrder',
			'columns' => 'servicename, id',
		);
		$actual = getRelatedRecords('12x1613', 'Contacts', 'Services', $qparams, $current_user);
		$expected= array(
			'records' => array(
				array(
					0 => 'Investing',
					'servicename' => 'Investing',
					1 => '9713',
					'serviceid' => '9713',
					2 => 'd8827a99ae00c5ef9cda704173cdea5d042d39c3',
					'cbuuid' => 'd8827a99ae00c5ef9cda704173cdea5d042d39c3',
					'id' => '26x9713',
				),
				array(
					0 => 'Set up computers, cell phones, and similar devices',
					'servicename' => 'Set up computers, cell phones, and similar devices',
					1 => '9755',
					'serviceid' => '9755',
					2 => '60e70f186b72282a963338fbd4eab1ec9e8d04ea',
					'cbuuid' => '60e70f186b72282a963338fbd4eab1ec9e8d04ea',
					'id' => '26x9755',
				),
				array(
					0 => 'Bird-watching',
					'servicename' => 'Bird-watching',
					1 => '9722',
					'serviceid' => '9722',
					2 => 'b3fac938a788007f55ade8a65c0ebacc649012bd',
					'cbuuid' => 'b3fac938a788007f55ade8a65c0ebacc649012bd',
					'id' => '26x9722',
				),
			),
		);
		$this->assertEquals($expected, $actual, 'Contacts-Services SO');
		////////////////////////////
		$qparams = array(
			'productDiscriminator' => 'ProductLineQuote',
			'columns' => 'servicename, id',
		);
		$actual = getRelatedRecords('12x1613', 'Contacts', 'Services', $qparams, $current_user);
		$expected= array(
			'records' => array(
				array(
					0 => 'Social and cultural event',
					'servicename' => 'Social and cultural event',
					1 => '9730',
					'serviceid' => '9730',
					2 => 'bcb11c59a702245bf8cd6c67b58de37b111c0b1e',
					'cbuuid' => 'bcb11c59a702245bf8cd6c67b58de37b111c0b1e',
					'id' => '26x9730',
				),
				array(
					0 => 'Set up computers, cell phones, and similar devices',
					'servicename' => 'Set up computers, cell phones, and similar devices',
					1 => '9738',
					'serviceid' => '9738',
					2 => 'ef0f50fff37934cc88767e196cc4a6b92d9d46d7',
					'cbuuid' => 'ef0f50fff37934cc88767e196cc4a6b92d9d46d7',
					'id' => '26x9738',
				),
				array(
					0 => 'Design',
					'servicename' => 'Design',
					1 => '9752',
					'serviceid' => '9752',
					2 => '9ad64a8f94fe7c23ee6abff1828e231ec17ae2a5',
					'cbuuid' => '9ad64a8f94fe7c23ee6abff1828e231ec17ae2a5',
					'id' => '26x9752',
				),
			),
		);
		$this->assertEquals($expected, $actual, 'Contacts-Services Quote');
		////////////////////////////
		$qparams = array(
			'productDiscriminator' => 'ProductLineInvoice',
			'columns' => 'servicename, id',
		);
		$actual = getRelatedRecords('12x1613', 'Contacts', 'Services', $qparams, $current_user);
		$expected= array(
			'records' => array(
			),
		);
		$this->assertEquals($expected, $actual, 'Contacts-Services Invoice');
		////////////////////////////
		$qparams = array(
			'productDiscriminator' => 'ProductLineAll',
			'columns' => 'servicename, id',
		);
		$actual = getRelatedRecords('12x1613', 'Contacts', 'Services', $qparams, $current_user);
		$expected= array(
			'records' => array(
				array(
					0 => 'Social and cultural event',
					'servicename' => 'Social and cultural event',
					1 => '9730',
					'serviceid' => '9730',
					2 => 'bcb11c59a702245bf8cd6c67b58de37b111c0b1e',
					'cbuuid' => 'bcb11c59a702245bf8cd6c67b58de37b111c0b1e',
					'id' => '26x9730',
				),
				array(
					0 => 'Set up computers, cell phones, and similar devices',
					'servicename' => 'Set up computers, cell phones, and similar devices',
					1 => '9738',
					'serviceid' => '9738',
					2 => 'ef0f50fff37934cc88767e196cc4a6b92d9d46d7',
					'cbuuid' => 'ef0f50fff37934cc88767e196cc4a6b92d9d46d7',
					'id' => '26x9738',
				),
				array(
					0 => 'Design',
					'servicename' => 'Design',
					1 => '9752',
					'serviceid' => '9752',
					2 => '9ad64a8f94fe7c23ee6abff1828e231ec17ae2a5',
					'cbuuid' => '9ad64a8f94fe7c23ee6abff1828e231ec17ae2a5',
					'id' => '26x9752',
				),
				array(
					0 => 'Investing',
					'servicename' => 'Investing',
					1 => '9713',
					'serviceid' => '9713',
					2 => 'd8827a99ae00c5ef9cda704173cdea5d042d39c3',
					'cbuuid' => 'd8827a99ae00c5ef9cda704173cdea5d042d39c3',
					'id' => '26x9713',
				),
				array(
					0 => 'Set up computers, cell phones, and similar devices',
					'servicename' => 'Set up computers, cell phones, and similar devices',
					1 => '9755',
					'serviceid' => '9755',
					2 => '60e70f186b72282a963338fbd4eab1ec9e8d04ea',
					'cbuuid' => '60e70f186b72282a963338fbd4eab1ec9e8d04ea',
					'id' => '26x9755',
				),
				array(
					0 => 'Bird-watching',
					'servicename' => 'Bird-watching',
					1 => '9722',
					'serviceid' => '9722',
					2 => 'b3fac938a788007f55ade8a65c0ebacc649012bd',
					'cbuuid' => 'b3fac938a788007f55ade8a65c0ebacc649012bd',
					'id' => '26x9722',
				),
			),
		);
		$this->assertEquals($expected, $actual, 'Contacts-Services All');
	}

}
?>