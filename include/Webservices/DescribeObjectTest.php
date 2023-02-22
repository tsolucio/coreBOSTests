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

class DescribeObjectTest extends TestCase {

	private $asset = array(
		'label' => 'Assets',
		'label_raw' => 'Assets',
		'name' => 'Assets',
		'createable' => true,
		'updateable' => true,
		'deleteable' => true,
		'retrieveable' => true,
		'fields' => array(
			0 => array(
				'name' => 'asset_no',
				'label' => 'Asset No',
				'label_raw' => 'Asset No',
				'mandatory' => false,
				'type' => array('name' => 'string'),
				'nullable' => false,
				'editable' => false,
				'uitype' => '4',
				'typeofdata' => 'V~O',
				'sequence' => '2',
				'quickcreate' => false,
				'displaytype' => '1',
				'summary' => 'B',
				'block' => array(
					'blockid' => '103',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_ASSET_INFORMATION',
					'blockname' => 'Asset Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			1 => array(
				'name' => 'product',
				'label' => 'Product Name',
				'label_raw' => 'Product Name',
				'mandatory' => true,
				'type' => array(
					'refersTo' => array(0 => 'Products'),
					'name' => 'reference',
				),
				'nullable' => true,
				'editable' => true,
				'uitype' => '10',
				'typeofdata' => 'V~M',
				'sequence' => '3',
				'quickcreate' => false,
				'displaytype' => '1',
				'summary' => 'B',
				'block' => array(
					'blockid' => '103',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_ASSET_INFORMATION',
					'blockname' => 'Asset Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			2 => array(
				'name' => 'serialnumber',
				'label' => 'Serial Number',
				'label_raw' => 'Serial Number',
				'mandatory' => true,
				'type' => array('name' => 'string'),
				'nullable' => true,
				'editable' => true,
				'uitype' => '2',
				'typeofdata' => 'V~M',
				'sequence' => '4',
				'quickcreate' => false,
				'displaytype' => '1',
				'summary' => 'B',
				'block' => array(
					'blockid' => '103',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_ASSET_INFORMATION',
					'blockname' => 'Asset Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			3 => array(
				'name' => 'assigned_user_id',
				'label' => 'Assigned To',
				'label_raw' => 'Assigned To',
				'mandatory' => true,
				'type' => array(
					'assignto' => array(
						'users' => array(
							'label_raw' => 'Users',
							'label' => 'Users',
							'options' => array(
								0 => array(
									'userid' => '19x1',
									'username' => 'Administrator',
								),
								1 => array(
									'userid' => '19x11',
									'username' => 'nocreate cbTest',
								),
								2 => array(
									'userid' => '19x5',
									'username' => 'cbTest testdmy',
								),
								3 => array(
									'userid' => '19x8',
									'username' => 'cbTest testes',
								),
								4 => array(
									'userid' => '19x12',
									'username' => 'cbTest testmcurrency',
								),
								5 => array(
									'userid' => '19x6',
									'username' => 'cbTest testmdy',
								),
								6 => array(
									'userid' => '19x10',
									'username' => 'cbTest testtz',
								),
								7 => array(
									'userid' => '19x13',
									'username' => 'cbTest testtz-3',
								),
								8 => array(
									'userid' => '19x7',
									'username' => 'cbTest testymd',
								),
							),
						),
						'groups' => array(
							'label_raw' => 'Groups',
							'label' => 'Groups',
							'options' => array(
								0 => array(
									'groupid' => '20x3',
									'groupname' => 'Marketing Group',
								),
								1 => array(
									'groupid' => '20x4',
									'groupname' => 'Support Group',
								),
								2 => array(
									'groupid' => '20x2',
									'groupname' => 'Team Selling',
								),
							),
						),
					),
					'name' => 'owner',
				),
				'nullable' => false,
				'editable' => true,
				'uitype' => '53',
				'typeofdata' => 'V~M',
				'sequence' => '4',
				'quickcreate' => false,
				'displaytype' => '1',
				'summary' => 'B',
				'block' => array(
					'blockid' => '103',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_ASSET_INFORMATION',
					'blockname' => 'Asset Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			4 => array(
				'name' => 'datesold',
				'label' => 'Date Sold',
				'label_raw' => 'Date Sold',
				'mandatory' => true,
				'type' => array(
					'format' => 'yyyy-mm-dd',
					'name' => 'date',
				),
				'nullable' => true,
				'editable' => true,
				'uitype' => '5',
				'typeofdata' => 'D~M',
				'sequence' => '5',
				'quickcreate' => false,
				'displaytype' => '1',
				'summary' => 'B',
				'block' => array(
					'blockid' => '103',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_ASSET_INFORMATION',
					'blockname' => 'Asset Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			5 => array(
				'name' => 'dateinservice',
				'label' => 'Date in Service',
				'label_raw' => 'Date in Service',
				'mandatory' => true,
				'type' => array(
					'format' => 'yyyy-mm-dd',
					'name' => 'date'
				),
				'nullable' => true,
				'editable' => true,
				'uitype' => '5',
				'typeofdata' => 'D~M~OTH~GE~datesold~Date Sold',
				'sequence' => '6',
				'quickcreate' => false,
				'displaytype' => '1',
				'summary' => 'B',
				'block' => array(
					'blockid' => '103',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_ASSET_INFORMATION',
					'blockname' => 'Asset Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			6 => array(
				'name' => 'assetstatus',
				'label' => 'Status',
				'label_raw' => 'Status',
				'mandatory' => true,
				'type' => array(
					'picklistValues' => array(
						0 => array(
							'label' => 'In Service',
							'value' => 'In Service',
							'tooltip' => '',
						),
						1 => array(
							'label' => 'Out-of-service',
							'value' => 'Out-of-service',
							'tooltip' => '',
						),
					),
					'defaultValue' => 'In Service',
					'name' => 'picklist',
				),
				'nullable' => true,
				'editable' => true,
				'uitype' => '15',
				'typeofdata' => 'V~M',
				'sequence' => '7',
				'quickcreate' => false,
				'displaytype' => '1',
				'summary' => 'B',
				'block' => array(
					'blockid' => '103',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_ASSET_INFORMATION',
					'blockname' => 'Asset Information',
				),
				'default' => 'In Service',
				'helpinfo' => '',
			),
			7 => array(
				'name' => 'tagnumber',
				'label' => 'Tag Number',
				'label_raw' => 'Tag Number',
				'mandatory' => false,
				'type' => array('name' => 'string'),
				'nullable' => true,
				'editable' => true,
				'uitype' => '2',
				'typeofdata' => 'V~O',
				'sequence' => '8',
				'quickcreate' => false,
				'displaytype' => '1',
				'summary' => 'B',
				'block' => array(
					'blockid' => '103',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_ASSET_INFORMATION',
					'blockname' => 'Asset Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			8 => array(
				'name' => 'invoiceid',
				'label' => 'Invoice Name',
				'label_raw' => 'Invoice Name',
				'mandatory' => false,
				'type' => array(
					'refersTo' => array(0 => 'Invoice'),
					'name' => 'reference',
				),
				'nullable' => true,
				'editable' => true,
				'uitype' => '10',
				'typeofdata' => 'V~O',
				'sequence' => '9',
				'quickcreate' => false,
				'displaytype' => '1',
				'summary' => 'B',
				'block' => array(
					'blockid' => '103',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_ASSET_INFORMATION',
					'blockname' => 'Asset Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			9 => array(
				'name' => 'shippingmethod',
				'label' => 'Shipping Method',
				'label_raw' => 'Shipping Method',
				'mandatory' => false,
				'type' => array('name' => 'string'),
				'nullable' => true,
				'editable' => true,
				'uitype' => '2',
				'typeofdata' => 'V~O',
				'sequence' => '10',
				'quickcreate' => false,
				'displaytype' => '1',
				'summary' => 'B',
				'block' => array(
					'blockid' => '103',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_ASSET_INFORMATION',
					'blockname' => 'Asset Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			10 => array(
				'name' => 'shippingtrackingnumber',
				'label' => 'Shipping Tracking Number',
				'label_raw' => 'Shipping Tracking Number',
				'mandatory' => false,
				'type' => array('name' => 'string'),
				'nullable' => true,
				'editable' => true,
				'uitype' => '2',
				'typeofdata' => 'V~O',
				'sequence' => '11',
				'quickcreate' => false,
				'displaytype' => '1',
				'summary' => 'B',
				'block' => array(
					'blockid' => '103',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_ASSET_INFORMATION',
					'blockname' => 'Asset Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			11 => array(
				'name' => 'assetname',
				'label' => 'Asset Name',
				'label_raw' => 'Asset Name',
				'mandatory' => true,
				'type' => array('name' => 'string'),
				'nullable' => true,
				'editable' => true,
				'uitype' => '1',
				'typeofdata' => 'V~M',
				'sequence' => '12',
				'quickcreate' => false,
				'displaytype' => '1',
				'summary' => 'B',
				'block' => array(
					'blockid' => '103',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_ASSET_INFORMATION',
					'blockname' => 'Asset Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			12 => array(
				'name' => 'account',
				'label' => 'Customer Name',
				'label_raw' => 'Customer Name',
				'mandatory' => true,
				'type' => array(
					'refersTo' => array(0 => 'Accounts'),
					'name' => 'reference',
				),
				'nullable' => true,
				'editable' => true,
				'uitype' => '10',
				'typeofdata' => 'V~M',
				'sequence' => '13',
				'quickcreate' => false,
				'displaytype' => '1',
				'summary' => 'B',
				'block' => array(
					'blockid' => '103',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_ASSET_INFORMATION',
					'blockname' => 'Asset Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			13 => array(
				'name' => 'createdtime',
				'label' => 'Created Time',
				'label_raw' => 'Created Time',
				'mandatory' => false,
				'type' => array('name' => 'datetime'),
				'nullable' => false,
				'editable' => false,
				'uitype' => '70',
				'typeofdata' => 'DT~O',
				'sequence' => '14',
				'quickcreate' => false,
				'displaytype' => '2',
				'summary' => 'B',
				'block' => array(
					'blockid' => '103',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_ASSET_INFORMATION',
					'blockname' => 'Asset Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			14 => array(
				'name' => 'modifiedtime',
				'label' => 'Modified Time',
				'label_raw' => 'Modified Time',
				'mandatory' => false,
				'type' => array('name' => 'datetime'),
				'nullable' => false,
				'editable' => false,
				'uitype' => '70',
				'typeofdata' => 'DT~O',
				'sequence' => '15',
				'quickcreate' => false,
				'displaytype' => '2',
				'summary' => 'B',
				'block' => array(
					'blockid' => '103',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_ASSET_INFORMATION',
					'blockname' => 'Asset Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			15 => array(
				'name' => 'modifiedby',
				'label' => 'Last Modified By',
				'label_raw' => 'Last Modified By',
				'mandatory' => false,
				'type' => array(
					'refersTo' => array(0 => 'Users'),
					'name' => 'reference',
				),
				'nullable' => false,
				'editable' => false,
				'uitype' => '52',
				'typeofdata' => 'V~O',
				'sequence' => '16',
				'quickcreate' => false,
				'displaytype' => '3',
				'summary' => 'B',
				'block' => array(
					'blockid' => '103',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_ASSET_INFORMATION',
					'blockname' => 'Asset Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			16 => array(
				'name' => 'created_user_id',
				'label' => 'Created By',
				'label_raw' => 'Created By',
				'mandatory' => false,
				'type' => array(
					'refersTo' => array(0 => 'Users'),
					'name' => 'reference',
				),
				'nullable' => false,
				'editable' => false,
				'uitype' => '52',
				'typeofdata' => 'V~O',
				'sequence' => '17',
				'quickcreate' => false,
				'displaytype' => '2',
				'summary' => 'B',
				'block' => array(
					'blockid' => '103',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_ASSET_INFORMATION',
					'blockname' => 'Asset Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			17 => array(
				'name' => 'description',
				'label' => 'Notes',
				'label_raw' => 'Notes',
				'mandatory' => false,
				'type' => array('name' => 'text'),
				'nullable' => true,
				'editable' => true,
				'uitype' => '19',
				'typeofdata' => 'V~O',
				'sequence' => '1',
				'quickcreate' => false,
				'displaytype' => '1',
				'summary' => 'B',
				'block' => array(
					'blockid' => '105',
					'blocksequence' => '3',
					'blocklabel' => 'LBL_DESCRIPTION_INFORMATION',
					'blockname' => 'Notes',
				),
				'default' => '',
				'helpinfo' => '',
			),
			18 => array(
				'name' => 'id',
				'label' => 'assetsid',
				'label_raw' => 'assetsid',
				'mandatory' => false,
				'type' => array('name' => 'autogenerated'),
				'nullable' => false,
				'editable' => false,
				'default' => '',
				'uitype' => 7,
				'helpinfo' => '',
				'typeofdata' => 'V~O',
				'sequence' => 0,
				'quickcreate' => true,
				'displaytype' => 0,
				'summary' => 'N',
			),
		),
		'idPrefix' => '29',
		'isEntity' => true,
		'labelFields' => 'assetname',
		'filterFields' => array(
			'fields' => array(
				0 => 'asset_no',
				1 => 'assetname',
				2 => 'account',
				3 => 'product',
			),
			'linkfields' => array( 0 => 'assetname'),
			'pagesize' => 40,
			'relatedfields' => array(),
		),
		'relatedModules' => array(
			'HelpDesk' => array(
				'related_tabid' => '13',
				'related_module' => 'HelpDesk',
				'label' => 'HelpDesk',
				'labeli18n' => 'Support Tickets',
				'actions' => 'ADD,SELECT',
				'relationId' => '126',
				'relatedfield' => null,
				'relationtype' => 'N:N',
				'filterFields' => array(
					'fields' => array(
						0 => 'ticket_no',
						1 => 'ticket_title',
						2 => 'parent_id',
						3 => 'ticketstatus',
						4 => 'ticketpriorities',
						5 => 'assigned_user_id',
					),
					'linkfields' => array( 0 => 'ticket_title'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
			),
			'Documents' => array(
				'related_tabid' => '8',
				'related_module' => 'Documents',
				'label' => 'Documents',
				'labeli18n' => 'Documents',
				'actions' => 'ADD,SELECT',
				'relationId' => '127',
				'relatedfield' => null,
				'relationtype' => 'N:N',
				'filterFields' => array(
					'fields' => array(
						0 => 'note_no',
						1 => 'notes_title',
						2 => 'filename',
						3 => 'modifiedtime',
						4 => 'assigned_user_id',
					),
					'linkfields' => array( 0 => 'notes_title'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
			),
		),
	);

	private $faq = array(
		'label' => 'FAQ',
		'label_raw' => 'Faq',
		'name' => 'Faq',
		'createable' => true,
		'updateable' => true,
		'deleteable' => true,
		'retrieveable' => true,
		'fields' => array(
			0 => array(
				'name' => 'product_id',
				'label' => 'Product Name',
				'label_raw' => 'Product Name',
				'mandatory' => false,
				'type' => array(
					'refersTo' => array('Products', 'Services'),
					'name' => 'reference',
				),
				'nullable' => true,
				'editable' => true,
				'uitype' => '10',
				'typeofdata' => 'I~O',
				'sequence' => '1',
				'quickcreate' => false,
				'displaytype' => '1',
				'summary' => 'B',
				'block' => array(
					'blockid' => '37',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_FAQ_INFORMATION',
					'blockname' => 'Faq Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			1 => array(
				'name' => 'faq_no',
				'label' => 'Faq No',
				'label_raw' => 'Faq No',
				'mandatory' => false,
				'type' => array(
					'name' => 'string',
				),
				'nullable' => false,
				'editable' => false,
				'uitype' => '4',
				'typeofdata' => 'V~O',
				'sequence' => '2',
				'quickcreate' => false,
				'displaytype' => '1',
				'summary' => 'B',
				'block' => array(
					'blockid' => '37',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_FAQ_INFORMATION',
					'blockname' => 'Faq Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			2 => array(
				'name' => 'faqstatus',
				'label' => 'Status',
				'label_raw' => 'Status',
				'mandatory' => true,
				'type' => array(
					'picklistValues' => array(
						0 => array(
							'label' => 'Draft',
							'value' => 'Draft',
							'tooltip' => '',
						),
						1 => array(
							'label' => 'Reviewed',
							'value' => 'Reviewed',
							'tooltip' => '',
						),
						2 => array(
							'label' => 'Published',
							'value' => 'Published',
							'tooltip' => '',
						),
						3 => array(
							'label' => 'Obsolete',
							'value' => 'Obsolete',
							'tooltip' => '',
						),
					),
					'defaultValue' => 'Draft',
					'name' => 'picklist'
				),
				'nullable' => false,
				'editable' => true,
				'uitype' => '15',
				'typeofdata' => 'V~M',
				'sequence' => '3',
				'quickcreate' => false,
				'displaytype' => '1',
				'summary' => 'B',
				'block' => array(
					'blockid' => '37',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_FAQ_INFORMATION',
					'blockname' => 'Faq Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			3 => array(
				'name' => 'faqcategories',
				'label' => 'Category',
				'label_raw' => 'Category',
				'mandatory' => false,
				'type' => array(
					'picklistValues' => array(
						array(
							'label' => 'General',
							'value' => 'General',
							'tooltip' => '',
						),
						array(
							'label' => 'Others',
							'value' => 'Others',
							'tooltip' => '',
						),
						array(
							'label' => 'Testing',
							'value' => 'Testing',
							'tooltip' => '',
						),
						array(
							'label' => 'Website',
							'value' => 'Website',
							'tooltip' => '',
						),
					),
					'defaultValue' => 'General',
					'name' => 'picklist',
				),
				'nullable' => false,
				'editable' => true,
				'uitype' => '15',
				'typeofdata' => 'V~O',
				'sequence' => '4',
				'quickcreate' => false,
				'displaytype' => '1',
				'summary' => 'B',
				'block' => array(
					'blockid' => '37',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_FAQ_INFORMATION',
					'blockname' => 'Faq Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			4 => array(
				'name' => 'createdtime',
				'label' => 'Created Time',
				'label_raw' => 'Created Time',
				'mandatory' => false,
				'type' => array('name' => 'datetime'),
				'nullable' => false,
				'editable' => false,
				'uitype' => '70',
				'typeofdata' => 'DT~O',
				'sequence' => '5',
				'quickcreate' => false,
				'displaytype' => '2',
				'summary' => 'B',
				'block' => array(
					'blockid' => '37',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_FAQ_INFORMATION',
					'blockname' => 'Faq Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			5 => array(
				'name' => 'modifiedtime',
				'label' => 'Modified Time',
				'label_raw' => 'Modified Time',
				'mandatory' => false,
				'type' => array('name' => 'datetime'),
				'nullable' => false,
				'editable' => false,
				'uitype' => '70',
				'typeofdata' => 'DT~O',
				'sequence' => '6',
				'quickcreate' => false,
				'displaytype' => '2',
				'summary' => 'B',
				'block' => array(
					'blockid' => '37',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_FAQ_INFORMATION',
					'blockname' => 'Faq Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			6 => array(
				'name' => 'question',
				'label' => 'Question',
				'label_raw' => 'Question',
				'mandatory' => true,
				'type' => array(
					'name' => 'text',
				),
				'nullable' => true,
				'editable' => true,
				'uitype' => '19',
				'typeofdata' => 'V~M',
				'sequence' => '7',
				'quickcreate' => false,
				'displaytype' => '1',
				'summary' => 'B',
				'block' => array(
					'blockid' => '37',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_FAQ_INFORMATION',
					'blockname' => 'Faq Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			7 => array(
				'name' => 'modifiedby',
				'label' => 'Last Modified By',
				'label_raw' => 'Last Modified By',
				'mandatory' => false,
				'type' => array(
					'refersTo' => array(0 => 'Users'),
					'name' => 'reference',
				),
				'nullable' => false,
				'editable' => false,
				'uitype' => '52',
				'typeofdata' => 'V~O',
				'sequence' => '7',
				'quickcreate' => false,
				'displaytype' => '3',
				'summary' => 'B',
				'block' => array(
					'blockid' => '37',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_FAQ_INFORMATION',
					'blockname' => 'Faq Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			8 => array(
				'name' => 'faq_answer',
				'label' => 'Answer',
				'label_raw' => 'Answer',
				'mandatory' => true,
				'type' => array('name' => 'text'),
				'nullable' => true,
				'editable' => true,
				'uitype' => '19',
				'typeofdata' => 'V~M',
				'sequence' => '8',
				'quickcreate' => false,
				'displaytype' => '1',
				'summary' => 'B',
				'block' => array(
					'blockid' => '37',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_FAQ_INFORMATION',
					'blockname' => 'Faq Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			9 => array(
				'name' => 'created_user_id',
				'label' => 'Created By',
				'label_raw' => 'Created By',
				'mandatory' => false,
				'type' => array(
					'refersTo' => array(0 => 'Users'),
					'name' => 'reference',
				),
				'nullable' => false,
				'editable' => false,
				'uitype' => '52',
				'typeofdata' => 'V~O',
				'sequence' => '9',
				'quickcreate' => false,
				'displaytype' => '2',
				'summary' => 'B',
				'block' => array(
					'blockid' => '37',
					'blocksequence' => '1',
					'blocklabel' => 'LBL_FAQ_INFORMATION',
					'blockname' => 'Faq Information',
				),
				'default' => '',
				'helpinfo' => '',
			),
			10 => array(
				'name' => 'id',
				'label' => 'id',
				'label_raw' => 'id',
				'mandatory' => false,
				'type' => array('name' => 'autogenerated'),
				'nullable' => false,
				'editable' => false,
				'default' => '',
				'uitype' => 7,
				'helpinfo' => '',
				'typeofdata' => 'V~O',
				'sequence' => 0,
				'quickcreate' => true,
				'displaytype' => 0,
				'summary' => 'N',
			),
		),
		'idPrefix' => '3',
		'isEntity' => true,
		'labelFields' => 'question',
		'filterFields' => array(
			'fields' => array(
				0 => 'faq_no',
				1 => 'question',
				2 => 'faqcategories',
				3 => 'product_id',
				4 => 'createdtime',
				5 => 'modifiedtime',
			),
			'linkfields' => array( 0 => 'question'),
			'pagesize' => 40,
			'relatedfields' => array(),
		),
		'relatedModules' => array(
			'Documents' => array(
				'related_tabid' => '8',
				'related_module' => 'Documents',
				'label' => 'Documents',
				'labeli18n' => 'Documents',
				'actions' => 'add,select',
				'relationId' => '89',
				'relatedfield' => null,
				'relationtype' => 'N:N',
				'filterFields' => array(
					'fields' => array(
						0 => 'note_no',
						1 => 'notes_title',
						2 => 'filename',
						3 => 'modifiedtime',
						4 => 'assigned_user_id',
					),
					'linkfields' => array( 0 => 'notes_title'),
					'pagesize' => 40,
					'relatedfields' => array(),
				),
			),
		),
	);

	public function __construct() {
		$this->asset['fields'][4]['default'] = date('Y-m-d');
		$this->asset['fields'][5]['default'] = date('Y-m-d');
		parent::__construct();
	}

	/**
	 * Method testonemodule
	 * @test
	 */
	public function testonemodule() {
		global $current_user;
		$actual = vtws_describe('Assets', $current_user);
		$this->assertEquals($this->asset, $actual);
	}

	/**
	 * Method testtwomodules
	 * @test
	 */
	public function testtwomodules() {
		global $current_user;
		$actual = vtws_describe('Assets,Faq', $current_user);
		$expected = array(
			'Assets' => $this->asset,
			'Faq' => $this->faq,
		);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * Method testactormodule
	 * @test
	 */
	public function testactormodule() {
		global $current_user;
		$actual = vtws_describe('Currency', $current_user);
		$expected = array(
			'label' => 'Currency',
			'label_raw' => 'Currency',
			'name' => 'Currency',
			'createable' => false,
			'updateable' => false,
			'deleteable' => false,
			'retrieveable' => true,
			'fields' => array(
				array(
					'name' => 'id',
					'label' => 'id',
					'label_raw' => 'id',
					'mandatory' => false,
					'editable' => false,
					'type' => array('name' => 'autogenerated'),
					'nullable' => false,
					'default' => '',
				),
				array(
					'name' => 'currency_name',
					'label' => 'Currency Name',
					'label_raw' => 'currency name',
					'mandatory' => false,
					'editable' => true,
					'type' => array('name' => 'string'),
					'nullable' => false,
					'nullable' => true,
				),
				array(
					'name' => 'currency_code',
					'label' => 'Currency Code',
					'label_raw' => 'currency code',
					'mandatory' => false,
					'editable' => true,
					'type' => array('name' => 'string'),
					'nullable' => false,
					'nullable' => true,
				),
				array(
					'name' => 'currency_symbol',
					'label' => 'Symbol',
					'label_raw' => 'currency symbol',
					'mandatory' => false,
					'editable' => true,
					'type' => array('name' => 'string'),
					'nullable' => false,
					'nullable' => true,
				),
				array(
					'name' => 'conversion_rate',
					'label' => 'Conversion Rate',
					'label_raw' => 'conversion rate',
					'mandatory' => false,
					'editable' => true,
					'type' => array('name' => 'double'),
					'nullable' => false,
					'nullable' => true,
				),
				array(
					'name' => 'currency_status',
					'label' => 'Status',
					'label_raw' => 'currency status',
					'mandatory' => false,
					'editable' => true,
					'type' => array('name' => 'string'),
					'nullable' => false,
					'nullable' => true,
				),
				array(
					'name' => 'defaultid',
					'label' => 'Default ID',
					'label_raw' => 'defaultid',
					'mandatory' => true,
					'editable' => true,
					'type' => array('name' => 'string'),
					'nullable' => false,
					'default' => '0',
					'nullable' => false,
				),
				array(
					'name' => 'deleted',
					'label' => 'Deleted',
					'label_raw' => 'Deleted',
					'mandatory' => true,
					'editable' => true,
					'type' => array('name' => 'integer'),
					'nullable' => false,
					'default' => '0',
					'nullable' => false,
				),
				array(
					'name' => 'currency_position',
					'label' => 'Currency Position',
					'label_raw' => 'currency position',
					'mandatory' => true,
					'editable' => true,
					'type' => array('name' => 'char'),
					'nullable' => false,
					'nullable' => false,
				),
			),
			'idPrefix' => '21',
			'isEntity' => false,
			'labelFields' => 'currency_name',
			'filterFields' => array(
				'fields' => array(
					0 => 'id',
					1 => 'currency_name',
					2 => 'currency_code',
					3 => 'currency_symbol',
					4 => 'conversion_rate',
					5 => 'currency_position',
					6 => 'currency_status',
				),
				'linkfields' => array('id'),
				'pagesize' => 40,
			),
			'relatedModules' => array(),
		);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * Method testemptymodule
	 * @test
	 */
	public function testemptymodule() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		vtws_describe('', $current_user);
	}

	/**
	 * Method testnopermissiononemodule
	 * @test
	 */
	public function testnopermissiononemodule() {
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(11); // nocreate
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		vtws_describe('cbTermConditions', $user);
	}

	/**
	 * Method testnopermissiontwomodules
	 * @test
	 */
	public function testnopermissiontwomodules() {
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(11); // nocreate
		$actual = vtws_describe('Assets,cbTermConditions', $user);
		$expected = array('Assets' => $this->asset);
		$expected['Assets']['createable'] = false;
		$expected['Assets']['updateable'] = false;
		$this->assertEquals($expected, $actual);
	}

	/**
	 * Method testnopermissionthreemodules
	 * @test
	 */
	public function testnopermissionthreemodules() {
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(11); // nocreate
		$actual = vtws_describe('Assets,cbTermConditions,Faq', $user);
		$expa = $this->asset;
		$expa['createable'] = false;
		$expa['updateable'] = false;
		$expf = $this->faq;
		$expf['createable'] = false;
		$expf['updateable'] = false;
		$expf['deleteable'] = false;
		$expected = array(
			'Assets' => $expa,
			'Faq' => $expf,
		);
		$this->assertEquals($expected, $actual);
	}
}
?>