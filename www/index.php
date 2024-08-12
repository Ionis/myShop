<?php

global $smarty;
session_start();    // Начинаем сессию

// Если в сессии нет массива корзины, тогда мы его создаем
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Включаем отображение ошибок
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include_once '../config/config.php';
include_once '../library/mainFunctions.php';

$controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) : 'Index';
$actionName = $_GET['action'] ?? 'index';

if (isset($_SESSION['user'])) {
    $smarty->assign('arrUser', $_SESSION['user']);
}

//echo "<pre>";
//echo print_r($_SESSION, true);
//echo "</pre>";

$smarty->assign('cartCntItems', count($_SESSION['cart']));

loadPage($smarty, $controllerName, $actionName);