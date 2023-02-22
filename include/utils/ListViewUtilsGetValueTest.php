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

class ListViewUtilsGetValueTest extends TestCase {

	/**
	 * Method getValueExpectedForAccounts
	 * return getValue expected result for Accounts module
	 */
	private function getValueExpectedForAccounts($fieldname, $fieldvalue, $focus, $mode, $popuptype, $id) {
		if ($fieldname == $focus->list_link_field) {
			if ($mode=='search') {
				switch ($popuptype) {
					case 'specific':
						$ret = '<a href="javascript:window.close();" onclick=\'set_return_specific("92", "Rose & Co Management Cnslnts");\'id = 5>Rose & Co Management Cnslnts</a>';
						break;
					case 'detailview':
						$ret = '<a style="cursor:pointer;" onclick=\'add_data_to_relatedlist("92","0","Accounts","");\'>Rose & Co Management Cnslnts</a>';
						break;
					case 'inventory_prod_po':
						$ret = '<a href="javascript:window.close();" id=\'popup_product_92\' onclick=\'set_return_inventory_po("92", "Rose &amp; Co Management Cnslnts", "", "tax1=4.500,tax2=10.000,tax3=12.500","1","","::"); \' vt_prod_arr=\'{"entityid":"92","prodname":"Rose &amp; Co Management Cnslnts","unitprice":"","qtyinstk":"0","taxstring":"tax1=4.500,tax2=10.000,tax3=12.500","rowid":"1","desc":"","subprod_ids":"::"}\' >Rose & Co Management Cnslnts</a>';
						break;
					case 'specific_account_address':
						$ret = '<a href="javascript:void(0);" onclick=\'set_return_shipbilladdress("92", "Rose & Co Management Cnslnts", "41 Augusta Hwy", "41 Augusta Hwy", "Richmond", "Richmond", "BC", "BC", "V6X 3S2", "V6X 3S2", "Canada", "Canada","", "");\'id='.$id.'>Rose & Co Management Cnslnts</a>';
						break;
					case 'specific_contact_account_address':
						$ret = '<a href="javascript:window.close();" onclick=\'set_return_contact_address("92", "Rose & Co Management Cnslnts", "41 Augusta Hwy", "41 Augusta Hwy", "Richmond", "Richmond", "BC", "BC", "V6X 3S2", "V6X 3S2", "Canada", "Canada","", "");\'id='.$id.'>Rose & Co Management Cnslnts</a>';
						break;
					case 'specific_potential_account_address':
						$ret = 'Rose & Co Management Cnslnts';
						break;
					case 'set_return_emails':
						$ret = '<a href="javascript:if (document.getElementById(\'closewindow\').value==\'true\') {window.close();}" onclick=\'return set_return_emails(92,9,"Rose &amp; Co Management Cnslnts","amber.windell@cox.net","","1", "default"); \'id = '.$id.'>Rose & Co Management Cnslnts</a>';
						break;
					case 'specific_campaign':
						$ret = '<a href="javascript:window.close();" onclick=\'set_return_specific_campaign("92", "Rose & Co Management Cnslnts");\'id = '.$id.'>Rose & Co Management Cnslnts</a>';
						break;
					default:
						$ret = '<a href="javascript:if (document.getElementById(\'closewindow\').value==\'true\') {window.close();}" onclick=\'set_return("92", "Rose & Co Management Cnslnts");\' id=\''.$id.'\' >Rose & Co Management Cnslnts</a>';
				}
			} else {
				$ret = '<a href="index.php?action=DetailView&module=Accounts&record=92" id='.$id.'>Rose & Co Management Cnslnts</a>';
			}
		} else {
			switch ($fieldname) {
				case 'account_id':
					$ret = "<a href='index.php?module=Accounts&action=DetailView&record=74' title='Organizations'>Chemex Labs Ltd</a>";
					break;
				case 'cf_726':
				case 'emailoptout':
					$ret = $fieldvalue==1 ? 'yes' : 'no';
					break;
				case 'website':
					$ret = '<a href="http://www.rosecomanagementcnslnts.com" target="_blank">http://www.rosecomanagementcnslnts.com</a>';
					break;
				case 'assigned_user_id':
					$ret = 'nocreate cbTest';
					break;
				case 'annual_revenue':
					$ret = '<span style="float:right;padding-right:10px;display:block;">4,210,827.00</span>';
					break;
				case 'ownership':
				case 'cf_718':
					$ret = gtltTagsToHTML($fieldvalue);
					break;
				case 'employees':
					$ret = '<span style="float:right;padding-right:10px;display:block;">147</span>';
					break;
				default:
					$ret = $fieldvalue;
			}
		}
		return $ret;
	}

	/**
	 * Method getValueAccountProvider
	 * params
	 */
	public function getValueAccountProvider() {
		global $adb, $current_user;
		$_REQUEST['return_module'] = 'Contacts';
		$_REQUEST['form'] = 'hardcoded';
		$_REQUEST['curr_row'] = '1';
		$module = 'Accounts';
		$entity_id = '92';
		$focus = CRMEntity::getInstance($module);
		$focus->retrieve_entity_info($entity_id, $module);
		$focus->column_fields['parentid'] = 74;
		$focus->column_fields['tickersymbol'] = 'áçèñtös';
		$focus->column_fields['ownership'] = 'probability>50';
		$adb->pquery(
			'update vtiger_account set parentid=?,tickersymbol=?,ownership=? where accountid=?',
			array(74, 'áçèñtös', 'probability>50', $entity_id)
		);
		$focus->column_fields['cf_718'] = 'probability<50';
		$focus->column_fields['cf_726'] = 1;
		$focus->column_fields['cf_722'] = '2020-01-11';
		$adb->pquery(
			'update vtiger_accountscf set cf_718=?,cf_726=?,cf_722=? where accountid=?',
			array('probability<50', 1, '2020-01-11', $entity_id)
		);
		$fields = array(
			'accountname' => array(
				'2' => 'accountname',
				'typeofdata' => 'V~M',
			),
			'account_id' => array(
				'10' => 'parentid',
				'typeofdata' => 'V~O',
			),
			'tickersymbol' => array(
				'1' => 'tickersymbol',
				'typeofdata' => 'V~O',
			),
			'ownership' => array(
				'1' => 'ownership',
				'typeofdata' => 'V~O',
			),
			'cf_718' => array(
				'1' => 'cf_718',
				'typeofdata' => 'V~O',
			),
			'cf_726' => array(
				'56' => 'cf_726',
				'typeofdata' => 'C~O',
			),
			'emailoptout' => array(
				'56' => 'emailoptout',
				'typeofdata' => 'C~O',
			),
			'email1' => array(
				'13' => 'email1',
				'typeofdata' => 'V~O',
			),
			'website' => array(
				'17' => 'website',
				'typeofdata' => 'V~O',
			),
			'assigned_user_id' => array(
				'53' => 'smownerid',
				'typeofdata' => 'V~O',
			),
			'rating' => array(
				'15' => 'rating',
				'typeofdata' => 'V~O',
			),
			'createdtime' => array(
				'70' => 'createdtime',
				'typeofdata' => 'DT~O',
			),
			'annual_revenue' => array(
				'71' => 'annualrevenue',
				'typeofdata' => 'N~O',
			),
			'cf_722' => array(
				'5' => 'cf_722',
				'typeofdata' => 'D~O',
			),
			'employees' => array(
				'7' => 'employees',
				'typeofdata' => 'I~O',
			)
		);
		$popuptypes = array(
			'', 'specific', 'detailview', 'inventory_prod_po', 'specific_account_address', 'specific_contact_account_address',
			'specific_potential_account_address', 'set_return_emails', 'specific_campaign',
		);

		$modes = array('', 'search', 'list');
		$list_result_count = 0;
		$queryGenerator = new QueryGenerator($module, $current_user);
		$queryGenerator->setFields(array_keys($fields));
		$queryGenerator->addCondition('id', $entity_id, 'e');
		$query = $queryGenerator->getQuery();
		$list_result = $adb->query($query);
		$return = array();
		$id=1;
		counterValue(true);
		foreach ($fields as $fieldname => $field_result) {
			foreach ($popuptypes as $popuptype) {
				foreach ($modes as $mode) {
					$return[] = array(
						$fields,
						$list_result,
						$fieldname,
						$focus,
						$module,
						$entity_id,
						$list_result_count,
						$mode,
						$popuptype,
						$this->getValueExpectedForAccounts($fieldname, $focus->column_fields[$fieldname], $focus, $mode, $popuptype, $id),
					);
					if (!($mode=='search' && ($popuptype=='inventory_prod_po' || $popuptype=='specific_potential_account_address'))) {
						$id++;
					}
				}
			}
		}
		return $return;
	}

	/**
	 * Method testgetValueAccount
	 * @test
	 * @dataProvider getValueAccountProvider
	 */
	public function testgetValueAccount($field_result, $list_result, $fieldname, $focus, $module, $entity_id, $list_result_count, $mode, $popuptype, $expected) {
		$msg = "getValue of $fieldname for $module $entity_id $mode $popuptype";
		if ($msg=='getValue of accountname for Accounts 92  ') {
			counterValue(true);
		}
		$focus->popup_type=$popuptype;
		unset($_SESSION['internal_mailer']);
		$_REQUEST['action'] = 'x';
		unset($_REQUEST['recordid']);
		$actual = getValue($field_result, $list_result, $fieldname, $focus, $module, $entity_id, $list_result_count, $mode, $popuptype);
		if ($fieldname=='email1') {
			$this->assertEquals('<a href="mailto:'.$expected.'">'.$expected.'</a>', $actual, $msg);
			$_SESSION['internal_mailer'] = 1;
			$actual = getValue($field_result, $list_result, $fieldname, $focus, $module, $entity_id, $list_result_count, $mode, $popuptype);
			if (empty($popuptype)) {
				$this->assertEquals('<a href="javascript:InternalMailer(92,9,\'email1\',\'Accounts\',\'record_id\');">'.$expected.'</a>', $actual, $msg);
			} else {
				$this->assertEquals($expected, $actual, $msg);
			}
		} else {
			$this->assertEquals($expected, $actual, $msg);
		}
	}

	/**
	 * Method getValueExpectedForProducts
	 * return getValue expected result for Products module
	 */
	private function getValueExpectedForProducts($mode, $popuptype, $id) {
		if ($mode=='search') {
			switch ($popuptype) {
				case 'inventory_prod':
					$ret = '<a href="javascript:window.close();" id=\'popup_product_2616\' onclick=\'set_return_inventory("2616", "K101high \"Pressure\" Japanese Stainless Steel", "48.61", "","tax1=4.500,tax2=10.000,tax3=12.500","1","","::",0);\' vt_prod_arr=\'{"entityid":"2616","prodname":"K101high \"Pressure\" Japanese Stainless Steel","unitprice":48.61,"qtyinstk":"","taxstring":"tax1=4.500,tax2=10.000,tax3=12.500","rowid":"1","desc":"","subprod_ids":"::","dto":0}\' >K101high "Pressure" Japanese Stainless S...</a>';
					break;
				case 'inventory_service':
					$ret = '<a href="javascript:window.close();" id=\'popup_product_2616\' onclick=\'set_return_inventory("2616", "K101high \"Pressure\" Japanese Stainless Steel", "48.61", "tax1=4.500,tax2=10.000,tax3=12.500","1","",0);\' vt_prod_arr=\'{"entityid":"2616","prodname":"K101high \"Pressure\" Japanese Stainless Steel","unitprice":48.61,"taxstring":"tax1=4.500,tax2=10.000,tax3=12.500","rowid":"1","desc":"","dto":0}\' >K101high "Pressure" Japanese Stainless S...</a>';
					break;
				case 'inventory_pb':
					$ret = '<a href="javascript:window.close();" onclick=\'set_return_inventory_pb("0", "productname"); \'id = 6>K101high \"Pressure\" Japanese Stainless...</a>';
					break;
				default:
					$ret = '<a href="index.php?action=DetailView&module=Products&record=2616" id='.$id.'>K101high "Pressure" Japanese Stainless S...</a>';
			}
		} else {
			$ret = '<a href="index.php?action=DetailView&module=Products&record=2616" id='.$id.'>K101high "Pressure" Japanese Stainless S...</a>';
		}
		return $ret;
	}

	/**
	 * Method getValueProductProvider
	 * params
	 */
	public function getValueProductProvider() {
		global $adb, $current_user;
		$_REQUEST['return_module'] = 'Potentials';
		$_REQUEST['form'] = 'hardcoded';
		$_REQUEST['curr_row'] = '1';
		$module = 'Products';
		$entity_id = '2616';
		$_REQUEST['productid'] = $entity_id;
		$_REQUEST['fldname'] = 'productname';
		$focus = CRMEntity::getInstance($module);
		$focus->retrieve_entity_info($entity_id, $module);
		$focus->column_fields['productname'] = 'K101high "Pressure" Japanese Stainless Steel';
		$adb->pquery(
			'update vtiger_products set productname=? where productid=?',
			array('K101high "Pressure" Japanese Stainless Steel', $entity_id)
		);
		$fields = array(
			'productname' => array(
				'1' => 'productname',
				'typeofdata' => 'V~M',
			),
		);
		$popuptypes = array('inventory_prod', 'inventory_service', 'inventory_pb',);
		$_REQUEST['currencyid'] = '1';

		$modes = array('', 'search', 'list');
		$list_result_count = 0;
		$queryGenerator = new QueryGenerator($module, $current_user);
		$queryGenerator->setFields(array_keys($fields));
		$queryGenerator->addCondition('id', $entity_id, 'e');
		$query = $queryGenerator->getQuery();
		$list_result = $adb->query($query);
		$return = array();
		$id=1;
		counterValue(true);
		foreach ($fields as $fieldname => $field_result) {
			foreach ($popuptypes as $popuptype) {
				foreach ($modes as $mode) {
					$return[] = array(
						$fields,
						$list_result,
						$fieldname,
						$focus,
						$module,
						$entity_id,
						$list_result_count,
						$mode,
						$popuptype,
						$this->getValueExpectedForProducts($mode, $popuptype, $id),
					);
					if (!($mode=='search' && ($popuptype=='inventory_prod' || $popuptype=='inventory_service'))) {
						$id++;
					}
				}
			}
		}
		return $return;
	}

	/**
	 * Method testgetValueProduct
	 * @test
	 * @dataProvider getValueProductProvider
	 */
	public function testgetValueProduct($field_result, $list_result, $fieldname, $focus, $module, $entity_id, $list_result_count, $mode, $popuptype, $expected) {
		$msg = "getValue of $fieldname for $module $entity_id $mode $popuptype";
		if ($msg == 'getValue of productname for Products 2616  inventory_prod') {
			counterValue(true);
		}
		$focus->popup_type=$popuptype;
		$actual = getValue($field_result, $list_result, $fieldname, $focus, $module, $entity_id, $list_result_count, $mode, $popuptype);
		$this->assertEquals($expected, $actual, $msg);
	}

	/**
	 * Method getValueExpectedForContacts
	 * return getValue expected result for Contacts module
	 */
	private function getValueExpectedForContacts($mode, $popuptype, $id) {
		if ($mode=='search') {
			switch ($popuptype) {
				case 'specific':
					$ret = '<a href="javascript:void(0);" onclick=\'set_return_address("1087", "Lino Sut\\\'ulovich", "55 Margaret Rd", "55 Margaret Rd", "Heaton Ward", "Heaton Ward", "Yorkshire, West", "Yorkshire, West", "BD9 4DA", "BD9 4DA", "United Kingdom", "United Kingdom","", "","hardcoded");\'id = 5>Lino Sut\'ulovich</a>';
					break;
				case 'detailview':
					$ret = '<a style="cursor:pointer;" onclick=\'add_data_to_relatedlist("1087","0","Contacts","");\'>Lino Sut\'ulovich</a>';
					break;
				case 'inventory_prod_po':
					$ret = '<a href="javascript:window.close();" id=\'popup_product_1087\' onclick=\'set_return_inventory_po("1087", "Sut\\\'ulovich", "", "tax1=4.500,tax2=10.000,tax3=12.500","1","","::"); \' vt_prod_arr=\'{"entityid":"1087","prodname":"Sut\'ulovich","unitprice":"","qtyinstk":"0","taxstring":"tax1=4.500,tax2=10.000,tax3=12.500","rowid":"1","desc":"","subprod_ids":"::"}\' >Sut\'ulovich</a>';
					break;
				case 'specific_potential_account_address':
					$ret = 'Sut\'ulovich';
					break;
				case 'set_return_emails':
					$ret = '<a href="javascript:if (document.getElementById(\'closewindow\').value==\'true\') {window.close()};" onclick=\'return set_return_emails(1087,80,"Lino Sut\\\'ulovich","","","2", "default"); \'id = '.$id.'>Lino Sut\'ulovich</a>';
					break;
				case 'specific_campaign':
					$ret = '<a href="javascript:window.close();" onclick=\'set_return_specific_campaign("1087", "Sut\\\'ulovich");\'id = '.$id.'>Sut\'ulovich</a>';
					break;
				default:
					$ret = '<a href="javascript:if (document.getElementById(\'closewindow\').value==\'true\') {window.close();}" onclick=\'set_return("1087", "Lino Sut\\\'ulovich");\' id=\''.$id.'\' >Lino Sut\'ulovich</a>';
			}
		} else {
			$ret = '<a href="index.php?action=DetailView&module=Contacts&record=1087" id='.$id.'>Sut\'ulovich</a>';
		}
		return $ret;
	}

	/**
	 * Method getValueContactProvider
	 * params
	 */
	public function getValueContactProvider() {
		global $adb, $current_user;
		$_REQUEST['return_module'] = 'Potentials';
		$_REQUEST['form'] = 'hardcoded';
		$_REQUEST['curr_row'] = '1';
		$module = 'Contacts';
		$entity_id = '1087';
		$focus = CRMEntity::getInstance($module);
		$focus->retrieve_entity_info($entity_id, $module);
		$focus->column_fields['lastname'] = "Sut'ulovich";
		$adb->pquery(
			'update vtiger_contactdetails set lastname=? where contactid=?',
			array("Sut'ulovich", $entity_id)
		);
		$fields = array(
			'lastname' => array(
				'1' => 'lastname',
				'typeofdata' => 'V~M',
			),
		);
		$popuptypes = array(
			'', 'specific', 'detailview', 'inventory_prod_po', 'specific_potential_account_address',
			'set_return_emails', 'specific_campaign',
		);

		$modes = array('', 'search', 'list');
		$list_result_count = 0;
		$queryGenerator = new QueryGenerator($module, $current_user);
		$queryGenerator->setFields(array('firstname','lastname'));
		$queryGenerator->addCondition('id', $entity_id, 'e');
		$query = $queryGenerator->getQuery();
		$list_result = $adb->query($query);
		$return = array();
		$id=1;
		counterValue(true);
		foreach ($fields as $fieldname => $field_result) {
			foreach ($popuptypes as $popuptype) {
				foreach ($modes as $mode) {
					$return[] = array(
						$fields,
						$list_result,
						$fieldname,
						$focus,
						$module,
						$entity_id,
						$list_result_count,
						$mode,
						$popuptype,
						$this->getValueExpectedForContacts($mode, $popuptype, $id),
					);
					if (!($mode=='search' && ($popuptype=='inventory_prod_po' || $popuptype=='specific_potential_account_address'))) {
						$id++;
					}
				}
			}
		}
		return $return;
	}

	/**
	 * Method testgetValueContact
	 * @test
	 * @dataProvider getValueContactProvider
	 */
	public function testgetValueContact($field_result, $list_result, $fieldname, $focus, $module, $entity_id, $list_result_count, $mode, $popuptype, $expected) {
		$msg = "getValue of $fieldname for $module $entity_id $mode $popuptype";
		if ($msg=='getValue of lastname for Contacts 1087  ') {
			counterValue(true);
		}
		$focus->popup_type=$popuptype;
		$actual = getValue($field_result, $list_result, $fieldname, $focus, $module, $entity_id, $list_result_count, $mode, $popuptype);
		$this->assertEquals($expected, $actual, $msg);
	}

	/**
	 * Method getValueExpectedForEmails
	 * return getValue expected result for Emails module
	 */
	private function getValueExpectedForEmails($fieldname) {
		if ($fieldname=='bccmail') {
			$ret = 'Maecenas.mi.felis@arcuNuncmauris.net';
		} else {
			$ret = 'lina@yahoo.com,lina@yahoo.com';
		}
		return $ret;
	}

	/**
	 * Method getValueEmailProvider
	 * params
	 */
	public function getValueEmailProvider() {
		global $adb, $current_user;
		$_REQUEST['return_module'] = 'Potentials';
		$_REQUEST['form'] = 'hardcoded';
		$_REQUEST['curr_row'] = '1';
		$module = 'Emails';
		$entity_id = '26784';
		$focus = CRMEntity::getInstance($module);
		$focus->retrieve_entity_info($entity_id, $module);
		$fields = array(
			'saved_toid' => array(
				'8' => 'to_email',
				'typeofdata' => 'V~O',
			),
			'bccmail' => array(
				'8' => 'bcc_email',
				'typeofdata' => 'V~O',
			),
		);
		$popuptypes = array(
			'', 'specific', 'detailview', 'inventory_prod_po', 'specific_account_address', 'specific_contact_account_address',
			'specific_potential_account_address', 'set_return_emails', 'specific_campaign',
		);

		$modes = array('', 'search', 'list');
		$list_result_count = 0;
		$queryGenerator = new QueryGenerator($module, $current_user);
		$queryGenerator->setFields(array_keys($fields));
		$queryGenerator->addCondition('id', $entity_id, 'e');
		$query = $queryGenerator->getQuery();
		$list_result = $adb->query($query);
		$return = array();
		counterValue(true);
		foreach ($fields as $fieldname => $field_result) {
			foreach ($popuptypes as $popuptype) {
				foreach ($modes as $mode) {
					$return[] = array(
						$fields,
						$list_result,
						$fieldname,
						$focus,
						$module,
						$entity_id,
						$list_result_count,
						$mode,
						$popuptype,
						$this->getValueExpectedForEmails($fieldname),
					);
				}
			}
		}
		return $return;
	}

	/**
	 * Method testgetValueEmail
	 * @test
	 * @dataProvider getValueEmailProvider
	 */
	public function testgetValueEmail($field_result, $list_result, $fieldname, $focus, $module, $entity_id, $list_result_count, $mode, $popuptype, $expected) {
		$msg = "getValue of $fieldname for $module $entity_id $mode $popuptype";
		if ($msg=='getValue of lastname for Emails 1087  ') {
			counterValue(true);
		}
		$focus->popup_type=$popuptype;
		$actual = getValue($field_result, $list_result, $fieldname, $focus, $module, $entity_id, $list_result_count, $mode, $popuptype);
		$this->assertEquals($expected, $actual, $msg);
	}
}