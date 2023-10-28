
<?php
// $warehouse 	= (array) $content['warehouse'];
$ro 		= $content['main'];
// $Supplier 	= explode(";", $po['SupplierNote']);
$Product 	= $content['product'];
if (array_key_exists('raw', $content)) {
	$Raw = $content['raw'];
}

// $f 		= fopen(('./tool/HeaderFaktur1.txt'), "r");
// $npwp 	= fgets($f);
// fclose($f);
// $alamat = explode(";", $npwp);
?>
<head>
	<link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>tool/favicon.png"/> 
	<title><?php echo $PageTitle.' - '. $MainTitle; ?></title>
	<style type="text/css">
		@media only print {
		    a.noprint, input#size {
			    display:none !important;
			}
			thead.main { display: table-header-group; }
			tfoot.main { display: table-footer-group; }
		}
		@page { 
			size: potrait; 
			counter-increment: page; 
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

		.content {
			font-family: Arial, Helvetica, sans-serif;
			width: 750px;
		}
		.content table tr td { padding: 5px; }
		.header-company { text-align: center; }
		.header-company td { border: 0px !important; }
		.header-company h2, .header-company h6 { margin: 0px; }
		.header-po1>td { border: 1px solid #000; }
		.header-po1>td:first-child { width: 170px; }
		.header-po1>td:nth-child(2) { width: 370px; }
		.header-po1 .poid td{ font-weight: bolder; font-size: 20px !important; }
		.header-po1, .header-po1 tr { vertical-align: top;}
		.header-po1 table tr td { border: 1px !important; font-size: 12px; padding: 0px;}
		td.detail {	font-weight: bold; }
		.shipto h4, .shipto h5, .shipto h6 { margin: 0px; }

		.productlist th { border-bottom: 2px solid #000; }
		.productlist tbody { font-size: 12px; }
		.productlist tr td { border-bottom: 1px dashed #000 !important; }
		.productqty, .productdisc { text-align: center; }
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
		table { border-collapse: collapse; }
		.footer { 
			font-size: 10px;
			border-top: 1px solid #000;
		}
		#pageNumber { float: right; }

		.raw { 
			font-size: 12px;
			margin-left: 30px;
			background-color: #c4c4c4;
		}
		.raw tbody tr td:nth-child(2) { width: 400px; }
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
					<input type="number" name="size" id="size">
					<a href="#" id="noprint" class="noprint" autofocus>Print</a><br><br>
					<table width="750px">
						<tr class="header-po1">
							<td>
								<table>
									<tr class="poid"><td width="75px">RO ID</td><td>:</td><td class="detail"><?php echo $ro['ROID']; ?></td></tr>
									<tr><td width="75px">RO Date</td><td>:</td><td class="detail"><?php echo $ro['RODate']; ?></td></tr>
								</table>
							</td>
							<td class="shipto">
								<table>
									<tr><td width="75px">SO ID</td><td>:</td><td class="detail"><?php echo $ro['SOID']; ?></td></tr>
									<tr><td width="75px">RO Note</td><td>:</td><td class="detail"><?php echo $ro['RONote']; ?></td></tr>
								</table>
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
							<th>Product ID</th>
							<th>Product Name</th>
							<th>Qty</th>
						</thead>
						<tbody>
							<?php
					            if (isset($content['product'])) {
					                foreach ($Product as $row => $list) { 
					        ?>
						                <tr>
						                    <td class="productqty"><?php echo $list['ProductID'];?></td>
						                    <td class="productname"><?php echo $list['ProductCode'];?></td>
						                    <td class="productqty"><?php echo $list['ProductQty'];?></td>
						                </tr>
					        <?php 
					        			if (isset($Raw)) {
					        				if (array_key_exists($list['ProductID'], $Raw)) {
					        ?>			
					        			<tr>
					        				<td colspan="3">
					        					<table class="raw">
					        						<thead><tr><th>Raw ID</th><th>Raw Name</th><th>Raw Qty</th></tr></thead><tbody>
					        <?php
					        					foreach ($Raw[$list['ProductID']] as $key => $list2) {
					        ?>
					        			<tr>
					        				<td class="rawqty"><?php echo $list2['RawID']?></td>
					        				<td class="rawname"><?php echo $list2['ProductCode']?></td>
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
    $(".productname").css('font-size',size);
    $(".productqty").css('font-size',size);
    $(".productdisc").css('font-size',size);
    $(".productprice").css('font-size',size);
    $(".producttotal").css('font-size',size);
    $(".rawname").css('font-size',size);
    $(".rawqty").css('font-size',size);
});
</script>