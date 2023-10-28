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
.table-main tbody tr td { padding: 3px 10px; font-weight: bold;}
.productqtyorder, .productqty, .productqtyreceived {
  min-width: 50px;
  padding: 2px 5px;
  height: 25px;
}
.martop { margin-top: 5px; }
</style>

<?php 
$main = $detail['main'];
$product = $detail['product'];
$warehouse = $detail['warehouse'];
// print_r($product); 
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
                    <div class="productid2"></div>
                  </td>
	                <td>
                    <input class="productcode" name="productcode[]" type="hidden" readonly="" required=""> 
                    <div class="productcode2"></div>
                  </td>
	                <td>
                    <input class="productqtyorder" name="productqtyorder[]" type="hidden" min="0" required="" readonly=""> 
                    <div class="productqtyorder2"></div>
                  </td>
	                <td>
                    <input class="productqtyreceived" name="productqtyreceived[]" type="hidden" min="1" required="" readonly=""> 
                    <div class="productqtyreceived2"></div>
                  </td>
	                <td>
                    <input class="form-control input-sm productqty" name="productqty[]" type="number" min="1" required=""> 
                  </td>
	                <td>
	                  <button type="button" class="btn btn-danger btn-xs remove"><i class="fa fa-remove"></i></button>
	                </td>
	            </tr>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="box box-solid">
      <div class="box-body">
          <form name="form" id="form" action="<?php echo base_url();?>transaction/delivery_order_received_add_act" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="col-md-6">
            	<div class="box box-solid">
		            <div class="box-header with-border">
		              <h3 class="box-title">RECEIVE FROM</h3>
		            </div>
                <div class="box-body">
                  <div class="col-md-12 martop">
                    <div class="col-md-3"><label>SOID</label></div>
                    <div class="col-md-9"><?php echo $main['SOID']; ?></div>
                  </div>
                  <div class="col-md-12 martop">
                    <div class="col-md-3"><label>Customer</label></div>
                    <div class="col-md-9"><?php echo $main['DORFrom']; ?></div>
                  </div>
                </div>
		          </div>
            </div>
            <div class="col-md-6">
                <div class="col-md-12 martop">
                  <div class="col-md-3"><label>WAREHOUSE</label></div>
                  <div class="col-md-9">
                        <select class="form-control input-sm" style="width: 100%;" name="warehouse" id="warehouse" required="">
                          <?php foreach ($warehouse as $row => $list) { ?>
                          <option value="<?php echo $list['WarehouseID'];?>"><?php echo $list['WarehouseName'];?></option>
                          <?php } ?>
                        </select> 
                  </div>
                </div>
                <div class="col-md-12 martop">
                  <div class="col-md-3"><label>DOR type</label></div>
                  <div class="col-md-5">
                    <input class="form-control input-sm" name="type" type="text" placeholder="TYPE" required="" readonly="" value="<?php echo $main['DORType']; ?>">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control input-sm" name="reff" type="text" placeholder="TYPE" required="" readonly="" value="<?php echo $main['DORReff']; ?>">
                  </div>
                </div>
                <div class="col-md-12 martop">
                  <div class="col-md-3"><label>DOR Doc No</label></div>
                  <div class="col-md-9">
                    <input class="form-control input-sm" name="doc" type="text" placeholder="DOC NO" required="">
                  </div>
                </div>
                <div class="col-md-12 martop">
                  <div class="col-md-3"><label>DOR Date</label></div>
                  <div class="col-md-9">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="date" name="date" autocomplete="off" required="" >
                    </div>
                  </div>
                </div>
                <div class="col-md-12 martop">
                  <div class="col-md-3"><label>DOR Notes</label></div>
                  <div class="col-md-9">
                      <textarea class="form-control" id="note" name="note" placeholder="note" autocomplete="off"></textarea>
                  </div>
                </div>
                <div class="col-md-12 martop">
                  <div class="input-group">
                    <span class="input-group-addon"><input type="checkbox" id="returfc" name="returfc" checked="" value="1"> </span>
                    <input type="text" class="form-control" value="RETUR FREIGHT CHARGE" readonly="">
                  </div>
                </div>
            </div>
            <div class="col-md-12 martop" style="overflow-x:auto;">
              <table class="table table-bordered table-main table-responsive">
                <thead>
                  <tr>
                    <th>Product ID</th>
                    <th>Product Code</th>
                    <th>Qty Total </th>
                    <th>Qty Returned</th>
                    <th>Qty</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody></tbody>
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
var po_product = [];
jQuery( document ).ready(function( $ ) {
	 
	currentdate = new Date();
	$("#date").datepicker({ autoclose: true, format: 'yyyy-mm-dd'}).datepicker("setDate", currentdate);
	po_product = $.parseJSON('<?php if ( isset($detail['product2'])){ echo $detail['product2']; }?>');
    setTimeout( function order() {
      fillproduct();
    }, 500)
})
function fillproduct() {
if (po_product !== null) {
	  for( var i = 0; i<po_product.length; i++){
      $(".cellproduct:first .productid").val(po_product[i]['ProductID']);
	    $(".cellproduct:first .productid2").text(po_product[i]['ProductID']);
      $(".cellproduct:first .productcode").val(po_product[i]['ProductCode']);
	    $(".cellproduct:first .productcode2").text(po_product[i]['ProductCode']);
      $(".cellproduct:first .productqtyorder").val(po_product[i]['ProductQty']);
	    $(".cellproduct:first .productqtyorder2").text(po_product[i]['ProductQty']);
      $(".cellproduct:first .productqtyreceived").val(po_product[i]['DORQty']);
	    $(".cellproduct:first .productqtyreceived2").text(po_product[i]['DORQty']);
	    $(".cellproduct:first").attr('dataproduct',po_product[i]['ProductID']);
	    // $(".cellproduct:first .productcode").css('width',$(".cellproduct:first .productcode").val().length * 8);
	    $(".cellproduct:first").clone().appendTo('.table-main>tbody');
	    $(".cellproduct:first input").val("");
	  }
	}
	resize();
}
function resize() {
	$('.table-main').find('input').each(function (i, el) {
	  $(this).css('width',($(this).val().length * 8) + 30);
	});
}
$(".remove").live('click', function() {
	par = $(this).closest("tr").remove();
});
$('.productqty').live( "keyup", function() {
	par   = $(this).parent().parent();
	qty 	= parseInt($(this).val());
  qtyorder	= parseInt(par.find('.productqtyorder').val());
  qtyreceived	= parseInt(par.find('.productqtyreceived').val());
  // console.log(qty - qtyreceived)
  if ((qty + qtyreceived) > qtyorder) {
    alert("qty baru lebih besar dari ketentuan!")
  }
});
$("#form").submit(function(e) {
    if ($('.table-main .productid').length < 1) {
      e.preventDefault();
      alert("List Produk Kosong!")
      return false
    }
    $('.productqty').each(function(){
      par    	= $(this).parent().parent();
    	qty 	  = parseInt($(this).val());
      qtyorder      = parseInt(par.find('.productqtyorder').val());
      qtyreceived	  = parseInt(par.find('.productqtyreceived').val());
        if (qty == 0) {
          e.preventDefault();
          alert("QUANIITY purchase tidak boleh nol")
          return false
        }
        if ((qty + qtyreceived) > qtyorder) {
          e.preventDefault();
      	  alert("QUANIITY baru lebih besar dari ketentuan!")
          return false
        }
    });
});
</script>