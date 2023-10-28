<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css"> 
  .divfilterdate {
    display: none; 
    margin: 5px 0px;
    border: 1px solid #0073b7; 
    padding: 4px;
    overflow: auto;
  }
  @media (min-width: 768px){
      .form-group label.left {
        float: left;
        width: 130px;
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
        <button type="button" class="btn btn-primary btn-xs" onclick="window.open('<?php echo base_url();?>employee/employee_overtime_add', '_blank');" title='ADD Over Time'><b>+</b> Add Over Time</button>
        <a href="#" id="tr-filter" class="btn btn-primary btn-xs tr-filter"><i class="fa fa-search"></i> Filter by Column</a>
        <a href="#" id="filterdate" class="btn btn-primary btn-xs filterdate" title="FILTER"><i class="fa fa-search"></i> Filter</a>
        <div class="divfilterdate">
          <form role="form" action="<?php echo current_url();?>" method="post" >
            <div class="col-md-6">
                <div class="form-group">
                  <label class="left">Month Start</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control input-sm" autocomplete="off" name="filterstart" id="datestart" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="left">Month End</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control input-sm" autocomplete="off" name="filterend" id="dateend" required="">
                  </div>
                </div>
            </div>
            <div class="col-md-12">
              <center>
                <button type="submit" class="btn btn-primary btn-sm pull-center">Submit</button>
              </center>
            </div>
          </form>
        </div>
      </div>
      
      <div class="box-body">
          <table id="dt_list" class="table table-bordered table-hover nowrap" width="100%">
            <thead>
              <tr>
                <th>ID</th>
                <th>Employee</th>
                <!-- <th>Date</th> -->
                <th>Start</th>
                <th>End</th>
                <th>Job</th>
                <th>Volume</th>
                <!-- <th></th> -->
              </tr>
            </thead>
            <tbody>
            <?php
              $num_char = 40;
              if (isset($content)) {
               foreach ($content as $row => $list) { 
            ?>
                  <tr>
                    <td><?php echo $list['OTID'];?></td>
                    <td><?php echo $list['fullname'];?></td>
                    <!-- <td><?php echo $list['OverTimeDate'];?></td> -->
                    <td><?php echo $list['TimeStart'];?></td>
                    <td><?php echo $list['TimeEnd'];?></td>
                    <td><?php echo $list['Job'];?></td>
                    <td><?php echo $list['Qty'];?></td>
                    <!-- <td>
                      <?php if ($list['isApprove'] == "1") { ?>
                        <i class="fa fa-lg fa-check-square-o" style="color: green;" title="Approved"></i>
                      <?php } elseif ($list['isApprove'] == "2") {?> 
                        <span class="fa-stack fa-xs">
                          <i class="fa fa-square-o fa-stack-2x" style="color:red;"></i>
                          <i class="fa fa-remove fa-stack-1x" style="color:red;" title="Rejected"></i>
                        </span>
                        <a href="" OTID="<?php echo $list['OTID'];?>" class="btn btn-danger btn-xs delete"><i class="fa fa-fw fa-trash"></i></a>
                      <?php } else { ?>
                        <!-- <a href="employee_overtime_edit?OTID=<?php echo $list['OTID'];?>" target='_blank' class="btn btn-warning btn-xs"><i class="fa fa-fw fa-edit"></i></a> -->
                        <!-- <a href="employee_overtime_cancel?OTID=<?php echo $list['OTID'];?>" class="btn btn-danger btn-xs delete"><i class="fa fa-fw fa-trash"></i></a> -->
                        <!-- <a href="" OTID="<?php echo $list['OTID'];?>" class="btn btn-danger btn-xs delete"><i class="fa fa-fw fa-trash"></i></a> -->
                      <?php } ?>
                      <?php //if ($list['isApprove'] == "0") { ?>
                      <!-- <button type="button" class="btn btn-success btn-xs goApproval" title="goApproval" otid="<?php echo $list['OTID'];?>"><i class="fa fa-fw fa-sign-out"></i></button> -->
                    <?php //} ?>
                    <!-- </td> -->
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

  th_filter_hidden = [0,5,6,7]
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

  $('.delete').live('click',function(e){
    var
      OTID = $(this).attr('OTID');
      data = {OTID:OTID};
      var r = confirm("This Overtime will be deleted!\nare you sure?");
      if (r == true) {
        $.ajax({
          url: "<?php echo base_url();?>employee/employee_overtime_cancel",
          type : 'POST',
          data : data,
          success : function (response) {
            location.reload();
          }
        })
      }
  });

  dtable = $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
     
    "scrollX": true,
     "scrollY": true,
    "order":[[0, "asc"]],
    "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };
    }
  })

  var cek_dt = function() {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust()
  };
  $('#dt_list').resize(cek_dt);
  
  $("#datestart").datepicker({ 
    format: "yyyy-mm-dd",
    viewMode: "months", 
    minViewMode: "months"
  }).on('changeDate', function (selected) {
    var minDate = new Date(selected.date.valueOf());
    $('#dateend').datepicker('setStartDate', minDate);
  });
  $("#dateend").datepicker({ 
    format: "yyyy-mm-dd",
    viewMode: "months", 
    minViewMode: "months"
  }).on('changeDate', function (selected) {
    var maxDate = new Date(selected.date.valueOf());
    $('#datestart').datepicker('setEndDate', maxDate);
  });
  $(".filterdate").click(function(){
    $(".divfilterdate").slideToggle();
  });
  
  // $('.goApproval').live('click',function(e){
  //   par = $(this)
  //   OTID = par.attr('otid')
  //   $.ajax({
  //       url: '<?php echo base_url();?>employee/employee_overtime_goApproval',
  //       type : 'POST',
  //       data: {OTID:OTID},
  //       dataType : 'json',
  //       success:function(response){
  //         if (response['result'] == "success") {
  //           par.replaceWith( '' )
  //         }
  //         if ('note' in response) {
  //           alert(response['note'])
  //         }
  //       }
  //   });
  // });
});
</script>