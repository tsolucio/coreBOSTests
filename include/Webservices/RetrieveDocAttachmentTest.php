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

include_once 'include/Webservices/RetrieveDocAttachment.php';

class RetrieveDocAttachmentTest extends TestCase {

	/**
	 * Method testretrievedoc
	 * @test
	 */
	public function testretrievedoc() {
		global $current_user, $adb, $log;
		$current_user = Users::getActiveAdminUser();
		$Module = 'Documents';
		$cbUserID = '19x'.$current_user->id;
		$ObjectValues = array(
			'assigned_user_id' => $cbUserID,
			'created_user_id' => $cbUserID,
			'notes_title' => 'REST Test create doc',
			'filename'=>'some external place',
			'filetype'=>'',
			'filesize'=> '0',
			'fileversion'=>'4',
			'filelocationtype'=>'E',
			'filedownloadcount'=> '',
			'filestatus'=> '1',
			'folderid' => '',
			'notecontent' => 'áçèñtös',
			'modifiedby' => $cbUserID,
			'template' => '0',
			'template_for' => '',
			'mergetemplate' => '0',
		);
		$_FILES=array();
		$actual = vtws_create($Module, $ObjectValues, $current_user);
		$ObjectValues['note_no'] = $actual['note_no'];
		$ObjectValues['id'] = $actual['id'];
		$ObjectValues['createdtime'] = $actual['createdtime'];
		$ObjectValues['modifiedtime'] = $actual['modifiedtime'];
		$ObjectValues['cbuuid'] = CRMEntity::getUUIDfromWSID($actual['id']);
		$ObjectValues['filename'] = 'https://some external place';
		$this->assertEquals($ObjectValues, $actual, 'Create Document E');
		$sdoc = vtws_retrievedocattachment($actual['id'], true, $current_user);
		list($wsid, $crmid) = explode('x', $actual['id']);
		$expected = array(
			$actual['id'] => array(
				'recordid' => $crmid,
				'filetype' => '',
				'filename' => 'https://some external place',
				'filesize' => 0,
				'attachment' => '',
			),
		);
		$this->assertEquals($expected, $sdoc);
		///////
		$webserviceObject = VtigerWebserviceObject::fromName($adb, $Module);
		$vtModuleOperation = new VtigerModuleOperation($webserviceObject, $current_user, $adb, $log);
		$actual = $vtModuleOperation->wsVTQL2SQL("select notes_title,filename,filelocationtype from Documents;", $meta, $queryRelatedModules);
		$this->assertEquals("SELECT vtiger_notes.title,vtiger_notes.filename,vtiger_notes.filelocationtype,vtiger_notes.notesid FROM vtiger_notes LEFT JOIN vtiger_crmentity ON vtiger_notes.notesid=vtiger_crmentity.crmid   WHERE  vtiger_crmentity.deleted=0 LIMIT 100;", $actual);
	}
}
?>