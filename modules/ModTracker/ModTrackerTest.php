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
require_once 'modules/ModTracker/ModTracker.php';
use PHPUnit\Framework\TestCase;

class ModTrackerTest extends TestCase {

	/**
	 * Method testConstruct
	 * @test
	 */
	public function testConstruct() {
		$mt = new ModTracker();
		$this->assertInstanceOf(ModTracker::class, $mt, 'testConstruct');
	}

	/**
	 * Method getChangedRecordsProvider
	 * params
	 */
	public function getChangedRecordsProvider() {
		$estart3 = array(
			'created' => array(
				0 => array(
					'uniqueid' => '3',
					'modifiedtime' => '2016-03-15 14:41:52',
					'module' => 'Contacts',
					'crmid' => '1084',
					'assigneduserid' => '11',
				),
				1 => array(
					'uniqueid' => '5',
					'modifiedtime' => '2016-04-02 18:14:42',
					'module' => 'Contacts',
					'crmid' => '1090',
					'assigneduserid' => '5',
				),
				2 => array(
					'uniqueid' => '7',
					'modifiedtime' => '2016-04-02 18:14:43',
					'module' => 'Contacts',
					'crmid' => '1088',
					'assigneduserid' => '6',
				),
			),
			'updated' => array(
			),
			'deleted' => array(),
			'more' => true,
			'uniqueid' => '7',
		);
		$estart2 = array(
			'created' => array(
				0 => array(
					'uniqueid' => '3',
					'modifiedtime' => '2016-03-15 14:41:52',
					'module' => 'Contacts',
					'crmid' => '1084',
					'assigneduserid' => '11',
				),
				1 => array(
					'uniqueid' => '5',
					'modifiedtime' => '2016-04-02 18:14:42',
					'module' => 'Contacts',
					'crmid' => '1090',
					'assigneduserid' => '5',
				),
			),
			'updated' => array(
			),
			'deleted' => array(),
			'more' => true,
			'uniqueid' => '5',
		);
		$e2017 = array(
			'created' => array(
				0 => array(
					'uniqueid' => '18',
					'modifiedtime' => '2017-07-06 23:35:21',
					'module' => 'Accounts',
					'crmid' => '113',
					'assigneduserid' => '1',
				),
				1 => array(
					'uniqueid' => '19',
					'modifiedtime' => '2017-07-06 23:35:22',
					'module' => 'Accounts',
					'crmid' => '111',
					'assigneduserid' => '1',
				),
				2 => array(
					'uniqueid' => '20',
					'modifiedtime' => '2017-07-06 23:35:23',
					'module' => 'Accounts',
					'crmid' => '108',
					'assigneduserid' => '1',
				),
			),
			'updated' => array(
			),
			'deleted' => array(),
			'more' => true,
			'uniqueid' => '20',
		);
		$e2017offset = array(
			'created' => array(
				0 => array(
					'uniqueid' => '26',
					'modifiedtime' => '2017-07-06 23:36:01',
					'module' => 'Contacts',
					'crmid' => '1203',
					'assigneduserid' => '1',
				),
				1 => array(
					'uniqueid' => '27',
					'modifiedtime' => '2017-07-06 23:36:02',
					'module' => 'Contacts',
					'crmid' => '1191',
					'assigneduserid' => '1',
				),
				2 => array(
					'uniqueid' => '28',
					'modifiedtime' => '2017-07-06 23:36:03',
					'module' => 'Contacts',
					'crmid' => '1188',
					'assigneduserid' => '1',
				),
			),
			'updated' => array(
			),
			'deleted' => array(),
			'more' => true,
			'uniqueid' => '28',
		);
		$empty = array(
			'created' => array(),
			'updated' => array(),
			'deleted' => array(),
			'more' => false,
			'uniqueid' => '1',
		);
		return array(
			array(1, 0, 3, $estart3),
			array(1, 0, 2, $estart2),
			array(1, 1490479359, 3, $e2017),
			array(25, 1490479359, 3, $e2017offset),
			array(1, 1985173759, 3, $empty),
		);
	}

	/**
	 * Method testgetChangedRecords
	 * @test
	 * @dataProvider getChangedRecordsProvider
	 */
	public function testgetChangedRecords($uniqueId, $mtime, $limit, $expected) {
		$mt = new ModTracker('');
		$actual = $mt->getChangedRecords($uniqueId, $mtime, $limit);
		unset($actual['lastModifiedTime']);
		$this->assertEquals($expected, $actual, 'ChangedRecords '.$uniqueId.', '.$mtime.', '.$limit);
	}

	/**
	 * Method getRecordFieldChangesProvider
	 * params
	 */
	public function getRecordFieldChangesProvider() {
		$esrv = array(
			'2020-06-14 01:33:48.000000' => array(
			'website' => array(
				'postvalue' => 'Website',
				'prevalue' => '',
			),
			'cost_price' => array(
				'postvalue' => '0.000000',
				'prevalue' => '',
			),
		));
		$epdo = array(
			'2019-03-04 07:30:47.000000' => array(
			'mfr_part_no' => array(
				'postvalue' => 'Mfr Part No',
				'prevalue' => '',
			),
			'cost_price' => array(
				'postvalue' => '0.000000',
				'prevalue' => '',
			),
			'productsheet' => array(
				'postvalue' => 'Product Sheet',
				'prevalue' => '',
			),
			'description' => array(
				'postvalue' => 'Eam tum adesse, cum dolor omnis absit; Non igitur bene. Quid ergo attinet gloriose loqui, nisi constanter loquare? Quid dubitas igitur mutare principia naturae? Atqui eorum nihil est eius generis, ut sit in fine atque extrerno bonorum. Immo vero, inquit, ad beatissime vivendum parum est, ad beate vero satis.',
				'prevalue' => ' Eam tum adesse, cum dolor omnis absit; Non igitur bene. Quid ergo attinet gloriose loqui, nisi constanter loquare? Quid dubitas igitur mutare principia naturae? Atqui eorum nihil est eius generis, ut sit in fine atque extrerno bonorum. Immo vero, inquit, ad beatissime vivendum parum est, ad beate vero satis. 

',
			)),
			'2020-03-19 15:15:03.000000' => array(
				'mfr_part_no' => array(
					'postvalue' => 'testme',
					'prevalue' => 'Mfr Part No',
				),
			)
		);
		$epdooffset = array(
			'2020-03-19 15:15:03.000000' => array(
				'mfr_part_no' => array(
					'postvalue' => 'testme',
					'prevalue' => 'Mfr Part No',
				),
			)
		);
		return array(
			array(9758, 0, $esrv),
			array(2617, 0, $epdo),
			array(2617, '2020-02-19 15:15:03.000000', $epdooffset),
			array(0, 0, array()),
		);
	}

	/**
	 * Method testgetRecordFieldChanges
	 * @test
	 * @dataProvider getRecordFieldChangesProvider
	 */
	public function testgetRecordFieldChanges($crmid, $mtime, $expected) {
		$actual = ModTracker::getRecordFieldChanges($crmid, $mtime);
		$this->assertEquals($expected, $actual, 'RecordFieldChanges '.$crmid.', '.$mtime);
	}

	/**
	 * Method getRecordFieldHistoryProvider
	 * params
	 */
	public function getRecordFieldHistoryProvider() {
		$epdo = array(
			array(
				'from' => '',
				'to' => 'Website',
			),
		);
		$esrv = array(
			array(
				'from' => '',
				'to' => 'Mfr Part No',
			),
			array(
				'from' => 'Mfr Part No',
				'to' => 'testme',
			),
		);
		return array(
			array(9758, 'website', $epdo),
			array(2617, 'mfr_part_no', $esrv),
			array(0, 'sales_stage', array()),
			array(2617, 'nofield', array()),
		);
	}

	/**
	 * Method testgetRecordFieldHistory
	 * @test
	 * @dataProvider getRecordFieldHistoryProvider
	 */
	public function testgetRecordFieldHistory($crmid, $field, $expected) {
		$actual = ModTracker::getRecordFieldHistory($crmid, $field);
		$this->assertEquals($expected, $actual, 'RecordFieldChanges '.$crmid.', '.$field);
	}
}
