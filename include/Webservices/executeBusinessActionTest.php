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

include_once 'include/Webservices/executeBusinessAction.php';

class testWSexecuteBusinessAction extends TestCase {

	/**
	 * Method testBusinessAction
	 * @test
	 */
	public function testBusinessAction() {
		global $current_user;
		$expected = '<table class="small" border="0" cellpadding="0" cellspacing="0" width="100%"> <tr class="detailview_block_header comments_block_header"> <td colspan="4" class="dvInnerHeader"> <div style="float: left; font-weight: bold;"> <div style="float: left;"> <a href="javascript:showHideStatus(\'tblModCommentsDetailViewBlockCommentWidget\',\'aidModCommentsDetailViewBlockCommentWidget\',\'$IMAGE_PATH\');"> <span class="exp_coll_block inactivate"><img id="aidModCommentsDetailViewBlockCommentWidget" src="themes/images/activate.gif" style="border: 0px solid rgb(0, 0, 0);" alt="Hide" title="Hide"></span></a> </span></a> </div><b>&nbsp;Comments Information</b></div> <span style="float: right;"> <img src="themes/softed/images/vtbusy.gif" border=0 id="indicatorModCommentsDetailViewBlockCommentWidget" style="display:none;">
		Show : <select class="small" onchange="ModCommentsCommon.reloadContentWithFiltering(\'DetailViewBlockCommentWidget\', \'74\', this.value, \'tblModCommentsDetailViewBlockCommentWidget\', \'indicatorModCommentsDetailViewBlockCommentWidget\');"> <option value="All" selected>All</option> <option value="Last5" >Last 5</option> <option value="Mine" >Mine</option> </select> </span> </td> </tr> </table> <div id="tblModCommentsDetailViewBlockCommentWidget" style="display: block;"> <table class="small" border="0" cellpadding="0" cellspacing="0" width="100%"> <tr style="height: 25px;"> <td colspan="4" align="left" class="dvtCellInfo commentCell"> <div id="contentwrap_ModCommentsDetailViewBlockCommentWidget" style="overflow: auto; margin-bottom: 20px; width: 100%; word-break: break-all;"> </div> </td> </tr> <tr style="height: 25px;" class=\'noprint\'> <td class="dvtCellLabel" align="right">
		Add Comment
	</td> <td width="100%" colspan="3" class="dvtCellInfo" align="left"> <div id="editarea_ModCommentsDetailViewBlockCommentWidget"> <textarea id="txtbox_ModCommentsDetailViewBlockCommentWidget" class="detailedViewTextBox" onFocus="this.className=\'detailedViewTextBoxOn\'" onBlur="this.className=\'detailedViewTextBox\'" cols="90" rows="8"></textarea> <br><a href="javascript:;" class="detailview_ajaxbutton ajax_save_detailview" onclick="ModCommentsCommon.addComment(\'ModCommentsDetailViewBlockCommentWidget\', \'74\');">Save</a> <a href="javascript:;" onclick="document.getElementById(\'txtbox_ModCommentsDetailViewBlockCommentWidget\').value=\'\';" class="detailview_ajaxbutton ajax_cancelsave_detailview">Clear</a> </div> </td> </tr> </table> </div>';
		$actual = executeBusinessAction('41x43063', '{"RECORD":"11x74","MODE":"DETAILVIEW"}', $current_user);
		$this->assertEquals($expected, $actual, 'BusinessAction');
		$expected = '<table class="small" border="0" cellpadding="0" cellspacing="0" width="100%"> <tr class="detailview_block_header comments_block_header"> <td colspan="4" class="dvInnerHeader"> <div style="float: left; font-weight: bold;"> <div style="float: left;"> <a href="javascript:showHideStatus(\'tblModCommentsDetailViewBlockCommentWidget\',\'aidModCommentsDetailViewBlockCommentWidget\',\'$IMAGE_PATH\');"> <span class="exp_coll_block inactivate"><img id="aidModCommentsDetailViewBlockCommentWidget" src="themes/images/activate.gif" style="border: 0px solid rgb(0, 0, 0);" alt="Hide" title="Hide"></span></a> </span></a> </div><b>&nbsp;Comments Information</b></div> <span style="float: right;"> <img src="themes/softed/images/vtbusy.gif" border=0 id="indicatorModCommentsDetailViewBlockCommentWidget" style="display:none;">
		Show : <select class="small" onchange="ModCommentsCommon.reloadContentWithFiltering(\'DetailViewBlockCommentWidget\', \'74\', this.value, \'tblModCommentsDetailViewBlockCommentWidget\', \'indicatorModCommentsDetailViewBlockCommentWidget\');"> <option value="All" selected>All</option> <option value="Last5" >Last 5</option> <option value="Mine" >Mine</option> </select> </span> </td> </tr> </table> <div id="tblModCommentsDetailViewBlockCommentWidget" style="display: block;"> <table class="small" border="0" cellpadding="0" cellspacing="0" width="100%"> <tr style="height: 25px;"> <td colspan="4" align="left" class="dvtCellInfo commentCell"> <div id="contentwrap_ModCommentsDetailViewBlockCommentWidget" style="overflow: auto; margin-bottom: 20px; width: 100%; word-break: break-all;"> </div> </td> </tr> <tr style="height: 25px;" class=\'noprint\'> <td class="dvtCellLabel" align="right">
		Add Comment
	</td> <td width="100%" colspan="3" class="dvtCellInfo" align="left"> <div id="editarea_ModCommentsDetailViewBlockCommentWidget"> <textarea id="txtbox_ModCommentsDetailViewBlockCommentWidget" class="detailedViewTextBox" onFocus="this.className=\'detailedViewTextBoxOn\'" onBlur="this.className=\'detailedViewTextBox\'" cols="90" rows="8"></textarea> <br><a href="javascript:;" class="detailview_ajaxbutton ajax_save_detailview" onclick="ModCommentsCommon.addComment(\'ModCommentsDetailViewBlockCommentWidget\', \'74\');">Save</a> <a href="javascript:;" onclick="document.getElementById(\'txtbox_ModCommentsDetailViewBlockCommentWidget\').value=\'\';" class="detailview_ajaxbutton ajax_cancelsave_detailview">Clear</a> </div> </td> </tr> </table> </div>';
		$actual = executeBusinessAction('41x43063', '{"RECORD":"74","MODE":"DETAILVIEW"}', $current_user);
		$this->assertEquals($expected, $actual, 'BusinessAction');
		$expected = '<table class="small" border="0" cellpadding="0" cellspacing="0" width="100%"> <tr class="detailview_block_header comments_block_header"> <td colspan="4" class="dvInnerHeader"> <div style="float: left; font-weight: bold;"> <div style="float: left;"> <a href="javascript:showHideStatus(\'tblModCommentsDetailViewBlockCommentWidget\',\'aidModCommentsDetailViewBlockCommentWidget\',\'$IMAGE_PATH\');"> <span class="exp_coll_block inactivate"><img id="aidModCommentsDetailViewBlockCommentWidget" src="themes/images/activate.gif" style="border: 0px solid rgb(0, 0, 0);" alt="Hide" title="Hide"></span></a> </span></a> </div><b>&nbsp;Comments Information</b></div> <span style="float: right;"> <img src="themes/softed/images/vtbusy.gif" border=0 id="indicatorModCommentsDetailViewBlockCommentWidget" style="display:none;">
		Show : <select class="small" onchange="ModCommentsCommon.reloadContentWithFiltering(\'DetailViewBlockCommentWidget\', \'74\', this.value, \'tblModCommentsDetailViewBlockCommentWidget\', \'indicatorModCommentsDetailViewBlockCommentWidget\');"> <option value="All" selected>All</option> <option value="Last5" >Last 5</option> <option value="Mine" >Mine</option> </select> </span> </td> </tr> </table> <div id="tblModCommentsDetailViewBlockCommentWidget" style="display: block;"> <table class="small" border="0" cellpadding="0" cellspacing="0" width="100%"> <tr style="height: 25px;"> <td colspan="4" align="left" class="dvtCellInfo commentCell"> <div id="contentwrap_ModCommentsDetailViewBlockCommentWidget" style="overflow: auto; margin-bottom: 20px; width: 100%; word-break: break-all;"> </div> </td> </tr> <tr style="height: 25px;" class=\'noprint\'> <td class="dvtCellLabel" align="right">
		Add Comment
	</td> <td width="100%" colspan="3" class="dvtCellInfo" align="left"> <div id="editarea_ModCommentsDetailViewBlockCommentWidget"> <textarea id="txtbox_ModCommentsDetailViewBlockCommentWidget" class="detailedViewTextBox" onFocus="this.className=\'detailedViewTextBoxOn\'" onBlur="this.className=\'detailedViewTextBox\'" cols="90" rows="8"></textarea> <br><a href="javascript:;" class="detailview_ajaxbutton ajax_save_detailview" onclick="ModCommentsCommon.addComment(\'ModCommentsDetailViewBlockCommentWidget\', \'74\');">Save</a> <a href="javascript:;" onclick="document.getElementById(\'txtbox_ModCommentsDetailViewBlockCommentWidget\').value=\'\';" class="detailview_ajaxbutton ajax_cancelsave_detailview">Clear</a> </div> </td> </tr> </table> </div>';
		$actual = executeBusinessAction('41x43063', '{"RECORD":"11x74"}', $current_user);
		$this->assertEquals($expected, $actual, 'BusinessAction');
	}

	/**
	 * Method testinvalidjsoncontext
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testinvalidjsoncontext() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALID_PARAMETER);
		executeBusinessAction('41x43061', '{wrong:json', $current_user);
	}

	/**
	 * Method testinvalidjsoncontextid
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testinvalidjsoncontextid() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALID_PARAMETER);
		executeBusinessAction('41x43061', '{"wrong":"json"}', $current_user);
	}

	/**
	 * Method testinvalidjsoncontextidinside
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testinvalidjsoncontextidinside() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALID_PARAMETER);
		executeBusinessAction('41x43061', '{"RECORD":"json"}', $current_user);
	}

	/**
	 * Method testinvalidID
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testinvalidID() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALID_PARAMETER);
		executeBusinessAction('41x43044', '{"RECORD":"notnumeric","MODE":"DETAILVIEW"}', $current_user);
	}

	/**
	 * Method testinvalidactiontype
	 * @test
	 * @expectedException WebServiceException
	 */
	public function testinvalidactiontype() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALID_PARAMETER);
		executeBusinessAction('41x43044', '{"RECORD":"11x74","MODE":"DETAILVIEW"}', $current_user);
	}
}
?>