<?php
/**
 * Created by PhpStorm.
 * User: slim
 * Date: 13/10/17
 * Time: 12:33
 */

ini_set('display_errors', 'On');
ini_set('html_errors', 'On');
ini_set('xdebug.trace_output_name', 'encryption.%t');

define('DIRSEP', DIRECTORY_SEPARATOR);

$url_root = $css_path = $_SERVER['SCRIPT_NAME'];
$url_root = implode('/', explode('/', $url_root, -1));
$css_path = $url_root . '/css/standard.css';

$script_filename = $_SERVER["SCRIPT_FILENAME"];
$arr_script_filename = explode('/' , $script_filename, '-1');
$script_path = implode('/', $arr_script_filename) . '/';

define ('LIB_CHART_OUTPUT_PATH', 'media/charts/');
define ('LIB_CHART_FILE_PATH', $script_path);
define ('LIB_CHART_CLASS_PATH', 'libchart/classes/');

//unique ID to identify our messages
$unique_identifier = "AF72";
define('DEVICE_ID', $unique_identifier);

//define destination msisdn
$dest_msisdn = 447817814149;
define('DEST_MSISDN', $dest_msisdn);

//logging setting
$log_file_path = "/p3t/phpappfolder/logs/testlog.log";
define('LOG_FILE_PATH', $log_file_path);

define('CSS_PATH', $css_path);
define('APP_NAME', 'Telemetry Basic');
define('LANDING_PAGE', $_SERVER['SCRIPT_NAME']);

$nav_links = [
    'Home' => 'home',
    'View' => 'viewsettings',
    'Send' => 'sendsettings',
];
define('NAV_LINKS', $nav_links);

$wsdl = 'https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl';
define('WSDL', $wsdl);

$settings = [
    "settings" => [
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,
        'mode' => 'development',
        'debug' => true,
        'view' => [
            'template_path' => __DIR__ . '/templates/',
            'twig' => [
                'cache' => false,
                'auto_reload' => true,
            ]
        ],
    ],
    'doctrine_settings' => [
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'telemetry_db',
        'port' => '3306',
        'user' => 'telemetry_user',
        'password' => 'telemetry_user_pass',
        'charset' => 'utf8mb4'
    ],
];

return $settings;
