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

class workflowfunctionsaggregationTest extends TestCase {

	/**
	 * Method testaggregationfunctions
	 * @test
	 */
	public function testaggregationfunctions() {
		global $current_user, $currentModule;
		$holdModule = $currentModule;
		$currentModule = 'Invoice';
		$entityCache = new VTEntityCache($current_user);
		$entityData = $entityCache->forId('11x74');
		$actual = __cb_aggregation(array('sum','Quotes','hdnSubTotal','[cf_747,y,,or]',$entityData));
		$this->assertEquals(3854.100000, $actual);
		$actual = __cb_aggregation(array('sum','Quotes','hdnSubTotal','',$entityData));
		$this->assertEquals(3854.100000, $actual);
		$actual = __cb_aggregation(array('sum','Invoice','hdnSubTotal','',$entityData));
		$this->assertEquals(3854.100000, $actual);
		$actual = __cb_aggregation(array('sum','Invoice','hdnGrandTotal','',$entityData));
		$this->assertEquals(4894.710000, $actual);
		$actual = __cb_aggregation(array('sum','Invoice','sum_nettotal','',$entityData));
		$this->assertEquals(3854.100000, $actual);
		////////////////
		$actual = __cb_aggregation(array('avg','Potentials','amount','',$entityData));
		$this->assertEquals(71117.0000000000, $actual, 'avg');
		$actual = __cb_aggregation(array('std','Potentials','amount','',$entityData));
		$this->assertEquals(983, $actual, 'std');
		////////////////
		$actual = __cb_aggregation(array('sum','Potentials','amount','[sales_stage,e,Closed Lost,or]',$entityData));
		$this->assertEquals(72100.000000, $actual);
		////////////////
		$actual = __cb_aggregation(array('sum','Potentials','amount','[amount,l,71000,or]',$entityData));
		$this->assertEquals(70134.000000, $actual);
		////////////////
		$actual = __cb_aggregation(array('sum','Potentials','amount','[amount,l,1000,or]',$entityData));
		$this->assertEquals(0, $actual, 'no values');
		$actual = __cb_aggregation(array('sum','Potentials','amount','[amount,l,71000,or],[sales_stage,e,Closed Lost,or]',$entityData));
		$this->assertEquals(142234, $actual, 'no values');
		////////////////
		$entityData = $entityCache->forId('7x3076'); // Invoice
		$actual = __cb_aggregation(array('sum','CobroPago','amount','',$entityData));
		$this->assertEquals(1601, $actual, 'CyP Invoice');
		$actual = __cb_aggregation(array('sum','CobroPago','amount','[paymentmode,e,Transfer,or]',$entityData));
		$this->assertEquals(383, $actual, 'CyP Invoice condition on CyP');
		// $actual = __cb_aggregation(array('sum','CobroPago','amount','[cf_1069,e,$invoice_no,or]',$entityData));
		// $this->assertEquals(383, $actual, 'CyP Invoice condition on Invoice');
		////////////////
		$entityData = $entityCache->forId('11x2005');
		$actual = __cb_aggregation(array('sum','Potentials','amount','[sales_stage,e,Closed Lost,or]',$entityData));
		$this->assertEquals(105176.000000, $actual);
		$actual = __cb_aggregation(array('sum','Potentials','amount','[amount,l,1000,or]',$entityData));
		$this->assertEquals(0, $actual, 'no values');
		$actual = __cb_aggregation(array('sum','Potentials','amount','[amount,l,71000,or],[sales_stage,e,Closed Lost,or]',$entityData));
		$this->assertEquals(126455.000000, $actual, 'no values');
		$actual = __cb_aggregation(array('sum','Potentials','amount','[isconvertedfromlead,e,1,or]',$entityData));
		$this->assertEquals(39120.000000, $actual, 'no values');
		////////////////
		$currentModule = 'Potentials';
		$entityData = $entityCache->forId('13x5358'); // N Amercn Min & Quar Equip Inc
		$actual = __cb_aggregation(array('sum','Potentials','amount','[related_to,e,$(related_to : (Accounts) accountname),or]',$entityData));
		$this->assertEquals(126455.000000, $actual, 'no values');
		$actual = __cb_aggregation(array('sum','Potentials','amount','[isconvertedfromlead,e,1,and],[related_to,e,$(related_to : (Accounts) accountname),and]',$entityData));
		$this->assertEquals(39120.000000, $actual, 'no values');
		$actual = __cb_aggregation(array('sum','Potentials','amount','[isconvertedfromlead,e,0,and],[related_to,e,$(related_to : (Accounts) accountname),and]',$entityData));
		$this->assertEquals(87335.000000, $actual, 'no values');
		$actual = __cb_aggregation(array('sum','Potentials','amount','[isconvertedfromlead,e,1,and],[related_to,e,$(related_to : (Accounts) accountname),or]',$entityData));
		$this->assertEquals(39120.000000, $actual, 'no values');
		$actual = __cb_aggregation(array('sum','Potentials','amount','[isconvertedfromlead,e,0,and],[related_to,e,$(related_to : (Accounts) accountname),or]',$entityData));
		$this->assertEquals(87335.000000, $actual, 'no values');
		////////////////
		$currentModule = 'SalesOrder';
		$entityData = $entityCache->forId('6x11424'); // Sales Order
		$actual = __cb_aggregation(array('sum','Invoice','hdnSubTotal','',$entityData));
		$this->assertEquals(9030.970000, $actual);
		$actual = __cb_aggregation(array('sum','Invoice','hdnGrandTotal','',$entityData));
		$this->assertEquals(11469.330000, $actual);
		$actual = __cb_aggregation(array('sum','Invoice','sum_nettotal','',$entityData));
		$this->assertEquals(9030.970000, $actual);
		$actual = __cb_aggregation(array('group_concat','Invoice','subject','',$entityData));
		$this->assertEquals('Sean Cassidy,Garth (Other Realm)', $actual);
		$actual = __cb_aggregation(array('group_concat','Invoice','subject separator ";"','',$entityData));
		$this->assertEquals('Sean Cassidy;Garth (Other Realm)', $actual);
		////////////////
		$currentModule = 'Potentials';
		$entityData = $entityCache->forId('13x5900'); // Egestas Aliquam Fringilla Corp potential
		$actual = __cb_aggregation(array('group_concat','Contacts','firstname','',$entityData));
		$this->assertEquals(0, $actual);
		$actual = __cb_aggregation(array('min','Potentials','amount','',$entityData));
		$this->assertEquals(370.000000, $actual);
		$actual = __cb_aggregation(array('max','Potentials','amount','[related_to,c,Chemex,or]',$entityData));
		$this->assertEquals(72100.000000, $actual);
		$actual = __cb_aggregation(array('max','Potentials','amount','[related_to,e,$(related_to : (Accounts) accountname),or]',$entityData));
		$this->assertEquals(72100.000000, $actual);
		////////////////
		$entityData = $entityCache->forId('29x4065'); // AST-000003 assets
		$actual = __cb_aggregation(array('sum','Potentials','amount','',$entityData));
		$this->assertEquals(0, $actual, ' modules not related');
		$actual = __cb_aggregation(array('undefined','Potentials','amount','',$entityData));
		$this->assertEquals(0, $actual, 'unknown operation');
		$actual = __cb_aggregation(array('sum','Potentials','inexistentfield','',$entityData));
		$this->assertEquals(0, $actual, 'unknown field');
		$currentModule = $holdModule;
	}

	/**
	 * Method testaggregationQuery
	 * @test
	 */
	public function testaggregationQuery() {
		global $current_user, $currentModule;
		$holdModule = $currentModule;
		$entityCache = new VTEntityCache($current_user);
		$currentModule = 'Accounts';
		$entityData = $entityCache->forId('11x2005');
		$actual = __cb_aggregation_getQuery(array('sum','Potentials','amount','',$entityData));
		$expected = 'select sum(amount) as aggop  FROM vtiger_potential INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_potential.potentialid INNER JOIN vtiger_potentialscf ON vtiger_potentialscf.potentialid = vtiger_potential.potentialid INNER JOIN vtiger_account ON (vtiger_account.accountid = vtiger_potential.related_to) LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid WHERE vtiger_crmentity.deleted=0 AND vtiger_account.accountid = 2005';
		$this->assertEquals($expected, $actual);
		$actual = __cb_aggregation_getQuery(array('sum','Potentials','vtiger_potential.amount','[amount,l,1000,or]',$entityData));
		$expected = 'select sum(vtiger_potential.amount) as aggop  FROM vtiger_potential INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_potential.potentialid INNER JOIN vtiger_potentialscf ON vtiger_potentialscf.potentialid = vtiger_potential.potentialid INNER JOIN vtiger_account ON (vtiger_account.accountid = vtiger_potential.related_to) LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid WHERE vtiger_crmentity.deleted=0 AND vtiger_account.accountid = 2005 and (vtiger_crmentity.deleted=0 AND   (( vtiger_potential.amount < 1000) ) AND vtiger_potential.potentialid > 0)';
		$this->assertEquals($expected, $actual);
		$actual = __cb_aggregation_getQuery(array('sum','Potentials','amount','[amount,l,1000,and]',$entityData));
		$expected = 'select sum(amount) as aggop  FROM vtiger_potential INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_potential.potentialid INNER JOIN vtiger_potentialscf ON vtiger_potentialscf.potentialid = vtiger_potential.potentialid INNER JOIN vtiger_account ON (vtiger_account.accountid = vtiger_potential.related_to) LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid WHERE vtiger_crmentity.deleted=0 AND vtiger_account.accountid = 2005 and (vtiger_crmentity.deleted=0 AND   (( vtiger_potential.amount < 1000) ) AND vtiger_potential.potentialid > 0)';
		$this->assertEquals($expected, $actual);
		$actual = __cb_aggregation_getQuery(array('sum','Potentials','vtiger_potential.amount','[amount,l,71000,or],[amount,e,10,or]',$entityData));
		$expected = 'select sum(vtiger_potential.amount) as aggop  FROM vtiger_potential INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_potential.potentialid INNER JOIN vtiger_potentialscf ON vtiger_potentialscf.potentialid = vtiger_potential.potentialid INNER JOIN vtiger_account ON (vtiger_account.accountid = vtiger_potential.related_to) LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid WHERE vtiger_crmentity.deleted=0 AND vtiger_account.accountid = 2005 and (vtiger_crmentity.deleted=0 AND   (( vtiger_potential.amount < 71000)  or ( vtiger_potential.amount = 10) ) AND vtiger_potential.potentialid > 0)';
		$this->assertEquals($expected, $actual);
		$actual = __cb_aggregation_getQuery(array('sum','Potentials','amount','[amount,l,71000,and],[amount,e,10,or]',$entityData));
		$expected = 'select sum(amount) as aggop  FROM vtiger_potential INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_potential.potentialid INNER JOIN vtiger_potentialscf ON vtiger_potentialscf.potentialid = vtiger_potential.potentialid INNER JOIN vtiger_account ON (vtiger_account.accountid = vtiger_potential.related_to) LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid WHERE vtiger_crmentity.deleted=0 AND vtiger_account.accountid = 2005 and (vtiger_crmentity.deleted=0 AND   (( vtiger_potential.amount < 71000)  or ( vtiger_potential.amount = 10) ) AND vtiger_potential.potentialid > 0)';
		$this->assertEquals($expected, $actual);
		$actual = __cb_aggregation_getQuery(array('sum','Potentials','vtiger_potential.amount','[amount,l,71000,or],[amount,e,10,and]',$entityData));
		$expected = 'select sum(vtiger_potential.amount) as aggop  FROM vtiger_potential INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_potential.potentialid INNER JOIN vtiger_potentialscf ON vtiger_potentialscf.potentialid = vtiger_potential.potentialid INNER JOIN vtiger_account ON (vtiger_account.accountid = vtiger_potential.related_to) LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid WHERE vtiger_crmentity.deleted=0 AND vtiger_account.accountid = 2005 and (vtiger_crmentity.deleted=0 AND   (( vtiger_potential.amount < 71000)  and ( vtiger_potential.amount = 10) ) AND vtiger_potential.potentialid > 0)';
		$this->assertEquals($expected, $actual);
		$actual = __cb_aggregation_getQuery(array('sum','Potentials','amount','[amount,l,71000,and],[amount,e,10,and]',$entityData));
		$expected = 'select sum(amount) as aggop  FROM vtiger_potential INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_potential.potentialid INNER JOIN vtiger_potentialscf ON vtiger_potentialscf.potentialid = vtiger_potential.potentialid INNER JOIN vtiger_account ON (vtiger_account.accountid = vtiger_potential.related_to) LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid WHERE vtiger_crmentity.deleted=0 AND vtiger_account.accountid = 2005 and (vtiger_crmentity.deleted=0 AND   (( vtiger_potential.amount < 71000)  and ( vtiger_potential.amount = 10) ) AND vtiger_potential.potentialid > 0)';
		$this->assertEquals($expected, $actual);
		$currentModule = $holdModule;
	}
}
?>