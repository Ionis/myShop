{foreach $recProducts as $prod}
    <div class="card" style="width: 12rem;">
        <img src="img/products/{$prod['image']}" class="card-img-top" alt="...">
        <div class="card-body">
            <h9 class="card-title">{$prod['name_ru']}</h9>
            <a href="/?controller=product&id={$prod['id']}" class="card-link">Подробнее</a>
        </div>
    </div>
{/foreach}