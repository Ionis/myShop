<?php

/**
 * Внесение в БД продуктов с привязкой к заказу
 *
 * @param int   $orderId ID заказа
 * @param array $cart    массив корзины
 *
 * @return bool TRUE в случае успешного добавления в БД
 */
function setPurchaseForOrder(int $orderId, array $cart): bool
{
    $sql = "INSERT INTO purchase (`order_id`, `product_id`, `price`, `amount`) VALUES ";
    // Формируем массив строк для запроса по каждому товару
    $values = array();
    foreach ($cart as $item) {
        $values[] = "('{$orderId}', '{$item['id']}', '{$item['price']}', '{$item['cnt']}')";
    }
    // Преобразуем массив в строку
    $sql .= implode(', ', $values);
    $link = createConnection();

    return mysqli_query($link, $sql);
}