<?php



const VERSION = '0.0.1';
const ROOT = __DIR__.'/';

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'];
$uri = $_SERVER['REQUEST_URI'];
$appUrl = $protocol . $host . $uri;


// rutas absolutas de las carpetas del aplicativo

const APP = ROOT . 'app/';
const LOGS = ROOT . 'logs/';
const CONTROLLERS  = APP . 'controllers/';

const MODELS = APP . 'models/';

const ROUTERS = APP . 'routers/';

const SYSTEMS = APP . 'systems/';

const VENDOR = ROOT . 'vendor/';
require VENDOR . 'autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

define("URL_API", $_ENV['URL_API']);

// configuracion base de datos

define("DB_HOST", $_ENV['DB_HOST']);
define("DB_USER", $_ENV['DB_USER']);
define("DB_PASS", $_ENV['DB_PASS']);
define("DB_NAME", $_ENV['DB_NAME']);

define("SECRET_KEY_JWT", $_ENV['SECRET_KEY_JWT']);
const ALGORIT_JWT = 'HS256';