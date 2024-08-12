<?php
/**
 * Контроллер страниц подкатегорий
 */

include_once '../models/CategoriesModel.php';
include_once '../models/ProductModel.php';
include_once '../models/OrdersModel.php';
include_once '../models/PurchaseModel.php';

/**
 * Метод формирования страницы корзины
 * @param $smarty
 */
function indexAction($smarty): void
{
    $itemsIds = $_SESSION['cart'] ?? array();

    $allCategories = getAllCategories();
    if (count($itemsIds) !== 0) {
        $recProducts = recProductsFromArray($itemsIds);
    } else {
        $recProducts = null;
    }

    $smarty->assign('pageTitle', 'Корзина');
    $smarty->assign('allCategories', $allCategories);
    $smarty->assign('recProducts', $recProducts);

    loadTemplate($smarty, 'cart');
}

/**
 * Добавление нового элемента в корзину
 * @return false|void
 */
function addToCartAction()
{
    $itemId = isset($_GET['id']) ? intval($_GET['id']) : null;

    if (!$itemId) return false;

    $resData = array();

    if (isset($_SESSION['cart']) && !in_array($itemId, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $itemId;
        $resData['cntItems'] = count($_SESSION['cart']);
        $resData['success'] = 1;
    } else {
        $resData['success'] = 0;
    }
    echo json_encode($resData);
}

/**
 * Удаление элемента из корзины
 * @return void
 */
function removeFromCartAction(): void
{
    $itemId = isset($_GET['id']) ? intval($_GET['id']) : null;

    if (!$itemId) exit();

    $resData = array();
    $key = array_search($itemId, $_SESSION['cart']);

    if ($key !== false) {
        unset($_SESSION['cart'][$key]);
        $resData['cntItems'] = count($_SESSION['cart']);
        $resData['success'] = 1;
    } else {
        $resData['success'] = 0;
    }
    echo json_encode($resData);
}

/**
 * Формирование страницы заказа
 * @param $smarty
 *
 * @return void
 */
function orderAction($smarty): void
{
    if (!isset($_SESSION['user'])) {
        redirect('/?controller=cart&');
    }
    // Получаем массив идентификаторов товаров
    $itemsIds = $_SESSION['cart'] ?? null;
    if (!$itemsIds) {
        // Если товаров нет, возвращаемся на страницу корзины
        redirect('/?controller=cart');
    }
    $itemsCnt = array();
    foreach ($itemsIds as $item) {
        $postVar = 'itemCnt_' . $item;  // Формируем ключ для массива POST
        $itemsCnt[$item] = $_POST[$postVar] ?? null;
    }

    // Список продуктов из массива корзины
    $recProducts = recProductsFromArray($itemsIds);

    // Для каждой записи о товаре добавляем поле
    // realPrice = кол-во продуктов * цена 1 продкута
    // cnt = количество товара в корзине
    $i = 0;
    foreach ($recProducts as &$item) {
        $item['cnt'] = $itemsCnt[$item['id']] ?? 0;
        if ($item['cnt']) {
            $item['realPrice'] = $item['cnt'] * $item['price'];
        } else {
            // Если вдруг в корзине есть товар с количеством 0 - удаляем его из заказа
            unset($recProducts[$i]);
        }
        $i++;
    }
    if (!$recProducts) {
        echo "Корзина пуста!";
        return;
    }
    // Итоговый массив заказа отправляем в сессию
    $_SESSION['orderFromCart'] = $recProducts;

    $allCategories = getAllCategories();
    $smarty->assign('pageTitle', 'Заказ');
    $smarty->assign('allCategories', $allCategories);
    $smarty->assign('recProducts', $recProducts);

    loadTemplate($smarty, 'order');
}

/**
 * AJAX функция сохранения запроса
 * @param array $_SESSION['orderFromCart'] массив товаров в заказе
 * @return void информация о выполнении операции
 */
function saveOrderAction(): void
{
    $cart = $_SESSION['orderFromCart'] ?? null;

    if (!$cart) {
        $resData['success'] = 0;
        $resData['message'] = 'Нет товаров в заказе';
        echo json_encode($resData);
        return;
    }
    // Могут не существовать, лучше реализовать проверку
    $name = $_REQUEST['name'];
    $phone = $_REQUEST['phone'];
    $address = $_REQUEST['address'];

    // Создаем новый заказ и получаем его ID
    $orderId = makeNewOrder($name, $phone, $address);

    // Проверка корректности записи заказа
    if (!$orderId) {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка создания заказа';
        echo json_encode($resData);
        return;
    }

    // Сохраняем товары созданного заказа
    $res = setPurchaseForOrder($orderId, $cart);

    // Формируем результат сохранения в ответ клиенту
    if ($res) {
        $resData['success'] = 1;
        $resData['message'] = 'Заказ создан';
        unset($_SESSION['orderFromCart']);
        unset($_SESSION['cart']);
    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка сохранения данных заказа № ' . $orderId;
    }

    echo json_encode($resData);
}