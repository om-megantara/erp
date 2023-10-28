<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">
  .form-addAssignment {
    display: none;
    border: 1px solid #3c8dbc;
    margin-top: 5px;
  }
  .ui-autocomplete {
    z-index: 5;
    float: left;
    display: none;
    min-width: 160px;   
    padding: 4px 0;
    margin: 2px 0 10px 10px;
    list-style: none;
    background-color: #ffffff;
    border-color: #ccc;
    border-style: solid;
    border-width: 1px;
    max-height: 200px; 
    overflow-y: scroll; 
    overflow-x: hidden;
  }
  @media (min-width: 768px){
    .form-group label.left {
      float: left;
      width: 150px;
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
      <div class="box-header with-border">
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT"><i class="fa fa-fw fa-print"></i>Print</button>
        <a href="#" id="addAssignment" class="addAssignment btn btn-primary btn-xs" title="Add Asset Assignment"><b>+</b> Add Asset Assignment</a>
        <div class="col-md-12 form-addAssignment with-border">
          <form role="form" action="<?php echo base_url();?>hrd/asset_assignment_add" method="post" >
            <div class="box box-solid ">
              <div class="box-header">
                <h3 class="box-title">Asset Assignment Name&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;<?php echo $content['assetnya']['AssetName']; ?></h3>
                <button type="submit" class="btn btn-primary pull-right">Submit</button>
              </div>
              <div class="box-body">
                <input type="hidden" name="assetid" value="<?php echo $content['assetnya']['AssetID'];?>">
                <div class="col-md-6">
                    <div class="form-group">
                      <label class="left">Date In</label>
                      <span class="left2">
                      <div class="input-group date">
                        <div class="input-group-addon">
                         <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control input-sm pull-right" id="dateind" name="dateind" placeholder="Date In" autocomplete="off">
                      </div>
                      </span>
                    </div>
                    <div class="form-group">
                      <label class="left">Status In</label>
                      <span class="left2">
                      <select class="form-control input-sm" name="statusin" id="statusin">
                        <option value="Good">Good</option>
                        <option value="Not Good">Not Good</option>
                        <option value="Lost">Lost</option>
                        <option value="New">New</option>
                        <option value="Broke">Broken</option>   
                        <option value="Sold">Sold</option>   
                      </select>
                      </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label class="left">Employee Name <B>*</B> </label>
                      <span class="left2">
                        <div class="form-group form-group-sm employeename">
                          <select class="form-control input-sm employeenamechild select2" name="employeename[]">
                            <?php
                            foreach ($content['employeeasset'] as $row => $listemployeename) {?>
                              <option value='<?php echo $listemployeename['EmployeeID'];?>'><?php echo $listemployeename['Fullname'];?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </span>
                    </div>
                    <div class="form-group">
                      <label class="left">Note</label>
                      <span class="left2">
                        <div class="input-group date">
                          <div class="input-group-addon">
                          <i class="fa fa-sticky-note"></i>
                          </div>
                          <textarea class="form-control input-sm" id="note" name="note" placeholder="Note" autocomplete="off"></textarea>
                        </div>
                      </span>
                    </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
            <tr>
              <th>ID</th>
              <th>Asset Name</th>
              <th>Employee</th>
              <th>Status In</th>
              <th>Status Out</th>
              <th>Date In</th>
              <th>Date Out</th>
              <th>Note</th>
			        <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
                $c='1';
                foreach ($content['assign'] as $row => $list) {
                ?>
                   <tr>
                    <td><?php echo $list['AssetID'];?></td>
                    <td><?php echo $list['AssetName'];?></td>
                    <td><?php echo $list['Fullname'];?></td>
                    <td><?php echo $list['StatusIn'];?></td>
                    <td><?php echo $list['StatusOut'];?></td>
                    <td><?php echo $list['DateInD'];?></td>
                    <td><?php echo $list['DateOut'];?></td>
					          <td><?php echo $list['Note'];?></td>
                    <td><a href="#" class="btn btn-success btn-xs" id="printAssetTransfer" assetid="<?php echo $list['AssetDetailID'];?>"><i class="fa fa-fw fa-print" title="print"></i></a></td>
                  </tr>
            <?php } ?>
        
            </tbody>
          </table>
      </div>
      <div class="box-footer">
      </div>
    </div>
  </section>
</div>

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/jquery-ui.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
  $('.select2').select2()
	 
	$("#dateind").datepicker({ 
    autoclose: true, 
    format: 'yyyy-mm-dd',
    todayBtn: 'linked',
  });
	fill_employeename();
	fill_asset();

  table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
    "order": [],
    "scrollX": true,
     "scrollY": true,
  });

  $("#printAssetTransfer").live('click', function() {
    assetid = $(this).attr("assetid")
    openPopupOneAtATime(assetid);
  });
  $(".addAssignment").click(function(){
      $(".form-addAssignment").slideToggle();
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

var popup;
function openPopupOneAtATime(x) {
    if (popup && !popup.closed) {
       popup.focus();
       popup.location.href = '<?php echo base_url();?>hrd/asset_transfer_print?id='+x;
    } else {
       popup = window.open('<?php echo base_url();?>hrd/asset_transfer_print?id='+x, '_blank', 'width=800,height=650,left=200,top=20');     
    }
}
function fill_asset(){
    $.ajax({
      url: '<?php echo base_url();?>hrd/fill_asset',
      type: 'get',
      dataType: 'json',
      success:function(response){
          var len = response.length;
         
          for( var i = 0; i<len; i++){
              var AssetName = response[i]['AssetName'];
              var AssetID = response[i]['AssetID'];
              $(".assetchild").append("<option value='"+AssetID+"'>"+AssetName+"</option>");
          }
      }
    });
}
function fill_employeename() {
  $.ajax({
      url: '<?php echo base_url();?>hrd/fill_employee_active',
      type: 'post',
      dataType: 'json',
      success:function(response){
          var len = response.length;
          
          for( var i = 0; i<len; i++){
              var EmployeeID = response[i]['EmployeeID'];
              var Fullname = response[i]['Fullname'];
              $(".employeenamechild").append("<option value='"+EmployeeID+"'>"+Fullname+"</option>");
          }
      }
  });
}
</script>