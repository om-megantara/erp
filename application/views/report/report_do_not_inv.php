<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">
 
<style type="text/css"> 
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
      </div>
      <div class="box-body">
        <table id="dt_list" class="table table-bordered " style="width: 100%;">
          <thead>
            <tr>
              <th>DO ID</th>
              <th>DO Reff</th>
              <th>Company Name</th>
              <th>Sales Name</th>
              <th>SEC</th>
              <th>Warehouse</th>
              <th>Delivery Date</th>
              <th>Employee Name</th>
              <th>DO Quantity</th>
              <th>Price Amount</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
              if (isset($content['main'])) {
                  foreach ($content['main'] as $row => $list) { 
                    $so = strpos($list['Reff'], "SO");
            ?>
                  <tr>
                      <td><?php echo $list['DOID'];?></td>
                      <td><?php echo $list['Reff'];?></td>
                      <td><?php echo $list['Company'];?></td>
                      <td><?php echo $list['Sales'];?></td>
                      <td><?php echo $list['SEC'];?></td>
                      <td><?php echo $list['WarehouseName'];?></td>
                      <td><?php echo $list['DODate'];?></td>
                      <td><?php echo $list['Employee'];?></td>
                      <td class="alignRight"><?php echo $list['DOQty'];?></td>
                      <td class="alignRight"><?php echo number_format($list['PriceAmount'],2);?></td> 
                      <td>
                        <button type="button" class="btn btn-primary btn-xs printdo" dodet="<?php echo $list['DOID'];?>" reff="<?php echo $list['Reff'];?>" title="PRINT"><i class="fa fa-fw fa-file-text-o"></i></button>
                        <button type="button" class="btn btn-primary btn-xs printdo2" dodet="<?php echo $list['DOID'];?>" reff="<?php echo $list['Reff'];?>" title="PRINT"><i class="fa fa-fw fa-file-text-o"></i></button>
                      </td>
                  </tr>
            <?php } } ?>
          </tbody>
          <tfoot>
              <tr>
                  <th colspan="8">
                    Total Current Page:<br>
                    Total All Page:<br>
                  </th>
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
        total8 = api
            .column( 8 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        total9 = api
            .column( 9 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Total over this page
        pageTotal8 = api
            .column( 8, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        pageTotal9 = api
            .column( 9, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

    //     // Update footer
        $( api.column( 8 ).footer() ).html(
            pageTotal8.toLocaleString(undefined, {minimumFractionDigits: 2}) +
            '<br>'+ total8.toLocaleString(undefined, {minimumFractionDigits: 2})
        );
        $( api.column( 9 ).footer() ).html(
            pageTotal9.toLocaleString(undefined, {minimumFractionDigits: 2}) +
            '<br>'+ total9.toLocaleString(undefined, {minimumFractionDigits: 2})
        );
    }
  })

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);

  var popup;
  function openPopupOneAtATime(x, y, z) {
    result = y.split(' ');
    if (z == 'general') {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>general/delivery_order_print?do='+x+'&type='+result[0];
      } else {
         popup = window.open('<?php echo base_url();?>general/delivery_order_print?do='+x+'&type='+result[0], '_blank', 'width=800,height=650,left=200,top=20');     
      }
    } else if (z=='special') {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>general/delivery_order_print2?do='+x+'&type='+result[0];
      } else {
         popup = window.open('<?php echo base_url();?>general/delivery_order_print2?do='+x+'&type='+result[0], '_blank', 'width=800,height=650,left=200,top=20');     
      }
    }
  }
  function openPopupOneAtATime2(x) {
      if (popup && !popup.closed) {
         popup.focus();
         popup.location.href = '<?php echo base_url();?>general/'+x;
      } else {
         popup = window.open('<?php echo base_url();?>general/'+x, '_blank', 'width=780,height=500,left=200,top=100');     
      }
  }
  $(".printdo").live('click', function() {
    dodet = $(this).attr("dodet")
    reff = $(this).attr("reff")
    openPopupOneAtATime(dodet, reff, 'general');
  });
  $(".printdo2").live('click', function() {
    dodet = $(this).attr("dodet")
    reff = $(this).attr("reff")
    openPopupOneAtATime(dodet, reff, 'special');
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