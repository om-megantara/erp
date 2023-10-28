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
		table.table-main td:first-child { width: 100px; text-align: center; }
		/*table.table-main td:nth-child(2) { width: 500px !important; }*/
		table.table-main td:nth-child(3),
		table.table-main td:nth-child(4),
		table.table-main td:nth-child(5) {
			width: 120px !important;
		}
		table.table-main thead td { text-align: center; background: #b9b9b9; font-weight: bold; }

		table.table-total td { 
			width: 50px !important; 
		}table.table-total span { 
			float: right; 
		}
		.warning { background-color: yellow; }
		/*table.table-total td:last-child { width: 0px !important; }*/
	</style>
</head>

<body>
	<center><a href="#" id="noprint" class="noprint" autofocus>Print</a></center>
	<div class="content">
		<center><h3><?php echo $main['CompanyName']?></td></tr></h3></center>
		<center><h5>Daily Report Transaction</h5></center>
		<center><h5><?php echo $main['BankName']." ".$main['Date']?></h5></center>
		<br>
		<table width="900px" class="table-main">
			<thead>
				<tr>
					<td>Distribution ID</td>
					<td>Note</td>
					<td>Debit</td>
					<td>Credit</td>
					<td>Saldo</td>
				</tr>
			</thead>
			<tbody>
		        <tr>
		            <td></td>
		            <td>SALDO AWAL</td>
		            <td></td>
		            <td></td>
	            	<td class="alignRight"><?php echo number_format($main['SaldoAwal'],2);?></td>
		        </tr>
		        <tr>
		            <td colspan="5"></td>
		        </tr>
				<?php
					$total = $main['SaldoAwal'];
					$totaldebit = 0;
					$totalcredit = 0;
				    if (isset($content['detail'])) {
						$detail = $content['detail'];
				        foreach ($content['detail'] as $row => $list) { 
							$BankTransactionDate =  date("M-d", strtotime($list['BankTransactionDate']));;
				?>
				        <tr>
				            <?php if ($list['DistributionID']=="") { ?>
				            	<td class="warning">
				            <?php } else { ?>
				            	<td>
				            <?php } ?>
				        		<?php echo $list['DistributionID'].' / '.$BankTransactionDate;?>
			        		</td>

				            <td>
				            	<?php 
				            	if ($list['IsDeposit'] == 1) {
				            		echo "(Customer) - ";
				            	}
				            		echo $list['BankTransactionNote'];
				            	?>
			            	</td>
				            <?php 
				            if ($list['BankTransactionType']=="debit") { 
					        	$totaldebit += $list['BankTransactionAmount']; 
				        		$total += $list['BankTransactionAmount'];
				            ?>
				            	<td class="alignRight"><?php echo number_format($list['BankTransactionAmount'],2);?></td>
				            	<td></td>
				            <?php 
					        } else { 
				            	$totalcredit += $list['BankTransactionAmount']; 
				        		$total -= $list['BankTransactionAmount'];
				        	?>
				            	<td></td>
				            	<td class="alignRight"><?php echo number_format($list['BankTransactionAmount'],2);?></td>
				            <?php } ?>
			            	<td class="alignRight"><?php echo number_format($total,2);?></td>
				        </tr>
			    <?php } } ?>
			</tbody>
			<tfoot>
	    		<tr>
		            <td colspan="2">TOTAL</td>
	            	<td class="alignRight"><?php echo number_format($totaldebit,2);?></td>
	            	<td class="alignRight"><?php echo number_format($totalcredit,2);?></td>
	            	<td class="alignRight"><?php echo number_format($total,2);?></td>
		        </tr>
			</tfoot>
		</table>
		<br>

		<table width="900px" class="table-total">
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td>
					SALDO AWAL : <span>Rp. <?php echo number_format($main['SaldoAwal'],2); ?></span><br>
					TOTAL PENERIMAAN : <span>Rp. <?php echo number_format($totaldebit,2); ?></span><br>
					TOTAL PENGELUARAN : <span>Rp. <?php echo number_format($totalcredit,2); ?></span><br>
					SALDO AKHIR : <span>Rp. <?php echo number_format($total,2); ?></span><br>

					<?php
					for ($i=0; $i < count($main['addMain']); $i++) { 
						if ($main['addMain'][$i] != "") {
					?>
						<?php echo $main['addMain'][$i]; ?> : <span>Rp. <?php echo number_format($main['addDetailAmount'][$i],2); ?></span><br>
				    <?php } } ?>
				</td>
			</tr>
			<tr>
				<td class="alignCenter">Membuat</td>
				<td class="alignCenter">Menyetujui</td>
				<td class="alignCenter">Menyetujui</td>
				<td class="alignCenter">Created By : <?php echo $UserName; ?></td>
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