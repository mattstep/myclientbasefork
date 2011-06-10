<script type="text/javascript">

	$(document).ready(function(){

		$("#invoice_stored_item_id").change(function(){

			$.post("<?php echo site_url('invoice_items/jquery_item_data'); ?>",{

				invoice_stored_item_id: $("#invoice_stored_item_id").val()

			}, function(data) {

				var json_data = "invoice_item = " + data;

				eval(json_data);

				$('#item_name').val(invoice_item.item_name);
				$('#item_price').val(invoice_item.item_cost);
				$('#item_description').val(invoice_item.item_description);
				$('#item_qty').val(1);

			});
			return false;
		});

	});

</script>