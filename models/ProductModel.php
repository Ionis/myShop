<?php
/**
 * Получение списка товаров для главной страницы
 * @param $limit - количество товаров
 * @return bool|array
 */
function getLastProducts($limit = null): bool|array
{
    $sql = 'SELECT * FROM products ORDER BY id DESC';   // Сортировка в обратном порядке
    $link = createConnection();

    if ($limit) {
        $sql = $sql . ' LIMIT ' . $limit;
    }
    $result = mysqli_query($link, $sql);
    // if ($result === false) {
    //     echo "Ошибка " . mysqli_error($link);
    // }
    return createSmartyRecArr($result);
}

/**
 * Получение списка товаров для страницы подкатегории
 * @param $id - идентификатор подкатегории
 * @return false|array
 */
function getProductsByCategory($id): false|array
{
    $itemId = intval($id);  // защита от SQL-инъекций
    $sql = 'SELECT * FROM products WHERE category_id = ' . $itemId;
    $link = createConnection();
    $result = mysqli_query($link, $sql);

    return createSmartyRecArr($result);
}

/**
 * Получение информации о конкретном товаре
 * @param $id - идентификатор товара
 * @return array|false|null
 */
function getProductById($id): bool|array|null
{
    $itemId = intval($id);
    $sql = 'SELECT * FROM products WHERE id = ' . $itemId;
    $link = createConnection();
    $result = mysqli_query($link, $sql);

    return mysqli_fetch_assoc($result);
}

function recProductsFromArray($itemsIds): bool|array
{
    $strIds = implode(', ', $itemsIds);
    $sql = 'SELECT * FROM products WHERE  id in (' . $strIds . ')';

    $link = createConnection();
    $result = mysqli_query($link, $sql);
    if ($result === false) {
        echo "Ошибка: " . mysqli_error($link);
        echo $sql;
    }

    return createSmartyRecArr($result);
}