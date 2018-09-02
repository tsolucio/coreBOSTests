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
// Turn on debugging level
$Vtiger_Utils_Log = false;
set_time_limit(0);
ini_set('memory_limit','1024M');
error_reporting(E_ERROR);ini_set("display_errors", "on");

require_once 'include/utils/utils.php';
coreBOS_Session::init();
require_once('vtlib/Vtiger/Module.php');
require_once('vtlib/Vtiger/Package.php');
require_once('vtlib/Vtiger/Net/Client.php');
require_once('modules/com_vtiger_workflow/include.inc');
require_once('modules/com_vtiger_workflow/tasks/VTEntityMethodTask.inc');
require_once('modules/com_vtiger_workflow/VTEntityMethodManager.inc');
require_once('include/events/include.inc');
require_once 'include/Webservices/Utils.php';
require_once("modules/Users/Users.php");
require_once("include/Webservices/State.php");
require_once("include/Webservices/OperationManagerEnDecode.php");
require_once("include/Webservices/OperationManager.php");
require_once("include/Webservices/SessionManager.php");
require_once 'include/Webservices/WebserviceField.php';
require_once 'include/Webservices/EntityMeta.php';
require_once 'include/Webservices/VtigerWebserviceObject.php';
require_once("include/Webservices/VtigerCRMObject.php");
require_once("include/Webservices/VtigerCRMObjectMeta.php");
require_once("include/Webservices/VtigerCRMActorMeta.php");
require_once("include/Webservices/VtigerModuleOperation.php");
require_once("include/Webservices/DataTransform.php");
require_once("include/Webservices/WebServiceError.php");
require_once 'include/utils/UserInfoUtil.php';
require_once 'include/Webservices/ModuleTypes.php';
require_once 'include/utils/VtlibUtils.php';
require_once 'include/Webservices/WebserviceEntityOperation.php';
require_once 'include/Webservices/Retrieve.php';
require_once 'include/Webservices/Create.php';
require_once 'include/Webservices/Update.php';
require_once 'include/Webservices/Revise.php';
require_once 'include/Webservices/DescribeObject.php';
require_once 'include/Webservices/RetrieveDocAttachment.php';
require_once('modules/Emails/mail.php');
require_once('modules/com_vtiger_workflow/VTSimpleTemplate.inc');
require_once 'modules/com_vtiger_workflow/VTEntityCache.inc';
require_once('modules/com_vtiger_workflow/VTWorkflowUtils.php');
require_once('modules/com_vtiger_workflow/expression_engine/include.inc');
require_once('modules/com_vtiger_workflow/WorkFlowScheduler.php');
global $current_user,$adb,$app_strings;

$current_user = Users::getActiveAdminUser();
if (empty($current_language)) {
	if(isset($_SESSION['authenticated_user_language']) && $_SESSION['authenticated_user_language'] != '') {
		$current_language = $_SESSION['authenticated_user_language'];
	} else {
		if(!empty($current_user->language)) {
			$current_language = $current_user->language;
		} else {
			$current_language = $default_language;
		}
	}
}
if (empty($app_strings)) $app_strings = return_application_language($current_language);
?>