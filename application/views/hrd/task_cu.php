<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<style type="text/css">
  #dttask_list tbody,
  #dttask_list thead,
  #dttask_list tfoot{
    font-size: 12px !important;
  }
  #dttask_list tbody td { padding: 4px; }
  #addtask {
    margin: 10px;
    background-color: #00a65a;
    color: white;
    padding: 2px 5px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    font-weight: bold;
  }
  .form-group { display: block; margin-bottom: 5px !important; }
  .customaddr {font-size: 12px; padding: 0px 3px; font-weight: bold; margin-bottom: 3px;}
  .phone, .email, .employeename {margin-top: 2px;}
  .add_addr {font-size: 18px; font-weight: bold; color: white; background-color: #5bc0de; padding: 0px 8px;}
  .fullname .form-control, .address .form-control { margin-top: 3px; }
  .box-body h6 {display: inline; color: red; font-weight: bold;}
</style>

<?php 
// print_r($content); 
?>
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
      </div>
      <div class="box-body form_addtask">
          <form name="form employee_add" id="form employee_add" action="<?php echo base_url();?>hrd/task_cu_act" method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return cek_input_detail()">
            <input type="hidden" name="taskid" value="<?php echo $content['task']['TaskID'];?>">
            <div class="col-md-6">
			  <div class="box-body">
				<div class="form-group">
				  <label>Task Name</label>
				  <input type="text" class="form-control" placeholder="Task Name" autocomplete="off" name="name" id="name" value="<?php echo $content['task']['TaskName'];?>">
				</div>
				<div class="form-group">
					<label>Task Description <h6>*</h6> </label>
					<textarea class="form-control" rows="4" placeholder="Task Description" name="taskdescription" id="taskdescription"><?php echo $content['task']['TaskDescription'];?></textarea>
				  </div>
			   <div class="form-group">
				  <label>Task Create Date</label>
				  <div class="input-group date">
					<div class="input-group-addon">
					  <i class="fa fa-calendar"></i>
					</div>
					<input type="text" class="form-control" autocomplete="off" name="createdate" id="createdate" value="<?php echo $content['task']['TaskCreatedDate'];?>" readonly required="">
				  </div>
				</div>
			   <div class="form-group">
				  <label>Task Due Date</label>
				  <div class="input-group date">
					<div class="input-group-addon">
					  <i class="fa fa-calendar"></i>
					</div>
					<input type="text" class="form-control" autocomplete="off" name="duedate" id="duedate" value="<?php echo $content['task']['TaskDueDate'];?>" required="">
				  </div>
				</div>
			   <div class="form-group" style="display:  <?php echo $content['task']['Displaycls']; ?>">
				  <label>Task Close Date</label>
				  <div class="input-group date">
					<div class="input-group-addon">
					  <i class="fa fa-calendar"></i>
					</div>
					<input type="text" class="form-control" autocomplete="off" name="closedate" id="closedate" value="<?php echo $content['task']['TaskCloseDate'];?>" required="">
				  </div>
				</div>
			  </div>
			</div>
            <div class="col-md-6">
			  <div class="box-body">
				<div class="form-group">
					<label>Task Giver</label>
					<select class="form-control" name="taskgiver" id="taskgiver"></select>
				  </div>
				<div class="form-group">
					<label>Task Assigned</label>
<!--					<select class="form-control" name="taskassigned" id="taskassigned"></select>-->
					<div class="input-group input-group-sm taskassigned">
					  <select class="form-control taskassignedchild" name="taskassigned[]">
						<option value="0" >---PILIH---</option>
					  </select>
					  <span class="input-group-btn">
						<button type="button" class="btn btn-primary  add_field" onclick="duplicatetaskassigned();">+</button>
						<button type="button" class="btn btn-primary  add_field" onclick="if ($('.taskassigned').length != 1) { $(this).closest('div').remove();}">-</button>
					  </span>
					</div>
				  </div>
				<div class="form-group">
					<label>Task Cc</label>
<!--					<select class="form-control" name="taskcc" id="taskcc"></select>-->
					<div class="input-group input-group-sm taskcc">
					  <select class="form-control taskccchild" name="taskcc[]">
						<option value="0" >---PILIH---</option>
					  </select>
					  <span class="input-group-btn">
						<button type="button" class="btn btn-primary  add_field" onclick="duplicatetaskcc();">+</button>
						<button type="button" class="btn btn-primary  add_field" onclick="if ($('.taskcc').length != 1) { $(this).closest('div').remove();}">-</button>
					  </span>
					</div>
				  </div>
				<div class="form-group">
					<label>Task Priority</label>
					<select class="form-control" name="taskpriority" id="taskpriority"></select>
				  </div>
				<div class="form-group" style="display:  <?php echo $content['task']['Displaycls']; ?>">
					<label>Task Status</label>
					<select class="form-control" name="taskstatus" id="taskstatus"></select>
				  </div>
				<div class="form-group" style="display:  <?php echo $content['task']['Displaycls']; ?>">
				  <label>Task Progress</label>
				  <input type="text" class="form-control" placeholder="Task Progress" autocomplete="off" name="taskprogress" id="taskprogress" value="<?php echo $content['task']['TaskProgress'];?>">
				</div>
			  </div>
			</div>
            <div class="col-md-12">
              <div class="box-footer" style="text-align: center;">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
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
<script>
j8  = jQuery.noConflict();
j8( document ).ready(function( $ ) {
   
//	$('#createdate').daterangepicker({ 
//		timePicker: false, 
//		singleDatePicker: true,
//		startDate: new Date(),
//		minDate: moment(),
//		// minDate: "2018-07-25",
//		maxDate: moment(),
//		locale: {
//		  format: 'YYYY-MM-DD HH:mm:ss'
//		}
//	  })
	$('#closedate').daterangepicker({ 
		timePicker: true, 
		singleDatePicker: true,
		startDate: new Date(),
		locale: {
		  format: 'YYYY-MM-DD HH:mm:ss'
		}
	  })
	$('#duedate').daterangepicker({ 
		timePicker: true, 
		singleDatePicker: true,
		startDate: new Date(),
		locale: {
		  format: 'YYYY-MM-DD HH:mm:ss'
		}
	  })
  fill_taskpriority();
  fill_taskstatus();
  fill_tasklevel();
  $("input").keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
	$('.edit').live('click',function(e){
    len = $('.taskassigned').length;
    for( var i = 1; i<len; i++){
      if ($('.taskassigned').length != 1) { $('.taskassigned:last').remove();}
    }
    $.ajax({
      url: '<?php echo base_url();?>master/get_taskassigned_set_value',
      type: 'post',
      data: {id:id},
      dataType: 'json',
      success:function(response){
        len = response.length;
        for( var i = 0; i<len; i++){
          console.log(i);
          $("select.taskassignedchild2:last").val(response[i]);
          $(".taskassignedchild2:last").prop("disabled", true);
          $(".taskassigned:last").clone().insertAfter(".taskassigned:last");
        }
        $('.taskassigned:last').remove();
      }
    });
  });
});
	
function fill_taskpriority() {
  $.ajax({
    url: '<?php echo base_url();?>hrd/fill_taskpriority',
    type: 'post',
    dataType: 'json',
    success:function(response){
      var len = response.length;
      for( var i = 0; i<len; i++){
          var TaskPriorityID = response[i]['TaskPriorityID'];
          var TaskPriorityName = response[i]['TaskPriorityName'];
          $("#taskpriority").append("<option value='"+TaskPriorityID+"'>"+TaskPriorityName+"</option>");
      }
      $("#taskpriority").val('<?php if ( isset($content['task']['TaskPriorityID'])){ echo $content['task']['TaskPriorityID']; }?>');
    }
  });
}

function fill_taskstatus() {
  $.ajax({
    url: '<?php echo base_url();?>hrd/fill_taskstatus',
    type: 'post',
    dataType: 'json',
    success:function(response){
      var len = response.length;
      for( var i = 0; i<len; i++){
          var TaskStatusID = response[i]['TaskStatusID'];
          var TaskStatusName = response[i]['TaskStatusName'];
          $("#taskstatus").append("<option value='"+TaskStatusID+"'>"+TaskStatusName+"</option>");
      }
      $("#taskstatus").val('<?php if ( isset($content['task']['TaskStatusID'])){ echo $content['task']['TaskStatusID']; }?>');
    }
  });
}
	
function fill_tasklevel() {
  $.ajax({
    url: '<?php echo base_url();?>hrd/fill_tasklevel',
    type: 'post',
    dataType: 'json',
    success:function(response){
      var len = response.length;
      for( var i = 0; i<len; i++){
          var LevelID = response[i]['LevelID'];
          var LevelName = response[i]['LevelName'];
		  var Email = response[i]['Email'];
          $("#taskgiver").append("<option value='"+LevelID+"'>"+LevelName+"("+Email+")"+"</option>");
		  $(".taskassignedchild").append("<option value='"+LevelID+"'>"+LevelName+"("+Email+")"+"</option>");
		  $(".taskccchild").append("<option value='"+LevelID+"'>"+LevelName+"("+Email+")"+"</option>");
      }
      $("#taskgiver").val('<?php if ( isset($content['task']['LevelID'])){ echo $content['task']['LevelID']; }?>');
	  $(".taskassignedchild").val('<?php if ( isset($content['task']['LevelTaskAssignedToID'])){ echo $content['task']['LevelTaskAssignedToID']; }?>');
	  $(".taskccchild").val('<?php if ( isset($content['task']['LevelTaskCcID'])){ echo $content['task']['LevelTaskCcID']; }?>');
    }
  });
}
	
function fill_employeename() {
  $.ajax({
      url: '<?php echo base_url();?>hrd/fill_employee',
      type: 'post',
      dataType: 'json',
      success:function(response){
          var len = response.length;
          //$("#employeename").empty();
          for( var i = 0; i<len; i++){
              var EmployeeID = response[i]['EmployeeID'];
              var Fullname = response[i]['Fullname'];
              $(".employeenamechild").append("<option value='"+EmployeeID+"'>"+Fullname+"</option>");
          }
      }
  });
}
function duplicatetaskassigned() { $(".taskassigned:last").clone().insertAfter(".taskassigned:last"); }
function duplicatetaskcc() { $(".taskcc:last").clone().insertAfter(".taskcc:last"); }
	
function duplicateemployeename() { $(".employeename:last").clone().insertAfter(".employeename:last"); }
	
function cek_input_detail() {
  if ($.trim($("#name").val()) === "" || $.trim($("#taskdescription").val()) === "" || $.trim($("#createdate").val()) === "" || $("#duedate").val() === "") {
    alert("input tidak boleh kosong");
    return false;
  }
}
</script>