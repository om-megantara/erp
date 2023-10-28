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
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
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

  .notActive { background: #999999 !important; }
</style>

<?php
// print_r($content['fullbrand']);
?>

<div class="content-wrapper" style="margin-left: 0px !important;">
  <section class="content">
    <div class="box box-solid">
      <div class="box-header">
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
          <thead>
            <tr>
              <th></th>
              <th>ID</th>
              <th>Name</th>
              <th>Code</th>
              <th>Stock</th>
              <th>Quality</th>
              <th>Category</th>
              <th>Brand</th>
              <th>Price</th>
              <th>HPP</th>
              <th>Supplier</th>
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
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
var j11 = $.noConflict(true);
j11( document ).ready(function( $ ) {
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
    {"targets": 2, "width": "1%"},
    ],
    // "aaSorting": [],
    "order":[],
    "searchDelay": 2000,
    "processing": true, 
    "language": { processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '}, 
    "serverSide": true, 
    "ajax": {
      "url": "<?php echo site_url('master/product_list_popup3_hpp_data')?>",
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
          data.page = "nothing";
          data.initDataTable = initDataTable; //3
          // data.fullname = $('#fullname').val();
          // data.Company = $('#Company').val();
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
$('.insert_data').live('click', function(e){
  var
    valueToPush = { }
    par         = $(this).parent().parent();
    valueToPush.stockable = $(this).attr("stockable");
    valueToPush.forsale = $(this).attr("forsale");
    valueToPush.tdid    = par.find("td:nth-child(2)").html();
    valueToPush.tdname  = par.find("td:nth-child(3)").html();
    valueToPush.tdcode  = par.find("td:nth-child(4)").html();
    valueToPush.tdstock = par.find("td:nth-child(5)").html();
    valueToPush.tdhpp = par.find("td:nth-child(10)").html();
    valueToPush.tdsupplier = par.find("td:nth-child(11)").html();
    window.opener.ProcessChildMessage(valueToPush);
}); 

</script>