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
		$this->assertEquals('WebserviceField',  get_class($wsfield), 'Class instantiated correctly');
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

}
?>