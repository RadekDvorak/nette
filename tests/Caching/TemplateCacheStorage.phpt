<?php

/**
 * Test: Nette\Caching\TemplateCacheStorage test.
 *
 * @author     David Grudl
 * @category   Nette
 * @package    Nette\Caching
 * @subpackage UnitTests
 */

use Nette\Caching\Cache;



require __DIR__ . '/../initialize.php';



$key = 'nette';
$value = '<?php echo "Hello World" ?>';

// temporary directory
define('TEMP_DIR', __DIR__ . '/tmp');
TestHelpers::purge(TEMP_DIR);



$cache = new Cache(new Nette\Templates\TemplateCacheStorage(TEMP_DIR));


Assert::false( isset($cache[$key]), 'Is cached?' );

Assert::null( $cache[$key], 'Cache content' );

// Writing cache...
$cache[$key] = $value;

$cache->release();

Assert::true( isset($cache[$key]), 'Is cached?' );

Assert::true( (bool) preg_match('#nette\.php$#', $cache[$key]['file']) );
Assert::true( is_resource($cache[$key]['handle']) );

$var = $cache[$key];

// Test include

// this is impossible
// $cache[$key] = NULL;

ob_start();
include $var['file'];
Assert::same( 'Hello World', ob_get_clean() );

fclose($var['handle']);
