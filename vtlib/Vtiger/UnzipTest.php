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
class testVtlibUnzip extends TestCase {
	private static $zipFile = __DIR__ . '/cbLoginHistory.zip';

	/**
	 * Method testgetList
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
		$actualList = $zipa->getList();
		$this->assertSame($expectedList, $actualList, 'unzip list info');
	}

	/**
	 * Method testunzipAllEx
	 * @test
	 */
	public function testunzipAllEx() {
		$cacheDir = 'cache/ziptest';
		$this->recursiveRemoveDirectory($cacheDir);
		$expected = array (
			0 => 'cache/ziptest',
			1 => 'cache/ziptest/Smarty',
			2 => 'cache/ziptest/Smarty/templates',
			3 => 'cache/ziptest/Smarty/templates/modules',
			4 => 'cache/ziptest/Smarty/templates/modules/cbLoginHistory',
			5 => 'cache/ziptest/Smarty/templates/modules/cbLoginHistory/templates',
			6 => 'cache/ziptest/modules',
			7 => 'cache/ziptest/modules/cbLoginHistory',
			8 => 'cache/ziptest/modules/cbLoginHistory/modules',
			9 => 'cache/ziptest/modules/cbLoginHistory/modules/cbLoginHistory',
			10 => 'cache/ziptest/modules/cbLoginHistory/language',
			11 => 'cache/ziptest/modules/cbLoginHistory/language/modules',
			12 => 'cache/ziptest/modules/cbLoginHistory/language/modules/cbLoginHistory',
			13 => 'cache/ziptest/modules/cbLoginHistory/language/modules/cbLoginHistory/language',
		);
		$unzip = new Vtiger_Unzip(self::$zipFile);
		@mkdir($cacheDir);
		// Unzip selectively
		$unzip->unzipAllEx( $cacheDir,
			Array(
				// Include only file/folders that need to be extracted
				'include' => Array('templates', "modules/cbLoginHistory", 'cron','manifest.xml'),
				//'exclude' => Array('manifest.xml')
				// NOTE: If excludes is not given then by those not mentioned in include are ignored.
			),
			// What files needs to be renamed?
			Array(
				// Templates folder
				'templates' => "Smarty/templates/modules/cbLoginHistory",
				// Cron folder
				'cron' => "cron/modules/cbLoginHistory"
			)
		);
		$actual = $this->getDirectroyListing($cacheDir,true);
		$this->assertEquals($expected, $actual, 'unzipAllEx directory list');
		$this->recursiveRemoveDirectory($cacheDir);
	}

	/**
	 * Method testunzip
	 * @test
	 */
	public function testunzip() {
		$cacheDir = 'cache/ziptest';
		$this->recursiveRemoveDirectory($cacheDir);
		$unzip = new Vtiger_Unzip(self::$zipFile);
		@mkdir($cacheDir);
		$fileName = 'manifest.xml';
		$dirname = dirname($fileName);
		$unzip->unzip($fileName, "$cacheDir/$dirname/".basename($fileName), 0664);
		$actual = $this->getDirectroyListing($cacheDir);
		$expected = array (
			0 => 'cache/ziptest',
			1 => 'cache/ziptest/manifest.xml',
		);
		$this->assertEquals($expected, $actual, "unzip $fileName");
		$fileName = 'modules/cbLoginHistory/index.php';
		$dirname = dirname($fileName);
		$unzip->unzip($fileName, "$cacheDir/$dirname/".basename($fileName), 0664);
		$actual = $this->getDirectroyListing($cacheDir);
		$expected = array (
			0 => 'cache/ziptest',
			1 => 'cache/ziptest/modules',
			2 => 'cache/ziptest/modules/cbLoginHistory',
			3 => 'cache/ziptest/modules/cbLoginHistory/index.php',
			4 => 'cache/ziptest/modules/cbLoginHistory/modules',
			5 => 'cache/ziptest/modules/cbLoginHistory/modules/cbLoginHistory',
			6 => 'cache/ziptest/manifest.xml',
		);
		$this->assertEquals($expected, $actual, "unzip $fileName");
		$fileName = 'modules/cbLoginHistory/language/de_de.lang.php';
		$dirname = dirname($fileName);
		$unzip->unzip($fileName, "$cacheDir/$dirname/".basename($fileName), 0664);
		$actual = $this->getDirectroyListing($cacheDir);
		$expected = array (
			0 => 'cache/ziptest',
			1 => 'cache/ziptest/modules',
			2 => 'cache/ziptest/modules/cbLoginHistory',
			3 => 'cache/ziptest/modules/cbLoginHistory/index.php',
			4 => 'cache/ziptest/modules/cbLoginHistory/modules',
			5 => 'cache/ziptest/modules/cbLoginHistory/modules/cbLoginHistory',
			6 => 'cache/ziptest/modules/cbLoginHistory/language',
			7 => 'cache/ziptest/modules/cbLoginHistory/language/modules',
			8 => 'cache/ziptest/modules/cbLoginHistory/language/modules/cbLoginHistory',
			9 => 'cache/ziptest/modules/cbLoginHistory/language/modules/cbLoginHistory/language',
			10 => 'cache/ziptest/modules/cbLoginHistory/language/de_de.lang.php',
			11 => 'cache/ziptest/manifest.xml',
		);
		$this->assertEquals($expected, $actual, "unzip $fileName");
		$fileName = 'templates/index.tpl';
		$dirname = dirname($fileName);
		$unzip->unzip($fileName, "$cacheDir/Smarty/templates/modules/cbLoginHistory/".basename($fileName), 0664);
		$actual = $this->getDirectroyListing($cacheDir);
		$expected = array (
			0 => 'cache/ziptest',
			1 => 'cache/ziptest/Smarty',
			2 => 'cache/ziptest/Smarty/templates',
			3 => 'cache/ziptest/Smarty/templates/modules',
			4 => 'cache/ziptest/Smarty/templates/modules/cbLoginHistory',
			5 => 'cache/ziptest/Smarty/templates/modules/cbLoginHistory/templates',
			6 => 'cache/ziptest/Smarty/templates/modules/cbLoginHistory/index.tpl',
			7 => 'cache/ziptest/modules',
			8 => 'cache/ziptest/modules/cbLoginHistory',
			9 => 'cache/ziptest/modules/cbLoginHistory/index.php',
			10 => 'cache/ziptest/modules/cbLoginHistory/modules',
			11 => 'cache/ziptest/modules/cbLoginHistory/modules/cbLoginHistory',
			12 => 'cache/ziptest/modules/cbLoginHistory/language',
			13 => 'cache/ziptest/modules/cbLoginHistory/language/modules',
			14 => 'cache/ziptest/modules/cbLoginHistory/language/modules/cbLoginHistory',
			15 => 'cache/ziptest/modules/cbLoginHistory/language/modules/cbLoginHistory/language',
			16 => 'cache/ziptest/modules/cbLoginHistory/language/de_de.lang.php',
			17 => 'cache/ziptest/manifest.xml',
		);
		$this->assertEquals($expected, $actual, "unzip $fileName");
		$this->recursiveRemoveDirectory($cacheDir);
	}

	/**
	 * Method testunzipAll
	 * @test
	 */
	public function testunzipAll() {
		$cacheDir = 'cache/ziptest';
		$this->recursiveRemoveDirectory($cacheDir);
		$unzip = new Vtiger_Unzip(self::$zipFile);
		@mkdir($cacheDir);
		$unzip->unzipAll($cacheDir);
		$actual = $this->getDirectroyListing($cacheDir);
		$expected = array (
			0 => 'cache/ziptest',
			1 => 'cache/ziptest/modules',
			2 => 'cache/ziptest/modules/cbLoginHistory',
			3 => 'cache/ziptest/modules/cbLoginHistory/index.php',
			4 => 'cache/ziptest/modules/cbLoginHistory/getJSON.php',
			5 => 'cache/ziptest/modules/cbLoginHistory/cbLoginHistoryAjax.php',
			6 => 'cache/ziptest/modules/cbLoginHistory/cbLoginHistory.php',
			7 => 'cache/ziptest/modules/cbLoginHistory/manifest.xml',
			8 => 'cache/ziptest/modules/cbLoginHistory/ExportRecords.php',
			9 => 'cache/ziptest/modules/cbLoginHistory/cbLoginHistory.js',
			10 => 'cache/ziptest/modules/cbLoginHistory/ListView.php',
			11 => 'cache/ziptest/modules/cbLoginHistory/language',
			12 => 'cache/ziptest/modules/cbLoginHistory/language/pt_br.lang.php',
			13 => 'cache/ziptest/modules/cbLoginHistory/language/nl_nl.lang.php',
			14 => 'cache/ziptest/modules/cbLoginHistory/language/it_it.lang.php',
			15 => 'cache/ziptest/modules/cbLoginHistory/language/en_gb.lang.php',
			16 => 'cache/ziptest/modules/cbLoginHistory/language/fr_fr.lang.php',
			17 => 'cache/ziptest/modules/cbLoginHistory/language/hu_hu.lang.php',
			18 => 'cache/ziptest/modules/cbLoginHistory/language/es_es.lang.php',
			19 => 'cache/ziptest/modules/cbLoginHistory/language/de_de.lang.php',
			20 => 'cache/ziptest/modules/cbLoginHistory/language/en_us.lang.php',
			21 => 'cache/ziptest/modules/cbLoginHistory/language/es_mx.lang.php',
			22 => 'cache/ziptest/manifest.xml',
			23 => 'cache/ziptest/templates',
			24 => 'cache/ziptest/templates/index.tpl',
		);
		$this->assertEquals($expected, $actual, "unzipAll");
		$this->recursiveRemoveDirectory($cacheDir);
	}

	private function getDirectroyListing($topdir,$onlydirectories=false) {
		$iter = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator($topdir, RecursiveDirectoryIterator::SKIP_DOTS),
			RecursiveIteratorIterator::SELF_FIRST,
			RecursiveIteratorIterator::CATCH_GET_CHILD // Ignore "Permission denied"
		);
		$actual = array($topdir);
		foreach ($iter as $path => $dir) {
			if (!$onlydirectories or $dir->isDir()) {
				$actual[] = $path;
			}
		}
		return $actual;
	}

	private function recursiveRemoveDirectory($directory) {
		foreach (glob("{$directory}/*") as $file) {
			if (is_dir($file)) {
				$this->recursiveRemoveDirectory($file);
			} else {
				unlink($file);
			}
		}
		@rmdir($directory);
	}
}
?>