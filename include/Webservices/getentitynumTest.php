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

include_once 'include/Webservices/getentitynum.php';

class getentitynumTest extends TestCase {

	/**
	 * Method testgetentitynum
	 * @test
	 */
	public function testgetentitynum() {
		global $current_user;
		$expected = array(array(
			'Leads' => array(
				'LEA'
			),
			'Accounts' => array(
				'ACC'
			),
			'Campaigns' => array(
				'CAM'
			),
			'Contacts' => array(
				'CON'
			),
			'Potentials' => array(
				'POT'
			),
			'HelpDesk' => array(
				'TT'
			),
			'Quotes' => array(
				'QUO'
			),
			'SalesOrder' => array(
				'SO'
			),
			'PurchaseOrder' => array(
				'PO'
			),
			'Invoice' => array(
				'INV'
			),
			'Products' => array(
				'PRO'
			),
			'Vendors' => array(
				'VEN'
			),
			'PriceBooks' => array(
				'PB'
			),
			'Faq' => array(
				'FAQ'
			),
			'Documents' => array(
				'DOC'
			),
			'ServiceContracts' => array(
				'SERCON'
			),
			'Services' => array(
				'SER'
			),
			'cbupdater' => array(
				'cbupd-'
			),
			'CobroPago' => array(
				'PAY-'
			),
			'ProjectMilestone' => array(
				'prjm-'
			),
			'ProjectTask' => array(
				'prjt-'
			),
			'Project' => array(
				'prj-'
			),
			'GlobalVariable' => array(
				'glb-'
			),
			'InventoryDetails' => array(
				'InvDet-'
			),
			'Assets' => array(
				'AST-'
			),
			'cbMap' => array(
				'BMAP-'
			),
			'cbTermConditions' => array(
				'cbTermConditions-'
			),
			'cbtranslation' => array(
				'cbtranslation-'
			),
			'BusinessActions' => array(
				'bact-'
			),
			'cbSurvey' => array(
				'srvy-'
			),
			'cbSurveyQuestion' => array(
				'srvyq-'
			),
			'cbSurveyDone' => array(
				'srvyd-'
			),
			'cbSurveyAnswer' => array(
				'srvya-'
			),
			'cbCompany' => array(
				'cmp-'
			),
			'cbCVManagement' => array(
				'cvm-'
			),
			'cbQuestion' => array(
				'cbQ-'
			),
			'ProductComponent' => array(
				'pcmpnt'
			),
			'Messages' => array(
				'MSG-'
			),
			'cbPulse' => array(
				'PL-'
			),
			'MsgTemplate' => array(
				'MSGT-'
			),
			'cbCredentials' => array(
				'CRED-'
			),
			'DocumentFolders' => array(
				'folder-'
			),
			'pricebookproductrel' => array(
				'PriceList-'
			),
			'AutoNumberPrefix' => array(
				'ANPx-'
			),
		));
		$this->assertEquals($expected, vtws_get_entitynum($current_user));
		$ruser = new Users();
		$ruser->retrieveCurrentUserInfoFromFile(11); // nocreate
		unset($expected[0]['cbTermConditions']);
		$this->assertEquals($expected, vtws_get_entitynum($ruser));
	}
}
?>