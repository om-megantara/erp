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
	    a.noprint, input#size, a.Attachment {
		    display:none !important;
		}
		thead.main { display: table-header-group; }
		tfoot.main { display: table-footer-group; }
		.footer-kaki{
			bottom:0%;
			position: absolute;
			left: 0; 
			right: 0; 
			margin-left: auto; 
			margin-right: auto; 
		}
	}
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
	.right { text-align: right; }
	.left { text-align: left; }
	.center { text-align: center; }
	.content {
		font-family: Calibri;
		width: 750px;
	}
	.content table tr td { padding: 5px; }
	.header-company { text-align: center; }
	.header-company td { border: 0px !important; }
	.header-company h2, .header-company h6 { margin: 0px; }
	.header-po1>td { border: 1px solid #000; }
	.header-po1>td:first-child { width: 170px; }
	.header-po1>td:nth-child(2) { width: 270px; }
	.header-po1 .poid td{ font-weight: bolder; font-size: 20px !important; }
	.header-po1, .header-po1 tr { vertical-align: top;}
	.header-po1 table tr td { border: 0px !important; font-size: 12px; padding: 0px;}
	td.detail {	font-weight: bold; }
	.shipto h4, .shipto h5, .shipto h6 { margin: 0px; }

	.productlist th { border-bottom: 2px solid #000; }
	.productlist tbody { font-size: 12px; }
	.productlist tr td { border-bottom: 1px solid #000 !important; }
	.productqty, .productdisc { text-align: right; }
	.productprice, .producttotal { text-align: right; }
	/*.productname { width: 410px; font-size: 15px; font-weight: bold; }*/
	/*.productqty, .productdisc, .productprice, .producttotal { font-size: 15px; font-weight: bold; }*/

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
	/*.rawname { font-weight: bold; font-size: 12px; }*/
	.pocancel {
		background: url("<?php echo base_url();?>tool/cancel.png") no-repeat;
		background-position-x: center;
	}
	.ProductID { display: inline; }

</style>
</head>
<body>
	<div class="content">
		<table>
			<thead class="main">
				<tr>
					<td>
						<table width="750px">
							<tr class="header-company">
								<?php if (in_array("print_without_header", $MenuList)) {?>
								<td></td>
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
							<tr class="header-po1">
								
								<input type="number" name="size" id="size">
									<a href="#" id="noprint" class="noprint" autofocus>Print</a>
									
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
								<th class="right">Qty</th>
								<!-- 
								<th>Disc</th>
								<th>Price</th>
								<th>Total</th>
								 -->
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
							                    	<!-- <div class="ProductID">(<?php echo $list['ProductID'];?>)</div>  -->
							                    	<?php echo $ProductName;?>
							                    </td>
							                    <td class="productqty"><?php echo $list['ProductQty'];?></td>
							                    <!-- 
							                    <td class="productdisc"><?php echo $list['ProductDisc'];?></td>
							                   	<td class="productprice"><?php echo $po['POCurrency']." ".number_format($list['ProductPrice'],2);?></td>
							                    <td class="producttotal"><?php echo $po['POCurrency']." ".number_format($list['ProductPriceTotal'],2);?></td>
							               		 -->
							                </tr>
						        <?php 
						        			if (isset($Raw)) {
						        				if (array_key_exists($list['ProductID'], $Raw)) {
						        ?>
						        			<tr>
						        				<td colspan="5">
						        					<table class="raw">
						        						<thead><tr><th>Raw Name</th><th>Raw Qty</th></tr></thead><tbody>
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
									<table width="100%" style="display: none;">
									<?php 
										if ($po['POType'] == "local") {
									?>
										<tr>
											<td>Down Payment</td><td>:</td><td class="detail"><?php echo $po['POCurrency']." ". number_format($po['DownPayment'],2); ?></td>
										</tr>
										<tr><td>Purchase Before Tax</td><td>:</td><td class="detail"><?php echo $po['POCurrency']." ". number_format($po['PriceBefore'],2); ?></td></tr>
										<tr><td>Tax Rate</td><td>:</td><td class="detail"><?php echo $po['TaxRate']."%"; ?></td></tr>
										<tr><td>Tax Amount</td><td>:</td><td class="detail"><?php echo $po['POCurrency']." ". number_format($po['TaxAmount'],2); ?></td></tr>
									<?php 
										}
									?>
										<tr><td>Total Payment Due</td><td>:</td><td class="detail"><?php echo $po['POCurrency']." ". number_format($po['TotalPrice'],2); ?></td></tr>
									</table>
								</td>
							</tr>
						</table>
						<br>
						<h5 class="footer">Printed By : <?php echo $UserName;?>, On : <?php echo date('d-m-Y H:i:s');?>
						</h5>
					</td>
				</tr>
				<tr>
					<td class="footer-kaki">
						<center><img  src="<?php echo base_url();?>tool/angzcommerz.png" width="220px" ></center>
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

</div>
<?php } ?>
</body>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script>
$( "#noprint" ).click(function() {
  	window.print();
});	

$('#size').live( "keyup", function() {
    size  = $(this).val();
    $(".productname").css('font-size',size);
    $(".productqty").css('font-size',size);
    $(".productdisc").css('font-size',size);
    //$(".productprice").css('font-size',size);
    //$(".producttotal").css('font-size',size);
    $(".rawname").css('font-size',size);
    $(".rawqty").css('font-size',size);
});
</script>