<?php
$main 		= (array) $content['main'];
$detail		= (array) $content['detail'];
$billing	= explode(";",$main['BillingAddress']);
$shipping	= explode(";",$main['ShipAddress']);



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
$TotalQty = 0;
$TotalQtyRetur = 0;

function ReversePerc($Price, $Perc)
{
	if ($Price > 0) {
		$value = ( $Price / (100-$Perc) ) *100;
	} else {
		$value = 0;
	}
	return $value;
}
?>
<head>
	<link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>tool/favicon.png"/> 
	<title><?php echo $PageTitle.' - ' .$MainTitle." - NO ".$main['INVID']; ?></title>
	<style type="text/css">
		@media only print {
		    a.noprint, input#size {
			    display:none !important;
			}
			thead.main { display: table-header-group; }
			tfoot.main { display: table-footer-group; }
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
		    margin-bottom: 20px;
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

		.productlist {
		  /*table-layout:fixed;*/
		  /*height:630px;*/
		}
		.productlist thead { font-size: 12px;}
		.productlist tbody { font-size: 12px;}
		.productlist th, .productlist td { padding: 2px 4px; }
		.productlist th { border-bottom: 2px solid #000; font-size: 14px; }
		/*.productlist tr td { border-bottom: 1px dashed #000 !important; }*/
		.productlist tr { height:1px; }
		.productlist tr:last-child { height:auto; }
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
	<table >
		<thead class="main">
			<tr>
				<td>
					<table width="750px">
						<tr class="header-company" >
							<?php if (in_array("print_without_header", $MenuList)) {?>
							<td colspan="2"><img src="<?php echo base_url();?>tool/kopsg.png" width="300px" align="left" style="vertical-align:top; margin-bottom: 0px;" >
							</td>
							<td colspan="2">
								<h3 style="margin-bottom: 0px; margin-top: 10px;" align="right">INVOICE RETUR. <?php echo $main['INVRID']; ?></h3>
							</td>
							<?php } else {?>
							<td><img src="<?php echo base_url();?>tool/kop.jpg" width="220px" align="left" style="vertical-align:top" ></td>
							<td colspan="3">
								<h3 style="margin-bottom: 0px; margin-top: 110px;" align="right">INVOICE RETUR. <?php echo $main['INVRID']; ?></h3>
							</td>
							<?php } ?>
						</tr>
						<tr>
							<td><input type="number" name="size" id="size" autocomplete="off" placeholder="Font Size Product List"></td>
							<td colspan="2"><a href="#" id="noprint" class="noprint" autofocus>Print</a></td>
						</tr>
						<tr class="header-po1">
							<td>
								<table>
									<tr class="soid"><td width="100px">Retur No</td><td>:</td><td class="detail"><?php echo $main['INVRID']; ?></td></tr>
									<tr class="soid"><td width="100px">Retur Date</td><td>:</td><td class="detail"><?php echo $main['INVRDate']; ?></td></tr>
									<tr class="soid"><td width="100px">DOR</td><td>:</td><td class="detail"><?php echo $main['DORID']; ?></td></tr>
									<tr class="soid"><td width="100px">Invoice No</td><td>:</td><td class="detail"><?php echo $main['INVID']; ?></td></tr>
								</table>
							</td>
							<td>
								<table>
									<tr class="soid"><td width="80px">Customer NO</td><td>:</td><td class="detail"><?php echo $main['CustomerID']; ?></td></tr>
									<tr class="soid"><td width="80px">Sales Person</td><td>:</td><td class="detail"><?php echo $main['sales']; ?></td></tr>
								</table>
							</td>
							<td class="sendfrom">
								<h6>RETUR FROM :</h6>
								<h4><?php echo $billing[0]; ?></h4>
								<h6>
									<?php echo $billing[2]; ?>
								</h6>
								<h6>
									<?php echo $main['phone']; ?>
								</h6>
							</td>
							<td class="sendfrom">
								<h6>RECEIVED IN :</h6>
								<h4><?php echo $main['WarehouseName']; ?></h4>
								<h6><?php echo $main['WarehouseAddress']; ?></h6>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</thead>
		
		<tbody>
			<tr>
				<td>
					<table width="750px;" class="productlist">
						<thead>
							<th>Product</th>
							<th>Qty</th>
							<th>Price</th>
							<th>FC</th>
							<th>Total</th>
						</thead>
						<tbody>
							<?php
				            if (isset($content['detail'])) {
				                foreach ($detail as $row => $list) { 
					        ?>
					                <tr>
					                    <td class="ProductID"><?php echo $list['ProductName'];?></td>
					                    <td class="center"><?php echo $list['ProductQty'];?></td>
					                    <td class="right">
					                    	<?php echo number_format($list['PriceAmount'],2);?>
					                    </td>
					                    <td class="right">
					                    	<?php echo number_format($list['FreightCharge'],2);?>
					                    </td>
					                    <td class="right">
					                    	<?php echo number_format($list['PriceTotal']+$list['FreightCharge'],2);?>
					                    </td>
					                </tr>
						    <?php	
								}
							}
						    ?>

						</tbody>
					</table>
				</td>
			</tr>
		</tbody>

		<tfoot class="main">
			<tr>
				<td>
					<table width="750px;" class="total">
						<tr>
							<td class="cell1">
								<?php
									if ($main['INVRNote'] != "") {
										echo "Note : ".$main['INVRNote']."<br><br>";
									}
								?>
							</td>
							<td class="cell2">
								<table width="100%">
									<tr>
										<td>Total Price Before Tax</td>
										<td>:</td>
										<td class="detail right"><?php echo number_format($main['PriceBeforeTax']+$main['FCInclude'], 2); ?></td>
									</tr>
									<tr>
										<td>Tax Rate</td>
										<td>:</td>
										<td class="detail right"><?php echo $main['TaxRate']."%"; ?></td>
									</tr>
									<tr>
										<td>Tax Price </td>
										<td>:</td>
										<td class="detail right">
											<?php echo number_format($main['PriceTax']+$main['FCTax'], 2); ?>
										</td>
									</tr>
									<?php if ($main['FCExclude']>0) { ?><tr>
										<td>FC Exclude </td>
										<td>:</td>
										<td class="detail right">
											<?php echo number_format($main['FCExclude'], 2); ?>
										</td>
									</tr>
						    		<?php } ?>
									<tr>
										<td>Total Invoice Retur </td>
										<td>:</td>
										<td class="detail right">
											<?php echo number_format($main['INVRTotal'], 2); ?>
										</td>
									</tr>
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
				</td>
			</tr>
		</tfoot>
	</table>
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