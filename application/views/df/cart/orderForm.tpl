{if !$success}
<div class="rightCol">
	<div class="product-page">
		<h1>Форма заказа</h1>
		<div class="orderInformation">
			<table width="450" border="1px solid" cellpadding="5" cellspacing="0">
				<tr>
					<td>Количество товаров в корзине</td>
					<td>{if $countProducts}{$countProducts}{else}{$basketCount}{/if}</td>
				</tr>
				<tr>
					<td>Общая сумма заказа:</td>
					<td>{if $totalPriceD}{$totalPriceD} у.е./{/if}{$totalPrice} руб.</td>
				</tr>
			</table>
		</div>
		<div class="orderErrors" {if $errors}style="display:block" {/if}>Заполните подсвеченные поля</div>
		<div class="orderForm">
			<form name="order" action="{if $id}/cart/sendproduct/{$id}{else}/cart/index/send{/if}" method="post" onsubmit="return validateForm();">
				{if $id}<input type="hidden" name="id" value="{$id}"/>{/if}
				<table width="450" border="0" cellpadding="1" cellspacing="1">
					<tbody>
						<tr>
							<td>Имя: <span class="required">*</span></td>
							<td><input rel="required" id="name" name="name" value="{$request->name}" type="text"></td>
						</tr>
						<tr>
							<td>Контактный телефон: <span class="required">*</span></td>
							<td><input rel="required" id="phone" name="phone" value="{$request->phone}" type="text"></td>
						</tr>
						<tr>
							<td>Контактный email:</td>
							<td><input id="email" name="email" value="{$request->email}" type="text"></td>
						</tr>
						<tr>
							<td colspan="2">Дополнительная информация:</td>
						</tr>
						<tr>
							<td colspan="2">
								<textarea id="message" rows="5" cols="60" name="message">{$request->message}</textarea>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<input value="Заказать" type="submit">
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	</div>
	{literal}
	<script>

		$(document).ready(function(){
			$('[rel="required"]').bind('change', function(){
				$('.orderErrors').hide();
				$(this).removeClass('error');
			})
		});

		function validateForm(){
			error = false;

			if($('#name').val() == ''){
				error = true;
				$('#name').addClass('error');
			}
			if($('#phone').val() == ''){
				error = true;
				$('#phone').addClass('error');
			}

			if(error){
				$('.orderErrors').text('Заполните подсвеченные поля');
				$('.orderErrors').show();
				return false;
			} else {
				return true;
			}

		}
	</script>
	{/literal}
</div>
{else}
<div class="successMessage">
		Спасибо за заказ.<br/> Менеджер свяжется с вами в ближайшее время.
		<br/>
		<a style="color: blue;" href="/">Перейти на сайт</a>
</div>
{/if}
