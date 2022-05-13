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

$Vtiger_Utils_Log = false;

class QueryTest extends TestCase {

	/**
	 * Method testQuery
	 * @test
	 */
	public function testQuery() {
		global $current_user;
		$actual = vtwsQueryWithTotal("select account_no from Accounts where accountname='Chemex Labs Ltd';", $current_user);
		$expected = array(
			'wsresult' => array(0 => array(
				'account_no' => 'ACC1',
				'id' => '11x74',
			)),
			'wsmoreinfo' => array(
				'totalrows' => 1
			),
		);
		$this->assertEquals($expected, $actual, 'normal query');
	}

	/**
	 * Method testQueryCache
	 * @test
	 */
	public function testQueryCache() {
		global $current_user,$Vtiger_Utils_Log;
		$Vtiger_Utils_Log = false;
		$Module = 'HelpDesk';
		$modhd = Vtiger_Module::getInstance($Module);
		$blkhd = Vtiger_Block::getInstance('LBL_TICKET_INFORMATION', $modhd);
		$fldhd = Vtiger_Field::getInstance('hdimage', $modhd);
		if ($fldhd) {
			// already there so we delete it
			$fldhd->delete(true);
		}
		$actualbefore = vtws_query("select * from HelpDesk limit 1;", $current_user);
		$expected = array(
			0 => array(
				'ticket_title' => 'Problem about cannot hear your salesperson on asterix calls',
				'from_mailscanner' => '0',
				'parent_id' => '12x1872',
				'assigned_user_id' => '19x5',
				'product_id' => '14x2617',
				'ticketpriorities' => 'Low',
				'ticketstatus' => 'Open',
				'ticketseverities' => 'Minor',
				'hours' => '26.000000',
				'createdtime' => '2015-04-06 17:11:52',
				'ticketcategories' => 'Small Problem',
				'days' => '2',
				'update_log' => 'Ticket created. Assigned to  user  Administrator -- Monday 15th February 2016 12:00:45 AM by admin--//--',
				'modifiedtime' => '2016-06-28 08:31:55',
				'ticket_no' => 'TT00001',
				'from_portal' => '0',
				'modifiedby' => '19x1',
				'email' => 'dahlia_benett@aol.com',
				'commentadded' => '',
				'created_user_id' => '19x1',
				'description' => " Cur deinde Metrodori liberos commendas? Si quae forte-possumus. Quae contraria sunt his, malane? Quis suae urbis conservatorem Codrum, quis Erechthei filias non maxime laudat? Primum quid tu dicis breve? Habent enim et bene longam et satis litigiosam disputationem. Duo Reges: constructio interrete. Cur, nisi quod turpis oratio est? Iis igitur est difficilius satis facere, qui se Latina scripta dicunt contemnere. \n\n",
				'solution' => '',
				'id' => '17x2636',
			),
		);
		$this->assertEquals($expected, $actualbefore, 'normal query all fields before modification');
		$fieldInstance = new Vtiger_Field();
		$fieldInstance->name = 'hdimage';
		$fieldInstance->label = 'hdimage';
		$fieldInstance->columntype = 'varchar(103)';
		$fieldInstance->uitype = 69;
		$fieldInstance->displaytype = 1;
		$fieldInstance->typeofdata = 'V~O';
		$fieldInstance->quickcreate = 0;
		$blkhd->addField($fieldInstance);
		unset(VTCacheUtils::$_fieldinfo_cache[13], VTCacheUtils::$_module_columnfields_cache[$Module]);
		vtws_query('', '', true);
		$actualafter = vtws_query("select * from HelpDesk limit 1;", $current_user);
		$expected = array(
			0 => array(
				'ticket_title' => 'Problem about cannot hear your salesperson on asterix calls',
				'from_mailscanner' => '0',
				'parent_id' => '12x1872',
				'assigned_user_id' => '19x5',
				'product_id' => '14x2617',
				'ticketpriorities' => 'Low',
				'ticketstatus' => 'Open',
				'ticketseverities' => 'Minor',
				'hours' => '26.000000',
				'createdtime' => '2015-04-06 17:11:52',
				'ticketcategories' => 'Small Problem',
				'days' => '2',
				'update_log' => 'Ticket created. Assigned to  user  Administrator -- Monday 15th February 2016 12:00:45 AM by admin--//--',
				'modifiedtime' => '2016-06-28 08:31:55',
				'ticket_no' => 'TT00001',
				'from_portal' => '0',
				'modifiedby' => '19x1',
				'email' => 'dahlia_benett@aol.com',
				'hdimage' => '',
				'commentadded' => '',
				'created_user_id' => '19x1',
				'description' => " Cur deinde Metrodori liberos commendas? Si quae forte-possumus. Quae contraria sunt his, malane? Quis suae urbis conservatorem Codrum, quis Erechthei filias non maxime laudat? Primum quid tu dicis breve? Habent enim et bene longam et satis litigiosam disputationem. Duo Reges: constructio interrete. Cur, nisi quod turpis oratio est? Iis igitur est difficilius satis facere, qui se Latina scripta dicunt contemnere. \n\n",
				'solution' => '',
				'id' => '17x2636',
				'hdimagefullpath' => '',
			),
		);
		$this->assertEquals($expected, $actualafter, 'normal query all fields after modification');
		$fldhd = Vtiger_Field::getInstance('hdimage', $modhd);
		if ($fldhd) {
			$fldhd->delete(true);
		}
		unset(VTCacheUtils::$_fieldinfo_cache[13], VTCacheUtils::$_module_columnfields_cache[$Module]);
		vtws_query('', '', true);
	}

	/**
	 * Method testMissingSemicolon
	 * @test
	 */
	public function testCreateWithDatesWrong() {
		global $current_user;
		$this->expectException(Exception::class);
		$this->expectExceptionMessage('Unexpected input at line1: "');
		vtws_query('select account_no from Accounts where accountname="Chemex Labs Ltd"', $current_user);
	}

	/**
	 * Method testWrongModule
	 * @test
	 */
	public function testWrongModule() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		vtws_query('select account_no from DoesNotExist where accountname="Chemex Labs Ltd"', $current_user);
	}

	/**
	 * Method testWrongSyntax
	 * @test
	 */
	public function testWrongSyntax() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$QUERYSYNTAX);
		vtws_query('select account_no from Accounts whereaccountname="Chemex Labs Ltd";', $current_user);
	}


	/**
	 * Method testWrongSyntax
	 * @test
	 */
	public function testNoPermissionOnModule() {
		global $current_user;
		$holduser = $current_user;
		$user = new Users();
		///  nocreate
		$user->retrieveCurrentUserInfoFromFile(11); // nocreate
		$current_user = $user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		try {
			vtws_query('select * from cbTermConditions', $current_user);
		} catch (\Throwable $th) {
			$current_user = $holduser;
			throw $th;
		}
	}
}
?>