<?php

const APP_URL = "http://localhost/lab_prog_2026_escalante_fuentes_elias/";
define('APP_URI', $_SERVER['DOCUMENT_ROOT'] . 'lab_prog_2026_escalante_fuentes_elias/app/');

define('APP_DIR_TEMPLATE', APP_URI . 'resources/template/');
define('APP_DIR_VIEWS', APP_URI . 'resources/views/');
define('APP_DIR_REPORTS', APP_URI . 'resources/reports/');

define('APP_FILE_TEMPLATE',     APP_DIR_TEMPLATE . 'template.php');
define('APP_FILE_LOG_ERRORS',   APP_URI.'logs/error.log');
define('APP_FILE_LOG_ACCESS',   APP_URI.'logs/access.log');

define('APP_FILE_LOGIN',    APP_DIR_VIEWS . 'authentication/index.php');
define('APP_FILE_LOGOUT',   APP_DIR_VIEWS . 'authentication/logout.php');


const APP_DEFAULT_CONTROLLER = "home";
const APP_DEFAULT_ACTION = "index";
const APP_AUTHENTICATION_CONTROLLER = "authentication";
const APP_LOGIN_ACTION = "login";
const APP_LOGOUT_ACTION = "logout";

const APP_TOKEN = 