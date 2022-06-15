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

class WebserviceFieldTest extends TestCase {

	/**
	 * Method testsanitizeReferences
	 * @test
	 */
	public function testsanitizeReferences() {
		global $current_user, $adb, $log;
		$wsfield = WebserviceField::fromFieldId($adb, -1); // field does not exist
		$this->assertFalse($wsfield, 'field does not exist');
		$wsfield = WebserviceField::fromFieldId($adb, 113); // potential account/contact
		$this->assertEquals('WebserviceField', get_class($wsfield), 'Class instantiated correctly');
		$this->assertEquals('related_to', $wsfield->getFieldName(), 'potential: related_to field name');
		$this->assertTrue($wsfield->isReferenceField(), 'potential: related_to is reference');
		$this->assertTrue($wsfield->isActiveField(), 'potential: related_to is active');
		$this->assertFalse($wsfield->isOwnerField(), 'potential: related_to is not owner');
		$this->assertTrue($wsfield->isMassEditable(), 'potential: related_to is mass editable');
		$wsfield = WebserviceField::fromFieldId($adb, 119); // potential assigned to
		$this->assertEquals('assigned_user_id', $wsfield->getFieldName(), 'potential: assigned_user_id field name');
		$this->assertFalse($wsfield->isReferenceField(), 'potential: assigned_user_id is not reference');
		$this->assertTrue($wsfield->isActiveField(), 'potential: assigned_user_id is active');
		$this->assertTrue($wsfield->isOwnerField(), 'potential: assigned_user_id is owner');
		$this->assertTrue($wsfield->isMassEditable(), 'potential: assigned_user_id is mass editable');
	}

	/**
	 * Method testgetPickListOptions
	 * @test
	 */
	public function testgetPickListOptions() {
		global $current_user, $adb, $log;
		$wsfield = WebserviceField::fromFieldId($adb, 13); // account rating
		$this->assertEquals('WebserviceField', get_class($wsfield), 'Class instantiated correctly');
		$this->assertEquals('rating', $wsfield->getFieldName(), 'account: rating field name');
		$expected = array(
			0 => array(
				'label' => '--None--',
				'value' => '--None--',
				'tooltip' => '',
			),
			1 => array(
				'label' => 'Acquired',
				'value' => 'Acquired',
				'tooltip' => '',
			),
			2 => array(
				'label' => 'Active',
				'value' => 'Active',
				'tooltip' => '',
			),
			3 => array(
				'label' => 'Market Failed',
				'value' => 'Market Failed',
				'tooltip' => '',
			),
			4 => array(
				'label' => 'Project Cancelled',
				'value' => 'Project Cancelled',
				'tooltip' => '',
			),
			5 => array(
				'label' => 'Shutdown',
				'value' => 'Shutdown',
				'tooltip' => '',
			),
		);
		$this->assertEquals($expected, $wsfield->getPickListOptions(), 'account: rating values');
		///////////////
		$wsfield = WebserviceField::fromFieldId($adb, 130); // campaign status
		$expected = array(
			0 => array(
				'label' => '--None--',
				'value' => '--None--',
				'tooltip' => '',
			),
			1 => array(
				'label' => 'Planning',
				'value' => 'Planning',
				'tooltip' => '',
			),
			2 => array(
				'label' => 'Active',
				'value' => 'Active',
				'tooltip' => '',
			),
			3 => array(
				'label' => 'Inactive',
				'value' => 'Inactive',
				'tooltip' => '',
			),
			4 => array(
				'label' => 'Completed',
				'value' => 'Completed',
				'tooltip' => '',
			),
			5 => array(
				'label' => 'Cancelled',
				'value' => 'Cancelled',
				'tooltip' => '',
			),
		);
		$this->assertEquals($expected, $wsfield->getPickListOptions(), 'campaign: status values');
		///////////////
		$wsfield = WebserviceField::fromFieldId($adb, 152); // campaignrelstatus uitype 16
		$expected = array(
			0 => array(
				'label' => '--None--',
				'value' => '--None--',
				'tooltip' => '',
			),
			1 => array(
				'label' => 'Contacted - Successful',
				'value' => 'Contacted - Successful',
				'tooltip' => '',
			),
			2 => array(
				'label' => 'Contacted - Unsuccessful',
				'value' => 'Contacted - Unsuccessful',
				'tooltip' => '',
			),
			3 => array(
				'label' => 'Contacted - Never Contact Again',
				'value' => 'Contacted - Never Contact Again',
				'tooltip' => '',
			),
		);
		$this->assertEquals($expected, $wsfield->getPickListOptions(), 'campaignrelstatus uitype 16');
		///////////////
		$wsfield = WebserviceField::fromFieldId($adb, 434); // payment_duration uitype 16
		$expected = array(
			0 => array(
				'label' => 'Net 30 days',
				'value' => 'Net 30 days',
				'tooltip' => '',
			),
			1 => array(
				'label' => 'Net 45 days',
				'value' => 'Net 45 days',
				'tooltip' => '',
			),
			2 => array(
				'label' => 'Net 60 days',
				'value' => 'Net 60 days',
				'tooltip' => '',
			),
		);
		$this->assertEquals($expected, $wsfield->getPickListOptions(), 'payment_duration uitype 16');
	}
}
?>