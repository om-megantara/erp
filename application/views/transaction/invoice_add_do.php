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
      width: 80px;
      padding: 5px 15px 5px 5px;
    }
    .form-group { margin-bottom: 10px; }
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
          <form name="form" id="form" action="<?php echo base_url();?>transaction/invoice_add_act" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="col-md-6">
  		        <div class="box box-solid">
  		            <div class="box-body">
  		            	<div class="col-md-12 martop">
	  		            	<div class="col-md-3"><label>Customer</label></div>
	  		            	<div class="col-md-9"><?php echo $BillingAddress; ?></div>
  		            	</div>
  		            	<div class="col-md-12 martop">
	  		            	<div class="col-md-3"><label>Shipping</label></div>
	  		            	<div class="col-md-9"><?php echo $ShipAddress; ?></div>
  		            	</div>
                    <div class="col-md-12 martop">
                      <div class="col-md-3"><label>Faktur</label></div>
                      <div class="col-md-9"><?php echo $TaxAddress[0]."<br>".$TaxAddress[2]; ?></div>
                    </div>
                    <div class="col-md-12 martop">
                      <div class="col-md-3"><label>NPWP</label></div>
                      <div class="col-md-9"><?php echo $main['NPWP']; ?></div>
                    </div>
                    <div class="col-md-12 martop">
                      <div class="col-md-3"><label>Faktur No</label></div>
                      <div class="col-md-9">
                        <?php echo $main['FakturNumberParent'].$main['FakturNumber']; ?>
                        <input type="hidden" name="FakturID" value="<?php echo $main['FakturID']; ?>">
                        <input type="hidden" name="FakturNumberParent" value="<?php echo $main['FakturNumberParent']; ?>">
                        <input type="hidden" name="FakturNumber" class="FakturNumber" value="<?php echo $main['FakturNumber']; ?>" min="1">
                      </div>
                    </div>
  		            </div>
  		        </div>
            </div>
            <div class="col-md-6">
            	<div class="box box-solid">
		            <div class="box-body">
                  <div class="col-md-12 martop">
                    <div class="col-md-3"><label>Sales</label></div>
                    <div class="col-md-9">: <?php echo $main['fullname']; ?></div>
                  </div>
			            <div class="col-md-12 martop">
	  		            	<div class="col-md-3"><label>SO ID</label></div>
	  		            	<div class="col-md-3">: 
                        <?php echo $main['SOID']; ?>
                        <input type="hidden" name="SOID" value="<?php echo $main['SOID']; ?>">    
                      </div>
	  		            	<div class="col-md-3"><label>SO Date</label></div>
	  		            	<div class="col-md-3">: <?php echo $main['SODate']; ?></div>
			            </div>
			            <div class="col-md-12 martop">
	  		            	<div class="col-md-3"><label>DO ID</label></div>
	  		            	<div class="col-md-3">: 
                        <?php echo $main['DOID']; ?>
                        <input type="hidden" name="DOID" value="<?php echo $main['DOID']; ?>">    
                      </div>
	  		            	<div class="col-md-3"><label>DO Date</label></div>
	  		            	<div class="col-md-3">: <?php echo $main['DODate']; ?></div>
			            </div>
			            <div class="col-md-12 martop">
	  		            	<div class="col-md-3"><label>SO Category</label></div>
	  		            	<div class="col-md-3">: <?php echo $main['CategoryName']; ?></div>
	  		            	<div class="col-md-3"><label>Payment Term</label></div>
	  		            	<div class="col-md-3">: <?php echo $main['PaymentTerm']; ?></div>
			            </div>
			            <div class="col-md-12 martop">
                    <div class="form-group">
			              	<label class="left">Date</label>
			                <div class="input-group date">
			                  <div class="input-group-addon">
			                    <i class="fa fa-calendar"></i>
			                  </div>
			                  <input type="text" class="input-sm form-control" id="date" name="date" autocomplete="off" required="" >
			                </div>
                    </div>
  		            </div>
                  <div class="col-md-12 martop">
                    <div class="input-group">
                      <span class="input-group-addon"><input type="checkbox" id="faktur" name="faktur" checked="" value="1"> </span>
                      <input type="text" class="form-control" value="CREATE FAKTUR PAJAK" readonly="">
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
                      
                      if ($main['PaymentTerm'] > 0) {
                        $PTPercent = $list['PT1Percent'];
                      } else {
                        $PTPercent = $list['PT2Percent'];
                      }
              ?>
	                  <tr>
          						<td class=" alignCenter">
                        <?php echo $list['ProductID'];?>
                        <input type="hidden" name="SalesOrderDetailID[]" value="<?php echo $list['SalesOrderDetailID'];?>">      
                        <input type="hidden" name="ProductID[]" value="<?php echo $list['ProductID'];?>">      
                      </td>
          						<td>
                        <?php echo $list['ProductName'];?>      
                        <input type="hidden" name="ProductName[]" value="<?php echo $list['ProductName'];?>">      
                      </td>
        				  		<td class=" alignCenter">
                        <?php echo $list['qtydelivered'];?>      
                        <input type="hidden" name="qtydelivered[]" value="<?php echo $list['qtydelivered'];?>">      
                        <input type="hidden" name="ProductMultiplier[]" value="<?php echo $list['ProductMultiplier'];?>">      
                        <input type="hidden" name="ProductHPP[]" value="<?php echo $list['ProductHPP'];?>">      
                        <input type="hidden" name="ProductWeight[]" value="<?php echo $list['ProductWeight'];?>">      
                      </td>
          						<td class="alignRight">
                        <?php echo number_format($list['ProductPriceDefault']);?>      
                        <input type="hidden" name="ProductPriceDefault[]" value="<?php echo $list['ProductPriceDefault'];?>">      
                      </td>
          						<td class=" alignCenter">
                        <?php echo $list['PricePercent'];?>      
                        <input type="hidden" name="PricePercent[]" value="<?php echo $list['PricePercent'];?>">      
                      </td>
          						<td class=" alignCenter">
                        <?php echo $PTPercent;?>      
                        <input type="hidden" name="PTPercent[]" value="<?php echo $PTPercent;?>">      
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
                        <input type="hidden" name="TotalFC" value="<?php echo $main['TotalFC']; ?>">
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
                        <input type="hidden" name="TotalPrice" value="<?php echo $main['TotalPrice']; ?>">
                      </div>
			            </div>
                  <div class="col-md-12 result">
                      <div class="col-md-4"><label>Total Invoice&emsp;&emsp;&nbsp;&nbsp;: </label></div>
                      <div class="col-md-4 nominal">
                        <?php echo number_format($main['TotalInvoice'],2); ?>
                        <input type="hidden" name="TotalInvoice" value="<?php echo $main['TotalInvoice']; ?>">
                      </div>
                  </div>
		            </div>
		          </div>
            </div>
            <div class="col-md-12">
              <div class="box-footer" style="text-align: center;">
                <button type="submit" class="btn btn-primary btn-submit" >Submit</button>
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
	DODate = '<?php echo $main['DODate']; ?>';
	$("#date")
  .attr('readonly', true)
  .datepicker({ autoclose: true, format: 'yyyy-mm-dd'})
  .datepicker("setDate", currentdate)
  // .datepicker("setStartDate", DODate);
	// console.log(product)

})

$("#form").submit(function(e) {
  FakturNumber = parseFloat($(".FakturNumber").val())
  if (FakturNumber < 1) {
    e.preventDefault();
    alert("Nomer Faktur Pajak habis!")
    return false
  }
});
</script>