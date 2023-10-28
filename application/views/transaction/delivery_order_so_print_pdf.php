<?php
$warehouse 	= (array) $content['warehouse'];
$do 		= (array) $content['do'];
$BillingAddress = explode(";", $do['BillingAddress']);
$ShipAddress = explode(";", $do['ShipAddress']);

//print_r($do); 
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

$QtyPurchased = 0;
$QtySent = 0;
$QtySend = 0;
$QtyNotSent = 0;
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
		    margin-bottom: 0px;
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
		.header-po1>td:first-child { width: 250px; }
		.header-po1>td:nth-child(2) { width: 300px; }
		.header-po1 .dorid td{ font-weight: bolder; font-size: 15px !important; }
		.header-po1, .header-po1 tr { vertical-align: top;}
		.header-po1 table tr td { border: 0px !important; font-size: 12px; padding: 0px;}
		td.detail {	font-weight: bold; }
		.sendfrom h4, .sendfrom h5, .sendfrom h6 { margin: 0px; }

		.productlist th { border-bottom: 2px solid #000; }
		.productlist tbody { font-size: 12px; }
		.productlist tr td { border-bottom: 1px solid #000 !important; }
		.ProductID {text-align: left;}
		.NotSend {text-align: right;}
		.QtyRequested, .QtySent, .QtySend { text-align: center; }
		.productprice, .producttotal { text-align: right; }
		
		.total .cell1{ 
			width: 250px; 
			font-size: 12px;
			font-weight: bold;
			border: 1px solid #000;
			vertical-align: top;
			word-break: break-all;
		}
		.total .cell2{ 
			width: 110px; 
			font-size: 12px;
			font-weight: bold;
			border: 1px solid #000;
			vertical-align: bottom;
			text-align: center;
		}

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
			<thead class="main">
				<tr>
					<td>
						<table width="750px" >
							<tr class="header-company" >
								<?php if (in_array("print_without_header", $MenuList)) {?>
								<td colspan="2"><img src="<?php echo base_url();?>tool/kopsg.png" width="300px" align="left" style="vertical-align:top; margin-bottom: 0px;" >
								</td>
								<td colspan="2">
									<h3 style="margin-bottom: 0px; margin-top: 10px;" align="right">Delivery Order SO. <?php echo $do['DOID']; ?></h3>
								</td>
								<?php } else {?>
								<td ><img src="<?php echo base_url();?>tool/kop.jpg" width="220px" align="left" style="vertical-align:top" ></td>
								<td colspan="2">
									<h3 style="margin-bottom: 0px; margin-top: 110px;" align="right">Delivery Order SO. <?php echo $do['DOID']; ?></h3>
								</td>
								<?php } ?>
							</tr>
							<tr>
								<td>
									<a href="#" id="noprint" class="noprint" autofocus>Print</a>
								</td>
							</tr>
							<tr class="header-po1">
								<td>
									<table>
										<tr class="doid"><td width="75px">DO Number</td><td>: </td><td class="detail"><?php echo $do['DOID']; ?></td></tr>
										<tr><td width="75px">DO Date</td><td>: </td><td class="detail"><?php echo $do['DODate']; ?></td></tr>
										<tr><td width="75px">SO Number </td><td>: </td><td class="detail"><?php echo $do['DOReff']; ?></td></tr>
										<tr><td width="75px">SO Category </td><td>: </td><td class="detail"><?php echo $do['SOCategory']; ?></td></tr>
										<tr><td width="75px">SO Date</td><td>: </td><td class="detail"><?php echo $do['SODate']; ?></td></tr>
										<tr><td width="75px">Sales </td><td>: </td><td class="detail"><?php echo $do['fullname']; ?></td></tr>
									</table>
								</td>
								<td>
									<table>
										<tr><td  width="75px">Customer </td><td>:</td><td class="detail"><?php echo $BillingAddress[0]; ?></td></tr>
										<tr><td  width="75px">Shiiping To </td><td>:</td><td class="detail"><?php echo $ShipAddress[1]."<br>".$ShipAddress[2]; ?></td></tr>
									</table>
								</td>
								<td class="sendfrom">
									<h6>SEND FROM :</h6>
									<h4><?php echo $warehouse['WarehouseName']; ?></h4>
									<h6>
										<?php echo $warehouse['WarehouseAddress']; ?><br>
										<?php echo "Phone : ".$warehouse['WarehousePhone']; ?><br>
									</h6>
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
								<th align="left">ID</th>
								<th>Product Name</th>
								<th>Qty Purchased</th>
								<th>Qty Sent</th>
								<th>Qty Send</th>
								<th align="right">Not Sent yet </th>
							</thead>
							<tbody>
								<?php
						            if (isset($content['product'])) {
						                foreach ($content['product'] as $row => $list) { 
						                	$QtyPurchased += $list['QtyPurchased'];
											$QtySent += $list['QtySent'];
											$QtySend += $list['QtySend'];
											$QtyNotSent += ($list['QtyPurchased']-$list['QtySend']-$list['QtySent']);
						        ?>
							                <tr>
							                    <td class="ProductID"><?php echo $list['ProductID'];?></td>
							                    <td class="productName"><?php echo $list['ProductName'];?></td>
							                    <td class="QtyRequested"><?php echo $list['QtyPurchased'];?></td>
							                    <td class="QtySent"><?php echo $list['QtySent'];?></td>
							                    <td class="QtySend"><?php echo $list['QtySend'];?></td>
							                    <td class="NotSend"><?php echo $list['QtyPurchased']-$list['QtySend']-$list['QtySent'];?></td>
							                </tr>
							    <?php	
										} 
							    	} 
							    ?>
							    			<tr><td colspan="6"></td></tr>
							                <tr>
							                    <td class="ProductID" colspan="2">Total</td>
							                    <td class="QtyRequested"><?php echo $QtyPurchased;?></td>
							                    <td class="QtySent"><?php echo $QtySent;?></td>
							                    <td class="QtySend"><?php echo $QtySend;?></td>
							                    <td class="NotSend"><?php echo $QtyNotSent;?></td>

							                </tr>
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
								<td class="cell1" style="text-align: justify;">
									If there is any incorrect transactions, please inform us within 30 days from invoice date.
									<br>
									<br>
									Bila terjadi tagihan yang tidak sesuai, kami mohon keluhan anda diinformasikan maksimal 30 hari sejak tanggal tagihan.
								</td>
								<td class="cell1" style="width:450px">
									<?php echo $do['DONote']; ?>
									<br>
									<br>
									<?php echo $do['SONote']; ?>
									<br>
									<br>
									kondisi barang yang diterima harap diperiksa kembali. Komplain atas cacat barang hanya diterima dalam waktu 2x24 jam. 
									Selebihnya dianggap diterima dengan kondisi baik.
								</td>
								<td class="cell2">Logistic</td>
								<td class="cell2">Customer</td>
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
    $(".Product").css('font-size',size);
    $(".productName").css('font-size',size);
    $(".DOReff").css('font-size',size);
    $(".QtyRequested").css('font-size',size);
    $(".QtySent").css('font-size',size);
    $(".QtySend").css('font-size',size);
    //$(".rawqty").css('font-size',size);
});
</script>