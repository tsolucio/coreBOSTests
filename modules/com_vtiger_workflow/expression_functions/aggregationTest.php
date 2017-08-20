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
class workflowfunctionsaggregationTest extends PHPUnit_Framework_TestCase {

	/**
	 * Method testaggregationfunctions
	 * @test
	 */
	public function testaggregationfunctions() {
		global $adb, $current_user;
		$entityCache = new VTEntityCache($current_user);
		$entityData = $entityCache->forId('11x74');
		$actual = __cb_aggregation(array('sum','Invoice','hdnSubTotal','',$entityData));
		$this->assertEquals(3855.260000, $actual);
		$actual = __cb_aggregation(array('sum','Invoice','hdnGrandTotal','',$entityData));
		$this->assertEquals(4895.870000, $actual);
		////////////////
		$actual = __cb_aggregation(array('avg','Potentials','amount','',$entityData));
		$this->assertEquals(71117.0000000000, $actual,'avg');
		$actual = __cb_aggregation(array('std','Potentials','amount','',$entityData));
		$this->assertEquals(983, $actual,'std');
		////////////////
		$actual = __cb_aggregation(array('sum','Potentials','amount','[sales_stage,e,Closed Lost,or]',$entityData));
		$this->assertEquals(72100.000000, $actual);
		////////////////
		$actual = __cb_aggregation(array('sum','Potentials','amount','[amount,l,71000,or]',$entityData));
		$this->assertEquals(70134.000000, $actual);
		////////////////
		$actual = __cb_aggregation(array('sum','Potentials','amount','[amount,l,1000,or]',$entityData));
		$this->assertEquals(0, $actual,'no values');
		$actual = __cb_aggregation(array('sum','Potentials','amount','[amount,l,71000,or],[sales_stage,e,Closed Lost,or]',$entityData));
		$this->assertEquals(142234, $actual,'no values');
		////////////////
		$entityData = $entityCache->forId('13x5900'); // Egestas Aliquam Fringilla Corp potential
		$actual = __cb_aggregation(array('min','Potentials','amount','',$entityData));
		$this->assertEquals(370.000000, $actual);
		$actual = __cb_aggregation(array('max','Potentials','amount','[related_to,c,Chemex,or]',$entityData));
		$this->assertEquals(72100.000000, $actual);
		$actual = __cb_aggregation(array('max','Potentials','amount','[related_to,e,$(related_to : (Accounts) accountname),or]',$entityData));
		$this->assertEquals(72100.000000, $actual);
		////////////////
		$entityData = $entityCache->forId('29x4065'); // AST-000003 assets
		$actual = __cb_aggregation(array('sum','Potentials','amount','',$entityData));
		$this->assertEquals(0, $actual,' modules not related');
		$actual = __cb_aggregation(array('undefined','Potentials','amount','',$entityData));
		$this->assertEquals(0, $actual,'unknown operation');
		$actual = __cb_aggregation(array('sum','Potentials','inexistentfield','',$entityData));
		$this->assertEquals(0, $actual,'unknown field');
	}

}
?>