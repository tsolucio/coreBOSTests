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
include_once('config.inc.php');
require_once('modules/Users/CreateUserPrivilegeFile.php');
global $adb,$current_user;

/////////////////////////
// Number of users to create
/////////////////////////
$NumberOfUsers = 5;

// Compruebo si el usuario ya existe
function UserExists($uname) {
	global $adb;
	$user_result = $adb->pquery('SELECT 1 FROM vtiger_users WHERE user_name=?', array($uname));
	return ($adb->num_rows($user_result) > 0);
}

$current_user = new Users();
$current_user->retrieveCurrentUserInfoFromFile(Users::getActiveAdminId());

$usrs = $adb->pquery('SELECT * FROM `marvel` order by rand() limit '.$NumberOfUsers,array());
while ($u=$adb->fetch_array($usrs)) {
	$name = decode_html($u['name']);
	$user_name = preg_replace("/[^A-Za-z0-9]/", '', $name);
	$loop=1;
	while (UserExists($user_name)) {
		$user_name.=$loop;
		$loop++;
	}
	$new_pass = $user_name;
	$focus = new Users();
	$focus->mode='';
	$focus->column_fields['user_password'] = $new_pass;
	$focus->column_fields['is_admin'] = 'off';
	$focus->column_fields['user_name'] = $user_name;
	$focus->column_fields['status'] = 'Active';
	$focus->column_fields['email1'] = 'noreply@corebos.org';
	$rrs = $adb->pquery('SELECT roleid FROM `vtiger_role` order by rand() limit 1',array());
	$focus->column_fields['roleid'] = $adb->query_result($rrs, 0, 'roleid');
	if (strpos($name, ' ')===false) {
		$name = $name. ' '. $name;
	}
	list($focus->column_fields['first_name'],$focus->column_fields['last_name']) = explode(' ',$name,2);
	$focus->column_fields['description'] = 'coreBOS Test User';
	$focus->column_fields['internal_mailer'] = 0;
	$focus->column_fields['activity_view']='This Week';
	$focus->column_fields['lead_view']='Today';
	$focus->column_fields['currency_id']='1';
	$focus->column_fields['currency_name']='Euro';
	$focus->column_fields['currency_code']='EUR';
	$focus->column_fields['currency_symbol']='&#8364;';
	$focus->column_fields['conv_rate']='1.000';
	$focus->column_fields['currency_grouping_pattern'] = '123,456,789';
	$focus->column_fields['currency_decimal_separator'] = '.';
	$focus->column_fields['currency_grouping_separator'] = ',';
	$focus->column_fields['currency_symbol_placement'] = '$1.0';
	
	$focus->saveentity("Users");
	$focus->saveHomeStuffOrder($focus->id);
	SaveTagCloudView($focus->id);
	
	//Para crear el confirm_password y ahora si encriptar el user_pass
	$focus->change_password($new_pass, $new_pass);
	
	//Creating the Privileges Flat File
	createUserSharingPrivilegesfile($focus->id);
	echo "User $name ($user_name) created\n";
}
$adb->pquery('update vtiger_users set change_password=0',array());
echo 'Users created!!';

?>
