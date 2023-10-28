<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/fixedColumns.bootstrap.min.css">

<style type="text/css">
  .rowlist, .rowtext { margin-top: 6px; }
  .divfilterdate {
    display: none; 
    border: 1px solid #0073b7; 
    padding: 4px; 
    overflow: auto;
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

  <div class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row rowtext">
            <div class="col-xs-4">
              <input type="text" class="form-control input-sm atributeid" name="atributeid[]" readonly>
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
        </div>
      </div>
    </div>
  </div>

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
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="2"><i class="fa fa-fw fa-print"></i> Print</button>
        <a title="ADD DELIVERY ORDER RECEIVED" href="<?php echo base_url();?>transaction/detail_to_dor" id="add_dor" class="btn btn-primary btn-xs add_dor"><b>+</b> Add Delivery Order Received</a>
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>

        <div class="divfilterdate">
          <form role="form" action="<?php echo current_url();?>" method="post" >
              <div class="col-md-6">
                <div class="form-group">
                  <label class="left">Search</label>
                  <span class="left2">
                    <div class="input-group input-group-sm">
                        <select class="form-control input-sm atributelist" style="width: 100%;" name="atributelist" required="">
                          <option value="DORID">DOR ID</option>
                          <option value="DORType">DOR Type</option>
                          <option value="DORReff">DOR Reff</option>
                          <option value="ProductID">Product ID</option>
                          <option value="DORDoc">SJ</option>
                          <option value="Company">Company From</option>
                          <option value="Warehouse">Warehouse</option>
                        </select>
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-primary  add_field" onclick="createattribute();">+</button>
                        </span>
                    </div>
                  </span>
                  <label id="atributelabel"></label>
                </div>
              </div>
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
              <div class="col-md-12" style="text-align: center;">
                <button type="submit" class="btn btn-primary">Submit
                </button>
              </div>
          </form>
        </div>
      </div>

      <div class="box-body">
        <table id="dt_list" class="table table-bordered " style="width: 100%;">
          <thead>
            <tr>
              <th class=" alignCenter">DOR ID</th>
              <th class=" alignCenter">DOR Reff</th>
              <th class=" alignCenter">From</th>
              <th class=" alignCenter">To</th>
              <th class=" alignCenter">Employee</th>
              <th class=" alignCenter">SJ Number</th>
              <th class=" alignCenter">Date</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
              if (isset($content)) {
                  foreach ($content as $row => $list) { ?>
                  <tr>
                      <td><?php echo $list['DORID'];?></td>
                      <td><?php echo $list['DORReff'];?></td>
                      <td><?php echo $list['from'];?></td>
                      <td><?php echo $list['to'];?></td>
                      <td><?php echo $list['employee'];?></td>
                      <td><?php echo $list['DORDoc'];?></td>
                      <td><?php echo $list['DORDate'];?></td>
                      <td>
                        <button type="button" class="btn btn-primary btn-xs printdor" dorid="<?php echo $list['DORID'];?>" reff="<?php echo $list['DORReff'];?>" title="PRINT"><i class="fa fa-fw fa-file-text-o"></i></button>
                      </td>
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
	 
  var table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "order": [[ 0, "desc" ]]
  })
  var cek_dt = function() {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
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
  function openPopupOneAtATime(x,y) {
    result = y.split(' ');
    if (popup && !popup.closed) {
       popup.focus();
       popup.location.href = '<?php echo base_url();?>transaction/delivery_order_received_print?dor='+x+'&type='+result[0];
    } else {
       popup = window.open('<?php echo base_url();?>transaction/delivery_order_received_print?dor='+x+'&type='+result[0], '_blank', 'width=800,height=650,left=200,top=20');     
    }
  }
  $(".printdor").live('click', function() {
    dorid = $(this).attr("dorid")
    reff = $(this).attr("reff")
    openPopupOneAtATime(dorid,reff);
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

function createattribute() {
  atributelist = $(".atributelist").val()
  $(".rowtext:first .atributeid").val(atributelist);
  $(".rowtext:first").clone().insertBefore('#atributelabel');
}
</script>
