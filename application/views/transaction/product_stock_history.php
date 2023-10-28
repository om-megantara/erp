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
</style>

<?php
$main = $content['main'];
?>

<div class="content-wrapper" style="margin-left: 0px !important;">
  <section class="content">   
    <div class="box box-solid">
      <div class="box-header">
        <div class="box-body">
          <div class="alert alert-info alert-dismissible" style="margin-bottom: 2px;">
            <h4>PRODUCT ID : <?php echo $main[0]['ProductID'];?></h4>
            <h4>PRODUCT NAME : <?php echo $main[0]['ProductCode'];?></h4>
            <h4>PRODUCT CODE : <?php echo $main[0]['ProductName'];?></h4>
            <?php foreach ($main as $row => $list) { ?>
                Stock (<?php echo $list['WarehouseName'];?>) : <?php echo $list['Quantity'];?><br>
            <?php } ?>
          </div>
          <div class="col-xs-3" style="padding-left:0px">
            <a href="#" id="tr-filter" class="btn btn-primary btn-sm tr-filter"><i class="fa fa-search"></i> Filter by Column</a>
          </div>
          <div class="col-xs-9" style="padding-right:0px">
            <div class="form-group" style="margin-bottom: 0px;">
              <div class="input-group input-group-sm ">
                  <select class="form-control WarehouseList"></select>
                  <span class="input-group-btn">
                      <button type="button" class="btn btn-primary " onclick="cek();">CEK</button>
                  </span>
              </div>
            </div>
          </div>  
          
        </div>
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered " style="width: 100%;">
          <thead>
            <tr>
              <th>History</th>
              <th>Date</th>
              <th>No Reff</th>
              <th>Reff</th>
              <th>Warehouse</th>
              <th>Quantity</th>
              <th>Qty Result</th>
              <th>Employee</th>
            </tr>
          </thead>
          <tbody>
            <?php
              if (isset($content['detail'])) {
                  foreach ($content['detail'] as $row => $list) { ?>
                  <tr>
                      <td><?php echo $list['HistoryID'];?></td>
                      <td><?php echo $list['CreatedDate'];?></td>
                      <td><?php echo $list['NoReff'];?></td>
                      <td><?php echo $list['Reff'];?></td>
                      <td><?php echo $list['WarehouseName'];?></td>
                      <td><?php echo $list['Quantity'];?></td>
                      <td><?php echo $list['QuantityAfter'];?></td>
                      <td><?php echo $list['fullname'];?></td>
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
        this.api().columns(4).every( function () {
            var column = this;
            column.data().unique().sort().each( function ( d, j ) {
                $('.WarehouseList').append( '<option value="'+d+'">'+d+'</option>' )
            } );
        } );
    },
  })
  dtable.page('last').draw('page');
  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

  $("#schedule1").datepicker({ 
    "setDate": new Date(), 
    autoclose: true, 
    format: 'yyyy-mm-dd',
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#schedule2').datepicker('setStartDate', minDate);
        var date2 = $('#schedule1').datepicker('getDate');
        $('#schedule2').datepicker('setDate', date2);
  });
  $("#schedule2").datepicker({ 
    "setDate": new Date(), 
    autoclose: true, 
    format: 'yyyy-mm-dd',
    }).on('changeDate', function (selected) {
      var maxDate = new Date(selected.date.valueOf());
      $('#schedule1').datepicker('setEndDate', maxDate);
  });
  $("#input1").datepicker({ 
    "setDate": new Date(), 
    autoclose: true, 
    format: 'yyyy-mm-dd',
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#input2').datepicker('setStartDate', minDate);
        var date2 = $('#input1').datepicker('getDate');
        $('#input2').datepicker('setDate', date2);
  });
  $("#input2").datepicker({ 
    "setDate": new Date(), 
    autoclose: true, 
    format: 'yyyy-mm-dd',
    }).on('changeDate', function (selected) {
      var maxDate = new Date(selected.date.valueOf());
      $('#input1').datepicker('setEndDate', maxDate);
  });
  $(".filterdate").click(function(){
    $(".divfilterdate").slideToggle();
  });

  var popup;
  function openPopupOneAtATime(x, y) {
    result = y.split(' ');
    if (popup && !popup.closed) {
       popup.focus();
       popup.location.href = '<?php echo base_url();?>transaction/delivery_order_print?do='+x+'&type='+result[0];
    } else {
       popup = window.open('<?php echo base_url();?>transaction/delivery_order_print?do='+x+'&type='+result[0], '_blank', 'width=800,height=650,left=200,top=20');     
    }
  }
  $(".printdo").on('click', function() {
    dodet = $(this).attr("dodet")
    reff = $(this).attr("reff")
    openPopupOneAtATime(dodet, reff);
  });
});

function cek() {
  $('#dt_list').dataTable().fnFilter($('.WarehouseList').val());
};
</script>