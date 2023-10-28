<?php
$detail		= $content['detail'];
$month = $content['detail'][0]['Month'];
$sales = $content['detail'][0]['Sales'];
// print_r($detail);

// function percentOf($a, $b)
// {
// 	$final = 100 - ($b/ ($a/100) );
// 	return $final;
// }
// function ReversePerc($Price, $Perc)
// {
// 	if ($Price > 0) {
// 		$value = ( $Price / (100-$Perc) ) *100;
// 	} else {
// 		$value = 0;
// 	}
// 	return $value;
// }
?>
<head>
	<link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>tool/favicon.png"/> 
	<title><?php echo $PageTitle. ' ' .$sales.' '.$month.' - '. $MainTitle; ?></title>
	<style type="text/css">
		@media only print {
		    a.noprint, a.showContent, input#size {
			    display:none !important;
			}
		}
		@page { size: potrait; }
		a.noprint, a.showContent {
			margin: 10px;
			background-color: #f44336;
		    color: white;
		    padding: 5px 20px;
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
		.header-company { text-align: center; }
		.header-company td { border: 0px !important; }
		.header-company h2, .header-company h6 { margin: 0px; }
		.header-po1>td { border: 1px solid #000; }
		.header-po1>td:nth-child(2){ width: 220px; }
		.header-po1>td:nth-child(3), .header-po1>td:nth-child(4) { width: 170px; }
		.header-po1 .dorid td{ font-weight: bolder; font-size: 15px !important; }
		.header-po1, .header-po1 tr { vertical-align: top; line-height: normal;}
		.header-po1 table tr td { border: 0px !important; font-size: 12px; padding: 5px;}
		td.detail {	font-weight: bold; font-size: 12px;}
		td.cust {	font-weight: bold; font-size: 12px; width:400px;}
		.sendfrom h4, .sendfrom h5, .sendfrom h6 { margin: 0px; }

		.marketinglist th, .marketinglist td { padding: 2px 4px; }
		.marketinglist th { border: 1px solid #000; font-size: 14px; }
		.marketinglist tbody { font-size: 12px; }
		.marketinglist tr td { border: 1px solid #000 !important; }
		.No{ width: 20px; }
		.City{ width: 250px; }
		.center { text-align: center; }
		.right { text-align: right; }
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
	<table width="750px">
		<tr class="header-company">
			<th colspan="7">
				<table width="750px" >
					<tr class="header-company">
						<?php if (in_array("print_without_header", $MenuList)) {?>
						<td colspan="2"></td>
						<td colspan="2">
							<h3 style="margin-bottom: 0px; margin-top: 110px;" align="right">Marketing Activity <?php echo $sales; ?></h3>
						</td>
						<?php } else {?>
						<td colspan="2"><img src="<?php echo base_url();?>tool/kop.jpg" width="220px" align="left" style="vertical-align:top" ></td>
						<td colspan="2">
							<h3 style="margin-bottom: 0px; margin-top: 110px;" align="right">Marketing Activity <?php echo $sales; ?></h3>
						</td>
						<?php } ?>
					</tr>
					<tr >
						<td colspan="4">
						<input type="number" name="size" id="size" autocomplete="off" placeholder="Font Size Product List">	
						<a href="#" id="noprint" class="btn-header noprint" autofocus>Print</a>
						</td>
					</tr>
				</table>
			</th>
		</tr>
		<tr class="header-po1" height="70px">
			<td>
				<table>
					<tr class="soid"><td><b>EXPENSE PERMIT FORM</b></td></tr>
					<tr><td >FEE MKT ACTIVITY <?php echo $sales; ?> <?php echo $month; ?> </td></tr>
					
				</table>
			</td>
			<td>
				<table>
					<tr><td><i>FOR OFFICE USE ONLY</i></td></tr>
					<tr><td>Tanggal</td><td><?php echo date('Y-m-d'); ?></td></tr>
				</table>
			</td>
		</tr>
		<tr class="header-po1"><td class="detail left ">TOTAL</td><td class="detail right total"></td></tr>
	</table><br>
	<table width="750px;" class="marketinglist">
		<thead>
			<th>No</th>
			<th>City</th>
			<th>Quantity</th>
			<th>Fee</th>
			<th>Extra %</th>
			<th>Sub Total</th>
		</thead>
		<tbody>
			<?php
			$no=0;
			$TOTAL1=0;
			$TOTAL2=0;
	            if (isset($content['detail'])) {
	                foreach ($detail as $row => $list) { 
	                	$no++;
	        ?>
		                <tr class="">
		                    <td class="No" ><?php echo $no;?></td>
		                    <td class="City" colspan=5><?php echo $list['CityName']; ?></td>
		                </tr>
		                <tr class="">
		                    <td class="No"></td>
		                    <td class="City right">CFU</td>
		                    <td class="right"><?php echo $list['TotalCFU']; ?></td>
		                    <td class="detail right"><?php echo "Rp ".number_format($list['CFU'],2); ?></td>
		                    <td class="detail right">50%</td>
		                    <td class="detail right"><?php $SUBTOTAL1=$list['TotalCFU']*($list['CFU']+$list['CFUUp']);  echo "Rp ".number_format($SUBTOTAL1,2); ?></td>
		                </tr>
		                <tr class="">
		                    <td class="No"></td>
		                    <td class="City right">CV</td>
		                    <td class="right"><?php echo $list['TotalCV']; ?></td>
		                    <td class="detail right"><?php echo "Rp ".number_format($list['CV'],2); ?></td>
		                    <td class="detail right">50%</td>
		                    <td class="detail right"><?php $SUBTOTAL2=$list['TotalCV']*($list['CV']+$list['CFUUp']);  echo "Rp ".number_format($SUBTOTAL2,2); ?></td>
		                </tr>
		                <!-- <tr class="">
		                    <td class="No"></td>
		                    <td class="City right">PRIMARY</td>
		                    <td class="right">1</td>
		                    <td class="detail right">Rp xxxxx</td>
		                    <td class="detail right">Rp xxxxx</td>
		                </tr>
		                <tr class="">
		                    <td class="No"></td>
		                    <td class="City right">SECOND</td>
		                    <td class="right">1</td>
		                    <td class="detail right">Rp xxxxx</td>
		                    <td class="detail right">Rp xxxxx</td>
		                </tr> -->
		    <?php		$TOTAL1=$TOTAL1+$SUBTOTAL1;
		    			$TOTAL2=$TOTAL2+$SUBTOTAL2;
					} $TOTAL=$TOTAL1+$TOTAL2;
		    	} 
		    ?>
		</tbody>
		<tr>
			<input type="hidden" id="total" value="<?php echo "Rp ".number_format($TOTAL,2);?>">
			<td class="right" colspan=5><b>Total FEE</b></td><td class="right"  id="total"><b><?php echo "Rp ".number_format($TOTAL,2);?></b></td>
		</tr>	
	</table><br>
	<!-- <table width="750px;" class="total">
		<tr>
			<table width="100%" border=1>
				<tr><td colspan="5" class="center" bgcolor="#aaaaaa"><b>POINT</b></td></tr>
				<tr><td class="detail left">1</td><td class="detail left" colspan=4>LATE INVOICE</td></tr>
				<tr><td></td><td class="cust right" >CUST 1</td><td class="detail center">0</td><td class="detail right">Rp xxxxx</td><td class="detail right">Rp xxxxx</td></tr>
				<tr><td></td><td class="cust right">CUST 2</td><td class="detail center">0</td><td class="detail right">Rp xxxxx</td><td class="detail right">Rp xxxxx</td></tr>
				<tr><td></td><td class="cust right">CUST 3</td><td class="detail center">0</td><td class="detail right">Rp xxxxx</td><td class="detail right">Rp xxxxx</td></tr>
				<tr><td></td><td class="cust right">CUST 4</td><td class="detail center">0</td><td class="detail right">Rp xxxxx</td><td class="detail right">Rp xxxxx</td></tr>
				<tr><td></td><td>:</td><td></td><td class="detail right">Sub Total Point</td><td class="detail right">Rp xxxxx</td></tr>
				<tr><td></td><td>:</td><td></td><td class="detail right">Grand Total</td><td class="detail right">Rp xxxxx</td></tr>
			</table>
		</tr>
	</table><br> -->
	<table width="750px;" height="150px" alignment="left" class="sign">
		<tr><td style="text-align: left;vertical-align: top;">Note :</td></tr>
	</table>

	<h5 class="footer">Printed By : <?php echo $UserName;?>, On : <?php echo date('d-m-Y H:i:s');?></h5>
</div>
</body>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script>
$( "#noprint" ).click(function() {
	total  = $("#total").val();
	// alert(total)
	$(".total").text(total);
  	window.print();
});	
$( "#showContent" ).click(function() {
  $( ".content1" ).toggle();
  $( ".content2" ).toggle();
});
$('#size').live( "keyup", function() {
    size  = $(this).val();
    $(".productlist tbody tr td").css('font-size',size);
});
</script>