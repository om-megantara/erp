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
.table-main tbody tr td { padding: 0px 5px; }
.table-main th:first-child, .table-main td:first-child { max-width: 75px !important; }
.table-main td:first-child input { max-width: 60px; }
.productqtyorder, .productqty, .productqtyreceived, .productstock {
  min-width: 50px;
  padding: 2px 3px;
}
.productprice {
  min-width: 80px;
  padding: 2px 3px;
}
.customborder { border: 1px solid #3c8dbc; padding: 3px;}
.supplieraddress { height: 50px; white-space: normal; padding: 3px !important;}

.dl-horizontal { margin: 0px; }
.dl-horizontal dt { width: 80px !important; }
@media (min-width: 768px){
    .dl-horizontal dd {
    	margin-left: 90px !important; 
   	}
}
@media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 100px;
      padding: 5px 15px 5px 5px;
    }
    .form-group span.left2 {
      display: block;
      overflow: hidden;
    }
    .form-group { margin-bottom: 5px; }
}
.cellproduct input { height: 23px; }
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
	                <td><input class="form-control input-sm productid" name="productid[]" type="text" readonly="" required=""></td>
	                <td><input class="form-control input-sm productcode" name="productcode[]" type="text" readonly="" required=""></td>
	                <td><input class="form-control input-sm productqty" name="productqty[]" type="number" min="1" required="" readonly=""></td>
                  <td><input class="form-control input-sm productstock" name="productstock[]" type="number" min="1" required="" readonly=""></td>
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
                    <h3 class="box-title">SEND FROM - TO</h3>
                  </div>
                  <div class="box-body">
                    <dl class="dl-horizontal">
                      <dt>From</dt>
                      <dd><?php echo $main['DORFrom']; ?></dd>
                      <dt>Warehouse</dt>
                      <dd>
                        <select class="form-control" style="width: 100%;" name="warehouse" id="warehouse" required="" disabled="">
                          <?php foreach ($warehouse as $row => $list) { ?>
                          <option value="<?php echo $list['WarehouseID'];?>"><?php echo $list['WarehouseName'];?></option>
                          <?php } ?>
                        </select>  
                      </dd>
                      <p></p>
                      <dt>To</dt>
                      <dd><?php echo $main['DORFrom']; ?></dd>
                      <dt>Warehouse</dt>
                      <dd>
                        <select class="form-control" style="width: 100%;" name="warehouse2" id="warehouse2" required="" disabled="">
                          <?php foreach ($warehouse as $row => $list) { ?>
                          <option value="<?php echo $list['WarehouseID'];?>"><?php echo $list['WarehouseName'];?></option>
                          <?php } ?>
                        </select>  
                      </dd>
                    </dl>
                  </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">DOR type</label>
                <span class="left2">
                  <input class="form-control input-sm" name="type" type="text" placeholder="TYPE" required="" readonly="" value="<?php echo $main['DORType']." ".$main['DORReff']; ?>">
                  <input name="type" type="hidden" required="" readonly="" value="<?php echo $main['DORType']; ?>">
                  <input name="reff" type="hidden" required="" readonly="" value="<?php echo $main['DORReff']; ?>">
                </span>
              </div>
              <div class="form-group">
                <label class="left">DOR Doc No</label>
                <span class="left2">
                  <input class="form-control input-sm" name="doc" type="text" placeholder="DOC NO" required="">
                </span>
              </div>
              <div class="form-group">
                <label class="left">DOR Date</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="date" name="date" autocomplete="off" required="" >
                </div>
              </div>
              <div class="form-group">
                <label class="left">DOR Notes</label>
                <span class="left2">
                  <textarea class="form-control" id="note" name="note" placeholder="note" autocomplete="off"><?php echo $main['note']; ?></textarea>
                </span>
              </div>
            </div>
            <div class="col-md-12" style="overflow-x:auto;">
              <table class="table table-bordered table-main table-responsive">
                <thead>
                  <tr>
                    <th>Product ID</th>
                    <th>Product Code</th>
                    <th>Qty received</th>
                    <th>Stock</th>
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
  StartDate = new Date(currentdate.getTime() - (1 * 24 * 60 * 60 * 1000));
  $("#date").datepicker({ 
    autoclose: true, 
    format: 'yyyy-mm-dd',
  })
  .datepicker("setDate", currentdate)
  .datepicker('setStartDate', currentdate)
  .datepicker('setEndDate', currentdate);
  
  $('#warehouse option[value=<?php echo $detail['main']['from'];?>]').attr('selected','selected');
  $('#warehouse2 option[value=<?php echo $detail['main']['to'];?>]').attr('selected','selected');
	product = $.parseJSON('<?php if ( isset($detail['product2'])){ echo $detail['product2']; }?>');
    setTimeout( function order() {
      fillproduct();
    }, 500)
})
function fillproduct() {
  if (product !== null) {
	  for( var i = 0; i<product.length; i++){
	    $(".cellproduct:first .productid").val(product[i]['ProductID']);
	    $(".cellproduct:first .productcode").val(product[i]['ProductCode']);
      $(".cellproduct:first .productqty").val(product[i]['ProductQty']);
	    $(".cellproduct:first .productstock").val(product[i]['stock']);
	    $(".cellproduct:first").attr('dataproduct',product[i]['ProductID']);
	    // $(".cellproduct:first .productcode").css('width',$(".cellproduct:first .productcode").val().length * 8);
	    $(".cellproduct:first").clone().appendTo('.table-main>tbody');
	    $(".cellproduct:first input").val("");
	  }
	}
  fillstock()
	resize();
}
function resize() {
	$('.table-main').find('input').each(function (i, el) {
	  $(this).css('width',($(this).val().length * 8) + 30);
	});
}
function fillstock() {
  warehouse = $("#warehouse2").val();
  product   = [];
  $('.table-main .productid').each(function(){
      par       = $(this).parent().parent();
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
            stock.val(response[$(this).val()]['stock'])
            // console.log(response[$(this).val()]['stock'])
        })
      }
    })
}
$(".remove").live('click', function() {
	par = $(this).closest("tr").remove();
});
$('.productqty').live( "keyup", function() {
	par    	= $(this).parent().parent();
	qty 	= parseInt($(this).val());
    qtyorder	= parseInt(par.find('.productqtyorder').val());
    qtyreceived	= parseInt(par.find('.productqtyreceived').val());
    console.log(qty + qtyreceived)
    if ((qty + qtyreceived) > qtyorder) {
      alert("qty baru lebih besar dari ketentuan!")
    }
});
$("#form").submit(function(e) {
  $("#form :disabled").removeAttr('disabled');
});
</script>