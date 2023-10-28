<?php
$main 		= (array) $content['main'];
$detail		= (array) $content['detail'];
$billing	= explode(";",$main['BillingAddress']);
$shipping	= explode(";",$main['ShipAddress']);
// print_r($detail);
 
$opts=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);  
$f 		= fopen(('./tool/HeaderFaktur1.txt'), "r", false, stream_context_create($opts));
$npwp 	= fgets($f);
fclose($f);
$alamat = explode(";", $npwp);
?>
<head>
	<link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>tool/favicon.png"/> 
	<title><?php echo $PageTitle.' - '. $MainTitle; ?></title>
	<style type="text/css">
		@media only print {
		    a.noprint, input#size {
			    display:none !important;
			}
		}
		@page { size: potrait; }
		a.noprint {
			margin: 10px;
			background-color: #f44336;
		    color: white;
		    padding: 10px 120px;
		    text-align: center;
		    text-decoration: none;
		    display: inline-block;
		    font-size: 12px;
		    margin-bottom: -20px;
		}

		.content {
			font-family: Arial, Helvetica, sans-serif;
			width: 750px;
		}
		.content table tr td { padding: 5px; }
		.header-company { text-align: center; }
		.header-company td { border: 0px !important; }
		.header-company h2, .header-company h6 { margin: 0px; }
		.header-po1>td { border: 1px solid #000; }
		.header-po1>td:nth-child(1), .header-po1>td:nth-child(2){ width: 200px; }
		.header-po1>td:nth-child(3), .header-po1>td:nth-child(4) { width: 170px; }
		.header-po1 .dorid td{ font-weight: bolder; font-size: 15px !important; }
		.header-po1, .header-po1 tr { vertical-align: top;}
		.header-po1 table tr td { border: 0px !important; font-size: 12px; padding: 0px;}
		td.detail {	font-weight: bold;}
		.sendfrom h4, .sendfrom h5, .sendfrom h6 { margin: 0px; }

		.productlist th, .productlist td { padding: 2px 4px; }
		.productlist th { border-bottom: 2px solid #000; font-size: 14px; }
		.productlist tbody { font-size: 12px; }
		.productlist tr td { border-bottom: 1px dashed #000 !important; }
		.ProductID{ width: 350px; }
		.center { text-align: center; }
		.right { text-align: right; }
		.productprice, .producttotal { text-align: right; }
		
		.total .cell1{ 
			width: 350px; 
			font-size: 12px;
			font-weight: bold;
			border: 1px solid #000;
			vertical-align: top;
		}
    	.cell1 { vertical-align: top; word-break: break-word; max-width: 350px; }
		.cell2 table { font-size: 12px; font-weight: bold;}
		.cell2 table tr td { padding: 0px !important; }
		.cell2 table tr td:first-child { width: 250px; }

		.sign tr td{
			border: 1px solid #000;
			width: 20%;
			vertical-align: bottom;
			text-align: center;
			font-size: 12px;
			font-weight: bold;
		}
		.sign tr:first-child td{ height: 50px; }
		table {
			border-collapse: collapse;
			font-family: monospace;
		}
		.footer { 
			font-size: 10px;
			border-top: 1px solid #000;
		}
	</style>
</head>

<body>
<div class="content">
	<table width="750px">
		<tr class="header-company">
			<td colspan="4">
				<h2><?php echo $alamat[0]; ?></h2>
				<h6>
					<?php echo $alamat[1]; ?><br>
					<?php echo "Phone : ".$alamat[2]." || Fax : ".$alamat[3]." || NPWP : ".$alamat[4]; ?>
				</h6>
				<input type="number" name="size" id="size" autocomplete="off" placeholder="Font Size Product List">
				<a href="#" id="noprint" class="noprint" autofocus>Print</a>
				<h5 style="margin-bottom: 0px;">COMMERCIAL INVOICE (FREIGHT CHARGE)</h5>
			</td>
		</tr>
		<tr class="header-po1">
			<td>
				<table>
					<tr class="soid"><td width="100px">Invoice No</td><td>:</td><td class="detail"><?php echo $main['INVID']; ?></td></tr>
					<tr class="soid"><td width="100px">Invoice Date</td><td>:</td><td class="detail"><?php echo $main['INVDate']; ?></td></tr>
					<tr class="soid"><td width="100px">Delivery Order</td><td>:</td><td class="detail"><?php echo $main['DOID']; ?></td></tr>
					<tr><td width="100px">SO Category </td><td>:</td><td class="detail"><?php echo $main['CategoryName']; ?></td></tr>
				</table>
			</td>
			<td>
				<table>
					<tr class="soid"><td width="80px">Customer NO</td><td>:</td><td class="detail"><?php echo $main['CustomerID']; ?></td></tr>
					<tr class="soid"><td width="80px">Payment Term</td><td>:</td><td class="detail"><?php echo $main['PaymentTerm']; ?></td></tr>
					<tr class="soid"><td width="80px">Due Date</td><td>:</td><td class="detail"><?php echo $main['due_date']; ?></td></tr>
					<tr class="soid"><td width="80px">Sales Person</td><td>:</td><td class="detail"><?php echo $main['sales']; ?></td></tr>
				</table>
			</td>
			<td class="sendfrom">
				<h6>BILL TO :</h6>
				<h4><?php echo $billing[0]; ?></h4>
				<h6>
					<?php echo $billing[2]; ?>
				</h6>
			</td>
			<td class="sendfrom">
				<h6>SHIP TO :</h6>
				<h6><?php echo $shipping[2]; ?></h6>
			</td>
		</tr>
	</table><br>
	<table width="750px;" class="productlist">
		<thead>
			<th>Product</th>
			<th>Qty</th>
			<th>Freight Charge</th>
		</thead>
		<tbody>
			<?php
	            if (isset($content['detail'])) {
	                foreach ($detail as $row => $list) { 
	        ?>
		                <tr>
		                    <td class="ProductID"><?php echo $list['ProductName'];?></td>
		                    <td class="center"><?php echo $list['ProductQty'];?></td>
		                    <td class="right"><?php echo number_format($list['FreightCharge'],2);?></td>
		                </tr>
		    <?php	
					} 
		    	} 
		    ?>
		</tbody>
	</table><br>
	<table width="750px;" class="total">
		<tr>
			<td class="cell1">
				<?php
					if ($main['INVTerm'] != "") {
						echo "Term : ".$main['INVTerm']."<br><br>";
					}
					if ($main['INVNote'] != "") {
                  		echo "Note : ".substr(str_replace(array("\r", "\n","\r\n"), " ",$main['INVNote']),0,250)." ... <br><br>";
					}
				?>
			</td>
			<td class="cell2">
				<table width="100%">
					<tr><td>Freight Charge Include</td><td>:</td><td class="detail right"><?php echo number_format($main['FCInclude'],2); ?></td></tr>
					<tr><td>Tax Rate</td><td>:</td><td class="detail right"><?php echo $main['TaxRate']."%"; ?></td></tr>
					<tr><td>Freight Charge Tax</td><td>:</td><td class="detail right"><?php echo number_format($main['FCTax'],2); ?></td></tr>
					<tr><td>Freight Charge Exclude</td><td>:</td><td class="detail right"><?php echo number_format($main['FCExclude'],2); ?></td></tr>
					<tr><td>Total Payment Due</td><td>:</td><td class="detail right"><?php echo number_format($main['FCExclude'],2); ?></td></tr>
				</table>
			</td>
		</tr>
	</table><br>
	<table width="750px;" class="sign">
		<tr><td></td><td></td><td></td><td></td></tr>
		<tr>
			<td><?php echo $main['sales']; ?><br>(SALES)</td>
			<td><?php echo $billing[0]; ?><br>(CUSTOMER)</td>
			<td></td>
			<td>Admin</td>
		</tr>
	</table>

	<h5 class="footer">Printed By : <?php echo $UserName;?>, On : <?php echo date('d-m-Y H:i:s');?></h5>
</div>
</body>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script>
$( "#noprint" ).click(function() {
  	window.print();
});	

$('#size').live( "keyup", function() {
    size  = $(this).val();
    $(".productlist tbody tr td").css('font-size',size);
});
</script>