<?php
/**
 * Модель для таблицы пользователей
 */

/**
 * Регистрация нового пользователя
 *
 * @param string|null $email   электронная почта пользователя
 * @param string|null $pwHash  хэш пароля
 * @param string|null $name    имя пользователя
 * @param string|null $phone   номер телефона
 * @param string|null $address адрес пользователя
 *
 * @return array массив данных нового пользователя
 */
function registerNewUser(string|null $email, string|null $pwHash, string|null $name, string|null $phone, string|null $address): array
{
    if ($email !== null) {
        $email = htmlspecialchars($email);
    } else {
        $email = '';
    }

    if ($name !== null) {
        $email = htmlspecialchars($name);
    } else {
        $name = '';
    }

    if ($phone !== null) {
        $email = htmlspecialchars($phone);
    } else {
        $phone = '';
    }

    if ($address !== null) {
        $email = htmlspecialchars($address);
    } else {
        $address = '';
    }

    $sql = "INSERT INTO users (`email`, `pwd`, `name`, `phone`, `address`) VALUES ('{$email}', '{$pwHash}', '{$name}', '{$phone}', '{$address}')";
    $link = createConnection();
    $result = mysqli_query($link, $sql);

    if ($result) {
        $sql = "SELECT * FROM users WHERE (`email` = '{$email}' and `pwd` = '{$pwHash}') LIMIT 1";
        $result = mysqli_query($link, $sql);
        $result = createSmartyRecArr($result);

        if (isset($result[0])) {
            $result['success'] = 1;
        } else {
            $result['success'] = 0;
        }
    } else {
        $result['success'] = 0;
    }

    return $result;
}

/**
 * Проверка параметров для регистрации пользователя
 * @param string $email
 * @param string $pwd1
 * @param string $pwd2
 * @return array|null результат
 */
function checkRegisterParams(string $email, string $pwd1, string $pwd2): array|null
{
    $result = null;

    if (!$email) {
        $result['success'] = null;
        $result['message'] = 'Введите email';
    }
//    if (!$pwd1) {
//        $result['success'] = null;
//        $result['message'] = 'Введите пароль';
//    }
    if (!$email) {
        $result['success'] = null;
        $result['message'] = 'Повторите пароль';
    }
    if ($pwd1 != $pwd2) {
        $result['success'] = null;
        $result['message'] = 'Пароли не совпадают';
    }
    return $result;
}

/**
 * Проверка почты на наличие дубликата
 * @param string $email
 * @return array массив - строка из таблицы users/пустой массив
 */
function checkUserEmail(string $email): array
{
    $email = htmlspecialchars($email);
    $sql = "SELECT id FROM users WHERE email = '" . $email . "'";
    $link = createConnection();
    $result = mysqli_query($link, $sql);

    return createSmartyRecArr($result);
}

/**
 * Авторизация пользователя
 *
 * @param string $email  почта
 * @param string $pwd пароль
 *
 * @return array массив данных пользователя
 */
function loginUser(string $email, string $pwd): array
{
    $email = htmlspecialchars($email);
    $sql = "SELECT * FROM users WHERE `email` = '" . $email . "' LIMIT 1";
    $link = createConnection();
    $result = mysqli_query($link, $sql);

    $result = createSmartyRecArr($result);
    if (isset($result[0]) && password_verify($pwd, $result[0]['pwd'])) {
        $result['success'] = 1;
    } else {
        $result['success'] = 0;
    }
    return $result;
}

/**
 * Изменение данных пользователя
 *
 * @param string $name    имя пользователя
 * @param string $phone   телефон пользователя
 * @param string $address адрес пользователя
 * @param string $pwd1    новый пароль
 * @param string $pwd2    повтор нового пароля
 *
 * @return bool TRUE в случае успеха
 */
function updateUserData(string $name, string $phone, string $address, string $pwd1, string $pwd2): bool
{
    $email = htmlspecialchars($_SESSION['user']['email']);
    $name = htmlspecialchars($name);
    $phone= htmlspecialchars($phone);
    $address = htmlspecialchars($address);
    $pwd1 = trim($pwd1);
    $pwd2 = trim($pwd2);

    $newPwd = null;
    if ($pwd1 && ($pwd1 === $pwd2)) {
        $newPwd = password_hash($pwd1, PASSWORD_BCRYPT);
    }

    $sql = "UPDATE users SET ";
    if ($newPwd) {
        $sql .= "`pwd` = '{$newPwd}', ";
    }
    $sql .= "`name` = '{$name}', `email` = '{$email}', `phone` = '{$phone}', `address` = '{$address}' ";
    $sql .= "WHERE `email` = '{$email}' LIMIT 1";
    $link = createConnection();

    return mysqli_query($link, $sql);
}