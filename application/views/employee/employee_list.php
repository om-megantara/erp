<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style type="text/css">
  .divuploadata {
    margin-top: 5px;
    border: 1px solid #367fa9;
    display: none;
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
        <button type="button" class="btn btn-primary btn-xs print_dt" title="PRINT" removeTd="1"><i class="fa fa-fw fa-print"></i> Print</button>
        <a href="<?php echo base_url();?>employee/employee_add" id="addEmployee" class="btn btn-primary btn-xs addEmployee" title="Add Employee" target="_blank"><b>+</b> Add Employee</a>
        <a href="#" id="uploadata" class="btn btn-primary btn-xs uploadata">Upload Employee</a> 
        
        <div class="divuploadata">
          <div class="box-body">
            <form name="form" action="<?php echo base_url();?>employee/employee_import_excel" method="post" enctype="multipart/form-data" autocomplete="off"> 
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputFile">Upload Employee</label>
                  <input type="file" id="excel" name="excel" accept=".xls">
                  <p class="help-block"></p>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
            <tr>
              <th id="order">Employee ID</th>
              <th>NIP</th>
              <th>BIOID</th>
              <th>Employee Name</th>
              <th>Job Position</th>
              <th>Office Location</th>
              <th>Status</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
              $no = 0;
              foreach ($content as $row => $list) { $no++;
                if ($list['status'] == "Active") { ?>
                    <tr class="mini">
                  <?php } else { ?>
                    <tr class="mini" style="background-color: #cc8585">
                  <?php }; ?>
                      <td><?php echo $list['EmployeeID'];?></td>
                      <td><?php echo $list['nip'];?></td>
                      <td><?php echo $list['BIOID'];?></td>
                      <td><?php echo $list['fullname'];?></td>
                      <td><?php echo $list['LevelCode'];?></td>
                      <td><?php echo $list['LocCode'];?></td>
                      <td><?php echo $list['status'];?></td>
                      <td>
                        <a href="<?php echo base_url();?>employee/view_profile/<?php echo $list['EmployeeID'];?>" class="btn btn-success btn-xs " style="margin: 0px;" target="_blank" title="View Profile"><i class="fa fa-file-photo-o"></i></a>

                        <a href="<?php echo base_url();?>employee/employee_edit/<?php echo $list['EmployeeID'];?>" class="btn btn-success btn-xs " style="margin: 0px;" target="_blank" title="Edit Employee"><i class="fa fa-edit"></i></a>

                        <a href="<?php echo base_url();?>employee/employee_export/<?php echo $list['ContactID'];?>" class="btn btn-success btn-xs export" style="margin: 0px;" target="_blank" title="Export Employee"><i class="fa fa-fw fa-send-o"></i></a>
                      </td>
                    </tr>
            <?php } ?>
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
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
jQuery( document ).ready(function( $ ) {
	 
  table = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "columnDefs": [ {
      "targets": 6,
      "orderable": false
    } ],
    "order": [[ 0, "asc" ]]
  });

  var cek_dt = function() {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
  };
  $('#dt_list').resize(cek_dt);

  $(".uploadata").click(function(){
    $(".divuploadata").slideToggle();
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