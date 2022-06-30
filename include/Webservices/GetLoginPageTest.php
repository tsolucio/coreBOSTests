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

include_once 'include/Webservices/getLoginPage.php';

class GetLoginPageTest extends TestCase {

	/**
	 * Method getLoginPageProvider
	 * params
	 */
	public function getLoginPageProvider() {
		$ecrm = '<!DOCTYPE html> <html> <head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> <meta name="robots" content="noindex"> <title>coreBOS</title> <link REL="SHORTCUT ICON" HREF="themes/images/favicon.ico"> <script type="text/javascript" src="themes/login/login.js"></script> <link rel="stylesheet" href="themes/login/cbcrm/style.css"> </head> <body onload="set_focus()" data-gr-c-s-loaded="true"> <div class="loginContainer"> <table class="loginWrapper" width="100%" height="100%" cellpadding="0" cellspacing="0" border="0"> <tr valign="top"> <td valign="top" align="left" colspan="2"> <img align="absmiddle" src="themes/images/coreboslogo.png" alt="logo" width="145px" height="65" /> <br /> <a target="_blank" href="http://www.your-company.tld"><span style="color: blacksmoke">Your Company</span></a> <br /> </td> </tr> <tr> <td valign="top" align="center" width="50%"></td> <td valign="top" align="center" width="50%"></td> </tr> </table> </td> </tr> </table> <div class="vtmktTitle">
			&nbsp;coreBOSCRM
			<div class="poweredBy">Powered by coreBOS - 8.0</div> </div> <div class="loginForm"> <form action="index.php" method="post" id="form"> <input type="hidden" name="module" value="Users" /> <input type="hidden" name="action" value="Authenticate" /> <input type="hidden" name="return_module" value="Users" /> <input type="hidden" name="return_action" value="Login" /> <div class="inputs"> <div class="label">User Name</div> <div class="input"> <input type="text" name="user_name" /> </div> <br /> <div class="label">Password</div> <div class="input"> <input type="password" name="user_password" /> </div> <br /> <div class="button"> <input type="submit" id="submitButton" value="LOGIN" /> </div> </div> </form> </div> </div> </body> </html>';
		$ecb = '<!DOCTYPE html> <html> <head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> <meta name="robots" content="noindex"> <title>coreBOS</title> <link REL="SHORTCUT ICON" HREF="themes/images/favicon.ico"> <script type="text/javascript" src="themes/login/login.js"></script> <link rel="stylesheet" href="include/style.css"> </head> <body onload="set_focus()" data-gr-c-s-loaded="true"> <div class="loginContainer"> <div id="loginWrapper"> <div id="loginTop"> <a href="index.php"><img src="themes/images/coreboslogo.png"></a> </div> <div id="loginBody"> <div class="loginForm"> <div class="poweredBy">Powered by coreBOS</div> <form action="index.php" method="post" id="form"> <input type="hidden" name="module" value="Users" /> <input type="hidden" name="action" value="Authenticate" /> <input type="hidden" name="return_module" value="Users" /> <input type="hidden" name="return_action" value="Login" /> <table border="0"> <tr> <td valign="middle">User Name</td> <td valign="middle"><input type="text" name="user_name" tabindex="1"></td> <td rowspan="2" align="center" valign="middle"><input type="submit" id="submitButton" value="" tabindex="3"></td> </tr> <tr> <td valign="middle">Password</td> <td valign="middle"><input type="password" name="user_password" tabindex="2"></td> </tr> </table> </form> </div> </div> </div> </div> </body> </html>';
		$elds = '<!DOCTYPE html> <html> <head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> <meta name="robots" content="noindex"> <title>coreBOS</title> <link REL="SHORTCUT ICON" HREF="themes/images/favicon.ico"> <script type="text/javascript" src="themes/login/login.js"></script> <link rel="stylesheet" href="themes/login/lds/sfdc_210.css"> <style type="text/css">
a {
	color: #0070d2;
}

body {
	background-color: #F4F6F9;
}

#content, .container {
	background-color: #ffffff;
}

#header {
	color: #16325c;
}

body {
	display: table;
	width: 100%;
}

#content {
	margin-bottom: 24px;
}

#wrap {
	height: 100%;
}

#right {
	vertical-align: middle;
}

.errorMessage {
	font-size: 12px;
	color: #982121;
}
</style> </head> <body onload="set_focus()" data-gr-c-s-loaded="true"> <div id="left" class="pr"> <div id="wrap"> <div id="main"> <div id="wrapper"> <div id="logo_wrapper" class="standard_logo_wrapper mb24"> <h1 style="height: 100%; display: table-cell; vertical-align: bottom;"> <img id="logo" class="standard_logo" src="themes/images/coreboslogo.png" alt="coreBOS" border="0" name="logo"> </h1> </div> <h2 id="header" class="mb12" style="display: none;"></h2> <div id="content" style="display: block;"> <div id="chooser" style="display: none"> <div class="loginError" id="chooser_error" style="display: block;"></div> </div> <div id="theloginform" style="display: block;"> <form method="post" id="login_form" action="index.php" target="_top" autocomplete="off" novalidate="novalidate"> <input type="hidden" name="module" value="Users" /> <input type="hidden" name="action" value="Authenticate" /> <input type="hidden" name="return_module" value="Users" /> <input type="hidden" name="return_action" value="Login" /> <div id="usernamegroup" class="inputgroup"> <label for="username" class="label">Usuario:</label> <div id="username_container"> <input class="input r4 wide mb16 mt8 username" type="email" value="" name="user_name" id="username" style="display: block;"> </div> </div> <label for="password" class="label">Contraseña:</label> <input class="input r4 wide mb16 mt8 password" type="password" id="password" name="user_password" onkeypress="checkCaps(event)" autocomplete="off"> <div id="pwcaps" class="mb16" style="display: none"> <img id="pwcapsicon" alt="CapsLock is active" width="12" src="themes/login/lds/capslock_blue.png">
									CapsLock is active
								</div> <input class="button r4 wide primary" type="submit" id="Login" name="Login" value="Start Session"> </form> </div> </div> </div> </div> <div id="footer">
				© Powered by coreBOS.
			</div> </div> </div> </body> </html>';
		return array(
			array('cbcrm', 'en_us', false, $ecrm),
			array('coreBOS', 'en_us', false, $ecb),
			array('ldsnoimage', 'es_es', false, $elds),
			array('DoesNotExist', 'es_es', false, $elds),
		);
	}

	/**
	 * Method testgetloginpage
	 * @test
	 * @dataProvider getLoginPageProvider
	 */
	public function testgetloginpage($template, $language, $csrf, $expected) {
		global $current_user;
		$this->assertEquals($expected, get_loginpage($template, $language, $csrf, $current_user));
	}
}
?>