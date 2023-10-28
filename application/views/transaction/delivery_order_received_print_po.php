<?php
$company 	= (array) $content['company'];
$warehouse 	= (array) $content['warehouse'];
$dor 		= (array) $content['dor'];

$Supplier 	= explode(";", $dor['SupplierNote']);
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
$qtyorder = 0;
$qtyreceived = 0;
$qtyreceive = 0;
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
		    margin-bottom: 0px;
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
		.header-po1 .dorid td{ font-weight: bolder; font-size: 15px !important; }
		.header-po1, .header-po1 tr { vertical-align: top;}
		.header-po1 table tr td { border: 0px !important; font-size: 12px; padding: 0px;}

		.shipto h4, .shipto h5, .shipto h6 { margin: 0px; }

		.productlist th { border-bottom: 2px solid #000; font-size: 13px; }
		.productlist tbody { font-size: 12px; }
		.productlist tr td { border-bottom: 1px dashed #000 !important; }
		.qtyorder, .qtyreceive, .qtyreceived { text-align: center; }
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
			width: 10%;
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
	<table width="750px" >
		<tr class="header-company">
			<?php if (in_array("print_without_header", $MenuList)) {?>
			<td colspan="4">
				<h3 style="margin-bottom: 0px; margin-top: 10px;" align="right">DELIVERY ORDER RECEIVED. <?php echo $dor['DORID'];?></h3>
			</td>
			<?php } else {?>
			<td><img src="<?php echo base_url();?>tool/kop.jpg" width="170px" align="left" style="vertical-align:top" ></td>
			<td colspan="2">
				<h3 style="margin-bottom: 0px; margin-top: 60px;" align="right">DELIVERY ORDER RECEIVED. <?php echo $dor['DORID'];?></h3>
			</td>
			<?php } ?>
		</tr>
		<tr>
			<td>
				<!-- <input type="number" name="size" id="size"> -->
			</td>
			<td>
				<a href="#" id="noprint" class="noprint" autofocus>Print</a>
			</td>
		</tr>
		<tr class="header-po1">
			<td>
				<table>
					<tr class="dorid"><td width="75px">DOR No </td><td>:</td><td class="detail"><?php echo $dor['DORID']; ?></td></tr>
					<tr><td width="75px">DOR Date </td><td>:</td><td class="detail"><?php echo $dor['DORDate']; ?></td></tr>
					<tr><td width="75px">PO Number </td><td>:</td><td class="detail"><?php echo $dor['DORReff']; ?></td></tr>
					<tr><td width="75px">Surat Jalan </td><td>:</td><td class="detail"><?php echo $dor['DORDoc']; ?></td></tr>
					<!--<tr><td width="75px">Pay Term </td><td>:</td><td class="detail"><?php echo $po['PaymentTerm']; ?></td></tr>-->
				</table>
			</td>
			<td>
				<table>
					<tr><td  width="75px">Name </td><td>:</td><td class="detail"><?php echo $Supplier[0]." (".$Supplier[1].") "; ?></td></tr>
					<tr><td  width="75px">Phone </td><td>:</td><td class="detail"><?php echo $Supplier[3]; ?></td></tr>
					<tr><td  width="75px">Address </td><td>:</td><td class="detail"><?php echo $Supplier[2]; ?></td></tr>
				</table>
			</td>
			<td class="shipto">
				<h6>SHIP TO :</h6>
				<h4><?php echo $warehouse['WarehouseName']; ?></h4>
				<h6>
					<?php echo $warehouse['WarehouseAddress']; ?><br>
					<?php echo "Phone : ".$warehouse['WarehousePhone']; ?>
				</h6>
			</td>
		</tr>
	</table><br>
	<table width="750px;" class="productlist">
		<thead>
			<th>Product Description</th>
			<th>Qty Ordered</th>
			<th>Qty Already Received</th>
			<th>Qty In Delivery</th>
		</thead>
		<tbody>
			<?php
	            if (isset($content['product'])) {
	                foreach ($Product as $row => $list) { 
	                	$qtyorder += $list['qtyorder'];
	                	$qtyreceived += $list['qtyreceived'];
	                	$qtyreceive += $list['qtyreceive'];
	        ?>
		                <tr>
		                    <td class="ProductCode"><div class="ProductID">(<?php echo $list['ProductID'];?>)</div> <?php echo $list['ProductCode'];?></td>
		                    <td class="qtyorder"><?php echo $list['qtyorder'];?></td>
		                    <td class="qtyreceived"><?php echo $list['qtyreceived'];?></td>
		                    <td class="qtyreceive"><?php echo $list['qtyreceive'];?></td>
		                </tr>
		    <?php	
					} 
		    	} 
		    ?>
            <tr>
                <td class="ProductCode"></td>
                <td class="qtyorder"></td>
                <td class="qtyreceived"></td>
                <td class="qtyreceive"></td>
            </tr>
            <tr>
                <td class="ProductCode"><b>TOTAL</b></td>
                <td class="qtyorder"><?php echo $qtyorder;?></td>
                <td class="qtyreceived"><?php echo $qtyreceived;?></td>
                <td class="qtyreceive"><?php echo $qtyreceive;?></td>
            </tr>
		</tbody>
	</table><br>
	<table width="750px;" class="sign">
		<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
		<tr>
			<td><?php echo $dor['fullname']; ?></td>
			<td>Accounting</td>
			<td>Menyetujui</td>
			<td>Mengetahui</td>
			<td>Petugas Bank</td>
			<td>Penyetor</td>
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
    $(".poid").css('font-size',size);
    $(".ProductCode").css('font-size',size);
    $(".DORReff").css('font-size',size);
    $(".qtyorder").css('font-size',size);
    $(".qtyreceive").css('font-size',size);
    $(".qtyreceived").css('font-size',size);
    //$(".rawqty").css('font-size',size);
});
</script>