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
class coreBOSxhguiWorker {

	public static function enable_cbprofile() {
		$dir = dirname(__DIR__).'/coreBOSTests/xhgui';
		require_once $dir . '/src/Xhgui/Config.php';
		Xhgui_Config::load($dir . '/config/config.default.php');
		if (file_exists($dir . '/config/config.php')) {
			Xhgui_Config::load($dir . '/config/config.php');
		}
		unset($dir);
		if (!(extension_loaded('mongo') || extension_loaded('mongodb')) && Xhgui_Config::read('save.handler') === 'mongodb') {
			error_log('xhgui - extension mongo not loaded');
			return;
		}
		if (!isset($_SERVER['REQUEST_TIME_FLOAT'])) {
			$_SERVER['REQUEST_TIME_FLOAT'] = microtime(true);
		}
		if (extension_loaded('tideways')) {
			tideways_enable(TIDEWAYS_FLAGS_NO_SPANS + TIDEWAYS_FLAGS_CPU + TIDEWAYS_FLAGS_MEMORY);
		} else {
			if (PHP_MAJOR_VERSION == 5 && PHP_MINOR_VERSION > 4) {
				xhprof_enable(XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY | XHPROF_FLAGS_NO_BUILTINS);
			} else {
				xhprof_enable(XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY);
			}
		}
	}

	public static function disable_cbprofile() {
		$data = array();
		if (extension_loaded('tideways')) {
			$data['profile'] = tideways_disable();
		} else {
			$data['profile'] = xhprof_disable();
		}
		ignore_user_abort(true);
		//flush();

		if (!defined('XHGUI_ROOT_DIR')) {
			require dirname(dirname(__FILE__)) . '/coreBOSTests/xhgui/src/bootstrap.php';
		}

		$uri = array_key_exists('REQUEST_URI', $_SERVER) ? $_SERVER['REQUEST_URI'] : null;
		if (empty($uri) && isset($_SERVER['argv'])) {
			$cmd = $_SERVER['PWD'] . basename($_SERVER['argv'][0]);
			$uri = $cmd . ' ' . implode(' ', array_slice($_SERVER['argv'], 1));
		}

		$time = array_key_exists('REQUEST_TIME', $_SERVER) ? $_SERVER['REQUEST_TIME'] : time();
		$requestTimeFloat = explode('.', $_SERVER['REQUEST_TIME_FLOAT']);
		if (!isset($requestTimeFloat[1])) {
			$requestTimeFloat[1] = 0;
		}

		if (Xhgui_Config::read('save.handler') === 'file') {
			$requestTs = array('sec' => $time, 'usec' => 0);
			$requestTsMicro = array('sec' => $requestTimeFloat[0], 'usec' => $requestTimeFloat[1]);
		} else {
			$requestTs = new MongoDate($time);
			$requestTsMicro = new MongoDate($requestTimeFloat[0], $requestTimeFloat[1]);
		}

		$data['meta'] = array(
			'url' => $uri,
			'SERVER' => $_SERVER,
			'get' => $_REQUEST,
			'env' => $_ENV,
			'simple_url' => Xhgui_Util::simpleUrl($uri),
			'request_ts' => $requestTs,
			'request_ts_micro' => $requestTsMicro,
			'request_date' => date('Y-m-d', $time),
		);

		try {
			$config = Xhgui_Config::all();
			$config += array('db.options' => array());
			$saver = Xhgui_Saver::factory($config);
			$saver -> save($data);
		} catch (Exception $e) {
			error_log('xhgui - ' . $e -> getMessage());
		}
	}

}
?>