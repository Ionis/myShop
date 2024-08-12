<?php
/**
 * Файл настроек проекта
 */

 // Константы для обращения к контроллерам
const PATH_PREFIX = '../controllers/';
const PATH_POSTFIX = 'Controller.php';

// Папка шаблона
$templateFolder = 'default';

// Пути к шаблонам
define('TMPLT_PREFIX', "../views/{$templateFolder}/");
const TMPLT_POSTFIX = '.tpl';

// Константы для подключения к БД
const DB_HOST = 'localhost';
const DB_NAME = 'my_shop';
const DB_USER = 'root';
const DB_PASSWORD = '';

// Количество самых последних товаров
const LASTPRODUCTS = 12;

// Путь к шаблонам www
define('TMPLT_WEBPATH', "/templates/{$templateFolder}/");

// Подключение класса Smarty()
require('../library/Smarty/libs/Smarty.class.php');
$smarty = new Smarty();
// Конфигурация объекта smarty
$smarty->setTemplateDir(TMPLT_PREFIX);
$smarty->setCompileDir('../tmp/smarty/template_c');
$smarty->setCacheDir('../tmp/smarty/cache');
$smarty->setConfigDir('../library/Smarty/configs');

$smarty->assign('templateWebPath', TMPLT_WEBPATH);