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

  .table-head td {
    font-size: 12px;
    font-weight: bold;
    padding: 2px 5px !important;
    border: 0px;
  }
</style>

<?php
$main = $content['main'];
// print_r($content['main']);
?>

<div class="content-wrapper" style="margin-left: 0px !important;">
  <section class="content">
    <div class="box box-solid">
      <div class="box-header">
          <div class="col-md-12">
            <table class="table table-responsive table-main table-head">
              <tbody>
                  <tr>
                      <td>Opname ID</td>
                      <td>: <?php echo $main['OpnameID'];?></td>
                      <td>Opname By</td>
                      <td>: <?php echo $main['OpnameBy'];?></td>
                  </tr>
                  <tr>
                      <td>Opname Date</td>
                      <td>: <?php echo $main['OpnameDate'];?></td>
                      <td>Warehouse</td>
                      <td>: <?php echo $main['WarehouseName'];?></td>
                  </tr>
                  <tr>
                      <td>Opname Note</td>
                      <td colspan="3">: <?php echo $main['OpnameNote'];?></td>
                  </tr>
              </tbody>
            </table>
          </div>
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
          <thead>
            <tr>
              <th></th>
              <th>ID</th>
              <th>Code</th>
              <th>Qty Opname</th>
            </tr>
          </thead>
          <tbody>
          <?php
            if (isset($content['detail'])) {
                foreach ($content['detail'] as $row => $list) { ?>
                <tr>
                  <td><a href="#" class="insert_data btn btn-primary btn-xs" WarehouseID="<?php echo $list['WarehouseID'];?>">Submit</a></td>
                  <td><?php echo $list['ProductID'];?></td>
                  <td><?php echo $list['ProductCode'];?></td>
                  <td><?php echo $list['Quantity'];?></td>
                </tr>
          <?php } } ?>
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
    "columnDefs": [
      { "targets": [0], "orderable": false, },
    ],
  })

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
    valueToPush.WarehouseID = $(this).attr("WarehouseID");
    valueToPush.ProductID    = par.find("td:nth-child(2)").html();
    valueToPush.ProductCode  = par.find("td:nth-child(3)").html();
    valueToPush.Quantity = par.find("td:nth-child(4)").html();
    window.opener.ProcessChildMessage(valueToPush);
}); 

</script>