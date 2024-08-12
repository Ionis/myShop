function addToCart(itemId) {
    console.log("js-addToCart()");
    $.ajax({
        type: 'POST',
        async: false,
        url: "/?controller=cart&action=addToCart&id=" + itemId + "/",
        dataType: 'json',
        success: function (data) {
            if (data['success']) {
                $('#cartCntItems').html(data['cntItems']);
                $('#addCart_' + itemId).hide();
                $('#removeFromCart_' + itemId).show();
            }
        }
    });
}

function removeFromCart(itemId) {
    console.log("js-removeFromCart()");
    $.ajax({
        type: 'POST',
        async: false,
        url: "/?controller=cart&action=removeFromCart&id=" + itemId + "/",
        dataType: 'json',
        success: function (data) {
            if (data['success']) {
                $('#cartCntItems').html(data['cntItems']);
                $('#addCart_' + itemId).show();
                $('#removeFromCart_' + itemId).hide();
            }
        }
    });
}

/**
 * Получение данных из формы
 * @param obj_form
 * @returns {{}}
 */
function getData(obj_form) {
    let hData = {};
    $('input, textarea, select', obj_form).each(function () {
        if (this.name && this.name !== '') {
            hData[this.name] = this.value;
            // console.log('hData[' + this.name + '] = ' + hData[this.name]);
        }
    });
    return hData;
}

function registerNewUser() {
    let postData = getData('#reg');
    $.ajax({
        type: 'POST',
        async: false,
        url: '/?controller=user&action=register&email=' + postData['email'] + '&pwd1=' + postData['pwd1'] + '&pwd2=' + postData['pwd2'],
        tataType: 'json',
        success: function (data) {
            alert(data.message);
            if (data.success) {
                window.location.href = '/';
            }
        }
    });
}

function loginUser() {
    let postData = getData('#auth');
    // console.log(postData);

    $.ajax({
        type: "POST",
        async: false,
        url: '/?controller=user&action=login&email=' + postData['emailLogin'] + '&pwd=' + postData['pwdLogin'],
        dataType: 'json',
        success: function (data) {
            if (data.success) {
                window.location.href = '/';
            } else {
                alert(data.message);
            }
        }
    });
}

function updateUserData() {
    let postData = getData('#profile');
    // console.log(postData);

    $.ajax({
        type: 'POST',
        async: false,
        url: '/?controller=user&action=update&name=' + postData['newName'] + '&phone=' + postData['newPhone'] + '&address=' + postData['newAddress'] + '&pwd1=' + postData['newPwd1'] + '&pwd2=' + postData['newPwd2'] + '&curPwd=' + postData['curPwd'],
        dataType: 'json',
        success: function (data) {
            if (data['success']) {
                alert(data.message);
            } else {
                alert(data.message);
            }
        }
    });
}

/**
 * Сохранение заказа
 */
function saveOrder() {
    let name = $('#userName').html();
    let phone = $('#userPhone').html();
    let address = $('#userAddress').html();
    console.log(name, phone, address);
    $.ajax({
        type: 'POST',
        async: false,
        url: '/?controller=cart&action=saveOrder&name=' + name + '&phone=' + phone + '&address=' + address,
        dataType: 'json',
        success: function (data) {
            if (data.success) {
                alert(data.message);
            } else {
                alert(data.message);    // Сообщение об ошибке
            }
        }
    });
}