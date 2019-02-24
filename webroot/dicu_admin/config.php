<?php

define('WEBSITE_VERSION', '1.0.0');
define('MAINTENANCE_MODE', false);
//sftp://109.69.238.222/var/www/html/dicu/app/webroot/dicu_admin
define('WEBSITE_NAME', 'DidISeeYou.com');
define('WEBSITE_NAME_FULL', 'DidISeeYou Inc.');
define('SALES_EMAIL', 'sales@didiseeyou.com');
define('SUPPORT_EMAIL', 'support@didseeyou.com');
define('WEBSITE_ADDRESS', 'UK');
define('WEBSITE_TOLLFREE', '');
define('WEBSITE_LOCAL', '');

define('DATE_FORMAT_SHORT', 'M d, Y');
define('DATE_FORMAT_LONG', 'M d, Y @ h:i A');


$server_name = $_SERVER["SERVER_NAME"];
if ($server_name == 'localhost') {
    define('HTTP_SUB_DIR', '/app/webroot/dicu_admin/');
} else {
    define('HTTP_SUB_DIR', '/app/webroot/dicu_admin/');

    if (isset($_GET['store_name']) && !empty($_GET['store_name'])) { // forcefully open any website 
        $server_name = strtolower($_GET['store_name']);
    }

    $server_name = str_replace('www.', '', $server_name);
    //$server_name = 'www.'.$server_name;// force www
}

//absolute http paths
define('HTTPS_SERVER', 'https://' . $server_name . HTTP_SUB_DIR);
define('HTTP_SERVER', 'http://' . $server_name . HTTP_SUB_DIR);

$site_url = HTTP_SERVER;
if (isset($_SERVER['HTTPS'])) {
    $site_url = HTTPS_SERVER;
}
define('HTTP_HTTPS', $site_url);

define('HTTP_IMAGES', HTTP_HTTPS . 'images/');
define('HTTP_UPLOADS', HTTP_HTTPS . 'uploads/');
define('HTTP_CACHE', HTTP_HTTPS . 'cache/');
define('HTTP_JS', HTTP_HTTPS . 'js/');
define('HTTP_CSS', HTTP_HTTPS . 'css/');

//absolute directory paths
define('HTTP_ROOT', str_replace('//', '/', $_SERVER["DOCUMENT_ROOT"] . HTTP_SUB_DIR));
define('HTTP_ROOT_SYSTEM', HTTP_ROOT . 'system/');
define('HTTP_ROOT_UPLOADS', HTTP_ROOT . 'uploads/');
define('HTTP_ROOT_IMAGES', HTTP_ROOT . 'images/');
define('HTTP_ROOT_CACHE', HTTP_ROOT . 'cache/');
define('HTTP_ROOT_COMMON', HTTP_ROOT . 'common/');

// DB
define('DB_DRIVER', 'mysql');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'dicu');
define('DB_PASSWORD', 'uYD0jNFLV89UfzXCv06RnKZEy');
define('DB_DATABASE', 'dicu');
define('DB_PORT', '3306');
define('DB_PREFIX', '');

define('PROFILE_IMG', 'http://109.69.238.222/files/images/');
?>
