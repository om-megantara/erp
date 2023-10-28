<?php 
$main = $content['main'];
$detail = $content['detail'];
$subSaldo = 0;
$TotalSaldo = 0;
$subSaldoArr = array();
$subNoteArr = array();
$subTypeArr = array();
?>

<style type="text/css">
	.subHeader {
		color: white;
	    font-weight: bold;
	    background-color: cadetblue;
	    text-align: center;
	}
	.subTotal { font-weight: bold; }
	.subTotal td {
		border-top: 1px solid black; 
		text-align: center;
	}
	.subSpace { height: 20px; }
	.alignRight { text-align: right; }
	.alignCenter { text-align: center; }

	tr.bold td { font-weight: bold; }
	.px-1 { padding-left: calc(1*20px) !important; }
	.px-2 { padding-left: calc(2*20px) !important; }
	.px-3 { padding-left: calc(3*20px) !important; }
	.px-4 { padding-left: calc(4*20px) !important; }
	.px-5 { padding-left: calc(5*20px) !important; }
	.px-6 { padding-left: calc(6*20px) !important; }
	.px-7 { padding-left: calc(7*20px) !important; }
	.px-8 { padding-left: calc(8*20px) !important; }
	.px-9 { padding-left: calc(9*20px) !important; }

	.table-detail td{
		font-size: 12px !important;
		padding: 3px 8px 3px 8px;
	}
</style>

<link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>tool/favicon.png"/> 
<title><?php echo $PageTitle.' - '.$MainTitle; ?></title>

<h4><?php echo $main['ReportName']; ?></h4>
<table class="table table-bordered table-detail table-responsive">
    <?php
      if (isset($detail)) {
          foreach ($detail as $row => $list) { 
          	if ($list['AccountID'] == 0) {
          		if ($list['Note'] == 'SUB TOTAL') {
          			$subSaldoArr[] = $subSaldo;
    ?>
		          <tr class="subTotal">
		            <td colspan="2"><?php echo $list['Note'];?></td>
		            <td class="alignRight"><?php echo number_format($subSaldo,2);?></td>
		          </tr>
    <?php 
    			} elseif ($list['Note'] == 'TOTAL') {
    ?>
		    <?php
		    	for ($i=0; $i < count($subSaldoArr) ; $i++) { 
					$TotalSaldo += ($subTypeArr[$i] == 'credit') ? $subSaldoArr[$i]*(-1) : $subSaldoArr[$i];
		    ?>
				  <tr class="bold">
		            <td class="alignCenter"><?php echo $subTypeArr[$i];?></td>
		            <td><?php echo $subNoteArr[$i];?></td>
		            <td class="alignRight"><?php echo number_format($subSaldoArr[$i],2);?></td>
		          </tr>
		    <?php } ?>

		          <tr class="subTotal">
		            <td colspan="2"><?php echo $list['Note'];?></td>
		            <td class="alignRight"><?php echo number_format($TotalSaldo,2);?></td>
		          </tr>
    <?php
    			}  elseif ($list['Note'] == '') {
    ?>
		          <tr class="subSpace">
		            <td colspan="3"></td>
		          </tr>
    <?php
    			} else {
					$subSaldo = 0;
					$subNoteArr[] = $list['Note'];
					$subTypeArr[] = $list['AccountType'];
    ?>
		          <tr class="subHeader">
		            <td>TYPE</td>
		            <td><?php echo $list['Note'];?></td>
		            <td>SALDO</td>
		          </tr>
    <?php
    			}
          	} else {
          		if ($list['AccountID'] != 0) {
					$AccountID = $list['AccountID'].' - ';
          		} else {
					$AccountID = '';
          		}

          		if ($list['Level'] == 'parent') {
					$AccountType = $list['AccountType'];
					$subSaldo += ($AccountType == 'credit') ? $list['AccountAmount']*(-1) : $list['AccountAmount'];
          		} else {
					$AccountType = '';
          		}
    ?>
        <?php if ($list['ChildCount']>1) { ?>
              <tr class="bold">
        <?php } else { ?>
              <tr>
        <?php } ?>
            <td class="alignCenter"><?php echo $AccountType;?></td>
            <td class="px-<?php echo $list['Spacing']; ?>"><?php echo $AccountID.$list['Note'];?></td>
            <td class="alignRight"><?php echo number_format($list['AccountAmount'],2);?></td>
          </tr>
    <?php } } } ?> 
</table>