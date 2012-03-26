{if $page->title}
<ul class="tabs">
	<li class="selected"><span>{$page->title|stripslashes}</span></li>
</ul>
{/if}
<div class="page">
	<div class="content-page">
		<h1>{$page->description}</h1>
		{$page->body|stripslashes}
	</div>
</div>
<div class="page-corners"><div></div></div>