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

include_once 'modules/GlobalVariable/SearchGlobalVarws.php';
include_once 'include/Webservices/Create.php';
include_once 'include/Webservices/Delete.php';

class SearchGlobalVarwsTest extends TestCase {

	/**
	 * Method testSearchGlobalVar
	 * @test
	 */
	public function testSearchGlobalVar() {
		global $current_user;
		$this->assertEquals('Home', cbws_SearchGlobalVar('Application_Default_Module', 'not found', '', $current_user));
		$this->assertEquals('not found', cbws_SearchGlobalVar('does not exist', 'not found', '', $current_user));
		$this->assertEquals('Home', cbws_SearchGlobalVar('Application_Default_Module', 'not found', 'Accounts', $current_user));
		$this->assertEquals('not found', cbws_SearchGlobalVar('does not exist', 'not found', 'HelpDesk', $current_user));
		$expected = array(
			'id' => '37x43951',
			'map' => '{"originmodule":{"originname":"MsgTemplate"},"dependencies":{"dependency":[{"field":"msgt_module","actions":{"function":{"field":"msgt_module","name":"msgtFillInModuleFields"}}},{"field":"msgt_fields","actions":{"function":{"field":"msgt_fields","name":"msgtInsertIntoMsg"}}}]}}',
		);
		$this->assertEquals($expected, cbws_SearchGlobalVar('BusinessMapping_MsgTemplate_FieldDependency', '', 'MsgTemplate', $current_user));
		$expected = array(
			'id' => '37x43950',
			'map' => '{"originmodule":{"originname":"MsgTemplate"},"fields":{"field":{"fieldname":"template","features":{"feature":{"name":"RTE","value":"1"}}}}}',
		);
		$this->assertEquals($expected, cbws_SearchGlobalVar('BusinessMapping_MsgTemplate_FieldInfo', '', 'MsgTemplate', $current_user));
		$rec = array(
			'default_check' => '0',
			'mandatory' => '0',
			'blocked' => '0',
			'module_list' => '',
			'category' => 'Application',
			'in_module_list' => '',
			'assigned_user_id' => vtws_getEntityId('Users').'x'.$current_user->id,
			'gvname' => 'BusinessMapping_MsgTemplate_FieldInfo',
			'bmapid' => 44012,
			'value' => '',
		);
		$gv = vtws_create('GlobalVariable', $rec, $current_user);
		$expected = array(
			'id' => '37x44012',
			'map' => '{"function":{"name":"getTagCloudView","parameters":{"parameter":"currentuserID"}}}',
		);
		$this->assertEquals($expected, cbws_SearchGlobalVar('BusinessMapping_MsgTemplate_FieldInfo', '', 'MsgTemplate', $current_user));
		vtws_delete($gv['id'], $current_user);
	}
}
