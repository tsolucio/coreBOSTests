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
require_once("include/events/VTWSEntityType.inc");

use PHPUnit\Framework\TestCase;
class VTWSEntityTypeTest extends TestCase {

	/**
	 * Method testVTWSEntityType
	 * @test
	 */
	public function testVTWSEntityType() {
		global $current_user, $adb;
		$current_user = Users::getActiveAdminUser();
		$setype = 'Potentials';
		$et = new VTWSEntityType($setype,$current_user);
		$this->assertInstanceOf(VTWSEntityType::class,$et,"testConstruct class VTWSEntityType");
		$this->assertEquals($setype, $et->getModuleName(), 'ModuleName');
		$this->assertEquals(getTabid($setype), $et->getTabId(), 'tabid');
		$fieldnames = array(
			0 => 'potentialname',
			1 => 'potential_no',
			2 => 'related_to',
			3 => 'amount',
			4 => 'opportunity_type',
			5 => 'closingdate',
			6 => 'leadsource',
			7 => 'nextstep',
			8 => 'assigned_user_id',
			9 => 'sales_stage',
			10 => 'campaignid',
			11 => 'probability',
			12 => 'modifiedtime',
			13 => 'createdtime',
			14 => 'modifiedby',
			15 => 'forecast_amount',
			16 => 'email',
			17 => 'isconvertedfromlead',
			18 => 'convertedfromlead',
			19 => 'created_user_id',
			20 => 'description',
			21 => 'id',
		);
		$this->assertEquals($fieldnames, $et->getFieldNames(), 'FieldNames');
		$fieldtypes = array();
		$ftypes = $et->getFieldTypes();
		$this->assertInstanceOf(VTWSFieldType::class,$ftypes['potential_no'],"potential_no");
		$this->assertEquals($ftypes['potential_no']->type, $et->getFieldType('potential_no')->type, 'FieldType potential_no');
		$this->assertEquals('String', $et->getFieldType('potential_no')->type, 'FieldType potential_no');
		$this->assertEquals(array('type' => 'String'),(array)$ftypes['potential_no'],'FieldType ToArray');
		$this->assertInstanceOf(VTWSFieldType::class,$ftypes['amount'],"amount");
		$this->assertEquals($ftypes['amount']->type, $et->getFieldType('amount')->type, 'FieldType amount');
		$this->assertEquals('Number', $et->getFieldType('amount')->type, 'FieldType amount');
		$this->assertEquals('Decimal', $et->getFieldType('amount')->format, 'FieldType amount');
		$this->assertEquals(array('type' => 'Number','format'=>'Decimal'),(array)$ftypes['amount'],'FieldType ToArray');
		$flabels = $et->getFieldLabels();
		$fieldlabels = array(
			'potentialname' => 'Opportunity Name',
			'potential_no' => 'Opportunity No',
			'amount' => 'Amount',
			'related_to' => 'Related To',
			'closingdate' => 'Expected Close Date',
			'opportunity_type' => 'Type',
			'nextstep' => 'Next Step',
			'leadsource' => 'Lead Source',
			'sales_stage' => 'Sales Stage',
			'assigned_user_id' => 'Assigned To',
			'probability' => 'Probability',
			'campaignid' => 'Campaign Source',
			'createdtime' => 'Created Time',
			'modifiedtime' => 'Modified Time',
			'modifiedby' => 'Last Modified By',
			'forecast_amount' => 'Forecast Amount',
			'email' => 'Email',
			'isconvertedfromlead' => 'Is Converted From Lead',
			'convertedfromlead' => 'Converted From Lead',
			'created_user_id' => 'Created By',
			'description' => 'Description',
			'id' => 'potentialid',
		);
		$this->assertEquals($fieldlabels,$flabels,'FieldLabels EN');
		$this->assertEquals($fieldlabels['amount'],$et->getFieldLabel('amount'),'FieldLabel amount EN');
		$this->assertEquals($fieldlabels['leadsource'],$et->getFieldLabel('leadsource'),'FieldLabel leadsource EN');
// 		$user = new Users();
// 		$user->retrieveCurrentUserInfoFromFile(8); // testes ES
// 		$et = new VTWSEntityType($setype,$user);
// 		$flabels = $et->getFieldLabels();
// 		$fieldlabels = array(
// 			'potentialname' => 'Oportunidad',
// 			'potential_no' => 'Núm. Oportunidad',
// 			'amount' => 'Importe',
// 			'related_to' => 'Relacionado con',
// 			'closingdate' => 'Fecha estimada de cierre',
// 			'opportunity_type' => 'Tipo',
// 			'nextstep' => 'Siguiente Paso',
// 			'leadsource' => 'Origen del Pre-Contacto',
// 			'sales_stage' => 'Fase de Venta',
// 			'assigned_user_id' => 'Asignado a',
// 			'probability' => 'Probabilidad',
// 			'campaignid' => 'Campaña Origen',
// 			'createdtime' => 'Fecha de Creación',
// 			'modifiedtime' => 'Última Modificación',
// 			'modifiedby' => 'Last Modified By',
// 			'forecast_amount' => 'Forecast Amount',
// 			'email' => 'Email',
// 			'isconvertedfromlead' => 'Is Converted From Lead',
// 			'convertedfromlead' => 'Converted From Lead',
// 			'created_user_id' => 'Created By',
// 			'description' => 'Descripción',
// 			'id' => 'potentialid',
// 		);
// 		$this->assertEquals($fieldlabels,$flabels,'FieldLabels ES');
// 		$this->assertEquals($fieldlabels['amount'],$et->getFieldLabel('amount'),'FieldLabel amount ES');
// 		$this->assertEquals($fieldlabels['leadsource'],$et->getFieldLabel('leadsource'),'FieldLabel leadsource ES');
	}

}
?>