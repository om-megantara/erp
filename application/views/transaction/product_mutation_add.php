<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

<style type="text/css">
.table-main {
  font-size: 12px;
  white-space: nowrap;
}
.table-main thead tr {
  background: #3c8dbc;
  color: #ffffff;
  align-content: center;
}
.table-main tbody tr:hover {
  background: #eef3f8;
  color: #000;
}
.table-main th:first-child, .table-main td:first-child { max-width: 75px !important; }
.table-main td:first-child input { max-width: 60px; }
/*.remove { padding: 4px 3px; margin: 2px 2px; }*/
/*.plusraw { padding: 2px 3px; margin: 2px 2px; } */
.productstock, .productqty,
.rawstock, .rawqty {
  max-width: 60px;
  min-width: 50px;
  padding: 2px 3px;
}
.cellraw { background: #eeeeee; }
.cellraw td:first-child { text-align: -webkit-right; }
.rawid { display: inline; }
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
// print_r($detail); 
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
                <td><input class="form-control input-sm productqty" name="productqty[]" type="number" min="1" required=""></td>
                <td><input class="form-control input-sm productstock" name="productstock[]" type="text" readonly="" required=""></td>
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
          <form name="form" id="form" action="<?php echo base_url();?>transaction/product_mutation_add_act" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="col-md-6">

              <div class="form-group">
                <label class="left">SEND FROM</label>
                <span class="left2">
                    <select class="form-control input-sm" style="width: 100%;" name="warehousefrom" id="warehousefrom" required="">
                      <?php foreach ($warehouse as $row => $list) { ?>
                      <option value="<?php echo $list['WarehouseID'];?>"><?php echo $list['WarehouseName'];?></option>
                      <?php } ?>
                    </select>  
                </span>
              </div>
              <div class="form-group">
                <label class="left">SEND TO</label>
                <span class="left2">
                    <select class="form-control input-sm" style="width: 100%;" name="warehouseto" id="warehouseto" required="">
                      <?php foreach ($warehouse as $row => $list) { ?>
                      <option value="<?php echo $list['WarehouseID'];?>"><?php echo $list['WarehouseName'];?></option>
                      <?php } ?>
                    </select>  
                </span>
              </div>
              <div class="form-group">
                <label class="left">FC</label>
                <span class="left2">
                  <input type="text" class="form-control input-sm mask-number" id="freightcharge" name="freightcharge" value="0"> 
                </span>
              </div>
            </div>
            <div class="col-md-6">
              <?php if (isset($detail)) { ?>
              <div class="form-group">
                <label class="left">Mutation ID</label>
                <span class="left2">
                  <input type="text" class="form-control input-sm" id="mutationid" name="mutationid" autocomplete="off" readonly="" value="<?php echo $detail['main']['MutationID'];?>">
                </span>
              </div>
              <?php }; ?>
              <div class="form-group">
                <label class="left">Date:</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm pull-right" id="scheduledate" name="scheduledate" autocomplete="off" required="">
                </div>
              </div>
              <div class="form-group">
                <label class="left">Notes</label>
                <span class="left2">
                  <textarea class="form-control input-sm" id="note" name="note" placeholder="note" autocomplete="off"></textarea>
                </span>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-btn raw">
                    <button type="button" class="btn btn-primary btn-sm" id="open_popup_product">TAMBAH</button>
                  </div>
                  <input type="text" class="form-control input-sm" readonly value="Search Product">
                </div>
              </div>
            </div>
            <div class="col-md-12" style="overflow-x:auto;">
              <table class="table table-bordered table-main">
                <thead>
                  <tr>
                    <th>Product ID</th>
                    <th>Product Code</th>
                    <th>Quantity</th>
                    <th>Stock</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
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
<script src="<?php echo base_url();?>tool/jquery.inputmask.bundle.js"></script>
<script>
var product = [];
jQuery( document ).ready(function( $ ) {
   
  currentdate = new Date();
  $("#scheduledate").datepicker({ autoclose: true, format: 'yyyy-mm-dd'}).datepicker("setDate", currentdate);
  // jika edit
  if ($("#mutationid").length != 0) {
    $("#form #scheduledate").val('<?php if ( isset($detail)){ echo $detail['main']['MutationDate']; }?>');
    $("#form #note").val('<?php if ( isset($detail)){ echo $detail['main']['MutationNote']; }?>');
    $("#form #freightcharge").val('<?php if ( isset($detail)){ echo $detail['main']['MutationFC']; }?>');
    $('#warehousefrom option[value=<?php if ( isset($detail)){ echo $detail['main']['WarehouseFrom']; }?>]').attr('selected','selected');
    $('#warehouseto option[value=<?php if ( isset($detail)){ echo $detail['main']['WarehouseTo']; }?>]').attr('selected','selected');

    product = $.parseJSON('<?php if ( isset($detail['product2'])){ echo $detail['product2']; }?>');
    setTimeout( function order() {
      fillproduct();
    }, 1000)
    setTimeout( function order() {
      $('#warehousefrom').trigger( "change" );
    }, 2000)
  }

  $(".mask-number").inputmask({ 
      alias:"currency", 
      prefix:'', 
      autoUnmask:true, 
      removeMaskOnSubmit:true, 
      showMaskOnHover: true 
  });
});

  function fillproduct() {
    if (product !== null) {
      for( var i = 0; i<product.length; i++){
        $(".cellproduct:first .productid").val(product[i]['ProductID']);
        $(".cellproduct:first .productcode").val(product[i]['ProductCode']);
        $(".cellproduct:first .productqty").val(product[i]['ProductQty']);
        // $(".cellproduct:first .productstock").val(product[i]['stock']);
        $(".cellproduct:first").attr('dataproduct',product[i]['ProductID']);
        $(".cellproduct:first .productcode").css('width',$(".cellproduct:first .productcode").val().length * 8);
        $(".cellproduct:first").clone().appendTo('.table-main tbody');
        $(".cellproduct:first input").val("");
      }
    }
  }

  var popup;
  function openPopupOneAtATime() {
      if (popup && !popup.closed) {
         popup.focus();
      } else {
         popup = window.open('<?php echo base_url();?>master/product_list_popup2', '_blank', 'width=700,height=500,left=200,top=100');     
      }
  }
  $("#open_popup_product").on('click', function() {
    $(".cellraw:first input").val("");
    openPopupOneAtATime();
  });
  function ProcessChildMessage(message) {
      $(".cellproduct:first .productid").val(message['tdid']);
      $(".cellproduct:first .productcode").val(message['tdcode']);
      // $(".cellproduct:first .productstock").val(message['tdstock']);
      $(".cellproduct:first").attr('dataproduct',message['tdid']);
      $(".cellproduct:first .productcode").css('width',$(".cellproduct:first .productcode").val().length * 8);
      $(".cellproduct:first").clone().appendTo('.table-main tbody');
      $(".cellproduct:first input").val("");
  }
  $(".remove").live('click', function() {
    par       = $(this).parent().parent();
    productid = par.find('.productid').val();
    $(".table-main tbody tr[dataproduct="+productid+"]").remove();
  });
  $('.productqty').live( "keyup", function() {
    count($(this))
  });
  $("#warehousefrom").live('change', function() {
    fillstock();
  });
  function count(el) {
    par    = el.parent().parent();
    qty    = parseInt(par.find('.productqty').val());
    stock  = parseInt(par.find('.productstock').val());
    if (qty > stock) {
      alert("qty lebih besar dari Stock!")
    }
  }
  function fillstock() {
    warehouse = $("#warehousefrom").val();
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
  $("#form").submit(function(e) {
    if ($('.table-main .productqty').length < 1) {
      e.preventDefault();
      alert("List Produk Kosong!")
      return false
    }
    $('.table-main .productqty').each(function(){
        par    = $(this).parent().parent();
        qty    = parseInt(par.find('.productqty').val());
        stock  = parseInt(par.find('.productstock').val());
        if (isNaN(stock)) {
          e.preventDefault();
          fillstock()
          return false
        }
        fillstock()
        if (qty == 0) {
          e.preventDefault();
          alert("QUANTITY purchase tidak boleh nol")
          return false
        }
        if (qty > stock) {
          e.preventDefault();
          alert("QUANTITY lebih besar dari Stock!")
          return false
        }
    });
  });

</script>
