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
/*.table-main th:first-child, .table-main td:first-child { max-width: 75px !important; }*/
.table-main td:first-child input { max-width: 60px; }
.productqtyorder, .productqty, .productqtysent, .productstock, .productqtyold {
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
.productid, .productparent, .totaldor { 
  display: inline !important; 
  padding: 2px;
}
.cellproduct input { height: 23px; }
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
</style>

<?php 

$main = $detail['main'];
$product = $detail['product'];

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
                    <input class="form-control input-sm productid" name="productid[]" type="text" readonly="" required="">
                    <i class="fa fa-fw fa-arrow-right"></i>
                    <input class="form-control input-sm productparent" name="productparent[]" type="text" readonly="" required="">
                  </td>
                  <td><input class="form-control input-sm productcode" name="productcode[]" type="text" readonly="" required=""></td>
                  <td><input class="form-control input-sm productstock" name="productstock[]" type="number" required="" readonly=""></td>
                  <td><input class="form-control input-sm productqtyorder" name="productqtyorder[]" type="number" min="0" required="" readonly=""></td>
                  <td><input class="form-control input-sm productqtysent" name="productqtysent[]" type="number" min="0" required="" readonly=""></td>
                  <td><input class="form-control input-sm productqtyold" name="productqtyold[]" type="number" min="0" required="" readonly=""></td>
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
                    <dl class="dl-horizontal">
                      <dt>To</dt>
                      <dd><?php echo $main['to']; ?></dd>
                      <dt>Name</dt>
                      <dd><?php echo $main['suppliername']; ?></dd>
                      <dt>Phone</dt>
                      <dd><?php echo $main['supplierphone']; ?></dd>
                      <dt>Address</dt>
                      <dd><?php echo $main['supplieraddr']; ?></dd>
                    </dl>
                  </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="box box-solid">
                  <div class="box-header with-border">
                    <h3 class="box-title">SEND FROM</h3>
                  </div>
                  <div class="box-body">
                    <div class="form-group">
                      <label class="left">Warehouse</label>
                      <span class="left2">
                        <select class="form-control input-sm" style="width: 100%;" name="warehouse" id="warehouse" required="">
                          <option value="<?php echo $main['WarehouseID'];?>"><?php echo $main['WarehouseName'];?></option>
                        </select>  
                      </span>
                    </div>
                    <div class="form-group">
                      <label class="left">DO Type</label>
                      <span class="left2">
                        <input class="form-control input-sm" type="text" required="" readonly="" value="<?php echo $main['DOType']." - ".$main['DOReff']; ?>"> 
                        <input name="do" type="hidden" required="" readonly="" value="<?php echo $main['DOID']; ?>">
                        <input name="type" type="hidden" required="" readonly="" value="<?php echo $main['DOType']; ?>"> 
                        <input name="reff" type="hidden" required="" readonly="" value="<?php echo $main['DOReff']; ?>">
                      </span>
                    </div>
                    <div class="form-group">
                      <label class="left">DO Date</label>
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control input-sm" id="date" name="date" autocomplete="off" readonly="" required="" value="<?php echo $main['DODate']; ?>" >
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="left">DO Notes</label>
                      <span class="left2">
                        <textarea class="form-control" id="note" name="note" placeholder="note" autocomplete="off"></textarea>
                      </span>
                    </div>
                  </div>
              </div>
            </div>
            <div class="col-md-12" style="overflow-x:auto;">
              <table class="table table-bordered table-main table-responsive">
                <thead>
                  <tr>
                    <th>RAW ID - Product ID</th>
                    <th>Product Code</th>
                    <th>Stock</th>
                    <th>Qty order</th>
                    <th>Qty sent</th>
                    <th>Qty old</th>
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
   
  product = $.parseJSON('<?php if ( isset($detail['product2'])){ echo $detail['product2']; }?>');
    setTimeout( function order() {
      fillproduct();
    }, 500)
})
function fillproduct() {
if (product !== null) {
    for( var i = 0; i<product.length; i++){
      $(".cellproduct:first .productparent").val(product[i]['ProductParent']);
      $(".cellproduct:first .productid").val(product[i]['ProductID']);
      $(".cellproduct:first .productcode").val(product[i]['ProductCode']);
      $(".cellproduct:first .productqtyorder").val(product[i]['RawQty']);
      $(".cellproduct:first .productqtysent").val(product[i]['QtySent']);
      $(".cellproduct:first .productqtyold").val(product[i]['ProductQty']);
      $(".cellproduct:first .productqty").val(product[i]['ProductQty']);
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
  qtyorder  = parseInt(par.find('.productqtyorder').val());
  qtysent   = parseInt(par.find('.productqtysent').val());
  qtystock  = parseInt(par.find('.productstock').val());
  qtyold  = parseInt(par.find('.productqtyold').val());
  if (qty > qtyold) {
    alert("qty baru lebih besar dari Qty lama!")
    return false
  }
}); 
function fillstock() {
  warehouse = $("#warehouse").val();
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
      qtyorder  = parseInt(par.find('.productqtyorder').val());
      qtysent   = parseInt(par.find('.productqtysent').val());
      qtystock  = parseInt(par.find('.productstock').val()); 
      qtyold  = parseInt(par.find('.productqtyold').val());
        // if (qty > qtyold) {
        //   e.preventDefault();
        //   alert("QUANTITY baru lebih besar dari Qty lama!")
        //   return false
        // }
    });
});
</script>