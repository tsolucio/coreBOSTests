<?php
/*************************************************************************************************
 * Copyright 2017 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

class cbmqtm_dbdistributorTest extends TestCase {

	/**
	 * Method testgetInstance
	 * @test
	 */
	public function testgetInstance() {
		$cbmq = coreBOS_MQTM::getInstance();
		$this->assertInstanceOf(cbmqtm_dbdistributor::class, $cbmq, 'testConstruct class coreBOS_MQTM');
	}

	/**
	 * Method testMessageQueue
	 * @test
	 */
	public function testMessageQueue() {
		global $adb;
		$cbmq = coreBOS_MQTM::getInstance();
		$adb->query('TRUNCATE cb_messagequeue');
		$cbmq->sendMessage('cbTestChannel', 'phpunit', 'phpunit', 'Data', '1:M', 1, 30, 0, 1, 'information');

		$rs = $adb->query('select count(*) from cb_messagequeue');
		$nummsg = $adb->query_result($rs, 0, 0);
		$this->assertEquals(1, $nummsg, 'testMessageQueue count after send');

		$this->assertTrue($cbmq->isMessageWaiting('cbTestChannel', 'phpunit', 'phpunit', '1'), 'testMessageQueue msg waiting');

		$actual = $cbmq->getMessage('cbTestChannel', 'phpunit', 'phpunit', '1');
		$rs = $adb->query('select count(*) from cb_messagequeue');
		$nummsg = $adb->query_result($rs, 0, 0);
		$this->assertEquals(0, $nummsg, 'testMessageQueue count after get');
		$expected = array(
			'channel' => 'cbTestChannel',
			'producer' => 'phpunit',
			'consumer' => 'phpunit',
			'type' => 'Data',
			'share' => '1:M',
			'sequence' => '1',
			'senton' => $actual['senton'], // we trust this is working correctly :-(
			'deliverafter' => $actual['deliverafter'],
			'expires' => $actual['expires'],
			'version' => $actual['version'],
			'invalid' => 0,
			'invalidreason' => '',
			'userid' => '1',
			'information' => 'information'
		);
		$this->assertEquals($expected, $actual, 'testMessageQueue send/get to DB');

		$cbmq->rejectMessage($expected, 'testreject');

		$rs = $adb->query('select count(*) from cb_messagequeue');
		$nummsg = $adb->query_result($rs, 0, 0);
		$this->assertEquals(1, $nummsg, 'testMessageQueue count after reject');

		$actual = $cbmq->getMessage('cbINVALID', 'phpunit', 'phpunit', '1');
		$rs = $adb->query('select count(*) from cb_messagequeue');
		$nummsg = $adb->query_result($rs, 0, 0);
		$this->assertEquals(0, $nummsg, 'testMessageQueue count after get');
		$expected = array(
			'channel' => 'cbINVALID',
			'producer' => 'phpunit',
			'consumer' => 'phpunit',
			'type' => 'Data',
			'share' => '1:M',
			'sequence' => '1',
			'senton' => $actual['senton'], // we trust this is working correctly :-(
			'deliverafter' => $actual['deliverafter'],
			'expires' => $actual['expires'],
			'version' => $actual['version'],
			'invalid' => 1,
			'invalidreason' => 'cbTestChannel::testreject',
			'userid' => '1',
			'information' => 'information',
		);
		$this->assertEquals($expected, $actual, 'testMessageQueue reject/get to DB');
	}

	/**
	 * Method testMSQDeliveryRange
	 * @test
	 */
	public function testMSQDeliveryRange() {
		global $adb;
		$cbmq = coreBOS_MQTM::getInstance();
		$adb->query('TRUNCATE cb_messagequeue');

		$now = time();
		$one_min = $now + (1 * 60);
		$two_min = $now + (2 * 60);
		$startDate = date('H:i:s', $one_min);
		$endDate = date('H:i:s', $two_min);
		$deliverRange = array('deliverStartTime'=>$startDate, 'deliverEndTime'=>$endDate, 'canSendOnSaturday'=>1, 'canSendOnSunday'=>1);
		$cbmq->sendMessage('cbTestChannel', 'phpunit', 'phpunit', 'Message', '1:M', 1, 0, 0, 0, 'sample information to test will read', $deliverRange);
		$cbmq->sendMessage('cbTestChannel', 'phpunit', 'phpunit', 'Message', '1:M', 1, 0, 0, 0, 'sample information to test will not read', $deliverRange);
		$actual = $cbmq->getMessage('cbTestChannel', 'phpunit', 'phpunit');
		$this->assertFalse($actual, 'Please wait after 1 minute and run again');
		sleep(65);
		$actual = $cbmq->getMessage('cbTestChannel', 'phpunit', 'phpunit');
		$expected = array(
			'channel' => 'cbTestChannel',
			'producer' => 'phpunit',
			'consumer' => 'phpunit',
			'type' => 'Message',
			'share' => '1:M',
			'sequence' => '1',
			'senton' => $actual['senton'], // we trust this is working correctly :-(
			'deliverafter' => $actual['deliverafter'],
			'expires' => $actual['expires'],
			'version' => $actual['version'],
			'invalid' => 0,
			'invalidreason' => '',
			'userid' => '0',
			'information' => 'sample information to test will read'
		);
		$this->assertEquals($expected, $actual, 'testMSQDeliveryRange');
		sleep(65); // now it is out of range so we should not get it
		$actual = $cbmq->getMessage('cbTestChannel', 'phpunit', 'phpunit');
		$this->assertFalse($actual, 'Message has expired');
		$rs = $adb->pquery('select count(*) from cb_messagequeue where channel=?', ['cbTestChannel']);
		$nummsg = $adb->query_result($rs, 0, 0);
		$this->assertEquals(1, $nummsg, 'testMessageQueue count after get expired');
		$adb->query('TRUNCATE cb_messagequeue');

		$deliverRange = array('deliverStartTime'=>'21:00:00', 'deliverEndTime'=>'23:59:00', 'canSendOnSaturday'=>0, 'canSendOnSunday'=>0);
		$cbmq->sendMessage('cbTestChannel', 'phpunit', 'phpunit', 'Message', '1:M', 1, 0, 0, 0, 'sample information to test', $deliverRange);

		$cur_time = date('H:i:s', time());
		$check_date = date('l');
		$actual = $cbmq->getMessage('cbTestChannel', 'phpunit', 'phpunit');
		$expected = array(
			'channel' => 'cbTestChannel',
			'producer' => 'phpunit',
			'consumer' => 'phpunit',
			'type' => 'Message',
			'share' => '1:M',
			'sequence' => '1',
			'senton' => $actual['senton'], // we trust this is working correctly :-(
			'deliverafter' => $actual['deliverafter'],
			'expires' => $actual['expires'],
			'version' => $actual['version'],
			'invalid' => 0,
			'invalidreason' => '',
			'userid' => '0',
			'information' => 'sample information to test'
		);
		if (($check_date == 'Saturday' || $check_date == 'Sunday') || ($cur_time < '21:00:00' || $cur_time > '23:59:00')) {
			$this->assertFalse($actual, 'This message is out of range');
			$adb->query('TRUNCATE cb_messagequeue');
		} else {
			$this->assertEquals($expected, $actual, 'testMSQDeliveryRangeNoDelivery');
		}
		////////////////////////////////////////////////////////////////////////////////////
		$deliverRange = array('deliverStartTime'=>'21:00:00', 'deliverEndTime'=>'23:59:00', 'canSendOnSaturday'=>1, 'canSendOnSunday'=>1);
		$cbmq->sendMessage('cbTestChannel', 'phpunit', 'phpunit', 'Message', '1:M', 1, 0, 0, 0, 'sample information to test', $deliverRange);

		$actual = $cbmq->getMessage('cbTestChannel', 'phpunit', 'phpunit');
		$expected = array(
			'channel' => 'cbTestChannel',
			'producer' => 'phpunit',
			'consumer' => 'phpunit',
			'type' => 'Message',
			'share' => '1:M',
			'sequence' => '1',
			'senton' => $actual['senton'], // we trust this is working correctly :-(
			'deliverafter' => $actual['deliverafter'],
			'expires' => $actual['expires'],
			'version' => $actual['version'],
			'invalid' => 0,
			'invalidreason' => '',
			'userid' => '0',
			'information' => 'sample information to test'
		);
		if ('21:00:00' < $cur_time && $cur_time < '23:59:00') {
			$this->assertEquals($expected, $actual, 'testMSQDeliveryRangeNoDelivery');
		} else {
			$this->assertFalse($actual, 'This message is out of range');
			$adb->query('TRUNCATE cb_messagequeue');
		}
	}

	/**
	 * Method testSubscribe
	 * @test
	 */
	public function testSubscribe() {
		global $adb, $default_charset;
		$cbmq = coreBOS_MQTM::getInstance();
		$adb->query('TRUNCATE cb_messagequeue');
		$cbmq->subscribeToChannel('cbTestChannel', 'phpunit', 'phpunit', array(1,1));
		$cbmq->subscribeToChannel('cbTestChannel', 'phpunit', 'phpunit', array(2,2));
		$cbmq->subscribeToChannel('cbTestChannel', 'phpunit', 'phpunitlog', '1,2');
		$subrs = $adb->query('select * from cb_mqsubscriptions order by consumer, callback');
		$actual = array();
		while ($s = $adb->fetch_array($subrs)) {
			$actual[$s['channel']][] = array(
				'producer' => $s['producer'],
				'consumer' => $s['consumer'],
				'callback' => html_entity_decode($s['callback'], ENT_QUOTES, $default_charset),
			);
		}
		$expected = array();
		$expected['cbTestChannel'][] = array(
			'producer' => 'phpunit',
			'consumer' => 'phpunit',
			'callback' => serialize(array(1,1)),
		);
		$expected['cbTestChannel'][] = array(
			'producer' => 'phpunit',
			'consumer' => 'phpunit',
			'callback' => serialize(array(2,2)),
		);
		$expected['cbTestChannel'][] = array(
			'producer' => 'phpunit',
			'consumer' => 'phpunitlog',
			'callback' => serialize('1,2'),
		);
		$expected['wfLaunchNowChannel'][] = array(
			'producer' => 'malaunchnow',
			'consumer' => 'malaunchnow',
			'callback' => 'a:3:{s:4:"file";s:50:"modules/com_vtiger_workflow/cbmqtm_malaunchnow.php";s:5:"class";s:18:"cbmqtm_malaunchnow";s:6:"method";s:11:"MALaunchNow";}',
		);
		$expected['ClickhouseChannel'][] = array(
			'producer' => 'ClickHouseHandler',
			'consumer' => 'ClickHouseSync',
			'callback' => 'a:3:{s:4:"file";s:46:"include/integrations/clickhouse/clickhouse.php";s:5:"class";s:18:"corebos_clickhouse";s:6:"method";s:14:"ClickHouseSync";}',
		);
		$this->assertEquals($expected, $actual, 'testSubscribe subscribe');

		$cbmq->sendMessage('cbTestChannel', 'phpunit', 'phpunit', 'Data', 'P:S', 1, 30, 0, 1, 'information');

		$rs = $adb->query('select count(*) from cb_messagequeue');
		$nummsg = $adb->query_result($rs, 0, 0);
		$this->assertEquals(3, $nummsg, 'testSubscribe count after send');

		$actual = $cbmq->getSubscriptionWakeUps();
		$expected = array();
		$expected[] = array(1,1);
		$expected[] = '1,2';
		$expected[] = array(2,2);
		$this->assertEquals($expected, $actual, 'testSubscribe wakeups');

		$cbmq->unsubscribeToChannel('cbTestChannel', 'phpunit', 'phpunit', array(1,1));
		$rs = $adb->query('select count(*) from cb_mqsubscriptions');
		$nummsg = $adb->query_result($rs, 0, 0);
		$rs = $adb->query('select count(*) from cb_mqsubscriptions');
		$nummsg = $adb->query_result($rs, 0, 0);
		$this->assertEquals(4, $nummsg, 'testSubscribe unsubscribe1');
		$cbmq->unsubscribeToChannel('cbTestChannel', 'phpunit', 'phpunit', array(2,2));
		$rs = $adb->query('select count(*) from cb_mqsubscriptions');
		$nummsg = $adb->query_result($rs, 0, 0);
		$this->assertEquals(3, $nummsg, 'testSubscribe unsubscribe2');
		$cbmq->unsubscribeToChannel('cbTestChannel', 'phpunit', 'phpunitlog', '1,2');
		$rs = $adb->query('select count(*) from cb_mqsubscriptions');
		$nummsg = $adb->query_result($rs, 0, 0);
		$this->assertEquals(2, $nummsg, 'testSubscribe unsubscribe3');
		$adb->query('TRUNCATE cb_messagequeue');
	}

	/**
	 * Method testExpire
	 * @test
	 */
	public function testExpire() {
		global $adb;
		$cbmq = coreBOS_MQTM::getInstance();
		$adb->query('TRUNCATE cb_messagequeue');
		$cbmq->sendMessage('cbTestChannel', 'phpunit', 'phpunit', 'Data', '1:M', 1, 1, 0, 1, 'information');
		sleep(2);
		$cbmq->expireMessages();
		$actual = $cbmq->getMessage('cbINVALID', 'phpunit', 'phpunit', '1');
		$rs = $adb->query('select count(*) from cb_messagequeue');
		$nummsg = $adb->query_result($rs, 0, 0);
		$this->assertEquals(0, $nummsg, 'testExpire count after get');
		$expected = array(
			'channel' => 'cbINVALID',
			'producer' => 'phpunit',
			'consumer' => 'phpunit',
			'type' => 'Data',
			'share' => '1:M',
			'sequence' => '1',
			'senton' => $actual['senton'], // we trust this is working correctly :-(
			'deliverafter' => $actual['deliverafter'],
			'expires' => $actual['expires'],
			'version' => $actual['version'],
			'invalid' => '1',
			'invalidreason' => 'cbTestChannel::Expired',
			'userid' => '1',
			'information' => 'information',
		);
		$this->assertEquals($expected, $actual, 'testExpire expired/get to DB');
	}

	/**
	 * Method testDeliverAfter
	 * @test
	 */
	public function testDeliverAfter() {
		global $adb;
		$cbmq = coreBOS_MQTM::getInstance();
		$adb->query('TRUNCATE cb_messagequeue');
		$cbmq->sendMessage('cbTestChannel', 'phpunit', 'phpunit', 'Data', '1:M', 1, 5, 5, 1, 'information'); // deliver after 5 seconds
		$this->assertFalse($cbmq->isMessageWaiting('cbTestChannel', 'phpunit', 'phpunit', '1'), 'testDeliverAfter no msg waiting');
		sleep(6);
		$this->assertTrue($cbmq->isMessageWaiting('cbTestChannel', 'phpunit', 'phpunit', '1'), 'testDeliverAfter msg waiting');
		sleep(6);
		$cbmq->expireMessages();
		$this->assertFalse($cbmq->isMessageWaiting('cbTestChannel', 'phpunit', 'phpunit', '1'), 'testDeliverAfter no msg, it has been expired');
		$this->assertTrue($cbmq->isMessageWaiting('cbINVALID', 'phpunit', 'phpunit', '1'), 'testDeliverAfter msg expired');
		$adb->query('TRUNCATE cb_messagequeue');
	}
}