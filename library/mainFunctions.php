<?php

use JetBrains\PhpStorm\NoReturn;

/**
 * Формирование запрашиваемой страницы
 *
 * @param string $controllerName название контроллера
 * @param string $actionName название функции обработки страницы
 */
function loadPage($smarty, string $controllerName, string $actionName = 'index'): void
{
    include_once PATH_PREFIX.$controllerName.PATH_POSTFIX;
    $function = $actionName . "Action";
    $function($smarty);
}

function loadTemplate($smarty, $templateName): void
{
    $smarty->display($templateName . TMPLT_POSTFIX);
}

function createSmartyRecArr($record): bool|array
{
    if (!$record) return false;
    $smartyRec = array();
    while ($row = mysqli_fetch_array($record)) {
        $smartyRec[] = $row;
    }
    return $smartyRec;
}

#[NoReturn] function redirect(string $url = "/"): void
{
    header("Location: {$url}");
    exit();
}