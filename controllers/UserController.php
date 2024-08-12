<?php
/**
 * Контроллер функций пользователя
 */

use JetBrains\PhpStorm\NoReturn;

include_once "../models/CategoriesModel.php";
include_once "../models/UsersModel.php";

/**
 * Формирование профиля пользователя
 *
 * @param object $smarty
 */
function indexAction(object $smarty): void
{
    $allCategories = getAllCategories();

    $smarty->assign('pageTitle', 'Профиль');
    $smarty->assign('allCategories', $allCategories);
    $smarty->assign('recCategory', null);

    loadTemplate($smarty, 'profile');
}

function templateRegAction($smarty): void
{
    loadTemplate($smarty, 'registration');
}

function templateAuthAction($smarty): void
{
    loadTemplate($smarty, 'authorization');
}

/**
 * AJAX регистрация пользователя
 * Инициализация сессионной переменной ($_SESSION['user'])
 *
 * @return void json массив данных нового пользователя
 */
function registerAction(): void
{
    $email = $_REQUEST['email'] ?? null;
    if (!is_null($email)) {
        $email = trim($email);
    }

    $pwd1 = $_REQUEST['pwd1'] ?? null;
    $pwd2 = $_REQUEST['pwd2'] ?? null;

    $phone = $_REQUEST['phone'] ?? null;
    $address = $_REQUEST['address'] ?? null;

    $name = $_REQUEST['name'] ?? null;
    if (!is_null($name)) {
        $name = trim($name);
    }

    $resData = null;
    $resData = checkRegisterParams($email, $pwd1, $pwd2);

    if (!$resData && checkUserEmail($email)) {
        $resData['success'] = 0;
        $resData['message'] = 'Пользователь с таким email (' . $email . ') уже существует';
    }

    if (!$resData) {
        $pwHash = password_hash($pwd1, PASSWORD_BCRYPT);

        $userData = registerNewUser($email, $pwHash, $name, $phone, $address);
        if ($userData['success']) {
            $resData['message'] = 'Пользователь успешно зарегистрирован';
            $resData['success'] = 1;

            $userData = $userData[0];
            $resData['userName'] = $userData['name'] ?: $userData['email'];
            $resData['userEmail'] = $email;

            $_SESSION['user'] = $userData;
            $_SESSION['user']['displayName'] = $userData['name'] ?: $userData['email'];
        } else {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка регистрации';
        }
    }
    header('Content-Type: application/json');
    echo json_encode($resData, JSON_UNESCAPED_UNICODE);
}

/**
 * Разлогирование пользователя
 * @return void
 */
function logoutAction(): void
{
    if (isset($_SESSION['user'])) {
        unset($_SESSION['user']);
        unset($_SESSION['cart']);
    }
    redirect('/');
}

/**
 * AJAX авторизация пользователя
 * @return void json массив авторизованного пользователя
 */
function loginAction(): void
{
    $email = $_REQUEST['email'] ?? null;
    $email = trim($email);

    $pwd = $_REQUEST['pwd'] ?? null;
    $pwd = trim($pwd);

    $userData = loginUser($email, $pwd);

    if ($userData['success']) {
        $userData = $userData[0];

        // Инициализируем сессионную переменную
        $_SESSION['user'] = $userData;
        $_SESSION['user']['displayName'] = $userData['name'] ?: $userData['email'];

        $resData['userName'] = $_SESSION['user'];
        $resData['success'] = 1;
    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Неверный email или пароль';
    }
    header('Content-Type: application/json');
    echo json_encode($resData, JSON_UNESCAPED_UNICODE);
}

/**
 * Обновление данных пользователя
 *
 * @return string|false json результат выполнения операции
 */
function updateAction(): string|false
{
    if (!isset($_SESSION['user'])) {
        redirect('/');
    }

    $resData = array();

    $phone = $_REQUEST['phone'] ?? null;
    $address = $_REQUEST['address'] ?? null;
    $name = $_REQUEST['name'] ?? null;
    $pwd1 = $_REQUEST['pwd1'] ?? null;
    $pwd2 = $_REQUEST['pwd2'] ?? null;
    $curPwd = $_REQUEST['curPwd'] ?? null;

    if (!$curPwd || (password_verify($curPwd, $_SESSION['user']['pwd']))) {
        $resData['success'] = 0;
        $resData['message'] = "Неверный пароль";
//        header('Content-Type: application/json');
        echo json_encode($resData);
        return false;
    }

    $res = updateUserData($name, $phone, $address, $pwd1, $pwd2);
    if ($res) {
        $resData['success'] = 1;
        $resData['message'] = "Данные сохранены";
        $resData['userName'] = $name;

        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['phone'] = $phone;
        $_SESSION['user']['address'] = $address;

        $newPwd = $_SESSION['user']['pwd'];
        if ($pwd1 && ($pwd1 == $pwd2)) {
            $newPwd = password_hash(trim($pwd1), PASSWORD_BCRYPT);
        }
        $_SESSION['user']['pwd'] = $newPwd;

        $_SESSION['user']['displayName'] = $name ?: $_SESSION['user']['email'];
    } else {
        $resData['success'] = 0;
        $resData['message'] = "Ошибка сохранения данных";
    }
//    header('Content-Type: application/json');
    echo json_encode($resData);
    return false;
}