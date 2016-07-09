<?php
/*************************************************************************************************
 * Copyright 2016 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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
include_once('vtlib/Vtiger/Module.php');
include_once('modules/Users/Users.php');
require_once('include/logging.php');
require_once('include/utils/UserInfoUtil.php');
require_once('include/utils/utils.php');
include_once('config.inc.php');
global $adb;

/////////////////////////
// Number of groups to create
/////////////////////////
$NumberOfGroups = 5;
$MaxGroupMembers = 5;
$MaxRoleMembers = 5;
$MaxRoleSubMembers = 3;
$MaxUserMembers = 15;
/////////////////////////

$randGroupMembers = array(0);
for ($c=1;$c<=$MaxGroupMembers;$c++) {
	if ($c % 5 == 0) $randGroupMembers[] = 0;
	$randGroupMembers[] = $c;
}
$randRoleMembers = array(0);
for ($c=1;$c<=$MaxRoleMembers;$c++) {
	if ($c % 4 == 0) $randRoleMembers[] = 0;
	$randRoleMembers[] = $c;
}
$randRoleSubMembers = array(0);
for ($c=1;$c<=$MaxRoleSubMembers;$c++) {
	if ($c % 3 == 0) $randRoleSubMembers[] = 0;
	$randRoleSubMembers[] = $c;
}
$randUserMembers = array(0);
for ($c=1;$c<=$MaxUserMembers;$c++) {
	if ($c % 7 == 0) $randUserMembers[] = 0;
	$randUserMembers[] = $c;
}

// Compruebo si el grupo ya existe
function GroupExists($gname) {
	global $adb;
	$grp_result = $adb->pquery('SELECT 1 FROM vtiger_groups WHERE groupname=?', array($gname));
	return ($adb->num_rows($grp_result) > 0);
}

$current_user = new Users();
$current_user->retrieveCurrentUserInfoFromFile(Users::getActiveAdminId());

$grrs = $adb->pquery('SELECT * FROM `marvel` order by rand() limit '.$NumberOfGroups,array());
while ($g=$adb->fetch_array($grrs)) {

	$grpname = html_entity_decode($g['name'],ENT_QUOTES,'UTF-8');
	$grpdesc = 'coreBOS Test Group';

	$loop=1;
	while (GroupExists($grpname)) {
		$grpname.=$loop;
		$loop++;
	}

	$grpMembers = array();

	$grpm = array();
	$numelems = rand(0, count($randGroupMembers)-1);
	$grprs = $adb->pquery('select groupid from vtiger_groups order by rand() limit '.$randGroupMembers[$numelems],array());
	while ($grp = $adb->fetch_array($grprs)) {
		$grpm[] = $grp['groupid'];
	}
	$grpMembers['groups'] = $grpm;

	$grpm = array();
	$numelems = rand(0, count($randRoleMembers)-1);
	$grprs = $adb->pquery('select roleid from vtiger_role order by rand() limit '.$randRoleMembers[$numelems],array());
	while ($grp = $adb->fetch_array($grprs)) {
		$grpm[] = $grp['roleid'];
	}
	$grpMembers['roles'] = $grpm;

	$grpm = array();
	$numelems = rand(0, count($randRoleSubMembers)-1);
	$grprs = $adb->pquery('select roleid from vtiger_role order by rand() limit '.$randRoleSubMembers[$numelems],array());
	while ($grp = $adb->fetch_array($grprs)) {
		$grpm[] = $grp['roleid'];
	}
	$grpMembers['rs'] = $grpm;

	$grpm = array();
	$numelems = rand(0, count($randUserMembers)-1);
	$grprs = $adb->pquery('select id from vtiger_users order by rand() limit '.$randUserMembers[$numelems],array());
	while ($grp = $adb->fetch_array($grprs)) {
		$grpm[] = $grp['id'];
	}
	$grpMembers['users'] = $grpm;

	$groupId = createGroup($grpname,$grpMembers,$grpdesc);

	echo "$grpname created\n";
}
?>
