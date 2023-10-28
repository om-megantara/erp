<?php
$main 		= (array) $content['main'];
$detail		= (array) $content['detail'];
$FakturParent	= $content['FakturParent'];
 
$opts=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);  
$Faktur2 = fopen(('./tool/HeaderFaktur2.txt'), "r", false, stream_context_create($opts)) or die("Unable to open file!");
$HeaderFaktur2 = '';
while(! feof($Faktur2))  {
	$HeaderFaktur2 .= fgets($Faktur2)."<br>";
}
fclose($Faktur2);

$TaxAddress	= explode(";",$main['TaxAddress']);
$main['INVDate'] = isset($main['INVDate']) ? $main['INVDate'] : $main['INVRDate'];
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
		    margin-bottom: -20px;
		}

		.content {
			font-family: Arial, Helvetica, sans-serif;
			width: 750px;
		}
		.content table tr td { padding: 5px; }
		table { border-collapse: collapse; }
		table tr td {
			border: 1px solid #000;
			padding: 5px;
			font-weight: bold;
			font-size: 12px;
			font-family: monospace;
		}
	</style>
</head>

<body>
<div class="content">
	<div>
		<input type="number" name="size" id="size" autocomplete="off" placeholder="Font Size Product List">
		<a href="#" id="noprint" class="noprint" autofocus>Print</a>
	</div><br>

	<table width="750px">
		<tr style="text-align: center;">
			<td colspan="3">
				Data Faktur
			</td>
		</tr>
		<tr><td colspan="3">Kode dan Nomer Seri Faktur Pajak : <?php echo $FakturParent.$main['FakturNumber']; ?></td></tr>
		<tr><td colspan="3">Penjual Barang Kena Pajak </td></tr>
		<tr>
			<td colspan="3">
				<?php echo $HeaderFaktur2; ?>
			</td>
		</tr>
		<tr><td colspan="3">Pembeli Barang Kena Pajak </td></tr>
		<tr>
			<td colspan="3">
			Nama : <?php echo $TaxAddress[0]; ?><br>
			Alamat : <?php echo $TaxAddress[2]; ?><br>
			NPWP : <?php echo $main['NPWP']; ?>
			</td>
		</tr>
		<tr style="text-align: center;">
			<td width="50px">No</td>
			<td width="450px">Nama Barang</td>
			<td >Harga</td>
		</tr>

		<?php
			$no = 0;
			$TotalProduct = 0;
            if (isset($content['detail'])) {
                foreach ($content['detail'] as $row => $list) { 
                	$no++;
                	$PriceFinal = ($list['PriceAmount']*$list['ProductQty']) + $list['FreightCharge'];
					$TotalProduct += $PriceFinal;
					$ProductFC = $list['FreightCharge']/max($list['ProductQty'],1);
        ?>
	                <tr>
	                    <td style="text-align: center;"><?php echo $no;?></td>
	                    <td>
	                    	<?php echo $list['ProductName'];?><br>
	                    	<?php echo number_format($list['PriceAmount']+$ProductFC,2);?> X <?php echo $list['ProductQty'];?>
	                    </td>
	                    <td style="text-align: right;"><?php echo number_format($PriceFinal,2);?></td>
	                </tr>
	    <?php	
				} 
	    	} 
    		$TaxFinalSales = $TotalProduct;
	    	$TaxFinalAmount = $main['PriceTax']+$main['FCTax'];
	    	if ($main['INVCategory'] == 2) {
	    		// $TaxFinalSales = $main['PriceTotal'];
	    		$TaxFinalAmount = ( $main['INVTotal']/1.1 )*0.1;
	    	}
	    ?>

		<tr>
			<td colspan="2">Harga Jual</td>
			<td style="text-align: right;"><?php echo number_format($TotalProduct,2);?></td>
		</tr>
		<tr>
			<td colspan="2">Dasar Kena Pajak</td>
			<td style="text-align: right;"><?php echo number_format($TaxFinalSales,2);?></td>
		</tr>
		<tr>
			<td colspan="2">PPN 10%</td>
			<td style="text-align: right;"><?php echo number_format($TaxFinalAmount,2);?></td>
		</tr>
		<tr>
			<td colspan="3" style="padding-left: 500px;">
				<br><br>
				Surabaya, <?php echo date("d M Y", strtotime($main['INVDate'])) ; ?>
				<br><br><br>
				Finance
				<br><br>
			</td>
		</tr>

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
    $("table tr td").css('font-size',size);
});
</script>