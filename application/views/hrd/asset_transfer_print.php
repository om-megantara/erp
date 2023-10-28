<?php 
$main = (array) $content['main'];
$detail1 = (array) $content['detail1'];
$detail2 = (array) $content['detail2'];


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
?>

<style type="text/css">
	@media only print {
	    a.noprint {
		    display:none !important;
		}
	}
	a.noprint {
		margin: 10px;
		background-color: #f44336;
	    color: white;
	    padding: 5px 20px;
	    text-align: center;
	    text-decoration: none;
	    display: inline-block;
	    font-size: 12px;
	    margin-bottom: 20px;
	}
	.content {
		font-family: Arial, Helvetica, sans-serif;
		width: 750px;
	}
	.table-main table { 
		vertical-align: top; 
		border-collapse: collapse;
	} 
	.table-main > tr > td {
		vertical-align: top;
	}
	.table-main table tr td { 
		padding: 2px 5px; 
		font-size: 12px !important;
	}
	.table-detail { 
		width: 100%; 
		border: 1px solid #000 !important;
	}
	.table-detail tr td {
		vertical-align: top;
	}
	.table-detail tr td:first-child { min-width: 80px; }
	.table-detail2 tr td {
		border: 0px solid #000 !important;
		vertical-align: top;
	}
	.table-detail2 tr td:first-child { min-width: 120px; }
	.detail-header {
		text-align: center; 
		background: #888;
		font-weight: bold;
	}
	.sign { width: 100%; }
	.sign tr:first-child { height: 80px; }
	.sign tr td{
		width: 20%;
		vertical-align: bottom;
		text-align: center;
		font-size: 12px;
		font-weight: bold;
	}
	.footer { 
		font-size: 10px;
		border-top: 1px solid #000;
	}
</style>

<body>
	<div class="content">
		<table class="table-main">
			<tr>
				<td colspan="2" style="text-align: center;">
					<h2 style="margin-bottom: -20px;"><?php echo $alamat[0]; ?></h2>
					<h6 style="margin-bottom: 0px;">
						<?php echo $alamat[1]; ?><br>
						<?php echo "Phone : ".$alamat[2]." || Fax : ".$alamat[3]." || NPWP : ".$alamat[4]; ?>
					</h6>
					<h6 style="margin-bottom: 0px;">FORM TRANSFER ASSET</h6>
					<a href="#" id="noprint" class="noprint" autofocus>Print</a>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table class="table-detail">
						<tr><td colspan="2" class="detail-header">Asset Detail</td></tr>
						<tr>
							<td>
								<table class="table-detail2">
									<tr><td>Asset ID</td><td>:</td><td><?php echo $main['AssetID'] ?></td></tr>
									<tr><td>Asset Name</td><td>:</td><td><?php echo $main['AssetName'] ?></td></tr>
									<tr><td>Model Number</td><td>:</td><td><?php echo $main['ModelNumber'] ?></td></tr>
									<tr><td>Serial Number</td><td>:</td><td><?php echo $main['SerialNumber'] ?></td></tr>
									<tr><td>Asset Color</td><td>:</td><td><?php echo $main['AssetColor'] ?></td></tr>
									<tr><td>Asset Type</td><td>:</td><td><?php echo $main['AssetType'] ?></td></tr>
								</table>
							</td>
							<td>
								<table class="table-detail2">
									<tr><td>Asset Category</td><td>:</td><td><?php echo $main['AssetCategory'] ?></td></tr>
									<tr><td>Asset Condition</td><td>:</td><td><?php echo $main['AssetCondition'] ?></td></tr>
									<tr><td>Asset Spesification</td><td>:</td><td><?php echo $main['AssetSpesification'] ?></td></tr>
									<tr><td>Asset Note</td><td>:</td><td><?php echo $main['AssetNote'] ?></td></tr>
									<tr><td>Asset Price</td><td>:</td><td><?php echo number_format($main['Price']) ?></td></tr>
									<tr><td>Date In</td><td>:</td><td><?php echo $main['DateIn'] ?></td></tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td style="width: 50%;">
					<?php if (!empty($detail1)) { ?>
					<table class="table-detail">
						<tr><td colspan="3" class="detail-header">Asset From</td></tr>
						<tr><td>Date In</td><td>:</td><td><?php echo $detail1['DateIn'] ?></td></tr>
						<tr><td>Date Out</td><td>:</td><td><?php echo $detail1['DateOut'] ?></td></tr>
						<tr><td>Status In</td><td>:</td><td><?php echo $detail1['StatusIn'] ?></td></tr>
						<tr><td>Status Out</td><td>:</td><td><?php echo $detail1['StatusOut'] ?></td></tr>
						<tr><td>Asset Note</td><td>:</td><td><?php echo $detail1['Note'] ?></td></tr>
					</table>
					<?php } ?>
				</td>
				<td style="width: 50%;">
					<table class="table-detail">
						<tr><td colspan="3" class="detail-header">Asset To</td></tr>
						<tr><td>Date In</td><td>:</td><td><?php echo $detail2['DateIn'] ?></td></tr>
						<tr><td>Date Out</td><td>:</td><td><?php echo $detail2['DateOut'] ?></td></tr>
						<tr><td>Status In</td><td>:</td><td><?php echo $detail2['StatusIn'] ?></td></tr>
						<tr><td>Status Out</td><td>:</td><td><?php echo $detail2['StatusOut'] ?></td></tr>
						<tr><td>Asset Note</td><td>:</td><td><?php echo $detail2['Note'] ?></td></tr>
					</table>
				</td>
			</tr>
		</table>

		<table class="sign">
			<tr><td></td><td></td><td></td></tr>
			<tr>
				<td>(HRD)</td>
				<td>
					<?php if (!empty($detail1)) { ?>
					<?php echo $detail1['fullname'];?><br>(<?php echo $detail1['LevelName'];?>)
					<?php } ?>
				</td>
				<td><?php echo $detail2['fullname'];?><br>(<?php echo $detail2['LevelName'];?>)</td>
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
</script>