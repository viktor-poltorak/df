{include file='seo/inc/tabs.tpl'}
<div class="manager-content">

    <div class="manager-header">
        <div class="fix">
            <img src="/images/admin/icons/menu.png" alt="" />
            <span>Общие SEO настройки</span>
        </div>
    </div>
    <div class="manager-list-holder">
        <div class="manager-list">
            <form action="/manager/seo/save-settings" method="post" class="form" enctype="multipart/form-data">
                <div class="form-item">
                    При составлении общих мета данные вы можете использовать динамические перевенные:<br/>
                    {literal}
                    {siteName} - будет автоматически подставлено название сайта указанное в настройках
                    {pageTitle} - установиться тайтл текущей страницы <br/>
                    Пример:
                    {siteName} - {pageTitle}
                    {/literal}
                    Более точно мета информацию можно настроить <a href="/manager/seo/meta">тут</a>
                </div>
                <div class="form-item">
                    <label>Общий тайтл сайта:</label>
                    <input type="text" id="title" name="commonTitle" value="{$request->commonTitle}" />
                </div>
                <div class="form-item">
                    <label>Meta description:</label>
                    <input type="text" name="metaDescription" value="{$request->metaDescription}" />
                </div>
                <div class="form-item">
                    <label>Meta keywords:</label>
                    <input type="text" name="metaKeywords" value="{$request->metaKeywords}" />
                </div>                
                <div class="form-item">
                    <label>Дополнительные мета теги:</label>
                    <textarea name="additionMetaTags">{$request->additionMetaTags}</textarea>
                </div>
                <div>
                    <input type="submit" value="Сохранить" />
                </div>
            </form>
        </div>

    </div>
</div>