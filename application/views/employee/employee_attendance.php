<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/css/select2.min.css">
<style type="text/css">
	.divuploadata, .divfilter, .divShowGroup {
		margin-top: 5px;
		border: 1px solid #367fa9;
		display: none;
	}

    #dt_list_wrapper td, #dt_list_wrapper th, 
    .table-group td, .table-group th { 
      white-space: nowrap; 
      vertical-align: top !important;
    }
    #dt_list_wrapper td:nth-child(1), #dt_list_wrapper th:nth-child(1) { width: 140px; } 
    #dt_list_wrapper td:nth-child(2), #dt_list_wrapper th:nth-child(2) { width: 100px; } 
    #dt_list_wrapper td:nth-child(3), #dt_list_wrapper th:nth-child(3) { width: 100px; } 
    #dt_list_wrapper tbody td {
      padding-top: 4px;
      padding-bottom: 4px;
      vertical-align: middle;
    }
    #dt_list_wrapper tbody, #dt_list_wrapper thead, #dt_list_wrapper tfoot,
    .table-group tbody, .table-group thead, .table-group tfoot {
      font-size: 12px !important;
      font-weight: bold;
    }
    .table-group td {
    	padding: 2px 8px !important;
    }
    #dt_list_wrapper select {
	    font-size: 12px;
	    padding: 2px;
	    width: auto;
	    height: 25px;
    }
    .HRD-Note { min-width: 200px; }
    .fulltime, .menitKerja, .menitAktif { display: none; }
    .warning { color: red; }
    .freeDay { background-color: #c1c1c1; }
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
	</section>
	<section class="content">
	    <div class="box box-solid">
	    	<div class="box-header">
				<div class="form-button"> 
			        <button type="button" class="btn btn-primary btn-xs print_dt" removeTd="1"><i class="fa fa-fw fa-print"></i> Print</button>
			        <a href="#" id="ShowGroup" class="btn btn-primary btn-xs ShowGroup">Group Time</a> 
			        <a href="#" id="uploadata" class="btn btn-primary btn-xs uploadata">Upload Excel Attendance</a> 
			        <a href="#" id="filter" class="btn btn-primary btn-xs filter"><i class="fa fa-search"></i> Filter</a> 
    			</div> 
 
 				<div class="divShowGroup">
 					<table class="table table-hover table-bordered table-main table-group" style="font-size: 14px;">
		    		  	<thead>
		    		  		<tr>
				                <td class="alignCenter">Group Name</td>
		    			      	<td class="alignCenter">Time Name</td>
		    			      	<td class="alignCenter">Time In</td>
		    			      	<td class="alignCenter">Time Break</td>
		    			      	<td class="alignCenter">Time Out</td>
		    			    </tr>
		    		  	</thead>
		    		  	<tbody>
							<?php
							  foreach ($content['groupTime'] as $row => $list) {  
							?>
			      		  		<tr>
				                  <td><?php echo $list['GroupTimeName'];?></td>
				                  <td><?php echo $list['TimeName'];?></td>
				                  <td class="alignCenter"><?php echo $list['TimeIn'];?></td>
				                  <td class="alignCenter"><?php echo $list['TimeBreak'];?></td>
				                  <td class="alignCenter"><?php echo $list['TimeOut'];?></td>
			      		  		</tr>
		              		<?php } ?>
		    		  	</tbody>
	    		  	</table>
 					
 				</div>
		        <div class="divuploadata">
		        	<div class="box-body">
						<form name="form" action="<?php echo base_url();?>employee/employee_attendance_excel" method="post" enctype="multipart/form-data" autocomplete="off"> 
					  		<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputFile">Upload Attendance</label>
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
		        <div class="divfilter">
		        	<div class="box-body">
						<form name="form" action="<?php echo current_url();?>" method="post" enctype="multipart/form-data" autocomplete="off"> 
					  		<div class="col-md-6">
				                <div class="form-group">
				                  <label class="left">Month Start</label>
				                  <div class="input-group">
				                    <div class="input-group-addon">
				                      <i class="fa fa-calendar"></i>
				                    </div>
				                    <input type="text" class="form-control input-sm" autocomplete="off" name="datestart" id="datestart" required="">
				                  </div>
				                </div>
				                <div class="form-group">
				                  <label class="left">Month End</label>
				                  <div class="input-group">
				                    <div class="input-group-addon">
				                      <i class="fa fa-calendar"></i>
				                    </div>
				                    <input type="text" class="form-control input-sm" autocomplete="off" name="dateend" id="dateend" required="">
				                  </div>
				                </div>
							</div>
					  		<div class="col-md-6">
								<div class="form-group">
								    <label class="left">Employee</label>
								    <span class="left2">
								      <select class="form-control input-sm select2" name="employee" id="employee" required="">
								        <option value='' selected disabled>Select Employee</option>
								      </select>
								    </span>
								</div>
							</div>
							<div class="col-md-12">
								<center>
									<button type="submit" class="btn btn-sm btn-primary">Submit</button>
								</center>
							</div>
						</form>
					</div>
		        </div>
	      	</div>
    		<div class="box-body table-responsive no-padding" style="overflow-x: auto; max-height: 800px;">
              <?php
                if (isset($content['main'])) {
              ?> 
				<form name="form" action="<?php echo base_url();?>employee/employee_attendance_adjust" method="post" enctype="multipart/form-data" autocomplete="off"> 

              	  <input type="hidden" name="EmployeeID" value="<?php echo $content['EmployeeID'];?>">
	    		  <table class="table table-hover table-bordered table-main" id="dt_list_wrapper">
	    		  	<thead>
	    		  		<tr>
			                <th class="alignCenter">Type</th>
	    			      	<th class="alignCenter">Day</th>
	    			      	<th class="alignCenter">Date</th>
			                <th class="alignCenter">Time</th>
			                <th class="alignCenter">Summary</th>
			                <th class="alignCenter">Note</th>
	    			    </tr>
	    		  	</thead>
	    		  	<tbody>
						<?php
						  foreach ($content['main'] as $row => $list) {  
						?>
		      		  		<tr>
			                  <td>
              					<input type="hidden" name="AttendanceDate[]" value="<?php echo $list['DateReff'];?>">
								<select class="form-control input-sm time" name="time[]" required="">
									<?php if ($list['TimeID'] != "") { ?>
										<option value="<?php echo $list['TimeID'];?>" TimeIn="<?php echo $list['TimeIn'];?>" TimeOut="<?php echo $list['TimeOut'];?>" TimeBreak="<?php echo $list['TimeBreak'];?>"><?php echo $list['TimeName'];?></option>
									<?php } ?>
									<?php
										foreach ($content['time'] as $key => $value) {
									?>
										<option value="<?php echo $value['TimeID'];?>" TimeIn="<?php echo $value['TimeIn'];?>" TimeOut="<?php echo $value['TimeOut'];?>" TimeBreak="<?php echo $value['TimeBreak'];?>"><?php echo $value['TimeName'];?></option>
									<?php
										}
									?>
								</select>
			                  </td>
			                  <td></td>
			                  <td class="alignCenter"><?php echo $list['DateReff'];?></td>
			                  <td>
			                  	<span class="fulltime"><?php echo $list['AttendanceTime'];?></span>
			                  	<?php echo chunk_split($list['AttendanceTime'],33,"<br>");?>
			                  </td>
			                  <td> </td>
			                  <td>
				                  <div class="form-group">
                      					<input type="text" class="form-control input-sm HRD-Note" placeholder="HRD Note" autocomplete="off" name="note[]" value="<?php echo $list['AttendanceNote'];?>">
				                  </div>
			                  </td>
		      		  		</tr>
	              		<?php } ?>
	              		<tr>
	              			<td></td>
	              			<td colspan="3" style="font-size: 16px;">
	              				<center>SUMMARY</center>
	              			</td>
	              			<td class="tdSummary"></td>
	              			<td></td>
	              		</tr>
	    		  	</tbody>
	    		  </table>

			  		<div class="col-md-12" style="margin-bottom: 10px;">
						<center>
							<button type="button" class="btn btn-success countSummary">Count</button>
							<button type="submit" class="btn btn-primary">Submit</button>
						</center>
					</div>
	    		</form>
              <?php } ?>
			</div>
	    </div>
	</section>
</div>
 
<script src="<?php echo base_url();?>tool/jquery8.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>tool/natural_sort.js"></script>
<script src="<?php echo base_url();?>tool/jquery.inputmask.bundle.js"></script>
<script src="<?php echo base_url();?>tool/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo base_url();?>tool/jquery.resize.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>tool/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script>
var j8 = $.noConflict(true);
j8( document ).ready(function( $ ) {
	fill_employee()
	init_note()

  	$('.select2').select2();
	$(".uploadata").click(function(){
		$(".divuploadata").slideToggle();
	}); 
	$(".filter").click(function(){
		$(".divfilter").slideToggle();
	}); 
	$(".ShowGroup").click(function(){
		$(".divShowGroup").slideToggle();
	}); 

	$("#datestart").datepicker({ 
	    format: "yyyy-mm-dd",
	    autoclose: true, 
	    format: 'yyyy-mm-dd',
	    // viewMode: "months", 
	    // minViewMode: "months"
	}).on('changeDate', function (selected) {
	    var minDate = new Date(selected.date.valueOf());
	    $('#dateend').datepicker('setStartDate', minDate);
	});
	$("#dateend").datepicker({ 
	    format: "yyyy-mm-dd",
	    autoclose: true, 
	    format: 'yyyy-mm-dd',
	    // viewMode: "months", 
	    // minViewMode: "months"
	}).on('changeDate', function (selected) {
	    var maxDate = new Date(selected.date.valueOf());
	    $('#datestart').datepicker('setEndDate', maxDate);
	});
});

function fill_employee() {
  $.ajax({
      url: '<?php echo base_url();?>employee/fill_employee_active',
      type: 'post',
      dataType: 'json',
      success:function(response){
          var len = response.length;
          for( var i = 0; i<len; i++){
              var EmployeeID = response[i]['EmployeeID'];
              var EmployeeName = response[i]['EmployeeName'];
              $("#employee").append("<option value='"+EmployeeID+"'>"+EmployeeName+"</option>");
          }
      }
  });
}
function init_note() {
	$('select.time').each(function(){
  		par  = $(this).closest('tr');
	    cekTime(par)
	})
}

j8(".time").change(function() {
  par  = $(this).closest('tr');
  cekTime(par)
});
function cekTime(par) { 
	// insert day name
	var note = ""
	var weekday = ["minggu","senin","selasa","rabu","kamis","jumat","sabtu"];
	curDate = new Date( par.find("td:eq(2)").html() )
	par.find("td:eq(1)").html(weekday[curDate.getDay()])
	if ( par.find(".fulltime").html() !== '' ) {
		// validating work time's
		valueTimeIn = par.find('.time option:selected').attr('TimeIn')
		valueTimeBreak = par.find('.time option:selected').attr('TimeBreak')
		valueTimeOut = par.find('.time option:selected').attr('TimeOut')

		TimeIn 		= new Date("01/01/2007 " + valueTimeIn).getTime();
		TimeBreak 	= new Date("01/01/2007 " + valueTimeBreak).getTime();
		TimeOut 	= new Date("01/01/2007 " + valueTimeOut).getTime();

		tesTime 	= new Date("01/01/2007 08:00:00").getTime();

		if (TimeBreak < tesTime) {
			// jika lewat hari
			adjustBreak = new Date("01/01/2007 " + valueTimeBreak);
			hour = adjustBreak.getHours();
			adjustBreak = adjustBreak.setHours(hour + 12)

			// -------------------------------------------------
	      	timeAll = [];
			timeAllRaw 	= par.find(".fulltime").html().split(' , ')
			len = timeAllRaw.length;
			for( var i = 0; i<len; i++){
				timePart = new Date("01/01/2007 " + timeAllRaw[i]).getTime();
				if (timePart > adjustBreak) {
					timeAll.push(timeAllRaw[i]);
				}
			}
			for( var i = 0; i<len; i++){
				timePart = new Date("01/01/2007 " + timeAllRaw[i]).getTime();
				if (timePart < adjustBreak) {
					timeAll.push(timeAllRaw[i]);
				}
			}
			valuestart 	= timeAll[0]
			valuestop 	= timeAll[timeAll.length-1];

			timeStart 	= new Date("01/01/2007 " + valuestart).getTime();
			timeEnd 	= new Date("01/01/2007 " + valuestop).getTime();
		} else {
			// jika dala 1 hari
			timeAll 	= par.find(".fulltime").html().split(' , ')
			valuestart 	= timeAll[0]
			valuestop 	= timeAll[timeAll.length-1];

			timeStart 	= new Date("01/01/2007 " + valuestart).getTime();
			timeEnd 	= new Date("01/01/2007 " + valuestop).getTime();

			menitKerja = parseInt(minuteConvert(TimeIn, TimeOut))
			menitAktif = parseInt(minuteConvert(timeStart, timeEnd))
			menitLembur = parseInt(minuteConvert(timeEnd, TimeOut))
			note += "<span class='menitKerja' style='display:none;'>" + menitKerja + "<br></span>"
			note += "<span class='menitAktif' style='display:none;'>" + menitAktif + "<br></span>"
			note += "Jam Kerja : " + timeConvert(timeStart, timeEnd) + "<br>"
		}

		// note += "jam masuk " + valueTimeIn + " --- jam pulang " + valueTimeOut + "<br>"
		note += "jam datang : " + valuestart + " --- jam keluar : " + valuestop + "<br>"
		if ((timeStart - TimeIn) > 60000) {
			menitTelat = parseInt(minuteConvert(TimeIn, timeStart))
			note += "<span class='warning'>Telat Masuk</span> : " + menitTelat + " minute(s)<br>"

			if (menitTelat <= 15) {
				telatDihitung = menitTelat - menitLembur
			} else {
				if (menitLembur<15) {
					telatDihitung = menitTelat - menitLembur
				} else {
					telatDihitung = menitTelat - 15
				}
			}
			if (telatDihitung > 0) {
				note += "<span class='warning'> <b>->> Telat Dihitung</b></span> : <span class='telatDihitung'>" + telatDihitung + "</span> minute(s)<br>"
			}
		}
		if ((timeEnd < TimeOut)) {
			pulangDihitung = minuteConvert(TimeOut, timeEnd)
			note += "<span class='warning'> <b>->> Pulang Cepat</b></span> : <span class='pulangDihitung'>" + pulangDihitung + "</span> minute(s)<br>"
		}
	} else {
		note += "<span class='warning'>Tidak Masuk Kerja.</span>"
		par.addClass('freeDay')
	}
	par.find("td:eq(4)").html(note)
}
function timeConvert(dt1, dt2) {
	var diff = ( dt2 - dt1 ) / 1000;
	var num = diff/(60);
	var hours = (num / 60);
	if (Math.abs(hours) < 1) {
		var rhours = 0
	} else {
		var rhours = Math.floor(hours);
	}
	var minutes = (hours - rhours) * 60;
	var rminutes = Math.abs(Math.floor(minutes));
	// return num + " minutes = " + rhours + " hour(s) and " + rminutes + " minute(s).";
	return Math.abs(rhours) + " hour(s) and " + rminutes + " minute(s).";
}
function MinuteToHourConvert(num) {
	var hours = (num / 60);
	if (Math.abs(hours) < 1) {
		var rhours = 0
	} else {
		var rhours = Math.floor(hours);
	}
	var minutes = (hours - rhours) * 60;
	var rminutes = Math.abs(Math.floor(minutes));
	// return num + " minutes = " + rhours + " hour(s) and " + rminutes + " minute(s).";
	return Math.abs(rhours) + " hour(s) and " + rminutes + " minute(s).";
}
function minuteConvert(dt1, dt2) {
	var diff = ( dt2 - dt1 ) / 1000;
	var num = diff/(60); 
	return Math.abs(Math.floor(num));
}
j8('button.countSummary').on('click', function() {
	totalKerjaDihitung = 0
	totalAktifDihitung = 0
	totalTelatDihitung = 0
	totalPulangDihitung = 0
	$(".tdSummary").empty()
	$('.menitKerja').each(function(){
		totalKerjaDihitung += parseInt($(this).html())
	})
	$('.menitAktif').each(function(){
		totalAktifDihitung += parseInt($(this).html())
	})
	$('.telatDihitung').each(function(){
		totalTelatDihitung += parseInt($(this).html())
	})
	$('.pulangDihitung').each(function(){
		totalPulangDihitung += parseInt($(this).html())
	})

	noteSummary = 'Total Hari Kerja : '+$('.menitKerja').length+'<br>'
	noteSummary += 'Total Jam Kerja : '+MinuteToHourConvert(totalKerjaDihitung)+'<br>'
	noteSummary += 'Total Jam Aktif : '+MinuteToHourConvert(totalAktifDihitung)+'<br>'
	noteSummary += 'Total Telat Dihitung : '+totalTelatDihitung+' minute(s)<br>'
	noteSummary += 'Total Pulang Dihitung : '+totalPulangDihitung+' minute(s)'
	$(".tdSummary").html(noteSummary)
})         
j8('button.print_dt').on('click', function() {               
  // var fvData = table.rows({ search:'applied', page: 'all' }).data(); 
  table = $("#dt_list_wrapper").html();
  $('.div_dt_print').empty().append(
		'<style type="text/css">.warning { color: red; }</style>' +
  		$('div.info_filter').html() + 
	     '<table id="dtTablePrint" class="col">' +
	     '<thead></thead>' +
	     '<tbody></tbody></table>'
  );

	$('#dt_list_wrapper thead').each(function(){
	    var row = $(this).html();
	    $('#dtTablePrint thead').append('<tr>'+row+'</tr>');
	});
	$('#dt_list_wrapper tbody').each(function(){
	    var row = $(this).html();
	    $('#dtTablePrint tbody').append('<tr>'+row+'</tr>');
	});
	$('#dtTablePrint tbody input').each(function(){
	    var text = $(this).val();
	    $(this).after(text).remove();
	});
  	for (var i = 0; i < $('button.print_dt').attr('removeTd'); i++) {
    	$("#dtTablePrint th:first-child, #dtTablePrint td:first-child").remove();
  	}

  var w = window.open();
  var html = $(".div_dt_print").html();
  $(w.document.body).append('<link rel="stylesheet" href="<?php echo base_url();?>tool/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">');
  $(w.document.body).append("<link href='<?php echo base_url();?>tool/dtPrint.css' rel='stylesheet' type='text/css' />");
  $(w.document.body).append(html);
});
</script>