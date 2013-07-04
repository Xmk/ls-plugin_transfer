<li><a class="js-admin-action-convert" href="#">Convert</a></li>

<div class="modal" id="transfer_form" data-type="modal">
	<header class="modal-header">
		<h3>Convert Data Base</h3>
		<a href="#" class="close jqmClose" data-type="modal-close"></a>
	</header>
	<form class="modal-content">
		<p>
			<label for="convert_form_oldhost">Input Old Host adress</label>
			<input type="text" id="convert_form_oldhost" class="input-text input-width-full" />
		</p>
		<button type="button" class="button button-primary js-admin-action-convert-submit">Start</button>
	</form>
	<div class="loader" style="display:none"></div>
</div>

{literal}
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('.js-admin-action-convert-submit').click(function() {
			var form = $('#transfer_form form');
			var load = $('#transfer_form .loader');

			var old_host = form.find('#convert_form_oldhost').val();

			var params = {'old_host':old_host};

			load.height(form.height()).css({'background': 'url(' + DIR_STATIC_SKIN + '/images/loader.gif) no-repeat center center', 'min-height': 70});
			form.hide();
			load.show();

			ls.ajax(aRouter['ajax']+'transfer/convert', params, function(data) {
				if (!data.bStateError) {
					$('#transfer_form').jqmHide();
					form.show();
					load.hide();
					ls.msg.notice(data.sMsgTitle,data.sMsg);
				} else {
					ls.msg.error(data.sMsgTitle,data.sMsg);
				}
			}.bind(this), {
				'error': function() {
					form.show();
					load.hide();
					ls.msg.error('Error','System Error');
				}.bind(this)
			});
			return false;
		});
		$('.js-admin-action-convert').click(function() {
			$('#transfer_form').jqmShow();
			return false;
		});
		$('#transfer_form').jqm();
	});
</script>
{/literal}