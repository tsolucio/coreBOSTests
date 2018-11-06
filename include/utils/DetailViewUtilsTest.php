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

use PHPUnit\Framework\TestCase;

class testDetailViewUtils extends TestCase {

	/**
	 * Method testgetRelatedLists
	 * @test
	 */
	public function testgetRelatedLists() {
		$currentModule = 'Accounts';
		$focus = CRMEntity::getInstance($currentModule);
		$restrictedRelations = array();
		$actual = getRelatedLists($currentModule, $focus, $restrictedRelations);
		$expected = array(
			'Contacts' => array (
			  'related_tabid' => '4',
			  'relationId' => '1',
			  'actions' => 'add',
			),
			'Potentials' => array (
			  'related_tabid' => '2',
			  'relationId' => '2',
			  'actions' => 'add',
			),
			'Quotes' => array (
			  'related_tabid' => '20',
			  'relationId' => '3',
			  'actions' => 'add',
			),
			'Sales Order' => array (
			  'related_tabid' => '22',
			  'relationId' => '4',
			  'actions' => 'add',
			),
			'Invoice' => array (
			  'related_tabid' => '23',
			  'relationId' => '5',
			  'actions' => 'add',
			),
			'Activities' => array (
			  'related_tabid' => '63',
			  'relationId' => '6',
			  'actions' => 'add',
			),
			'Emails' => array (
			  'related_tabid' => '10',
			  'relationId' => '7',
			  'actions' => 'add',
			),
			'Documents' => array (
			  'related_tabid' => '8',
			  'relationId' => '9',
			  'actions' => 'add,select',
			),
			'HelpDesk' => array (
			  'related_tabid' => '13',
			  'relationId' => '10',
			  'actions' => 'add',
			),
			'Products' => array (
			  'related_tabid' => '14',
			  'relationId' => '11',
			  'actions' => 'select',
			),
			'Campaigns' => array (
			  'related_tabid' => '26',
			  'relationId' => '87',
			  'actions' => 'select',
			),
			'Service Contracts' => array (
			  'related_tabid' => '37',
			  'relationId' => '92',
			  'actions' => 'ADD',
			),
			'Services' => array (
			  'related_tabid' => '38',
			  'relationId' => '108',
			  'actions' => 'SELECT',
			),
			'CobroPago' => array (
			  'related_tabid' => '42',
			  'relationId' => '116',
			  'actions' => 'ADD',
			),
			'Assets' => array (
			  'related_tabid' => '43',
			  'relationId' => '128',
			  'actions' => 'ADD',
			),
			'Projects' => array (
			  'related_tabid' => '50',
			  'relationId' => '137',
			  'actions' => 'ADD',
			),
			'InventoryDetails' => array (
			  'related_tabid' => '57',
			  'relationId' => '155',
			  'actions' => '',
			),
			'cbSurveyDone' => array (
			  'related_tabid' => '68',
			  'relationId' => '178',
			  'actions' => 'ADD',
			),
			'cbSurveyAnswer' => array (
			  'related_tabid' => '69',
			  'relationId' => '182',
			  'actions' => 'ADD',
			),
			'cbCompany' => array (
			  'related_tabid' => '70',
			  'relationId' => '188',
			  'actions' => 'ADD',
			),
		);
		$this->assertEquals($expected, $actual, 'testgetRelatedLists get accounts no restrictions');
		$restrictedRelations = array(1,4,6);
		$actual = getRelatedLists($currentModule, $focus, $restrictedRelations);
		$expected = array(
			'Contacts' => array (
			  'related_tabid' => '4',
			  'relationId' => '1',
			  'actions' => 'add',
			),
			'Sales Order' => array (
			  'related_tabid' => '22',
			  'relationId' => '4',
			  'actions' => 'add',
			),
			'Activities' => array (
			  'related_tabid' => '63',
			  'relationId' => '6',
			  'actions' => 'add',
			),
		);
		$this->assertEquals($expected, $actual, 'testgetRelatedLists get accounts with restrictions');

		//////////////////////////
		$currentModule = 'Potentials';
		$focus = CRMEntity::getInstance($currentModule);
		$restrictedRelations = array();
		$actual = getRelatedLists($currentModule, $focus, $restrictedRelations);
		$expected = array(
			'Activities' => array (
				'related_tabid' => '63',
				'relationId' => '30',
				'actions' => 'add',
			),
			'Contacts' => array (
				'related_tabid' => '4',
				'relationId' => '31',
				'actions' => 'select',
			),
			'Products' => array (
				'related_tabid' => '14',
				'relationId' => '32',
				'actions' => 'select',
			),
			'Sales Stage History' => array (
				'related_tabid' => '0',
				'relationId' => '33',
				'actions' => '',
			),
			'Documents' => array (
				'related_tabid' => '8',
				'relationId' => '34',
				'actions' => 'add,select',
			),
			'Quotes' => array (
				'related_tabid' => '20',
				'relationId' => '35',
				'actions' => 'add',
			),
			'Sales Order' => array (
				'related_tabid' => '22',
				'relationId' => '36',
				'actions' => 'add',
			),
			'Services' => array (
				'related_tabid' => '38',
				'relationId' => '110',
				'actions' => 'SELECT',
			),
			'CobroPago' => array (
				'related_tabid' => '42',
				'relationId' => '124',
				'actions' => 'ADD',
			),
			'Emails' => array (
				'related_tabid' => '10',
				'relationId' => '148',
				'actions' => 'ADD',
			),
		);
		$this->assertEquals($expected, $actual, 'testgetRelatedLists get potentials no restrictions');
		$restrictedRelations = array(31,34,36);
		$actual = getRelatedLists($currentModule, $focus, $restrictedRelations);
		$expected = array(
			'Contacts' => array (
				'related_tabid' => '4',
				'relationId' => '31',
				'actions' => 'select',
			),
			'Documents' => array (
				'related_tabid' => '8',
				'relationId' => '34',
				'actions' => 'add,select',
			),
			'Sales Order' => array (
				'related_tabid' => '22',
				'relationId' => '36',
				'actions' => 'add',
			),
		);
		$this->assertEquals($expected, $actual, 'testgetRelatedLists get potentials with restrictions');
	}

	/**
	 * Method testgetRelatedListsInformation
	 * @test
	 */
	public function testgetRelatedListsInformation() {
		$this->assertTrue(true, 'DEPRECATED METHOD: Do not use. call individual methods to get specific records');
	}

	/**
	 * Method testgetRelatedListInfoById
	 * @test
	 */
	public function testgetRelatedListInfoById() {
		$relationInfo = getRelatedListInfoById(31);
		$expected = array(
			'relatedTabId' => '4',
			'functionName' => 'get_contacts',
			'label' => 'Contacts',
			'actions' => 'select',
			'relationId' => '31',
		);
		$this->assertEquals($expected, $relationInfo, 'testgetRelatedListInfoById');
		$relationInfo = getRelatedListInfoById(36);
		$expected = array(
			'relatedTabId' => '22',
			'functionName' => 'get_salesorder',
			'label' => 'Sales Order',
			'actions' => 'add',
			'relationId' => '36',
		);
		$this->assertEquals($expected, $relationInfo, 'testgetRelatedListInfoById');
	}
}