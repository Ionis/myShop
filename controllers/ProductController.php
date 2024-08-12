<?php
include_once '../models/ProductModel.php';
include_once '../models/CategoriesModel.php';

function indexAction($smarty) {
    $itemId = $_GET['id'] ?? null;
    if ($itemId == null) exit();

    $allCategories = getAllCategories();
    // Получаем данные продукта
    $recProduct = getProductById($itemId);
    $recCategory = getCategoriesById($recProduct['category_id']);

    $smarty->assign('pageTitle', $recProduct['name_ru']);
    $smarty->assign('allCategories', $allCategories);
    $smarty->assign('recCategory', $recCategory);
    $smarty->assign('recProduct', $recProduct);

    // Создаем флаг
    $smarty->assign('itemInCart', 0);
    if (in_array($itemId, $_SESSION['cart'])) {
        $smarty->assign('itemInCart', 1);
    }

    loadTemplate($smarty, 'product');
}