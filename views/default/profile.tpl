<!DOCTYPE html>
<html lang="en">
<head>
    {include file="../includes/head.tpl"}
</head>
<body>
{include file="../includes/header.tpl"}
<div class="wrapper">
    {include file="../includes/sidebarMenu.tpl"}
    <div id="content">
        <h5>Профиль</h5>
        <div class="col-md-7 border-right" id = "profile">
            <div class="p-2 py-1">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="labels">Email</label>
                        <label class="labels"> {$arrUser['email']}</label>
                    </div>
                    <div class="col-md-12">
                        <label class="labels">Имя</label>
                        <input type="text" class="form-control" id="newName" name="newName" value={$arrUser['name']}>
                    </div>
                    <div class="col-md-12">
                        <label class="labels">Телефон</label>
                        <input type="text" class="form-control" id="newPhone" name="newPhone" value={$arrUser['phone']}>
                    </div>
                    <div class="col-md-12">
                        <label class="labels">Адрес</label>
                        <input type="text" class="form-control" id="newAddress" name="newAddress" value={$arrUser['address']}>
                    </div>
                    <div class="col-md-12">
                        <label class="labels">Новый пароль</label>
                        <input type="text" class="form-control" id="newPwd1" name="newPwd1" value="">
                    </div>
                    <div class="col-md-12">
                        <label class="labels">Повторите пароль</label>
                        <input type="text" class="form-control" id="newPwd2" name="newPwd2" value="">
                    </div>
                    <div class="col-md-12">
                        <label class="labels">Введите старый пароль</label>
                        <input type="text" class="form-control" id="curPwd" name="curPwd" value="">
                    </div>
                </div>
                <div class="mt-5 text-center">
                    <button class="btn btn-primary btn-sm" type="button" onclick="updateUserData();">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
</div>
{include file="../includes/footer.tpl"}
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</html>