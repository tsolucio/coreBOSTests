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
class testVtlibUnzip extends PHPUnit_Framework_TestCase {
	private static $zipFile = __DIR__ . '/cbLoginHistory.zip';
	
	/**
	 * Method testConstructsetURLDisconnect
	 * @test
	 */
	public function testgetList() {
		$expectedList = array (
			'manifest.xml' => array (
				'file_name' => 'manifest.xml',
				'compression_method' => 8,
				'lastmod_datetime' => 1482516520,
				'crc' => 2159072277,
				'compressed_size' => 226,
				'uncompressed_size' => 427 
			),
			'modules/cbLoginHistory/index.php' => array (
				'file_name' => 'modules/cbLoginHistory/index.php',
				'compression_method' => 8,
				'lastmod_datetime' => 1482236244,
				'crc' => 2442578722,
				'compressed_size' => 307,
				'uncompressed_size' => 679 
			),
			'modules/cbLoginHistory/manifest.xml' => array (
				'file_name' => 'modules/cbLoginHistory/manifest.xml',
				'compression_method' => 8,
				'lastmod_datetime' => 1482236244,
				'crc' => 3032954958,
				'compressed_size' => 914,
				'uncompressed_size' => 2109 
			),
			'modules/cbLoginHistory/cbLoginHistoryAjax.php' => array (
				'file_name' => 'modules/cbLoginHistory/cbLoginHistoryAjax.php',
				'compression_method' => 8,
				'lastmod_datetime' => 1482236244,
				'crc' => 3264661394,
				'compressed_size' => 273,
				'uncompressed_size' => 579 
			),
			'modules/cbLoginHistory/language/de_de.lang.php' => array (
				'file_name' => 'modules/cbLoginHistory/language/de_de.lang.php',
				'compression_method' => 8,
				'lastmod_datetime' => 1482236244,
				'crc' => 1545382535,
				'compressed_size' => 411,
				'uncompressed_size' => 883 
			),
			'modules/cbLoginHistory/language/it_it.lang.php' => array (
				'file_name' => 'modules/cbLoginHistory/language/it_it.lang.php',
				'compression_method' => 8,
				'lastmod_datetime' => 1482236244,
				'crc' => 148289608,
				'compressed_size' => 400,
				'uncompressed_size' => 855 
			),
			'modules/cbLoginHistory/language/pt_br.lang.php' => array (
				'file_name' => 'modules/cbLoginHistory/language/pt_br.lang.php',
				'compression_method' => 8,
				'lastmod_datetime' => 1482236244,
				'crc' => 1489342377,
				'compressed_size' => 429,
				'uncompressed_size' => 900 
			),
			'modules/cbLoginHistory/language/en_us.lang.php' => array (
				'file_name' => 'modules/cbLoginHistory/language/en_us.lang.php',
				'compression_method' => 8,
				'lastmod_datetime' => 1482236244,
				'crc' => 714009349,
				'compressed_size' => 295,
				'uncompressed_size' => 654 
			),
			'modules/cbLoginHistory/language/en_gb.lang.php' => array (
				'file_name' => 'modules/cbLoginHistory/language/en_gb.lang.php',
				'compression_method' => 8,
				'lastmod_datetime' => 1482236244,
				'crc' => 714009349,
				'compressed_size' => 295,
				'uncompressed_size' => 654 
			),
			'modules/cbLoginHistory/language/hu_hu.lang.php' => array (
				'file_name' => 'modules/cbLoginHistory/language/hu_hu.lang.php',
				'compression_method' => 8,
				'lastmod_datetime' => 1482236244,
				'crc' => 1107592222,
				'compressed_size' => 397,
				'uncompressed_size' => 881 
			),
			'modules/cbLoginHistory/language/nl_nl.lang.php' => array (
				'file_name' => 'modules/cbLoginHistory/language/nl_nl.lang.php',
				'compression_method' => 8,
				'lastmod_datetime' => 1482236244,
				'crc' => 3621974815,
				'compressed_size' => 411,
				'uncompressed_size' => 894 
			),
			'modules/cbLoginHistory/language/fr_fr.lang.php' => array (
				'file_name' => 'modules/cbLoginHistory/language/fr_fr.lang.php',
				'compression_method' => 8,
				'lastmod_datetime' => 1482236244,
				'crc' => 1107592222,
				'compressed_size' => 397,
				'uncompressed_size' => 881 
			),
			'modules/cbLoginHistory/language/es_es.lang.php' => array (
				'file_name' => 'modules/cbLoginHistory/language/es_es.lang.php',
				'compression_method' => 8,
				'lastmod_datetime' => 1482236244,
				'crc' => 1465915341,
				'compressed_size' => 310,
				'uncompressed_size' => 670 
			),
			'modules/cbLoginHistory/language/es_mx.lang.php' => array (
				'file_name' => 'modules/cbLoginHistory/language/es_mx.lang.php',
				'compression_method' => 8,
				'lastmod_datetime' => 1482236244,
				'crc' => 1465915341,
				'compressed_size' => 310,
				'uncompressed_size' => 670 
			),
			'modules/cbLoginHistory/ExportRecords.php' => array (
				'file_name' => 'modules/cbLoginHistory/ExportRecords.php',
				'compression_method' => 8,
				'lastmod_datetime' => 1482236244,
				'crc' => 1900597356,
				'compressed_size' => 274,
				'uncompressed_size' => 583 
			),
			'modules/cbLoginHistory/cbLoginHistory.js' => array (
				'file_name' => 'modules/cbLoginHistory/cbLoginHistory.js',
				'compression_method' => 8,
				'lastmod_datetime' => 1482236244,
				'crc' => 71449992,
				'compressed_size' => 228,
				'uncompressed_size' => 525 
			),
			'modules/cbLoginHistory/cbLoginHistory.php' => array (
				'file_name' => 'modules/cbLoginHistory/cbLoginHistory.php',
				'compression_method' => 8,
				'lastmod_datetime' => 1482236244,
				'crc' => 3893047786,
				'compressed_size' => 564,
				'uncompressed_size' => 1540 
			),
			'modules/cbLoginHistory/getJSON.php' => array (
				'file_name' => 'modules/cbLoginHistory/getJSON.php',
				'compression_method' => 8,
				'lastmod_datetime' => 1482236244,
				'crc' => 855573040,
				'compressed_size' => 1027,
				'uncompressed_size' => 2607 
			),
			'modules/cbLoginHistory/ListView.php' => array (
				'file_name' => 'modules/cbLoginHistory/ListView.php',
				'compression_method' => 8,
				'lastmod_datetime' => 1482236244,
				'crc' => 1771634721,
				'compressed_size' => 671,
				'uncompressed_size' => 1633 
			),
			'templates/index.tpl' => array (
				'file_name' => 'templates/index.tpl',
				'compression_method' => 8,
				'lastmod_datetime' => 1482236242,
				'crc' => 427506083,
				'compressed_size' => 2142,
				'uncompressed_size' => 5609 
			),
		);
		$zipa = new Vtiger_Unzip(self::$zipFile);
		$actualLisr = $zipa->getList();
		$this->assertSame($expectedList, $actualLisr, 'unzip list info');
	}
}
?>