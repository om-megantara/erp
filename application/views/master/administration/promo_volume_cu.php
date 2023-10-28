<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">
  .form-promovolid { display: none; }
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
  .productcomponent td { padding: 2px 5px !important; }
  .table-display-list tr:hover { background: #00c0ef; }
  .productcomponent button { padding: 0px 5px !important; }
  .productcomponent input { height: 20px !important; padding: 2px 4px !important; }
  .table-display-list thead { background: #3c8dbc !important; }
  .table-display-list thead a { color: #ffffff !important; }
  #myInput { margin: 10px 0px; }
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
  .notYetApprove { background-color: #f39c12; }

  .div_add_qty_filter .col-md-3,
  .rowQP .col-md-3 {
    padding-left: 5px;
    padding-right: 5px;
  }
  .div_add_qty_filter,
  .div_add_qty_filter .col-xs-12,
  .rowQP {
    padding-left: 0px;
    padding-right: 0px;
  }
  .rowPB, .rowQP { margin-top: 5px; }

  .promo, .promoAmount, .topAmount, .cbdAmount,
  .top, .cbd, .productprice, .qty {
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
              <tr class="productcomponent">
                <td class="productid"></td>
                <td class="productname"></td>
                <td>
                  <input type="hidden" class="form-control input-sm status" name="status[]">
                  <input type="hidden" class="form-control input-sm product" name="product[]" placeholder="Quantity" autocomplete="off" min="0">
                  <span class="qty2" style="display: none;"></span>
                  <input type="number" class="form-control input-sm qty" name="qty[]" placeholder="Quantity" autocomplete="off" min="1">
                </td>
                <td>
                  <input type="number" class="form-control input-sm mask-number productprice" name="productprice[]" readonly="" step="0.01">
                </td>
                <td>
                  <input type="number" class="form-control input-sm promo" name="promo[]" placeholder="Disc(%)" autocomplete="off" min="0" readonly="" step="0.01">
                  <input type="number" class="form-control input-sm mask-number promoAmount" name="promoAmount[]" readonly="" step="0.01">
                </td>
                <td>
                  <input type="number" class="form-control input-sm top" name="top[]" placeholder="Disc(%)" autocomplete="off" min="0" readonly="" step="0.01">
                  <input type="number" class="form-control input-sm mask-number topAmount" name="topAmount[]" readonly="" step="0.01">
                </td>
                <td>
                  <input type="number" class="form-control input-sm cbd" name="cbd[]" placeholder="Disc(%)" autocomplete="off" min="0" readonly="" step="0.01">
                  <input type="number" class="form-control input-sm mask-number cbdAmount" name="cbdAmount[]" readonly="" step="0.01">
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

            <div class="col-xs-12 rowQP">
              <div class="col-md-3">
                <input type="number" class="form-control input-sm qty_filter" autocomplete="off" name="qty_filter[]" " title="Filter Qty" required="" readonly="" step="0.01">
              </div>
              <div class="col-md-3">
                <input type="number" class="form-control input-sm promo_filter" autocomplete="off" name="promo_filter[]" " title="Filter Promo" required="" readonly="" step="0.01">
              </div>
              <div class="col-md-3">
                <input type="number" class="form-control input-sm TOP_filter" autocomplete="off" name="TOP_filter[]" title="Filter TOP" required="" readonly="" step="0.01">
              </div>
              <div class="col-md-3">
                <div class="input-group input-group-sm"> 
                  <input type="number" class="form-control input-sm CBD_filter" autocomplete="off" name="CBD_filter[]" title="Filter CBD" required="" readonly="" step="0.01">
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-danger remove" title="Remove" onclick="$(this).closest('.rowQP').remove();">x</button>
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
        <form name="form" id="form" action="<?php echo base_url();?>master/promo_volume_cu_act" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <div class="box box-solid">
              <div class="box-body">
                <div class="form-group form-promovolid">
                  <label class="left">Promo ID</label>
                  <span class="left2">
                    <input type="text" class="form-control input-sm" placeholder="Promo ID" autocomplete="off" name="promovolid" id="promovolid" value="<?php echo $main['promolist']['PromoVolID'];?>">
                  </span>
                </div>
                <div class="form-group fullname">
                  <label class="left">Promo Name</label>
                  <span class="left2">
                    <input type="text" class="form-control input-sm" placeholder="Promo Name" autocomplete="off" name="pname" id="pname" value="<?php echo $main['promolist']['PromoVolName']; ?>" required="">
                  </span>
                </div>
                <div class="form-group">
                  <label class="left">Promo Note</label>
                  <span class="left2">
                    <textarea class="form-control input-sm" rows="3" placeholder="Promo Note" name="pnote" id="pnote"><?php echo $main['promolist']['PromoVolNote']; ?></textarea>
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
                      <input type="text" class="form-control input-sm" autocomplete="off" name="pstart" id="pstart" value="<?php echo $main['promolist']['DateStart']; ?>" required="">
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control input-sm" autocomplete="off" name="pend" id="pend" value="<?php echo $main['promolist']['DateEnd']; ?>" required="">
                    </div>
                  </div>
                </div>

                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-btn raw">
                        <button type="button" class="btn btn-primary btn-sm" id="open_popup" title="ADD">Add</button>
                      </div>
                      <input type="text" class="form-control input-sm" readonly value="Product Promo list">
                    </div>
                  </div>
                <span style="display: none;">
                  <div class="col-md-12" style="padding: 0px 10px !important; margin-bottom: 10px;">
                    <div class="col-md-3">
                      <input type="number" class="form-control input-sm" autocomplete="off" name="default" id="defaultqty" min="0" placeholder="Quantity">
                    </div>
                    <div class="col-md-3">
                      <input type="number" class="form-control input-sm" autocomplete="off" name="default" id="defaultpromo" min="0" placeholder="Promo">
                    </div>
                    <div class="col-md-3">
                      <input type="number" class="form-control input-sm" autocomplete="off" name="default" id="defaulttop" min="0" placeholder="TOP">
                    </div>
                    <div class="col-md-3">
                      <input type="number" class="form-control input-sm" autocomplete="off" name="default" id="defaultcbd" min="0" placeholder="CBD">
                    </div>
                  </div>
                </span>


              </div>
            </div>
          </div>
          <div class="col-md-6">
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
                          // if ($list['num_child'] == 1) {
                      ?>
                        <option value="<?php echo $list['ProductCategoryID'];?>"><?php echo $list['ProductCategoryName'] ;?></option>
                      <?php }  ?>
                    </select>
                  </div>

                  <div class="col-xs-6">
                    <div class="input-group input-group-sm"> 
                      <select class="form-control input-sm BrandList" style="width: 100%;" name="BrandList" required="">
                        <?php 
                          foreach ($brand as $row => $list) { 
                            // if ($list['num_child'] == 1) {
                        ?>
                          <option value="<?php echo $list['ProductBrandID'];?>"><?php echo $list['ProductBrandName'] ;?></option>
                        <?php }  ?>
                      </select>
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-primary btn-xs" id="add_brand_category" title="ADD">Add</button> 
                      </span>
                    </div>
                  </div>
                </div>

                  <div class="category_brand_list"></div>

                  <div class="col-xs-12 div_add_qty_filter">  
                    <div class="col-md-3">
                      Qty
                      <input type="number" class="form-control input-sm" autocomplete="off" name="qty_filter_main" id="qty_filter_main" min="0" placeholder="Filter Qty" title="Filter Qty" required="" value="0" step="0.01">
                    </div>
                    <div class="col-md-3">
                      Promo
                      <input type="number" class="form-control input-sm" autocomplete="off" name="promo_filter_main" id="promo_filter_main" min="0" placeholder="Filter Promo" title="Filter Promo" required="" value="0" step="0.01">
                    </div>
                    <div class="col-md-3">
                      TOP
                      <input type="number" class="form-control input-sm" autocomplete="off" name="TOP_filter_main" id="TOP_filter_main" min="0" placeholder="Filter TOP" title="Filter TOP" required="" value="0" step="0.01">
                    </div>
                    <div class="col-md-3">
                      CBD
                      <div class="input-group input-group-sm"> 
                        <input type="number" class="form-control input-sm" autocomplete="off" name="CBD_filter_main" id="CBD_filter_main" min="0" placeholder="Filter CBD" title="Filter CBD" required="" value="0" step="0.01">
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-primary btn-xs" id="add_qty_percent" title="ADD">+</button> 
                        </span>
                      </div>
                    </div>
                  </div>

                  <div class="qty_percent_list"></div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="box-footer" style="text-align: center;">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
          <div class="col-md-12" style="overflow-x:auto;">
            <div class="box box-solid">
              <div class="box-body no-padding">
                <input type="text" class="form-control input-sm" placeholder="SEARCH CONTENT" id="myInput" autocomplete="off">
                <table class="table table-bordered table-display-list" id="table_main">
                  <thead>
                    <tr>
                      <th class=" alignCenter">ID</th>
                      <th class=" alignCenter">Name</th>
                      <th class=" alignCenter">Quantity</th>
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
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>tool/fancyTable.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.inputmask.js"></script>
<script>
j8  = jQuery.noConflict();
var promolistd = [];
var promoBC = [];
var promoQP = [];
var BrandList = [];
var CategoryList = [];
var fancyTable = 0;
var id_loaded = 0;

jQuery( document ).ready(function( $ ) {
   
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

  if ($("#promovolid").val() !== "") {
    $("#form #isActive").val('<?php if ( isset($main['promolist'])){ echo $main['promolist']['isActive']; }?>');
    $(".form-promovolid").show();
    $("#promovolid").prop("disabled", true)
    if ($("#pstart").val() !== null) { $("#pstart").prop("disabled", true) }
    promolistd = $.parseJSON('<?php if ( isset($main['promod2'])){ echo $main['promod2']; }?>');
    promolistdlength = promolistd.length

    if (promolistdlength > 0) {
      load_modal()
    }

    promoBC = $.parseJSON('<?php if ( isset($main['promoBC2'])){ echo $main['promoBC2']; }?>');
    promoQP = $.parseJSON('<?php if ( isset($main['promoQP2'])){ echo $main['promoQP2']; }?>');
    BrandList = $.parseJSON('<?php if ( isset($brand2)){ echo $brand2; }?>');
    CategoryList = $.parseJSON('<?php if ( isset($category2)){ echo $category2; }?>');
    setTimeout( function order() {
      productcomponentedit();
      if (fancyTable<1) {
        init()
      }
    }, 2000)
  }
});

function init() {
  j8("#table_main").fancyTable({
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
      $("#pricecategory").val('<?php if ( isset($main['promolist']['PricecategoryID'])){ echo $main['promolist']['PricecategoryID']; }?>');
      if ($("#pricecategory").val() !== null) { $("#pricecategory").prop("disabled", true)}
    }
  });
}
j8("input").keydown(function(event){
  if(event.keyCode == 13) {
    event.preventDefault();
    return false;
  }
}); 

function productcomponentedit() {
  if (promolistd !== null) {
    for( var i = 0; i<promolistd.length; i++){
      addraw(promolistd[i]['ProductID'], promolistd[i]['ProductCode'], promolistd[i]['ProductQty'], promolistd[i]['ProductPrice'], promolistd[i]['Promo'], promolistd[i]['PT1Discount'], promolistd[i]['PT2Discount'], promolistd[i]['status'] );
    }
  }

  if (promoBC !== null) {
    for( var i = 0; i<promoBC.length; i++){
      if (promoBC[i]['ProductBrandID'] !== "") {
        add_brand_category(  promoBC[i]['ProductBrandID'], BrandList[promoBC[i]['ProductBrandID']]['ProductBrandName'], promoBC[i]['ProductCategoryID'], CategoryList[promoBC[i]['ProductCategoryID']]['ProductCategoryName']);
      }
    }
  }
  if (promoQP !== null) {
    for( var i = 0; i<promoQP.length; i++){
      add_qty_percent( promoQP[i]['ProductQty'], promoQP[i]['PromoPercent'],  promoQP[i]['PT1Percent'],  promoQP[i]['PT2Percent'] );
    }
  }
}
function addraw(id, name, qty, price, promo, top, cbd, status="old") {
  PromoDefaultCategory = $('select#pricecategory option').filter(':selected').attr('promo')
  if (PromoDefaultCategory !== undefined ) {
    price = countPercent(price, PromoDefaultCategory)
    if (id != "") {
      promoAmount = countPercent(price,promo)
      topAmount = countPercent(promoAmount,top)
      cbdAmount = countPercent(promoAmount,cbd)
      $(".productcomponent:first .productid").html(id);
      $(".productcomponent:first .productname").html(name);
      $(".productcomponent:first .status").val(status);
      $(".productcomponent:first .product").val(id);
      $(".productcomponent:first .qty").val(qty).attr('readonly', true);
      $(".productcomponent:first .qty2").text(qty);
      $(".productcomponent:first .productprice").val(price);
      $(".productcomponent:first .promo").val(promo).attr('max',promo);
      $(".productcomponent:first .promoAmount").val( countPercent(price,promo) );
      $(".productcomponent:first .top").val(top).attr('max',top);
      $(".productcomponent:first .topAmount").val(topAmount).attr('max',top);
      $(".productcomponent:first .cbd").val(cbd).attr('max',cbd);
      $(".productcomponent:first .cbdAmount").val(cbdAmount).attr('max',cbd);
      $(".productcomponent:first").clone().appendTo(".table-display-list tbody"); 
      // $(".productcomponent:last").find('input').attr('readonly', true);
      if ($(".productcomponent:last .status").val() == "new") {
        $(".productcomponent:last").addClass("notYetApprove").attr("title", "Not Yet Approved"); 
        $(".productcomponent:last").find(".productprice").attr("readonly", true); 
      }
      init_mask()
    }
    id_loaded += 1
  } 
  if (id_loaded >= promolistdlength) {
    $("#modal-loading-ajax").modal('hide');
  } 
}

var popup_product_list = null;
j8("#open_popup").on('click', function() {
  if (popup_product_list && !popup_product_list.closed) {
     popup_product_list.focus();
  } else {
     popup_product_list = window.open('<?php echo base_url();?>general/product_list_popup', '_blank', 'width=800,height=500,left=200,top=100');     
  }
}); 
function ProcessChildMessage(message) {
  // qty   = $("#defaultqty").val()
  // promo = $("#defaultpromo").val()
  // TOP  = $("#defaulttop").val()
  // cbd  = $("#defaultcbd").val()
  par = $(".qty_percent_list")
  qty   = par.find(".qty_filter")
  promo = par.find(".promo_filter")
  topf  = par.find(".TOP_filter")
  cbdf  = par.find(".CBD_filter")

  if (qty.length > 0) {
    for (var i = qty.length - 1; i >= 0; i--) {
      if (typeof message !== 'undefined' && message.length > 0) {
        for( var x = 0; x<message.length; x++){
          if (message[x]['tdid'] !== undefined) {
            addraw(message[x]['tdid'], message[x]['tdname'], $(qty[i]).val(), parseInt(message[x]['tdprice'].replace(/,/g, '')), $(promo[i]).val(), $(topf[i]).val(), $(cbdf[i]).val(), "new");
          }
        }
      }
    }
  } else {
    alert('masukkan dulu promo qty nya.')
  }
  // sortTable()
}
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

j8("#add_qty_percent").live('click', function(){
  qty_filter_main = $('#qty_filter_main').val();
  promo_filter_main = $('#promo_filter_main').val();
  TOP_filter_main = $('#TOP_filter_main').val();
  CBD_filter_main = $('#CBD_filter_main').val();
  add_qty_percent(qty_filter_main, promo_filter_main, TOP_filter_main, CBD_filter_main)
});
function add_qty_percent(qty_filter_main, promo_filter_main, TOP_filter_main, CBD_filter_main) {
  $(".rowQP:first .qty_filter").val(qty_filter_main);
  $(".rowQP:first .promo_filter").val(promo_filter_main);
  $(".rowQP:first .TOP_filter").val(TOP_filter_main);
  $(".rowQP:first .CBD_filter").val(CBD_filter_main);
  $(".rowQP:first").clone().appendTo(".qty_percent_list"); 
}

j8("#myInput").on("keyup", function() {
  var value = $(this).val().toLowerCase();
  $("#table_main tbody tr").filter(function() {
    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
  });
});

function countPercent(x,y) {
  var z = x - (x * (y/100))
  return parseFloat(z).toFixed(2)
}
function countPercent2(x,y) {
  var z = 100 - (y / (x/100))
  z = (Math.ceil(z * 100) / 100)
  return parseFloat(z).toFixed(2)
}
j8(".promo").live("keyup", function() {
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

function setEdit(el) {
  par  = el.closest('tr');
  par.find('.qty').attr('readonly',false).attr('max','1000');
  par.find('.promo').attr('readonly',false).attr('max','100');
  par.find('.promoAmount').attr('readonly',false);
  par.find('.top').attr('readonly',false).attr('max','100');
  par.find('.cbd').attr('readonly',false).attr('max','100');
  par.find('.status').val('new');
  par.addClass("notYetApprove").attr("title", "Not Yet Approved"); 
}
function cek_input_detail() {
}
j8("#form").submit(function(e) {
  if ($('.productcomponent').length < 2) {
    e.preventDefault();
    alert("harus menambahkan product walaupun hanya 1 !!!");
    return false
  } else {
    $(this).find(':disabled').removeAttr('disabled');
    $(this).find('input').removeAttr('readonly');
  }
});

function load_modal() {
  $("#modal-loading-ajax").modal({
    show: true,
    backdrop: 'static',
    keyboard: false
  });
}
</script>
