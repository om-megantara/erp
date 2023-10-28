<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">
 
<style type="text/css"> 
  .divfilterdate {
    display: none; 
    border: 1px solid #0073b7; 
    padding: 4px; 
    margin: 5px 0px;
  }
  .martop-4 { margin-top: 4px; }
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
      .form-group { margin-bottom: 5px; }
  }
</style>

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <?php echo $PageTitle.' - '. $MainTitle; ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
  </section>

  <section class="content">
    <div class="box box-solid">
      <div class="box-header">
          <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="1"><i class="fa fa-fw fa-print"></i> Print</button>
          <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>

          <div class="divfilterdate">
            <form role="form" action="<?php echo base_url();?>report/report_do_fc" method="post" >
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="left">Date Start</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                          <i class="fa fa-calendar">
                          </i>
                        </div>
                        <input type="text" class="form-control input-sm" autocomplete="off" name="input1" id="input1">
                    </div>
                  </div>
                  <div class="form-group">
                      <label class="left">Date End</label>
                      <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar">
                            </i>
                          </div>
                          <input type="text" class="form-control input-sm" autocomplete="off" name="input2" id="input2">
                      </div>
                  </div>

                </div>
                <div class="col-md-6">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
          </div>
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered " style="width: 100%;">
          <thead>
            <tr>
              <th>DO ID</th>
              <th>Company Name</th>
              <th>FC Doc</th>
              <th>Date</th>
              <th>Amount</th>
              <th>Bank Dist.</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
              if (isset($content['main'])) {
                  foreach ($content['main'] as $row => $list) { 
            ?>
                  <tr>
                      <td><?php echo $list['DOID'];?></td>
                      <td><?php echo $list['Company'];?></td>
                      <td><?php echo $list['Doc'];?></td>
                      <td><?php echo $list['Date'];?></td>
                      <td class="alignRight"><?php echo number_format($list['Amount'],2);?></td>
                      <td><?php echo $list['DistributionID'];?></td>
                      <td>
                        <button type="button" class="btn btn-success btn-xs reportfc" title="Report FreightCharge" reff="do_fc_report?do=<?php echo $list['DOID'];?>"><i class="fa fa-fw fa-print"></i></button>
                      </td>
                  </tr>
            <?php } } ?>
          </tbody>
          <tfoot>
              <tr>
                  <th colspan="4">
                    Total Current Pag4e:<br>
                    Total All Page:<br>
                  </th>
                  <th class="alignRight"></th>
                  <th colspan="2"></th>
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
     
    "scrollX": true,
     "scrollY": true,
    "order": [[ 0, "desc" ]],
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
        total4 = api
            .column( 4 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Total over this page
        pageTotal4 = api
            .column( 4, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Update footer
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
  function openPopupOneAtATime2(x) {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>transaction/'+x;
      } else {
         popup = window.open('<?php echo base_url();?>transaction/'+x, '_blank', 'width=780,height=500,left=200,top=100');     
      }
  }
  $(".reportfc").live('click', function() {
    reff = $(this).attr("reff")
    openPopupOneAtATime2(reff);
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