<?php
	/*
	 * You can add custom links in the home page by appending them here ...
	 * The format for each link is:
		$homeLinks[] = array(
			'url' => 'path/to/link', 
			'title' => 'Link title', 
			'description' => 'Link text',
			'groups' => array('group1', 'group2'), // groups allowed to see this link, use '*' if you want to show the link to all groups
			'grid_column_classes' => '', // optional CSS classes to apply to link block. See: http://getbootstrap.com/css/#grid
			'panel_classes' => '', // optional CSS classes to apply to panel. See: http://getbootstrap.com/components/#panels
			'link_classes' => '', // optional CSS classes to apply to link. See: http://getbootstrap.com/css/#buttons
			'icon' => 'path/to/icon' // optional icon to use with the link
		);
	 */
$x=3;
$Date = date("Y-m-d");
$year = date("Y");
$month = date("m");
$start = $year . "-" . $month . "-" . "01";
$end = $year . "-" . $month . "-" . "31";
$res = sqlValue("SELECT count(name)
                   FROM clients
           RIGHT OUTER JOIN invoices ON clients.id = invoices.client
                 WHERE invoices.status = 'Not Paid'
              AND date_due
                  BETWEEN '" . $start . "' AND '" . $end . "' ", $eo); // due



$res1 = sqlValue("SELECT count(name)
                   FROM clients
           RIGHT OUTER JOIN invoices ON clients.id = invoices.client
                 WHERE invoices.status = 'Not Paid'
              AND date_due > '" . $end . "'
                   ", $eo); // upcoming


$homeLinks[] = array(
			'url' => 'invoice_botton.php', 
			'title' => 'Reports', 
			'description' => "Smart Reports for your work <br> <br><p style='color: #d43f3a'> ".$res1." <a  style='color: #d43f3a' href='find_all_invoice_upcoming.php'>Upcoming invoices </a> <br> <a href='find_all_invoice_due.php'>  ".$res." Due invoices </a>  </p> ",
                     
			'groups' => array('*'), // groups allowed to see this link, use '*' if you want to show the link to all groups
			'grid_column_classes' => 'col-md-12 col-lg-12', // optional CSS classes to apply to link block. See: http://getbootstrap.com/css/#grid
			'panel_classes' => 'panel-success', // optional CSS classes to apply to panel. See: http://getbootstrap.com/components/#panels
			'link_classes' => 'btn-success', // optional CSS classes to apply to link. See: http://getbootstrap.com/css/#buttons
			'icon' => '' // optional icon to use with the link
		);
