<?php
// HTTP
define('HTTP_SERVER', 'http://loudcar-local.com.ua/');

// HTTPS
define('HTTPS_SERVER', 'http://loudcar-local.com.ua/');

// DIR
define('DOC_ROOT', substr($_SERVER['DOCUMENT_ROOT'], -1) == '/' ? substr($_SERVER['DOCUMENT_ROOT'], 0, strlen($_SERVER['DOCUMENT_ROOT'])-1) : $_SERVER['DOCUMENT_ROOT']);
define('DIR_APPLICATION', DOC_ROOT . '/catalog/');
define('DIR_SYSTEM', DOC_ROOT . '/system/');
define('DIR_IMAGE', DOC_ROOT . '/image/');
define('DIR_STORAGE', DOC_ROOT . '/..' . '/storage/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'view/theme/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');
define('DIR_CACHE', DIR_STORAGE . 'cache/');
define('DIR_DOWNLOAD', DIR_STORAGE . 'download/');
define('DIR_LOGS', DIR_STORAGE . 'logs/');
define('DIR_MODIFICATION', DIR_STORAGE . 'modification/');
define('DIR_SESSION', DIR_STORAGE . 'session/');
define('DIR_UPLOAD', DIR_STORAGE . 'upload/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'loudcar');
define('DB_PORT', '3306');
define('DB_PREFIX', 'oc_');