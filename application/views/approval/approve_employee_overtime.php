<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<style type="text/css">
  .divfilterdate {
    display: none;
    margin: 5px 10px;
    border: 1px solid #0073b7;
    padding: 4px;
    overflow: auto;
  }
  .form-group { display: block; margin-bottom: 5px !important; }
  #reject { background-color: #dd4b39; }
  #approve { background-color: #00a65a; }

  .detailNote { 
    max-width: 600px; 
    white-space: normal !important;
  }
</style>

<?php
  $actor = $content['actor']['Actor1'] != $EmployeeID ? : "Actor1";
  $actor = $content['actor']['Actor2'] != $EmployeeID ? $actor : "Actor2";
  $actor = $content['actor']['Actor3'] != $EmployeeID ? $actor : "Actor3";
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <?php 
        echo $PageTitle.' - '. $MainTitle; ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-fw fa-info-circle" title="HELP"></i>Help</a></li>
    </ol>
  </section>

  <section class="content">
    <div class="box box-solid">
      <div class="box-header">
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
                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
              </center>
            </div>
          </form>
        </div>
      </div>
      <div class="box-body form_addcontact">
        <div class="col-md-12  no-padding">
          <table id="dt_list" class="table table-bordered table-hover dtapproval" width="100%">
            <thead>
            <tr>
              <!-- <th id="order" class=" alignCenter">No</th> -->
              <!-- <th class=" alignCenter">Title</th>
              <th class=" alignCenter">Note</th>
              <th class=" alignCenter">A1</th>
              <th class=" alignCenter">A2</th>
              <th class=" alignCenter">A3</th> -->
              <th>ID</th>
              <th>Employee</th>
              <!-- <th>Date</th> -->
              <th>Start</th>
              <th>End</th>
              <th>Duration</th>
              <th>OT/Month</th>
              <th>Job</th>
              <th>Volume</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
              <?php
                // if ($content['actor']!= "" && !empty($content['list'])) {
                  foreach ($content['list'] as $row => $list) {
                    //$list['Note'] = str_replace("//", "<br>", $list['Note']);
              ?>
                      <tr>
                        <!-- <td class=" alignCenter"><?php echo $list['ApprovalID'];?></td> -->
                        <!-- <td><?php echo $list['Title']." - ".$list['Customer'];?></td>
                        <td><div class="detailNote"><?php echo $list['Note'];?></div></td>
                        <td class="alignCenter">
                          <?php if ($list['Actor1ID'] != "") { ?>
                            <i class="fa fa-fw fa-check-square-o" style="color: green;" title="CONFIRM <?php echo $list['Actor1'];?>"></i>
                            <span style="display:none;"><?php echo $list['Actor1'];?></span>
                          <?php }; ?>
                        </td>
                        <td class="alignCenter">
                          <?php if ($list['Actor2ID'] != "") { ?>
                            <i class="fa fa-fw fa-check-square-o" style="color: green;" title="CONFIRM <?php echo $list['Actor2'];?>"></i>
                            <span style="display:none;"><?php echo $list['Actor2'];?></span>
                          <?php }; ?>
                        </td>
                        <td class="alignCenter">
                          <?php if ($list['Actor3ID'] != "") { ?>
                            <i class="fa fa-fw fa-check-square-o" style="color: green;" title="CONFIRM <?php echo $list['Actor3'];?>"></i>
                            <span style="display:none;"><?php echo $list['Actor3'];?></span>
                          <?php }; ?>
                        </td>
                        <td>
                          <?php if (in_array("print_without_header", $MenuList)) {?>
                          <button type="button" class="btn btn-warning btn-xs printso2" title="PRINT OFFLINE" soid="<?php echo $list['SOID'];?>"><i class="fa fa-fw fa-print"></i></button>
                          <?php } else { ?>
                          <button type="button" class="btn btn-warning btn-xs printso" title="PRINT" soid="<?php echo $list['SOID'];?>"><i class="fa fa-fw fa-print"></i></button>
                          <?php } ?>
                          <button type="button" class="btn btn-success btn-xs detail" title="DETAIL" id="<?php echo $list['ApprovalID'];?>" soid="<?php echo $list['SOID'];?>" data-toggle="modal" data-target="#modal-note"><i class="fa fa-fw fa-edit"></i></button>
                        </td> -->
                        <td><?php echo $list['ApprovalID'];?></td>
                        <td><?php echo $list['fullname'];?></td>
                        <td><?php echo $list['TimeStart'];?></td>
                        <td><?php echo $list['TimeEnd'];?></td>
                        <td><?php echo $list['Duration'];?></td>
                        <td><?php echo $list['timeSum'];?></td>
                        <td><?php echo $list['Job'];?></td>
                        <td><?php echo $list['Qty'];?></td>
                        <td>
                          <button type="button" class="btn btn-success btn-xs detail" title="Approve" id='approve'  data='<?php echo $actor; ?>'  OTID="<?php echo $list['OTID'];?>" data-toggle="modal" ><i class="fa fa-fw fa-check-square"></i></button>
                          <button type="button" class="btn btn-success btn-xs detail" title="Reject" id="reject" data='<?php echo $actor; ?>' OTID="<?php echo $list['OTID'];?>" data-toggle="modal" ><i class="fa fa-fw fa fa-close" ></i></button>
                        </td>
                      </tr>
              <?php } //} ?>
            </tbody>
          </table>
        </div>
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
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script>
j8  = jQuery.noConflict();
j8( document ).ready(function( $ ) {
   
  $('#dt_list').DataTable({
    "pageLength": <?php echo $this->session->userdata('ReportPagingDefault');?>,
    "lengthMenu": [[<?php echo $this->session->userdata('ReportPaging');?>], [<?php echo $this->session->userdata('ReportPaging');?>]],
    "dom": 'lifrtip',
    "scrollX": true,
     "scrollY": true,
    "order":[]
  });

  var cek_dt = function() {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
  };
  $('#dt_list').resize(cek_dt);

  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});

jQuery( document ).ready(function( $ ) {

  $('#approve').live('click',function(e){
    var
      user = $(this).attr('data');
      OTID = $(this).attr('OTID');
      par  = $(this).parent().parent();
      data = {user:user,OTID:OTID};
      alert(OTID);
      $.ajax({
        url: "<?php echo base_url();?>approval/approve_employee_overtime_act/approve",
        type : 'POST',
        data : data,
        success : function (response) {
          window.location.href = "<?php echo current_url(); ?>";
        }
      })
  });
  $('#reject').live('click',function(e){
    var
      user = $(this).attr('data');
      OTID = $(this).attr('OTID');
      par  = $(this).parent().parent();
      data = {user:user,OTID:OTID};
      alert(OTID);
      $.ajax({
        url: "<?php echo base_url();?>approval/approve_employee_overtime_act/reject",
        type : 'POST',
        data : data,
        success : function (response) {
          window.location.href = "<?php echo current_url(); ?>";
        }
      })
  });

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
});
</script>