<?php
$currDir = dirname(__FILE__);
include("$currDir/defaultLang.php");
include("$currDir/language.php");
include("$currDir/lib.php");
include_once("$currDir/header.php");


$custmer_id = intval($_REQUEST['search']);
$invoices_fields = get_sql_fields('invoices');
$res = sql("select * from invoices where client={$custmer_id}", $eo);
$name = sql("select name from clients where id={$custmer_id}", $eo);

$Date = date("Y-m-d");
$year = date("Y");
$month = date("m");
$start = $year . "-" . $month . "-" . "01";
$end = $year . "-" . $month . "-" . "31";


$total_invoice_due = sql("SELECT sum(total)
                   FROM clients
           RIGHT OUTER JOIN invoices ON clients.id = invoices.client
                 WHERE invoices.status = 'Not Paid'
                  AND clients.id = {$custmer_id}
              AND date_due
                  BETWEEN '" . $start . "' AND '" . $end . "' ", $eo);


$total_invoice_upcoming = sql("SELECT sum(total)
                   FROM clients
           RIGHT OUTER JOIN invoices ON clients.id = invoices.client
                 WHERE invoices.status = 'Not Paid'
                  AND clients.id = {$custmer_id}
                
              AND date_due > '" . $end . "'
                   ", $eo);


$total_invoice_over_due = sql("SELECT sum(total)
                   FROM clients
           RIGHT OUTER JOIN invoices ON clients.id = invoices.client
                 WHERE invoices.status = 'Not Paid'
				  AND clients.id = {$custmer_id}
              AND date_due < '" . $start . "'
                   ", $eo);


$total = 0;
if (
		($total_invoice_due_r = db_fetch_assoc($total_invoice_due)) &&
		($total_invoice_upcoming_r = db_fetch_assoc($total_invoice_upcoming)) &&
		($total_invoice_over_due_r = db_fetch_assoc($total_invoice_over_due))
) {
	$x = number_format($total_invoice_due_r['sum(total)'], 2);
	$x1 = number_format($total_invoice_upcoming_r['sum(total)'], 2);
	$x2 = number_format($total_invoice_over_due_r['sum(total)'], 2);

	$total = $total_invoice_due_r['sum(total)'] + $total_invoice_upcoming_r['sum(total)'] + $total_invoice_over_due_r['sum(total)'];
}

$tt=0;
if ($na = db_fetch_assoc($name)) {
	$nn = $na['name'];
}
?>



<div class="input-group">
	<span class="input-group-btn">
		<a href="invoice_botton.php?search_by_customer=1" class="btn btn-info hidden-print btn btn-secondary" role="button">Back to Reports</a>
	</span>
	<button class="btn btn-primary  hidden-print" type="button" id="sendToPrinter" onclick="window.print();"><i class="glyphicon glyphicon-print"></i> Print</button>
</div>

<div class="row">
    <div class="col-xs-8 ">
        <h1>   <?php echo $nn; ?></h1>
    </div>
    <div class="col-xs-4 text-right " style="margin-top: 20px" >
        <h4> Total invoices: $<?php echo number_format($total, 2); ?> </h4>
    </div>             
</div>
<?php if(db_num_rows($res)){?>

<table class="table table-striped table-bordered">
    <thead>

    <th class="text-center" style="color:#0066ff ; font-size: 15px"> Invoice id</th>
    <th class="text-center" style="color:#0066ff ; font-size: 15px">Status </th>
    <th class="text-center" style="color:#0066ff ; font-size: 15px">Due Date </th>
    <th class="text-center" style="color:#0066ff ; font-size: 15px">Total </th>


</thead>

<tbody>
	<?php while ($order = db_fetch_assoc($res)) { ?>
		<tr>
			<td class="text-right"><?php echo $order['id']; ?> </td>
			<td class="text-center"><?php echo $order['status']; ?></td>

			<td class="text-center"><?php
				$s = config("adminConfig");
				echo date($s['PHPDateFormat'], strtotime($order['date_due']));
				?></td>
			<td class="text-right"><?php echo number_format($order['total'], 2); ?></td>


		</tr>
		
		
		
	<?php 
	if($order['status']=="Paid"){
		$tt+=$order['total'];
	}
	
	
	} ?>

</tbody>
<tfoot>
    <tr>
        <th colspan="3" class="text-right">Total due invoices </th>
        <th class="text-right">
            $<?php echo $x ?></th>
    </tr>



    <tr>
        <th colspan="3" class="text-right">Total upcoming invoices </th>
        <th class="text-right">
            $<?php echo $x1 ?></th>

    </tr>
	
	
	    <tr>
        <th colspan="3" class="text-right">Total paid invoices </th>
        <th class="text-right">
            $<?php echo number_format($tt,2) ?></th>

    </tr>


    <tr>
        <th colspan="3" class="text-right">Total  over-due invoices </th>
        <th class="text-right">
            $<?php echo $x2; ?></th>
    </tr>

    <tr></tr>

    <tr>
        <th colspan="3" class="text-right">Total invoices</th>
        <th class="text-right">
            $<?php echo number_format($total, 2); ?></th>

    </tr>
</tfoot>
</table>
<?php }else{
	echo '<div class="alert alert-danger">' . $Translation['No records found']. '</div>';
}?>
<?php
include_once("$currDir/footer.php");
?>