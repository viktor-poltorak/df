{if $category->sub_categories}

{foreach from=$category->sub_categories item=sub_category}

<option value="{$sub_category->category_id}" {if $sub_category->parent_id == $sub_category->category_id}selected{/if}>{$sub_category->name}</option>

{assign var=$category value=$sub_category}
{include file='pages/inc/select-sub-category.tpl'}

{/foreach}

{/if}