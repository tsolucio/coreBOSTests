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

class BusinessActionsTest extends TestCase {

	/**
	 * Method testgetAllByType
	 * @test
	 */
	public function testgetAllByType() {
		$customlink_params = array('MODULE'=>'CobroPago', 'RECORD'=>14297, 'ACTION'=>'DetailView');
		$actual = Vtiger_Link::getAllByType(getTabid('CobroPago'), array('DETAILVIEWBASIC', 'DETAILVIEW', 'DETAILVIEWWIDGET'), $customlink_params);
		$expectedLink = new Vtiger_Link();
		$expectedLink->tabid = '42';
		$expectedLink->linkid = '43542';
		$expectedLink->linktype = 'DETAILVIEWBASIC';
		$expectedLink->linklabel = 'View History';
		$expectedLink->linkurl = "javascript:ModTrackerCommon.showhistory('14297')";
		$expectedLink->linkicon = '';
		$expectedLink->sequence = '0';
		$expectedLink->status = false;
		$expectedLink->handler_path = 'modules/ModTracker/ModTracker.php';
		$expectedLink->handler_class = 'ModTracker';
		$expectedLink->handler = 'isViewPermitted';
		$expectedLink->onlyonmymodule = '0';
		$expected = array(
			'DETAILVIEWBASIC' => array(
				0 => $expectedLink,
			),
			'DETAILVIEW' => array(),
			'DETAILVIEWWIDGET' => array(),
		);
		$this->assertEquals($expected, $actual);
		/////////////////////////////////////////
		$actual = Vtiger_Link::getAllByType(getTabid('CobroPago'), 'DETAILVIEWBASIC', $customlink_params);
		$expectedLink = new Vtiger_Link();
		$expectedLink->tabid = '42';
		$expectedLink->linkid = '43542';
		$expectedLink->linktype = 'DETAILVIEWBASIC';
		$expectedLink->linklabel = 'View History';
		$expectedLink->linkurl = "javascript:ModTrackerCommon.showhistory('14297')";
		$expectedLink->linkicon = '';
		$expectedLink->sequence = '0';
		$expectedLink->status = false;
		$expectedLink->handler_path = 'modules/ModTracker/ModTracker.php';
		$expectedLink->handler_class = 'ModTracker';
		$expectedLink->handler = 'isViewPermitted';
		$expectedLink->onlyonmymodule = '0';
		$expected = array(
			'DETAILVIEWBASIC' => $expectedLink,
		);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * Method testaddLink
	 * @test
	 */
	public function testaddLink() {
		$module_contacts = Vtiger_Module::getInstance('Contacts');
		$expectedLinks = $module_contacts->getLinks();

		// Link attributes
		$tabid = getTabid('Contacts');
		$linktype = 'LISTVIEWBASIC';
		$linklabel = 'LBL_SELECT_ALL';
		$linkurl = 'toggleSelectAllEntries_ListView();';
		$linkicon = '';
		$sequence = '0';
		$handler_path = '';
		$handler_class = '';
		$handler = '';
		$onlyonmymodule = '0';

		// Adding link
		$module_contacts->addLink($linktype, $linklabel, $linkurl);
		$actualLinks = $module_contacts->getLinks();

		// Getting linkid
		$lastLink = end($actualLinks);
		reset($actualLinks);
		$linkid = $lastLink->linkid;

		// Link object
		$link = new Vtiger_Link();
		$link->tabid = $tabid;
		$link->linkid = $linkid;
		$link->linktype = $linktype;
		$link->linklabel = $linklabel;
		$link->linkurl = $linkurl;
		$link->linkicon = $linkicon;
		$link->sequence = $sequence;
		$link->handler_path = $handler_path;
		$link->handler_class = $handler_class;
		$link->handler = $handler;
		$link->onlyonmymodule = $onlyonmymodule;

		// Adding link object to expectedLinks
		$expectedLinks["LISTVIEWBASIC"] = $link;

		// Delete created link
		Vtiger_Link::deleteLink($tabid, $linktype, $linklabel);

		$this->assertEquals($expectedLinks, $actualLinks);
	}

	/**
	 * Method testupdateLink
	 * @test
	 */
	public function testupdateLink() {
		// Module links
		$module_contacts = Vtiger_Module::getInstance('Contacts');
		$links = $module_contacts->getLinks();

		// Last link
		$lastLink = end($links);
		reset($links);

		$expectedLinkLabel = "Send Email";

		// Update module last link
		Vtiger_Link::updateLink($lastLink->tabid, $lastLink->linkid, array('linklabel' => $expectedLinkLabel));

		// Updated module links
		$newLinks =$module_contacts->getLinks();
		$newLastLink = end($newLinks);
		reset($newLinks);

		$actualLinkLabel = $newLastLink->linklabel;

		// Restore module link value
		Vtiger_Link::updateLink($lastLink->tabid, $lastLink->linkid, array('linklabel' => $lastLink->linklabel));

		$this->assertEquals($expectedLinkLabel, $actualLinkLabel);
	}

	/**
	 * Method testdeleteLink
	 * @test
	 */
	public function testdeleteLink() {
		// Module links
		$module_contacts = Vtiger_Module::getInstance('Contacts');
		$actualLinks = $module_contacts->getLinks();

		// Last link
		$lastLink = end($actualLinks);
		reset($actualLinks);

		// Remove last link
		array_pop($actualLinks);

		// Delete last link
		Vtiger_Link::deleteLink($lastLink->tabid, $lastLink->linktype, $lastLink->linklabel);

		// Remained links
		$expectedLinks = $module_contacts->getLinks();

		// Restore link
		$handlerInfo = array();
		$handlerInfo['path'] = $lastLink->handler_path;
		$handlerInfo['class'] = $lastLink->handler_class;
		$handlerInfo['method'] = $lastLink->handler;

		$module_contacts->addLink($lastLink->linktype, $lastLink->linklabel, $lastLink->linkurl, $lastLink->icon, $lastLink->sequence, $handlerInfo, $lastLink->onlyonmymodule);

		$this->assertEquals($expectedLinks, $actualLinks);
	}

	/**
	 * Method testdeleteAll
	 * @test
	 */
	public function testdeleteAll() {
		// Module links
		$module_contacts = Vtiger_Module::getInstance('Contacts');
		$actualLinks = $module_contacts->getLinks();

		// Delete all module links
		Vtiger_Link::deleteAll(getTabid('Contacts'));

		$expectedLinks = $module_contacts->getLinks();

		// Restore module links
		foreach ($actualLinks as $link) {
			$handlerInfo['path'] = $link->handler_path;
			$handlerInfo['class'] = $link->handler_class;
			$handlerInfo['method'] = $link->handler;

			$module_contacts->addLink($link->linktype, $link->linklabel, $link->linkurl, $link->icon, (int)$link->sequence, $handlerInfo, $link->onlyonmymodule);
		}

		$this->assertEquals(0, count($expectedLinks));
	}
}