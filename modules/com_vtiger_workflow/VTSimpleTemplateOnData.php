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

include_once 'modules/com_vtiger_workflow/VTSimpleTemplateOnData.inc';

class VTSimpleTemplateOnDataOnDataTest extends PHPUnit_Framework_TestCase {

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
		$actual = $ct->render($entityCache, 'Accounts',$data);
		$this->assertEquals($expected, $actual, 'Constant String');
		// Account variables
		$ct = new VTSimpleTemplateOnData('AccountId:$account_no - AccountName:$accountname');
		$expected = 'AccountId:hard coded account number - AccountName:hard coded account name';
		$actual = $ct->render($entityCache, 'Accounts',$data);
		$this->assertEquals($expected, $actual,'Account variables');
		// User variables
		$ct = new VTSimpleTemplateOnData('$(assigned_user_id : (Users) email1)');
		$expected = 'noreply@tsolucio.com';
		$actual = $ct->render($entityCache, 'Accounts',$data);
		$this->assertEquals($expected, $actual,'User variables');
		// Member of
		$ct = new VTSimpleTemplateOnData('$(account_id : (Accounts) accountname)​​​​​​​');
		$expected = '​​​​​​​'; // this information does not exist so we get an empty string back
		$actual = $ct->render($entityCache, 'Accounts',$data);
		$this->assertEquals($expected, $actual,'Member of variables');
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
			'assigned_user_id'=>$userId
		);
		$util = new VTWorkflowUtils();
		$adminUser = $util->adminUser();
		$entityCache = new VTEntityCache($adminUser);
		// Detail View URL
		$ct = new VTSimpleTemplateOnData('$(general : (__VtigerMeta__) crmdetailviewurl)');
		$expected = $site_URL.'/index.php?action=DetailView&module=Accounts&record=';
		$actual = $ct->render($entityCache, 'Accounts',$data);
		$this->assertEquals($expected, $actual, 'Detail View URL');
		// Today
		$ct = new VTSimpleTemplateOnData('$(general : (__VtigerMeta__) date)');
		$expected = date('m-d-Y');
		$actual = $ct->render($entityCache, 'Accounts',$data);
		$this->assertEquals($expected, $actual,'Today');
		// Record ID
		$ct = new VTSimpleTemplateOnData('$(general : (__VtigerMeta__) recordId)');
		$expected = '';
		$actual = $ct->render($entityCache, 'Accounts',$data);
		$this->assertEquals($expected, $actual,'Record ID');
		// Comments
		$ct = new VTSimpleTemplateOnData('$(general : (__VtigerMeta__) comments)​​​​​​​');
		$expected = '​​​​​​​'; // this information does not exist so we get an empty string back
		$actual = $ct->render($entityCache, 'Accounts',$data);
		$this->assertEquals($expected, $actual,'Comments');
		// Teardown
		$util->revertUser();
	}

}
