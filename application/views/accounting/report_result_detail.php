<?php 
$main = $content['main'];
$detail = $content['detail'];
$subTotalCredit = 0;
$subTotalDebit = 0;
$Saldo = 0;
$TotalCredit = 0;
$TotalDebit = 0;
$TotalSaldo = array();
?>

<style type="text/css">
	.subHeader {
		color: white;
	    font-weight: bold;
	    background-color: cadetblue;
	    text-align: center;
	}
	.subTotal {
		font-weight: bold;
	}
	.subSpace {
		height: 20px;
	}
	.table-detail td{
		font-size: 12px !important;
		padding: 3px 8px !important;
	}
</style>
<center><h4><?php echo $main['ReportName']; ?></h4></center>
<table class="table table-bordered table-detail table-responsive">
    <?php
      if (isset($detail)) {
          foreach ($detail as $row => $list) { 
  			$credit = 0;
  			$debit = 0;
          	if ($list['AccountID'] == 0) {
          		if ($list['Note'] == 'SUB TOTAL') {
    ?>
		          <tr class="subTotal">
		            <td><?php echo $list['Note'];?></td>
		            <td class="alignRight"><?php echo number_format($subTotalDebit,2);?></td>
		            <td class="alignRight"><?php echo number_format($subTotalCredit,2);?></td>
		            <td class="alignRight"><?php echo number_format($Saldo,2);?></td>
		          </tr>
    <?php 
					$TotalCredit += $subTotalCredit;
					$TotalDebit += $subTotalDebit;
					$subTotalCredit = 0;
					$subTotalDebit = 0;
					$Saldo = 0;
    			} elseif ($list['Note'] == 'TOTAL') {
    ?>
		          <tr class="subTotal">
		            <td><?php echo $list['Note'];?></td>
		            <td class="alignRight"><?php echo number_format($TotalDebit,2);?></td>
		            <td class="alignRight"><?php echo number_format($TotalCredit,2);?></td>
		            <td class="alignRight"><?php echo number_format($TotalDebit + $TotalCredit,2);?></td>
		          </tr>
    <?php
    			}  elseif ($list['Note'] == '') {
    ?>
		          <tr class="subSpace">
		            <td colspan="4"></td>
		          </tr>
    <?php
    			} else {
    ?>
		          <tr class="subHeader">
		            <td><?php echo $list['Note'];?></td>
		            <td>DEBIT</td>
		            <td>CREDIT</td>
		            <td>SALDO</td>
		          </tr>
    <?php

    			}
          	} else {
          		if ($list['AccountType'] == 'credit') {
          			$credit = $list['AccountAmount2'];
					$subTotalCredit += $credit;
          			$Saldo += $credit;
          		} else {
          			$debit = $list['AccountAmount2'];
					$subTotalDebit += $debit;
          			$Saldo += $debit;
          		}
    ?>
          <tr>
            <td><?php echo $list['Note'];?></td>
            <td class="alignRight"><?php echo number_format($debit,2);?></td>
            <td class="alignRight"><?php echo number_format($credit,2);?></td>
            <td class="alignRight"><?php echo number_format($Saldo,2);?></td>
          </tr>
    <?php } } } ?> 
</table>