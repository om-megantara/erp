<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">

<style type="text/css">
  .form-group { display: block; margin-bottom: 5px !important; }
  .fullname .form-control, .address .form-control { margin-top: 3px; }
  .box-body h6 { display: inline; color: red; font-weight: bold; }
  @media (max-width: 768px) {
    .productcomponent select {
      min-width: 370px !important;
    }
  }
  .table-display-list { 
    font-size: 12px !important; 
    white-space: nowrap; 
    background: #ffffff;
  }
  .productcomponent td { padding: 2px 5px !important;}
  .table-display-list tr:hover { background: #00c0ef; }
  .table-display-list thead { background: #3c8dbc !important; }
  .table-display-list thead a { color: #ffffff !important; }
  .productcomponent button { padding: 0px 5px !important; }
  .productcomponent input { height: 20px !important; padding: 2px 4px !important; }
  #InputSearchFancy { margin: 10px 0px; }

  @media (min-width: 768px){
      .form-group label.left {
        float: left;
        width: 150px;
        padding: 5px 15px 5px 5px;
      }
      .form-group span.left2 {
        display: block;
        overflow: hidden;
      }
      .form-group { margin-bottom: 5px; }
  }
  .form-pricelistid {display: none !important;}
  .notYetApprove { background-color: #f39c12; }

  .div_add_qty_filter .col-md-3 {
    padding-left: 5px;
    padding-right: 5px;
  }
  .div_add_qty_filter {
    padding-left: 0px;
    padding-right: 0px;
  }
  .rowPB { margin-bottom: 5px; }

  .promo, .promoAmount, .topAmount, .cbdAmount,
  .top, .cbd, .productprice {
    display: inline-block !important;
    width: 70px;
  }  
  .promoAmount, .topAmount, .cbdAmount, .productprice {
    width: 90px;
  }  
</style>

<?php
$main = $content['main'];
$brand = $content['brand'];
$brand2 = json_encode($content['brand']);
$category = $content['category'];
$category2 = json_encode($content['category']);
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
   
    <div class="modal fade" id="modal-contact">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
          </div>
          <div class="modal-body">
            <table>
              <tr class="productcomponent" title="">
                <td class="productid"></td>
                <td class="productname"></td>
                <td>
                  <input type="number" class="form-control input-sm mask-number productprice" name="productprice[]" readonly="" step="0.01">
                </td>
                <td>
                  <input type="hidden" class="form-control input-sm status" name="status[]">
                  <input type="hidden" class="form-control input-sm product" name="product[]" placeholder="Qty" autocomplete="off" min="1" max="100">
                  <input type="number" class="form-control input-sm alignRight promo" name="promo[]" placeholder="Disc(%)" autocomplete="off" min="0" max="100" readonly="" step="0.01">
                  <input type="number" class="form-control input-sm mask-number promoAmount" name="promoAmount[]" readonly="" step="0.01">
                </td>
                <td>
                  <input type="number" class="form-control alignRight input-sm top" name="top[]" placeholder="Disc(%)" autocomplete="off" min="0" max="100" readonly="" step="0.01">
                  <input type="number" class="form-control input-sm mask-number topAmount" readonly="" step="0.01">
                </td>
                <td>
                  <input type="number" class="form-control input-sm alignRight cbd" name="cbd[]" placeholder="Disc(%)" autocomplete="off" min="0" max="100" readonly="" step="0.01">
                  <input type="number" class="form-control input-sm mask-number cbdAmount" readonly="" step="0.01">
                </td>
                <td>
                  <button type="button" class="btn btn-danger" onclick="if ($('.productcomponent').length != 1 ) { $(this).closest('tr').remove(); buildcurproductlist();}"><i class="fa fa-fw fa-ban"></i></button>
                  <button type="button" class="btn btn-primary" onclick="setEdit($(this))"><i class="fa fa-fw fa-edit"></i></button>
                </td>
              </tr>
            </table>

            <div class="row rowPB">
              <div class="col-xs-6">
                  <input type="hidden" class="form-control input-sm CategoryID" name="CategoryID[]" readonly>
                  <input type="text" class="form-control input-sm CategoryName" name="CategoryName[]" readonly>
              </div>
              <div class="col-xs-6">
                <div class="input-group input-group-sm"> 
                  <input type="hidden" class="form-control input-sm BrandID" name="BrandID[]" readonly>
                  <input type="text" class="form-control input-sm BrandName" name="BrandName[]" readonly>
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-danger remove" title="Remove" onclick="$(this).closest('.rowPB').remove();">x</button>
                  </span>
                </div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>
   
    <div class="box box-solid">
      <div class="box-body form_addcontact">
        <form name="form" id="form" action="<?php echo base_url();?>master/price_list_cu_act" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <div class="box box-solid">
              <div class="box-body">
                <div class="form-group form-pricelistid">
                  <label class="left">Promo Piece ID</label>
                  <span class="left2">
                    <input type="text" class="form-control input-sm" placeholder="Promo Piece ID" autocomplete="off" name="pricelistid" id="pricelistid" value="<?php echo $main['pricelist']['PricelistID'];?>">
                  </span>
                </div>
                <div class="form-group fullname">
                  <label class="left">Promo Piece Name</label>
                  <span class="left2">
                    <input type="text" class="form-control input-sm" placeholder="Promo Piece Name" autocomplete="off" name="pname" id="pname" value="<?php echo $main['pricelist']['PricelistName']; ?>" required="">
                  </span>
                </div>
                <div class="form-group">
                  <label class="left">Promo Piece  Note</label>
                  <span class="left2">
                    <textarea class="form-control input-sm" rows="3" placeholder="Promo Piece  note" name="pnote" id="pnote"><?php echo $main['pricelist']['PricelistNote']; ?></textarea>
                  </span>
                </div>
                <div class="form-group">
                  <label class="left">Price Category</label>
                  <span class="left2">
                    <select class="form-control input-sm" name="pricecategory" id="pricecategory" required=""></select>
                  </span>
                </div>
                <div class="form-group">
                  <label class="left">Status</label>
                  <span class="left2">
                    <select class="form-control input-sm" name="isActive" id="isActive">
                      <option value="1">Active</option>   
                      <option value="0">Non Active</option>   
                    </select>
                  </span>
                </div>
                <div class="col-md-12" style="padding: 0px 10px !important; margin-bottom: 10px;">
                  <div class="col-md-2">
                    <label>Date</label>
                  </div>
                  <div class="col-md-5">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control input-sm" autocomplete="off" name="pstart" id="pstart" value="<?php echo $main['pricelist']['DateStart']; ?>" required="">
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control input-sm" autocomplete="off" name="pend" id="pend" value="<?php echo $main['pricelist']['DateEnd']; ?>" required="">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-btn raw">
                      <button type="button" class="btn btn-primary btn-sm" id="open_popup" title="ADD">Add</button>
                    </div>
                    <input type="text" class="form-control input-sm" readonly value="Product Promo Piece">
                  </div>
                </div>
                
                <span style="display: none;">
                  <div class="col-md-12" style="padding: 0px 10px !important; margin-bottom: 10px;">
                    <div class="col-md-4">
                      <input type="number" class="form-control input-sm" autocomplete="off" name="default" id="promo" min="0" placeholder="Default Promo">
                    </div>
                    <div class="col-md-4">
                      <input type="number" class="form-control input-sm" autocomplete="off" name="default" id="TOP" min="0" placeholder="Default TOP">
                    </div>
                    <div class="col-md-4">
                      <input type="number" class="form-control input-sm" autocomplete="off" name="default" id="CBD" min="0" placeholder="Default CBD">
                    </div>
                  </div>
                </span>

              </div>
            </div>
          </div>
          <div class="col-md-6" id="addedit">
            <div class="box box-solid">
              <div class="box-header">
                <b>PRODUCT FILTER
              </div>
              <div class="box-body">
                <div class="row" style="margin-bottom: 5px;">
                  
                  <div class="col-xs-12">
                    <label>
                      Category / Brand 
                    </label>
                  </div>
                  <div class="col-xs-6">
                    <select class="form-control input-sm CategoryList" style="width: 100%;" name="CategoryList" required="">
                      <?php 
                        foreach ($category as $row => $list) { 
                          if ($list['num_child'] != 0) {
                      ?>
                        <option value="<?php echo $list['ProductCategoryID'];?>"><?php echo $list['ProductCategoryName'] ;?></option>
                      <?php } } ?>
                    </select>
                  </div>

                  <div class="col-xs-6">
                    <div class="input-group input-group-sm"> 
                      <select class="form-control input-sm BrandList" style="width: 100%;" name="BrandList" required="">
                        <?php 
                          foreach ($brand as $row => $list) { 
                            if ($list['num_child'] != 0) {
                        ?>
                          <option value="<?php echo $list['ProductBrandID'];?>"><?php echo $list['ProductBrandName'] ;?></option>
                        <?php } } ?>
                      </select>
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-primary btn-xs" id="add_brand_category" title="ADD">Add</button> 
                      </span>
                    </div>
                  </div>
                </div>

                  <div class="category_brand_list"></div>

                  <div class="col-md-12 div_add_qty_filter">
                    <div class="col-md-3">
                      <label class="left">Promo</label>
                    </div>
                    <div class="col-md-3">
                      <input type="number" class="form-control input-sm" autocomplete="off" name="promo_filter" id="promo_filter" min="0" placeholder="Filter Promo" title="Filter Promo" required="" step="0.01">
                    </div>
                    <div class="col-md-3">
                      <input type="number" class="form-control input-sm" autocomplete="off" name="TOP_filter" id="TOP_filter" min="0" placeholder="Filter TOP" title="Filter TOP" required="" step="0.01">
                    </div>
                    <div class="col-md-3">
                      <input type="number" class="form-control input-sm" autocomplete="off" name="CBD_filter" id="CBD_filter" min="0" placeholder="Filter CBD" title="Filter CBD" required="" step="0.01">
                    </div>
                  </div>

              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="box-footer" style="text-align: center;">
              <button type="submit" class="btn btn-primary btn-solid">Submit</button>
              <!-- <button class="btn btn-primary btn-solid" onclick="console.log(ProductOld); return false;">old</button> -->
              <!-- <button class="btn btn-primary btn-solid" onclick="buildcurproductlist(); arr_diff(ProductOld, ProductNew); console.log(ProductNew); return false;">new</button> -->
            </div>
          </div>
          <div class="col-md-12" style="overflow-x:auto;">
            <div class="box box-solid">
              <div class="box-body no-padding">
                <input type="text" class="form-control input-sm" placeholder="SEARCH CONTENT" id="InputSearchFancy" autocomplete="off">
                <table class="table table-display-list table-bordered" id="table_main">
                  <thead>
                    <tr>
                      <th class="alignCenter">ID</th>
                      <th class=" alignCenter">Product Name</th>
                      <th class=" alignCenter">Price</th>
                      <th class=" alignCenter">Promo</th>
                      <th class=" alignCenter">TOP</th>
                      <th class=" alignCenter">CBD</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/jquery-ui.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.inputmask.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>tool/fancyTable.min.js"></script>
<script>
var fancyTable = 0;
var id_loaded = 0;
var pricelistd = [];
var pricelistBC = [];
var BrandList = [];
var CategoryList = [];

var ProductOld = []
var ProductNew = []

j8  = jQuery.noConflict();
j8( document ).ready(function( $ ) {
  fill_price();

  $("#pstart").datepicker({ 
    "setDate": new Date(), 
    autoclose: true, 
    format: 'yyyy-mm-dd',
    todayBtn:  1,
  }).on('changeDate', function (selected) {
    var minDate = new Date(selected.date.valueOf());
    $('#pend').datepicker('setStartDate', minDate);
  });
  $("#pend").datepicker({ 
    "setDate": new Date(), 
    autoclose: true, 
    format: 'yyyy-mm-dd',
  }).on('changeDate', function (selected) {
    var maxDate = new Date(selected.date.valueOf());
    $('#pstart').datepicker('setEndDate', maxDate);
  }); 
  $(".mask-number").inputmask({ 
      alias:"currency", 
      prefix:'', 
      autoUnmask:true, 
      removeMaskOnSubmit:true, 
      showMaskOnHover: true 
  });

  if ($("#form #pricelistid").val() !== "") {
    $("#form #isActive").val('<?php if ( isset($main['pricelist'])){ echo $main['pricelist']['isActive']; }?>');

    $("#form #promo_filter").val('<?php echo $main['pricelist']['PromoPercent']; ?>');
    $("#form #TOP_filter").val('<?php echo $main['pricelist']['PT1Percent']; ?>');
    $("#form #CBD_filter").val('<?php echo $main['pricelist']['PT2Percent']; ?>');

    $(".form-pricelistid").show();
    $("#pricelistid").prop("disabled", true)
    if ($("#pstart").val() !== null) { $("#pstart").prop("disabled", true) }
    pricelistd = $.parseJSON('<?php if ( isset($main['pricelistd2'])){ echo $main['pricelistd2']; }?>');
    pricelistdlength = pricelistd.length

    if (pricelistdlength > 0) {
      load_modal()
    }

    pricelistBC = $.parseJSON('<?php if ( isset($main['pricelistBC2'])){ echo $main['pricelistBC2']; }?>');
    BrandList = $.parseJSON('<?php if ( isset($brand2)){ echo $brand2; }?>');
    CategoryList = $.parseJSON('<?php if ( isset($category2)){ echo $category2; }?>');
    // console.log(CategoryList)
    setTimeout( function order() {
      productcomponentedit();

      if (fancyTable<1) {
        init()
      }
    }, 2000)
  }
});
 
function ProcessChildMessage(message) {
  buildcurproductlist()
  // promo = $("#promo").val()
  // TOP = $("#TOP").val()
  // CBD = $("#CBD").val()
  promo = $("#promo_filter").val()
  TOP = $("#TOP_filter").val()
  CBD = $("#CBD_filter").val()
  if (typeof message !== 'undefined' && message.length > 0) {
    for( var i = 0; i<message.length; i++){
      // console.log(message[i]['tdid'])
      if ($.inArray(message[i]['tdid'], curproductlist) < 0) {  //cek jika product exist in list
        if (message[i]['tdid'] !== undefined) {
          addraw(message[i]['tdid'], message[i]['tdname'], parseInt(message[i]['tdprice'].replace(/,/g, '')), promo, TOP, CBD, "new" );
        }
      }
    }
  }
  buildcurproductlist()
  // sortTable()
}
function fill_price() {
  $.ajax({
    url: '<?php echo base_url();?>master/fill_price',
    type: 'post',
    dataType: 'json',
    success:function(response){
      var len = response.length;
      for( var i = 0; i<len; i++){
          var PricecategoryID = response[i]['PricecategoryID'];
          var PricecategoryName = response[i]['PricecategoryName'];
          var PromoDefault = response[i]['PromoDefault'];
          $("#pricecategory").append("<option value='"+PricecategoryID+"' promo='"+PromoDefault+"'>"+PricecategoryName+" ("+PromoDefault+"%)</option>");
      }
      <?php 
        if (isset($main['pricelist']['PricecategoryID'])) {
      ?>
        $("#pricecategory option[value='<?php echo $main['pricelist']['PricecategoryID'];?>']").prop('selected',true);
        if ($("#pricecategory").val() !== null) { $("#pricecategory").prop("disabled", true)}

      <?php } ?>
    }
  });
}  
function productcomponentedit() {
  if (pricelistd !== null) {
    for( var i = 0; i<pricelistd.length; i++){
      if (pricelistd[i]['ProductID'] != "") {
        ProductOld.push(pricelistd[i]['ProductID'])
      }

      addraw(pricelistd[i]['ProductID'], pricelistd[i]['ProductName'], pricelistd[i]['ProductPrice'], pricelistd[i]['Promo'], pricelistd[i]['PT1Discount'], pricelistd[i]['PT2Discount'], pricelistd[i]['status'] );
    }
  }

  if (pricelistBC !== null) {
    for( var i = 0; i<pricelistBC.length; i++){
      if (pricelistBC[i]['ProductBrandID'] !== "") {
        add_brand_category(  pricelistBC[i]['ProductBrandID'], BrandList[pricelistBC[i]['ProductBrandID']]['ProductBrandName'], pricelistBC[i]['ProductCategoryID'], CategoryList[pricelistBC[i]['ProductCategoryID']]['ProductCategoryName']);
      }
    }
  }
}
function addraw(id, name, price, promo, top, cbd, status="old") {
  PromoDefaultCategory = $('select#pricecategory option').filter(':selected').attr('promo')
  if (PromoDefaultCategory !== undefined) {
    price = countPercent(price, PromoDefaultCategory)
    if (id != "") {
      promoAmount = countPercent(price,promo)
      topAmount = countPercent(promoAmount,top)
      cbdAmount = countPercent(promoAmount,cbd)
      $(".productcomponent:first .productid").html(id);
      $(".productcomponent:first .productname").html(name);
      $(".productcomponent:first .productprice").val(price);
      $(".productcomponent:first .Status").val(status);
      $(".productcomponent:first .product").val(id);
      $(".productcomponent:first .promo").val(promo).attr('max',promo);
      $(".productcomponent:first .promoAmount").val(promoAmount);
      $(".productcomponent:first .top").val(top).attr('max',top);
      $(".productcomponent:first .topAmount").val(topAmount).attr('max',top);
      $(".productcomponent:first .cbd").val(cbd).attr('max',cbd);
      $(".productcomponent:first .cbdAmount").val(cbdAmount).attr('max',cbd);
      $(".productcomponent:first").clone().appendTo(".table-display-list tbody"); 
      // $(".productcomponent:last").find('input').attr('readonly', true);
      if ($(".productcomponent:last .status").val() == "new") {
        $(".productcomponent:last").addClass("notYetApprove").attr("title", "Not Yet Approved"); 
        $(".productcomponent:last").find("input").attr("readonly", false).attr('required', true); 
        $(".productcomponent:last").find(".productprice").attr("readonly", true); 
        $(".productcomponent:last").find(".topAmount").attr("readonly", true); 
        $(".productcomponent:last").find(".cbdAmount").attr("readonly", true); 
        $(".productcomponent:last .promo").attr('max','100');
        $(".productcomponent:last .top").attr('max','100');
        $(".productcomponent:last .cbd").attr('max','100');
      }
      init_mask()
      id_loaded += 1
    }
  }
  if (id_loaded >= pricelistdlength) {
    $("#modal-loading-ajax").modal('hide');
  }
}

function init() {
  j8("#table_main").fancyTable({
    // sortColumn:0,
    pagination: true,
    perPage: 20,
    searchable: false,
  });
  fancyTable +=1
}
function init_mask() {
  j8('.productcomponent:last .mask-number').inputmask({ 
    alias:"currency", 
    prefix:'', 
    autoUnmask:true, 
    removeMaskOnSubmit:true, 
    showMaskOnHover: true 
  });
} 
function countPercent(x,y) {
  var z = x - (x * (y/100))
  return parseFloat(z).toFixed(2)
}
function countPercent2(x,y) {
  var z = 100 - (y / (x/100))
  z = (Math.ceil(z * 100) / 100)
  return parseFloat(z).toFixed(2)
}
j8(".promo").live("change", function() {
  par  = $(this).closest('.productcomponent');
  updatePromo(par)
});
function updatePromo(par) {
  productprice = par.find('.productprice').val()
  promo = par.find('.promo').val()
  promoAmount = countPercent(productprice, promo) 
  par.find('.promoAmount').val(promoAmount)
  updateTOP(par)
  updateCBD(par)
}
j8(".promoAmount").live("keyup", function() {
  par  = $(this).closest('.productcomponent');
  productprice = par.find('.productprice').val()
  promoAmount = par.find('.promoAmount').val()
  promo = countPercent2(productprice, promoAmount)
  par.find('.promo').val(promo)
  updateTOP(par)
  updateCBD(par)
});
j8(".promoAmount").live("focusout", function() {
  par  = $(this).closest('.productcomponent');
  updatePromo(par)
});
j8(".top").live("keyup", function() {
  par  = $(this).closest('.productcomponent');
  updateTOP(par)
});
function updateTOP(par) {
  promoAmount = par.find('.promoAmount').val()
  topPercent = par.find('.top').val()
  topAmount = countPercent(promoAmount, topPercent)
  par.find('.topAmount').val(topAmount)
}
j8(".cbd").live("keyup", function() {
  par  = $(this).closest('.productcomponent');
  updateCBD(par)
});
function updateCBD(par) {
  promoAmount = par.find('.promoAmount').val()
  cbdPercent = par.find('.cbd').val()
  cbdAmount = countPercent(promoAmount, cbdPercent)
  par.find('.cbdAmount').val(cbdAmount)
}

// ----------------------------------------------------------------------------------
j8("#InputSearchFancy").on("keyup", function() {
  var value = $(this).val().toLowerCase();
  $("#table_main tbody tr").filter(function() {
    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
  });
});
function sortTable() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("table_main");
  switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[0];
      y = rows[i + 1].getElementsByTagName("TD")[0];
      //check if the two rows should switch place:
      // if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
      if (parseFloat(x.innerHTML) > parseFloat(y.innerHTML)) {
        //if so, mark as a switch and break the loop:
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}
function setEdit(el) {
  par  = el.closest('tr');
  par.find('.promo').attr('readonly',false).attr('max','100');
  par.find('.promoAmount').attr('readonly',false);
  par.find('.top').attr('readonly',false).attr('max','100');
  par.find('.cbd').attr('readonly',false).attr('max','100');
  par.find('.status').val('new');
  par.addClass("notYetApprove").attr("title", "Not Yet Approved"); 
}

// ----------------------------------------------------------------------------------
j8("#add_brand_category").live('click', function(){
  BrandID = $('.BrandList option:selected').val();
  BrandName = $('.BrandList option:selected').text();
  CategoryID = $('.CategoryList option:selected').val();
  CategoryName = $('.CategoryList option:selected').text();
  add_brand_category(BrandID, BrandName, CategoryID, CategoryName)
});
function add_brand_category(BrandID, BrandName, CategoryID, CategoryName) {
  $(".rowPB:first .BrandID").val(BrandID);
  $(".rowPB:first .BrandName").val(BrandName);
  $(".rowPB:first .CategoryID").val(CategoryID);
  $(".rowPB:first .CategoryName").val(CategoryName);
  $(".rowPB:first").clone().appendTo(".category_brand_list"); 
}
var curproductlist = []
function buildcurproductlist() {
  curproductlist = []
  ProductNew = []
  par = $(".productcomponent .productid")
  for (var i = 1; i < par.length; i++) {
    curproductlist.push($(par[i]).html())

    ProductNew.push($(par[i]).html()) 
  }
  // console.log(ProductNew)
  // console.log(ProductOld)
}
var popup_product_list = null;
j8("#open_popup").on('click', function() {
  if (popup_product_list && !popup_product_list.closed) {
     popup_product_list.focus();
  } else {
     popup_product_list = window.open('<?php echo base_url();?>general/product_list_popup', '_blank', 'width=800,height=500,left=200,top=100');     
  }
}); 

// ---------------------------------------------------------------------------------- 
j8("#form").submit(function(e) {
  if ($('#table_main .productcomponent').length < 1) {
    alert("harus menambahkan product walaupun hanya 1 !!!");
    e.preventDefault();
    return false;
  }

    buildcurproductlist()
    id_del = 0 
    id_add = 0
    res = ''
    for (var i = 0; i < ProductOld.length; i++) { 
        if ( !(ProductNew.includes(ProductOld[i])) ){
          id_del +=1
        }
    }
    for (var i = 0; i < ProductNew.length; i++) {
        if ( !(ProductOld.includes(ProductNew[i])) ){
          id_add +=1
        }
    }
    if (id_del > 0) {
      res += 'dihapus '+id_del+' product.\n'
    }
    if (id_add > 0) {
      res += 'ditambahkan '+id_add+' product.'
    }
    // console.log(ProductOld)
    // console.log(ProductNew)
    // errornote = arr_diff(ProductOld, ProductNew)
    if (res !== '') {
      var r = confirm(res);
      if (r == false) {
        e.preventDefault();
        return false
      } else { 
        $(this).find(':disabled').removeAttr('disabled');
        $(this).find('input').removeAttr('readonly');

        return true
      } 
    } else {
        $(this).find(':disabled').removeAttr('disabled');
        $(this).find('input').removeAttr('readonly');

        return true
    }
});

function load_modal() {
  $("#modal-loading-ajax").modal({
    show: true,
    backdrop: 'static',
    keyboard: false
  });
}

// compare array ----------------------------------------------
function arr_diff (a1, a2) {
    id_del = 0 
    id_add = 0
    res = ''
    for (var i = 0; i < a1.length; i++) { 
        if ( !(a2.includes(a1[i])) ){
          id_del +=1
        }
    }
    for (var i = 0; i < a2.length; i++) {
        if ( !(a1.includes(a2[i])) ){
          id_add +=1
        } 
    }
    if (id_del > 0) {
      res += 'dihapus '+id_del+' product.\n'
    }
    if (id_add > 0) {
      res += 'ditambahkan '+id_add+' product.'
    }
    return res
}
</script>