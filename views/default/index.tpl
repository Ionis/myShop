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
            <h5>Последние поступления</h5>
            {include file="../includes/productCards.tpl"}
        </div>
    </div>
    {include file="../includes/footer.tpl"}
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</html>