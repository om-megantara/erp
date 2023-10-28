<?php
$main 		= (array) $content['main'];
$detail		= (array) $content['detail'];
$billing	= explode(";",$main['BillingAddress']);
$shipping	= explode(";",$main['ShipAddress']);
  
$TotalQty = 0;
$TotalQtyRetur = 0;

function ReversePerc($Price, $Perc)
{
	if ($Perc > 0) {
		if ($Price > 0) {
			$value = ( $Price / (100-$Perc) ) *100;
		} else {
			$value = 0;
		}
	} else {
		if ($Price > 0) {
			$value = $Price;
		} else {
			$value = 0;
		}
	}
	return $value;
}
function PercentValue($Price, $Perc)
{
	if ($Perc > 0) {
		$value = $Price * ($Perc/100);
	} else {
		$value = 0;
	}
	return $value;
}
?>
<head>
	<link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>tool/favicon.png"/> 
	<title><?php echo $PageTitle.' - ' .$MainTitle." - NO ".$main['INVID']; ?></title>
	<style type="text/css">
		@media only print {
		    .btn-header, input#size {
			    display:none !important;
			}
			thead.main { display: table-header-group; }
			tfoot.main { display: table-footer-group; }
		}
		@page { size: potrait; }
		.btn-header {
			/*margin: 10px 5px;*/
			background-color: #f44336;
		    color: white;
		    padding: 5px 10px;
		    text-align: center;
		    text-decoration: none;
		    display: inline-block;
		    font-size: 12px;
		    margin-bottom: 20px;
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
		.header-po1>td:nth-child(1), .header-po1>td:nth-child(2){ width: 200px; }
		.header-po1>td:nth-child(3), .header-po1>td:nth-child(4) { width: 170px; }
		.header-po1 .dorid td{ font-weight: bolder; font-size: 15px !important; }
		.header-po1, .header-po1 tr { vertical-align: top;}
		.header-po1 table tr td { border: 0px !important; font-size: 12px; padding: 0px;}
		td.detail {	font-weight: bold;}
		.sendfrom h4, .sendfrom h5, .sendfrom h6 { margin: 0px; }

		.productlist {
		  /*table-layout:fixed;*/
		  /*height:630px;*/
		}
		.productlist thead { font-size: 12px;}
		.productlist tbody { font-size: 12px;}
		.productlist th, .productlist td { padding: 2px 4px; }
		.productlist th { border-bottom: 2px solid #000; font-size: 14px; }
		/*.productlist tr td { border-bottom: 1px solid #000 !important; }*/*/
		.productlist tr { height:1px; }
		.productlist tr:last-child { height:auto; }
		.ProductID{ width: 350px; }
		.center { text-align: center; }
		.right { text-align: right; }
		.productprice, .producttotal { text-align: right; }
		
		.total .cell1{ 
			width: 350px; 
			font-size: 12px;
			font-weight: bold;
			border: 1px solid #000;
			vertical-align: top;
			word-break: break-all;
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
		table {
			border-collapse: collapse;
			font-family: Calibri;
		}
		.footer { 
			font-size: 10px;
			border-top: 1px solid #000;
		}
		.ContentThirdParty { display: none; }
	</style>
</head>

<body>
<div class="content">
	<table>
		<thead class="main">
			<tr>
				<td>
					<table width="750px">
						<tr class="header-company">
							<td colspan="2"><img src="<?php echo base_url();?>tool/kopsg.png" width="300px" align="left" style="vertical-align:top; margin-bottom: 0px;" >
							</td>
							<td colspan="2">							
								<h3 style="margin-bottom: 0px; margin-top: 10px;" align="right">COMMERCIAL INVOICE. <?php echo $main['INVID']; ?></h3>
							</td>
						</tr>
						<tr class="header-company">
							<td colspan="4">
								<input type="number" name="size" id="size" autocomplete="off" placeholder="Font Size Product List">
								<a href="#" id="noprint" class="btn-header noprint" autofocus>Print</a>
								<a href="#" class="btn-header ShowContentFull" autofocus>Show Full</a>
								<a href="#" class="btn-header ShowContentNonPromo" autofocus>Non Promo</a>
								<a href="#" class="btn-header ShowContentThirdParty" autofocus>Third Party</a>
							</td>
						</tr>
						<tr class="header-po1">
							<td>
								<table>
									<tr class="soid"><td width="100px">Invoice No</td><td>:</td><td class="detail"><?php echo $main['INVID']; ?></td></tr>
									<tr class="soid"><td width="100px">Invoice Date</td><td>:</td><td class="detail"><?php echo $main['INVDate']; ?></td></tr>
									<tr class="soid"><td width="100px">Delivery Order</td><td>:</td><td class="detail"><?php echo $main['DOID']; ?></td></tr>
									<tr><td width="100px">SO ID </td><td>:</td><td class="detail"><?php echo $main['SOID']; ?></td></tr>
									<tr><td width="100px">SO Category </td><td>:</td><td class="detail"><?php echo $main['CategoryName']; ?></td></tr>
								</table>
							</td>
							<td>
								<table>
									<tr class="soid"><td width="80px">Customer NO</td><td>:</td><td class="detail"><?php echo $main['CustomerID']; ?></td></tr>
									<tr class="soid"><td width="80px">Payment Term</td><td>:</td><td class="detail"><?php echo $main['PaymentTerm']; ?></td></tr>
									<tr class="soid"><td width="80px">Due Date</td><td>:</td><td class="detail"><?php echo $main['due_date']; ?></td></tr>
									<tr class="soid"><td width="80px">Sales Person</td><td>:</td><td class="detail"><?php echo $main['sales']; ?></td></tr>
								</table>
							</td>
							<td class="sendfrom">
								<h6>BILL TO :</h6>
								<h4><?php echo $billing[0]; ?></h4>
								<h6>
									<?php echo $billing[2]; ?>
								</h6>
								<h6>
									<?php  echo $main['phone']; ?>
								</h6>
							</td>
							<td class="sendfrom">
								<h6>SHIP TO :</h6>
								<h6><?php echo $shipping[2]; ?></h6>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</thead>
		
		<tbody>
			<tr>
				<td>
					<table width="750px;" class="productlist">
						<thead>
							<th align="left">Product</th>
							<th>Qty</th>
							<th>Price</th>
							<th>Promo Disc</th>
							<th>PT Disc</th>
							<th align="right">Total</th>
						</thead>
						<tbody>
							<?php
				            if (isset($content['detail'])) {
								$TotalPriceAmount = 0;
								$dorProductQty = 0;
				            	if ($main['INVCategory'] == 1) {
					            	// from do=============================================================
					                foreach ($detail as $row => $list) { 
	                					$ProductPriceDefaultAsal = $list['ProductPriceDefault'];
										$dorProductQty += $list['dorProductQty'];
				                		$PTPercent = $list['PTPercent'];

					                	if ($list['ProductQty'] > 0) {
						                	if ($main['FCRetur']==1) {
						                		$FCper = $list['FreightCharge']/$list['ProductQty'];
						                	} else {
						                		$FCper = $list['FreightCharge']/$list['doProductQty'];
						                	}
					                	} else {
					                		$FCper = 0;
					                	}

					                	$FC = ReversePerc($FCper, $PTPercent);
					                	$FC = ReversePerc($FC, $list['PromoPercent']);

					                	// if PT < 0
					                	$list['PromoPercent'] = ($list['PromoPercent'] < 0) ? 0 : $list['PromoPercent'] ;
					                	$PTPercent = ($PTPercent < 0) ? 0 : $PTPercent ; 
					                	$list['ProductPriceDefault'] = ReversePerc($list['PriceAmount'], $PTPercent);
					                	$list['ProductPriceDefault'] = ReversePerc($list['ProductPriceDefault'], $list['PromoPercent']);

					                	// roundUp
					                	$PriceTotal1 = ($list['PriceAmount']+$FCper) * $list['doProductQty'];

					                	$PriceDefault1 = ($list['ProductPriceDefault']-PercentValue($list['ProductPriceDefault'],$list['PromoPercent']) );
					                	$PriceDefault2 = ( $PriceDefault1-PercentValue($PriceDefault1,$PTPercent) );
					                	$PriceTotal2 = ( $PriceDefault2 + round($FCper) ) * $list['doProductQty'];

					                	$PriceTotal3 = ($PriceTotal1-$PriceTotal2);
					                	if ( $PriceTotal3 < 10 && $PriceTotal3 > -10) {
					                		$PriceTotal = $PriceTotal2 ;
					                	} else {
					                		$PriceTotal = ($PriceTotal2 > $PriceTotal1)? $PriceTotal2 : $PriceTotal1 ;
					                	}
										$TotalPriceAmount += $PriceTotal;
										// ------------------------------------------------------------

										// promo include price------------------------------------------
										if ($list['PromoPercent'] > 0) {
											$ProductPriceDefault2 = round($list['ProductPriceDefault']+$FC) * (1-($list['PromoPercent']/100));
										} else {
											$ProductPriceDefault2 = round($list['ProductPriceDefault']+$FC);
										}

					                	if ($list['FreightCharge'] <= 0) {
					                		if ($list['PriceAmount'] < $ProductPriceDefaultAsal) {
					                			$list['ProductPriceDefault'] = $ProductPriceDefaultAsal;
					                		}
					                	}
					        ?>
						                <tr class="content1">
						                    <td class="ProductID"><?php echo $list['ProductName'];?></td>
						                    <td class="center"><?php echo $list['doProductQty'];?></td>
						                    <td class="right">
						                    	<?php echo number_format( round($list['ProductPriceDefault']+$FC) );?>
						                    </td>
						                    <td class="center"><?php echo $list['PromoPercent']."%";?></td>
						                    <td class="center"><?php echo $PTPercent."%";?></td>
						                    <td class="right">
						                    	<?php echo number_format( round($PriceTotal) );?>
						                    </td>
						                </tr> 
						                <tr class="Content2" style="display: none;">
						                    <td class="ProductID"><?php echo $list['ProductName'];?></td>
						                    <td class="center"><?php echo $list['doProductQty'];?></td>
						                    <td class="right">
						                    	<?php echo number_format(round($ProductPriceDefault2));?>
						                    </td>
						                    <td class="center">0%</td>
						                    <td class="center"><?php echo $PTPercent."%";?></td>
						                    <td class="right">
						                    	<?php echo number_format( round($PriceTotal) );?>
						                    </td>
						                </tr>

						    <?php	
									}
								} elseif ($main['INVCategory'] == 2) {
					            	// from so=============================================================
					            	foreach ($detail as $row => $list) { 
	                					$ProductPriceDefaultAsal = $list['ProductPriceDefault'];
					                	$TotalQty += $list['ProductQty'];
		                				$PTPercent = $list['PTPercent'];
				                		$FCper = $list['FreightCharge']/$list['ProductQty'];
					                	$FC = ReversePerc($FCper, $list['PTPercent']);
					                	$FC = ReversePerc($FC, $list['PromoPercent']);

					                	// if PT < 0
					                	$PromoPercent = ($list['PromoPercent'] < 0) ? 0 : $list['PromoPercent'] ;
					                	$PTPercent = ($PTPercent < 0) ? 0 : $PTPercent ; 
					                	$list['ProductPriceDefault'] = ReversePerc($list['PriceAmount'], $PTPercent);
					                	$list['ProductPriceDefault'] = ReversePerc($list['ProductPriceDefault'], $list['PromoPercent']);
					                	
					                	$PriceTotal = ($list['PriceAmount']+$FCper) * $list['ProductQty'];
										$TotalPriceAmount += $PriceTotal;

										// promo include price--------------------------
										if ($list['PromoPercent'] > 0) {
											$ProductPriceDefault2 = ($list['ProductPriceDefault']+$FC) * (1-($list['PromoPercent']/100));
										} else {
											$ProductPriceDefault2 = round($list['ProductPriceDefault']+$FCper);
										}
										// --------------------------------------------------

					                	if ($list['FreightCharge'] <= 0) {
					                		$list['ProductPriceDefault'] = $ProductPriceDefaultAsal;
	                						$ProductPriceDefault2 = $ProductPriceDefaultAsal;
					                	}
						    ?>
									<tr class="Content1">
					                    <td class="ProductID"><?php echo $list['ProductName'];?></td>
					                    <td class="center"><?php echo $list['ProductQty'];?></td>
					                    <td class="right">
					                    	<?php echo number_format($list['ProductPriceDefault']+$FC,2);?>
					                    </td>
					                    <td class="center"><?php echo $PromoPercent."%";?></td>
					                    <td class="center"><?php echo $list['PTPercent']."%";?></td>
					                    <td class="right">
					                    	<?php echo number_format($PriceTotal,2);?>
					                    </td>
					                </tr>
					                <tr class="Content2" style="display: none;">
					                    <td class="ProductID"><?php echo $list['ProductName'];?></td>
					                    <td class="center"><?php echo $list['ProductQty'];?></td>
					                    <td class="right">
					                    	<?php echo number_format($ProductPriceDefault2,2);?>
					                    </td>
						                    <td class="center">0%</td>
					                    <td class="center"><?php echo $list['PTPercent']."%";?></td>
					                    <td class="right">
					                    	<?php echo number_format($PriceTotal,2);?>
					                    </td>
					                </tr>
						    <?php	}
								} 
					    	}  
						    ?>

						    <tr><td colspan="6"></td></tr>

						    <!-- only from do -->
				            <?php 
								$TotalPriceReturned = 0;
						    	if ($dorProductQty > 0) { 
						    ?>
						    <tr>
						    	<td colspan="6">
						    	<b style="color: red;">Returned : </b><br>
							    	<table>
							    		<thead>
							    			<tr>
							                    <td class="ProductID">Product</td>
							                    <td class="center">Qty</td>
							                    <td class="right">Amount</td>
							                </tr>
							    		</thead>
							    		<tbody>
							    			<?php
									            if (isset($content['detail'])) {
									                foreach ($detail as $row => $list) { 
					                					$TotalQtyRetur += $list['dorProductQty'];
							    						if ($list['dorProductQty'] > 0) {
										                	if ($main['FCRetur']==1) {
										                		$FC = $list['FreightCharge']/max($list['ProductQty'],1);
										                		$PriceTotal = ($list['PriceAmount']+$FC) * $list['dorProductQty'];
										                	} else {
										                		$FC = $list['FreightCharge']/$list['doProductQty'];
										                		$PriceTotal = $list['PriceAmount'] * $list['dorProductQty'];
										                	}
								    						$TotalPriceReturned += $PriceTotal;
									        ?>
											                <tr>
											                    <td class="ProductID"><?php echo $list['ProductName'];?></td>
											                    <td class="center"><?php echo $list['dorProductQty'];?></td>
											                    <td class="right">
											                    	<?php echo number_format($PriceTotal,2);?>
											                    </td>
											                </tr>
										    <?php	
														}
													} 
										    	} 
										    ?>
							    		</tbody>
							    	</table>
							    </td>
							</tr>
						    <?php } ?>
						    <!-- ================================== -->

						    <tr><td colspan="6"></td></tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>

		<tfoot class="main">
			<tr>
				<td>
					<table width="750px;" class="total">
						<tr>
							<td class="cell1" style="width:450px">
								<?php
									if ($main['INVTerm'] != "") {
										echo "Term : ".$main['INVTerm']."<br>";
									}
									if ($main['INVNote'] != "") {
										echo "Note : ".str_replace(array("\r", "\n","\r\n"), " ",$main['INVNote'])."<br><br>";
									}
									if ($main['INVMP'] != "") {
										echo "INVOICE MP : ".$main['INVMP']."<br>";
									}
									if ($main['TotalPaid'] > 0) {
										echo "Total Paid : ".number_format($main['TotalPaid'],2)."<br>";
									}
								?>
							</td>
							<td class="cell2" style="vertical-align:top">
								<table width="100%">
									<tr>
										<td>Total Quantity</td>
										<td>:</td>
										<td class="detail right"><?php echo $TotalQty - $TotalQtyRetur; ?></td>
									</tr>
									<tr>
										<td>Total Price Before Tax</td>
										<td>:</td>
										<td class="detail right"><?php echo number_format($TotalPriceAmount, 2); ?></td>
									</tr>
									<tr>
										<td>Tax Rate</td>
										<td>:</td>
										<td class="detail right"><?php echo $main['TaxRate']."%"; ?></td>
									</tr>
									<tr>
										<td>Tax Price </td>
										<td>:</td>
										<td class="detail right">
											<?php echo number_format( round($TotalPriceAmount * ($main['TaxRate']/100)) ); ?>
										</td>
									</tr>

						    		<?php if ($TotalPriceReturned > 0) { ?>
										<tr>
											<td>Returned Amount </td>
											<td>:</td>
											<td class="detail right"><?php echo number_format( $TotalPriceReturned+($TotalPriceReturned*0.1), 2); ?></td>
										</tr>
						    		<?php } ?>

						    		<?php if ($main['INVCategory']==1) { ?>
										<?php 
											$paymentAmount1 = $main['PriceTotal'] + $main['FCInclude'] + $main['FCTax']; 
											$paymentAmount2 = $TotalPriceAmount + (round($TotalPriceAmount * ($main['TaxRate']/100))) ;
						                	$paymentAmount3 = ($paymentAmount1-$paymentAmount2);
						                	if ( $paymentAmount3 < 10 && $paymentAmount3 > -10) {
						                		$main['paymentAmount'] = $paymentAmount2 ;
						                	} else {
												$main['paymentAmount'] = ($paymentAmount2 > $paymentAmount1) ? $paymentAmount2 : $paymentAmount1 ; 
						                	}
										?>
										<tr>
											<td>Total Payment Due</td><td>:</td><td class="detail right"><?php echo number_format($main['paymentAmount'],2); ?></td>
										</tr>
						    		<?php } elseif ($main['INVCategory']==2) { ?>
										<tr>
											<td>Total Invoice</td><td>:</td><td class="detail right"><?php echo number_format($main['PriceTotal']+$main['FCTotal'],2); ?></td>
										</tr>
										<?php 
											if ($main['TotalPaid'] > 0) { 
												$main['paymentAmount'] = $main['paymentAmount']-$main['TotalPaid'];
										?>
										<tr>
											<td>Total Paid</td><td>:</td><td class="detail right"><?php echo number_format($main['TotalPaid'],2); ?></td>
										</tr>
										<?php } ?>

										<tr>
											<td>Total Payment Due</td><td>:</td><td class="detail right"><?php echo number_format(round($main['paymentAmount']),2); ?></td>
										</tr>
						    		<?php } ?>

						    			<tr class="ContentThirdParty"><td colspan="3"><br></td></tr>
						    			<tr class="ContentThirdParty">
											<td>Third Party Fees</td><td>:</td><td class="detail right"><?php echo number_format(round($main['FCExclude']),2); ?></td>
										</tr>
										<tr class="ContentThirdParty">
											<td>Grand Total Payment Due</td><td>:</td><td class="detail right"><?php echo number_format(round($main['paymentAmount'] + $main['FCExclude']),2); ?></td>
										</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</tfoot>
	</table>
</div>
</body>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script>
$( "#noprint" ).click(function() {
  	window.print();
});	

$( ".showContentFull" ).click(function() {
  $( ".content1" ).slideDown('fast');
  $( ".content2" ).slideUp('fast');
});
$( ".ShowContentNonPromo" ).click(function() {
  $( ".content1" ).slideUp('fast');
  $( ".content2" ).slideDown('fast');
});
$( ".ShowContentThirdParty" ).click(function() {
	if ($('.ContentThirdParty').is(":hidden")) {
        $('.ContentThirdParty').css("display", "table-row");
    } else {
        $('.ContentThirdParty').css("display", "none");
    }
});
$('#size').live( "keyup", function() {
    size  = $(this).val();
    $(".productlist tbody tr td").css('font-size',size);
});
</script>