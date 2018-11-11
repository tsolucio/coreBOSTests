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

include_once 'modules/com_vtiger_workflow/VTSimpleTemplateOnData.inc';

class VTSimpleTemplateOnDataOnDataTest extends TestCase {

	/**
	 * Method testRender
	 * @test
	 */
	public function testRender() {
		// Setup
		$entityId = '11x74';
		$userId = '19x6'; // testmdy
		$data = array(
			'accountname' => 'hard coded account name',
			'account_no' => 'hard coded account number',
			'assigned_user_id'=>$userId
		);
		$util = new VTWorkflowUtils();
		$adminUser = $util->adminUser();
		$entityCache = new VTEntityCache($adminUser);
		// Constant string.
		$ct = new VTSimpleTemplateOnData('Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto.');
		$expected = 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto.';
		$actual = $ct->render($entityCache, 'Accounts', $data);
		$this->assertEquals($expected, $actual, 'Constant String');
		// Account variables
		$ct = new VTSimpleTemplateOnData('AccountId:$account_no - AccountName:$accountname');
		$expected = 'AccountId:hard coded account number - AccountName:hard coded account name';
		$actual = $ct->render($entityCache, 'Accounts', $data);
		$this->assertEquals($expected, $actual, 'Account variables');
		// User variables
		$ct = new VTSimpleTemplateOnData('$(assigned_user_id : (Users) email1)');
		$expected = 'noreply@tsolucio.com';
		$actual = $ct->render($entityCache, 'Accounts', $data);
		$this->assertEquals($expected, $actual, 'User variables');
		// Member of
		$ct = new VTSimpleTemplateOnData('$(account_id : (Accounts) accountname)​​​​​​​');
		$expected = '​​​​​​​'; // this information does not exist so we get an empty string back
		$actual = $ct->render($entityCache, 'Accounts', $data);
		$this->assertEquals($expected, $actual, 'Member of variables');
		// Teardown
		$util->revertUser();
	}

	/**
	 * Method testMeta
	 * @test
	 */
	public function testMeta() {
		global $site_URL;
		// Setup
		$entityId = '12x1607';
		$userId = '19x6'; // testmdy
		$data = array(
			'accountname' => 'hard coded account name',
			'account_no' => 'hard coded account number',
			'assigned_user_id'=>$userId,
		);
		$util = new VTWorkflowUtils();
		$adminUser = $util->adminUser();
		$entityCache = new VTEntityCache($adminUser);
		// Detail View URL
		$ct = new VTSimpleTemplateOnData('$(general : (__VtigerMeta__) crmdetailviewurl)');
		$expected = $site_URL.'/index.php?action=DetailView&module=Accounts&record=0';
		$actual = $ct->render($entityCache, 'Accounts', $data);
		$this->assertEquals($expected, $actual, 'Detail View URL');
		// Today
		$ct = new VTSimpleTemplateOnData('$(general : (__VtigerMeta__) date)');
		$expected = date('m-d-Y');
		$actual = $ct->render($entityCache, 'Accounts', $data);
		$this->assertEquals($expected, $actual, 'Today');
		// Record ID
		$ct = new VTSimpleTemplateOnData('$(general : (__VtigerMeta__) recordId)');
		$expected = '0';
		$actual = $ct->render($entityCache, 'Accounts', $data);
		$this->assertEquals($expected, $actual, 'Record ID');
		// Teardown
		$util->revertUser();
	}

	/**
	 * Method testMetaExceptionOnRelated
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testMetaExceptionOnRelated() {
		$entityId = '12x1607';
		$userId = '19x6'; // testmdy
		$data = array(
			'accountname' => 'hard coded account name',
			'account_no' => 'hard coded account number',
			'assigned_user_id'=>$userId,
		);
		$util = new VTWorkflowUtils();
		$adminUser = $util->adminUser();
		$entityCache = new VTEntityCache($adminUser);
		// Comments
		$ct = new VTSimpleTemplateOnData('$(general : (__VtigerMeta__) comments)​​​​​​​');
		$expected = '​​​​​​​'; // this information does not exist so we get an empty string back
		$actual = $ct->render($entityCache, 'Accounts', $data);
		$this->assertEquals($expected, $actual, 'Comments');
		// Teardown
		$util->revertUser();
	}

	/**
	 * Method testOwnerFields
	 * @test
	 */
	public function testOwnerFields() {
		// Setup
		$entityId = '28x14331'; // payment
		$data = array(
			'assigned_user_id' => '19x6',
			'cyp_no' => 'PAY-0000038',
			'reference' => 'Chip Martin',
			'parent_id' => '11x144',
			'related_id' => '7x3934',
			'register' => '2016-01-08',
			'duedate' => '2016-06-17',
			'paymentdate' => '2016-06-17',
			'paid' => '1',
			'credit' => '1',
			'paymentmode' => 'Cash',
			'paymentcategory' => 'Sale',
			'amount' => '443.00',
			'cost' => '200.00',
			'benefit' => '243.00',
			'createdtime' => '2015-08-16 09:44:21',
			'modifiedtime' => '2015-12-06 14:56:24',
			'reports_to_id' => '19x7',
			'description' => 'mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam auctor, velit eget laoreet posuere, enim nisl elementum purus, accumsan interdum libero dui nec',
			'created_user_id' => '19x1',
			'record_id' => $entityId,
			'record_module' => 'CobroPago',
		);
		$adminUser = Users::getActiveAdminUser();
		$entityCache = new VTEntityCache($adminUser);
		// Constant string.
		$ct = new VTSimpleTemplateOnData('The user assigned to this payment is $assigned_user_id and the user who will have a comission is $reports_to_id.');
		$expected = 'The user assigned to this payment is 19x6 and the user who will have a comission is 19x7.';
		$actual = $ct->render($entityCache, 'CobroPago', $data);
		$this->assertEquals($expected, $actual, 'User variables');
	}
}
