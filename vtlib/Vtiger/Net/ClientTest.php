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
class testVtlibNetClient extends TestCase {
	private static $netURL = '';

	public static function setUpBeforeClass() {
		global $site_URL;
		self::$netURL = $site_URL.'/webservice.php';
	}

	/**
	 * Method testConstructsetURLDisconnect
	 * @test
	 */
	public function testConstructsetURLDisconnect() {
		$client = new Vtiger_Net_Client(self::$netURL);
		$this->assertSame($client->url, self::$netURL, "testConstruct URL");
		$this->assertFalse($client->response,"testConstruct response");
		$this->assertInstanceOf('Vtiger_Net_Client', $client,"testConstruct client");
		$this->assertInstanceOf('HTTP_Request2', $client->client,"testConstruct client");
		$client->disconnect();
		$this->assertInstanceOf('Vtiger_Net_Client', $client,"testDisconnect client");
		$this->assertInstanceOf('HTTP_Request2', $client->client,"testConstruct client");
	}

	/**
	 * Method testdoPost
	 * @test
	 */
	public function testdoGetPost() {
		$client = new Vtiger_Net_Client(self::$netURL);
		$content = $client->doGet(array('operation'=>'getchallenge','username'=>'admin'));
		$this->assertStringStartsWith('{"success":true,"result":{"token":', $content,'testdoGetPost get content');
		$this->assertTrue($client->response,'testdoGetPost get response');
		$this->assertFalse($client->wasError(),'testdoGetPost get error');
		$response = json_decode($content,true);
		$result = $response['result'];
		$generatedKey = md5($result['token'].'cdYTBpiMR9RfGgO');
		$post = $client->doPost(array('operation'=>'login','username'=>'admin','accessKey'=>$generatedKey));
		$this->assertStringStartsWith('{"success":true,"result":{"sessionName":', $post,'testdoGetPost post content');
		$this->assertTrue($client->response,'testdoGetPost post response');
		$this->assertFalse($client->wasError(),'testdoGetPost post error');
	}

}
?>