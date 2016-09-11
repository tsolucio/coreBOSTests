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
class VTSimpleTemplateTest extends PHPUnit_Framework_TestCase {

	/**
	 * Method testRender
	 * @test
	 */
	public function testRender() {
		// Setup
		$entityId = '11x74';
		$util = new VTWorkflowUtils();
		$adminUser = $util->adminUser();
		$entityCache = new VTEntityCache($adminUser);
		// Constant string.
		$ct = new VTSimpleTemplate('Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto.');
		$expected = 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto.';
		$actual = $ct->render($entityCache, $entityId);
		$this->assertEquals($expected, $actual, 'Constant String');
		// Account variables
		$ct = new VTSimpleTemplate('AccountId:$account_no - AccountName:$accountname');
		$expected = 'AccountId:ACC1 - AccountName:Chemex Labs Ltd';
		$actual = $ct->render($entityCache, $entityId);
		$this->assertEquals($expected, $actual,'Account variables');
		// User variables
		$ct = new VTSimpleTemplate('$(assigned_user_id : (Users) email1)');
		$expected = 'noreply@tsolucio.com';
		$actual = $ct->render($entityCache, $entityId);
		$this->assertEquals($expected, $actual,'User variables');
		// Member of
		$ct = new VTSimpleTemplate('$(account_id : (Accounts) accountname)​​​​​​​');
		$expected = 'Rowley Schlimgen Inc​​​​​​​';
		$actual = $ct->render($entityCache, $entityId);
		$this->assertEquals($expected, $actual,'Member of variables');
		// Teardown
		$util->revertUser();
	}

	/**
	 * Method testMeta
	 * @test
	 */
	public function testMeta() {
		global $site_URL;
		// Setup
		$entityId = '12x1607';
		$util = new VTWorkflowUtils();
		$adminUser = $util->adminUser();
		$entityCache = new VTEntityCache($adminUser);
		// Detail View URL
		$ct = new VTSimpleTemplate('$(general : (__VtigerMeta__) crmdetailviewurl)');
		$expected = $site_URL.'/index.php?action=DetailView&module=Contacts&record=1607';
		$actual = $ct->render($entityCache, $entityId);
		$this->assertEquals($expected, $actual, 'Detail View URL');
		// Today
		$ct = new VTSimpleTemplate('$(general : (__VtigerMeta__) date)');
		$expected = date('Y-m-d');
		$actual = $ct->render($entityCache, $entityId);
		$this->assertEquals($expected, $actual,'Today');
		// Record ID
		$ct = new VTSimpleTemplate('$(general : (__VtigerMeta__) recordId)');
		$expected = '1607';
		$actual = $ct->render($entityCache, $entityId);
		$this->assertEquals($expected, $actual,'Record ID');
		// Comments
		$ct = new VTSimpleTemplate('$(general : (__VtigerMeta__) comments)​​​​​​​');
		$expected = '<div class="comments"><div class="commentdetails"><ul class="commentfields"><li class="commentcreator"> Administrator</li><li class="commentdate">2015-10-06 11:31:58</li><li class="commentcomment">turpis nec mauris blandit mattis. Cras eget nisi dictum augue malesuada malesuada. Integer id magna et ipsum cursus vestibulum. Mauris magna. Duis dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec porttitor tellus non magna. Nam ligula elit, pretium et, rutrum non, hendrerit id, ante. Nunc mauris sapien, cursus in, hendrerit consectetuer, cursus et, magna. Praesent interdum ligula eu enim. Etiam imperdiet dictum magna. Ut tincidunt orci quis lectus. Nullam suscipit, est ac facilisis facilisis, magna tellus faucibus leo, in lobortis tellus justo sit amet nulla. Donec non justo. Proin non massa non ante bibendum ullamcorper. Duis cursus, diam at pretium aliquet, metus urna convallis erat, eget tincidunt dui augue eu tellus. Phasellus elit pede, malesuada vel, venenatis vel, faucibus id, libero. Donec consectetuer mauris id sapien. Cras dolor dolor, tempus non, lacinia at, iaculis quis, pede.</li></ul></div><div class="commentdetails"><ul class="commentfields"><li class="commentcreator"> Administrator</li><li class="commentdate">2015-12-15 21:18:07</li><li class="commentcomment">nec metus facilisis lorem tristique aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero et tristique pellentesque, tellus sem mollis dui, in sodales elit erat vitae risus. Duis a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus mauris a nunc. In at pede. Cras vulputate velit eu sem. Pellentesque ut ipsum ac mi eleifend egestas. Sed pharetra, felis eget varius ultrices, mauris ipsum porta elit, a feugiat tellus lorem eu metus. In lorem. Donec elementum, lorem ut aliquam iaculis, lacus pede sagittis augue, eu tempor</li></ul></div></div>​​​​​​​';
		$actual = $ct->render($entityCache, $entityId);
		$this->assertEquals($expected, $actual,'Comments');
		// Teardown
		$util->revertUser();
	}

}
