<?php
$currDir = dirname(__FILE__);
include("$currDir/defaultLang.php");
include("$currDir/language.php");
include("$currDir/lib.php");
include_once("$currDir/header.php");


$search_year = $_REQUEST['search'];
//echo $search_year;

$invoices_fields = get_sql_fields('invoices');
$Date = date("Y-m-d");
$year = date("Y");
$month = date("m");
$start = $year . "-" . $month . "-" . "01";
$end = $year . "-" . $month . "-" . "31";

$res = sql("SELECT name, date_due, invoices.id, total,status
                   FROM clients
           RIGHT OUTER JOIN invoices ON clients.id = invoices.client
          ", $eo);
$total_of_month1_paid = 0;
$total_of_month1_notpaid = 0;
$total_of_month2_paid = 0;
$total_of_month2_notpaid = 0;
$total_of_month3_paid = 0;
$total_of_month3_notpaid = 0;
$total_of_month4_paid = 0;
$total_of_month4_notpaid = 0;
$total_of_month5_paid = 0;
$total_of_month5_notpaid = 0;
$total_of_month6_paid = 0;
$total_of_month6_notpaid = 0;
$total_of_month7_paid = 0;
$total_of_month7_notpaid = 0;
$total_of_month8_paid = 0;
$total_of_month8_notpaid = 0;
$total_of_month9_paid = 0;
$total_of_month9_notpaid = 0;
$total_of_month10_paid = 0;
$total_of_month10_notpaid = 0;
$total_of_month11_paid = 0;
$total_of_month11_notpaid = 0;
$total_of_month12_paid = 0;
$total_of_month12_notpaid = 0;

while ($row = db_fetch_assoc($res)) {
	// echo $row['date_due']."<br>";

	$datePieces = explode("-", $row['date_due']);

	if (((intval($search_year) . "-" . "01") == (intval($datePieces[0]) . "-" . $datePieces[1])) && ($row['status'] == "Paid")) {
		// echo "hna";
		$total_of_month1_paid+=$row['total'];
		// echo "<br>".$total_of_month1_paid;
	} else if (((intval($search_year) . "-" . "01") == (intval($datePieces[0]) . "-" . $datePieces[1])) && ($row['status'] == "Not Paid")) {
		$total_of_month1_notpaid+=$row['total'];
	}

	if (((intval($search_year) . "-" . "02") == (intval($datePieces[0]) . "-" . $datePieces[1])) && ($row['status'] == "Paid")) {
		// echo "hna";
		$total_of_month2_paid+=$row['total'];
		// echo "<br>".$total_of_month1_paid;
	} else if (((intval($search_year) . "-" . "02") == (intval($datePieces[0]) . "-" . $datePieces[1])) && ($row['status'] == "Not Paid")) {
		$total_of_month2_notpaid+=$row['total'];
	}


	if (((intval($search_year) . "-" . "03") == (intval($datePieces[0]) . "-" . $datePieces[1])) && ($row['status'] == "Paid")) {
		// echo "hna";
		$total_of_month3_paid+=$row['total'];
		// echo "<br>".$total_of_month1_paid;
	} else if (((intval($search_year) . "-" . "03") == (intval($datePieces[0]) . "-" . $datePieces[1])) && ($row['status'] == "Not Paid")) {
		$total_of_month3_notpaid+=$row['total'];
	}


	if (((intval($search_year) . "-" . "04") == (intval($datePieces[0]) . "-" . $datePieces[1])) && ($row['status'] == "Paid")) {
		// echo "hna";
		$total_of_month4_paid+=$row['total'];
		// echo "<br>".$total_of_month1_paid;
	} else if (((intval($search_year) . "-" . "04") == (intval($datePieces[0]) . "-" . $datePieces[1])) && ($row['status'] == "Not Paid")) {
		$total_of_month4_notpaid+=$row['total'];
	}


	if (((intval($search_year) . "-" . "05") == (intval($datePieces[0]) . "-" . $datePieces[1])) && ($row['status'] == "Paid")) {
		// echo "hna";
		$total_of_month5_paid+=$row['total'];
		// echo "<br>".$total_of_month1_paid;
	} else if (((intval($search_year) . "-" . "05") == (intval($datePieces[0]) . "-" . $datePieces[1])) && ($row['status'] == "Not Paid")) {
		$total_of_month5_notpaid+=$row['total'];
	}


	if (((intval($search_year) . "-" . "06") == (intval($datePieces[0]) . "-" . $datePieces[1])) && ($row['status'] == "Paid")) {
		// echo "hna";
		$total_of_month6_paid+=$row['total'];
		// echo "<br>".$total_of_month1_paid;
	} else if (((intval($search_year) . "-" . "06") == (intval($datePieces[0]) . "-" . $datePieces[1])) && ($row['status'] == "Not Paid")) {
		$total_of_month6_notpaid+=$row['total'];
	}


	if (((intval($search_year) . "-" . "07") == (intval($datePieces[0]) . "-" . $datePieces[1])) && ($row['status'] == "Paid")) {
		// echo "hna";
		$total_of_month7_paid+=$row['total'];
		// echo "<br>".$total_of_month1_paid;
	} else if (((intval($search_year) . "-" . "07") == (intval($datePieces[0]) . "-" . $datePieces[1])) && ($row['status'] == "Not Paid")) {
		$total_of_month7_notpaid+=$row['total'];
	}




	if (((intval($search_year) . "-" . "08") == (intval($datePieces[0]) . "-" . $datePieces[1])) && ($row['status'] == "Paid")) {
		// echo "hna";
		$total_of_month8_paid+=$row['total'];
		// echo "<br>".$total_of_month1_paid;
	} else if (((intval($search_year) . "-" . "08") == (intval($datePieces[0]) . "-" . $datePieces[1])) && ($row['status'] == "Not Paid")) {
		$total_of_month8_notpaid+=$row['total'];
	}


	if (((intval($search_year) . "-" . "09") == (intval($datePieces[0]) . "-" . $datePieces[1])) && ($row['status'] == "Paid")) {
		// echo "hna";
		$total_of_month9_paid+=$row['total'];
		// echo "<br>".$total_of_month1_paid;
	} else if (((intval($search_year) . "-" . "09") == (intval($datePieces[0]) . "-" . $datePieces[1])) && ($row['status'] == "Not Paid")) {
		$total_of_month8_notpaid+=$row['total'];
	}


	if (((intval($search_year) . "-" . "10") == (intval($datePieces[0]) . "-" . $datePieces[1])) && ($row['status'] == "Paid")) {
		// echo "hna";
		$total_of_month10_paid+=$row['total'];
		// echo "<br>".$total_of_month1_paid;
	} else if (((intval($search_year) . "-" . "10") == (intval($datePieces[0]) . "-" . $datePieces[1])) && ($row['status'] == "Not Paid")) {
		$total_of_month10_notpaid+=$row['total'];
	}


	if (((intval($search_year) . "-" . "11") == (intval($datePieces[0]) . "-" . $datePieces[1])) && ($row['status'] == "Paid")) {
		// echo "hna";
		$total_of_month11_paid+=$row['total'];
		// echo "<br>".$total_of_month1_paid;
	} else if (((intval($search_year) . "-" . "11") == (intval($datePieces[0]) . "-" . $datePieces[1])) && ($row['status'] == "Not Paid")) {
		$total_of_month11_notpaid+=$row['total'];
	}



	if (((intval($search_year) . "-" . "12") == (intval($datePieces[0]) . "-" . $datePieces[1])) && ($row['status'] == "Paid")) {
		// echo "hna";
		$total_of_month12_paid+=$row['total'];
		// echo "<br>".$total_of_month1_paid;
	} else if (((intval($search_year) . "-" . "12") == (intval($datePieces[0]) . "-" . $datePieces[1])) && ($row['status'] == "Not Paid")) {
		$total_of_month12_notpaid+=$row['total'];
	}
}
?>


<div class="input-group">
	<span class="input-group-btn">
		<a href="invoice_botton.php?search_by_year=1" class="btn btn-info hidden-print btn btn-secondary" role="button">Back to Reports</a>
	</span>
	<button class="btn btn-primary  hidden-print" type="button" id="sendToPrinter" onclick="window.print();"><i class="glyphicon glyphicon-print"></i> Print</button>
</div>


<h1> Year <?php echo $search_year ?> </h1>

<table class="table table-striped table-bordered">
    <thead>


    <th class="text-center text-primary">Month </th>

    <th class="text-center text-primary">Paid </th>

    <th class="text-center text-primary">Not Paid </th>
	<th class="text-center text-primary">Total </th>



</thead>

<tbody>
    <tr>
        <td>January</td>
        <td class="text-right"><?php echo number_format($total_of_month1_paid, 2) ?></td>
        <td class="text-right"><?php echo number_format($total_of_month1_notpaid, 2) ?></td>
		<td class="text-right"><?php echo number_format($total_of_month1_paid+$total_of_month1_notpaid, 2) ?></td>
    </tr>


    <tr>
        <td>February</td>
        <td class="text-right"><?php echo number_format($total_of_month2_paid, 2) ?></td>
        <td class="text-right"><?php echo number_format($total_of_month2_notpaid, 2) ?></td>
		<td class="text-right"><?php echo number_format($total_of_month2_paid+$total_of_month2_notpaid, 2) ?></td>
    </tr>



    <tr>
        <td>March</td>
        <td class="text-right"><?php echo number_format($total_of_month3_paid, 2) ?></td>
        <td class="text-right"><?php echo number_format($total_of_month3_notpaid, 2) ?></td>
		<td class="text-right"><?php echo number_format($total_of_month3_paid+$total_of_month3_notpaid, 2) ?></td>
    </tr>



    <tr>
        <td>April</td>
        <td class="text-right"><?php echo number_format($total_of_month4_paid, 2) ?></td>
        <td class="text-right"><?php echo number_format($total_of_month4_notpaid, 2) ?></td>
		<td class="text-right"><?php echo number_format($total_of_month4_paid+$total_of_month4_notpaid, 2) ?></td>
    </tr>




    <tr>
        <td>May</td>
        <td class="text-right"><?php echo number_format($total_of_month5_paid, 2) ?></td>
        <td class="text-right"><?php echo number_format($total_of_month5_notpaid, 2) ?></td>
		<td class="text-right"><?php echo number_format($total_of_month5_paid+$total_of_month5_notpaid, 2) ?></td>
    </tr>



    <tr>
        <td>June</td>
        <td class="text-right"><?php echo number_format($total_of_month6_paid, 2) ?></td>
        <td class="text-right"><?php echo number_format($total_of_month6_notpaid, 2) ?></td>
		<td class="text-right"><?php echo number_format($total_of_month6_paid+$total_of_month6_notpaid, 2) ?></td>
    </tr>



    <tr>
        <td>July</td>
        <td class="text-right"><?php echo number_format($total_of_month7_paid, 2) ?></td>
        <td class="text-right"><?php echo number_format($total_of_month7_notpaid, 2) ?></td>
		<td class="text-right"><?php echo number_format($total_of_month7_paid+$total_of_month7_notpaid, 2) ?></td>
    </tr>



    <tr>
        <td>August</td>
        <td class="text-right"><?php echo number_format($total_of_month8_paid, 2) ?></td>
        <td class="text-right"><?php echo number_format($total_of_month8_notpaid, 2) ?></td>
		<td class="text-right"><?php echo number_format($total_of_month8_paid+$total_of_month8_notpaid, 2) ?></td>
    </tr>



    <tr>
        <td>September</td>
        <td class="text-right"><?php echo number_format($total_of_month9_paid, 2) ?></td>
        <td class="text-right"><?php echo number_format($total_of_month9_notpaid, 2) ?></td>
		<td class="text-right"><?php echo number_format($total_of_month9_paid+$total_of_month9_notpaid, 2) ?></td>
    </tr>




    <tr>
        <td>October</td>
        <td class="text-right"><?php echo number_format($total_of_month10_paid, 2) ?></td>
        <td class="text-right"><?php echo number_format($total_of_month10_notpaid, 2) ?></td>
		<td class="text-right"><?php echo number_format($total_of_month10_paid+$total_of_month10_notpaid, 2) ?></td>
    </tr>


    <tr>
        <td>November</td>
        <td class="text-right"><?php echo number_format($total_of_month11_paid, 2) ?></td>
        <td class="text-right"><?php echo number_format($total_of_month11_notpaid, 2) ?></td>
		<td class="text-right"><?php echo number_format($total_of_month11_paid+$total_of_month11_notpaid, 2) ?></td>
    </tr>


    <tr>
        <td>December</td>
        <td class="text-right"><?php echo number_format($total_of_month12_paid, 2) ?></td>
        <td class="text-right"><?php echo number_format($total_of_month12_notpaid, 2) ?></td>
		<td class="text-right"><?php echo number_format($total_of_month12_paid+$total_of_month12_notpaid, 2) ?></td>
    </tr>








</tbody>



<tfoot>
    <tr>
        <th colspan="1" class="text-right"> Totals</th>
        <th class="text-right">
            <?php 


		$x11=$total_of_month1_paid+$total_of_month2_paid+$total_of_month3_paid+$total_of_month4_paid+
			$total_of_month5_paid+$total_of_month6_paid+$total_of_month7_paid+	$total_of_month8_paid+
				$total_of_month9_paid+$total_of_month10_paid+$total_of_month11_paid+$total_of_month12_paid;
		
		
		echo  number_format($x11,2);
		?></th>
		
		
		
		
		
		
		  <th class="text-right">
            <?php
			
			$x12=$total_of_month1_notpaid+$total_of_month2_notpaid+$total_of_month3_notpaid+$total_of_month4_notpaid+
			$total_of_month5_notpaid+$total_of_month6_notpaid+$total_of_month7_notpaid+	$total_of_month8_notpaid+
				$total_of_month9_notpaid+$total_of_month10_notpaid+$total_of_month11_notpaid+$total_of_month12_notpaid;
		
		
		echo  number_format($x12,2);
			
			
		?></th>
		  
		  
		  
		  
		  
		  	  <th class="text-right">
            <?php
			echo  number_format($x12+$x11,2);
			
		?></th>
			  
	</tr>


</tfoot>

</table>
<?php
include_once("$currDir/footer.php");
?>