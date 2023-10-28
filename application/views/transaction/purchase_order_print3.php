<?php
$company 	= (array) $content['company'];
$warehouse 	= (array) $content['warehouse'];
$po 		= (array) $content['po'];
$Supplier 	= explode(";", $po['SupplierNote']);
$Product 	= $content['product'];
if (array_key_exists('raw', $content)) {
	$Raw = $content['raw'];
}
$totalProduct = 0;
$totalRAW = 0;
 
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

if ($po['POType'] == "local") {
	$npwptitle = "NPWP";
} elseif ($po['POType'] == "import") {
	$npwptitle = "Tax Identification Number";
}
$status = ($po['POStatus'] == 2 ? "Canceled" : "");
$status = ($status == "" && $po['isApprove'] == 0 ? "Rejected" : $status);
$status = ($status == "" ? "" : "(".$status.")");
?>
<head>

<link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>tool/favicon.png"/> 
<title><?php echo $PageTitle.' - '. $MainTitle; ?></title>
<style type="text/css">
	@media only print {
	    a.noprint, a.showContent, input#size {
		    display:none !important;
		}
		thead.main { display: table-header-group; }
		tfoot.main { display: table-footer-group; }
		.footer-kaki{
			bottom:0%;
			position: static;
			left: 0; 
			right: 0; 
			margin-left: auto; 
			margin-right: auto; 
		}
	}  
	
	a.noprint, a.showContent {
		margin: 5px 2px;
		background-color: #f44336;
	    color: white;
	    padding: 5px 20px;
	    text-align: center;
	    text-decoration: none;
	    display: inline-block;
	    font-size: 12px;
	    margin-bottom: -20px;
	}
	a.Attachment {
		margin: 3px 2px;
		background-color: #4cae4c;
	    color: white;
	    padding: 2px 5px;
	    text-align: center;
	    text-decoration: none;
	    display: inline-block;
	    font-size: 12px;
	}

	.content {
		font-family: Calibri;
		width: 750px;
	}
	.content table tr td { padding: 5px; }
	.header-company { text-align: center; }
	.header-company td { border: 0px !important; }
	.header-company h2, .header-company h6 { margin: 0px; }
	.header-po1>td { border: 1px solid #000; }
	.header-po1>td:first-child { width: 150px; }
	.header-po1>td:nth-child(2) { width: 270px; }
	.header-po1 .poid td{ font-weight: bolder; font-size: 20px !important; }
	.header-po1, .header-po1 tr { vertical-align: top;}
	.header-po1 table tr td { border: 1px !important; font-size: 12px; padding: 0px;}
	td.detail {	font-weight: bold; }
	.shipto h4, .shipto h5, .shipto h6 { margin: 0px; }

	.productlist th { border-bottom: 2px solid #000; }
	.productlist tbody { font-size: 12px; }
	.productlist tr td { border-bottom: 1px solid #000 !important; }
	.productqty, .productprice, .productdisc { text-align: center; }
	.producttotal { text-align: right; }
	.right { text-align: right; }
	.left { text-align: left; }
	.center { text-align: center; }
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
	.pocancel {
		background: url("<?php echo base_url();?>tool/cancel.png") no-repeat;
		background-position-x: center;
	}
	.ProductID { display: inline; }
	.POimport { display: none; }
    .alignRight { text-align: right; }
</style>
</head>

<body>
	<div class="content">
		<table >
			<thead class="main">
				<tr>
					<td>
						<table width="750px">
							<tr class="header-company">
								<?php if (in_array("print_without_header", $MenuList)) {?>
								<td colspan="2"><img src="<?php echo base_url();?>tool/kopsg.png" width="300px" align="left" style="vertical-align:top; margin-bottom: 0px;" >
								</td>
								<td colspan="2">
									<h3 style="margin-bottom: 0px; margin-top: 10px;" align="right">PURCHASE ORDER. <?php echo $po['POID']; ?></h3>
								</td>
								<?php } else {?>
								<td><img src="<?php echo base_url();?>tool/kop.jpg" width="220px" align="left" style="vertical-align:top" ></td>
								<td colspan="2">
									<h3 style="margin-bottom: 0px; margin-top: 110px;" align="right">PURCHASE ORDER. <?php echo $po['POID']; ?></h3>
								</td>
								<?php } ?>
							</tr>
							<tr class="header-company">
								<td colspan="4">
								<input type="number" name="size" id="size">
									<a href="#" id="noprint" class="noprint" autofocus>Print</a>
									<a href="#" id="showContent" class="showContent" autofocus>Show PO Import</a>
								</td>
							</tr>
							<tr class="header-po1">
								<td>
									<table>
										<tr class="poid"><td width="75px">PO No</td><td>:</td><td class="detail"><?php echo $po['POID']; ?></td></tr>
										<tr><td width="75px">PO Date</td><td>:</td><td class="detail"><?php echo $po['PODate']; ?></td></tr>
										<tr><td width="75px">Ship Date</td><td>:</td><td class="detail"><?php echo $po['ShippingDate']; ?></td></tr>
										<tr><td width="75px">Pay Term </td><td>:</td><td class="detail"><?php echo $po['PaymentTerm']; ?></td></tr>
									</table>
								</td>
								<td>
									<table>
										<tr><td  width="75px">Name </td><td>:</td><td class="detail"><?php echo $Supplier[0]; ?></td></tr>
										<tr><td  width="75px">Phone </td><td>:</td><td class="detail"><?php echo $Supplier[3]; ?></td></tr>
										<tr><td  width="75px">Address </td><td>:</td><td class="detail"><?php echo $Supplier[2]; ?></td></tr>
									</table>
								</td>
								<td class="shipto">
									<h6>SHIP TO :</h6>
									<?php 
										if ($po['ShippingAlt'] == "") {
									?>
									<h4><?php echo $warehouse['WarehouseName']; ?></h4>
									<h6>
										<?php echo $warehouse['WarehouseAddress']; ?><br>
										<?php echo "Phone : ".$warehouse['WarehousePhone']; ?>
									</h6>
									<?php 
										} else {
									?>
									<h6>
										<?php echo $po['ShippingAlt']; ?><br>
									</h6>
									<?php 
										}
									?>
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
								<th class="left">Product Name</th>
								<th>Qty</th>
								<th>Disc</th>
								<th>Price</th>
								<th class="right">Total</th>
							</thead>
							<tbody>
								<?php
						            if (isset($content['product'])) {
						                foreach ($Product as $row => $list) { 
						                	$totalProduct += $list['ProductQty'];
						                	$ProductName = ($list['ProductSupplierCode'] != "") ? $list['ProductSupplierCode'] : $list['ProductName'] ;
						        ?>
							                <tr>
							                    <td class="productname">
							                    	<?php echo $ProductName;?>
							                    </td>
							                    <td class="productqty"><?php echo $list['ProductQty'];?></td>
							                    <td class="productdisc"><?php echo $list['ProductDisc'];?></td>
							                    <td class="productprice">
							                    	<span class="POlocal"><?php echo "Rp. ".number_format($list['ProductPrice'],2);?></span>
							                    	<span class="POimport"><?php echo $po['POCurrency']." ".number_format($list['ProductPrice2'],2);?></span>
						                    	</td>
							                    <td class="producttotal">
							                    	<span class="POlocal"><?php echo "Rp. ".number_format($list['ProductPriceTotal'],2);?></span>
							                    	<span class="POimport"><?php echo $po['POCurrency']." ".number_format($list['ProductPriceTotal2'],2);?></span>
						                    	</td>
							                </tr>
						        <?php 
						        			if (isset($Raw)) {
						        				if (array_key_exists($list['ProductID'], $Raw)) {
						        ?>
						        			<tr>
						        				<td colspan="5" >
						        					<table class="raw">
						        						<thead><tr><th class="left">Raw Name</th><th>Raw Qty</th></tr></thead><tbody>
						        <?php
						        					foreach ($Raw[$list['ProductID']] as $key => $list2) {
						                				$totalRAW += $list2['RawQty'];
						        ?>
						        			<tr>
						        				<td class="rawname"><?php echo $list2['ProductName']?></td>
						        				<td class="rawqty"><?php echo $list2['RawQty']?></td>
						        			</tr>
						        <?php
						        					}
						        ?>
						        						</tbody>
						        					</table>
						        				</td>
						        			</tr>
						        <?php
						        				}
						        			}
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
								<td class="cell1"><?php echo $po['PONote']; ?></td>
								<td class="cell2">
									<table width="100%">
										<tr>
											<td>Total Product</td>
											<td>:</td>
											<td class="detail alignRight"> 
												<?php echo number_format($totalProduct);?> 
											</td>
										</tr>
								        <?php if ($totalRAW > 0) { ?>
										<tr>
											<td>Total RAW</td>
											<td>:</td>
											<td class="detail alignRight">
												<?php echo number_format($totalRAW);?>
											</td>
										</tr>
								        <?php } ?>
										<tr>
											<td>Purchase Before Tax</td>
											<td>:</td>
											<td class="detail alignRight">
						                    	<span class="POlocal"><?php echo "Rp. ".number_format($po['PriceBefore'],2);?></span>
						                    	<span class="POimport"><?php echo $po['POCurrency']." ".number_format($po['PriceBefore2'],2);?></span>
											</td>
										</tr>
										<tr>
											<td>Tax Amount</td>
											<td>:</td>
											<td class="detail alignRight">
						                    	<span class="POlocal"><?php echo "Rp. ".number_format($po['TaxAmount'],2);?></span>
						                    	<span class="POimport"><?php echo $po['POCurrency']." ".number_format($po['TaxAmount2'],2);?></span>
											</td>
										</tr>
										<tr>
											<td>Total Payment Due</td>
											<td>:</td>
											<td class="detail alignRight">
						                    	<span class="POlocal"><?php echo "Rp. ".number_format($po['TotalPrice'],2);?></span>
						                    	<span class="POimport"><?php echo $po['POCurrency']." ".number_format($po['TotalPrice2'],2);?></span>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<br>
						<table width="750px;" class="sign">
							<tr><td></td><td></td><td></td><td></td><td></td></tr>
							<tr>
								<td><?php echo $po['fullname']; ?></td>
								<td></td>
								<td></td>
								<td></td>
								<td>Supplier</td>
							</tr>
						</table>
						<h5 class="footer">
							Printed By : <?php echo $UserName;?>, On : <?php echo date('d-m-Y H:i:s');?><span class="pageCounter"></span>
						</h5>
					</td>
				</tr>
				<tr>
					<td class="footer-kaki">
						<!-- <center><img  src="<?php echo base_url();?>tool/angzcommerz.png" width="220px" ></center> -->
					</td>
				</tr>
			</tfoot>
		</table>
	</div>

<?php 
	if ($po['POAttachment'] != "") {
?>
<div class="div_attachment">
	File Attachment : <a href="<?php echo base_url();?>tool/po/<?php echo $po['POAttachment']; ?>" class="Attachment" ><?php echo $po['POAttachment']; ?></a>
	<!-- <embed src="<?php echo base_url();?>tool/po/<?php echo $po['POAttachment']; ?>" width="760px" height="100%" /> -->
	<!-- <iframe src="<?php echo base_url();?>tool/po/<?php echo $po['POAttachment']; ?>" width="750px" height="100%" /> -->
	<!-- <iframe src="http://docs.google.com/gview?url=<?php echo base_url();?>tool/po/<?php echo $po['POAttachment']; ?>&embedded=true"  style="width:750px; height:500px;" frameborder="0"></iframe> -->
</div>
<?php } ?>

</body>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script>
$( "#noprint" ).click(function() {
  	window.print();
});	
$( "#showContent" ).click(function() {
  $( ".POlocal" ).toggle();
  $( ".POimport" ).toggle();
});
$('#size').live( "keyup", function() {
    size  = $(this).val();
    $(".productname").css('font-size',size);
    $(".productqty").css('font-size',size);
    $(".productdisc").css('font-size',size);
    $(".productprice").css('font-size',size);
    $(".producttotal").css('font-size',size);
    $(".rawname").css('font-size',size);
    $(".rawqty").css('font-size',size);
});
</script>