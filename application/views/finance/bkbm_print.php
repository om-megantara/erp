<?php 
$main = $content['main'];
$detail = $content['detail'];
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
			width: 900px;
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
		table.table-main td:first-child { width: 100px; }
		table.table-main td:nth-child(2) { width: 160px; }
		table.table-main thead td { text-align: center; background: #b9b9b9; font-weight: bold; }
		table.table-main tbody td:first-child { text-align: center; }
		.aliRight { text-align: right; width: 120px !important; }

		table.table-total td { text-align: center; width: 80px !important; }
		table.table-total td:last-child { width: 200px !important; }
	</style>
</head>

<body>
	<center><a href="#" id="noprint" class="noprint" autofocus>Print</a></center>
	<div class="content">
		<center><h3><?php echo $main['CompanyName']?></td></tr></h3></center>
		<center><h5><?php echo $main['CompanyAddress']?></h5></center>
		<br>
		<center><h5> <?php echo $main['BankName']?> - Bukti masuk (<?php echo $main['Date']?>)</h5></center>
		<br>

		<table width="900px" class="table-main">
			<thead>
				<tr>
					<td>Transaction ID</td>
					<td>Customer</td>
					<td>Note</td>
					<td>Payment</td>
					<td>Deposit</td>
				</tr>
			</thead>
			<tbody>
				<?php
					$total = 0;
					$totaldeposit = 0;
					$totalpayment = 0;
				    if (isset($content['detail'])) {
				        foreach ($content['detail'] as $row => $list) { 
				        	$total += $list['total']
				?>
				        <tr>
				            <td><?php echo $list['BankTransactionID'];?></td>
				            <td><?php echo $list['CustomerID']." :<br>".$list['Company2'];?></td>
				            <td><?php echo $list['note'];?></td>
				            <?php if ($list['type']=="Payment") { $totalpayment += $list['total']; ?>
				            	<td class="aliRight">Rp. <?php echo number_format($list['total'],2);?></td>
				            	<td></td>
				            <?php } else { $totaldeposit += $list['total']; ?>
				            	<td></td>
				            	<td class="aliRight">Rp. <?php echo number_format($list['total'],2);?></td>
				            <?php } ?>
				        </tr>
			    <?php } } ?>
			</tbody>
			<tfoot>
	    		<tr>
		            <td colspan="3">TOTAL</td>
	            	<td class="aliRight">Rp. <?php echo number_format($totalpayment,2);?></td>
	            	<td class="aliRight">Rp. <?php echo number_format($totaldeposit,2);?></td>
		        </tr>
			</tfoot>
		</table>
		<br>

		<table width="900px" class="table-total">
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
				<td><h1>Rp. <?php echo number_format($total); ?></h1></td>
			</tr>
			<tr>
				<td>ACC</td>
				<td>Menyetujui</td>
				<td>Mengetahui</td>
				<td>Finance</td>
				<td>Pembuat</td>
				<td>Penerima</td>
				<td>Created By : <?php echo $UserName; ?></td>
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