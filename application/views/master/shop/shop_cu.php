
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">

<style type="text/css">
  .form-group { display: block; margin-bottom: 5px !important; }
  /*.form-control, .address .form-control { margin-top: 3px; }*/
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
  .form-shopid {display: none !important;}
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
</style>

<?php
$main = $content['main'];
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
                <td><input type="hidden" name="productid[]" class="productid"><span class="productid2"></span></td>
                <td><span class="productcode"></span></td>
                <td><span class="productname"></span></td>
                <td><span class="linktext"></span></td>
                <td>
                  <button type="button" class="btn btn-primary add_field" onclick="if ($('.productcomponent').length != 1 ) { $(this).closest('tr').remove(); buildcurproductlist();}">-</button>
                </td>
              </tr>
            </table>

          </div>
        </div>
      </div>
    </div>
   
    <div class="box box-solid">
      <div class="box-body">
        <form name="form" id="form" action="<?php echo base_url();?>master/shop_cu_act" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
          <div class="col-md-6">
            <div class="box box-solid">
              <div class="box-body">
                <div class="form-group form-shopid">
                  <label class="left">Shop ID</label>
                  <span class="left2">
                    <input type="text" class="form-control input-sm" placeholder="Shop ID" autocomplete="off" name="shopid" id="shopid" value="<?php echo $main['ShopID'];?>">
                  </span>
                </div>
                <div class="form-group">
                  <label class="left">Shop Name</label>
                  <span class="left2">
                    <input type="text" class="form-control input-sm" placeholder="Shop Name" autocomplete="off" name="shopname" id="shopname" value="<?php echo $main['ShopName']; ?>" required="">
                  </span>
                </div>
                <div class="form-group">
                  <label class="left">Shop Link</label>
                  <span class="left2">
                    <input type="text" class="form-control input-sm" placeholder="Shop Link" autocomplete="off" name="shoplink" id="shoplink" value="<?php echo $main['ShopLink']; ?>" required="">
                  </span>
                </div>
                <div class="form-group">
                  <label class="left">Shop Note</label>
                  <span class="left2">
                    <textarea class="form-control input-sm" rows="3" placeholder="Shop note" name="shopnote" id="shopnote"><?php echo $main['ShopNote']; ?></textarea>
                  </span>
                </div> 
              </div>
            </div>
          </div>
          <div class="col-md-6" id="addedit">
            <div class="box box-solid">
              <div class="box-body"> 
                <div class="form-group">
                  <label class="left">Sales</label>
                  <span class="left2">
                    <select class="form-control input-sm saleschild" name="sales" required="">
                      <option value='<?php echo $main['SalesID'];?>' selected><?php echo $main['SalesName'];?></option>
                    <?php foreach ($content['sales'] as $row => $listsales) {?>
                      <option value='<?php echo $listsales['SalesID'];?>'><?php echo $listsales['SalesName'];?></option>
                    <?php } ?>
                    </select>
                  </span>
                </div>
                <span>
                  <div class="form-group customborder">
                    <div class="input-group">
                      <div class="input-group-btn raw">
                        <button type="button" class="btn btn-primary btn-sm" id="open_popup" title="ADD">Add</button>
                      </div>
                      <input type="text" class="form-control input-sm" readonly value="Product List in Shop">
                    </div>
                  </div> 
                </span>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="box-footer" style="text-align: center;">
              <button type="submit" class="btn btn-primary btn-solid">Submit</button>
            </div>
          </div>
          <div class="col-md-12" style="overflow-x:auto;">
            <div class="box box-solid">
              <div class="box-body no-padding">
                <input type="text" class="form-control input-sm" placeholder="SEARCH CONTENT" id="myInput" autocomplete="off">
                <table class="table table-display-list table-bordered" id="table_main">
                  <thead>
                    <tr>
                      <th class=" alignCenter">ID</th>
                      <th class=" alignCenter">Product Code</th>
                      <th class=" alignCenter">Product Name</th>
                      <th class=" alignCenter">Link</th>
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
<script>
var fancyTable = 0;
var product = [];
j8  = jQuery.noConflict();
j8( document ).ready(function( $ ) {
   
});
jQuery( document ).ready(function( $ ) {
  if ($("#form #shopid").val() !== "") {
    $("#shopid").prop("disabled", true)
    product = $.parseJSON('<?php if ( isset($content['product2'])){ echo $content['product2']; }?>');

    setTimeout( function order() {
      productcomponentedit();
      if (fancyTable<1) {
        init()
      }
    }, 1000)
  }
});
 
function productcomponentedit() {
  if (product !== null) {
    for( var i = 0; i<product.length; i++){
      addraw(product[i]['ProductID'], product[i]['ProductCode'], product[i]['ProductName'], product[i]['LinkText']);
    }
  }
}
function addraw(id, code, name, link) {
  if (id != "") {
    $(".productcomponent:first .productid").val(id);
    $(".productcomponent:first .productid2").html(id);
    $(".productcomponent:first .productcode").html(code);
    $(".productcomponent:first .productname").html(name);
    $(".productcomponent:first .linktext").html(link);
    $(".productcomponent:first").clone().appendTo(".table-display-list tbody"); 
    // $(".productcomponent:last").find('input').attr('readonly', true);
  }
}

function init() {
  j8("#table_main").fancyTable({
    inputStyle: 'color:black;',
    // sortColumn:0,
    pagination: true,
    perPage:20,
    // sortable: false,
    // globalSearch:true
  });
  fancyTable +=1
}

var popup_product_list = null;
j8("#open_popup").on('click', function() {
  if (popup_product_list && !popup_product_list.closed) {
     popup_product_list.focus();
  } else {
     popup_product_list = window.open('<?php echo base_url();?>general/product_list_popup', '_blank', 'width=800,height=500,left=200,top=100');     
  }
});	

var curproductlist = []
function buildcurproductlist() {
  curproductlist = []
  par = $(".productcomponent .productid")
  for (var i = 1; i < par.length; i++) {
    curproductlist.push($(par[i]).val())
  }
}

function ProcessChildMessage(message) {
  buildcurproductlist()
  promo = $("#promo").val()
  TOP = $("#TOP").val()
  CBD = $("#CBD").val()
  if (typeof message !== 'undefined' && message.length > 0) {
    for( var i = 0; i<message.length; i++){
      // console.log(message[i]['tdid'])
      if ($.inArray(message[i]['tdid'], curproductlist) < 0) {  //cek jika product exist in list
        if (message[i]['tdid'] !== undefined) {
          addraw(message[i]['tdid'], message[i]['tdcode'], message[i]['tdname'],'');
        }
      }
    }
  }
  if (fancyTable<1) {
    init()
  }
  sortTable()
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
j8("#myInput").on("keyup", function() {
  var value = $(this).val().toLowerCase();
  $("#table_main tbody tr").filter(function() {
    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
  });
});
 
j8('#form').live('submit', function() {
    $(this).find(':disabled').removeAttr('disabled');
});
</script>