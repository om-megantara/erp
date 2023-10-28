<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css">
<style type="text/css"> 
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
  .form-group { margin-bottom: 10px; }
  .kiri { margin-left: -10px; }
  ._jw-tpk-container {font-size: 14px !important;}
}
</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <?php echo $PageTitle.' - '. $MainTitle;?>
      <?php 
        // $Time1=explode(" ", $content[0]['TimeStart']);
        // // $Time1=explode(" ", $content['TimeStart']);
        // $Start=explode(":",$Time1[1]);
        // $Time2=explode(" ", $content[0]['TimeEnd']);
        // $End=explode(":",$Time2[1]);
      ?>
      
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url();?>tool/help/<?php echo $help;?>.pdf" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-fw fa-info-circle"></i>Help</a></li>
    </ol>
  </section>

  <section class="content">

    <div class="box box-solid">
      <div class="box-body">
        <form name="form" id="form" action="<?php echo base_url();?>employee/employee_overtime_edit_act" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">Employee Name</label>
              <span class="left2">
                <input type="hidden" class="form-control input-sm OTID" name="OTID" required="" value="<?php echo $content[0]['OTID'];?>">
                <select class="form-control select2 input-sm Employee" id="employee" name="employee" required=""> 
                  <option value="<?php echo $content[0]['EmployeeID'];?>"><?php echo $content[0]['fullname']." | ".$content[0]['LevelCode'];;?></option>
                  <?php
                    foreach ($content['employee'] as $row => $list) {
                  ?>
                  <option value="<?php echo $list['EmployeeID'];?>"><?php echo $list['fullname']." | ".$list['LevelCode'];?></option>
                  <?php } ?>
                </select>
              </span>
            </div>
            <!-- <div class="form-group">
              <label class="left">Date</label>
              <span class="left2">
                <input type="text" class="form-control input-sm date" name="date" id="date" required="" value="<?php echo $content[0]['OverTimeDate'];?>">
              </span>
            </div> -->
            <div class="form-group">
              <label class="left">Time Start</label>
              <span class="left2">
                <!-- <input type="time" class="form-control input-sm start" name="start" id="time1" min="08:00" placeholder="Time Start" required="" value="<?php echo $Start[0].":".$Start[1];?>"> -->
                <input type="text" class="form-control input-sm" autocomplete="off" name="time1" id="time1" value="<?php echo $content[0]['TimeStart'];?>">
              </span>
            </div>
            <div class="form-group">
              <label class="left">Time End</label>
              <span class="left2">
                <!-- <input type="time" class="form-control input-sm end" name="end" id="time2" min="08:00" placeholder="Time End" required="" value="<?php echo $End[0].":".$End[1];?>"> -->
              <input type="text" class="form-control input-sm" autocomplete="off" name="time2" id="time2" value="<?php echo $content[0]['TimeEnd'];?>" >

              </span>
            </div>
          </div>
          <!-- <div class="form-group">
            <label class="left">Time Start</label>
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar">
                </i>
              </div>
              <input type="text" class="form-control input-sm" autocomplete="off" name="time1" id="time1">
            </div>
          </div>
          <div class="form-group">
            <label class="left">Time End</label>
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar">
                </i>
              </div>
              <input type="text" class="form-control input-sm" autocomplete="off" name="time2" id="time2">
            </div>
          </div> -->
          <div class="col-md-6">
            <div class="form-group">
              <label class="left">Job</label>
              <span class="left2">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-gear"></i>
                  </div>
                  <textarea class="form-control pull-right" rows="2" name="job" id="job" required=""><?php echo $content[0]['Job'];?></textarea>
                </div>
              </span>
            </div> 
            <div class="form-group">
              <label class="left">Volume</label>
              <span class="left2">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-sticky-note-o"></i>
                  </div>
                  <input type="text" class="form-control pull-right" rows="2" name="volume" id="volume" value="<?php echo $content[0]['Qty'];?>"></input>
                </div>
              </span>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="box-footer" style="text-align: center;">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>

<!-- <script src="<?php //echo base_url();?>tool/jquery8.js"></script>
<script src="<?php //echo base_url();?>tool/jquery.inputmask.bundle.js"></script>
<script src="<?php //echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php //echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script> -->
<!-- <link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/> -->
<!-- <script src="<?php //echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script> -->

<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/jquery.inputmask.bundle.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script> -->
<!-- <link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/> -->
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script>
j8 = jQuery.noConflict();
j8( document ).ready(function( $ ) {
  $('.select2').select2();
  
  $('#time1').daterangepicker({ 
    timePicker: true, 
    singleDatePicker: true,
    // startDate: new Date(),
    // minDate: moment().add(-1, 'M').toDate(),
    // minDate: "2018-07-25",
    maxDate: moment(),
    locale: {
      format: 'YYYY-MM-DD HH:mm:ss'
    }
  })
  $('#time2').daterangepicker({ 
    timePicker: true, 
    singleDatePicker: true,
    // startDate: new Date(),
    // minDate: moment().add(-1, 'M').toDate(),
    // minDate: "2018-07-25",
    maxDate: moment(),
    locale: {
      format: 'YYYY-MM-DD HH:mm:ss'
    }
  })

});



</script>