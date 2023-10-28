<?php
$company 	= (array) $content['company'];
$warehouse 	= (array) $content['warehouse'];
$do 		= (array) $content['do'];
// print_r($do);
$Supplier 	= explode(";", $do['SupplierNote']);
$Product 	= $content['product'];

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

$lineTotal = 0;
$QtyRequested = 0;
$QtySent = 0;
$QtySend = 0;
$Total = 0;
?>
<head>
	<link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>tool/favicon.png"/> 
	<title><?php echo $PageTitle.' - '. $MainTitle; ?></title>
	<style type="text/css">
		@media only print {
		    a.noprint, input#size { display:none !important; }
			thead {display: table-header-group;} 
			tfoot {display: table-footer-group;}
			
			.page-footer {
			  position: fixed;
			  bottom: 0;
			  width: 100%;
			}
			.page-header {
			  position: fixed;
			  top: 0;
			  width: 100%;
			}
			.page-header-space {
			  height: 255px;
			}
			.page-footer-space {
			  height: 250px;
			}

		}
		@page { size: potrait; display: table; }
		
		.page-header {
		  height: 255px;
		}
		.page-footer {
		  height: 250px;
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
		.header-po1 > td { border: 0px solid #000; width: 250px; }
		.header-po1, .header-po1 tr { vertical-align: top;}
		.header-po1 table tr td { border: 1px !important; font-size: 12px; padding: 0px;}
		td.detail {	font-weight: bold; }

		.productlist tbody { font-size: 12px; }
		.productlist tr td { border: 0px solid #000; }
		.QtyRequested, .ProductID, .QtySent, .QtySend { text-align: center; }
		.productprice, .producttotal { text-align: right; }
		
		.total .cell1{ 
			font-size: 12px;
			font-weight: bold;
			border: 0px solid #000;
			vertical-align: top;
		}
		table { border-collapse: collapse; }
		.footer { 
			font-size: 10px;
			border-top: 0px solid #000;
		}
		.pocancel {
			background: url("<?php echo base_url();?>tool/cancel.png") no-repeat;
			background-position-x: center;
		}
	</style>
</head>

<body>
	<div class="content" style="margin-left: 40px;">
		<input type="number" name="size" id="size">
		<a href="#" id="noprint" class="noprint" autofocus>Print</a>

		<div class="page-header">
			<table style="width: 700px;">
				<tr class="header-company">
					<td colspan="3" style="text-align: right; font-weight: bold; height: 80px;">
						DELIVERY ORDER<br>
						Distribution From Warehouse <?php echo $warehouse['WarehouseName']; ?>
					</td>
				</tr>
				<tr class="header-po1">
					<td>
						<table>
							<tr class="doid">
								<td width="75px"></td>
								<td class="detail"><?php echo $do['DOID']; ?></td>
							</tr>
							<tr>
								<td width="75px"></td>
								<td class="detail"><?php echo $do['DODate']; ?></td>
							</tr>
						</table>
					</td>
					<td>
						<table>
							<tr><td width="100px"></td><td class="detail">PO <?php echo $do['DOReff']; ?></td></tr>
							<tr><td width="100px"></td><td class="detail">RO <?php echo $do['ROID']; ?></td></tr>
						</table>
					</td>
					<td>
					</td>
				</tr>
				<tr class="header-po1">
					<td colspan="3" style="min-height: 180px;">
						<table>
							<tr>
								<td class="detail" style="width: 350px; padding: 5px;">
									<br><br>Ship To : <?php echo $Supplier[0]." (".$Supplier[1].") "; ?>
									<br><?php echo $Supplier[3]; ?>
									<br><?php echo $Supplier[2]; ?>
								</td>
								<td class="detail" style="width: 350px; padding: 5px;">
									<br><br>Ship From : <?php echo $warehouse['WarehouseName']; ?>
									<br><?php echo $warehouse['WarehouseAddress']; ?>
									<br><?php echo "Phone : ".$warehouse['WarehousePhone']; ?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>

		<table>

			<thead class="main">
				<tr>
					<td>
						<div class="page-header-space">
							.
						</div>
					</td>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td>
						<table width="750px;" class="productlist" style="margin-left: -20px; ">
							<thead>
								<tr>
									<td colspan="6">
										<br><br><br><br><br><br>
									</td>
								</tr>
							</thead>
							<tbody>
								<?php
						            if (isset($content['product'])) {
						                foreach ($content['product'] as $row => $list) { 
						                	$lineTotal = $list['QtyRequested']-$list['QtySent'];
											$QtyRequested += $list['QtyRequested'];
											$QtySent += $list['QtySent'];
											$QtySend += $list['QtySend'];
											$Total += $lineTotal;
						        ?>
							                <tr class="content1">
							                    <td class="ProductID" style="width: 30px;"><?php echo $list['ProductID']." (".$list['ProductParent'].")";?></td>
							                    <td class="productName" style="width: 300px;"><?php echo $list['productNameRaw']."<br> (".$list['productNameParent'].")";?></td>
							                    <td class="QtyRequested"><?php echo $list['QtyRequested'];?></td>
							                    <td class="QtySent"><?php echo $list['QtySent'];?></td>
							                    <td class="QtySend"><?php echo $list['QtySend'];?></td>
							                    <td class="QtySend"><?php echo $lineTotal;?></td>

							                </tr>
							    <?php	
										} 
							    	} 
							    ?>

						    	<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="6">
										<br><br><br><br><br><br>
									</td>
								</tr>
							</tfoot>
						</table>
					</td>
				</tr>
			</tbody>

			<tfoot class="main">
				<tr>
					<td>
			          	<div class="page-footer-space">.</div>
					</td>
				</tr>
			</tfoot>
		</table>

		<div class="page-footer">
			<table class="total" style="min-height: 250px; width: 700px;">
				<tr>
					<td class="cell1" style="text-align: justify;">
						<?php echo $do['DONote']; ?>
					</td>
				</tr>
			</table>
			<h5 class="footer" style="display: none;">Printed By : <?php echo $UserName;?>, On : <?php echo date('d-m-Y H:i:s');?></h5>
		</div>
	</div>
</body>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script>
$( "#noprint" ).click(function() {
  	window.print();
});	
$( "button" ).click(function() {
  $( "p" ).toggle();
});

$('#size').live( "keyup", function() {
    size  = $(this).val();
    $(".Product").css('font-size',size);
    $(".productName").css('font-size',size);
    $(".DOReff").css('font-size',size);
    $(".QtyRequested").css('font-size',size);
    $(".QtySent").css('font-size',size);
    $(".QtySend").css('font-size',size);
});
</script>