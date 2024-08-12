<!doctype html>
<html lang="en">
<head>
    {include file = "../includes/head.tpl"}
</head>
<body>
{include file = "../includes/header.tpl"}
<div class = "wrapper">
    {include file = "../includes/sidebarMenu.tpl"}
    <div id="content">
        <h5>Ваш заказ</h5>
        <form id = "formOrder" action = "/?controller=cart&action=saveOrder" method = "POST">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12">
                    {foreach $recProducts as $item name=products}
                        <div class="card rounded-3 mb-4">
                            <div class="card-body p-4" style = "font-size: 13px;">
                                <div class="row d-flex justify-content-between align-items-center">
                                    <div class="col-md-2">
                                        <img src="img/products/{$item['image']}" class="img-fluid rounded-3" alt="{$item['name_ru']}">
                                    </div>
                                    <label name="{$item['name_ru']}" class="col-md-4 col-lg-4 col-xl-4" style="color: black">{$item['name_ru']}</label>
                                    <div class="col-md-3 d-flex">
                                        <label name="itemCnt_{$item['id']}" id="itemCnt_{$item['id']}">Количество: {$item['cnt']}</label>
                                    </div>
                                    <div class="col-md-2">
                                        <h9 id="itemRealPrice_{$item['id']}" class="mb-0">{$item['realPrice']} руб.</h9>
                                    </div>
                                    <div class="col-md-1 col-lg-1 col-xl-1 text-end">

                                    </div>
                                </div>
                            </div>
                        </div>
                    {/foreach}
                    <h6>Данные получателя: </h6>
                    <div class="col-md-6 border-right">
                        <div class="p-2 py-1">
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label class="labels">Email: </label><label id = "userEmail" class="labels"> {$arrUser['email']}</label>
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Имя: </label><label id = "userName"  class="labels"> {$arrUser['name']}</label>
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Телефон: </label><label id = "userPhone"  class="labels"> {$arrUser['phone']}</label>
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Адрес доставки: </label><label id = "userAddress" class="labels"> {$arrUser['address']}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-pills order">
                        <li class="nav-item">
                            <button class="btn btn-primary btn-sm" type="button" onclick="saveOrder();">Оформить заказ</button>
                        </li>
                    </ul>
                </div>
            </div>
        </form>
    </div>
</div>

{include file = "../includes/footer.tpl"}

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</html>