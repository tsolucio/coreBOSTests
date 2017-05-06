coreBOS Tests
=======

**core Business Operating System Tests and Profiles**

Set of functional, unit and integrations tests, and performance benchmarking scripts for the [coreBOS Project](http://corebos.org/).

The goal of the project is to create a set of automatic validations, more oriented towards [Behavior-Driven Development](http://en.wikipedia.org/wiki/Behavior_driven_development) than unit tests, because unit tests would be overkill and extremely difficult at this stage for such a complex project. We will prefer and create functional and integration tests over unit tests although some unit tests will make it into the mix (curiously unit tests have been the first to make it into the project :-) ).

Installation
-------

Clone the the full [coreBOS repository](https://github.com/tsolucio/corebos). The coreBOS Tests project is a submodule inside the coreBOS github repository. So you will have to follow the typical steps to get the code from the submodule:
```
git submodule init
git submodule update
```

Create a database with the contents of the test database which can be found in build/coreBOSTests/database/coreBOSTests.sql

Next copy the test config.inc.php file from build/coreBOSTests/database/config.inc.php to the root of the test project:
```
cd {coreBOSTests Project directory}
cp build/coreBOSTests/database/config.inc.php .
```
Now edit the file and correctly set the variables:
* site_URL
* root_directory
* database configuration

You should be able to log in with the user and password "admin".

* go to coreBOS Updater, load and apply all changes (as always)
* go to Settings > Access Privileges and "Recalculate"
* go to Settings > Module Manager. Deactivate and Activate the Assets module (for example). We do this to generate and update the tabdata.php file.

You should be able to run the different tests now.

Test Execution
-------

To launch the **functional/behavior tests**, go into the root coreBOS directory and launch this command:

```build/coreBOSTests/phpunit -c build/coreBOSTests/phpunit.xml```

Optionally with debugging for more verbose output:

```build/coreBOSTests/phpunit --debug -c build/coreBOSTests/phpunit.xml```

If you want to execute the **integration tests**, you will need a selenium server. On my server I use this to get selenium ready:

```java -jar selenium-server-standalone-2.52.0.jar -Dwebdriver.chrome.driver=/var/www/coreBOSTest/build/coreBOSTests/vendor/webdriver/chromedriver```

Then you can launch the tests with:

```build/coreBOSTests/phpunit -c build/coreBOSTests/integration.xml```

Individual tests suites
-------

In the files build/coreBOSTests/phpunit.xml and build/coreBOSTests/integration.xml you will find definitions of the different test suites that can be launched individually if needed.

Test browser
----------

By default, the integration tests are executed in firefox and chrome browsers, which are the two coreBOS officially supported browsers. So your selenium server must have the chrome driver loaded. You can find a driver for linux 64bit in build/coreBOSTests/vendor/webdriver/. You can add other browsers by adding the corresponding webdriver in your selenium server and changing the base integration test class which can be found at build/coreBOSTests/integration/cbIntegrationTest.php

Developing Tests
----------

For functional and unit tests just follow phpunit good practices by creating test scripts in the same structure as the original file and with the recommended file naming conventions.

Then edit the test suites accordingly if necessary.

For integration tests the same rules apply except that the base class for tests is the one that coreBOSTests uses, so all our integration tests inherit the two browser testing. The integration tests are launched in **http://localhost/coreBOSTest** so the coreBOS test installation **MUST** live there (you can change that in the integration/cbIntegrationTest.php file). You can look at the existing tests for examples, but it basically means something like this:

```
<?php
//put your license here
require_once 'build/coreBOSTests/integration/cbIntegrationTest.php';

class YourIntegrationTest extends cbIntegrationTest
{
...
```

Profiling
-------
This project also caters the needs of profiling the application. To accomplish this, we use the [XHProf PHP](http://pecl.php.net/package/xhprof) and [Tideways](https://tideways.io/) extensions and the visual user interface [XHGUI](https://github.com/perftools/xhgui.git).

To get profiling working you need to:
* install the XHProf PHP or Tideways extension in your PHP (uprofiler has not been tested but should work also)
* install mongodb and mongodb PHP libraries
* your apache must be configured to accept .htaccess directives because the build directory is protected from web access so we need to eliminate that restriction for the xhgui direcotry
* your apache must have mod_rewrite loaded
* get the latest code of the coreBOSTest project (see above)
* inside the xhgui directory (build/coreBOSTests/xhgui) you have to download composer.phar and execute `composer update`
* register the profiling calls:
```
cd {coreBOSTests Project directory}
cp build/coreBOSTests/registerxhgui.php .
php registerxhgui.php
rm registerxhgui.php
```

That is all that is needed. As you work with the application, profiling information will be dumped into the mongodb database and you will be able to view it accessing the XHGUI site at (**localhost!**):

```
http://localhost/your_corebos/build/coreBOSTests/xhgui/webroot/
```

**A profiling register will be made for approximately every 10 accesses to the application.**

If you want to **force a registration** in any part of the code you have to take these steps:

* include the coreBOSxhguiWorker class

```
include_once('build/coreBOSTests/cbxhgui.php');
 ```
 
* enable the profile at the start of the code you want to analyze

```
coreBOSxhguiWorker::enable_cbprofile();
```

* disable the profile at the end of the code you want to analyze

```
coreBOSxhguiWorker::disable_cbprofile();
```

For example, to analyze List View calls you would apply this patch:

```
diff --git a/modules/Vtiger/ListView.php b/modules/Vtiger/ListView.php
index 1bc9257..c5f5dce 100644
--- a/modules/Vtiger/ListView.php
+++ b/modules/Vtiger/ListView.php
@@ -8,7 +8,8 @@
  * All Rights Reserved.
  ************************************************************************************/
 global $app_strings, $mod_strings, $current_language, $currentModule, $theme, $list_max_entries_per_page;
-
+include_once('build/coreBOSTests/cbxhgui.php');
+coreBOSxhguiWorker::enable_cbprofile();
 require_once('Smarty_setup.php');
 require_once('include/ListView/ListView.php');
 require_once('modules/CustomView/CustomView.php');
@@ -231,5 +232,5 @@ if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '')
        $smarty->display("ListViewEntries.tpl");
 else
        $smarty->display('ListView.tpl');
-
+coreBOSxhguiWorker::disable_cbprofile();
 ?>
```

This setup is based on the work described in engineyard.com blog post [**Profiling PHP with Xhprof & Xhgui**](https://blog.engineyard.com/2014/profiling-with-xhprof-xhgui-part-1) which is a recommended read along with the article [Profiling PHP Applications with XHGui](https://inviqa.com/blog/profiling-xhgui). Some other helpful links are:

  * [Tideways PHP Profiler Extension](https://github.com/tideways/php-profiler-extension)
  * [How To Set Up XHProf and XHGui for Profiling PHP Applications on Ubuntu 14.04](https://www.digitalocean.com/community/tutorials/how-to-set-up-xhprof-and-xhgui-for-profiling-php-applications-on-ubuntu-14-04#step-4-—-set-up-mongodb-indexes-(optional))
  * [xhgui](https://github.com/perftools/xhgui)

Tideways extension
-------

This is what my tideways extension settings look like on PHP7

```
; Configuration for Tideways Profiler Extension
; priority=40
extension=tideways.so
tideways.load_library=0
tideways.auto_prepend_library=0
tideways.auto_start=0
tideways.monitor=FULL
tideways.collect=FULL
tideways.monitor_cli=1

; Tideways Application API-Key to configure when using just one application on
; this php installation.
;tideways.api_key=

; Configure the profiling sample rate for this PHP server globally.  The given
; number is an integer representing percent between 0 and 100
tideways.sample_rate=100

; Automatically detect transactions and exceptions of a given framework The
; following frameworks are currently supported:
;
; symfony2, symfony2c, shopware, oxid, magento, zend1, zend2, laravel,
; wordpress
;tideways.framework=
```


License
-------

[MIT](https://github.com/tsolucio/coreBOSTests/blob/master/LICENSE.md)

**Thank you** very much for your help and contribution.

*coreBOS Team*
