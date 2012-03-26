<div class="manager-content">

	<div class="manager-header">
		<img src="/images/admin/icons/contacts.png" alt="" />
		<span>Контакты</span>
	</div>

	<form action="/manager/contacts/save/" method="post">
		
		<div class="form-item inputs">
			<label>Телефоны</label>
			<div class="form-cols">
				<div class="form-item">
				{foreach from=$phones item=phone}
					<input type="text" name="phones[]" value="{$phone->value}" />
					{cycle values=',</div><div class="form-item">'}
				{foreachelse}
					<input type="text" name="phones[]" value="" />
					<input type="text" name="phones[]" value="" />
				{/foreach}
				</div>
			</div>
			<label>Телефоны</label>
			<div class="form-cols">
				<label>sd</label>
				<div class="form-item">
				{foreach from=$faxes item=fax}
					<input type="text" name="faxes[]" value="{$fax->value}" />
					{cycle values=',</div><div class="form-item">'}
				{foreachelse}
					<input type="text" name="faxes[]" value="" />
					<input type="text" name="faxes[]" value="" />
				{/foreach}
				</div>
			</div>
		</div>

		<div class="form-item inputs">
			<div class="form-cols">
				<div class="form-item">
					<label>Адрес</label>
					<input type="text" name="address" value="{$address->value}" />
				</div>
				<div class="form-item">
					<label>Email</label>
					<input type="text" name="email" value="{$email->value}" />
				</div>
			</div>
		</div>
		
		<br />
		<br />
		<div>
			<input type="submit" value="Сохранить" />
		</div>
	</form>
</div>