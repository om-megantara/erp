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
.productqtyorder, .productqty, .productqtyreceived {
  min-width: 55px;
  padding: 2px 3px;
}
.expdate {
  min-width: 100px;
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
.cellproduct { text-align: center; }
.cellproduct input { height: 23px; }

</style>

<?php 
$main = $detail['main'];
$product = $detail['product'];
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
	                <td><input class="form-control input-sm productcodesupplier" name="productcodesupplier[]" type="text" readonly=""></td>
	                <td><input class="form-control input-sm productqtyorder" name="productqtyorder[]" type="number" min="0" required="" readonly=""></td>
                  <td><input class="form-control input-sm productqtyreceived" name="productqtyreceived[]" type="number" min="1" required="" readonly=""></td>
	                <td>
                    <span class="rawqty"></span>
                    <input class="raw1" type="hidden" required="" readonly="">
                    <input class="raw2" type="hidden" required="" readonly="">
                  </td>
                  <td><input class="form-control input-sm productqty" name="productqty[]" type="number" min="1" required=""></td>
                  <td><input type="text" class="form-control input-sm expdate" name="expdate[]" autocomplete="off" placeholder="yyyy-mm-dd" ></td>
	                <td>
                    <input class="stockable" name="stockable[]" type="hidden" required="">
                    <span class="stockable2"></span>
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
		              <h3 class="box-title">SEND FROM - TO</h3>
		            </div>
		            <div class="box-body">
		              <dl class="dl-horizontal">
		                <dt>From</dt>
		                <dd><?php echo $main['DORFrom']; ?></dd>
		                <dt>Name</dt>
		                <dd><?php echo $main['suppliername']; ?></dd>
		                <dt>Phone</dt>
		                <dd><?php echo $main['supplierphone']; ?></dd>
		                <dt>Address</dt>
		                <dd><?php echo $main['supplieraddr']; ?></dd>
                    <p></p>
                    <dt>To</dt>
                    <dd>
                        <select class="form-control input-sm" style="width: 100%;" name="warehouse" id="warehouse" required="">
                          <?php foreach ($warehouse as $row => $list) { ?>
                          <option value="<?php echo $list['WarehouseID'];?>"><?php echo $list['WarehouseName'];?></option>
                          <?php } ?>
                        </select> 
                    </dd>
                  </dl>
		              </dl>
		            </div>
		          </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">DOR type</label>
                <span class="left2">
                  <input class="form-control input-sm" name="type" type="text" placeholder="TYPE" required="" readonly="" value="<?php echo $main['DORType']." ".$main['DORReff']; ?>">
                  <!-- <input name="warehouse" type="text" readonly="" value="<?php echo $main['WarehouseID']; ?>"> -->
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
                  <input type="text" class="form-control pull-right date" id="date" name="date" autocomplete="off" required="" >
                </div>
              </div>
              <div class="form-group">
                <label class="left">DOR Notes</label>
                <span class="left2">
                  <textarea class="form-control" id="note" name="note" placeholder="note" autocomplete="off"></textarea>
                </span>
              </div>
            </div>
            <div class="col-md-12" style="overflow-x:auto;">
              <table class="table table-bordered table-main table-responsive table-main">
                <thead>
                  <tr>
                    <th>Product ID</th>
                    <th>Product Code</th>
                    <th>Product Code Supplier</th>
                    <th>Qty order</th>
                    <th>Qty received</th>
                    <th>RAW (qty / sent)</th>
                    <th>Qty</th>
                    <th>EXP Date</th>
                    <th>Stockable</th>
                    <th></th>
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
var po_product = [];
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

	$("#warehouse").val(<?php if ( isset($main['WarehouseID'])){ echo $main['WarehouseID']; }?>);
	po_product = $.parseJSON('<?php if ( isset($detail['product2'])){ echo $detail['product2']; }?>');
  setTimeout( function order() {
    fillproduct();
  }, 500)
})
function fillproduct() {
if (po_product !== null) {
	  for( var i = 0; i<po_product.length; i++){
	    $(".cellproduct:first .productid").val(po_product[i]['ProductID']);
	    $(".cellproduct:first .productcode").val(po_product[i]['ProductCode']);
	    $(".cellproduct:first .productcodesupplier").val(po_product[i]['ProductSupplier']);
	    $(".cellproduct:first .productqtyorder").val(po_product[i]['ProductQty']);
      $(".cellproduct:first .productqtyreceived").val(po_product[i]['DORQty']);
      $(".cellproduct:first .rawqty").text(po_product[i]['RawQty'] + " / " + po_product[i]['RawSent']);
      $(".cellproduct:first .raw1").val(po_product[i]['RawQty']);
      $(".cellproduct:first .raw2").val(po_product[i]['RawSent']);
      $(".cellproduct:first .expdate").val(po_product[i]['expdate']);
      $(".cellproduct:first .stockable").val(po_product[i]['Stockable']);
      if (po_product[i]['Stockable'] === '1') {
        $(".cellproduct:first .stockable2").html('<i class="fa fa-check"></i>');
      }
      // console.log(po_product[i]['RawQty'] + " / " + po_product[i]['RawSent'])
	    $(".cellproduct:first").attr('dataproduct',po_product[i]['ProductID']);
	    // $(".cellproduct:first .productcode").css('width',$(".cellproduct:first .productcode").val().length * 8);
	    $(".cellproduct:first").clone().appendTo('.table-main>tbody');
      $(".cellproduct:first input").val("");
	    $(".cellproduct:first span").text("");
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
  console.log(qty + qtyreceived)
  if ((qty + qtyreceived) > qtyorder) {
    alert("qty baru lebih besar dari ketentuan!")
  }
});
$("#form").submit(function(e) {
    errorcount  = 0
    errornote   = ""

    if ($('.table-main .productid').length < 1) {
      e.preventDefault();
      alert("List Produk Kosong!")
      return false
    }
    $('.table-main .productqty').each(function(){
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

        productid = parseInt(par.find('.productid').val());
        raw1 = parseInt(par.find('.raw1').val());
        raw2 = parseInt(par.find('.raw2').val());

        main = qtyorder/(qty+qtyreceived)
        rawto= raw1/raw2
        if (raw1 > 0) {
          if ( main < rawto ) {
            errorcount += 1
            errornote += "- RAW dari " +productid+ " tidak sesuai, seharusnya "+ ((raw1/qtyorder)*(qty+qtyreceived)) +" \n"
          }
        }
    });
    if (errorcount > 0) {
      errornote += "anda yakin DOR?\n"
      var r = confirm(errornote);
      if (r == false) {
        e.preventDefault();
        return false
      }
    }
});
</script>