<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" type="image/ico" href="<?php echo base_url();?>tool/favicon.ico"/> 
  <title>CUSTOMER LIST</title>
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
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
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
  tfoot input {
    width: 100%;
    font-size: 12px !important;
    padding: 3px;
    box-sizing: border-box;
  }
  #divhideshow { display: none; margin-left: 10px; border: 1px solid #0073b7; padding: 5px;}
  #form-filter {
    border: 1px solid #0073b7; 
    padding: 4px;
    padding-top: 20px; 
    display: none;
  }
</style>
<?php
// print_r($content['fullbrand']);
?>
<div class="content-wrapper">
  <section class="content">
    <div class="box box-solid">
      <div class="box-header">
        <!-- <a href="#" id="hideshow" class="hideshow">Hide/Show column</a> -->
        <!-- <a href="#" id="check" class="check">Submit Data</a> -->
        <a href="#" id="divfilter" class="btn btn-primary btn-xs divfilter"><b>+</b> Filter By Column</a>
        <div id="divhideshow">
          Hide/Show column :
          <a class="btn btn-primary btn-xs toggle-vis" data-column="1">ID</a> 
          <a class="btn btn-primary btn-xs toggle-vis" data-column="2">Name</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="3">Code</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="4">Price</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="5">Quality</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="6">Category</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="7">Brand</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="8">Documentation</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="9">Min Stock</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="10">Max Stock</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="11">Full Brand</a>
          <a class="btn btn-primary btn-xs toggle-vis" data-column="12">Full Category</a>
        </div>

        <form id="form-filter" class="form-horizontal">
            <div class="form-group">
                <label for="fullname" class="col-sm-2 control-label">fullname</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="fullname">
                </div>
            </div>
            <div class="form-group">
                <label for="Company" class="col-sm-2 control-label">Company</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="Company">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-4">
                    <button type="button" id="btn-filter" class="btn btn-primary">Filter</button>
                    <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
                </div>
            </div>
        </form>
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
          <thead>
            <tr>
              <th></th>
              <th id="order">ID</th>
              <th>Name</th>
              <th>Company</th>
              <th>Category</th>
            </tr>
          </thead>
          <tbody>
          </tbody>

        </table>
      </div>
    </div>
  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery11.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
var j11 = $.noConflict(true);
j11( document ).ready(function( $ ) {
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
    "columnDefs": [ 
    {"targets": 1, "width": "1%"},
    
    ],
    // "aaSorting": [],
    "searchDelay": 1000,
    "processing": true, 
    "language": { processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '}, 
    "serverSide": true, 
    "ajax": {
      "url": "<?php echo site_url('finance/customer_list_popup2_data')?>",
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
          data.page = "filter_customer";
          data.initDataTable = initDataTable; //3
          data.fullname = $('#fullname').val();
          data.Company = $('#Company').val();
      },
      complete: function() {
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
    "columnDefs": [
      { "targets": [0], "orderable": false, },
    ],

  })

  $('#btn-filter').click(function(){ //button filter event click
      table.ajax.reload();  //just reload table
  });
  $('#btn-reset').click(function(){ //button reset event click
      $('#form-filter')[0].reset();
      table.ajax.reload();  //just reload table
  });
  $(document).on('keydown', '.dataTables_filter input', function(e){ //enter to search
    if (e.keyCode == 13) {
      table.search($(this).val()).draw();
      // $("#btn-filter").trigger("click");
    }
  });

  $('a.toggle-vis').on( 'click', function (e) {
      e.preventDefault();
      var column = table.column( $(this).attr('data-column') );
      column.visible( ! column.visible() );
      table.columns.adjust().draw();
  } );

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

});

</script>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script>
$("#hideshow").click(function(){
  $("#divhideshow").slideToggle();
});
$("#divfilter").click(function(){
  $("#form-filter").slideToggle();
});
$('.insert_data').live('click',function(e){
  var
    valueToPush = { }
    par         = $(this).parent().parent();
    valueToPush.tdid    = par.find("td:nth-child(2)").html();
    valueToPush.tdname  = par.find("td:nth-child(3)").html();
    window.opener.ProcessChildMessage(valueToPush);
});
</script>