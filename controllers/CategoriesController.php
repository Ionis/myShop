<?php
/**
 * Контроллер страниц подкатегорий
 */

include_once '../models/CategoriesModel.php';
include_once '../models/ProductModel.php';

/**
 * Метод формирования страницы подкатегорий
 * @param $smarty
 */
function indexAction($smarty): void
{
    $childCategoryId = $_GET['id'] ?? null;
    if ($childCategoryId == null) exit();

    $allCategories = getAllCategories();

    // Информация о подкатегории
    $recCategory = getCategoriesById($childCategoryId);
    // Информация о продуктах внутри подкатегории
    $recProducts = getProductsByCategory($childCategoryId);

    $smarty->assign('pageTitle', $recCategory['name_ru']);
    $smarty->assign('allCategories', $allCategories);
    $smarty->assign('recCategory', $recCategory);
    $smarty->assign('recProducts', $recProducts);

    loadTemplate($smarty, 'category');
}