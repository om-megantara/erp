<link rel="stylesheet" href="<?php echo base_url();?>tool/jstree/dist/themes/default/style.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<style type="text/css">  
  .divfilterdate {
    display: none; 
    margin: 5px 0px;
    border: 1px solid #0073b7; 
    padding: 4px;
    overflow: auto;
  }
  tr.bold td { font-weight: bold; }
  .px-1 { padding-left: calc(1*7px) !important; }
  .px-2 { padding-left: calc(2*7px) !important; }
  .px-3 { padding-left: calc(3*7px) !important; }
  .px-4 { padding-left: calc(4*7px) !important; }
  .px-5 { padding-left: calc(5*7px) !important; }
  .px-6 { padding-left: calc(6*7px) !important; }
  .px-7 { padding-left: calc(7*7px) !important; }
  .px-8 { padding-left: calc(8*7px) !important; }
  .px-9 { padding-left: calc(9*7px) !important; }
  @media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 130px;
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
                <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="0"><i class="fa fa-fw fa-print"></i> Print</button>
 
                <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>
                <div class="divfilterdate">
                  <form role="form" action="<?php echo current_url();?>" method="post" >
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="left">Month</label>
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control input-sm" autocomplete="off" name="datestart" id="datestart" required="">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <button type="submit" class="btn btn-primary btn-sm pull-center">Submit</button>
                    </div>
                  </form>
                </div>
            </div>
            <div class="box-body">
              <table id="dt_list" class="table table-bordered " style="width: 100% !important;">
                <thead>
                  <tr>
                    <th class="alignCenter">Account Name</th>
                    <th class="alignCenter">Account Amount</th>
                  </tr> 
                </thead>
                <tbody>
                <?php
                  // echo count($content);
                  if (isset($content)) {
                      foreach ($content as $row => $list) { 
                        // $AmountCredit = ($list['AccountType'] == 'credit') ? $list['AccountAmount3'] : 0 ;
                        // $AmountDebit = ($list['AccountType'] == 'debit') ? $list['AccountAmount3'] : 0 ;
                        // $AmountCrediTotal = ($list['AccountType'] == 'credit') ? $list['AccountAmount2'] : 0 ;
                        // $AmountDebitTotal = ($list['AccountType'] == 'debit') ? $list['AccountAmount2'] : 0 ;
                ?>
                <?php if ($list['ChildCount']>1) { ?>
                      <tr class="bold">
                <?php } else { ?>
                      <tr>
                <?php } ?>
                        <td class="alignleft px-<?php echo $list['Spacing']; ?>">
                          <?php echo $list['AccountCode'].' - '.$list['AccountName'];?>
                        </td>
                        <!-- 
                        <td class="alignRight"><?php echo number_format($AmountDebit,2);?></td>
                        <td class="alignRight"><?php echo number_format($AmountCredit,2);?></td>
                        <td class="alignRight"><?php echo number_format($AmountDebitTotal,2);?></td>
                        <td class="alignRight"><?php echo number_format($AmountCrediTotal,2);?></td>
                         -->
                        <td class="alignRight"><?php echo number_format($list['AccountAmount4'],2);?></td>
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
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
jQuery(function($) {

  var table = $('#dt_list').DataTable({
    "searching" : false,
    "paging" : false,
    "ordering" : false,
    "info" : false,
    "columnDefs": [
        {"targets": 1, "width": "10%"},
        // {"targets": 2, "width": "10%"},
        // {"targets": 3, "width": "10%"},
        // {"targets": 4, "width": "10%"},
    ],
    "footerCallback": function ( row, data, start, end, display ) {
        // var api = this.api(), data;

        // // Remove the formatting to get integer data for summation
        // var intVal = function ( i ) {
        //     return typeof i === 'string' ?
        //         i.replace(/[\$,]/g, '')*1 :
        //         typeof i === 'number' ?
        //             i : 0;
        // };

        // // Total over all pages
        // total1 = api
        //     .column( 1 )
        //     .data()
        //     .reduce( function (a, b) {
        //         return intVal(a) + intVal(b);
        //     }, 0 );
        // total2 = api
        //     .column( 2 )
        //     .data()
        //     .reduce( function (a, b) {
        //         return intVal(a) + intVal(b);
        //     }, 0 ); 

        // // Total over this page
        // pageTotal1 = api
        //     .column( 1, { page: 'current'} )
        //     .data()
        //     .reduce( function (a, b) {
        //         return intVal(a) + intVal(b);
        //     }, 0 );
        // pageTotal2 = api
        //     .column( 2, { page: 'current'} )
        //     .data()
        //     .reduce( function (a, b) {
        //         return intVal(a) + intVal(b);
        //     }, 0 ); 

        // // Update footer
        // $( api.column( 1 ).footer() ).html(
        //     pageTotal1.toLocaleString(undefined, {minimumFractionDigits: 2})  
        // );
        // $( api.column( 2 ).footer() ).html(
        //     pageTotal2.toLocaleString(undefined, {minimumFractionDigits: 2})  
        // ); 
 
    }
  })
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
         '</tbody>'+
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

  $("#datestart").datepicker({ 
    format: "yyyy-mm-dd",
    viewMode: "months", 
    minViewMode: "months"
  }).on('changeDate', function (selected) {
    var minDate = new Date(selected.date.valueOf());
    $('#dateend').datepicker('setStartDate', minDate);
  });
  $(".filterdate").click(function(){
    $(".divfilterdate").slideToggle();
  });
}); 
</script>