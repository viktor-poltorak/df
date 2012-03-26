<ul class="tabs">
    <li class="selected"><span>Наши объекты</span></li>
</ul>
<div class="page">
    <div class="page-content">
        <div class="object-view">
            <table class="label">
                <tr>
                    <td class="label-corner"><img src="/images/label-top-left.png" alt="" /></td>
                    <td></td>
                    <td class="label-corner"><img src="/images/label-top-right.png" alt="" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="label-content">
                        {$object->name}
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="label-corner"><img src="/images/label-bottom-left.png" alt="" /></td>
                    <td></td>
                    <td class="label-corner"><img src="/images/label-bottom-right.png" alt="" /></td>
                </tr>
            </table>
            <div class="object-description">
                {$object->description}
            </div>
            {foreach from=$images item=item}
                <div class="object-images">
                    <a rel="facebox" href="/upload/objects/{$item->path}">
                        <img rel="facebox" width="190" src="/upload/objects/{$item->path}" />
                    </a>
                </div>
            {foreachelse}
                <p>Нет изображений</p>
            {/foreach}
        </div>
    </div>
</div>