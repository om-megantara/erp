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
// $product 	= $content['product'];
// $warehouse 	= $content['warehouse'];
$BillingAddress = str_replace(";", ", ", $main['BillingAddress']);
$ShipAddress = str_replace(";",", ", $main['ShipAddress']);
$TaxAddress = explode(";", ($main['TaxAddress']!="" ? $main['TaxAddress'] : $main['BillingAddress']));
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <?php echo $PageTitle.' - '. $MainTitle; ?>
    </h1>
    <ol class="breadcrumb">
      <li><a title="HELP" class="btn btn-warning btn-xs" href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" target="_blank"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
  </section>
  <section class="content">

    <div class="box box-solid">
      <div class="box-body">
          <form name="form" id="form" action="<?php echo base_url();?>transaction/invoice_retur_add_act" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="col-md-6">
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
                    <div class="col-md-12 martop">
                      <div class="col-md-3"><label>Faktur</label></div>
                      <div class="col-md-9">: <?php echo $TaxAddress[0]."<br>".$TaxAddress[2]; ?></div>
                    </div>
                    <div class="col-md-12 martop">
                      <div class="col-md-3"><label>NPWP</label></div>
                      <div class="col-md-9">: <?php echo $main['NPWP']; ?></div>
                    </div>
  		            </div>
  		        </div>
            </div>
            <div class="col-md-6">
            	<div class="box box-solid">
		            <div class="box-body">
                  <div class="row">
                    <div class="col-md-3"><label>Sales</label></div>
                    <div class="col-md-9">: <?php echo $main['sales']; ?></div>
                  </div>
			            <div class="row">
	  		            	<div class="col-md-3"><label>DOR ID</label></div>
	  		            	<div class="col-md-3">: 
                        <?php echo $main['DORID']; ?>
                        <input type="hidden" name="DORID" value="<?php echo $main['DORID']; ?>">    
                      </div>
	  		            	<div class="col-md-3"><label>DOR Date</label></div>
	  		            	<div class="col-md-3">: <?php echo $main['DORDate']; ?></div>
			            </div>
			            <div class="row">
	  		            	<div class="col-md-3"><label>INV ID</label></div>
	  		            	<div class="col-md-3">: 
                        <?php echo $main['INVID']; ?>
                        <input type="hidden" name="INVID" value="<?php echo $main['INVID']; ?>">    
                      </div>
	  		            	<div class="col-md-3"><label>INV Date</label></div>
	  		            	<div class="col-md-3">: <?php echo $main['INVDate']; ?></div>
			            </div>
                  <div class="row">
                    <div class="form-group">
                      <label class="left">Faktur Number</label>
                      <span class="left2">
                          <input type="text" class="input-sm form-control" name="FakturNumber" autocomplete="off" required="" value="<?php echo $main['FakturNumber']; ?>" readonly>
                      </span>
                    </div>
                    <div class="form-group">
                      <label class="left">Date</label>
                      <span class="left2">
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="input-sm form-control" id="date" name="date" autocomplete="off" required="" >
                        </div>
                      </span>
                    </div>
                    <div class="form-group">
                      <label class="left"></label>
                      <span class="left2">
                        <div class="input-group">
                          <span class="input-group-addon"><input type="checkbox" id="fc" name="fc" checked="" value="1"> </span>
                          <input type="text" class="form-control" value="RETUR FREIGHT CHARGE" readonly="">
                        </div>
                      </span>
                    </div>
                    <div class="form-group">
                      <label class="left">Notes</label>
                      <span class="left2">
                        <textarea class="form-control" id="note" name="note" placeholder="No INV Retur dari customer" autocomplete="off"></textarea>
                      </span>
                    </div>
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
                    <th class=" alignCenter">Quantity delivered</th>
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
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
      </div>
    </div>
  </section>
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