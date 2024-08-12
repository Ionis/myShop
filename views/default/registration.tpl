<!doctype html>
<html lang="en">
<head>
    {include file = "../includes/head.tpl"}
</head>
<body>
<div class = "wrapper">
    <div class="form" id="reg">
        <section class="vh-30">
            <div class="container h-30">
                <div class="row d-flex justify-content-center align-items-center h-30">
                    <div class="col-lg-8">
                        <div class="card text-black" style="border-radius: 25px;">
                            <div class="card-body p-md-1">
                                <div class="row justify-content-center">
                                    <div class="col-md-6 order-2">
                                        <p class="text-center h3 mb-3 mx-2 mx-md-4 mt-4">Регистрация</p>
                                        <form class="mx-1 mx-md-4">
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <input type="email" id="email" class="form-control" name = "email"/>
                                                    <label class="form-label" for="email">Email</label>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <input type="password" id="pwd1" class="form-control" name = "pwd1"/>
                                                    <label class="form-label" for="pwd1">Пароль</label>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                                <div class="form-outline flex-fill mb-0">
                                                    <input type="password" id="pwd2" class="form-control" name = "pwd2"/>
                                                    <label class="form-label" for="pwd2">Повторите пароль</label>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center mx-4 mb-3">
                                                <button type="button" class="btn btn-primary" onclick="registerNewUser();">Отправить</button>
                                                <a href = "/" type="button" class="btn btn-outline-primary me-2" style = "margin-left: 15px">Назад</a>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                                             class="img-fluid" alt="Sample image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
</body>
</html>