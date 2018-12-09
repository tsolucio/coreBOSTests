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
use PHPUnit\Framework\TestCase;

include_once 'include/Webservices/Create.php';
include_once 'include/Webservices/Delete.php';

class VTExpressionEvaluaterTest extends TestCase {

	/**
	 * Method testFunctions
	 * @test
	 */
	public function testFunctions() {
		$adminUser = Users::getActiveAdminUser();
		$entityId = '11x74'; // employees = 131
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$testexpression = 'add_days(cf_722, (cf_719*7))';
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => cf_722
    [type] => string
)
',
			1 => 'VTExpressionSymbol Object
(
    [value] => cf_719
    [type] => string
)
',
			2 => '7',
			3 => 'Array
(
    [0] => 2.00
    [1] => 7
)
',
			4 => 'Array
(
    [0] => 2016-02-15
    [1] => 14
)
',
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('2016-02-29', $exprEvaluation);
		/////////////////////////
		$testexpression = 'add_days(14)';
		$expectedresult = array(
			0 => '14',
			1 => 'Array
(
    [0] => 14
)
',
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$expecteddate = date('Y-m-d',mktime(0,0,0,date('m'),date('d') + 14,date('Y')));
		$this->assertEquals($expecteddate, $exprEvaluation);
		/////////////////////////
		$testexpression = "get_date('today')";
		$expectedresult = array(
			0 => 'today',
			1 => 'Array
(
    [0] => today
)
',
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$expecteddate = date('Y-m-d');
		$this->assertEquals($expecteddate, $exprEvaluation);
		/////////////////////////
		$testexpression = "add_days(get_date('today'), 7)";
		$expectedresult = array(
			0 => 'today',
			1 => 'Array
(
    [0] => today
)
',
			2 => '7',
			3 => 'Array
(
    [0] => '.date('Y-m-d').'
    [1] => 7
)
'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$expecteddate = date('Y-m-d',mktime(0,0,0,date('m'),date('d') + 7,date('Y')));
		$this->assertEquals($expecteddate, $exprEvaluation);
		/////////////////////////
		$testexpression = "uppercase('today')";
		$expectedresult = array(
			0 => 'today',
			1 => 'Array
(
    [0] => today
)
',
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('TODAY', $exprEvaluation);
		/////////////////////////
		$testexpression = "concat('fixed', accountname, format_date(sub_days(cf_722, 30),'m'),'-',format_date(add_days(cf_722, 30),'m'))";
		$expectedresult = array(
			0 => 'fixed',
			1 => 'VTExpressionSymbol Object
(
    [value] => accountname
    [type] => string
)
',
			2 => 'VTExpressionSymbol Object
(
    [value] => cf_722
    [type] => string
)
',
			3 => '30',
			4 => 'Array
(
    [0] => 2016-02-15
    [1] => 30
)
',
			5 => 'm',
			6 => 'Array
(
    [0] => 2016-01-16
    [1] => m
)
',
			7 => '-',
			8 => 'VTExpressionSymbol Object
(
    [value] => cf_722
    [type] => string
)
',
			9 => '30',
			10=> 'Array
(
    [0] => 2016-02-15
    [1] => 30
)
',
			11 => 'm',
			12 => 'Array
(
    [0] => 2016-03-16
    [1] => m
)
',
			13 => 'Array
(
    [0] => fixed
    [1] => Chemex Labs Ltd
    [2] => 01
    [3] => -
    [4] => 03
)
'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('fixedChemex Labs Ltd01-03', $exprEvaluation);
		/////////////////////////
		$testexpression = "concat('fixed', accountname, $(assigned_user_id : (Users) email1))";
		$expectedresult = array(
			0 => 'fixed',
			1 => 'VTExpressionSymbol Object
(
    [value] => accountname
    [type] => string
)
',
			2 => 'VTExpressionSymbol Object
(
    [value] => $(assigned_user_id : (Users) email1)
    [type] => string
)
',
			3 => 'Array
(
    [0] => fixed
    [1] => Chemex Labs Ltd
    [2] => noreply@tsolucio.com
)
'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('fixedChemex Labs Ltdnoreply@tsolucio.com', $exprEvaluation);
		/////////////////////////
		$testexpression = "coalesce('fixed', tickersymbol, $(assigned_user_id : (Users) email1))";
		$expectedresult = array(
			0 => 'fixed',
			1 => 'VTExpressionSymbol Object
(
    [value] => tickersymbol
    [type] => string
)
',
			2 => 'VTExpressionSymbol Object
(
    [value] => $(assigned_user_id : (Users) email1)
    [type] => string
)
',
			3 => 'Array
(
    [0] => fixed
    [1] => 
    [2] => noreply@tsolucio.com
)
'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('fixed', $exprEvaluation);
		/////////////////////////
		$testexpression = "coalesce(tickersymbol, $(assigned_user_id : (Users) email1))";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => tickersymbol
    [type] => string
)
',
			1 => 'VTExpressionSymbol Object
(
    [value] => $(assigned_user_id : (Users) email1)
    [type] => string
)
',
			2 => 'Array
(
    [0] => 
    [1] => noreply@tsolucio.com
)
'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('noreply@tsolucio.com', $exprEvaluation);
		/////////////////////////
		$testexpression = "coalesce(tickersymbol, employees)";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => tickersymbol
    [type] => string
)
',
			1 => 'VTExpressionSymbol Object
(
    [value] => employees
    [type] => string
)
',
			2 => 'Array
(
    [0] => 
    [1] => 131
)
'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('131', $exprEvaluation);
		/////////////////////////
		$entityId = '28x14335'; // Payment
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$testexpression = "get_nextdate(duedate , $(parent_id : (Accounts) cf_719),' ',1)";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => duedate
    [type] => string
)
',
			1 => 'VTExpressionSymbol Object
(
    [value] => $(parent_id : (Accounts) cf_719)
    [type] => string
)
',
			2 => ' ',
			3 => '1',
			4 => 'Array
(
    [0] => 2016-05-22
    [1] => 2,00000
    [2] =>  
    [3] => 1
)
'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('2016-06-02', $exprEvaluation);
		/////////////////////////
		$testexpression = "get_nextdate(duedate , $(parent_id : (Accounts) cf_719),'',1)";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => duedate
    [type] => string
)
',
			1 => 'VTExpressionSymbol Object
(
    [value] => $(parent_id : (Accounts) cf_719)
    [type] => string
)
',
			2 => '',
			3 => '1',
			4 => 'Array
(
    [0] => 2016-05-22
    [1] => 2,00000
    [2] => 
    [3] => 1
)
'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('2016-06-02', $exprEvaluation);
		/////////////////////////
		$entityId = '11x74'; // Account
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$testexpression = "stringposition(cf_732, ' |##| ')";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => cf_732
    [type] => string
)
',
			1 => ' |##| ',
			2 => 'Array
(
    [0] => Adipose 3 |##| Chronos |##| Earth
    [1] =>  |##| 
)
'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals(9, $exprEvaluation);
		/////////////////////////
		$entityId = '11x74'; // Account
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$testexpression = "stringreplace(' |##| ', ', ',cf_732 )";
		$expectedresult = array(
			0 => ' |##| ',
			1 => ', ',
			2 => 'VTExpressionSymbol Object
(
    [value] => cf_732
    [type] => string
)
',
			3 => 'Array
(
    [0] =>  |##| 
    [1] => , 
    [2] => Adipose 3 |##| Chronos |##| Earth
)
'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('Adipose 3, Chronos, Earth', $exprEvaluation);
		/////////////////////////
		$entityId = '11x74'; // Account
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$testexpression = "translate('LBL_LAST_VIEWED')";
$expectedresult = array(
    0 => 'LBL_LAST_VIEWED',
    1 => 'Array
(
    [0] => LBL_LAST_VIEWED
)
',
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('Last Viewed', $exprEvaluation);
		/////////////////////////
		$entityId = '11x74'; // Account
		global $current_language, $current_user;
		$holdlang = $current_language;
		$current_language = 'es_es';
		$cbtr = array(
			'locale' => 'es_es',
			'translation_module' => 'cbtranslation',
			'translation_key' => 'June',
			'i18n' => 'Junio',
			'assigned_user_id' => vtws_getEntityId('Users').'x'.$current_user->id,
		);
		$trinfo = vtws_create('cbtranslation', $cbtr, $current_user);
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$testexpression = "translate(format_date('2017-06-20','F'))";
		$expectedresult = array(
			0 => '2017-06-20',
			1 => 'F',
			2 => 'Array
(
    [0] => 2017-06-20
    [1] => F
)
',
			3 => 'Array
(
    [0] => June
)
'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('Junio', $exprEvaluation);
		vtws_delete($trinfo['id'], $current_user);
		$current_language = $holdlang;
	}

	/**
	 * Method testFields
	 * @test
	 */
	public function testFields() {
		$adminUser = Users::getActiveAdminUser();
		$entityId = '11x74'; // employees = 131
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$testexpression = "accountname";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => accountname
    [type] => string
)
',
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('Chemex Labs Ltd', $exprEvaluation);
		/////////////////////////
		$testexpression = "fieldthatdoesnotexist";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => fieldthatdoesnotexist
    [type] => string
)
',
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('', $exprEvaluation);
		/////////////////////////
		$testexpression = "$(assigned_user_id : (Users) email1)";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => $(assigned_user_id : (Users) email1)
    [type] => string
)
',
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('noreply@tsolucio.com', $exprEvaluation);
	}

	/**
	 * Method testOperations
	 * @test
	 */
	public function testOperations() {
		$adminUser = Users::getActiveAdminUser();
		$entityId = '11x74'; // employees = 131
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$testexpression = "employees + 1";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => employees
    [type] => string
)
',
			1 => '1',
			2 => 'Array
(
    [0] => 131
    [1] => 1
)
'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals(132, $exprEvaluation);
		/////////////////////////
		$testexpression = "1 - employees";
		$expectedresult = array(
			0 => '1',
			1 => 'VTExpressionSymbol Object
(
    [value] => employees
    [type] => string
)
',
			2 => 'Array
(
    [0] => 1
    [1] => 131
)
'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals(-130, $exprEvaluation);
		/////////////////////////
		$testexpression = "cf_719 + (employees * 0.9)";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => cf_719
    [type] => string
)
',
			1 => 'VTExpressionSymbol Object
(
    [value] => employees
    [type] => string
)
',
			2 => '0.9',
			3 => 'Array
(
    [0] => 131
    [1] => 0.9
)
',
			4 => 'Array
(
    [0] => 2.00
    [1] => 117.9
)
'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals(119.9, $exprEvaluation);

		$entityId = '11x74'; // employees = 131
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$testexpression = "employees * 0.5";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => employees
    [type] => string
)
',
			1 => '0.5',
			2 => 'Array
(
    [0] => 131
    [1] => 0.5
)
'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals(65.5, $exprEvaluation);

		$entityId = '11x74'; // employees = 131
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$testexpression = "employees * .5";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => employees
    [type] => string
)
',
			1 => '0.5',
			2 => 'Array
(
    [0] => 131
    [1] => 0.5
)
'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals(65.5, $exprEvaluation);
	}

	/**
	 * Method testIFFieldvsValue
	 * @test
	 */
	public function testIFFieldvsValue() {
		$adminUser = Users::getActiveAdminUser();
		$entityId = '11x74'; // employees = 131
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$testexpression = 'if employees != 13 then 0 else 1 end';
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => employees
    [type] => string
)
',
			1 => '13',
			2 => 'Array
(
    [0] => 131
    [1] => 13
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => !=
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => employees
                            [type] => string
                        )

                    [2] => 13
                )

        )

    [1] => 0
    [2] => 1
)
',
			4 => true,
			5 => '0'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals(0, $exprEvaluation);
		/////////////////////////
		// Now we turn it around
		$testexpression = 'if 13 != employees then 0 else 1 end';
		$expectedresult = array(
			0 => '13',
			1 => 'VTExpressionSymbol Object
(
    [value] => employees
    [type] => string
)
',
			2 => 'Array
(
    [0] => 13
    [1] => 131
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => !=
                            [type] => string
                        )

                    [1] => 13
                    [2] => VTExpressionSymbol Object
                        (
                            [value] => employees
                            [type] => string
                        )

                )

        )

    [1] => 0
    [2] => 1
)
',
			4 => true,
			5 => '0'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals(0, $exprEvaluation);
		/////////////////////////
		// Now we test string return value
		$testexpression = "if 13 != employees then 'then' else 'else' end";
		$expectedresult = array(
			0 => '13',
			1 => 'VTExpressionSymbol Object
(
    [value] => employees
    [type] => string
)
',
			2 => 'Array
(
    [0] => 13
    [1] => 131
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => !=
                            [type] => string
                        )

                    [1] => 13
                    [2] => VTExpressionSymbol Object
                        (
                            [value] => employees
                            [type] => string
                        )

                )

        )

    [1] => then
    [2] => else
)
',
			4 => true,
			5 => 'then'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('then', $exprEvaluation);
		/////////////////////////
		// operator
		$testexpression = "if 13 &lt; employees then 'then' else 'else' end";
		$expectedresult = array(
			0 => '13',
			1 => 'VTExpressionSymbol Object
(
    [value] => employees
    [type] => string
)
',
			2 => 'Array
(
    [0] => 13
    [1] => 131
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => <
                            [type] => string
                        )

                    [1] => 13
                    [2] => VTExpressionSymbol Object
                        (
                            [value] => employees
                            [type] => string
                        )

                )

        )

    [1] => then
    [2] => else
)
',
			4 => true,
			5 => 'then'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('then', $exprEvaluation);
		/////////////////////////
		// operator
		$testexpression = "if 13 &gt; employees then 'then' else 'else' end";
		$expectedresult = array(
			0 => '13',
			1 => 'VTExpressionSymbol Object
(
    [value] => employees
    [type] => string
)
',
			2 => 'Array
(
    [0] => 13
    [1] => 131
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => >
                            [type] => string
                        )

                    [1] => 13
                    [2] => VTExpressionSymbol Object
                        (
                            [value] => employees
                            [type] => string
                        )

                )

        )

    [1] => then
    [2] => else
)
',
			4 => false,
			5 => 'else'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('else', $exprEvaluation);
		/////////////////////////
		// operator
		$testexpression = "if 13 &lt;= employees then 'then' else 'else' end";
		$expectedresult = array(
			0 => '13',
			1 => 'VTExpressionSymbol Object
(
    [value] => employees
    [type] => string
)
',
			2 => 'Array
(
    [0] => 13
    [1] => 131
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => <=
                            [type] => string
                        )

                    [1] => 13
                    [2] => VTExpressionSymbol Object
                        (
                            [value] => employees
                            [type] => string
                        )

                )

        )

    [1] => then
    [2] => else
)
',
			4 => true,
			5 => 'then'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('then', $exprEvaluation);
		/////////////////////////
		// operator
		$testexpression = "if $(assigned_user_id : (Users) email1) == 'noreply@tsolucio.com' then 'then' else 'else' end";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => $(assigned_user_id : (Users) email1)
    [type] => string
)
',
			1 => 'noreply@tsolucio.com',
			2 => 'Array
(
    [0] => noreply@tsolucio.com
    [1] => noreply@tsolucio.com
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => ==
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => $(assigned_user_id : (Users) email1)
                            [type] => string
                        )

                    [2] => noreply@tsolucio.com
                )

        )

    [1] => then
    [2] => else
)
',
			4 => true,
			5 => 'then'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('then', $exprEvaluation);
		/////////////////////////
		// operator
		$testexpression = "if 'notthesame' == $(assigned_user_id : (Users) email1) then 'then' else 'else' end";
		$expectedresult = array(
			0 => 'notthesame',
			1 => 'VTExpressionSymbol Object
(
    [value] => $(assigned_user_id : (Users) email1)
    [type] => string
)
',
			2 => 'Array
(
    [0] => notthesame
    [1] => noreply@tsolucio.com
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => ==
                            [type] => string
                        )

                    [1] => notthesame
                    [2] => VTExpressionSymbol Object
                        (
                            [value] => $(assigned_user_id : (Users) email1)
                            [type] => string
                        )

                )

        )

    [1] => then
    [2] => else
)
',
			4 => false,
			5 => 'else'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('else', $exprEvaluation);
	}

	/**
	 * Method testIFReturnFields
	 * @test
	 */
	public function testIFReturnFields() {
		$adminUser = Users::getActiveAdminUser();
		$entityId = '11x74'; // employees = 131
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$testexpression = 'if employees != 13 then employees else accountname end';
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => employees
    [type] => string
)
',
			1 => '13',
			2 => 'Array
(
    [0] => 131
    [1] => 13
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => !=
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => employees
                            [type] => string
                        )

                    [2] => 13
                )

        )

    [1] => VTExpressionSymbol Object
        (
            [value] => employees
            [type] => string
        )

    [2] => VTExpressionSymbol Object
        (
            [value] => accountname
            [type] => string
        )

)
',
			4 => true,
			5 => 'VTExpressionSymbol Object
(
    [value] => employees
    [type] => string
)
'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals(131, $exprEvaluation);
		//////////////////////////////
		$testexpression = 'if employees &lt;= 13 then employees else accountname end';
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => employees
    [type] => string
)
',
			1 => '13',
			2 => 'Array
(
    [0] => 131
    [1] => 13
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => <=
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => employees
                            [type] => string
                        )

                    [2] => 13
                )

        )

    [1] => VTExpressionSymbol Object
        (
            [value] => employees
            [type] => string
        )

    [2] => VTExpressionSymbol Object
        (
            [value] => accountname
            [type] => string
        )

)
',
			4 => false,
			5 => 'VTExpressionSymbol Object
(
    [value] => accountname
    [type] => string
)
'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('Chemex Labs Ltd', $exprEvaluation);
		/////////////////////////
		$testexpression = "if accountname == '' then 0 else 1 end";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => accountname
    [type] => string
)
',
			1 => '',
			2 => 'Array
(
    [0] => Chemex Labs Ltd
    [1] => 
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => ==
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => accountname
                            [type] => string
                        )

                    [2] => 
                )

        )

    [1] => 0
    [2] => 1
)
',
			4 => false,
			5 => '1'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals(1, $exprEvaluation);
	}

	/**
	 * Method testIFReturnFunctions
	 * @test
	 */
	public function testIFReturnFunctions() {
		$adminUser = Users::getActiveAdminUser();
		$entityId = '11x74'; // employees = 131
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$testexpression = 'if employees != 13 then add_days(cf_722,3) else sub_days(cf_722,3) end';
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => employees
    [type] => string
)
',
			1 => '13',
			2 => 'Array
(
    [0] => 131
    [1] => 13
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => !=
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => employees
                            [type] => string
                        )

                    [2] => 13
                )

        )

    [1] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => add_days
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => cf_722
                            [type] => string
                        )

                    [2] => 3
                )

        )

    [2] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => sub_days
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => cf_722
                            [type] => string
                        )

                    [2] => 3
                )

        )

)
',
			4 => true,
			5 => 'VTExpressionSymbol Object
(
    [value] => cf_722
    [type] => string
)
',
			6 => '3',
			7 => 'Array
(
    [0] => 2016-02-15
    [1] => 3
)
'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('2016-02-18', $exprEvaluation);
		//////////////////////////////
		$testexpression = 'if employees &lt;= 13 then add_days(cf_722,3) else sub_days(cf_722,3) end';
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => employees
    [type] => string
)
',
			1 => '13',
			2 => 'Array
(
    [0] => 131
    [1] => 13
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => <=
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => employees
                            [type] => string
                        )

                    [2] => 13
                )

        )

    [1] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => add_days
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => cf_722
                            [type] => string
                        )

                    [2] => 3
                )

        )

    [2] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => sub_days
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => cf_722
                            [type] => string
                        )

                    [2] => 3
                )

        )

)
',
			4 => false,
			5 => 'VTExpressionSymbol Object
(
    [value] => cf_722
    [type] => string
)
',
			6 => '3',
			7 => 'Array
(
    [0] => 2016-02-15
    [1] => 3
)
'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('2016-02-12', $exprEvaluation);
		/////////////////////////
		$testexpression = "if accountname == '' then concat(accountname,'-',tickersymbol) else concat(tickersymbol,'-',accountname) end";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => accountname
    [type] => string
)
',
			1 => '',
			2 => 'Array
(
    [0] => Chemex Labs Ltd
    [1] => 
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => ==
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => accountname
                            [type] => string
                        )

                    [2] => 
                )

        )

    [1] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => concat
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => accountname
                            [type] => string
                        )

                    [2] => -
                    [3] => VTExpressionSymbol Object
                        (
                            [value] => tickersymbol
                            [type] => string
                        )

                )

        )

    [2] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => concat
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => tickersymbol
                            [type] => string
                        )

                    [2] => -
                    [3] => VTExpressionSymbol Object
                        (
                            [value] => accountname
                            [type] => string
                        )

                )

        )

)
',
			4 => false,
			5 => 'VTExpressionSymbol Object
(
    [value] => tickersymbol
    [type] => string
)
',
			6 => '-',
			7 => 'VTExpressionSymbol Object
(
    [value] => accountname
    [type] => string
)
',
			8 => 'Array
(
    [0] => 
    [1] => -
    [2] => Chemex Labs Ltd
)
',
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('-Chemex Labs Ltd', $exprEvaluation);
		/////////////////////////
		$testexpression = "if accountname=='' then concat(accountname,'-',tickersymbol) else concat(tickersymbol,'-',accountname) end";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => accountname
    [type] => string
)
',
			1 => '',
			2 => 'Array
(
    [0] => Chemex Labs Ltd
    [1] => 
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => ==
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => accountname
                            [type] => string
                        )

                    [2] => 
                )

        )

    [1] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => concat
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => accountname
                            [type] => string
                        )

                    [2] => -
                    [3] => VTExpressionSymbol Object
                        (
                            [value] => tickersymbol
                            [type] => string
                        )

                )

        )

    [2] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => concat
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => tickersymbol
                            [type] => string
                        )

                    [2] => -
                    [3] => VTExpressionSymbol Object
                        (
                            [value] => accountname
                            [type] => string
                        )

                )

        )

)
',
			4 => false,
			5 => 'VTExpressionSymbol Object
(
    [value] => tickersymbol
    [type] => string
)
',
			6 => '-',
			7 => 'VTExpressionSymbol Object
(
    [value] => accountname
    [type] => string
)
',
			8 => 'Array
(
    [0] => 
    [1] => -
    [2] => Chemex Labs Ltd
)
',
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('-Chemex Labs Ltd', $exprEvaluation);
		/////////////////////////
		$testexpression = "if cf_718 == '' then concat(cf_718,'-',cf_725) else concat(cf_725,'-',cf_718) end";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => cf_718
    [type] => string
)
',
			1 => '',
			2 => 'Array
(
    [0] => 
    [1] => 
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => ==
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => cf_718
                            [type] => string
                        )

                    [2] => 
                )

        )

    [1] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => concat
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => cf_718
                            [type] => string
                        )

                    [2] => -
                    [3] => VTExpressionSymbol Object
                        (
                            [value] => cf_725
                            [type] => string
                        )

                )

        )

    [2] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => concat
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => cf_725
                            [type] => string
                        )

                    [2] => -
                    [3] => VTExpressionSymbol Object
                        (
                            [value] => cf_718
                            [type] => string
                        )

                )

        )

)
',
			4 => true,
			5 => 'VTExpressionSymbol Object
(
    [value] => cf_718
    [type] => string
)
',
			6 => '-',
			7 => 'VTExpressionSymbol Object
(
    [value] => cf_725
    [type] => string
)
',
			8 => 'Array
(
    [0] => 
    [1] => -
    [2] => 
)
',
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('-', $exprEvaluation);
		/////////////////////////
		$testexpression = "if cf_718=='' then concat(cf_718,'-',cf_725) else concat(cf_725,'-',cf_718) end";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => cf_718
    [type] => string
)
',
			1 => '',
			2 => 'Array
(
    [0] => 
    [1] => 
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => ==
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => cf_718
                            [type] => string
                        )

                    [2] => 
                )

        )

    [1] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => concat
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => cf_718
                            [type] => string
                        )

                    [2] => -
                    [3] => VTExpressionSymbol Object
                        (
                            [value] => cf_725
                            [type] => string
                        )

                )

        )

    [2] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => concat
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => cf_725
                            [type] => string
                        )

                    [2] => -
                    [3] => VTExpressionSymbol Object
                        (
                            [value] => cf_718
                            [type] => string
                        )

                )

        )

)
',
			4 => true,
			5 => 'VTExpressionSymbol Object
(
    [value] => cf_718
    [type] => string
)
',
			6 => '-',
			7 => 'VTExpressionSymbol Object
(
    [value] => cf_725
    [type] => string
)
',
			8 => 'Array
(
    [0] => 
    [1] => -
    [2] => 
)
',
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('-', $exprEvaluation);
		/////////////////////////
		$testexpression = "if cf_718 != '' then concat(cf_718,'-',cf_725) else concat(cf_725,'-',cf_718) end";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => cf_718
    [type] => string
)
',
			1 => '',
			2 => 'Array
(
    [0] => 
    [1] => 
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => !=
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => cf_718
                            [type] => string
                        )

                    [2] => 
                )

        )

    [1] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => concat
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => cf_718
                            [type] => string
                        )

                    [2] => -
                    [3] => VTExpressionSymbol Object
                        (
                            [value] => cf_725
                            [type] => string
                        )

                )

        )

    [2] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => concat
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => cf_725
                            [type] => string
                        )

                    [2] => -
                    [3] => VTExpressionSymbol Object
                        (
                            [value] => cf_718
                            [type] => string
                        )

                )

        )

)
',
			4 => false,
			5 => 'VTExpressionSymbol Object
(
    [value] => cf_725
    [type] => string
)
',
			6 => '-',
			7 => 'VTExpressionSymbol Object
(
    [value] => cf_718
    [type] => string
)
',
			8 => 'Array
(
    [0] => 
    [1] => -
    [2] => 
)
',
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('-', $exprEvaluation);
		/////////////////////////
		$entityId = '11x79';
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$testexpression = "if cf_718=='' then concat(cf_718,'-',cf_725) else concat(cf_725,'-',cf_718) end";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => cf_718
    [type] => string
)
',
			1 => '',
			2 => 'Array
(
    [0] => 
    [1] => 
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => ==
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => cf_718
                            [type] => string
                        )

                    [2] => 
                )

        )

    [1] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => concat
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => cf_718
                            [type] => string
                        )

                    [2] => -
                    [3] => VTExpressionSymbol Object
                        (
                            [value] => cf_725
                            [type] => string
                        )

                )

        )

    [2] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => concat
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => cf_725
                            [type] => string
                        )

                    [2] => -
                    [3] => VTExpressionSymbol Object
                        (
                            [value] => cf_718
                            [type] => string
                        )

                )

        )

)
',
			4 => true,
			5 => 'VTExpressionSymbol Object
(
    [value] => cf_718
    [type] => string
)
',
			6 => '-',
			7 => 'VTExpressionSymbol Object
(
    [value] => cf_725
    [type] => string
)
',
			8 => 'Array
(
    [0] => 
    [1] => -
    [2] => 
)
',
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('-', $exprEvaluation);
	}

	/**
	 * Method testIFReturnOperations
	 * @test
	 */
	public function testIFReturnOperations() {
		$adminUser = Users::getActiveAdminUser();
		$entityId = '11x74'; // employees = 131
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$testexpression = 'if employees != 13 then employees + 1 else employees - 1 end';
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => employees
    [type] => string
)
',
			1 => '13',
			2 => 'Array
(
    [0] => 131
    [1] => 13
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => !=
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => employees
                            [type] => string
                        )

                    [2] => 13
                )

        )

    [1] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => +
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => employees
                            [type] => string
                        )

                    [2] => 1
                )

        )

    [2] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => -
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => employees
                            [type] => string
                        )

                    [2] => 1
                )

        )

)
',
			4 => true,
			5 => 'VTExpressionSymbol Object
(
    [value] => employees
    [type] => string
)
',
			6 => '1',
			7 => 'Array
(
    [0] => 131
    [1] => 1
)
'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals(132, $exprEvaluation);
		//////////////////////////////
		$testexpression = 'if employees &lt;= 13 then employees + 1 else employees - 1 end';
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => employees
    [type] => string
)
',
			1 => '13',
			2 => 'Array
(
    [0] => 131
    [1] => 13
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => <=
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => employees
                            [type] => string
                        )

                    [2] => 13
                )

        )

    [1] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => +
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => employees
                            [type] => string
                        )

                    [2] => 1
                )

        )

    [2] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => -
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => employees
                            [type] => string
                        )

                    [2] => 1
                )

        )

)
',
			4 => false,
			5 => 'VTExpressionSymbol Object
(
    [value] => employees
    [type] => string
)
',
			6 => '1',
			7 => 'Array
(
    [0] => 131
    [1] => 1
)
'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals(130, $exprEvaluation);
	}

	/**
	 * Method testIFWaterfall
	 * @test
	 */
	public function testIFWaterfall() {
		$adminUser = Users::getActiveAdminUser();
		$entityId = '11x74';
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$testexpression = "if accountname == 'Chemex Labs Ltd' then 'accountname' else if bill_city == 'Els Poblets' then 'bill_city' else if ship_country == 'Spain' then 'ship_country' else 'none' end";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => accountname
    [type] => string
)
',
			1 => 'Chemex Labs Ltd',
			2 => 'Array
(
    [0] => Chemex Labs Ltd
    [1] => Chemex Labs Ltd
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => ==
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => accountname
                            [type] => string
                        )

                    [2] => Chemex Labs Ltd
                )

        )

    [1] => accountname
    [2] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => if
                            [type] => string
                        )

                    [1] => VTExpressionTreeNode Object
                        (
                            [arr] => Array
                                (
                                    [0] => VTExpressionSymbol Object
                                        (
                                            [value] => ==
                                            [type] => string
                                        )

                                    [1] => VTExpressionSymbol Object
                                        (
                                            [value] => bill_city
                                            [type] => string
                                        )

                                    [2] => Els Poblets
                                )

                        )

                    [2] => bill_city
                    [3] => VTExpressionTreeNode Object
                        (
                            [arr] => Array
                                (
                                    [0] => VTExpressionSymbol Object
                                        (
                                            [value] => if
                                            [type] => string
                                        )

                                    [1] => VTExpressionTreeNode Object
                                        (
                                            [arr] => Array
                                                (
                                                    [0] => VTExpressionSymbol Object
                                                        (
                                                            [value] => ==
                                                            [type] => string
                                                        )

                                                    [1] => VTExpressionSymbol Object
                                                        (
                                                            [value] => ship_country
                                                            [type] => string
                                                        )

                                                    [2] => Spain
                                                )

                                        )

                                    [2] => ship_country
                                    [3] => none
                                )

                        )

                )

        )

)
',
			4 => true,
			5 => 'accountname'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('accountname', $exprEvaluation);
		////////////////////////
		$testexpression = "if accountname != 'Chemex Labs Ltd' then 'accountname' else if bill_city == 'Els Poblets' then 'bill_city' else if ship_country == 'Spain' then 'ship_country' else 'none' end";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => accountname
    [type] => string
)
',
			1 => 'Chemex Labs Ltd',
			2 => 'Array
(
    [0] => Chemex Labs Ltd
    [1] => Chemex Labs Ltd
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => !=
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => accountname
                            [type] => string
                        )

                    [2] => Chemex Labs Ltd
                )

        )

    [1] => accountname
    [2] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => if
                            [type] => string
                        )

                    [1] => VTExpressionTreeNode Object
                        (
                            [arr] => Array
                                (
                                    [0] => VTExpressionSymbol Object
                                        (
                                            [value] => ==
                                            [type] => string
                                        )

                                    [1] => VTExpressionSymbol Object
                                        (
                                            [value] => bill_city
                                            [type] => string
                                        )

                                    [2] => Els Poblets
                                )

                        )

                    [2] => bill_city
                    [3] => VTExpressionTreeNode Object
                        (
                            [arr] => Array
                                (
                                    [0] => VTExpressionSymbol Object
                                        (
                                            [value] => if
                                            [type] => string
                                        )

                                    [1] => VTExpressionTreeNode Object
                                        (
                                            [arr] => Array
                                                (
                                                    [0] => VTExpressionSymbol Object
                                                        (
                                                            [value] => ==
                                                            [type] => string
                                                        )

                                                    [1] => VTExpressionSymbol Object
                                                        (
                                                            [value] => ship_country
                                                            [type] => string
                                                        )

                                                    [2] => Spain
                                                )

                                        )

                                    [2] => ship_country
                                    [3] => none
                                )

                        )

                )

        )

)
',
			4 => false,
			5 => 'VTExpressionSymbol Object
(
    [value] => bill_city
    [type] => string
)
',
			6 => 'Els Poblets',
			7 => 'Array
(
    [0] => Els Poblets
    [1] => Els Poblets
)
',
			8 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => ==
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => bill_city
                            [type] => string
                        )

                    [2] => Els Poblets
                )

        )

    [1] => bill_city
    [2] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => if
                            [type] => string
                        )

                    [1] => VTExpressionTreeNode Object
                        (
                            [arr] => Array
                                (
                                    [0] => VTExpressionSymbol Object
                                        (
                                            [value] => ==
                                            [type] => string
                                        )

                                    [1] => VTExpressionSymbol Object
                                        (
                                            [value] => ship_country
                                            [type] => string
                                        )

                                    [2] => Spain
                                )

                        )

                    [2] => ship_country
                    [3] => none
                )

        )

)
',
			9 => true,
			10 => 'bill_city'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('bill_city', $exprEvaluation);
		////////////////////////
		$testexpression = "if accountname != 'Chemex Labs Ltd' then 'accountname' else if bill_city != 'Els Poblets' then 'bill_city' else if ship_country == 'Spain' then 'ship_country' else 'none' end";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => accountname
    [type] => string
)
',
			1 => 'Chemex Labs Ltd',
			2 => 'Array
(
    [0] => Chemex Labs Ltd
    [1] => Chemex Labs Ltd
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => !=
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => accountname
                            [type] => string
                        )

                    [2] => Chemex Labs Ltd
                )

        )

    [1] => accountname
    [2] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => if
                            [type] => string
                        )

                    [1] => VTExpressionTreeNode Object
                        (
                            [arr] => Array
                                (
                                    [0] => VTExpressionSymbol Object
                                        (
                                            [value] => !=
                                            [type] => string
                                        )

                                    [1] => VTExpressionSymbol Object
                                        (
                                            [value] => bill_city
                                            [type] => string
                                        )

                                    [2] => Els Poblets
                                )

                        )

                    [2] => bill_city
                    [3] => VTExpressionTreeNode Object
                        (
                            [arr] => Array
                                (
                                    [0] => VTExpressionSymbol Object
                                        (
                                            [value] => if
                                            [type] => string
                                        )

                                    [1] => VTExpressionTreeNode Object
                                        (
                                            [arr] => Array
                                                (
                                                    [0] => VTExpressionSymbol Object
                                                        (
                                                            [value] => ==
                                                            [type] => string
                                                        )

                                                    [1] => VTExpressionSymbol Object
                                                        (
                                                            [value] => ship_country
                                                            [type] => string
                                                        )

                                                    [2] => Spain
                                                )

                                        )

                                    [2] => ship_country
                                    [3] => none
                                )

                        )

                )

        )

)
',
			4 => false,
			5 => 'VTExpressionSymbol Object
(
    [value] => bill_city
    [type] => string
)
',
			6 => 'Els Poblets',
			7 => 'Array
(
    [0] => Els Poblets
    [1] => Els Poblets
)
',
			8 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => !=
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => bill_city
                            [type] => string
                        )

                    [2] => Els Poblets
                )

        )

    [1] => bill_city
    [2] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => if
                            [type] => string
                        )

                    [1] => VTExpressionTreeNode Object
                        (
                            [arr] => Array
                                (
                                    [0] => VTExpressionSymbol Object
                                        (
                                            [value] => ==
                                            [type] => string
                                        )

                                    [1] => VTExpressionSymbol Object
                                        (
                                            [value] => ship_country
                                            [type] => string
                                        )

                                    [2] => Spain
                                )

                        )

                    [2] => ship_country
                    [3] => none
                )

        )

)
',
			9 => false,
			10 => 'VTExpressionSymbol Object
(
    [value] => ship_country
    [type] => string
)
',
			11 => 'Spain',
			12 => 'Array
(
    [0] => Spain
    [1] => Spain
)
',
			13 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => ==
                            [type] => string
                        )

                    [1] => VTExpressionSymbol Object
                        (
                            [value] => ship_country
                            [type] => string
                        )

                    [2] => Spain
                )

        )

    [1] => ship_country
    [2] => none
)
',
			14 => true,
			15 => 'ship_country',
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('ship_country', $exprEvaluation);
		////////////////////////
		$testexpression = "if 681487 != 681487 then 4 else if 4 < 5 then 1 else 1 + 4 - 5 end";
		$expectedresult = array(
			0 => '681487',
			1 => '681487',
			2 => 'Array
(
    [0] => 681487
    [1] => 681487
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => !=
                            [type] => string
                        )

                    [1] => 681487
                    [2] => 681487
                )

        )

    [1] => 4
    [2] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => if
                            [type] => string
                        )

                    [1] => VTExpressionTreeNode Object
                        (
                            [arr] => Array
                                (
                                    [0] => VTExpressionSymbol Object
                                        (
                                            [value] => <
                                            [type] => string
                                        )

                                    [1] => 4
                                    [2] => 5
                                )

                        )

                    [2] => 1
                    [3] => VTExpressionTreeNode Object
                        (
                            [arr] => Array
                                (
                                    [0] => VTExpressionSymbol Object
                                        (
                                            [value] => +
                                            [type] => string
                                        )

                                    [1] => 1
                                    [2] => VTExpressionTreeNode Object
                                        (
                                            [arr] => Array
                                                (
                                                    [0] => VTExpressionSymbol Object
                                                        (
                                                            [value] => -
                                                            [type] => string
                                                        )

                                                    [1] => 4
                                                    [2] => 5
                                                )

                                        )

                                )

                        )

                )

        )

)
',
			5 => '4',
			6 => '5',
			7 => 'Array
(
    [0] => 4
    [1] => 5
)
',
			8 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => <
                            [type] => string
                        )

                    [1] => 4
                    [2] => 5
                )

        )

    [1] => 1
    [2] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => +
                            [type] => string
                        )

                    [1] => 1
                    [2] => VTExpressionTreeNode Object
                        (
                            [arr] => Array
                                (
                                    [0] => VTExpressionSymbol Object
                                        (
                                            [value] => -
                                            [type] => string
                                        )

                                    [1] => 4
                                    [2] => 5
                                )

                        )

                )

        )

)
',
			9 => true,
			10 => '1',
			4 => false,
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('1', $exprEvaluation);
		////////////////////////
		$testexpression = "if 681487 != 681487 then 4 else if 4 > 5 then 1 else 1 + 4 - 5 end";
		$expectedresult = array(
			0 => '681487',
			1 => '681487',
			2 => 'Array
(
    [0] => 681487
    [1] => 681487
)
',
			3 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => !=
                            [type] => string
                        )

                    [1] => 681487
                    [2] => 681487
                )

        )

    [1] => 4
    [2] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => if
                            [type] => string
                        )

                    [1] => VTExpressionTreeNode Object
                        (
                            [arr] => Array
                                (
                                    [0] => VTExpressionSymbol Object
                                        (
                                            [value] => >
                                            [type] => string
                                        )

                                    [1] => 4
                                    [2] => 5
                                )

                        )

                    [2] => 1
                    [3] => VTExpressionTreeNode Object
                        (
                            [arr] => Array
                                (
                                    [0] => VTExpressionSymbol Object
                                        (
                                            [value] => +
                                            [type] => string
                                        )

                                    [1] => 1
                                    [2] => VTExpressionTreeNode Object
                                        (
                                            [arr] => Array
                                                (
                                                    [0] => VTExpressionSymbol Object
                                                        (
                                                            [value] => -
                                                            [type] => string
                                                        )

                                                    [1] => 4
                                                    [2] => 5
                                                )

                                        )

                                )

                        )

                )

        )

)
',
			5 => '4',
			6 => '5',
			7 => 'Array
(
    [0] => 4
    [1] => 5
)
',
			8 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => >
                            [type] => string
                        )

                    [1] => 4
                    [2] => 5
                )

        )

    [1] => 1
    [2] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => +
                            [type] => string
                        )

                    [1] => 1
                    [2] => VTExpressionTreeNode Object
                        (
                            [arr] => Array
                                (
                                    [0] => VTExpressionSymbol Object
                                        (
                                            [value] => -
                                            [type] => string
                                        )

                                    [1] => 4
                                    [2] => 5
                                )

                        )

                )

        )

)
',
	9 => false,
	10 => '1',
	4 => false,
	11 => '4',
	12 => '5',
	13 => 'Array
(
    [0] => 4
    [1] => 5
)
',
	14 => 'Array
(
    [0] => 1
    [1] => -1
)
'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('0', $exprEvaluation);
	}

	/**
	 * Method testIFFunctionInCondition
	 * @test
	 */
	public function testIFFunctionInCondition() {
		$adminUser = Users::getActiveAdminUser();
		$entityId = '11x74';
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$testexpression = "if substring(phone,0,2) == '00' then concat('+',phone) else phone end ";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => phone
    [type] => string
)
',
			1 => '0',
			2 => '2',
			3 => 'Array
(
    [0] => 03-3608-5660
    [1] => 0
    [2] => 2
)
',
			4 => '00',
			5 => 'Array
(
    [0] => 03
    [1] => 00
)
',
			6 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => ==
                            [type] => string
                        )

                    [1] => VTExpressionTreeNode Object
                        (
                            [arr] => Array
                                (
                                    [0] => VTExpressionSymbol Object
                                        (
                                            [value] => substring
                                            [type] => string
                                        )

                                    [1] => VTExpressionSymbol Object
                                        (
                                            [value] => phone
                                            [type] => string
                                        )

                                    [2] => 0
                                    [3] => 2
                                )

                        )

                    [2] => 00
                )

        )

    [1] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => concat
                            [type] => string
                        )

                    [1] => +
                    [2] => VTExpressionSymbol Object
                        (
                            [value] => phone
                            [type] => string
                        )

                )

        )

    [2] => VTExpressionSymbol Object
        (
            [value] => phone
            [type] => string
        )

)
',
			7 => false,
			8 => 'VTExpressionSymbol Object
(
    [value] => phone
    [type] => string
)
',
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('03-3608-5660', $exprEvaluation);
		//////////////////////////////
		$testexpression = "if '00' != substring(phone,0,2) then concat('+',phone) else phone end ";
		$expectedresult = array(
			0 => '00',
			1 => 'VTExpressionSymbol Object
(
    [value] => phone
    [type] => string
)
',
			2 => '0',
			3 => '2',
			4 => 'Array
(
    [0] => 03-3608-5660
    [1] => 0
    [2] => 2
)
',
			5 => 'Array
(
    [0] => 00
    [1] => 03
)
',
			6 => 'Array
(
    [0] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => !=
                            [type] => string
                        )

                    [1] => 00
                    [2] => VTExpressionTreeNode Object
                        (
                            [arr] => Array
                                (
                                    [0] => VTExpressionSymbol Object
                                        (
                                            [value] => substring
                                            [type] => string
                                        )

                                    [1] => VTExpressionSymbol Object
                                        (
                                            [value] => phone
                                            [type] => string
                                        )

                                    [2] => 0
                                    [3] => 2
                                )

                        )

                )

        )

    [1] => VTExpressionTreeNode Object
        (
            [arr] => Array
                (
                    [0] => VTExpressionSymbol Object
                        (
                            [value] => concat
                            [type] => string
                        )

                    [1] => +
                    [2] => VTExpressionSymbol Object
                        (
                            [value] => phone
                            [type] => string
                        )

                )

        )

    [2] => VTExpressionSymbol Object
        (
            [value] => phone
            [type] => string
        )

)
',
			7 => true,
			8 => '+',
			9 => 'VTExpressionSymbol Object
(
    [value] => phone
    [type] => string
)
',
    10 => 'Array
(
    [0] => +
    [1] => 03-3608-5660
)
'
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('+03-3608-5660', $exprEvaluation);
	}

	/**
	 * Method testGetUserFunctions
	 * @test
	 */
	public function testGetUserFunctions() {
		$adminUser = Users::getActiveAdminUser();
		$entityId = '11x74'; // employees = 131
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$testexpression = 'getCurrentUserID()';
		$expectedresult = array(
			0 => 'Array
(
)
',
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('19x1', $exprEvaluation);
		$testexpression = 'getCurrentUserName()';
		$expectedresult = array(
			0 => 'Array
(
)
',
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('admin', $exprEvaluation);
		$testexpression = "getCurrentUserName('full')";
		$expectedresult = array(
			0 => 'full',
			1 => 'Array
(
    [0] => full
)
',
		);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('Administrator', $exprEvaluation);
	}

	/**
	 * Method testOwnerFields
	 * @test
	 */
	public function testOwnerFields() {
		$adminUser = Users::getActiveAdminUser();
		$entityId = '28x14331'; // payment
		$entity = new VTWorkflowEntity($adminUser, $entityId);
		$testexpression = "assigned_user_id";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => assigned_user_id
    [type] => string
)
',
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('cbTest testmdy', $exprEvaluation);
		//////////////
		$testexpression = "created_user_id";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => created_user_id
    [type] => string
)
',
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals(' Administrator', $exprEvaluation);
		///////////////
		$testexpression = "reports_to_id";
		$expectedresult = array(
			0 => 'VTExpressionSymbol Object
(
    [value] => reports_to_id
    [type] => string
)
',
);
		$parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($testexpression)));
		$expression = $parser->expression();
		$exprEvaluater = new VTFieldExpressionEvaluater($expression);
		$exprEvaluation = $exprEvaluater->evaluate($entity);
		$this->assertEquals($expectedresult, $exprEvaluater->debug);
		$this->assertEquals('cbTest testymd', $exprEvaluation);
	}
}
?>