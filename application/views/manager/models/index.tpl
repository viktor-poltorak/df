{include file='models/inc/tabs.tpl'}
<div class="manager-content">
    <div class="manager-header">
        <div class="fix">
            <img width="64" height="64" src="/images/admin/icons/kde.png" alt="" />
            <span>Марки автомобилей</span>
        </div>
    </div>
    <div class="manager-list-holder">
	{foreach from=$models item=model}
        <div class="manager-list{cycle values=', gray-bg'}">
            <div class="manager-list-image">
                <img src="/images/admin/star.png" alt="" />
            </div>
            <div class="manager-list-content">
                <a href="/manager/models/edit/id/{$model->model_id}/">
                     {$model->model_name|stripslashes}
                </a>
                <br />
            </div>
            <div class="manager-list-controls">
                <a href="/manager/models/edit/id/{$model->model_id}">
                    <img src="/images/admin/edit.png" alt="Редактировать" />
                </a>
                <a href="/manager/models/delete/id/{$model->model_id}">
                    <img src="/images/admin/delete.png" alt="Удалить" />
                </a>
            </div>
        </div>
	{foreachelse}
        <div class="manager-list{cycle values=', gray-bg'}">
            <div class="manager-list-image">
                <img src="/images/admin/star-off.png" alt="" />
            </div>
            <div class="manager-list-content star-down">
				Пока никаких моделей нет.
            </div>
        </div>
	{/foreach}
    </div>
</div>