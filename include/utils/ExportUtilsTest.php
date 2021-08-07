<?php
/*************************************************************************************************
 * Copyright 2018 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

include_once 'include/utils/ExportUtils.php';
use PHPUnit\Framework\TestCase;

class ExportUtilsTest extends TestCase {

	/****
	 * TEST Users decimal configuration
	 * name format is: {decimal_separator}{symbol_position}{grouping}{grouping_symbol}{currency}
	 ****/
	private $usradmin = 1;
	private $usrnocreate = 11;
	private $usrdota0x = 5; // testdmy 2 decimal places
	private $usrcomd0x = 6; // testmdy 3 decimal places
	private $usrdotd3com = 7; // testymd 4 decimal places
	private $usrcoma3dot = 10; // testtz 5 decimal places
	private $usrdota3comdollar = 12; // testmcurrency 6 decimal places

	/**
	 * Method getPermittedBlocksProvider
	 * params
	 */
	public function getPermittedBlocksProvider() {
		return array(
			array($this->usradmin, 'Accounts', 'create_view', '(9, 10, 127, 11, 12)'),
			array($this->usradmin, 'Accounts', 'edit_view', '(9, 10, 127, 11, 12)'),
			array($this->usradmin, 'Accounts', 'detail_view', '(9, 10, 127, 11, 12)'),
			array($this->usradmin, 'Assets', 'create_view', '(103, 104, 105)'),
			array($this->usradmin, 'Assets', 'edit_view', '(103, 104, 105)'),
			array($this->usradmin, 'Assets', 'detail_view', '(103, 104, 105)'),
			array($this->usradmin, 'Products', 'create_view', '(31, 32, 33, 34, 35, 36)'),
			array($this->usradmin, 'Products', 'edit_view', '(31, 32, 33, 34, 35, 36)'),
			array($this->usradmin, 'Products', 'detail_view', '(31, 32, 33, 34, 35, 36)'),
			array($this->usradmin, 'HelpDesk', 'create_view', '(25, 26, 27, 28, 29)'),
			array($this->usradmin, 'HelpDesk', 'edit_view', '(25, 26, 27, 28, 29, 30)'),
			array($this->usradmin, 'HelpDesk', 'detail_view', '(25, 26, 27, 28, 29, 30)'),
			/////
			array($this->usrdota0x, 'Accounts', 'create_view', '(9, 10, 127, 11, 12)'),
			array($this->usrdota0x, 'Accounts', 'edit_view', '(9, 10, 127, 11, 12)'),
			array($this->usrdota0x, 'Accounts', 'detail_view', '(9, 10, 127, 11, 12)'),
			array($this->usrdota0x, 'Assets', 'create_view', '(103, 104, 105)'),
			array($this->usrdota0x, 'Assets', 'edit_view', '(103, 104, 105)'),
			array($this->usrdota0x, 'Assets', 'detail_view', '(103, 104, 105)'),
			array($this->usrdota0x, 'Products', 'create_view', '(31, 32, 33, 34, 35, 36)'),
			array($this->usrdota0x, 'Products', 'edit_view', '(31, 32, 33, 34, 35, 36)'),
			array($this->usrdota0x, 'Products', 'detail_view', '(31, 32, 33, 34, 35, 36)'),
			array($this->usrdota0x, 'HelpDesk', 'create_view', '(25, 26, 27, 28, 29)'),
			array($this->usrdota0x, 'HelpDesk', 'edit_view', '(25, 26, 27, 28, 29, 30)'),
			array($this->usrdota0x, 'HelpDesk', 'detail_view', '(25, 26, 27, 28, 29, 30)'),
		);
	}

	/**
	 * Method testgetPermittedBlocks
	 * @test
	 * @dataProvider getPermittedBlocksProvider
	 */
	public function testgetPermittedBlocks($userid, $module, $disp_view, $expected) {
		global $current_user;
		$hold_user = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($userid);
		$current_user = $user;
		$actual = getPermittedBlocks($module, $disp_view);
		$this->assertEquals($expected, $actual, 'testgetPermittedBlocks');
		$current_user = $hold_user;
	}

	/**
	 * Method getPermittedFieldsQueryProvider
	 * params
	 */
	public function getPermittedFieldsQueryProvider() {
		$sqlAccounts = 'SELECT vtiger_field.columnname, vtiger_field.fieldlabel, vtiger_field.tablename
			FROM vtiger_field
			WHERE vtiger_field.tabid=6 AND vtiger_field.block IN (9, 10, 127, 11, 12) AND vtiger_field.displaytype IN (1,2,4) and vtiger_field.presence in (0,2)
			ORDER BY block,sequence';
		$sqlAssets = 'SELECT vtiger_field.columnname, vtiger_field.fieldlabel, vtiger_field.tablename
			FROM vtiger_field
			WHERE vtiger_field.tabid=43 AND vtiger_field.block IN (103, 104, 105) AND vtiger_field.displaytype IN (1,2,4) and vtiger_field.presence in (0,2)
			ORDER BY block,sequence';
		$sqlProducts = 'SELECT vtiger_field.columnname, vtiger_field.fieldlabel, vtiger_field.tablename
			FROM vtiger_field
			WHERE vtiger_field.tabid=14 AND vtiger_field.block IN (31, 32, 33, 34, 35, 36) AND vtiger_field.displaytype IN (1,2,4) and vtiger_field.presence in (0,2)
			ORDER BY block,sequence';
		$sqlHelpDesk1 = 'SELECT vtiger_field.columnname, vtiger_field.fieldlabel, vtiger_field.tablename
			FROM vtiger_field
			WHERE vtiger_field.tabid=13 AND vtiger_field.block IN (25, 26, 27, 28, 29) AND vtiger_field.displaytype IN (1,2,4) and vtiger_field.presence in (0,2)
			ORDER BY block,sequence';
		$sqlHelpDesk2 = 'SELECT vtiger_field.columnname, vtiger_field.fieldlabel, vtiger_field.tablename
			FROM vtiger_field
			WHERE vtiger_field.tabid=13 AND vtiger_field.block IN (25, 26, 27, 28, 29, 30) AND vtiger_field.displaytype IN (1,2,4) and vtiger_field.presence in (0,2)
			ORDER BY block,sequence';
		/////
		$sqlAccountsU = 'SELECT vtiger_field.columnname, vtiger_field.fieldlabel, vtiger_field.tablename
			FROM vtiger_field
			INNER JOIN vtiger_profile2field ON vtiger_profile2field.fieldid=vtiger_field.fieldid
			INNER JOIN vtiger_def_org_field ON vtiger_def_org_field.fieldid=vtiger_field.fieldid
			WHERE vtiger_field.tabid=6 AND vtiger_field.block IN (9, 10, 127, 11, 12) AND vtiger_field.displaytype IN (1,2,4)
				and vtiger_profile2field.visible=0 AND vtiger_def_org_field.visible=0 AND vtiger_profile2field.profileid IN (6)
				and vtiger_field.presence in (0,2) GROUP BY vtiger_field.fieldid
			ORDER BY block,sequence';
		$sqlAssetsU = 'SELECT vtiger_field.columnname, vtiger_field.fieldlabel, vtiger_field.tablename
			FROM vtiger_field
			INNER JOIN vtiger_profile2field ON vtiger_profile2field.fieldid=vtiger_field.fieldid
			INNER JOIN vtiger_def_org_field ON vtiger_def_org_field.fieldid=vtiger_field.fieldid
			WHERE vtiger_field.tabid=43 AND vtiger_field.block IN (103, 104, 105) AND vtiger_field.displaytype IN (1,2,4)
				and vtiger_profile2field.visible=0 AND vtiger_def_org_field.visible=0 AND vtiger_profile2field.profileid IN (6)
				and vtiger_field.presence in (0,2) GROUP BY vtiger_field.fieldid
			ORDER BY block,sequence';
		$sqlProductsU = 'SELECT vtiger_field.columnname, vtiger_field.fieldlabel, vtiger_field.tablename
			FROM vtiger_field
			INNER JOIN vtiger_profile2field ON vtiger_profile2field.fieldid=vtiger_field.fieldid
			INNER JOIN vtiger_def_org_field ON vtiger_def_org_field.fieldid=vtiger_field.fieldid
			WHERE vtiger_field.tabid=14 AND vtiger_field.block IN (31, 32, 33, 34, 35, 36) AND vtiger_field.displaytype IN (1,2,4)
				and vtiger_profile2field.visible=0 AND vtiger_def_org_field.visible=0 AND vtiger_profile2field.profileid IN (6)
				and vtiger_field.presence in (0,2) GROUP BY vtiger_field.fieldid
			ORDER BY block,sequence';
		$sqlHelpDeskU1 = 'SELECT vtiger_field.columnname, vtiger_field.fieldlabel, vtiger_field.tablename
			FROM vtiger_field
			INNER JOIN vtiger_profile2field ON vtiger_profile2field.fieldid=vtiger_field.fieldid
			INNER JOIN vtiger_def_org_field ON vtiger_def_org_field.fieldid=vtiger_field.fieldid
			WHERE vtiger_field.tabid=13 AND vtiger_field.block IN (25, 26, 27, 28, 29) AND vtiger_field.displaytype IN (1,2,4)
				and vtiger_profile2field.visible=0 AND vtiger_def_org_field.visible=0 AND vtiger_profile2field.profileid IN (6)
				and vtiger_field.presence in (0,2) GROUP BY vtiger_field.fieldid
			ORDER BY block,sequence';
		$sqlHelpDeskU2 = 'SELECT vtiger_field.columnname, vtiger_field.fieldlabel, vtiger_field.tablename
			FROM vtiger_field
			INNER JOIN vtiger_profile2field ON vtiger_profile2field.fieldid=vtiger_field.fieldid
			INNER JOIN vtiger_def_org_field ON vtiger_def_org_field.fieldid=vtiger_field.fieldid
			WHERE vtiger_field.tabid=13 AND vtiger_field.block IN (25, 26, 27, 28, 29, 30) AND vtiger_field.displaytype IN (1,2,4)
				and vtiger_profile2field.visible=0 AND vtiger_def_org_field.visible=0 AND vtiger_profile2field.profileid IN (6)
				and vtiger_field.presence in (0,2) GROUP BY vtiger_field.fieldid
			ORDER BY block,sequence';
		return array(
			array($this->usradmin, 'Accounts', 'create_view', $sqlAccounts),
			array($this->usradmin, 'Accounts', 'edit_view', $sqlAccounts),
			array($this->usradmin, 'Accounts', 'detail_view', $sqlAccounts),
			array($this->usradmin, 'Assets', 'create_view', $sqlAssets),
			array($this->usradmin, 'Assets', 'edit_view', $sqlAssets),
			array($this->usradmin, 'Assets', 'detail_view', $sqlAssets),
			array($this->usradmin, 'Products', 'create_view', $sqlProducts),
			array($this->usradmin, 'Products', 'edit_view', $sqlProducts),
			array($this->usradmin, 'Products', 'detail_view', $sqlProducts),
			array($this->usradmin, 'HelpDesk', 'create_view', $sqlHelpDesk1),
			array($this->usradmin, 'HelpDesk', 'edit_view', $sqlHelpDesk2),
			array($this->usradmin, 'HelpDesk', 'detail_view', $sqlHelpDesk2),
			/////
			array($this->usrdota0x, 'Accounts', 'create_view', $sqlAccountsU),
			array($this->usrdota0x, 'Accounts', 'edit_view', $sqlAccountsU),
			array($this->usrdota0x, 'Accounts', 'detail_view', $sqlAccountsU),
			array($this->usrdota0x, 'Assets', 'create_view', $sqlAssetsU),
			array($this->usrdota0x, 'Assets', 'edit_view', $sqlAssetsU),
			array($this->usrdota0x, 'Assets', 'detail_view', $sqlAssetsU),
			array($this->usrdota0x, 'Products', 'create_view', $sqlProductsU),
			array($this->usrdota0x, 'Products', 'edit_view', $sqlProductsU),
			array($this->usrdota0x, 'Products', 'detail_view', $sqlProductsU),
			array($this->usrdota0x, 'HelpDesk', 'create_view', $sqlHelpDeskU1),
			array($this->usrdota0x, 'HelpDesk', 'edit_view', $sqlHelpDeskU2),
			array($this->usrdota0x, 'HelpDesk', 'detail_view', $sqlHelpDeskU2),
		);
	}

	/**
	 * Method testgetPermittedFieldsQuery
	 * @test
	 * @dataProvider getPermittedFieldsQueryProvider
	 */
	public function testgetPermittedFieldsQuery($userid, $module, $disp_view, $expected) {
		global $current_user;
		$hold_user = $current_user;
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile($userid);
		$current_user = $user;
		$actual = getPermittedFieldsQuery($module, $disp_view);
		$this->assertEquals($expected, $actual, 'testgetPermittedFieldsQuery');
		$current_user = $hold_user;
	}
}