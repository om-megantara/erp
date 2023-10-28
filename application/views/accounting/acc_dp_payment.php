<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">

<style type="text/css">
  /*css fixed column*/
  .DTFC_LeftWrapper thead th, .DTFC_RightWrapper thead th,
  .DTFC_LeftWrapper tbody td, .DTFC_RightWrapper tbody td {
    font-size: 12px !important;
  }
  .DTFC_LeftWrapper tbody td, .DTFC_RightWrapper tbody td {
    padding: 4px !important;
    vertical-align: text-top;
    height: 28px;
  }
  /*.DTFC_LeftBodyLiner{overflow-y:unset !important}*/
  /*.DTFC_RightBodyLiner{overflow-y:unset !important}*/
  /*---------------------*/

  .divfilterdate { 
    margin: 5px 0px;
    display: none; 
    border: 1px solid #0073b7; 
    padding: 5px;
    overflow: auto;
  }

@media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 80px;
      padding: 5px 15px 5px 5px;
    }
    .form-group { margin-bottom: 10px; }
}
</style>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      <?php echo $PageTitle.' - '. $MainTitle; ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-fw fa-info-circle" title="HELP"></i>Help</a></li>
    </ol>
  </section>

  <section class="content">
    <div class="box box-solid">
      <div class="box-header">
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT"><i class="fa fa-fw fa-print"></i> Print</button>
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>
        <br>
        <div class="divfilterdate">
              <form role="form" action="<?php echo current_url();?>" method="post" >
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="left">START</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control input-sm" autocomplete="off" name="filterstart" id="filterstart">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="left">END</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control input-sm" autocomplete="off" name="filterend" id="filterend">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <button type="submit" class="btn btn-primary pull-center">Submit</button>
                  </div> 
              </form>
        </div>
      </div>
      
      <div class="box-body">
        <table id="dt_list" class="table table-bordered " style="width: 100% !important;">
          <thead>
            <tr>
              <th class=" alignCenter">Deposit ID</th>
              <th class=" alignCenter">Company Name</th>
              <th class=" alignCenter">Deposit</th>
              <th class=" alignCenter">Reff</th>
              <th class=" alignCenter">Payment</th>
              <th class=" alignCenter">Date</th>
            </tr>
          </thead>
          <tbody>
          <?php
            if (isset($content['main'])) {
                foreach ($content['main'] as $row => $list) { ?>
                <tr>
                  <td class="alignCenter"><?php echo $list['DepositID'];?></td>
                  <td><?php echo $list['Company2'];?></td>
                  <td class="alignRight"><?php echo number_format($list['DepositAmount'],2);?></td>
                  <td><?php echo $list['reff'];?></td>
                  <td class="alignRight"><?php echo number_format($list['Amount'],2);?></td>
                  <td><?php echo $list['Date'];?></td>
                </tr>
          <?php } } ?>
          </tbody>
          <tfoot>
              <tr>
                  <th colspan="2">
                    Total Current Page:<br>
                    Total All Page:<br>
                  </th>
                  <th class="alignRight"></th>
                  <th class="alignRight"></th>
                  <th class="alignRight"></th>
                  <th></th>
              </tr>
          </tfoot>
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
   

  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
    "order": [[ 0, "asc" ]],
    "scrollX": true,
     "scrollY": true,
    "scrollCollapse": true,
    "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };

        // Total over all pages
        total2 = api
            .column( 2 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        total4 = api
            .column( 4 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 ); 

        // Total over this page
        pageTotal2 = api
            .column( 2, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        pageTotal4 = api
            .column( 4, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 ); 

        // Update footer
        $( api.column( 2 ).footer() ).html(
            pageTotal2.toLocaleString(undefined, {minimumFractionDigits: 2}) +
            '<br>'+ total2.toLocaleString(undefined, {minimumFractionDigits: 2})
        );
        $( api.column( 4 ).footer() ).html(
            pageTotal4.toLocaleString(undefined, {minimumFractionDigits: 2}) +
            '<br>'+ total4.toLocaleString(undefined, {minimumFractionDigits: 2})
        );
    }
  })

  var cek_dt = function() {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

  $("#filterstart").datepicker({ 
    "setDate": new Date(), 
    autoclose: true, 
    format: 'yyyy-mm-dd',
    todayBtn:  1,
  }).on('changeDate', function (selected) {
    var minDate = new Date(selected.date.valueOf());
    $('#filterend').datepicker('setStartDate', minDate);
  });
  $("#filterend").datepicker({ 
    "setDate": new Date(), 
    autoclose: true, 
    format: 'yyyy-mm-dd',
  }).on('changeDate', function (selected) {
    var maxDate = new Date(selected.date.valueOf());
    $('#filterstart').datepicker('setEndDate', maxDate);
  });
  $(".filterdate").click(function(){
    $(".divfilterdate").slideToggle();
  });
  $('button.print_dt').on('click', function() {               
      var fvData = table.rows({ search:'applied', page: 'all' }).data(); 
      $('.div_dt_print').empty().append(
         '<table id="dtTablePrint" class="col">' +
         '<thead>'+
         '<tr>'+
            $.map(table.columns().visible(),
                function(colvisible, colindex){
                   return (colvisible) ? "<th>" + $(table.column(colindex).header()).html() + "</th>" : null;
             }).join("") +
         '</tr>'+
         '</thead>'+
         '<tbody>' +
            $.map(fvData, function(rowdata, rowindex){
               return "<tr>" + $.map(table.columns().visible(),
                  function(colvisible, colindex){
                     return (colvisible) ? "<td class='col"+colindex+"'>" + $('<div/>').text(rowdata[colindex]).text() + "</td>" : null;
                  }).join("") + "</tr>";
            }).join("") +
         '</tbody>' +
         '<tfoot>' +
         '<tr>'+
            $.map(table.columns().visible(),
                function(colvisible, colindex){
                   return (colvisible) ? "<th>" + $(table.column(colindex).footer()).html() + "</th>" : null;
             }).join("") +
         '</tr>'+
         '</tfoot></table>'
      );

      for (var i = 0; i < $('button.print_dt').attr('removeTd'); i++) {
        $("#dtTablePrint th:last-child, #dtTablePrint td:last-child").remove();
      }

      var w = window.open();
      var html = $(".div_dt_print").html();
      $(w.document.body).append('<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">');
      $(w.document.body).append("<link href='<?php echo base_url();?>tool/dtPrint.css' rel='stylesheet' type='text/css' />");
      $(w.document.body).append(html);
  });

});
</script>