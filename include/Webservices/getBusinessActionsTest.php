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

include_once 'include/Webservices/getBusinessActions.php';

class getBusinessActionsTest extends TestCase {

	private function stripLinkID($array) {
		foreach ($array as $types => $tinfo) {
			foreach ($tinfo as $idx => $lobj) {
				$lobj->linkid=0;
			}
		}
		return $array;
	}

	/**
	 * Method getBusinessActionsProvider
	 * params
	 */
	public function getBusinessActionsProvider() {
		global $adb;
		$edocl = $this->stripLinkID(array(
			'LISTVIEWBASIC' => array(BusinessActions::convertToObject(8, array(
				'businessactionsid' => '43094',
				'elementtype_action' => 'LISTVIEWBASIC',
				'linklabel' => 'LNK_DOWNLOAD',
				'linkurl' => 'massDownload();',
				'linkicon' => '',
				'sequence' => '0',
				'status' => false,
				'handler_path' => '',
				'handler_class' => '',
				'handler' => '',
				'onlyonmymodule' => '0',
				'widget_header' => '',
				'widget_width' => '',
				'widget_height' => '',
			))),
			'HEADERSCRIPT' => array(),
			'HEADERCSS' => array(),
		));
		$eastl = array(
			'LISTVIEWBASIC' => array(),
			'HEADERSCRIPT' => array(),
			'HEADERCSS' => array(),
		);
		$eastd = $this->stripLinkID(array(
			'DETAILVIEWBASIC' => array(BusinessActions::convertToObject(43, array(
				'businessactionsid' => '43086',
				'elementtype_action' => 'DETAILVIEWBASIC',
				'linklabel' => 'View History',
				'linkurl' => "javascript:ModTrackerCommon.showhistory('4115')",
				'linkicon' => '',
				'sequence' => '0',
				'status' => false,
				'handler_path' => 'modules/ModTracker/ModTracker.php',
				'handler_class' => 'ModTracker',
				'handler' => 'isViewPermitted',
				'onlyonmymodule' => '0',
				'widget_header' => '',
				'widget_width' => '',
				'widget_height' => '',
			))),
			'HEADERSCRIPT' => array(),
			'HEADERCSS' => array(),
			'DETAILVIEWWIDGET' => array(),
		));
		$ectol = $this->stripLinkID(array(
			'LISTVIEWBASIC' => array(
				BusinessActions::convertToObject(4, array(
					'businessactionsid' => '44122',
					'elementtype_action' => 'LISTVIEWBASIC',
					'linklabel' => 'Send SMS',
					'linkurl' => "SMSNotifierCommon.displaySelectWizard(this, 'Contacts');",
					'linkicon' => '',
					'sequence' => '0',
					'status' => false,
					'handler_path' => '',
					'handler_class' => '',
					'handler' => '',
					'onlyonmymodule' => '0',
					'widget_header' => '0',
					'widget_width' => '',
					'widget_height' => '',
				)),
				BusinessActions::convertToObject(4, array(
					'businessactionsid' => '44124',
					'elementtype_action' => 'LISTVIEWBASIC',
					'linklabel' => 'LBL_SEND_MAIL_BUTTON',
					'linkurl' => "return eMail('Contacts',this);",
					'linkicon' => '',
					'sequence' => '0',
					'status' => false,
					'handler_path' => '',
					'handler_class' => '',
					'handler' => '',
					'onlyonmymodule' => '0',
					'widget_header' => '0',
					'widget_width' => '',
					'widget_height' => '',
				)),
				BusinessActions::convertToObject(4, array(
					'businessactionsid' => '44124',
					'elementtype_action' => 'LISTVIEWBASIC',
					'linklabel' => 'Mass Tag',
					'linkurl' => "javascript:showMassTag();",
					'linkicon' => '',
					'sequence' => '0',
					'status' => false,
					'handler_path' => '',
					'handler_class' => '',
					'handler' => '',
					'onlyonmymodule' => '0',
					'widget_header' => '0',
					'widget_width' => '',
					'widget_height' => '',
				))
			),
			'HEADERSCRIPT' => array(BusinessActions::convertToObject(4, array(
				'businessactionsid' => '44121',
				'elementtype_action' => 'HEADERSCRIPT',
				'linklabel' => 'MailJS',
				'linkurl' => 'include/js/Mail.js',
				'linkicon' => '',
				'sequence' => '0',
				'status' => false,
				'handler_path' => '',
				'handler_class' => '',
				'handler' => '',
				'onlyonmymodule' => '1',
				'widget_header' => '0',
				'widget_width' => '',
				'widget_height' => '',
			))),
			'HEADERCSS' => array(),
		));
		$ectod = $this->stripLinkID(array(
			'DETAILVIEWBASIC' => array(
				BusinessActions::convertToObject(4, array(
					'businessactionsid' => '44114',
					'elementtype_action' => 'DETAILVIEWBASIC',
					'linklabel' => 'LBL_ADD_NOTE',
					'linkurl' => 'index.php?module=Documents&action=EditView&return_module=Contacts&return_action=DetailView&return_id=1494&parent_id=1494&createmode=link',
					'linkicon' => 'themes/images/bookMark.gif',
					'sequence' => '0',
					'status' => false,
					'handler_path' => '',
					'handler_class' => '',
					'handler' => '',
					'onlyonmymodule' => '0',
					'widget_header' => '0',
					'widget_width' => '',
					'widget_height' => '',
				)),
				BusinessActions::convertToObject(4, array(
					'businessactionsid' => '44115',
					'elementtype_action' => 'DETAILVIEWBASIC',
					'linklabel' => 'Send SMS',
					'linkurl' => "javascript:SMSNotifierCommon.displaySelectWizard_DetailView('Contacts', '1494');",
					'linkicon' => '',
					'sequence' => '0',
					'status' => false,
					'handler_path' => '',
					'handler_class' => '',
					'handler' => '',
					'onlyonmymodule' => '0',
					'widget_header' => '0',
					'widget_width' => '',
					'widget_height' => '',
				)),
				BusinessActions::convertToObject(4, array(
					'businessactionsid' => '44116',
					'elementtype_action' => 'DETAILVIEWBASIC',
					'linklabel' => 'LBL_SHOW_CONTACT_HIERARCHY',
					'linkurl' => 'index.php?module=Contacts&action=Hierarchy&recordid=1494',
					'linkicon' => 'themes/images/hierarchy_color16.png',
					'sequence' => '0',
					'status' => false,
					'handler_path' => '',
					'handler_class' => '',
					'handler' => '',
					'onlyonmymodule' => '0',
					'widget_header' => '0',
					'widget_width' => '',
					'widget_height' => '',
				)),
				BusinessActions::convertToObject(4, array(
					'businessactionsid' => '44117',
					'elementtype_action' => 'DETAILVIEWBASIC',
					'linklabel' => 'View History',
					'linkurl' => "javascript:ModTrackerCommon.showhistory('1494')",
					'linkicon' => '',
					'sequence' => '0',
					'status' => false,
					'handler_path' => 'modules/ModTracker/ModTracker.php',
					'handler_class' => 'ModTracker',
					'handler' => 'isViewPermitted',
					'onlyonmymodule' => '0',
					'widget_header' => '0',
					'widget_width' => '',
					'widget_height' => '',
				)),
				BusinessActions::convertToObject(4, array(
					'businessactionsid' => '44118',
					'elementtype_action' => 'DETAILVIEWBASIC',
					'linklabel' => 'LBL_SENDMAIL_BUTTON_LABEL',
					'linkurl' => "javascript:fnvshobj('.actionlink_lbl_sendmail_button_label .webMnu','sendmail_cont');sendmail('Contacts',1494);",
					'linkicon' => 'themes/images/sendmail.png',
					'sequence' => '0',
					'status' => false,
					'handler_path' => '',
					'handler_class' => '',
					'handler' => '',
					'onlyonmymodule' => '0',
					'widget_header' => '0',
					'widget_width' => '',
					'widget_height' => '',
				)),
				BusinessActions::convertToObject(4, array(
					'businessactionsid' => '44119',
					'elementtype_action' => 'DETAILVIEWBASIC',
					'linklabel' => 'Add Event',
					'linkurl' => 'index.php?module=cbCalendar&action=EditView&return_module=Contacts&return_action=DetailView&return_id=1494&cbfromid=1494',
					'linkicon' => 'themes/images/AddEvent.gif',
					'sequence' => '0',
					'status' => false,
					'handler_path' => '',
					'handler_class' => '',
					'handler' => '',
					'onlyonmymodule' => '0',
					'widget_header' => '0',
					'widget_width' => '',
					'widget_height' => '',
				)),
			),
			'HEADERSCRIPT' => array(BusinessActions::convertToObject(4, array(
				'businessactionsid' => '44121',
				'elementtype_action' => 'HEADERSCRIPT',
				'linklabel' => 'MailJS',
				'linkurl' => 'include/js/Mail.js',
				'linkicon' => '',
				'sequence' => '0',
				'status' => false,
				'handler_path' => '',
				'handler_class' => '',
				'handler' => '',
				'onlyonmymodule' => '1',
				'widget_header' => '0',
				'widget_width' => '',
				'widget_height' => '',
			))),
			'HEADERCSS' => array(),
			'DETAILVIEWWIDGET' => array(
				BusinessActions::convertToObject(4, array(
					'businessactionsid' => '44120',
					'elementtype_action' => 'DETAILVIEWWIDGET',
					'linklabel' => 'DetailViewBlockCommentWidget',
					'linkurl' => 'block://ModComments:modules/ModComments/ModComments.php',
					'linkicon' => '',
					'sequence' => '1',
					'status' => false,
					'handler_path' => '',
					'handler_class' => '',
					'handler' => '',
					'onlyonmymodule' => '0',
					'widget_header' => '0',
					'widget_width' => '',
					'widget_height' => '',
				)),
				BusinessActions::convertToObject(4, array(
					'businessactionsid' => '44120',
					'elementtype_action' => 'DETAILVIEWWIDGET',
					'linklabel' => 'PortalUserPasswordManagement',
					'linkurl' => 'module=Contacts&action=ContactsAjax&file=PortalUserPasswordManagement&recordid=1494',
					'linkicon' => '',
					'sequence' => '1',
					'status' => false,
					'handler_path' => '',
					'handler_class' => '',
					'handler' => '',
					'onlyonmymodule' => '0',
					'widget_header' => '0',
					'widget_width' => '',
					'widget_height' => '',
				)),
			),
		));
		$docrs = $adb->query('select notesid from vtiger_notes inner join vtiger_crmentity on crmid=notesid where deleted=0 limit 1');
		$docid = $adb->query_result($docrs, 0, 'notesid');
		$edocd = $this->stripLinkID(array(
			'DETAILVIEWBASIC' => array(),
			'HEADERSCRIPT' => array(),
			'HEADERCSS' => array(),
			'DETAILVIEWWIDGET' => array(BusinessActions::convertToObject(8, array(
				'businessactionsid' => '43151',
				'elementtype_action' => 'DETAILVIEWWIDGET',
				'linklabel' => 'Document actions',
				'linkurl' => 'module=Documents&action=DocumentsAjax&file=documentsWidget&record='.$docid,
				'linkicon' => '',
				'sequence' => '1',
				'status' => false,
				'handler_path' => '',
				'handler_class' => '',
				'handler' => '',
				'onlyonmymodule' => '0',
				'widget_header' => '',
				'widget_width' => '',
				'widget_height' => '',
			))),
		));
		$views = array(
			'ListView' => array(
				'types' => 'LISTVIEWBASIC,HEADERSCRIPT,HEADERCSS',
				'ids' => array(
					'Documents' => 0,
					'Assets' => 0,
					'Contacts' => 0,
				),
				'exp' => array(
					'Documents' => $edocl,
					'Assets' => $eastl,
					'Contacts' => $ectol,
				),
			),
			'DetailView' => array(
				'types' => 'DETAILVIEWBASIC,HEADERSCRIPT,HEADERCSS,DETAILVIEWWIDGET',
				'ids' => array(
					'Documents' => $docid,
					'Assets' => 4115,
					'Contacts' => 1494,
				),
				'exp' => array(
					'Documents' => $edocd,
					'Assets' => $eastd,
					'Contacts' => $ectod,
				),
			),
		);
		$return = array();
		foreach ($views as $view => $vinfo) {
			foreach ($vinfo['ids'] as $module => $recid) {
				if (!($view=='DetailView' && $module=='Documents' && empty($docid))) {
					$return[] = array($view, $module, $recid, $vinfo['types'], $vinfo['exp'][$module]);
				}
			}
		}
		return $return;
	}

	/**
	 * Method testgetBusinessActions
	 * @test
	 * @dataProvider getBusinessActionsProvider
	 */
	public function testgetBusinessActions($view, $module, $id, $linktype, $expected) {
		global $current_user;
		$actual = $this->stripLinkID(getBusinessActions($view, $module, $id, $linktype, $current_user));
		$this->assertEqualsCanonicalizing($expected, $actual, 'getBusinessActions');
	}

	/**
	 * Method testactormodule
	 * @test
	 */
	public function testactormodule() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		getBusinessActions('ListView', 'AuditTrail', 0, 'LISTVIEWBASIC,LISTVIEW', $current_user);
	}

	/**
	 * Method testnonentitymodule
	 * @test
	 */
	public function testnonentitymodule() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		getBusinessActions('ListView', 'evvtMenu', 0, 'LISTVIEWBASIC,LISTVIEW', $current_user);
	}

	/**
	 * Method testemptymodule
	 * @test
	 */
	public function testemptymodule() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		getBusinessActions('ListView', '', 0, 'LISTVIEWBASIC,LISTVIEW', $current_user);
	}

	/**
	 * Method testinexistentmodule
	 * @test
	 */
	public function testinexistentmodule() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		getBusinessActions('ListView', 'DoesNotExist', 0, 'LISTVIEWBASIC,LISTVIEW', $current_user);
	}

	/**
	 * Method testnopermissionmodule
	 * @test
	 */
	public function testnopermissionmodule() {
		$user = new Users();
		$user->retrieveCurrentUserInfoFromFile(11); // nocreate > no access to cbTermConditions
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		getBusinessActions('ListView', 'cbTermConditions', 0, 'LISTVIEWBASIC,LISTVIEW', $user);
	}

	/**
	 * Method testnotpermittedmoduledetail
	 * @test
	 */
	public function testnotpermittedmoduledetail() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$ACCESSDENIED);
		getBusinessActions('DetailView', 'Users', 1, 'DETAILVIEWBASIC,DETAILVIEW', $current_user);
	}

	/**
	 * Method testnotpermittedmodulelist
	 * @test
	 */
	public function testnotpermittedmodulelist() {
		global $current_user;
		$actual = getBusinessActions('ListView', 'Users', 1, 'LISTVIEWBASIC,LISTVIEW', $current_user);
		$expected = array(
			'LISTVIEWBASIC' => array(),
			'LISTVIEW' => array(),
		);
		$this->assertEquals($expected, $actual, 'getBusinessActions');
	}
}
?>