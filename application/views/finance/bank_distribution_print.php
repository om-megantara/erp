<?php 
$main = $content['main'];
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
		table {
		  border-collapse: collapse;
		}
		h1, h3, h5 { margin: 0px !important; }
		table.table-main tr td, 
		table.table-detail tr td, 
		table.table-total tr td { 
			padding: 2px 4px;
			border: 1px solid #000;
			font-size: 12px; 
		}
		table.table-detail tr td { border: 0px solid #000 !important; vertical-align: top; } 
		table.table-detail table { max-width: 350px; } 
		table.table-main td:first-child { width: 25px; }
		table.table-main td:nth-child(2) { width: 160px; }
		table.table-main td:nth-child(3) { width: 450px; }
		table.table-main thead td { text-align: center; background: #b9b9b9; font-weight: bold; }
		table.table-main tbody td:first-child { text-align: center; }
		table.table-main tbody td:last-child { text-align: right; }

		table.table-total td { text-align: center; width: 80px !important; }
		table.table-total td:last-child { width: 200px !important; }
	</style>
</head>

<body>
	<center><a href="#" id="noprint" class="noprint" autofocus>Print</a></center>
	<div class="content">
		<center><h3><?php echo $main['CompanyName'];?></td></tr></h3></center>
		<center><h5><?php echo $main['CompanyAddress'];?></h5></center>
		<br>

		<table class="table-detail" width="750px">
			<tr>
				<td>
					<table>
						<tr><td>Type</td><td>: <?php echo $main['DistributionTypeName'];?></td></tr>
						<tr><td>Distribution ID</td><td>: <?php echo $main['DistributionID'];?></td></tr>
						<tr><td>Distribution No</td><td>: <?php echo $main['DistributionNumber'];?></td></tr>
					</table>
				</td>
				<td>
					<table>
						<tr><td>Company</td><td>: <?php echo $main['CompanyName'];?></td></tr>
						<tr><td>Date</td><td>: <?php echo $main['DistributionDate'];?></td></tr>
						<tr><td>Note</td><td>: <?php echo $main['DistributionNote'];?></td></tr>

						<?php if (isset($main['info'])) { ?>
						<tr><td></td><td>: <?php echo $main['info'];?></td></tr>
			    		<?php }  ?>
					</table>
				</td>
			</tr>
		</table>
		<br>

		<table width="750px" class="table-main">
			<thead>
				<tr>
					<td>No</td>
					<td>Name</td>
					<td>Note</td>
					<td>Amount</td>
				</tr>
			</thead>
			<tbody>
				<?php
				    if (isset($content['detail'])) {
				    	$no = 0;
				        foreach ($content['detail'] as $row => $list) { 
				        	$no++;
				?>
				        <tr>
				            <td><?php echo $no;?></td>
				            <td><?php echo $list['ContactName'];?></td>
				            <td><?php echo $list['ReffType'].' '.$list['ReffNo'].' - '.$list['Note'];?></td>
				            <td><?php echo number_format($list['Amount'],2);?></td>
				        </tr>
			    <?php } } ?>
			</tbody>
		</table>
		<br>

		<table width="750px" class="table-total">
			<tr>
				<td rowspan="2"></td>
				<td rowspan="2"></td>
				<td rowspan="2"></td>
				<td rowspan="2"></td>
				<td rowspan="2"></td>
				<td rowspan="2"></td>
				<td >TOTAL</td>
			</tr>
			<tr>
				<td><h1>Rp. <?php echo number_format($main['DistributionTotal']); ?></h1></td>
			</tr>
			<tr>
				<td>ACC</td>
				<td>Menyetujui</td>
				<td>Mengetahui</td>
				<td>Finance</td>
				<td>Pembuat</td>
				<td>Penerima</td>
				<td>Created By : <?php echo $main['fullname']; ?></td>
			</tr>
		</table>
	</div>
</body>


<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script>
$( "#noprint" ).click(function() {
  	window.print();
});	
</script>