<ul class="tabs">
    <li class="selected"><span>Карта сайта</span></li>
</ul>
<div class="page">
    <div class="sitemap">
        <h1><a href="/">Главная</a></h1>
        <ul>
            {foreach from=$pages item=item}
            <li><a href="/pages/{$item->link}">{$item->title}</a></li>
            {/foreach}
            <li>
                <a href="/catalog">Каталог</a>
                <ul>
                    <li>
                        Производители
                        <ul>
                            {foreach from=$producers item=item}
                            <li><a href="/catalog/manufacturer/id/{$item->category_id}">{$item->name}</a></li>
                            {/foreach}
                        </ul>
                    </li>
                    <li>
                        Категории
                        <ul>
                            {foreach from=$categories item=item}
                            <li><a href="/catalog/category/id/{$item->category_id}">{$item->name}</a></li>
                            {/foreach}
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<div class="page-corners"><div></div></div>