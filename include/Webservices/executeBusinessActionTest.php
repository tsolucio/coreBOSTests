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

class executeBusinessActionTest extends TestCase {

	/**
	 * Method testBusinessAction
	 * @test
	 */
	public function testBusinessAction() {
		global $current_user;
		$expected = <<< MCHTML
<input type="hidden" id="comments_parentId" value="74" /> <div class="slds-section slds-is-open" style="margin-bottom: 0rem !important"> <h3 class="slds-section__title"> <button aria-expanded="true" class="slds-button slds-section__title-action" onclick="showHideStatus('tblModCommentsDetailViewBlockCommentWidget','aidModCommentsDetailViewBlockCommentWidget','\$IMAGE_PATH');"> <svg class="slds-section__title-action-icon slds-button__icon slds-button__icon_left" aria-hidden="true" id="svg_tblModCommentsDetailViewBlockCommentWidget_block"> <use xlink:href="include/LD/assets/icons/utility-sprite/svg/symbols.svg#switch"></use> </svg> <svg class="slds-section__title-action-icon slds-button__icon slds-button__icon_left" aria-hidden="true" id="svg_tblModCommentsDetailViewBlockCommentWidget_none" style="display: none"> <use xlink:href="include/LD/assets/icons/utility-sprite/svg/symbols.svg#chevronright"></use> </svg> <span class="slds-truncate" title="Comments Information"> <strong>Comments Information</strong> </span> </button> </h3> <span style="float: right;position:relative; left: -16px; top: -25px;">
			Show : <select class="small" onchange="ModCommentsCommon.reloadContentWithFiltering('DetailViewBlockCommentWidget', '74', this.value, 'tblModCommentsDetailViewBlockCommentWidget', 'indicatorModCommentsDetailViewBlockCommentWidget');"> <option value="All" selected>All</option> <option value="Last5" >Last 5</option> <option value="Mine" >Mine</option> </select> </span> </div> <div id="tblModCommentsDetailViewBlockCommentWidget" style="display: block;"> <table class="small" border="0" cellpadding="0" cellspacing="0" width="100%"> <tr style="height: 25px;"> <td colspan="4" align="left" class="dvtCellInfo commentCell"> <div id="contentwrap_ModCommentsDetailViewBlockCommentWidget" style="overflow: auto; margin-bottom: 20px; width: 100%; word-break: break-all;"> </div> </td> </tr> <tr style="height: 25px;" class='noprint'> <td class="dvtCellLabel" align="right">
			Add Comment
		</td> <td width="100%" colspan="3" class="dvtCellInfo" align="left"> <div id="editarea_ModCommentsDetailViewBlockCommentWidget"> <textarea id="txtbox_ModCommentsDetailViewBlockCommentWidget" class="detailedViewTextBox" onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'" cols="90" rows="8"></textarea> <br> <button class="slds-button slds-button_success" title="Save" onclick="ModCommentsCommon.addComment('ModCommentsDetailViewBlockCommentWidget', '74');" style="color:#ffffff;" > <svg class="slds-button__icon slds-button__icon_left" aria-hidden="true"> <use xlink:href="include/LD/assets/icons/utility-sprite/svg/symbols.svg#save"></use> </svg>
						Save
				</button> <button class="slds-button slds-button_neutral" title="Clear" onclick="document.getElementById('txtbox_ModCommentsDetailViewBlockCommentWidget').value='';" style="margin-left: 0;" > <svg class="slds-button__icon slds-button__icon_left" aria-hidden="true"> <use xlink:href="include/LD/assets/icons/utility-sprite/svg/symbols.svg#redo"></use> </svg>
						Clear
				</button> </div> </td> </tr> </table> </div>
MCHTML;
		$actual = executeBusinessAction('41x43063', '{"RECORD":"11x74","MODE":"DETAILVIEW"}', $current_user);
		$this->assertEquals($expected, $actual, 'BusinessAction');
		$expected = <<< MCHTML
<input type="hidden" id="comments_parentId" value="74" /> <div class="slds-section slds-is-open" style="margin-bottom: 0rem !important"> <h3 class="slds-section__title"> <button aria-expanded="true" class="slds-button slds-section__title-action" onclick="showHideStatus('tblModCommentsDetailViewBlockCommentWidget','aidModCommentsDetailViewBlockCommentWidget','\$IMAGE_PATH');"> <svg class="slds-section__title-action-icon slds-button__icon slds-button__icon_left" aria-hidden="true" id="svg_tblModCommentsDetailViewBlockCommentWidget_block"> <use xlink:href="include/LD/assets/icons/utility-sprite/svg/symbols.svg#switch"></use> </svg> <svg class="slds-section__title-action-icon slds-button__icon slds-button__icon_left" aria-hidden="true" id="svg_tblModCommentsDetailViewBlockCommentWidget_none" style="display: none"> <use xlink:href="include/LD/assets/icons/utility-sprite/svg/symbols.svg#chevronright"></use> </svg> <span class="slds-truncate" title="Comments Information"> <strong>Comments Information</strong> </span> </button> </h3> <span style="float: right;position:relative; left: -16px; top: -25px;">
			Show : <select class="small" onchange="ModCommentsCommon.reloadContentWithFiltering('DetailViewBlockCommentWidget', '74', this.value, 'tblModCommentsDetailViewBlockCommentWidget', 'indicatorModCommentsDetailViewBlockCommentWidget');"> <option value="All" selected>All</option> <option value="Last5" >Last 5</option> <option value="Mine" >Mine</option> </select> </span> </div> <div id="tblModCommentsDetailViewBlockCommentWidget" style="display: block;"> <table class="small" border="0" cellpadding="0" cellspacing="0" width="100%"> <tr style="height: 25px;"> <td colspan="4" align="left" class="dvtCellInfo commentCell"> <div id="contentwrap_ModCommentsDetailViewBlockCommentWidget" style="overflow: auto; margin-bottom: 20px; width: 100%; word-break: break-all;"> </div> </td> </tr> <tr style="height: 25px;" class='noprint'> <td class="dvtCellLabel" align="right">
			Add Comment
		</td> <td width="100%" colspan="3" class="dvtCellInfo" align="left"> <div id="editarea_ModCommentsDetailViewBlockCommentWidget"> <textarea id="txtbox_ModCommentsDetailViewBlockCommentWidget" class="detailedViewTextBox" onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'" cols="90" rows="8"></textarea> <br> <button class="slds-button slds-button_success" title="Save" onclick="ModCommentsCommon.addComment('ModCommentsDetailViewBlockCommentWidget', '74');" style="color:#ffffff;" > <svg class="slds-button__icon slds-button__icon_left" aria-hidden="true"> <use xlink:href="include/LD/assets/icons/utility-sprite/svg/symbols.svg#save"></use> </svg>
						Save
				</button> <button class="slds-button slds-button_neutral" title="Clear" onclick="document.getElementById('txtbox_ModCommentsDetailViewBlockCommentWidget').value='';" style="margin-left: 0;" > <svg class="slds-button__icon slds-button__icon_left" aria-hidden="true"> <use xlink:href="include/LD/assets/icons/utility-sprite/svg/symbols.svg#redo"></use> </svg>
						Clear
				</button> </div> </td> </tr> </table> </div>
MCHTML;
		$actual = executeBusinessAction('41x43063', '{"RECORD":"74","MODE":"DETAILVIEW"}', $current_user);
		$this->assertEquals($expected, $actual, 'BusinessAction');
		$expected = <<< MCHTML
<input type="hidden" id="comments_parentId" value="74" /> <div class="slds-section slds-is-open" style="margin-bottom: 0rem !important"> <h3 class="slds-section__title"> <button aria-expanded="true" class="slds-button slds-section__title-action" onclick="showHideStatus('tblModCommentsDetailViewBlockCommentWidget','aidModCommentsDetailViewBlockCommentWidget','\$IMAGE_PATH');"> <svg class="slds-section__title-action-icon slds-button__icon slds-button__icon_left" aria-hidden="true" id="svg_tblModCommentsDetailViewBlockCommentWidget_block"> <use xlink:href="include/LD/assets/icons/utility-sprite/svg/symbols.svg#switch"></use> </svg> <svg class="slds-section__title-action-icon slds-button__icon slds-button__icon_left" aria-hidden="true" id="svg_tblModCommentsDetailViewBlockCommentWidget_none" style="display: none"> <use xlink:href="include/LD/assets/icons/utility-sprite/svg/symbols.svg#chevronright"></use> </svg> <span class="slds-truncate" title="Comments Information"> <strong>Comments Information</strong> </span> </button> </h3> <span style="float: right;position:relative; left: -16px; top: -25px;">
			Show : <select class="small" onchange="ModCommentsCommon.reloadContentWithFiltering('DetailViewBlockCommentWidget', '74', this.value, 'tblModCommentsDetailViewBlockCommentWidget', 'indicatorModCommentsDetailViewBlockCommentWidget');"> <option value="All" selected>All</option> <option value="Last5" >Last 5</option> <option value="Mine" >Mine</option> </select> </span> </div> <div id="tblModCommentsDetailViewBlockCommentWidget" style="display: block;"> <table class="small" border="0" cellpadding="0" cellspacing="0" width="100%"> <tr style="height: 25px;"> <td colspan="4" align="left" class="dvtCellInfo commentCell"> <div id="contentwrap_ModCommentsDetailViewBlockCommentWidget" style="overflow: auto; margin-bottom: 20px; width: 100%; word-break: break-all;"> </div> </td> </tr> <tr style="height: 25px;" class='noprint'> <td class="dvtCellLabel" align="right">
			Add Comment
		</td> <td width="100%" colspan="3" class="dvtCellInfo" align="left"> <div id="editarea_ModCommentsDetailViewBlockCommentWidget"> <textarea id="txtbox_ModCommentsDetailViewBlockCommentWidget" class="detailedViewTextBox" onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'" cols="90" rows="8"></textarea> <br> <button class="slds-button slds-button_success" title="Save" onclick="ModCommentsCommon.addComment('ModCommentsDetailViewBlockCommentWidget', '74');" style="color:#ffffff;" > <svg class="slds-button__icon slds-button__icon_left" aria-hidden="true"> <use xlink:href="include/LD/assets/icons/utility-sprite/svg/symbols.svg#save"></use> </svg>
						Save
				</button> <button class="slds-button slds-button_neutral" title="Clear" onclick="document.getElementById('txtbox_ModCommentsDetailViewBlockCommentWidget').value='';" style="margin-left: 0;" > <svg class="slds-button__icon slds-button__icon_left" aria-hidden="true"> <use xlink:href="include/LD/assets/icons/utility-sprite/svg/symbols.svg#redo"></use> </svg>
						Clear
				</button> </div> </td> </tr> </table> </div>
MCHTML;
		$actual = executeBusinessAction('41x43063', '{"RECORD":"11x74"}', $current_user);
		$this->assertEquals($expected, $actual, 'BusinessAction');
	}

	/**
	 * Method testinvalidjsoncontext
	 * @test
	 */
	public function testinvalidjsoncontext() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALID_PARAMETER);
		executeBusinessAction('41x43061', '{wrong:json', $current_user);
	}

	/**
	 * Method testinvalidjsoncontextid
	 * @test
	 */
	public function testinvalidjsoncontextid() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALID_PARAMETER);
		executeBusinessAction('41x43061', '{"wrong":"json"}', $current_user);
	}

	/**
	 * Method testinvalidjsoncontextidinside
	 * @test
	 */
	public function testinvalidjsoncontextidinside() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALID_PARAMETER);
		executeBusinessAction('41x43061', '{"RECORD":"json"}', $current_user);
	}

	/**
	 * Method testinvalidID
	 * @test
	 */
	public function testinvalidID() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALID_PARAMETER);
		executeBusinessAction('41x43044', '{"RECORD":"notnumeric","MODE":"DETAILVIEW"}', $current_user);
	}

	/**
	 * Method testinvalidactiontype
	 * @test
	 */
	public function testinvalidactiontype() {
		global $current_user;
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode('INVALID_MODULE');
		$this->expectException(WebServiceException::class);
		$this->expectExceptionCode(WebServiceErrorCode::$INVALID_PARAMETER);
		executeBusinessAction('41x43044', '{"RECORD":"11x74","MODE":"DETAILVIEW"}', $current_user);
	}
}
?>