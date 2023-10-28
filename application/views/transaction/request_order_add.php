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
.productstock, .productqty, .productpo,
.rawstock, .rawqty, .RawPO {
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
.cellproduct input,
.cellraw input { 
  height: 23px; 
}
</style>

<?php 
// print_r($ro_detail); 
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
                <td><input class="form-control input-sm productpo" name="productpo[]" type="text" readonly="" required=""></td>
                <td>
                  <button type="button" class="btn btn-danger btn-xs remove"><i class="fa fa-remove"></i></button>
                  <button type="button" class="btn btn-primary btn-xs plusraw"><i class="fa fa-plus"></i> RAW</button>
                </td>
              </tr>
              <tr class="cellraw" dataproduct="">
                <td>
                  <i class="fa fa-fw fa-arrow-right"></i>
                  <input class="form-control input-sm rawid" name="rawid[]" type="text" readonly="" required="">
                  <input class="form-control input-sm rawproductid" name="rawproductid[]" type="hidden" readonly="" required="">
                </td>
                <td><input class="form-control input-sm rawcode" name="rawcode[]" type="text" readonly="" required=""></td>
                <td><input class="form-control input-sm rawqty" name="rawqty[]" type="number" min="1" required=""></td>
                <td><input class="form-control input-sm rawstock" name="rawstock[]" type="text" readonly="" required=""></td>
                <td><input class="form-control input-sm rawpo" name="rawpo[]" type="text" readonly="" required=""></td>
                <td>
                  <button type="button" class="btn btn-danger btn-xs removeraw"><i class="fa fa-remove"></i></button>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="box box-solid">
      <div class="box-body">
          <input type="hidden" name="ro_sugestion_val" id="ro_sugestion_val" value="<?php if ( isset($ro_sugestion['ro_sugestion_val'])){ echo $ro_sugestion['ro_sugestion_val']; }?>">
          <form name="form" id="form" action="<?php echo base_url();?>transaction/request_order_add_act" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="col-md-6">
              <?php if (isset($ro_detail)) { ?>
              <div class="form-group">
                <label class="left">RO Number</label>
                <span class="left2">
                  <input type="text" class="form-control input-sm" id="ro" name="ro" placeholder="RO" autocomplete="off" readonly="" value="<?php echo $ro_detail['main']['ROID'];?>">
                </span>
              </div>
              <?php }; ?>
              <div class="form-group">
                <label class="left">Date</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm pull-right" id="createdate" name="createdate" autocomplete="off" required="" readonly="">
                </div>
              </div>
              <div class="form-group">
                <label class="left">Schedule</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control input-sm pull-right" id="scheduledate" name="scheduledate" autocomplete="off" required="" readonly="">
                </div>
              </div>
              <div class="form-group">
                <label class="left">Notes</label>
                <span class="left2">
                  <textarea class="form-control input-sm" id="note" name="note" placeholder="note" autocomplete="off"></textarea>
                </span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">SO Number</label>
                <div class="input-group martop">
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-primary input-sm" id="cek_so">Check</button>
                  </div>
                  <input type="text" class="form-control input-sm" id="so" name="so" placeholder="SO" autocomplete="off">
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-btn raw">
                    <button type="button" class="btn btn-primary" id="open_popup_product">Add</button>
                  </div>
                  <input type="text" class="form-control" readonly value="Search Product">
                </div>
              </div>
            </div>
            <div class="col-md-12" style="overflow-x:auto;">
              <table class="table table-bordered table-main">
                <thead>
                  <tr>
                    <th class=" alignCenter">Product ID</th>
                    <th class=" alignCenter">Product Code</th>
                    <th class=" alignCenter">Quantity</th>
                    <th class=" alignCenter">Stock</th>
                    <th class=" alignCenter">PO</th>
                    <th class=" alignCenter">Action</th>
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
<script>
var ro_product = [];
var so_product = [];
var ro_raw = [];
var ro_sugestion = [];

jQuery( document ).ready(function( $ ) {
   
  // currentdate = new Date();
  // $("#scheduledate").datepicker({ autoclose: true, format: 'yyyy-mm-dd'}).datepicker("setDate", currentdate);
  $("#createdate").val("<?php echo date('Y-m-d')?>")
  $("#scheduledate").val("<?php echo date('Y-m-d')?>")
  // jika edit
  if ($("#ro").length) {
    $("#form #createdate").val('<?php if ( isset($ro_detail)){ echo $ro_detail['main']['RODate']; }?>');
    $("#form #scheduledate").val('<?php if ( isset($ro_detail)){ echo $ro_detail['main']['ROScheduleDate']; }?>');
    $("#form #note").val('<?php if ( isset($ro_detail)){ echo $ro_detail['main']['RONote']; }?>');
    $("#form #so").val('<?php if ( isset($ro_detail)){ echo $ro_detail['main']['SOID']; }?>').attr("readonly", true);

    ro_product = $.parseJSON('<?php if ( isset($ro_detail['product2'])){ echo $ro_detail['product2']; }?>');
    ro_raw = $.parseJSON('<?php if ( isset($ro_detail['raw2'])){ echo $ro_detail['raw2']; }?>');
    setTimeout( function order() {
      fillproduct();
    }, 1000)
    setTimeout( function order() {
      fillraw();
    }, 2000)
    setTimeout( function order() {
      cek_po();
    }, 2000)
  }
  if ( $("#ro_sugestion_val").val() !== '' ) {
    ro_sugestion = $.parseJSON('<?php if ( isset($ro_sugestion['product2'])){ echo $ro_sugestion['product2']; }?>');
    ro_sugestion_qty = $.parseJSON('<?php if ( isset($ro_sugestion['productqty2'])){ echo $ro_sugestion['productqty2']; }?>');
    setTimeout( function order() {
      fillproduct();
    }, 1000)
  }
});

function fillproduct() {
  if (ro_product !== null) {
    for( var i = 0; i<ro_product.length; i++){
      $(".cellproduct:first .productid").val(ro_product[i]['ProductID']);
      $(".cellproduct:first .productcode").val(ro_product[i]['ProductCode']);
      $(".cellproduct:first .productqty").val(ro_product[i]['ProductQty']).attr('min',ro_product[i]['ProductPO']);
      $(".cellproduct:first .productstock").val(ro_product[i]['stock']);
      $(".cellproduct:first .productpo").val(ro_product[i]['ProductPO']);
      $(".cellproduct:first").attr('dataproduct',ro_product[i]['ProductID']);
      $(".cellproduct:first .productcode").css('width',$(".cellproduct:first .productcode").val().length * 8);
      $(".cellproduct:first").clone().appendTo('.table-main tbody');
      $(".cellproduct:first input").val("");
      $(".cellproduct:first .productqty").attr('min',0);
    }
  }
  if (so_product !== null) {
    for( var i = 0; i<so_product.length; i++){
      $(".cellproduct:first .productid").val(so_product[i]['ProductID']);
      $(".cellproduct:first .productcode").val(so_product[i]['ProductCode']);
      $(".cellproduct:first .productqty").val(so_product[i]['ProductQty']);
      $(".cellproduct:first .productstock").val(so_product[i]['stock']);
      $(".cellproduct:first").attr('dataproduct',so_product[i]['ProductID']);
      $(".cellproduct:first .productcode").css('width',$(".cellproduct:first .productcode").val().length * 8);
      $(".cellproduct:first").clone().appendTo('.table-main tbody');
      $(".cellproduct:first input").val("");
    }
  }
  if (ro_sugestion !== null) {
    for( var i = 0; i<ro_sugestion.length; i++){
      $(".cellproduct:first .productid").val(ro_sugestion[i]['ProductID']);
      $(".cellproduct:first .productcode").val(ro_sugestion[i]['ProductCode']);
      $(".cellproduct:first .productqty").val(ro_sugestion_qty[ro_sugestion[i]['ProductID']]);
      $(".cellproduct:first .productstock").val(ro_sugestion[i]['stock']);
      $(".cellproduct:first .productpo").val('0');
      $(".cellproduct:first").attr('dataproduct',ro_sugestion[i]['ProductID']);
      $(".cellproduct:first .productcode").css('width',$(".cellproduct:first .productcode").val().length * 8);
      $(".cellproduct:first").clone().appendTo('.table-main tbody');
      $(".cellproduct:first input").val("");
    }
  }
}
function fillraw() {
  if (ro_raw !== null) {
    for( var i = 0; i<ro_raw.length; i++){
      $(".cellraw:first .rawproductid").val(ro_raw[i]['ProductID']);
      $(".cellraw:first .rawid").val(ro_raw[i]['RawID']);
      $(".cellraw:first .rawcode").val(ro_raw[i]['ProductCode']);
      $(".cellraw:first .rawstock").val(ro_raw[i]['stock']);
      $(".cellraw:first .rawqty").val(ro_raw[i]['RawQty']).attr('min',ro_raw[i]['RawPO']);
      $(".cellraw:first .rawpo").val(ro_raw[i]['RawPO']);
      $(".cellraw:first .rawcode").css('width',$(".cellraw:first .rawcode").val().length * 8);
      
      $(".cellraw:first").attr('dataproduct',ro_raw[i]['ProductID']);
      $(".cellraw:first").clone().insertAfter('.table-main tbody tr[dataproduct='+ro_raw[i]['ProductID']+']:last');
    }
  }
}
function cek_po() {
  $(".table-main .cellproduct").each(function() {
      dataproduct = $(this).attr('dataproduct')
      dataproductPO = $(this).find(".productpo").val()
      if (dataproductPO > 0) {
        par = $('.table-main tbody tr[dataproduct='+dataproduct+']')
        // par.find('.productqty').attr('readonly', true)
        // par.find('.rawqty').attr('readonly', true)
        par.find('.remove').remove()
        par.find('.remove').remove()
        par.find('.plusraw').remove()
        par.find('.removeraw').remove()
      }
  });
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
$(".plusraw").live('click', function() {
  par       = $(this).parent().parent();
  productid = par.find('.productid').val();
  $(".cellraw:first .rawproductid").val(productid);
  openPopupOneAtATime();
});

function buildcurlist() {
  par = $(".table-main .cellproduct .productid")
  curlist = []
  for (var i = 0; i < par.length; i++) {
    curlist.push($(par[i]).val())
  }
}
function buildcurRawlist() {
  parRaw = $(".table-main .cellraw .rawid")
  parProduct = $(".table-main .cellraw .rawproductid")
  curRawlist = []
  for (var i = 0; i < parRaw.length; i++) {
    curRawlist.push( $(parProduct[i]).val()+"."+$(parRaw[i]).val() )
  }
}
function ProcessChildMessage(message) {
  if (message['stockable']!==0) {
    if ($(".cellraw:first .rawproductid").val() === "") {
      buildcurlist()
      if ($.inArray(message['tdid'], curlist) < 0) {  //cek jika product exist in list
        $(".cellproduct:first .productid").val(message['tdid']);
        $(".cellproduct:first .productcode").val(message['tdcode']);
        $(".cellproduct:first .productstock").val(message['tdstock']);
        $(".cellproduct:first .productpo").val('0');
        $(".cellproduct:first").attr('dataproduct',message['tdid']);
        $(".cellproduct:first .productcode").css('width',$(".cellproduct:first .productcode").val().length * 8);
        $(".cellproduct:first").clone().appendTo('.table-main tbody');
        $(".cellproduct:first input").val("");
      }
    } else {
      buildcurRawlist()
      rawproductid = $(".cellraw:first .rawproductid").val();

      if ($.inArray(rawproductid+"."+message['tdid'], curRawlist) < 0) {  //cek jika product exist in list
        $(".cellraw:first .rawid").val(message['tdid']);
        $(".cellraw:first .rawcode").val(message['tdcode']);
        $(".cellraw:first .rawstock").val(message['tdstock']);
        $(".cellraw:first .rawcode").css('width',$(".cellraw:first .rawcode").val().length * 8);
        
        rawproductid = $(".cellraw:first .rawproductid").val();
        $(".cellraw:first").attr('dataproduct',rawproductid);

        $(".cellraw:first").clone().insertAfter('.table-main tbody tr[dataproduct='+rawproductid+']:last');
      }
    } 
  } else {
    alert("product is not stockable!")
  }
}
$(".remove").live('click', function() {
  par       = $(this).parent().parent();
  productid = par.find('.productid').val();
  $(".table-main tbody tr[dataproduct="+productid+"]").remove();
});
$(".removeraw").live('click', function() {
  par       = $(this).parent().parent();
  par.remove();
});

$("#form").submit(function(e) {
  if ($('.table-main .cellproduct').length < 1) {
    e.preventDefault();
    alert("List Produk Kosong!")
    return false
  }
});

$('#cek_so').click( function() {
  id = $('#so').val()
  $('.table-main tbody').empty()
  $.ajax({
    url: "<?php echo base_url();?>transaction/get_so_detail",
    type : 'POST',
    data: {id: id},
    dataType : 'json',
    success : function (response) {
      if ("result" in response) {
        alert(response['result'])
      } 
      so_product = response['detail']
      $("#scheduledate").val(response['SOShipDate'])
      $("#note").val(response['SONote'])
      fillproduct()
    }
  })
});

</script>
