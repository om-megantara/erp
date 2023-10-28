<?php
$so 		= $content['so'];
$detail		= $content['detail'];
$billing	= explode(";",$so['BillingAddress']);
$shipping	= explode(";",$so['ShipAddress']);
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
$TotalQty = 0;

function percentOf($a, $b)
{
	$final = 100 - ($b/ ($a/100) );
	return $final;
}
function ReversePerc($Price, $Perc)
{
	// if ($Perc > 0) {
		if ($Price > 0) {
			$value = ( $Price / (100-$Perc) ) *100;
		} else {
			$value = 0;
		}
	// } else {
	// 	$value = 0;
	// }
	return $value;
}
?>
<head>
	<link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>tool/favicon.png"/> 
	<title><?php echo $PageTitle.' - '. $MainTitle; ?></title>
	<style type="text/css">
		@media only print {
		    .btn-header, a.noprint, input#size {
			    display:none !important;
			}
			thead.mainThead { display: table-header-group; }
			tfoot.mainTfoot { display: table-footer-group; }
		}
		@page { size: A4; }
		.btn-header {
			margin: 10px 2px;
			background-color: #f44336;
		    color: white;
		    padding: 5px 20px;
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

		thead.mainThead > tr { width: 750px; }
		.content table tr td { padding: 5px; }
		.header-company { text-align: center; }
		.header-company td { border: 0px !important; }
		.header-company h2, .header-company h6 { margin: 0px; }
		.header-po1>td { border: 1px solid #000; }
		.header-po1>td:nth-child(2){ width: 220px; }
		.header-po1>td:nth-child(3), .header-po1>td:nth-child(4) { width: 170px; }
		.header-po1 .dorid td{ font-weight: bolder; font-size: 15px !important; }
		.header-po1, .header-po1 tr { vertical-align: top;}
		.header-po1 table tr td { border: 0px !important; font-size: 12px; padding: 0px;}
		td.detail {	font-weight: bold;}
		.sendfrom h4, .sendfrom h5, .sendfrom h6 { margin: 0px; }

		tr.productlist { width: 750px !important; }
		.productlist th, .productlist td { padding: 2px 4px; font-size: 12px; }
		.productlist th { border-bottom: 2px solid #000; font-size: 14px; }
		.productlist tr td { border-bottom: 1px dashed #000 !important; }
		.ProductID{ width: 350px; }
		.center { text-align: center; }
		.right { text-align: right; }
		.productprice, .producttotal { text-align: right; }
		
		.total { margin-top: 10px; }
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

		.sign { margin-top: 10px; }
		.sign tr td{
			border: 1px solid #000;
			width: 20%;
			vertical-align: bottom;
			text-align: center;
			font-size: 12px;
			font-weight: bold;
		}
		.sign tr:first-child td{ height: 50px; }
		table { border-collapse: collapse; }
		.footer { 
			font-size: 10px;
			border-top: 1px solid #000;
		}

		.raw { 
			font-size: 12px;
			margin-left: 30px;
			background-color: #c4c4c4;
		}
		.raw tbody tr td:first-child { width: 400px; }
		/*.rawname { font-weight: bold; font-size: 12px; }*/
		.pocancel {
			background: url("<?php echo base_url();?>tool/cancel.png") no-repeat;
			background-position-x: center;
		}
	</style>
</head>

<body>
	<div class="content">
		<table>
			<thead class="mainThead">
				<tr>
					<th colspan="7">
						<table width="750px">
							<tr class="header-company">
								<td colspan="4">
									<h2><?php echo $alamat[0]; ?></h2>
									<h6>
										<?php echo $alamat[1]; ?><br>
										<?php echo "Phone : ".$alamat[2]." || Fax : ".$alamat[3]." || NPWP : ".$alamat[4]; ?>
									</h6>
									<input type="number" name="size" id="size" autocomplete="off" placeholder="Font Size Product List">
									<a href="#" id="noprint" class="btn-header noprint" autofocus>Print</a>
									<a href="#" class="btn-header showContentFull" autofocus>Show Full</a>
									<a href="#" class="btn-header showContentNonFC" autofocus>Non FC</a>
									<a href="#" class="btn-header showContentNonPromoFC" autofocus>Non Promo & FC</a>
									<h5 style="margin-bottom: 0px;">SALES ORDER</h5>
								</td>
							</tr>
							<tr class="header-po1">
								<td>
									<table>
										<tr class="soid"><td width="75px">SO No</td><td>:</td><td class="detail"><?php echo $so['SOID']; ?></td></tr>
										<tr><td width="75px">SO Category </td><td>:</td><td class="detail"><?php echo $so['CategoryName'].' ('.$so['SOType'].')'; ?></td></tr>
										<tr><td width="75px">Create Date</td><td>:</td><td class="detail"><?php echo $so['SODate']; ?></td></tr>
										<tr><td width="75px">Ship Date</td><td>:</td><td class="detail"><?php echo $so['SOShipDate']; ?></td></tr>
										<tr><td width="75px">Payment </td><td>:</td><td class="detail"><?php echo $so['PaymentWay']." / ".$so['PaymentTerm']; ?></td></tr>
									</table>
								</td>
								<td>
									<table>
										<tr class="soid"><td width="75px">Customer NO</td><td>:</td><td class="detail"><?php echo $so['CustomerID']; ?></td></tr>
										<tr class="soid"><td width="75px">Region</td><td>:</td><td class="detail"><?php echo $so['RegionID']; ?></td></tr>
										<tr><td width="75px">SEC</td><td>:</td><td class="detail"><?php echo $so['secname']; ?></td></tr>
										<tr><td width="75px">Sales</td><td>:</td><td class="detail"><?php echo $so['salesname']; ?></td></tr>
										<tr><td width="75px">NPWP </td><td>:</td><td class="detail"><?php echo $so['NPWP'];?></td></tr>
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
									<h6><?php echo $shipping[1]; ?></h6>
									<h6><?php echo $shipping[2]; ?></h6>
								</td>
							</tr>
						</table>
					</th>
				</tr>
				<tr class="productlist">
					<th>Product</th>
					<th>Qty</th>
					<th>Price</th>
					<th>Promo Disc</th>
					<th>PT Disc</th>
					<th>FC</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody width="750px;" class="productlist">
					<?php
			            if (isset($content['detail'])) {
			                foreach ($detail as $row => $list) { 
			                	$ProductPriceDefaultAsal = $list['ProductPriceDefault'];
			                	$TotalQty += $list['ProductQty'];
			                	if ($so['PaymentWay'] == "CBD") {
			                		$PTPercent = $list['PT2Percent'];
			                	} else {
			                		$PTPercent = $list['PT1Percent'];
			                	}
			                	if ($so['FreightCharge'] == 0) {
			                		$FreightCharge = $list['FreightCharge'];
			                	} else {
			                		$FreightCharge = 0;
			                	}

			                	// if ( $list['PricePercent'] < 0 ) {
			                	// 	$PTPercent = "0";
			                	// 	$list['PricePercent'] = percentOf($list['ProductPriceDefault'], $list['PriceAmount']);
			                	// }

			                	// if PT < 0
			                	$list['PricePercent'] = ($list['PricePercent'] < 0) ? 0 : $list['PricePercent'] ;
			                	$PTPercent = ($PTPercent < 0) ? 0 : $PTPercent ; 
			                	$list['ProductPriceDefault'] = ReversePerc($list['PriceAmount'], $PTPercent);
			                	$list['ProductPriceDefault'] = ReversePerc($list['ProductPriceDefault'], $list['PricePercent']);

			                	// fc include in price
			                	$FreightCharge2 = ReversePerc($FreightCharge, $PTPercent);
			                	$FreightCharge2 = ReversePerc($FreightCharge2, $list['PricePercent']);
			                	$ProductPriceDefault2 = $list['ProductPriceDefault'] + ($FreightCharge2/ max($list['ProductQty'],1) );

			                	//fc and promo include in price
			                	$ProductPriceDefault3 = $ProductPriceDefault2 * (1-($list['PricePercent']/100));

			                	if ($FreightCharge <= 0) {
			                		$list['ProductPriceDefault'] = $ProductPriceDefaultAsal;
			                		$ProductPriceDefault2 = $ProductPriceDefaultAsal;
			                	}
			        ?>
				                <tr class="content1">
				                    <td class="ProductID"><?php echo "(".$list['ProductID'].") ".$list['ProductName'];?></td>
				                    <td class="center"><?php echo $list['ProductQty'];?></td>
				                    <td class="right"><?php echo number_format($list['ProductPriceDefault'],2);?></td>
				                    <td class="center"><?php echo $list['PricePercent']."%";?></td>
				                    <td class="center"><?php echo $PTPercent."%";?></td>
				                    <td class="right"><?php echo number_format($FreightCharge,2);?></td>
				                    <td class="right"><?php echo number_format($list['PriceTotal'],2);?></td>
				                </tr>
				                <tr class="content2" style="display: none;">
				                    <td class="ProductID"><?php echo "(".$list['ProductID'].") ".$list['ProductName'];?></td>
				                    <td class="center"><?php echo $list['ProductQty'];?></td>
				                    <td class="right"><?php echo number_format($ProductPriceDefault2,2);?></td>
				                    <td class="center"><?php echo $list['PricePercent']."%";?></td>
				                    <td class="center"><?php echo $PTPercent."%";?></td>
				                    <td class="right">0</td>
				                    <td class="right"><?php echo number_format($list['PriceTotal'],2);?></td>
				                </tr>
				                <tr class="content3" style="display: none;">
				                    <td class="ProductID"><?php echo "(".$list['ProductID'].") ".$list['ProductName'];?></td>
				                    <td class="center"><?php echo $list['ProductQty'];?></td>
				                    <td class="right"><?php echo number_format($ProductPriceDefault3,2);?></td>
				                    <td class="center">0%</td>
				                    <td class="center"><?php echo $PTPercent."%";?></td>
				                    <td class="right">0</td>
				                    <td class="right"><?php echo number_format($list['PriceTotal'],2);?></td>
				                </tr>
				    <?php	
							} 
				    	} 
				    ?> 
			</tbody>
			<tfoot class="mainTfoot">
				<tr>
					<td colspan="7">
						<table width="750px;" class="total">
							<tr>
								<td class="cell1">
									<?php
										if ($so['DPMinimumPercent'] > 0) {
											echo "Minimum DP : ".$so['DPMinimumPercent']."% / ".number_format($so['DPMinimumAmount'],2)."<br><br>";
										}
										if ( ($so['TotalDeposit']+$so['TotalPayment']) > 0) {
											echo "Total Paid : ".number_format(($so['TotalDeposit']+$so['TotalPayment']),2)."<br><br>";
										}
										if ($so['SOTerm'] != "") {
											echo "Term : ".$so['SOTerm']."<br><br>";
										}
										if ($so['SONote'] != "") {
											echo "Note : ".$so['SONote']."<br><br>";
										}
										// if ($so['PermitNote'] != "") {
										// 	echo "Permit : ".$so['PermitNote']."<br><br>";
										// }
										if ($so['CancelNote'] != "") {
											echo "Cancel : ".$so['CancelNote']."<br><br>";
										}
									?>
									ACCOUNT INFORMATION<br>
									PT. ANGHAUZ INDONESIA<br>
									BCA Cabang Margomulyo<br>
									A/C 463-198-8835
								</td>
								<td class="cell2">
									<table width="100%">
										<tr><td>Total Quantity</td><td>:</td><td class="detail right"><?php echo $TotalQty; ?></td></tr>
										<tr><td>Total Before Tax</td><td>:</td><td class="detail right"><?php echo number_format($so['SOTotalBefore'],2); ?></td></tr>
										<tr><td>Tax Rate</td><td>:</td><td class="detail right"><?php echo $so['TaxRate']."%"; ?></td></tr>
										<tr><td>Tax Amount</td><td>:</td><td class="detail right"><?php echo number_format($so['TaxAmount'],2); ?></td></tr>
										<tr><td>Freight Charge</td><td>:</td><td class="detail right"><?php echo number_format($so['FreightCharge'],2); ?></td></tr>
										<tr><td>Total Payment Due</td><td>:</td><td class="detail right"><?php echo number_format($so['SOTotal'],2); ?></td></tr>
									</table>
								</td>
							</tr>
						</table>
						<table width="750px;" class="sign">
							<tr><td></td><td></td><td></td><td></td><td></td></tr>
							<tr>
								<td><?php echo $so['salesname']; ?></td>
								<td><?php echo $so['secname']; ?></td>
								<td></td>
								<td></td>
								<td>Admin</td>
							</tr>
						</table>
					</td>
				</tr>
			</tfoot>
		</table>

		<h5 class="footer">Printed By : <?php echo $UserName;?>, On : <?php echo date('d-m-Y H:i:s');?></h5>
	</div>
</body>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script>
$( "#noprint" ).click(function() {
  	window.print();
});	
$( ".showContentFull" ).click(function() {
  $( ".content1" ).slideDown('fast');
  $( ".content2" ).slideUp('fast');
  $( ".content3" ).slideUp('fast');
});
$( ".showContentNonFC" ).click(function() {
  $( ".content1" ).slideUp('fast');
  $( ".content2" ).slideDown('fast');
  $( ".content3" ).slideUp('fast');
});
$( ".showContentNonPromoFC" ).click(function() {
  $( ".content1" ).slideUp('fast');
  $( ".content2" ).slideUp('fast');
  $( ".content3" ).slideDown('fast');
});
$('#size').live( "keyup", function() {
    size  = $(this).val();
    $(".productlist tbody tr td").css('font-size',size);
});
</script>