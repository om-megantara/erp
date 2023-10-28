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

  .divfilterdate {
    display: none; 
    border: 1px solid #0073b7; 
    padding: 4px; 
    margin: 5px 0px;
  }
  .alert-dismissible h4 {
    margin-bottom: 5px !important;
  }
  .tr-filter-column { display: none; }
  .input-filter-column { width: 100%; }
  td.note {
    min-width: 250px !important;
    white-space: normal !important;
  }
</style>

<?php
$main1 = $content['main1'];
if (isset($content['detail'])){
  $main = $content['detail'];
}

?>

<div class="content-wrapper" style="margin-left: 0px !important;min-height: 600px !important;">
  <section class="content">   
    <div class="box box-solid">
      <div class="box-header">
        <div class="box-body">
          <div class="alert alert-info alert-dismissible" style="margin-bottom: 2px;">
            <h4>PRODUCT ID : <?php echo $main1[0]['ProductID'];?></h4>
            <h4>PRODUCT NAME : <?php echo $main1[0]['ProductName'];?></h4>
            <h4>PRODUCT CODE : <?php echo $main1[0]['ProductCode'];?></h4>
            <h4>WAREHOUSE : </h4>
            <?php
              if(isset($main1)) {
                foreach ($main1 as $row) { ?>
                  Stock (<?php echo $row['WarehouseName'];?>) : <?php echo $row['Stock'];?><br>
            <?php }
              } ?>
          </div>
          <div class="col-xs-3" style="padding-left:0px">
          </div>
        </div>
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered text-wrap" style="width: 100%;">
          <thead>
            <tr>
              <th>No</th>
              <th>Date</th>
              <th>ProductID</th>
              <th>ProductName</th>
              <th>Warehouse</th>
              <th>SA</th>
              <th>Stock</th>
            </tr>
          </thead>
          <tbody>
            <?php
              if (isset($main)) {
                $no=0;
                  foreach ($main as $list) {$no++; ?>
                  <tr>
                      <td><?php echo $no;?></td>
                      <td><?php echo $list['CheckDate'];?></td>
                      <td><?php echo $list['ProductID'];?></td>
                      <td class="note"><?php echo $list['ProductName'];?></td>
                      <td><?php echo $list['WarehouseName'];?></td>
                      <td><?php echo $list['Sab'];?></td>
                      <td><?php echo $list['Quantity'];?></td>
                  </tr>
            <?php } } ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
jQuery( document ).ready(function( $ ) {

  th_filter_hidden = [0,1,5,6,7]
  $('#dt_list thead tr').clone(true).appendTo( '#dt_list thead' );
  $('#dt_list thead tr:eq(0)').addClass('tr-filter-column')
  $('#dt_list thead tr:eq(0) th').each( function (i) {
    if (th_filter_hidden.indexOf(i) < 0) {
      var title = $(this).text();
      $(this).html( '<input type="text" class="input-filter-column input input-sm" placeholder="Search '+title+'" />' );

      $( 'input', this ).on( 'keyup change', function () {
          if ( dtable.column(i).search() !== this.value ) {
              dtable
                  .column(i)
                  .search( this.value )
                  .draw();
          }
      });
    } else {
      $(this).text('')
    }
  });
  $(".tr-filter").click(function(){
    $(".tr-filter-column").slideToggle().focus();
  });
	 
  dtable = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    // "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "order":[],
    initComplete: function () {
        this.api().columns(5).every( function () {
            var column = this;
            column.data().unique().sort().each( function ( d, j ) {
                $('.WarehouseList').append( '<option value="'+d+'">'+d+'</option>' )
            } );
        } );
    },
  })
  table.page('last').draw('page');
  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

</script>