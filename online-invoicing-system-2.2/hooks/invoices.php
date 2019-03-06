<?php

// For help on using hooks, please refer to http://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks

function invoices_init(&$options, $memberInfo, &$args) {

	return TRUE;
}

function invoices_header($contentType, $memberInfo, &$args) {
	$header = '';

	switch ($contentType) {
		case 'tableview':
			$header = '';
			break;

		case 'detailview':
			$header = '';
			break;

		case 'tableview+detailview':
			$header = '';
			break;

		case 'print-tableview':
			$header = '';
			break;

		case 'print-detailview':
			$header = '';
			break;

		case 'filters':
			$header = '';
			break;
	}

	return $header;
}

function invoices_footer($contentType, $memberInfo, &$args) {
	$footer = '';

	switch ($contentType) {
		case 'tableview':
			$footer = '';
			break;

		case 'detailview':
			$footer = '';
			break;

		case 'tableview+detailview':
			$footer = '';
			break;

		case 'print-tableview':
			$footer = '';
			break;

		case 'print-detailview':
			$footer = '';
			break;

		case 'filters':
			$footer = '';
			break;
	}

	return $footer;
}

function invoices_before_insert(&$data, $memberInfo, &$args) {

	return TRUE;
}

function invoices_after_insert($data, $memberInfo, &$args) {

	return TRUE;
}

function invoices_before_update(&$data, $memberInfo, &$args) {

	return TRUE;
}

function invoices_after_update($data, $memberInfo, &$args) {

	return TRUE;
}

function invoices_before_delete($selectedID, &$skipChecks, $memberInfo, &$args) {

	return TRUE;
}

function invoices_after_delete($selectedID, $memberInfo, &$args) {
	
}

function invoices_dv($selectedID, $memberInfo, &$html, &$args) {
	global $Translation;
	if (isset($_REQUEST['dvprint_x']))
		return;  // hna 3shan msh ytb3 el html code m3 el tb3a

	ob_start();
	?>

	<script>
		$j(function () {
	<?php if ($selectedID) { ?> 

        
				$j('#invoices_dv_action_buttons .btn-toolbar').append(
						'<div class="btn-group-vertical btn-group-lg" style="width: 100%;">' +
						'<button type="button" class="btn btn-default btn-lg" onclick="print_invoice_tax()">' +
						'<i class="glyphicon glyphicon-print"></i> Print Invoice  </button>'

						);

setTimeout(function () {
					$j('#deselect').removeClass('btn-warning').addClass('btn-default').get(0).lastChild.data = '<?php echo $Translation['Back']; ?>';
				}, 1000);
				
				
				
				if ($j("input[type='radio']#type1:checked").val() !== "Tax") {
						$j('#tax').hide();
						$j('label[for="tax"]').hide();
							//$j('#tax').val("0.00");
						console.log("yoyo")
				}

	<?php } else { ?>
	               $j('#total').val("0.00");
				   
				setTimeout(function () {
					$j('#deselect').removeClass('btn-warning').addClass('btn-default').get(0).lastChild.data = '<?php echo $Translation['Back']; ?>';
				}, 1000);
				
				
				if ($j("input[type='radio']#type1:checked").val() !== "Tax") {
						$j('#tax').hide();
						//$j('#tax').val("0.00");
						$j('label[for="tax"]').hide();
						console.log("yoyo")
				}
	<?php } ?>
		});


		function print_invoice_tax() {
			if ($j("input[type='radio']#type1:checked").val() == "Tax") {
				var selectedID = '<?php echo urlencode($selectedID); ?>'; 
				window.location = 'tax_invoice.php?id=' + selectedID; 
				
			}
			else {
				var selectedID = '<?php echo urlencode($selectedID); ?>';
			
				window.location = 'no_tax_invoice.php?id=' + selectedID; 
			}
		}


	</script>

	<?php
	$form_code = ob_get_contents();
	ob_end_clean();

	$html .= $form_code;
}

function invoices_csv($query, $memberInfo, $args) {

	return $query;
}
