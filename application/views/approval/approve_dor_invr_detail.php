<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">
.table-main{
  font-size: 12px;
  white-space: nowrap;
  border: 1px solid #3c8dbc;
}
.table-main thead tr{
  background: #3c8dbc;
  color: #ffffff;
  align-content: center;
}
.table-main tbody tr:hover { background: #3c8dbcb0; }
.table-main tbody tr td { padding: 2px 10px; font-weight: bold; }
.productqtyorder, .productqty, .productqtysent, .productstock {
  min-width: 50px;
  padding: 5px 3px;
  height: 25px;
}
.martop { margin-top: 5px; }
.result { color: red; font-weight: bold; }
.nominal { text-align: right; }
.content-header { text-align: left; }

@media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 120px;
      padding: 5px 15px 5px 5px;
    }
    .form-group span.left2 {
      display: block;
      overflow: hidden;
    }
    .form-group { margin-bottom: 5px; }
}
</style>

<?php 
$main 	= $content['main'];
$BillingAddress = str_replace(";", ", ", $main['BillingAddress']);
$ShipAddress = str_replace(";",", ", $main['ShipAddress']);
$TaxAddress = explode(";", ($main['TaxAddress']!="" ? $main['TaxAddress'] : $main['BillingAddress']));
$actor  = $content['actor'];
?>

<div class="box box-solid">
  <div class="box-body">
        <div class="col-md-6 content-header">
	        <div class="box box-solid">
	            <div class="box-body">
	            	<div class="col-md-12 martop">
		            	<div class="col-md-3"><label>Customer</label></div>
		            	<div class="col-md-9">: <?php echo $BillingAddress; ?></div>
	            	</div>
	            	<div class="col-md-12 martop">
		            	<div class="col-md-3"><label>Shipping</label></div>
		            	<div class="col-md-9">: <?php echo $ShipAddress; ?></div>
	            	</div> 
	            </div>
	        </div>
        </div>
        <div class="col-md-6 content-header">
        	<div class="box box-solid">
            <div class="box-body">
              <div class="row">
                <div class="col-md-3"><label>Sales</label></div>
                <div class="col-md-9">: <?php echo $main['sales']; ?></div>
              </div>
              <div class="row">
                <div class="col-md-3"><label>INV ID</label></div>
                <div class="col-md-9">: <?php echo $main['INVID']; ?></div>
              </div>
              <div class="row">
                <div class="col-md-3"><label>INV Date</label></div>
                <div class="col-md-9">: <?php echo $main['INVDate']; ?></div>
              </div> 
              <div class="row">
                <div class="col-md-3"><label>DOR Note</label></div>
                <div class="col-md-9">: <?php echo $main['DORNote']; ?></div>
              </div> 
            </div>
          </div>
        </div>
        <div class="col-md-12" style="overflow-x:auto;">
          <table class="table table-bordered table-main table-responsive">
            <thead>
              <tr>
                <th class=" alignCenter">ID</th>
                <th class=" alignCenter">Product Name</th>
                <th class=" alignCenter">Qty INV</th>
                <th class=" alignCenter">Qty DOR</th>
                <th class=" alignCenter">Price Default</th>
                <th class=" alignCenter">Promo Percent</th>
                <th class=" alignCenter">PT Percent</th>
                <th class=" alignCenter">Price Amount</th>
                <th class=" alignCenter">Line Total</th>
                <th class=" alignCenter">Freight Charge</th>
              </tr>
            </thead>
            <tbody>
          <?php
                // echo count($content);
            if (isset($content['detail'])) {
                foreach ($content['detail'] as $row => $list) { 
          ?>
                <tr>
      						<td class=" alignCenter">
                    <?php echo $list['ProductID'];?>
                    <input type="hidden" name="ProductID[]" value="<?php echo $list['ProductID'];?>">      
                  </td>
      						<td>
                    <?php echo $list['ProductName'];?>      
                    <input type="hidden" name="ProductName[]" value="<?php echo $list['ProductName'];?>">      
                  </td>
                  <td class=" alignCenter">
                    <?php echo $list['ProductQty'];?>      
                  </td>
                  <td class=" alignCenter result">
                    <?php echo $list['qtyreceived'];?>      
                    <input type="hidden" name="qtyreceived[]" value="<?php echo $list['qtyreceived'];?>">      
                    <input type="hidden" name="ProductMultiplier[]" value="<?php echo $list['ProductMultiplier'];?>">      
                    <input type="hidden" name="ProductHPP[]" value="<?php echo $list['ProductHPP'];?>">      
                    <input type="hidden" name="ProductWeight[]" value="<?php echo $list['ProductWeight'];?>">      
                  </td>
      						<td class="alignRight">
                    <?php echo number_format($list['ProductPriceDefault']);?>      
                    <input type="hidden" name="ProductPriceDefault[]" value="<?php echo $list['ProductPriceDefault'];?>">      
                  </td>
                  <td class=" alignCenter">
                    <?php echo $list['PromoPercent'];?>      
                    <input type="hidden" name="PromoPercent[]" value="<?php echo $list['PromoPercent'];?>">      
                  </td>
                  <td class=" alignCenter">
                    <?php echo $list['PTPercent'];?>      
                    <input type="hidden" name="PTPercent[]" value="<?php echo $list['PTPercent'];?>">      
                  </td>
      						<td class="alignRight">
                    <?php echo number_format($list['PriceAmount']);?>      
                    <input type="hidden" name="PriceAmount[]" value="<?php echo $list['PriceAmount'];?>">      
                  </td>
      						<td class="alignRight">
                    <?php echo number_format($list['linetotal']);?>      
                    <input type="hidden" name="linetotal[]" value="<?php echo $list['linetotal'];?>">      
                  </td>
      						<td class="alignRight">
                    <?php echo number_format($list['FreightCharge']);?>      
                    <input type="hidden" name="FreightCharge[]" value="<?php echo $list['FreightCharge'];?>">      
                  </td>
                </tr>
          <?php } } ?>
            </tbody>
          </table>
        </div>
        <div class="col-md-6 martop">
          <div class="box box-solid">
            <div class="box-body">
              <div class="col-md-12">
                  <div class="col-md-5"><label>Freight Charge Include&emsp;:</label></div>
                  <div class="col-md-4 nominal">
                    <?php echo number_format($main['FCInclude'],2); ?>
                    <input type="hidden" name="FCInclude" value="<?php echo $main['FCInclude']; ?>">
                  </div>
              </div>
              <div class="col-md-12">
                  <div class="col-md-5"><label>Freight Charge Tax&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label></div>
                  <div class="col-md-4 nominal">
                    <?php echo number_format($main['TaxFC'],2); ?>
                    <input type="hidden" name="TaxFC" value="<?php echo $main['TaxFC']; ?>">
                  </div>
              </div>
              <div class="col-md-12">
                  <div class="col-md-5"><label>Freight Charge Exclude&emsp;:</label></div>
                  <div class="col-md-4 nominal">
                    <?php echo number_format($main['FCExclude'],2); ?>
                    <input type="hidden" name="FCExclude" value="<?php echo $main['FCExclude']; ?>">
                  </div>
              </div>
              <div class="col-md-12 result">
                  <div class="col-md-5"><label>Total Freight Charge&emsp;&emsp;&nbsp;:</label></div>
                  <div class="col-md-4 nominal">
                    <?php echo number_format($main['TotalFC'],2); ?>
                    <input type="hidden" class="TotalFC" name="TotalFC" value="<?php echo $main['TotalFC']; ?>">
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 martop">
        	<div class="box box-solid">
            <div class="box-body">
	            <div class="col-md-12">
		            	<div class="col-md-4"><label>Price Before Tax&emsp;: </label></div>
		            	<div class="col-md-4 nominal">
                    <?php echo number_format($main['PriceBefore'],2); ?>    
                    <input type="hidden" name="PriceBefore" value="<?php echo $main['PriceBefore']; ?>">
                  </div>
	            </div>
	            <div class="col-md-12">
		            	<div class="col-md-4"><label>Price Tax&emsp;&emsp;&emsp;&emsp;: </label></div>
		            	<div class="col-md-4 nominal">
                    <?php echo number_format($main['TaxPrice'],2); ?>    
                    <input type="hidden" name="TaxPrice" value="<?php echo $main['TaxPrice']; ?>">
                  </div>
	            </div>
	            <div class="col-md-12 result">
		            	<div class="col-md-4"><label>Total Price&emsp;&emsp;&emsp;&nbsp;&nbsp;: </label></div>
		            	<div class="col-md-4 nominal">
                    <?php echo number_format($main['TotalPrice'],2); ?>    
                    <input type="hidden" class="TotalPrice" name="TotalPrice" value="<?php echo $main['TotalPrice']; ?>">
                  </div>
	            </div>
              <div class="col-md-12 result">
                  <div class="col-md-4"><label>Total Invoice&emsp;&emsp;&nbsp;&nbsp;: </label></div>
                  <div class="col-md-4 nominal">
                    <span class="TotalInvoiceRetur2"><?php echo number_format($main['TotalInvoiceRetur'],2); ?></span>
                    <input type="hidden" class="TotalInvoiceRetur" name="TotalInvoiceRetur" value="<?php echo $main['TotalInvoiceRetur']; ?>">
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="box-footer" style="text-align: center;">
            <?php if ($actor == "") { ?>
            <button type="submit" class="btn btn-primary btn-submit approve" id="<?php echo $content['id'];?>" po=<?php echo $main['DORID'];?>>Approve</button>
            <button type="submit" class="btn btn-danger btn-submit reject" id="<?php echo $content['id'];?>" po=<?php echo $main['DORID'];?>>Reject</button>
            <?php } ?>
          </div>
        </div>
  </div>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
var product = [];
jQuery( document ).ready(function( $ ) {
	 

  currentdate = new Date();
  startDate = new Date(currentdate.getFullYear(), currentdate.getMonth(), 1);
  endDate = new Date(currentdate.getFullYear(), currentdate.getMonth(), 31);
	$("#date").datepicker({ 
    autoclose: true, 
    format: 'yyyy-mm-dd',
    autoclose: true,
    // startDate: startDate,
    // endDate: endDate
  }).datepicker("setDate", currentdate);
	// console.log(product)

  $('#fc').live('click',function(e){
    TotalFC = parseFloat($('.TotalFC').val())
    TotalPrice = parseFloat($('.TotalPrice').val())
    if ($(this).is(':checked')) {
      TotalInvoiceRetur = TotalFC + TotalPrice
    } else {
      TotalInvoiceRetur = TotalPrice
    }
    $('.TotalInvoiceRetur2').text(TotalInvoiceRetur.toLocaleString(undefined, {minimumFractionDigits: 2}))
    $('.TotalInvoiceRetur').val(TotalInvoiceRetur)
  });
})
</script>