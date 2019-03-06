<?php
$currDir = dirname(__FILE__);
include("$currDir/defaultLang.php");
include("$currDir/language.php");
include("$currDir/lib.php");
include_once("$currDir/header.php");

$search_to = $_REQUEST['id'];
$tt = 0;
$res = sql("
               SELECT name, code , date_due 
                 FROM clients
           RIGHT OUTER JOIN invoices ON clients.id = invoices.client
                  WHERE invoices.id =$search_to", $eo);

$voice_items = sql(" 
            SELECT invoice_items.unit_price , qty , price,item_description,items.name 
                 FROM invoice_items
          Right OUTER JOIN items ON items.id = invoice_items.item
                  WHERE invoice_items.invoice =$search_to", $eo);


$total_invoice = sql("select discount,tax,total from invoices where id= $search_to", $eo);

function convertNumberToWord($num = false) {
	$num = str_replace(array(',', ' '), '', trim($num));
	if (!$num) {
		return false;
	}
	$fractions = round($num - intval($num), 2);
	$num = (int) $num;
	$words = array();
	$list1 = array('', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven',
		'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
	);
	$list2 = array('', 'Ten', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety', 'Hundred');
	$list3 = array('', 'Thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
		'Octillion', 'Nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
		'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
	);
	$num_length = strlen($num);
	$levels = (int) (($num_length + 2) / 3);
	$max_length = $levels * 3;
	$num = substr('00' . $num, -$max_length);
	$num_levels = str_split($num, 3);
	for ($i = 0; $i < count($num_levels); $i++) {
		$levels--;
		$hundreds = (int) ($num_levels[$i] / 100);
		$hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ( $hundreds == 1 ? '' : '' ) . ' ' : '');
		$tens = (int) ($num_levels[$i] % 100);
		$singles = '';
		if ($tens < 20) {
			$tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
		} else {
			$tens = (int) ($tens / 10);
			$tens = ' ' . $list2[$tens] . ' ';
			$singles = (int) ($num_levels[$i] % 10);
			$singles = ' ' . $list1[$singles] . ' ';
		}
		$words[] = $hundreds . $tens . $singles . ( ( $levels && (int) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
	} //end for loop
	$commas = count($words);
	if ($commas > 1) {
		$commas = $commas - 1;
	}
	return implode(' ', $words) . ($fractions ? " and {$fractions}" : '');
}

if ($ord = db_fetch_assoc($total_invoice)) {
	$total_invoice_total = $ord['total'];
	$total_invoice_tax = $ord['tax'];
	$total_invoice_discount = $ord['discount'];
}


$total_befor_discount=0;
?>

<div class="input-group">
	<span class="input-group-btn">
		<a href="invoices_view.php?SelectedID=<?php echo $_REQUEST['id'] ?>" class="btn btn-info hidden-print btn btn-secondary" role="button">Cancel printing</a>
	</span>
	<button class="btn btn-primary  hidden-print" type="button" id="sendToPrinter" onclick="window.print();"><i class="glyphicon glyphicon-print"></i> Print</button>
</div>



		<div>
			<img src="resources/images/tax.png" style="width: 100%; margin-bottom: 50px;">
		</div>

<?php
if ($orde = db_fetch_assoc($res)) {
	echo "<div>Invoice ref# {$orde['code']}</div>";
	echo "<div>Client: {$orde['name']}</div>";
	$s = config("adminConfig");
	echo "<div>Due date: " . date($s['PHPDateFormat'], strtotime($orde['date_due'])) . "</div>";
}
?>


		<div class="vspacer-lg"></div>

		<table class="table table-striped table-bordered">
			<thead>

			<th class="text-center" style="color:#0066ff ; font-size: 15px"> Description</th>
			<th class="text-center" style="color:#0066ff ; font-size: 15px">Unit price </th>

			<th class="text-center" style="color:#0066ff ; font-size: 15px">Quantity </th>

			<th class="text-center" style="color:#0066ff ; font-size: 15px">Price </th>




			</thead>

			<tbody>
<?php while ($order = db_fetch_assoc($voice_items)) { ?>
					<tr>

						<td class="text-left"><?php echo $order['name'] . "<p class='text-muted'>" . $order['item_description'] . "</p>"; ?></td>
						<td class="text-right"><?php echo number_format($order['unit_price'], 2); ?></td>
						<td class="text-right"><?php echo number_format($order['qty'], 2); ?></td>
						<td class="text-right"><?php echo number_format($order['price'], 2); ?></td>



					</tr>
<?php
$total_befor_discount+=$order['price'];} ?>

			</tbody>
			<tfoot>
				
				
						<tr>
					<th colspan="3" class="text-right">SubTotal </th>
					<th class="text-right"> 
<?php echo number_format($total_befor_discount, 2); ?>

					</th>

				</tr>
				
				
				<tr>
					<th colspan="3" class="text-right">Discount </th>
					<th class="text-right"> 
<?php echo number_format($total_invoice_discount, 2); ?>

					</th>

				</tr>



				<tr>
					<th colspan="3" class="text-right">Tax </th>
					<th class="text-right"> 
<?php echo number_format($total_invoice_tax, 2); ?>

					</th>

				</tr>
				
				
				
								<tr>
					<th colspan="3" class="text-right">Total</th>
					<th class="text-right"> 
						<?php echo number_format($total_invoice_total, 2); ?>

					</th>

				</tr>
				
				<tr>
					<th colspan="4" class="text-right"><?php echo "Only " . convertNumberToWord($total_invoice_total) . " ".$currency_title."  due"; ?> </th>
				</tr>       




			</tfoot>



		</table>

		<h4 class="text-center"><i>Thank you for your business</i></h4>
<?php
include_once("$currDir/footer.php");
?>
