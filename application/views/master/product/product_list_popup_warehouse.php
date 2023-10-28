<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" type="image/ico" href="<?php echo base_url();?>tool/favicon.ico"/> 
  <title>PRODUCT LIST</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/dist/css/AdminLTE.min.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/dist/css/skins/_all-skins.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/dataTables.checkboxes.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
  <style type="text/css">
  </style>
</head>
<style type="text/css"> 
    /*css datatable*/
    table.dataTable tr:hover { background-color:#71d1eb !important; }
    table.dataTable { width:100% !important; }
    @media (min-width: 950px) {
      /*for DT info on top*/
      .dataTables_wrapper .dataTables_length {
        margin-right: 20px;
        display: inline;
      }
      .dataTables_wrapper .dataTables_info {
        display: inline-block;
      }
      .dataTables_wrapper .dataTables_filter {
        float: right;
      }
      .dataTables_wrapper .dataTables_paginate {
        float: right;
      }
      /*-------------------*/
    }
    .dataTables_filter .btn { margin-bottom: 0px; }
    #dt_list td, #dt_list th, 
    #dt_list2 td, #dt_list2 th, 
    #dt_list3 td, #dt_list3 th { 
      white-space: nowrap; 
      vertical-align: top !important;
    }
    #dt_list tbody td,
    #dt_list2 tbody td,
    #dt_list3 tbody td {
      padding-top: 4px;
      padding-bottom: 4px;
    }
    #dt_list tbody, #dt_list thead, #dt_list tfoot,
    #dt_list2 tbody, #dt_list2 thead, #dt_list2 tfoot,
    #dt_list3 tbody, #dt_list3 thead, #dt_list3 tfoot,
    .dataTables_scrollHeadInner thead,
    .dataTables_scrollFootInner tfoot,
    .DTFC_LeftWrapper tfoot {
      font-size: 12px !important;
    }
    /*------------------------*/
    
  .toggle-vis {
    background-color: #0073b7;
    color: white;
    padding: 1px 3px;
    text-align: center;
    text-decoration: none;
    font-size: 12px;
    font-weight: bold;
    cursor: pointer;
  }
  #divhideshow { display: none; border: 1px solid #0073b7; padding: 5px; margin-top: 3px;}
  #form-filter { display: none; margin-top: 3px; }
  
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
    .form-group { margin-bottom: 10px; }
  }
  .rowlist, .rowtext { margin-top: 6px; }
  .radio { display: inline-block !important; margin-left: 10px; }
  .notActive { background: #999999 !important; }
</style>

<?php
$category = $data['content']['category'];
$brand = $data['content']['brand'];
$atribute = $data['content']['atribute'];
?>

<div class="content-wrapper" style="margin-left: 0px !important;">

  <div class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row rowtext">
            <div class="col-xs-4">
              <input type="hidden" class="form-control input-sm atributeid" name="atributeid[]" readonly>
              <input type="text" class="form-control input-sm atributetype" name="atributetype[]" readonly>
            </div>
            <div class="col-xs-8">
              <div class="input-group input-group-sm">                
                <input type="text" class="form-control input-sm atributevalue" name="atributevalue[]" required="">
                <span class="input-group-btn input-group-atributeConn">
                  <select name="atributeConn[]" class="form-control input-sm atributeConn">
                      <option value="or ">OR</option>
                      <option value="and">AND</option>
                  </select>
                </span>
                <span class="input-group-btn">
                  <button type="button" class="btn btn-primary  add_field" onclick="$(this).closest('.rowtext').remove();">-</button>
                </span>
              </div>
            </div>
          </div>
          <div class="row rowlist">
            <div class="col-xs-4">
              <input type="hidden" class="form-control input-sm atributeid" name="atributeid[]" readonly>
              <input type="text" class="form-control input-sm atributetype" name="atributetype[]" readonly>
            </div>
            <div class="col-xs-8">
              <div class="input-group input-group-sm">
                <select class="form-control input-sm atributevalue" name="atributevalue[]" required>
                  <option value="0">--TOP--</option>
                </select>
                <span class="input-group-btn input-group-atributeConn">
                  <select name="atributeConn[]" class="form-control input-sm atributeConn">
                      <option value="or ">OR</option>
                      <option value="and">AND</option>
                  </select>
                </span>
                <span class="input-group-btn">
                  <button type="button" class="btn btn-primary  add_field" onclick="$(this).closest('.rowlist').remove();">-</button>
                </span>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="box box-solid">
      <div class="box-header">
        <a href="#" id="hideshow" class="btn btn-primary btn-xs hideshow" title="HIDE/SHOW COLUMN">Hide/Show Column</a>
        <a href="#" id="check" class="btn btn-primary btn-xs check" title="SUBMIT DATA">Submit Data</a>
        <a href="#" id="divfilter" class="btn btn-primary btn-xs divfilter" title="FILTER"><i class="fa fa-search"></i> Filter</a>
        <input type="hidden" name="WarehouseID" id="WarehouseID" value="<?php echo $this->input->get_post('id');?>">
        <br>

        <div id="divhideshow">
          Hide/Show Column :
          <!-- <a class="toggle-vis" data-column="2">ID</a>  -->
          <a class="btn btn-primary btn-xs toggle-vis" data-column="3" title="NAME">Product Name</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="4" title="CODE">Product Code</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="5" title="">Stock</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="6" title="">Price</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="7" title="">Category</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="8" title="">Brand</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="9" title="">Quality</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="10" title="">Description</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="11" title="">Status</a>
        </div>

        <form id="form-filter">
          <div class="col-md-12" style="margin-bottom: 10px; border: 1px solid #0073b7; padding: 5px;">
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Stock</label>
                <span class="left2">
                  <div class="radio">
                    <label>
                      <input type="radio" name="stock" value="1">
                      Non Zero
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="stock" value="0" checked="">
                      All
                    </label>
                  </div>
                </span>
              </div>
              <div class="form-group">
                <label class="left">Category</label>
                <span class="left2">
                  <select class="form-control input-sm select2" style="width: 100%;" name="category" id="category" required="">
                    <option value="0">Empty</option>
                    <?php foreach ($category as $row => $list) { ?>
                    <option value="<?php echo $list['ProductCategoryID'];?>"><?php echo $list['ProductCategoryName'] ;?></option>
                    <?php } ?>
                  </select>
                </span>
              </div>
              <div class="form-group">
                <label class="left">Brand</label>
                <span class="left2">
                  <select class="form-control input-sm select2" style="width: 100%;" name="brand" id="brand" required="">
                    <option value="0">Empty</option>
                    <?php foreach ($brand as $row => $list) { ?>
                    <option value="<?php echo $list['ProductBrandID'];?>"><?php echo $list['ProductBrandName'] ;?></option>
                    <?php } ?>
                  </select>
                </span>
              </div>
              <center style="margin-bottom: 5px;">
                <button type="button" id="btn-filter" class="btn btn-primary btn-sm">Filter</button>
              </center>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="left">Atribute List</label>
                <span class="left2">
                  <div class="input-group input-group-sm">
                      <select class="form-control input-sm atributelist" style="width: 100%;" name="atributelist" required="">
                        <option value="ProductID_text">ProductID</option>
                        <?php foreach ($atribute as $row => $list) { ?>
                        <option value="<?php echo $list['ProductAtributeID'].'_'.$list['ProductAtributeType'];?>"><?php echo $list['ProductAtributeName'] ;?></option>
                        <?php } ?>
                      </select>
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-primary  add_field" onclick="createattribute();">+</button>
                      </span>
                  </div>
                </span>
              </div>
              <label id="atributelabel"></label>
            </div>
          </div>
        </form>
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
              <tr>
                <th></th>
                <th>No</th>
                <th>ID</th>
                <th>Name</th>
                <th>Code</th>
                <th>Stock</th>
                <th>Price</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Quality</th>
                <th>Description</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
      </div>
    </div>
  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery11.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.checkboxes.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
var j11 = $.noConflict(true);

j11( document ).ready(function( $ ) {
  $('.select2').select2();
  var rows_selected = []; // for adding checkbox
  var initDataTable = true; // 1
  var table = $('#dt_list')
  .on('preXhr.dt', function ( e, settings, data ) {
    if (settings.jqXHR) settings.jqXHR.abort();
  })
  .DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "order": [],
    "scrollX": true,
     "scrollY": true,
    "aaSorting": [],

    "searchDelay": 1000,
    "processing": true, 
    "language": { processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '}, 
    "serverSide": true, 
    "ajax": {
      "url": "<?php echo site_url('general/product_list_popup_warehouse_data')?>",
      "type": "POST",
      beforeSend: function(){
        // Here, manually add the loading message.
        $('#dt_list > tbody').html(
          '<tr class="odd">' +
            '<td valign="top" class="dataTables_empty" colspan="100%" style="font-size: large;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></td>' +
          '</tr>'
        );
      },
      "data": function ( data ) {
          data.page = "filter_product2";
          data.initDataTable = initDataTable; //3
          data.join = "stock_warehouse";
          data.warehouse = $('#WarehouseID').val();
          data.category = $('#category').val();
          data.brand = $('#brand').val();
          data.stockW = $("input[name='stock']:checked").val();

          data.atributeid = [];
          data.atributevalue = [];
          data.atributeConn = [];
          $("#divsearch .atributeConn").each(function() {
              data.atributeConn.push($(this).val());
          });
          $("#divsearch .atributeid").each(function() {
              data.atributeid.push($(this).val());
          });
          $("#divsearch .atributevalue").each(function() {
              data.atributevalue.push($(this).val());
          });
      },
      complete: function() {
        uncheckAll()
        if (initDataTable === true) {
          $('#dt_list > tbody').html(
            '<tr class="odd">' +
              '<td valign="top" class="dataTables_empty" colspan="100%" style="font-size: large;"><p>do Filter/Search first!!!</p></td>' +
            '</tr>'
          );
          initDataTable = false;
        }
      },
    },
    initComplete : function() {
        var input = $('.dataTables_filter input').unbind(),
            self = this.api(),
            $searchButton = $('<button class="btn btn-flat btn-success ">">')
                       .html('<i class="fa fa-fw fa-search">')
                       .click(function() {
                          self.search(input.val()).draw();
                       }),
            $clearButton = $('<button class="btn btn-flat btn-danger ">')
                       .html('<i class="fa fa-fw fa-remove">')
                       .click(function() {
                          input.val('');
                          $searchButton.click(); 
                       }) 
        $('.dataTables_filter').append($searchButton, $clearButton);
        $('.dataTables_filter input').attr('title', 'press ENTER for apply search');
    },
    'columnDefs': [
       {  
          'targets': 0,
          'checkboxes': { 'selectRow': true }
       }
    ],
    'select': {
       'style': 'multi'
    },
    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {                
        if ( aData[11] == "notActive"){
            jQuery(nRow).addClass('notActive');
        }               
    },
  })
  $(document).on('keydown', '.dataTables_filter input', function(e){ //enter to search
    if (e.keyCode == 13) {
      table.search($(this).val()).draw();
      // $("#btn-filter").trigger("click");
    }
  });

  function uncheckAll() {
    table.columns().checkboxes.deselectAll()
  }
  // Handle form submission event
  $('#check').on('click', function(e){
    var rows_selected = table.column(0).checkboxes.selected();
    var rows_selected2 = []
    $.each(rows_selected, function(index, rowId){
      rowId = rowId - 1
      if (index <= (rows_selected.length)) {
        var valueCurrent = [] 
        valueCurrent.ProductID = table.cell( rowId, 2 ).data();
        valueCurrent.ProductCode = table.cell( rowId, 4 ).data();
        valueCurrent.ProductName = table.cell( rowId, 3 ).data();
        valueCurrent.Quantity = table.cell( rowId, 5 ).data();
        rows_selected2.push(valueCurrent);
      }
    });
    console.log(rows_selected2)

    // send to parent
    window.opener.ProcessChildMessage(rows_selected2);
    // window.close()
  });

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

  $('a.toggle-vis').on( 'click', function (e) {
      e.preventDefault();
      var column = table.column( $(this).attr('data-column') );
      column.visible( ! column.visible() );
      table.columns.adjust().draw();
  } );

  $("#divfilter").click(function(){
    $("#form-filter").slideToggle();
  });
  $('#btn-filter').click(function(){ //button filter event click
      table.ajax.reload();  //just reload table
  });
  $('#btn-reset').click(function(){ //button reset event click
      $('#form-filter')[0].reset();
      table.ajax.reload();  //just reload table
  });

  setTimeout( function order() {
    $('a[data-column="3"]').click();
    // $('a[data-column="4"]').click();
    // $('a[data-column="5"]').click();
    $('a[data-column="6"]').click();
    // $('a[data-column="7"]').click();
    // $('a[data-column="8"]').click();
    $('a[data-column="9"]').click();
    $('a[data-column="10"]').click();
    $('a[data-column="11"]').click();
  }, 100) //force to order and fix header width
});
</script>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script>
$("#hideshow").click(function(){
  $("#divhideshow").slideToggle();
});
function createattribute() {
  atributelist = $(".atributelist").val().split("_")
  atributename = $(".atributelist option:selected").text()
  if (atributelist[1] === "text") {
      $(".rowtext:first .atributeid").val(atributelist[0]);
      $(".rowtext:first .atributetype").val(atributename);
      $(".rowtext:first").clone().insertBefore('#atributelabel');
  } else {
      $.ajax({
        url: "<?php echo base_url();?>general/get_atribute_detail",
        type : 'GET',
        data : 'id=' + atributelist[0],
        dataType : 'json',
        success : function (response) {
              $(".rowlist:first .atributeid").val(response['ProductAtributeID']);
              $(".rowlist:first .atributetype").val(response['ProductAtributeName']);
              valuecode = response['valuecode'].split(",");
              valuename = response['valuename'].split(",");
              $(".rowlist:first .atributevalue").empty();
              
              var codelen = valuename.length;
              for( var x = 0; x<codelen; x++){
                $(".rowlist:first .atributevalue").append("<option value='"+valuecode[x]+"'>"+valuename[x]+"</option>");
              }
              $(".rowlist:first").clone().insertBefore('#atributelabel'); 
        }
      })
  }
}
</script>