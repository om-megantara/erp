<?php
$main   = $content['main'];
$product = $content['product'];
$actor  = $content['actor'];
$approval  = $content['approval'];
?>

<style type="text/css">
  .table-main tr td {
    font-size: 12px;
    padding: 2px 8px !important;
    white-space: nowrap !important;
  }
  .table-detail thead th, .total {
    background: #3169c6;
    color: #ffffff;
    text-align: center;
    color: white;
  }
  .table-detail, 
  .table-detail>thead>tr>th, 
  .table-detail>tbody>tr>td {
    border-color: #3169c6 !important;
    padding: 2px 2px !important;
    font-size: 12px;
  }
  .table-detail > tbody > tr > td, .table-detail > thead > tr > th { 
    word-break: break-all; 
    white-space: nowrap; 
  }

  input[type='checkbox'] {
    -webkit-appearance:none;
    width:15px;
    height:15px;
    background:white;
    border-radius:3px;
    border:1px solid #555;
  }
  input[type='checkbox']:checked {
    background: #3c8dbc;
  }
  .warningpo {
  	color: red;
  	font-weight: bold;
  }
</style>

	<div class="row" style=" background-color: #ffffff;">
		<div class="col-md-12">
			<input type="hidden" name="POID" value="<?php echo $content['POID']; ?>">
			<input type="hidden" name="ApprovalID" value="<?php echo $content['id']; ?>">
			<table class="table table-hover table-main">
				<tr>
					<td>
						<table>
						  <tr>
						    <td>PO ID</td>
						    <td>: <?php echo $main['POID'];?></td>
						  </tr>
						  <tr>
						    <td>PO Date</td>
						    <td>: <?php echo $main['PODate'];?></td>
						  </tr>
						  <tr>
						    <td>Shipping Date</td>
						    <td>: <?php echo $main['ShippingDate'];?></td>
						  </tr>
						  <tr>
						    <td>Shipping To</td>
						    <td>: <?php echo $main['WarehouseName'];?></td>
						  </tr>
						</table>
					</td>
					<td>
						<table>
						  <tr>
						    <td>Last Update</td>
						    <td>: <?php echo $main['POLastUpdate'];?></td>
						  </tr>
						  <tr>
						    <td>Supplier</td>
						    <td>: <?php echo $main['suppliername'];?></td>
						  </tr>
						  <?php if ($main['POType'] == "import") { ?>
							  <tr>
							    <td>Currency</td>
							    <td>: <?php echo $main['POCurrency'];?> </td>
							  </tr>
							  <tr>
							    <td>Currency Ex.</td>
							    <td>: <?php echo number_format($main['POCurrencyEx']);?> </td>
							  </tr>
						  <?php } ?>
						  <tr>
						    <td>Note</td>
						    <td>: <?php echo $main['PONote'];?> </td>
						  </tr>
						  <?php if ($main['POExpiredNote'] != "") { ?>
							  <tr class="warningpo">
							    <td>Expired Note</td>
							    <td>: <?php echo $main['POExpiredNote'];?> </td>
							  </tr> 
						  <?php } ?>

						</table>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="row" style="overflow-x: auto; background-color: #ffffff;">
		<div class="col-md-12">
		    <table class="table table-bordered table-detail table-responsive" id="table_detail">
		      <thead>
		        <tr>
		          <th>ID</th>
		          <th>Name</th>
		          <th>Quantity</th>
		          <th>Pending</th>
		          <th>HPP</th>
		          <th>Price</th>
		          <th>Total</th>
		        </tr>
		      </thead>
		      <tbody>
		        <?php 
		        if (isset($content['product'])) {
		          	foreach ($content['product'] as $row => $list) { 
		          		$ProductCode = ($list['ProductSupplierCode'] == "" ? $list['ProductCode'] : $list['ProductSupplierCode']);
		        ?>
		          <tr>
		            <td class="alignCenter"><?php echo $list['ProductID'];?></td>
		            <td><?php echo $ProductCode;?></td>
		            <td class="alignCenter"><?php echo $list['ProductQty'];?></td>
		            <td class="alignCenter warningpo"><?php echo $list['Pending']?></td>
		            <td class="alignRight"><?php echo number_format($list['ProductPriceHPP']);?></td>
		            <td class="alignRight">
		            	<?php echo number_format($list['ProductPrice'],2);?>
		            	<?php echo ( ($list['ProductPrice2'] > 0) ? '<br>'.number_format($list['ProductPrice2'],2) : "" ); ?>
		            </td>
		            <td class="alignRight">
		            	<?php echo number_format($list['ProductPriceTotal'],2);?>
		            	<?php echo ( ($list['ProductPriceTotal2'] > 0) ? '<br>'.number_format($list['ProductPriceTotal2'],2) : "" ); ?>
		            </td>
		          </tr>
		        <?php 
		    		if (isset($content['raw'][$list['ProductID']])) {
		    	?>
		    		<tr>
		    			<td></td>
						<td colspan="6">
							<table class="table-bordered table-detail table-responsive">
								<thead><tr><th>Raw ID</th><th>Raw Name</th><th>Raw Qty</th><th>DO Qty</th></tr></thead><tbody>
					<?php
		          		foreach ($content['raw'][$list['ProductID']] as $row => $list2) { 
					?>
								<tr>
									<td class="alignCenter"><?php echo $list2['RawID']?></td>
									<td><?php echo $list2['ProductCode']?></td>
									<td class="alignCenter"><?php echo $list2['RawQty']?></td>
									<td class="alignCenter warningpo"><?php echo $list2['DOQty']?></td>
								</tr>
					<?php
						}
					?>
								</tbody>
							</table>
						</td>
					</tr>
					<?php } } } ?>
		      </tbody>
		    </table>
			<table class="table table-hover table-main">
				<tr>
					<td>
						Note Approval : <br> <?php echo $approval['Note']?>
					</td>
					<td>
					  	<?php if ($main['POType'] == "import") { ?>
							<table>
							  <tr>
							    <td>Total Price</td>
							    <td>: <?php echo $main['POCurrency'].' '.number_format($main['PriceBefore2'],2);?></td>
							  </tr>
							  <tr>
							    <td>Tax Amount</td>
							    <td>: <?php echo $main['POCurrency'].' '.number_format($main['TaxAmount2'],2);?></td>
							  </tr>
							  <tr>
							    <td>Total PO</td>
							    <td>: <?php echo $main['POCurrency'].' '.number_format($main['TotalPrice2'],2);?></td>
							  </tr> 
							</table>
						<?php } ?>
					</td>
					<td>
						<table>
						  <tr>
						    <td>Total Price</td>
						    <td>: <?php echo 'Rp '.number_format($main['PriceBefore'],2);?></td>
						  </tr>
						  <tr>
						    <td>Tax Amount</td>
						    <td>: <?php echo 'Rp '.number_format($main['TaxAmount'],2);?></td>
						  </tr>
						  <tr>
						    <td>Total PO</td>
						    <td>: <?php echo 'Rp '.number_format($main['TotalPrice'],2);?></td>
						  </tr> 
						</table>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="row" style="text-align: center; background-color: #ffffff;">
	    <?php if ($actor == "") { ?>
			<button type="submit" class="btn btn-primary btn-submit approve" id="<?php echo $content['id'];?>" po=<?php echo $main['POID'];?>>Approve</button>
			<button type="submit" class="btn btn-danger btn-submit reject" id="<?php echo $content['id'];?>" po=<?php echo $main['POID'];?>>Reject</button>
	    <?php } ?>
	</div>


