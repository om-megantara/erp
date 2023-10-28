<?php
$company 	= (array) $content['company'];
$warehouse 	= (array) $content['warehouse'];
$do 		= (array) $content['do'];
//print_r($do);
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
			font-family: Calibri;
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
		td.detail {	font-weight: bold; }
		.sendfrom h4, .sendfrom h5, .sendfrom h6 { margin: 0px; }

		.productlist th { border-bottom: 2px solid #000; }
		.productlist tbody { font-size: 12px; }
		.productlist tr td { border-bottom: 1px solid #000 !important; }
		.ProductID  {text-align: left; }
		.NotSend  {text-align: right; }
		.QtyRequested, .QtySent, .QtySend {  text-align: center; }
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
	<table width="750px" >
		<tr class="header-company" >
			<?php if (in_array("print_without_header", $MenuList)) {?>
			<td ></td>
			<td colspan="2">
				<h3 style="margin-bottom: 0px; margin-top: 10px;" align="right">Delivery Order Raw. <?php echo $do['DOID']; ?></h3>
			</td>
			<?php } else {?>
			<td ><img src="<?php echo base_url();?>tool/kop.jpg" width="220px" align="left" style="vertical-align:top" ></td>							
			<td colspan="2">
				<h3 style="margin-bottom: 0px; margin-top: 110px;" align="right">Delivery Order Raw. <?php echo $do['DOID']; ?></h3>
			</td>
			<?php } ?>
		</tr>
		<tr>
			<td>
			<input type="number" name="size" id="size">
			</td>
			<td>
				<a href="#" id="noprint" class="noprint" autofocus>Print</a>
			</td>
		</tr>
		<tr class="header-po1">
			<td>
				<table>
					<tr class="doid"><td width="75px">DO No</td><td>: </td><td class="detail"> <?php echo $do['DOID']; ?></td></tr>
					<tr><td width="75px">DO Date</td><td>: </td><td class="detail"> <?php echo $do['DODate']; ?></td></tr>
					<tr><td width="75px">PO Number </td><td>: </td><td class="detail"> <?php echo $do['DOReff']; ?></td></tr>
					<tr><td width="75px">RO Number </td><td>: </td><td class="detail"> <?php echo $do['ROID']; ?></td></tr>
					<tr><td width="75px">Employee </td><td>: </td><td class="detail"> <?php echo $do['fullname']; ?></td></tr>
				</table>
			</td>
			<td>
				<table>
					<tr><td  width="75px">Name </td><td>: </td><td class="detail"> <?php echo $Supplier[0]." (".$Supplier[1].") "; ?></td></tr>
					<tr><td  width="75px">Phone </td><td>: </td><td class="detail"> <?php echo $Supplier[3]; ?></td></tr>
					<tr><td  width="75px">Address </td><td>: </td><td class="detail"> <?php echo $Supplier[2]; ?></td></tr>
				</table>
			</td>
			<td class="sendfrom">
				<h6>SEND FROM :</h6>
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
			<th align="left">Product ID</th>
			<th>Product Name</th>
			<th>Qty Requested</th>
			<th>Qty Sent</th>
			<th>Qty Send</th>
			<th align="right">Not Sent yet </th>
		</thead>
		<tbody>
			<?php
	            if (isset($content['product'])) {
	                foreach ($Product as $row => $list) { 
	                	$lineTotal = $list['QtyRequested']-$list['QtySent'];
						$QtyRequested += $list['QtyRequested'];
						$QtySent += $list['QtySent'];
						$QtySend += $list['QtySend'];
						$Total += $lineTotal;
	        ?>
		                <tr>
		                    <td class="ProductID"><?php echo $list['ProductID']." (".$list['ProductParent'].")";?></td>
		                    <td class="productName"><?php echo $list['productNameRaw']."<br> (".$list['productNameParent'].")";?></td>
		                    <td class="QtyRequested"><?php echo $list['QtyRequested'];?></td>
		                    <td class="QtySent"><?php echo $list['QtySent'];?></td>
		                    <td class="QtySend"><?php echo $list['QtySend'];?></td>
		                    <td class="NotSend"><?php echo $lineTotal;?></td>
		                </tr>
		    <?php	
					} 
		    	} 
		    ?>
		                <tr>
		                    <td class="ProductID"></td>
		                    <td class="productName"></td>
		                    <td class="QtyRequested"></td>
		                    <td class="QtySent"></td>
		                    <td class="QtySend"></td>
		                    <td class="NotSend"></td>
		                </tr>
		                <tr>
		                    <td class="ProductID"><b>TOTAL</b></td>
		                    <td class="productName"></td>
		                    <td class="QtyRequested"><?php echo $QtyRequested;?></td>
		                    <td class="QtySent"><?php echo $QtySent;?></td>
		                    <td class="QtySend"><?php echo $QtySend;?></td>
		                    <td class="NotSend"><?php echo $Total;?></td>
		                </tr>
		</tbody>
	</table><br>

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
    $(".Product").css('font-size',size);
    $(".productName").css('font-size',size);
    $(".DOReff").css('font-size',size);
    $(".QtyRequested").css('font-size',size);
    $(".QtySent").css('font-size',size);
    $(".QtySend").css('font-size',size);
    //$(".rawqty").css('font-size',size);
});
</script>