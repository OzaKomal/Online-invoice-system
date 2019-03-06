<?php
$currDir = dirname(__FILE__);
include("$currDir/defaultLang.php");
include("$currDir/language.php");
include("$currDir/lib.php");
include_once("$currDir/header.php");


$invoices_fields = get_sql_fields('invoices');
$Date = date("Y-m-d");
$year = date("Y");
$month = date("m");
$start = $year . "-" . $month . "-" . "01";
$end = $year . "-" . $month . "-" . "31";

$res = sql("SELECT name, date_due, invoices.id, total
                   FROM clients
           RIGHT OUTER JOIN invoices ON clients.id = invoices.client
                 WHERE invoices.status = 'Not Paid'
              AND date_due < DATE '" . $start . "'
                   ", $eo);




$total_invoice_due = sql("SELECT sum(total)
                   FROM clients
           RIGHT OUTER JOIN invoices ON clients.id = invoices.client
                 WHERE invoices.status = 'Not Paid'
              AND date_due < DATE '" . $start . "'
                   ", $eo);

//while  ($order = db_fetch_assoc($res)){
//    echo $order['name'];
//}
?>


<div class="input-group">
 <span class="input-group-btn">
<a href="invoice_botton.php" class="btn btn-info hidden-print btn btn-secondary" role="button">Back to Reports</a>
 </span>
	<button class="btn btn-primary  hidden-print" type="button" id="sendToPrinter" onclick="window.print();"><i class="glyphicon glyphicon-print"></i> Print</button>
</div>


<div class="row">
    <div >
        <!-- company info -->
        <h1> All Over-due Invoices</h1>
    </div>

</div>


<?php if(db_num_rows($res)){?>
<table class="table table-striped table-bordered">
    <thead>

    <th class="text-center" style="color:#0066ff ; font-size: 15px"> Invoice Number</th>
    <th class="text-center" style="color:#0066ff ; font-size: 15px">Customer  Name </th>

    <th class="text-center" style="color:#0066ff ; font-size: 15px">Invoice Date </th>

    <th class="text-center" style="color:#0066ff ; font-size: 15px">Total </th>



</thead>

<tbody>
    <?php while ($order = db_fetch_assoc($res)) { ?>
        <tr>
            <td class="text-right"><?php echo $order['id']; ?> </td>
            <td class="text-left"><?php echo $order['name']; ?>
            </td>

            <td class="text-center"><?php
                $s = config("adminConfig");
                echo date($s['PHPDateFormat'], strtotime($order['date_due']));
                ?></td>

            <td class="text-right"><?php echo number_format($order['total'], 2); ?></td>



        </tr>
    <?php } ?>

</tbody>
<tfoot>
    <tr>
        <th colspan="3" class="text-right">Total  Over-due invoices </th>
        <th class="text-right">
            $<?php
            if ($total_invoice_due_r = db_fetch_assoc($total_invoice_due)) {
                echo number_format($total_invoice_due_r['sum(total)'], 2);
            }
            ?></th>
    </tr>





</tfoot>
</table>

<?php }else{
	echo '<div class="alert alert-danger">' . $Translation['No records found']. '</div>';
}?>
<?php
include_once("$currDir/footer.php");
?>