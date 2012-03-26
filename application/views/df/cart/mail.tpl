<h1>Информация о заказе</h1>
<table width="450" border="1px solid" cellpadding="5" cellspacing="0">
	<tr>
		<td width="30%">Количество товаров в корзине</td>
		<td>{$products|@count}</td>
	</tr>
	<tr>
		<td>Имя покупателя:</td>
		<td>{$name}</td>
	</tr>
	<tr>
		<td>Контактный телефон:</td>
		<td>{$phone}</td>
	</tr>
	{if $email}
	<tr>
		<td>Контактный email:</td>
		<td>{$email}</td>
	</tr>
	{/if}
	{if $message}
	<tr>
		<td>Сообщение:</td>
		<td>{$message}</td>
	</tr>
	{/if}
</table>
<h2>Список товаров</h2>
<table width="450" border="1px solid" cellpadding="5" cellspacing="0">
	<tr>
		<th>Название</th>
		<th>Оригинальная цена</th>
		<th>Скидка</th>
		<th>Цена со скидкой</th>
	</tr>
	{foreach from=$products item=item}
	<tr>
		<td><a style="color: black;" href="http://alshe.by/product/view/{$item->product_id}">{$item->title}</a></td>
		<td>{$item->originalPrice} у.е.</td>
		<td>{$item->discount}%</td>		
		<td>{if $item->dollar}{$item->dollar} руб./{/if}{$item->price} у.е.</td>
	</tr>
	{/foreach}
	<tr>
		<td colspan="3">Общая стоимость (со скидкой)</td>
		<td>{if $totalPriceD}{$totalPriceD} у.е./{/if}{$totalPrice} руб.</td>
	</tr>
</table>
