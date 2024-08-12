<?php
// Модель категорий для меню

 /**
  * Создание подключения к БД
  *
  * @return mysqli|bool
  */
 function createConnection(): bool|mysqli
 {
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if ($link === false) {
        // $err = "Невозможно подключиться к MYSQL. Ошибка: " . mysqli_connect_error();
        return false;
    } else {
        // echo 'Соединение установлено успешно!<br>';
        // mysqli_set_charset($link, 'utf8');
        return $link;
    }
    
 }

 /**
  * Получение категорий товаров из БД
  *
  * @return array|bool
  */
 function getAllCategories(): bool|array
 {
    $sql = 'SELECT * FROM categories WHERE parent_id = 0';
    $link = createConnection();
    $result = mysqli_query($link, $sql);
    $smartyArray = array();

    if ($result === false) {
        // $err = "Невозможно выполнить запрос. Ошибка: " . mysqli_error($link);
        return false;
    } else {
        while ($row = mysqli_fetch_array($result)) {
            $recChildren = getChildren($row['id']);
            if ($recChildren) {
                $row['children'] = $recChildren;
            }
            $smartyArray[] = $row;
            $child = 3;
        }
    }
    return $smartyArray;
    
 }

/**
 * Получение подкатегорий товаров из БД
 * @param $recId - идентификатор категории
 * @return array|false
 */
 function getChildren($recId): array|false
 {
    $sql = 'SELECT * FROM categories WHERE parent_id = ' . $recId;
    $link = createConnection();
    $result = mysqli_query($link, $sql);
    return createSmartyRecArr($result);
 }

/**
 * Получение информации о подкатегории
 * @param $id - идентификатор категории
 * @return array|false|null
 */
 function getCategoriesById($id): array|false|null
 {
     $categoryId = intval($id); // защита от SQL-инъекций
     $sql = 'SELECT * FROM categories WHERE id = ' . $categoryId;
     $link = createConnection();
     $result = mysqli_query($link, $sql);

     if ($result === false) {
         echo "Ошибка: " . mysqli_error($link);
     }

     return mysqli_fetch_assoc($result);    // Возвращаем ассоциативный массив
 }