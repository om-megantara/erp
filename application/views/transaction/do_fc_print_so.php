<?php
$somain 	= (array) $content['somain'];
$sodetail 	= (array) $content['sodetail'];
$payment 	= (array) $content['payment'];
$ShipAddress= explode(";", $somain['BillingAddress']);
$weightTotal = 0;
$qtyTotal = 0;
$FCin = 0;
$FCex = $somain['FreightCharge'];

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
		    margin-bottom: 10px;
		}

		.content {
			font-family: Arial, Helvetica, sans-serif;
			width: 750px;
		}
		.content table tr td { padding: 2px; }
		.header-po1>td { border: 1px solid #000; }
		.header-po1>td:first-child { width: 200px; }
		.header-po1>td:nth-child(2) { width: 260px; }
		.header-po1, .header-po1 tr { vertical-align: top;}
		.header-po1 table tr td { border: 0px !important; font-size: 12px; padding: 0px;}

		.productlist th { border-bottom: 2px solid #000; font-size: 13px;}
		.productlist tbody { font-size: 12px; }
		.productlist tr td { border-bottom: 0px dashed #000 !important; }
		.qtyorder, .qtyreceive, .qtyreceived { text-align: center; }
		.productprice, .producttotal { text-align: right; }
		
		table { border-collapse: collapse; }
		.ProductID { display: inline; }

		.payment {
			font-size: 10px;
			font-weight: bold;
			display: inline-block;
		}
		h3 { margin: 0px; }
	</style>
</head>

<body>
	<center><a href="#" id="noprint" class="noprint" autofocus>Print</a></center>
	<div class="content">
		<center><h3>FORM FREIGHT CHARGE</h3></center>
		<table width="750px">
			<tr class="header-po1">
				<td>
					<table>
						<tr><td width="75px">DO No </td><td>:</td><td class="detail"><?php echo $somain['DOID']; ?></td></tr>
						<tr><td width="75px">SO No </td><td>:</td><td class="detail"><?php echo $somain['SOID']; ?></td></tr>
						<tr><td width="75px">SO Date </td><td>:</td><td class="detail"><?php echo $somain['SODate']; ?></td></tr>
						<tr><td width="75px">SO Category </td><td>:</td><td class="detail"><?php echo $somain['CategoryName']; ?></td></tr>
					</table>
				</td>
				<td>
					<table>
						<tr><td width="75px">Sales Name</td><td>:</td><td class="detail"><?php echo $somain['salesname']; ?></td></tr>
						<tr><td width="75px">Customer ID </td><td>:</td><td class="detail"><?php echo $somain['CustomerID']; ?></td></tr>
						<tr><td width="75px">Company </td><td>:</td><td class="detail"><?php echo $somain['Company']; ?></td></tr>
					</table>
				</td>
			</tr>
		</table><br>
		<table width="750px;" class="productlist">
			<thead>
				<th>Product Name</th>
				<th>Bruto/Pcs</th>
				<th>Qty</th>
				<th>Bruto</th>
				<th>FC Inc Amount</th>
			</thead>
			<tbody>
				<?php
		            if (isset($content['sodetail'])) {
		                foreach ($sodetail as $row => $list) { 
		                	if ($FCex > 0) {
		                		$list['FreightCharge'] = 0;
		                	}
		                	$qtyTotal += $list['ProductQty'];
		                	$FCin += $list['FreightCharge'];
		                	$weight = $list['ProductQty']*$list['ProductWeight']; 
		                	$weightTotal += $weight;
		        ?>
			                <tr>
			                    <td class="ProductCode"><div class="ProductID">(<?php echo $list['ProductID'];?>)</div> <?php echo $list['ProductName'];?></td>
			                    <td class="qtyreceive"><?php echo $list['ProductWeight'];?></td>
			                    <td class="qtyreceive"><?php echo $list['ProductQty'];?></td>
			                    <td class="qtyreceive"><?php echo $weight;?></td>
			                    <td class="producttotal"><?php echo number_format($list['FreightCharge'],2);?></td>
			                </tr>
			    <?php	
						} 
			    	};
			    	$FCtotal = $FCin + $FCex; 
			    ?>
			    <tr><td colspan="5"><h3>.</h3></td></tr>
			    <tr>
			    	<td rowspan="5"> 
			    		<table border=1><tr><td>
			    			<b>ACCOUNT INFORMATION <br> PT. ANGHAUZ INDONESIA <br> BCA Cabang Margomulyo <br> A/C 463-198-8835 </b>
			    		</td></tr></table>
			    	</td>
			    	<td class="producttotal" colspan="2"><b>Total Qty</b></td>
			    	<td class="producttotal" colspan="2"><?php echo number_format($qtyTotal);?></td>
			    </tr>
			    <tr>
			    	<td class="producttotal" colspan="2"><b>Total Weight</b></td>
			    	<td class="producttotal" colspan="2"><?php echo number_format($weightTotal);?></td>
			    </tr>
			    <tr>
			    	<td class="producttotal" colspan="2"><b>Freight Charge Include</b></td>
			    	<td class="producttotal" colspan="2"><?php echo number_format($FCin,2);?></td>
			    </tr>
			    <tr>
			    	<td class="producttotal" colspan="2"><b>Freight Charge Exclude</b></td>
			    	<td class="producttotal" colspan="2"><?php echo number_format($FCex,2);?></td>
			    </tr>
			    <tr>
			    	<td class="producttotal" colspan="2"><b>Total Freight Charge</b></td>
			    	<td class="producttotal" colspan="2"><?php echo number_format($FCtotal,2);?></td>
			    </tr>
			</tbody>
		</table><br>

		<?php
			foreach ($payment as $key => $row) {
		?>
			<table class="payment">
				<tr>
					<td>
						<?php echo $row['ExpeditionName']; ?> <br>
						Amount : <?php echo number_format($row['PaymentAmount']); ?> <br>
						Date : <?php echo $row['PaymentDate']; ?> <br>
						Reff : <?php echo $row['ExpeditionReff']; ?> <br>
						DO No : <?php echo $row['DOID']; ?> <br>
						DO Qty : <?php echo $row['ProductQty']; ?> <br>
						DO Weight : <?php echo $row['totalweight']; ?> <br>
					</td>
				</tr>
			</table>
		<?php
			}
		?>
	</div>
</body>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script>
$( "#noprint" ).click(function() {
  	window.print();
});	
</script>