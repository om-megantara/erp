<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">
.table-main{
  font-size: 12px;
  white-space: nowrap;
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
</style>

<?php 
$main 		= $detail['main'];
$product 	= $detail['product'];
$warehouse 	= $detail['warehouse'];
$BillingAddress = str_replace(";", ", ", $main['BillingAddress']);
$ShipAddress = explode(";", $main['ShipAddress']);
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <?php echo $PageTitle.' - '. $MainTitle; ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
  </section>
  <section class="content">

    <div class="modal fade" id="modal-cell">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <table>
	        	  <tr class="cellproduct" dataproduct="">
	               	<td>
                    <input class="productid" name="productid[]" type="hidden" readonly="" required="">
	               		<input class="salesorderdetailid" name="salesorderdetailid[]" type="hidden" readonly="" required="">
	               		<div class="productid2"></div>
	               	</td>
  	             	<td>
  	             		<input class="productcode" name="productcode[]" type="hidden" readonly="" required="">
	               		<div class="productcode2"></div>
  	             	</td>
                	<td>
                		<input class="productstock" name="productstock[]" type="hidden" required="" readonly="">
	               		<div class="productstock2"></div>
                	</td>
	              	<td>
	              		<input class="productqtyorder" name="productqtyorder[]" type="hidden" min="0" required="" readonly="">
	               		<div class="productqtyorder2"></div>
	              	</td>
	              	<td>
	              		<input class="productqtysent" name="productqtysent[]" type="hidden" min="1" required="" readonly="">
	               		<div class="productqtysent2"></div>
	              	</td>
	              	<td><input class="form-control input-sm productqty" name="productqty[]" type="number" min="0" required=""></td>
	            </tr>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="box box-solid">
      <div class="box-body">
          <form name="form" id="form" action="<?php echo base_url();?>transaction/delivery_order_edit_act" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="col-md-6">
  		        <div class="box box-solid">
  		            <div class="box-header with-border">
  		              <h3 class="box-title">SEND TO</h3>
  		            </div>
  		            <div class="box-body">
  		            	<div class="col-md-12 martop">
	  		            	<div class="col-md-3"><label>Customer</label></div>
	  		            	<div class="col-md-9"><?php echo $BillingAddress; ?></div>
  		            	</div>
  		            	<div class="col-md-12 martop">
	  		            	<div class="col-md-3"><label>Shipping</label></div>
	  		            	<div class="col-md-9"><?php echo $ShipAddress[2]; ?></div>
  		            	</div>
  		            </div>
  		        </div>
            </div>
            <div class="col-md-6">
            	<div class="box box-solid">
		            <div class="box-header with-border">
		              <h3 class="box-title">SEND FROM</h3>
		            </div>
		            <div class="box-body">
			            <div class="col-md-12 martop">
	  		            	<div class="col-md-3"><label>Warehouse</label></div>
	  		            	<div class="col-md-9">
		                        <select class="form-control input-sm" style="width: 100%;" name="warehouse" id="warehouse" required="" disabled="">
		                          <?php foreach ($warehouse as $row => $list) { ?>
		                          <option value="<?php echo $list['WarehouseID'];?>"><?php echo $list['WarehouseName'];?></option>
		                          <?php } ?>
		                        </select> 
	  		            	</div>
			            </div>
			            <div class="col-md-12 martop">
			              	<div class="col-md-3"><label> DO type</label></div>
			              	<div class="col-md-5">
			                	<input class="form-control input-sm" name="type" type="text" placeholder="TYPE" required="" readonly="" value="<?php echo $main['DOType']; ?>">
			              	</div>
			              	<div class="col-md-4">
                        <input class="form-control input-sm" name="reff" type="text" required="" readonly="" value="<?php echo $main['DOReff']; ?>">
			                	<input name="do" type="hidden" required="" readonly="" value="<?php echo $main['DOID']; ?>">
			              	</div>
			            </div>
			            <div class="col-md-12 martop">
			              	<div class="col-md-3"><label> DO Date</label></div>
			              	<div class="col-md-9">
				                <div class="input-group date">
				                  <div class="input-group-addon">
				                    <i class="fa fa-calendar"></i>
				                  </div>
				                  <input type="text" class="form-control input-sm" id="date" name="date" autocomplete="off" disabled="" required="" value="<?php echo $main['DODate']; ?>" >
				                </div>
                      </div>
  		            </div>
  		            <div class="col-md-12 martop">
  		              	<div class="col-md-3"><label> DO Notes</label></div>
  		              	<div class="col-md-9">
  		                	<textarea class="form-control input-sm" id="note" name="note" placeholder="note" autocomplete="off"><?php echo $main['DONote']; ?></textarea>
  		                </div>
  		            </div>
                  <?php if ($main['SOCategory']==2) { ?>
                  <div class="col-md-12 martop">
                    <div class="input-group">
                      <span class="input-group-addon"><input type="checkbox" id="newdo" name="newdo" checked="" value="1"> </span>
                      <input type="text" class="form-control input-sm" value="CREATE NEW DO FROM RETURNED QTY (CONSIGNMENT ONLY)" readonly="">
                    </div>
                    <!-- <h5 style="color: red; font-weight: bolder;">*) isi dengan Quantity yang laku</h5> -->
                  </div>
                  <?php } ?>
		            </div>
		        </div>
            </div>
            <div class="col-md-12" style="overflow-x:auto;">
              <table class="table table-bordered table-main table-responsive">
                <thead>
                  <tr>
                    <th>Product ID</th>
                    <th>Product Code</th>
                    <th>Stock</th>
                    <th>Qty order</th>
                    <th>Qty Old</th>
                    <th>Qty New</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
            <div class="col-md-12">
              <div class="box-footer" style="text-align: center;">
                <button type="submit" class="btn btn-primary" >Submit</button>
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
	$("#date").datepicker({ autoclose: true, format: 'yyyy-mm-dd'});
  $("#warehouse").val('<?php echo $main['WarehouseID']; ?>')
	product = $.parseJSON('<?php if ( isset($detail['product2'])){ echo $detail['product2']; }?>');
	// console.log(product)
    setTimeout( function order() {
      fillproduct();
    }, 500)
})
function fillproduct() {
	if (product !== null) {
	  for( var i = 0; i<product.length; i++){
      maxqty = parseInt(product[i]['SOPending']) + parseInt(product[i]['ProductQty'])

	    $(".cellproduct:first .productid").val(product[i]['ProductID']);
      $(".cellproduct:first .productid2").text(product[i]['ProductID']);
	    $(".cellproduct:first .salesorderdetailid").val(product[i]['SalesOrderDetailID']);
	    $(".cellproduct:first .productcode").val(product[i]['ProductName']);
	    $(".cellproduct:first .productcode2").text(product[i]['ProductName']);
	    $(".cellproduct:first .productqtyorder").val(product[i]['SOQty']);
	    $(".cellproduct:first .productqtyorder2").text(product[i]['SOQty']);
	    $(".cellproduct:first .productqtysent").val(product[i]['ProductQty']);
      $(".cellproduct:first .productqtysent2").text(product[i]['ProductQty']);
	    $(".cellproduct:first .productqty").attr('max',maxqty).val(product[i]['ProductQty']);
	    $(".cellproduct:first").attr('dataproduct',product[i]['ProductID']);
	    // $(".cellproduct:first .productcode").css('width',$(".cellproduct:first .productcode").val().length * 8);
	    $(".cellproduct:first").clone().appendTo('.table-main>tbody');
	    $(".cellproduct:first input").val("");
	  }
	}
  fillstock();
  resize();
}
function resize() {
  $('.table-main').find('input').each(function (i, el) {
    $(this).css('width',($(this).val().length * 8) + 30);
  });
}

$('.productqty').live( "keyup", function() {
	par  = $(this).parent().parent();
	qty  = parseInt($(this).val());
	qtyorder	= parseInt(par.find('.productqtyorder').val());
	qtysent   = parseInt(par.find('.productqtysent').val());
	qtystock  = parseInt(par.find('.productstock').val());
  if (qty > qtyorder) {
    alert("qty baru lebih besar dari ketentuan!")
    // return false
  }
});
function fillstock() {
  warehouse = $("#warehouse").val();
  product   = [];
  $('.table-main .productid').each(function(){
    par       = $(this).parent().parent();
    par.find(".productstock").val("");
    par.find(".productstock2").text("");
    product.push($(this).val());
  })
  $.ajax({
      url: "<?php echo base_url();?>transaction/get_stock",
      type : 'POST',
      data: {product: product, warehouse: warehouse},
      dataType : 'json',
      success : function (response) {
        $('.table-main .productid').each(function(){
            par   = $(this).parent().parent();
            stock = par.find(".productstock");
            stock2 = par.find(".productstock2");
            stock.val(response[$(this).val()]['stock'])
            stock2.text(response[$(this).val()]['stock'])
            console.log(response[$(this).val()]['stock'])
        })
      }
    })
}
$("#form").submit(function(e) {
    if ($('.table-main .productid').length < 1) {
      e.preventDefault();
      alert("List Produk Kosong!")
      return false
    }
    $('.productqty').each(function(){
  		par    = $(this).parent().parent();
      qty    = parseInt($(this).val());
  		qtymax = parseInt($(this).attr('max'));
  		qtyorder	= parseInt(par.find('.productqtyorder').val());
  		qtysent	  = parseInt(par.find('.productqtysent').val());
  		qtystock  = parseInt(par.find('.productstock').val());
          // if (qty == 0) {
          //   e.preventDefault();
          //   alert("QUANTITY purchase tidak boleh nol")
          //   return false
          // }
          // if (qty > qtymax) {
          //   e.preventDefault();
          //   alert("QUANTITY baru lebih besar dari kebutuhan!")
          //   return false
          // }
          // if ( (qty-qtysent) > qtystock) {
          //   e.preventDefault();
          //   alert("QUANTITY baru lebih besar dari STOCK!")
          //   return false
          // }
    });

    $("input").attr("disabled", false);
    $("select").attr("disabled", false);
});
</script>